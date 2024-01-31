<?php

require_once '../connection.php';
require_once '../product.php';
// Start the session
session_start();

// Make connection with the Database
$database = new Database();
$conn = $database->getConnection();

// Add product to the shopping cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Fetch product information from the database
    $stmt = $conn->prepare("SELECT * FROM product WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        // Check if there is enough stock
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Create a Product object using the fetched data
            $product = new Product($conn, $row['id'], $row['product_name'], $row['description'], $row['quantity'], $row['price']);

            // Check if there is enough stock
            if ($quantity > 0 && $quantity <= $product->getQuantity()) {
                // Add product to the shopping cart
                $_SESSION['cart'][$product_id]['product_name'] = $product->getProductName();
                $_SESSION['cart'][$product_id]['price'] = $product->getPrice();
                $_SESSION['cart'][$product_id]['quantity'] += $quantity;

                // Decrease stock in the database using prepared statements
                $new_stock = $product->getQuantity() - $quantity;
                $stmt = $conn->prepare("UPDATE product SET quantity = ? WHERE id = ?");
                $stmt->bind_param("ii", $new_stock, $product_id);
                $stmt->execute();
            } else {
                echo "Invalid quantity or not enough stock available.";
            }

        } else {
            echo "Product not found in the database.";
        }
    } else {
        error_log("Error executing the database query: " . $conn->error);
        echo "An error occurred. Please try again later.";
    }
}

// Show the shopping cart
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    echo "<h2>Shopping Cart</h2>";
    foreach ($_SESSION['cart'] as $product_id => $product) {
        // Check if the keys 'product_name' and 'price' exist before accessing them
        if (isset($product['product_name']) && isset($product['price'])) {
            echo "<p>{$product['product_name']} - Price: {$product['price']} - Quantity: {$product['quantity']}</p>";
        } else {
            echo "<p>Invalid product information in the shopping cart for product ID: $product_id.</p>";
        }
    }
} else {
    echo "<p>Shopping Cart is empty.</p>";
}


// Close the database connection
$database->closeConnection();

// Output debugging information
echo "<pre>";
var_dump($result->fetch_assoc());  // Output the fetched product information for debugging
echo "</pre>";


?>