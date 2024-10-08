<?php
class InventoryFacade extends DBConnection
{
    public function get_allInventoriesDatatable($requestData)
    {
        $columns = array(
            0 => 'p.id',
            1 => 'p.prod_desc',
            2 => 'p.barcode',
            3 => 'u.uom_name',
            4 => 'all_qty_purchased',
            5 => 'all_qty_received',
            6 => 'p.product_stock',
            7 => 'p.cost',
            8 => 'p.prod_price',
        );
    
        $sql = "SELECT 
                    i.*, p.*, u.uom_name,
                    SUM(p.product_stock) AS total_stock,
                    COUNT(*) as total_count,
                    li.latest_isReceived,
                    li.qty_purchased as all_qty_purchased,
                    li.qty_received as all_qty_received
                FROM 
                    inventory i
                INNER JOIN products p ON p.id = i.product_id
                LEFT JOIN uom u ON u.id = p.uom_id
                LEFT JOIN (
                    SELECT product_id, isReceived as latest_isReceived, qty_purchased, qty_received
                    FROM inventory
                    WHERE (product_id, id) IN (
                        SELECT product_id, MAX(id) as id
                        FROM inventory
                        GROUP BY product_id
                    )
                ) li ON li.product_id = p.id ";
    
        $whereClause = '';
        $params = array();
    
        if (!empty($requestData['search']['value'])) {
            $whereClause .= " WHERE p.prod_desc LIKE :search OR p.barcode LIKE :search OR u.uom_name LIKE :search";
            $params['search'] = "%" . $requestData['search']['value'] . "%";
        }
    
        $sql .= $whereClause . " GROUP BY p.id";
    
        if (!empty($requestData['order'])) {
            $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'];
        } else {
            $sql .= " ORDER BY p.prod_desc ASC";
        }
    
        $sql .= " LIMIT :limit OFFSET :offset";
    
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':limit', $requestData['length'], PDO::PARAM_INT);
        $stmt->bindParam(':offset', $requestData['start'], PDO::PARAM_INT);
        
        foreach ($params as $key => $value) {
            $stmt->bindParam(":$key", $value);
        }
    
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $data;
    }
    
    // public function get_allInventories()
    // {
    //     $requestData = $_REQUEST;
    //     $data = $this->get_allInventoriesDatatable($requestData);
    
    //     $totalData = $totalFiltered = 0;
    //     if (count($data) > 0) {
    //         $totalData = $totalFiltered = $data[0]['total_count'];
    //     }
    
    //     $json_data = array(
    //         "draw" => intval($requestData['draw']),
    //         "recordsTotal" => intval($totalData),
    //         "recordsFiltered" => intval($totalFiltered),
    //         "data" => $data
    //     );
    
    //     return $json_data;
    // }
    public function get_allInventories($searchInput, $offset, $recordsPerPage)
    {
        $sql = "";
        if(!empty($searchInput))
        {
            $sql = $this->connect()->prepare("SELECT 
                                                i.*, p.*, u.uom_name, i.id as inventory_id,
                                                SUM(p.product_stock) AS total_stock,
                                                COUNT(*) as total_count,
                                                li.latest_isReceived,
                                                li.qty_purchased as all_qty_purchased,
                                                li.qty_received as all_qty_received
                                            FROM 
                                                inventory i
                                            INNER JOIN products p ON p.id = i.product_id
                                            LEFT JOIN uom u ON u.id = p.uom_id
                                            LEFT JOIN (
                                                SELECT product_id, isReceived as latest_isReceived, qty_purchased, qty_received
                                                FROM inventory
                                                WHERE (product_id, id) IN (
                                                    SELECT product_id, MAX(id) as id
                                                    FROM inventory
                                                    GROUP BY product_id
                                                )
                                            ) li ON li.product_id = p.id 
                                            WHERE 
                                                p.prod_desc LIKE :searchQuery OR 
                                                p.barcode LIKE :searchQuery OR 
                                                p.brand LIKE :searchQuery 
                                            GROUP BY i.product_id
                                            ORDER BY p.prod_desc ASC LIMIT  10");

            $searchParam = $searchInput . "_%";
            $sql->bindParam(':searchQuery', $searchParam, PDO::PARAM_STR);
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            
            $sql = $this->connect()->prepare("SELECT 
                                                    i.*, p.*, u.uom_name, i.id as inventory_id,
                                                    SUM(p.product_stock) AS total_stock,
                                                    COUNT(*) as total_count,
                                                    li.latest_isReceived,
                                                    li.qty_purchased as all_qty_purchased,
                                                    li.qty_received as all_qty_received
                                                FROM 
                                                    inventory i
                                                INNER JOIN products p ON p.id = i.product_id
                                                LEFT JOIN uom u ON u.id = p.uom_id
                                                LEFT JOIN (
                                                    SELECT product_id, isReceived as latest_isReceived, qty_purchased, qty_received
                                                    FROM inventory
                                                    WHERE (product_id, id) IN (
                                                        SELECT product_id, MAX(id) as id
                                                        FROM inventory
                                                        GROUP BY product_id
                                                    )
                                                ) li ON li.product_id = p.id 
                                                GROUP BY i.product_id
                                                ORDER BY p.prod_desc ASC LIMIT  $offset, $recordsPerPage");
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC);

        }
    }
    public function get_totalInventories()
    {
        $sql = $this->connect()->prepare("SELECT 
                                                    i.*, p.*, u.uom_name,
                                                    SUM(p.product_stock) AS total_stock,
                                                    COUNT(*) as total_count,
                                                    li.latest_isReceived,
                                                    li.qty_purchased as all_qty_purchased,
                                                    li.qty_received as all_qty_received
                                                FROM 
                                                    inventory i
                                                INNER JOIN products p ON p.id = i.product_id
                                                LEFT JOIN uom u ON u.id = p.uom_id
                                                LEFT JOIN (
                                                    SELECT product_id, isReceived as latest_isReceived, qty_purchased, qty_received
                                                    FROM inventory
                                                    WHERE (product_id, id) IN (
                                                        SELECT product_id, MAX(id) as id
                                                        FROM inventory
                                                        GROUP BY product_id
                                                    )
                                                ) li ON li.product_id = p.id 
                                                GROUP BY i.product_id");
        $sql->execute();
        return $sql->rowCount();                     
    }
    // public function get_allInventoriesDatatable($requestData)
    // {
    //     $columns = array(
    //         0 => 'p.id',
    //         1 => 'p.prod_desc',
    //         2 => 'p.barcode',
    //         3 => 'u.uom_name',
    //         4 => 'all_qty_purchased',
    //         5 => 'all_qty_received',
    //         6 => 'p.product_stock',
    //         7 => 'p.cost',
    //         8 => 'p.prod_price',
    //     );
    
    //     // $sql = "SELECT 
    //     //             inventory.*, products.*, uom.*, SUM(inventory.qty_purchased) as all_qty_purchased, SUM(inventory.qty_received) as all_qty_received,
    //     //             SUM(products.product_stock) AS total_stock,
    //     //             COUNT(*) OVER() as total_count 
    //     //         FROM inventory 
    //     //         INNER JOIN products ON products.id = inventory.product_id 
    //     //         LEFT JOIN uom ON uom.id = products.uom_id";
    //     $sql = "SELECT 
    //                 i.*, p.*, u.uom_name,
    //                 SUM(p.product_stock) AS total_stock,
    //                 COUNT(*) as total_count,
    //                 li.latest_isReceived,
    //                 li.qty_purchased as all_qty_purchased,
    //                 li.qty_received as all_qty_received
    //             FROM 
    //                 inventory i
    //             INNER JOIN products p ON p.id = i.product_id
    //             LEFT JOIN uom u ON u.id = p.uom_id
    //             LEFT JOIN (
    //                 SELECT product_id, isReceived as latest_isReceived, qty_purchased, qty_received
    //                 FROM inventory
    //                 WHERE (product_id, id) IN (
    //                         SELECT product_id, MAX(id) as id
    //                         FROM inventory
    //                         GROUP BY product_id
    //                         )
    //             ) li ON li.product_id = p.id ";

    
    //         if (!empty($requestData['search']['value'])) {
    //             $sql .= " WHERE p.prod_desc LIKE '%" . $requestData['search']['value'] . "%'
    //                     OR p.barcode LIKE '%" . $requestData['search']['value'] . "%'
    //                     OR u.uom_name LIKE '%" . $requestData['search']['value'] . "%' ";
    //         }
    
    //     $sql .= " GROUP BY p.id";
    //     // $sql .= " GROUP BY p.id, p.prod_desc, u.uom_name, li.latest_isReceived";
    
    //     if (!empty($requestData['order'])) {
    //         $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'];
    //     } else {
    //         $sql .= " ORDER BY p.prod_desc ASC";
    //     }
    
    //     $sql .= " LIMIT :limit OFFSET :offset";
    
    //     $stmt = $this->connect()->prepare($sql);
    //     $stmt->bindParam(':limit', $requestData['length'], PDO::PARAM_INT);
    //     $stmt->bindParam(':offset', $requestData['start'], PDO::PARAM_INT);
    //     $stmt->execute();
    //     $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    //     return $data;
    // }
    // public function get_allInventories()
    // {
    //     $requestData = $_REQUEST;
    //     $data = $this->get_allInventoriesDatatable($requestData);

    //     $totalData = $totalFiltered = 0;
    //     if (count($data) > 0) {
    //         $totalData = $totalFiltered = $data[0]['total_count'];
    //     }

    //     $json_data = array(
    //         "draw" => intval($requestData['draw']),
    //         "recordsTotal" => intval($totalData),
    //         "recordsFiltered" => intval($totalFiltered),
    //         "data" => $data
    //     );

    //     return $json_data;
    // }
    public function get_allInventoriesData()
    {
        $stmt = $this->connect()->prepare("SELECT 
                                                inventory.*, products.*, uom.*, SUM(inventory.qty_purchased) as all_qty_purchased, SUM(inventory.qty_received) as all_qty_received
                                            FROM inventory 
                                            INNER JOIN products ON products.id = inventory.product_id 
                                            LEFT JOIN uom ON uom.id = products.uom_id
                                            GROUP BY products.id
                                            ORDER BY products.prod_desc asc");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function get_allProductByInventoryType($type)
    {
        $data = "";
        if($type === "1")
        {
            // $sql = $this->connect()->prepare("SELECT supplier.*, products.*, inventory.*, uom.*, orders.*, inventory.id as inventory_id
            //                                 FROM inventory
            //                                 JOIN products ON products.id = inventory.product_id
            //                                 JOIN uom ON uom.id = products.uom_id
            //                                 JOIN orders ON orders.id = inventory.order_id
            //                                 JOIN supplier ON supplier.id = orders.supplier_id
            //                                 ORDER BY inventory.id DESC; LIMIT :offset, :perPage");

            // $sql->bindParam(':offset', $offset, PDO::PARAM_INT);
            // $sql->bindParam(':perPage', $perPage, PDO::PARAM_INT);
            // $sql->execute();
            // $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        if($type === "2")
        {
            $sql = "SELECT products.*, uom.*, products.id as product_id
                    FROM products
                    LEFT JOIN uom ON uom.id = products.uom_id
                    ORDER BY products.id ASC;";

            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            $data =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }
    public function get_inventoryDataById($inventory_id)
    {
        $sql = "SELECT products.*, inventory.*, uom.*, inventory.id as inventory_id
                FROM inventory
                JOIN products ON products.id = inventory.product_id
                JOIN uom ON uom.id = products.uom_id
                WHERE inventory.id = :inventory_id";

        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":inventory_id", $inventory_id);
        $stmt->execute();
        $data =  $stmt->fetch(PDO::FETCH_ASSOC);
        
        $array = [
            "inventory_id" => $data["inventory_id"],
            "prod_desc"=> $data["prod_desc"],
            'stock'=>$data['stock'],
            "cost"=> $data["cost"],            
            "sub_row"=> $this->get_allTheSerialized($inventory_id),
            "isSerialized"=> $data["isSerialized"],
        ];
        return $array;
    }
    public function get_productDataById($inventory_id)
    {
        $sql = "SELECT products.*, uom.*
                FROM products
                LEFT JOIN uom ON uom.id = products.uom_id
                WHERE products.id = :inventory_id";

        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":inventory_id", $inventory_id);
        $stmt->execute();
        $data =  $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;

    }
    public function get_allTheSerialized($inventory_id)
    {
        $sql = "SELECT serialized_product.*, inventory.*, serialized_product.serial_number, serialized_product.id as serial_id
                FROM serialized_product
                INNER JOIN inventory ON inventory.id = serialized_product.inventory_id 
                WHERE inventory.id = :inventory_id";

        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':inventory_id', $inventory_id, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    public function get_inventory($inventory_id)
    {
        $sql = "SELECT * FROM inventory WHERE id=:id";
        $stmt = $this->connect()->prepare($sql);  
        $stmt->bindParam(":id", $inventory_id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    public function get_allStocksData($inventory_id)
    {   
        $sql = "SELECT products.*, stocks.*, stocks.date as stock_date
                FROM products
                INNER JOIN stocks ON stocks.inventory_id = products.id
                WHERE products.id = :inventory_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":inventory_id", $inventory_id);
        $stmt->execute();
        $stocks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return [
            'inventoryInfo' => $this->get_productDataById($inventory_id),
            'stocks' =>$stocks,
        ];
    }
    public function get_allStocksDataByDate($inventory_id, $start_date, $end_date)
    {
        $stocks = [];
        if($start_date !== "" AND $end_date !== "")
        {
            $formatted_start_date = date("Y-m-d", strtotime($start_date));
            $formatted_end_date = date("Y-m-d", strtotime($end_date));
          
            $sql = "SELECT products.*, stocks.*, stocks.date as stock_date
                    FROM products
                    INNER JOIN stocks ON stocks.inventory_id = products.id
                    WHERE products.id = :inventory_id
                    AND (DATE(stocks.date) BETWEEN :st_date AND :end_date)";

            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":inventory_id", $inventory_id);
            $stmt->bindParam(":st_date", $formatted_start_date);
            $stmt->bindParam(":end_date", $formatted_end_date);
            $stmt->execute();
            $stocks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            $sql = "SELECT products.*, stocks.*, stocks.date as stock_date
                    FROM products
                    INNER JOIN stocks ON stocks.inventory_id = products.id
                    WHERE products.id = :inventory_id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":inventory_id", $inventory_id);
            $stmt->execute();
            $stocks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
     
        return [
            'inventoryInfo' => $this->get_productDataById($inventory_id),
            'stocks' => $stocks,
        ];
    }
    public function get_expirationNotification()
    {
        $sql = $this->connect()->prepare("SELECT * FROM expiration_notification");
        $sql->execute();
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    public function get_expiringProductsForLossAndDamage($type)
    {
        $sql = $this->connect()->prepare("SELECT products.prod_desc, products.cost, products.id as product_id, 
                                            products.barcode, inventory.isReceived, inventory.id as inventory_id, 
                                            received_items.date_expired, transaction_qty, dateItemReceived, received_items.qty_received, 
                                            received_items.id as received_item_id
                                            FROM inventory
                                            INNER JOIN products ON products.id = inventory.product_id
                                            INNER JOIN received_items ON received_items.inventory_id = inventory.id
                                            WHERE received_items.date_expired IS NOT NULL
                                            AND received_items.status = 0
                                            ORDER BY products.id");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        $products = []; $notifications = [];

        foreach( $result as $row )
        {
            $transaction_qty = $row['transaction_qty'];
            if($transaction_qty > 0)
            {
                $expiration_date = new DateTime($row['date_expired'] ?? '');
                $now = new DateTime();
            
                $interval = $now->diff($expiration_date);
                $days_remaining = $interval->days;
                if ($expiration_date > $now) {
                    $days_remaining++;
                }
                else {
                    $days_remaining = -$days_remaining; 
                }
                $products[] = [
                    'inventory_id' => $row['inventory_id'],
                    'product_id' => $row['product_id'],
                    'prod_desc'=>$row['prod_desc'],
                    'cost'=>$row['cost'],
                    'barcode'=>$row['barcode'],
                    'is_received' =>$row['isReceived'],
                    'date_expired'=>$row['date_expired'],
                    'transaction_qty'=>$row['transaction_qty'],
                    'qty_received'=>$row['qty_received'],
                    'dateItemReceived' => $row['dateItemReceived'],
                    'days_remaining'=>$days_remaining,
                    'received_item_id' => $row['received_item_id']

                ];
            }
        
        }
        return $products;
    }
    public function get_productsForExpiring($searchInput, $offset, $recordsPerPage)
    {
        date_default_timezone_set('Asia/Manila');
        if(!empty($searchInput))
        {
            $query = "SELECT products.prod_desc, products.barcode, inventory.isReceived, inventory.id as inventory_id, received_items.date_expired, received_items.qty_received as transaction_qty, dateItemReceived
                    FROM inventory
                    INNER JOIN products ON products.id = inventory.product_id
                    INNER JOIN received_items ON received_items.inventory_id = inventory.id
                    WHERE received_items.date_expired IS NOT NULL  
                    AND received_items.status = 0
                    AND products.prod_desc LIKE :searchQuery OR
                    products.barcode LIKE :searchQuery";
            
            $searchParam = "%_" . $searchInput;
            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(':searchQuery', $searchParam, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $products = []; $notifications = [];
            foreach( $result as $row )
            {
                $transaction_qty = $row['transaction_qty'];
                if($transaction_qty > 0)
                {
                    $expiration_date = new DateTime($row['date_expired'] ?? '');
                    $now = new DateTime();
                
                    $interval = $now->diff($expiration_date);
                    $days_remaining = $interval->days;
                    if ($expiration_date > $now) {
                        $days_remaining++;
                    }
                    else {
                        $days_remaining = -$days_remaining; 
                    }
                    $products[] = [
                        'inventory_id' => $row['inventory_id'],
                        'prod_desc'=>$row['prod_desc'],
                        'barcode'=>$row['barcode'],
                        'is_received' =>$row['isReceived'],
                        'date_expired'=>$row['date_expired'],
                        'transaction_qty'=>$row['transaction_qty'],
                        'dateItemReceived' => $row['dateItemReceived'],
                        'days_remaining'=>$days_remaining
                    ];
                }
            
            }
            $notify_before = $this->get_expirationNotification();
            foreach($notify_before as $nb)
            {
                $notifications[] = [
                    'notify_before' => $nb['notify_before'],
                    'is_active' => $nb['is_active'],
                ];
            }
            return [
                'products'=> $products,
                'notifications'=> $notifications,
            ];
        }
        else
        {
            $query = "SELECT products.prod_desc, products.barcode, inventory.isReceived, inventory.id as inventory_id, received_items.date_expired, transaction_qty, dateItemReceived
                        FROM inventory
                        INNER JOIN products ON products.id = inventory.product_id
                        INNER JOIN received_items ON received_items.inventory_id = inventory.id
                        WHERE received_items.date_expired IS NOT NULL
                        AND received_items.status = 0
                        ORDER BY products.id ASC LIMIT $offset, $recordsPerPage";
            
            $stmt = $this->connect()->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $products = []; $notifications = [];
            foreach( $result as $row )
            {
                $transaction_qty = $row['transaction_qty'];
                if($transaction_qty > 0)
                {
                    $expiration_date = new DateTime($row['date_expired'] ?? '');
                    $now = new DateTime();
                
                    $interval = $now->diff($expiration_date);
                    $days_remaining = $interval->days;
                    if ($expiration_date > $now) {
                        $days_remaining++;
                    }
                    else {
                        $days_remaining = -$days_remaining; 
                    }
                    $products[] = [
                        'inventory_id' => $row['inventory_id'],
                        'prod_desc'=>$row['prod_desc'],
                        'barcode'=>$row['barcode'],
                        'is_received' =>$row['isReceived'],
                        'date_expired'=>$row['date_expired'],
                        'days_remaining'=>$days_remaining,
                        'transaction_qty'=>$row['transaction_qty'],
                        'dateItemReceived' => $row['dateItemReceived'],
                    ];
                }
              
            }
            $notify_before = $this->get_expirationNotification();
            foreach($notify_before as $nb)
            {
                $notifications[] = [
                    'notify_before' => $nb['notify_before'],
                    'is_active' => $nb['is_active'],
                ];
            }
            return [
                'products'=> $products,
                'notifications'=> $notifications,
            ];
        }
        
    }
    public function get_realtime_notifications()
    {
        date_default_timezone_set('Asia/Manila');
        $query = "SELECT products.prod_desc, products.barcode, inventory.isReceived, inventory.id as inventory_id, received_items.date_expired,  received_items.transaction_qty
                FROM inventory
                INNER JOIN products ON products.id = inventory.product_id
                INNER JOIN received_items ON received_items.inventory_id = inventory.id
                WHERE received_items.date_expired IS NOT NULL  
                AND received_items.status = 0";
        
        $result = $this->connect()->prepare($query); 
        $result->execute();
        $result = $result->fetchAll(PDO::FETCH_ASSOC);
        $products = []; $notifications = [];
        foreach( $result as $row )
        {
            $transaction_qty = $row['transaction_qty'];
            if($transaction_qty > 0)
            {
                $expiration_date = new DateTime($row['date_expired'] ?? '');
                $now = new DateTime();
            
                $interval = $now->diff($expiration_date);
                $days_remaining = $interval->days;
                if ($expiration_date >= $now) {
                    $days_remaining++;
                }
                else {
                    $days_remaining = -$days_remaining; 
                }
                $products[] = [
                    'inventory_id' => $row['inventory_id'],
                    'prod_desc'=>$row['prod_desc'],
                    'barcode'=>$row['barcode'],
                    'is_received' =>$row['isReceived'],
                    'date_expired'=>$row['date_expired'],
                    'days_remaining'=>$days_remaining,
                    'transaction'=>$row['transaction_qty']
                ];
            }
          
        }
        $notify_before = $this->get_expirationNotification();
        foreach($notify_before as $nb)
        {
            $notifications[] = [
                'notify_before' => $nb['notify_before'],
                'is_active' => $nb['is_active'],
            ];
        }
        return [
            'products'=> $products,
            'notifications'=> $notifications,
        ];
    }
    public function total_forExpiringProducts()
    {
        date_default_timezone_set('Asia/Manila');
        $query = "SELECT products.prod_desc, products.barcode, inventory.isReceived, inventory.id as inventory_id, received_items.date_expired
                FROM inventory
                INNER JOIN products ON products.id = inventory.product_id
                INNER JOIN received_items ON received_items.inventory_id = inventory.id
                WHERE received_items.date_expired IS NOT NULL  ";
        
        $result = $this->connect()->prepare($query); 
        $result->execute();
        return $result->rowCount();
        // $products = []; $notifications = [];
        // foreach( $result as $row )
        // {
        //     $expiration_date = new DateTime($row['date_expired'] ?? '');
        //     $now = new DateTime();
        
        //     $interval = $now->diff($expiration_date);
        //     $days_remaining = $interval->days;
        //     if ($expiration_date > $now) 
        //     {
        //         $days_remaining++;
        //     }
        //     else 
        //     {
        //         $days_remaining = -$days_remaining; 
        //     }
        //     $products[] = [
        //         'prod_desc'=>$row['prod_desc'],
        //         'barcode'=>$row['barcode'],
        //         'is_received' =>$row['isReceived'],
        //         'date_expired'=>$row['date_expired'],
        //         'days_remaining'=>$days_remaining,
        //     ];
        // }
        // $notify_before = $this->get_expirationNotification();
        // foreach($notify_before as $nb)
        // {
        //     $notifications[] = [
        //         'notify_before' => $nb['notify_before'],
        //         'is_active' => $nb['is_active'],
        //     ];
        // }
        // return [
        //     'products'=> $products,
        //     'notifications'=> $notifications,
        // ];
    }
    public function save_expirationNotification($data)
    {
        $notifications = json_decode($data["notifications"], true);
        foreach ($notifications as $notification) 
        {
            $is_active = $notification["value"] ? 1 : 0;
            $notify_before = 0;
            switch (strtolower($notification["label"]))
            {
                case "30 days":
                    $notify_before = 30;
                    break;
                case "15 days":
                    $notify_before = 15;
                    break;
                case "5 days":
                    $notify_before = 5;
                    break;
                default:
                    break;
            }

            $sql = $this->connect()->prepare("UPDATE expiration_notification SET is_active = :is_active WHERE notify_before = :notify_before");
            $sql->bindParam(":is_active", $is_active);
            $sql->bindParam(":notify_before", $notify_before);
            $sql->execute();
        }
        return [
            'status'=>true,
            'msg'=>"Your expiration notification settings have been successfully saved",
        ];
    }
    function getSessionVariable($key) 
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }
    public function save_quickInventory($formData)
    {
        $pdo = $this->connect();
        
        $tbl_data = json_decode($formData['tbl_data'], true);
        foreach($tbl_data as $row)
        {
            $inventory_id = $row['inventory_id'];
            $received_id = $row['receive_id'];
            $qty_onhand = (float)$row['col_2'];
            $newqty = (float)$row['newqty'];
            date_default_timezone_set('Asia/Manila');
            $currentDate = date('Y-m-d h:i:s');

            $stmt = $this->connect()->prepare("UPDATE products SET product_stock = :new_stock WHERE id = :id");
            $stmt->bindParam(":new_stock", $newqty); 
            $stmt->bindParam(":id", $inventory_id); 
            $stmt->execute();

            $sql = $pdo->prepare("UPDATE `received_items` SET `qty_received`= ?,`transaction_qty`= ? WHERE id = ?");
            $sql->execute([$newqty, $newqty, $received_id]);
            
            $currentStock = 0;
            $newqty = "+".$newqty;
            $stock_customer = $formData['user_name'];
            $document_number = "---";
            $transaction_type = "Quick Inventory";
            $stmt = $this->connect()->prepare("INSERT INTO stocks (inventory_id, stock_customer, stock_qty, stock, document_number, transaction_type, date)
                                                VALUES (?, ?, ?, ?, ?, ?, ?)");

            $movement = $qty_onhand > $newqty ? "-".$qty_onhand-$newqty : "+".$newqty - $qty_onhand;
            $stmt->bindParam(1, $inventory_id, PDO::PARAM_INT);
            $stmt->bindParam(2, $stock_customer, PDO::PARAM_STR); 
            $stmt->bindParam(3, $movement, PDO::PARAM_STR); 
            $stmt->bindParam(4, $newqty, PDO::PARAM_STR); 
            $stmt->bindParam(5, $document_number, PDO::PARAM_STR); 
            $stmt->bindParam(6, $transaction_type, PDO::PARAM_STR); 
            $stmt->bindParam(7, $currentDate, PDO::PARAM_STR); 
            $stmt->execute();
        }
        return [
            'status'=>true,
            'msg'=>'Quick inventory has been successfully saved!',	
        ];
    }



    public function save_quickInventory1($data) 
    {
        $pdo = $this->connect();
        foreach ($data as $datas) 
        {
            $sql = $pdo->prepare("UPDATE `received_items` SET `qty_received`= ?,`transaction_qty`= ? WHERE id = ?");
            $sql->execute([$datas->inputs_qty, $datas->inputs_qty, $datas->ids]);
        }

        $inventory_id = $datas->product_id;
        $qty_onhand = (float)$datas->totalOnHand;
        $newqty = (float)$datas->totalQty;
        date_default_timezone_set('Asia/Manila');
        $currentDate = date('Y-m-d h:i:s');

        $stmt = $pdo->prepare("UPDATE products SET product_stock = :new_stock WHERE id = :id");
        $stmt->bindParam(":new_stock", $newqty); 
        $stmt->bindParam(":id", $inventory_id); 
        $stmt->execute();
        
        $currentStock = 0;
        $newqty = "+".$newqty;
        $stock_customer = 'Alexander Caones';
        $document_number = "---";
        $transaction_type = "Quick Inventory";
        $stmt = $pdo->prepare("INSERT INTO stocks (inventory_id, stock_customer, stock_qty, stock, document_number, transaction_type, date)
                                            VALUES (?, ?, ?, ?, ?, ?, ?)");

        $movement = $qty_onhand > $newqty ? "-".$qty_onhand-$newqty : "+".$newqty - $qty_onhand;
        $stmt->bindParam(1, $inventory_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $stock_customer, PDO::PARAM_STR); 
        $stmt->bindParam(3, $movement, PDO::PARAM_STR); 
        $stmt->bindParam(4, $newqty, PDO::PARAM_STR); 
        $stmt->bindParam(5, $document_number, PDO::PARAM_STR); 
        $stmt->bindParam(6, $transaction_type, PDO::PARAM_STR); 
        $stmt->bindParam(7, $currentDate, PDO::PARAM_STR); 
        $stmt->execute();
        
        echo json_encode('SUCCESS');
    }


    public function fetchProducts($search)
    {
        $stmt = $this->connect()->prepare("SELECT prod_desc FROM products WHERE prod_desc LIKE :p");
        $stmt->execute(['p' => "%$search%"]);
        $suggestions = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $suggestions;
    }
    public function get_allProducts()
    {
        $isNegativeInventoryChecked = isset($_GET['isNegativeInventoryChecked']);
        if($isNegativeInventoryChecked)
        {
            $where = $_GET['isNegativeInventoryChecked'] === "1" ? 'WHERE products.product_stock < 0' : 'WHERE products.product_stock >= 1  OR products.product_stock = 0';
            $sql = $this->connect()->prepare("SELECT products.*,
                        CASE 
                        WHEN uom.uom_name IS null THEN ''
                        ELSE uom.uom_name
                        END AS uom
                        FROM PRODUCTS 
                        LEFT JOIN uom ON products.uom_id = uom.id
                        $where
                        order by products.prod_desc asc");
            $sql->execute();
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
        else
        {
            $sql = $this->connect()->prepare("SELECT products.*,
                        CASE 
                        WHEN uom.uom_name IS null THEN ''
                        ELSE uom.uom_name
                        END AS uom
                        FROM PRODUCTS 
                        LEFT JOIN uom ON products.uom_id = uom.id
                        order by products.prod_desc asc");
            $sql->execute();
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
        
      
    }
    public function get_allSuppliers()
    {
        $sqlStatement = $this->connect()->prepare("SELECT * FROM supplier");
        $sqlStatement->execute();
        return $sqlStatement->fetchAll(PDO::FETCH_ASSOC);
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
    public function get_productInfo($product)
    {
        $sql = "SELECT *, isVat FROM products WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':id', $product, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function get_supplierInfo($supplier)
    {
        $sql = "SELECT * FROM supplier WHERE supplier = :supplier";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':supplier', $supplier, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function save_supplier($supplier)
    {
        $sql = "SELECT id FROM supplier WHERE supplier = :value";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':value', $supplier);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchColumn();
            return $result;
        } else {
            $sqlStatement = $this->connect()->prepare("INSERT INTO supplier (supplier) VALUES (?)");
            $sqlStatement->bindParam(1, $supplier, PDO::PARAM_STR);
            $sqlStatement->execute();
        }
    }
    public function validateData($formData)
    {
        $errors = [];

        $validationRules = [
            'pcs_no' => 'Pieces number is required',
            'date_purchased' => 'Date purchased is required',
            'supplier' => 'Supplier is required',
            'product' => 'Product ID is required'
        ];

        if (!isset($_POST['isPaid']) && $_POST['isPaid'] !== 'on') {
            $errors['isPaid'] = 'The item should be marked as paid.';
        }

        foreach ($validationRules as $field => $errorMessage) {
            if (empty($formData[$field])) {
                $errors[$field] = $errorMessage;
            }
        }

        return empty($errors) ? true : $errors;
    }
    public function get_lastOrderData()
    {
        $sql = "SELECT * FROM orders ORDER BY id DESC LIMIT 1";
        $result = $this->connect()->prepare($sql);
        $result->execute();
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    public function get_lastSettingData()
    {
        $sql = "SELECT * FROM order_payment_settings ORDER BY id DESC LIMIT 1";
        $result = $this->connect()->prepare($sql);
        $result->execute();
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    public function verify_order($po_number)
    {
        $sql = "SELECT * FROM orders WHERE po_number = :po_number";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':po_number', $po_number, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount() > 0 ? true : false;
    }
    public function get_purchaseOrderNo()
    {
        $sql = "SELECT * FROM orders ORDER BY id DESC LIMIT 1";
        $result = $this->connect()->prepare($sql);
        $result->execute();
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    public function save_orderPayments($formData)
    {
        if(isset($formData["next_payment"]) || isset( $formData["rem_balance"]))
        {
            $balance = $this->remove_nonBreakingSpace($this->clean_number(($formData['rem_balance'])));
            $next_payment = $this->remove_nonBreakingSpace($this->clean_number((($formData['next_payment']))));
            $new_balance = $balance - $next_payment;
            $date = date('Y-m-d', strtotime($formData['date_paid']));
            $order_setting_id = $formData['order_setting_id'];
            $sql = "INSERT INTO order_payments (order_setting_id, payment, balance, date_paid)
                    VALUES (?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $order_setting_id, PDO::PARAM_INT);
            $stmt->bindParam(2, $next_payment, PDO::PARAM_STR);
            $stmt->bindParam(3, $new_balance, PDO::PARAM_STR);
            $stmt->bindParam(4, $date, PDO::PARAM_STR);
            $stmt->execute();
            return [
                'status'=>true,
                'msg'=>"Payment has been successfully saved!",
            ];
        }
        else
        {
            return [
                'status'=>false,
                'msg'=> 'Invalid field input!'
            ];
        }
    }
    public function get_orderPaymentHistory($order_id)
    {
        $sql = "SELECT orders.*, order_payment_settings.*, order_payments.*, order_payment_settings.balance as ordersetting_balance, order_payments.balance as order_balance, order_payment_settings.id as order_payment_setting_id
                    FROM orders
                    JOIN order_payment_settings ON orders.id = order_payment_settings.order_id
                    JOIN order_payments ON order_payment_settings.id = order_payments.order_setting_id
                    WHERE orders.id = :order_id";

        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue(":order_id", $order_id, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    public function save_unpaidPaymentTerms($formData)
    {
        $serializedFormData = $formData['unpaid_form'];
        $order_id = $formData['order_id'];
        $unpaid_form = [];
        parse_str($serializedFormData, $unpaid_form);

        $sql = "UPDATE orders SET isNotification = :isNotification, isReccurring = :isReccurring, term = :term, due_date = :due_date, note = :note, unpaid_amount = :unpaid_amount WHERE id = :id";
        
        $unpaid_amount = floatval($unpaid_form['partialPayment']);
        $isNotification = isset($unpaid_form['notification_unpaid']) && $unpaid_form['notification_unpaid'] == 'on' ? 1 : 0;
        $isReccurring = isset($unpaid_form['reccurring_unpaid']) && $unpaid_form['reccurring_unpaid'] == 'on' ? 1 : 0;
        $term = $unpaid_form['unpaid_term'];
        $unpaid_note = $unpaid_form['unpaid_note'];
        $dueDate = date('Y-m-d', strtotime($unpaid_form['unpaid_dueDate']));
        $sqlStatement = $this->connect()->prepare($sql);
        $params = [
            ':isReccurring' => $isReccurring,
            ':isNotification' => $isNotification,
            ':term' => $term,
            ':due_date'=>$dueDate,
            ':note' => $unpaid_note,
            ':unpaid_amount' => $unpaid_amount,
            ':id' => $order_id
        ];
        $sqlStatement->execute($params);
        
        return [
            'success' => true,
            'message' => 'Payment terms, has been successfully updated.'
        ];
    }
    public function get_unpaid_transaction($order_id)
    {
        $order_data_sql = $this->connect()->prepare("SELECT orders.*
                                        FROM orders
                                        WHERE orders.id = :order_id");
        $order_data_sql->execute([':order_id'=>$order_id]);
        $order_data = $order_data_sql->fetch(PDO::FETCH_ASSOC);

        $sql = $this->connect()->prepare("SELECT orders.*, order_payments.*
                                        FROM orders
                                        INNER JOIN order_payments ON order_payments.order_id = orders.id
                                        WHERE orders.id = :order_id");
        $sql->execute([':order_id'=>$order_id]);
        $history = $sql->fetch(PDO::FETCH_ASSOC);

        return [
            'orderData'=>$order_data,
            'history'=>$history,
        ];
    }
    public function save_unpaidPayment($formData)
    {
        $serializedFormData = $formData['unpaid_form'];
        $unpaid_form = [];
        parse_str($serializedFormData, $unpaid_form);

        $order_id = $unpaid_form['unpaid_order_id'];
        $payment_method_id = $unpaid_form['payment_method'];
        $unpaid_amount = $unpaid_form['partialPayment'];
        $reference_no = $unpaid_form['reference_no'];
        $unpaid_balance = $unpaid_form['unpaid_balance'];
        $date_paid = date('Y-m-d', strtotime($unpaid_form['date_paid']));
        $balance = $unpaid_balance - $unpaid_amount;
        $unpaid_stmt = $this->connect()->prepare("INSERT INTO order_payments (order_id, paid_amount, balance, date_paid, payment_method_id, reference_no)
                                                VALUES (:order_id, :paid_amount, :balance, :date_paid, :payment_method_id, :reference_no)");
        $unpaid_stmt->execute([
            ':order_id' => $order_id,
            ':paid_amount' => $unpaid_amount,
            ':balance' => $balance,
            ':date_paid' => $date_paid,
            ':payment_method_id' => $payment_method_id,
            ':reference_no' => $reference_no,
        ]);
        
        if($balance === 0.00)
        {
            $order = $this->connect()->prepare("UPDATE orders SET unpaid_amount = :unpaid_amount, isPaid = :isPaid WHERE id=:id");
            $order->execute([':unpaid_amount'=>$balance, ':isPaid'=>1, ':id'=>$order_id]);
        }
        else
        {
            $order = $this->connect()->prepare("UPDATE orders SET unpaid_amount = :unpaid_amount WHERE id=:id");
            $order->execute([':unpaid_amount'=>$balance, ':id'=>$order_id]);
        }
        
        return [
            'success'=>true,
            'message'=>'Payment has been successfully updated',
        ];
    }
    public function save_order($formData)
    {
        $isPaid = $formData['isPaid'];
        $supplier_id = $this->get_supplierInfo($formData['supplier'])['id'];
        $date_purchased = date('Y-m-d', strtotime($formData['date_purchased']));
        $po_number = $formData['po_number'];
        $price = $this->remove_nonBreakingSpace($this->clean_number($formData['total']));
        $totalTax = $this->remove_nonBreakingSpace($this->clean_number($formData['totalTax']));
        $totalQty = $formData['totalQty'];
        $totalPrice = $this->remove_nonBreakingSpace($this->clean_number($formData['totalPrice']));
        $order_type = 1;
        
        $order_id = $this->get_lastOrderData() === false ? 0 : $this->get_lastOrderData()['id'];
        if ($formData['order_id'] !== "0") 
        {
            $sql = "UPDATE orders SET isPaid = :v1, supplier_id = :v2, date_purchased = :v3, price = :v4, totalTax = :v5, totalQty = :v6, totalPrice = :v7 WHERE id = :id";
            $sqlStatement = $this->connect()->prepare($sql);

            $sqlStatement->bindParam(':v1', $isPaid);
            $sqlStatement->bindParam(':v2', $supplier_id);
            $sqlStatement->bindParam(':v3', $date_purchased);
            $sqlStatement->bindParam(':v4', $price);
            $sqlStatement->bindParam(':v5', $totalTax);
            $sqlStatement->bindParam(':v6', $totalQty);
            $sqlStatement->bindParam(':v7', $totalPrice);
            $sqlStatement->bindParam(':id', $formData['order_id']);
            $sqlStatement->execute();

            $order_id = $formData['order_id'];

        } 
        else 
        {
            if (!$this->verify_order($po_number)) 
            {
                if($isPaid === 1)
                {
                    $sql = "INSERT INTO orders 
                            (isPaid, supplier_id, date_purchased, po_number, price, order_type, totalTax, totalQty, totalPrice) 
                            VALUES 
                            (:isPaid, :supplier_id, :date_purchased, :po_number, :price, :order_type, :totalTax, :totalQty, :totalPrice)";

                    $sqlStatement = $this->connect()->prepare($sql);
                    $params = [
                        ':isPaid' => $isPaid,
                        ':supplier_id' => $supplier_id,
                        ':date_purchased' => $date_purchased,
                        ':po_number' => $po_number,
                        ':price' => $price,
                        ':order_type' => $order_type,
                        ':totalTax' => $totalTax,
                        ':totalQty' => $totalQty,
                        ':totalPrice' => $totalPrice,
                    ];

                    $sqlStatement->execute($params);
                }
                else
                {
                    $serializedFormData = $formData['unpaid_form'];
                    $unpaid_form = [];
                    parse_str($serializedFormData, $unpaid_form);

                    $sql = "INSERT INTO orders 
                            (isPaid, supplier_id, date_purchased, po_number, price, order_type, totalTax, totalQty, totalPrice, isNotification, isReccurring, term, due_date, note, unpaid_amount) 
                            VALUES 
                            (:isPaid, :supplier_id, :date_purchased, :po_number, :price, :order_type, :totalTax, :totalQty, :totalPrice, :isNotification, :isReccurring, :term, :due_date, :note, :unpaid_amount)";
                    
                    $total_orderAmount = floatval($price);
                    $unpaid_amount = floatval($unpaid_form['partialPayment']);
                    $isNotification = isset($unpaid_form['notification_unpaid']) && $unpaid_form['notification_unpaid'] == 'on' ? 1 : 0;
                    $isReccurring = isset($unpaid_form['reccurring_unpaid']) && $unpaid_form['reccurring_unpaid'] == 'on' ? 1 : 0;
                    $term = $unpaid_form['unpaid_term'];
                    $unpaid_note = $unpaid_form['unpaid_note'];
                    $unpaid_balance = $total_orderAmount-$unpaid_amount;
                    $dueDate = date('Y-m-d', strtotime($unpaid_form['unpaid_dueDate']));
                    $sqlStatement = $this->connect()->prepare($sql);
                    $params = [
                        ':isPaid' => $isPaid,
                        ':supplier_id' => $supplier_id,
                        ':date_purchased' => $date_purchased,
                        ':po_number' => $po_number,
                        ':price' => $price,
                        ':order_type' => $order_type,
                        ':totalTax' => $totalTax,
                        ':totalQty' => $totalQty,
                        ':totalPrice' => $totalPrice,
                        ':isReccurring' => $isReccurring,
                        ':isNotification' => $isNotification,
                        ':term' => $term,
                        ':due_date'=>$dueDate,
                        ':note' => $unpaid_note,
                        ':unpaid_amount' => $unpaid_balance,
                    ];
                    $sqlStatement->execute($params);
                    $order_id = $this->get_lastOrderData()['id'];
                
                    $date_paid = date('Y-m-d', strtotime($unpaid_form['date_paid']));
                    
                    $payment_method_id = $unpaid_form['payment_method'];
                    $reference_no = $unpaid_form['reference_no'];
                    $unpaid_stmt = $this->connect()->prepare("INSERT INTO order_payments (order_id, paid_amount, balance, date_paid, payment_method_id, reference_no)
                                                            VALUES (:order_id, :paid_amount, :balance, :date_paid, :payment_method_id, :reference_no)");
                    $unpaid_stmt->execute([
                        ':order_id' => $order_id,
                        ':paid_amount' => $unpaid_amount,
                        ':balance' => $unpaid_balance,
                        ':date_paid' => $date_paid,
                        ':payment_method_id' => $payment_method_id,
                        ':reference_no' => $reference_no,
                    ]);
                }
                $order_id = $this->get_lastOrderData()['id'];
            }
        }
        return $order_id;
    }
    public function get_allPaymentMethods()
    {
        $sql = $this->connect()->prepare("SELECT * FROM payment_method WHERE id != 4 AND id != 6");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function get_productInfoByInventoryId($inventory_id)
    {
        $sql = $this->connect()->prepare("SELECT inventory.*, products.id as prod_id
                                        FROM inventory, products
                                        WHERE products.id = inventory.product_id
                                        AND inventory.id = :inv_id  
                                        ");
        $sql->bindParam(":inv_id", $inventory_id);
        $sql->execute();
        return $sql->fetch();
    }
    public function get_orderDataByPONumber($po_number)
    {
        $stmt = $this->connect()->prepare("SELECT orders.* FROM orders 
                                            WHERE orders.po_number = :po_number");
        $stmt->execute([':po_number'=>$po_number]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function save_receivedItems($formData)
    {
        $tbl_data = json_decode($formData['tbl_data'], true);
        // $subRowData = json_decode($formData['subRowData'], true);
        $is_received = $formData['is_received'] !== 0 ? true : false;
        // $serializedFormData = $formData['receive_form'];
        $po_number = $formData["po_number"];
        $isPaid = $formData["isPaid"];
        $order_id = $this->get_orderDataByPONumber($po_number)['id'];
        $total_received = 0;
        $today = date('Y-m-d');
        foreach ($tbl_data as $row) 
        {
            $inventory_id = $row["inventory_id"];
            $qty_received = $row["qty_received"];
            $total_received += (float) $qty_received;

            $expired_date = null;
            if(isset($row["date_expired"]) && $row["date_expired"] !== "")
            {
                $expired_date = date('Y-m-d', strtotime($row["date_expired"]));
            }
            $isSerialized = $row["isSerialized"];
            $isSelected = isset($row["isSelected"]);
            $currentDate = date("Y-m-d");

            if ($isSelected) 
            {
                $is_serialized = $isSerialized ? 1 : 0;
                $is_received_val = 1;

                $product_info = $this->get_productInfoByInventoryId($inventory_id);
                $product_id = $product_info['prod_id'];

                if($is_received)
                {
                    $isReceived = 1;

                    $stmt = $this->connect()->prepare("UPDATE inventory SET isReceived = :isReceived, stock = stock + :new_stock, qty_received = qty_received + :qty_received, qty_purchased = qty_purchased - :counted, dateReceived = :dateReceived WHERE id = :id");
                    $stmt->bindParam(":new_stock", $qty_received); 
                    $stmt->bindParam(":isReceived", $isReceived); 
                    $stmt->bindParam(":qty_received", $qty_received);
                    $stmt->bindParam(":counted", $qty_received);
                    $stmt->bindParam(":dateReceived", $today);
                    $stmt->bindParam(":id", $inventory_id); 
                    $stmt->execute();

                    $dateItemReceived = date('Y-m-d');
                    $stmt = $this->connect()->prepare("
                        INSERT INTO received_items (inventory_id, qty_received, date_expired, transaction_qty, dateItemReceived)
                        VALUES (:inventory_id, :qty_received, :date_expired, :transaction_qty, :dateItemReceived)
                    ");
                    $params = [
                        ':inventory_id' => $inventory_id,
                        ':qty_received' => $qty_received,
                        ':date_expired'=> $expired_date,
                        ':transaction_qty' => $qty_received,
                        ':dateItemReceived' => $dateItemReceived,
                    ];
                    $stmt->execute($params);


                    if($isPaid === 0)
                    {
                        $expense_quantity = (float) $qty_received;
                        $expense_type = "PURCHASED ORDER";
                        $supplier_id = $this->get_supplierInfo($formData['supplier'])['id'];
                        $invoice_number = $po_number;
                        $price = (float) $product_info['amount_beforeTax'];
                        $total_amount = $expense_quantity * $price;
                        $date_of_transaction = date('Y-m-d');
                        $uom_id_expense = $this->get_productInfo($product_id)['uom_id'];
                        $taxable_amount = $total_amount;
                        $expense_stmt = $this->connect()->prepare("
                            INSERT INTO expenses (product_id, date_of_transaction, expense_type, quantity, uom_id, supplier, invoice_number, price, total_amount, taxable_amount)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ? )
                        ");
    
                        $expense_stmt->bindParam(1, $product_id, PDO::PARAM_STR);
                        $expense_stmt->bindParam(2, $date_of_transaction, PDO::PARAM_STR);
                        $expense_stmt->bindParam(3, $expense_type, PDO::PARAM_STR);
                        $expense_stmt->bindParam(4, $expense_quantity, PDO::PARAM_INT);
                        $expense_stmt->bindParam(5, $uom_id_expense, PDO::PARAM_INT);
                        $expense_stmt->bindParam(6, $supplier_id, PDO::PARAM_INT);
                        $expense_stmt->bindParam(7, $invoice_number, PDO::PARAM_STR);
                        $expense_stmt->bindParam(8, $price, PDO::PARAM_STR);
                        $expense_stmt->bindParam(9, $total_amount, PDO::PARAM_STR);
                        $expense_stmt->bindParam(10, $taxable_amount, PDO::PARAM_STR);
                        $expense_stmt->execute();
                    }
                    

                    if($qty_received > 0) {$qty_received = "+".$qty_received;}
                    $stmt = $this->connect()->prepare("UPDATE products SET product_stock = product_stock + :new_stock WHERE id = :id");
                    $stmt->bindParam(":new_stock", $qty_received); 
                    $stmt->bindParam(":id", $product_id); 
                    $stmt->execute();
        
                    $currentStock = $this->get_productInfo($product_id)['product_stock'];
                    date_default_timezone_set('Asia/Manila');
                    $currentDate = date('Y-m-d h:i:s');
                    $stock_customer = $formData['user_name'];
                    $document_number = $po_number;
                    $transaction_type = "Received";
                    $stmt = $this->connect()->prepare("INSERT INTO stocks (inventory_id, stock_customer, stock_qty, stock, document_number, transaction_type, date)
                                                        VALUES (?, ?, ?, ?, ?, ?, ?)");
        
                    $stmt->bindParam(1, $product_id, PDO::PARAM_INT);
                    $stmt->bindParam(2, $stock_customer, PDO::PARAM_STR); 
                    $stmt->bindParam(3, $qty_received, PDO::PARAM_STR); 
                    $stmt->bindParam(4, $currentStock, PDO::PARAM_STR); 
                    $stmt->bindParam(5, $document_number, PDO::PARAM_STR); 
                    $stmt->bindParam(6, $transaction_type, PDO::PARAM_STR); 
                    $stmt->bindParam(7, $currentDate, PDO::PARAM_STR); 
                    $stmt->execute();

                    // if ($isSerialized) 
                    // {
                    //    foreach($subRowData as $sub_row)
                    //    {
                    //         $sqlStatement = $this->connect()->prepare("UPDATE serialized_product SET serial_number = :serial_number WHERE id = :serial_id");

                    //         $sqlStatement->bindParam(":serial_number", $sub_row['serial_number'], PDO::PARAM_STR);
                    //         $sqlStatement->bindParam(":serial_id", $sub_row['serial_id'], PDO::PARAM_STR);
                    //         $sqlStatement->execute();
                    //     }
                    // }
                }
                else
                {
                    $isReceived = 1;

                    $stmt = $this->connect()->prepare("UPDATE inventory SET isReceived = :isReceived, stock = stock + :new_stock, qty_received = :qty_received, qty_purchased = qty_purchased - :counted, dateReceived = :dateReceived WHERE id = :id");
                    $stmt->bindParam(":new_stock", $qty_received); 
                    $stmt->bindParam(":isReceived", $isReceived); 
                    $stmt->bindParam(":qty_received", $qty_received);
                    $stmt->bindParam(":counted", $qty_received);
                    $stmt->bindParam(":dateReceived", $today);
                    $stmt->bindParam(":id", $inventory_id); 
                    $stmt->execute();

                    $dateItemReceived = date('Y-m-d');
                    $stmt = $this->connect()->prepare("
                        INSERT INTO received_items (inventory_id, qty_received, date_expired, transaction_qty, dateItemReceived)
                        VALUES (:inventory_id, :qty_received, :date_expired, :transaction_qty, :dateItemReceived)
                    ");
                    $params = [
                        ':inventory_id' => $inventory_id,
                        ':qty_received' => $qty_received,
                        ':date_expired'=> $expired_date,
                        ':transaction_qty' => $qty_received,
                        ':dateItemReceived' => $dateItemReceived,
                    ];
                    $stmt->execute($params);

                    $stmt = $this->connect()->prepare("UPDATE products SET product_stock = product_stock + :new_stock WHERE id = :id");
                    $stmt->bindParam(":new_stock", $qty_received); 
                    $stmt->bindParam(":id", $product_id); 
                    $stmt->execute();
        
                    $currentStock = $this->get_productInfo($product_id)['product_stock'];
                    $currentDate = date('Y-m-d H:i:s');
                    $stock_customer = $formData['user_name'];
                    $document_number = $po_number;
                    $transaction_type = "Received";
                    $stmt = $this->connect()->prepare("INSERT INTO stocks (inventory_id, stock_customer, stock_qty, stock, document_number, transaction_type, date)
                                                        VALUES (?, ?, ?, ?, ?, ?, ?)");
        
                    $stmt->bindParam(1, $inventory_id, PDO::PARAM_INT);
                    $stmt->bindParam(2, $stock_customer, PDO::PARAM_STR); 
                    $stmt->bindParam(3, $qty_received, PDO::PARAM_STR); 
                    $stmt->bindParam(4, $currentStock, PDO::PARAM_STR); 
                    $stmt->bindParam(5, $document_number, PDO::PARAM_STR); 
                    $stmt->bindParam(6, $transaction_type, PDO::PARAM_STR); 
                    $stmt->bindParam(7, $currentDate, PDO::PARAM_STR); 
                    $stmt->execute();
    
                    // if ($isSerialized) 
                    // {
                    //    foreach($subRowData as $sub_row)
                    //    {
                    //         if($this->check_serialNumber($inventory_id, $sub_row['serial_number']) === false) 
                    //         {
                    //             $sqlStatement = $this->connect()->prepare("INSERT INTO serialized_product (inventory_id, serial_number) 
                    //             VALUES (?, ?)");
    
                    //             $sqlStatement->bindParam(1, $inventory_id, PDO::PARAM_STR);
                    //             $sqlStatement->bindParam(2, $sub_row['serial_number'], PDO::PARAM_STR);
                    //             $sqlStatement->execute();
                    //         }
                    //     }
                    // }
                }
            }
        }
        $is_received = 1;
        $sql = $this->connect()->prepare("UPDATE orders SET is_received = :is_received, totalReceived = totalReceived + :totalReceived
                                        WHERE id = :id");
        $sql->bindParam(":is_received", $is_received, PDO::PARAM_INT);
        $sql->bindParam(":totalReceived", $total_received, PDO::PARAM_INT);
        $sql->bindParam(":id", $order_id, PDO::PARAM_STR);
        $sql->execute();
        return ['status' => true, 'msg' => 'Items has been successfully saved'];
    }
    
    public function check_serialNumber($inventory_id, $serial_number)
    {
        $sql = "SELECT * FROM serialized_product WHERE inventory_id = :inventory_id AND serial_number = :serial_number";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":inventory_id", $inventory_id, PDO::PARAM_STR);
        $stmt->bindParam(":serial_number", $serial_number, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() ? true : false;
    }
    public function fetch_latestPONo()
    {
        return $this->generateString($this->get_purchaseOrderNo()['id'] + 1);
    }
    function generateString($id)
    {
        $paddedId = str_pad($id, 9, '0', STR_PAD_LEFT);
        $result = "10-" . $paddedId;
        return $result;
    }
    public function remove_inventories($inventories)
    {
        foreach ($inventories as $inventory_id) {
            $sql = "DELETE FROM inventory WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindValue(":id", $inventory_id);
            $stmt->execute();
        }
    }
    public function check_ifInventoryExist($product_id)
    {
        $sql = $this->connect()->prepare("SELECT id FROM inventory WHERE product_id = :product_id");
        $sql->bindValue(":product_id", $product_id, PDO::PARAM_STR);
        $sql->execute();
        return $sql->rowCount() > 0;
    }
    public function save_purchaseOrder($formData)
    {
        $order_data = $this->get_orderData($this->save_order($formData));
        if ($this->validateData($formData)) {
            $tbldata = json_decode($formData['data'], true);
            $order_id = $this->save_order($formData);
            $existed_product = [];
            
            if ($formData['order_id'] > 0) {
                if (isset($formData['remove_inventories'])) {
                    $this->remove_inventories($formData['remove_inventories']);
                }
                foreach ($tbldata as $row) 
                {
                    $inventory_id = $row['inventory_id'];
                    $product_id = $row['product_id'];
                    $product = $row['column_1'];
                    $quantity = $row['column_2'];
                    $price = $this->remove_nonBreakingSpace($this->clean_number($row['column_3']));
                    $total = $this->remove_nonBreakingSpace($this->clean_number($row['column_4']));
                    $status = 1;
                    $isSelected = 1;

                    $isVat = $this->get_productInfo($product_id)['isVat'] === 1;

                    $amount_beforeTax = $price;
                    $amount_afterTax = 0;
                    $tax = 0;
                    if ($isVat) {
                        $tax = $price / 1.12;
                        $amount_afterTax = $price - $tax;
                    }

                    $isPriceNotChange = $this->get_productInfo($product_id)['cost'] === $price;
                    $is_taxInclusive = $this->get_productInfo($product_id)['is_taxIncluded'] === 1;
                    $new_selling_price = $this->get_productInfo($product_id)['prod_price'];
                    $new_cost_price = $price;

                    if($isPriceNotChange)
                    {
                        if($is_taxInclusive)
                        {
                            $mark_up = $this->get_productInfo($product_id)['markup']; 
                            $interest = $price * ($mark_up/100);
                            $new_selling_price = (float) $new_cost_price + $interest;
                            $new_selling_price = number_format($new_selling_price, 2, '.', '');
                        }
                        else
                        {
                            $mark_up = $this->get_productInfo($product_id)['markup']; 
                            $interest = $price * ($mark_up/100);
                            $selling_price = $new_cost_price + $interest;
            
                            $withTax = ($new_selling_price/1.12) * 0.12;
                            $new_selling_price = $withTax;
                            $new_selling_price = number_format($new_selling_price, 2, '.', '');
                        }
                    } 

                    if ($inventory_id === 0) 
                    {

                        $sqlStatement = $this->connect()->prepare("INSERT INTO inventory (order_id, product_id, qty_purchased, amount_beforeTax, amount_afterTax, status, isSelected, total, tax) 
                                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

                        $sqlStatement->bindParam(1, $order_id, PDO::PARAM_STR);
                        $sqlStatement->bindParam(2, $product_id, PDO::PARAM_STR);
                        $sqlStatement->bindParam(3, $quantity, PDO::PARAM_STR);
                        $sqlStatement->bindParam(4, $price, PDO::PARAM_STR);
                        $sqlStatement->bindParam(5, $new_cost_price, PDO::PARAM_STR);
                        $sqlStatement->bindParam(6, $status, PDO::PARAM_STR);
                        $sqlStatement->bindParam(7, $isSelected, PDO::PARAM_STR);
                        $sqlStatement->bindParam(8, $total, PDO::PARAM_STR);
                        $sqlStatement->bindParam(9, $tax, PDO::PARAM_STR);
                        $sqlStatement->execute();

                        $product_sql = $this->connect()->prepare("UPDATE products SET cost = :cost, prod_price = :prod_price WHERE id = :id");
                        $product_sql->bindParam(":cost", $new_cost_price);
                        $product_sql->bindParam(":prod_price", $new_selling_price);
                        $product_sql->bindParam(":id", $product_id);
                        $product_sql->execute();
                      
                    }
                     else 
                    {
                        $sql = "UPDATE inventory SET qty_purchased = :v1, amount_beforeTax = :v2, amount_afterTax = :v3, status = :v4, total = :v5, tax = :v6, order_id = :v7, product_id = :v8 WHERE id = :id";
                        $sqlStatement = $this->connect()->prepare($sql);

                        $sqlStatement->bindParam(':v1', $quantity);
                        $sqlStatement->bindParam(':v2', $amount_beforeTax);
                        $sqlStatement->bindParam(':v3', $amount_afterTax);
                        $sqlStatement->bindParam(':v4', $status);
                        $sqlStatement->bindParam(':v5', $total);
                        $sqlStatement->bindParam(':v6', $tax);
                        $sqlStatement->bindParam(':v7', $formData['order_id']);
                        $sqlStatement->bindParam(':v8', $product_id);
                        $sqlStatement->bindParam(':id', $inventory_id);
                        $sqlStatement->execute();

                        $product_sql = $this->connect()->prepare("UPDATE products SET cost = :cost, prod_price = :prod_price WHERE id = :id");
                        $product_sql->bindParam(":cost", $new_cost_price);
                        $product_sql->bindParam(":prod_price", $new_selling_price);
                        $product_sql->bindParam(":id", $product_id);
                        $product_sql->execute();
                    }

                }
            } else {
                $order_id = $this->save_order($formData);
                foreach ($tbldata as $row) {
                    $product_id = $row['product_id'];
                    $product = $row['column_1'];
                    $quantity = $row['column_2'];
                    $price = $this->remove_nonBreakingSpace($this->clean_number($row['column_3']));
                    $total = $this->remove_nonBreakingSpace($this->clean_number($row['column_4']));
                    $status = 1;
                    $isSelected = 1;

                    $isVat = $this->get_productInfo($product_id)['isVat'] === 1;
               
                    $amount_beforeTax = $price;
                    $amount_afterTax = 0;
                    $tax = 0;
                    if ($isVat) {
                        $tax = $price / 1.12;
                        $amount_afterTax = $price - $tax;
                    }


                    $isPriceNotChange = $this->get_productInfo($product_id)['cost'] === $price;
                    $is_taxInclusive = $this->get_productInfo($product_id)['is_taxIncluded'] === 1;
                    $new_selling_price = $this->get_productInfo($product_id)['prod_price'];
                    $new_cost_price = $price;
                    
                    if($isPriceNotChange)
                    {
                        if($is_taxInclusive)
                        {
                            $mark_up = $this->get_productInfo($product_id)['markup']; 
                            $interest = $price * ($mark_up/100);
                            $new_selling_price = (float) $new_cost_price + $interest;
                            $new_selling_price = number_format($new_selling_price, 2, '.', '');
                        }
                        else
                        {
                            $mark_up = $this->get_productInfo($product_id)['markup']; 
                            $interest = $price * ($mark_up/100);
                            $selling_price = $new_cost_price + $interest;
            
                            $withTax = ($new_selling_price/1.12) * 0.12;
                            $new_selling_price = $withTax;
                            $new_selling_price = number_format($new_selling_price, 2, '.', '');
                        }
                    } 

                    $sqlStatement = $this->connect()->prepare("INSERT INTO inventory (order_id, product_id, qty_purchased, amount_beforeTax, amount_afterTax, status, isSelected, total, tax) 
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

                    $sqlStatement->bindParam(1, $order_id, PDO::PARAM_STR);
                    $sqlStatement->bindParam(2, $product_id, PDO::PARAM_STR);
                    $sqlStatement->bindParam(3, $quantity, PDO::PARAM_STR);
                    $sqlStatement->bindParam(4, $amount_beforeTax, PDO::PARAM_STR);
                    $sqlStatement->bindParam(5, $amount_afterTax, PDO::PARAM_STR);
                    $sqlStatement->bindParam(6, $status, PDO::PARAM_STR);
                    $sqlStatement->bindParam(7, $isSelected, PDO::PARAM_STR);
                    $sqlStatement->bindParam(8, $total, PDO::PARAM_STR);
                    $sqlStatement->bindParam(9, $tax, PDO::PARAM_STR);
                    $sqlStatement->execute();
                    
                    $product_sql = $this->connect()->prepare("UPDATE products SET cost = :cost, prod_price = :prod_price WHERE id = :id");
                    $product_sql->bindParam(":cost", $new_cost_price);
                    $product_sql->bindParam(":prod_price", $new_selling_price);
                    $product_sql->bindParam(":id", $product_id);
                    $product_sql->execute();

                    $isPaid = $order_data['isPaid'] === 1;

                    if($isPaid)
                    {
                        $expense_quantity = $quantity;
                        $expense_type = "PURCHASED ORDER";
                        $supplier_id = $order_data['supplier_id'];
                        $invoice_number = $order_data['po_number'];
                        $price = $amount_beforeTax;
                        $total_amount = $expense_quantity * $price;
                        $date_of_transaction = date('Y-m-d');
                        $uom_id_expense = $this->get_productInfo($product_id)['uom_id'];

                        $expense_stmt = $this->connect()->prepare("
                            INSERT INTO expenses (product_id, date_of_transaction, expense_type, quantity, uom_id, supplier, invoice_number, price, total_amount, taxable_amount)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ? )
                        ");

                        $expense_stmt->bindParam(1, $product_id, PDO::PARAM_STR);
                        $expense_stmt->bindParam(2, $date_of_transaction, PDO::PARAM_STR);
                        $expense_stmt->bindParam(3, $expense_type, PDO::PARAM_STR);
                        $expense_stmt->bindParam(4, $expense_quantity, PDO::PARAM_INT);
                        $expense_stmt->bindParam(5, $uom_id_expense, PDO::PARAM_INT);
                        $expense_stmt->bindParam(6, $supplier_id, PDO::PARAM_INT);
                        $expense_stmt->bindParam(7, $invoice_number, PDO::PARAM_STR);
                        $expense_stmt->bindParam(8, $price, PDO::PARAM_STR);
                        $expense_stmt->bindParam(9, $total_amount, PDO::PARAM_STR);
                        $expense_stmt->bindParam(10, $total_amount, PDO::PARAM_STR);
                        $expense_stmt->execute();
                    }
                }
            }
            return [
                'status' => true,
                'message' => 'Purchase Orders has been successfully saved!',
                'order_id' => $this->save_order($formData),
                'po_number' => $order_data['po_number'],
                'existed_product'=>"->no",
            ];
        } else {
            return [
                'status' => false,
                'errors' => $this->validateData($formData),
            ];
        }
    }
    public function get_orderData($order_id)
    {
        $sql = "SELECT *
                FROM orders
                WHERE orders.id = :order_id";

        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
