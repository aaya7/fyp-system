<?= template_header('Order History') ?>

<?php
$customerID = $_SESSION['customerID'];

$stmt = $conn->prepare('SELECT o.orderID, o.order_date, o.orderQuantity, c.customerAddress, 
o.totalPayment, o.paymentStatus FROM orders o JOIN customers c 
ON o.customerID = c.customerID WHERE o.customerID = ? ');
$stmt->bind_param('i', $_GET['customerID']);
$stmt->execute();
$result = $stmt->get_result(); 

if ($result->num_rows == 0) {
    echo ('<br><br><h1>Order is not placed yet!</h1>');
}

if ($result->num_rows > 0) {
?>
    <div class="cart content-wrapper">
        <h1>Order History</h1>
        <table>
            <thead>
                <tr>
                    <td>Order ID</td>
                    <td>Order Date</td>
                    <td>Order Quantity</td>
                    <td>Delivery Address</td>
                    <td>Total Payment (RM)</td>
                    <td>Payment Status</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($orders = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?= $orders['orderID'] ?></td>
                        <td><?= $orders['order_date'] ?></td>
                        <td><?= $orders['orderQuantity'] ?></td>
                        <td><?= $orders['customerAddress'] ?></td>
                        <td><?= $orders['totalPayment'] ?></td>
                        <td><?= $orders['paymentStatus'] ?></td>
                        <td>
                            <a href="index.php?page=../Products/viewOrder&orderID=<?= $orders['orderID'] ?>" title="View"><i class="fa-solid fa-eye" style="font-size: 20px; padding:5px;"></i></a>
                            <?php if ($orders['paymentStatus'] == 'Completed') : ?>
                                <a href="index.php?page=../Products/viewReceipt&orderID=<?= $orders['orderID'] ?>" title="Receipt"><i class="fa-solid fa-receipt" style="font-size: 20px; padding:5px;"></i></a>
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
                    <td colspan="5" style="text-align:center;">You have no order placed.</td>
                </tr>';
        }
            ?>
            </tbody>
        </table>
    </div>
    <?= template_footer() ?>