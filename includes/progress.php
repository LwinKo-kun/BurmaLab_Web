<?php
/**
 * Gamification & Progress Engine (BurmaLab-Web)
 * Handles XP calculations, daily streaks, and lab/chapter completion state.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db.php';

/**
 * Updates daily login streak and awards daily login XP (+15 XP).
 */
function update_user_streak_and_login(PDO $pdo, int $userId): void {
    $today = date('Y-m-d');
    
    $stmt = $pdo->prepare('SELECT current_streak, last_login_date, total_xp FROM user_streaks WHERE user_id = ?');
    $stmt->execute([$userId]);
    $streakData = $stmt->fetch();

    if (!$streakData) {
        $insert = $pdo->prepare('INSERT INTO user_streaks (user_id, current_streak, last_login_date, total_xp) VALUES (?, 1, ?, 10)');
        $insert->execute([$userId, $today]);
    } else {
        $lastLogin = $streakData['last_login_date'];
        $currentStreak = (int)$streakData['current_streak'];
        $totalXp = (int)$streakData['total_xp'];

        if ($lastLogin !== $today) {
            $yesterday = date('Y-m-d', strtotime('-1 day'));
            if ($lastLogin === $yesterday) {
                $currentStreak++;
            } else {
                $currentStreak = 1; 
            }
            $totalXp += 15; 

            $update = $pdo->prepare('UPDATE user_streaks SET current_streak = ?, last_login_date = ?, total_xp = ? WHERE user_id = ?');
            $update->execute([$currentStreak, $today, $totalXp, $userId]);
        }
    }
}

/**
 * Get comprehensive statistics for the active user dashboard.
 */
function get_user_stats(PDO $pdo, int $userId): array {
    $stmt = $pdo->prepare('SELECT current_streak, total_xp FROM user_streaks WHERE user_id = ?');
    $stmt->execute([$userId]);
    $stats = $stmt->fetch();

    $completedLabsStmt = $pdo->prepare('SELECT COUNT(*) FROM user_progress WHERE user_id = ? AND item_type = "lab"');
    $completedLabsStmt->execute([$userId]);
    $labsCount = (int)$completedLabsStmt->fetchColumn();

    $completedChaptersStmt = $pdo->prepare('SELECT COUNT(*) FROM user_progress WHERE user_id = ? AND item_type = "chapter"');
    $completedChaptersStmt->execute([$userId]);
    $chaptersCount = (int)$completedChaptersStmt->fetchColumn();

    return [
        'streak' => (int)($stats['current_streak'] ?? 0),
        'xp' => (int)($stats['total_xp'] ?? 0),
        'completed_labs' => $labsCount,
        'completed_chapters' => $chaptersCount
    ];
}

/**
 * Mark a lab or theory chapter as completed and award XP (Labs = 50 XP, Chapters = 20 XP).
 */
function mark_item_completed(PDO $pdo, int $userId, string $itemType, string $itemIdentifier): bool {
    if (!in_array($itemType, ['lab', 'chapter'], true)) {
        return false;
    }

    try {
        $pdo->beginTransaction();

        // Insert completion record ignoring duplicate submissions
        $stmt = $pdo->prepare('INSERT IGNORE INTO user_progress (user_id, item_type, item_identifier) VALUES (?, ?, ?)');
        $stmt->execute([$userId, $itemType, $itemIdentifier]);

        if ($stmt->rowCount() > 0) {
            // Award XP only on new completion
            $xpAward = ($itemType === 'lab') ? 50 : 20;
            $xpStmt = $pdo->prepare('UPDATE user_streaks SET total_xp = total_xp + ? WHERE user_id = ?');
            $xpStmt->execute([$xpAward, $userId]);
        }

        $pdo->commit();
        return true;
    } catch (\Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log("Progress completion error: " . $e->getMessage());
        return false;
    }
}

/**
 * Check if a specific lab or chapter has been completed by the user.
 */
function is_item_completed(PDO $pdo, int $userId, string $itemType, string $itemIdentifier): bool {
    $stmt = $pdo->prepare('SELECT 1 FROM user_progress WHERE user_id = ? AND item_type = ? AND item_identifier = ?');
    $stmt->execute([$userId, $itemType, $itemIdentifier]);
    return (bool)$stmt->fetchColumn();
}