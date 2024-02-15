<?php

if (isset($_GET['productID'])) {
    // Prepare statement and execute, prevents SQL injection
    $stmt = $conn->prepare('SELECT * FROM products WHERE productID = ?');
    $stmt->bind_param('i', $_GET['productID']); // Bind the parameter to prevent SQL injection
    $stmt->execute();

    $result = $stmt->get_result(); // Get the result set from the statement
    $product = $result->fetch_assoc(); // Fetch the product details

    // Check if the product exists (array is not empty)
    if (!$product) {
        // Simple error to display if the product doesn't exist (array is empty)
        exit('Product does not exist!');
    }

    if ($product['productQuantity'] == 0) {
        // Update product status to "Unavailable"
        $updateStmt = $conn->prepare('UPDATE products SET productStatus = "Unavailable" WHERE productID = ?');
        $updateStmt->bind_param('i', $_GET['productID']);
        $updateStmt->execute();
        $updateStmt->close();
    }
    else{
        $updateStmt = $conn->prepare('UPDATE products SET productStatus = "Available" WHERE productID = ?');
        $updateStmt->bind_param('i', $_GET['productID']);
        $updateStmt->execute();
        $updateStmt->close();
    }
} else {
    // Simple error to display if the product ID wasn't specified
    exit('Product does not exist!');
}
?>
<?= template_header('Product') ?>
<div class="product content-wrapper">
    <br><br>
    <img src="../pic/Products/<?= $product['productImg']?>" width="500" height="500" alt="<?= $product['productName'] ?>">
    <div>
        <h1 class="name"><?= $product['productName'] ?></h1><br>
        <table>
            <thead>
                <tr>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Status</td>
                    <td>Manufactured Date</td>
                    <td>Expired Date</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>RM<?= $product['productPrice'] ?></td>
                    <td><?= $product['productQuantity'] ?></td>
                    <td><?= $product['productStatus'] ?></td>
                    <td><?= $product['product_mandate'] ?></td>
                    <td><?= $product['product_expdate'] ?></td>
                </tr>
            </tbody>
        </table>
        <form action="index.php?page=../Products/cart" method="POST">
            <label>Select Quantity:</label>
            <input type="number" name="productQuantity" value="1" min="1" max="<?= $product['productQuantity'] ?>" placeholder="Quantity" required>
            <input type="hidden" name="productID" value="<?= $product['productID'] ?>">
            <?php if ($product['productQuantity'] > 0 ) : ?>
                <input type="submit" name="addtoCart" value="Add To Cart">
            <?php else : ?>
                <button type="button" disabled>Add To Cart</button>
            <?php endif; ?>
        </form>
        <div class="description">
            <?= $product['productDesc'] ?>
        </div>
    </div>
</div>

<?= template_footer() ?>