<?php
session_start();

// Destroy the session to log out the user
session_destroy();

// Redirect to the login page for the appropriate user type
if (isset($_SESSION['admin_email'])) {
    header("Location: admin_login.php"); // Redirect to admin login page
} else {
    header("Location: student_login.php"); // Redirect to student login page
}

exit();
?>