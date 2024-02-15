<?= template_header('Event List') ?>
<style>
    .buttons input[type="submit"], .buttons input[type="button"] {
        padding: 12px 20px;
        border: 0;
        background: #272c51;
        color: #ffffff;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        border-radius: 5px;
    }

    .buttons input[type="submit"]:hover, .buttons input[type="button"]:hover {
        background: #272c51be;
    }

    .add-products {
        width: 100%;
        display: none;
        background: rgb(238, 174, 202);
        background: radial-gradient(circle,
                rgba(238, 174, 202, 0.6448704481792717) 0%,
                rgba(148, 187, 233, 0.7120973389355743) 100%);
        border: 1px solid #6b4f32;
        color: #05053f;
        border-radius: 50px 50px;
        padding: 25px;
    }
</style>
<?php
$sellerID = $_SESSION['sellerID'];
$query = "SELECT * FROM events WHERE sellerID = $sellerID";
$stmt = $conn->prepare($query);
$stmt->execute();

$result = $stmt->get_result();
$events = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="event-banner">
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
<div class="aboutus-text">
    <h3>List of Upcoming Events for UiTM Tapah Students.</h3><br>
    <center>
        <i class="fas fa-marker" onclick="openForm()" style="cursor: pointer; color:#05053f;">Add New Event</i>
    </center><br>
    <?php
    if (isset($_POST['addEvent'])) {
        $file_name2 = $_FILES['eventBanner']['name'];
        $file_name = $_FILES['eventImg']['name'];
        $tempname2 = $_FILES['eventBanner']['tmp_name'];
        $tempname = $_FILES['eventImg']['tmp_name']; 
        $folder = '../pic/Events/';

        $sellerID = $_SESSION['sellerID'];
        $eventName = $_POST['eventName'];
        $eventDate = $_POST['eventDate'];
        $eventLocation = $_POST['eventLocation'];
        $eventStatus = $_POST['eventStatus'];
        $eventDesc = $_POST['eventDesc'];

        move_uploaded_file($tempname, $folder . $file_name);
        move_uploaded_file($tempname2, $folder . $file_name2);

        $query = mysqli_query($conn, "INSERT INTO events 
        (eventName, eventDate, eventLocation, eventStatus, eventDesc, sellerID, eventImg, eventBanner) 
        VALUES ('$eventName', '$eventDate', '$eventLocation', '$eventStatus', '$eventDesc', '$sellerID', '$file_name', '$file_name2')");

        if ($query) {
            echo ("<script>alert('Successful!')</script>");
            echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/eventList&sellerID=$sellerID';</script>");
        } else {
            echo ("<script>alert('Unsuccessful!')</script>");
        }
    }
    ?>

    <div class="add-products" id="updateForm">
        <form action="" method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td><label for="eventImg"><b>Event Poster:</b></label></td>
                    <td><input type="file" name="eventImg" required /></td>
                </tr>
                <tr>
                    <td><label for="eventBanner"><b>Event Banner:</b></label></td>
                    <td><input type="file" name="eventBanner" required /></td>
                </tr>
                <tr>
                    <td><label for="eventName"><b>Event Name:</b></label></td>
                    <td><input type="text" name="eventName" placeholder="Enter Event Name" required></td>
                </tr>
                <tr>
                    <td><label for="eventDate"><b>Event Date:</b></label></td>
                    <td><input type="date" name="eventDate" required></td>
                </tr>
                <tr>
                    <td><label for="eventStatus"><b>Event Status:</b></label></td>
                    <td><select name="eventStatus" required>
                            <option value="">Select Status:</option>
                            <option value="Upcoming">Upcoming</option>
                            <option value="Started">Started</option>
                            <option value="Ended">Ended</option>
                        </select></td>
                </tr>
                <tr>
                    <td><label for="eventDesc"><b>Event Description:</b></label></td>
                    <td><textarea name="eventDesc" rows="10" cols="100" placeholder="Enter Event Description" required></textarea></td>
                </tr>
                <tr>
                    <td><label for="eventLocation"><b>Event Location:</b></label></td>
                    <td><input type="text" name="eventLocation" placeholder="Enter Event Location" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div class="buttons">
                            <input type="submit" onclick="closeForm()" title="Cancel" name="cancel" value="Cancel">
                            <input type="submit" name="addEvent" onclick="return confirm('Are you sure?');" title="Submit" value="Submit">
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div><br><br>

    <?php if ($result->num_rows == 0) {
        echo ('<br><br><h1>Event does not exist!</h1>');
    } ?>
    <center>
        <?php
        foreach ($events as $event) {
        ?>
            <div class="box-event">
                <table>
                    <tr>
                        <td class="event-img">
                            <img src="../pic/Events/<?= $event['eventImg'] ?>" width="170" height="170">
                            <strong>
                                <p><?= $event['eventDate'] ?></p>
                            </strong>
                        </td>
                        <td class="event-desc">
                            <strong>
                                <p><?= $event['eventName'] ?></p>
                            </strong><br>
                            <div class="description">
                                <?= $event['eventDesc'] ?>
                            </div><br>
                            <center>
                                <form action="" method="POST">
                                    <input type="hidden" name="eventID" value="<?= $event['eventID'] ?>">
                                    <div class="buttons">
                                        <input type="submit" name="deleteEvent" onclick="return confirm('Delete This Event?');" title="Delete Event" value="Delete">
                                        <a href="sellerIndex.php?page=../SellerDashboard/eventDisplay&eventID=<?= $event['eventID'] ?>" title="Edit Event">
                                            <input type="button" value="Edit">
                                        </a>
                                    </div>
                                </form>
                                <?php
                                if (isset($_POST['deleteEvent'])) {
                                    $eventID = $_POST['eventID'];

                                    $stmtDelete = $conn->prepare('DELETE FROM events WHERE eventID = ?');
                                    $stmtDelete->bind_param('i', $eventID);

                                    if ($stmtDelete->execute()) {
                                        echo ("<script>alert('Delete Event Successfully!')</script>");
                                        echo ("<script>window.location = 'sellerIndex.php?page=../SellerDashboard/eventList&sellerID=$sellerID';</script>");
                                    } else {
                                        echo ("<script>alert('Error Deleting Event!')</script>");
                                    }
                                    $stmtDelete->close();
                                }
                                ?>
                                <center>
                        </td>
                        <td>
                            <p>Location: <strong><?= $event['eventLocation'] ?></strong></p>
                            <p>Status: <strong><?= $event['eventStatus'] ?></strong></p>
                        </td>
                    </tr>
                </table>
            </div><br>
        <?php } ?>
    </center>
</div>
<script>
    function openForm() {
        document.getElementById("updateForm").style.display = "block";
    }

    function closeForm() {
        document.getElementById("updateForm").style.display = "none";
    }
</script>

<?= template_footer() ?>