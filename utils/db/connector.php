<?php

error_reporting(E_ALL); // Set error reporting to display all types of errors

class DBConnection
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "tinkerpro";

    protected function connect()
    {
        try {
            date_default_timezone_set('Asia/Manila');
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db;
            $pdo = new PDO($dsn, $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo '<img src="./assets/icons/db-offline.jpg" style="width: 20px; margin-bottom: 3px"> Offline';
            // Output the error message for debugging
            echo 'Error: ' . $e->getMessage();
        }
    }

}

?>