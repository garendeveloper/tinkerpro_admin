<?php

  class SupplierFacade extends DBConnection {
   

    public function addSupplier($formData){
        $s_name = $formData['supplierName'] ?? null;
        $s_contact =  $formData['supplierContact'] ?? null;
        $s_email =  $formData['supplierEmail'] ?? null;
        $s_company =  $formData['supplierCompany'] ?? null;
        $s_status =  $formData['supplierStatus'] ?? null;
        $p_supplied = $formData['suppliedProductData'] ?? null;
        $i_supplied = $formData['suppliedIngredientsData'] ?? null;
    
        $sqlSupplier = 'INSERT INTO supplier(supplier,contact,email,company,is_active) VALUES (?,?,?,?,?)';
        $stmtSupplier = $this->connect()->prepare($sqlSupplier);
        $successSupplier = $stmtSupplier->execute([$s_name, $s_contact, $s_email, $s_company, $s_status]);
    
        if ($successSupplier) {
            $maxIdQuery = $this->connect()->query('SELECT MAX(id) AS max_id FROM supplier');
            $maxIdResult = $maxIdQuery->fetch(PDO::FETCH_ASSOC);
            $maxId = $maxIdResult['max_id'];
    
            // Insert supplied products
            if ($p_supplied) {
                $suppliedProducts = json_decode($p_supplied, true);
    
                foreach ($suppliedProducts as $product) {
                    $prod_id = $product['productId'];

                    $ingredients_id = 0; 
                    $sqlSuppliedProduct = 'INSERT INTO supplied(prod_id, supplier_id) VALUES (?,?)';
                    $stmtSuppliedProduct = $this->connect()->prepare($sqlSuppliedProduct);
                    $stmtSuppliedProduct->execute([$prod_id, $maxId]);
                }
            }

            if($i_supplied){
                $suppliedIngredients = json_decode($i_supplied, true);

                foreach ($suppliedIngredients as $ingredients) {
                    $ingredients_id = $ingredients['ingredientsId'];

                    $sqlSuppliedIngredients = 'INSERT INTO supplied(ingredients_id, supplier_id) VALUES (?,?)';
                    $stmtSuppliedIngredients = $this->connect()->prepare($sqlSuppliedIngredients);
                    $stmtSuppliedIngredients->execute([$ingredients_id, $maxId]);
                }
            }
            return true;
        } else {
            echo "Insertion failed.";
            return false;
        }
        

    }
    public function get_allSuppliers()
    {
        $stmt = $this->connect()->prepare("SELECT supplier, id FROM supplier");
        $stmt->execute();
        return $stmt;
    }
    public function getSupplierAndSuppliedData($searchQuery){
        if ($searchQuery !== null && $searchQuery !== '') {
            $sql = 'SELECT s.id as id, s.supplier as name,s.contact as contact, s.email as email, s.company as company, s.is_active as status FROM `supplier` as s';

            if (!empty($searchQuery)) {
            $sql .= ' WHERE 
                s.supplier LIKE :searchQuery 
                OR s.contact  LIKE :searchQuery 
                OR  s.email LIKE :searchQuery 
                OR s.company LIKE :searchQuery';
            }

            $stmt = $this->connect()->prepare($sql);

            if (!empty($searchQuery)) {
            $searchParam = "%$searchQuery%";
            $stmt->bindParam(':searchQuery', $searchParam);
            }

            $stmt->execute();
            return $stmt;

        }else{
        $sql = "SELECT s.id as id, s.supplier as name,s.contact as contact, s.email as email, s.company as company, s.is_active as status FROM `supplier` as s";
        $stmt = $this->connect()->query($sql);
        return $stmt;
        }
    }
    public function getSuppliedProducts($supplier_id){

        $sql = "SELECT sd.id as id, sd.prod_id as productId, p.prod_desc as name FROM supplied as sd 
        INNER JOIN products as p ON p.id = sd.prod_id WHERE  prod_id IS NOT NULL AND sd.supplier_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$supplier_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getSuppliedIng($supplier_id){
        $sql = "SELECT sd.id as id, sd.ingredients_id as ingredientsId, i.name as name FROM supplied as sd 
        INNER JOIN ingredients as i ON i.id = sd.ingredients_id WHERE ingredients_id IS NOT NULL AND sd.supplier_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$supplier_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function updateSupplier($formData){
        $s_name = $formData['supplierName'] ?? null;
        $s_contact =  $formData['supplierContact'] ?? null;
        $s_email =  $formData['supplierEmail'] ?? null;
        $s_company =  $formData['supplierCompany'] ?? null;
        $s_status =  $formData['supplierStatus'] ?? null;
        $id =  $formData['id'] ?? null;
    
        $sql = 'UPDATE supplier SET 
                 supplier = ?,
                 contact = ?,
                 email = ?,
                 company = ?,
                 is_active = ?
                 WHERE id = ?';
    
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$s_name, $s_contact, $s_email, $s_company, $s_status, $id]);
    
        return $stmt;
    }
     
}
