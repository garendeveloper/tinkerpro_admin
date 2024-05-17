<?php
class DashboardFacade extends DBConnection 
{
    public function get_product_total_count()
    {
        $stmt = $this->connect()->prepare("SELECT COUNT(products.id) as total FROM products INNER JOIN inventory ON inventory.product_id = products.id WHERE inventory.isReceived = 1");
        $stmt->execute();
        return $stmt->fetch()["total"] ?? 0;
    }
    public function get_total_sales()
    {
        $stmt = $this->connect()->prepare("SELECT COUNT(id) as total FROM products");
        $stmt->execute();
        return $stmt->rowCount();
    }
}