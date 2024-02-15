<?php
use PHPMailer\PHPMailer\PHPMailer;
$username = "root";
$dbpass = "root";
$dbname = "fyproject";
$conn = new mysqli("localhost", $username, $dbpass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Template header, feel free to customize this
function template_header($title)
{
    // Get the number of items in the shopping cart, which will be displayed in the header.
    $customerName =  $_SESSION['customerName']; 
    $customerID = $_SESSION['customerID'];
    $num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
    echo <<<EOT
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>$title</title>
            <link href="../css/styling1.css" rel="stylesheet">
            <meta content="width=device-width, initial-scale=1.0" name="viewport">
            <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
        </head>
        <body>
            <header>
                <div class="navbar">
                    <div class="logo">
                        <a href="javascript:history.back()"><i class="fas fa-arrow-left"></i></a>
                        <a>INFINITY<i class="fa-solid fa-infinity" style="background-color:#272c51 ; color:#e5c3a6;"></i>
                        </a>
                    </div>
                    <ul class="links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="index.php?page=../Dashboard/dashboard">Dashboard</a></li>
                        <li><a href="index.php?page=../Products/products">Products</a></li>
                        <li><a href="index.php?page=../Shops/shops">Shops</a></li>
                        <li><a href="index.php?page=../Events/events">Events</a></li>
                    </ul>
                    <ul class="links">
                        <div class="dropdown">
                            <button class="dropbtn"> $customerName <i class="fas fa-user"></i></button>
                            <div class="dropdown-content">
                           
                                <a href="index.php?page=../Profile/profile&customerID=$customerID">Profile</a>
                                <a href="index.php?page=../Products/placeOrder&customerID=$customerID">Order History</a>
                                <a href="logout.php" onclick="return confirm('Are you sure?');" >Logout</a>
                            </div>
                        </div> 
                        <a href="index.php?page=../Products/cart"><i class="fas fa-shopping-cart"></i>
                        <span class="badge-cart">$num_items_in_cart</span></a>
                    </ul>
                    <div class="toggle_btn">
                        <i class="fa-solid fa-bars"></i>
                    </div>
                </div>

                <div class="dropdown-nav">
                    <li><a href="#">Home</a></li>
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="index.php?page=products">Products</a></li>
                    <li><a href="#">Shops</a></li>
                    <li><a href="../navtest/events.html">Events</a></li>  
                    <li><a href="#" class="link_btn"><i class="fas fa-shopping-cart"></i></a></li>
                    <li><a href="#" class="link_btn"><i class="fas fa-user"></i></a></li>
                </div>
            </header>
            <script>
                const toggleBtn = document.querySelector('.toggle_btn')
                const toggleBtnIcon = document.querySelector('.toggle_btn i')
                const dropdownNav = document.querySelector('.dropdown-nav')

                toggleBtn.onclick =function (){
                    dropdownNav.classList.toggle('open')
                    const isOpen =dropdownNav.classList.contains('open')

                    toggleBtnIcon.classList = isOpen
                    ? 'fa-solid fa-xmark'
                    : 'fa-solid fa-bars'
                }
                dropdownNav.style.zIndex = '999';
            </script>
            <main>
    EOT;
}
// Template footer
function template_footer()
{
    $year = date('Y');
    echo <<<EOT
            </main>
            <footer>
                <div class="content-wrapper">
                    <div class="footer-contents">
                        <a href="index.php?page=../aboutus">About Us</a>
                        <a href="mailto:contact@example.com"><i class="far fa-envelope"></i> Email</a>
                        <p>&copy; $year, UiTM Tapah E-Commerce Platform: INFINITY</p>
                        <a href="https://www.instagram.com/example" target="_blank"><i class="fab fa-instagram"></i> Instagram</a>
                        <a href="https://twitter.com/example" target="_blank"><i class="fab fa-twitter"></i> Twitter</a>
                    </div>
                </div>
            </footer>
        </body>
    </html>
    EOT;
}
