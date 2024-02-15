<?php
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
    $sellerName =  $_SESSION['sellerName'];
    $sellerID = $_SESSION['sellerID'];
    echo <<<EOT
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>$title</title>
            <link href="../css/styling2.css" rel="stylesheet">
            <meta content="width=device-width, initial-scale=1.0" name="viewport">
            <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
        </head>
        <body>
            <header>
                <div class="navbar">
                    <div class="logo">
                        <a href="javascript:history.back()"><i class="fas fa-arrow-left" title="Back"></i></a>
                        <a>INFINITY<i class="fa-solid fa-infinity" style="background-color:#272c51 ; color:#e5c3a6;"></i>
                        </a>
                    </div>
                    <ul class="links">
                        <li><a href="sellerIndex.php">Dashboard</a></li>
                        <li><a href="sellerIndex.php?page=../SellerDashboard/productList&sellerID=$sellerID">Products</a></li>
                        <li><a href="sellerIndex.php?page=../SellerDashboard/eventList&sellerID=$sellerID">Events</a></li>
                        <li><a href="sellerIndex.php?page=../SellerDashboard/shopAccount&sellerID=$sellerID">Shop</a></li>
                        <li><a href="sellerIndex.php?page=../SellerDashboard/ordersProfile&sellerID=$sellerID">Orders</a></li>
                        <li><a href="sellerIndex.php?page=../SellerDashboard/salesPerformance&sellerID=$sellerID">Sales Performance</a></li>
                    </ul>
                    <ul class="links">
                        <div class="dropdown">
                            <button class="dropbtn"> $sellerName <i class="fas fa-user"></i></button>
                            <div class="dropdown-content">
                           
                                <a href="sellerIndex.php?page=../SellerDashboard/sellerProfile&sellerID=$sellerID">Profile</a>
                                <a href="sellerLogout.php" onclick="return confirm('Are you sure?');" >Logout</a>
                            </div>
                        </div> 
                    </ul>
                    <div class="toggle_btn">
                        <i class="fa-solid fa-bars"></i>
                    </div>
                </div>

                <div class="dropdown-nav">
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
                        <a href="sellerIndex.php?page=../aboutus">About Us</a>
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
