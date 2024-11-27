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
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['pass'] ?? '';

    if (empty($email) || empty($password)) {
        header("Location: ../login.html?error=empty_fields");
        exit();
    }

    $sql = "SELECT userID, password, role FROM users WHERE email = ?";
    $try = $conn->prepare($sql);

    if (!$try) {
        die("Query preparation failed: " . $conn->error);
    }

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
            exit();
        } else {
            header("Location: ../login.html?error=incorrect_password");
            exit();
        }
    } else {
        header("Location: ../login.html?error=email_not_found");
        exit();
    }

    $try->close();
}

$conn->close();
?>