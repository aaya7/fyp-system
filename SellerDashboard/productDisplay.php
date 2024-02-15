<style>
    .image-container {
        position: relative;
        display: inline-block;
        width: 20%;
    }

    .middle {
        transition: .5s ease;
        opacity: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        text-align: center;
        font-size: 40px;
    }

    .image {
        opacity: 1;
        display: block;
        width: 100%;
        height: auto;
        transition: .5s ease;
        backface-visibility: hidden;
    }

    .image-container:hover .image {
        opacity: 0.3;
    }

    .image-container:hover .middle {
        opacity: 1;
    }

    button {
        font-size: 40px;
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
    }
</style>

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
} else {
    // Simple error to display if the product ID wasn't specified
    exit('Product does not exist!');
}

if (isset($_POST['removeImage'])) {
    $imagePath = '../pic/Products/' . $product['productImg'];

    // Remove the image file from the server
    if (file_exists($imagePath)) {
        unlink($imagePath);

        // Update the product record in the database to set productImg to NULL or an empty string
        $stmt = $conn->prepare('UPDATE products SET productImg = NULL WHERE productID = ?');
        $stmt->bind_param('i', $_GET['productID']);
        $stmt->execute();

        $productID = $_GET['productID'];
        echo '<script>alert("Image removed successfully!");</script>';
        echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/productDisplay&productID=$productID';</script>");
    } else {
        echo '<script>alert("Image file not found!");</script>';
    }
}
if (isset($_POST['addImage'])) {

    if ($_FILES['newImage']['error'] === UPLOAD_ERR_OK) {
        $newImageName = $_FILES['newImage']['name'];
        $newImagePath = '../pic/Products/' . $newImageName;

        // Move the uploaded file to the desired location
        move_uploaded_file($_FILES['newImage']['tmp_name'], $newImagePath);

        // Update the product record in the database with the new image
        $stmt = $conn->prepare('UPDATE products SET productImg = ? WHERE productID = ?');
        $stmt->bind_param('si', $newImageName, $_GET['productID']);
        $stmt->execute();
        $productID = $_GET['productID'];

        echo '<script>alert("Image added successfully!");</script>';
        echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/productDisplay&productID=$productID';</script>");
    } else {
        echo '<script>alert("Error uploading image!");</script>';
    }
}
?>

<?= template_header('Product Display') ?>
<div class="cart content-wrapper">

    <table style="border-collapse: collapse;">
        <tr>
            <td><label for="productImg"><b>Product Image:</b></label></td>
            <td>
                <div class="image-container">
                    <img src="../pic/Products/<?= $product['productImg'] ?>" width="150" height="150" class="image">
                    <div class="middle" onclick="return confirm('Remove Image?');" id="deleteIcon">
                        <?php if ($product['productImg'] !== null) : ?>
                            <form method="post">
                                <button type="submit" name="removeImage">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                    <?php if ($product['productImg'] == null) : ?>
                        <div class="middle" id="addIcon">
                            <button>
                                <i class="fa-solid fa-pen" onclick="addImage()"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
                <form style="display: none;" method="post" id="updateForm" enctype="multipart/form-data">
                    <!-- <label for="newImage">Choose a new image:</label> -->
                    <input type="file" name="newImage" required><br>
                    <input type="submit" name="addImage" value="Submit">
                    <input type="submit" onclick="closeForm()" value="Cancel">
                </form>
            </td>

        </tr>
        <tr>
            <td><label for="productName"><b>Product Name:</b></label></td>
            <td><?= $product['productName'] ?>
                <form method="post" id="updateName" style="display: none;">
                    <input type="text" name="productName" value="<?= $product['productName'] ?>" required>
                    <input type="submit" name="updateName" value="Submit">
                </form>
            </td>
            <?php
            if (isset($_POST['updateName'])) {
                $productName = $_POST['productName'];
                $stmtUpdateName = $conn->prepare('UPDATE products SET productName = ? WHERE productID = ?');
                $stmtUpdateName->bind_param('si', $productName, $_GET['productID']);

                $productID = $_GET['productID'];

                if ($stmtUpdateName->execute()) {
                    echo ("<script>alert('Product Name Updated Successfully!')</script>");
                    echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/productDisplay&productID=$productID';</script>");
                } else {
                    echo ("<script>alert('Error updating product name!')</script>");
                }
                $stmtUpdateName->close();
            }
            ?>
        </tr>
        <tr>
            <td><label for="product_mandate"><b>Product Manufactured Date:</b></label></td>
            <td><?= $product['product_mandate'] ?>
                <form method="post" id="updateManDate" style="display: none;">
                    <input type="date" name="product_mandate" value="<?= $product['product_mandate'] ?>" required>
                    <input type="submit" name="updateManDate" value="Submit">
                </form>
            </td>
            <?php
            if (isset($_POST['updateManDate'])) {
                $newManDate = $_POST['product_mandate'];
                $stmtUpdateManDate = $conn->prepare('UPDATE products SET product_mandate = ? WHERE productID = ?');
                $stmtUpdateManDate->bind_param('si', $newManDate, $_GET['productID']);

                $productID = $_GET['productID'];

                if ($stmtUpdateManDate->execute()) {
                    echo ("<script>alert('Manufactured Date Updated Successfully!')</script>");
                    echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/productDisplay&productID=$productID';</script>");
                } else {
                    echo ("<script>alert('Error updating manufactured date!')</script>");
                }
                $stmtUpdateManDate->close();
            }
            ?>
        </tr>
        <tr>
            <td><label for="product_expdate"><b>Product Expired Date:</b></label></td>
            <td><?= $product['product_expdate'] ?>
                <form method="post" id="updateExpDate" style="display: none;">
                    <input type="date" name="product_expdate" value="<?= $product['product_expdate'] ?>" required>
                    <input type="submit" name="updateExpDate" value="Submit">
                </form>
            </td>
            <?php
            if (isset($_POST['updateExpDate'])) {
                $newExpDate = $_POST['product_expdate'];
                $stmtUpdateExpDate = $conn->prepare('UPDATE products SET product_expdate = ? WHERE productID = ?');
                $stmtUpdateExpDate->bind_param('si', $newExpDate, $_GET['productID']);

                $productID = $_GET['productID'];

                if ($stmtUpdateExpDate->execute()) {
                    echo ("<script>alert('Expired Date Updated Successfully!')</script>");
                    echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/productDisplay&productID=$productID';</script>");
                } else {
                    echo ("<script>alert('Error updating expired date!')</script>");
                }
                $stmtUpdateExpDate->close();
            }
            ?>
        </tr>
        <tr>
            <td><label for="productQuantity"><b>Product Quantity:</b></label></td>
            <td><?= $product['productQuantity'] ?>
                <form method="post" id="updateQuantity" style="display: none;">
                    <input type="number" name="productQuantity" value="<?= $product['productQuantity'] ?>" required>
                    <input type="submit" name="updateQuantity" value="Submit">
                </form>
            </td>
            <?php
            if (isset($_POST['updateQuantity'])) {
                $newQuantity = $_POST['productQuantity'];
                $stmtUpdateQuantity = $conn->prepare('UPDATE products SET productQuantity = ? WHERE productID = ?');
                $stmtUpdateQuantity->bind_param('ii', $newQuantity, $_GET['productID']);

                $productID = $_GET['productID'];

                if ($stmtUpdateQuantity->execute()) {
                    echo ("<script>alert('Quantity Updated Successfully!')</script>");
                    echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/productDisplay&productID=$productID';</script>");
                } else {
                    echo ("<script>alert('Error updating quantity!')</script>");
                }
                $stmtUpdateQuantity->close();
            }
            ?>
        </tr>
        <tr>
            <td><label for="productPrice"><b>Product Price (RM):</b></label></td>
            <td>RM<?= $product['productPrice'] ?>
                <form method="post" id="updatePrice" style="display: none;">
                    <input type="text" pattern="\d+(\.\d{2})?" name="productPrice" value="<?= $product['productPrice'] ?>" required>
                    <input type="submit" name="updatePrice" value="Submit">
                </form>
            </td>
            <?php
            if (isset($_POST['updatePrice'])) {
                $newPrice = $_POST['productPrice'];
                $stmtUpdatePrice = $conn->prepare('UPDATE products SET productPrice = ? WHERE productID = ?');
                $stmtUpdatePrice->bind_param('di', $newPrice, $_GET['productID']);

                $productID = $_GET['productID'];

                if ($stmtUpdatePrice->execute()) {
                    echo ("<script>alert('Price Updated Successfully!')</script>");
                    echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/productDisplay&productID=$productID';</script>");
                } else {
                    echo ("<script>alert('Error updating price!')</script>");
                }
                $stmtUpdatePrice->close();
            }
            ?>
        </tr>
        <tr>
            <td><label for="productStatus"><b>Product Status:</b></label></td>
            <td>
                <?= $product['productStatus'] ?>
                <form method="post" id="updateStatus" style="display: none;">
                    <select name="productStatus" required>
                        <option value="">Select Status:</option>
                        <option value="Available">Available</option>
                        <option value="Unavailable">Unavailable</option>
                    </select>
                    <input type="submit" name="updateStatus" value="Submit">
                </form>
            </td>
            <?php
            if (isset($_POST['updateStatus'])) {
                $productStatus = $_POST['productStatus'];
                $stmtUpdate = $conn->prepare('UPDATE products SET productStatus = ? WHERE productID = ?');
                $stmtUpdate->bind_param('si', $productStatus, $_GET['productID']);

                $productID = $_GET['productID'];

                if ($stmtUpdate->execute()) {
                    echo ("<script>alert('Status Updated Successfully!')</script>");
                    echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/productDisplay&productID=$productID';</script>");
                } else {
                    echo ("<script>alert('Error updating status!')</script>");
                }
                $stmtUpdate->close();
            } ?>
        </tr>
        <tr>
            <td><label for="productDesc"><b>Product Description:</b></label></td>
            <td style="width: 70%;"><?= $product['productDesc'] ?>
                <form method="post" id="updateDesc" style="display: none;">
                    <textarea name="productDesc" rows="10" cols="100" required><?= $product['productDesc'] ?></textarea>
                    <input type="submit" name="updateDesc" value="Submit">
                </form>
            </td>
            <?php
            if (isset($_POST['updateDesc'])) {
                $newDesc = $_POST['productDesc'];
                $stmtUpdateDesc = $conn->prepare('UPDATE products SET productDesc = ? WHERE productID = ?');
                $stmtUpdateDesc->bind_param('si', $newDesc, $_GET['productID']);

                $productID = $_GET['productID'];

                if ($stmtUpdateDesc->execute()) {
                    echo ("<script>alert('Description Updated Successfully!')</script>");
                    echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/productDisplay&productID=$productID';</script>");
                } else {
                    echo ("<script>alert('Error updating description!')</script>");
                }
                $stmtUpdateDesc->close();
            }
            ?>
        </tr>
        <tr>
            <td></td>
            <td>
                <div class="buttons">
                    <input type="submit" onclick="closeForm()" title="Cancel" value="Cancel">
                    <input type="submit" onclick="updateProduct()" title="Update" value="Update">
                </div>
            </td>
        </tr>
    </table>
</div>

<script>
    function addImage() {
        // Add your logic here to remove the image
        document.getElementById("updateForm").style.display = "block";
    }

    function closeForm() {
        document.getElementById("updateForm").style.display = "none";
        document.getElementById("updatePrice").style.display = "none";
        document.getElementById("updateStatus").style.display = "none";
        document.getElementById("updateName").style.display = "none";
        document.getElementById("updateManDate").style.display = "none";
        document.getElementById("updateExpDate").style.display = "none";
        document.getElementById("updateQuantity").style.display = "none";
        document.getElementById("updateDesc").style.display = "none";
    }

    function updateProduct() {
        document.getElementById("updateStatus").style.display = "block";
        document.getElementById("updatePrice").style.display = "block";
        document.getElementById("updateName").style.display = "block";
        document.getElementById("updateManDate").style.display = "block";
        document.getElementById("updateExpDate").style.display = "block";
        document.getElementById("updateQuantity").style.display = "block";
        document.getElementById("updateDesc").style.display = "block";
    }
</script>

<?= template_footer() ?>