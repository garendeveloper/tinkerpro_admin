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

                $stmt = $this->connect()->prepare("UPDATE stocks SET stock = :new_stock WHERE inventory_id = :id");
                $stmt->bindParam(":new_stock", $counted); 
                $stmt->bindParam(":id", $inventory_id); 
                $stmt->execute();
            }
            return [
                'status'=>true,
                'msg'=>'Inventory count has been successfully recorded.'
            ];
        }
    }