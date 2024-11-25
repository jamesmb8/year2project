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

// Debug database connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<pre>";
    print_r($_POST); // Debug POST data
    echo "</pre>";

    $email = $_POST['email'] ?? '';
    $password = $_POST['pass'] ?? '';

    if (empty($email) || empty($password)) {
        die("Email or password is missing.");
    }

    $sql = "SELECT userID, password, role FROM users WHERE email = ?";
    $try = $conn->prepare($sql);

    if (!$try) {
        die("Preparation failed: " . $conn->error);
    }

    $try->bind_param("s", $email);

    if (!$try->execute()) {
        die("Database query failed: " . $try->error);
    }

    $try->store_result();

    if ($try->num_rows > 0) {
        $try->bind_result($id, $hashedp, $role);
        $try->fetch();

        if (password_verify($password, $hashedp)) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $id;
            $_SESSION['role'] = $role;

            // Debug headers
            if (headers_sent($file, $line)) {
                die("Headers already sent in $file on line $line");
            }

            if ($role === 'admin' || $role === 'manager') {
                header("Location: ../admindash.php");
            } elseif ($role === 'customer') {
                header("Location: ../dashboard.php");
            }
            exit();
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