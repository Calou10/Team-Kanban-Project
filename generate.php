<?php
// Replace 'your_plain_password' with the actual password you want to hash
$plain_password = 'password123'; // Put the actual password here
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

echo $hashed_password;
?>