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
} else {
    echo ("Successfull");
}


if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    
    $email = $_POST['email'];
    $password = $_POST['pass'];
   


        $sql = "SELECT userID, password, role from users WHERE email= ?";
        $try = $conn->prepare($sql);
        $try->bind_param("s", $email);
        $try->execute();
        $try->store_result();
        $try->bind_result($id, $hashed_password, $role);
        $try->fetch();


        $_SESSION['user_id'] = $id;
        $_SESSION['role'] = $role;
        header("../dashboard.html");
        exit();
}
$try->close();
$conn->close();


?>