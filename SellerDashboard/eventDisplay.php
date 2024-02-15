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

if (isset($_GET['eventID'])) {
    // Prepare statement and execute, prevents SQL injection
    $stmt = $conn->prepare('SELECT * FROM events WHERE eventID = ?');
    $stmt->bind_param('i', $_GET['eventID']); // Bind the parameter to prevent SQL injection
    $stmt->execute();

    $result = $stmt->get_result(); // Get the result set from the statement
    $event = $result->fetch_assoc(); // Fetch the product details

    // Check if the product exists (array is not empty)
    if (!$event) {
        // Simple error to display if the product doesn't exist (array is empty)
        exit('Event does not exist!');
    }
} else {
    // Simple error to display if the product ID wasn't specified
    exit('Event does not exist!');
}

if (isset($_POST['removeEventImg'])) {
    $imagePath = '../pic/Events/' . $event['eventImg'];

    // Remove the image file from the server
    if (file_exists($imagePath)) {
        unlink($imagePath);

        // Update the event record in the database to set eventImg to NULL or an empty string
        $stmt = $conn->prepare('UPDATE events SET eventImg = NULL WHERE eventID = ?');
        $stmt->bind_param('i', $_GET['eventID']);
        $stmt->execute();

        $eventID = $_GET['eventID'];
        echo '<script>alert("Event Image removed successfully!");</script>';
        echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/eventDisplay&eventID=$eventID';</script>");
    } else {
        echo '<script>alert("Event Image file not found!");</script>';
    }
}

if (isset($_POST['removeEventBanner'])) {
    $bannerImagePath = '../pic/Events/' . $event['eventBanner'];

    // Remove the banner image file from the server
    if (file_exists($bannerImagePath)) {
        unlink($bannerImagePath);

        // Update the event record in the database to set eventBanner to NULL or an empty string
        $stmt = $conn->prepare('UPDATE events SET eventBanner = NULL WHERE eventID = ?');
        $stmt->bind_param('i', $_GET['eventID']);
        $stmt->execute();

        $eventID = $_GET['eventID'];
        echo '<script>alert("Event Banner removed successfully!");</script>';
        echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/eventDisplay&eventID=$eventID';</script>");
    } else {
        echo '<script>alert("Event Banner file not found!");</script>';
    }
}

if (isset($_POST['addImage'])) {
    if ($_FILES['newImage']['error'] === UPLOAD_ERR_OK) {
        $newImageName = $_FILES['newImage']['name'];
        $newImagePath = '../pic/Events/' . $newImageName;

        // Move the uploaded file to the desired location
        move_uploaded_file($_FILES['newImage']['tmp_name'], $newImagePath);

        // Update the event record in the database with the new image
        $stmt = $conn->prepare('UPDATE events SET eventImg = ? WHERE eventID = ?');
        $stmt->bind_param('si', $newImageName, $_GET['eventID']);
        $stmt->execute();
        $eventID = $_GET['eventID'];

        echo '<script>alert("Event Image added successfully!");</script>';
        echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/eventDisplay&eventID=$eventID';</script>");
    } else {
        echo '<script>alert("Error uploading event image!");</script>';
    }
}

if (isset($_POST['addBannerImage'])) {
    if ($_FILES['newBannerImage']['error'] === UPLOAD_ERR_OK) {
        $newBannerImageName = $_FILES['newBannerImage']['name'];
        $newBannerImagePath = '../pic/Events/' . $newBannerImageName;

        // Move the uploaded banner image file to the desired location
        move_uploaded_file($_FILES['newBannerImage']['tmp_name'], $newBannerImagePath);

        // Update the event record in the database with the new banner image
        $stmt = $conn->prepare('UPDATE events SET eventBanner = ? WHERE eventID = ?');
        $stmt->bind_param('si', $newBannerImageName, $_GET['eventID']);
        $stmt->execute();
        $eventID = $_GET['eventID'];

        echo '<script>alert("Event Banner added successfully!");</script>';
        echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/eventDisplay&eventID=$eventID';</script>");
    } else {
        echo '<script>alert("Error uploading event banner image!");</script>';
    }
}
?>

<?= template_header('Event Display') ?>
<div class="cart content-wrapper">

    <table style="border-collapse: collapse; ">
        <tr>
            <td><label for="eventImg"><b>Event Image:</b></label></td>
            <td>
                <div class="image-container">
                    <img src="../pic/Events/<?= $event['eventImg'] ?>" width="150" height="150" class="image">
                    <div class="middle" onclick="return confirm('Remove Event Image?');" id="deleteIcon">
                        <?php if ($event['eventImg'] !== null) : ?>
                            <form method="post">
                                <button type="submit" name="removeEventImg">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                    <?php if ($event['eventImg'] == null) : ?>
                        <div class="middle" id="addIcon">
                            <button>
                                <i class="fa-solid fa-pen" onclick="addImage()"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
                <form style="display: none;" id="updateForm"  method="post" enctype="multipart/form-data">
                    <input type="file" name="newImage" required><br>
                    <input type="submit" name="addImage" value="Submit">
                    <input type="submit" onclick="closeForm()" value="Cancel">
                </form>
            </td>
        </tr>
        <tr>
            <td><label for="eventBanner"><b>Event Banner:</b></label></td>
            <td>
                <div class="image-container">
                    <img src="../pic/Events/<?= $event['eventBanner'] ?>" width="300" height="250" class="image">
                    <div class="middle" onclick="return confirm('Remove Event Banner?');" id="deleteIcon">
                        <?php if ($event['eventBanner'] !== null) : ?>
                            <form method="post">
                                <button type="submit" name="removeEventBanner">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                    <?php if ($event['eventBanner'] == null) : ?>
                        <div class="middle" id="addIcon">
                            <button>
                                <i class="fa-solid fa-pen" onclick="addBannerImage()"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
                <form style="display: none;" id="updateForm2" method="post" enctype="multipart/form-data" >
                    <input type="file" name="newBannerImage" required><br>
                    <input type="submit" name="addBannerImage" value="Submit">
                    <input type="submit" onclick="closeForm()" value="Cancel">
                </form>
            </td>
        </tr>
        <tr>
            <td><label for="eventName"><b>Event Name:</b></label></td>
            <td><?= $event['eventName'] ?>
                <form method="post" id="updateName" style="display: none;">
                    <input type="text" name="eventName" value="<?= $event['eventName'] ?>" required>
                    <input type="submit" name="updateName" value="Submit">
                </form>
            </td>
            <?php
            if (isset($_POST['updateName'])) {
                $newEventName = $_POST['eventName']; 
                $stmtUpdateName = $conn->prepare('UPDATE events SET eventName = ? WHERE eventID = ?'); 
                $stmtUpdateName->bind_param('si', $newEventName, $_GET['eventID']); 

                $eventID = $_GET['eventID'];

                if ($stmtUpdateName->execute()) {
                    echo ("<script>alert('Event Name Updated Successfully!')</script>");
                    echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/eventDisplay&eventID=$eventID';</script>");
                } else {
                    echo ("<script>alert('Error updating event name!')</script>");
                }
                $stmtUpdateName->close();
            }
            ?>
        </tr>

        <tr>
            <td><label for="eventDate"><b>Event Date:</b></label></td>
            <td><?= $event['eventDate'] ?>
                <form method="post" id="updateDate" style="display: none;">
                    <input type="date" name="eventDate" value="<?= $event['eventDate'] ?>" required>
                    <input type="submit" name="updateDate" value="Submit">
                </form>
            </td>
            <?php
            if (isset($_POST['updateDate'])) {
                $newDate = $_POST['eventDate'];
                $stmtUpdateDate = $conn->prepare('UPDATE events SET eventDate = ? WHERE eventID = ?');
                $stmtUpdateDate->bind_param('si', $newDate, $_GET['eventID']);

                $eventID = $_GET['eventID'];

                if ($stmtUpdateDate->execute()) {
                    echo ("<script>alert('Event Date Updated Successfully!')</script>");
                    echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/eventDisplay&eventID=$eventID';</script>");
                } else {
                    echo ("<script>alert('Error updating event date!')</script>");
                }
                $stmtUpdateDate->close();
            }
            ?>
        </tr>
        <tr>
            <td><label for="eventLocation"><b>Event Location:</b></label></td>
            <td><?= $event['eventLocation'] ?>
                <form method="post" id="updateLocation" style="display: none;">
                    <input type="text" name="eventLocation" value="<?= $event['eventLocation'] ?>" required>
                    <input type="submit" name="updateLocation" value="Submit">
                </form>
            </td>
            <?php
            if (isset($_POST['updateLocation'])) {
                $newLocation = $_POST['eventLocation'];
                $stmtUpdateLocation = $conn->prepare('UPDATE events SET eventLocation = ? WHERE eventID = ?');
                $stmtUpdateLocation->bind_param('si', $newLocation, $_GET['eventID']);

                $eventID = $_GET['eventID'];

                if ($stmtUpdateLocation->execute()) {
                    echo ("<script>alert('Location Updated Successfully!')</script>");
                    echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/eventDisplay&eventID=$eventID';</script>");
                } else {
                    echo ("<script>alert('Error updating location!')</script>");
                }
                $stmtUpdateLocation->close();
            }
            ?>
        </tr>
        <tr>
            <td><label for="eventStatus"><b>Event Status:</b></label></td>
            <td>
                <?= $event['eventStatus'] ?>
                <form method="post" id="updateStatus" style="display: none;">
                    <select name="eventStatus" required>
                        <option value="">Select Status:</option>
                        <option value="Upcoming">Upcoming</option>
                        <option value="Started">Started</option>
                        <option value="Ended">Ended</option>
                    </select>
                    <input type="submit" name="updateStatus" value="Submit">
                </form>
            </td>
            <?php
            if (isset($_POST['updateStatus'])) {
                $eventStatus = $_POST['eventStatus'];
                $stmtUpdate = $conn->prepare('UPDATE events SET eventStatus = ? WHERE eventID = ?');
                $stmtUpdate->bind_param('si', $eventStatus, $_GET['eventID']);

                $eventID = $_GET['eventID'];

                if ($stmtUpdate->execute()) {
                    echo ("<script>alert('Status Updated Successfully!')</script>");
                    echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/eventDisplay&eventID=$eventID';</script>");
                } else {
                    echo ("<script>alert('Error updating status!')</script>");
                }
                $stmtUpdate->close();
            } ?>
        </tr>
        <tr>
            <td><label for="eventDesc"><b>Event Description:</b></label></td>
            <td style="width: 70%;"><?= $event['eventDesc'] ?>
                <form method="post" id="updateDesc" style="display: none;">
                    <textarea name="eventDesc" rows="10" cols="100" required><?= $event['eventDesc'] ?></textarea>
                    <input type="submit" name="updateDesc" value="Submit">
                </form>
            </td>
            <?php
            if (isset($_POST['updateDesc'])) {
                $newDesc = $_POST['eventDesc'];
                $stmtUpdateDesc = $conn->prepare('UPDATE events SET eventDesc = ? WHERE eventID = ?');
                $stmtUpdateDesc->bind_param('si', $newDesc, $_GET['eventID']);

                $eventID = $_GET['eventID'];

                if ($stmtUpdateDesc->execute()) {
                    echo ("<script>alert('Description Updated Successfully!')</script>");
                    echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/eventDisplay&eventID=$eventID';</script>");
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
    function addBannerImage(){
        document.getElementById("updateForm2").style.display = "block";
    }

    function closeForm() {
        document.getElementById("updateForm").style.display = "none";
        document.getElementById("updateStatus").style.display = "none";
        document.getElementById("updateName").style.display = "none";
        document.getElementById("updateDate").style.display = "none";
        document.getElementById("updateDesc").style.display = "none";
        document.getElementById("updateLocation").style.display = "none";
    }

    function updateProduct() {
        document.getElementById("updateStatus").style.display = "block";
        document.getElementById("updateName").style.display = "block";
        document.getElementById("updateDate").style.display = "block";
        document.getElementById("updateLocation").style.display = "block";
        document.getElementById("updateDesc").style.display = "block";
    }
</script>

<?= template_footer() ?>