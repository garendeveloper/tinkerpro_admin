<?php
class OrderFacade extends DBConnection
{
    public function get_allOrders($page, $perPage)
    {
        $offset = ($page - 1) * $perPage;
        $sql = $this->connect()->prepare("SELECT orders.*, supplier.*, orders.id as order_id
                                            FROM orders
                                            INNER JOIN supplier
                                            ON supplier.id = orders.supplier_id
                                            ORDER BY orders.id DESC; LIMIT :offset, :perPage ");

        $sql->bindParam(':offset', $offset, PDO::PARAM_INT);
        $sql->bindParam(':perPage', $perPage, PDO::PARAM_INT);
        $sql->execute();
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }
    public function get_allPurchaseOrders()
    {
        $sql = "SELECT orders.*, supplier.*
                FROM orders
                INNER JOIN supplier ON supplier.id = orders.supplier_id
                ORDER BY orders.po_number asc";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function get_allTheSerialized($inventory_id)
    {
        $sql = "SELECT serialized_product.*, inventory.*, serialized_product.serial_number,serialized_product.id as serial_id
                FROM serialized_product
                INNER JOIN inventory ON inventory.id = serialized_product.inventory_id 
                WHERE inventory.id = :inventory_id";

        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':inventory_id', $inventory_id, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    public function get_orderDataByPurchaseNumber($po_number)
    {
        $sql = "SELECT orders.*, products.*, supplier.*, inventory.*, inventory.id as inventory_id
                FROM orders
                INNER JOIN inventory ON orders.id = inventory.order_id 
                INNER JOIN supplier ON supplier.id = orders.supplier_id
                INNER JOIN products ON products.id = inventory.product_id
                WHERE orders.po_number = :po_number";

        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':po_number', $po_number, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $tbl_data = [];
        foreach ($data as $row) {
            $tbl_data[] = [
                'inventory_id' => $row['inventory_id'],
                'po_number' => $row['po_number'],
                'date_purchased' => $row['date_purchased'],
                'supplier' => $row['supplier'],
                'isSelected' => $row['isSelected'],
                'isSerialized' => $row['isSerialized'],
                'qty_received' => $row['qty_received'],
                'qty_purchased' => $row['qty_purchased'],
                'prod_desc' => $row['prod_desc'],
                'date_expired' => $row['date_expired'],
                'stock'=>$row['stock'],
                'isReceived'=>$row['isReceived'],
                'is_received'=>$row['is_received'],
                'isPaid'=>$row['isPaid'],
                'sub_row'=>$this->get_allTheSerialized($row['inventory_id']),
            ];
        }
        return $tbl_data;
    }
    public function get_orderData($order_id)
    {
        $sql = "SELECT orders.*, products.*, supplier.*, inventory.*, inventory.id as inventory_id
                FROM orders
                INNER JOIN inventory ON orders.id = inventory.order_id 
                INNER JOIN supplier ON supplier.id = orders.supplier_id
                INNER JOIN products ON products.id = inventory.product_id
                WHERE orders.id = :order_id";

        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>