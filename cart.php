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

// Handle the deletion of selected items
if (isset($_POST['delete_selected'])) {
    $selected_items = $_POST['cart_items']; // Array of selected item IDs
    if (!empty($selected_items)) {
        $selected_items_str = implode(',', $selected_items); // Convert array to comma-separated string
        $delete_query = "DELETE FROM cart WHERE id IN ($selected_items_str) AND user_id = '$user_id'";
        if (mysqli_query($conn, $delete_query)) {
            echo "<script>alert('Selected items deleted successfully.'); window.location='cart.php';</script>";
        } else {
            echo "Error deleting items: " . mysqli_error($conn);
        }
    }
}

// Fetch all cart items for the logged-in user
$query = "SELECT id, user_id, product_id, name, product_image, price, size, qty, created_at
          FROM cart 
          WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="cart-navigation">
            <a href="index.php" class="btn btn-secondary back-btn">Back</a>
            <a href="view_orders.php" class="btn btn-info view-orders-btn">View Orders</a>
          </div>';
    echo '<h2 class="cart-title">Your Cart</h2>';
    echo '<form action="orders.php" method="post" id="cart-form">';

    // Add Select All checkbox at the top
    echo '<div class="cart-select-all">
            <input type="checkbox" id="select-all"> <label for="select-all">Select All</label>
          </div>';

    echo '<div class="cart-summary">
            <div><strong>Total: PHP <span id="total-price">0.00</span></strong></div>
            <button type="submit" class="btn btn-primary checkout-btn">Proceed to Checkout</button>
            <button type="button" onclick="deleteSelectedItems()" class="btn btn-danger">Delete Selected</button>
          </div>';

    echo '<div class="cart-items">';
    while ($row = mysqli_fetch_assoc($result)) {
        $qty = $row['qty']; // Use 'qty' instead of 'quantity'
        $item_total = $row['price'] * $qty; // Use 'qty' instead of 'quantity'
    
        echo '<div class="cart-item" data-id="' . $row['id'] . '" data-price="' . $row['price'] . '">
        <div class="cart-item-image">
            <img src="' . htmlspecialchars($row['product_image']) . '" alt="' . htmlspecialchars($row['name']) . '">
        </div>
        <div class="cart-item-info">
            <div class="cart-item-name">' . htmlspecialchars($row['name']) . '</div>
            <div class="cart-item-size">Size: ' . htmlspecialchars($row['size']) . '</div>
            <div class="cart-item-quantity">
                Quantity: 
                <button type="button" class="qty-btn minus" data-id="' . $row['id'] . '">-</button>
                <span class="qty-display">' . $qty . '</span>
                <button type="button" class="qty-btn plus" data-id="' . $row['id'] . '">+</button>
            </div>
            <div class="cart-item-price">PHP ' . number_format($row['price'], 2) . '</div>
            <div class="cart-item-total">Total: PHP <span class="item-total">' . number_format($item_total, 2) . '</span></div>
            <div class="select-checkbox">
                <input class="form-check-input" type="checkbox" name="cart_items[]" value="' . $row['id'] . '" data-price="' . $row['price'] . '">
            </div>
        </div>
    </div>';
    }
    echo '</div>';

    // Get the total cost of items in the cart
    $total_cost_query = "SELECT SUM(price * qty) AS total_cost FROM cart WHERE user_id = '$user_id'"; // Use 'qty' instead of 'quantity'

    $total_cost_result = mysqli_query($conn, $total_cost_query);
    $total_cost = mysqli_fetch_assoc($total_cost_result)['total_cost'];

    echo '</form>';
} else {
    echo '<div class="cart-navigation">
            <a href="index.php" class="btn btn-secondary back-btn">Back</a>
            <a href="view_orders.php" class="btn btn-info view-orders-btn">View Orders</a>
          </div>';
    echo '<h2 class="cart-title">Your Cart</h2>';
    echo '<div class="alert alert-warning">Your cart is empty.</div>';
}
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding-top: 80px; /* Allow space for the fixed header */
        }

        .cart-title {
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 30px;
            color: #333;
        }

        .cart-navigation {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .back-btn, .view-orders-btn {
            padding: 10px 20px;
            font-size: 1rem;
        }

        .cart-summary {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 15px 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 10;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.2rem;
            color: #333;
            box-sizing: border-box;
        }

        .cart-items {
            margin-top: 100px; /* Make space for the fixed summary at the top */
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin: 0 10%;
        }

        .cart-item {
            display: flex;
            align-items: center;
            background-color: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease-in-out;
            cursor: pointer;
            position: relative;
        }

        .cart-item:hover {
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
            background-color: #f7f7f7;
        }

        .cart-item.selected {
            background-color: #e3f2fd; /* Light blue background when selected */
        }

        .cart-item-image img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .cart-item-info {
            margin-left: 20px;
            flex-grow: 1;
        }

        .cart-item-name {
            font-size: 1.1rem;
            font-weight: bold;
        }

        .cart-item-size, .cart-item-price, .cart-item-total {
            color: #666;
            font-size: 1rem;
        }

        .cart-item-price {
            font-size: 1.1rem;
            color: #28a745;
            font-weight: bold;
        }

        .select-checkbox {
            position: absolute;
            top: 15px;
            right: 15px;
        }

        .form-check-input {
            width: 25px;
            height: 25px;
            cursor: pointer;
        }

        .checkout-btn {
            padding: 10px 20px;
            background-color: #28a745;
            border: none;
            color: #fff;
            cursor: pointer;
            font-size: 1rem;
            border-radius: 5px;
        }

        .checkout-btn:hover {
            background-color: #218838;
        }

        .cart-summary div {
            font-size: 1rem;
            color: #333;
        }

        .cart-summary button {
            padding: 10px 20px;
        }
        .qty-btn {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .qty-btn:hover {
            background-color: #e0e0e0;
        }

        .qty-display {
            font-size: 1.2rem;
            padding: 0 10px;
            display: inline-block;
            width: 40px;
            text-align: center;
        }
        .cart-select-all {
            position: absolute;
            top: 150px;
            right: 200px;
            background-color: #f8f9fa;
            padding: 15px 20px; /* Increased padding */
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            font-size: 1.2rem; /* Adjusted font size */
        }

        .cart-select-all input {
            margin-right: 12px; /* Increased space between checkbox and label */
            width: 24px; /* Increased checkbox size */
            height: 24px; /* Increased checkbox size */
        }

        .cart-select-all label {
            font-weight: bold;
            font-size: 1.2rem; /* Larger label font size for better alignment */
        }



    </style>
</head>

<script>
// JavaScript remains the same for updating total price and item selection
function deleteSelectedItems() {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = ''; // Submitting to the same page

    const deleteInput = document.createElement('input');
    deleteInput.type = 'hidden';
    deleteInput.name = 'delete_selected';
    deleteInput.value = '1';

    form.appendChild(deleteInput);

    document.querySelectorAll('input[name="cart_items[]"]:checked').forEach(checkbox => {
        const hiddenCheckbox = document.createElement('input');
        hiddenCheckbox.type = 'hidden';
        hiddenCheckbox.name = 'cart_items[]';
        hiddenCheckbox.value = checkbox.value;
        form.appendChild(hiddenCheckbox);
    });

    document.body.appendChild(form);
    form.submit();
}

// Handle item selection and total calculation
const checkboxes = document.querySelectorAll('.form-check-input');
const totalPriceElement = document.getElementById('total-price');

// JavaScript for handling quantity changes and recalculating the total
let total = 0;

// Function to update the total price based on selected items
function updateTotal() {
    total = 0;

    // Loop through all checkboxes that are checked
    document.querySelectorAll('.form-check-input:checked').forEach(checkedBox => {
        const price = parseFloat(checkedBox.getAttribute('data-price')); // Get the price from the checkbox's data-price attribute
        const qty = parseInt(checkedBox.closest('.cart-item').querySelector('.qty-display').innerText); // Get the quantity from the item details

        // Add the price * quantity to the total if the price and qty are valid numbers
        if (!isNaN(price) && !isNaN(qty)) {
            total += price * qty;
        }
    });

    // Update the total price on the page
    totalPriceElement.textContent = total.toFixed(2); // Display the total with two decimals
}

// Select/Deselect All checkbox functionality
document.getElementById('select-all').addEventListener('change', function() {
    const isChecked = this.checked;

    // Check or uncheck all item checkboxes
    document.querySelectorAll('.form-check-input').forEach(checkbox => {
        checkbox.checked = isChecked;
    });

    updateTotal(); // Recalculate the total after selection changes
});

// Call updateTotal on page load to initialize the total based on currently selected items
document.addEventListener('DOMContentLoaded', updateTotal);

// Handle increase/decrease of item quantity
document.querySelectorAll('.qty-btn').forEach(button => {
    button.addEventListener('click', function() {
        const buttonType = this.classList.contains('plus') ? 'plus' : 'minus'; // Determine if it's a plus or minus button
        const cartItem = this.closest('.cart-item');
        const qtyDisplay = cartItem.querySelector('.qty-display');
        let currentQty = parseInt(qtyDisplay.innerText);
        const itemId = this.getAttribute('data-id');
        
        if (buttonType === 'plus') {
            currentQty += 1; // Increase the quantity by 1
        } else if (buttonType === 'minus' && currentQty > 1) {
            currentQty -= 1; // Decrease the quantity by 1, but don't go below 1
        }

        // Update the quantity display
        qtyDisplay.innerText = currentQty;

        // Update the total price for this item
        const itemPrice = parseFloat(cartItem.querySelector('.cart-item-price').innerText.replace('PHP', '').trim());
        const itemTotal = itemPrice * currentQty;
        cartItem.querySelector('.item-total').innerText = 'PHP ' + itemTotal.toFixed(2); // Update item total

        updateTotal(); // Recalculate the total for all selected items

        // Optionally, you can update the quantity in the database using AJAX
        updateCartItemQuantity(itemId, currentQty);
    });
});

// Update the total price when a checkbox is clicked (only when checkboxes are checked or unchecked)
document.querySelectorAll('.form-check-input').forEach(checkbox => {
    checkbox.addEventListener('change', updateTotal);
});
// Example AJAX function to update the quantity in the database
function updateCartItemQuantity(itemId, quantity) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_cart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status == 200) {
            console.log('Cart updated successfully');
        } else {
            console.error('Failed to update cart');
        }
    };
    xhr.send(`item_id=${itemId}&quantity=${quantity}`);
}
</script>
