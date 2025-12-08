<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

try {
    require_once 'db.php';
    
    if (!isset($pdo)) {
        throw new Exception('Database connection not established');
    }
    
    $query = "SELECT product_id, SUM(likes_count) as total_likes 
              FROM product_likes
              GROUP BY product_id";
        
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $likes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $likesData = [];
    foreach ($likes as $like) {
        $likesData[$like['product_id']] = (int)$like['total_likes'];
    }
    
    echo json_encode([
        'success' => true,
        'data' => $likesData
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
