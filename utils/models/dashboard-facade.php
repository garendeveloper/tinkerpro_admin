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
    function convertDateFormat($date) {
        $dateTime = DateTime::createFromFormat('d/m/Y', $date);
        if (!$dateTime) {
            throw new Exception("Failed to parse date: $date");
        }
        return $dateTime->format('Y-m-d');
    }
    public function get_dataByMonthAndYear($month, $year)
    {
        $pdo =  $this->connect();
        $sales = 'SELECT
                SUM(DISTINCT payments.payment_amount - payments.change_amount) AS totalPaid,
                payments.id AS paymentId,
                payments.payment_amount AS totalAmount,
                payments.date_time_of_payment,
                receipt.id AS receiptId,
                SUM(transactions.subtotal) AS totalAmount1,
                transactions.transaction_num,
                SUM(transactions.prod_qty) AS totalProductQty
                FROM payments
                INNER JOIN transactions ON payments.id = transactions.payment_id
                INNER JOIN receipt ON receipt.id = transactions.receipt_id
                WHERE MONTH(payments.date_time_of_payment) = ?
                AND YEAR(payments.date_time_of_payment) = ?
                GROUP BY payments.id;';

        $sales_result = $pdo->prepare($sales); 
        $sales_result->execute([$month, $year]);
        $salesReport = $sales_result->fetchAll(PDO::FETCH_ASSOC);

        $refunded_query = "SELECT 
                                id,
                                refunded_method_id,
                                payment_id,
                                refunded_qty, 
                                reference_num, 
                                OriginalAmountRef,
                                vat_amount,
                                VatExempt,
                                ROUND((totalRefAmount - cartDiscount), 2) AS totalRefAmount,
                                ROUND((overAllDiscounts + cartDiscount), 2) AS overAllDiscounts,
                                credits,
                                cartDiscount,
                                customerDiscount,
                                itemDiscount,
                                date
                            FROM (
                                SELECT 
                                    id, 
                                    refunded_method_id, 
                                    payment_id, 
                                    refunded_qty, 
                                    reference_num, 
                                    SUM(refunded_amt) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS OriginalAmountRef,
                                    ROUND(((SUM(refunded_amt) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))) / 1.12) * 0.12 ,2) AS vat_amount,
                                    ROUND((SUM(refunded_amt) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))) / 1.12 ,2) AS VatExempt,
                                    ROUND(SUM(refunded_amt) - (JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount')) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) ), 2) AS totalRefAmount,
                                    (JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS overAllDiscounts,
                                    SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].credits'))) AS credits,
                                    SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * (refunded_amt)) AS cartDiscount,
                                    (JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) AS customerDiscount,
                                    SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS itemDiscount,
                                    date 
                                    FROM refunded
                                    WHERE MONTH(date) = ?
                                    AND YEAR(date) = ?
                                    GROUP BY payment_id
                            ) AS subquery";

        $refund_report = $pdo->prepare($refunded_query);
        $refund_report->execute([$month, $year]);
        $refundData = $refund_report->fetchAll(PDO::FETCH_ASSOC);

        $return_query = "SELECT 
            id,
            product_id,
            payment_id,
            return_qty,
            lessItemDiscount,
            vat_amount,
            VatExempt,
            totalReturnAmount,
            overAllDiscounts,
            credits,
            cartDiscount,
            customerDiscount,
            itemDiscount,
            date   
        FROM (
            SELECT 
                id, 
                product_id,
                payment_id, 
                return_qty, 
                SUM(return_amount) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) as lessItemDiscount,
                ROUND(((SUM(return_amount) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))) / 1.12) * 0.12 ,2) AS vat_amount,
                ROUND((SUM(return_amount) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))) / 1.12 ,2) VatExempt,
                ROUND(SUM(return_amount) - (SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * return_amount) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))), 2) AS totalReturnAmount,
                SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * return_amount) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS overAllDiscounts,
                SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].credits'))) AS credits,
                SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * return_amount) AS cartDiscount,
                (JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) AS customerDiscount,
                SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS itemDiscount,
                date 
                FROM return_exchange
                WHERE MONTH(date) = ?
                AND YEAR(date) = ?
                GROUP BY payment_id
        ) AS subqeury
        ";


        $return_report = $pdo->prepare($return_query);
        $return_report->execute([$month, $year]);
        $returndData = $return_report->fetchAll(PDO::FETCH_ASSOC);
        
        $monthlySales = array_sum(array_column($salesReport, 'totalAmount'));
        $monthlyRefund = array_sum(array_column($refundData, 'totalRefAmount'));
        $monthlyReturn = array_sum(array_column($returndData, 'totalReturnAmount'));
        
        $monthyear_sales = $monthlySales - $monthlyRefund - $monthlyReturn;
        return $monthyear_sales;
    }
    public function getHourlyProducts($startDate, $endDate, $startTime, $endTime)
    {
        $productSales = 'SELECT
                        payments.date_time_of_payment,
                        SUM(transactions.prod_qty) AS productSoldQty,
                        transactions.prod_price,
                        SUM(transactions.prod_qty) * products.prod_price AS totalProductAmount,
                        products.id AS productsId,
                        products.prod_desc AS productName,
                        products.isVAT,
                        products.is_discounted,
                        receipt.barcode,
                        CASE 
                        	WHEN payments.id = transactions.payment_id THEN
                            	payments.payment_amount
                            ELSE 0
                        END AS totalSales,
                        receipt.id AS receiptId,
                        discounts.name AS customerType,
                        discounts.discount_amount AS customerDiscountRate
                    FROM transactions
                        INNER JOIN products ON products.id = transactions.prod_id
                        INNER JOIN receipt ON receipt.id = transactions.receipt_id
                        INNER JOIN users ON users.id = transactions.user_id
                        INNER JOIN discounts ON discounts.id = users.discount_id
                        INNER JOIN payments ON payments.id = transactions.payment_id
                    WHERE transactions.is_paid = 1 AND transactions.is_void NOT IN (1,2)
                    AND DATE(payments.date_time_of_payment) BETWEEN ? AND ?
                    AND TIME(payments.date_time_of_payment) BETWEEN ? AND ?
                    GROUP BY products.id';

        $product_sold_result = $this->connect()->prepare($productSales);
        $product_sold_result->execute([$startDate, $endDate, $startTime, $endTime]);
        $hourlyProducts = $product_sold_result->fetchAll(PDO::FETCH_ASSOC);
        return $hourlyProducts;
    }
    public function getTopProducts($startDate, $endDate) 
    {
        $pdo = $this->connect();
        $totalSales = 0;

        $productSales = 'SELECT
                        payments.date_time_of_payment,
                        SUM(transactions.prod_qty) AS productSoldQty,
                        transactions.prod_price,
                        SUM(transactions.prod_qty) * products.prod_price AS totalProductAmount,
                        products.id AS productsId,
                        products.prod_desc AS productName,
                        products.isVAT,
                        products.is_discounted,
                        receipt.barcode,
                        CASE 
                        	WHEN payments.id = transactions.payment_id THEN
                            	payments.payment_amount
                            ELSE 0
                        END AS totalSales,
                        receipt.id AS receiptId,
                        discounts.name AS customerType,
                        discounts.discount_amount AS customerDiscountRate
                    FROM transactions
                        INNER JOIN products ON products.id = transactions.prod_id
                        INNER JOIN receipt ON receipt.id = transactions.receipt_id
                        INNER JOIN users ON users.id = transactions.user_id
                        INNER JOIN discounts ON discounts.id = users.discount_id
                        INNER JOIN payments ON payments.id = transactions.payment_id
                    WHERE transactions.is_paid = 1 AND transactions.is_void NOT IN (1,2)
                    AND DATE(payments.date_time_of_payment) BETWEEN ? AND ?
                    GROUP BY products.id';

        $product_sold_result = $pdo->prepare($productSales);
        $product_sold_result->execute([$startDate, $endDate]);
        $soldProducts = $product_sold_result->fetchAll(PDO::FETCH_ASSOC);
        
        return $soldProducts;
    }

    public function get_allTopProducts($item, $start_date, $end_date)
    {
        $start_date = $this->convertDateFormat($start_date);
        $end_date = $this->convertDateFormat($end_date);
        
        $top_products = $this->getTopProducts($start_date, $end_date);

        $tp_array = [];
        $total_sales_by_period = 0;
        foreach($top_products as $row)
        {
            $grossAmount = (float)$row['totalSales'];
            $total_sales_by_period += $grossAmount;

            $tp_array[] = [
                'product' => $row['productName'],
                'total_paid_amount' => $grossAmount,
                'total_sales_amount' => $grossAmount, 
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
            'total_expense_by_period' => $this->get_expenseValueFromDatePeriod($start_date, $end_date)['total_expense_of_the_month'],
            'total_landing_cost' => $this->get_expenseValueFromDatePeriod($start_date, $end_date)['total_landing_cost']
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
        $totalSales = 0;
        foreach($labels as $label => $timeRange)
        {
            list($start_time, $end_time) = explode(' AND ', $timeRange);
        
            $top_products = $this->getHourlyProducts($start_date, $end_date, $start_time, $end_time);
            $sales = 0;
            foreach($top_products as $row)
            {
                $grossAmount = (float)$row['totalSales'];
                $sales += $grossAmount;
            }
            
            $chart_labels[] = $label;
            $salesData[] = $sales;
            $totalSales += $sales;
        }
        
        return [
            'labels' => $chart_labels,
            'salesData' => $salesData,
            'totalSales'=> $totalSales,
        ];
    }
    public function formatNumber($number) 
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
            $grossAmount = $this->get_dataByMonthAndYear($month, $year);
            $month_expense = $this->get_totalExpenseOfTheMonth($month, $year)['total_expense_of_the_month'];
            $landingCost_expense = $this->get_totalExpenseOfTheMonth($month, $year)['total_landing_cost'];
            
            $totalLandingCost = $month_expense - $landingCost_expense;
            $expensesData[] = $month_expense !== null ? $month_expense + $totalLandingCost : 0;
            $annual_expenses += $month_expense + $totalLandingCost;
            
            $salesData[] = $grossAmount;
            $annual_sales += $grossAmount;
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
            'top_month_value' => number_format($maxValue, 2),
            'top_expensiveMonth' => $expenseMonthName,
            'top_expensiveMonth_value' => number_format($maxExpenseValue, 2),
            'annual_expenses' => $annual_expenses, 
        ];
        return $response;
    }
    public function get_expenseValueFromDatePeriod($start_date, $end_date)
    {
        $stmt = $this->connect()->prepare("SELECT 
                                                SUM(expenses.total_amount) AS total_expense_of_the_month,
                                                SUM(
                                                    CASE 
                                                        WHEN JSON_VALID(expenses.landingCost) = 1 AND JSON_EXTRACT(expenses.landingCost, '$.totalLandingCost') IS NOT NULL 
                                                        THEN CAST(JSON_UNQUOTE(JSON_EXTRACT(expenses.landingCost, '$.totalLandingCost')) AS DECIMAL(10,2))
                                                        ELSE 0
                                                    END
                                                ) AS total_landing_cost
                                            FROM expenses
                                            LEFT JOIN supplier ON supplier.id = expenses.supplier
                                            LEFT JOIN uom ON uom.id = expenses.uom_id
                                            WHERE DATE(expenses.date_of_transaction) BETWEEN ? AND ?");
        $stmt->execute([$start_date, $end_date]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function get_totalExpenseOfTheMonth($month, $year)
    {
        $stmt = $this->connect()->prepare("SELECT SUM(expenses.total_amount) AS total_expense_of_the_month,
                                                SUM(
                                                    CASE 
                                                        WHEN JSON_VALID(expenses.landingCost) = 1 AND JSON_EXTRACT(expenses.landingCost, '$.totalLandingCost') IS NOT NULL 
                                                        THEN CAST(JSON_UNQUOTE(JSON_EXTRACT(expenses.landingCost, '$.totalLandingCost')) AS DECIMAL(10,2))
                                                        ELSE 0
                                                    END
                                                ) AS total_landing_cost
                                            FROM expenses
                                            LEFT JOIN supplier ON supplier.id = expenses.supplier
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
        if(!empty($singleDate) && (empty($startDate) && empty($endDate)))
        {
            $startDate = $singleDate;
            $endDate = $singleDate;
        } 
        return ['total_sales'=>$this->get_salesByPeriod($startDate, $endDate)];
    }
    public function get_salesByPeriod($start_date, $end_date)
    {
        $pdo =  $this->connect();
        $sales = 'SELECT
                SUM(DISTINCT payments.payment_amount - payments.change_amount) AS totalPaid,
                payments.id AS paymentId,
                payments.date_time_of_payment,
                receipt.id AS receiptId,
                SUM(transactions.subtotal) AS totalAmount,
                transactions.transaction_num,
                SUM(transactions.prod_qty) AS totalProductQty
                FROM payments
                INNER JOIN transactions ON payments.id = transactions.payment_id
                INNER JOIN receipt ON receipt.id = transactions.receipt_id
                WHERE DATE(payments.date_time_of_payment) BETWEEN ? AND ?
                GROUP BY payments.id;';

        $sales_result = $pdo->prepare($sales); 
        $sales_result->execute([$start_date, $end_date]);
        $salesReport = $sales_result->fetchAll(PDO::FETCH_ASSOC);

        $refunded_query = "SELECT 
                                id,
                                refunded_method_id,
                                payment_id,
                                refunded_qty, 
                                reference_num, 
                                OriginalAmountRef,
                                vat_amount,
                                VatExempt,
                                ROUND((totalRefAmount - cartDiscount), 2) AS totalRefAmount,
                                ROUND((overAllDiscounts + cartDiscount), 2) AS overAllDiscounts,
                                credits,
                                cartDiscount,
                                customerDiscount,
                                itemDiscount,
                                date
                            FROM (
                                SELECT 
                                    id, 
                                    refunded_method_id, 
                                    payment_id, 
                                    refunded_qty, 
                                    reference_num, 
                                    SUM(refunded_amt) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS OriginalAmountRef,
                                    ROUND(((SUM(refunded_amt) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))) / 1.12) * 0.12 ,2) AS vat_amount,
                                    ROUND((SUM(refunded_amt) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))) / 1.12 ,2) AS VatExempt,
                                    ROUND(SUM(refunded_amt) - (JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount')) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) ), 2) AS totalRefAmount,
                                    (JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS overAllDiscounts,
                                    SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].credits'))) AS credits,
                                    SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * (refunded_amt)) AS cartDiscount,
                                    (JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) AS customerDiscount,
                                    SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS itemDiscount,
                                    date 
                                    FROM refunded
                                    WHERE date BETWEEN ? AND ? 
                                    GROUP BY payment_id
                            ) AS subquery";

        $refund_report = $pdo->prepare($refunded_query);
        $refund_report->execute([$start_date, $end_date]);
        $refundData = $refund_report->fetchAll(PDO::FETCH_ASSOC);

        $return_query = "SELECT 
            id,
            product_id,
            payment_id,
            return_qty,
            lessItemDiscount,
            vat_amount,
            VatExempt,
            totalReturnAmount,
            overAllDiscounts,
            credits,
            cartDiscount,
            customerDiscount,
            itemDiscount,
            date   
        FROM (
            SELECT 
                id, 
                product_id,
                payment_id, 
                return_qty, 
                SUM(return_amount) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) as lessItemDiscount,
                ROUND(((SUM(return_amount) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))) / 1.12) * 0.12 ,2) AS vat_amount,
                ROUND((SUM(return_amount) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))) / 1.12 ,2) VatExempt,
                ROUND(SUM(return_amount) - (SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * return_amount) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))), 2) AS totalReturnAmount,
                SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * return_amount) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS overAllDiscounts,
                SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].credits'))) AS credits,
                SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * return_amount) AS cartDiscount,
                (JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) AS customerDiscount,
                SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS itemDiscount,
                date 
                FROM return_exchange
                WHERE date BETWEEN ? AND ?
                GROUP BY payment_id
        ) AS subqeury
        ";


        $return_report = $pdo->prepare($return_query);
        $return_report->execute([$start_date, $end_date]);
        $returndData = $return_report->fetchAll(PDO::FETCH_ASSOC);
        
        $monthlySales = array_sum(array_column($salesReport, 'totalAmount'));
        $monthlyRefund = array_sum(array_column($refundData, 'totalRefAmount'));
        $monthlyReturn = array_sum(array_column($returndData, 'totalReturnAmount'));
        
        $salesByPeriod = $monthlySales - $monthlyRefund - $monthlyReturn;
        return $salesByPeriod;
    }
}