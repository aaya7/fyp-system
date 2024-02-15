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
                <th><?php echo $sellerName ?>'s Profile</th>
                <th><i class="fas fa-marker" onclick="openForm()"></i></th>
            </tr>
            <tr>
                <td>Name: <?= $seller['sellerName'] ?></td>
            </tr>
            <tr>
                <td>Category: <?= $seller['sellerCategory'] ?></td>
            </tr>
            <tr>
                <td>Faculty: <?= $seller['sellerFaculty'] ?></td>
            </tr>
            <tr>
                <td>Course: <?= $seller['sellerCourse'] ?></td>
            </tr>
            <tr>
                <td>Address: <?= $seller['sellerAddress'] ?></td>
            </tr>
            <tr>
                <td>Phone Number: <?= $seller['sellerPnum'] ?></td>
            </tr>
            <tr>
                <td>E-mail: <?= $seller['sellerEmail'] ?></td>
            </tr>
        </table>

        <div class="form-popup" id="updateForm">
            <form action="" class="form-container" method="POST">
                <table>
                    <tr>
                        <td><label for="sellerName"><b>Name:</b></label></td>
                        <td><input type="text" name="sellerName" value="<?= $seller['sellerName'] ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="sellerCategory"><b>Category:</b></label></td>
                        <td>
                            <select name="sellerCategory">
                                <option value="">Select Category:</option>
                                <option value="Student">Student</option>
                                <option value="Staff">Staff</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="sellerFaculty"><b>Faculty:</b></label></td>
                        <td>
                            <select name="sellerFaculty">
                                <option value="">Select Faculty:</option>
                                <option value="FSG (Faculty of Applied Science)">FSG (Faculty of Applied Science)</option>
                                <option value="FA (Faculty of Accountancy)">FA (Faculty of Accountancy)</option>
                                <option value="KPPIM (College of Computing, Informatics and Media)">KPPIM (College of Computing, Informatics and Media)</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="sellerCourse"><b>Course:</b></label></td>
                        <td>
                            <select name="sellerCourse">
                                <option value="">Select Course:</option>
                                <option value="AS120 - Diploma in Applied Science">AS120 - Diploma in Applied Science</option>
                                <option value="AC120 - Diploma in Accounting Information System">AC120 - Diploma in Accounting Information System</option>
                                <option value="AC110 - Diploma in Accountancy">AC110 - Diploma in Accountancy </option>
                                <option value="AC151 - Foundation in Accountancy (ACCA FIA)">AC151 - Foundation in Accountancy (ACCA FIA)</option>
                                <option value="CS110 - Diploma in Computer Science">CS110 - Diploma in Computer Science</option>
                                <option value="CS230 - Bachelor of Computer Science (Honours)">CS230 - Bachelor of Computer Science (Honours)</option>
                                <option value="CS111 - Diploma in Statistics">CS111 - Diploma in Statistics</option>
                                <option value="CS112 - Diploma in Actuarial Science">CS112 - Diploma in Actuarial Science</option>
                                <option value="CS143 - Diploma in Mathematical Sciences">CS143 - Diploma in Mathematical Sciences</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="sellerAddress"><b>Address:</b></label></td>
                        <td><input type="text" name="sellerAddress" value="<?= $seller['sellerAddress'] ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="sellerPnum"><b>Phone Number:</b></label></td>
                        <td><input type="text" name="sellerPnum" value="<?= $seller['sellerPnum'] ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="sellerEmail"><b>E-mail:</b></label></td>
                        <td><input type="email" name="sellerEmail" value="<?= $seller['sellerEmail'] ?>" required></td>
                    </tr>
                    <tr>
                        <td><button type="button" class="btn cancel" onclick="closeForm()">Cancel</button></td>
                        <td><button type="submit" name="updateSellerProfile" class="btn" onclick="return confirm('Are you sure?');">Update</button></td>
                    </tr>
                </table>
            </form>
            <?php
            $sellerID = $_SESSION['sellerID'];
            if (isset($_POST['updateSellerProfile'])) {

                $sellerName = $_POST['sellerName'];
                $sellerCategory = $_POST['sellerCategory'];
                $sellerFaculty = $_POST['sellerFaculty'];
                $sellerCourse = $_POST['sellerCourse'];
                $sellerAddress = $_POST['sellerAddress'];
                $sellerPnum = $_POST['sellerPnum'];
                $sellerEmail = $_POST['sellerEmail'];

                $sqlUpdate = "UPDATE sellers SET sellerName='$sellerName', sellerCategory='$sellerCategory',
                    sellerFaculty='$sellerFaculty', sellerCourse='$sellerCourse', sellerAddress='$sellerAddress', 
                    sellerPnum='$sellerPnum', sellerEmail='$sellerEmail' where sellerID='$sellerID' ";

                if ($conn->query($sqlUpdate) === TRUE) {
                    echo ("<script>alert('Profile Updated Successfully!')</script>");
                    echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/sellerProfile&sellerID=$sellerID';</script>");
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