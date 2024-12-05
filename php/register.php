<?php
session_start();

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $confirm_password = $_POST['cpass'];
    $role = "customer";

    if ($password !== $confirm_password) {
        header("Location: ../registerform.php?error=passwords_mismatch");
        exit();
    }

    // Check if the email already exists
    $sql = "SELECT email FROM users WHERE email = ?";
    $try = $conn->prepare($sql);

    if ($try) {
        $try->bind_param("s", $email);
        $try->execute();
        $try->store_result();

        if ($try->num_rows > 0) {
            header("Location: ../registerform.php?error=email_exists");
            exit();
        }
    } else {
        die("Query preparation failed: " . $conn->error);
    }

    // Insert the new user
    $hashedp = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
    $try = $conn->prepare($sql);

    if ($try) {
        $try->bind_param("ssss", $name, $email, $hashedp, $role);
        if ($try->execute()) {
            // Get the user ID of the newly created user
            $userID = $conn->insert_id;

            // Set session variables to log in the user
            $_SESSION['user_id'] = $userID;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;

            // Redirect to dashboard
            header("Location: ../dashboard.php");
            exit();
        } else {
            header("Location: ../registerform.php?error=registration_failed");
            exit();
        }
        $try->close();
    } else {
        die("Query preparation failed: " . $conn->error);
    }
}

$conn->close();
?>
