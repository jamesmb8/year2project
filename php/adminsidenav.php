<?php
session_start();
$role = $_SESSION['role'];
?>
<link rel="stylesheet" href="../style.css" />
<div class="adminsidenav" id="adminsidenav">
    <?php if ($role == "customer"): ?>
        <a href="dashboard.html">Home</a>
        <a href="account.html">Account</a>
    <?php elseif ($role == "manager"): ?>
        <a href="dashboard.html">Home</a>
        <a href="account.html">Account</a>
        <a href="reports.html">Reports</a>
    <?php elseif ($role == "admin"): ?>
        <a href="dashboard.html">Home</a>
        <a href="account.html">Account</a>
        <a href="reports.html">Reports</a>
        <a href="stock.html">Stock</a>
    <?php endif; ?>
</div>