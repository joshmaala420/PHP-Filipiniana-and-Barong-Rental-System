<?php
include('connection.php');

session_start(); // Start the session to retrieve user data

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Please log in to add items to the cart.');
            window.location.href = 'login.php'; // Redirect to login page
          </script>";
    exit();
}

// Validate POST data
if (isset($_POST['product_id'], $_POST['size'], $_POST['qty'])) {
    $productId = intval($_POST['product_id']);
    $size = htmlspecialchars($_POST['size'], ENT_QUOTES, 'UTF-8');
    $userId = $_SESSION['user_id']; // Use session for user ID
    $quantity = intval($_POST['qty']);

    // Ensure valid quantity
    if ($quantity <= 0) {
        echo "<script>
                alert('Invalid quantity!');
                window.history.back();
              </script>";
        exit();
    }

    // Fetch product details
    $stmt = $conn->prepare("SELECT prod_img, prod_title, price FROM products WHERE id = ?");
    if ($stmt === false) {
        echo "<script>alert('Database error: Could not fetch product details.'); window.history.back();</script>";
        exit();
    }

    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $fetchData = $result->fetch_assoc();
        $productName = $fetchData['prod_title'];
        $productPrice = $fetchData['price'];
        $productImg = $fetchData['prod_img'];

        // Check if product with this size already exists in the cart
        $checkStmt = $conn->prepare("SELECT qty FROM cart WHERE user_id = ? AND product_id = ? AND size = ?");
        if ($checkStmt === false) {
            echo "<script>alert('Database error: Could not check cart.'); window.history.back();</script>";
            exit();
        }

        $checkStmt->bind_param("iis", $userId, $productId, $size);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // Product with this size already exists, update quantity
            $updateStmt = $conn->prepare("UPDATE cart SET qty = qty + ? WHERE user_id = ? AND product_id = ? AND size = ?");
            if ($updateStmt === false) {
                echo "<script>alert('Database error: Could not update cart.'); window.history.back();</script>";
                exit();
            }

            $updateStmt->bind_param("iiis", $quantity, $userId, $productId, $size);
            $updateStmt->execute();
            $updateStmt->close();
        } else {
            // Insert new product into cart with the selected size
            $insertStmt = $conn->prepare("INSERT INTO cart (user_id, product_id, name, product_image, price, size, qty) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if ($insertStmt === false) {
                echo "<script>alert('Database error: Could not add product to cart.'); window.history.back();</script>";
                exit();
            }

            $insertStmt->bind_param("iissssi", $userId, $productId, $productName, $productImg, $productPrice, $size, $quantity);
            $insertStmt->execute();
            $insertStmt->close();
        }

        // Redirect back to the product page or previous page
        echo "<script>
                alert('Product added/updated in the cart!');
                window.location.href = '" . ($_SERVER['HTTP_REFERER'] ?? 'product.php') . "';
              </script>";
    } else {
        echo "<script>
                alert('Product not found.');
                window.history.back();
              </script>";
    }

    // Close prepared statement
    $stmt->close();
    $checkStmt->close();
} else {
    echo "<script>
            alert('Missing product details.');
            window.history.back();
          </script>";
}

// Close the database connection
$conn->close();
?>
