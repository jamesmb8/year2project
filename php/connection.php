<?php
$servername = "localhost";
$username = "root";
$password = ""; // Replace with the correct password
$dbname = "InventoryManagement";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}
$conn->close();
?>