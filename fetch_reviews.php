<?php
// Include the database connection
include('connection.php');

// Get the product_id from the query string
$product_id = $_GET['product_id'];

// Check if the product_id is passed correctly
if (empty($product_id)) {
    echo json_encode(['error' => 'Product ID is missing']);
    exit;
}

// Fetch reviews from the database
$sql = "SELECT username, rating, comment FROM reviews WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the query returned any rows
if ($result->num_rows > 0) {
    // Prepare reviews as an array
    $reviews = [];
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }

    // Return reviews as JSON
    echo json_encode($reviews);
} else {
    echo json_encode(['message' => 'No reviews found for this product']);
}
?>
