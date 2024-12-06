<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginform.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "InventoryManagement";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}


$salesData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];


    if (!empty($startDate) && !empty($endDate)) {
     
        $sql = "SELECT sales.saleID, sales.userID, sales.productID, products.productName, 
                       sales.quantity, sales.price, sales.sale_date 
                FROM sales
                JOIN products ON sales.productID = products.productID
                WHERE sales.sale_date BETWEEN ? AND ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $salesData[] = $row;
        }

        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reports</title>
    <link rel="stylesheet" href="CSS/adminstyle.css">
</head>
<body>
<div id="header"></div>
<div id="sidenav"></div>
    
    <div class="content">
        <div class="container">
            <h1 class="dashboard-title">Sales Reports</h1>
            <div class="filter-section">
                <form method="POST" action="reports.php">
                    <label for="startDate">Start Date:</label>
                    <input type="date" id="startDate" name="startDate" required>
                    <label for="endDate">End Date:</label>
                    <input type="date" id="endDate" name="endDate" required>
                    <button type="submit">Go</button>
                </form>
            </div>
            <div class="reports-section">
                <h2>Sales Overview</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sale ID</th>
                            <th>User ID</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Sale Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($salesData)): ?>
                            <?php foreach ($salesData as $sale): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($sale['saleID']); ?></td>
                                    <td><?php echo htmlspecialchars($sale['userID']); ?></td>
                                    <td><?php echo htmlspecialchars($sale['productName']); ?></td>
                                    <td><?php echo htmlspecialchars($sale['quantity']); ?></td>
                                    <td><?php echo htmlspecialchars(number_format($sale['price'], 2)); ?></td>
                                    <td><?php echo htmlspecialchars($sale['sale_date']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No sales data found for the selected date range.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="admin.js"></script>
</body>
</html>
