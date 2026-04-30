<?php
session_start();
include('connection.php');

if (isset($_POST['item_id']) && isset($_POST['quantity'])) {
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    $user_id = $_SESSION['user_id'];

    // Validate quantity (ensure it's a positive integer)
    if ($quantity > 0) {
        $update_query = "UPDATE cart SET qty = '$quantity' WHERE id = '$item_id' AND user_id = '$user_id'";
        if (mysqli_query($conn, $update_query)) {
            echo "Quantity updated successfully.";
        } else {
            echo "Error updating quantity: " . mysqli_error($conn);
        }
    }
}
?>
