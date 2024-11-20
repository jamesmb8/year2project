<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'manager'])) {
  header("Location: login.html");
  exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
      <link rel="stylesheet" href="CSS/style.css" />
</head>
<body>
<div id="header"></div>
<div id="adminsidenav"></div>

<a href="php/logout.php">Logout</a>


<script src="script.js"></script>
   
</body>
</html>