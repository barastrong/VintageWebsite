<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $userId = $data['userId'] ?? '';
    
    if (empty($userId)) {
        echo json_encode(['success' => false, 'message' => 'User ID required']);
        exit;
    }
    
    $stmt = $pdo->prepare("UPDATE users SET is_login = 0 WHERE id = ?");
    if ($stmt->execute([$userId])) {
        echo json_encode(['success' => true, 'message' => 'Logout successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Logout failed']);
    }
}
?>
