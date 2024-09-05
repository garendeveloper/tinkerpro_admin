<?php

  class Employee_facade extends DBConnection {

    public function fetchEmployee() {
      $sql = $this->connect()->prepare("SELECT * FROM employee");
      $sql->execute();
      return $sql;
    }
    
  
  }

?>