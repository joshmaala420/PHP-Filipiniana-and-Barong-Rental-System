<?php
// Start the session at the top of the page
session_start();
include('connection.php'); 

if(isset($_POST['login-btn'])){ 

    $Email = $_POST['email'];
    $password = $_POST['password'];
    $encPass = md5($password); 

    // Query to check the user's credentials
    $sql = mysqli_query($conn , "SELECT * FROM users WHERE email = '$Email' AND password = '$encPass'");

    // If user exists with matching credentials
    if(mysqli_num_rows($sql) > 0){
        // Fetch user data
        $user = mysqli_fetch_assoc($sql);

        // Store user data in session
        $_SESSION['username'] = $user['full_name'];
        $_SESSION['user_id'] = $user['id'];  // Assuming 'id' is the primary key in your users table
        $_SESSION['user_email'] = $user['email']; // Optionally, store the user's email as well

        // Redirect to the referring page or index and show success alert
        echo "<script>
                alert('Login successful!');
                window.location.href = '" . ($_SERVER['HTTP_REFERER'] ?? 'index.php') . "';
              </script>";
        exit(); // Ensure no further code is executed after redirect
    } else { 
        // Login failed, show error alert and redirect back
        echo "<script>
                alert('Invalid email or password!');
                window.location.href = '" . ($_SERVER['HTTP_REFERER'] ?? 'login.php') . "';
              </script>";
        exit(); // Stop script execution
    }
}
?>
