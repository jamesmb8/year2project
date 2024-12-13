<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "InventoryManagement";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT productID, productName, price, quantity FROM products";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    echo json_encode(["success" => true, "products" => $products]);
} else {
    echo json_encode(["success" => false, "message" => "No products found"]);
}

$conn->close();
?>