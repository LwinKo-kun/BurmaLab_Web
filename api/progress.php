<?php
/**
 * Async Progress API Endpoint (BurmaLab-Web)
 * Receives JSON payloads to log completions and return updated XP totals.
 */
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/progress.php';

if (!is_authenticated()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Authentication required']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$itemType = $input['item_type'] ?? '';
$itemIdentifier = trim($input['item_identifier'] ?? '');

if (!in_array($itemType, ['lab', 'chapter'], true) || empty($itemIdentifier)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid parameters provided']);
    exit;
}

$userId = (int)$_SESSION['user_id'];
$success = mark_item_completed($pdo, $userId, $itemType, $itemIdentifier);
$stats = get_user_stats($pdo, $userId);

echo json_encode([
    'success'            => $success,
    'item_type'          => $itemType,
    'item_identifier'    => $itemIdentifier,
    'total_xp'           => $stats['xp'],
    'completed_labs'     => $stats['completed_labs'],
    'completed_chapters' => $stats['completed_chapters']
]);