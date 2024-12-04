<?php

$hostName = "mysql-db"; // This is the service name defined in docker-compose.yml
$dbUser = "user"; // MySQL user
$dbPassword = "userpassword"; // MySQL user password
$dbName = "test1"; // The database you want to use

$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}

?>
