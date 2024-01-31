<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../connection.php';
require_once '../user.php';
require_once '../address.php';

// Make connection with Database class
$database = new Database();
$conn = $database->getConnection();

// Initialize variables for user and address data
$id = $_GET['id'] ?? null;
//echo "User ID: $id";

$user = new User($conn, $id, null, null, null, null, null, null, null, null);
// Debugging
//var_dump($user);

// Fetch existing user data from the database
if (!$user->fetchUserDataFromDatabase($id)) {
    // Debugging
    //$query = "SELECT * FROM user WHERE id = $id";
    //echo "SQL Query: $query";

    echo "Error: User not found!";
    exit;
}

$address_id = $user->getAddressId();

$address = new Address($conn, $address_id, null, null, null, null);

// Fetch existing address data from the database
if (!$address->fetchAddressDataFromDatabase($address_id)) {
    echo "Error: Address not found!";
    exit;
}


// Handle form submission for user update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Obtain data from the form
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $username = $_POST['username'];
        // Hash the password if provided
        $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : $user->getPassword();

        $phone_number = $_POST['phone_number'];
        $email = $_POST['email'];
        $roll = $_POST['roll'];

        // Obtain data from the form for address
        $street_name = $_POST['street_name'];
        $house_number = $_POST['house_number'];
        $postal_code = $_POST['postal_code'];
        $city = $_POST['city'];

        // Update address data
        $address->updateAddressData($street_name, $house_number, $postal_code, $city);

        // Update user data
        $user->updateUserData($first_name, $last_name, $username, $password, $phone_number, $email, $roll);

        echo "User updated successfully!";
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
    <title>Edit User</title>
</head>
<body>

<!-- Form to edit an existing user -->
<h2>Edit User</h2>
<form action="edit_user.php?id=<?php echo $id; ?>" method="post">
    <!-- Display existing user data in the form -->
    <label for="first_name">First Name:</label>
    <input type="text" id="first_name" name="first_name" value="<?php echo $user->getFirstName(); ?>" required>
    <br>
    <label for="last_name">Last Name:</label>
    <input type="text" id="last_name" name="last_name" value="<?php echo $user->getLastName(); ?>" required>
    <br>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="<?php echo $user->getUsername(); ?>" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" value="<?php echo $user->getPassword(); ?>" required>
    <br>
    <label for="phone_number">Phone Number:</label>
    <input type="tel" id="phone_number" name="phone_number" value="<?php echo $user->getPhoneNumber(); ?>" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo $user->getEmail(); ?>" required>
    <br>
    <label for="roll">Roll:</label>
    <input type="text" id="roll" name="roll" value="<?php echo $user->getRoll(); ?>" required>
    <br>

    <!-- Display existing address data in the form -->
    <label for="street_name">Street Name:</label>
    <input type="text" id="street_name" name="street_name" value="<?php echo $address->getStreetName(); ?>" required>
    <br>
    <label for="house_number">House Number:</label>
    <input type="text" id="house_number" name="house_number" value="<?php echo $address->getHouseNumber(); ?>" required>
    <br>
    <label for="postal_code">Postal Code:</label>
    <input type="text" id="postal_code" name="postal_code" value="<?php echo $address->getPostalCode(); ?>" required>
    <br>
    <label for="city">City:</label>
    <input type="text" id="city" name="city" value="<?php echo $address->getCity(); ?>" required>
    <br>

    <button type="submit">Update User</button>
    <!-- Button to the dashboard.php -->
    <span class="right"><a href="../dashboard.php" class="text-red" style="text-decoration: none;">Back to Dashboard</a></span>
</form>
</body>
</html>
