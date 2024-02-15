<?php

use PHPMailer\PHPMailer\PHPMailer;
?>

<?= template_header('Order List') ?>
<?php

$sellerID = $_SESSION['sellerID'];

$stmt = $conn->prepare('SELECT oi.orderID, oi.orderItemID, oi.productID, oi.itemQuantity, oi.itemPrice, oi.codPickupDate, 
oi.deliverOption, o.order_date, o.customerID, c.customerAddress, o.totalPayment, o.paymentStatus, oi.statusStatement 
FROM orders o JOIN order_items oi 
ON o.orderID = oi.orderID JOIN products p 
ON oi.productID = p.productID JOIN customers c
ON o.customerID = c.customerID WHERE sellerID = ? ORDER BY oi.orderID; ');
$stmt->bind_param('i', $sellerID); // Bind the parameter to prevent SQL injection
$stmt->execute();
$result = $stmt->get_result(); // Get the result set from the statement
if ($result->num_rows == 0) {
    echo ('<br><br><h1>Order does not exist!</h1>');
} elseif ($result->num_rows > 0) {
?>
    <div class="cart content-wrapper">
        <h1>Order List</h1>

        <!-- Filter section with dropdown -->
        <div class="filter-section">
            <label for="status">Filter Based on Order Status:</label>
            <select id="status">
                <option value="">All</option>
                <option value="Order Submitted.">Order Submitted.</option>
                <option value="Order Is Being Prepared.">Order Is Being Prepared.</option>
                <option value="Order Is Ready.">Order Is Ready.</option>
                <option value="Order Is On The Way.">Order Is On The Way.</option>
                <option value="Order Completed.">Order Completed.</option>
            </select>

            <button onclick="filterStatusOrders()">Search</button>
        </div>

        <table style="font-size: 14px;">
            <thead>
                <tr>
                    <td>Order ID</td>
                    <td>Order Item ID</td>
                    <td>Product ID</td>
                    <td>Customer ID</td>
                    <td>Customer Address</td>
                    <td>Item Quantity</td>
                    <td>Item Price</td>
                    <td>COD/Pickup Date</td>
                    <td>Deliver Option</td>
                    <td>Order Date</td>
                    <td>Payment Status</td>
                    <td>Order Status</td>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each order and display details
                while ($orders = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?= $orders['orderID'] ?></td>
                        <td><?= $orders['orderItemID'] ?></td>
                        <td><?= $orders['productID'] ?></td>
                        <td><?= $orders['customerID'] ?></td>
                        <td><?= $orders['customerAddress'] ?></td>
                        <td style="text-align: center;"><?= $orders['itemQuantity'] ?></td>
                        <td>RM<?= $orders['itemPrice'] ?></td>
                        <td><?= $orders['codPickupDate'] ?>
                            <?php if ($orders['codPickupDate'] == Null) : ?>
                                <i class="fa-solid fa-pen" onclick="editCodPickupDate(<?= $orders['orderItemID'] ?>)"></i>
                            <?php endif; ?>

                            <form style="display: none;" action="" id="updateDate<?= $orders['orderItemID'] ?>" class="updateDate" method="POST">
                                <input type="hidden" name="orderItemID" value="<?= $orders['orderItemID'] ?>">
                                <label for="codPickupDate"><b>COD/Pickup Date:</b></label>
                                <input type="date" name="codPickupDate" required>
                                <button type="button" class="btn cancel" onclick="closeForm2(<?= $orders['orderItemID'] ?>)">Cancel</button>
                                <button type="submit" name="updateDate" class="btn" onclick="return confirm('Are you sure?');">Update</button>
                            </form>

                        </td>
                        <td><?= $orders['deliverOption'] ?></td>
                        <td><?= $orders['order_date'] ?></td>
                        <td><?= $orders['paymentStatus'] ?></td>
                        <td><?= $orders['statusStatement'] ?>
                            <form style="display: none;" action="" id="updateForm<?= $orders['orderItemID'] ?>" class="updateForm" method="POST">
                                <input type="hidden" name="orderItemID" value="<?= $orders['orderItemID'] ?>">
                                <select name="statusStatement">
                                    <option value="">Select Statement:</option>
                                    <option value="Order Submitted.">Order Submitted.</option>
                                    <option value="Order Is Being Prepared.">Order Is Being Prepared.</option>
                                    <option value="Order Is Ready.">Order Is Ready.</option>
                                    <option value="Order Is On The Way.">Order Is On The Way.</option>
                                    <option value="Order Completed.">Order Completed.</option>
                                </select><br>
                                <button type="button" class="btn cancel" onclick="closeForm(<?= $orders['orderItemID'] ?>)">Cancel</button>
                                <button type="submit" name="updateStatus" class="btn" onclick="return confirm('Are you sure?');">Update</button>
                            </form>
                        </td>
                        <td><?php if ($orders['statusStatement'] != 'Order Completed.') : ?>
                                <i class="fa-solid fa-pen" onclick="editOrderStatus(<?= $orders['orderItemID'] ?>)"></i>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
            <?php
        } else {
            // Display a message if there are no orders for the customer
            '<tr>
                    <td colspan="5" style="text-align:center;">No order received.</td>
                </tr>';
        }
            ?>
            </tbody>
        </table>
        <?php
        if (isset($_POST['updateStatus'])) {
            $orderItemID = $_POST['orderItemID'];
            $statusStatement = $_POST['statusStatement'];

            $stmtUpdate = $conn->prepare('UPDATE order_items SET statusStatement = ? WHERE orderItemID = ?');
            $stmtUpdate->bind_param('si', $statusStatement, $orderItemID);

            if ($stmtUpdate->execute()) {
                echo ("<script>alert('Status Updated Successfully!')</script>");
                echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/ordersProfile&sellerID=$sellerID';</script>");
            } else {
                echo ("<script>alert('Error updating status!')</script>");
            }

            $stmtUpdate->close();
        }

        if (isset($_POST['updateDate'])) {
            $orderItemID = $_POST['orderItemID'];
            $codPickupDate = $_POST['codPickupDate'];

            $updateDate = $conn->prepare('UPDATE order_items SET codPickupDate = ? WHERE orderItemID = ?');
            $updateDate->bind_param('si', $codPickupDate, $orderItemID);

            if ($updateDate->execute()) {
                $stmt = $conn->prepare('SELECT c.customerEmail, c.customerName, oi.deliverOption, oi.orderItemID
                                        FROM customers c 
                                        JOIN orders o ON c.customerID = o.customerID 
                                        JOIN order_items oi ON o.orderID = oi.orderID 
                                        WHERE oi.orderItemID = ?');
                $stmt->bind_param('i', $orderItemID);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $customerEmail = $row["customerEmail"];
                    $customerName = $row["customerName"];
                    $deliverOption = $row["deliverOption"];
                    $orderItemID = $row["orderItemID"];

                    // Send email to the customer
                    $subject = "COD/Pickup Date Updated";
                    $message = "Dear $customerName,\n\n";
                    $message .= "The COD/Pickup date for your product in Order Item ID = $orderItemID has been updated. Please be informed that you may now receive your order via $deliverOption on $codPickupDate.\n";
                    $message .= "Thank you for shopping with us!";
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
                        echo "<script>alert('Date Updated Successfully!');</script>";
                        echo "<script>window.location = 'sellerIndex.php?page=../SellerDashboard/ordersProfile&sellerID=$sellerID';</script>";
                    } else {
                        echo "<script>alert('Error sending email: " . $mail->ErrorInfo . "');</script>";
                    }
                } else {
                    echo "<script>alert('Customer email not found.');</script>";
                }
            } else {
                echo "<script>alert('Error updating date!');</script>";
            }

            $updateDate->close();
        }
        ?>
    </div>
    <script>
        function filterStatusOrders() {
            var selectedStatus = document.getElementById('status').value;
            var rows = document.querySelectorAll('tbody tr');

            for (var i = 0; i < rows.length; i++) {
                var statusCell = rows[i].querySelector('td:nth-child(12)'); // Assuming the status is in the 9th column

                if (selectedStatus === '' || statusCell.innerText.trim() === selectedStatus) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }

        function editOrderStatus(orderItemID) {
            // Hide all forms before showing the selected one
            var forms = document.querySelectorAll('.updateForm');
            for (var i = 0; i < forms.length; i++) {
                forms[i].style.display = 'none';
            }

            document.getElementById("updateForm" + orderItemID).style.display = "block";
        }

        function editCodPickupDate(orderItemID) {
            // Hide all forms before showing the selected one
            var forms = document.querySelectorAll('.updateDate');
            for (var i = 0; i < forms.length; i++) {
                forms[i].style.display = 'none';
            }

            document.getElementById("updateDate" + orderItemID).style.display = "block";
        }

        function closeForm(orderItemID) {
            document.getElementById("updateForm" + orderItemID).style.display = "none";
        }

        function closeForm2(orderItemID) {
            document.getElementById("updateDate" + orderItemID).style.display = "none";
        }
    </script>

    <?= template_footer() ?>