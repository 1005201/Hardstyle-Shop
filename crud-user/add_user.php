<?php

require_once '../connection.php';
require_once '../user.php';
require_once '../address.php';

// Make connection with Database class
$database = new Database();
$conn = $database->getConnection();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Obtain data from the form
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $username = $_POST['username'];
        // Hash the password
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $phone_number = $_POST['phone_number'];
        $email = $_POST['email'];
        $roll = $_POST['roll'];

        // Obtain data from the form for address
        $street_name = $_POST['street_name'];
        $house_number = $_POST['house_number'];
        $postal_code = $_POST['postal_code'];
        $city = $_POST['city'];

        // Insert address
        $address = new address($conn, null, $street_name, $house_number, $postal_code, $city);
        $address->insertAddress();
        $address_id = $address->getId();

        // Prepare the SQL query
        $stmt = $conn->prepare("INSERT INTO user (first_name, last_name, username, password, phone_number, email, roll, address_id) VALUES (:first_name, :last_name, :username, :password, :phone_number, :email, :roll, :address_id)");

        // Bind parameters
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':roll', $roll);
        $stmt->bindParam(':address_id', $address_id);

        // Execute the query
        $stmt->execute();

        echo "User added successfully!";
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
    <title>User List</title>
</head>
<body>

<!-- Form to add a new user -->
<h2>Add New User</h2>
<form action="add_user.php" method="post">
    <label for="first_name">First Name:</label>
    <input type="text" id="first_name" name="first_name" required>
    <br>
    <label for="last_name">Last Name:</label>
    <input type="text" id="last_name" name="last_name" required>
    <br>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <label for="phone_number">Phone Number:</label>
    <input type="tel" id="phone_number" name="phone_number" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="roll">Roll:</label>
    <input type="text" id="roll" name="roll" required>
    <br>
    <label for="street_name">Street Name:</label>
    <input type="text" id="street_name" name="street_name" required>
    <br>
    <label for="house_number">House Number:</label>
    <input type="text" id="house_number" name="house_number" required>
    <br>
    <label for="postal_code">Postal Code:</label>
    <input type="text" id="postal_code" name="postal_code" required>
    <br>
    <label for="city">City:</label>
    <input type="text" id="city" name="city" required>
    <br>
    <button type="submit">Add User</button>
    <!-- Button to the dashboard.php-->
    <span class="right"><a href="../dashboard.php" class="text-red" style="text-decoration: none;">Back to Dashboard</a></span>
</form>
</body>
</html>
