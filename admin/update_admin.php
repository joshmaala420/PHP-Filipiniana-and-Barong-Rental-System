<?php
include('connection.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['userId'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $encpass = md5($password);

    if(!empty($password)){
            $sql = mysqli_query($conn, "UPDATE admins SET  email = '$email', username = '$username' WHERE id= $userId");
            echo "<script>
            alert('Update successful!');
            window.location.href = '" . 'admins_acc_page.php'. "';
          </script>";
            exit();
    }else{
        // if no uploaded image//
        $sql = mysqli_query($conn, "UPDATE admins SET email = '$email', username = '$username',  password ='$encpass' WHERE id= $userId");
        echo "<script>
        alert('Update successful!');
        window.location.href = '" . 'admins_acc_page.php'. "';
         </script>";
        exit();
    }

    $conn->close();
}
?>
