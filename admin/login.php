<?php
include('connection.php'); 

// Start the session at the top of the page
session_start();

if(isset($_POST['login-btn'])){ 

    $username = $_POST['username'];
    $password = $_POST['password'];
    $encPass = md5($password); 

    // Query to check the user's credentials
    $sql = mysqli_query($conn , "SELECT * FROM admins WHERE username = '$username' AND password = '$encPass'");

    // If user exists with matching credentials
    if(mysqli_num_rows($sql) > 0){
        // Fetch user data
        $user = mysqli_fetch_assoc($sql);

        // Store user data in session
        $_SESSION['admin_username'] = $username;  // Assuming 'id' is the primary key in your users table

        // Redirect to the referring page or index and show success alert
        echo "<script>
                alert('Login successful!');
                window.location.href = '" . 'home.php'. "';
              </script>";
        exit(); // Ensure no further code is executed after redirect
    } else { 
        // Login failed, show error alert and redirect back
        echo "<script>
                alert('Invalid email or password!');
                window.location.href = '" .  'index.php' . "';
              </script>";
        exit(); // Stop script execution
    }
}
?>
