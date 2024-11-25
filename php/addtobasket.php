<?php
session_start();
header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

// Retrieve posted data
$data = json_decode(file_get_contents('php://input'), true);
$productId = $data['productId'] ?? null;
$quantity = $data['quantity'] ?? null;

if (!$productId || !$quantity) {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    exit();
}

// Initialize basket if not already set
if (!isset($_SESSION['basket'])) {
    $_SESSION['basket'] = [];
}

// Update basket
if (isset($_SESSION['basket'][$productId])) {
    $_SESSION['basket'][$productId] += $quantity;
} else {
    $_SESSION['basket'][$productId] = $quantity;
}

echo json_encode(['success' => true, 'message' => 'Product added to basket.']);
