<?php
session_start();


if (!isset($_SESSION['basket'])) {
    $_SESSION['basket'] = []; 
    var_dump($_SESSION['basket']);
}


header('Content-Type: application/json');
echo json_encode($_SESSION['basket']);
?>