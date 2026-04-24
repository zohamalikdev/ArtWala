<?php
session_start();
include "../db.php";

$error = "";

// LOGIC: If already logged in, skip this page
if(isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

if(isset($_POST['login']))
{
    // Sanitize the email input (Logic Fix #1)
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Select the user based on the escaped email
    $query = "SELECT * FROM admin WHERE email='$email'";
    $data = mysqli_query($conn, $query);

    if(mysqli_num_rows($data) == 1)
    {
        $row = mysqli_fetch_assoc($data);
        
        // Strict comparison for the password
        if ($password === $row['password'])
        {
            // Set session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['email'];

            // Move to the dashboard
            header("Location: dashboard.php");
            exit();
        }
        else 
        { 
            $error = "Incorrect password"; 
        }
    } 
    else 
    { 
        $error = "Email not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>ArtWala - Admin Login </title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body class="admin-login">

    <div class="admin-logo">
        ART<span>WALA</span>
    </div>

    <h2>Admin Login</h2>

    <?php if($error != ""): ?>
        <p style="color:red; font-weight:bold;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Email</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit" name="login">Login</button>

        <div class="back-link">
            <br>
            <a href="../index.php">Back to ArtWala</a>
        </div>
    </form>
        

</body>
</html>