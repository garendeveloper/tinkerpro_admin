<?php
    class InventoryFacade extends DBConnection
    {
        public function get_allInventories($page, $perPage)
        {
            $offset = ($page - 1) * $perPage;
            $sql = $this->connect()->prepare("SELECT * FROM PRODUCTS LIMIT :offset, :perPage");
            $sql->bindParam(':offset', $offset, PDO::PARAM_INT);
            $sql->bindParam(':perPage', $perPage, PDO::PARAM_INT);
            $sql->execute();
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        }
        public function get_allSuppliers()
        {
            $sqlStatement = $this->connect()->prepare("SELECT * FROM SUPPLIER");
            $sqlStatement->execute();
            return $sqlStatement->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_productInfo($product)
        {
            $sql = "SELECT id FROM products WHERE product_desc = :product_desc";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':product_desc', $product);
            $stmt->execute();
            $primary_key_id = "";

            if ($stmt->rowCount() > 0) 
            {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $primary_key_id = $row[$primary_key_column];
            } 
            return $primary_key_id;
        }
        public function save_supplier($supplier)
        {
            $sql = "SELECT id FROM supplier WHERE supplier = :value";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':value', $supplier);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) 
            {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $primary_key_id = $row[$primary_key_column];
                return $primary_key_id;
            } 
            else 
            {
                $sqlStatement = $this->connect()->prepare("INSERT INTO supplier (supplier) VALUES (?)");
                $sqlStatement->bindParam(1, $supplier, PDO::PARAM_STR);
                $sqlStatement->execute();

                return $this->connect()->lastInsertId();
            }
        }
        public function validateData($formData)
        {  
            $errors = [];

            $validationRules = [
                'pcs_no' => 'Pieces number is required',
                'date_purchased' => 'Date purchased is required',
                'supplier' => 'Supplier is required',
                'isPaid' => 'Payment status is required',
                'product_id' => 'Product ID is required'
            ];

            foreach ($validationRules as $field => $errorMessage) 
            {
                if (empty($formData[$field])) 
                {
                    $errors[$field] = $errorMessage;
                }
            }

            return empty($errors) ? true : $errors;
        }
        public function save_purchaseOrder($formData)
        {
            if(!$this->validateData($formData))
            {
                $supplier_id = $this->save_supplier($formData['supplier']);
                $product_id = $this->get_productInfo($formData['prod_desc']);

                $sqlStatement = $this->connect()->prepare("INSERT INTO inventories (supplier_id, product_id, date_purchased, pcs_no, isPaid, stock, qty_purchased, qty_received, serial_number, amount_beforeTax, amount_afterTax, batch_no, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");    
                $sqlStatement->bindParam(1, $supplier_id, PDO::PARAM_STR);
                $sqlStatement->bindParam(2, $product_id, PDO::PARAM_STR);
                $sqlStatement->bindParam(3, $formData['date_purchased'], PDO::PARAM_STR);
                $sqlStatement->bindParam(4, $formData['pcs_no'], PDO::PARAM_STR);
                $sqlStatement->bindParam(5, $formData['isPaid'], PDO::PARAM_STR);
                $sqlStatement->bindParam(6, 0, PDO::PARAM_STR);
                $sqlStatement->bindParam(7, $formData['qty_purchased'], PDO::PARAM_STR);
                $sqlStatement->bindParam(10, $formData['serial_number'], PDO::PARAM_STR);
                $sqlStatement->bindParam(11, 0.0, PDO::PARAM_STR);
                $sqlStatement->bindParam(12, 0.0, PDO::PARAM_STR);
                $sqlStatement->bindParam(13, $formData['batch_no'], PDO::PARAM_STR);
                $sqlStatement->bindParam(14, 1, PDO::PARAM_STR);
                $sqlStatement->execute();
                
                return [
                    'status'=>true, 
                    'message'=>"Successfully inserted to db"
                ];
            }
            else
            {
                return [
                    'status'=>false, 
                    'errors'=>$this->validateData($formData)
                ];
            }
        }
       
    }
?>