<?php

require_once 'connection.php';
require_once 'product.php';
require_once 'user.php';
require_once 'address.php';

// Make connection with the Database class
$database = new Database();
$conn = $database->getConnection();

// Read operation: Fetch all products
$stmt = $conn->query("SELECT * FROM product");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Read operation: Fetch all users
$stmt = $conn->query("SELECT * FROM user");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close the database connection when done
$database->closeConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
<h1>Dashboard</h1>

<!-- Button to navigate to the cart page -->
<a href="cart/cart.php">Shopping cart</a>

<h2>Product List</h2>

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
            <td><?php echo '€ ' . $product['price']; ?></td>
            <td>
                <a href="crud-product/edit_product.php?id=<?php echo $product['id']; ?>">Edit</a>
                | <a href="crud-product/delete_product.php?id=<?php echo $product['id']; ?>">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- Button to navigate to the Add Product page -->
<a href="crud-product/add_product.php">Add New Product</a>

<h2>User List</h2>

<!-- Table to display product details -->
<table border="1">
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Username</th>
        <th>Phone Number</th>
        <th>E-mail</th>
        <th>Roll</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['first_name']; ?></td>
            <td><?php echo $user['last_name']; ?></td>
            <td><?php echo $user['username']; ?></td>
            <td><?php echo $user['phone_number']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['roll']; ?></td>
            <td>
                <a href="crud-user/read_user.php?id=<?php echo $user['id']; ?>">Info</a>
                | <a href="crud-user/edit_user.php?id=<?php echo $user['id']; ?>">Edit</a>
                | <a href="crud-user/delete_user.php?id=<?php echo $user['id']; ?>">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- Button to navigate to the Add Product page -->
<a href="crud-user/add_user.php">Add New User</a>

</body>
</html>
