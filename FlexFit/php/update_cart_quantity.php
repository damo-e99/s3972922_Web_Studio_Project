<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];


    $cartData = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];

    if (array_key_exists($productId, $cartData) && $quantity >= 1) {
        $cartData[$productId] = $quantity;

        setcookie('cart', json_encode($cartData), time() + 3600, '/');

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Invalid product ID or quantity']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}?>