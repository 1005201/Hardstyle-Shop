<?php

class address
{
    private $conn;
    private $id;
    private $street_name;
    private $house_number;
    private $postal_code;
    private $city;

    public function __construct($conn, $id, $street_name, $house_number, $postal_code, $city)
    {
        $this->conn = $conn;
        $this->id = $id;
        $this->street_name = $street_name;
        $this->house_number = $house_number;
        $this->postal_code = $postal_code;
        $this->city = $city;
    }

    public function insertAddress()
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO address (street_name, house_number, postal_code, city) VALUES (:street_name, :house_number, :postal_code, :city)");

            $stmt->bindParam(':street_name', $this->street_name);
            $stmt->bindParam(':house_number', $this->house_number);
            $stmt->bindParam(':postal_code', $this->postal_code);
            $stmt->bindParam(':city', $this->city);

            $stmt->execute();

            $this->id = $this->conn->lastInsertId();  // Get the ID of the newly inserted address

            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }
    public function getStreetName()
    {
        return $this->street_name;
    }
    public function getHouseNumber()
    {
        return $this->house_number;
    }

    public function getPostalCode()
    {
        return $this->postal_code;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function fetchAddressDataFromDatabase($addressId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM address WHERE id = :id");
            $stmt->bindParam(':id', $addressId);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                // If the address is found, set the properties with the data from the database
                $this->id = $result['id'];
                $this->street_name = $result['street_name'];
                $this->house_number = $result['house_number'];
                $this->postal_code = $result['postal_code'];
                $this->city = $result['city'];

                return true;
            } else {
                return false;  // Address not found
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function updateAddressData($street_name, $house_number, $postal_code, $city)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE address SET street_name = :street_name, house_number = :house_number, postal_code = :postal_code, city = :city WHERE id = :id");

            $stmt->bindParam(':street_name', $street_name);
            $stmt->bindParam(':house_number', $house_number);
            $stmt->bindParam(':postal_code', $postal_code);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':id', $this->id);

            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}