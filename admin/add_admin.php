<?php
include('connection.php');

if(isset($_POST['add_btn'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $encPass = md5($password);

    $sql = mysqli_query($conn, "INSERT INTO admins (email, username, password) VALUES ('$email','$username ','$encPass')");
    if($sql){
        echo "<script>
        alert('Insert Successful!');
        window.location.href = '" . 'admins_acc_page.php'. "';
      </script>";
        exit();
    }else{
        echo "<script>
        alert('Insert Failed!');
        window.location.href = '" . 'admins_acc_page.php'. "';
      </script>";
        exit();
    }
}

?>