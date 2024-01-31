<?php

// Include your Database class
require_once 'connection.php';

class User
{
    private $conn;
    private $id;
    private $address_id;
    private $first_name;
    private $last_name;
    private $username;
    private $password;
    private $phone_number;
    private $email;
    private $roll;

    // Constructor to initialize a new user object
    public function __construct($conn, $id, $address_id, $first_name, $last_name, $username, $password, $phone_number, $email, $roll)
    {
        $this->conn = $conn;
        $this->id = $id;
        $this->address_id = $address_id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->username = $username;
        $this->password = $password;
        $this->phone_number = $phone_number;
        $this->email = $email;
        $this->roll = $roll;
    }

    // Getter methods
    public function getId()
    {
        return $this->id;
    }

    public function getAddressId()
    {
        return $this->address_id;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getRoll()
    {
        return $this->roll;
    }

    // Setter methods
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setAddressId($address_id)
    {
        $this->address_id = $address_id;
    }
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setRoll($roll)
    {
        $this->roll = $roll;
    }

    // Fetch user data from the database
    public function fetchUserDataFromDatabase($id)
    {
        $query = "SELECT * FROM user WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the user data
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // If user not found, return false
        if (!$row) {
            return false;
        }
        // Populate the user object with data from the database
        $this->id = $row['id'];
        $this->address_id = $row['address_id'];
        $this->first_name = $row['first_name'];
        $this->last_name = $row['last_name'];
        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->phone_number = $row['phone_number'];
        $this->email = $row['email'];
        $this->roll = $row['roll'];

        return true;

    }
    // Update the user table
    public function updateUserData($first_name, $last_name, $username, $password, $phone_number, $email, $roll) {
        $query = "UPDATE user SET first_name = :first_name, last_name = :last_name, username = :username, password = :password, phone_number = :phone_number, email = :email, roll = :roll WHERE id = :id";

        // Prepare the statement
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':roll', $roll);
        $stmt->bindParam(':id', $this->id);

        // Execute the query
        $stmt->execute();
    }
}

// Use the Database class
$database = new Database();
$conn = $database->getConnection();

// Creating a new User object
$user = new User($conn, null, null, null, null, null, null, null, null, null);

// Fetch user data from the database based on the user ID (e.g., ID = 1)
$userId = 1;
$user->fetchUserDataFromDatabase($userId);

// Close the database connection when done
$database->closeConnection();
?>