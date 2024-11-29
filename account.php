<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  // Redirect to login page if not logged in
  header("Location: login.html");
  exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "InventoryManagement";

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT name, email FROM users WHERE userID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email);
$stmt->fetch();
$stmt->close();

// Handle password update
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
  <title>Home page</title>
</head>

<body>
  <div id="header"></div>
  <div id="sidenav"></div>
  <div class="account-container">
    <h2>Your Account</h2>
    <form method="POST" action="account.php">
      <label for="name">Company Name:</label>
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

    <?php if ($password_message): ?>
      <p style="color: red;"><?php echo htmlspecialchars($password_message); ?></p>
    <?php endif; ?>
  </div>


  <a href="php/logout.php">Logout</a>
  <script src="script.js"></script>
</body>

</html>