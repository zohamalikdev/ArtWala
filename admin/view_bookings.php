<?php
session_start();
include "../db.php";

// Security Check
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Simple query to get all bookings
$query = "SELECT * FROM bookings ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="view-bookings">
    <div class="view-topbar">
        <h1>ArtWala <span>- Admin</span></h1>

        <div class="view-actions">
            <a href="dashboard.php" class="btn back">Back</a>
            <a href="logout.php" class="btn red">Logout</a>
        </div>
    </div>
    
    <h2>All Bookings</h2>

    <table class="booking-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Event ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Tickets</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['event_id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['tickets']; ?></td>
                </tr>
            <?php 
                }
            } else {
                echo "<tr><td colspan='6' style='text-align:center;'>No bookings found</td></tr>";
            }
            ?>
        </tbody>
    </table>


</body>
</html>