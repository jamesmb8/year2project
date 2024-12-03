<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
  header("Location: loginform.php");
  exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="CSS/style.css" />
  <title>Dashboard</title>
</head>
<body>
<div id="header"></div>
<div id="sidenav"></div>

  <div class ="main-content">

    <h1>Products</h1>
    <div class="basket-button-container">
    <button id="viewBasketBtn" class="basket-button">View Basket</button>
  </div>
    <table id="producttable" class="producttable">
      <thead>
      <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Add to basket</th>
      </tr>
      </thead>
        <tbody>
          
        </tbody>

    </table>

  </div>
 

<script src="script.js"></script>
</body>
</html>