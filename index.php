<?php
include "db.php";

// get search text and make it safe for the query
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// basic SQL logic
if ($search != "") {
    $query = "SELECT * FROM events 
              WHERE title LIKE '%$search%' 
              OR venue LIKE '%$search%'";
} else {
    $query = "SELECT * FROM events";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>ArtWala - Art Events</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <header class="topbar">
    <div class="logo">ArtWala</div>

    <div class="header-right">
        <form method="GET" action="index.php" class="search-form">
            <select disabled>
                <option>City</option>
            </select>

            <select disabled>
                <option>Category</option>
            </select>

            <input type="text" name="search" placeholder="Search..." 
                   value="<?php echo htmlspecialchars($search); ?>">

            <button type="submit" class="search-btn">Search</button>
        </form>

        <a href="admin/login.php" class="admin-btn">Admin</a>
    </div>
</header>


  <main class="container">
    <h2 class="event-heading">Events</h2>

    <div class="events-grid">
      <?php
      if (mysqli_num_rows($result) == 0) {
          echo "<p class='no-event'>No events found.</p>";
      } else {
          while ($row = mysqli_fetch_assoc($result)) {
      ?>
  
      <div class="event-card">
        <img src="<?php echo $row['image']; ?>" alt="Event Image">
        
        <div class="event-info">
          <h3><?php echo $row['title']; ?></h3>
          <p class="event-meta">
            <?php echo $row['event_date']; ?> • <?php echo $row['venue'] ?? ''; ?>
          </p>

          <div class="event-footer">
            <a href="event_info.php?id=<?php echo $row['id']; ?>" class="book-link">
                <button class="book-btn">View Details</button>
            </a>
            <span class="tickets"><?php echo $row['tickets']; ?> tickets left</span>
          </div>
        </div>
      </div>

      <?php
          }
      } 
      ?>
    </div> </main> <footer class="footer">
    <p>ArtWala &copy; <?php echo date("Y"); ?> — Simple event ticketing for art events.</p>
  </footer>



</body>
</html>