<?php

class Database
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "hardstyleshop";
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//            echo "Connected to the database successfully!";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function closeConnection()
    {
        $this->conn = null;
      // echo "Connection closed!";
    }
}

// Voorbeeld van het gebruik van de Database-klasse
$database = new Database();
$conn = $database->getConnection();

// Voer hier je databasebewerkingen uit

// Sluit de verbinding wanneer je klaar bent
$database->closeConnection();


?>