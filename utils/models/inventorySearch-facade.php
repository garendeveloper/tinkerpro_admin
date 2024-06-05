<?php
    class InventorySearchFacade extends DBConnection
    {
        public function fetchInventories($searchInput)
        {
            $sql = $this->connect()->prepare(" SELECT 
                                                supplier.id AS supplier_id, 
                                                products.id AS product_id, 
                                                products.prod_desc,
                                                products.barcode,
                                                inventory.id AS inventory_id, 
                                                uom.uom_name,
                                                orders.id AS order_id, 
                                                orders.supplier_id,
                                                inventory.stock,
                                                inventory.amount_beforeTax,
                                                inventory.amount_afterTax,
                                                orders.isPaid,
                                                inventory.isReceived,
                                                inventory.qty_purchased
                                            FROM inventory
                                            JOIN products ON products.id = inventory.product_id
                                            JOIN uom ON uom.id = products.uom_id
                                            JOIN orders ON orders.id = inventory.order_id
                                            JOIN supplier ON supplier.id = orders.supplier_id

                                            UNION ALL
                                            
                                            SELECT 
                                                NULL AS supplier_id, 
                                                p.id AS product_id, 
                                                p.prod_desc,
                                                p.barcode,
                                                NULL AS inventory_id, 
                                                u.uom_name,
                                                NULL AS order_id, 
                                                NULL AS supplier_id, 
                                                -1 AS stock,
                                                NULL AS amount_beforeTax,
                                                NULL AS amount_afterTax,
                                                NULL AS isPaid,
                                                NULL AS isReceived,
                                                0 AS qty_purchased
                                            FROM products p
                                            JOIN uom u ON u.id = p.uom_id;
                                            
                                            products.prod_desc LIKE :searchQuery OR 
                                            products.barcode LIKE :searchQuery OR 
                                            products.sku LIKE :searchQuery OR 
                                            products.code LIKE :searchQuery OR 
                                            products.brand LIKE :searchQuery ORDER BY prod_desc ASC LIMIT  10");

            $stmt = $this->connect()->prepare($sql);
            $stmt->
            $stmt->execute();
        }
    }
?>