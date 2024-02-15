<?php

if (isset($_GET['sellerID'])) {
    // Prepare statement and execute, prevents SQL injection
    $stmt = $conn->prepare('SELECT * FROM products p JOIN sellers s 
    ON p.sellerID = s.sellerID WHERE p.sellerID = ?');
    $stmt->bind_param('i', $_GET['sellerID']); // Bind the parameter to prevent SQL injection
    $stmt->execute();

    $result = $stmt->get_result();
    $products = $result->fetch_all(MYSQLI_ASSOC);
    $total_products = $result->num_rows;

    $conn->close();
    if (!empty($products) || empty($products)) {
        $shopName = $products[0]['shopName'];
    }
} else {
    // Simple error to display if the product ID wasn't specified
    exit('Product does not exist!');
}
?>
<?= template_header('Shop Products') ?>

<div class="products content-wrapper">
    <h1>Product List For <?php echo $shopName; ?></h1>
    <br>
    <p><?= $total_products ?> available Products for <?php echo $_SESSION['customerName']; ?>.</p>
    <div class="products-wrapper">
        <?php foreach ($products as $product) : ?>
            <a href="index.php?page=../Products/product&productID=<?= $product['productID'] ?>" class="product">
                <img src="../pic/Products/<?= $product['productImg'] ?>" width="200" height="200" alt="<?= $product['productName'] ?>">
                <span class="name"><?= $product['productName'] ?></span>
                <span class="price">MYR<?= $product['productPrice'] ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<?= template_footer() ?>