<?php
session_start();
$currentPage = $_SERVER['REQUEST_URI']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            color: #333;
        }

        p {
            color: #555;
            line-height: 1.6;
        }
        .user-name{
            position: absolute;
            top: 25px;
            right: 80px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .Span-name{
            color: crimson;
        }
        @media (max-width: 1366px){
            .home-img{
                height: 300px;
                width: 300px;
            }
            .logo-title{
                font-size: 20px;
            }
            .sm{
                font-size: 25px;
            }
            .red_btn{
                padding: 10px;
                font-size: 19px;
            }
            footer{
                min-height: 200px;
            }
            @media(max-width: 1366px ){
                .modal-content{
                    left: 0;
                    height: 600px;
                    top: 0;
                    width: 600px;
                }
                .modal-right.switch{
                    transform: translateX(-175%)
                }
                input[type="email"],
                input[type="password"],
                input[type="text"]{
                    padding: 10px;
                }
                .modal-left.switch{
                    transform: translateX(63%)
                }
                .header{
                    height: 23vh;
                }
                .home{
                    height: 900px;
                }
            }

        }
    </style>
</head>
<body>

<div class="header">
    <?php
        if (isset($_SESSION['username'])) {
            echo '<p class="user-name"> Welcome, <span class="Span-name">' . $_SESSION['username'] . '</span></p>';
        }
        ?>

        <div class="logo">
            <h2 class="logo-title">Patolot Barong <br>& Filipiniana Rental Reservation</h2>
        </div>
        <ul>
            <a href="index.php"><li>Home</li></a>      
            <a href="product.php"><li>Product</li></a>     
            <a href="about_us.php"><li>About Us</li></a>   
            <a href="contact_us.php"><li>Contact Us</li></a> 
            <?php if(!isset($_SESSION['user_id'])){
                ?>
                     <a href="#" class="btn btn-warning" onclick="openModal()" id="login-btn">Login</a>
                <?php
            }else{
                ?>
                    <a href="logout.php" class="btn btn-danger">Logout</a> 
                <?php  
            } ?>

            <a href="cart.php" class="cart-icon"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z"/>
                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
            </svg></a>
    </div>            
        </ul>
    </div>
</header>

<div class="content">
    <h2>Welcome to Our Company!</h2>
    <p>
        At Patolot barong, we believe in delivering quality products and services to our valued customers.
        We have been in the industry for [X] years, and our mission is to provide quality barong's that
        cater to the needs and preferences of individuals and businesses alike. Our goal is to ensure that you
        get the best value for your money while experiencing excellent customer service every step of the way.
    </p>

    <h3>Our Vision</h3>
    <p>
        Our vision is to become the leading provider of quality barong's by continuously innovating and
        improving to meet the growing demands of our customers. We aim to make a positive impact on the lives
        of those we serve.
    </p>

    <h3>Our Values</h3>
    <p>
        - Customer Satisfaction: We prioritize the needs of our customers above all else.<br>
        - Integrity: We maintain the highest level of honesty and transparency.<br>
        - Innovation: We are committed to staying ahead of the curve with new ideas and technologies.<br>
        - Excellence: We strive for excellence in everything we do.
    </p>
</div>

<footer>
    <div class="Soc-Links">
        <p>SOCIAL LINKS</p>
        <ul>
            <li><a href=""><svg xmlns="http://www.w3.org/2000/svg" height="25" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
            </svg> FaceBook</a></li>
            <li><a href=""><svg xmlns="http://www.w3.org/2000/svg" height="25" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
            <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
            </svg> Twitter</a></li>
            <li><a href=""><svg xmlns="http://www.w3.org/2000/svg" height="25" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
            </svg> Instagram</a></li>
        </ul>
    </div>
    <p>&copy; 2024 Patolot Barong & Filipiniana Rental and Reservation. All rights reserved.</p>
    <div class="contact">
        <p>CONTACTS</p>
        <ul>
            <li><svg xmlns="http://www.w3.org/2000/svg" height="25" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
            </svg> 09291234567</li>
            <li><a href="mailto:patolot@gmail.com"><svg xmlns="http://www.w3.org/2000/svg" height="25" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
            </svg> patolot@gmail.com</a></li>
        </ul>
    </div>
</footer>
</body>
</html>
