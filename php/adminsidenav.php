<?php
session_start();
$role = $_SESSION['role'];
?>
<link rel="stylesheet" href="../CSS/style.css" />
<div class="sidenav" id="adminsidenav">

    <?php if ($role == "customer"): ?>
        <a href="dashboard.html">Home</a>
        <a href="account.html">Account</a>
    <?php elseif ($role == "manager"): ?>
        <a href="admindash.html">Home</a>
        <a href="adminaccount.html">Account</a>
        <a href="reports.html">Reports</a>
    <?php elseif ($role == "admin"): ?>
        <a href="admindash.php">Home</a>
        <a href="adminaccount.php">Account</a>
        <a href="reports.php">Reports</a>
        <a href="stock.php">Stock</a>
    <?php endif; ?>
</div>