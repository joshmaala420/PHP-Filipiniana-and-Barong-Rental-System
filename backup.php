<?php
session_start();
include('connection.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Please Login First!');
            window.location.href = 'index.php';
        </script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['user_email'];

// Ensure there are items in the cart
if (!isset($_SESSION['cart_items_temp']) || empty($_SESSION['cart_items_temp'])) {
    echo "<script>
            alert('No items to confirm.');
            window.location.href = 'cart.php';
        </script>";
    exit();
}
$cart_items = $_SESSION['cart_items_temp'];
$total_order_price = 0;
$transaction_no = uniqid('TRANS-');



// Step 1: Check if any product is already reserved for the selected date
$cart_conflict = false;

foreach ($cart_items as $cart_item_id) {
    // Get the product_id from cart items
    $query_product = "SELECT product_id FROM cart WHERE id = '$cart_item_id' AND user_id = '$user_id'";
    $result_product = mysqli_query($conn, $query_product);
    if (!$result_product) {
        echo "Error in query: " . mysqli_error($conn);
        exit();
    }

    if ($result_product && $product_row = mysqli_fetch_assoc($result_product)) {
        $product_id = $product_row['product_id'];

        // Check if this product has been reserved for the selected date in the to_pay_orders table
        $query_check_product_reservation = "
            SELECT COUNT(*) AS count FROM to_pay_orders t
            JOIN orders o ON o.transaction_no = t.transaction_no
            WHERE o.product_id = '$product_id'
            AND t.date_r = '$Date_r'
            AND t.status != 'Cancelled'
        ";

        $result_check_product_reservation = mysqli_query($conn, $query_check_product_reservation);
        if (!$result_check_product_reservation) {
            echo "Error in query: " . mysqli_error($conn);
            exit();
        }

        $row = mysqli_fetch_assoc($result_check_product_reservation);
        if ($row['count'] > 0) {
            $cart_conflict = true;
            break;  // Exit the loop if any conflict is found
        }
    }
}

if ($cart_conflict) {
    echo "<script>
            alert('One or more products are already reserved on the selected date. Please choose another date or item.');
            window.location.href = 'cart.php';
        </script>";
    exit();
}

// Step 2: Start a transaction to ensure atomic operations
mysqli_begin_transaction($conn);

try {
    // Loop through the cart items and insert the data into the orders table
    foreach ($cart_items as $cart_item_id) {
        $query = "SELECT cart.product_id, cart.size, products.prod_title, products.price, products.prod_img
                FROM cart
                JOIN products ON cart.product_id = products.id
                WHERE cart.id = '$cart_item_id' AND cart.user_id = '$user_id'";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            throw new Exception("Error in query: " . mysqli_error($conn));
        }

        if ($result && $row = mysqli_fetch_assoc($result)) {
            $product_name = $row['prod_title'];
            $product_price = $row['price'];
            $product_image = $row['prod_img'];
            $size = $row['size'];
            $total_order_price = $_POST['total_amount'];
            $total_qty = $_POST['total_qty'];

            // Insert the order into the orders table
            $insert_order = "INSERT INTO orders (product_id, user_id, product_name, product_image, transaction_no, size, qty, total, created_at)
                            VALUES ('{$row['product_id']}', '$user_id', '$product_name', '$product_image', '$transaction_no', '$size','$total_qty', '$product_price', NOW())";
            if (!mysqli_query($conn, $insert_order)) {
                throw new Exception("Failed to insert order.");
            }
        }
    }

    // Get reference number from POST data
    $reference_no = mysqli_real_escape_string($conn, $_POST['reference_no']);

    $Date_r = date('Y-m-d', strtotime($_POST['date_r'])); // Ensure date is in the correct format
    $Time_r = date('H:i', strtotime($_POST['time_r'])); // Ensure time is in the correct format
    // Insert into the to_pay_orders table
    $insert_to_pay_order = "INSERT INTO to_pay_orders (user_id, email, transaction_no, reference_no, total, time_r, date_r, created_at, status)
                            VALUES ('$user_id', '$user_email', '$transaction_no', '$reference_no', '$total_order_price', '$Time_r', '$Date_r', NOW(), 'Pending')";
        if (!mysqli_query($conn, $insert_to_pay_order)) {
            throw new Exception("Failed to insert into to_pay_orders.");
        }

    // Clear the temporary cart data from the session
    unset($_SESSION['cart_items_temp']);

    // Commit the transaction
    mysqli_commit($conn);

    // Redirect to the confirmation page
    echo "<script>
            alert('Order Confirmed!');
            window.location.href = 'index.php'; // Or custom order summary page
        </script>";

    // Delete selected items from the cart after successful order insertion
    $selected_items_str = implode(',', $cart_items);  // Use the same cart items from the session
    $delete_query = "DELETE FROM cart WHERE id IN ($selected_items_str) AND user_id = '$user_id'";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Selected items deleted successfully.'); window.location.href = 'cart.php';</script>";
    } else {
        echo "Error deleting items: " . mysqli_error($conn);
    }

} catch (Exception $e) {
    // If there is any error, rollback the transaction
    mysqli_rollback($conn);
    echo "<script>
            alert('Error processing your order: " . $e->getMessage() . "');
            window.location.href = 'cart.php';
        </script>";
}
?>
