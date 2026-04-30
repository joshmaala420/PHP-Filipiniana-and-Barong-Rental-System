<?php
ob_start();  // Start output buffering
session_start();
include('header.php');
include('sidebar.php');
include('connection.php');
include('includes.php');

if (!isset($_SESSION['admin_username'])) {
    header('Location: index.php');
    exit();
}
// Get the search term if it exists
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Modify the SQL query to search for admins by username, email, or password
$sql = "SELECT * FROM admins WHERE username LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%'";

$AdminsRecords = mysqli_query($conn, $sql);
ob_end_flush();  // End output buffering and flush the output
?>

<style>
    .content{
        margin-top: 80px;
    }
     /* Modal styles */
     .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .form-input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn-edit {
            background-color: #28a745;
            border: none;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-edit:hover {
            background-color: #218838;
        }
        .add-admin{
        position: absolute;
        right: 20px;
        top: 200px;
        padding: 5px;
    }
</style>

<div class="content">
<div class="search-container" style="margin-bottom: 20px;">
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Search admins..." class="form-input" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
</div>

<button class="add-admin" onclick="openAdminModal()">+ Add Admin</button>
        <!-- Content Sections -->
         
        <div id="Orders" class="table-container">
            <h2>Admins</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    while($row = mysqli_fetch_assoc($AdminsRecords)){
                        $ID = $row['id']; ?>
                     <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['password']; ?></td>
                        <td ><button class="btn btn-edit btn-success" type="button" onclick="openEditModal(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['username']); ?>', '<?php echo htmlspecialchars($row['email']); ?>', '<?php echo htmlspecialchars($row['password']); ?>')">Edit</button>
                        <?php echo "<a href=\"functions.php?OrdersDeleteID=$ID\"><button class=\"btn btn-danger\">Delete</button></a>"?>
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

            <!-- Modal for Editing admin -->
            <div id="editModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeEditModal()">&times;</span>
                    <h2>Edit admin</h2>
                    <form id="editForm" method="POST" action="update_admin.php" enctype="multipart/form-data">
                        <input type="hidden" id="userId" name="userId">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-input" required>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-input" required>
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-input">
                        <button type="submit" class="btn-edit">Save Changes</button>
                    </form>
                </div>
            </div>
             <!-- Modal for adding admin -->
             <div id="add-Admin-Modal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeAdminModal()">&times;</span>
                    <h2>Add admin</h2>
                    <form id="addForm" method="POST" action="add_admin.php" enctype="multipart/form-data">
                        <input type="hidden" id="userId" name="userId">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-input" required>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-input" required>
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-input">
                        <button type="submit" class="btn-edit" name="add_btn">Submit</button>
                    </form>
                </div>
            </div>


<script>
    function openAdminModal(){
        document.getElementById('add-Admin-Modal').style.display = 'block';
    }
     // Close the Edit Modal
     function closeAdminModal() {
        document.getElementById('add-Admin-Modal').style.display = 'none';
    }
     // Open the Edit Modal and populate it with user data
     function openEditModal(userId, username, email, phone, password) {
        document.getElementById('userId').value = userId;
        document.getElementById('username').value = username;
        document.getElementById('email').value = email;
        document.getElementById('password').value = '';  // Clear previous input for file upload
        document.getElementById('editModal').style.display = 'block';
    }

    // Close the Edit Modal
    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }
</script>