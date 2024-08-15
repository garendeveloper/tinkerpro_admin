<?php


class SalesHistoyFacade extends DBConnection {

    public function getAllSales($id, $roleId, $allUsers) {
        $pdo = $this->connect();

        $selectClause = "
        SELECT
            payment_id,
            or_num,
            barcode,
            discount_id,
            customer_id,
            customer_type,
            customer_discount,
            customer_fname,
            cutomer_lname,
            temporary_name,
            total,
            totalDis,
            totalQty,
            transaction_num,
            is_transact,
            change_amount,
            payment_amount,
            barcode_img,
            date_time_of_payment,
            returnID,
            (totalDis + total) AS totalAmount,
            ROUND(((total)), 2) AS totalVatSales,
            ROUND((((total)) * 0.12)+ 0.0001, 2) AS VAT, 
            ROUND((ROUND(((total)) + 0.0001, 2) * (customer_discount / 100))+ 0.0001, 2) AS fcustomer_discount,
            ((total * customer_discount) / 100) AS customerDisType,
            ROUND(total - (ROUND((ROUND(((total))+ 0.0001, 2) * (customer_discount / 100))+ 0.0001, 2)), 2) AS toBePaid,
            isVAT,
            is_paid,
            is_void,
            reason,
            is_refunded,
            cashier
        FROM (
            SELECT
                users.id AS customer_id,
                users.discount_id,
                discounts.discount_amount AS customer_discount,
                users.first_name AS customer_fname,
                users.last_name AS cutomer_lname,
                temporary_names.name AS temporary_name,
                discounts.name AS customer_type,
                transactions.transaction_num,
                transactions.is_transact,
                transactions.payment_id,
                payments.change_amount,   
                ROUND(payments.payment_amount - SUM(DISTINCT transactions.service_charge), 2) AS payment_amount,
                payments.date_time_of_payment,
                return_exchange.id AS returnID,
                SUM(transactions.subtotal) AS total,
                SUM(transactions.discount_amount) AS totalDis,
                SUM(transactions.prod_qty) AS totalQty,
                products.isVAT,
                receipt.id AS or_num,
                receipt.barcode,
                receipt.barcode_img,
                receipt.is_refunded,
                transactions.is_paid,
                transactions.is_void,
                void_reason.reason,
                CONCAT(cashierUser.first_name, ' ', cashierUser.last_name) AS cashier
            FROM transactions
            INNER JOIN payments ON payments.id = transactions.payment_id
            INNER JOIN products ON products.id = transactions.prod_id
            INNER JOIN users ON users.id = transactions.user_id
            INNER JOIN users AS cashierUser ON cashierUser.id = transactions.cashier_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN receipt ON receipt.id = transactions.receipt_id
            LEFT JOIN temporary_names ON temporary_names.id = transactions.tempo_name
            LEFT JOIN return_exchange ON payments.id = return_exchange.payment_id
            LEFT JOIN void_reason ON void_reason.id = transactions.void_id";

        $whereClause = ($roleId == 1 || $allUsers == 1) ? "" : " WHERE transactions.cashier_id = ?";
        $groupClause = "
            GROUP BY
                transactions.transaction_num,
                transactions.is_transact,
                payments.change_amount,
                payments.payment_amount
            ORDER BY receipt.id DESC
        ) AS subquery;";


        $payments = "
        SELECT payments.*, transactions.payment_id, SUM(DISTINCT payments.cart_discount) AS CartDiscount
                        FROM payments
                        INNER JOIN transactions ON payments.id = transactions.payment_id";
        $groupClausePayment = "
        GROUP BY payments.id";

        $pay = $payments . $whereClause . $groupClausePayment;
        $sql = $selectClause . $whereClause . $groupClause;

        $q = $pdo->prepare($sql);
        $payStatement = $pdo->prepare($pay);

        if ($roleId == 1 || $allUsers == 1) {
            $q->execute();
            $payStatement->execute();
        } else {
            $q->execute([$id]);
            $payStatement->execute([$id]);
        }
    
        // Define the SQL query for the second execution
        $secondQuery = "
        SELECT DISTINCT
            users.id AS customer_id,
            discounts.discount_amount AS customer_discount,
            users.first_name AS customer_fname,
            users.last_name AS cutomer_lname,
            temporary_names.name AS temporary_name,
            discounts.name AS customer_type,
            payments.change_amount,   
            payments.payment_amount,
            payments.date_time_of_payment,
            SUM( refunded.refunded_amt) AS totalRefunded,
            CAST(SUM(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')) AS DECIMAL(10,2)) AS itemDiscountsData,
            refunded.reference_num,
            refunded.payment_id,
            refunded.otherDetails,
            products.isVAT,
            transactions.subtotal,
            transactions.transaction_num,
            transactions.is_transact,
            receipt.barcode_img,
            receipt.id AS or_num,
            receipt.barcode,
            SUM(transactions.subtotal) AS total,
            receipt.is_refunded,
            refunded.date AS refunded_date_time,
            CONCAT(cashierUser.first_name, ' ', cashierUser.last_name) AS cashier
        FROM refunded
        INNER JOIN payments ON payments.id = refunded.payment_id
        INNER JOIN products ON products.id = refunded.prod_id
        INNER JOIN (SELECT payment_id,receipt_id,tempo_name,cashier_id,user_id,subtotal,transaction_num,is_transact FROM transactions GROUP BY payment_id) as transactions 						ON transactions.payment_id = payments.id
        INNER JOIN receipt ON receipt.id = transactions.receipt_id
        INNER JOIN users ON users.id = transactions.user_id
        INNER JOIN users AS cashierUser ON cashierUser.id = transactions.cashier_id
        INNER JOIN discounts ON discounts.id = users.discount_id
        LEFT JOIN temporary_names ON temporary_names.id = transactions.tempo_name
        WHERE refunded.payment_id = payments.id";
    
        $whereClause2 = ($roleId == 1 || $allUsers == 1) ? "" : " AND transactions.cashier_id = ?";
        $groupClause2 = " GROUP BY refunded.reference_num";


        $returnProducts = "
        SELECT DISTINCT
            return_exchange.return_qty,
            users.id AS customer_id,
            return_exchange.id AS returnID,
            discounts.discount_amount AS customer_discount,
            users.first_name AS customer_fname,
            users.last_name AS cutomer_lname,
            temporary_names.name AS temporary_name,
            discounts.name AS customer_type,
            payments.change_amount,   
            payments.payment_amount,
            payments.date_time_of_payment,
            SUM(return_exchange.return_amount) AS totalReturn,
            CAST(SUM(JSON_EXTRACT(otherDetails, '$[0].itemDiscountsData')) AS DECIMAL(10,2)) AS itemDiscountsData,
            return_exchange.payment_id,
            return_exchange.otherDetails,
            products.isVAT,
            transactions.subtotal,
            transactions.transaction_num,
            transactions.is_transact,
            receipt.barcode_img,
            receipt.id AS or_num,
            receipt.barcode,
            SUM(transactions.subtotal) AS total,
            receipt.is_refunded,
            return_exchange.date AS return_date,
            CONCAT(cashierUser.first_name, ' ', cashierUser.last_name) AS cashier
        FROM return_exchange
        INNER JOIN payments ON payments.id = return_exchange.payment_id
        INNER JOIN products ON products.id = return_exchange.product_id
        INNER JOIN (SELECT payment_id,receipt_id,tempo_name,cashier_id,user_id,subtotal,transaction_num,is_transact FROM transactions GROUP BY payment_id) as transactions 						ON transactions.payment_id = payments.id
        INNER JOIN receipt ON receipt.id = transactions.receipt_id
        INNER JOIN users ON users.id = transactions.user_id
        INNER JOIN users AS cashierUser ON cashierUser.id = transactions.cashier_id
        INNER JOIN discounts ON discounts.id = users.discount_id
        LEFT JOIN temporary_names ON temporary_names.id = transactions.tempo_name
        WHERE return_exchange.payment_id = payments.id";


        $groupClause3 = " GROUP BY return_exchange.id";

    
        $sql2 = $secondQuery . $whereClause2 . $groupClause2;
        $ret_products = $returnProducts . $whereClause2 . $groupClause3;

        $q2 = $pdo->prepare($sql2);
        $return_products = $pdo->prepare($ret_products);
    
        if ($roleId == 1 || $allUsers == 1) {
            $q2->execute();
            $return_products->execute();
        } else {
            $q2->execute([$id]);
            $return_products->execute([$id]);
        }
    
      
        $response = $q->fetchAll(PDO::FETCH_ASSOC);
        $refund_data = $q2->fetchAll(PDO::FETCH_ASSOC);
        $paymentDetails = $payStatement->fetchAll(PDO::FETCH_ASSOC);
        $returned = $return_products->fetchAll(PDO::FETCH_ASSOC);
    
        echo json_encode([
            'success' => true,
            'data' => $response,
            'data2' => $refund_data,
            'payments_details' => $paymentDetails,
            'returnProducts' => $returned,
        ]);
    }
    public function getTransactionsByNumJS($transactionNum) {
        $sql = $this->connect()->prepare("SELECT transactions.*, 
        payments.*,
            products.isVAT,
        users.first_name,
        users.last_name,
        temporary_names.name AS temporary_name,
        discounts.name,
        receipt.barcode_img,
            SUM(transactions.prod_qty) AS totalProdQty,
            SUM(transactions.subtotal) AS totalSubtotal
        FROM transactions 
            INNER JOIN products ON products.id = transactions.prod_id
            INNER JOIN payments ON payments.id = transactions.payment_id
            INNER JOIN users ON users.id = transactions.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN receipt ON receipt.id = transactions.receipt_id
            LEFT JOIN temporary_names ON temporary_names.id = transactions.tempo_name
            WHERE transaction_num = '$transactionNum' AND is_transact = '1'
            GROUP BY transactions.prod_id;");
        $sql->execute();
    
    
        $q = $this->connect()->prepare("SELECT * FROM payment_method");
        $q->execute();
    
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        $paymentMethod = $q->fetchAll(PDO::FETCH_ASSOC);
    
        echo json_encode([
            'success' => true, 
            'response' => $result,
            'paymentMethod' => $paymentMethod,
        ]);
      }
    
}

