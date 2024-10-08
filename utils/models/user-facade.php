<?php

class UserFacade extends DBConnection {

    public function verifyAdminUser($password)
    {
        session_start();
        $user_id = $_SESSION['user_id'];
        $sql = $this->connect()->prepare("SELECT * FROM users WHERE password = ? and id = ?");
        $sql->execute([$password, $user_id]);
        $isExist = $sql->rowCount() > 0;

        $status = false;
        $message = "Invalid password!";
        if($isExist)
        {
            $status = true;
            $message = "Password is found";
        }
        return [
            'status' => $status,
            'message' => $message,
        ];
    }


    public function getValidateAccess($id) {
        $pdo = $this->connect();

        $sql = $pdo->prepare("SELECT
        JSON_UNQUOTE(JSON_EXTRACT(permission, '$[0].Management')) AS access
        FROM abilities WHERE user_id = ? LIMIT 1;");

        $sql->execute([$id]);
        $access = $sql->fetch(PDO::FETCH_ASSOC);

        return $access;
    }


    public function fetchUserForLogs()
    {
        $stmt = $this->connect()->query("SELECT * FROM users ORDER BY users.id asc");
        return $stmt;
    }
    public function fetchUsers($value, $searchQuery, $selectedUser, $singleDateData, $startDate, $endDate) {
    
        if ($value > 0) {
            $sql = 'SELECT users.id as id, users.last_name as last_name, users.first_name as first_name, role.role_name as role_name,
            users.username as username, users.password as password, users.users_identification as identification, users.employee_number as employeeNum, users.date_hired as dateHired,
            user_status.status as status, users.profileImage as imageName, users.status_id as status_id, users.role_id as role_id, abilities.permission as permission
            FROM users INNER JOIN role ON role.id = users.role_id LEFT JOIN abilities ON abilities.user_id=users.id LEFT JOIN user_status ON users.status_id = user_status.id 
            WHERE role_id != 4 AND role_id != 1 AND username != "admin" AND users.status_id = :status_id ORDER BY users.id ASC';

            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':status_id', $value);
            $stmt->execute();
            return $stmt;
        }
        else if ($searchQuery !== null && $searchQuery !== '') {
            $sql = 'SELECT users.id as id, users.last_name as last_name, users.first_name as first_name, role.role_name as role_name,
            users.username as username, users.password as password, users.users_identification as identification, users.employee_number as employeeNum, users.date_hired as dateHired,
            user_status.status as status, users.profileImage as imageName, users.status_id as status_id, users.role_id as role_id, abilities.permission as permission
            FROM users INNER JOIN role ON role.id = users.role_id LEFT JOIN abilities ON abilities.user_id=users.id LEFT JOIN user_status ON users.status_id = user_status.id 
            WHERE role_id != 4 AND role_id != 1 AND username != "admin"';

            if (!empty($searchQuery)) {
                $sql .= ' AND (users.first_name LIKE :searchQuery OR users.last_name LIKE :searchQuery OR users.employee_number LIKE :searchQuery OR role.role_name LIKE :searchQuery)';
            }

            $sql .= ' ORDER BY users.id ASC';

            $stmt = $this->connect()->prepare($sql);

            if (!empty($searchQuery)) {
                $searchParam = "%$searchQuery%";
                $stmt->bindParam(':searchQuery', $searchParam);
            }

            $stmt->execute();
            return $stmt;

        }
        else if ($selectedUser &&  !$singleDateData && !$startDate  && !$endDate) {
            $sql = 'SELECT users.id as id, users.last_name as last_name, users.first_name as first_name, role.role_name as role_name,
            users.username as username, users.password as password, users.users_identification as identification, users.employee_number as employeeNum, users.date_hired as dateHired,
            user_status.status as status, users.profileImage as imageName, users.status_id as status_id, users.role_id as role_id, abilities.permission as permission
            FROM users INNER JOIN role ON role.id = users.role_id LEFT JOIN abilities ON abilities.user_id=users.id LEFT JOIN user_status ON users.status_id = user_status.id 
            WHERE role_id != 4 AND role_id != 1 AND username != "admin" AND users.id = :selectedUser ORDER BY id ASC';

            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':selectedUser', $selectedUser);
            $stmt->execute();
            return $stmt;
        }
        if (!$selectedUser &&  $singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT users.id as id, users.last_name as last_name, users.first_name as first_name, role.role_name as role_name,
            users.username as username, users.password as password, users.users_identification as identification, users.employee_number as employeeNum, users.date_hired as dateHired,
            user_status.status as status, users.profileImage as imageName, users.status_id as status_id, users.role_id as role_id, abilities.permission as permission
            FROM users INNER JOIN role ON role.id = users.role_id LEFT JOIN abilities ON abilities.user_id=users.id LEFT JOIN user_status ON users.status_id = user_status.id 
            WHERE role_id != 4 AND role_id != 1 AND username != "admin" AND users.date_hired = :singleDateData ORDER BY id ASC';

            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':singleDateData', $singleDateData);
            $stmt->execute();
            return $stmt;
            
        }
       else if(!$selectedUser &&  !$singleDateData && $startDate && $endDate) {
           $sql = 'SELECT users.id as id, users.last_name as last_name, users.first_name as first_name, role.role_name as role_name,
            users.username as username, users.password as password, users.users_identification as identification, users.employee_number as employeeNum, users.date_hired as dateHired,
            user_status.status as status, users.profileImage as imageName, users.status_id as status_id, users.role_id as role_id, abilities.permission as permission
            FROM users INNER JOIN role ON role.id = users.role_id LEFT JOIN abilities ON abilities.user_id=users.id LEFT JOIN user_status ON users.status_id = user_status.id 
            WHERE role_id != 4 AND role_id != 1 AND username != "admin" AND (users.date_hired BETWEEN :startDate AND :endDate) ORDER BY id ASC';

            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':startDate', $startDate);
            $stmt->bindParam(':endDate', $endDate);
            $stmt->execute();
            return $stmt;
                        
        }
        else if($selectedUser &&  $singleDateData && !$startDate && !$endDate){
            $sql = 'SELECT users.id as id, users.last_name as last_name, users.first_name as first_name, role.role_name as role_name,
            users.username as username, users.password as password, users.users_identification as identification, users.employee_number as employeeNum, users.date_hired as dateHired,
            user_status.status as status, users.profileImage as imageName, users.status_id as status_id, users.role_id as role_id, abilities.permission as permission
            FROM users INNER JOIN role ON role.id = users.role_id LEFT JOIN abilities ON abilities.user_id=users.id LEFT JOIN user_status ON users.status_id = user_status.id 
            WHERE role_id != 4 AND role_id != 1 AND username != "admin"  AND (users.id = :selectedUser AND users.date_hired = :singleDateData) ORDER BY id ASC';
               
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':singleDateData', $singleDateData);
            $stmt->bindParam(':selectedUser', $selectedUser);
            $stmt->execute();
            return $stmt;
            
        }
        else if($selectedUser &&  !$singleDateData && $startDate  && $endDate){
            $sql = 'SELECT users.id as id, users.last_name as last_name, users.first_name as first_name, role.role_name as role_name,
            users.username as username, users.password as password, users.users_identification as identification, users.employee_number as employeeNum, users.date_hired as dateHired,
            user_status.status as status, users.profileImage as imageName, users.status_id as status_id, users.role_id as role_id, abilities.permission as permission
            FROM users INNER JOIN role ON role.id = users.role_id LEFT JOIN abilities ON abilities.user_id=users.id LEFT JOIN user_status ON users.status_id = user_status.id 
            WHERE role_id != 4 AND role_id != 1 AND username != "admin"  AND (users.id = :selectedUser AND users.date_hired BETWEEN :startDate AND :endDate)';

            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':selectedUser', $selectedUser);
            $stmt->bindParam(':startDate', $startDate);
            $stmt->bindParam(':endDate', $endDate);
            $stmt->execute();
            return $stmt;
        }
        else{
            $sql = 'SELECT users.id as id, users.last_name as last_name, users.first_name as first_name, role.role_name as role_name,
            users.username as username, users.password as password, users.users_identification as identification, users.employee_number as employeeNum, users.date_hired as dateHired,
            user_status.status as status, users.profileImage as imageName, users.status_id as status_id, users.role_id as role_id, abilities.permission as permission
            FROM users INNER JOIN role ON role.id = users.role_id LEFT JOIN abilities ON abilities.user_id=users.id LEFT JOIN user_status ON users.status_id = user_status.id 
            WHERE role_id != 4 AND role_id != 1 AND username != "admin" ORDER BY id ASC';

            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            return $stmt;
           }
       
     
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
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllCustomers() {
        $sql = $this->connect()->prepare( "SELECT * FROM role WHERE role_name != 'Super Admin'" );
        $sql->execute();
        return $sql;
    }

    public function getUsers() {
        $sql = $this->connect()->prepare( "SELECT id,first_name,last_name FROM users WHERE username NOT IN ('admin','superadmin') AND role_id != 4 ORDER BY id ASC" );
        $sql->execute();
        return $sql;
    }
    public function getAllDiscountUsers()
    {
        $sql = $this->connect()->prepare( "SELECT * FROM discounts ORDER BY id ASC" );
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
    public function verify_role($roleName)
    {
        $sql = $this->connect()->prepare("SELECT * FROM role WHERE role_name = ?");
        $sql->execute([$roleName]);

        if ($sql->rowCount() > 0) 
        {
            $role = $sql->fetch(PDO::FETCH_ASSOC);
            return $role['id'];
        } 
        else 
        {
            $pdo = $this->connect();
            $sql = $pdo->prepare("INSERT INTO role (role_name) VALUES (?)");
            $sql->execute([$roleName]);
            return $pdo->lastInsertId();
        }
    }
    public function addNewUsers($formData)
    {
        $pdo = $this->connect();

        $role_id = $formData['role_id'];
        $roleName = $formData['roleName'];
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

        $role_id = $this->verify_role($roleName);

        $existingUsers = $pdo->prepare('SELECT * FROM users WHERE role_id <> 4');
        $existingUsers->execute();
        $getUsers = $existingUsers->fetchAll(PDO::FETCH_ASSOC);

        $userExists = false;

        foreach ($getUsers as $user) {
            if ($user['username'] == $username && $user['password'] == $password) {
                return ['success' => false, 'message' => 'User already exists'];
            }
        }
        
        
        if (!$userExists) {
            $sql = 'INSERT INTO users (role_id, last_name, first_name, password, username, profileImage,date_hired,employee_number,users_identification,status_id) VALUES (?, ?, ?, ?, ?, ?,?,?,?,?)';
       
            $stmt =  $pdo->prepare($sql);
            $stmt->execute([$role_id, $last_name, $first_name, $password, $username, $fileName, $newDateHired, $employeeNum, $identification, $status]);
    
            $lastUserInserted =  $pdo->lastInsertId();
            $sqls = "INSERT INTO `series`(`cashier_id`, `series`) VALUES (?,?)";
            $stmt = $pdo->prepare($sqls);
            $stmt->execute([$lastUserInserted, $lastUserInserted]);
        
            $userId = null;
            if ($stmt) {
                $maxIdQuery = $this->connect()->query('SELECT MAX(id) AS max_id FROM users');
                $maxId = $maxIdQuery->fetch(PDO::FETCH_ASSOC);
        
                if ($maxId && isset($maxId['max_id'])) 
                {
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
                        'Promotion' => ($formData["promotion"] == 1) ? 'Access Granted' : 'No Access',
                        //new
                        'Coupon' => ($formData["coupon"] == 1) ? 'Access Granted' : 'No Access',
                        'Charges' => ($formData["charges"] == 1) ? 'Access Granted' : 'No Access',
                        'Pricelist' => ($formData["pricelist"] == 1) ? 'Access Granted' : 'No Access',
                        'Expenses' => ($formData["expenses"] == 1) ? 'Access Granted' : 'No Access',
                        'Supplier' => ($formData["supplier"] == 1) ? 'Access Granted' : 'No Access',
                        'Customer' => ($formData["customer"] == 1) ? 'Access Granted' : 'No Access',
                        'Pricetag' => ($formData["pricetag"] == 1) ? 'Access Granted' : 'No Access',
                        'Activitylogs' => ($formData["activitylogs"] == 1) ? 'Access Granted' : 'No Access',
                        'Management' => ($formData["management"] == 1) ? 'Access Granted' : 'No Access',
            );
        
                    $jsonData = json_encode($permissionData);
                    $insertPermission = $this->connect()->prepare('INSERT INTO abilities (permission, user_id, created_at) VALUES (?, ?, now())');
                    $insertPermission->execute([$jsonData, $userId]);

                    // Check if roleName is 'Cashier' or 'Inventory' and insert into the 'employee' table
                if (in_array($roleName, ['Cashier', 'Inventory'])) {
                    $sqlEmployee = 'INSERT INTO employee (fname, lname, position, user_id, employee_number, username, password, date_hired, status_id, profileimage) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
                    $stmtEmployee = $pdo->prepare($sqlEmployee);
                    $stmtEmployee->execute([$first_name, $last_name, $roleName, $userId, $employeeNum, $username, $password, $newDateHired, $status, $fileName]);
                }

                }
            }
        
            return ['success' => true, 'message' => 'User added successfully', 'userId' => $lastUserInserted];
        }

    }
    

public function updateDataUsers($formData) {
    $role_id = $formData['role_id'];
    $roleName = $formData['roleName'];
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
        $query = "SELECT profileImage FROM users WHERE id = ?";
        $statement = $this->connect()->prepare($query);
        $statement->execute([$id]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $fileName = $result['profileImage'];
        } else {
            $fileName = null;
        }
        
    } else {
        $tempPath = $uploadedFile['tmp_name'];
        $fileName = $uploadedFile['name'];

        $destination = './assets/profile/' . $fileName;
        move_uploaded_file($tempPath, $destination);
    }

    $role_id = $this->verify_role($roleName);

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
                'Promotion' => ($formData["promotion"] == 1) ? 'Access Granted' : 'No Access',
                //new add
                'Coupon' => ($formData["coupon"] == 1) ? 'Access Granted' : 'No Access',
                'Charges' => ($formData["charges"] == 1) ? 'Access Granted' : 'No Access',
                'Pricelist' => ($formData["pricelist"] == 1) ? 'Access Granted' : 'No Access',
                'Expenses' => ($formData["expenses"] == 1) ? 'Access Granted' : 'No Access',
                'Supplier' => ($formData["supplier"] == 1) ? 'Access Granted' : 'No Access',
                'Customer' => ($formData["customer"] == 1) ? 'Access Granted' : 'No Access',
                'Pricetag' => ($formData["pricetag"] == 1) ? 'Access Granted' : 'No Access',
                'Activitylogs' => ($formData["activitylogs"] == 1) ? 'Access Granted' : 'No Access',
                'Management' => ($formData["management"] == 1) ? 'Access Granted' : 'No Access',


    );

    $jsonData = json_encode($permissionData);
    $updatePermission = $this->connect()->prepare('UPDATE abilities SET permission = ?, created_at = now() WHERE user_id = ?');
    $updatePermission->execute([$jsonData, $id]);

    return ['success' => true, 'message' => 'User updated successfully'];
}

public function getUsersData() {
    $sql = 'SELECT * FROM users WHERE id NOT IN (2) AND role_id NOT IN (4)';
    $stmt = $this->connect()->query($sql);
    return $stmt;
}
public function getCustomersData(){
    $sql = 'SELECT * FROM users WHERE role_id NOT IN (1,2,3,5,6)';
    $stmt = $this->connect()->query($sql);
    return $stmt;
}
public function addCustomer($formData){
    $code = $formData['code'];
    $firstrName = $formData['firstName'];
    $lastName = $formData['lastName'];
    $customerContact = $formData['customercontact'];
    $customeremail = $formData['customeremail'];
    $due = $formData['due'];
    $pwdOrSCid = $formData['pwdOrSCid'];
    $taxExempt =  $formData['taxExempt'];
    $tin =  $formData['tin'];
    $type =  $formData['type'];
    $address = $formData['address'];
    $discountID = $formData['role'];

    $childName = $formData['childName'];
    $childBirth = $formData['childBirth'];
    $childAge = $formData['childAge'];

    $roleType = 4;
    $sql = 'INSERT INTO users(first_name,role_id, last_name, discount_id) VALUES (?,?,?,?)';
    $pdo = $this->connect();
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$firstrName ,$roleType, $lastName, $discountID]);
    
    $lastInsertId = $pdo->lastInsertId();
    if($lastInsertId){
        $sql = 'INSERT INTO customer(user_id,contact,code,type,email,address,is_tax_exempt,pwdOrScId,scOrPwdTIN,dueDateInterval, child_name, child_birth, child_age) VALUES (?,?,?,?,?,?,?,?,?,?, ?, ?, ?)';
        $pdo = $this->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$lastInsertId ,$customerContact, $code , $type, $customeremail,$address,$taxExempt,$pwdOrSCid,$tin,$due, $childName, $childBirth, $childAge]);
    }
    return true;

}
public function getCouponStatus(){
    $sql = 'SELECT id,isUse FROM return_coupon';
    $stmt = $this->connect()->query($sql);
    return $stmt;
}
public function getAllCouponsStatus($value,$searchQuery){
    if ($value == "0" ||$value == "1" ) {
        $sql = 'SELECT * FROM return_coupon WHERE isUse = :status_id ORDER BY transaction_dateTime DESC';
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':status_id', $value);
        $stmt->execute();
        return $stmt;
    }else if($searchQuery){
        $sql = 'SELECT * FROM return_coupon WHERE qrNumber LIKE :searchQuery ORDER BY transaction_dateTime DESC';
        $stmt = $this->connect()->prepare($sql);
        
        if (!empty($searchQuery)) {
            $searchParam = "%$searchQuery%";
            $stmt->bindParam(':searchQuery', $searchParam);
        }
        
        $stmt->execute();
        return $stmt;
    }
    else{
    $sql = 'SELECT * FROM return_coupon ORDER BY transaction_dateTime DESC';
    $stmt = $this->connect()->query($sql);
    return $stmt;
    }
}

public function fetchShop() {
    $sql = $this->connect()->prepare("SELECT shop.*,
invoice_name.*
FROM shop
INNER JOIN invoice_name ON invoice_name.id = shop.invoice_id_name;");
    $sql->execute();
    return $sql;
  }
  function getLatestReturnCouponData($id){
        
    $sql = $this->connect()->prepare("SELECT * FROM return_coupon WHERE id = :id");
    $sql->bindParam(':id', $id);
    $sql->execute();
    $latestCoupon = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $latestCoupon;
}
public function getExpiration(){
    $sql = $this->connect()->prepare("SELECT *
    FROM coupon_expiration");

        $sql->execute();
        return $sql;
}
public function defaultCouponExpiration($value){
    $default = 1;

    
    $sqlUpdateAll = 'UPDATE coupon_expiration SET `default` = 0';
    $conn = $this->connect();
    $stmtUpdateAll = $conn->prepare($sqlUpdateAll);
    $stmtUpdateAll->execute();

    $sqlSetDefault = 'UPDATE coupon_expiration SET `default` = ? WHERE id = ?';
    $stmtSetDefault = $conn->prepare($sqlSetDefault);
    $stmtSetDefault->execute([$default, $value]);

    return $stmtSetDefault;
}
    public function getDefaultDate(){
        $sql = $this->connect()->prepare("SELECT *
        FROM coupon_expiration WHERE `default` = 1");

            $sql->execute();
            $default = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $default;
    }

  
    public function deleteCustomer($customerId, $typeFunction) {
        $pdo = $this->connect();

        if ($typeFunction == 0) {
            $udpateUser = $pdo->prepare("UPDATE `users` SET `status_id`= 2 WHERE `id` = ?");
            $udpateUser->execute([$customerId]);
            
            echo json_encode([
                'type' => 'Updated',
                'success' => true,
                'data' => 'Success Delete',
            ]);
        } else {
            
            $deleteCustomer = $pdo->prepare('DELETE FROM `users` WHERE id = ?');
            $deleteCustomer->execute([$customerId]);
    
            echo json_encode([
                'type' => 'deleted',
                'success' => true,
                'data' => 'Success Delete',
            ]);
        }
    }
    

    public function getValidateCustomer($customerId) {
        $pdo = $this->connect();
        $validate = $pdo->prepare('SELECT * FROM transactions WHERE user_id = ? LIMIT 1');
        $validate->execute([$customerId]);

        $res = $validate->fetch(PDO::FETCH_ASSOC);
        if(!empty($res)) {
            echo json_encode([
                'isTransact' => true,
            ]);
        } else {
            echo json_encode([
                'isTransact' => false,
            ]);
        }
    }
}

?>