<?php
require 'dbconn.php';
session_start();
if (isset($_POST['custLogin'])) {

    $customerID = $_POST['customerID'];
    $password = $_POST['password'];
    $customerName = $_POST['customerName'];
    $sql = "SELECT * FROM `customers` WHERE  customerID='$customerID' AND password='$password'";
    $result = mysqli_query($conn, $sql) or die(mysqli_connect_error());
    $rows = mysqli_num_rows($result);
    if ($rows == 1) {
        $_SESSION['customerID'] = $customerID;
        $_SESSION['password'] = $password;
        $_SESSION['customerName'] = $customerName;
        // Redirect to user dashboard page
        echo ("<script>alert('You have been logged in Successfully!')</script>");
        echo ("<script>window.location = 'http://localhost/Projects/fyproject/Dashboard/index.php';</script>");
    } else {
        echo ("<script>alert('Invalid credentials! Please LOGIN again.')</script>");
        echo ("<script>window.location = 'customerLogin.php';</script>");
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Online Commerce Platform</title>
    <link href="authorize.css" rel="stylesheet" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>

<body>
    <header>
        <div class="header-contents">
            <a href="javascript:history.back()"><i class="fas fa-arrow-left"></i></a>
            <a href="#">INFINITY<i class="fa-solid fa-infinity"></i></a>
            <a href="mailto:contact@example.com"><i class="far fa-envelope"></i> Email</a>
            <p>&copy; 2023, UiTM Tapah E-Commerce Platform</p>
            <a href="https://www.instagram.com/example" target="_blank"><i class="fab fa-instagram"></i> Instagram</a>
            <a href="https://twitter.com/example" target="_blank"><i class="fab fa-twitter"></i> Twitter</a>
        </div>
    </header>
    <div class="container">
        <div class="title">Customer Login</div><br>
        <div class="content">
            <form method="POST" action="" name="login">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">Full Name</span>
                        <input type="text" name="customerName" placeholder="Enter your Fullname:" required />
                    </div>
                    <div class="input-box">
                        <span class="details">Student ID or Staff ID</span>
                        <input type="text" name="customerID" placeholder="Enter Student/Staff ID:" required />
                    </div>
                    <div class="input-box">
                        <span class="details">Password</span>
                        <input type="password" name="password" placeholder="Enter Password:" required />
                    </div>
                </div>
                <div class="button">
                    <input type="submit" name="custLogin" value="Login" /><br><br>
                    <a href="customerSignup.php">Don't have an account? Register Here!</a>
                </div>
            </form><br>
            <a style="color: purple; text-decoration:underline;" onclick=openForm()>Forgot Password?</a><br>
            <form action="retrieve_password.php" method="post" id="forgotPass" style="display: none;">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>
                <button type="submit">Submit</button>
                <button type="submit" onclick=closeForm()>Cancel</button>
            </form>
        </div>
    </div>
    <script>
        function openForm() {
            document.getElementById("forgotPass").style.display = "block";
        }

        function closeForm() {
            document.getElementById("forgotPass").style.display = "none";
        }
    </script>
</body>

</html>