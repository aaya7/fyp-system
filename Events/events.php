<?php
$query = "SELECT * FROM events";
$stmt = $conn->prepare($query);
$stmt->execute();

$result = $stmt->get_result();
$events = $result->fetch_all(MYSQLI_ASSOC);
$total_events = $result->num_rows;

$conn->close();
?>
<?= template_header('Events') ?>

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
    <br><br>
    <h3>List of Upcoming Events for UiTM Tapah Students.</h3><br>
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
                            <div class="description" >
                                <?= $event['eventDesc'] ?>
                            </div>
                        </td>
                        <td>
                            <p>Location: <strong><?= $event['eventLocation'] ?></strong></p>
                            <p>Status: <strong><?= $event['eventStatus'] ?></strong></p>
                            <p><a href="index.php?page=../Shops/shopProduct&sellerID=<?= $event['sellerID'] ?>">View More</a></p>
                        </td>
                    </tr>
                </table>
            </div><br>
        <?php } ?>

    </center>
</div>

<?= template_footer() ?>