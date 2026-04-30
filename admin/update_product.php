<?php
include('connection.php');
if (isset($_POST['upload'])) {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $prodId= $_POST['prodId'];
    $prod_name = $_POST['prodName'];
    $prod_size = $_POST['prodSize'];
    $prod_price = $_POST['prodPrice'];
    $prod_Qty = $_POST['prodQty'];
    $prod_desc = $_POST['prodDesc'];
    $target_dir = "../uploads/"; // Admin path
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        $image = $_FILES['images']['name'][$key];
        $target_file = $target_dir . basename($image);

     if(!empty($image)){
        if (move_uploaded_file($tmp_name, $target_file)) {
            $sql = mysqli_query($conn, "UPDATE products SET prod_title = '$prod_name', description = '$prod_desc', price = $prod_price, size ='$prod_size', qty = $prod_Qty, prod_img ='uploads/$image' WHERE id= $prodId");
            echo "<script>
            alert('Update successful!');
            window.location.href = '" . 'products.php'. "';
          </script>";
            exit();
        }
    }else{
        // if no uploaded image//
        $sql = mysqli_query($conn, "UPDATE products SET prod_title = '$prod_name', description = '$prod_desc', price = $prod_price, size ='$Prod_size' WHERE id= $prodId");
        echo "<script>
        alert('Update successful!');
        window.location.href = '" . 'products.php'. "';
         </script>";
        exit();
    }
}

    $conn->close();
}

?>

