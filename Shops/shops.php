<?php
$query = "SELECT * FROM sellers";
$stmt = $conn->prepare($query);
$stmt->execute();

$result = $stmt->get_result();
$sellers = $result->fetch_all(MYSQLI_ASSOC);
$total_sellers = $result->num_rows;

$conn->close();
?>
<?= template_header('Shops') ?>
<div class="products content-wrapper">
	<h1>Shop List</h1>
	<div class="popup" onclick="popup()">Read Me
		<span class="popuptext" id="myPopup">Browse your desired products from each shop and add products to cart first if you are interested to purchase.</span>
	</div>

	<script>
		function popup() {
			var popup = document.getElementById("myPopup");
			popup.classList.toggle("show");
		}
	</script>
	<p><?= $total_sellers ?> available Shops for <?php echo $_SESSION['customerName']; ?>.</p>
	<div class="shop-container">
		<ol style="--length: 5" role="list">
			<?php
			$i = 1;
			foreach ($sellers as $seller) { ?>
				<li style="--i: <?= $i ?>">
					<a href="index.php?page=../Shops/shopProduct&sellerID=<?= $seller['sellerID'] ?>">
						<h3><?= $seller['shopName'] ?></h3>
						<p><?= $seller['shopCategory'] ?></p>
					</a>
				</li>
			<?php
				$i++;
			}
			?>
		</ol>
	</div>
</div>
<?= template_footer() ?>