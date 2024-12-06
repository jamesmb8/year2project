<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: loginform.php");
    exit();
}

if (empty($_SESSION['basket'])) {
    echo "Your basket is empty.";
    exit();
}

$basket = $_SESSION['basket'];


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "InventoryManagement";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}


$conn->begin_transaction();

try {

    $userId = $_SESSION['user_id'];
    $stmt = $conn->prepare("INSERT INTO orders (userID) VALUES (?)");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $orderId = $stmt->insert_id;
    $stmt->close();


    foreach ($basket as $productId => $quantity) {

        $stmt = $conn->prepare("SELECT price FROM products WHERE productID = ?");
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $price = $row['price'];
        } else {
            throw new Exception("Product not found for ID: $productId");
        }
        $stmt->close();

    
        $stmt = $conn->prepare("INSERT INTO orderItems (orderID, productID, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('iiid', $orderId, $productId, $quantity, $price);
        $stmt->execute();
        $stmt->close();


        $stmt = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE productID = ?");
        $stmt->bind_param('ii', $quantity, $productId);
        $stmt->execute();
        $stmt->close();


        $stmt = $conn->prepare("INSERT INTO sales (userID, productID, quantity, price, sale_date) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param('iiid', $userId, $productId, $quantity, $price);
        $stmt->execute();
        $stmt->close();
    }


    $conn->commit();


    unset($_SESSION['basket']);

  
    header("Location: thankyou.php?order_id=$orderId");
    exit();
} catch (Exception $e) {
    $conn->rollback();
    echo "Error processing your order: " . $e->getMessage();
}

$conn->close();
?>
