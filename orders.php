<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id'])) {
    echo "<script>
    alert('Please Login First!');
    window.location.href = 'index.php';
    </script>";
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_POST['cart_items']) || empty($_POST['cart_items'])) {
    echo "<script>
    alert('No items selected for checkout.');
    window.location.href = 'cart.php';
    </script>";
    exit();
}

$cart_items = $_POST['cart_items'];
$_SESSION['cart_ids'] = implode(',', $cart_items);
$_SESSION['cart_items_temp'] = $cart_items;  // Temporarily save cart items in session

// Calculate the total price from cart items (just like you did in the cart)
// Calculate the total price from cart items (including quantity)
$total_order_price = 0;

foreach ($cart_items as $item_id) {
    // Query to get both price and quantity of the selected item
    $query = "SELECT cart.price, cart.qty, cart.size, products.prod_title, products.prod_img 
      FROM cart 
      JOIN products ON cart.product_id = products.id
      WHERE cart.id = '$item_id' AND cart.user_id = '$user_id'";

    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        // Calculate the total price for this item: price * qty
        $item_total = $row['price'] * $row['qty']; 
        $total_order_price += $item_total; 

        // Store item details in session for later use if needed
        $order_details[] = [
          'item_id' => $item_id,
          'prod_title' => $row['prod_title'],
          'prod_img' => $row['prod_img'],
          'price' => $row['price'],
          'qty' => $row['qty'],
          'size' => isset($row['size']) ? $row['size'] : 'N/A',  // Check if size exists
          'item_total' => $item_total
      ];
      
    }
}

// Generate unique transaction number
$transaction_no = uniqid('TRANS-');

// Save order to the database when modal confirmation button is clicked
if (isset($_POST['confirm_order'])) {
    $order_details_json = json_encode($order_details); // Save cart items as a JSON string
    $total_price = $total_order_price;  // Get the total order price
    $reference_no = $_POST['reference_no']; // Get the reference number from the form

   // Start the transaction
mysqli_begin_transaction($conn);

try {
    // Insert order into the orders table
    $insert_order = "INSERT INTO orders (user_id, transaction_no, total, created_at, order_details, reference_no)
                     VALUES ('$user_id', '$transaction_no', '$total_price', NOW(), '$order_details_json', '$reference_no')";
    if (mysqli_query($conn, $insert_order)) {
        // If the order insertion is successful, delete cart items
        $cart_items_str = implode(',', $cart_items); // Convert cart items array to a string
        $delete_cart_query = "DELETE FROM `cart` WHERE `id` IN ($cart_items_str) AND `user_id` = '$user_id'";
        if (mysqli_query($conn, $delete_cart_query)) {
            // If cart items deleted successfully, commit transaction
            mysqli_commit($conn);
            echo "<script>
            alert('Order confirmed and cart cleared!');
            window.location.href = 'thank_you.php';
            </script>";
        } else {
            throw new Exception("Failed to clear cart.");
        }
    } else {
        throw new Exception("Failed to insert order.");
    }
} catch (Exception $e) {
    // If any error occurs, rollback the transaction
    mysqli_rollBack($conn);
    echo "<script>
    alert('Error: " . $e->getMessage() . "');
    window.location.href = 'cart.php';
    </script>";
}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Summary</title>
<style>
    .order-container { font-size: 2rem; max-width: 751px; margin: 0 auto; padding: 0px; border: 1px solid #ddd; border-radius: 8px; }
    .order-item { display: flex; align-items: center; margin-bottom: 10px; }
    .order-item img { width: 80px; height: 80px; object-fit: cover; margin-right: 10px; border-radius: 4px; }
    .order-details { flex: 1; }
    .order-summary { font-weight: bold; text-align: right; }
    .modal { display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0, 0, 0, 0.4); }
    .modal-content { background-color: white; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 400px; }
    .modal-footer { text-align: left; margin-top: 20px; }
    .modal-footer button { padding: 10px 20px; font-size: 16px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
    .modal-footer button.cancel { background-color: red; }
    .btn-con { background-color: #4CAF50; color: white; font-size: 2rem; cursor: pointer; padding: 10px; }
    .reference_number { width: 350px; height: 30px; font-size: 18px; padding: 10px; border-radius: 5px; border: 1px solid #ccc; margin: 10px; }
    form input { font-size: 18px; height: 30px; padding: 5px; }
    .date-time { margin-bottom: 20px; }
</style>
</head>
<body>
<div class="order-container">
  <h2>Order Summary</h2>
  <?php 
  // Initialize the total price
  $total_order_price = 0;

  foreach ($order_details as $order_item):
?>
<div class="order-item">
    <img src="<?= $order_item['prod_img']; ?>" alt="<?= $order_item['prod_title']; ?>">
    <div class="order-details">
        <p><?= $order_item['prod_title']; ?> (Size: <?= $order_item['size']; ?>)</p>
        <p>Price: PHP <?= number_format($order_item['price'], 2); ?></p>
        <p>Quantity: <?= $order_item['qty']; ?></p>
        <p>Item Total: PHP <?= number_format($order_item['item_total'], 2); ?></p> <!-- Show item total -->
    </div>
</div>
<?php 
    // Accumulate the total price for all items
    $total_order_price += $order_item['item_total']; 
    $total_qty = $order_item['qty']; 
endforeach;
  ?>

  <!-- Replace the order summary with the calculated total -->
  <p class="order-summary" style="font-size: 1.5rem; font-weight: bold; text-align: right;">
    Total Order Price: PHP <?= number_format($total_order_price, 2); ?>
  </p>

  <!-- Proceed to order confirmation button -->
  <button onclick="openModal()" class="btn-con">Confirm</button>
  
  <!-- Modal Structure for confirmation -->
  <div id="qrModal" class="modal">
    <div class="modal-content">
      <h3>Order Confirmation</h3>
      <img src="img/QrCode.jpg" alt="QR Code" style="height: 30vh;">
      <p>Scan the QR code to Confirm your payment</p>

      <div class="modal-footer">
        <form action="confirm_order.php" method="POST">
          <label for="reference_no">Enter Reference Number:</label>
          <input type="text" id="reference_no" name="reference_no" class="reference_number" placeholder="Enter Reference Number" required>
          <input type="hidden" name="cart_items" value="<?= implode(",", $cart_items) ?>">
          <input type="hidden" name="transaction_no" value="<?= $transaction_no ?>">
          <input type="hidden" name="total_qty" value="<?= $total_qty ?>">
          <input type="hidden" name="total_amount" value="<?= $total_order_price ?>">
          <div class="date-time">
            <input type="date" name="date_r">
            <input type="time" name="time_r">
          </div>
          <button type="button" class="cancel" onclick="closeModal()">Cancel</button>
          <button type="submit" name="confirm_order">Confirm Order</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
// Function to open the modal
function openModal() {
    document.getElementById("qrModal").style.display = "block";
}

// Function to close the modal
function closeModal() {
    document.getElementById("qrModal").style.display = "none";
}

// Close modal if clicked outside of the modal content
window.onclick = function(event) {
    if (event.target == document.getElementById("qrModal")) {
        closeModal();
    }
}
</script>
</body>
</html>
