<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

try {
    require_once 'db.php';
    
    if (!isset($pdo)) {
        throw new Exception('Database connection not established');
    }
    
    $query = "SELECT 
                p.id,
                p.name,
                p.image,
                p.description,
                p.size,
                p.price,
                p.created_at,
                COALESCE(SUM(l.likes_count), 0) as total_likes
              FROM product p
              LEFT JOIN product_likes l ON p.id = l.product_id
              GROUP BY p.id
              ORDER BY p.created_at DESC";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $formattedProducts = [];
    foreach ($products as $product) {
        $formattedProducts[] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => number_format($product['price'], 0, ',', '.'),
            'size' => $product['size'] ? $product['size'] : 'One Size',
            'likes' => (int)$product['total_likes'],
            'image' => $product['image'] ? $product['image'] : '#E8E8E8',
            'description' => $product['description']
        ];
    }
    
    echo json_encode([
        'success' => true,
        'data' => $formattedProducts
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
