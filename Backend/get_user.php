<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

include "db.php"; 

if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400); 
    echo json_encode([
        "success" => false,
        "message" => "User ID is required"
    ]);
    exit;
}

$id = $_GET['id']; 

$sql = "SELECT id, fullname, username, email, image FROM users WHERE id = ? LIMIT 1";

try {
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(1, $id, PDO::PARAM_INT); 
    $stmt->execute(); 

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (!isset($user['image']) || $user['image'] === '') {
            $user['image'] = null; 
        }

        echo json_encode([
            "success" => true,
            "data" => $user
        ]);
    } else {
        http_response_code(404);
        echo json_encode([
            "success" => false,
            "message" => "User not found"
        ]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Query error: " . $e->getMessage()
    ]);
}
?>