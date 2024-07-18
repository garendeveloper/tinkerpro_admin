<?php
    class Loss_and_damage_facade extends DBConnection
    {
        public function get_last_lossanddamages_id()
        {
            $sql = "SELECT * FROM loss_and_damages ORDER BY id DESC LIMIT 1";
            $result = $this->connect()->prepare($sql);
            $result->execute();
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return empty($row) ? 0 : $row["id"];
        }
        public function check_lossanddamageinfo_exist($reference_no)
        {
            $sql = $this->connect()->prepare("SELECT * FROM loss_and_damage_info WHERE reference_no = :ref_no");
            $sql->bindParam(":ref_no", $reference_no, PDO::PARAM_STR);
            $sql->execute();
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            return empty($row) ? false : $row["id"];
        }
        public function get_last_lostanddamageinfo_id()
        {
            $sql = "SELECT * FROM loss_and_damage_info ORDER BY id DESC LIMIT 1";
            $result = $this->connect()->prepare($sql);
            $result->execute();
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return empty($row) ? 0 : $row["id"];
        }
        public function get_last_lostanddamageinfo_byID($id)
        {
            $sql = "SELECT * FROM loss_and_damage_info WHERE id = :id";
            $result = $this->connect()->prepare($sql);
            $result->bindParam(':id', $id);
            $result->execute();
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
        public function get_all_lostanddamageinfo()
        {
            $sql = "SELECT * FROM loss_and_damage_info ORDER BY id ASC";
            $result = $this->connect()->prepare($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_lostanddamage_data($id)
        {
            $sql = "SELECT
                        products.*,
                        loss_and_damages.*,
                        loss_and_damages.id AS loss_and_damage_id
                    FROM
                        products
                    JOIN
                        loss_and_damages ON products.id = loss_and_damages.inventory_id
                    WHERE
                        loss_and_damages.loss_and_damage_info_id = :ref_id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":ref_id", $id);
            $stmt->execute();
            $data =  $stmt->fetchAll(PDO::FETCH_ASSOC);
            $info = $this->get_last_lostanddamageinfo_byID($id);
            return [
                'info'=> $info,
                'data'=> $data,
            ];
        }
        public function get_latest_reference_no()
        {
            $id = $this->get_last_lostanddamageinfo_id() ??0;
            return $this->generateString($id + 1);
        }
        function generateString($id)
        {
            $paddedId = str_pad($id, 9, '0', STR_PAD_LEFT);
            $result = "50-" . $paddedId;
            return $result;
        }
        public function remove_nonBreakingSpace($string)
        {
            return preg_replace('/[^\d.]/', '', $string);
        }
        public function clean_number($number)
        {
            $number = str_replace(["₱", ",", " ",], "", $number);
            return $number;
        }
        public function delete_lossanddamage($id, $reference_no, $user)
        {
            $sql = $this->connect()->prepare("SELECT * FROM loss_and_damages WHERE loss_and_damage_info_id = :info_id");
            $sql->execute([':info_id'=>$id]);
            $declared_products = $sql->fetchAll(PDO::FETCH_ASSOC);

            $document_number = $reference_no;
            $stock_user = $user;
            foreach($declared_products as $dp)
            {
                $product_id = $dp['inventory_id'];
                $return_qty = "+".$dp['qty_damage'];
                $current_stock = $this->get_productInfo($dp['inventory_id'])['product_stock'];
                $new_stock = $current_stock + $dp['qty_damage'];
                $currentDate = date('Y-m-d h:i:s');
                $transaction_type = "Return Loss and Damage";
                $stmt = $this->connect()->prepare("INSERT INTO stocks (inventory_id, stock_customer, stock_qty, stock, document_number, transaction_type, date)
                                                    VALUES (?, ?, ?, ?, ?, ?, ?)");
    
                $stmt->bindParam(1, $product_id, PDO::PARAM_INT);
                $stmt->bindParam(2, $stock_user, PDO::PARAM_STR); 
                $stmt->bindParam(3, $return_qty, PDO::PARAM_STR); 
                $stmt->bindParam(4, $new_stock, PDO::PARAM_STR); 
                $stmt->bindParam(5, $document_number, PDO::PARAM_STR); 
                $stmt->bindParam(6, $transaction_type, PDO::PARAM_STR); 
                $stmt->bindParam(7, $currentDate, PDO::PARAM_STR); 
                $stmt->execute();

                $product = $this->connect()->prepare("UPDATE products SET product_stock = :new_stock WHERE id = :prod_id");
                $product->execute([
                    ':new_stock'=>$new_stock,
                    ':prod_id'=>$product_id
                ]);
            }

            $expense_stmt = $this->connect()->prepare("DELETE FROM expenses WHERE invoice_number = :invoice_number");
            $expense_stmt->execute([
                ':invoice_number'=>$reference_no
            ]);

            $lossanddamage_stmt = $this->connect()->prepare("DELETE FROM loss_and_damages WHERE loss_and_damage_info_id = :info_id ");
            $lossanddamage_stmt->execute([
                ':info_id'=>$id,
            ]);

            $lossanddamageinfo_stmt = $this->connect()->prepare("DELETE FROM loss_and_damage_info WHERE id = :id ");
            $lossanddamageinfo_stmt->execute([
                ':id'=>$id,
            ]);

            return [
                'success'=>true,
                'message'=>'Item with reference no: '.$reference_no.' has been succesully removed',
            ];
        }
        public function save_loss_and_damage($formData)
        {
            date_default_timezone_set('Asia/Manila');
            
            $tbl_data = json_decode($formData["tbl_data"], true);
            $sub_row_data = json_decode($formData["sub_row_data"], true);
            $serializedFormData = $formData['loss_and_damage_form'];
            $note = $formData['note'];
            $loss_and_damage_form = [];
            parse_str($serializedFormData, $loss_and_damage_form);
            $reference_no = $loss_and_damage_form['ref'];
            $date_transact = date('Y-m-d', strtotime($loss_and_damage_form['date_damage']));
            $reason = $loss_and_damage_form['ld_reason'];
            $other_reason = "N/A";
            
            $total_qty = $this->remove_nonBreakingSpace($this->clean_number($formData["total_qty"])) ;
            $total_cost = $this->remove_nonBreakingSpace($this->clean_number($formData["total_cost"]));
            $over_all_total_cost = $this->remove_nonBreakingSpace($this->clean_number($formData['over_all_total_cost']));
            $currentDate = date("Y-m-d");
            $loss_and_damage_info_id = 0;
            if($this->check_lossanddamageinfo_exist($reference_no))
            {
                $loss_and_damage_info_id = $this->check_lossanddamageinfo_exist($reference_no);
            }
            else
            {
                $stmt = $this->connect()->prepare("INSERT INTO loss_and_damage_info (reference_no, reason, other_reason, date_transact, total_qty, total_cost, over_all_total_cost, note)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bindParam(1, $reference_no, PDO::PARAM_STR);
                $stmt->bindParam(2, $reason, PDO::PARAM_STR);
                $stmt->bindParam(3, $other_reason, PDO::PARAM_STR);
                $stmt->bindParam(4, $date_transact, PDO::PARAM_STR);
                $stmt->bindParam(5, $total_qty, PDO::PARAM_STR);
                $stmt->bindParam(6, $total_cost, PDO::PARAM_STR);
                $stmt->bindParam(7, $over_all_total_cost, PDO::PARAM_STR);
                $stmt->bindParam(8, $note, PDO::PARAM_STR);
                $stmt->execute();
    
                $loss_and_damage_info_id = $this->get_last_lostanddamageinfo_id();
            }
            foreach($tbl_data as $row)
            {
                $inventory_id = $row['inventory_id'];
                $qty_damage = $row['qty_damage'];
                $cost = $this->remove_nonBreakingSpace($this->clean_number($row['col_3']));
                $sub_total = $this->remove_nonBreakingSpace($this->clean_number($row['col_4']));

                $stmt = $this->connect()->prepare("INSERT INTO loss_and_damages (inventory_id, loss_and_damage_info_id, qty_damage, cost, total_cost)
                                                    VALUES (?,?, ?, ?, ?)");
                $stmt->bindParam(1, $inventory_id, PDO::PARAM_INT);
                $stmt->bindParam(2, $loss_and_damage_info_id, PDO::PARAM_STR);
                $stmt->bindParam(3, $qty_damage, PDO::PARAM_STR);
                $stmt->bindParam(4, $cost, PDO::PARAM_STR);
                $stmt->bindParam(5, $sub_total, PDO::PARAM_STR);
                $stmt->execute();

                $loss_and_damage_id = $this->get_last_lossanddamages_id();

                $currentStock = $this->get_productInfo($inventory_id)['product_stock'];
                $new_stock = $currentStock - $qty_damage;
                $stmt = $this->connect()->prepare("UPDATE products SET product_stock = :new_stock WHERE id = :id");
                $stmt->bindParam(":new_stock", $new_stock); 
                $stmt->bindParam(":id", $inventory_id); 
                $stmt->execute();
    
               
                $currentDate = date('Y-m-d h:i:s');
                $qty_damage = $this->makeNegative($qty_damage);
                $stock_customer = $formData['user_name'];
                $document_number = $reference_no;
                $transaction_type = "Loss and Damage (".$reason." )";
                $stmt = $this->connect()->prepare("INSERT INTO stocks (inventory_id, stock_customer, stock_qty, stock, document_number, transaction_type, date)
                                                    VALUES (?, ?, ?, ?, ?, ?, ?)");
    
                $stmt->bindParam(1, $inventory_id, PDO::PARAM_INT);
                $stmt->bindParam(2, $stock_customer, PDO::PARAM_STR); 
                $stmt->bindParam(3, $qty_damage, PDO::PARAM_STR); 
                $stmt->bindParam(4, $new_stock, PDO::PARAM_STR); 
                $stmt->bindParam(5, $document_number, PDO::PARAM_STR); 
                $stmt->bindParam(6, $transaction_type, PDO::PARAM_STR); 
                $stmt->bindParam(7, $currentDate, PDO::PARAM_STR); 
                $stmt->execute();

                $expense_quantity = $qty_damage;
                $expense_type = "LOSS AND DAMAGE";
                $supplier_id = 0;
                $invoice_number = $reference_no;
                $price = $cost;
                $total_amount = $sub_total;
                $date_of_transaction = date('Y-m-d');
                $uom_id_expense = $this->get_productInfo($inventory_id)['uom_id'];

                $expense_stmt = $this->connect()->prepare("
                    INSERT INTO expenses (product_id, date_of_transaction, expense_type, quantity, uom_id, supplier, invoice_number, price, total_amount)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ? )
                ");

                $expense_stmt->bindParam(1, $inventory_id, PDO::PARAM_STR);
                $expense_stmt->bindParam(2, $date_of_transaction, PDO::PARAM_STR);
                $expense_stmt->bindParam(3, $expense_type, PDO::PARAM_STR);
                $expense_stmt->bindParam(4, $expense_quantity, PDO::PARAM_INT);
                $expense_stmt->bindParam(5, $uom_id_expense, PDO::PARAM_INT);
                $expense_stmt->bindParam(6, $supplier_id, PDO::PARAM_INT);
                $expense_stmt->bindParam(7, $invoice_number, PDO::PARAM_STR);
                $expense_stmt->bindParam(8, $price, PDO::PARAM_STR);
                $expense_stmt->bindParam(9, $total_amount, PDO::PARAM_STR);
                $expense_stmt->execute();

                if(isset($sub_row_data))
                {
                    foreach($sub_row_data as $sr)
                    {
                        $serial_id = $sr['serial_id']; 
                        $is_check = $sr['is_serialCheck'];
                        if($is_check)
                        {
                            $stmt = $this->connect()->prepare("INSERT INTO serialized_loss_and_damage (serial_id, loss_and_damage_id)
                                                                VALUES (?, ?)");
                            $stmt->bindParam(1, $serial_id, PDO::PARAM_STR);
                            $stmt->bindParam(2, $loss_and_damage_id, PDO::PARAM_STR);
                            $stmt->execute();
                        }
                    }
                }
            }
            return [
                'status'=>true,
                'msg'=>'loss and damage has been successfully saved'
            ];
        }
        public function makeNegative($qty_damage) 
        {
            $qty_damage = (float)$qty_damage;
            
            if ($qty_damage > 0) {
                $qty_damage = -$qty_damage;
            }
            
            return $qty_damage;
        }
        public function get_productInfo($product)
        {
            $sql = "SELECT *, isVat, product_stock FROM products WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':id', $product, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
        public function get_consolidatedLossAndDamages($startDate, $endDate, $singleDate)
        {
            $stmt = $this->connect()->prepare("SELECT SUM(loss_and_damages.total_cost) AS totalAmountDamage
                                                FROM loss_and_damages
                                                INNER JOIN products ON products.id = loss_and_damages.inventory_id
                                                INNER JOIN loss_and_damage_info ON loss_and_damage_info.id = loss_and_damages.loss_and_damage_info_id
                                                WHERE 
                                                (:singleDateParam IS NOT NULL AND loss_and_damage_info.date_transact = :singleDateParam) OR
                                                (:startDateParam IS NOT NULL AND :endDateParam IS NOT NULL AND loss_and_damage_info.date_transact BETWEEN :startDateParam AND :endDateParam) OR
                                                (:singleDateParam IS NULL AND :startDateParam IS NULL AND :endDateParam IS NULL AND loss_and_damage_info.date_transact = CURDATE())");
        
            $params = [];
        
            if (!empty($singleDate)) {
                $params[':singleDateParam'] = $singleDate;
            } else {
                $params[':singleDateParam'] = null;
            }
        
            if (!empty($startDate)) {
                $params[':startDateParam'] = $startDate;
            } else {
                $params[':startDateParam'] = null;
            }
        
            if (!empty($endDate)) {
                $params[':endDateParam'] = $endDate;
            } else {
                $params[':endDateParam'] = null;
            }
        
            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
    }