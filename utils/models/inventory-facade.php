<?php
    class InventoryFacade extends DBConnection
    {
        public function get_allInventories($page, $perPage)
        {
            $offset = ($page - 1) * $perPage;
            $sql = $this->connect()->prepare("SELECT supplier.*, products.*, inventory.*, uom.* FROM supplier, products, inventory, uom WHERE supplier.ID = inventory.supplier_id AND products.id = inventory.product_id AND uom.id = products.uom_id LIMIT :offset, :perPage");
            $sql->bindParam(':offset', $offset, PDO::PARAM_INT);
            $sql->bindParam(':perPage', $perPage, PDO::PARAM_INT);
            $sql->execute();
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        }
        public function get_allSuppliers()
        {
            $sqlStatement = $this->connect()->prepare("SELECT * FROM supplier");
            $sqlStatement->execute();
            return $sqlStatement->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_productInfo($product)
        {
            $data = explode(":", $product);
            $data = array_map('trim', $data);
            $prod_desc = $data[0];
            $barcode = $data[1];

            $sql = "SELECT id, isVat FROM products WHERE prod_desc = :prod_desc and barcode = :barcode";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':prod_desc', $prod_desc, PDO::PARAM_STR);
            $stmt->bindParam(':barcode', $barcode, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
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
        public function get_purchaseOrderNo()
        {
            $sql = "SELECT * FROM inventory ORDER BY id DESC LIMIT 1";
            $result = $this->connect()->prepare($sql);
            $result->execute();
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
        public function fetch_latestPONo()
        {
            return $this->generateString($this->get_purchaseOrderNo()['pcs_no']+1);
        }
        function generateString($id) 
        {
            $paddedId = str_pad($id, 9, '0', STR_PAD_LEFT);
            $result = "10-" . $paddedId;
            return $result;
        }
        public function save_purchaseOrder($formData)
        {
            if($this->validateData($formData))
            {
                $tbldata = json_decode($formData['data'], true);
                $supplier_id = $this->save_supplier($formData['supplier']);
                $date_purchased = $formData['date_purchased'];
                $isPaid = $formData['isPaid'] ? 1 : 0;
                $lastId = $this->get_purchaseOrderNo()['pcs_no'];

                foreach($tbldata as $row)
                {
                    $product = $row['column_1'];
                    $quantity = $row['column_2'];
                    $price = $row['column_3'];
                    $total = $row['column_4'];
                    $status = 1;
                    $type = 1;

                    $product_id = $this->get_productInfo($product)['id'];
                    $isVat = ($this->get_productInfo($product)['isVat'] == 1 ? true : false);
                    
                    $amount_afterTax = 0;
                    if($isVat)
                    {
                        $amount_afterTax = $price/1.12;
                        $amount_afterTax = $price-$amount_afterTax;
                    }
                    
                    $sqlStatement = $this->connect()->prepare("INSERT INTO inventory (supplier_id, product_id, date_purchased, pcs_no, po_number, qty_purchased, amount_beforeTax, amount_afterTax, isPaid, status,type, total) 
                                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                    $sqlStatement->bindParam(1, $supplier_id, PDO::PARAM_STR);
                    $sqlStatement->bindParam(2, $product_id, PDO::PARAM_STR);
                    $sqlStatement->bindParam(3, $date_purchased, PDO::PARAM_STR);
                    $sqlStatement->bindParam(4, $lastId, PDO::PARAM_STR);
                    $sqlStatement->bindParam(5, $this->generateString($lastId), PDO::PARAM_STR);
                    $sqlStatement->bindParam(6, $quantity, PDO::PARAM_STR);
                    $sqlStatement->bindParam(7, $price, PDO::PARAM_STR);
                    $sqlStatement->bindParam(8, $amount_afterTax, PDO::PARAM_STR);
                    $sqlStatement->bindParam(9, $isPaid, PDO::PARAM_STR);
                    $sqlStatement->bindParam(10, $status, PDO::PARAM_STR); 
                    $sqlStatement->bindParam(11, $type, PDO::PARAM_STR);
                    $sqlStatement->bindParam(12, $total, PDO::PARAM_STR);
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