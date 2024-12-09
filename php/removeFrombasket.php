<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $productId = $input['productId'];

    if (!isset($_SESSION['basket'][$productId])) {
        echo json_encode(['success' => false, 'message' => 'Item not in basket']);
        exit();
    }

    unset($_SESSION['basket'][$productId]);

    echo json_encode(['success' => true, 'message' => 'Item removed']);
}
?>