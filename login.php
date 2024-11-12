<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>ECE Engineering School Paris</h1>
</header>
<div class="container ">
    
        
        <!-- Student Login Form -->
        
            <?php
            session_start();
            if (isset($_POST["student_login"])) {
                $email = $_POST["student_email"];
                $password = $_POST["student_password"];
                
                require_once "database.php";
                $sql = "SELECT * FROM user WHERE email = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $user = mysqli_fetch_assoc($result);

                if ($user && password_verify($password, $user["password"])) {
                    $_SESSION["user_email"] = $user["email"];
                    header("Location: student.php");
                    exit();
                } else {
                    echo "<div class='alert alert-danger'>Invalid student email or password</div>";
                }
            }
            ?>
            <form action="login.php" method="post">
                <h3>Student Login</h3>
                <div class="form-group">
                    <input type="email" placeholder="Enter Email:" name="student_email" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Enter Password:" name="student_password" class="form-control" required>
                </div>
                <div class="form-btn">
                    <input type="submit" value="Login" name="student_login" class="btn btn-primary">
                </div>
            </form>
            <div><p>Not registered yet? <a href="registration.php">Register Here</a></p></div>
        </div>
  

        <!-- Admin Login Form -->
        <div class="container "> 
        
            <?php
            if (isset($_POST["admin_login"])) {
                $email = $_POST["admin_email"];
                $password = $_POST["admin_password"];
                
                require_once "database.php";
                $sql = "SELECT * FROM admin WHERE email = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $admin = mysqli_fetch_assoc($result);

                if ($admin && password_verify($password, $admin["password"])) {
                    $_SESSION["admin_email"] = $admin["email"];
                    header("Location: admin.php");
                    exit();
                } else {
                    echo "<div class='alert alert-danger'>Invalid admin email or password</div>";
                }
            }
            ?>
            <form action="login.php" method="post">
                <h3>Admin Login</h3>
                <div class="form-group">
                    <input type="email" placeholder="Enter Email:" name="admin_email" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Enter Password:" name="admin_password" class="form-control" required>
                </div>
                <div class="form-btn">
                    <input type="submit" value="Login" name="admin_login" class="btn btn-primary">
                </div>
            </form>
            <div><p>Not registered yet? <a href="admin_register.php">Register Here</a></p></div>
        </div>
        
    </body>
</html>
