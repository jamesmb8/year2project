<?php
// reports_data.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "InventoryManagement";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$startDate = $_GET['startDate'] ?? '';
$endDate = $_GET['endDate'] ?? '';

if ($startDate && $endDate) {
    $query = "SELECT * FROM sales WHERE sale_date BETWEEN ? AND ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $salesData = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($salesData);
} else {
    echo json_encode([]);
}
?>
