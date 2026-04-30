<?php

// Define limit per page
$limit = 10;

// Get the current page for each type of reservation (default to 1 if not set)
$pageOrders = isset($_GET['pageOrders']) ? (int)$_GET['pageOrders'] : 1;
$pageUsers = isset($_GET['pageUsers']) ? (int)$_GET['pageUsers'] : 1;
$pageAdmins = isset($_GET['pageAdmins']) ? (int)$_GET['pageAdmins'] : 1;
$pageProducts = isset($_GET['pageProducts']) ? (int)$_GET['pageProducts'] : 1;

// Calculate the offset for each type of query
$offsetOrders = ($pageOrders - 1) * $limit;
$offsetUsers = ($pageUsers - 1) * $limit;
$offsetAdmins = ($pageAdmins - 1) * $limit;
$offsetProducts = ($pageProducts - 1) * $limit;

// Orders Page Query
$totalRecordsOrders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM to_pay_orders"))['total'];
$totalPagesOrders = ceil($totalRecordsOrders / $limit);
$OrdersRecords = mysqli_query($conn, "SELECT * FROM to_pay_orders LIMIT $offsetOrders, $limit");

// Users Page Query with Search Functionality
$searchQueryUsers = isset($_GET['search_user']) ? mysqli_real_escape_string($conn, $_GET['search_user']) : '';

// Modify the query to search based on the input for Users
$searchConditionUsers = "";
if ($searchQueryUsers) {
    $searchConditionUsers = "WHERE full_name LIKE '%$searchQueryUsers%' OR email LIKE '%$searchQueryUsers%' OR phone LIKE '%$searchQueryUsers%'";
}

// Query to get the users based on the search condition
$queryUsers = "SELECT * FROM users $searchConditionUsers LIMIT $offsetUsers, $limit";

// Get the total number of users matching the search condition
$totalRecordsUsersQuery = "SELECT COUNT(*) AS total FROM users $searchConditionUsers";
$totalRecordsUsers = mysqli_fetch_assoc(mysqli_query($conn, $totalRecordsUsersQuery))['total'];
$totalPagesUsers = ceil($totalRecordsUsers / $limit);

// Fetch the records for the current page
$UsersRecords = mysqli_query($conn, $queryUsers);

// Admins Page Query
$totalRecordsAdmins = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM admins"))['total'];
$totalPagesAdmins = ceil($totalRecordsAdmins / $limit);
$AdminsRecords = mysqli_query($conn, "SELECT * FROM admins LIMIT $offsetAdmins, $limit");

// Products Page Query
$totalRecordsProducts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM products"))['total'];
$totalPagesProducts = ceil($totalRecordsProducts / $limit);
$ProductsRecords = mysqli_query($conn, "SELECT * FROM products LIMIT $offsetProducts, $limit");

?>
