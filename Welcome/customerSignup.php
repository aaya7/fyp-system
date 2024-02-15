<?php
require 'dbconn.php';
if (isset($_POST['custRegister'])) {

    $customerID = $_POST['customerID'];
    $customerName = $_POST['customerName'];
    $customerPnum = $_POST['customerPnum'];
    $customerEmail = $_POST['customerEmail'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    $sql1 = "SELECT * FROM `customers` WHERE  customerID='$customerID'";
    $result = mysqli_query($conn, $sql1) or die(mysqli_connect_error());

    $sql2 = "SELECT * FROM `customers` WHERE  customerEmail='$customerEmail'";
    $result2 = mysqli_query($conn, $sql2) or die(mysqli_connect_error());

    $custEmail = mysqli_num_rows($result2);
    $custID = mysqli_num_rows($result);

    if (($custID == 0) && ($password1 == $password2) && ($custEmail == 0)) {
        $insert = "INSERT INTO `customers`(`customerID`, `customerName`, `customerPnum`, `customerEmail`, `password`) 
        VALUES ('$customerID','$customerName','$customerPnum','$customerEmail','$password1')";
        $insertResult = mysqli_query($conn, $insert) or die(mysqli_connect_error());
        if ($insertResult) {
            echo ("<script>alert('You have been registered in Successfully! Please Login to continue browsing.')</script>");
            echo ("<script>window.location = 'customerLogin.php';</script>");
        } else if ($password1 != $password2) {
            echo ("<script>alert('Passwords not match. Please enter the same password!')</script>");
            echo ("<script>window.location = 'customerSignup.php';</script>");
        }
    } else if ($custID > 0) {
        echo ("<script>alert('Student ID or Staff ID already registered.')</script>");
        echo ("<script>window.location = 'customerSignup.php';</script>");
    } else if ($custEmail > 0) {
        echo ("<script>alert('This email already registered.')</script>");
        echo ("<script>window.location = 'customerSignup.php';</script>");
    } else {
        echo ("<script>alert('Register Failed!')</script>");
        echo ("<script>window.location = 'customerSignup.php';</script>");
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Online Commerce Platform</title>
    <link href="authorize.css" rel="stylesheet">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
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
        <div class="title">Customer Registration</div><br>
        <div class="content">
            <form method="POST" action="" name="register">
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
                        <span class="details">Email</span>
                        <input type="email" name="customerEmail" placeholder="Enter your active Email:" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Phone Number</span>
                        <input type="text" name="customerPnum" placeholder="01x-xxxxxxx" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Password</span>
                        <input type="password" name="password1" placeholder="Enter Password:" required />
                    </div>
                    <div class="input-box">
                        <span class="details">Confirm Password</span>
                        <input type="password" name="password2" placeholder="Please confirm your password:" required>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" name="custRegister" value="Register"><br><br>
                    <a href="customerLogin.php">Already have an account? Login Here!</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>