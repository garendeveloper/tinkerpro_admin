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
    }
?>