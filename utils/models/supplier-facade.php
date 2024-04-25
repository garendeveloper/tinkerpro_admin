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
    public function getSupplierAndSuppliedData(){
        $sql = "SELECT s.supplier as name,s.contact as contact, s.email as email, s.company as company, s.is_active as status FROM `supplier` as s";
        $stmt = $this->connect()->query($sql);
        return $stmt;
    }
     
}
