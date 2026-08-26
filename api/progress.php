<?php
session_start();
header('Content-Type: application/json');

// 1. Check if user is logged in
if (empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// 2. Connect to the database (going up one directory to reach 'includes')
require_once __DIR__ . '/../includes/db.php';

// 3. Get the JSON data sent by the fetch request
$data = json_decode(file_get_contents('php://input'), true);
$itemType = $data['item_type'] ?? '';
$itemIdentifier = $data['item_identifier'] ?? '';
$userId = $_SESSION['user_id'];

if (!$itemType || !$itemIdentifier) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required data']);
    exit;
}

try {
    $pdo->beginTransaction();

    // 4. Record the completed chapter/lab (INSERT IGNORE prevents duplicates)
    $stmt = $pdo->prepare("INSERT IGNORE INTO user_progress (user_id, item_type, item_identifier) VALUES (:uid, :type, :identifier)");
    $stmt->execute([
        'uid' => $userId,
        'type' => $itemType,
        'identifier' => $itemIdentifier
    ]);

    // 5. If a new row was inserted, grant the user +20 XP
    if ($stmt->rowCount() > 0) {
        $xpStmt = $pdo->prepare("UPDATE user_streaks SET total_xp = total_xp + 20 WHERE user_id = :uid");
        $xpStmt->execute(['uid' => $userId]);
    }

    $pdo->commit();
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error']);
    // Optional: error_log($e->getMessage());
}