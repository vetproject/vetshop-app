<?php
$host = "db";
$user = "admin";
$pass = "admin123";
$dbname = "vetshop_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
