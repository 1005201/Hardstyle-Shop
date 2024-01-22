<?php

require_once 'product.php';
require_once 'connection.php';

// Make connection with Database class
$database = new Database();
$conn = $database->getConnection();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Obtain data from the form
        $product_name = $_POST['product_name'];
        $description = $_POST['description'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];

        // Prepare the SQL query
        $stmt = $conn->prepare("INSERT INTO product (product_name, description, quantity, price) VALUES (:product_name, :description, :quantity, :price)");

        // Bind parameters
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);

        // Execute the query
        $stmt->execute();

        echo "Product added successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Close the database connection when done
$database->closeConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
</head>
<body>

<!-- Form to add a new product -->
<h2>Add New Product</h2>
<form action="add_product.php" method="post">
    <label for="product_name">Product Name:</label>
    <input type="text" id="product_name" name="product_name" required>
    <br>
    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea>
    <br>
    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" required>
    <br>
    <label for="price">Price:</label>
    <input type="number" id="price" name="price" step="0.01" required>
    <br>
    <button type="submit">Add Product</button>
</form>
<!-- Button to the product_list.php-->
<a href="product_list.php">Back to Product List</a>
</body>
</html>