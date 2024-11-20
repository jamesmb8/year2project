<?php
session_start();
$role = $_SESSION['role'] ?? 'customer';
?>
  <link rel="stylesheet" href="../style.css" />
<div class="sidenav" id="sidenav">

    <a href="dashboard.html">Home</a>
    <a href="account.html">Account</a>
   
    

</div>

