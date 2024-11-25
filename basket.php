<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Fetch basket from session
$basket = $_SESSION['basket'] ?? [];

// Fetch product details from database
$servername = "localhost";
$username = "root";
$password = "Hallam123@";
$dbname = "InventoryManagement";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$productDetails = [];
if (!empty($basket)) {
    $placeholders = implode(',', array_fill(0, count($basket), '?'));
    $stmt = $conn->prepare("SELECT productID, productName, price FROM products WHERE productID IN ($placeholders)");
    $stmt->bind_param(str_repeat('i', count($basket)), ...array_keys($basket));
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $row['quantity'] = $basket[$row['productID']];
        $row['total'] = $row['price'] * $row['quantity'];
        $productDetails[] = $row;
    }

    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basket</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
    <div id="header"></div>
    <div id="sidenav"></div>
    <main>
        <h1>Your Basket</h1>
        <table id="basketTable">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($productDetails)) {
                    foreach ($productDetails as $item) {
                        echo "<tr data-product-id='{$item['productID']}'>";
                        echo "<td>{$item['productName']}</td>";
                        echo "<td>£" . number_format($item['price'], 2) . "</td>";
                        echo "<td>
                                <div class='quantity-control'>
                                    <button class='quantity-btn' data-action='decrease'>-</button>
                                    <input type='text' class='quantity-input' value='{$item['quantity']}' readonly>
                                    <button class='quantity-btn' data-action='increase'>+</button>
                                </div>
                              </td>";
                        echo "<td>£" . number_format($item['total'], 2) . "</td>";
                        echo "<td><button class='remove-item-btn'>Remove</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Your basket is empty.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
<script src="script.js"></script>
</body>

</html>