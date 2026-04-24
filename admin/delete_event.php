<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if(!isset($_GET['id'])) {
    die("No ID provided");
}

$id = (int)$_GET['id'];

if($id <= 0){
    die("Invalid ID");
}

mysqli_query($conn, "DELETE FROM events WHERE id=$id");

header("Location: dashboard.php");
exit;
?>