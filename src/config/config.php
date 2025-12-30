<?php
$host = "db"; // service name in docker-compose
$user = getenv('MYSQL_USER');
$pass = getenv('MYSQL_PASSWORD');
$dbname = getenv('MYSQL_DATABASE');

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("❌ Database connection failed: " . $conn->connect_error);
}
?>
