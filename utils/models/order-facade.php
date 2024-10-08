<?php
class OrderFacade extends DBConnection
{

    public function get_totalOrders()
    {
        $sql = $this->connect()->prepare("SELECT 
                                                orders.*, supplier.*, orders.id as order_id
                                            FROM 
                                                orders
                                            INNER JOIN supplier ON supplier.id = orders.supplier_id
                                            WHERE orders.is_received = 0
                                            GROUP BY orders.id, supplier.supplier");

        $sql->execute();
        return $sql->rowCount();
    }
    public function get_allOrders($searchInput, $offset, $recordsPerPage)
    {
        if(!empty($searchInput))
        {
            $sql = $this->connect()->prepare("SELECT 
                                                orders.*, supplier.*, orders.id as order_id
                                            FROM 
                                                orders
                                            INNER JOIN supplier ON supplier.id = orders.supplier_id
                                            WHERE orders.po_number LIKE :searchQuery OR 
                                                supplier.supplier LIKE :searchQuery OR 
                                                orders.due_date LIKE :searchQuery
                                            GROUP BY orders.id, supplier.supplier
                                            ORDER BY orders.po_number ASC LIMIT  $offset, $recordsPerPage");

            $searchParam = $searchInput . "_%";
            $sql->bindParam(':searchQuery', $searchParam, PDO::PARAM_STR);
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            $sql = $this->connect()->prepare("SELECT 
                                                    orders.*, supplier.*, orders.id as order_id
                                                FROM 
                                                    orders
                                                INNER JOIN supplier ON supplier.id = orders.supplier_id
                                                GROUP BY orders.id, supplier.supplier");

            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    public function fetch_products()
    {
        $stmt = $this->connect()->prepare("SELECT products.*, orders.*
                                           FROM products
                                            ");
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
    public function delete_purchaseOrder($order_id)
    {
        $sql = "DELETE FROM orders WHERE id = :id";
        $stmt1 = $this->connect()->prepare($sql);
        $stmt1->bindParam(":id", $order_id);
        $stmt1->execute();

        $inventory = "DELETE FROM inventory WHERE order_id = :order_id";
        $stmt2 = $this->connect()->prepare($inventory);
        $stmt2->bindParam(":order_id", $order_id);
        $stmt2->execute();

        return [
            'status' => true,
            'message' => "Purchase order has been successfully removed!"  
        ];
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
        foreach ($data as $row) 
        {
            $tbl_data[] = [
                'isFullyReceived' => $row['totalQty'] == $row['totalReceived'] ? 1 : 0,
                'order_id' => $row['order_id'],
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
    public function get_orderDataById($id)
    {
        $sql = "SELECT orders.*, products.*, supplier.*, inventory.*, inventory.id as inventory_id
                FROM orders
                INNER JOIN inventory ON orders.id = inventory.order_id 
                INNER JOIN supplier ON supplier.id = orders.supplier_id
                INNER JOIN products ON products.id = inventory.product_id
                WHERE orders.id = :id";

        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
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
    public function get_realtime_orderExpirations()
    {
        $sql = $this->connect()->prepare('
                                            SELECT *
                                            FROM orders 
                                            WHERE due_date BETWEEN CURDATE() AND CURDATE() + INTERVAL orders.term DAY
                                            AND orders.isReccurring = 1
                                            AND orders.isPaid = 0
                                            AND orders.isNotification = 1');
        $sql->execute();
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $data;
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
    public function get_paymentHistory($order_id)
    {
        
        $sql = $this->connect()->prepare("SELECT order_payments.*, payment_method.*
                                        FROM order_payments 
                                        INNER JOIN orders ON order_payments.order_id = orders.id
                                        LEFT JOIN payment_method ON order_payments.payment_method_id = payment_method.id
                                        WHERE orders.id = $order_id");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function get_unpaidPurchases($startDate, $endDate, $supplier)
    {
        $sql = "";
        if(empty($supplier))
        {
            $sql = "SELECT orders.*, supplier.supplier, inventory.total
                    FROM orders
                    INNER JOIN supplier ON supplier.id = orders.supplier_id
                    INNER JOIN inventory ON inventory.order_id = orders.id
                    WHERE orders.isPaid = 0
                    AND (orders.date_purchased BETWEEN :startDate AND :endDate)
                    ORDER BY orders.id ASC";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
            $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            $sql = "SELECT orders.*, supplier.supplier, inventory.total
                    FROM orders
                    INNER JOIN supplier ON supplier.id = orders.supplier_id
                    INNER JOIN inventory ON inventory.order_id = orders.id
                    WHERE orders.isPaid = 0
                    AND (orders.date_purchased BETWEEN :startDate AND :endDate)
                    AND supplier.id = :supplier_id
                    ORDER BY orders.id ASC";

            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
            $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
            $stmt->bindParam(':supplier_id', $supplier, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}
?>