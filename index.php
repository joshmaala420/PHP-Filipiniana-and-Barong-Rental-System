<?php
session_start();
$currentPage = $_SERVER['REQUEST_URI']; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Patolot Barong and Filipiniana Rental and Reservation</title>
    <style>
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
        @media (min-width: 600px){
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
            @media(min-width: 900px ){
                .modal-content{
                    left: 0;
                    height: 550px;
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
                    height: 2rem;
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
<header>
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

<div class="Home">
    <div class="main_slide">
        <div>
            <h1 class="sm">Patolot <span>Barong and Filipiniana</span> Rental and Reservation</h1>
            <p> Style on Demand : Rent, Reserve, Repeat</p>
            <button class="red_btn">Visit Now <i class="fa-solid fa-arrow-right-long"></i></button>
        </div>
        <div>
            <img src="img/Home.png" class="home-img" alt="">
        </div>
    </div>
</div>

<!-- Modal Structure -->
<div id="modal" class="modal" style="display: none;">
    <div class="modal-content">
    <span class="close" id="close-modal">&times;</span>
        <!-- Left Section: Forms -->
        <div class="modal-left">
            <div id="form-container">
                <!-- Login Form -->
                <div id="login-form">
                    <h2>Login</h2>
                    <form action="login.php" method="POST">
                        <input type="hidden" name="redirect_url" value="<?php echo htmlspecialchars($currentPage); ?>">
                        <label for="login-email">Email:</label>
                        <input type="email" name="email" id="login-email" placeholder="Enter your email" required>
                        <label for="login-password">Password:</label>
                        <input type="password" name="password" id="login-password" placeholder="Enter your password" required>
                        <button type="submit" class="btn btn-primary" name="login-btn">Login</button>
                    </form>
                </div>
              <!-- Admin Login Form -->
                <div id="admin-login-form" style="display: none;">
                    <h2>Register</h2>
                    <form method="POST" action="registration.php">
                        <label for="register-name">Full Name:</label>
                        <input type="text" name="full_name" id="register-name" placeholder="Enter your full name" required>
                        <label for="register-email">Email:</label>
                        <input type="email"  name="email" id="register-email" placeholder="Enter your email" required>
                        <label for="register-phone">Phone:</label>
                        <input type="text"  name="phone" id="register-phone" placeholder="Enter your Phone number" required>
                        <label for="register-password">Password:</label>
                        <input type="password"  name="password" id="register-password" placeholder="Enter your password" required>
                        <label for="register-confirm-password">Confirm Password:</label>
                        <input type="password"  name="password_2" id="register-confirm-password" placeholder="Confirm your password" required>
                        <button type="submit" class="btn btn-primary" name="reg_btn">Sign Up</button>
                    </form>
                </div>
                <!-- Sign Up Form -->
                <div id="register-form" style="display: none;">
                    <h2>Sign Up</h2>
                    <form method="POST" action="registration.php">
                        <label for="register-name">Full Name:</label>
                        <input type="text" name="full_name" id="register-name" placeholder="Enter your full name" required>
                        <label for="register-email">Email:</label>
                        <input type="email"  name="email" id="register-email" placeholder="Enter your email" required>
                        <label for="register-phone">Phone:</label>
                        <input type="text"  name="phone" id="register-phone" placeholder="Enter your Phone number" required>
                        <label for="register-password">Password:</label>
                        <input type="password"  name="password" id="register-password" placeholder="Enter your password" required>
                        <label for="register-confirm-password">Confirm Password:</label>
                        <input type="password"  name="password_2" id="register-confirm-password" placeholder="Confirm your password" required>
                        <button type="submit" class="btn btn-primary" name="reg_btn">Sign Up</button>
                        <p>Already have an account? <a href="#" id="to-login" class="text-primary">Login here</a></p>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Right Section: Switch Button and Arrow -->
        <div class="modal-right">
            <svg xmlns="http://www.w3.org/2000/svg" height="100" fill="currentColor" class="bi bi-arrow-left-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5m14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5"/>
            </svg>
            <button class="switch-btn" id="switch-btn">Register</button>
        </div>
    </div>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0+ymcddK1+u8db4XzY9rBctzzklhBr0v6KzKhZAp4wb5gwe0" crossorigin="anonymous"></script>
<script>
const modal = document.getElementById("modal");
const closeModal = document.getElementById("close-modal");
const toLogin = document.getElementById("to-login");
const loginForm = document.getElementById("login-form");
const registerForm = document.getElementById("register-form");
const adminLoginForm = document.getElementById("admin-login-form");
const switchBtn = document.getElementById("switch-btn");
const modalLeft = document.querySelector(".modal-left");
const modalRight = document.querySelector(".modal-right");


// Open modal 
function openModal() {
    modal.style.display = "flex"; 
    loginForm.style.display = "block"; 
    registerForm.style.display = "none";
    adminLoginForm.style.display = "none"; 
}

// Close modal
closeModal.addEventListener("click", () => {
    modal.style.display = "none";
    modalLeft.classList.remove("switch");
    modalRight.classList.remove("switch");
});



// Switch to login form
toLogin.addEventListener("click", () => {
    registerForm.style.display = "none";
    loginForm.style.display = "block";
});

// Switch between login and admin login
switchBtn.addEventListener("click", () => {
    modalLeft.classList.toggle("switch");
    modalRight.classList.toggle("switch");
    if (modalLeft.classList.contains("switch")) {
        loginForm.style.display = "none";
        registerForm.style.display = "none";
        adminLoginForm.style.display = "block"; // Show Admin Login Form
        switchBtn.textContent = "Login"; // Change button text to user
    } else {
        adminLoginForm.style.display = "none";
        loginForm.style.display = "block"; 
        switchBtn.textContent = "Register"; // Change button text to admin
    }
});

</script>
</body>
</html>
