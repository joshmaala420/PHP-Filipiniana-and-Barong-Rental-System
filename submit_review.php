<?php
session_start();
include('connection.php');

$data = json_decode(file_get_contents('php://input'), true);
$product_id = $data['product_id'];
$comment = $data['comment'];
$rating = $data['rating'];
$created_at = $data['created_at'];
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; 

if (!$user_id) {
    $user_id = null;
}

$sql = "INSERT INTO reviews (product_id, comment, rating, user_id, created_at) 
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isiss", $product_id, $comment, $rating, $user_id, $created_at);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

$stmt->close();
$conn->close();
?>
