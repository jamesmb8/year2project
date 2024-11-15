<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "Hallam123@";
$dbname = "InventoryManagement";

$conn = new mysqli($servername, $username, $password, $dbname);



$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    
    $email = $_POST['email'];
    $password = $_POST['pass'];
   


        $sql = "SELECT userID, password, role from users WHERE email= ?";
        $try = $conn->prepare($sql);
        $try->bind_param("s", $email);
        $try->execute();
        $try->store_result();

        if ($try->num_rows > 0) 
        {
        $try->bind_result($id, $hashedp, $role);
        $try->fetch();
            if (password_verify($password, $hashedp)) 
            {
            $_SESSION['user_id'] = $id;
            $_SESSION['role'] = $role;
            

            if ($role === 'admin') 
            {
            header("Location: ../admindash.html");
            } elseif ($role === 'manager')
            {
            header("Location: ../admindash.html");
            } elseif ($role === 'customer')
            {
            header("Location: ../dashboard.html");
            }
            exit();
        } else {
            $error = "Incorrect Password, try again";
        }

        } else {
        $error = "Incorrect Email, try again";
        }

       


       
      
        exit();
}
$try->close();
$conn->close();


?>