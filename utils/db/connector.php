<?php

  class DBConnection {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "tinkerpro";

    protected function connect() {
      try {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db;
        $pdo = new PDO($dsn, $this->user, $this->pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
      } catch(PDOException $e) {
        echo '<img src="./assets/icons/db-offline.jpg" style="width: 20px; margin-bottom: 3px"> Offline';
      }
    }

  }

?>