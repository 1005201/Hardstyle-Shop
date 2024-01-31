<?php

// Include your Database class
require_once 'connection.php';

class product
{
    private $id;
    private $product_name;
    private $description;
    private $quantity;
    private $price;
    private $conn;

    // Constructor to initialize a new product object
    public function __construct($conn, $product_id, $product_name, $description, $quantity, $price) {
        $this->conn = $conn;
        $this->id = $product_id;
        $this->product_name = $product_name;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    // Add similar getters and setters for other properties: $product_name, $description, $quantity, $price
    // Getter methods
    public function getId()
    {
        return $this->id;
    }

    public function getProductName()
    {
        return $this->product_name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getPrice()
    {
        return $this->price;
    }

    // Setter method to set the product name
    public function setProductName($product_name)
    {
        $this->product_name = $product_name;
    }
    // Example method to calculate the total value of the product
    public function getTotalValue()
    {
        return $this->quantity * $this->price;
    }

    // Example method to fetch product data from the database based on the product ID
    public function fetchProductDataFromDatabase($productId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM product WHERE id = :id");
            $stmt->bindParam(':id', $productId);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                // If the product is found, set the properties with the data from the database
                $this->id = $result['id'];
                $this->product_name = $result['product_name'];
                $this->description = $result['description'];
                $this->quantity = $result['quantity'];
                $this->price = $result['price'];

                return true;
            } else {
                return false;  // Product not found
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}

// Use the Database class
$database = new Database();
$conn = $database->getConnection();

// Creating a new Product object
$product = new product($conn, null, null, null, null, null);

// Fetch product data from the database based on the product ID (e.g., ID = 1)
$productId = 1;
$product->fetchProductDataFromDatabase($productId);

// Close the database connection when done
$database->closeConnection();
