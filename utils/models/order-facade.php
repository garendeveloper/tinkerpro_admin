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
                INNER JOIN supplier ON supplier.id = orders.supplier_id";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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