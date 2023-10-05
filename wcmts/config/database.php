<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'wcmts');
define('DB_PASS', '123456');
define('DB_NAME', 'wcmts');

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if($conn->connect_error) {
    die('Connection Failed ' . $conn->connect_error);
}

echo 'CONNECTED!';