<?php
use PHPMailer\PHPMailer\PHPMailer;
?>
<?php

if (isset($_POST['productID'], $_POST['productQuantity']) && is_numeric($_POST['productID']) && is_numeric($_POST['productQuantity'])) {
    $productID = (int) $_POST['productID'];
    $productQuantity = (int) $_POST['productQuantity'];

    $stmt = $conn->prepare('SELECT * FROM products WHERE productID = ?');
    $stmt->bind_param('i', $productID);
    $stmt->execute();

    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product && $productQuantity > 0) {
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($productID, $_SESSION['cart'])) {
                
                $_SESSION['cart'][$productID] += $productQuantity;
                echo ("<script>alert('Product Exist in the Cart! Quantity has been Updated')</script>");
            } else {

                $_SESSION['cart'][$productID] = $productQuantity;
                echo ("<script>alert('Successfully added product to your cart!')</script>");
            }
        } else {

            $_SESSION['cart'] = array($productID => $productQuantity);
            echo ("<script>alert('Successfully added product to your cart!')</script>");
        }
    } else {

        echo ("<script>alert('ERROR TO ADD TO CART!')</script>");
    }
}
// Remove product from cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    // Remove the product from the shopping cart
    unset($_SESSION['cart'][$_GET['remove']]);
    echo ("<script>alert('Removed Product Successfully!')</script>");
}
// Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Loop through the post data so we can update the quantities for every product in cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'productQuantity') !== false && is_numeric($v)) {
            $id = str_replace('productQuantity-', '', $k);
            $quantity = (int) $v;
            // Always do checks and validation
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                // Update new quantity
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    // Prevent form resubmission...
    header('location: index.php?page=../Products/cart');
    exit;
}

$num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
$orderQuantity = 0;

if ($products_in_cart) {

    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $conn->prepare('SELECT * FROM products WHERE productID IN (' . $array_to_question_marks . ')');

    $stmt->bind_param(str_repeat('i', count($products_in_cart)), ...array_keys($products_in_cart));
    $stmt->execute();

    $result = $stmt->get_result();
    $products = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($products as $product) {
        $productPrice = (float) $product['productPrice'];
        $itemQuantity = (int) $products_in_cart[$product['productID']];
        $subtotal += $productPrice * $itemQuantity;
        $orderQuantity += $products_in_cart[$product['productID']];
    }
}

if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

    $totalPayment = $subtotal;
    $order_date;
    $customerID = $_SESSION['customerID'];
    $deliverOption = $_POST['deliverOption'];

    $statusStatement = "Order Submitted.";

    $insertOrder = "INSERT INTO `orders`(`order_date`, `orderQuantity`, `totalPayment`, `customerID`) 
    VALUES (NOW(),'$orderQuantity','$totalPayment','$customerID')";
    $insertOrderResult = mysqli_query($conn, $insertOrder) or die(mysqli_error($conn));

    if ($insertOrderResult) {

        $orderID = mysqli_insert_id($conn);
        foreach ($products as $product) {
            $productID = $product['productID'];
            $itemQuantity = $products_in_cart[$product['productID']];
            $itemPrice = $product['productPrice'] * $itemQuantity;

            $insertOrderItem = "INSERT INTO `order_items`(`orderID`, `productID`, `itemQuantity`, `itemPrice`,`statusStatement`, `deliverOption`) 
        VALUES ('$orderID','$productID','$itemQuantity','$itemPrice','$statusStatement', '$deliverOption')";

            $insertOrderItemResult = mysqli_query($conn, $insertOrderItem) or die(mysqli_error($conn));
        }
        if ($insertOrderItemResult) {

            $customerID = $_SESSION['customerID'];
            $sql = "SELECT customerEmail, customerName FROM customers WHERE customerID = $customerID ";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $customerEmail = $row["customerEmail"];
                $customerName = $row["customerName"];

                if (!empty($customerEmail)) {
                    $_SESSION['cart'] = array();

                    // Send email to the customer
                    $subject = "Order Confirmation";
                    $message = "Dear $customerName,\n\n";
                    $message .= "Your order has been successfully placed. Thank you for shopping with us!\n";
                    $message .= "Order ID: $orderID\n"; // Include relevant order details
                    $message .= "Total Payment: RM$totalPayment\n"; // Include relevant order details
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
                        echo ("<script>alert('Congratulations, your order has been submitted Successfully!')</script>");
                    } else {
                        echo "Error sending email: " . $mail->ErrorInfo;
                    }
                } else {
                    echo "Customer email not found.";
                }
            } else {
                echo "0 results";
            }

            // echo ("<script>alert('Congratulations, your order has been submitted Successfully!')</script>");
            echo ("<script>window.location = 'index.php?page=../Products/placeOrder&customerID=$customerID';</script>");

            foreach ($products as $product) {
                $productID = $product['productID'];
                $itemQuantity = $products_in_cart[$product['productID']];

                // Calculate the new product quantity after the order
                $newQuantity = $product['productQuantity'] - $itemQuantity;

                // Update the product quantity in the database
                $updateProductQuantity = "UPDATE `products` SET `productQuantity` = '$newQuantity' WHERE `productID` = '$productID'";
                $updateProductResult = mysqli_query($conn, $updateProductQuantity);

                if (!$updateProductResult) {
                    echo ("<script>alert('ERROR UPDATING PRODUCT QUANTITY, PLEASE TRY AGAIN!')</script>");
                    exit; // Exit if there's an error updating product quantity
                }
                $newProductSold = $product['productSold'] + $itemQuantity;

                // Update the productSold quantity in the database
                $updateProductSold = "UPDATE `products` SET `productSold` = '$newProductSold' WHERE `productID` = '$productID'";
                $updateProductSoldResult = mysqli_query($conn, $updateProductSold);

                if (!$updateProductSoldResult) {
                    echo ("<script>alert('ERROR UPDATING PRODUCT SOLD QUANTITY, PLEASE TRY AGAIN!')</script>");
                    exit; // Exit if there's an error updating productSold quantity
                }
            }
        } else {
            echo ("<script>alert('ERROR TO PLACE ORDER, PLEASE TRY AGAIN!')</script>");
        }
    } else {
        echo ("<script>alert('ERROR TO PLACE ORDER, PLEASE TRY AGAIN!')</script>");
    }
    exit;
}
?>

<?= template_header('Cart') ?>

<div class="cart content-wrapper">
    <h1>Shopping Cart</h1>
    <form action="index.php?page=../Products/cart" method="post">
        <table>
            <thead>
                <tr>
                    <td colspan="2">Product</td>
                    <td>Product Price</td>
                    <td>Product Quantity</td>
                    <td>Total Price of Product Quantity (MYR)</td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)) : ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($products as $product) : ?>
                        <tr>
                            <td class="img">
                                <a href="index.php?page=../Products/product&productID=<?= $product['productID'] ?>">
                                    <img src="../pic/Products/<?= $product['productImg'] ?>" width="50" height="50" alt="<?= $product['productName'] ?>">
                                </a>
                            </td>
                            <td>
                                <a href="index.php?page=../Products/product&productID=<?= $product['productID'] ?>">
                                    <?= $product['productName'] ?>
                                </a>
                                <br>
                                <a href="index.php?page=../Products/cart&remove=<?= $product['productID'] ?>" onclick="return confirm('Are you sure?');" class="remove">Remove</a>
                            </td>
                            <td class="price">[1 Unit] = MYR
                                <?= $product['productPrice'] ?>
                            </td>
                            <td class="quantity">
                                <input type="number" name="productQuantity-<?= $product['productID'] ?>" value="<?= $products_in_cart[$product['productID']] ?>" min="1" max="<?= $product['productQuantity'] ?>" placeholder="Quantity" required>
                            </td>
                            <td class="price">MYR
                                <?= $product['productPrice'] * $products_in_cart[$product['productID']] ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Delivery Option:</span>
            <select name="deliverOption" required oninvalid="this.setCustomValidity('Please select a delivery option.')" oninput="setCustomValidity('')">
                <option value="">Select Delivery Option:</option>
                <option value="COD">COD</option>
                <option value="Pickup">Pickup</option>
            </select><br><br>
            <span class="text">Total Product Quantity in Cart:</span>
            <span class="price">
                <?= $orderQuantity ?>
            </span><br><br>
            <span class="text">Subtotal:</span>
            <span class="price">MYR
                <?= $subtotal ?>
            </span>
        </div>
        <div class="buttons">
            <input type="submit" onclick="return confirm('Update Quantity?');" value="Update" name="update">
            <input type="submit" onclick="return confirm('Place Order?');" value="Place Order" name="placeorder">
        </div>
    </form>
</div>

<?= template_footer() ?>