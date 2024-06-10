<?php
    class InventoryCountFacade extends DBConnection
    {
        public function check_inventorycountinfo_exist($reference_no)
        {
            $sql = $this->connect()->prepare("SELECT * FROM inventory_count_info WHERE reference_no = :ref_no");
            $sql->bindParam(":ref_no", $reference_no, PDO::PARAM_STR);
            $sql->execute();
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            return empty($row) ? 0 : $row["id"];
        }
        public function get_last_id()
        {
            $sql = "SELECT * FROM inventory_count_info ORDER BY id DESC LIMIT 1";
            $result = $this->connect()->prepare($sql);
            $result->execute();
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return empty($row) ? 0 : $row["id"];
        }
        public function get_latest_reference_no()
        {
            $id = $this->get_last_id() ??0;
            return $this->generateString($id + 1);
        }
        function generateString($id)
        {
            $paddedId = str_pad($id, 9, '0', STR_PAD_LEFT);
            $result = "30-" . $paddedId;
            return $result;
        }
        public function remove_nonBreakingSpace($string)
        {
            return preg_replace('/[^\d.]/', '', $string);
        }
        public function clean_number($number)
        {
            $number = str_replace(["₱", ",", "+", " ",], "", $number);
            return $number;
        }
        public function save_inventory_count($formData)
        {
            $tbl_data = json_decode($formData["tbl_data"], true);
            $reference_no = $formData['reference_no'];
            $inventory_count_info_id = $formData['refer_id'];
            $date_counted = date('Y-m-d', strtotime($formData['date_counted']));

           
            $inventory_count_info_id = 0;
            if($this->check_inventorycountinfo_exist($reference_no) !== 0)
            {
                $inventory_count_info_id = $this->check_inventorycountinfo_exist($reference_no);
            }
            else
            {
                $stmt = $this->connect()->prepare("INSERT INTO inventory_count_info (reference_no, date_counted)
                VALUES (?, ?)");
                $stmt->bindParam(1, $reference_no, PDO::PARAM_STR);
                $stmt->bindParam(2, $date_counted, PDO::PARAM_STR);
                $stmt->execute();
    
                $inventory_count_info_id = $this->get_last_id();
            }
            $currentDate = date("Y-m-d");
            foreach($tbl_data as $row)
            {
                $inventory_id = $row['inventory_id'];
                $qty = $row['qty'];
                $counted = $row['counted'];
                $difference = $this->clean_number($row['difference']);

                $stmt = $this->connect()->prepare("INSERT INTO inventory_count_items (inventory_id, inventory_count_info_id, qty, counted, difference)
                                                    VALUES (?,?, ?, ?, ?)");
                $stmt->bindParam(1, $inventory_id, PDO::PARAM_INT);
                $stmt->bindParam(2, $inventory_count_info_id, PDO::PARAM_STR);
                $stmt->bindParam(3, $qty, PDO::PARAM_STR);
                $stmt->bindParam(4, $counted, PDO::PARAM_STR);
                $stmt->bindParam(5, $difference, PDO::PARAM_STR);
                $stmt->execute();

                // $stmt = $this->connect()->prepare("UPDATE inventory SET stock = :new_stock  WHERE id = :id");
                // $stmt->bindParam(":new_stock", $counted); 
                // $stmt->bindParam(":id", $inventory_id); 
                // $stmt->execute();

                // $stmt = $this->connect()->prepare("INSERT INTO stocks (inventory_id, stock, date)
                //                                     VALUES (?, ?, ?)");
                // $stmt->bindParam(1, $inventory_id, PDO::PARAM_INT);
                // $stmt->bindParam(2, $counted, PDO::PARAM_STR); 
                // $stmt->bindParam(3, $currentDate, PDO::PARAM_STR); 
                // $stmt->execute();
            
                $stmt = $this->connect()->prepare("UPDATE products SET product_stock = :new_stock WHERE id = :id");
                $stmt->bindParam(":counted", $counted); 
                $stmt->bindParam(":id", $inventory_id); 
                $stmt->execute();
    
                $currentStock = $this->get_productDataById($inventory_id)['product_stock'];
                $currentDate = date('Y-m-d H:i:s');
                $stock_customer = $formData['user_name'];
                $document_number = $reference_no;
                $transaction_type = "Inventory Count";
                $stmt = $this->connect()->prepare("INSERT INTO stocks (inventory_id, stock_customer, stock_qty, stock, document_number, transaction_type, date)
                                                    VALUES (?, ?, ?, ?, ?, ?, ?)");
    
                $stmt->bindParam(1, $inventory_id, PDO::PARAM_INT);
                $stmt->bindParam(2, $stock_customer, PDO::PARAM_STR); 
                $stmt->bindParam(3, $currentStock, PDO::PARAM_STR); 
                $stmt->bindParam(4, $counted, PDO::PARAM_STR); 
                $stmt->bindParam(5, $document_number, PDO::PARAM_STR); 
                $stmt->bindParam(6, $transaction_type, PDO::PARAM_STR); 
                $stmt->bindParam(7, $currentDate, PDO::PARAM_STR); 
                $stmt->execute();
            }
           
            return [
                'status'=>true,
                'msg'=>'Inventory count has been successfully recorded.'
            ];
        }
        
        public function get_productDataById($product_id)
        {
            $sql = "SELECT products.*, uom.*
                    FROM products
                    INNER JOIN uom ON uom.id = products.uom_id
                    WHERE products.id = :product_id";
    
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":product_id", $inventory_id);
            $stmt->execute();
            $data =  $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
    
        }

        public function get_inventoryCountDataById($id)
        {
            $info = $this->get_data($id);
            $sql = $this->connect()->prepare('SELECT inventory.*, products.*, inventory_count_items.*, inventory_count_items.qty as counted_qty, inventory_count_items.id as inventory_count_item_id
                                            FROM inventory
                                            JOIN products ON products.id = inventory.product_id
                                            JOIN inventory_count_items ON inventory.id = inventory_count_items.inventory_id
                                            WHERE inventory_count_items.inventory_count_info_id = '.$id.';
                                            ');
            $sql->execute();
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            return [
                'info'=>$info,
                'data'=>$data,
            ];
        }
        
        public function get_activeProducts()
        {
            $sql = $this->connect()->prepare("SELECT * FROM PRODUCTS WHERE status = 1 ORDER BY prod_desc asc");
            $sql->execute();
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        }

        public function get_data($id)
        {
            $sql = $this->connect()->prepare("SELECT * FROM inventory_count_info WHERE id = :id");
            $sql->bindParam(":id", $id, PDO::PARAM_STR);
            $sql->execute();
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
        public function get_allData()
        {
            $sql = "SELECT * FROM inventory_count_info";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }