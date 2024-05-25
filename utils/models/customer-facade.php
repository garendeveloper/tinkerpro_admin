<?php

  class CustomerFacade extends DBConnection {

    public function getCustomersData(){
        $sql="SELECT u.id as id, c.id as customerId, c.contact as contact,u.first_name as firstname, u.last_name as lastname, c.code as code, c.type as type, c.email as email, c.address as address,
        c.is_tax_exempt as is_tax_exempt,c.pwdOrScId as pwdOrScId,c.scOrPwdTIN as scOrPwdTIN,c.dueDateInterval as dueDateInterval, c.privilege_id as privilege_id
        FROM customer AS c INNER JOIN users as u ON u.id = c.user_id;";
         
        $stmt = $this->connect()->query($sql);
        return $stmt; 

    }
    public function updateCustomer($formData) {
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
      $role = 4;
  
      // Update the users table
      $sql = 'UPDATE users SET 
          first_name = ?,
          role_id = ?,
          last_name = ?
          WHERE id = ?';
  
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$firstName, $role, $lastName, $id]);
  
      // Update the customer table
      $sql = 'UPDATE customer SET 
          contact = ?,
          code = ?,
          type = ?,
          email = ?,
          address = ?,
          is_tax_exempt = ?,
          pwdOrScId = ?,
          scOrPwdTIN = ?,
          dueDateInterval = ?
          WHERE id = ?';
  
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$customerContact, $code, $type, $customeremail, $address, $taxExempt, $pwdOrSCid, $tin, $due, $customerid]);
  
      return true;
  }
  
    
}
    

    
    
  
