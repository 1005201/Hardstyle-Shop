<?php
error_reporting(E_ALL);
require_once 'connection.php';

// Start the session
session_start();

// Make connection with the Database
$database = new Database();
$conn = $database->getConnection();

// Fetch all products from the database
$sql = "SELECT * FROM product";
$stmt = $conn->query($sql);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if there are products
if (count($result) > 0) {
    foreach ($result as $row) {
        // Display product information
        echo "<div>";
        echo "<h3>{$row['product_name']}</h3>";

        // Display the image using the direct URL or path
        echo "<img src='directe_URL_naar_afbeelding' alt='{$row['product_name']}' style='width: 101px;'>";

        // The quantity is here extra, is not needed here, but for now it can
        echo "<p>Price: {$row['price']} - Quantity: {$row['quantity']}</p>";

        // Display form to add product to the shopping cart
        echo "<form method='post' action='cart/add_cart.php'>";
        echo "<input type='hidden' name='product_id' value='{$row['id']}'>";
        echo "Quantity: <input type='number' name='quantity' value='1' min='1' max='{$row['quantity']}'>";
        echo "<input type='submit' name='add_to_cart' value='Add to Cart'>";
        echo "</form>";

        echo "</div>";
    }
} else {
    echo "No products found.";
}

// Close the database connection
$database->closeConnection();
?>
