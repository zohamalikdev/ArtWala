<?php
// db.php - Database connection settings
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "tryart";
$DB_PORT = 3306;

// Create connection
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);

// Check connection
if (!$conn) {
    // die() stops the script and shows the specific error
    die("Connection failed: " . mysqli_connect_error());
}

// If it reaches here, the connection is successful. 
// We leave it blank so no extra text appears on your website.
?>