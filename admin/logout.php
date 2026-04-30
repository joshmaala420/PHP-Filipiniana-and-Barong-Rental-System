<?php
session_start(); 

unset($_SESSION['admin_id']);

echo "<script>
    alert('Logout successful!');
    window.location.href = 'index.php';
</script>";

exit();
