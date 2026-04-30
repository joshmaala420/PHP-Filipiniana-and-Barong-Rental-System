<?php
// Start session
session_start();
include('connection.php'); // Your database connection file

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Check if we are deleting a single item or multiple items
    if (isset($_GET['id'])) {
        // Single item deletion (existing behavior)
        $item_id = $_GET['id'];
        
        // Sanitize and validate item ID
        if (!is_numeric($item_id)) {
            echo "Invalid item ID";
            exit;
        }
        
        $item_id = mysqli_real_escape_string($conn, $item_id);

        // SQL query to delete the cart item
        $query = "DELETE FROM `cart` WHERE `id` = ? AND `user_id` = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ii", $item_id, $user_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "Item deleted successfully";
        } else {
            echo "Error deleting item: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);

    } elseif (isset($_POST['cart_items']) && is_array($_POST['cart_items'])) {
        // Multiple item deletion (new functionality)
        $selected_items = $_POST['cart_items']; // Array of selected item IDs

        // Validate and sanitize input IDs
        if (array_filter($selected_items, fn($item) => !is_numeric($item))) {
            echo "Invalid item IDs";
            exit;
        }

        // Sanitize each item ID
        $selected_items = array_map(function($item) use ($conn) {
            return mysqli_real_escape_string($conn, $item);
        }, $selected_items);

        // Convert array to a comma-separated string
        $selected_items_str = implode(',', $selected_items);

        // SQL query to delete selected items
        $query = "DELETE FROM `cart` WHERE `id` IN ($selected_items_str) AND `user_id` = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "Selected items deleted successfully";
        } else {
            echo "Error deleting selected items: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Invalid request";  // Handle invalid request (no valid ID or cart_items array)
    }
} else {
    echo "User not logged in";  // Handle case where user is not logged in
}
?>
