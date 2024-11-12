<?php
session_start();
if (!isset($_SESSION["admin_email"])) {
    header("Location: login.php");
    exit();
}

require_once "database.php";

// Fetch all users (students) from the database
$result = mysqli_query($conn, "SELECT * FROM user");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
<h1>ECE Engineering School Paris</h1>
    <h2>Admin Dashboard - Student Management</h2>
</header>
<div class="container6 ">
    <h3 id="student">Student Records</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Surname</th>
                <th>Email</th>
                <th>Department</th>
                <th>Date of Birth</th>
                <th>Social Security</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['first_name']; ?></td>
                <td><?php echo $user['sur_name']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['Department']; ?></td>
                <td><?php echo $user['Date_of_birth']; ?></td>
                <td><?php echo $user['Social_security']; ?></td>
                <td>
                    <a href="edit_student.php?id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_student.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
</div>
</body>
</html>
