<?php 

class BirFacade extends DBConnection {


    public function getSalesDaily() {
        $pdo = $this->connect();

        $daily = "SELECT 
            subquery.business_date_id,
            all_data,
            z_read_date,
            first_receipt_num,
            last_receipt_num,
            paidAmount,
            subtotal,
            SC_DIS,
            PWD_DIS,
            SP_DIS,
            NAAC_DIS,
            CUSTOMER_DIS,
            VOID,
            VOID_DISCOUNT,
            VAT_ADJUST,
            VAT_SALES_ADJUST,
            VOID_NAAC_DISCOUNT,
            VOID_PWD_DISCOUNT,
            VOID_SP_DISCOUNT,
            VOID_SC_DISCOUNT,
            VAT_SALES,
            VAT_AMOUNT,
            VAT_EXEMPT
        FROM (
            SELECT
                DATE(z_read.date_time) AS z_read_date,
                z_read.all_data,
                MIN(receipt.barcode) AS first_receipt_num,
                MAX(receipt.barcode) AS last_receipt_num,
                business_date.id AS business_date_id,
                discounts.discount_amount AS customer_discount,
                discounts.name AS customer_type,
                transactions.receipt_id,
                transactions.payment_id,
                transactions.user_id,
                transactions.cashier_id,
                SUM(DISTINCT payments.sc_pwd_discount) AS CUSTOMER_DIS,
                SUM(DISTINCT payments.payment_amount - payments.change_amount) AS paidAmount,
                SUM(
                    CASE
                    	WHEN discounts.name = 'SP' THEN
                    		(transactions.subtotal) / 1.12 
                		WHEN discounts.name <> 'SP' THEN
                    		(transactions.subtotal)
                        ELSE 0
                    	END
                ) AS subtotal,
            
                 SUM(ROUND(
                    CASE 
                        WHEN discounts.name = 'SP' AND products.isVAT = 1 THEN 
                         0
                        WHEN discounts.name <> 'SP' AND products.isVAT = 1 THEN
                            ROUND((transactions.subtotal / 1.12),2)
                        ELSE 0
                    END, 2
                )) AS VAT_SALES,

               SUM(ROUND(
                    CASE 
                     WHEN discounts.name = 'SP' AND products.isVAT = 1 THEN 
                         0
                    WHEN discounts.name <> 'SP' AND products.isVAT = 1 THEN
                    	ROUND((transactions.subtotal / 1.12) * 0.12,2)
                    ELSE 0
                    END, 2
                )) AS VAT_AMOUNT,

                SUM(DISTINCT ROUND(
                    CASE 
                        WHEN transactions.is_void = 2 THEN
                            payments.sc_pwd_discount
                        ELSE 0
                    END, 2
                )) AS VOID_DISCOUNT,
            
            
            	SUM(DISTINCT ROUND(
                    CASE 
                        WHEN transactions.is_void = 2 AND discounts.name = 'SP' THEN
                            payments.sc_pwd_discount
                        ELSE 0
                    END, 2
                )) AS VOID_SP_DISCOUNT,
            
            	SUM(DISTINCT ROUND(
                    CASE 
                        WHEN transactions.is_void = 2 AND discounts.name = 'SC' THEN
                            payments.sc_pwd_discount
                        ELSE 0
                    END, 2
                )) AS VOID_SC_DISCOUNT,
            
            	SUM(DISTINCT ROUND(
                    CASE 
                        WHEN transactions.is_void = 2 AND discounts.name = 'PWD' THEN
                            payments.sc_pwd_discount
                        ELSE 0
                    END, 2
                )) AS VOID_PWD_DISCOUNT,
            
            
            	SUM(DISTINCT ROUND(
                    CASE 
                        WHEN transactions.is_void = 2 AND discounts.name = 'NAAC' THEN
                            payments.sc_pwd_discount
                        ELSE 0
                    END, 2
                )) AS VOID_NAAC_DISCOUNT,
            
            	SUM(ROUND(
                    CASE 
                        WHEN transactions.is_void = 2 THEN
                            (transactions.subtotal)
                        ELSE 0
                    END, 2
                )) AS VOID,
            
            	SUM(ROUND(
                    CASE 
                        WHEN transactions.is_void = 2 AND discounts.name <> 'SP' AND products.isVAT = 1 THEN
                            ROUND((transactions.subtotal / 1.12), 2)
                        ELSE 0
                    END, 2
                )) AS VAT_SALES_ADJUST,
            
            	 SUM(ROUND(
                    CASE 
                        WHEN transactions.is_void = 2 AND discounts.name <> 'SP' AND products.isVAT = 1 THEN
                            ROUND((transactions.subtotal / 1.12) * 0.12, 2)
                        ELSE 0
                    END, 2
                )) AS VAT_ADJUST,
            
                SUM(ROUND(
                    CASE 
                    WHEN discounts.name = 'SP' AND products.isVAT = 1 THEN
                        ROUND((transactions.subtotal / 1.12), 2)
                    WHEN products.isVAT = 0 THEN
                        ROUND(transactions.subtotal, 2)
                    ELSE 0
                    END, 2
                )) AS VAT_EXEMPT, 
            
                SUM(DISTINCT CASE 
					WHEN discounts.name = 'SC' THEN
                        payments.sc_pwd_discount
                    ELSE 0
                END) AS SC_DIS,

                SUM(DISTINCT CASE 
					WHEN discounts.name = 'PWD' THEN
                        payments.sc_pwd_discount
                    ELSE 0
                END) AS PWD_DIS,

                SUM(DISTINCT CASE
                    WHEN discounts.name = 'NAAC' THEN
                        payments.sc_pwd_discount
                    ELSE 0
                END) AS NAAC_DIS,
                
                SUM(DISTINCT CASE
                    WHEN discounts.name = 'SP' THEN
                        payments.sc_pwd_discount
                    ELSE 0
                END) AS SP_DIS,

                ROUND(
                SUM(CASE 
                    WHEN products.isVAT = 1 AND (products.isSCEnabled = 1 OR products.isPWDEnabled = 1) AND (discounts.name = 'SC' OR discounts.name = 'PWD') THEN 
                        transactions.subtotal ELSE 0
                END), 2) AS SC_PWD_VAT_PRICE,
                
                SUM(CASE
                    WHEN products.isVAT = 0 AND (products.isSCEnabled = 1 OR products.isPWDEnabled = 1) AND (discounts.name = 'SC' OR discounts.name = 'PWD') THEN
                        transactions.subtotal 
                    ELSE 0
                END) AS SC_PWD_NOT_VAT_DIS,
                
                CASE 
                    WHEN products.isVAT = 0 AND products.is_discounted = 1 AND transactions.is_void <> 2 THEN
                        ROUND(SUM(transactions.subtotal), 2)
                    ELSE 0
                END AS nonVatDiscounted,
                
                CASE 
                    WHEN products.isVAT = 0 AND transactions.is_void <> 2 THEN
                        ROUND(SUM(transactions.subtotal), 2)
                    ELSE 0
                END AS nonVat,
                
                CASE 
                    WHEN products.isVAT = 1 AND transactions.is_void <> 2 THEN
                        ROUND(SUM(transactions.subtotal), 2)
                    ELSE 0
                END AS vatable_price
            FROM transactions
            INNER JOIN payments ON payments.id = transactions.payment_id
            INNER JOIN receipt ON receipt.id = transactions.receipt_id
            INNER JOIN users ON users.id = transactions.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN products ON products.id = transactions.prod_id
            INNER JOIN business_date ON business_date.id = payments.business_date_id
            LEFT JOIN z_read ON z_read.id = business_date.z_read_id
            
            GROUP BY business_date.id
        ) AS subquery
        GROUP BY subquery.business_date_id";

        $dailyReport = $pdo->prepare($daily);
        $dailyReport->execute();
        $dailyResult = $dailyReport->fetchAll(PDO::FETCH_ASSOC);


        $refund_transactions = "SELECT 
        SUM(DISTINCT refunded.refunded_amt) AS totalRefunded,
        refunded.refunded_method_id,
        refunded.reference_num,
        refunded.otherDetails,
        refunded.payment_id,
        receipt.barcode,
        payments.payment_amount,
        payments.change_amount,
        products.isVAT,
        payments.business_date_id,
        discounts.name AS customerType,

        SUM(DISTINCT ROUND(CASE
        	WHEN discounts.name = 'SC' THEN
            	JSON_UNQUOTE(JSON_EXTRACT(refunded.otherDetails, '$[0].discount'))
            ELSE 0
        END,2)) AS SC_DIS,
        
        SUM(DISTINCT ROUND(CASE
        	WHEN discounts.name = 'SP' THEN
            	JSON_UNQUOTE(JSON_EXTRACT(refunded.otherDetails, '$[0].discount'))
            ELSE 0
        END,2)) AS SP_DIS,

		SUM(DISTINCT ROUND(CASE
        	WHEN discounts.name = 'PWD' THEN
            	JSON_UNQUOTE(JSON_EXTRACT(refunded.otherDetails, '$[0].discount'))
            ELSE 0
        END,2)) AS PWD_DIS,
        
        SUM(DISTINCT ROUND(CASE
        	WHEN discounts.name = 'NAAC' THEN
            	JSON_UNQUOTE(JSON_EXTRACT(refunded.otherDetails, '$[0].discount'))
            ELSE 0
        END,2)) AS NAAC_DIS,

        JSON_UNQUOTE(JSON_EXTRACT(refunded.otherDetails, '$[0].discount')) AS customer_discount,
            SUM( DISTINCT CASE
                    WHEN products.isVAT = 1 AND discounts.name <> 'SP' THEN 
                        ROUND(
                            (
                                (refunded.refunded_qty * products.prod_price) - 
                                ((refunded.refunded_qty * products.prod_price) * (( refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                            ) / 1.12,
                            2
                        )
                    ELSE 0
                END) AS totalVatSales,
                SUM(DISTINCT CASE
                    WHEN products.isVAT = 1 AND discounts.name <> 'SP' THEN 
                        ROUND(
                        (
                                ((refunded.refunded_qty * products.prod_price) - 
                                ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount/ (t.prod_qty * products.prod_price)) * 100) / 100)
                            ) / 1.12) * 0.12,
                            2
                        )
                    ELSE 0
                END) AS VAT,
                SUM(DISTINCT 
                    ROUND(CASE 
                        WHEN products.isVAT = 1 AND discounts.name = 'SP' THEN
                        ((refunded.refunded_qty * products.prod_price) / 1.12)
                        WHEN products.isVAT = 0 AND discounts.name = 'SP' THEN
                        ((refunded.refunded_qty * products.prod_price))
                        WHEN products.isVAT = 0 AND discounts.name <> 'SP' THEN
                        ((refunded.refunded_qty * products.prod_price))
                        ELSE 0
                        END
                ,2)) AS vatExempt
        FROM refunded
            INNER JOIN payments ON payments.id = refunded.payment_id
            INNER JOIN transactions AS t ON payments.id = t.payment_id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN receipt ON receipt.id = t.receipt_id
            INNER JOIN products ON products.id = refunded.prod_id
       	GROUP BY payments.business_date_id";

        $refundedSql = $pdo->prepare($refund_transactions);
        $refundedSql->execute();
        $refundedResult = $refundedSql->fetchAll(PDO::FETCH_ASSOC);


        $returnTransaction = "SELECT 
        SUM(DISTINCT return_exchange.return_amount) AS totalReturn,
        return_exchange.otherDetails,
        return_exchange.payment_id,
        receipt.barcode,
        payments.payment_amount,
        payments.change_amount,
        products.isVAT,
        payments.business_date_id,
        discounts.name AS customerType,

        SUM(DISTINCT ROUND(CASE
        	WHEN discounts.name = 'SC' THEN
            	JSON_UNQUOTE(JSON_EXTRACT(return_exchange.otherDetails, '$[0].discount'))
            ELSE 0
        END,2)) AS SC_DIS,
        
        SUM(DISTINCT ROUND(CASE
        	WHEN discounts.name = 'SP' THEN
            	JSON_UNQUOTE(JSON_EXTRACT(return_exchange.otherDetails, '$[0].discount'))
            ELSE 0
        END,2)) AS SP_DIS,

		SUM(DISTINCT ROUND(CASE
        	WHEN discounts.name = 'PWD' THEN
            	JSON_UNQUOTE(JSON_EXTRACT(return_exchange.otherDetails, '$[0].discount'))
            ELSE 0
        END,2)) AS PWD_DIS,
        
        SUM(DISTINCT ROUND(CASE
        	WHEN discounts.name = 'NAAC' THEN
            	JSON_UNQUOTE(JSON_EXTRACT(return_exchange.otherDetails, '$[0].discount'))
            ELSE 0
        END,2)) AS NAAC_DIS,

        JSON_UNQUOTE(JSON_EXTRACT(return_exchange.otherDetails, '$[0].discount')) AS customer_discount,
            SUM( DISTINCT CASE
                    WHEN products.isVAT = 1 AND discounts.name <> 'SP' THEN 
                        ROUND(
                            (
                                (return_exchange.return_qty * products.prod_price) - 
                                ((return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                            ) / 1.12,
                            2
                        )
                    ELSE 0
                END) AS totalVatSales,
                SUM(DISTINCT CASE
                    WHEN products.isVAT = 1 AND discounts.name <> 'SP' THEN 
                        ROUND(
                        (
                                ((return_exchange.return_qty * products.prod_price) - 
                                ((return_exchange.return_qty * products.prod_price) * ((return_exchange.itemDiscount/ (t.prod_qty * products.prod_price)) * 100) / 100)
                            ) / 1.12) * 0.12,
                            2
                        )
                    ELSE 0
                END) AS VAT,
                SUM(DISTINCT 
                    ROUND(CASE 
                        WHEN products.isVAT = 1 AND discounts.name = 'SP' THEN
                        ((return_exchange.return_qty * products.prod_price) / 1.12)
                        WHEN products.isVAT = 0 AND discounts.name = 'SP' THEN
                        ((return_exchange.return_qty * products.prod_price))
                        WHEN products.isVAT = 0 AND discounts.name <> 'SP' THEN
                        ((return_exchange.return_qty * products.prod_price))
                        ELSE 0
                        END
                ,2)) AS vatExempt
        FROM return_exchange
            INNER JOIN payments ON payments.id = return_exchange.payment_id
            INNER JOIN transactions AS t ON payments.id = t.payment_id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN receipt ON receipt.id = t.receipt_id
            INNER JOIN products ON products.id = return_exchange.product_id
       	GROUP BY payments.business_date_id";

        $returndSql = $pdo->prepare($returnTransaction);
        $returndSql->execute();
        $returnResult = $returndSql->fetchAll(PDO::FETCH_ASSOC);


        $return_map = [];
        foreach ($returnResult as $returns) {
            $return_map[$returns['business_date_id']] = $returns;
        }

        $refunded_map = [];
        foreach ($refundedResult as $refunded) {
            $refunded_map[$refunded['business_date_id']] = $refunded;
        }

        $result = [];
        foreach ($dailyResult as $daily) {
            $business_date = $daily['business_date_id'];
            $VOID = $daily['VOID'];
            $totalVoid = ($daily['VOID'] - $daily['VOID_DISCOUNT']);
            $paidAmount = $daily['paidAmount'];
            $totalAmount = (float)$daily['subtotal'] - (float)$VOID;
            $sc_discount = $daily['SC_DIS'] - $daily['VOID_SC_DISCOUNT'];
            $pwd_discount = $daily['PWD_DIS'] - $daily['VOID_PWD_DISCOUNT'];
            $naac_discount = $daily['NAAC_DIS'] - $daily['VOID_NAAC_DISCOUNT'];
            $sp_discount = $daily['SP_DIS'] - $daily['VOID_SP_DISCOUNT'];
            $totalCustomerDiscount = (float)$daily['CUSTOMER_DIS'] - (float)$daily['VOID_DISCOUNT'];

            $VOID_DISCOUNT = $daily['VOID_DISCOUNT'];

            $VOID_SC_DISCOUNT = (float)$daily['VOID_SC_DISCOUNT'];
            $VOID_PWD_DISCOUNT = (float)$daily['VOID_PWD_DISCOUNT'];
            $VOID_SP_DISCOUNT = (float)$daily['VOID_SP_DISCOUNT'];
            $VOID_NAAC_DISCOUNT = (float)$daily['VOID_NAAC_DISCOUNT'];

            $VOID_ADJUST = $daily['VAT_ADJUST'];
            $VOID_SALES_ADJUST = $daily['VAT_SALES_ADJUST'];
            $VAT_SALES = $daily['VAT_SALES'];
            $VAT_AMOUNT = $daily['VAT_AMOUNT'];
            $VAT_EXEMPT = $daily['VAT_EXEMPT'];

            $BEG_SI = $daily['first_receipt_num'];
            $END_SI = $daily['last_receipt_num'];

            $NET = ($daily['subtotal'] - ($totalCustomerDiscount - $daily['VOID_DISCOUNT']));

            $VAT_SALES_REF_RETURN = 0;
            $VAT_AMOUNT_REF_RET = 0;
            $sc_ref_ret_void_discount = 0;
            $sp_ref_ret_void_discount = 0;
            $naac_ref_ret_void_discount = 0;
            $pwd_ref_ret_void_discount = 0;
            $VAT_ADJUST = 0;
            $TOTAL_DEDUCTION = 0;
            $PRESENT_ACC_SALES = 0;

            $sc_ref_ret_void_discount += $VOID_SC_DISCOUNT;
            $pwd_ref_ret_void_discount += $VOID_PWD_DISCOUNT;
            $sp_ref_ret_void_discount += $VOID_SP_DISCOUNT;
            $naac_ref_ret_void_discount += $VOID_NAAC_DISCOUNT;
            $total_Ref_Ret_amount = 0;

            if (isset($refunded_map[$business_date])) {
                $total_Ref_Ret_amount += (floatval($refunded_map[$business_date]['totalRefunded']));
                $totalAmount -= (floatval($refunded_map[$business_date]['totalRefunded']));
                if ($refunded_map[$business_date]['customerType'] == 'SC') {
                    $sc_discount -= max(0, $refunded_map[$business_date]['SC_DIS']);
                    $sc_ref_ret_void_discount += $refunded_map[$business_date]['SC_DIS'];
                } else if ($refunded_map[$business_date]['customerType'] == 'SP') {
                    $sp_discount -= max(0, $refunded_map[$business_date]['SP_DIS']);
                    $sp_ref_ret_void_discount += $refunded_map[$business_date]['SP_DIS'];
                } else if ($refunded_map[$business_date]['customerType'] == 'NAAC') {
                    $naac_discount -= max(0, $refunded_map[$business_date]['NAAC_DIS']);
                    $naac_ref_ret_void_discount += $refunded_map[$business_date]['NAAC_DIS'];
                } else if ($refunded_map[$business_date]['customerType'] == 'PWD') {
                    $pwd_discount -= max(0, $refunded_map[$business_date]['PWD_DIS']);
                    $pwd_ref_ret_void_discount += $refunded_map[$business_date]['PWD_DIS'];
                }
                
                $totalCustomerDiscount -= $refunded_map[$business_date]['customer_discount'];
                $total_Ref_CustomerDiscount = $refunded_map[$business_date]['customer_discount'];

                $VAT_SALES -= $refunded_map[$business_date]['totalVatSales'];
                $VAT_SALES_REF_RETURN = $refunded_map[$business_date]['totalVatSales'];

                $VAT_AMOUNT -= $refunded_map[$business_date]['VAT'];
                $VAT_AMOUNT_REF_RET += $refunded_map[$business_date]['VAT'];

                $VAT_EXEMPT -= $refunded_map[$business_date]['vatExempt'];
                $VAT_ADJUST += $VAT_AMOUNT_REF_RET;
            }


            if (isset($return_map[$business_date])) {
                $total_Ref_Ret_amount += (floatval($return_map[$business_date]['totalReturn']));
                $totalAmount -= (floatval($return_map[$business_date]['totalReturn']));
                if ($return_map[$business_date]['customerType'] == 'SC') {
                    $sc_discount -= $return_map[$business_date]['SC_DIS'];
                    $sc_ref_ret_void_discount += $return_map[$business_date]['SC_DIS'];
                } else if ($return_map[$business_date]['customerType'] == 'SP') {
                    $sp_discount -= $return_map[$business_date]['SP_DIS'];
                    $sp_ref_ret_void_discount += $return_map[$business_date]['SP_DIS'];
                } else if ($return_map[$business_date]['customerType'] == 'NAAC') {
                    $naac_discount -= $return_map[$business_date]['NAAC_DIS'];
                    $naac_ref_ret_void_discount += $return_map[$business_date]['NAAC_DIS'];
                } else if ($return_map[$business_date]['customerType'] == 'PWD') {
                    $pwd_discount -= $return_map[$business_date]['PWD_DIS'];
                    $pwd_ref_ret_void_discount += $return_map[$business_date]['PWD_DIS'];
                }
                
                $totalCustomerDiscount -= $return_map[$business_date]['customer_discount'];
                $total_Ref_CustomerDiscount = $return_map[$business_date]['customer_discount'];

                $VAT_SALES -= $return_map[$business_date]['totalVatSales'];
                $VAT_SALES_REF_RETURN = $return_map[$business_date]['totalVatSales'];

                $VAT_AMOUNT -= $return_map[$business_date]['VAT'];
                $VAT_AMOUNT_REF_RET += $return_map[$business_date]['VAT'];

                $VAT_EXEMPT -= $return_map[$business_date]['vatExempt'];
                $VAT_ADJUST += $VAT_AMOUNT_REF_RET;
            }

            $result[] = [
                'PRESENT_ACC_SALES' => max(0, number_format($totalAmount - $totalCustomerDiscount,2)),
                'less_discount' => number_format($totalCustomerDiscount,2),
                'VOID' => number_format($VOID - $VOID_DISCOUNT,2),
                'totalReturn' => $total_Ref_Ret_amount,
                'BEG_SI' => $BEG_SI,
                'END_SI' => $END_SI,
                'subtotal' => number_format($totalAmount,2),
                'sc_discount' => number_format($sc_discount,2),
                'sp_discount' => number_format($sp_discount,2),
                'naac_discount' => number_format($naac_discount,2),
                'pwd_discount' => number_format($pwd_discount,2),
                'VAT_SALES' => number_format((float)$VAT_SALES - (float)$VOID_SALES_ADJUST,2),
                'VAT_AMOUNT' => number_format((float)$VAT_AMOUNT - (float)$VOID_ADJUST,2),
                'VAT_EXEMPT' => number_format($VAT_EXEMPT,2),
                'sc_ref_ret_void_discount' => number_format($sc_ref_ret_void_discount,2),
                'sp_ref_ret_void_discount' => number_format($sp_ref_ret_void_discount,2),
                'naac_ref_ret_void_discount' => number_format($naac_ref_ret_void_discount,2),
                'pwd_ref_ret_void_discount' => number_format($pwd_ref_ret_void_discount,2),
                'total_Ref_CustomerDiscount' => number_format($total_Ref_CustomerDiscount,2),
                'VAT_SALES_REF_RETURN' => number_format($VAT_SALES_REF_RETURN,2),
                'VAT_AMOUNT_REF_RET' => number_format($VAT_AMOUNT_REF_RET + $VOID_ADJUST,2),
                'VAT_ADJUST' => number_format($VAT_ADJUST,2),
                // 'NET' => (number_format(($totalAmount - $totalCustomerDiscount) - $VAT_ADJUST,2)),
                'NET' => (number_format($VAT_AMOUNT_REF_RET,2)),
            ];
            
        }

        return $result;

    }

    public function getAllZread($startDate, $endDate) {
        $pdo = $this->connect();

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

        $result = [];
        if (!empty($z_reports_data)) 
        { 
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

                $grandAccumulatedEnd = $ZReadData->present_accumulated_sale;
                $totalIncome = $ZReadData->gross_amount; 
                $vatableSales = $ZReadData->vatable_sales;
                $vatAmount = $ZReadData->vat_amount;
                $vatExempt = $ZReadData->vat_exempt;
                $sc_discount = $ZReadData->senior_discount;
                $pwd_discount = $ZReadData->pwd_discount;
                $naac_discount = $ZReadData->naac_discount;
                $solo_parent_discount = $ZReadData->solo_parent_discount;
                $other_discount = $ZReadData->other_discount;
                $returns =  $ZReadData->return;
                $voids = $ZReadData->void;
                $totalDeductions = ($ZReadData->senior_discount + $ZReadData->pwd_discount + $ZReadData->naac_discount + $solo_parent_discount + $other_discount + $ZReadData->void + $returns);
                $z_counter = $ZReadData->zReadCounter;
                $void_vat = (float)$ZReadData->total_void_vat;
                $returnd_vat = (float)$ZReadData->vat_return;
                $refund_vat = (float)$ZReadData->vat_refunded;
                $netSales = (float)$ZReadData->net_amount;

                $result[] = [
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
            }
        }
    
        return $result;
    }
  
    public function E_reports($customerType, $startDate, $endDate) {
     
        $pdo = $this->connect();
        // Base query for e_reports
        $e_reports_query = "SELECT
		customer_type,
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
        VAT_EXEMPTS,
        vatable_price,
        ROUND(
          CASE 
          WHEN customer_type = 'SP' THEN 0
          ELSE vatable_price / 1.12
          END, 2
        ) AS VAT_SALES,

        ROUND(
            CASE 
            WHEN customer_type = 'SP' THEN 0
            ELSE (vatable_price / 1.12) * 0.12
            END, 2
        ) AS VAT_AMOUNT,

        SUM(ROUND(
            CASE 
            WHEN (customer_type = 'SP') THEN
            	(ROUND(vatable_price / 1.12, 2)) + nonVat
            ELSE nonVat
            END, 2
        )) AS VAT_EXEMPT,
       
       SUM(
        CASE
            WHEN (customer_type = 'SP' OR customer_type = 'NAAC') THEN
                ROUND((SP_NAAC_VAT_PRICE / 1.12) * (customer_discount / 100), 2)
            ELSE 0
        END +
        CASE
            WHEN (customer_type = 'SC' OR customer_type = 'PWD') AND ROUND(SP_NAAC_VAT_PRICE, 2) < 2500 THEN
                ROUND(SC_PWD_VAT_PRICE * (customer_discount / 100), 2)
            ELSE 0
        END +
        CASE
            WHEN (customer_type = 'SC' OR customer_type = 'PWD') AND ROUND(SP_NAAC_VAT_PRICE, 2) >= 2500 THEN
                ROUND(2500 * (customer_discount / 100), 2)
            ELSE 0
        END +
        CASE
            WHEN (customer_type = 'SC' OR customer_type = 'PWD') AND ROUND(SP_NAAC_VAT_PRICE, 2) >= 2500 AND ROUND(nonVat, 2) <> 0 THEN
                ROUND(2500 * (customer_discount / 100), 2)
            ELSE 0
        END +
        CASE
            WHEN (customer_type = 'SC' OR customer_type = 'PWD') AND ROUND(SP_NAAC_VAT_PRICE, 2) < 2500 AND ROUND(nonVat, 2) <> 0 THEN
                ROUND(nonVat * (customer_discount / 100), 2)
            ELSE 0
        END +
          
        CASE
            WHEN (customer_type = 'SP' OR customer_type = 'NAAC') AND ROUND(nonVat, 2) <> 0 THEN
                ROUND(nonVat * (customer_discount / 100), 2)
            ELSE 0
        END  
    	) AS CUSTOMER_DIS,
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
                    ROUND(SUM(transactions.subtotal), 2) AS totalAmount,
                    payments.cart_discount AS cart_discount,
                    payments.sc_pwd_discount AS customerDiscount,
                    transactions.payment_id AS paymentIds,
                    transactions.receipt_id AS receiptIds,
                    (payments.payment_amount - payments.change_amount) AS paymentAmount,
                    payments.creditTotal AS totalCredit,
                    payments.payment_details,
                    payments.date_time_of_payment,
            		discounts.name AS customer_type,
                    discounts.discount_amount AS customer_discount,
                    payments.vatable_sales AS VAT_EXEMPTS,
            
            		ROUND(
                        SUM(CASE WHEN products.isVAT = 1 AND (products.isSPEnabled = 1 OR products.isNAACEnabled = 1) THEN 
                           transactions.subtotal ELSE 0 
                      END),2) AS SP_NAAC_VAT_PRICE,

                    ROUND(
                        SUM(CASE WHEN products.isVAT = 1 AND (products.isSCEnabled = 1 OR products.isPWDEnabled = 1) THEN 
                           transactions.subtotal ELSE 0 
                      END),2) AS SC_PWD_VAT_PRICE,
            
                    CASE 
                        WHEN products.isVAT = 1 AND products.is_discounted = 1 THEN
                            ROUND((SUM( transactions.subtotal)),2)
                        ELSE 0
                        END AS vatDiscounted,
            
                    CASE 
                        WHEN products.isVAT = 0 AND products.is_discounted = 1 THEN
                            ROUND((SUM( transactions.subtotal)),2)
                        ELSE 0
                        END AS nonVatDiscounted,
           			CASE 
                        WHEN products.isVAT = 0 THEN
                            ROUND((SUM( transactions.subtotal)),2)
                        ELSE 0
                        END AS nonVat,
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
                WHERE transactions.is_paid = 1 AND transactions.is_void NOT IN (1, 2) AND users.discount_id = ?";
  
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
            ROUND(((SUM(refunded_amt) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))) ) * 0.12 ,2) AS vat_amount,
            ROUND((SUM(refunded_amt) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))))  ,2) AS VatExempt,
            ROUND(SUM(refunded_amt) - (JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount')) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) ), 2) AS totalRefAmount,
            (JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS overAllDiscounts,
            SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].credits'))) AS credits,
            SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * (refunded_amt)) AS cartDiscount,
            (JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) AS customerDiscount,
            SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS itemDiscount,
            date 
            FROM refunded
            GROUP BY payment_id
    ) AS subquery;";
        
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
                    ROUND(((SUM(return_amount) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))) ) * 0.12 ,2) AS vat_amount,
                    ROUND((SUM(return_amount) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))))  ,2) VatExempt,
                    ROUND(SUM(return_amount) - (SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * return_amount) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))), 2) AS totalReturnAmount,
                    SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * return_amount) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS overAllDiscounts,
                    SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].credits'))) AS credits,
                    SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * return_amount) AS cartDiscount,
                    (JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) AS customerDiscount,
                    SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS itemDiscount,
                    date 
                    FROM return_exchange
                    GROUP BY payment_id
            ) AS subqeury;";

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

            // $netSales = (float)$payments['paymentAmount'] - $totalVat;
            $netSales = (float)$payments['paymentAmount'];

            if (isset($refunded_map[$payment_id])) {
                $totalPaymentAmount -= (floatval($refunded_map[$payment_id]['totalRefAmount']));
                // $totalVatSales -= floatval($refunded_map[$payment_id]['VatExempt']);
                // $totalVat -= floatval($refunded_map[$payment_id]['vat_amount']);
                // $netSales -= floatval($refunded_map[$payment_id]['totalRefAmount']) + floatval($refunded_map[$payment_id]['vat_amount']);
                $netSales -= floatval($refunded_map[$payment_id]['totalRefAmount']);

            }

            if (isset($returned_map[$payment_id])) {
                $totalPaymentAmount -= (floatval($returned_map[$payment_id]['totalReturnAmount']));
                // $totalVatSales -= floatval($returned_map[$payment_id]['VatExempt']);
                // $totalVat -= floatval($returned_map[$payment_id]['vat_amount']);
                $netSales -= floatval($returned_map[$payment_id]['totalReturnAmount']) + floatval($returned_map[$payment_id]['vat_amount']);
            }
            

            if (max(0, (float)number_format($totalPaymentAmount, 2, '.', '')) != 0) {
                $customerDisRef = $refunded_map[$payment_id]['customerDiscount'] ?? 0;
                $totalRef = $refunded_map[$payment_id]['OriginalAmountRef'] ?? 0;
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
                    'totalAmount' => (float)(number_format($payments['totalAmount'] - $totalRef,2, '.', '')),
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
                    'customer_discount' => (float)($payments['CUSTOMER_DIS'] - $customerDisRef), // Temporary Change
                    'totalRefAmount' => $refunded_map[$payment_id]['totalRefAmount'] ?? 0,
                    'overAllDiscounts' => $refunded_map[$payment_id]['overAllDiscounts'] ?? 0,
                    'credits' => $refunded_map[$payment_id]['credits'] ?? 0,
                    'cartDiscount' => $refunded_map[$payment_id]['cartDiscount'] ?? 0,
                    // 'customerDiscount' => $customerDis,
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
    public function getDailyTransaction($startDate, $endDate)
    {
        $dateToday = "";
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);
        $end->modify('+1 day');
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($start, $interval, $end);
        
       
        $result = [];
        foreach($period as $date)
        {
            $dateToday = $date->format('Y-m-d');
            $pdo =  $this->connect();
            $sales = "WITH SalesData AS (
                            SELECT 
                                ROUND(SUM(py.payment_amount) - SUM(py.change_amount) - SUM(t.service_charge), 2) AS grossSale,
                                p.isVAT AS isVat,
                                p.isSCEnabled,
                                p.isSPEnabled,
                                p.isPWDEnabled,
                                p.isNAACEnabled,
                                d.name AS discountType,
                                d.discount_amount AS discount
                            FROM payments py
                            INNER JOIN transactions t ON t.payment_id = py.id
                            INNER JOIN products p ON t.prod_id = p.id
                            INNER JOIN receipt r ON t.receipt_id = r.id
                            INNER JOIN users u ON t.user_id = u.id
                            INNER JOIN discounts d ON u.discount_id = d.id 
                            WHERE t.is_void NOT IN (1, 2)
                            AND is_paid = 1
                            AND py.date_time_of_payment = ?
                            GROUP BY p.isVAT, p.isSCEnabled, p.isSPEnabled, p.isPWDEnabled, p.isNAACEnabled, d.name, d.discount_amount
                        )
                        SELECT 
                        (SELECT barcode FROM receipt ORDER BY id ASC LIMIT 1) AS beg_si,
                        (SELECT barcode FROM receipt ORDER BY id DESC LIMIT 1) AS end_si,
                            grossSale,
                            CASE 
                                WHEN isVat = 1 THEN  
                                    ROUND(grossSale / 1.12, 2) 
                                ELSE  0
                            END AS vatableSales,
                            CASE 
                                WHEN isVat = 1 THEN 
                                    ROUND(grossSale * 0.12, 2) 
                                ELSE 0
                            END AS vatAmount,
                            CASE 
                                WHEN isSCEnabled = 1 AND discountType = 'SC' THEN
                                    ROUND(grossSale * (discount / 100), 2)
                                ELSE 0
                            END AS totalSCDiscount,
                            CASE 
                                WHEN isPWDEnabled = 1 AND discountType = 'PWD' THEN
                                    ROUND(grossSale * (discount / 100), 2)
                                ELSE 0
                            END AS totalPWDDiscount,
                            CASE 
                                WHEN isSPEnabled = 1 AND discountType = 'SP' THEN
                                    ROUND(grossSale * (discount / 100), 2)
                                ELSE 0
                            END AS totalSPDiscount,
                            CASE 
                                WHEN isNAACEnabled = 1 AND discountType = 'NAAC' THEN
                                    ROUND(grossSale * (discount / 100), 2)
                                ELSE 0
                            END AS totalNAACDiscount
                        FROM SalesData";

            $sales_result = $pdo->prepare($sales); 
            $sales_result->execute([$dateToday]);
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
                                        ROUND(((SUM(refunded_amt) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))))) * 0.12 ,2) AS vat_amount,
                                        ROUND((SUM(refunded_amt) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))) ,2) AS VatExempt,
                                        ROUND(SUM(refunded_amt) - (JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount')) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) ), 2) AS totalRefAmount,
                                        (JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS overAllDiscounts,
                                        SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].credits'))) AS credits,
                                        SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * (refunded_amt)) AS cartDiscount,
                                        (JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) AS customerDiscount,
                                        SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS itemDiscount,
                                        date 
                                        FROM refunded
                                        WHERE date = ?
                                        GROUP BY payment_id
                                ) AS subquery";

            $refund_report = $pdo->prepare($refunded_query);
            $refund_report->execute([$dateToday]);
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
                                    ROUND(((SUM(return_amount) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))))) * 0.12 ,2) AS vat_amount,
                                    ROUND((SUM(return_amount) - SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))) ,2) VatExempt,
                                    ROUND(SUM(return_amount) - (SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * return_amount) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')))), 2) AS totalReturnAmount,
                                    SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * return_amount) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) + SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS overAllDiscounts,
                                    SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].credits'))) AS credits,
                                    SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].cartRate')) * return_amount) AS cartDiscount,
                                    (JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].discount'))) AS customerDiscount,
                                    SUM(JSON_UNQUOTE(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData'))) AS itemDiscount,
                                    date 
                                    FROM return_exchange
                                    WHERE date = ?
                                    GROUP BY payment_id
                            ) AS subqeury
                            ";

            $return_report = $pdo->prepare($return_query);
            $return_report->execute([$dateToday]);
            $returndData = $return_report->fetchAll(PDO::FETCH_ASSOC);

            $dailySales = array_sum(array_column($salesReport, 'grossSale'));
            $dailyRefund = array_sum(array_column($refundData, 'totalRefAmount'));
            $dailyReturn = array_sum(array_column($returndData, 'totalReturnAmount'));

            $dailyNetSales = $dailySales - $dailyRefund - $dailyReturn;
            

            $vatableSales = array_sum(array_column($salesReport, 'vatableSales'));
            $vatAmount = array_sum(array_column($salesReport, 'vatAmount'));

            $sc_discount = array_sum(array_column($salesReport, 'totalSCDiscount'));
            $pwd_discount =  array_sum(array_column($salesReport, 'totalPWDDiscount'));
            $naac_discount =  array_sum(array_column($salesReport, 'totalNAACDiscount'));
            $sp_discount = array_sum(array_column($salesReport, 'totalSPDiscount'));
            $totalDeductions = $sc_discount + $pwd_discount + $naac_discount + $sp_discount;
            $result[] = [
                'dateRange' => $dateToday,
                'beginning_si' => array_column($salesReport, 'beg_si'),
                'end_si' => array_column($salesReport, 'end_si'),
                'grandEndAccumulated' => 0,
                'grandBegAccumulated' => 0,
                'issued_si' => 0,
                'grossSalesToday' => $dailySales,
                'vatable_sales' => $vatableSales,
                'vatAmount' => $vatAmount,
                'vatExempt' => 0,
                'zero_rated' => 0,
                'sc_discount' => $sc_discount,
                'pwd_discount' => $pwd_discount,
                'naac_discount' => $naac_discount,
                'solo_parent_discount' => $sp_discount,
                'other_discount' => 0,
                'returned' => 0,
                'voids' => 0,
                'totalDeductions' => $totalDeductions,
                'void_vat' => 0,
                'returnd_vat' => 0,
                'othersVatAdjustment' =>0,
                'totalVatAjustment' => 0,
                'refund_vat' =>0,
                'netSales' => $dailyNetSales,
                'totalIncome' => 0,
                'resetCount' => 0,
                'z_counter' => 0,
            ];

            if($startDate === $endDate) return $result;
        }
        if($startDate !== $endDate)
            return $result;
    }
}
?>
