<?php

require_once 'product.php';
require_once 'connection.php';

// Make connention with the Database class
$database = new Database();
$conn = $database->getConnection();

// Read operation: Fetch all products
$stmt = $conn->query("SELECT * FROM product");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

<h1>Product List</h1>

<!-- Table to display product details -->
<table border="1">
    <tr>
        <th>ID</th>
        <th>Product Name</th>
        <th>Description</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><?php echo $product['id']; ?></td>
            <td><?php echo $product['product_name']; ?></td>
            <td><?php echo $product['description']; ?></td>
            <td><?php echo $product['quantity']; ?></td>
            <td><?php echo $product['price']; ?></td>
            <td>
                <a href="crud-product/edit_product.php?id=<?php echo $product['id']; ?>">Edit</a>
                | <a href="crud-product/delete_product.php?id=<?php echo $product['id']; ?>">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- Button to navigate to the Add Product page -->
<a href="crud-product/add_product.php">Add New Product</a>

</body>
</html>
