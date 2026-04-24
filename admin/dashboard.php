<?php
session_start();
include "../db.php";

// Redirect if not logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch events - ordered by newest first
$query = "SELECT * FROM events ORDER BY id DESC";
$events = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArtWala - Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="admin-dashboard">

<div class="admin-topbar">
    <h1>ArtWala <span>- Admin</span></h1>

    <div class="admin-actions">
        <a href="add_event.php" class="btn green">Add Event</a>
        <a href="view_bookings.php" class="btn dark">View Bookings</a>
        <a href="logout.php" class="btn red">Logout</a>
    </div>
</div>

<div class="admin-card">
    <h2>All Events</h2>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                <th>Date</th>
                <th>Venue</th>
                <th>Tickets</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($events)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>

                <td>
                    <img src="../<?php echo $row['image']; ?>" class="event-img" style="width: 50px; height: auto;">
                </td>

                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo $row['event_date']; ?></td>
                <td><?php echo htmlspecialchars($row['venue']); ?></td>
                <td><?php echo $row['tickets']; ?></td>

                <td>
                    <a href="edit_event.php?id=<?php echo $row['id']; ?>" class="btn small">Edit</a>
                    <a href="delete_event.php?id=<?php echo $row['id']; ?>" 
                       class="btn small red"
                       onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


</body>
</html>