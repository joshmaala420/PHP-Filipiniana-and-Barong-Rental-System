<?php
ob_start();  // Start output buffering
session_start();
include('header.php');
include('sidebar.php');
include('connection.php');
include('includes.php');

// Ensure user is logged in as admin
if (!isset($_SESSION['admin_username'])) {
    header('Location: index.php');
    exit();
}

// Search functionality
$searchQuery = "";
if (isset($_POST['search'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_POST['search']);
}

// Calculate offset for pagination
$limit = 5; // Number of items per page
$pageOrders = isset($_GET['pageOrders']) ? (int)$_GET['pageOrders'] : 1;
$offsetOrders = ($pageOrders - 1) * $limit;

// Modify query to fetch the latest orders from to_pay_orders table and allow search
$query = "SELECT * FROM to_pay_orders WHERE transaction_no LIKE '%$searchQuery%' OR reference_no LIKE '%$searchQuery%' OR email LIKE '%$searchQuery%' ORDER BY created_at DESC LIMIT $offsetOrders, $limit";
$OrdersRecords = mysqli_query($conn, $query);

// Calculate the total number of records that match the search query
$totalRecordsQuery = "SELECT COUNT(*) AS total FROM to_pay_orders WHERE transaction_no LIKE '%$searchQuery%' OR reference_no LIKE '%$searchQuery%' OR email LIKE '%$searchQuery%'";
$totalRecordsOrders = mysqli_fetch_assoc(mysqli_query($conn, $totalRecordsQuery))['total'];
$totalPagesOrders = ceil($totalRecordsOrders / $limit);


ob_end_flush();  // End output buffering and flush the output
?>

<div class="content">
    <!-- Content Sections -->
    <div id="Orders" class="table-container">
        <h2>Orders</h2>

        <!-- Search Bar -->
        <form method="POST" action="" style="margin-bottom: 20px;">
            <input type="text" name="search" class="form-control" placeholder="Search by Transaction No, Reference No, or User" value="<?php echo $searchQuery; ?>">
            <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Search</button>
        </form>

        <!-- Orders Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Transaction No</th>
                    <th>Reference No</th>
                    <th>View Orders</th>
                    <th>Total Amount</th>
                    <th>Reserve Date</th>
                    <th>Reserve Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                while($row = mysqli_fetch_assoc($OrdersRecords)){
                    $ID = $row['id']; 
                    $TRNO = $row['transaction_no'];
                    $TotalP = $row['total'];
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['transaction_no']; ?></td>
                        <td><?php echo $row['reference_no']; ?></td>
                        <td><?php echo "<a href=\"view_orders.php?ViewOrder=$TRNO && totalPrice=$TotalP\"><button class=\"btn bg-dark text-white\">Orders</button></a>"?></td>
                        <td><?php echo $row['total']; ?></td>
                        <td><?php echo $row['date_r']; ?></td>
                        <td><?php  echo !empty($row['time_r']) ? $row['time_r'] : 'No time set'; ?></td>
                        <td><?php 
                            if ($row['status'] == 1){
                                echo "Approved";
                            }elseif($row['status'] == 0){
                                echo "Pending";
                            }elseif($row['status'] == 2){
                                echo "Canceled";
                            } ?></td>
                        <td> 
                            <?php echo "<a href=\"functions.php?OrdersAcceptID=$ID\"><button class=\"btn btn-success\">Accept</button></a>"?>
                            <?php echo "<a href=\"functions.php?OrdersCancelID=$ID\"><button class=\"btn btn-primary\">Cancel</button></a>"?>
                            <?php echo "<a href=\"functions.php?OrdersDeleteID=$ID && TransNo=$TRNO\"><button class=\"btn btn-danger\">Delete</button></a>"?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Pagination Links -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php if($pageOrders > 1): ?>
                    <li class="page-item"><a class="page-link" href="?pageOrders=<?php echo $pageOrders-1; ?>">Previous</a></li>
                <?php endif; ?>

                <?php for($i = 1; $i <= $totalPagesOrders; $i++): ?>
                    <li class="page-item <?php if($i == $pageOrders) echo 'active'; ?>">
                        <a class="page-link" href="?pageOrders=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if($pageOrders < $totalPagesOrders): ?>
                    <li class="page-item"><a class="page-link" href="?pageOrders=<?php echo $pageOrders+1; ?>">Next</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <div id="modal" class="order-modal" style="display: none;">
        <div class="modal-content"></div>
    </div>

</div>
