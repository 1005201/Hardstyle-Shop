<?php

// Start the session
session_start();

// Check if product_id and quantity are set
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check if quantity is valid
    if ($quantity > 0) {
        // Add the product to the shopping cart
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;

        // Redirect to the main page
        header("Location: cart.php");
        exit();
    }
}

// If no valid data, go back to the main page
header("Location: ../webshop.php");
exit();

