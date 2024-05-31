<?php
class InventoryFacade extends DBConnection
{
    public function get_allInventories()
    {
        $offset = isset($_GET['page']) ? $_GET['page'] : 1;
        // $sql = $this->connect()->prepare("SELECT supplier.*, products.*, inventory.*, uom.*, orders.*, inventory.id as inventory_id
        //                                     FROM inventory
        //                                     JOIN products ON products.id = inventory.product_id
        //                                     JOIN uom ON uom.id = products.uom_id
        //                                     JOIN orders ON orders.id = inventory.order_id
        //                                     JOIN supplier ON supplier.id = orders.supplier_id
        //                                     ORDER BY inventory.id ASC;");
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
                                        JOIN uom u ON u.id = p.uom_id;");
        $sql->execute();
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $data;
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
            $sql = "SELECT supplier.*, products.*, inventory.*, uom.*, orders.*, inventory.id as inventory_id
                    FROM inventory
                    JOIN products ON products.id = inventory.product_id
                    JOIN uom ON uom.id = products.uom_id
                    JOIN orders ON orders.id = inventory.order_id
                    JOIN supplier ON supplier.id = orders.supplier_id
                    ORDER BY inventory.id DESC;";

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
        $sql = "SELECT inventory.*, stocks.* 
                FROM inventory
                INNER JOIN stocks ON stocks.inventory_id = inventory.id
                WHERE inventory.id = :inventory_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":inventory_id", $inventory_id);
        $stmt->execute();
        $stocks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return [
            'inventoryInfo' => $this->get_inventoryDataById($inventory_id),
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
    public function get_realtime_notifications()
    {
        $query = "SELECT products.*, inventory.*, inventory.id as inventory_id
                    FROM inventory
                    JOIN products ON products.id = inventory.product_id
                    ORDER BY inventory.id DESC;";
        $result = $this->connect()->prepare($query); 
        $result->execute();
        $result = $result->fetchAll(PDO::FETCH_ASSOC);
        $products = []; $notifications = [];
        foreach( $result as $row )
        {
            $expiration_date = new DateTime($row['date_expired'] ?? '');
            $now = new DateTime();
            $interval = $expiration_date->diff($now);
            $days_remaining = $interval->days;
            $products[] = [
                'prod_desc'=>$row['prod_desc'],
                'barcode'=>$row['barcode'],
                'is_received' =>$row['isReceived'],
                'date_expired'=>$row['date_expired'],
                'days_remaining'=>$days_remaining,
            ];
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
    
    public function save_quickInventory($formData)
    {
        $tbl_data = json_decode($formData['tbl_data'], true);
        foreach($tbl_data as $row)
        {
            $inventory_id = $row['inventory_id'];
            $qty_onhand = (int)$row['col_2'];
            $newqty = (int)$row['newqty'];
            $newqty = $newqty + $qty_onhand;
            $currentDate = date('Y-m-d');

            $stmt = $this->connect()->prepare("UPDATE inventory SET stock = :new_stock WHERE id = :id");
            $stmt->bindParam(":new_stock", $newqty); 
            $stmt->bindParam(":id", $inventory_id); 
            $stmt->execute();

            $newqty = "+".$newqty;
            $stmt = $this->connect()->prepare("INSERT INTO stocks (inventory_id, stock, date)
                                                VALUES (?, ?, ?)");
            $stmt->bindParam(1, $inventory_id, PDO::PARAM_INT);
            $stmt->bindParam(2, $newqty, PDO::PARAM_STR); 
            $stmt->bindParam(3, $currentDate, PDO::PARAM_STR); 
            $stmt->execute();
        }
        return [
            'status'=>true,
            'msg'=>'Quick inventory has been successfully saved!',	
        ];
    }
    public function get_allProducts()
    {
        // $sql = $this->connect()->prepare("SELECT A.*, B.id as inventory_id
        //                                 FROM products A
        //                                 LEFT JOIN  inventory B ON A.ID = B.product_id
        //                                 WHERE B.product_id IS NULL");
        $sql = $this->connect()->prepare("SELECT * FROM PRODUCTS");
        $sql->execute();
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $data;
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
    public function save_order($formData)
    {
        $isPaid = filter_var($formData['isPaid'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $supplier_id = $this->get_supplierInfo($formData['supplier'])['id'];
        $date_purchased = date('Y-m-d', strtotime($formData['date_purchased']));
        $po_number = $formData['po_number'];
        $price = $this->remove_nonBreakingSpace($this->clean_number($formData['total']));
        $totalTax = $this->remove_nonBreakingSpace($this->clean_number($formData['totalTax']));
        $totalQty = $formData['totalQty'];
        $totalPrice = $this->remove_nonBreakingSpace($this->clean_number($formData['totalPrice']));
        $order_type = 1;
      
        $order_id = $this->get_lastOrderData() === false ? 0 : $this->get_lastOrderData()['id'];
        if ($formData['order_id'] !== "0") {
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
        } else {
            if (!$this->verify_order($po_number)) {
                $sqlStatement = $this->connect()->prepare("INSERT INTO orders (isPaid, supplier_id, date_purchased, po_number, price, order_type, totalTax, totalQty, totalPrice) 
                                                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $sqlStatement->bindParam(1, $isPaid, PDO::PARAM_STR);
                $sqlStatement->bindParam(2, $supplier_id, PDO::PARAM_STR);
                $sqlStatement->bindParam(3, $date_purchased, PDO::PARAM_STR);
                $sqlStatement->bindParam(4, $po_number, PDO::PARAM_STR);
                $sqlStatement->bindParam(5, $price, PDO::PARAM_STR);
                $sqlStatement->bindParam(6, $order_type, PDO::PARAM_STR);
                $sqlStatement->bindParam(7, $totalTax, PDO::PARAM_STR);
                $sqlStatement->bindParam(8, $totalQty, PDO::PARAM_STR);
                $sqlStatement->bindParam(9, $totalPrice, PDO::PARAM_STR);
                $sqlStatement->execute();

                $order_id = $this->get_lastOrderData()['id'];
            }
            if($order_id > 0)
            {
                if ($isPaid === 0) {
                    $serializedFormData = $formData['payment_settings'];
                   
                    $payment_settings = [];
                    parse_str($serializedFormData, $payment_settings);
    
                    $due_date = date('Y-m-d', strtotime($payment_settings['s_due']));
                    $loanAmount = $this->remove_nonBreakingSpace($this->clean_number($payment_settings['loan_amount']));
                    $interestRate = $payment_settings['interest_rate'];
                    $withInterest = $this->remove_nonBreakingSpace($this->clean_number($payment_settings['withInterest']));
                    $totalWithInterest = $this->remove_nonBreakingSpace($this->clean_number($payment_settings['total_withInterest']));
                    $loanTerm = $this->remove_nonBreakingSpace($this->clean_number($payment_settings['loan_term']));
                    $amortizationFrequency = $this->remove_nonBreakingSpace($this->clean_number($payment_settings['amortization_frequency']));
                    $amortizationFrequencyText = $formData['amortization_frequency_text'];
                    $installment = $this->remove_nonBreakingSpace($this->clean_number($payment_settings['installment']));
                    $rBalance = $this->remove_nonBreakingSpace($this->clean_number($payment_settings['r_balance']));
                    $orderId = $order_id;
                    $payment = $installment;
                    if($rBalance === "0.00")
                    {
                        $changePaid = 1;
                        $sql = "UPDATE orders SET isPaid = :v1 WHERE id = :id";
                        $sqlStatement = $this->connect()->prepare($sql);
                        $sqlStatement->bindParam(':v1', $changePaid);
                        $sqlStatement->bindParam(':id', $orderId);
                        $sqlStatement->execute();
                    }
                    $sql = "INSERT INTO order_payment_settings (loan, loan_percentage, interest, with_interest, due_date, term, amortization_value, amortization_text, installment, balance, order_id)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->bindParam(1, $loanAmount, PDO::PARAM_STR);
                    $stmt->bindParam(2, $interestRate, PDO::PARAM_STR);
                    $stmt->bindParam(3, $withInterest, PDO::PARAM_STR);
                    $stmt->bindParam(4, $totalWithInterest, PDO::PARAM_STR);
                    $stmt->bindParam(5, $due_date, PDO::PARAM_STR);
                    $stmt->bindParam(6, $loanTerm, PDO::PARAM_STR);
                    $stmt->bindParam(7, $amortizationFrequency, PDO::PARAM_STR);
                    $stmt->bindParam(8, $amortizationFrequencyText, PDO::PARAM_STR);
                    $stmt->bindParam(9, $installment, PDO::PARAM_STR);
                    $stmt->bindParam(10, $rBalance, PDO::PARAM_STR);
                    $stmt->bindParam(11, $orderId, PDO::PARAM_STR);
                    $stmt->execute();
    
                    $last_setting_id = $this->get_lastSettingData()['id'];
    
                    $sql_payment = "INSERT INTO order_payments (order_setting_id, payment, balance, date_paid)
                                        VALUES (?, ?, ?, ?)";
    
                    $orderSettingId = $last_setting_id;
    
                    $date_paid = date("Y-m-d");
                    $stmt_payment = $this->connect()->prepare($sql_payment);
                    $stmt_payment->bindParam(1, $orderSettingId, PDO::PARAM_INT);
                    $stmt_payment->bindParam(2, $payment, PDO::PARAM_STR);
                    $stmt_payment->bindParam(3, $rBalance, PDO::PARAM_STR);
                    $stmt_payment->bindParam(4, $date_paid, PDO::PARAM_STR);
                    $stmt_payment->execute();
                }
            }
        }
        return $order_id;
    }
    public function save_receivedItems($formData)
    {
        $tbl_data = json_decode($formData['tbl_data'], true);
        // $subRowData = json_decode($formData['subRowData'], true);
        $is_received = $formData['is_received'] !== 0 ? true : false;
        // $serializedFormData = $formData['receive_form'];
        $po_number = $formData["po_number"];
      
        foreach ($tbl_data as $row) 
        {
            $inventory_id = $row["inventory_id"];
            $qty_received = $row["qty_received"];
            $expired_date = "";
            if($row["date_expired"] !== "")
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

                $sql = $this->connect()->prepare("UPDATE orders SET is_received = :is_received
                    WHERE po_number = :po_number");
                $sql->bindParam(":is_received", $is_received_val, PDO::PARAM_INT);
                $sql->bindParam(":po_number", $po_number, PDO::PARAM_STR);
                $sql->execute();

                $sql = "UPDATE inventory SET qty_received = :v1, date_expired = :v2, isSerialized = :v3 WHERE id = :id";
                $sqlStatement = $this->connect()->prepare($sql);
                $sqlStatement->bindParam(':v1', $qty_received);
                $sqlStatement->bindParam(':v2', $expired_date, PDO::PARAM_STR);
                $sqlStatement->bindParam(':v3', $is_serialized, PDO::PARAM_INT);
                $sqlStatement->bindParam(':id', $inventory_id);
                $sqlStatement->execute();

                if($is_received)
                {
                    $isReceived = 1;
                    $stmt = $this->connect()->prepare("UPDATE inventory SET isReceived = :isReceived, stock = stock + :new_stock, qty_received = :qty_received, qty_purchased = qty_purchased - :counted WHERE id = :id");
                    $stmt->bindParam(":new_stock", $qty_received); 
                    $stmt->bindParam(":isReceived", $isReceived); 
                    $stmt->bindParam(":qty_received", $qty_received);
                    $stmt->bindParam(":counted", $qty_received);
                    $stmt->bindParam(":id", $inventory_id); 
                    $stmt->execute();

                    if($qty_received > 0) {$qty_received = "+".$qty_received;}
                   
                    $stmt = $this->connect()->prepare("INSERT INTO stocks (inventory_id, stock, date)
                                                        VALUES (?, ?, ?)");
                    $stmt->bindParam(1, $inventory_id, PDO::PARAM_INT);
                    $stmt->bindParam(2, $qty_received, PDO::PARAM_STR); 
                    $stmt->bindParam(3, $currentDate, PDO::PARAM_STR); 
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
                    $stmt = $this->connect()->prepare("UPDATE inventory SET isReceived = :isReceived, stock = stock + :new_stock, qty_received = :qty_received, qty_purchased = qty_purchased - :counted WHERE id = :id");
                    $stmt->bindParam(":new_stock", $qty_received); 
                    $stmt->bindParam(":isReceived", $isReceived); 
                    $stmt->bindParam(":qty_received", $qty_received);
                    $stmt->bindParam(":counted", $qty_received);
                    $stmt->bindParam(":id", $inventory_id); 
                    $stmt->execute();

                    $qty_received = "+".$qty_received;
                    $stmt = $this->connect()->prepare("INSERT INTO stocks (inventory_id, stock, date)
                                                        VALUES (?, ?, ?)");
                    $stmt->bindParam(1, $inventory_id, PDO::PARAM_INT);
                    $stmt->bindParam(2, $qty_received, PDO::PARAM_STR); 
                    $stmt->bindParam(3, $currentDate, PDO::PARAM_STR); 
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
        if ($this->validateData($formData)) {
            $tbldata = json_decode($formData['data'], true);
            $order_id = $this->save_order($formData);
            $existed_product = [];
            if ($formData['order_id'] > 0) {
                if (isset($formData['remove_inventories'])) {
                    $this->remove_inventories($formData['remove_inventories']);
                }
                foreach ($tbldata as $row) {
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
                    if ($inventory_id === 0) {

                        if(!$this->check_ifInventoryExist($product_id))
                        {
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
                        }
                        else
                        {
                            $existed_product[] = [$product_id];
                        }
                    } else {
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

                    if(!$this->check_ifInventoryExist($product_id))
                    {
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
                    }
                    else{
                        $existed_product[] = [$this->get_productInfo($product_id)['prod_desc']];
                    }
                }
            }
            return [
                'status' => true,
                'message' => 'Purchase Orders has been successfully saved!',
                'existed_product'=>$existed_product,
            ];
        } else {
            return [
                'status' => false,
                'errors' => $this->validateData($formData),
            ];
        }
    }
}
