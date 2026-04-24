<?php
include "db.php";

// Sanitize the ID to ensure it's a number
$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

if ($id == '') {
    die("Invalid Event ID");
}

$query = "SELECT * FROM events WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0){
    echo "Event not found!";
    exit;
}

$event = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArtWala - <?php echo $event['title']; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="eventinfo-topbar">
        <div class="event-logo">ArtWala</div>
        <div>
            <a href="index.php" class="eventnav-btn">Back</a>
            <a href="admin/login.php" class="eventnav-btn admin">Admin</a>
        </div>
    </header>

    <main class="eventdetails-container">
        <div class="eventinfo-detail-card">
            <div class="eventinfo-image">
                <img src="<?php echo $event['image']; ?>" alt="Event Image">
            </div>

            <div class="eventinfo-details">
                <h1><?php echo $event['title']; ?></h1>
                
                <p class="eventinfo-meta">
                    <?php echo $event['event_date']; ?> •
                    <?php echo $event['venue']; ?>
                </p>

                <p class="eventinfo-desc">
                    <?php echo $event['description'] ?? 'Join us for an amazing art experience.'; ?>
                </p>

                <p class="eventinfo-tickets">
                    <strong>Available Tickets:</strong> <?php echo $event['tickets']; ?>
                </p>

                <?php if ($event['tickets'] > 0): ?>
                    <a href="book.php?id=<?php echo $event['id']; ?>">
                        <button class="eventbook-now">Book Now</button>
                    </a>
                <?php else: ?>
                    <button class="eventbook-now" disabled style="background-color: grey;">Sold Out</button>
                <?php endif; ?>
            </div>
        </div>

        <div class="eventinfo-gallery">
            <h3>Image Gallery</h3>
            <div class="eventgallery-grid">
                <img src="<?php echo $event['image']; ?>" alt="Gallery 1">
                <img src="<?php echo $event['image']; ?>" alt="Gallery 2">
                <img src="<?php echo $event['image']; ?>" alt="Gallery 3">
                <img src="<?php echo $event['image']; ?>" alt="Gallery 4">
            </div>
        </div>
    </main>

    <footer class="eventinfo-footer">
          ArtWala © <?php echo date("Y"); ?>
    </footer>


</body>
</html>