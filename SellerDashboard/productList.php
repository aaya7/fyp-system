<?= template_header('Product List') ?>
<?php

$sellerID = $_SESSION['sellerID'];
$sellerName = $_SESSION['sellerName'];
$query = "SELECT * FROM products WHERE sellerID = $sellerID ";
$stmt = $conn->prepare($query);
$stmt->execute();

$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
if ($result->num_rows == 0) {
    echo ('<br><br><h1>Product does not exist!</h1>');
}
?>

<div class="products content-wrapper">
    <h1>Product List</h1>
    <i class="fas fa-marker" onclick="openForm()" style="cursor: pointer;">Add New Product</i>
    <br><br>
    <?php
    if (isset($_POST['addProduct'])) {

        $file_name = $_FILES['productImg']['name'];
        $tempname = $_FILES['productImg']['tmp_name'];
        $folder = '../pic/Products/' . $file_name;

        $sellerID = $_SESSION['sellerID'];
        $productName = $_POST['productName'];
        $product_mandate = $_POST['product_mandate'];
        $product_expdate = $_POST['product_expdate'];
        $productQuantity = $_POST['productQuantity'];
        $productPrice = $_POST['productPrice'];
        $productStatus = $_POST['productStatus'];
        $productDesc = $_POST['productDesc'];

        $query = mysqli_query($conn, "INSERT INTO products 
        (productName, product_mandate, product_expdate, productQuantity, productPrice, productStatus, productDesc, sellerID, productImg) 
        VALUES ('$productName', '$product_mandate', '$product_expdate', '$productQuantity', '$productPrice', '$productStatus', '$productDesc', '$sellerID', '$file_name')");

        if (move_uploaded_file($tempname, $folder)) {
            echo ("<script>alert('Successful!')</script>");
            echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/productList&sellerID=$sellerID';</script>");
        } else {
            echo ("<script>alert('Unsuccessful!')</script>");
        }
    }
    ?>
    <div class="add-products" id="updateForm">
        <form action="" method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td><label for="productImg"><b>Product Image:</b></label></td>
                    <td><input type="file" name="productImg" required /></td>
                </tr>
                <tr>
                    <td><label for="productName"><b>Product Name:</b></label></td>
                    <td><input type="text" name="productName" placeholder="Enter Product Name" required></td>
                </tr>
                <tr>
                    <td><label for="product_mandate"><b>Product Manufactured Date:</b></label></td>
                    <td><input type="date" name="product_mandate" required></td>
                </tr>
                <tr>
                    <td><label for="product_expdate"><b>Product Expired Date:</b></label></td>
                    <td><input type="date" name="product_expdate" required></td>
                </tr>
                <tr>
                    <td><label for="productQuantity"><b>Product Quantity:</b></label></td>
                    <td><input type="number" name="productQuantity" placeholder="Enter Product Quantity" required></td>
                </tr>
                <tr>
                    <td><label for="productPrice"><b>Product Price (RM):</b></label></td>
                    <!-- type="text" pattern="\d+(\.\d{2})?" -->
                    <td><input type="text" pattern="\d+(\.\d{2})?" name="productPrice" placeholder="Enter Product Price" required></td>
                </tr>
                <tr>
                    <td><label for="productStatus"><b>Product Status:</b></label></td>
                    <td><select name="productStatus" required>
                            <option value="">Select Status:</option>
                            <option value="Available">Available</option>
                            <option value="Unavailable">Unavailable</option>
                        </select></td>
                </tr>
                <tr>
                    <td><label for="productDesc"><b>Product Description:</b></label></td>
                    <td><textarea id="description" name="productDesc" rows="10" cols="100" placeholder="Enter Product Description" required></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div class="buttons">
                            <input type="submit" onclick="closeForm()" title="Cancel" name="cancel" value="Cancel">
                            <input type="submit" name="addProduct" onclick="return confirm('Are you sure?');" title="Submit" value="Submit">
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="products-wrapper">
        <?php foreach ($products as $product) : ?>
            <a href="sellerIndex.php?page=../SellerDashboard/productDisplay&productID=<?= $product['productID'] ?>" class="product">
                <img src="../pic/Products/<?= $product['productImg'] ?>" width="200" height="200" alt="<?= $product['productName'] ?>">
                <span class="name"><?= $product['productName'] ?></span>
                <span class="price">MYR<?= $product['productPrice'] ?></span>
                <form action="" method="POST">
                    <input type="hidden" name="productID" value="<?= $product['productID'] ?>">
                    <div class="buttons">
                        <input type="submit" name="deleteProduct" onclick="return confirm('Delete This Product?');" title="Delete Product" value="Delete">
                    </div>
                </form>
            </a>
        <?php endforeach; ?>
    </div>
    <?php
    if (isset($_POST['deleteProduct'])) {
        $productID = $_POST['productID']; // Retrieve productID from the form submission

        $stmtDelete = $conn->prepare('DELETE FROM products WHERE productID = ?');
        $stmtDelete->bind_param('i', $productID);

        if ($stmtDelete->execute()) {
            echo ("<script>alert('Delete Product Successfully!')</script>");
            echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/productList&sellerID=$sellerID';</script>");
        } else {
            echo ("<script>alert('Error Deleting Product!')</script>");
        }
        $stmtDelete->close();
    }
    ?>
    <script>
        function openForm() {
            document.getElementById("updateForm").style.display = "block";
        }

        function closeForm() {
            document.getElementById("updateForm").style.display = "none";
        }
    </script>
</div>

<?= template_footer() ?>