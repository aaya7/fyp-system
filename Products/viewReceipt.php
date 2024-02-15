<?= template_header('Receipt') ?>

<div style="width: 80%; margin: auto; margin-top: 20px;">
    <?php
    if (isset($_GET['orderID'])) {
        // Prepare statement and execute, prevents SQL injection
        $stmt = $conn->prepare('SELECT o.orderID, o.order_date, o.orderQuantity, c.customerAddress, 
        o.totalPayment, o.paymentStatus FROM orders o JOIN customers c 
        ON o.customerID = c.customerID WHERE o.orderID = ?');
        $stmt->bind_param('i', $_GET['orderID']); // Bind the parameter to prevent SQL injection
        $stmt->execute();
        $result = $stmt->get_result();
    }

    $allOrdersCompleted = true; // Flag to track if all orders have statusStatement as "Order Completed."

    if ($result->num_rows > 0) {
    ?>
        <center>
        <h2>Thank you for choosing INFINITY! We truly appreciate your support and hope you enjoy your purchases. Looking forward to serving you again soon!</h2><br>
            <table style="width:50%; border-radius:20px 50px; border-collapse:collapse; background-color: rgba(216, 191, 216, 0.4); margin-bottom:20px;">
                <?php
                while ($orders = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td>
                            <img src="../pic/logoInfinity.png" width="150" height="40" class="image">
                        </td>
                        <td>
                            <strong><p>Here is Your Receipt for Order = <?= $orders['orderID'] ?></p></strong>
                        </td>
                    </tr>
                    <tr>
                        <td>Order ID</td>
                        <td>
                            <?= $orders['orderID'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Order Date</td>
                        <td><?= $orders['order_date'] ?>

                        </td>
                    </tr>
                    <tr>
                        <td>Order Quantity</td>
                        <td>
                            <?= $orders['orderQuantity'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Delivery Address</td>
                        <td>
                            <?= $orders['customerAddress'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Total Payment (RM)</td>
                        <td>
                            RM<?= $orders['totalPayment'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Payment Status</td>
                        <td>
                            <?= $orders['paymentStatus'] ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
            <?php
        } else {
            // Display a message if there are no orders for the customer
            '<tr>
                    <td colspan="5" style="text-align:center;">You have no order placed.</td>
                </tr>';
        }
            ?>
            </table>
        </center>
</div>
<?= template_footer() ?>