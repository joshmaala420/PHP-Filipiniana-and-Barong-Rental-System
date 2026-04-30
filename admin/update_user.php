<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['userId'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $encpass = md5($password);

    if(!empty($password)){
            $sql = mysqli_query($conn, "UPDATE users SET full_name = '$username', email = '$email ', phone = $phone, password ='$encpass' WHERE id= $userId");
            echo "<script>
            alert('Update successful!');
            window.location.href = '" . 'users_acc_page.php'. "';
          </script>";
            exit();
    }else{
        // if no uploaded image//
        $sql = mysqli_query($conn, "UPDATE users SET full_name = '$username', email = '$email', phone = $phone, password ='$encpass' WHERE id= $userId");
        echo "<script>
        alert('Update successful!');
        window.location.href = '" . 'users_acc_page.php'. "';
         </script>";
        exit();
    }

    $conn->close();
}
?>
