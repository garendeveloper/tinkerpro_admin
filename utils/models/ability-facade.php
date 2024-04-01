<?php

  class AbilityFacade extends DBConnection {
    public function processFormData($selectedUsers, $refundPermissions, $salesReportPermissions) {
        $permissionData = array();
        
        if (!empty($refundPermissions)) {
            $permissionData[] = array(
                'Refund' => $refundPermissions
            );
        }
    
        if (!empty($salesReportPermissions)) {
            $permissionData[] = array(
                'SalesReport' => $salesReportPermissions
            );
        }
    
        $jsonData = json_encode($permissionData);
        $query = "SELECT COUNT(*) AS count FROM abilities WHERE user_id = :user_id";
        $statement = $this->connect()->prepare($query);
    
        $updateQuery = "UPDATE abilities SET permission = :permission WHERE user_id = :user_id";
        $updateStatement = $this->connect()->prepare($updateQuery);
    
        $insertQuery = "INSERT INTO abilities (permission, user_id, created_at) VALUES (:permission, :user_id, now())";
        $insertStatement = $this->connect()->prepare($insertQuery);
    
        foreach ($selectedUsers as $userId) {
            $statement->bindParam(':user_id', $userId);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
    
            if ($result['count'] > 0) {
                $updateStatement->bindParam(':permission', $jsonData);
                $updateStatement->bindParam(':user_id', $userId);
                $updateStatement->execute();
            } else {
                $insertStatement->bindParam(':permission', $jsonData);
                $insertStatement->bindParam(':user_id', $userId);
                $insertStatement->execute();
            }
        }
    
       
        $success = true;
        return $success;
    }
    public function getPermissionData($user_id){
        $sql = $this->connect()->prepare("SELECT * FROM abilities WHERE user_id = :user_id");
        $sql->bindParam(':user_id', $user_id);
        $sql->execute();
        $perm =  $sql->fetchAll(PDO::FETCH_ASSOC);
      return  $perm;
    }
    }
    
  
