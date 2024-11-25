<?php
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
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $confirm_password = $_POST['cpass'];
    $role = "customer";

    // Check if passwords match
    if ($password !== $confirm_password) {
        // Redirect with an error message
        header("Location: ../register.html?error=passwords_mismatch");
        exit();
    }

    // Hash the password
    $hashedp = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
    $try = $conn->prepare($sql);

    if ($try) {
        $try->bind_param("ssss", $name, $email, $hashedp, $role);

        if ($try->execute()) {
            // Automatically log in the new user
            $user_id = $conn->insert_id; // Get the last inserted ID
            $_SESSION['user_id'] = $user_id;
            $_SESSION['role'] = $role;

            // Redirect to the dashboard
            header("Location: ../dashboard.php");
            exit();
        } else {
            // Registration failed
            header("Location: ../register.html?error=registration_failed");
            exit();
        }
        $try->close();
    } else {
        die("Query preparation failed: " . $conn->error);
    }
}

$conn->close();
?>


