<?php
// include("/Projects/fyproject/Welcome/auth.php");
// Get the 4 most recently added products
$stmt = $conn->prepare('SELECT * FROM products ORDER BY productAddDate DESC LIMIT 4');
$stmt->execute();
$result = $stmt->get_result(); // Get the result set from the statement
$recentProducts = $result->fetch_all(MYSQLI_ASSOC);
?>
<?= template_header('Home') ?>

<div class="featured">
    <h2>Welcome<br> to UiTM Tapah Online Commerce <br> Platform: INFINITY</h2><br>
    <p>Discover Your Interest Here!</p>
</div>
<br><br>

<div class="recentlyadded content-wrapper">
    <h2>Recently Added Products</h2>
    <div class="products">
        <?php foreach ($recentProducts as $product) : ?>
            <a href="index.php?page=../Products/product&productID=<?= $product['productID'] ?>" class="product">
                <img src="../pic/Products/<?= $product['productImg'] ?>" width="200" height="200" alt="<?= $product['productName'] ?>">
                <span class="name"><?= $product['productName'] ?></span>
                <span class="price">MYR<?= $product['productPrice'] ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<div class="banner-area">
    <?php
    $query = "SELECT * FROM events";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $result = $stmt->get_result();
    $events = $result->fetch_all(MYSQLI_ASSOC);
    $total_events = $result->num_rows;

    $conn->close();
    ?>
    <h2>UiTM Tapah Upcoming Events</h2>
    <?php
        foreach ($events as $event) {
        ?>
    <div class="slideshow-box">
        <center>
            <img class="slide" src="../pic/Events/<?= $event['eventBanner'] ?>">
        </center>
    </div>
    <?php } ?>
    <script>
        let slideIndex = 0;
        const slides = document.getElementsByClassName('slide');

        function showSlides() {
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = 'none';
            }

            slideIndex = (slideIndex + 1) % slides.length;
            slides[slideIndex].style.display = 'block';
        }

        function startSlideshow() {
            showSlides();
            setInterval(showSlides, 3000); // 3 seconds interval
        }

        startSlideshow();
    </script>
</div>

<?= template_footer() ?>