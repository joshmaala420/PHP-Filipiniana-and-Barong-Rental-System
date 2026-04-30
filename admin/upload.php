<?php
include('connection.php');
if (isset($_POST['upload'])) {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $prod_name = $_POST['prodname'];
    $prod_size = $_POST['Psize'];
    $prod_price = $_POST['proprice'];
    $prod_Qty = $_POST['proQty'];
    $prod_desc = $_POST['desc'];
    $target_dir = "../uploads/"; // Admin path
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        $image = $_FILES['images']['name'][$key];
        $target_file = $target_dir . basename($image);

        if (move_uploaded_file($tmp_name, $target_file)) {
            $sql = "INSERT INTO products (prod_title, description, price, size , qty, prod_img) VALUES ('$prod_name','$prod_desc',$prod_price,'$prod_size', '$prod_Qty','uploads/$image')";
            if ($conn->query($sql) === TRUE) {
                // Redirect to home.php with a gallery parameter
                header("Location: products.php?");
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Failed to upload image: $image";
        }
    }

    $conn->close();
}

?>
