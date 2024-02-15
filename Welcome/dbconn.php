<?php
// Create connection

$username = "root";
$dbpass = "root";
$dbname = "fyproject";
$conn = mysqli_connect("localhost", $username, $dbpass, $dbname);
// $username = "id21355443_projectdb";
// $dbpass = "123@kittyPia";
// $dbname = "id21355443_devbybitsyaya";
// $conn = mysqli_connect("files.000webhost.com", $username, $dbpass, $dbname);
//     // https://zootaipingonlineticketing.000webhostapp.com/
//     // https://zootaipingonlineticketing.000webhostapp.com/prestige/

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>