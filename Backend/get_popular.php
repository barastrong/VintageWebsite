<?php
// get_popular_items.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *'); 
header('Content-Type: application/json');

require 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

try {
    if (!isset($pdo)) {
        throw new Exception('Database connection not established');
    }
    
    // Query untuk mengambil produk dan menjumlahkan likes_count
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
              ORDER BY total_likes DESC, p.created_at DESC 
              LIMIT 5"; // Urutkan utama berdasarkan total_likes dan batasi 5
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $formattedProducts = [];
    foreach ($products as $product) {
        $formattedProducts[] = [
            'id' => $product['id'],
            'name' => $product['name'],
            // Hapus pemformatan harga (number_format) di sini agar ProductCard yang menanganinya
            'price' => $product['price'], 
            'size' => $product['size'] ? $product['size'] : 'One Size',
            // Gunakan 'likes' untuk ProductCard jika itu yang diharapkan
            'likes' => (int)$product['total_likes'],
            'image' => $product['image'] ? $product['image'] : '#E8E8E8',
            'description' => $product['description']
        ];
    }
    
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'data' => $formattedProducts
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'General Error: ' . $e->getMessage()
    ]);
}
?>