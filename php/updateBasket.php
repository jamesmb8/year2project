<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $productId = $input['productId'];
    $quantity = $input['quantity'];

    if (!isset($_SESSION['basket'][$productId])) {
        echo json_encode(['success' => false, 'message' => 'Item not in basket']);
        exit();
    }

    // Update item quantity
    $_SESSION['basket'][$productId] = $quantity;

    // Fetch price from the database for updated total
    $servername = "localhost";
    $username = "root";
    $password = "Hallam123@";
    $dbname = "InventoryManagement";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT price FROM products WHERE productID = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $stmt->bind_result($price);
    $stmt->fetch();
    $stmt->close();
    $conn->close();

    $newTotal = $price * $quantity;

    echo json_encode(['success' => true, 'newTotal' => $newTotal]);
}
?>