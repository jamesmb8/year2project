<?php



error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "Hallam123@";
$dbname = "InventoryManagement";

$conn = new mysqli($servername, $username, $password, $dbname);

$try = "SELECT productID, productName, price, quantity FROM products";
$result = $conn->query($try);

if ($result->num_rows > 0) {
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products = $row;
    }
    echo json_encode(["success" => true, "produts" => $products]);
} else {
    echo json_encode(["success" => true, "products" => []]);
}

$conn->close();
?>