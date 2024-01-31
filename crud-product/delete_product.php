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

// Handle form submission to delete the product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Execute a SQL DELETE query to delete the product
    try {
        $stmt = $conn->prepare("DELETE FROM product WHERE id = :id");
        $stmt->bindParam(':id', $productId);
        $stmt->execute();

        echo "Product deleted successfully!";
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
    <title>Delete Product</title>
</head>
<body>

<h1>Delete Product</h1>

<?php if ($error): ?>
    <p><?php echo $error; ?></p>
<?php else: ?>
    <!-- Display product details -->
    <p>ID: <?php echo $product->getid(); ?></p>
    <p>Product Name: <?php echo $product->getProductName(); ?></p>
    <p>Description: <?php echo $product->getDescription(); ?></p>
    <p>Quantity: <?php echo $product->getQuantity(); ?></p>
    <p>Price: <?php echo $product->getPrice(); ?></p>

    <!-- Form to confirm product deletion -->
    <form action="delete_product.php?id=<?php echo $productId; ?>" method="post">
        <p>Are you sure you want to delete this product?</p>
        <button type="submit">Delete Product</button>
    </form>
<?php endif; ?>
<!-- Button to the dashboard.php-->
<a href="../dashboard.php">Back to Dashboard</a>

</body>
</html>
