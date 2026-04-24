<?php
include "db.php";

/* 1. CHECK EVENT ID */
if (!isset($_GET['id'])) {
    die("Event ID not found");
}

// Sanitize ID for security
$event_id = mysqli_real_escape_string($conn, $_GET['id']);

/* 2. FETCH EVENT DATA */
$event_query = "SELECT * FROM events WHERE id = $event_id";
$event_result = mysqli_query($conn, $event_query);
$event = mysqli_fetch_assoc($event_result);

if (!$event) {
    die("Event not found");
}

/* 3. LOGIC FOR SUBMITTING THE FORM */
if (isset($_POST['confirm'])) {

    // Sanitize inputs
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $phone   = mysqli_real_escape_string($conn, $_POST['phone']);
    $tickets = (int)$_POST['tickets']; // Force to integer for math

    /* --- THE FIX FOR NEGATIVE TICKETS --- */
    if ($tickets > $event['tickets']) {
        echo "<script>alert('Error: Not enough tickets available. Only " . $event['tickets'] . " left.');</script>";
    } 
    else if ($tickets <= 0) {
        echo "<script>alert('Please enter a valid number of tickets.');</script>";
    }
    else {
        /* SAVE BOOKING */
        $insert = "INSERT INTO bookings (event_id, name, email, phone, tickets)
                   VALUES ('$event_id', '$name', '$email', '$phone', '$tickets')";
        mysqli_query($conn, $insert);

        /* REDUCE TICKETS */
        $update = "UPDATE events 
                   SET tickets = tickets - $tickets 
                   WHERE id = $event_id";
        mysqli_query($conn, $update);

        /* REDIRECT AFTER SUCCESS */
        header("Location: confirm.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book <?php echo htmlspecialchars($event['title']); ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="topbar">
    <div class="logo">ArtWala</div>
    <div class="top-actions">
        <a href="index.php" class="btn dark">Back</a>
        <a href="admin/login.php" class="btn green">Admin</a>
    </div>
</div>

<div class="booking-card">

    <h2>Book Tickets – <?php echo htmlspecialchars($event['title']); ?></h2>
    
    <p>Available Tickets: <strong><?php echo $event['tickets']; ?></strong></p>

    <?php if ($event['tickets'] > 0): ?>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text"  name="phone"  placeholder="Phone Number" minlength="10" maxlength="11" pattern="\d*" title="Please enter a valid 10 or 11 digit phone number" required>
            
            <input type="number" name="tickets" placeholder="Number of tickets" 
                   max="<?php echo $event['tickets']; ?>" min="1" required>

            <div class="booking-actions">
                <button type="submit" name="confirm" class="btn green">
                    Confirm Booking
                </button>
                
                <a href="index.php" class="btn dark">Cancel</a>
            </div>
        </form>
    <?php else: ?>
        <div class="error-msg">
            <p><strong>Sold Out!</strong> No more tickets available for this event.</p>
            <a href="index.php" class="btn dark">Go Back</a>
        </div>
    <?php endif; ?>

</div>

<footer class="eventinfo-footer">
      ArtWala © <?php echo date("Y"); ?>
</footer>


</body>
</html>