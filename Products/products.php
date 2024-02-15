<?php
$query = "SELECT * FROM products";
$stmt = $conn->prepare($query);
$stmt->execute();

$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
$total_products = $result->num_rows;

$conn->close();
?>

<?= template_header('Products') ?>

<div class="products content-wrapper">
    <h1>Product List</h1>
    <div class="popup" onclick="popup()">Read Me
        <span class="popuptext" id="myPopup">Browse your desired products and add products to cart first if you are interested to purchase.</span>
    </div>

    <script>
        function popup() {
            var popup = document.getElementById("myPopup");
            popup.classList.toggle("show");
        }
    </script>

    <!-- Filter section with dropdown -->
    <div class="filter-section">
        <br><strong><?= $total_products ?> available Products for <?php echo $_SESSION['customerName']; ?>.</strong><br><br>
        <label for="priceRange">Price Range:</label>
        <select id="priceRange">
            <option value="">All</option>
            <option value="0-15">Below than RM15</option>
            <option value="15-30">RM15 - RM30</option>
            <option value="30-45">RM30 - RM45</option>
            <option value="45-60">RM45 - RM60</option>
            <option value="60-75">RM60 - RM75</option>
            <option value="75-90">RM75 - RM90</option>
            <option value="90-100">RM90 - RM100</option>
        </select><br>
        <label for="productStatus">Product Status:</label>
        <select id="productStatus">
            <option value="">All</option>
            <option value="Available">Available</option>
            <option value="Unavailable">Unavailable</option>
        </select><br><br>
        <div class="buttons">
            <input type="submit" onclick="filterProducts()" value="Search" title="Search" name="filter">
        </div>
    </div>

    <div class="products-wrapper">
        <?php foreach ($products as $product) : ?>
            <a href="index.php?page=../Products/product&productID=<?= $product['productID'] ?>" class="product" data-status="<?= $product['productStatus'] ?>">
                <img src="../pic/Products/<?= $product['productImg'] ?>" width="200" height="200" alt="<?= $product['productName'] ?>">
                <span class="name"><?= $product['productName'] ?></span>
                <span class="price">MYR<?= $product['productPrice'] ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<script>
    function filterProducts() {
        var selectedRange = document.getElementById('priceRange').value;
        var selectedStatus = document.getElementById('productStatus').value;
        var rangeValues = selectedRange.split('-');
        var minPrice = parseFloat(rangeValues[0]);
        var maxPrice = parseFloat(rangeValues[1]);

        var products = document.querySelectorAll('.product');

        for (var i = 0; i < products.length; i++) {
            var productPrice = parseFloat(products[i].querySelector('.price').innerText.replace('MYR', ''));
            var productStatus = products[i].getAttribute('data-status');

            var priceInRange = isNaN(minPrice) || (productPrice >= minPrice && productPrice <= maxPrice);
            var statusMatches = selectedStatus === '' || productStatus === selectedStatus;

            if (priceInRange && statusMatches) {
                products[i].style.display = 'block';
            } else {
                products[i].style.display = 'none';
            }
        }
    }
</script>

<?= template_footer() ?>