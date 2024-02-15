<?php

use PHPMailer\PHPMailer\PHPMailer;
// Database connection details
$username = "root";
$dbpass = "root";
$dbname = "fyproject";
$conn = new mysqli("localhost", $username, $dbpass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    // Check if email exists in the database
    $query = "SELECT customerID, customerName, password FROM customers WHERE customerEmail = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $password = $row["password"];
        $customerName = $row["customerName"];
        $customerID = $row["customerID"];

        // Include PHPMailer autoload.php file
        require 'vendor/autoload.php';

        // Create a PHPMailer instance
        $mail = new PHPMailer();

        // Set SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hidayahkai@gmail.com';
        $mail->Password = 'jqlazykoxerbzaey';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Send an email with the retrieved password
        $mail->setFrom('hidayahkai@gmail.com', 'Nur Hidayah');
        $mail->addAddress($email);
        $mail->Subject = "INFINITY: Password Retrieval";
        $mail->Body = "Dear $customerName,

        We hope this message finds you well. We have received your request for password retrieval and are pleased to assist you promptly.
        Your password has been securely retrieved, and we are providing it to you as requested. Please find your login credentials below:
        
        ID: $customerID
        Password: $password
        
        Please ensure to keep this information confidential to maintain the security of your account. For further assistance or inquiries, 
        please contact our developers at 017-4228947. Thank you for your attention to this matter.
        
        Best regards,
        Nur Hidayah
        

        Copyright © 2024 UiTM Tapah E-Commerce Platform: INFINITY. All rights reserved.";

        if ($mail->send()) {
            echo ("<script>alert('Password was emailed successfully, please check your email!')</script>");
            echo ("<script>window.location = 'customerLogin.php';</script>");
        } else {
            echo "Error sending email: " . $mail->ErrorInfo;
        }
    } else {
        echo "Email not found.";
    }
}

$conn->close();
