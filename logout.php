<?php
session_start(); 

unset($_SESSION['user_id']);
unset($_SESSION['username']);
unset($_SESSION['email']);

echo "<script>
    alert('Logout successful!');
    window.location.href = 'index.php';
</script>";

exit();
