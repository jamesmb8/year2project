<?php

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


$month = $_GET['month'] ?? date('Y-m');
$response = [];


$salesQuery = "SELECT DATE(sale_date) as sale_date, SUM(quantity * price) as total 
               FROM sales 
               WHERE DATE_FORMAT(sale_date, '%Y-%m') = ?
               GROUP BY DATE(sale_date)";
$stmt = $conn->prepare($salesQuery);
$stmt->bind_param('s', $month);
$stmt->execute();
$result = $stmt->get_result();
$salesData = [];
while ($row = $result->fetch_assoc()) {
    $salesData[] = $row;
}
$response['sales'] = $salesData;

$topProductsQuery = "SELECT products.productName, SUM(sales.quantity) as total_sold 
                     FROM sales 
                     INNER JOIN products ON sales.productID = products.productID 
                     GROUP BY products.productID 
                     ORDER BY total_sold DESC LIMIT 5";
$topProducts = $conn->query($topProductsQuery)->fetch_all(MYSQLI_ASSOC);
$response['topProducts'] = $topProducts;


$ordersQuery = "SELECT products.productName, sales.quantity, sales.quantity * sales.price as total 
                FROM sales 
                INNER JOIN products ON sales.productID = products.productID 
                WHERE DATE_FORMAT(sale_date, '%Y-%m') = ?";
$stmt = $conn->prepare($ordersQuery);
$stmt->bind_param('s', $month);
$stmt->execute();
$response['orders'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


$lowStockQuery = "SELECT productName, quantity 
                  FROM products 
                  WHERE quantity < low_stock_threshold";
$response['lowStock'] = $conn->query($lowStockQuery)->fetch_all(MYSQLI_ASSOC);

echo json_encode($response);
?>
