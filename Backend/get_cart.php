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
    
    $userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
    
    if ($userId === 0) {
        throw new Exception('User ID is required');
    }
    
    $query = "SELECT pc.id, pc.product_id, pc.name, pc.quantity, p.price, p.size, p.image
              FROM product_cart pc
              LEFT JOIN product p ON pc.product_id = p.id
              WHERE pc.user_id = :user_id AND pc.is_cart = 1
              ORDER BY pc.created_at DESC";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute(['user_id' => $userId]);
    
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $formattedItems = [];
    foreach ($cartItems as $item) {
        $formattedItems[] = [
            'id' => $item['id'],
            'product_id' => $item['product_id'],
            'name' => $item['name'],
            'size' => $item['size'] ? $item['size'] : 'One Size',
            'price' => 'Rp' . number_format($item['price'], 0, ',', '.'),
            'quantity' => (int)$item['quantity'],
            'image' => $item['image'] ? $item['image'] : '#E8E8E8'
        ];
    }
    
    echo json_encode([
        'success' => true,
        'data' => $formattedItems
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
