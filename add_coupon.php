<?php

include(__DIR__ . '/utils/db/connector.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  
    
    $dbConnection = new DBConnection();
    $conn = $dbConnection->getConnection();  
    

    if ($conn) { // Proceed only if connection is successful
        // Decode the JSON data from the request body
        $data = json_decode(file_get_contents('php://input'), true);

        // Extract data from the decoded JSON
        $amount = $data['amount'];
        $validity = $data['validity'];
        $qrNumber = $data['qrNumber'];
        $multipleUse = $data['multipleUse'];

        // Calculate the expiry date and time
        $expiry_dateTime = date('Y-m-d H:i:s', strtotime($validity));

        // Prepare an SQL statement to prevent SQL injection
        $sql = "INSERT INTO return_coupon (qrNumber, receipt_id, c_amount, isUse, transaction_dateTime, expiry_dateTime, multiple_use)
                VALUES (:qrNumber, 0, :amount, 0, NOW(), :expiry_dateTime, :multipleUse)";

        try {
          
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':qrNumber', $qrNumber);
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':expiry_dateTime', $expiry_dateTime);
            $stmt->bindParam(':multipleUse', $multipleUse);
            
            if ($stmt->execute()) {
                $insertedId = $conn->lastInsertId(); // Get the ID of the newly inserted row
                echo json_encode(['success' => true, 'qrNumber' => $qrNumber, 'id' => $insertedId]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to insert data']);
            }
            
        } catch (PDOException $e) {
         
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    }

    $conn = null;
}
?>
