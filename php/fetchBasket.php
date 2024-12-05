<?php
session_start();

// Check if the basket exists in the session
if (!isset($_SESSION['basket'])) {
    $_SESSION['basket'] = []; // Initialize an empty basket if it doesn't exist
    var_dump($_SESSION['basket']);
}

// Send the basket as a JSON response
header('Content-Type: application/json');
echo json_encode($_SESSION['basket']);
?>