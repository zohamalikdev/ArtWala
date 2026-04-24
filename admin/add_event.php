<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['add_event'])) {
    // Escaping strings to prevent SQL syntax errors
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $venue = mysqli_real_escape_string($conn, $_POST['venue']);
    $date = $_POST['event_date'];
    $tickets = $_POST['tickets'];

    // IMAGE LOGIC
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    // 1. Path for the server to move the file
    $target_dir = "../images/";
    $target_file = $target_dir . $image_name;

    // 2. Path for the database so front-end can find it
    $db_save_path = "images/" . $image_name;

    if (move_uploaded_file($image_tmp, $target_file)) {
        // save data in database using the correct relative path
        $query = "INSERT INTO events (title, venue, event_date, tickets, image)
                  VALUES ('$title', '$venue', '$date', '$tickets', '$db_save_path')";

        mysqli_query($conn, $query);
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Image upload failed. Check if images folder exists and is writable.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArtWala - Add Event</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="add-event">
  <main class="add-container">
    <div class="add-card">
      <h2>Add Event</h2>
      
      <form method="post" enctype="multipart/form-data" class="add-form">
        
        <input type="text" name="title" placeholder="Title" required>
        <input type="text" name="venue" placeholder="Venue" required>
        
        <div class="flex-row">
          <input type="date" name="event_date" required>
        </div>

        <input type="number" name="tickets" placeholder="Number of Tickets" required>
        <input type="file" name="image" required>

        <div class="form-actions">
          <button type="submit" class="add-event" name="add_event">Add Event</button>
          <a href="dashboard.php" class="btn-ghost">Cancel</a>
        </div>
      </form>
    </div>
  </main>

</body>
</html>