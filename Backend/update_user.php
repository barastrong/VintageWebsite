<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Tambahkan Authorization jika menggunakan token
header('Access-Control-Max-Age: 86400'); 

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once 'db.php';

// Folder untuk menyimpan gambar user
$uploadDir = __DIR__ . '/uploads/users/';

// Pastikan folder ada
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Ambil data dari $_POST karena ini adalah FormData
    $userId = $_POST['userId'] ?? null;
    $fullname = $_POST['fullName'] ?? ''; 
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    
    $imagePath = null;
    $updateImageQuery = "";
    
    if (empty($userId) || empty($fullname) || empty($username) || empty($email)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'All fields and User ID are required']);
        exit;
    }
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $destPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $imagePath = 'uploads/users/' . $fileName;
            $updateImageQuery = ", image = ?";
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file']);
            exit;
        }
    }
    
    // 3. Validasi Keunikan
    $stmt = $pdo->prepare("SELECT id, image FROM users WHERE (email = ? OR username = ?) AND id != ?");
    $stmt->execute([$email, $username, $userId]);
    $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($currentUser) {
        http_response_code(409); 
        echo json_encode(['success' => false, 'message' => 'Email or username is already taken by another user']);
        exit;
    }

    // 4. Update data di database
    $sql = "UPDATE users SET fullname = ?, username = ?, email = ? {$updateImageQuery} WHERE id = ?";
    
    $updateData = [$fullname, $username, $email];
    if ($imagePath !== null) {
        // Jika ada gambar baru, hapus gambar lama
        $getOldImage = $pdo->prepare("SELECT image FROM users WHERE id = ?");
        $getOldImage->execute([$userId]);
        $oldUser = $getOldImage->fetch(PDO::FETCH_ASSOC);
        if ($oldUser && $oldUser['image'] && file_exists(__DIR__ . '/' . $oldUser['image'])) {
            unlink(__DIR__ . '/' . $oldUser['image']);
        }
        
        $updateData[] = $imagePath;
    }
    $updateData[] = $userId;
    
    $updateStmt = $pdo->prepare($sql);
    
    if ($updateStmt->execute($updateData)) {
        if ($updateStmt->rowCount() > 0 || $imagePath !== null) {
            echo json_encode(['success' => true, 'message' => 'Profile updated successfully', 'imagePath' => $imagePath]);
        } else {
            echo json_encode(['success' => true, 'message' => 'Profile data remains unchanged']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
    }

} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>