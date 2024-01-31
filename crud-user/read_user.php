<?php

require_once '../connection.php';
require_once '../user.php';
require_once '../address.php';

// Make connection with the Database class
$database = new Database();
$conn = $database->getConnection();

// basic code
// Initialize variables for user and address data
$id = $_GET['id'] ?? null;

// Read operation: Fetch the user with the specified ID
$stmt = $conn->prepare("SELECT * FROM user WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

// Check for errors in the user query
if (!$stmt) {
    die('Error in user query: ' . print_r($conn->errorInfo(), true));
}

$user = $stmt->fetch(PDO::FETCH_ASSOC);
$address = $user["address_id"];

// Read operation: Fetch the address for the specified user ID
$stmt = $conn->prepare("SELECT * FROM address WHERE id = :id");
$stmt->bindParam(':id', $address, PDO::PARAM_INT);
$stmt->execute();

// Check for errors in the address query
if (!$stmt) {
    die('Error in address query: ' . print_r($conn->errorInfo(), true));
}
$address = $stmt->fetch(PDO::FETCH_ASSOC);

/* medium code // Read operation: Fetch the user with the specified ID and their address
$stmt = $conn->prepare("SELECT user.*, address.*
                       FROM user
                       LEFT JOIN address ON user.address_id = address.id
                       WHERE user.id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);*/

// Close the database connection when done
$database->closeConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
</head>
<body>
    <h1>User Information</h1>

    <!-- Display user details in a form -->
    <h3>User Details</h3>
    <?php echo "ID: " . $user['id']. "<br>"; ?>
    <?php echo "First Name: " . $user['first_name']. "<br>"; ?>
    <?php echo "Last Name: " . $user['last_name']. "<br>"; ?>
    <?php echo "Username: " . $user['username']. "<br>"; ?>
    <?php echo "Phone Number: " . $user['phone_number']. "<br>"; ?>
    <?php echo "Email: " . $user['email']. "<br>"; ?>
    <?php echo "Roll: " . $user['roll']. "<br>". "<br>"; ?>

    <!-- Display address details in a form -->
    <h3>Address Details</h3>
    <?php echo "Street Name: " . $address['street_name']. "<br>"; ?>
    <?php echo "House Number: " . $address['house_number']. "<br>"; ?>
    <?php echo "Postal Code: " . $address['postal_code']. "<br>"; ?>
    <?php echo "City: " . $address['city']. "<br>". "<br>"; ?>

    <!-- Button to the dashboard.php-->
    <span class="right"><a href="../dashboard.php" class="text-red" style="text-decoration: none;">Back to Dashboard</a></span>

</body>
</html>
