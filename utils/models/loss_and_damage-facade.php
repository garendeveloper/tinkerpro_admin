<?php
    class Loss_and_damage_facade extends DBConnection
    {
        public function get_last_id()
        {
            $sql = "SELECT * FROM loss_and_damages ORDER BY id DESC LIMIT 1";
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
        public function save_loss_and_damage($formData)
        {
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

            $loss_and_damage_id = $this->get_last_id();
          
            foreach($tbl_data as $row)
            {
                $inventory_id = $row['inventory_id'];
                $qty_damage = $row['qty_damage'];
                $cost = $this->remove_nonBreakingSpace($this->clean_number($row['col_3']));
                $sub_total = $this->remove_nonBreakingSpace($this->clean_number($row['col_4']));

                $is_lossOrDamage = 1;
                $stmt = $this->connect()->prepare("UPDATE inventory SET is_lossOrDamage = :v1 WHERE id = :id");
                $stmt->bindParam(":v1", $is_lossOrDamage);
                $stmt->bindParam(":id", $inventory_id);
                $stmt->execute();

                $stmt = $this->connect()->prepare("INSERT INTO loss_and_damages (inventory_id, loss_and_damage_info_id, qty_damage, cost, total_cost)
                                                    VALUES (?,?, ?, ?, ?)");
                $stmt->bindParam(1, $inventory_id, PDO::PARAM_INT);
                $stmt->bindParam(2, $loss_and_damage_id, PDO::PARAM_STR);
                $stmt->bindParam(3, $qty_damage, PDO::PARAM_STR);
                $stmt->bindParam(4, $cost, PDO::PARAM_STR);
                $stmt->bindParam(5, $sub_total, PDO::PARAM_STR);
                $stmt->execute();

                $stmt = $this->connect()->prepare("UPDATE stocks SET stock = stock - :quantity WHERE inventory_id = :id");
                $stmt->bindParam(":quantity", $qty_damage); 
                $stmt->bindParam(":id", $inventory_id); 
                $stmt->execute();
                
                if(isset($sub_row_data))
                {
                    foreach($sub_row_data as $sr)
                    {
                        $serial_number = $sr['serial_number'];
                        $is_check = $sr['is_serialCheck'];
                        if($is_check)
                        {
                            $stmt = $this->connect()->prepare("UPDATE serialized_product SET is_lossOrDamage = :v1 WHERE serial_number = :serial_number");
                            $stmt->bindParam(":v1", $is_lossOrDamage);
                            $stmt->bindParam(":serial_number", $serial_number);
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
    }