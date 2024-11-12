<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

</head>
<body>
<header>
    <h1>ECE Engineering Schools Paris</h1>
</header>
<div class="container3">
    <?php
    if (isset($_POST["register"])) {
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $passwordRepeat = $_POST["repeat_password"];

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $errors = array();

        if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($passwordRepeat)) {
            array_push($errors, "All fields are required");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Invalid email format");
        }
        if (strlen($password) < 8) {
            array_push($errors, "Password must be at least 8 characters");
        }
        if ($password !== $passwordRepeat) {
            array_push($errors, "Passwords do not match");
        }

        require_once "database.php";
        $sql = "SELECT * FROM admin WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            array_push($errors, "Email is already registered!");
        }

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        } else {
            $sql = "INSERT INTO admin (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt, "ssss", $first_name, $last_name, $email, $passwordHash);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>You are registered successfully.</div>";
            } else {
                echo "<div class='alert alert-danger'>Something went wrong. Please try again.</div>";
            }
        }
    }
    ?>
    <form action="admin_register.php" method="post">
        <h3>College Admin Registration</h3>
        <div class="form-group mb-3">
            <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
        </div>
        <div class="form-group mb-3">
            <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
        </div>
        <div class="form-group mb-3">
            <input type="email" class="form-control" name="email" placeholder="Email" required>
        </div>
        <div class="form-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>
        <div class="form-group mb-3">
            <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password" required>
        </div>
        <div class="form-btn">
            <input type="submit" class="btn btn-primary w-100" value="Register" name="register">
        </div>
    </form><br>
    <div id="login"><p>Already Registered <a href="login.php">
  <button class="btn btn-primary">Login here</button>
</a>
</p></div>
</div>
</body>
</html>
