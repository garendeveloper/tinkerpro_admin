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
    public function get_salesDataByYear($year)
    {
        $salesData = [];
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        
        for ($i = 1; $i <= count($months) - 1; $i++) 
        {
            $month = $i;
            // $payment_sql = $this->connect()->prepare("SELECT payments.id as payment_id, transactions.discount_amount, transactions.is_paid, transactions.is_void, (payments.payment_amount - transactions.discount_amount) as gross_sale
            // FROM payments
            // INNER JOIN transactions on payments.id = transactions.payment_id
            // AND MONTH(payments.date_time_of_payment) = :currentMonth
            // AND YEAR(payments.date_time_of_payment) = :currentYear
            // GROUP BY payments.id;");
            $payment_sql = $this->connect()->prepare("WITH RefundSums AS (
                                                    SELECT 
                                                        r.payment_id,
                                                        COALESCE(
                                                                CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].credits')) AS DECIMAL(10, 2)),
                                                                0
                                                            ) as credits,
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
                                                        ) AS total_item_discounts
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
                                                                CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].discount')) AS DECIMAL(10, 2)),
                                                                0
                                                            ) as discountsReturnTender,
                                                    SUM(COALESCE(rc.return_amount, 0)) AS return_amt,
                                                        SUM(
                                                            COALESCE(
                                                                CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].itemDiscountsData')) AS DECIMAL(10, 2)),
                                                                0
                                                            )
                                                        ) AS total_return_item_discounts
                                                    FROM 
                                                        return_exchange  rc
                                                    GROUP BY 
                                                        rc.payment_id
                                                )
                                                SELECT
                                                DISTINCT
                                                    u.first_name AS first_name,
                                                    u.last_name AS last_name, 
                                                    ROUND(COALESCE(SUM(DISTINCT p.payment_amount), 0),2) AS paid_amount,
                                                    ROUND(COALESCE(SUM(DISTINCT p.change_amount), 0),2) AS totalChange,
                                                    p.date_time_of_payment AS date,
                                                    p.cart_discount AS cart_discount,
                                                    d.discount_amount AS discountsRate,
                                                    COALESCE(SUM(DISTINCT rs.refunded_amt), 0) AS refunded_amt,
                                                    IFNULL(rs.total_item_discounts, 0) AS total_item_discounts,
                                                    COALESCE(SUM(DISTINCT rs.credits), 0) AS totalCredits,
                                                    COALESCE(SUM(DISTINCT rs.discountsTender), 0) AS totalDiscountsTender,
                                                    
                                                    COALESCE(SUM(DISTINCT res.return_amt), 0) AS return_amt,
                                                    IFNULL(res. total_return_item_discounts, 0) AS total_return_item_discounts,
                                                    COALESCE(SUM(DISTINCT res.rc_credits), 0) AS totalReturnCredits,
                                                    COALESCE(SUM(DISTINCT res.discountsReturnTender), 0) AS totalDiscountsReturnTender
                                                    
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
                                                    AND MONTH(payments.date_time_of_payment) = :currentMonth
                                                    AND YEAR(payments.date_time_of_payment) = :currentYear
                                                GROUP BY 
                                                    p.id;");

            $payment_sql->bindParam(":currentMonth", $month);
            $payment_sql->bindParam(":currentYear", $year);
            $payment_sql->execute();
            $payments = $payment_sql->fetchAll(PDO::FETCH_ASSOC);
    
            $monthly_gross_sale = 0;
    
            foreach ($payments as $payment) 
            {
                $payment_id = $payment['payment_id'];
                $gross_sale = $gross_sale - $total_item_discounts - $total_refund;
                $monthly_gross_sale += $payment['paid_amount'] ;
                // $refundedSql = $this->connect()->prepare("SELECT * FROM REFUNDED WHERE payment_id = :payment_id");
                // $refundedSql->bindParam(":payment_id", $payment_id, PDO::PARAM_STR);
                // $refundedSql->execute();
                // $refunded = $refundedSql->fetchAll(PDO::FETCH_ASSOC);
                // $total_refund = 0;
                // - $payment['discountsRate'] - $payment['refunded_amt'] - $payment['total_item_discounts'] - $payment['totalCredits'];
                // foreach ($refunded as $refund) 
                // {
                //     $other_details_json = file_get_contents($refund['other_details']);
                //     $discount_category = json_decode($other_details_json, false);
                //     $credits = $discount_category->credits ?? 0;
                //     $discount = $discount_category->discount ?? 0;
                //     $itemDiscount = $discount_category->itemDiscountsData ?? 0;
                //     $total_refund += $refund['refunded_amt'] - $itemDiscount - $credits - $discount;
                // }
    
                // $returnAndExchange_sql = $this->connect()->prepare("SELECT * FROM `return_exchange` WHERE payment_id = :payment_id");
                // $returnAndExchange_sql->bindParam(":payment_id", $payment['id']);
                // $returnAndExchange_sql->execute();
                // $return_exchange = $returnAndExchange_sql->fetchAll(PDO::FETCH_ASSOC);
    
                // $total_return_exhange = 0;
                // foreach ($return_exchange as $ret_ex) 
                // {
                //     $other_details_json = file_get_contents($ret_ex['other_details']);
                //     $discount_category = json_decode($other_details_json, false);
                //     $credits = $discount_category->credits ?? 0;
                //     $discount = $discount_category->discount ?? 0;
                //     $itemDiscount = $discount_category->itemDiscountsData ?? 0;
                //     $total_return_exhange += $ret_ex['refunded_amt'] - $itemDiscount - $credits - $discount;
                // }
    
                // $gross_sale = $gross_sale - $total_item_discounts - $total_refund - $total_return_exhange;
                // $gross_sale = $gross_sale - $total_item_discounts - $total_refund;
              
            }
    
            $salesData[] = $monthly_gross_sale;
        }
        
      
        $response = [
            'salesData' => $salesData,
            'months' => $months
        ];
        return $response;
    }
}