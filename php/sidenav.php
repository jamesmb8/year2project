<?php
session_start();
$role = $_SESSION['role'] ?? 'customer';
?>
  <link rel="stylesheet" href="../CSS/style.css" />
<div class="sidenav" id="sidenav">

    <a href="dashboard.php">Home</a>
    <a href="account.php">Account</a>
    <a id="AboutUs" href="about.php">About Us</a>
   
    

</div>

