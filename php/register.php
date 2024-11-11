<?php   

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "Hallam123@";
$dbname = "InventoryManagement";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Failed");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $confirm_password = $_POST['cpass'];

    if ($password !== $confirm_password) {
        die("Passwords don't match");
    }


$hashedp = password_hash($password, PASSWORD_DEFAULT);
echo "Name: $name, Email: $email, HashedP: $hashedp <br>";
$sql = "INSERT INTO users (name, email, password) VALUES (?,?,?)";
$try = $conn->prepare($sql);

$try->bind_param("sss", $name, $email, $hashedp);
$try->execute();

$try->close();
}
$conn->close();

?>