<?php

require_once '../product.php';
require_once '../connection.php';

// Make connection with the Database class
$database = new Database();
$conn = $database->getConnection();

// Initialize variables
$product = new Product($conn, null, null, null, null, null);
$error = "";

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Fetch product data from the database based on the product ID
    if (!$product->fetchProductDataFromDatabase($productId)) {
        $error = "Product not found";
    }
} else {
    $error = "Product ID not provided";
}

// Handle form submission to update the product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are submitted
    if (isset($_POST['product_name']) && isset($_POST['description']) && isset($_POST['quantity']) && isset($_POST['price'])) {
        // Retrieve submitted data
        $newProductName = $_POST['product_name'];
        $newDescription = $_POST['description'];
        $newQuantity = $_POST['quantity'];
        $newPrice = $_POST['price'];

        // Perform validations if necessary

        // Execute a SQL UPDATE query to update the product
        try {
            $stmt = $conn->prepare("UPDATE product SET product_name = :product_name, description = :description, quantity = :quantity, price = :price WHERE id = :id");
            $stmt->bindParam(':product_name', $newProductName);
            $stmt->bindParam(':description', $newDescription);
            $stmt->bindParam(':quantity', $newQuantity);
            $stmt->bindParam(':price', $newPrice);
            $stmt->bindParam(':id', $productId);
            $stmt->execute();

            echo "Product updated successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "All fields are required.";
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
    <title>Edit Product</title>
</head>
<body>

<h1>Edit Product</h1>

<?php if ($error): ?>
    <p><?php echo $error; ?></p>
<?php else: ?>
    <!-- Form to edit the existing product -->
    <form action="edit_product.php?id=<?php echo $productId; ?>" method="post">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" value="<?php echo $product->getProductName(); ?>" required>
        <br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo $product->getDescription(); ?></textarea>
        <br>
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" value="<?php echo $product->getQuantity(); ?>" required>
        <br>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" value="<?php echo $product->getPrice(); ?>" required>
        <br>
        <button type="submit">Update Product</button>
    </form>
<?php endif; ?>
<!-- Button to the dashboard.php-->
<a href="../dashboard.php">Back to Dashboard</a>

</body>
</html>

