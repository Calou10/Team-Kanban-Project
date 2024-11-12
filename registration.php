<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>ECE Engineering School Paris</h1>
</header>
<div class="container3">
    <?php
    if (isset($_POST["submit"])) {
        $first_name = $_POST["first_name"];
        $sur_name = $_POST["sur_name"];
        $Date_of_birth = $_POST["Date_of_birth"];
        $email = $_POST["email"];
        $Department = $_POST["Department"];
        $Social_security = $_POST["Social_security"];
        $password = $_POST["password"];
        $passwordRepeat = $_POST["repeat_password"];

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $errors = array();

        if (empty($first_name) || empty($sur_name) || empty($Date_of_birth) || empty($email) || empty($Department) || empty($Social_security) || empty($password) || empty($passwordRepeat)) {
            array_push($errors, "All fields are required");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
        }
        if (strlen($password) < 8) {
            array_push($errors, "Password must be at least 8 characters long");
        }
        if ($password !== $passwordRepeat) {
            array_push($errors, "Password does not match");
        }

        require_once "database.php";
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        
        if (mysqli_stmt_num_rows($stmt) > 0) {
            array_push($errors, "Email already exists!");
        }
        
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        } else {
            $sql = "INSERT INTO user (first_name, sur_name, Date_of_birth, email, Department, Social_security, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt, "sssssss", $first_name, $sur_name, $Date_of_birth, $email, $Department, $Social_security, $passwordHash);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>You are registered successfully.</div>";
            } else {
                die("Something went wrong");
            }
        }
    }
    ?>

    <form action="registration.php" method="post">
    
            <div class="form-group">
                <input type="text" class="form-control" name="first_name" placeholder="First Name:">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="sur_name" placeholder="Sur Name:">
            </div>
            <div class="form-group">
                <input type="date" class="form-control" name="Date_of_birth" placeholder="Date of Birth:">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="Department" placeholder="Department">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="Social_security" placeholder="Social Security Number">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>

        </form>
    <div id="login"><p>Already Registered <a href="login.php"><b>Login Here</b></a></p></div>
</div>
</body>
</html>
