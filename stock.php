<?php
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

// Handle product update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $productID = $_POST['productID'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $sql = "UPDATE products SET price = ?, quantity = ? WHERE productID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dii", $price, $quantity, $productID);
    $stmt->execute();
}

// Fetch all products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Stock Management</title>
    <link rel="stylesheet" href="CSS/adminstyle.css">
</head>
<body>
    <div id="header"></div>
    <div id="sidenav"></div>
    <div class="content">
        <div class="container">
            <h1 class="dashboard-title">Stock Management</h1>
            <div class="stock-section">
                <h2>Products</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['productID']) ?></td>
                                <td><?= htmlspecialchars($row['productName']) ?></td>
                                <td>
                                    <form method="POST" style="display:flex; gap:10px; align-items:center;">
                                        <input type="hidden" name="productID" value="<?= $row['productID'] ?>">
                                        <input type="number" step="0.01" name="price" value="<?= $row['price'] ?>" required>
                                </td>
                                <td>
                                        <input type="number" name="quantity" value="<?= $row['quantity'] ?>" required>
                                </td>
                                <td>
                                        <button type="submit" name="action" value="update">Update</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="admin.js"></script>
</body>
</html>
