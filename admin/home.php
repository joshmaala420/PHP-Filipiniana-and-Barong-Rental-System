<?php
ob_start();  // Start output buffering
session_start();

if (!isset($_SESSION['admin_username'])) {
    header('Location: index.php');
    exit();
}

// Include connection to database
include('connection.php');  // Include the connection file
include('header.php');
include('sidebar.php');

// Fetch counts from the database using MySQLi queries
$OrdersCountQuery = "SELECT COUNT(*) AS total_Orders FROM orders";
$UsersCountQuery = "SELECT COUNT(*) AS total_Users FROM users";
$AdminsCountQuery = "SELECT COUNT(*) AS total_Admins FROM admins";


$OrdersCountResult = $conn->query($OrdersCountQuery);
$UsersCountResult = $conn->query($UsersCountQuery);
$AdminsCountResult = $conn->query($AdminsCountQuery);


// Fetch the counts from the query result
$OrdersCount = $OrdersCountResult->fetch_assoc()['total_Orders'];
$UsersCount = $UsersCountResult->fetch_assoc()['total_Users'];
$AdminsCount = $AdminsCountResult->fetch_assoc()['total_Admins'];


ob_end_flush();  // End output buffering and flush the output
?>

<!-- Custom styles for the dashboard -->
<style>
    .dashboard {
        display: flex;
        gap: 20px;
        padding: 20px;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-body i {
        font-size: 2.5rem;
    }

    .card-title {
        font-weight: bold;
    }

    /* Style for the total count to make it stand out */
    .rel{
        position: relative;
        height: 200px;
    }
    .highlight-total {
        font-size: 2rem; /* Increase font size */
        font-weight: 700; /* Make it bold */
        color: #333; /* White text */
        background-color: #f2f2f2; /* Coral background */
        border-radius: 0;
        margin-top: 10px;
        width: 350px;
        height: 100px;
        bottom: -1px;
        left: -1px;
        position: absolute;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .big{
        font-size: 20px;
        font-weight: bold;
        color: #333;
    }
</style>

<div class="content">
    <div class="container mt-5">
        <h1 class="text-center">Admin Dashboard</h1>

        <div class="row text-center mt-4">
            <!-- Order Section -->
            <div class="col-md-4">
                <div class="card bg-danger text-white mb-4">
                    <div class="rel card-body">
                        <h5 class="card-title mt-2">Orders</h5>
                        <p class="big card-text">Total Orders</p>
                        <div class="highlight-total"><?php echo $OrdersCount; ?></div> <!-- Highlighted Total -->
                    </div>
                </div>
            </div>
             <!-- Order Section -->
             <div class="col-md-4">
                <div class="rel card bg-primary text-white mb-4">
                    <div class="card-body">
                        <h5 class="card-title mt-2">Users</h5>
                        <p class="big card-text">Total Users</p>
                        <div class="highlight-total"><?php echo $UsersCount; ?></div> <!-- Highlighted Total -->
                    </div>
                </div>
            </div>
             <!-- Order Section -->
             <div class="col-md-4">
                <div class="rel card bg-warning text-white mb-4">
                    <div class="card-body">
                        <h5 class="card-title mt-2">Admins</h5>
                        <p class="big card-text">Total Admins</p>
                        <div class="highlight-total"><?php echo $AdminsCount; ?></div> <!-- Highlighted Total -->
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
