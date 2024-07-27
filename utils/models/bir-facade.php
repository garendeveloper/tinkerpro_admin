<?php 

class BirFacade extends DBConnection {


    public function getAllZread($startDate, $endDate) {
        $pdo = $this->connect();

        if ($startDate == null && $endDate == null) {
            return;
        } 

        if(empty($startDate) && empty($endDate))
        {
            return;
        }
        
        $lastRowDate = "SELECT business_date.*, payments.business_date_id FROM `business_date` 
                    LEFT JOIN payments ON business_date.id = payments.business_date_id
                    ORDER BY `id` DESC LIMIT 1";
        $beginingOfBusiness = $pdo->prepare($lastRowDate);
        $beginingOfBusiness->execute();
        $lastDate = $beginingOfBusiness->fetch(PDO::FETCH_ASSOC);

        $todaySales = "SELECT payments.*,
        business_date.business_date,
        SUM(DISTINCT transactions.discount_amount) AS itemDiscount,
        SUM(DISTINCT return_exchange.return_amount) AS returnItems,
        SUM(DISTINCT refunded.refunded_amt) AS refundedItems 
        FROM payments
        INNER JOIN business_date ON business_date.id = payments.business_date_id
        INNER JOIN transactions ON payments.id = transactions.payment_id
        LEFT JOIN refunded ON payments.id = refunded.payment_id
        LEFT JOIN return_exchange ON payments.id = return_exchange.payment_id
        WHERE payments.business_date_id = ?
        GROUP BY payments.id;";

        $todaySales_data = $pdo->prepare($todaySales);
        $todaySales_data->execute([$lastDate['id']]);

        $t_sales = $todaySales_data->fetchAll(PDO::FETCH_ASSOC);
        $TodaySales = 0;
        $returnAmount = 0;
        $refundAmount = 0;
        foreach ($t_sales as $data) {
            $returnAmount += (float)$data['returnItems'];
            $refundAmount += (float)$data['refundedItems'];
            $TodaySales += (((float)$data['payment_amount'] + (float)$data['sc_pwd_discount'] + (float)$data['cart_discount'] + (float)$data['itemDiscount']) - ($returnAmount + $refundAmount));
        }

        $z_record = "SELECT * FROM `z_read`
                     WHERE DATE(`date_time`) BETWEEN ? AND ?";
        $z_all_reports = $pdo->prepare($z_record);
        $z_all_reports->execute([$startDate, $endDate]);
        $z_reports_data = $z_all_reports->fetchAll(PDO::FETCH_ASSOC);
    
        $beginning_si = null;
        $end_si = null;

        $grandAccumulatedBeg = 0;
        $grandAccumulatedEnd = 0;
        $grossSalesToday = 0;
        $vatableSales = 0;
        $vatAmount = 0;
        $vatExempt = 0;
        $sc_discount = 0;
        $pwd_discount = 0;
        $naac_discount = 0;
        $solo_parent_discount = 0;
        $other_discount = 0;
        $returns = 0;
        $voids = 0;
        $totalDeductions = 0;
        $z_counter = 0;

        $void_vat = 0;
        $returnd_vat = 0;
        $refund_vat = 0;
        $netSales = 0;

        $totalIncome = 0;
        $resetCount = 0;

        if (!empty($z_reports_data)) {
         
            foreach($z_reports_data as $index => $summary) {
                $ZReadData = json_decode($summary['all_data']);
                if ($index === 0) {
                    $beginning_si = $ZReadData->beg_si;
                    $grandAccumulatedBeg = $ZReadData->present_accumulated_sale;
                }
                
                if ($index === count($z_reports_data) - 1) {
                    $end_si = $ZReadData->end_si;
                    $resetCount = $ZReadData->resetCount ?? 0;
                }

                $grandAccumulatedEnd += $ZReadData->present_accumulated_sale;
                $totalIncome += $ZReadData->gross_amount; 
                $vatableSales += $ZReadData->vatable_sales;
                $vatAmount += $ZReadData->vat_amount;
                $vatExempt += $ZReadData->vat_exempt;
                $sc_discount += $ZReadData->senior_discount;
                $pwd_discount += $ZReadData->pwd_discount;
                $naac_discount += $ZReadData->naac_discount;
                $solo_parent_discount += $ZReadData->solo_parent_discount;
                $other_discount += $ZReadData->other_discount;
                $returns +=  $ZReadData->return;
                $voids += $ZReadData->void;
                $totalDeductions += ($ZReadData->senior_discount + $ZReadData->pwd_discount + $ZReadData->naac_discount + $solo_parent_discount + $other_discount + $ZReadData->void + $returns);
                $z_counter = $ZReadData->zReadCounter;
                $void_vat += (float)$ZReadData->total_void_vat;
                $returnd_vat += (float)$ZReadData->vat_return;
                $refund_vat += (float)$ZReadData->vat_refunded;
                $netSales += (float)$ZReadData->net_amount;
            }
    
        }
    
        $result = [
            'dateRange' => $startDate . ' - ' . $endDate,
            'beginning_si' => $beginning_si,
            'end_si' => $end_si,
            'grandEndAccumulated' => $grandAccumulatedEnd,
            'grandBegAccumulated' => $grandAccumulatedBeg,
            'issued_si' => 0,
            'grossSalesToday' => $TodaySales,
            'vatable_sales' => $vatableSales,
            'vatAmount' => $vatAmount,
            'vatExempt' => $vatExempt,
            'zero_rated' => 0,
            'sc_discount' => $sc_discount,
            'pwd_discount' => $pwd_discount,
            'naac_discount' => $naac_discount,
            'solo_parent_discount' => $solo_parent_discount,
            'other_discount' => $other_discount,
            'returned' => $returns,
            'voids' => $voids,
            'totalDeductions' => $totalDeductions,
            'void_vat' => $void_vat,
            'returnd_vat' => $returnd_vat,
            'othersVatAdjustment' => ($void_vat + $refund_vat),
            'totalVatAjustment' => ($void_vat + $refund_vat + $returnd_vat),
            'refund_vat' => $refund_vat,
            'netSales' => $netSales,
            'totalIncome' => $totalIncome,
            'resetCount' => $resetCount,
            'z_counter' => $z_counter,
        ];
        return $result;
    }
  
    public function E_reports($customerType, $startDate, $endDate) {
     
        $pdo = $this->connect();

        // Base query for e_reports
        $e_reports_query = 'SELECT
        first_name,
        last_name,
        scOrPwdTIN,
        pwdOrScId,
        child_name,
        child_age,
        child_birth,
        discount_id,
        user_id,
        discount_amount,
        prod_price,
        is_paid,
        is_transact,
        is_void,
        totalPayment,
        itemDiscount,
        totalAmount,
        cart_discount,
        customerDiscount,
        paymentIds,
        receiptIds,
        paymentAmount,
        totalCredit,
        payment_details,
        date_time_of_payment,
        VAT_EXEMPT,
        vatable_price,
            CASE
                WHEN ROUND((vatable_price / 1.12), 2) >= 2500 THEN
                    ROUND((vatable_price / 1.12) - 2500, 2)
                ELSE 
                    0
                END AS VAT_SALES,
            CASE 
                WHEN ROUND((vatable_price / 1.12), 2) >= 2500 THEN
                    ROUND(ROUND((vatable_price / 1.12) - 2500, 2) * 0.12, 2)
                ELSE 
                    0
                END AS VAT_AMOUNT,
            CASE 
                WHEN ROUND((vatable_price / 1.12), 2) >= 2500 THEN
                    ROUND((2500 / 1.12), 2)
                ELSE
                    ROUND((vatable_price / 1.12), 2)
                END AS VAT_EXEMPT,
                
            CASE 
                WHEN ROUND(((vatDiscounted) / 1.12), 2) >= 2500 THEN
                    (2500) * ROUND((customer_discount / 100), 2)
                ELSE 
                    ROUND((vatable_price / 1.12),2) * ROUND((customer_discount / 100), 2)
                END AS CUSTOMER_DIS,
                
        change_amount,
        barcode
        FROM (
            SELECT 
                    users.first_name,
                    users.last_name,
                    customer.scOrPwdTIN,
                    customer.pwdOrScId,
                    customer.child_name,
                    customer.child_birth,
                    customer.child_age,
                    users.discount_id,
                    transactions.user_id, 
                    transactions.discount_amount, 
                    transactions.prod_price, 
                    transactions.is_paid,
                    transactions.is_transact,
                    transactions.is_void,
                    ROUND(SUM(transactions.prod_price), 2) AS totalPayment,
                    ROUND(SUM(transactions.discount_amount), 2) AS itemDiscount,
                    ROUND(SUM(payments.payment_amount + payments.cart_discount + payments.sc_pwd_discount + transactions.discount_amount), 2) AS totalAmount,
                    payments.cart_discount AS cart_discount,
                    payments.sc_pwd_discount AS customerDiscount,
                    transactions.payment_id AS paymentIds,
                    transactions.receipt_id AS receiptIds,
                    (payments.payment_amount - payments.change_amount) AS paymentAmount,
                    payments.creditTotal AS totalCredit,
                    payments.payment_details,
                    payments.date_time_of_payment,
                    discounts.discount_amount AS customer_discount,
                    payments.vatable_sales AS VAT_EXEMPT,
            
                    CASE 
                        WHEN products.isVAT = 1 AND products.is_discounted = 1 THEN
                            ROUND((SUM(transactions.subtotal)),2)
                        ELSE 0
                        END AS vatDiscounted,
            
                    CASE 
                        WHEN products.isVAT = 0 AND products.is_discounted = 1 THEN
                            ROUND((SUM(transactions.subtotal)),2)
                        ELSE 0
                        END AS nonVatDiscounted,
                    CASE 
                        WHEN products.isVAT = 1 THEN
                            ROUND((SUM(transactions.subtotal)),2)
                        END AS vatable_price,
                    payments.change_amount, 
                    receipt.barcode
                FROM transactions
                INNER JOIN products ON products.id = transactions.prod_id
                INNER JOIN payments ON payments.id = transactions.payment_id
                INNER JOIN users ON users.id = transactions.user_id
                INNER JOIN discounts ON discounts.id = users.discount_id
                INNER JOIN customer ON users.id = customer.user_id
                INNER JOIN receipt ON receipt.id = transactions.receipt_id
                WHERE transactions.is_paid = 1 AND users.discount_id = ?';
        // Append WHERE clause for date range if specified
        $whereClause = " AND DATE(payments.date_time_of_payment) BETWEEN ? AND ?";
        $groupBy = " GROUP BY transactions.payment_id ORDER BY receipt.barcode DESC
		) AS subquery";
        
        if ($startDate == '' && $endDate == '') {
            $e_reports = $pdo->prepare($e_reports_query . $groupBy);
            $e_reports->execute([$customerType]);
        } else {
            $e_reports = $pdo->prepare($e_reports_query . $whereClause . $groupBy);
            $e_reports->execute([$customerType, $startDate, $endDate]);
        }
        
        $e_reports_data = $e_reports->fetchAll(PDO::FETCH_ASSOC);
        
        
        // Fetch refundedTransactions
        $refunded_query = "SELECT 
            id, 
            prod_id, 
            refunded_method_id, 
            payment_id, 
            refunded_qty, 
            reference_num, 
            SUM(refunded_amt) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) as lessDiscount,
            ROUND(((SUM(refunded_amt) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))) / 1.12) * 0.12 ,2) AS vat_amount,
            ROUND((SUM(refunded_amt) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))) / 1.12 ,2) VatExempt,
            ROUND(SUM(refunded_amt) - (SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * refunded_qty) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))), 2) AS totalRefAmount,
            SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * refunded_qty) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS overAllDiscounts,
            SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].credits'))) AS credits,
            SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * refunded_qty) AS cartDiscount,
            SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) AS customerDiscount,
            SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS itemDiscount,
            date 
            FROM refunded
            GROUP BY payment_id;";
        
        $refundedTransactions = $pdo->prepare($refunded_query);
        $refundedTransactions->execute();
        $refunded_data = $refundedTransactions->fetchAll(PDO::FETCH_ASSOC);
        
        // Create an associative array for refunded transactions by payment_id
        $refunded_map = [];
        foreach ($refunded_data as $refunded) {
            $refunded_map[$refunded['payment_id']] = $refunded;
        }


        $return_query = "SELECT 
            id, 
          	product_id,
            payment_id, 
            return_qty, 
            SUM(return_amount) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) as lessItemDiscount,
            ROUND(((SUM(return_amount) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))) / 1.12) * 0.12 ,2) AS vat_amount,
            ROUND((SUM(return_amount) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))) / 1.12 ,2) VatExempt,
            ROUND(SUM(return_amount) - (SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * return_qty) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))), 2) AS totalReturnAmount,
            SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * return_qty) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS overAllDiscounts,
            SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].credits'))) AS credits,
            SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * return_qty) AS cartDiscount,
            SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) AS customerDiscount,
            SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS itemDiscount,
            date 
            FROM return_exchange
            GROUP BY payment_id";

        $returnedTransactions = $pdo->prepare($return_query);
        $returnedTransactions->execute();
        $returned_data = $returnedTransactions->fetchAll(PDO::FETCH_ASSOC);

        $returned_map = [];
        foreach ($returned_data as $returned) {
            $returned_map[$returned['payment_id']] = $returned;
        }

        // Prepare the final result
        $result = [];
        foreach ($e_reports_data as $payments) {
            $payment_id = $payments['paymentIds'];
            $totalPaymentAmount = (float)$payments['paymentAmount'];
            
            $totalVatExempt = (float)$payments['VAT_EXEMPT'];
            $totalVat = (float)$payments['VAT_AMOUNT'];
            $totalVatSales = (float)$payments['VAT_SALES'];

            $netSales = (float)$payments['paymentAmount'] - $totalVat;
            if (isset($refunded_map[$payment_id])) {
                $totalPaymentAmount -= (floatval($refunded_map[$payment_id]['totalRefAmount']));
                // $totalVatSales -= floatval($refunded_map[$payment_id]['VatExempt']);
                // $totalVat -= floatval($refunded_map[$payment_id]['vat_amount']);
                $netSales -= floatval($refunded_map[$payment_id]['totalRefAmount']) + floatval($refunded_map[$payment_id]['vat_amount']);
            }

            if (isset($returned_map[$payment_id])) {
                $totalPaymentAmount -= (floatval($returned_map[$payment_id]['totalReturnAmount']));
                // $totalVatSales -= floatval($returned_map[$payment_id]['VatExempt']);
                // $totalVat -= floatval($returned_map[$payment_id]['vat_amount']);
                $netSales -= floatval($returned_map[$payment_id]['totalReturnAmount']) + floatval($returned_map[$payment_id]['vat_amount']);
            }
            

            if (max(0, (float)number_format($totalPaymentAmount,2, '.', '')) != 0) {
                $result[] = [
                    'first_name' => $payments['first_name'],
                    'last_name' => $payments['last_name'],
                    'child_name' => $payments['child_name'],
                    'child_birth' => $payments['child_birth'],
                    'child_age' => $payments['child_age'],
                    'customerTIN' => $payments['scOrPwdTIN'],
                    'customerID' => $payments['pwdOrScId'],
                    'discount_id' => $payments['discount_id'],
                    'user_id' => $payments['user_id'],
                    'totalAmount' => (float)number_format($payments['totalAmount'],2, '.', ''),
                    'discount_amount' => $payments['discount_amount'],
                    'prod_price' => (float)number_format($payments['prod_price'],2, '.', ''),
                    'is_paid' => $payments['is_paid'],
                    'is_transact' => $payments['is_transact'],
                    'is_void' => $payments['is_void'],
                    'totalPayment' => (float)number_format($payments['totalPayment'],2, '.', ''),
                    'itemDiscount' => (float)number_format($payments['itemDiscount'],2, '.', ''),
                    'paymentIds' => $payments['paymentIds'],
                    'receiptIds' => $payments['receiptIds'],
                    'paymentAmount' => (float)number_format($payments['paymentAmount'],2, '.', ''),
                    'cart_discount' => (float)number_format($payments['cart_discount'],2, '.', ''),
                    'totalCredit' => (float)number_format($payments['totalCredit'],2, '.', ''),
                    'payment_details' => $payments['payment_details'],
                    'date_time_of_payment' => $payments['date_time_of_payment'],
                    'vat_sales' => (float)number_format($totalVatSales, 2, '.', ''),
                    'vatExempt' => (float)number_format($totalVatExempt, 2, '.', ''),
                    'vat_amount' => (float)number_format($totalVat, 2, '.', ''),
                    'change_amount' => $payments['change_amount'],  
                    'barcode' => $payments['barcode'],
                    'customer_discount' => $payments['CUSTOMER_DIS'], // Temporary Change
                    'totalRefAmount' => $refunded_map[$payment_id]['totalRefAmount'] ?? 0,
                    'overAllDiscounts' => $refunded_map[$payment_id]['overAllDiscounts'] ?? 0,
                    'credits' => $refunded_map[$payment_id]['credits'] ?? 0,
                    'cartDiscount' => $refunded_map[$payment_id]['cartDiscount'] ?? 0,
                    'customerDiscount' => $refunded_map[$payment_id]['customerDiscount'] ?? 0,
                    'itemDiscount_refunded' => $refunded_map[$payment_id]['itemDiscount'] ?? 0,
                    'date_refunded' => $refunded_map[$payment_id]['date'] ?? 0,
                    'vatRef' => $refunded_map[$payment_id]['vat_amount'] ?? 0,
                    'finalPaymentAmount' => max(0, (float)number_format($totalPaymentAmount,2, '.', '')),
                    'netSales' => max(0, (float)number_format($netSales,2, '.', '')),
                ];
            }

            
        }
        return $result;
    }

}
?>
