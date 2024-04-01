<?php

class UserFacade extends DBConnection {

    public function fetchUsers($value, $searchQuery) {
        $sql = 'SELECT users.id as id, users.last_name as last_name, users.first_name as first_name, role.role_name as role_name,
                users.username as username, users.password as password, users.users_identification as identification, users.employee_number as employeeNum, users.date_hired as dateHired,
                user_status.status as status, users.profileImage as imageName, users.status_id as status_id, users.role_id as role_id, abilities.permission as permission
                FROM users INNER JOIN role ON role.id = users.role_id LEFT JOIN abilities ON abilities.user_id=users.id LEFT JOIN user_status ON users.status_id = user_status.id 
                WHERE role_id != 4 AND role_id != 1 AND username != "admin"';
    
        if ($value > 0) {
            $sql .= ' AND users.status_id = :status_id';
        }
        if ($searchQuery !== null && $searchQuery !== '') {
            $sql .= ' AND (users.first_name LIKE :searchQuery OR users.last_name LIKE :searchQuery OR  users.employee_number LIKE :searchQuery OR role.role_name LIKE :searchQuery)';
        }
        $sql .= ' ORDER BY id DESC';
    
        $stmt = $this->connect()->prepare($sql);
        if ($value > 0) {
            $stmt->bindParam(':status_id', $value);
        }
        if ($searchQuery !== null && $searchQuery !== '') {
            $searchParam = "%$searchQuery%";
            $stmt->bindParam(':searchQuery', $searchParam);
        }
        $stmt->execute();
    
        return $stmt;
    }
    

    public function verifyUsernameAndPassword( $password ) {
        $sql = $this->connect()->prepare( 'SELECT  password FROM users WHERE password = ?' );
        $sql->execute( [ $password ] );
        $count = $sql->rowCount();
        return $count;
    }

    public function addUser( $firstName, $lastName, $username, $password, $roleType, $refundPerm, $salesReport ) {
        $sql = $this->connect()->prepare( 'INSERT INTO users(role_id, first_name, last_name, username, password) VALUES (?, ?, ?, ?, ?)' );
        $sql->execute( [ $roleType, $firstName, $lastName, $username, $password ] );

        $userId = null;
        if ( $sql ) {
            $maxIdQuery = $this->connect()->query( 'SELECT MAX(id) AS max_id FROM users' );
            $maxId = $maxIdQuery->fetch( PDO::FETCH_ASSOC );

            if ( $maxId && isset( $maxId[ 'max_id' ] ) ) {
                $userId = $maxId[ 'max_id' ];

                $permissionData = array();

                if ( $refundPerm == 1 ) {
                    $permissionData[] = array(
                        'Refund' => 'Access Granted'
                    );
                } else {
                    $permissionData[] = array(
                        'Refund' => 'No Access'
                    );
                }

                if ( $salesReport == 1 ) {
                    $permissionData[] = array(
                        'SalesReport' => 'Access Granted'
                    );
                } else {
                    $permissionData[] = array(
                        'SalesReport' => 'No Access'
                    );
                }

                $jsonData = json_encode( $permissionData );
                $insertPermission = $this->connect()->prepare( 'INSERT INTO abilities (permission, user_id, created_at) VALUES (?, ?, now())' );
                $insertPermission->execute( [ $jsonData, $userId ] );
            }
        }

        return $userId;
    }

    public function updateUser( $updateUserId, $firstName, $lastName, $username, $password, $roleType ) {
        $sql = $this->connect()->prepare( "UPDATE users SET first_name = '$firstName',role_id = '$roleType', last_name = '$lastName', username = '$username', password = '$password' WHERE id = $updateUserId" );
        $sql->execute();
        return $sql;
    }

    public function deleteUser( $userId ) {
        $sql = $this->connect()->prepare( "DELETE FROM users WHERE id = $userId" );
        $sql->execute();
        return $sql;
    }

    public function isLoggedIn( $userId ) {
        $sql = $this->connect()->prepare( "UPDATE user SET is_logged_in = 1 WHERE id = $userId" );
        $sql->execute();
        return $sql;
    }

    public function isLoggedOut( $userId ) {
        $sql = $this->connect()->prepare( "UPDATE user SET is_logged_in = 0 WHERE id = $userId" );
        $sql->execute();
        return $sql;
    }

    public function signIn( $password ) {
        $sql = $this->connect()->prepare( 'SELECT * FROM users WHERE password = ?' );
        $sql->execute( [ $password ] );
        return $sql;
    }

    public function getRoleType() {
        $sql = $this->connect()->prepare( "SELECT * FROM role WHERE role_name != 'Customer' AND role_name != 'Super Admin';" );
        $sql->execute();
        return $sql;
    }

    public function getUsers() {
        $sql = $this->connect()->prepare( "SELECT id,first_name,last_name FROM users WHERE username NOT IN ('admin','superadmin') AND role_id != 4 ORDER BY id DESC" );
        $sql->execute();
        return $sql;
    }

    public function getUsersStatus() {
        $sql = $this->connect()->prepare( 'SELECT * FROM user_status' );
        $sql->execute();
        return $sql;
    }

    public function checkUsersIdentificationNumber( $roleId ) {
        $roleId = ( int )$roleId;

        $prefix = '';
        if ( $roleId === 1 ) {
            $prefix = 'SA';
        } elseif ( $roleId === 2 ) {
            $prefix = 'A';
        } elseif ( $roleId === 3 ) {
            $prefix = 'C';
        } elseif ( $roleId === 5 ) {
            $prefix = 'S';
        } elseif ( $roleId === 6 ) {
            $prefix = 'M';
        }

        $lastIdQuery = $this->connect()->prepare( 'SELECT MAX(users_identification) AS max_id FROM users WHERE users_identification LIKE ?' );
        $lastIdQuery->execute( [ $prefix . '%' ] );
        $lastIdResult = $lastIdQuery->fetch( PDO::FETCH_ASSOC );
        $lastId = isset( $lastIdResult[ 'max_id' ] ) ? $lastIdResult[ 'max_id' ] : '';

        $incrementedNumber = ( $lastId === '' ) ? 1 : ( int )ltrim( $lastId, $prefix ) + 1;

        $incrementedNumberPadded = str_pad( $incrementedNumber, 4, '0', STR_PAD_LEFT );
        return $prefix . $incrementedNumberPadded;
    }

    public function addNewUsers($formData)
    {
        $role_id = $formData['role_id'];
        $last_name = $formData['last_name'];
        $first_name = $formData['first_name'];
        $password = $formData['password'];
        $username = $formData['username'];
        $dateHired = $formData['dateHired'];
        $dateHired = str_replace('-', '/', $dateHired);
        $newDateHired = date('Y-m-d', strtotime($dateHired));
        $employeeNum = $formData['employeeNum'];
        $identification = $formData['userID'];
        $status = $formData['status'];
        $uploadedFile = $_FILES['uploadedImage'] ?? null;
    
        if ($uploadedFile !== null && $uploadedFile['error'] === UPLOAD_ERR_OK) {
            $tempPath = $uploadedFile['tmp_name'];
            $fileName = $uploadedFile['name'];
    
            $destination = './assets/profile/' . $fileName;
            move_uploaded_file($tempPath, $destination);
        } else {
            
            $fileName = null; 
        }
    
        $sql = 'INSERT INTO users (role_id, last_name, first_name, password, username, profileImage,date_hired,employee_number,users_identification,status_id) VALUES (?, ?, ?, ?, ?, ?,?,?,?,?)';
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$role_id, $last_name, $first_name, $password, $username, $fileName, $newDateHired, $employeeNum, $identification, $status]);
    
        $userId = null;
        if ($stmt) {
            $maxIdQuery = $this->connect()->query('SELECT MAX(id) AS max_id FROM users');
            $maxId = $maxIdQuery->fetch(PDO::FETCH_ASSOC);
    
            if ($maxId && isset($maxId['max_id'])) {
                $userId = $maxId['max_id'];
    
                $permissionData = array();
    
                $permissionData[] = array(
                    'Refund' => ($formData["refund"] == 1) ? 'Access Granted' : 'No Access',
                    'ReturnExchange' => ($formData["return"] == 1) ? 'Access Granted' : 'No Access',
                    'XReading' => ($formData["xreading"] == 1) ? 'Access Granted' : 'No Access',
                    'ZReading' => ($formData["zreading"] == 1) ? 'Access Granted' : 'No Access',
                    'CashCount' => ($formData["cashcount"] == 1) ? 'Access Granted' : 'No Access',
                    'SalesHistory' => ($formData["saleshistory"] == 1) ? 'Access Granted' : 'No Access',
                    'Inventory' => ($formData["inventory"] == 1) ? 'Access Granted' : 'No Access',
                    'Reports' => ($formData["reporting"] == 1) ? 'Access Granted' : 'No Access',
                    'StartingCash' => ($formData["starting"] == 1) ? 'Access Granted' : 'No Access',
                    'Products' => ($formData["products"] == 1) ? 'Access Granted' : 'No Access',
                    'Documents' => ($formData["documents"] == 1) ? 'Access Granted' : 'No Access',
                    'PurchaseOrder' => ($formData["purchase"] == 1) ? 'Access Granted' : 'No Access',
                    'VoidItem' => ($formData["voiditem"] == 1) ? 'Access Granted' : 'No Access',
                    'VoidCart' => ($formData["voidcart"] == 1) ? 'Access Granted' : 'No Access',
                    'CancelReceipt' => ($formData["cancelreceipt"] == 1) ? 'Access Granted' : 'No Access',
                    'Users' => ($formData["users"] == 1) ? 'Access Granted' : 'No Access',
        );
    
                $jsonData = json_encode($permissionData);
                $insertPermission = $this->connect()->prepare('INSERT INTO abilities (permission, user_id, created_at) VALUES (?, ?, now())');
                $insertPermission->execute([$jsonData, $userId]);
            }
        }
    
        return ['success' => true, 'message' => 'User added successfully'];
    }
    

public function updateDataUsers($formData) {
    $role_id = $formData['role_id'];
    $last_name = $formData['last_name'];
    $first_name = $formData['first_name'];
    $password = $formData['password'];
    $username = $formData['username'];
    $dateHired = $formData['dateHired'];
    $dateHired = str_replace('-', '/', $dateHired);
    $newDateHired = date('Y-m-d', strtotime($dateHired));
    $employeeNum = $formData['employeeNum'];
    $identification = $formData['userID'];
    $status = $formData['status'];
    $uploadedFile = $_FILES['uploadedImage'] ?? null;
    $id = $formData['id'];

    if ($uploadedFile === null || $uploadedFile['error'] !== UPLOAD_ERR_OK) {
        // If uploaded image is null or upload failed
        $fileName = null; // Set fileName to null if image upload is null or failed
    } else {
        // If uploaded image is not null and upload succeeded
        $tempPath = $uploadedFile['tmp_name'];
        $fileName = $uploadedFile['name'];

        $destination = './assets/profile/' . $fileName;
        move_uploaded_file($tempPath, $destination);
    }

    $sql = 'UPDATE users SET 
            role_id = ?, 
            last_name = ?, 
            first_name = ?, 
            password = ?, 
            username = ?, 
            profileImage = ?, 
            date_hired = ?, 
            employee_number = ?, 
            users_identification = ?, 
            status_id = ? 
            WHERE id = ?';

    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$role_id, $last_name, $first_name, $password, $username, $fileName, $newDateHired, $employeeNum, $identification, $status, $id]);

    $permissionData = array();
    $permissionData[] = array(
                'Refund' => ($formData["refund"] == 1) ? 'Access Granted' : 'No Access',
                'ReturnExchange' => ($formData["return"] == 1) ? 'Access Granted' : 'No Access',
                'XReading' => ($formData["xreading"] == 1) ? 'Access Granted' : 'No Access',
                'ZReading' => ($formData["zreading"] == 1) ? 'Access Granted' : 'No Access',
                'CashCount' => ($formData["cashcount"] == 1) ? 'Access Granted' : 'No Access',
                'SalesHistory' => ($formData["saleshistory"] == 1) ? 'Access Granted' : 'No Access',
                'Inventory' => ($formData["inventory"] == 1) ? 'Access Granted' : 'No Access',
                'Reports' => ($formData["reporting"] == 1) ? 'Access Granted' : 'No Access',
                'StartingCash' => ($formData["starting"] == 1) ? 'Access Granted' : 'No Access',
                'Products' => ($formData["products"] == 1) ? 'Access Granted' : 'No Access',
                'Documents' => ($formData["documents"] == 1) ? 'Access Granted' : 'No Access',
                'PurchaseOrder' => ($formData["purchase"] == 1) ? 'Access Granted' : 'No Access',
                'VoidItem' => ($formData["voiditem"] == 1) ? 'Access Granted' : 'No Access',
                'VoidCart' => ($formData["voidcart"] == 1) ? 'Access Granted' : 'No Access',
                'CancelReceipt' => ($formData["cancelreceipt"] == 1) ? 'Access Granted' : 'No Access',
                'Users' => ($formData["users"] == 1) ? 'Access Granted' : 'No Access',
    );

    $jsonData = json_encode($permissionData);
    $updatePermission = $this->connect()->prepare('UPDATE abilities SET permission = ?, created_at = now() WHERE user_id = ?');
    $updatePermission->execute([$jsonData, $id]);

    return ['success' => true, 'message' => 'User updated successfully'];
}

}
?>