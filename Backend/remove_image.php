<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Max-Age: 86400');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once 'db.php';

$uploadDir = __DIR__ . '/uploads/users/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $userId = $data['userId'] ?? null;
    
    if (empty($userId)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'User ID is required']);
        exit;
    }
    
    $stmt = $pdo->prepare("SELECT image FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $imageToDelete = $user['image'] ?? null;

    $deletedFile = false;
    
    if ($imageToDelete) {
        $fullPath = __DIR__ . '/' . $imageToDelete;

        if (file_exists($fullPath) && is_file($fullPath)) {
            if (unlink($fullPath)) {
                $deletedFile = true;
            } else {
                error_log("Failed to unlink file: " . $fullPath);
            }
        }
    }

    $updateStmt = $pdo->prepare("UPDATE users SET image = NULL WHERE id = ?");
    
    if ($updateStmt->execute([$userId])) {
        echo json_encode(['success' => true, 'message' => 'Profile photo removed successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to remove image path from database']);
    }

} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>