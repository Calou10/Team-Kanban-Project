<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["user_email"])) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit();
}

// User is logged in, fetch the user's email from session
$email = $_SESSION["user_email"];

// Include database connection
require_once "database.php";

// Query to fetch user details based on the email
$sql = "SELECT * FROM user WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "<div class='alert alert-danger'>User not found in the database</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>ECE Engineering School Paris</h1>
</header>

<div class="container4">
    <h2>Welcome, <?php echo htmlspecialchars($user['first_name']); ?>!</h2>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
    <p>Department: <?php echo htmlspecialchars($user['Department']); ?></p>
    <p>Date of Birth: <?php echo htmlspecialchars($user['Date_of_birth']); ?></p>
    <p>Social Security: <?php echo htmlspecialchars($user['Social_security']); ?></p><br>
    <div class="button-container">
        <form action="schedule.php" method="post" style="display:inline;" >
            <input type="submit" value="Schedule" class="btn btn-primary">
        </form>
        <form action="logout.php" method="post" style="display:inline;">
            <input type="submit" value="Logout" class="btn btn-danger">
        </form>
        
    </div>

</div>
</body>
</html>
