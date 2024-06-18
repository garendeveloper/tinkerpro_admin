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
    function convertDateFormat($date) {
        $dateTime = DateTime::createFromFormat('d/m/Y', $date);
        if (!$dateTime) {
            throw new Exception("Failed to parse date: $date");
        }
        return $dateTime->format('Y-m-d');
    }
    public function get_allTopProducts($item, $start_date, $end_date)
    {
        // $sql = $this->connect()->prepare("SELECT products.prod_desc as product, 
        //                                     (payments.payment_amount - payments.change_amount) as total_paid_amount
        //                                 FROM payments, products, transactions
        //                                 WHERE payments.id = transactions.payment_id
        //                                 AND products.id = transactions.prod_id
        //                                 AND transactions.is_paid = 1
        //                                 GROUP BY products.id
        //                                 ORDER by total_paid_amount DESC
        //                                 LIMIT :item");
        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = $this->convertDateFormat($end_date);

        $sql = $this->connect()->prepare("WITH RefundSums AS (
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
                                            AND (DATE(p.date_time_of_payment) BETWEEN :st_date AND :end_date)
                                        GROUP BY 
                                            p.id");

        $sql->execute([':st_date' => $start_date, ':end_date' => $end_date]);
        $top_products = $sql->fetchAll(PDO::FETCH_ASSOC);

        $tp_array = [];
        $total_sales_by_period = 0;
        foreach($top_products as $row)
        {
            $paid_amount = $row['paid_amount'];
            $totalChange = $row['totalChange'];
        
            $sales = $paid_amount - $totalChange;
        
            $refunded_amt = $row['refunded_amt'];
            $refudned_item_discount = $row['total_item_discounts'];
            $refund_credits = $row['totalCredits'];
            $totalRefundDiscountsTendered = $row['totalDiscountsTender'];
        
            $totalRefundedAmt =  $refunded_amt-$refudned_item_discount- $totalRefundDiscountsTendered;
        
            $return_amount = $row['return_amt'];
            $return_item_discounts = $row['total_return_item_discounts'];
            $return_credits = $row['totalReturnCredits'];
            $totalReturnDiscountsTender = $row['totalDiscountsReturnTender'];
        
            $totalReturnAmt = $return_amount-$return_item_discounts-$totalReturnDiscountsTender;
        
            $totalGrossSales = $sales-$totalRefundedAmt-$totalReturnAmt;
            $total_sales_by_period += $totalGrossSales;
            $tp_array[] = [
                'product' => $row['product'],
                'total_paid_amount' => $totalGrossSales,
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
        ];
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
                $monthly_gross_sale += $totalGrossSales;
            
            }
    
            $salesData[] = $monthly_gross_sale;
            $annual_sales += $monthly_gross_sale;
        }

        $maxValue = max($salesData);
        $maxIndex = array_search($maxValue, $salesData);
        $monthName = $months[$maxIndex];

        $response = [
            'salesData' => $salesData,
            'months' => $months,
            'annual_sales' => $annual_sales,
            'top_month' => $monthName,
            'top_month_value' => $maxValue,
        ];
        return $response;
    }
    public function get_salesDataByHour($start_date, $end_date)
    {
        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = $this->convertDateFormat($end_date);

        $salesData = [];
        $timeRanges = [
            '6AM-8AM' => ['06:00 AM', '08:00 AM'],
            '8AM-10AM' => ['08:00 AM', '10:00 AM'],
            '11AM-1PM' => ['11:00 AM', '01:00 PM'],
            '1PM-3PM' => ['01:00 PM', '03:00 PM'],
            '3PM-5PM' => ['03:00 PM', '05:00 PM'],
            '5PM-7PM' => ['05:00 PM', '07:00 PM'],
            '8PM-10PM' => ['08:00 PM', '10:00 PM'],
            '10PM-12AM' => ['10:00 PM', '12:00 AM'],
            '12AM-2AM' => ['12:00 AM', '02:00 AM'],
            '2AM-4AM' => ['02:00 AM', '04:00 AM'],
            '4AM-6AM' => ['04:00 AM', '06:00 AM'],
        ];
        
        $labels = [];
        foreach ($timeRanges as $label => $timeRange) {
            $start_time = $timeRange[0];
            $end_time = $timeRange[1];
        
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
                    AND (DATE(p.date_time_of_payment) BETWEEN :st_date AND :end_date)
                    AND (TIME(p.date_time_of_payment) BETWEEN :start_time AND :end_time)
                GROUP BY 
                    p.id
            ");
        
            $payment_sql->execute([
                ':st_date' => $start_date,
                ':end_date' => $end_date,
                ':start_time' => $start_time,
                ':end_time' => $end_time
            ]);
            
            $payments = $payment_sql->fetchAll(PDO::FETCH_ASSOC);
        
            $hourly_sales = 0;
        
            foreach ($payments as $row) {
                $paid_amount = $row['paid_amount'];
                $totalChange = $row['totalChange'];
        
                $sales = $paid_amount - $totalChange;
        
                $refunded_amt = $row['refunded_amt'];
                $refunded_item_discount = $row['total_item_discounts'];
                $refund_credits = $row['totalCredits'];
                $totalRefundDiscountsTendered = $row['totalDiscountsTender'];
        
                $totalRefundedAmt = $refunded_amt - $refunded_item_discount - $totalRefundDiscountsTendered;
        
                $return_amount = $row['return_amt'];
                $return_item_discounts = $row['total_return_item_discounts'];
                $return_credits = $row['totalReturnCredits'];
                $totalReturnDiscountsTender = $row['totalDiscountsReturnTender'];
        
                $totalReturnAmt = $return_amount - $return_item_discounts - $return_credits - $totalReturnDiscountsTender;
        
                $totalGrossSales = $sales - $totalRefundedAmt - $totalReturnAmt;
                $hourly_sales += $totalGrossSales;
            }
        
            $salesData[] = $hourly_sales;
            $labels[] = $label;
        }
        $salesData = !$this->isAllZeros($salesData) ? $salesData : 0;
        $response = [
            'salesData' => $salesData,
            'labels' => $labels,
        ];
        return $response;
    }
    function isAllZeros($array) 
    {
        return count(array_filter($array)) === 0;
    }
}