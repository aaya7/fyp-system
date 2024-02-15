<?= template_header('User Profile') ?>

<?php
if (isset($_GET['customerID'])) {
    // Prepare statement and execute, prevents SQL injection
    $stmt = $conn->prepare('SELECT * FROM customers WHERE customerID = ?');
    $stmt->bind_param('i', $_GET['customerID']); // Bind the parameter to prevent SQL injection
    $stmt->execute();

    $result = $stmt->get_result(); // Get the result set from the statement
    $customer = $result->fetch_assoc(); // Fetch the product details

    // Check if the product exists (array is not empty)
    if (!$customer) {
        // Simple error to display if the product doesn't exist (array is empty)
        exit('Customer does not exist!');
    }
} else {
    // Simple error to display if the product ID wasn't specified
    exit('Customer does not exist!');
}
$customerName =  $_SESSION['customerName'];
$customerID = $_SESSION['customerID'];
?>
<div class="content-wrapper">
    <div class="profile_display">
        <h2>Edit Profile</h2>
        <table>
            <tr>
                <th><?php echo $customerName ?>'s Profile</th>
                <th><i class="fas fa-marker" onclick="openForm()"></i></th>
            </tr>
            <tr>
                <td>Name: <?= $customer['customerName'] ?></td>
            </tr>
            <tr>
                <td>Category: <?= $customer['customerCategory'] ?></td>
            </tr>
            <tr>
                <td>Faculty: <?= $customer['customerFaculty'] ?></td>
            </tr>
            <tr>
                <td>Course: <?= $customer['customerCourse'] ?></td>
            </tr>
            <tr>
                <td>Address: <?= $customer['customerAddress'] ?></td>
            </tr>
            <tr>
                <td>Phone Number: <?= $customer['customerPnum'] ?></td>
            </tr>
            <tr>
                <td>E-mail: <?= $customer['customerEmail'] ?></td>
            </tr>
        </table>

        <div class="form-popup" id="updateForm">
            <form action="" class="form-container" method="POST">
                <table>
                    <tr>
                        <td><label for="customerName"><b>Name:</b></label></td>
                        <td><input type="text" name="customerName" value="<?= $customer['customerName'] ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="customerCategory"><b>Category:</b></label></td>
                        <td>
                            <select name="customerCategory">
                                <option value="">Select Category:</option>
                                <option value="Student">Student</option>
                                <option value="Staff">Staff</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="customerFaculty"><b>Faculty:</b></label></td>
                        <td>
                            <select name="customerFaculty">
                                <option value="">Select Faculty:</option>
                                <option value="FSG (Faculty of Applied Science)">FSG (Faculty of Applied Science)</option>
                                <option value="FA (Faculty of Accountancy)">FA (Faculty of Accountancy)</option>
                                <option value="KPPIM (College of Computing, Informatics and Media)">KPPIM (College of Computing, Informatics and Media)</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="customerCourse"><b>Course:</b></label></td>
                        <td>
                            <select name="customerCourse">
                                <option value="">Select Course:</option>
                                <option value="AS120 - Diploma in Applied Science">AS120 - Diploma in Applied Science</option>
                                <option value="AC120 - Diploma in Accounting Information System">AC120 - Diploma in Accounting Information System</option>
                                <option value="AC110 - Diploma in Accountancy ">AC110 - Diploma in Accountancy </option>
                                <option value="AC151 - Foundation in Accountacy (ACCA FIA)">AC151 - Foundation in Accountacy (ACCA FIA)</option>
                                <option value="CS110 - Diploma in Computer Science">CS110 - Diploma in Computer Science</option>
                                <option value="CS230 - Bachelor of Computer Science (Honours)">CS230 - Bachelor of Computer Science (Honours)</option>
                                <option value="CS111 - Diploma in Statistics">CS111 - Diploma in Statistics</option>
                                <option value="CS112 - Diploma in Actuarial Science">CS112 - Diploma in Actuarial Science</option>
                                <option value="CS143 - Diploma in Mathematical Sciences">CS143 - Diploma in Mathematical Sciences</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="customerAddress"><b>Address:</b></label></td>
                        <td><input type="text" name="customerAddress" value="<?= $customer['customerAddress'] ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="customerPnum"><b>Phone Number:</b></label></td>
                        <td><input type="text" name="customerPnum" value="<?= $customer['customerPnum'] ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="customerEmail"><b>E-mail:</b></label></td>
                        <td><input type="email" name="customerEmail" value="<?= $customer['customerEmail'] ?>" required></td>
                    </tr>
                    <tr>
                        <td><button type="button" class="btn cancel" onclick="closeForm()">Cancel</button></td>
                        <td><button type="submit" name="updateCustProfile" class="btn" onclick="return confirm('Are you sure?');">Update</button></td>
                    </tr>
                </table>
            </form>
            <?php
            $customerID = $_SESSION['customerID'];
            if (isset($_POST['updateCustProfile'])) {

                $customerName = $_POST['customerName'];
                $customerCategory = $_POST['customerCategory'];
                $customerFaculty = $_POST['customerFaculty'];
                $customerCourse = $_POST['customerCourse'];
                $customerAddress = $_POST['customerAddress'];
                $customerPnum = $_POST['customerPnum'];
                $customerEmail = $_POST['customerEmail'];

                $sqlUpdate = "UPDATE customers SET customerName='$customerName', customerCategory='$customerCategory',
                    customerFaculty='$customerFaculty', customerCourse='$customerCourse', customerAddress='$customerAddress', 
                    customerPnum='$customerPnum', customerEmail='$customerEmail' where customerID='$customerID' ";

                if ($conn->query($sqlUpdate) === TRUE) {
                    echo ("<script>alert('Profile Updated Successfully!')</script>");
                    echo ("<script>window.location = 'index.php?page=../Profile/profile&customerID=$customerID';</script>");
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