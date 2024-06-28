<?php
class DashboardFacade extends DBConnection 
{
    public function pos_settings()
    {
        $stmt = $this->connect()->prepare("SELECT color_pallete FROM pos_settings");
        $stmt->execute();
        return $stmt->fetch()["color_pallete"] ?? "";
    }
    public function get_product_total_count()
    {
        $stmt = $this->connect()->prepare("SELECT COUNT(products.id) as total FROM products INNER JOIN inventory ON inventory.product_id = products.id WHERE inventory.isReceived = 1");
        $stmt->execute();
        return $stmt->fetch()["total"] ?? 0;
    }
    public function get_total_sales()
    {
        
    }
    function convertDateFormat($date) {
        $dateTime = DateTime::createFromFormat('d/m/Y', $date);
        if (!$dateTime) {
            throw new Exception("Failed to parse date: $date");
        }
        return $dateTime->format('Y-m-d');
    }
    public function get_allTopProducts($item, $start_date, $end_date)
    {
        $start_date = $this->convertDateFormat($start_date);
        $end_date = $this->convertDateFormat($end_date);
    
        $top_products = $this->query_top_products($start_date, $end_date);

        $tp_array = [];
        $total_sales_by_period = 0;
        foreach($top_products as $row)
        {
            $grossAmount = $row['grossAmount'] - $row['itemDiscount'] - $row['overallDiscounts']-$row['totalCartDiscountPerItem'];

            $total_sales_by_period += $grossAmount;

            $tp_array[] = [
                'product' => $row['product'],
                'total_paid_amount' => $grossAmount,
            ];
        }
        usort($tp_array, function($a, $b) {
            return $b['total_paid_amount'] - $a['total_paid_amount'];
        });
        $data = array_slice($tp_array, 0, $item);
        return [
            'data'=> $data,
            'total_sales_by_period' => $total_sales_by_period,
            'total_gross_sales_by_period' => $total_sales_by_period,
            'total_expense_by_period' => $this->get_expenseValueFromDatePeriod($start_date, $end_date)['total_expense_of_the_month']
        ];
    }
    public function get_salesDataByHour($start_date, $end_date)
    {
        $start_date = $this->convertDateFormat($start_date);
        $end_date = $this->convertDateFormat($end_date);
        
        $labels = [
            '6AM-8AM' => '06:00:00 AND 08:00:00',
            '8AM-10AM' => '08:00:00 AND 10:00:00',
            '10AM-12PM' => '10:00:00 AND 12:00:00',
            '12PM-2PM' => '12:00:00 AND 14:00:00',
            '2PM-4PM' => '14:00:00 AND 16:00:00',
            '4PM-6PM' => '16:00:00 AND 18:00:00',
            '6PM-8PM' => '18:00:00 AND 20:00:00',
            '8PM-10PM' => '20:00:00 AND 22:00:00',
            '10PM-12AM' => '22:00:00 AND 00:00:00',
            '12AM-2AM' => '00:00:00 AND 02:00:00',
            '2AM-4AM' => '02:00:00 AND 04:00:00',
            '4AM-6AM' => '04:00:00 AND 06:00:00'
        ];
        
        $salesData = [];
        $chart_labels = [];
        foreach($labels as $label => $timeRange)
        {
            list($start_time, $end_time) = explode(' AND ', $timeRange);
            $top_products = $this->query_top_products_by_hour($start_date, $end_date, $start_time, $end_time);

            $sales = 0;
            foreach($top_products as $row)
            {
                $grossAmount = $row['grossAmount'] 
                            - $row['itemDiscount'] 
                            - $row['overallDiscounts']
                            - $row['totalCartDiscountPerItem'];
                
                $sales += $grossAmount;
            }
            
            $chart_labels[] = $label;
            $salesData[] = $sales;
        }
        
        return [
            'labels' => $chart_labels,
            'salesData' => $salesData,
        ];
    }
    public function query_top_products_by_hour($start_date, $end_date, $start_time, $end_time)
    {
        $sql = $this->connect()->prepare("WITH TotalCartValue AS (
                                        SELECT
                                        DISTINCT
                                            py.id AS payment_id,
                                            py.cart_discount AS total_cart_value,
                                            py.cart_discount/SUM(t.prod_qty) as cartdiscount
                                        FROM
                                            transactions AS t
                                        INNER JOIN
                                            products AS p ON p.id = t.prod_id
                                        INNER JOIN
                                            payments AS py ON py.id = t.payment_id
                                        WHERE
                                            t.is_paid = 1
                                            AND t.is_void = 0
                                        GROUP BY
                                            py.id
                                    )
                                    SELECT DISTINCT  
                                    p.id AS id, 
                                    p.prod_desc AS product, 
                                    p.cost AS cost,
                                    p.sku AS sku, 
                                    p.markup AS markup, 
                                    py.id AS payment_id, 
                                    p.prod_price AS prod_price,
                                    SUM(t.prod_qty)  AS qty,
                                    COALESCE(tr.total_qty,0) as refundedQty,
                                    COALESCE(ret.total_qty,0) AS returnedQty,
                                    SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0) as newQty,
                                    CAST(SUM(t.discount_amount)- COALESCE(ret.overAlldiscounts,0)-COALESCE(tr.overAlldiscounts,0)AS DECIMAL(10,2))as itemDiscount,
                                    CAST(SUM(
                                        CASE 
                                            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                                                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
                                            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                                                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
                                            ELSE 0 
                                        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)AS DECIMAL(10,2))  AS overallDiscounts,
                                    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,

                                    CASE
                                        WHEN p.isVAT = 1 THEN 
                                            CAST(
                                                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                                                AS DECIMAL(10,2)
                                            )
                                        ELSE 0
                                    END AS totalVat,
                                    CAST((CAST(COALESCE(SUM(tc.cartdiscount),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0))AS DECIMAL(10,2)) as totalCartDiscountPerItem,
                                    COALESCE( tr.refundedamt,0)  as refundedAmt,
                                    COALESCE( ret.returnamt,0) as returnAmt,
                                    COALESCE(tr.total_cart,0) AS CARTrEFUND
                                
                                FROM 
                                    products AS p
                                INNER JOIN 
                                    transactions AS t ON p.id = t.prod_id 
                                INNER JOIN 
                                    payments AS py ON py.id = t.payment_id 
                                INNER JOIN 
                                    users AS u ON u.id = t.user_id 
                                INNER JOIN 
                                    discounts AS d ON d.id = u.discount_id 
                                LEFT JOIN
                                    TotalCartValue AS tc ON tc.payment_id = py.id
                                LEFT JOIN(WITH RefundSums AS (
                                    SELECT 
                                    DISTINCT
                                        r.id AS refunded_id,
                                        r.payment_id,
                                        r.prod_id,
                                        r.refunded_qty AS qty,
                                        r.refunded_amt AS amount,
                                        r.reference_num,
                                        r.otherDetails,
                                        u.id AS user_id,
                                        u.discount_id,
                                        d.discount_amount AS discountRate,
                                        products.prod_desc AS prod_desc,
                                        products.barcode AS barcode,
                                        products.sku AS sku,
                                        products.isVAT,
                                        products.is_discounted,
                                        products.prod_price,
                                        r.itemDiscount,
                                        t.prod_qty,
                                            COALESCE(
                                                    CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].itemDiscountsData')) AS DECIMAL(10, 2)), 0
                                                        )
                                                    AS total_item_discounts,
                                    COALESCE(r.refunded_amt,0) * COALESCE(
                                                CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 20)),
                                                0
                                            ) AS refundCart
                                    FROM refunded AS r
                                    INNER JOIN payments AS p ON r.payment_id = p.id
                                    INNER JOIN transactions AS t ON t.payment_id = p.id
                                    INNER JOIN products ON r.prod_id = products.id
                                    INNER JOIN users AS u ON t.user_id = u.id
                                    INNER JOIN discounts AS d ON u.discount_id = d.id
                                ),
                                CustomerDiscounts AS (
                                    SELECT 
                                    DISTINCT
                                        rs.refunded_id,
                                        rs.payment_id,
                                        rs.prod_id ,
                                        SUM(DISTINCT rs.refundCart) as overallCart,
                                        SUM(DISTINCT rs.total_item_discounts) AS overAlldiscounts,
                                        SUM(DISTINCT rs.qty) AS total_qty,
                                        CAST(SUM(DISTINCT rs.amount)AS DECIMAL(10,2)) AS total_amount,
                                        SUM(
                                            CASE
                                                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                                                    CAST(
                                                        (
                                                            ((rs.qty * rs.prod_price) - 
                                                            ((rs.qty * rs.prod_price) * ((rs.itemDiscount / (rs.prod_qty * rs.prod_price)) * 100) / 100)
                                                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                                                        
                                                    )
                                                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                                                    CAST(
                                                        (
                                                            ((rs.qty * rs.prod_price) - 
                                                            ((rs.qty * rs.prod_price) * ((rs.itemDiscount / (rs.qty * rs.prod_price)) * 100) / 100)
                                                        ) * rs.discountRate / 100)
                                                        AS DECIMAL(10,2)
                                                    )
                                                ELSE 0
                                            END
                                        ) AS total_customer_discount
                                    FROM RefundSums AS rs
                                    GROUP BY rs.refunded_id, rs.payment_id, rs.prod_id
                                ),
                                RefundTotals AS (
                                    SELECT 
                                        cd.prod_id,
                                        SUM(cd.total_qty) AS total_qty,
                                        CAST(SUM(cd.total_amount)AS DECIMAL(10,2)) AS total_amount,
                                        CAST(SUM(cd.total_customer_discount)AS DECIMAL(10,2)) AS total_customer_discount,
                                        CAST(SUM(cd.overallCart)AS DECIMAL(10,6)) as total_cart,
                                    SUM(cd.overAlldiscounts) AS overAlldiscounts
                                    FROM CustomerDiscounts AS cd
                                    GROUP BY cd.prod_id
                                )
                                SELECT 
                                    rt.prod_id,
                                    rt.total_qty,
                                    rt.total_amount,
                                    rt.total_customer_discount,
                                    rt.overAlldiscounts,
                                    rt.total_cart,
                                    CAST((rt.total_amount-rt.total_customer_discount-rt.overAlldiscounts- rt.total_cart) AS DECIMAL(10,2)) AS refundedamt
                                FROM RefundTotals AS rt)  AS tr On tr.prod_id = p.id
                                LEFT JOIN (WITH RefundSums AS (
                                    SELECT 
                                    DISTINCT
                                        r.id AS return_id,
                                        r.payment_id,
                                        r.product_id,
                                        r.return_qty AS qty,
                                        r.return_amount AS amount,
                                        r.otherDetails,
                                        u.id AS user_id,
                                        u.discount_id,
                                        d.discount_amount AS discountRate,
                                        products.prod_desc AS prod_desc,
                                        products.barcode AS barcode,
                                        products.sku AS sku,
                                        products.isVAT,
                                        products.is_discounted,
                                        products.prod_price,
                                        r.itemDiscount,
                                        t.prod_qty,
                                            COALESCE(
                                                    CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].itemDiscountsData')) AS DECIMAL(10, 2)), 0
                                                        )
                                                    AS total_item_discounts,
                                    COALESCE(r.return_amount,0) * COALESCE(
                                                CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 20)),
                                                0
                                            ) AS returnCart
                                    FROM return_exchange AS r
                                    INNER JOIN payments AS p ON r.payment_id = p.id
                                    INNER JOIN transactions AS t ON t.payment_id = p.id
                                    INNER JOIN products ON r.product_id = products.id
                                    INNER JOIN users AS u ON t.user_id = u.id
                                    INNER JOIN discounts AS d ON u.discount_id = d.id
                                ),
                                CustomerDiscounts AS (
                                    SELECT 
                                    DISTINCT
                                        rs.return_id,
                                        rs.payment_id,
                                        rs.product_id,
                                        SUM(DISTINCT rs.returnCart) as overallCart,
                                        SUM(DISTINCT rs.total_item_discounts) AS overAlldiscounts,
                                        SUM(DISTINCT rs.qty) AS total_qty,
                                        CAST(SUM(DISTINCT rs.amount)AS DECIMAL(10,2)) AS total_amount,
                                        SUM(
                                            CASE
                                                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                                                    CAST(
                                                        (
                                                            ((rs.qty * rs.prod_price) - 
                                                            ((rs.qty * rs.prod_price) * ((rs.itemDiscount / (rs.prod_qty * rs.prod_price)) * 100) / 100)
                                                        ) / 1.12) * rs.discountRate / 100
                                                        AS DECIMAL(10,2)
                                                    )
                                                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                                                    CAST(
                                                        (
                                                            ((rs.qty * rs.prod_price) - 
                                                            ((rs.qty * rs.prod_price) * ((rs.itemDiscount / (rs.qty * rs.prod_price)) * 100) / 100)
                                                        ) * rs.discountRate / 100)
                                                        AS DECIMAL(10,2)
                                                    )
                                                ELSE 0
                                            END
                                        ) AS total_customer_discount
                                    FROM RefundSums AS rs
                                    GROUP BY rs.return_id, rs.payment_id, rs.product_id
                                ),
                                ReturnTotals AS (
                                    SELECT 
                                        cd.product_id,
                                        SUM(cd.total_qty) AS total_qty,
                                        CAST(SUM(cd.total_amount)AS DECIMAL(10,2)) AS total_amount,
                                        CAST(SUM(cd.total_customer_discount)AS DECIMAL(10,2)) AS total_customer_discount,
                                        CAST(SUM(cd.overallCart)AS DECIMAL(10,6)) as total_cart,
                                    SUM(cd.overAlldiscounts) AS overAlldiscounts
                                    FROM CustomerDiscounts AS cd
                                    GROUP BY cd.product_id
                                )
                                SELECT 
                                    rt.product_id,
                                    rt.total_qty,
                                    rt.total_amount,
                                    rt.total_customer_discount,
                                    rt.overAlldiscounts,
                                    rt.total_cart,
                                    CAST((rt.total_amount-rt.total_customer_discount-rt.overAlldiscounts- rt.total_cart)AS DECIMAL(10,2)) AS returnamt
                                FROM ReturnTotals AS rt) AS ret ON ret.product_id = p.id
                                WHERE 
                                    t.is_paid = 1 
                                    AND t.is_void = 0
                                    AND (DATE(py.date_time_of_payment) BETWEEN :st_date AND :end_date)
                                    AND (TIME(py.date_time_of_payment) BETWEEN :start_time AND :end_time)
                                GROUP BY
                                    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
                                HAVING
                                newQty > 0;");

        $sql->execute([
            ':st_date' => $start_date,
            ':end_date' => $end_date,
            ':start_time' => $start_time,
            ':end_time' => $end_time
        ]);
      return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function query_top_products($start_date, $end_date)
    {
        $sql = $this->connect()->prepare("WITH TotalCartValue AS (
                                        SELECT
                                        DISTINCT
                                            py.id AS payment_id,
                                            py.cart_discount AS total_cart_value,
                                            py.cart_discount/SUM(t.prod_qty) as cartdiscount
                                        FROM
                                            transactions AS t
                                        INNER JOIN
                                            products AS p ON p.id = t.prod_id
                                        INNER JOIN
                                            payments AS py ON py.id = t.payment_id
                                        WHERE
                                            t.is_paid = 1
                                            AND t.is_void = 0
                                        GROUP BY
                                            py.id
                                    )
                                    SELECT DISTINCT  
                                    p.id AS id, 
                                    p.prod_desc AS product, 
                                    p.cost AS cost,
                                    p.sku AS sku, 
                                    p.markup AS markup, 
                                    py.id AS payment_id, 
                                    p.prod_price AS prod_price,
                                    SUM(t.prod_qty)  AS qty,
                                    COALESCE(tr.total_qty,0) as refundedQty,
                                    COALESCE(ret.total_qty,0) AS returnedQty,
                                    SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0) as newQty,
                                    CAST(SUM(t.discount_amount)- COALESCE(ret.overAlldiscounts,0)-COALESCE(tr.overAlldiscounts,0)AS DECIMAL(10,2))as itemDiscount,
                                    CAST(SUM(
                                        CASE 
                                            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                                                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
                                            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                                                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
                                            ELSE 0 
                                        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)AS DECIMAL(10,2))  AS overallDiscounts,
                                    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,

                                    CASE
                                        WHEN p.isVAT = 1 THEN 
                                            CAST(
                                                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                                                AS DECIMAL(10,2)
                                            )
                                        ELSE 0
                                    END AS totalVat,
                                    CAST((CAST(COALESCE(SUM(tc.cartdiscount),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0))AS DECIMAL(10,2)) as totalCartDiscountPerItem,
                                    COALESCE( tr.refundedamt,0)  as refundedAmt,
                                    COALESCE( ret.returnamt,0) as returnAmt,
                                    COALESCE(tr.total_cart,0) AS CARTrEFUND
                                
                                FROM 
                                    products AS p
                                INNER JOIN 
                                    transactions AS t ON p.id = t.prod_id 
                                INNER JOIN 
                                    payments AS py ON py.id = t.payment_id 
                                INNER JOIN 
                                    users AS u ON u.id = t.user_id 
                                INNER JOIN 
                                    discounts AS d ON d.id = u.discount_id 
                                LEFT JOIN
                                    TotalCartValue AS tc ON tc.payment_id = py.id
                                LEFT JOIN(WITH RefundSums AS (
                                    SELECT 
                                    DISTINCT
                                        r.id AS refunded_id,
                                        r.payment_id,
                                        r.prod_id,
                                        r.refunded_qty AS qty,
                                        r.refunded_amt AS amount,
                                        r.reference_num,
                                        r.otherDetails,
                                        u.id AS user_id,
                                        u.discount_id,
                                        d.discount_amount AS discountRate,
                                        products.prod_desc AS prod_desc,
                                        products.barcode AS barcode,
                                        products.sku AS sku,
                                        products.isVAT,
                                        products.is_discounted,
                                        products.prod_price,
                                        r.itemDiscount,
                                        t.prod_qty,
                                            COALESCE(
                                                    CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].itemDiscountsData')) AS DECIMAL(10, 2)), 0
                                                        )
                                                    AS total_item_discounts,
                                    COALESCE(r.refunded_amt,0) * COALESCE(
                                                CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 20)),
                                                0
                                            ) AS refundCart
                                    FROM refunded AS r
                                    INNER JOIN payments AS p ON r.payment_id = p.id
                                    INNER JOIN transactions AS t ON t.payment_id = p.id
                                    INNER JOIN products ON r.prod_id = products.id
                                    INNER JOIN users AS u ON t.user_id = u.id
                                    INNER JOIN discounts AS d ON u.discount_id = d.id
                                ),
                                CustomerDiscounts AS (
                                    SELECT 
                                    DISTINCT
                                        rs.refunded_id,
                                        rs.payment_id,
                                        rs.prod_id ,
                                        SUM(DISTINCT rs.refundCart) as overallCart,
                                        SUM(DISTINCT rs.total_item_discounts) AS overAlldiscounts,
                                        SUM(DISTINCT rs.qty) AS total_qty,
                                        CAST(SUM(DISTINCT rs.amount)AS DECIMAL(10,2)) AS total_amount,
                                        SUM(
                                            CASE
                                                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                                                    CAST(
                                                        (
                                                            ((rs.qty * rs.prod_price) - 
                                                            ((rs.qty * rs.prod_price) * ((rs.itemDiscount / (rs.prod_qty * rs.prod_price)) * 100) / 100)
                                                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                                                        
                                                    )
                                                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                                                    CAST(
                                                        (
                                                            ((rs.qty * rs.prod_price) - 
                                                            ((rs.qty * rs.prod_price) * ((rs.itemDiscount / (rs.qty * rs.prod_price)) * 100) / 100)
                                                        ) * rs.discountRate / 100)
                                                        AS DECIMAL(10,2)
                                                    )
                                                ELSE 0
                                            END
                                        ) AS total_customer_discount
                                    FROM RefundSums AS rs
                                    GROUP BY rs.refunded_id, rs.payment_id, rs.prod_id
                                ),
                                RefundTotals AS (
                                    SELECT 
                                        cd.prod_id,
                                        SUM(cd.total_qty) AS total_qty,
                                        CAST(SUM(cd.total_amount)AS DECIMAL(10,2)) AS total_amount,
                                        CAST(SUM(cd.total_customer_discount)AS DECIMAL(10,2)) AS total_customer_discount,
                                        CAST(SUM(cd.overallCart)AS DECIMAL(10,6)) as total_cart,
                                    SUM(cd.overAlldiscounts) AS overAlldiscounts
                                    FROM CustomerDiscounts AS cd
                                    GROUP BY cd.prod_id
                                )
                                SELECT 
                                    rt.prod_id,
                                    rt.total_qty,
                                    rt.total_amount,
                                    rt.total_customer_discount,
                                    rt.overAlldiscounts,
                                    rt.total_cart,
                                    CAST((rt.total_amount-rt.total_customer_discount-rt.overAlldiscounts- rt.total_cart) AS DECIMAL(10,2)) AS refundedamt
                                FROM RefundTotals AS rt)  AS tr On tr.prod_id = p.id
                                LEFT JOIN (WITH RefundSums AS (
                                    SELECT 
                                    DISTINCT
                                        r.id AS return_id,
                                        r.payment_id,
                                        r.product_id,
                                        r.return_qty AS qty,
                                        r.return_amount AS amount,
                                        r.otherDetails,
                                        u.id AS user_id,
                                        u.discount_id,
                                        d.discount_amount AS discountRate,
                                        products.prod_desc AS prod_desc,
                                        products.barcode AS barcode,
                                        products.sku AS sku,
                                        products.isVAT,
                                        products.is_discounted,
                                        products.prod_price,
                                        r.itemDiscount,
                                        t.prod_qty,
                                            COALESCE(
                                                    CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].itemDiscountsData')) AS DECIMAL(10, 2)), 0
                                                        )
                                                    AS total_item_discounts,
                                    COALESCE(r.return_amount,0) * COALESCE(
                                                CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 20)),
                                                0
                                            ) AS returnCart
                                    FROM return_exchange AS r
                                    INNER JOIN payments AS p ON r.payment_id = p.id
                                    INNER JOIN transactions AS t ON t.payment_id = p.id
                                    INNER JOIN products ON r.product_id = products.id
                                    INNER JOIN users AS u ON t.user_id = u.id
                                    INNER JOIN discounts AS d ON u.discount_id = d.id
                                ),
                                CustomerDiscounts AS (
                                    SELECT 
                                    DISTINCT
                                        rs.return_id,
                                        rs.payment_id,
                                        rs.product_id,
                                        SUM(DISTINCT rs.returnCart) as overallCart,
                                        SUM(DISTINCT rs.total_item_discounts) AS overAlldiscounts,
                                        SUM(DISTINCT rs.qty) AS total_qty,
                                        CAST(SUM(DISTINCT rs.amount)AS DECIMAL(10,2)) AS total_amount,
                                        SUM(
                                            CASE
                                                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                                                    CAST(
                                                        (
                                                            ((rs.qty * rs.prod_price) - 
                                                            ((rs.qty * rs.prod_price) * ((rs.itemDiscount / (rs.prod_qty * rs.prod_price)) * 100) / 100)
                                                        ) / 1.12) * rs.discountRate / 100
                                                        AS DECIMAL(10,2)
                                                    )
                                                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                                                    CAST(
                                                        (
                                                            ((rs.qty * rs.prod_price) - 
                                                            ((rs.qty * rs.prod_price) * ((rs.itemDiscount / (rs.qty * rs.prod_price)) * 100) / 100)
                                                        ) * rs.discountRate / 100)
                                                        AS DECIMAL(10,2)
                                                    )
                                                ELSE 0
                                            END
                                        ) AS total_customer_discount
                                    FROM RefundSums AS rs
                                    GROUP BY rs.return_id, rs.payment_id, rs.product_id
                                ),
                                ReturnTotals AS (
                                    SELECT 
                                        cd.product_id,
                                        SUM(cd.total_qty) AS total_qty,
                                        CAST(SUM(cd.total_amount)AS DECIMAL(10,2)) AS total_amount,
                                        CAST(SUM(cd.total_customer_discount)AS DECIMAL(10,2)) AS total_customer_discount,
                                        CAST(SUM(cd.overallCart)AS DECIMAL(10,6)) as total_cart,
                                    SUM(cd.overAlldiscounts) AS overAlldiscounts
                                    FROM CustomerDiscounts AS cd
                                    GROUP BY cd.product_id
                                )
                                SELECT 
                                    rt.product_id,
                                    rt.total_qty,
                                    rt.total_amount,
                                    rt.total_customer_discount,
                                    rt.overAlldiscounts,
                                    rt.total_cart,
                                    CAST((rt.total_amount-rt.total_customer_discount-rt.overAlldiscounts- rt.total_cart)AS DECIMAL(10,2)) AS returnamt
                                FROM ReturnTotals AS rt) AS ret ON ret.product_id = p.id
                                WHERE 
                                    t.is_paid = 1 
                                    AND t.is_void = 0
                                    AND (DATE(py.date_time_of_payment) BETWEEN :st_date AND :end_date)
                                GROUP BY
                                    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
                                HAVING
                                newQty > 0;");

      $sql->execute([':st_date' => $start_date, ':end_date' => $end_date]);
      return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    function formatNumber($number) 
    {
        return number_format((float)$number, 2, '.', ',');
    }
    public function get_salesDataByYear($year)
    {
        $salesData = [];
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $annual_sales = 0;
        $expensesData = [];
        $annual_expenses = 0;
        for ($i = 1; $i <= count($months) - 1; $i++) 
        {
            $month = $i;
            $payment_sql = $this->connect()->prepare("WITH RefundSums AS (
                                                        SELECT 
                                                            r.payment_id,
                                                            COALESCE(
                                                                    CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].credits')) AS DECIMAL(10, 2)),
                                                                    0
                                                                ) as credits,
                                                        COALESCE(
                                                                    CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].cartRate')) AS DECIMAL(10, 2)),
                                                                    0
                                                                ) as cartRateRefund,
                                                            COALESCE(
                                                                    CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].discount')) AS DECIMAL(10, 2)),
                                                                    0
                                                                ) as discountsTender,
                                                        SUM(COALESCE(r.refunded_amt, 0)) AS refunded_amt,
                                                            SUM(
                                                                COALESCE(
                                                                    CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].itemDiscountsData')) AS DECIMAL(10, 2)),
                                                                    0
                                                                )
                                                            ) AS total_item_discounts,
                                                    ROUND(SUM(COALESCE(r.refunded_amt, 0) * COALESCE(
                                                        CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 20)),
                                                        0
                                                    )),2) AS refundCart,
                                                    ROUND(SUM(COALESCE(r.refunded_amt, 0)) - 
                                                    COALESCE(
                                                        CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].credits')) AS DECIMAL(10, 2)),
                                                        0
                                                    )-  COALESCE(
                                                                    CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].discount')) AS DECIMAL(10, 2)),
                                                                    0
                                                                ) - ROUND(SUM(COALESCE(r.refunded_amt, 0) * COALESCE(
                                                        CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 20)),
                                                        0
                                                    )),2),2) AS otherPayments
                                                        FROM 
                                                            refunded r
                                                        GROUP BY 
                                                            r.reference_num
                                                    ),
                                                    ReturnExchangeSums AS (
                                                        SELECT 
                                                            rc.payment_id,
                                                        COALESCE(
                                                                    CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].credits')) AS DECIMAL(10, 2)),
                                                                    0
                                                                ) as rc_credits,
                                                            COALESCE(
                                                                    CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].cartRate')) AS DECIMAL(10, 2)),
                                                                    0
                                                                ) as cartRateReturn,
                                                            COALESCE(
                                                                    CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].discount')) AS DECIMAL(10, 2)),
                                                                    0
                                                                ) as discountsReturnTender,
                                                        SUM(COALESCE(rc.return_amount, 0)) AS return_amt,
                                                            SUM(
                                                                COALESCE(
                                                                    CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].itemDiscountsData')) AS DECIMAL(10, 2)),
                                                                    0
                                                                )
                                                            ) AS total_return_item_discounts,
                                                        ROUND(SUM(COALESCE(rc.return_amount, 0) * COALESCE(
                                                        CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 20)),
                                                        0
                                                    )),2) AS returnCart,
                                                    ROUND(SUM(COALESCE(rc.return_amount, 0)) - 
                                                    COALESCE(
                                                        CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].credits')) AS DECIMAL(10, 2)),
                                                        0
                                                    )-  COALESCE(
                                                                    CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].discount')) AS DECIMAL(10, 2)),
                                                                    0
                                                                ) - ROUND(SUM(COALESCE(rc.return_amount, 0) * COALESCE(
                                                        CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 20)),
                                                        0
                                                    )),2),2) AS otherReturnPayments 
                                                    
                                                        FROM 
                                                            return_exchange  rc
                                                        GROUP BY 
                                                            rc.payment_id
                                                    )
                                                    SELECT
                                                    DISTINCT
                                                        ps.prod_desc as product,
                                                        ROUND(COALESCE(SUM(DISTINCT p.payment_amount), 0),2) AS paid_amount,
                                                        ROUND(COALESCE(SUM(DISTINCT p.change_amount), 0),2) AS totalChange,
                                                        p.date_time_of_payment AS date,
                                                        p.cart_discount AS cart_discount,
                                                        d.discount_amount AS discountsRate,
                                                        COALESCE(SUM(DISTINCT rs.refunded_amt), 0) AS refunded_amt,
                                                        IFNULL(rs.total_item_discounts, 0) AS total_item_discounts,
                                                        COALESCE(SUM(DISTINCT rs.credits), 0) AS totalCredits,
                                                        COALESCE(SUM(DISTINCT rs.discountsTender), 0) AS totalDiscountsTender,
                                                        COALESCE(SUM(DISTINCT rs.cartRateRefund), 0) AS cartRateRefundTotal,
                                                        COALESCE(SUM(DISTINCT rs.refundCart), 0) AS cartRefundTotal,
                                                        COALESCE(SUM(DISTINCT rs.otherPayments), 0) AS totalOtherPayments,
                                                        
                                                        COALESCE(SUM(DISTINCT res.return_amt), 0) AS return_amt,
                                                        IFNULL(res. total_return_item_discounts, 0) AS total_return_item_discounts,
                                                        COALESCE(SUM(DISTINCT res.rc_credits), 0) AS totalReturnCredits,
                                                        COALESCE(SUM(DISTINCT res.discountsReturnTender), 0) AS totalDiscountsReturnTender,
                                                        COALESCE(SUM(DISTINCT res.cartRateReturn), 0) AS cartRateReturnTotal,
                                                        COALESCE(SUM(DISTINCT res.returnCart), 0) AS cartReturnTotal,
                                                        COALESCE(SUM(DISTINCT res.otherReturnPayments ), 0) AS totalOtherReturnPayments
                                                    
                                                        
                                                    FROM 
                                                        payments AS p
                                                        INNER JOIN transactions AS t ON p.id = t.payment_id 
                                                        INNER JOIN users AS u ON u.id = t.user_id
                                                        INNER JOIN discounts AS d ON d.id = u.discount_id
                                                        INNER JOIN products AS ps ON ps.id = t.prod_id
                                                        LEFT JOIN RefundSums rs ON rs.payment_id = p.id
                                                        LEFT JOIN ReturnExchangeSums res ON res.payment_id = p.id
                                                    WHERE
                                                    t.is_paid = 1 
                                                    AND t.is_void = 0 
                                                    AND MONTH(p.date_time_of_payment) = :currentMonth
                                                    AND YEAR(p.date_time_of_payment) = :currentYear
                                                GROUP BY 
                                                       p.id");

            $payment_sql->execute([':currentMonth' => $month, ':currentYear' => $year]);
            $payments = $payment_sql->fetchAll(PDO::FETCH_ASSOC);

            $monthly_gross_sale = 0;
    
            foreach ($payments as $row) 
            {

                $paid_amount = $row['paid_amount'];
                $totalChange = $row['totalChange'];
            
                $sales = $paid_amount - $totalChange;
            
                $refunded_amt = $row['refunded_amt'];
                $refudned_item_discount = $row['total_item_discounts'];
                $refund_credits = $row['totalCredits'];
                $totalRefundDiscountsTendered = $row['totalDiscountsTender'];
            
                $totalRefundedAmt =  $refunded_amt-$refudned_item_discount- $totalRefundDiscountsTendered;
            
                //return
                $return_amount = $row['return_amt'];
                $return_item_discounts = $row['total_return_item_discounts'];
                $return_credits = $row['totalReturnCredits'];
                $totalReturnDiscountsTender = $row['totalDiscountsReturnTender'];
            
                $totalReturnAmt = $return_amount-$return_item_discounts-$return_credits-$totalReturnDiscountsTender;
            
                $totalGrossSales = $sales-$totalRefundedAmt-$totalReturnAmt;
                $monthly_gross_sale += number_format($totalGrossSales, 2);
            
            }
            $month_expense = $this->get_totalExpenseOfTheMonth($month, $year)['total_expense_of_the_month'];
            $expensesData[] = $month_expense !== null ? $month_expense : 0;
            $annual_expenses += $month_expense;
            
            $salesData[] = $monthly_gross_sale;
            $annual_sales += $monthly_gross_sale;
        }

        $maxValue = max($salesData);
        $maxIndex = array_search($maxValue, $salesData);
        $monthName = $months[$maxIndex];

        $maxExpenseValue = max($expensesData);
        $maxExpenseIndex = array_search($maxExpenseValue, $expensesData);
        $expenseMonthName = $months[$maxExpenseIndex];

        $response = [
            'salesData' => $salesData,
            'expensesData' => $expensesData,
            'months' => $months,
            'annual_sales' => $annual_sales,
            'top_month' => $monthName,
            'top_month_value' => $maxValue,
            'top_expensiveMonth' => $expenseMonthName,
            'top_expensiveMonth_value' => $maxExpenseValue,
            'annual_expenses' => $annual_expenses,
        ];
        return $response;
    }
    public function get_expenseValueFromDatePeriod($start_date, $end_date)
    {
        $stmt = $this->connect()->prepare("SELECT SUM(expenses.total_amount) AS total_expense_of_the_month
                                            FROM expenses
                                            INNER JOIN supplier ON supplier.id = expenses.supplier
                                            LEFT JOIN uom ON uom.id = expenses.uom_id
                                            WHERE (expenses.date_of_transaction BETWEEN :st_date AND :end_date)");
        $stmt->execute([':st_date'=>$start_date, ':end_date'=>$end_date]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function get_totalExpenseOfTheMonth($month, $year)
    {
        $stmt = $this->connect()->prepare("SELECT SUM(expenses.total_amount) AS total_expense_of_the_month
                                        FROM expenses
                                        INNER JOIN supplier ON supplier.id = expenses.supplier
                                        LEFT JOIN uom ON uom.id = expenses.uom_id
                                        WHERE MONTH(expenses.date_of_transaction) = :currentMonth
                                        AND YEAR(expenses.date_of_transaction) = :currentYear");
        $stmt->execute([':currentMonth'=>$month, ':currentYear'=>$year]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    function isAllZeros($array) 
    {
        return count(array_filter($array)) === 0;
    }
    public function get_allRevenues($startDate, $endDate, $singleDate)
    {
        $sql = "SELECT 
                    ROUND(SUM(total_sales), 2) AS total_sales,
                    ROUND(JSON_UNQUOTE(JSON_EXTRACT(all_data, '$.gross_amount')), 2) AS gross_amount,
                    ROUND(JSON_UNQUOTE(JSON_EXTRACT(all_data, '$.vatable_sales')), 2) AS vatable_sales,
                    ROUND(JSON_UNQUOTE(JSON_EXTRACT(all_data, '$.less_discount')), 2) AS less_discount,
                    ROUND(JSON_UNQUOTE(JSON_EXTRACT(all_data, '$.less_return_amount')), 2) AS less_return_amount,
                    ROUND(JSON_UNQUOTE(JSON_EXTRACT(all_data, '$.less_refund_amount')), 2) AS less_refund_amount
                FROM 
                    z_read
                WHERE 
                    (:singleDateParam IS NOT NULL AND DATE(date_time) = :singleDateParam) OR
                    (:startDateParam IS NOT NULL AND :endDateParam IS NOT NULL AND DATE(date_time) BETWEEN :startDateParam AND :endDateParam) OR
                    (:singleDateParam IS NULL AND :startDateParam IS NULL AND :endDateParam IS NULL AND DATE(date_time) = CURDATE())
                ";
        
        $params = [];
        
        if (!empty($singleDate)) {
            $params[':singleDateParam'] = $singleDate;
        } else {
            $params[':singleDateParam'] = null;
        }
        
        if (!empty($startDate)) {
            $params[':startDateParam'] = $startDate;
        } else {
            $params[':startDateParam'] = null;
        }
        
        if (!empty($endDate)) {
            $params[':endDateParam'] = $endDate;
        } else {
            $params[':endDateParam'] = null;
        }
        
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}