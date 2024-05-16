<?php

  class AbilityFacade extends DBConnection {
    // public function getPermissionData($user_id){
    //     $sql = $this->connect()->prepare("SELECT * FROM abilities WHERE user_id = :user_id");
    //     $sql->bindParam(':user_id', $user_id);
    //     $sql->execute();
    //     $perm =  $sql->fetchAll(PDO::FETCH_ASSOC);
    //   return  $perm;
    // }
    public function permission($userID){
        // $permi = $this->connect()->prepare("SELECT level FROM ability  WHERE user_id = :userID");
        $permi = $this->connect()->prepare("SELECT permission FROM abilities  WHERE user_id = :userID");
        $permi->bindParam(':userID', $userID, PDO::PARAM_STR);
        $permi->execute();

        $id =  $permi->fetchAll(PDO::FETCH_ASSOC);
        return $id;
    }

    public function checkCredentials($inputPassword) {
        $stmt = $this->connect()->prepare("SELECT role_id, username, password FROM users  WHERE password = :password");
        $stmt->bindParam(':password', $inputPassword, PDO::PARAM_STR);
        $stmt->execute();
       
        if ($user = $stmt->fetch()) {
            if ($inputPassword === $user['password']) {
                if ($user['role_id'] == 1) {
                    return 'superadmin';
                } elseif ($user['role_id'] == 2) {
                    return 'admin';
                }
            }
        }

        return false; 
    }

    public function perm($userID){
        $permissions = [];
        try {
            $permi = $this->connect()->prepare("SELECT permission FROM abilities WHERE user_id = :userID");
            $permi->bindParam(':userID', $userID, PDO::PARAM_INT);
            $permi->execute();
            
            // Fetch the permissions data
            $permissionsData = $permi->fetch(PDO::FETCH_ASSOC);
    
            if ($permissionsData) {
                // Decode the JSON data to an associative array
                $permissions = json_decode($permissionsData['permission'], true);
            }
        } catch (PDOException $e) {
            // Handle any potential exceptions or errors here
            echo "Error: " . $e->getMessage();
        }
    
        return $permissions;
    }
    }
    

    
    
  
