<?php

  class CustomerFacade extends DBConnection 
  {

    public function getCustomersData($searchQuery)
    {
        if ($searchQuery !== null && $searchQuery !== '') 
        {
            $sql = 'SELECT u.id as id, c.id as customerId, 
                    c.contact as contact,u.first_name as firstname, u.last_name as lastname, 
                    c.code as code, c.type as type, c.email as email, c.address as address,
                    c.is_tax_exempt as is_tax_exempt,
                    c.pwdOrScId as pwdOrScId,c.scOrPwdTIN as scOrPwdTIN,c.dueDateInterval as dueDateInterval, c.privilege_id as privilege_id,
                    d.name, d.discount_amount, u.discount_id, c.child_name, c.child_birth, c.child_age
            FROM customer AS c 
            INNER JOIN users as u ON u.id = c.user_id
            INNER JOIN discounts as d ON d.id = u.discount_id';

            if (!empty($searchQuery)) {
            $sql .= ' WHERE 
                u.first_name LIKE :searchQuery 
                OR u.last_name LIKE :searchQuery 
                OR c.address LIKE :searchQuery 
                OR c.contact LIKE :searchQuery
                OR d.name LIKE :searchQuery';
            }

            $stmt = $this->connect()->prepare($sql);

            if (!empty($searchQuery)) {
                $searchParam = "%_$searchQuery";
                $stmt->bindParam(':searchQuery', $searchParam);
            }

            $stmt->execute();
            return $stmt;

    }else{
        $sql="SELECT u.id as id, c.id as customerId, 
                    c.contact as contact,u.first_name as firstname, u.last_name as lastname, 
                    c.code as code, c.type as type, c.email as email, c.address as address,
                    c.is_tax_exempt as is_tax_exempt,
                    c.pwdOrScId as pwdOrScId,c.scOrPwdTIN as scOrPwdTIN,c.dueDateInterval as dueDateInterval, c.privilege_id as privilege_id,
                    d.name, d.discount_amount, u.discount_id, c.child_name, c.child_birth, c.child_age
            FROM customer AS c 
            INNER JOIN users as u ON u.id = c.user_id
            INNER JOIN discounts as d ON d.id = u.discount_id
            ORDER BY c.id ASC";
         
        
        $stmt = $this->connect()->query($sql);
        return $stmt; 
    }
    }
    public function updateCustomer($formData) 
    {
      $code = $formData['code'];
      $firstName = $formData['firstName'];
      $lastName = $formData['lastName'];
      $customerContact = $formData['customercontact'];
      $customeremail = $formData['customeremail'];
      $due = $formData['due'];
      $pwdOrSCid = $formData['pwdOrSCid'];
      $taxExempt =  $formData['taxExempt'];
      $tin =  $formData['tin'];
      $type =  $formData['type'];
      $address = $formData['address'];
      $id = $formData['userId'];
      $customerid = $formData['customerId'];
      $discountID = $formData['role'];
      $role = 4;
  
      $childName = $formData['childName'];
      $childBirth = $formData['childBirth'];
      $childAge = $formData['childAge'];

      $sql = 'UPDATE users SET 
          first_name = ?,
          role_id = ?,
          last_name = ?,
          discount_id = ?
          WHERE id = ?';
  
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$firstName, $role, $lastName, $discountID, $id]);
  
      $sql = 'UPDATE customer SET 
          contact = ?,
          code = ?,
          type = ?,
          email = ?,
          address = ?,
          is_tax_exempt = ?,
          pwdOrScId = ?,
          scOrPwdTIN = ?,
          dueDateInterval = ?,
          child_name = ?,
          child_birth = ?,
          child_age = ?
          WHERE id = ?';
  
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$customerContact, $code, $type, $customeremail, $address, $taxExempt, $pwdOrSCid, $tin, $due, $childName, $childBirth, $childAge, $customerid]);
  
      return true;
  }
}
    

    
    
  
