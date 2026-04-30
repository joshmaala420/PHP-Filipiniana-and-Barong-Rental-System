<?php
session_start();
include('connection.php');

$user_id = $_SESSION['user_id'];
$viewSql = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = $user_id");



?>
<style>
    *{
        padding: 0;
        margin: 0;
    }
.view-container{
    height: 100%;
    width: 100%;
    background-color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
}
.view-content{
    height: 95vh;
    width: 45vw;
    background-color: rgb(247, 238, 224);
    padding: 20px;
    border-radius: 10px;
    overflow: scroll;
    overflow-x: hidden;
}
.order-details{
    height: 25vh;
    width: 100%;
    background: rgb(245, 227, 195);
    border: 1px solid orange;
    margin-top: 40px;
    border-radius: 10px;
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
}
.order-Title{
    text-align: center;
    font-size: 30px;
    padding: 10px;
    margin-bottom: 10px;
}
p{
    font-size: 22px;
    font-weight: 600;
    margin: 10px;
}
span{
    color:  crimson;
}
.image-container{
    height: 100%;
    width: 200px;
    background-color: #333;
    border-radius: 10px 0 0 10px;
}
.image-container img{
    width: 100%;
    height: 100%;
    border-radius: 10px 0 0 10px;
}
.description p{
    margin: 10px;
}
.Pro-details{
    color: blue;
}
.back-button{
    position: absolute;
    width: 150px;
    padding: 10px;
    margin: 20px;
    border-radius: 10px;
    font-size: 20px;
    font-weight: 400;
    border: none;
}
.back-button:hover{
    background-color: crimson;
    color: white;
}
</style>

<a href="orders.php"><button class="back-button">Back</button></a>


<div class="view-container">
    <div class="view-content">
        <h3 class="order-Title">Order Details</h3>
        <hr>
       <?php
       $total_price = 0; 
       while($row = mysqli_fetch_assoc($viewSql)){ 
        $status = $row['status'];
        ?>
        <div class="order-details">
            <div class="image-container">
                <img src="<?php echo $row['product_image']; ?>" alt="">
            </div>
            <div class="description">
                <p>Product Name :  <span class="Pro-details"><?php echo $row['product_name']; ?></span></p>
                <p>Size :  <span class="Pro-details"><?php echo $row['size']; ?></span></p>
                <p>Price: <span class="Pro-details"><?php echo $row['total']; ?></span></p>
                <p>Quantity: <span class="Pro-details"><?php echo $row['qty']; ?></span></p>
                <p>Status: <span class="Pro-details"><?php if($status == 0){
                    echo '<span class="text-primary">payment is on process</span>';
                 }if($status == 1){
                    echo '<span class="text-success">Ready to pickup!</span>';
                    echo '<br>';
                    echo '<a href="map.php">View Location</a>';
                 } ?>
                 </p>
            </div>
        </div>
       <?php } ?>

    </div>
</div>