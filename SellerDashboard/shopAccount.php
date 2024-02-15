<?= template_header('Shop Profile') ?>

<?php
if (isset($_GET['sellerID'])) {
    // Prepare statement and execute, prevents SQL injection
    $stmt = $conn->prepare('SELECT * FROM sellers WHERE sellerID = ?');
    $stmt->bind_param('i', $_GET['sellerID']); // Bind the parameter to prevent SQL injection
    $stmt->execute();

    $result = $stmt->get_result(); // Get the result set from the statement
    $seller = $result->fetch_assoc(); // Fetch the product details

    // Check if the product exists (array is not empty)
    if (!$seller) {
        // Simple error to display if the product doesn't exist (array is empty)
        exit('Seller does not exist!');
    }
} else {
    // Simple error to display if the product ID wasn't specified
    exit('Seller does not exist!');
}
$sellerName =  $_SESSION['sellerName'];
$sellerID =  $_SESSION['sellerID'];
?>
<div class="content-wrapper">
    <div class="profile_display">
        <h2>Edit Profile</h2>
        <table>
            <tr>
                <th><?php echo $sellerName ?>'s Shop Account Profile</th>
                <th><i class="fas fa-marker" onclick="openForm()"></i></th>
            </tr>
            <tr>
                <td>Name: <?= $seller['sellerName'] ?></td>
            </tr>
            <tr>
                <td>Shop Name: <?= $seller['shopName'] ?></td>
            </tr>
            <tr>
                <td>Date Created: <?= $seller['shopCreated'] ?></td>
            </tr>
            <tr>
                <td>Shop Category: <?= $seller['shopCategory'] ?></td>
            </tr>
            <tr>
                <td>Shop Address: <?= $seller['sellerAddress'] ?></td>
            </tr>
        </table>

        <div class="form-popup" id="updateForm">
            <form action="" class="form-container" method="POST">
                <table>
                    <tr>
                        <td><label for="shopName"><b>Shop Name:</b></label></td>
                        <td><input type="text" name="shopName" value="<?= $seller['shopName'] ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="shopCategory"><b>Shop Category:</b></label></td>
                        <td>
                            <select name="shopCategory">
                                <option value="">Select Shop Category:</option>
                                <option value="Preloved">Preloved</option>
                                <option value="Basic Needs">Basic Needs</option>
                                <option value="Health & Beauty">Health & Beauty</option>
                                <option value="Online Ticketing">Online Ticketing</option>
                                <option value="Food">Food</option>
                                <option value="Books">Books</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="sellerAddress"><b>Shop Address:</b></label></td>
                        <td><input type="text" name="sellerAddress" value="<?= $seller['sellerAddress'] ?>" required></td>
                    </tr>
                    <tr>
                        <td><button type="button" class="btn cancel" onclick="closeForm()">Cancel</button></td>
                        <td><button type="submit" name="updateShopProfile" class="btn" onclick="return confirm('Are you sure?');">Update</button></td>
                    </tr>
                </table>
            </form>
            <?php
            $sellerID = $_SESSION['sellerID'];
            if (isset($_POST['updateShopProfile'])) {

                $shopName = $_POST["shopName"];
                $shopCategory = $_POST["shopCategory"];
                $sellerAddress = $_POST["sellerAddress"];

                $sqlUpdate = "UPDATE sellers SET shopName='$shopName', shopCategory='$shopCategory',
                sellerAddress='$sellerAddress' WHERE sellerID='$sellerID'";

                if ($conn->query($sqlUpdate) === TRUE) {
                    echo ("<script>alert('Shop Account Profile Updated Successfully!')</script>");
                    echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/shopAccount&sellerID=$sellerID';</script>");
                } else {
                    echo ("<script>alert('Please Try Again!')</script>");
                }

                $conn->close();
            }
            ?>
        </div>
    </div>
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