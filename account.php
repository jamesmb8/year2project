<?php
session_start();

if (!isset($_SESSION['user_id'])) {

  header("Location: loginform.php");
  exit();
}

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

$user_id = $_SESSION['user_id'];


$sql = "SELECT name, email FROM users WHERE userID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email);
$stmt->fetch();
$stmt->close();


$order_sql = "
    SELECT o.orderID, p.productName, oi.quantity, oi.price 
    FROM orders o
    JOIN orderItems oi ON o.orderID = oi.orderID
    JOIN products p ON oi.productID = p.productID
    WHERE o.userID = ?
    ORDER BY o.orderID DESC
";
$order_stmt = $conn->prepare($order_sql);
$order_stmt->bind_param("i", $user_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();


$password_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_password'])) {
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];

  if ($new_password === $confirm_password) {
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $update_sql = "UPDATE users SET password = ? WHERE userID = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $hashed_password, $user_id);

    if ($update_stmt->execute()) {
      $password_message = "Password updated successfully!";
    } else {
      $password_message = "Error updating password.";
    }

    $update_stmt->close();
  } else {
    $password_message = "Passwords do not match. Please try again.";
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="CSS/style.css" />
  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
  <title>Your Account</title>
</head>

<body>
  <div id="header"></div>
  <div id="sidenav"></div>
  <div class="account-container">
    <h2>Your Account</h2>
    <form method="POST" action="account.php">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" readonly><br>

      <label for="email">Email:</label>
      <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly><br>

      <h3>Update Password</h3>
      <label for="new_password">New Password:</label>
      <input type="password" id="new_password" name="new_password" required><br>

      <label for="confirm_password">Confirm Password:</label>
      <input type="password" id="confirm_password" name="confirm_password" required><br>

      <input type="submit" name="update_password" value="Update Password">
    </form>
</div>

    <?php if ($password_message): ?>
      <p style="color: red;"><?php echo htmlspecialchars($password_message); ?></p>
    <?php endif; ?>

    <h3>Your Past Orders</h3>
    <?php if ($order_result->num_rows > 0): ?>
      <table>
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $order_result->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['orderID']); ?></td>
              <td><?php echo htmlspecialchars($row['productName']); ?></td>
              <td><?php echo htmlspecialchars($row['quantity']); ?></td>
              <td>£<?php echo htmlspecialchars(number_format($row['price'], 2)); ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>You have no past orders.</p>
    <?php endif; ?>
  </div>
<div class="bottom">
  <a href="php/logout.php"id="logout">Logout</a>
    </div>
  <script src="script.js"></script>
</body>

</html>
