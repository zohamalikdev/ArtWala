<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


if (!isset($_GET['id'])) {
    die("No ID in URL");
}

$id = (int)$_GET['id'];

if ($id <= 0) {
    die("Invalid ID");
}

// Fetch event
$result = mysqli_query($conn, "SELECT * FROM events WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("Event not found!");
}

// Update event
if(isset($_POST['update_event'])) {

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $venue = mysqli_real_escape_string($conn, $_POST['venue']);
    $date = $_POST['date'];
    $tickets = $_POST['tickets'];

    $image_sql = "";

    // If new image uploaded
    if(!empty($_FILES['image']['name'])) {

        $image_name = time() . "_" . $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];

        move_uploaded_file($image_tmp, "../images/" . $image_name);

        $image_sql = ", image='images/$image_name'";
    }

    $update_query = "UPDATE events SET 
                        title='$title', 
                        venue='$venue', 
                        event_date='$date', 
                        tickets='$tickets' 
                        $image_sql 
                     WHERE id=$id";

    mysqli_query($conn, $update_query);

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event - ArtWala</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="add-event">

<h2 style="text-align:center; color:#00ff88; margin-bottom:20px;">Edit Event</h2>

<form method="post" enctype="multipart/form-data" class="add-form">

    <label>Title</label>
    <input type="text" name="title" value="<?php echo $row['title']; ?>" required>

    <label>Venue</label>
    <input type="text" name="venue" value="<?php echo $row['venue']; ?>" required>

    <label>Event Date</label>
    <input type="date" name="date" value="<?php echo $row['event_date']; ?>" required>

    <label>Tickets</label>
    <input type="number" name="tickets" value="<?php echo $row['tickets']; ?>" min="1" required>

    <div style="margin-top: 15px;">
        <p>Current Image:</p>
        <img src="../<?php echo $row['image']; ?>" 
             style="width:120px; border-radius:6px; margin-bottom:10px; border:1px solid #444;">
        <br>
        <label>Change Image (Optional)</label>
        <input type="file" name="image" accept="image/*">
    </div>

    <div class="form-actions" style="margin-top: 20px;">
        <button type="submit" name="update_event" class="add-event">Update Event</button>
        <a href="dashboard.php" class="btn-ghost">Cancel</a>
    </div>

</form>

</body>
</html>