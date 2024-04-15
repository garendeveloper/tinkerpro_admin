<?php
    class InventoryFacade extends DBConnection
    {
        public function get_allInventories($page, $perPage)
        {
            $offset = ($page - 1) * $perPage;
            $sql = $this->connect()->prepare("SELECT supplier.*, products.*, inventory.*, uom.*, orders.*, inventory.id as inventory_id
                                            FROM inventory
                                            JOIN products ON products.id = inventory.product_id
                                            JOIN uom ON uom.id = products.uom_id
                                            JOIN orders ON orders.id = inventory.order_id
                                            JOIN supplier ON supplier.id = orders.supplier_id
                                            ORDER BY inventory.id DESC; LIMIT :offset, :perPage");

            $sql->bindParam(':offset', $offset, PDO::PARAM_INT);
            $sql->bindParam(':perPage', $perPage, PDO::PARAM_INT);
            $sql->execute();
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        }
        public function get_allProducts()
        {
            $sql = $this->connect()->prepare("SELECT * FROM products");
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
        public function remove_nonBreakingSpace($string)
        {
            return preg_replace('/[^\d.]/', '', $string);
        }
        public function clean_number($number)
        {
            $number = str_replace(["₱", ",", " ", ], "", $number);
            return $number;
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
        public function get_supplierInfo($supplier)
        {
            $sql = "SELECT * FROM supplier WHERE supplier = :supplier";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':supplier', $supplier, PDO::PARAM_STR);
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
        public function get_lastOrderData()
        {
            $sql = "SELECT * FROM orders ORDER BY id DESC LIMIT 1";
            $result = $this->connect()->prepare($sql);
            $result->execute();
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
        public function verify_order($po_number)
        {
            $sql = "SELECT * FROM orders WHERE po_number = :po_number";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':po_number', $po_number, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->rowCount() > 0 ? true : false;
        }
        public function get_purchaseOrderNo()
        {
            $sql = "SELECT * FROM orders ORDER BY id DESC LIMIT 1";
            $result = $this->connect()->prepare($sql);
            $result->execute();
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
        public function save_order($formData)
        {
            $isPaid = isset($formData['isPaid']) ? 1 : 0;

            $supplier_id = $this->get_supplierInfo($formData['supplier'])['id'];
            $date_purchased = date('Y-m-d', strtotime($formData['date_purchased']));
            $po_number = $formData['po_number'];
            $price = $this->remove_nonBreakingSpace($this->clean_number($formData['total']));
            $totalTax = $this->remove_nonBreakingSpace($this->clean_number($formData['totalTax']));
            $order_type = 1;

            $order_id = $this->get_lastOrderData()['id'];
            if($formData['order_id'] > 0)
            {
                $sqlStatement = $this->connect()->prepare("UPDATE orders 
                                                            SET isPaid = ?, 
                                                                supplier_id = ?, 
                                                                date_purchased = ?, 
                                                                po_number = ?, 
                                                                price = ?, 
                                                                order_type = ?, 
                                                                totalTax = ?
                                                            WHERE id = ?");
                
                $sqlStatement->bindParam(1, $isPaid, PDO::PARAM_STR);
                $sqlStatement->bindParam(2, $supplier_id, PDO::PARAM_STR);
                $sqlStatement->bindParam(3, $date_purchased, PDO::PARAM_STR);
                $sqlStatement->bindParam(4, $po_number, PDO::PARAM_STR);
                $sqlStatement->bindParam(5, $price, PDO::PARAM_STR);
                $sqlStatement->bindParam(6, $order_type, PDO::PARAM_STR);
                $sqlStatement->bindParam(7, $totalTax, PDO::PARAM_STR);
                $sqlStatement->bindParam(8, $id, PDO::PARAM_INT); 
                $sqlStatement->execute();

                $order_id = $formData['order_id'];

                if($isPaid === 1)
                {
                    //Payment transaction here [History ...]
                }   
            }
            else
            {
                if(!$this->verify_order($po_number))
                {
                    $sqlStatement = $this->connect()->prepare("INSERT INTO orders (isPaid, supplier_id, date_purchased, po_number, price, order_type, totalTax) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)");
    
                    $sqlStatement->bindParam(1, $isPaid, PDO::PARAM_STR);
                    $sqlStatement->bindParam(2, $supplier_id, PDO::PARAM_STR);
                    $sqlStatement->bindParam(3, $date_purchased, PDO::PARAM_STR);
                    $sqlStatement->bindParam(4, $po_number, PDO::PARAM_STR);
                    $sqlStatement->bindParam(5, $price, PDO::PARAM_STR);
                    $sqlStatement->bindParam(6, $order_type, PDO::PARAM_STR);
                    $sqlStatement->bindParam(7, $totalTax, PDO::PARAM_STR);
                    $sqlStatement->execute();
    
                    $order_id = $this->get_lastOrderData()['id'];
    
                    if($isPaid === 1)
                    {
                        //Payment transaction here [History ...]
                    }   
                }
            }
           
            return $order_id;
        }
        public function fetch_latestPONo()
        {
            return $this->generateString($this->get_purchaseOrderNo()['id']+1);
        }
        function generateString($id) 
        {
            $paddedId = str_pad($id, 9, '0', STR_PAD_LEFT);
            $result = "10-" . $paddedId;
            return $result;
        }
        public function remove_inventories($inventories)
        {
            foreach($inventories as $inventory_id)
            {
                $sql = "DELETE FROM inventory WHERE id = :id";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindValue(":id", $inventory_id);
                $stmt->execute();
            }
        }
        public function save_purchaseOrder($formData)
        {
            if($this->validateData($formData))
            {
                $tbldata = json_decode($formData['data'], true);
                $order_id = $this->save_order($formData);
                if($formData['order_id'] > 0)
                {   
                    if(isset($formData['remove_inventories'])) 
                    {
                        $this->remove_inventories($formData['remove_inventories']);
                    }
                    foreach($tbldata as $row)
                    {
                        $inventory_id = $row['inventory_id'];
                        $product = $row['column_1'];
                        $quantity = $row['column_2'];
                        $price = $this->remove_nonBreakingSpace($this->clean_number($row['column_3']));
                        $total = $this->remove_nonBreakingSpace($this->clean_number($row['column_4']));
                        $status = 1;
                        $isSelected = 1;
    
                        $product_id = $this->get_productInfo($product)['id'];
                        $isVat = $this->get_productInfo($product)['isVat'] == 1 ? true : false;
                        
                        $amount_beforeTax = $price;
                        $amount_afterTax = 0;
                        $tax = 0;
                        if($isVat)
                        {
                            $tax = $price / 1.12;
                            $amount_afterTax = $price - $tax;
                        }
                        if($inventory_id === 0)
                        {
                            
                            $sqlStatement = $this->connect()->prepare("INSERT INTO inventory (order_id, product_id, qty_purchased, amount_beforeTax, amount_afterTax, status, isSelected, total, tax) 
                                                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

                            $sqlStatement->bindParam(1, $order_id, PDO::PARAM_STR);
                            $sqlStatement->bindParam(2, $product_id, PDO::PARAM_STR);
                            $sqlStatement->bindParam(3, $quantity, PDO::PARAM_STR);
                            $sqlStatement->bindParam(4, $amount_beforeTax, PDO::PARAM_STR);
                            $sqlStatement->bindParam(5, $amount_afterTax, PDO::PARAM_STR);
                            $sqlStatement->bindParam(6, $status, PDO::PARAM_STR);
                            $sqlStatement->bindParam(7, $isSelected, PDO::PARAM_STR);
                            $sqlStatement->bindParam(8, $total, PDO::PARAM_STR);
                            $sqlStatement->bindParam(9, $tax, PDO::PARAM_STR);
                            $sqlStatement->execute();
                        }
                        else
                        {
                            $sql = "UPDATE inventory SET qty_purchased = :v1, amount_beforeTax = :v2, amount_afterTax = :v3, status = :v4, total = :v5, tax = :v6, order_id = :v7, product_id = :v8 WHERE id = :id";
                            $sqlStatement = $this->connect()->prepare($sql);
    
                            $sqlStatement->bindParam(':v1', $quantity);
                            $sqlStatement->bindParam(':v2', $amount_beforeTax);
                            $sqlStatement->bindParam(':v3', $amount_afterTax);
                            $sqlStatement->bindParam(':v4', $status);
                            $sqlStatement->bindParam(':v5', $total);
                            $sqlStatement->bindParam(':v6', $tax);
                            $sqlStatement->bindParam(':v7', $formData['order_id']);
                            $sqlStatement->bindParam(':v8', $product_id);
                            $sqlStatement->bindParam(':id', $inventory_id);
                            $sqlStatement->execute();
                        }
                       
                    }
                }
                else
                {
                    $order_id = $this->save_order($formData);
                    foreach($tbldata as $row)
                    {
                        $product = $row['column_1'];
                        $quantity = $row['column_2'];
                        $price = $this->remove_nonBreakingSpace($this->clean_number($row['column_3']));
                        $total = $this->remove_nonBreakingSpace($this->clean_number($row['column_4']));
                        $status = 1;
                        $isSelected = 1;

                        $product_id = $this->get_productInfo($product)['id'];
                        $isVat = $this->get_productInfo($product)['isVat'] == 1 ? true : false;
                        
                        $amount_beforeTax = $price;
                        $amount_afterTax = 0;
                        $tax = 0;
                        if($isVat)
                        {
                            $tax = $price / 1.12;
                            $amount_afterTax = $price - $tax;
                        }
                        
                        $sqlStatement = $this->connect()->prepare("INSERT INTO inventory (order_id, product_id, qty_purchased, amount_beforeTax, amount_afterTax, status, isSelected, total, tax) 
                                                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

                        $sqlStatement->bindParam(1, $order_id, PDO::PARAM_STR);
                        $sqlStatement->bindParam(2, $product_id, PDO::PARAM_STR);
                        $sqlStatement->bindParam(3, $quantity, PDO::PARAM_STR);
                        $sqlStatement->bindParam(4, $amount_beforeTax, PDO::PARAM_STR);
                        $sqlStatement->bindParam(5, $amount_afterTax, PDO::PARAM_STR);
                        $sqlStatement->bindParam(6, $status, PDO::PARAM_STR);
                        $sqlStatement->bindParam(7, $isSelected, PDO::PARAM_STR);
                        $sqlStatement->bindParam(8, $total, PDO::PARAM_STR);
                        $sqlStatement->bindParam(9, $tax, PDO::PARAM_STR);
                        $sqlStatement->execute();
                    }
                }
                return [
                    'status'=>true, 
                    'message'=>'Purchase Orders has been successfully saved!'
                ];   
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