<?php
// Include the database connection file
include 'connection.php';

// Check if the registration form is submitted
if (isset($_POST['reg_btn'])) {
    // Get the form data
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $password_2 = $_POST['password_2'];

    // Validate if passwords match
    if ($password !== $password_2) {
        echo "Passwords do not match.";
    } else {
        // Hash the password
        $hashed_password = md5($password);

        // Check if the email already exists in the database
        $check_email_query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $check_email_query);
        
        if (mysqli_num_rows($result) > 0) {
            echo "Email is already registered.";
        } else {
            // Insert the new user into the database
            $insert_query = "INSERT INTO users (full_name, email, phone, password) 
                             VALUES ('$full_name', '$email', '$phone', '$hashed_password')";
            $insert_result = mysqli_query($conn, $insert_query);

            if ($insert_result) {
                echo "<script>
                alert('Register successful!');
                window.location.href = '" . ($_SERVER['HTTP_REFERER'] ?? 'index.php') . "';
              </script>";
        exit(); // Ensure no further code is executed after redirect
            } else {
                echo "<script>
                alert('Email Already Exist!');
                window.location.href = '" . ($_SERVER['HTTP_REFERER'] ?? 'login.php') . "';
              </script>";
             exit(); // Stop script execution
            }
        }
    }
}
?>