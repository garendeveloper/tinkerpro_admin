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
    public function get_allTopProducts($item)
    {
        $sql = $this->connect()->prepare("SELECT products.prod_desc as product, 
                                            (payments.payment_amount - payments.change_amount) as total_paid_amount
                                        FROM payments, products, transactions
                                        WHERE payments.id = transactions.payment_id
                                        AND products.id = transactions.prod_id
                                        AND transactions.is_paid = 1
                                        GROUP BY products.id
                                        ORDER by total_paid_amount DESC
                                        LIMIT :item");
        $sql->bindParam(":item", $item, PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}