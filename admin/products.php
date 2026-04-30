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

// Fetch search query from GET if present
$searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Modify query to include the search condition
$query = "SELECT * FROM products WHERE prod_title LIKE '%$searchQuery%' OR description LIKE '%$searchQuery%' ORDER BY id DESC";

// Get total records for pagination
$totalRecordsQuery = "SELECT COUNT(*) FROM products WHERE prod_title LIKE '%$searchQuery%' OR description LIKE '%$searchQuery%'";
$totalRecordsResult = mysqli_query($conn, $totalRecordsQuery);
$totalRecords = mysqli_fetch_array($totalRecordsResult)[0];

// Define pagination variables
$limit = 10; // Records per page
$totalPagesProducts = ceil($totalRecords / $limit); // Calculate total pages
$pageProducts = isset($_GET['pageProducts']) ? (int)$_GET['pageProducts'] : 1;
$start = ($pageProducts - 1) * $limit;

// Add LIMIT for pagination
$query .= " LIMIT $start, $limit";
$ProductsRecords = mysqli_query($conn, $query);

ob_end_flush();  // End output buffering and flush the output
?>


<style>
    .prod-img{
        height: 120px;
        width: 120px;
    }
    .content{
        margin-top: 80px;
    }
    .add-product{
        position: absolute;
        right: 20px;
        top: 100px;
        padding: 5px;
    }
    .add-prod-modal{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7); 
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        animation: fadeIn 0.3s ease-out;
    }
    .modal-prod-content{
        display: flex;
        flex-direction: column;
        position: relative;
        width: 600px;
        max-height: 600px;
        background-color: #fff;
        border-radius: 12px;
        border: none;
        overflow: hidden;
        transition: transform 0.3s ease-in-out;
        box-shadow: 20px 15px #5557;
        padding: 10px;
    }
    .close-btn{
        width: 80px;
        position: absolute;
        right: 10px;
        border: none;
        border-radius: 10px;
        background-color: crimson;
        color: white;
    }
    .close-btn:hover{
        background-color: rgb(241, 114, 139);
    }
    .form-modal{
        margin-top: 40px;
        height: 700px;
        display: flex;
    }
    .input-fields{
        display: flex;
        margin: 20px;
        justify-content: space-between;
        align-items: center;
    }
    .input-fields input, textarea{
        padding: 10px;
        width: 400px;
        border-radius: 5px;
    }
    .button-holder{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .form-btn{
        position: absolute;
        bottom: 20px;
    }
</style>
<button class="add-product" onclick="OpenModal()">+ Add Product</button>
<div class="content">
<div class="search-bar">
    <form method="GET" action="">
        <input type="text" name="search" class="form-control" placeholder="Search by Product Name or Description" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
</div>

        <!-- Content Sections -->
        <div id="Orders" class="table-container">
            <h2>Products</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    while($row = mysqli_fetch_assoc($ProductsRecords)){
                        $ID = $row['id']; ?>
                     <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><img class="prod-img" src="../<?php echo htmlspecialchars($row['prod_img']); ?>" alt=""></td>
                        <td><?php echo htmlspecialchars($row['prod_title']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                        <td><?php echo htmlspecialchars($row['size']); ?></td>
                        <td><?php echo htmlspecialchars($row['qty']); ?></td>
                        <td > <button class="btn btn-edit btn-success" type="button" onclick="openEditModal(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['prod_title']); ?>','<?php echo htmlspecialchars($row['description']); ?>', <?php echo htmlspecialchars($row['price']); ?>, <?php echo htmlspecialchars($row['qty']); ?>, '<?php echo htmlspecialchars($row['size']); ?>', '<?php echo htmlspecialchars($row['prod_img']); ?>')">Edit</button>
                        <?php echo "<a href=\"functions.php?ProductsDeleteID=$ID\"><button class=\"btn btn-danger\">Delete</button></a>"?>
                        </td>
                   </tr>
                   <?php } ?>
                </tbody>
            </table>
              <!-- Pagination Links -->
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php if($pageProducts > 1): ?>
                        <li class="page-item"><a class="page-link" href="?pageProducts=<?php echo $pageProducts-1; ?>">Previous</a></li>
                    <?php endif; ?>
                    
                    <?php for($i = 1; $i <= $totalPagesProducts; $i++): ?>
                        <li class="page-item <?php if($i == $pageProducts) echo 'active'; ?>">
                            <a class="page-link" href="?pageProducts=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    
                    <?php if($pageProducts < $totalPagesProducts): ?>
                        <li class="page-item"><a class="page-link" href="?pageProducts=<?php echo $pageProducts+1; ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>

        <div id="modal" class="add-prod-modal" style="display: none;" >
            <div class="modal-prod-content">
                <h3>Add Products</h3>
                <button class="close-btn" onclick="closeModal()">X</button>
                <div class="form-modal">
                <form class="upload-form" action="upload.php" method="POST" enctype="multipart/form-data">
                <div class="input-fields">
                    <label for="">Product Name: </label>
                    <input type="text" name="prodname">
                </div>
                <div class="input-fields">
                    <label for="">Size: </label>
                    <input type="text" name="Psize">
                </div>
                <div class="input-fields">
                    <label for="">Price: </label>
                    <input type="text" name="proprice">
                </div>
                <div class="input-fields">
                    <label for="">Qty: </label>
                    <input type="number" name="proQty">
                </div>
                <div class="input-fields">
                    <label for="">Description: </label>
                    <textarea name="desc"></textarea>
                </div>
                <div class="input-fields">
                    <label for="upload">Upload Image: </label>
                    <input type="file" name="images[]" accept="image/*" multiple required>
                </div>
                <div class="button-holder">
                    <button class="form-btn" type="submit" name="upload">Submit</button>
                </div>
                </form>
                </div>
            </div>
        </div>

        <div id="editModal" class="add-prod-modal" style="display: none;" >
            <div class="modal-prod-content">
                <h3>Add Products</h3>
                <button class="close-btn" onclick="closeEditModal()">X</button>
                <div class="form-modal">
                <form class="upload-form" action="update_product.php" method="POST" enctype="multipart/form-data">
                <div class="input-fields">
                    <input type="hidden" id="prodId" name="prodId">
                    <label for="">Product Name: </label>
                    <input type="text" name="prodName" id="prodName">
                </div>
                <div class="input-fields">
                    <label for="">Size: </label>
                    <input type="number" name="prodSize" id="prodSize">
                </div>
                <div class="input-fields">
                    <label for="">Price: </label>
                    <input type="text" name="prodPrice" id="prodPrice">
                </div>
                <div class="input-fields">
                    <label for="">Size: </label>
                    <input type="text" name="prodQty" id="prodQty">
                </div>
                <div class="input-fields">
                    <label for="">Description: </label>
                    <textarea name="prodDesc" id="prodDesc"></textarea >
                </div>
                <div class="input-fields">
                    <label for="upload">Upload Image: </label>
                    <input type="file" name="images[]" id="prodImg" accept="image/*">
                </div>
                <div class="button-holder">
                    <button class="form-btn" type="submit" name="upload">Submit</button>
                </div>
                </form>
                </div>
            </div>
        </div>


        <script>
            const modal = document.getElementById("modal");

            function OpenModal() {
                modal.style.display = "flex";
            }
            function closeModal() {
                modal.style.display = "none";
            }
              // Open the Edit Admin Modal and populate it with admin data
            function openEditModal(prodId, prodName, prodDesc, prodPrice, prodSize, prodQty, prodImg) {
                document.getElementById('prodId').value = prodId;
                document.getElementById('prodName').value = prodName;
                document.getElementById('prodDesc').value = prodDesc;
                document.getElementById('prodPrice').value = prodPrice;
                document.getElementById('prodSize').value = prodSize;
                document.getElementById('prodQty').value = prodQty;
                document.getElementById('prodImg').value = ''; 
                document.getElementById('editModal').style.display = 'flex';

            }
              // Open the Edit Admin Modal and populate it with admin data
              function closeEditModal() {
                document.getElementById('editModal').style.display = 'none';
            }
        </script>