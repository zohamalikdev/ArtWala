<?php
// We don't strictly need db.php here unless we are fetching the last ID, 
// but it's fine to keep if you plan to add more features later.
include "db.php"; 

// Optional: Generate a random booking number for a more professional look
$booking_ref = "AW" . rand(10000, 99999);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed - ArtWala</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="topbar">
        <div class="logo">ArtWala</div>
    </div>

    <div class="confirm-card">
        <div class="success-icon">✔️</div>
        
        <h2>Booking Confirmed!</h2>

        <p>
            Your booking was successful.<br>
            <strong>Booking Reference: <?php echo $booking_ref; ?></strong>
        </p>

        <p>
            You will receive a confirmation email shortly with your ticket details.
            Booking Confirmed! Payment: Pay at the venue. Show booking reference at entry
        </p>

        <div class="confirm-actions">
            <a href="index.php" class="btn green">
                Back to Homepage
            </a>
        </div>
    </div>

    <footer class="eventinfo-footer">
          ArtWala © <?php echo date("Y"); ?>
    </footer>

</body>
</html>