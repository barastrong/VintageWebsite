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

    // 1. Cek apakah ada parameter user_id
    if (!isset($_GET['user_id'])) {
        throw new Exception('Parameter user_id diperlukan');
    }

    $user_id = $_GET['user_id'];
    
    // 2. Query SQL
    // Mengambil produk yang dilike oleh user tersebut
    $query = "SELECT 
                p.id, 
                p.name, 
                p.price, 
                p.image, 
                p.size,
                (SELECT COALESCE(SUM(likes_count), 0) FROM product_likes WHERE product_id = p.id) as total_likes
              FROM product_likes pl
              JOIN product p ON pl.product_id = p.id
              WHERE pl.user_id = :uid";
              // Tambahkan 'AND pl.likes_count = 1' jika database Anda masih menyimpan history unlike sebagai angka 0
        
    $stmt = $pdo->prepare($query);
    $stmt->execute(['uid' => $user_id]);
    
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // 3. Format Data
    $formattedData = [];
    foreach ($items as $item) {
        $formattedData[] = [
            'id'    => (int)$item['id'],
            'name'  => $item['name'],
            'price' => number_format($item['price'], 0, ',', '.'), 
            'image' => $item['image'], 
            'size'  => $item['size'],
            'likes' => (int)$item['total_likes'],
            'liked' => true 
        ];
    }
    
    echo json_encode([
        'success' => true,
        'data' => $formattedData
    ]);
    
} catch (Exception $e) {
    http_response_code(500); 
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>