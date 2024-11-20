<?php
ob_start();
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "Hallam123@";
$dbname = "InventoryManagement";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['pass'] ?? '';

    $sql = "SELECT userID, password, role FROM users WHERE email = ?";
    $try = $conn->prepare($sql);
    $try->bind_param("s", $email);
    $try->execute();
    $try->store_result();

    if ($try->num_rows > 0) {
        $try->bind_result($id, $hashedp, $role);
        $try->fetch();

        if (password_verify($password, $hashedp)) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $id;
            $_SESSION['role'] = $role;

            if ($role === 'admin' || $role === 'manager') {
                header("Location: ../admindash.php");
            } elseif ($role === 'customer') {
                header("Location: ../dashboard.php");
            }
            exit(); // Stops further script execution
        } else {
            $error = "Incorrect password. Please try again.";
        }
    } else {
        $error = "No account found with this email. Please try again.";
    }

    $try->close();
}

$conn->close();
?>