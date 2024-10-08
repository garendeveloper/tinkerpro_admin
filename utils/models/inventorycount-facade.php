<?php
// use Xendit\PaymentMethod\GetAllPaymentMethodsDefaultResponse;
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

           
            if(isset($inventory_count_info_id) && !empty($inventory_count_info_id))
            {
                $sql = $this->connect()->prepare("UPDATE inventory_count_info SET date_counted = :date_counted WHERE id = :id");
                $sql->execute([
                    ':date_counted' => $date_counted,
                    ':id' => $inventory_count_info_id,
                ]);
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
                    $inventory_count_item_id = $row['inventory_count_item_id'];
                    $difference = $this->clean_number($row['difference']);
    
                    if(!empty($counted))
                    {
                        if(!empty($inventory_count_item_id) && isset($inventory_count_item_id))
                        {
                            $stmt = $this->connect()->prepare("UPDATE inventory_count_items SET inventory_id = :inventory_id,  qty = :qty, counted = :counted, difference = :difference WHERE id = :id ");
                      
                            $stmt->execute([
                                ':inventory_id' => $inventory_id,
                                ':qty' => $qty,
                                ':counted' => $counted,
                                ':difference' => $difference,
                                ':id' => $inventory_count_item_id
                            ]);
                        }
                        else
                        {
                            $stmt = $this->connect()->prepare("INSERT INTO inventory_count_items (inventory_id, inventory_count_info_id, qty, counted, difference)
                                                                VALUES (?,?, ?, ?, ?)");
                            $stmt->bindParam(1, $inventory_id, PDO::PARAM_INT);
                            $stmt->bindParam(2, $inventory_count_info_id, PDO::PARAM_STR);
                            $stmt->bindParam(3, $qty, PDO::PARAM_STR);
                            $stmt->bindParam(4, $counted, PDO::PARAM_STR);
                            $stmt->bindParam(5, $difference, PDO::PARAM_STR);
                            $stmt->execute();
                        }
                       
    
                        $stmt2 = $this->connect()->prepare("UPDATE products SET product_stock = :new_stock WHERE id = :id");
                        $stmt2->bindParam(":new_stock", $counted); 
                        $stmt2->bindParam(":id", $inventory_id); 
                        $stmt2->execute();
    
                        $currentStock = $this->get_productDataById($inventory_id)['product_stock'];
                        date_default_timezone_set('Asia/Manila');
                        $currentDate = date('Y-m-d h:i:s');
                        $stock_customer = $formData['user_name'];
                        $document_number = $reference_no;
                        $transaction_type = "Inventory Count";
                        $difference = $difference > 0 ? "+".$difference : $difference;
                        $stmt1 = $this->connect()->prepare("INSERT INTO stocks (inventory_id, stock_customer, stock_qty, stock, document_number, transaction_type, date)
                                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    
                        $stmt1->bindParam(1, $inventory_id, PDO::PARAM_INT);
                        $stmt1->bindParam(2, $stock_customer, PDO::PARAM_STR); 
                        $stmt1->bindParam(3, $difference, PDO::PARAM_STR); 
                        $stmt1->bindParam(4, $counted, PDO::PARAM_STR); 
                        $stmt1->bindParam(5, $document_number, PDO::PARAM_STR); 
                        $stmt1->bindParam(6, $transaction_type, PDO::PARAM_STR); 
                        $stmt1->bindParam(7, $currentDate, PDO::PARAM_STR); 
                        $stmt1->execute();
                    }
            }
            
            return [
                'status'=>true,
                'msg'=>'Inventory count has been successfully recorded.'
            ];
        }
        
        public function get_productDataById($product_id)
        {
            $sql = "SELECT products.*
                    FROM products
                    WHERE id = :product_id";
    
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":product_id", $product_id);
            $stmt->execute();
            $data =  $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
    
        }

        public function get_inventoryCountDataById($id)
        {
            $info = $this->get_data($id);
            $sql = $this->connect()->prepare('SELECT products.*, inventory_count_items.*, inventory_count_items.qty as counted_qty, inventory_count_items.id as inventory_count_item_id
                                            FROM products
                                            JOIN inventory_count_items ON products.id = inventory_count_items.inventory_id
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
        public function get_allData($searchInput, $offset, $recordsPerPage)
        {
            if(!empty($searchInput))
            {
                $sql = "SELECT *
                        FROM inventory_count_info ic 
                        WHERE   ic.date_counted 
                        LIKE :searchQuery OR 
                        ic.reference_no LIKE :searchQuery";

                $searchParam = $searchInput . "_%";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindParam(':searchQuery', $searchParam, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            else
            {
                $sql = "SELECT * FROM inventory_count_info ic  ORDER BY ic.id ASC LIMIT  $offset, $recordsPerPage";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        public function total_inventoryCounts()
        {
            $sql = "SELECT * FROM inventory_count_info";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            return $stmt->rowCount();
        }
    }