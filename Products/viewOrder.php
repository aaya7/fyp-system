<?php

use PHPMailer\PHPMailer\PHPMailer;
?>
<?= template_header('Order History') ?>
<?php

if (isset($_GET['orderID'])) {
    // Prepare statement and execute, prevents SQL injection
    $stmt = $conn->prepare('SELECT * FROM order_items oi JOIN products p on oi.productID = p.productID JOIN orders o on oi.orderID = o.orderID WHERE oi.orderID = ?');
    $stmt->bind_param('i', $_GET['orderID']); // Bind the parameter to prevent SQL injection
    $stmt->execute();
    $result = $stmt->get_result();
}

$allOrdersCompleted = true; // Flag to track if all orders have statusStatement as "Order Completed."

if ($result->num_rows > 0) {
?>
    <div class="cart content-wrapper">
        <h1>Order Item List</h1>
        <table>
            <thead>
                <tr style="text-align: center;">
                    <td style=" width:150px">Order Item ID</td>
                    <td>Order ID</td>
                    <td>Product ID</td>
                    <td>Product Name</td>
                    <td>Item Quantity</td>
                    <td>Item Price</td>
                    <td>COD/Pickup Date</td>
                    <td>Deliver Option</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each order and display details
                while ($orders = $result->fetch_assoc()) {
                ?>
                    <tr style="text-align: center; width:150px">
                        <td><?= $orders['orderItemID'] ?></td>
                        <td><?= $orders['orderID'] ?></td>
                        <td><?= $orders['productID'] ?></td>
                        <td><?= $orders['productName'] ?></td>
                        <td><?= $orders['itemQuantity'] ?></td>
                        <td><?= $orders['itemPrice'] ?></td>
                        <td><?= $orders['codPickupDate'] ?></td>
                        <td><?= $orders['deliverOption'] ?></td>
                        <td><?= $orders['statusStatement'] ?></td>
                    </tr>
                <?php
                    // Check if the order status is not "Order Completed.", if so, set the flag to false
                    if ($orders['statusStatement'] !== "Order Completed.") {
                        $allOrdersCompleted = false;
                    }
                }
                // If all orders have statusStatement as "Order Completed.", update paymentStatus to "Completed"
                if ($allOrdersCompleted) {
                    $updateStmt = $conn->prepare('UPDATE orders SET paymentStatus = "Completed" WHERE orderID = ?');
                    $updateStmt->bind_param('i', $_GET['orderID']);
                    
                    if ($updateStmt->execute()) {
                        // Fetch customer email from the database
                        $customerID = $_SESSION['customerID'];
                        $sql = "SELECT customerEmail, customerName FROM customers WHERE customerID = $customerID ";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Fetch customer email
                            $row = $result->fetch_assoc();
                            $customerEmail = $row["customerEmail"];
                            $customerName = $row["customerName"];

                            // Send email to the customer
                            $subject = "Payment and Order Completion Confirmation";
                            $message = "Dear $customerName,\n\n";
                            $message .= "Your payment and order have been successfully completed. Thank you for shopping with us!\n";
                            $message .= "Order ID: " . $_GET['orderID'] . "\n"; // Include relevant order details
                            $message .= "\n\nBest regards,\nINFINITY";
                            $message .= "\n\nCopyright © 2024 UiTM Tapah E-Commerce Platform: INFINITY. All rights reserved.";


                            // Include PHPMailer autoload.php file
                            require '../vendor/autoload.php';

                            // Create a PHPMailer instance
                            $mail = new PHPMailer();

                            // Set SMTP configuration
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'hidayahkai@gmail.com'; // Update with your email address
                            $mail->Password = 'jqlazykoxerbzaey'; // Update with your email password
                            $mail->SMTPSecure = 'tls';
                            $mail->Port = 587;

                            // Send email
                            $mail->setFrom('hidayahkai@gmail.com', 'INFINITY'); // Update with your email address and name
                            $mail->addAddress($customerEmail); // Add customer's email address
                            $mail->Subject = $subject;
                            $mail->Body = $message;

                            if ($mail->send()) {
                            } else {
                                echo "Error sending email: " . $mail->ErrorInfo;
                            }
                        } else {
                            echo "Customer email not found.";
                        }
                    }
                }
                ?>
            <?php
        } else {
            // Display a message if there are no orders for the customer
            echo '<tr>
                    <td colspan="5" style="text-align:center;">You have no order placed.</td>
                </tr>';
        }
            ?>
            </tbody>
        </table>
    </div>
    <?= template_footer() ?>