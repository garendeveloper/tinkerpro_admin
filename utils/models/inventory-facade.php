<?php
    class InventoryFacade extends DBConnection
    {
        public function get_allInventories($page, $perPage)
        {
            $offset = ($page - 1) * $perPage;
            $sql = $this->connect()->prepare("SELECT SUPPLIER.*, PRODUCTS.*, INVENTORY.* FROM SUPPLIER, PRODUCTS, INVENTORY WHERE SUPPLIER.ID = INVENTORY.SUPPLIER_ID AND PRODUCTS.ID = INVENTORY.PRODUCT_ID LIMIT :offset, :perPage");
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
            $sql = "SELECT id FROM products WHERE prod_desc = :prod_desc";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':prod_desc', $product);
            $stmt->execute();

            $result = $stmt->fetchColumn();
            return $result;
          
        }
        public function save_supplier($supplier)
        {
            $sql = "SELECT id FROM supplier WHERE supplier = :value";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':value', $supplier);
            $stmt->execute();
           
            if ($stmt->rowCount() > 0) 
            {
                $result = $stmt->fetchColumn();
                return $result;
            } 
            else 
            {
                $sqlStatement = $this->connect()->prepare("INSERT INTO supplier (supplier) VALUES (?)");
                $sqlStatement->bindParam(1, $supplier, PDO::PARAM_STR);
                $sqlStatement->execute();

                return $this->connect()->insert_id();
            }
        }
        public function validateData($formData)
        {  
            $errors = [];

            $validationRules = [
                'pcs_no' => 'Pieces number is required',
                'date_purchased' => 'Date purchased is required',
                'supplier' => 'Supplier is required',
                'product' => 'Product ID is required'
            ];

            if (!isset($_POST['isPaid']) && $_POST['isPaid'] !== 'on')
            {
                $errors['isPaid'] = 'The item should be marked as paid.';
            }
            
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
            if($this->validateData($formData))
            {
                $tbldata = json_decode($formData['data'], true);
                $supplier_id = $this->save_supplier($formData['supplier']);
                $pcs_no = $formData['pcs_no'];
                $date_purchased = $formData['date_purchased'];
                $isPaid = $formData['isPaid'] ? 1 : 0;
    
                foreach($tbldata as $row)
                {
                    $product = $row['column_1'];
                    $b_s = $row['column_2'];
                    $quantity = $row['column_3'];
                    $price = $row['column_4'];
                    $total = $row['column_5'];
                    $status = 1;
                    $type = 1;
                    $parts = explode(":", $b_s);
                    $serial_number="";
                    $batch_no = $parts[0];
                    if(count($parts) > 1) 
                    {
                        $serial_number = $parts[1];
                    }
                    $product_id = $this->get_productInfo($product);
    
                    $sqlStatement = $this->connect()->prepare("INSERT INTO inventory (supplier_id, product_id, date_purchased,  pcs_no, qty_purchased, serial_number, amount_beforeTax, amount_afterTax, isPaid, status, batch_no, type) 
                                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $sqlStatement->bindParam(1, $supplier_id, PDO::PARAM_STR);
                    $sqlStatement->bindParam(2, $product_id, PDO::PARAM_STR);
                    $sqlStatement->bindParam(3, $date_purchased, PDO::PARAM_STR);
                    $sqlStatement->bindParam(4, $pcs_no, PDO::PARAM_STR);
                    $sqlStatement->bindParam(5, $quantity, PDO::PARAM_STR);
                    $sqlStatement->bindParam(6, $serial_number, PDO::PARAM_STR);
                    $sqlStatement->bindParam(7, $price, PDO::PARAM_STR);
                    $sqlStatement->bindParam(8, $price, PDO::PARAM_STR);
                    $sqlStatement->bindParam(9, $isPaid, PDO::PARAM_STR);
                    $sqlStatement->bindParam(10, $status, PDO::PARAM_STR);
                    $sqlStatement->bindParam(11, $batch_no, PDO::PARAM_STR);    
                    $sqlStatement->bindParam(12, $type, PDO::PARAM_STR);
                    $sqlStatement->execute();
                }
                return ['status'=>true, 'message'=>'Purchase Orders has been successfully submitted'];   
            }
            else
            {
                return [
                    'status' => false,
                    'errors' => $this->validateData($formData),
                ];
            }
        }
    }
?>