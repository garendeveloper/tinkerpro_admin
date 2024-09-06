<?php

  class Employee_facade extends DBConnection {

    public function fetchEmployee() {
      $sql = $this->connect()->prepare("SELECT * FROM employee");
      $sql->execute();
      return $sql;
    }
    

    public function deleteEmployee($id){
    $pdo = $this->connect();
    $sql = "DELETE FROM employee WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id]);
}


    public function getEmployeeStatus() {
      $sql = $this->connect()->prepare( 'SELECT * FROM user_status' );
      $sql->execute();
      return $sql;
  }
  


  public function addNewEmployee($formData)
  {
      // Connect to the database
      $pdo = $this->connect();
  
      // Extract form data
      $last_name = $formData['last_name'];
      $first_name = $formData['first_name'];
      $empPosition = $formData['position'];
      $password = $formData['password'];
      $username = $formData['username'];
      $dateHired = $formData['dateHired'];
      $employeeNum = $formData['employeeNum'];
      $status = $formData['status'];
      $uploadedFile = $_FILES['uploadedImage'] ?? null;
  
      // Date formatting
      $dateHired = str_replace('-', '/', $dateHired);
      $newDateHired = date('Y-m-d', strtotime($dateHired));
  
      // Hash the password before storing
      $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
  
      // Handle file upload if it exists
      if ($uploadedFile !== null && $uploadedFile['error'] === UPLOAD_ERR_OK) {
          $tempPath = $uploadedFile['tmp_name'];
          $fileName = $uploadedFile['name'];
  
          $destination = './assets/profile/' . $fileName;
          move_uploaded_file($tempPath, $destination);
      } else {
          $fileName = null; // Or you can provide a default image
      }
  
      // Enable error mode to handle exceptions
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
      // Insert into database
      $sql = 'INSERT INTO employee (lname, fname, position, password, username, profileImage, date_hired, employee_number, status_id) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
      $stmt = $pdo->prepare($sql);
  
      try {
          // Execute the prepared statement
          $stmt->execute([
              $last_name,
              $first_name,
              $empPosition,
              $hashedPassword, // Use the hashed password
              $username,
              $fileName,
              $newDateHired,
              $employeeNum,
              $status
          ]);
  
          // Get the last inserted ID
          $userId = $pdo->lastInsertId();
          return ['success' => true, 'message' => 'User added successfully', 'userId' => $userId];
  
      } catch (PDOException $e) {
          // Handle SQL errors
          return ['success' => false, 'message' => 'Error inserting user: ' . $e->getMessage()];
      }
  }

}
  
    

?>