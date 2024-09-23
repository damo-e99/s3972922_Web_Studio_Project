<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SESSION['authenticated']) {
        $userId = $_SESSION['authenticated_user']['id'];


        if (isset($_SESSION['cart'][$userId]) && !empty($_SESSION['cart'][$userId]) && isset($_POST['product_id'])) {
            $productId = $_POST['product_id'];

            if (isset($_SESSION['cart'][$userId][$productId])) {
                unset($_SESSION['cart'][$userId][$productId]);
                $_SESSION['message'] = 'Product removed from your cart.';
            } else {
                $_SESSION['message'] = 'Product not found in your cart.';
            }
        } else {
            $_SESSION['message'] = 'Invalid request. Please try again.';
        }

        if (isset($_POST['clear_cart'])) {
        if ($_SESSION['authenticated']) {
            $userId = $_SESSION['authenticated_user']['id'];
            unset($_SESSION['cart'][$userId]);
        }
}
    } 
    else {
        $_SESSION['message'] = 'Please log in to remove items from your cart.';
    }

    header('Location: cart.php'); 
} else {
    $_SESSION['message'] = 'Invalid request. Please try again.';
    header('Location: cart.php');
}

?>
