<?php
session_start();
include('connection.php');

// Helper function to sanitize user input
function sanitizeInput($input) {
    return (int) $input; // cast to integer to prevent SQL injection
}

// Accept Order
if (isset($_GET['OrdersAcceptID'])) {
    $OID = sanitizeInput($_GET['OrdersAcceptID']);
    $OrderStatus = 1;

    // Check if the order is already accepted
    $Ocount = "SELECT COUNT(*) AS statusCount FROM to_pay_orders WHERE id = ? AND status = 1";
    $stmt = $conn->prepare($Ocount);
    $stmt->bind_param("i", $OID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['statusCount'] > 0) {
        echo "<script>alert('This request is already accepted!'); window.location.href = 'orders.php';</script>";
    } else {
        // Fetch transaction_no from to_pay_orders
        $stmt = $conn->prepare("SELECT transaction_no FROM to_pay_orders WHERE id = ?");
        $stmt->bind_param("i", $OID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $trn = $row['transaction_no'];

        // Update the status in both tables
        $Osql2 = $conn->prepare("UPDATE orders SET status = ? WHERE transaction_no = ?");
        $Osql2->bind_param("is", $OrderStatus, $trn);

        $Osql = $conn->prepare("UPDATE to_pay_orders SET status = ? WHERE id = ?");
        $Osql->bind_param("ii", $OrderStatus, $OID);

        if ($Osql->execute() && $Osql2->execute()) {
            echo "<script>alert('Accept Successful!'); window.location.href = 'orders.php';</script>";
        } else {
            echo "<script>alert('Failed to accept!'); window.location.href = 'orders.php';</script>";
        }
    }
}

// Cancel Order
if (isset($_GET['OrdersCancelID'])) {
    $OCID = sanitizeInput($_GET['OrdersCancelID']);
    $OCStatus = 2;

    // Check if the order is already canceled
    $OCCount = "SELECT COUNT(*) AS OCstatusCount FROM to_pay_orders WHERE id = ? AND status = 2";
    $stmt = $conn->prepare($OCCount);
    $stmt->bind_param("i", $OCID);
    $stmt->execute();
    $OCResult = $stmt->get_result();
    $OCrow = $OCResult->fetch_assoc();

    if ($OCrow['OCstatusCount'] > 0) {
        echo "<script>alert('This request is already canceled!'); window.location.href = 'orders.php';</script>";
    } else {
        // Update the status to canceled
        $OCsql = $conn->prepare("UPDATE to_pay_orders SET status = ? WHERE id = ?");
        $OCsql->bind_param("ii", $OCStatus, $OCID);

        if ($OCsql->execute()) {
            echo "<script>alert('Cancellation Successful!'); window.location.href = 'orders.php';</script>";
        } else {
            echo "<script>alert('Failed to cancel!'); window.location.href = 'orders.php';</script>";
        }
    }
}

// Delete Order
if (isset($_GET['OrdersDeleteID'])) {
    $ODID = sanitizeInput($_GET['OrdersDeleteID']);

    // Delete from to_pay_orders table
    $ODsql = $conn->prepare("DELETE FROM to_pay_orders WHERE id = ?");
    $ODsql->bind_param("i", $ODID);

    if ($ODsql->execute()) {
        echo "<script>alert('Delete Successful!');</script>";
        if (isset($_GET['TransNo'])) {
            $transNo = $_GET['TransNo'];

            // Delete from orders table
            $TrSql = $conn->prepare("DELETE FROM orders WHERE transaction_no = ?");
            $TrSql->bind_param("s", $transNo);
            $TrSql->execute();
        }
        echo "<script>window.location.href = 'orders.php';</script>";
    } else {
        echo "<script>alert('Failed to delete!'); window.location.href = 'orders.php';</script>";
    }
}

// Delete Product
if (isset($_GET['ProductsDeleteID'])) {
    $PDID = sanitizeInput($_GET['ProductsDeleteID']);

    $PDsql = $conn->prepare("DELETE FROM products WHERE id = ?");
    $PDsql->bind_param("i", $PDID);

    if ($PDsql->execute()) {
        echo "<script>alert('Delete Successful!'); window.location.href = 'products.php';</script>";
    } else {
        echo "<script>alert('Failed to delete!'); window.location.href = 'products.php';</script>";
    }
}
?>
