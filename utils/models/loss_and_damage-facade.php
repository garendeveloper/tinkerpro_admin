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
            $id = $this->get_last_id()['id'] ??0;
            return $this->generateString($id + 1);
        }
        function generateString($id)
        {
            $paddedId = str_pad($id, 9, '0', STR_PAD_LEFT);
            $result = "50-" . $paddedId;
            return $result;
        }
    }