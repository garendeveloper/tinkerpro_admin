<?php

class OtherReportsFacade extends DBConnection {

    public function getRefundData( $selectedProduct, $singleDateData, $startDate, $endDate ) {

        if ( $selectedProduct && !$singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT r.id  AS refunded_id,r.refunded_method_id as method, p.id AS payment_id, products.prod_desc AS prod_desc,rc.qrNumber as qrNumber,
        r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, products.barcode as barcode,products.sku as sku,
        r.date AS date, r.refunded_method_id AS method, t.receipt_id AS receipt_id,r.otherDetails as otherDetails
        FROM refunded AS r
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN (
            SELECT DISTINCT payment_id, receipt_id
            FROM transactions
        ) AS t ON t.payment_id = p.id
        INNER JOIN receipt AS rt ON rt.id = t.receipt_id
        LEFT JOIN return_coupon as rc ON rc.receipt_id = rt.id
        INNER JOIN products ON r.prod_id = products.id 
        WHERE r.prod_id = :selectedProduct';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedProduct', $selectedProduct );
            $sql->execute();
            return $sql;

        } else if ( !$selectedProduct && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT r.id  AS refunded_id,r.refunded_method_id as method, p.id AS payment_id, products.prod_desc AS prod_desc,rc.qrNumber as qrNumber,
        r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, products.barcode as barcode,products.sku as sku,
        r.date AS date, r.refunded_method_id AS method, t.receipt_id AS receipt_id,r.otherDetails as otherDetails
        FROM refunded AS r
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN (
            SELECT DISTINCT payment_id, receipt_id
            FROM transactions
        ) AS t ON t.payment_id = p.id
        INNER JOIN receipt AS rt ON rt.id = t.receipt_id
        LEFT JOIN return_coupon as rc ON rc.receipt_id = rt.id
        INNER JOIN products ON r.prod_id = products.id
        WHERE DATE(r.date) = :singleDateData';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;

        } else if ( !$selectedProduct && !$singleDateData && $startDate && $endDate ) {
            $sql = 'SELECT r.id  AS refunded_id,r.refunded_method_id as method, p.id AS payment_id, products.prod_desc AS prod_desc,rc.qrNumber as qrNumber,
        r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, products.barcode as barcode,products.sku as sku,
        r.date AS date, r.refunded_method_id AS method, t.receipt_id AS receipt_id,r.otherDetails as otherDetails
        FROM refunded AS r
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN (
            SELECT DISTINCT payment_id, receipt_id
            FROM transactions
        ) AS t ON t.payment_id = p.id
        INNER JOIN receipt AS rt ON rt.id = t.receipt_id
        LEFT JOIN return_coupon as rc ON rc.receipt_id = rt.id
        INNER JOIN products ON r.prod_id = products.id
        WHERE DATE(r.date) BETWEEN :startDate AND :endDate ';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;
        } else if ( $selectedProduct && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT r.id  AS refunded_id,r.refunded_method_id as method, p.id AS payment_id, products.prod_desc AS prod_desc,rc.qrNumber as qrNumber,
            r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, products.barcode as barcode,products.sku as sku,
            r.date AS date, r.refunded_method_id AS method, t.receipt_id AS receipt_id,r.otherDetails as otherDetails
        FROM refunded AS r
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN (
            SELECT DISTINCT payment_id, receipt_id
            FROM transactions
        ) AS t ON t.payment_id = p.id
        INNER JOIN receipt AS rt ON rt.id = t.receipt_id
        LEFT JOIN return_coupon as rc ON rc.receipt_id = rt.id
        INNER JOIN products ON r.prod_id = products.id
        WHERE r.prod_id = :selectedProduct AND DATE(r.date) = :singleDateData';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedProduct', $selectedProduct );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;

        } else if ( $selectedProduct && !$singleDateData && $startDate && $endDate ) {
            $sql = 'SELECT r.id  AS refunded_id,r.refunded_method_id as method, p.id AS payment_id, products.prod_desc AS prod_desc,rc.qrNumber as qrNumber,
        r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, products.barcode as barcode,products.sku as sku,
        r.date AS date, r.refunded_method_id AS method, t.receipt_id AS receipt_id,r.otherDetails as otherDetails
        FROM refunded AS r
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN (
            SELECT DISTINCT payment_id, receipt_id
            FROM transactions
        ) AS t ON t.payment_id = p.id
        INNER JOIN receipt AS rt ON rt.id = t.receipt_id
        LEFT JOIN return_coupon as rc ON rc.receipt_id = rt.id
        INNER JOIN products ON r.prod_id = products.id 
        WHERE r.prod_id = :selectedProduct AND DATE(r.date) BETWEEN :startDate AND :endDate';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedProduct', $selectedProduct );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;
        } else {
            $sql = 'SELECT r.id  AS refunded_id,r.refunded_method_id as method, p.id AS payment_id, products.prod_desc AS prod_desc,rc.qrNumber as qrNumber,
        r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, products.barcode as barcode,products.sku as sku,
        r.date AS date, r.refunded_method_id AS method, t.receipt_id AS receipt_id,r.otherDetails as otherDetails
    FROM refunded AS r
    INNER JOIN payments AS p ON r.payment_id = p.id 
    INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id
        FROM transactions
    ) AS t ON t.payment_id = p.id
    INNER JOIN receipt AS rt ON rt.id = t.receipt_id
    LEFT JOIN return_coupon as rc ON rc.receipt_id = rt.id
    INNER JOIN products ON r.prod_id = products.id;';
            $stmt = $this->connect()->query( $sql );
            return $stmt;
        }
    }

    public function getRefundByCustomers( $selectedCustomers, $singleDateData, $startDate, $endDate, $selectedRefundTypes ) {
        if ( $selectedCustomers && !$singleDateData && !$startDate && !$endDate && !$selectedRefundTypes ) {
            $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id, r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
          INNER JOIN payments AS p ON r.payment_id = p.id 
          INNER JOIN products ON r.prod_id = products.id 
          INNER JOIN transactions AS t ON t.payment_id = p.id 
          INNER JOIN users AS u ON t.user_id = u.id WHERE t.user_id = :selectedCustomers';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedCustomers', $selectedCustomers );
            $sql->execute();
            return $sql;

        } else if ( !$selectedCustomers && $singleDateData && !$startDate && !$endDate  && !$selectedRefundTypes ) {
            $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id, r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        INNER JOIN transactions AS t ON t.payment_id = p.id 
        INNER JOIN users AS u ON t.user_id = u.id WHERE DATE(r.date) = :singleDateData';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;
        } else if ( !$selectedCustomers && !$singleDateData && $startDate && $endDate  && !$selectedRefundTypes ) {
            $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id, r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        INNER JOIN transactions AS t ON t.payment_id = p.id 
        INNER JOIN users AS u ON t.user_id = u.id WHERE DATE(r.date) BETWEEN :startDate AND :endDate';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;
        } else if ( $selectedCustomers && $singleDateData && !$startDate && !$endDate  && !$selectedRefundTypes ) {
            $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id,  r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        INNER JOIN transactions AS t ON t.payment_id = p.id 
        INNER JOIN users AS u ON t.user_id = u.id WHERE t.user_id = :selectedCustomers AND DATE(r.date) = :singleDateData';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->bindParam( ':selectedCustomers', $selectedCustomers );
            $sql->execute();
            return $sql;
        } else if ( $selectedCustomers && !$singleDateData && $startDate && $endDate  && !$selectedRefundTypes ) {
            $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id,  r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        INNER JOIN transactions AS t ON t.payment_id = p.id 
        INNER JOIN users AS u ON t.user_id = u.id WHERE t.user_id = :selectedCustomers AND DATE(r.date) BETWEEN :startDate AND :endDate';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedCustomers', $selectedCustomers );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;
        } else if ( !$selectedCustomers && !$singleDateData && !$startDate && !$endDate  && $selectedRefundTypes ) {
            $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id,  r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        INNER JOIN transactions AS t ON t.payment_id = p.id 
        INNER JOIN users AS u ON t.user_id = u.id WHERE r.refunded_method_id = :selectedRefundTypes';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedRefundTypes',  $selectedRefundTypes );
            $sql->execute();
            return $sql;
        } else if ( $selectedCustomers && !$singleDateData && !$startDate && !$endDate  && $selectedRefundTypes ) {
            $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id,  r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        INNER JOIN transactions AS t ON t.payment_id = p.id 
        INNER JOIN users AS u ON t.user_id = u.id WHERE t.user_id = :selectedCustomers AND r.refunded_method_id = :selectedRefundTypes';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedRefundTypes',  $selectedRefundTypes );
            $sql->bindParam( ':selectedCustomers', $selectedCustomers );
            $sql->execute();
            return $sql;
        } else if ( !$selectedCustomers && $singleDateData && !$startDate && !$endDate  && $selectedRefundTypes ) {
            $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id,  r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        INNER JOIN transactions AS t ON t.payment_id = p.id 
        INNER JOIN users AS u ON t.user_id = u.id WHERE DATE(r.date) = :singleDateData AND r.refunded_method_id = :selectedRefundTypes';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedRefundTypes',  $selectedRefundTypes );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;
        } else if ( !$selectedCustomers && !$singleDateData && $startDate && $endDate  && $selectedRefundTypes ) {
            $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id,  r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        INNER JOIN transactions AS t ON t.payment_id = p.id 
        INNER JOIN users AS u ON t.user_id = u.id WHERE DATE(r.date) BETWEEN :startDate AND :endDate AND r.refunded_method_id = :selectedRefundTypes';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedRefundTypes',  $selectedRefundTypes );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;
        } else if ( $selectedCustomers && $singleDateData && !$startDate && !$endDate  && $selectedRefundTypes ) {
            $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id,  r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        INNER JOIN transactions AS t ON t.payment_id = p.id 
        INNER JOIN users AS u ON t.user_id = u.id WHERE t.user_id = :selectedCustomers AND DATE(r.date) = :singleDateData AND r.refunded_method_id = :selectedRefundTypes';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedRefundTypes',  $selectedRefundTypes );
            $sql->bindParam( ':selectedCustomers', $selectedCustomers );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;
        } else if ( $selectedCustomers && !$singleDateData && $startDate && $endDate  && $selectedRefundTypes ) {
            $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id,  r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        INNER JOIN transactions AS t ON t.payment_id = p.id 
        INNER JOIN users AS u ON t.user_id = u.id WHERE t.user_id = :selectedCustomers AND DATE(r.date) BETWEEN :startDate AND :endDate AND r.refunded_method_id = :selectedRefundTypes';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedRefundTypes',  $selectedRefundTypes );
            $sql->bindParam( ':selectedCustomers', $selectedCustomers );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;
        } else {
            $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id,  r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r INNER JOIN payments AS p ON r.payment_id = p.id INNER JOIN products ON r.prod_id = products.id INNER JOIN transactions AS t ON t.payment_id = p.id INNER JOIN users AS u ON t.user_id = u.id';
            $stmt = $this->connect()->query( $sql );
            return $stmt;
        }
    }

    public function getReturnAndEx( $selectedProduct, $singleDateData, $startDate, $endDate ) {
        if ( $selectedProduct && !$singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT r.id AS return_id, p.id AS payment_id, products.prod_desc AS prod_desc, products.barcode as barcode, products.sku as sku,
          SUM(r.return_qty) AS qty, r.date AS date,
          products.prod_price AS prod_price, SUM(r.return_amount) AS amount,
          (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id,r.otherDetails as otherDetails
            FROM return_exchange AS r
            INNER JOIN payments AS p ON r.payment_id = p.id 
            INNER JOIN products ON r.product_id = products.id
            WHERE r.product_id = :selectedProduct
            GROUP BY p.id, products.id';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedProduct', $selectedProduct );
            $sql->execute();
            return $sql;

        } else if ( !$selectedProduct && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT r.id AS return_id, p.id AS payment_id, products.prod_desc AS prod_desc, products.barcode as barcode, products.sku as sku,
          SUM(r.return_qty) AS qty, r.date AS date,
          products.prod_price AS prod_price,SUM(r.return_amount) AS amount,
          (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id,r.otherDetails as otherDetails
            FROM return_exchange AS r
            INNER JOIN payments AS p ON r.payment_id = p.id 
            INNER JOIN products ON r.product_id = products.id
            WHERE DATE(r.date) = :singleDateData
            GROUP BY p.id, products.id';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;
        } else if ( !$selectedProduct && !$singleDateData && $startDate && $endDate ) {
            $sql = 'SELECT r.id AS return_id, p.id AS payment_id, products.prod_desc AS prod_desc, products.barcode as barcode, products.sku as sku,
          SUM(r.return_qty) AS qty, r.date AS date,
          products.prod_price AS prod_price, SUM(r.return_amount) AS amount,
          (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id,r.otherDetails as otherDetails
            FROM return_exchange AS r
            INNER JOIN payments AS p ON r.payment_id = p.id 
            INNER JOIN products ON r.product_id = products.id
            WHERE DATE(r.date) BETWEEN :startDate AND :endDate 
            GROUP BY p.id, products.id';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;
        } else if ( $selectedProduct && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT r.id AS return_id, p.id AS payment_id, products.prod_desc AS prod_desc, products.barcode as barcode, products.sku as sku,
          SUM(r.return_qty) AS qty, r.date AS date,
          products.prod_price AS prod_price,SUM(r.return_amount) AS amount,
          (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id,r.otherDetails as otherDetails
            FROM return_exchange AS r
            INNER JOIN payments AS p ON r.payment_id = p.id 
            INNER JOIN products ON r.product_id = products.id
            WHERE r.product_id = :selectedProduct AND DATE(r.date) = :singleDateData 
            GROUP BY p.id, products.id';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedProduct', $selectedProduct );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;
        } else if ( $selectedProduct && !$singleDateData && $startDate && $endDate ) {
            $sql = 'SELECT r.id AS return_id, p.id AS payment_id, products.prod_desc AS prod_desc, products.barcode as barcode, products.sku as sku,
          SUM(r.return_qty) AS qty, r.date AS date,
          products.prod_price AS prod_price, SUM(r.return_amount) AS amount,
          (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id
            FROM return_exchange AS r
            INNER JOIN payments AS p ON r.payment_id = p.id 
            INNER JOIN products ON r.product_id = products.id
            WHERE  r.product_id = :selectedProduct AND DATE(r.date) BETWEEN :startDate AND :endDate
            GROUP BY P.id, products.id';
            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedProduct', $selectedProduct );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;
        } else {

            $sql = "SELECT r.id AS return_id, p.id AS payment_id, products.prod_desc AS prod_desc, products.barcode as barcode, products.sku as sku,
        SUM(r.return_qty) AS qty, r.date AS date,
        products.prod_price AS prod_price,  SUM(r.return_amount) AS amount,
        (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id,r.otherDetails as otherDetails
        FROM return_exchange AS r
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.product_id = products.id
        GROUP BY p.id, products.id";

            $stmt = $this->connect()->query( $sql );
            return $stmt;
        }
    }

    public function getReturnExchangeCustomers( $selectedCustomers, $singleDateData, $startDate, $endDate ) {
        if ( $selectedCustomers && !$singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT DISTINCT r.id AS return_id, p.id AS payment_id, r.return_qty AS qty,products.prod_price as prod_price, (r.return_qty* products.prod_price) as return_amount, r.date AS date, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM return_exchange AS r 
      INNER JOIN payments AS p ON r.payment_id = p.id 
      INNER JOIN products ON r.product_id = products.id 
      INNER JOIN transactions AS t ON t.payment_id = p.id 
      INNER JOIN users AS u ON t.user_id = u.id  WHERE t.user_id = :selectedCustomers';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedCustomers', $selectedCustomers );
            $sql->execute();
            return $sql;

        } else if ( !$selectedCustomers && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT DISTINCT r.id AS return_id, p.id AS payment_id, r.return_qty AS qty,products.prod_price as prod_price, (r.return_qty* products.prod_price) as return_amount, r.date AS date, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM return_exchange AS r 
      INNER JOIN payments AS p ON r.payment_id = p.id 
      INNER JOIN products ON r.product_id = products.id 
      INNER JOIN transactions AS t ON t.payment_id = p.id 
      INNER JOIN users AS u ON t.user_id = u.id WHERE DATE(r.date) = :singleDateData';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;

        } else if ( !$selectedCustomers && !$singleDateData && $startDate && $endDate ) {
            $sql = 'SELECT DISTINCT r.id AS return_id, p.id AS payment_id, r.return_qty AS qty,products.prod_price as prod_price, (r.return_qty* products.prod_price) as return_amount, r.date AS date, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM return_exchange AS r 
      INNER JOIN payments AS p ON r.payment_id = p.id 
      INNER JOIN products ON r.product_id = products.id 
      INNER JOIN transactions AS t ON t.payment_id = p.id 
      INNER JOIN users AS u ON t.user_id = u.id  WHERE DATE(r.date) BETWEEN :startDate AND :endDate';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;

        } else if ( $selectedCustomers && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT DISTINCT r.id AS return_id, p.id AS payment_id, r.return_qty AS qty,products.prod_price as prod_price, (r.return_qty* products.prod_price) as return_amount, r.date AS date, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM return_exchange AS r 
      INNER JOIN payments AS p ON r.payment_id = p.id 
      INNER JOIN products ON r.product_id = products.id 
      INNER JOIN transactions AS t ON t.payment_id = p.id 
      INNER JOIN users AS u ON t.user_id = u.id WHERE t.user_id = :selectedCustomers AND DATE(r.date) = :singleDateData';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->bindParam( ':selectedCustomers', $selectedCustomers );
            $sql->execute();
            return $sql;
        } else if ( $selectedCustomers && !$singleDateData && $startDate && $endDate ) {
            $sql = 'SELECT DISTINCT r.id AS return_id, p.id AS payment_id, r.return_qty AS qty,products.prod_price as prod_price, (r.return_qty* products.prod_price) as return_amount, r.date AS date, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM return_exchange AS r 
      INNER JOIN payments AS p ON r.payment_id = p.id 
      INNER JOIN products ON r.product_id = products.id 
      INNER JOIN transactions AS t ON t.payment_id = p.id 
      INNER JOIN users AS u ON t.user_id = u.id  WHERE t.user_id = :selectedCustomers AND DATE(r.date) BETWEEN :startDate AND :endDate';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedCustomers', $selectedCustomers );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;
        } else {
            $sql = 'SELECT DISTINCT r.id AS return_id, p.id AS payment_id, r.return_qty AS qty,products.prod_price as prod_price, (r.return_qty* products.prod_price) as return_amount, r.date AS date, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM return_exchange AS r INNER JOIN payments AS p ON r.payment_id = p.id INNER JOIN products ON r.product_id = products.id INNER JOIN transactions AS t ON t.payment_id = p.id INNER JOIN users AS u ON t.user_id = u.id';
            $stmt = $this->connect()->query( $sql );
            return $stmt;

        }
    }

    public function getBOMData( $selectedProduct, $selectedIngredients ) {
        if ( $selectedProduct && !$selectedIngredients ) {
            $sql = 'SELECT bom.id as id, p.prod_desc as prod_desc, i.name as name, u.uom_name as uom_name, bom.qty as qty
      FROM `bill_of_materials` as bom 
      INNER JOIN products as p ON p.id = bom.prod_id 
      INNER JOIN ingredients AS i ON i.id = bom.ingredients_id
      LEFT JOIN uom as u ON u.id = i.uom_id WHERE bom.prod_id = :selectedProduct';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedProduct', $selectedProduct );
            $sql->execute();
            return $sql;
        } else if ( !$selectedProduct && $selectedIngredients ) {
            $sql = 'SELECT bom.id as id, p.prod_desc as prod_desc, i.name as name, u.uom_name as uom_name, bom.qty as qty
      FROM `bill_of_materials` as bom 
      INNER JOIN products as p ON p.id = bom.prod_id 
      INNER JOIN ingredients AS i ON i.id = bom.ingredients_id
      LEFT JOIN uom as u ON u.id = i.uom_id WHERE bom.ingredients_id = :selectedIngredients';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedIngredients', $selectedIngredients );
            $sql->execute();
            return $sql;

        } else if ( $selectedProduct && $selectedIngredients ) {
            $sql = 'SELECT bom.id as id, p.prod_desc as prod_desc, i.name as name, u.uom_name as uom_name, bom.qty as qty
      FROM `bill_of_materials` as bom 
      INNER JOIN products as p ON p.id = bom.prod_id 
      INNER JOIN ingredients AS i ON i.id = bom.ingredients_id
      LEFT JOIN uom as u ON u.id = i.uom_id WHERE bom.prod_id = :selectedProduct AND bom.ingredients_id = :selectedIngredients';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedIngredients', $selectedIngredients );
            $sql->bindParam( ':selectedProduct', $selectedProduct );
            $sql->execute();
            return $sql;

        } else {
            $sql = 'SELECT bom.id as id, p.prod_desc as prod_desc, i.name as name, u.uom_name as uom_name, bom.qty as qty
    FROM `bill_of_materials` as bom 
    INNER JOIN products as p ON p.id = bom.prod_id 
    INNER JOIN ingredients AS i ON i.id = bom.ingredients_id
    LEFT JOIN uom as u ON u.id = i.uom_id';
            $stmt = $this->connect()->query( $sql );
            return $stmt;
        }
    }

    public function getCustomersData( $customerId ) {

        if ( $customerId ) {
            $sql = 'SELECT u.first_name as first_name, u.last_name as last_name, c.contact as contact, c.email as email, d.name as name, d.discount_amount as rate 
      FROM `customer` as c 
      RIGHT JOIN users as u on u.id = c.user_id 
      LEFT JOIN discounts AS d ON d.id = u.discount_id WHERE u.role_id = 4 AND u.id = :customerId ';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':customerId', $customerId );
            $sql->execute();
            return $sql;

        } else {

            $sql = 'SELECT u.first_name as first_name, u.last_name as last_name, c.contact as contact, c.email as email, d.name as name, d.discount_amount as rate 
      FROM `customer` as c 
      RIGHT JOIN users as u on u.id = c.user_id 
      LEFT JOIN discounts AS d ON d.id = u.discount_id WHERE u.role_id = 4;';
            $stmt = $this->connect()->query( $sql );
            return $stmt;
        }
    }
    // public function voidedItemsData() {
    //   $sql = 'SELECT p.prod_desc as prod_desc, us.first_name as c_first_name, us.last_name as c_last_name, u.first_name as u_first_name, u.last_name as u_last_name, t.prod_qty as prod_qty,t.prod_price as prod_price, t.subtotal as totalAmount, t.is_void as paidStatus, py.date_time_of_payment as paymentDate FROM `transactions` as t LEFT JOIN products as p ON t.prod_id = p.id RIGHT JOIN payments as py ON py.id = t.payment_id INNER JOIN users as u ON u.id = t.user_id INNER JOIN users as us ON t.cashier_id = us.id WHERE t.is_void = 2;';
    //   $stmt = $this->connect()->query( $sql );
    //   return $stmt;
    // }

    public function cashInAmountsData( $userId, $singleDateData, $startDate, $endDate,$entries ) {
        if($entries == "in"){
        if ( $userId && !$singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT c.cash_in_amount as amount,c.reason_note as note,c.date as date, u.first_name as first_name, u.last_name as last_name
      FROM cash_in_out as c 
      INNER JOIN users as u ON u.id = c.user_id 
      WHERE cashType = 0 AND u.id = :userId';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':userId', $userId );
            $sql->execute();
            return $sql;

        } else if ( !$userId && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT c.cash_in_amount as amount,c.reason_note as note,c.date as date, u.first_name as first_name, u.last_name as last_name
      FROM cash_in_out as c 
      INNER JOIN users as u ON u.id = c.user_id 
      WHERE cashType = 0  AND DATE(c.date) = :singleDateData';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;

        } else if ( !$userId && !$singleDateData && $startDate && $endDate ) {
            $sql = 'SELECT c.cash_in_amount as amount,c.reason_note as note,c.date as date, u.first_name as first_name, u.last_name as last_name
      FROM cash_in_out as c 
      INNER JOIN users as u ON u.id = c.user_id 
      WHERE cashType = 0  AND DATE(c.date) BETWEEN :startDate AND :endDate';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;

        } else if ( $userId && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT c.cash_in_amount as amount,c.reason_note as note,c.date as date, u.first_name as first_name, u.last_name as last_name
      FROM cash_in_out as c 
      INNER JOIN users as u ON u.id = c.user_id 
      WHERE cashType = 0 AND u.id = :userId AND DATE(c.date) = :singleDateData';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':userId', $userId );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;

        } else if ( $userId && !$singleDateData && $startDate && $endDate ) {
            $sql = 'SELECT c.cash_in_amount as amount,c.reason_note as note,c.date as date, u.first_name as first_name, u.last_name as last_name
      FROM cash_in_out as c 
      INNER JOIN users as u ON u.id = c.user_id 
      WHERE cashType = 0 AND u.id = :userId AND DATE(c.date) BETWEEN :startDate AND :endDate';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':userId', $userId );

            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;

        } else {
            $sql = 'SELECT c.cash_in_amount as amount,c.reason_note as note,c.date as date, u.first_name as first_name, u.last_name as last_name FROM cash_in_out as c INNER JOIN users as u ON u.id = c.user_id WHERE cashType = 0';
            $stmt = $this->connect()->query( $sql );
            return $stmt;
        }
    }else{
        if ( $userId && !$singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT c.cash_out_amount as amount,c.reason_note as note,c.date as date, u.first_name as first_name, u.last_name as last_name
      FROM cash_in_out as c 
      INNER JOIN users as u ON u.id = c.user_id 
      WHERE cashType = 1 AND u.id = :userId';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':userId', $userId );
            $sql->execute();
            return $sql;

        } else if ( !$userId && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT c.cash_out_amount as amount,c.reason_note as note,c.date as date, u.first_name as first_name, u.last_name as last_name
      FROM cash_in_out as c 
      INNER JOIN users as u ON u.id = c.user_id 
      WHERE cashType = 1  AND DATE(c.date) = :singleDateData';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;

        } else if ( !$userId && !$singleDateData && $startDate && $endDate ) {
            $sql = 'SELECT c.cash_out_amount as amount,c.reason_note as note,c.date as date, u.first_name as first_name, u.last_name as last_name
      FROM cash_in_out as c 
      INNER JOIN users as u ON u.id = c.user_id 
      WHERE cashType = 1  AND DATE(c.date) BETWEEN :startDate AND :endDate';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;

        } else if ( $userId && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT c.cash_out_amount as amount,c.reason_note as note,c.date as date, u.first_name as first_name, u.last_name as last_name
      FROM cash_in_out as c 
      INNER JOIN users as u ON u.id = c.user_id 
      WHERE cashType = 1 AND u.id = :userId AND DATE(c.date) = :singleDateData';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':userId', $userId );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;

        } else if ( $userId && !$singleDateData && $startDate && $endDate ) {
            $sql = 'SELECT c.cash_out_amount as amount,c.reason_note as note,c.date as date, u.first_name as first_name, u.last_name as last_name
      FROM cash_in_out as c 
      INNER JOIN users as u ON u.id = c.user_id 
      WHERE cashType = 1 AND u.id = :userId AND DATE(c.date) BETWEEN :startDate AND :endDate';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':userId', $userId );

            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;

        } else {
            $sql = 'SELECT c.cash_out_amount as amount,c.reason_note as note,c.date as date, u.first_name as first_name, u.last_name as last_name FROM cash_in_out as c INNER JOIN users as u ON u.id = c.user_id WHERE cashType = 1';
            $stmt = $this->connect()->query( $sql );
            return $stmt;
        } 
        
    }
    }
    public function getUnpaidSales( $selectedCustomers, $userId, $singleDateData, $startDate, $endDate ) {
        if ( $selectedCustomers && !$userId && !$singleDateData && !$startDate && !$endDate ) {
            $sql = 'WITH TotalPaid AS (
        SELECT 
            receipt_id,
            COALESCE(SUM(paid_amount), 0) AS total_paid_amount
        FROM 
            paid_credits 
        GROUP BY 
            receipt_id
    )
    SELECT 
        u.first_name AS first_name,
        u.last_name AS last_name,
        t.user_id,
        cust.code as code,
        cust.type as type,
        SUM(IFNULL(tp.total_paid_amount, 0)) AS total_paid_amount,
        SUM(COALESCE(p.creditTotal, 0)) AS credit_amount,
        SUM(COALESCE(p.creditTotal, 0)) - SUM(IFNULL(tp.total_paid_amount, 0)) AS balance
    FROM 
        payments AS p 
    RIGHT JOIN 
        (
            SELECT 
                payment_id, 
                user_id, 
                cashier_id,
                MAX(receipt_id) AS receipt_id
            FROM 
                transactions 
            GROUP BY 
                payment_id
        ) AS t ON p.id = t.payment_id 
    LEFT JOIN 
        receipt AS r ON r.id = t.receipt_id 
    INNER JOIN 
        users AS u ON u.id = t.user_id 
    INNER JOIN customer as cust ON u.id = cust.user_id
    INNER JOIN 
        users AS c ON c.id = t.cashier_id
    LEFT JOIN 
        TotalPaid AS tp ON tp.receipt_id = r.id
    WHERE 
        COALESCE(p.creditTotal, 0) != 0
        AND (COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0) ) != 0 AND t.user_id = :customerId
    GROUP BY
        u.first_name, u.last_name,t.user_id,cust.type ORDER BY u.first_name ASC';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':customerId', $selectedCustomers );
            $sql->execute();
            return $sql;

        } else if ( !$selectedCustomers && !$userId && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'WITH TotalPaid AS (
        SELECT 
            receipt_id,
            COALESCE(SUM(paid_amount), 0) AS total_paid_amount
        FROM 
            paid_credits 
        GROUP BY 
            receipt_id
    )
    SELECT 
        u.first_name AS first_name,
        u.last_name AS last_name,
        t.user_id,
        cust.code as code,
        cust.type as type,
        SUM(IFNULL(tp.total_paid_amount, 0)) AS total_paid_amount,
        SUM(COALESCE(p.creditTotal, 0)) AS credit_amount,
        SUM(COALESCE(p.creditTotal, 0)) - SUM(IFNULL(tp.total_paid_amount, 0)) AS balance
    FROM 
        payments AS p 
    RIGHT JOIN 
        (
            SELECT 
                payment_id, 
                user_id, 
                cashier_id,
                MAX(receipt_id) AS receipt_id
            FROM 
                transactions 
            GROUP BY 
                payment_id
        ) AS t ON p.id = t.payment_id 
    LEFT JOIN 
        receipt AS r ON r.id = t.receipt_id 
    INNER JOIN 
        users AS u ON u.id = t.user_id 
    INNER JOIN customer as cust ON u.id = cust.user_id
    INNER JOIN 
        users AS c ON c.id = t.cashier_id
    LEFT JOIN 
        TotalPaid AS tp ON tp.receipt_id = r.id
    WHERE 
        COALESCE(p.creditTotal, 0) != 0
        AND (COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0) ) != 0 AND DATE(p.date_time_of_payment) = :singleDateData
    GROUP BY
         u.first_name, u.last_name,  t.user_id,cust.type ORDER BY u.first_name ASC';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;
        } else if ( !$selectedCustomers && !$userId && !$singleDateData && $startDate && $endDate ) {
            $sql = 'WITH TotalPaid AS (
        SELECT 
            receipt_id,
            COALESCE(SUM(paid_amount), 0) AS total_paid_amount
        FROM 
            paid_credits 
        GROUP BY 
            receipt_id
    )
    SELECT 
        u.first_name AS first_name,
        u.last_name AS last_name,
        t.user_id,
        cust.code as code,
        cust.type as type,
        SUM(IFNULL(tp.total_paid_amount, 0)) AS total_paid_amount,
        SUM(COALESCE(p.creditTotal, 0)) AS credit_amount,
        SUM(COALESCE(p.creditTotal, 0)) - SUM(IFNULL(tp.total_paid_amount, 0)) AS balance
    FROM 
        payments AS p 
    RIGHT JOIN 
        (
            SELECT 
                payment_id, 
                user_id, 
                cashier_id,
                MAX(receipt_id) AS receipt_id
            FROM 
                transactions 
            GROUP BY 
                payment_id
        ) AS t ON p.id = t.payment_id 
    LEFT JOIN 
        receipt AS r ON r.id = t.receipt_id 
    INNER JOIN 
        users AS u ON u.id = t.user_id 
    INNER JOIN customer as cust ON u.id = cust.user_id
    INNER JOIN 
        users AS c ON c.id = t.cashier_id
    LEFT JOIN 
        TotalPaid AS tp ON tp.receipt_id = r.id
    WHERE 
        COALESCE(p.creditTotal, 0) != 0
        AND (COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0) ) != 0 AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate
    GROUP BY
        u.first_name, u.last_name, t.user_id,cust.type ORDER BY u.first_name ASC';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;
        } else if ( $selectedCustomers && !$userId && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'WITH TotalPaid AS (
        SELECT 
            receipt_id,
            COALESCE(SUM(paid_amount), 0) AS total_paid_amount
        FROM 
            paid_credits 
        GROUP BY 
            receipt_id
    )
    SELECT 
        u.first_name AS first_name,
        u.last_name AS last_name,
        t.user_id,
        cust.code as code,
        cust.type as type,
        SUM(IFNULL(tp.total_paid_amount, 0)) AS total_paid_amount,
        SUM(COALESCE(p.creditTotal, 0)) AS credit_amount,
        SUM(COALESCE(p.creditTotal, 0)) - SUM(IFNULL(tp.total_paid_amount, 0)) AS balance
    FROM 
        payments AS p 
    RIGHT JOIN 
        (
            SELECT 
                payment_id, 
                user_id, 
                cashier_id,
                MAX(receipt_id) AS receipt_id
            FROM 
                transactions 
            GROUP BY 
                payment_id
        ) AS t ON p.id = t.payment_id 
    LEFT JOIN 
        receipt AS r ON r.id = t.receipt_id 
    INNER JOIN 
        users AS u ON u.id = t.user_id 
    INNER JOIN customer as cust ON u.id = cust.user_id
    INNER JOIN 
        users AS c ON c.id = t.cashier_id
    LEFT JOIN 
        TotalPaid AS tp ON tp.receipt_id = r.id
    WHERE 
        COALESCE(p.creditTotal, 0) != 0
        AND (COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0) ) != 0 AND t.user_id = :customerId AND DATE(p.date_time_of_payment) = :singleDateData
    GROUP BY
        u.first_name, u.last_name, t.user_id,cust.type ORDER BY u.first_name ASC';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':customerId', $selectedCustomers );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;

        } else if ( $selectedCustomers && !$userId && !$singleDateData && $startDate && $endDate ) {
            $sql = 'WITH TotalPaid AS (
        SELECT 
            receipt_id,
            COALESCE(SUM(paid_amount), 0) AS total_paid_amount
        FROM 
            paid_credits 
        GROUP BY 
            receipt_id
    )
    SELECT 
        u.first_name AS first_name,
        u.last_name AS last_name,
        t.user_id,
        cust.code as code,
        cust.type as type,
        SUM(IFNULL(tp.total_paid_amount, 0)) AS total_paid_amount,
        SUM(COALESCE(p.creditTotal, 0)) AS credit_amount,
        SUM(COALESCE(p.creditTotal, 0)) - SUM(IFNULL(tp.total_paid_amount, 0)) AS balance
    FROM 
        payments AS p 
    RIGHT JOIN 
        (
            SELECT 
                payment_id, 
                user_id, 
                cashier_id,
                MAX(receipt_id) AS receipt_id
            FROM 
                transactions 
            GROUP BY 
                payment_id
        ) AS t ON p.id = t.payment_id 
    LEFT JOIN 
        receipt AS r ON r.id = t.receipt_id 
    INNER JOIN 
        users AS u ON u.id = t.user_id 
    INNER JOIN customer as cust ON u.id = cust.user_id
    INNER JOIN 
        users AS c ON c.id = t.cashier_id
    LEFT JOIN 
        TotalPaid AS tp ON tp.receipt_id = r.id
    WHERE 
        COALESCE(p.creditTotal, 0) != 0
        AND (COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0) ) != 0 AND t.user_id = :customerId  AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate
     GROUP BY
        u.first_name, u.last_name,  t.user_id,cust.type ORDER BY u.first_name ASC';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->bindParam( ':customerId', $selectedCustomers );
            $sql->execute();
            return $sql;
        } else if ( !$selectedCustomers && $userId && !$singleDateData && !$startDate && !$endDate ) {
            $sql = 'WITH TotalPaid AS (
        SELECT 
            receipt_id,
            COALESCE(SUM(paid_amount), 0) AS total_paid_amount
        FROM 
            paid_credits 
        GROUP BY 
            receipt_id
    )
    SELECT 
        u.first_name AS first_name,
        u.last_name AS last_name,
        t.user_id,
        cust.code as code,
        cust.type as type,
        SUM(IFNULL(tp.total_paid_amount, 0)) AS total_paid_amount,
        SUM(COALESCE(p.creditTotal, 0)) AS credit_amount,
        SUM(COALESCE(p.creditTotal, 0)) - SUM(IFNULL(tp.total_paid_amount, 0)) AS balance
    FROM 
        payments AS p 
    RIGHT JOIN 
        (
            SELECT 
                payment_id, 
                user_id, 
                cashier_id,
                MAX(receipt_id) AS receipt_id
            FROM 
                transactions 
            GROUP BY 
                payment_id
        ) AS t ON p.id = t.payment_id 
    LEFT JOIN 
        receipt AS r ON r.id = t.receipt_id 
    INNER JOIN 
        users AS u ON u.id = t.user_id 
    INNER JOIN customer as cust ON u.id = cust.user_id
    INNER JOIN 
        users AS c ON c.id = t.cashier_id
    LEFT JOIN 
        TotalPaid AS tp ON tp.receipt_id = r.id
    WHERE 
        COALESCE(p.creditTotal, 0) != 0
        AND (COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0) ) != 0 AND t.cashier_id = :userId
    GROUP BY
         u.first_name, u.last_name,t.user_id,cust.type ORDER BY u.first_name ASC';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':userId',  $userId );
            $sql->execute();
            return $sql;

        } else if ( !$selectedCustomers && $userId && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'WITH TotalPaid AS (
        SELECT 
            receipt_id,
            COALESCE(SUM(paid_amount), 0) AS total_paid_amount
        FROM 
            paid_credits 
        GROUP BY 
            receipt_id
    )
    SELECT 
        u.first_name AS first_name,
        u.last_name AS last_name,
        t.user_id,
        cust.code as code,
        cust.type as type,
        SUM(IFNULL(tp.total_paid_amount, 0)) AS total_paid_amount,
        SUM(COALESCE(p.creditTotal, 0)) AS credit_amount,
        SUM(COALESCE(p.creditTotal, 0)) - SUM(IFNULL(tp.total_paid_amount, 0)) AS balance
    FROM 
        payments AS p 
    RIGHT JOIN 
        (
            SELECT 
                payment_id, 
                user_id, 
                cashier_id,
                MAX(receipt_id) AS receipt_id
            FROM 
                transactions 
            GROUP BY 
                payment_id
        ) AS t ON p.id = t.payment_id 
    LEFT JOIN 
        receipt AS r ON r.id = t.receipt_id 
    INNER JOIN 
        users AS u ON u.id = t.user_id 
    INNER JOIN customer as cust ON u.id = cust.user_id
    INNER JOIN 
        users AS c ON c.id = t.cashier_id
    LEFT JOIN 
        TotalPaid AS tp ON tp.receipt_id = r.id
    WHERE 
        COALESCE(p.creditTotal, 0) != 0
        AND (COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0) ) != 0 AND t.cashier_id = :userId AND DATE(p.date_time_of_payment) = :singleDateData
    GROUP BY
        u.first_name, u.last_name, t.user_id,cust.type ORDER BY u.first_name ASC';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':userId',  $userId );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;

        } else if ( !$selectedCustomers && $userId && !$singleDateData && $startDate && $endDate ) {
            $sql = 'WITH TotalPaid AS (
        SELECT 
            receipt_id,
            COALESCE(SUM(paid_amount), 0) AS total_paid_amount
        FROM 
            paid_credits 
        GROUP BY 
            receipt_id
    )
    SELECT 
        u.first_name AS first_name,
        u.last_name AS last_name,
        t.user_id,
        cust.code as code,
        cust.type as type,
        SUM(IFNULL(tp.total_paid_amount, 0)) AS total_paid_amount,
        SUM(COALESCE(p.creditTotal, 0)) AS credit_amount,
        SUM(COALESCE(p.creditTotal, 0)) - SUM(IFNULL(tp.total_paid_amount, 0)) AS balance
    FROM 
        payments AS p 
    RIGHT JOIN 
        (
            SELECT 
                payment_id, 
                user_id, 
                cashier_id,
                MAX(receipt_id) AS receipt_id
            FROM 
                transactions 
            GROUP BY 
                payment_id
        ) AS t ON p.id = t.payment_id 
    LEFT JOIN 
        receipt AS r ON r.id = t.receipt_id 
    INNER JOIN 
        users AS u ON u.id = t.user_id 
    INNER JOIN customer as cust ON u.id = cust.user_id
    INNER JOIN 
        users AS c ON c.id = t.cashier_id
    LEFT JOIN 
        TotalPaid AS tp ON tp.receipt_id = r.id
    WHERE 
        COALESCE(p.creditTotal, 0) != 0
        AND (COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0) ) != 0 AND t.cashier_id = :userId AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate
    GROUP BY
        u.first_name, u.last_name,t.user_id,cust.type ORDER BY u.first_name ASC';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->bindParam( ':userId',  $userId );
            $sql->execute();
            return $sql;
        } else {
            $sql = 'WITH TotalPaid AS (
            SELECT 
                receipt_id,
                COALESCE(SUM(paid_amount), 0) AS total_paid_amount
            FROM 
                paid_credits 
            GROUP BY 
                receipt_id
        )
        SELECT 
            u.first_name AS first_name,
            u.last_name AS last_name,
            t.user_id,
            cust.code as code,
            cust.type as type,
            SUM(IFNULL(tp.total_paid_amount, 0)) AS total_paid_amount,
            SUM(COALESCE(p.creditTotal, 0)) AS credit_amount,
            SUM(COALESCE(p.creditTotal, 0)) - SUM(IFNULL(tp.total_paid_amount, 0)) AS balance
        FROM 
            payments AS p 
        RIGHT JOIN 
            (
                SELECT 
                    payment_id, 
                    user_id, 
                    cashier_id,
                    MAX(receipt_id) AS receipt_id
                FROM 
                    transactions 
                GROUP BY 
                    payment_id
            ) AS t ON p.id = t.payment_id 
        LEFT JOIN 
            receipt AS r ON r.id = t.receipt_id 
        INNER JOIN 
            users AS u ON u.id = t.user_id 
        INNER JOIN customer as cust ON u.id = cust.user_id
        INNER JOIN 
            users AS c ON c.id = t.cashier_id
        LEFT JOIN 
            TotalPaid AS tp ON tp.receipt_id = r.id
        WHERE 
            COALESCE(p.creditTotal, 0) != 0
        GROUP BY
            u.first_name, u.last_name, t.user_id,cust.type ORDER BY u.first_name ASC';
            $stmt = $this->connect()->query( $sql );
            return $stmt;
        }
    }

    public function getDiscountType() {
        $sql = 'SELECT * FROM discounts WHERE id NOT IN (5)';
        $stmt = $this->connect()->query( $sql );
        return $stmt;
    }

    public function getDiscountDataReceipt( $customerId, $discountType, $singleDateData, $startDate, $endDate ) {
        if ( $customerId && !$discountType && !$singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT 
        p.id AS payment_id,
        t.receipt_id AS receipt_id,
        u.first_name AS first_name, 
        u.last_name AS last_name, 
        d.name AS discountType,
        d.discount_amount AS rate,
        SUM(t.subtotal) AS total,
        ROUND(
        LEAST(
        CASE
            WHEN products.isVat = 1  AND products.is_discounted = 1 THEN
            ((SUM(t.subtotal) / 1.12) * (d.discount_amount / 100))
            WHEN products.isVat = 0  AND products.is_discounted = 1 AND d.discount_amount > 0 THEN
            (SUM(t.subtotal) * (d.discount_amount / 100))
            ELSE
            0
        END,
        125
        ) - LEAST(
        COALESCE(rd.customer_discount, 0) + COALESCE(rc.customer_discount, 0),
        125
        ),
        2
    ) AS discountAmount,
        p.date_time_of_payment AS date,
        c.first_name AS c_first_name,
        c.last_name AS c_last_name,
        COALESCE(rd.customer_discount, 0) AS total_discount_refund,
        COALESCE(rc.customer_discount, 0) AS total_discount_return
    FROM 
        transactions AS t
        INNER JOIN receipt AS r ON r.id = t.receipt_id
        INNER JOIN users AS u ON u.id = t.user_id 
        INNER JOIN discounts AS d ON u.discount_id = d.id 
        INNER JOIN payments AS p ON p.id = t.payment_id
        INNER JOIN users AS c ON c.id = t.cashier_id
        INNER JOIN products  ON products.id = t.prod_id
        LEFT JOIN (
         SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1  AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0  AND products.is_discounted = 1 AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (refunded.refunded_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            refunded
            INNER JOIN products ON products.id = refunded.prod_id
            INNER JOIN payments ON payments.id = refunded.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY refunded.payment_id
        ) AS rd ON rd.payment_id = p.id
        LEFT JOIN (
            SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1  AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0  AND products.is_discounted = 1  AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / ( return_exchange.return_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            return_exchange
            INNER JOIN products ON products.id =  return_exchange.product_id
            INNER JOIN payments ON payments.id =  return_exchange.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY  return_exchange.payment_id
        ) AS rc ON rc.payment_id = p.id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
       AND u.id = :customerId
    GROUP BY 
        p.id
        HAVING 
    discountAmount != 0;';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':customerId',  $customerId );
            $sql->execute();
            return $sql;

        } else if ( !$customerId && $discountType && !$singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT 
        p.id AS payment_id,
        t.receipt_id AS receipt_id,
        u.first_name AS first_name, 
        u.last_name AS last_name, 
        d.name AS discountType,
        d.discount_amount AS rate,
        SUM(t.subtotal) AS total,
        ROUND(
        LEAST(
        CASE
            WHEN products.isVat = 1  AND products.is_discounted = 1 THEN
            ((SUM(t.subtotal) / 1.12) * (d.discount_amount / 100))
            WHEN products.isVat = 0  AND products.is_discounted = 1 AND d.discount_amount > 0 THEN
            (SUM(t.subtotal) * (d.discount_amount / 100))
            ELSE
            0
        END,
        125
        ) - LEAST(
        COALESCE(rd.customer_discount, 0) + COALESCE(rc.customer_discount, 0),
        125
        ),
        2
    ) AS discountAmount,
        p.date_time_of_payment AS date,
        c.first_name AS c_first_name,
        c.last_name AS c_last_name,
        COALESCE(rd.customer_discount, 0) AS total_discount_refund,
        COALESCE(rc.customer_discount, 0) AS total_discount_return
    FROM 
        transactions AS t
        INNER JOIN receipt AS r ON r.id = t.receipt_id
        INNER JOIN users AS u ON u.id = t.user_id 
        INNER JOIN discounts AS d ON u.discount_id = d.id 
        INNER JOIN payments AS p ON p.id = t.payment_id
        INNER JOIN users AS c ON c.id = t.cashier_id
        INNER JOIN products  ON products.id = t.prod_id
        LEFT JOIN (
         SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1  AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0  AND products.is_discounted = 1 AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (refunded.refunded_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            refunded
            INNER JOIN products ON products.id = refunded.prod_id
            INNER JOIN payments ON payments.id = refunded.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY refunded.payment_id
        ) AS rd ON rd.payment_id = p.id
        LEFT JOIN (
            SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1  AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0  AND products.is_discounted = 1 AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / ( return_exchange.return_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            return_exchange
            INNER JOIN products ON products.id =  return_exchange.product_id
            INNER JOIN payments ON payments.id =  return_exchange.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY  return_exchange.payment_id
        ) AS rc ON rc.payment_id = p.id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
        AND d.id = :discountType
    GROUP BY 
        p.id
        HAVING 
    discountAmount != 0;';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':discountType', $discountType );
            $sql->execute();
            return $sql;
        } else if ( !$customerId && !$discountType && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT 
        p.id AS payment_id,
        t.receipt_id AS receipt_id,
        u.first_name AS first_name, 
        u.last_name AS last_name, 
        d.name AS discountType,
        d.discount_amount AS rate,
        SUM(t.subtotal) AS total,
        ROUND(
        LEAST(
        CASE
            WHEN products.isVat = 1  AND products.is_discounted = 1 THEN
            ((SUM(t.subtotal) / 1.12) * (d.discount_amount / 100))
            WHEN products.isVat = 0  AND products.is_discounted = 1 AND d.discount_amount > 0 THEN
            (SUM(t.subtotal) * (d.discount_amount / 100))
            ELSE
            0
        END,
        125
        ) - LEAST(
        COALESCE(rd.customer_discount, 0) + COALESCE(rc.customer_discount, 0),
        125
        ),
        2
    ) AS discountAmount,
        p.date_time_of_payment AS date,
        c.first_name AS c_first_name,
        c.last_name AS c_last_name,
        COALESCE(rd.customer_discount, 0) AS total_discount_refund,
        COALESCE(rc.customer_discount, 0) AS total_discount_return
    FROM 
        transactions AS t
        INNER JOIN receipt AS r ON r.id = t.receipt_id
        INNER JOIN users AS u ON u.id = t.user_id 
        INNER JOIN discounts AS d ON u.discount_id = d.id 
        INNER JOIN payments AS p ON p.id = t.payment_id
        INNER JOIN users AS c ON c.id = t.cashier_id
        INNER JOIN products  ON products.id = t.prod_id
        LEFT JOIN (
         SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1  AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0  AND products.is_discounted = 1 AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (refunded.refunded_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            refunded
            INNER JOIN products ON products.id = refunded.prod_id
            INNER JOIN payments ON payments.id = refunded.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY refunded.payment_id
        ) AS rd ON rd.payment_id = p.id
        LEFT JOIN (
            SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1  AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0  AND products.is_discounted = 1 AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / ( return_exchange.return_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            return_exchange
            INNER JOIN products ON products.id =  return_exchange.product_id
            INNER JOIN payments ON payments.id =  return_exchange.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY  return_exchange.payment_id
        ) AS rc ON rc.payment_id = p.id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
       AND DATE(p.date_time_of_payment) = :singleDateData
    GROUP BY 
        p.id
        HAVING 
    discountAmount != 0;';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;
        } else if ( !$customerId && !$discountType && !$singleDateData && $startDate && $endDate ) {
            $sql = 'SELECT 
        p.id AS payment_id,
        t.receipt_id AS receipt_id,
        u.first_name AS first_name, 
        u.last_name AS last_name, 
        d.name AS discountType,
        d.discount_amount AS rate,
        SUM(t.subtotal) AS total,
        ROUND(
        LEAST(
        CASE
            WHEN products.isVat = 1  AND products.is_discounted = 1 THEN
            ((SUM(t.subtotal) / 1.12) * (d.discount_amount / 100))
            WHEN products.isVat = 0   AND products.is_discounted = 1 AND d.discount_amount > 0 THEN
            (SUM(t.subtotal) * (d.discount_amount / 100))
            ELSE
            0
        END,
        125
        ) - LEAST(
        COALESCE(rd.customer_discount, 0) + COALESCE(rc.customer_discount, 0),
        125
        ),
        2
    ) AS discountAmount,
        p.date_time_of_payment AS date,
        c.first_name AS c_first_name,
        c.last_name AS c_last_name,
        COALESCE(rd.customer_discount, 0) AS total_discount_refund,
        COALESCE(rc.customer_discount, 0) AS total_discount_return
    FROM 
        transactions AS t
        INNER JOIN receipt AS r ON r.id = t.receipt_id
        INNER JOIN users AS u ON u.id = t.user_id 
        INNER JOIN discounts AS d ON u.discount_id = d.id 
        INNER JOIN payments AS p ON p.id = t.payment_id
        INNER JOIN users AS c ON c.id = t.cashier_id
        INNER JOIN products  ON products.id = t.prod_id
        LEFT JOIN (
         SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1  AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0  AND products.is_discounted = 1 AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (refunded.refunded_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            refunded
            INNER JOIN products ON products.id = refunded.prod_id
            INNER JOIN payments ON payments.id = refunded.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY refunded.payment_id
        ) AS rd ON rd.payment_id = p.id
        LEFT JOIN (
            SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1  AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0  AND products.is_discounted = 1 AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / ( return_exchange.return_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            return_exchange
            INNER JOIN products ON products.id =  return_exchange.product_id
            INNER JOIN payments ON payments.id =  return_exchange.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY  return_exchange.payment_id
        ) AS rc ON rc.payment_id = p.id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
 AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate
    GROUP BY 
        p.id
        HAVING 
    discountAmount != 0;';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;
        } else if ( $customerId && $discountType && !$singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT 
        p.id AS payment_id,
        t.receipt_id AS receipt_id,
        u.first_name AS first_name, 
        u.last_name AS last_name, 
        d.name AS discountType,
        d.discount_amount AS rate,
        SUM(t.subtotal) AS total,
        ROUND(
        LEAST(
        CASE
            WHEN products.isVat = 1  AND products.is_discounted = 1 THEN
            ((SUM(t.subtotal) / 1.12) * (d.discount_amount / 100))
            WHEN products.isVat = 0  AND products.is_discounted = 1 AND d.discount_amount > 0 THEN
            (SUM(t.subtotal) * (d.discount_amount / 100))
            ELSE
            0
        END,
        125
        ) - LEAST(
        COALESCE(rd.customer_discount, 0) + COALESCE(rc.customer_discount, 0),
        125
        ),
        2
    ) AS discountAmount,
        p.date_time_of_payment AS date,
        c.first_name AS c_first_name,
        c.last_name AS c_last_name,
        COALESCE(rd.customer_discount, 0) AS total_discount_refund,
        COALESCE(rc.customer_discount, 0) AS total_discount_return
    FROM 
        transactions AS t
        INNER JOIN receipt AS r ON r.id = t.receipt_id
        INNER JOIN users AS u ON u.id = t.user_id 
        INNER JOIN discounts AS d ON u.discount_id = d.id 
        INNER JOIN payments AS p ON p.id = t.payment_id
        INNER JOIN users AS c ON c.id = t.cashier_id
        INNER JOIN products  ON products.id = t.prod_id
        LEFT JOIN (
         SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1  AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0  AND products.is_discounted = 1 AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (refunded.refunded_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            refunded
            INNER JOIN products ON products.id = refunded.prod_id
            INNER JOIN payments ON payments.id = refunded.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY refunded.payment_id
        ) AS rd ON rd.payment_id = p.id
        LEFT JOIN (
            SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1  AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0  AND products.is_discounted = 1 AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / ( return_exchange.return_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            return_exchange
            INNER JOIN products ON products.id =  return_exchange.product_id
            INNER JOIN payments ON payments.id =  return_exchange.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY  return_exchange.payment_id
        ) AS rc ON rc.payment_id = p.id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
          AND u.id = :customerId
        AND d.id = :discountType
    GROUP BY 
        p.id
        HAVING 
    discountAmount != 0;';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':customerId',  $customerId );
            $sql->bindParam( ':discountType', $discountType );
            $sql->execute();
            return $sql;
        } else if ( $customerId && !$discountType && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT 
        t.receipt_id as receipt_id,
        u.first_name as first_name, 
        u.last_name as last_name, 
        d.name as discountType,
        d.discount_amount as rate,
        SUM(t.subtotal) as total,
        SUM(t.subtotal) * d.discount_amount / 100 as discountAmount,
        p.date_time_of_payment as date,
        c.first_name as c_first_name,
        c.last_name as c_last_name
    FROM 
        transactions as t
        INNER JOIN receipt as r ON r.id = t.receipt_id
        INNER JOIN users as u ON u.id = t.user_id 
        INNER JOIN discounts as d ON u.discount_id = d.id 
        INNER JOIN payments as p on p.id = t.payment_id
        INNER JOIN users as c ON c.id = t.cashier_id 
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
        AND u.id = :customerId
        AND DATE(p.date_time_of_payment) = :singleDateData
    GROUP BY 
        t.receipt_id, u.first_name, u.last_name, d.name, d.discount_amount;';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':customerId',  $customerId );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;
        } else if ( $customerId && !$discountType && !$singleDateData && $startDate && $endDate ) {
            $sql = 'SELECT 
        p.id AS payment_id,
        t.receipt_id AS receipt_id,
        u.first_name AS first_name, 
        u.last_name AS last_name, 
        d.name AS discountType,
        d.discount_amount AS rate,
        SUM(t.subtotal) AS total,
        ROUND(
        LEAST(
        CASE
            WHEN products.isVat = 1  AND products.is_discounted = 1 THEN
            ((SUM(t.subtotal) / 1.12) * (d.discount_amount / 100))
            WHEN products.isVat = 0 AND d.discount_amount > 0 THEN
            (SUM(t.subtotal) * (d.discount_amount / 100))
            ELSE
            0
        END,
        125
        ) - LEAST(
        COALESCE(rd.customer_discount, 0) + COALESCE(rc.customer_discount, 0),
        125
        ),
        2
    ) AS discountAmount,
        p.date_time_of_payment AS date,
        c.first_name AS c_first_name,
        c.last_name AS c_last_name,
        COALESCE(rd.customer_discount, 0) AS total_discount_refund,
        COALESCE(rc.customer_discount, 0) AS total_discount_return
    FROM 
        transactions AS t
        INNER JOIN receipt AS r ON r.id = t.receipt_id
        INNER JOIN users AS u ON u.id = t.user_id 
        INNER JOIN discounts AS d ON u.discount_id = d.id 
        INNER JOIN payments AS p ON p.id = t.payment_id
        INNER JOIN users AS c ON c.id = t.cashier_id
        INNER JOIN products  ON products.id = t.prod_id
        LEFT JOIN (
         SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1  AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0  AND products.is_discounted = 1 AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (refunded.refunded_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            refunded
            INNER JOIN products ON products.id = refunded.prod_id
            INNER JOIN payments ON payments.id = refunded.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY refunded.payment_id
        ) AS rd ON rd.payment_id = p.id
        LEFT JOIN (
            SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1  AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0  AND products.is_discounted = 1 AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / ( return_exchange.return_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            return_exchange
            INNER JOIN products ON products.id =  return_exchange.product_id
            INNER JOIN payments ON payments.id =  return_exchange.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY  return_exchange.payment_id
        ) AS rc ON rc.payment_id = p.id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
        AND u.id = :customerId
        AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate
    GROUP BY 
        p.id
        HAVING 
    discountAmount != 0;';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':customerId',  $customerId );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;
        } else if ( !$customerId && $discountType && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT 
        p.id AS payment_id,
        t.receipt_id AS receipt_id,
        u.first_name AS first_name, 
        u.last_name AS last_name, 
        d.name AS discountType,
        d.discount_amount AS rate,
        SUM(t.subtotal) AS total,
        ROUND(
        LEAST(
        CASE
            WHEN products.isVat = 1  AND products.is_discounted = 1 THEN
            ((SUM(t.subtotal) / 1.12) * (d.discount_amount / 100))
            WHEN products.isVat = 0 AND d.discount_amount > 0 THEN
            (SUM(t.subtotal) * (d.discount_amount / 100))
            ELSE
            0
        END,
        125
        ) - LEAST(
        COALESCE(rd.customer_discount, 0) + COALESCE(rc.customer_discount, 0),
        125
        ),
        2
    ) AS discountAmount,
        p.date_time_of_payment AS date,
        c.first_name AS c_first_name,
        c.last_name AS c_last_name,
        COALESCE(rd.customer_discount, 0) AS total_discount_refund,
        COALESCE(rc.customer_discount, 0) AS total_discount_return
    FROM 
        transactions AS t
        INNER JOIN receipt AS r ON r.id = t.receipt_id
        INNER JOIN users AS u ON u.id = t.user_id 
        INNER JOIN discounts AS d ON u.discount_id = d.id 
        INNER JOIN payments AS p ON p.id = t.payment_id
        INNER JOIN users AS c ON c.id = t.cashier_id
        INNER JOIN products  ON products.id = t.prod_id
        LEFT JOIN (
         SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1  AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0  AND products.is_discounted = 1 AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (refunded.refunded_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            refunded
            INNER JOIN products ON products.id = refunded.prod_id
            INNER JOIN payments ON payments.id = refunded.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY refunded.payment_id
        ) AS rd ON rd.payment_id = p.id
        LEFT JOIN (
            SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1  AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0  AND products.is_discounted = 1 AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / ( return_exchange.return_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            return_exchange
            INNER JOIN products ON products.id =  return_exchange.product_id
            INNER JOIN payments ON payments.id =  return_exchange.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY  return_exchange.payment_id
        ) AS rc ON rc.payment_id = p.id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
        AND d.id = :discountType
        AND DATE(p.date_time_of_payment) = :singleDateData
    GROUP BY 
        p.id
        HAVING 
    discountAmount != 0;';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':discountType', $discountType );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;
        } else if ( !$customerId && $discountType && !$singleDateData && $startDate && $endDate ) {
            $sql = 'SELECT 
        p.id AS payment_id,
        t.receipt_id AS receipt_id,
        u.first_name AS first_name, 
        u.last_name AS last_name, 
        d.name AS discountType,
        d.discount_amount AS rate,
        SUM(t.subtotal) AS total,
        ROUND(
        LEAST(
        CASE
            WHEN products.isVat =  1  AND products.is_discounted = 1 THEN
            ((SUM(t.subtotal) / 1.12) * (d.discount_amount / 100))
            WHEN products.isVat = 0 AND d.discount_amount > 0 THEN
            (SUM(t.subtotal) * (d.discount_amount / 100))
            ELSE
            0
        END,
        125
        ) - LEAST(
        COALESCE(rd.customer_discount, 0) + COALESCE(rc.customer_discount, 0),
        125
        ),
        2
    ) AS discountAmount,
        p.date_time_of_payment AS date,
        c.first_name AS c_first_name,
        c.last_name AS c_last_name,
        COALESCE(rd.customer_discount, 0) AS total_discount_refund,
        COALESCE(rc.customer_discount, 0) AS total_discount_return
    FROM 
        transactions AS t
        INNER JOIN receipt AS r ON r.id = t.receipt_id
        INNER JOIN users AS u ON u.id = t.user_id 
        INNER JOIN discounts AS d ON u.discount_id = d.id 
        INNER JOIN payments AS p ON p.id = t.payment_id
        INNER JOIN users AS c ON c.id = t.cashier_id
        INNER JOIN products  ON products.id = t.prod_id
        LEFT JOIN (
         SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1  AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0  AND products.is_discounted = 1 AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (refunded.refunded_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            refunded
            INNER JOIN products ON products.id = refunded.prod_id
            INNER JOIN payments ON payments.id = refunded.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY refunded.payment_id
        ) AS rd ON rd.payment_id = p.id
        LEFT JOIN (
            SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1  AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0  AND products.is_discounted = 1 AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / ( return_exchange.return_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            return_exchange
            INNER JOIN products ON products.id =  return_exchange.product_id
            INNER JOIN payments ON payments.id =  return_exchange.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY  return_exchange.payment_id
        ) AS rc ON rc.payment_id = p.id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
        AND d.id = :discountType
        AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate
    GROUP BY 
        p.id
        HAVING 
    discountAmount != 0;';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':discountType', $discountType );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;
        } else if ( $customerId && $discountType && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT 
        p.id AS payment_id,
        t.receipt_id AS receipt_id,
        u.first_name AS first_name, 
        u.last_name AS last_name, 
        d.name AS discountType,
        d.discount_amount AS rate,
        SUM(t.subtotal) AS total,
        ROUND(
        LEAST(
        CASE
            WHEN products.isVat = 1  AND products.is_discounted = 1 THEN
            ((SUM(t.subtotal) / 1.12) * (d.discount_amount / 100))
            WHEN products.isVat = 0 AND d.discount_amount > 0 THEN
            (SUM(t.subtotal) * (d.discount_amount / 100))
            ELSE
            0
        END,
        125
        ) - LEAST(
        COALESCE(rd.customer_discount, 0) + COALESCE(rc.customer_discount, 0),
        125
        ),
        2
    ) AS discountAmount,
        p.date_time_of_payment AS date,
        c.first_name AS c_first_name,
        c.last_name AS c_last_name,
        COALESCE(rd.customer_discount, 0) AS total_discount_refund,
        COALESCE(rc.customer_discount, 0) AS total_discount_return
    FROM 
        transactions AS t
        INNER JOIN receipt AS r ON r.id = t.receipt_id
        INNER JOIN users AS u ON u.id = t.user_id 
        INNER JOIN discounts AS d ON u.discount_id = d.id 
        INNER JOIN payments AS p ON p.id = t.payment_id
        INNER JOIN users AS c ON c.id = t.cashier_id
        INNER JOIN products  ON products.id = t.prod_id
        LEFT JOIN (
         SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1  AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0  AND products.is_discounted = 1 AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (refunded.refunded_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            refunded
            INNER JOIN products ON products.id = refunded.prod_id
            INNER JOIN payments ON payments.id = refunded.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY refunded.payment_id
        ) AS rd ON rd.payment_id = p.id
        LEFT JOIN (
            SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1  AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0  AND products.is_discounted = 1 AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / ( return_exchange.return_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            return_exchange
            INNER JOIN products ON products.id =  return_exchange.product_id
            INNER JOIN payments ON payments.id =  return_exchange.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY  return_exchange.payment_id
        ) AS rc ON rc.payment_id = p.id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
        AND u.id = :customerId
        AND d.id = :discountType
        AND DATE(p.date_time_of_payment) = :singleDateData
    GROUP BY 
        p.id
        HAVING 
    discountAmount != 0;';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':customerId',  $customerId );
            $sql->bindParam( ':discountType', $discountType );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;
        } else if ( $customerId && $discountType && !$singleDateData && $startDate && $endDate ) {
            $sql = 'SELECT 
        p.id AS payment_id,
        t.receipt_id AS receipt_id,
        u.first_name AS first_name, 
        u.last_name AS last_name, 
        d.name AS discountType,
        d.discount_amount AS rate,
        SUM(t.subtotal) AS total,
        ROUND(
        LEAST(
        CASE
            WHEN products.isVat = 1 AND products.is_discounted = 1 THEN
            ((SUM(t.subtotal) / 1.12) * (d.discount_amount / 100))
            WHEN products.isVat = 0 AND d.discount_amount > 0 THEN
            (SUM(t.subtotal) * (d.discount_amount / 100))
            ELSE
            0
        END,
        125
        ) - LEAST(
        COALESCE(rd.customer_discount, 0) + COALESCE(rc.customer_discount, 0),
        125
        ),
        2
    ) AS discountAmount,
        p.date_time_of_payment AS date,
        c.first_name AS c_first_name,
        c.last_name AS c_last_name,
        COALESCE(rd.customer_discount, 0) AS total_discount_refund,
        COALESCE(rc.customer_discount, 0) AS total_discount_return
    FROM 
        transactions AS t
        INNER JOIN receipt AS r ON r.id = t.receipt_id
        INNER JOIN users AS u ON u.id = t.user_id 
        INNER JOIN discounts AS d ON u.discount_id = d.id 
        INNER JOIN payments AS p ON p.id = t.payment_id
        INNER JOIN users AS c ON c.id = t.cashier_id
        INNER JOIN products  ON products.id = t.prod_id
        LEFT JOIN (
         SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1 AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND products.is_discounted = 1 AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (refunded.refunded_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            refunded
            INNER JOIN products ON products.id = refunded.prod_id
            INNER JOIN payments ON payments.id = refunded.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY refunded.payment_id
        ) AS rd ON rd.payment_id = p.id
        LEFT JOIN (
            SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1 AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND products.is_discounted = 1 AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / ( return_exchange.return_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            return_exchange
            INNER JOIN products ON products.id =  return_exchange.product_id
            INNER JOIN payments ON payments.id =  return_exchange.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY  return_exchange.payment_id
        ) AS rc ON rc.payment_id = p.id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
        AND u.id = :customerId
        AND d.id = :discountType
        AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate
    GROUP BY 
        p.id
        HAVING 
    discountAmount != 0;';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':customerId',  $customerId );
            $sql->bindParam( ':discountType', $discountType );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;
        } else {
            $sql = 'SELECT 
        p.id AS payment_id,
        t.receipt_id AS receipt_id,
        u.first_name AS first_name, 
        u.last_name AS last_name, 
        d.name AS discountType,
        d.discount_amount AS rate,
        SUM(t.subtotal) AS total,
        ROUND(
        LEAST(
        CASE
            WHEN products.isVat = 1 AND products.is_discounted = 1 THEN
            ((SUM(t.subtotal) / 1.12) * (d.discount_amount / 100))
            WHEN products.isVat = 0 AND d.discount_amount > 0 THEN
            (SUM(t.subtotal) * (d.discount_amount / 100))
            ELSE
            0
        END,
        125
        ) - LEAST(
        COALESCE(rd.customer_discount, 0) + COALESCE(rc.customer_discount, 0),
        125
        ),
        2
    ) AS discountAmount,
        p.date_time_of_payment AS date,
        c.first_name AS c_first_name,
        c.last_name AS c_last_name,
        COALESCE(rd.customer_discount, 0) AS total_discount_refund,
        COALESCE(rc.customer_discount, 0) AS total_discount_return
    FROM 
        transactions AS t
        INNER JOIN receipt AS r ON r.id = t.receipt_id
        INNER JOIN users AS u ON u.id = t.user_id 
        INNER JOIN discounts AS d ON u.discount_id = d.id 
        INNER JOIN payments AS p ON p.id = t.payment_id
        INNER JOIN users AS c ON c.id = t.cashier_id
        INNER JOIN products  ON products.id = t.prod_id
        LEFT JOIN (
         SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1 AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND products.is_discounted = 1 AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (refunded.refunded_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            refunded
            INNER JOIN products ON products.id = refunded.prod_id
            INNER JOIN payments ON payments.id = refunded.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY refunded.payment_id
        ) AS rd ON rd.payment_id = p.id
        LEFT JOIN (
            SELECT
         payments.id as payment_id,
     SUM(
        CASE
            WHEN products.isVAT = 1 AND products.is_discounted = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND products.is_discounted = 1 AND discounts.discount_amount > 0 THEN
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / ( return_exchange.return_qty * products.prod_price)) * 100) / 100)
                    ) * discounts.discount_amount / 100),
                    2
                )
            ELSE 0
        END) AS customer_discount
         
        FROM
            return_exchange
            INNER JOIN products ON products.id =  return_exchange.product_id
            INNER JOIN payments ON payments.id =  return_exchange.payment_id
            INNER JOIN (
                SELECT DISTINCT t.payment_id, t.prod_qty, t.receipt_id, t.user_id
                FROM transactions t
                INNER JOIN (
                    SELECT  payment_id, MAX(prod_qty) AS max_prod_qty
                    FROM transactions
                    GROUP BY payment_id
                ) AS max_t ON t.payment_id = max_t.payment_id AND t.prod_qty = max_t.max_prod_qty
            ) AS t ON t.payment_id = payments.id
            INNER JOIN receipt ON t.receipt_id = receipt.id
            INNER JOIN users ON users.id = t.user_id
            INNER JOIN discounts ON discounts.id = users.discount_id
            INNER JOIN customer ON customer.user_id = users.id
            GROUP BY  return_exchange.payment_id
        ) AS rc ON rc.payment_id = p.id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
    GROUP BY 
        p.id
        HAVING 
    discountAmount != 0;';

            $stmt = $this->connect()->query( $sql );
            return $stmt;
        }
    }

    public function getDiscountPerItem( $selectedProduct, $singleDateData, $startDate, $endDate ) {
        if ( $selectedProduct && !$singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT t.id AS id, t.prod_desc AS prod_desc, t.prod_price AS prod_price, t.discount_amount AS discount_amount,
        t.receipt_id AS receipt_id, p.date_time_of_payment AS date, (SUM(t.prod_qty)) AS qty, t.subtotal AS subtotal,
        (SUM(t.prod_qty) - ((COALESCE(refunded.refunded_qty, 0) + COALESCE(return_exchange.return_qty, 0)))) AS remaining_qty, COALESCE(refunded.refunded_qty, 0) AS refunded_qty,COALESCE(return_exchange.return_qty, 0) AS  return_qty,
        ROUND((((t.discount_amount) / (SUM(t.prod_qty) * products.prod_price)) * 100), 2) AS rate,
        ROUND(ROUND((SUM(t.prod_qty) - (COALESCE(refunded.refunded_qty, 0) + COALESCE(return_exchange.return_qty, 0))) * products.prod_price * (t.discount_amount / (SUM(t.prod_qty) * products.prod_price)), 2), 2) AS amountdiscounted,
        products.prod_price as prod_price
        FROM `transactions` AS t
        INNER JOIN payments AS p ON p.id = t.payment_id
        INNER JOIN products ON t.prod_id = products.id
        LEFT JOIN (
            SELECT payment_id, itemDiscount, prod_id, SUM(refunded_qty) as refunded_qty
            FROM refunded
            GROUP BY payment_id, itemDiscount, prod_id
        ) AS refunded ON t.payment_id = refunded.payment_id AND t.discount_amount = refunded.itemDiscount
        LEFT JOIN (
            SELECT payment_id, itemDiscount, product_id, SUM(return_qty) as return_qty
            FROM return_exchange
            GROUP BY payment_id, itemDiscount, product_id
        ) AS return_exchange ON t.payment_id =return_exchange.payment_id AND t.discount_amount = return_exchange.itemDiscount
        WHERE t.is_paid = 1 AND t.is_void = 0 AND t.discount_amount != 0 AND (t.prod_qty - COALESCE(refunded.refunded_qty, 0)) != 0
                 AND t.prod_id = :selectedProduct
     GROUP BY
        t.payment_id,t.discount_amount
        HAVING
        remaining_qty > 0;
    
      ';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedProduct',  $selectedProduct );
            $sql->execute();
            return $sql;
        } else if ( !$selectedProduct && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT t.id AS id, t.prod_desc AS prod_desc, t.prod_price AS prod_price, t.discount_amount AS discount_amount,
        t.receipt_id AS receipt_id, p.date_time_of_payment AS date, (SUM(t.prod_qty)) AS qty, t.subtotal AS subtotal,
        (SUM(t.prod_qty) - ((COALESCE(refunded.refunded_qty, 0) + COALESCE(return_exchange.return_qty, 0)))) AS remaining_qty, COALESCE(refunded.refunded_qty, 0) AS refunded_qty,COALESCE(return_exchange.return_qty, 0) AS  return_qty,
        ROUND((((t.discount_amount) / (SUM(t.prod_qty) * products.prod_price)) * 100), 2) AS rate,
        ROUND(ROUND((SUM(t.prod_qty) - (COALESCE(refunded.refunded_qty, 0) + COALESCE(return_exchange.return_qty, 0))) * products.prod_price * (t.discount_amount / (SUM(t.prod_qty) * products.prod_price)), 2), 2) AS amountdiscounted,
        products.prod_price as prod_price
        FROM `transactions` AS t
        INNER JOIN payments AS p ON p.id = t.payment_id
        INNER JOIN products ON t.prod_id = products.id
        LEFT JOIN (
            SELECT payment_id, itemDiscount, prod_id, SUM(refunded_qty) as refunded_qty
            FROM refunded
            GROUP BY payment_id, itemDiscount, prod_id
        ) AS refunded ON t.payment_id = refunded.payment_id AND t.discount_amount = refunded.itemDiscount
        LEFT JOIN (
            SELECT payment_id, itemDiscount, product_id, SUM(return_qty) as return_qty
            FROM return_exchange
            GROUP BY payment_id, itemDiscount, product_id
        ) AS return_exchange ON t.payment_id =return_exchange.payment_id AND t.discount_amount = return_exchange.itemDiscount
        WHERE t.is_paid = 1 AND t.is_void = 0 AND t.discount_amount != 0 AND (t.prod_qty - COALESCE(refunded.refunded_qty, 0)) != 0
            AND DATE(p.date_time_of_payment) = :singleDateData
     GROUP BY
        t.payment_id,t.discount_amount
        HAVING
        remaining_qty > 0;
    
      ';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;
        } else if ( !$selectedProduct && !$singleDateData && $startDate && $endDate ) {
            $sql = 'SELECT t.id AS id, t.prod_desc AS prod_desc, t.prod_price AS prod_price, t.discount_amount AS discount_amount,
        t.receipt_id AS receipt_id, p.date_time_of_payment AS date, (SUM(t.prod_qty)) AS qty, t.subtotal AS subtotal,
        (SUM(t.prod_qty) - ((COALESCE(refunded.refunded_qty, 0) + COALESCE(return_exchange.return_qty, 0)))) AS remaining_qty, COALESCE(refunded.refunded_qty, 0) AS refunded_qty,COALESCE(return_exchange.return_qty, 0) AS  return_qty,
        ROUND((((t.discount_amount) / (SUM(t.prod_qty) * products.prod_price)) * 100), 2) AS rate,
        ROUND(ROUND((SUM(t.prod_qty) - (COALESCE(refunded.refunded_qty, 0) + COALESCE(return_exchange.return_qty, 0))) * products.prod_price * (t.discount_amount / (SUM(t.prod_qty) * products.prod_price)), 2), 2) AS amountdiscounted,
        products.prod_price as prod_price
        FROM `transactions` AS t
        INNER JOIN payments AS p ON p.id = t.payment_id
        INNER JOIN products ON t.prod_id = products.id
        LEFT JOIN (
            SELECT payment_id, itemDiscount, prod_id, SUM(refunded_qty) as refunded_qty
            FROM refunded
            GROUP BY payment_id, itemDiscount, prod_id
        ) AS refunded ON t.payment_id = refunded.payment_id AND t.discount_amount = refunded.itemDiscount
        LEFT JOIN (
            SELECT payment_id, itemDiscount, product_id, SUM(return_qty) as return_qty
            FROM return_exchange
            GROUP BY payment_id, itemDiscount, product_id
        ) AS return_exchange ON t.payment_id =return_exchange.payment_id AND t.discount_amount = return_exchange.itemDiscount
        WHERE t.is_paid = 1 AND t.is_void = 0 AND t.discount_amount != 0 AND (t.prod_qty - COALESCE(refunded.refunded_qty, 0)) != 0
       AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate
     GROUP BY
        t.payment_id,t.discount_amount
        HAVING
        remaining_qty > 0;
    
      ';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;
        } else if ( $selectedProduct && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT t.id AS id, t.prod_desc AS prod_desc, t.prod_price AS prod_price, t.discount_amount AS discount_amount,
        t.receipt_id AS receipt_id, p.date_time_of_payment AS date, (SUM(t.prod_qty)) AS qty, t.subtotal AS subtotal,
        (SUM(t.prod_qty) - ((COALESCE(refunded.refunded_qty, 0) + COALESCE(return_exchange.return_qty, 0)))) AS remaining_qty, COALESCE(refunded.refunded_qty, 0) AS refunded_qty,COALESCE(return_exchange.return_qty, 0) AS  return_qty,
        ROUND((((t.discount_amount) / (SUM(t.prod_qty) * products.prod_price)) * 100), 2) AS rate,
        ROUND(ROUND((SUM(t.prod_qty) - (COALESCE(refunded.refunded_qty, 0) + COALESCE(return_exchange.return_qty, 0))) * products.prod_price * (t.discount_amount / (SUM(t.prod_qty) * products.prod_price)), 2), 2) AS amountdiscounted,
        products.prod_price as prod_price
        FROM `transactions` AS t
        INNER JOIN payments AS p ON p.id = t.payment_id
        INNER JOIN products ON t.prod_id = products.id
        LEFT JOIN (
            SELECT payment_id, itemDiscount, prod_id, SUM(refunded_qty) as refunded_qty
            FROM refunded
            GROUP BY payment_id, itemDiscount, prod_id
        ) AS refunded ON t.payment_id = refunded.payment_id AND t.discount_amount = refunded.itemDiscount
        LEFT JOIN (
            SELECT payment_id, itemDiscount, product_id, SUM(return_qty) as return_qty
            FROM return_exchange
            GROUP BY payment_id, itemDiscount, product_id
        ) AS return_exchange ON t.payment_id =return_exchange.payment_id AND t.discount_amount = return_exchange.itemDiscount
        WHERE t.is_paid = 1 AND t.is_void = 0 AND t.discount_amount != 0 AND (t.prod_qty - COALESCE(refunded.refunded_qty, 0)) != 0
         AND t.prod_id = :selectedProduct
            AND DATE(p.date_time_of_payment) = :singleDateData
     GROUP BY
        t.payment_id,t.discount_amount
        HAVING
        remaining_qty > 0;';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedProduct',  $selectedProduct );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;
        } else if ( $selectedProduct && !$singleDateData && $startDate && $endDate ) {
            $sql = 'SELECT t.id AS id, t.prod_desc AS prod_desc, t.prod_price AS prod_price, t.discount_amount AS discount_amount,
        t.receipt_id AS receipt_id, p.date_time_of_payment AS date, (SUM(t.prod_qty)) AS qty, t.subtotal AS subtotal,
        (SUM(t.prod_qty) - ((COALESCE(refunded.refunded_qty, 0) + COALESCE(return_exchange.return_qty, 0)))) AS remaining_qty, COALESCE(refunded.refunded_qty, 0) AS refunded_qty,COALESCE(return_exchange.return_qty, 0) AS  return_qty,
        ROUND((((t.discount_amount) / (SUM(t.prod_qty) * products.prod_price)) * 100), 2) AS rate,
        ROUND(ROUND((SUM(t.prod_qty) - (COALESCE(refunded.refunded_qty, 0) + COALESCE(return_exchange.return_qty, 0))) * products.prod_price * (t.discount_amount / (SUM(t.prod_qty) * products.prod_price)), 2), 2) AS amountdiscounted,
        products.prod_price as prod_price
        FROM `transactions` AS t
        INNER JOIN payments AS p ON p.id = t.payment_id
        INNER JOIN products ON t.prod_id = products.id
        LEFT JOIN (
            SELECT payment_id, itemDiscount, prod_id, SUM(refunded_qty) as refunded_qty
            FROM refunded
            GROUP BY payment_id, itemDiscount, prod_id
        ) AS refunded ON t.payment_id = refunded.payment_id AND t.discount_amount = refunded.itemDiscount
        LEFT JOIN (
            SELECT payment_id, itemDiscount, product_id, SUM(return_qty) as return_qty
            FROM return_exchange
            GROUP BY payment_id, itemDiscount, product_id
        ) AS return_exchange ON t.payment_id =return_exchange.payment_id AND t.discount_amount = return_exchange.itemDiscount
        WHERE t.is_paid = 1 AND t.is_void = 0 AND t.discount_amount != 0 AND (t.prod_qty - COALESCE(refunded.refunded_qty, 0)) != 0
        AND t.prod_id = :selectedProduct
        AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate 
        GROUP BY
        t.payment_id,t.discount_amount
        HAVING
        remaining_qty > 0';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedProduct',  $selectedProduct );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;
        } else {
            $sql = 'SELECT t.id AS id, t.prod_desc AS prod_desc, t.prod_price AS prod_price, t.discount_amount AS discount_amount,
    t.receipt_id AS receipt_id, p.date_time_of_payment AS date, (SUM(t.prod_qty)) AS qty, t.subtotal AS subtotal,
    (SUM(t.prod_qty) - ((COALESCE(refunded.refunded_qty, 0) + COALESCE(return_exchange.return_qty, 0)))) AS remaining_qty, COALESCE(refunded.refunded_qty, 0) AS refunded_qty,COALESCE(return_exchange.return_qty, 0) AS  return_qty,
    ROUND((((t.discount_amount) / (SUM(t.prod_qty) * products.prod_price)) * 100), 2) AS rate,
    ROUND(ROUND((SUM(t.prod_qty) - (COALESCE(refunded.refunded_qty, 0) + COALESCE(return_exchange.return_qty, 0))) * products.prod_price * (t.discount_amount / (SUM(t.prod_qty) * products.prod_price)), 2), 2) AS amountdiscounted,
    products.prod_price as prod_price
    FROM `transactions` AS t
    INNER JOIN payments AS p ON p.id = t.payment_id
    INNER JOIN products ON t.prod_id = products.id
    LEFT JOIN (
        SELECT payment_id, itemDiscount, prod_id, SUM(refunded_qty) as refunded_qty
        FROM refunded
        GROUP BY payment_id, itemDiscount, prod_id
    ) AS refunded ON t.payment_id = refunded.payment_id AND t.discount_amount = refunded.itemDiscount
    LEFT JOIN (
        SELECT payment_id, itemDiscount, product_id, SUM(return_qty) as return_qty
        FROM return_exchange
        GROUP BY payment_id, itemDiscount, product_id
    ) AS return_exchange ON t.payment_id =return_exchange.payment_id AND t.discount_amount = return_exchange.itemDiscount
    WHERE t.is_paid = 1 AND t.is_void = 0 AND t.discount_amount != 0 AND (t.prod_qty - COALESCE(refunded.refunded_qty, 0)) != 0
    GROUP BY
    t.payment_id,t.discount_amount
    HAVING
    remaining_qty > 0;';

            $stmt = $this->connect()->query( $sql );
            return $stmt;
        }
    }

    public function getPaymentMethod( $singleDateData, $startDate, $endDate) {
        if($singleDateData && !$startDate && !$endDate){
            $sql = "SELECT 
        SUM(JSON_VALUE(all_data, '$.cash_in_receive')) AS cash,
        SUM(JSON_VALUE(all_data, '$.credit')) AS credit,
        SUM(JSON_VALUE(all_data, '$.totalEwallet')) AS ewallet,
        SUM(JSON_VALUE(all_data, '$.totalCoupon')) AS coupon,
        SUM(JSON_VALUE(all_data, '$.totalCcDb')) AS cc,
        (SUM(JSON_VALUE(all_data, '$.cash_in_receive')) +   SUM(JSON_VALUE(all_data, '$.credit')) + SUM(JSON_VALUE(all_data, '$.totalEwallet')) +  SUM(JSON_VALUE(all_data, '$.totalCoupon')) +   SUM(JSON_VALUE(all_data, '$.totalCcDb'))) as total_amount,
        DATE(date_time) as date
        FROM z_read
        WHERE DATE(date_time) = :singleDateData
        GROUP BY DATE(date_time);";
    
                $sql = $this->connect()->prepare( $sql );
                $sql->bindParam( ':singleDateData',  $singleDateData );
    
                $sql->execute();
                return $sql;
        }else if(!$singleDateData && $startDate && $endDate){
            $sql = "SELECT 
            SUM(JSON_VALUE(all_data, '$.cash_in_receive')) AS cash,
            SUM(JSON_VALUE(all_data, '$.credit')) AS credit,
            SUM(JSON_VALUE(all_data, '$.totalEwallet')) AS ewallet,
            SUM(JSON_VALUE(all_data, '$.totalCoupon')) AS coupon,
            SUM(JSON_VALUE(all_data, '$.totalCcDb')) AS cc,
            (SUM(JSON_VALUE(all_data, '$.cash_in_receive')) +   SUM(JSON_VALUE(all_data, '$.credit')) + SUM(JSON_VALUE(all_data, '$.totalEwallet')) +  SUM(JSON_VALUE(all_data, '$.totalCoupon')) +   SUM(JSON_VALUE(all_data, '$.totalCcDb'))) as total_amount,
            DATE(date_time) as date
            FROM z_read
            WHERE DATE(date_time) BETWEEN :startDate AND :endDate
            GROUP BY DATE(date_time);";
        
                    $sql = $this->connect()->prepare( $sql );
                    $sql->bindParam( ':startDate',  $startDate);
                    $sql->bindParam( ':endDate',  $endDate);
                    $sql->execute();
                    return $sql;
        }
        else{
        $sql = "SELECT 
        SUM(JSON_VALUE(all_data, '$.cash_in_receive')) AS cash,
        SUM(JSON_VALUE(all_data, '$.credit')) AS credit,
        SUM(JSON_VALUE(all_data, '$.totalEwallet')) AS ewallet,
        SUM(JSON_VALUE(all_data, '$.totalCoupon')) AS coupon,
        SUM(JSON_VALUE(all_data, '$.totalCcDb')) AS cc,
        (SUM(JSON_VALUE(all_data, '$.cash_in_receive')) +   SUM(JSON_VALUE(all_data, '$.credit')) + SUM(JSON_VALUE(all_data, '$.totalEwallet')) +  SUM(JSON_VALUE(all_data, '$.totalCoupon')) +   SUM(JSON_VALUE(all_data, '$.totalCcDb'))) as total_amount,
        DATE(date_time) as date
      FROM z_read
        GROUP BY DATE(date_time);";
    
                $stmt = $this->connect()->query( $sql );
                return $stmt;
        }
    }

    public function getPaymentMethodByUsers( $userId, $singleDateData, $startDate, $endDate, $exclude ) {
        if ( $exclude == 1 ) {
            if ( $userId && !$singleDateData && !$startDate && !$endDate ) {
                $sql = "SELECT 
            payments.id AS id,
            u.id as id,
            u.first_name as firstname,
            u.last_name as lastname,
            transactions.payment_id,
            transactions.cashier_id,
            transactions.is_paid,
            transactions.is_void, 
            SUM(DISTINCT payments.change_amount) AS change_amount,
            DATE(payments.date_time_of_payment) AS payment_date,
    GREATEST(
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) 
        - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0) 
        - CASE
            WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
                rc.credit_amount
            WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
                (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
            ELSE 
                0
        END, 
        0
    ) AS credit_total,
    
              GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'cash' THEN (jt.amount - payments.change_amount) 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType = 'cash' THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE
                    WHEN rc.cash_amount > 0 AND rc.total_return_amount > rc.cash_amount THEN rc.cash_amount
                    WHEN rc.cash_amount > 0 AND rc.total_return_amount <= rc.cash_amount THEN rc.total_return_amount
                    ELSE 0
                  END,
                0
            ) AS cash_total,
              GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE
                    WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount THEN rc.ewallet_amount
                    WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount THEN rc.total_return_amount - rc.cash_amount
                    ELSE 0
                  END,
                0
            ) AS e_wallet_total,
              GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE 
                    WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) > rc.cc_amount THEN rc.cc_amount
                    WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) <= rc.cc_amount THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount
                    ELSE 0
                  END,
                0
            ) AS cdcards_total,
            GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'coupon' THEN jt.amount 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE
                    WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.coupon_amount) THEN rc.coupon_amount
                    WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.coupon_amount) THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount
                    ELSE 0
                  END,
                0
            ) AS coupons_total,
        GREATEST(
            (SUM(jt.amount) - SUM(DISTINCT payments.change_amount)) 
            - COALESCE(SUM(rf.refunded_amt), 0) 
            - COALESCE(rc.total_return_amount, 0),
            0
        ) AS total_amount,
        
        
            COALESCE(rc.total_return_amount, 0) AS total_return_amount,
            COALESCE(rc.cash_amount, 0) AS return_cash_amount,
            CASE
               WHEN rc.cash_amount > 0 AND (rc.total_return_amount > rc.cash_amount) THEN 
               rc.cash_amount
               WHEN rc.cash_amount > 0 AND (rc.total_return_amount <= rc.cash_amount) THEN
               rc.total_return_amount
            ELSE 0
            END AS tobe_deducted_cash,
            CASE
               WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount) THEN
               rc.ewallet_amount
               WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount) THEN
               rc.total_return_amount - rc.cash_amount
               ELSE 0
             END AS tobe_deducted_ewallet,
                CASE 
                WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) > rc.cc_amount) THEN
                rc.cc_amount
              WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) <= rc.cc_amount)  THEN
              (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount )
             ELSE 0
            END AS tobe_deducted_cc,
            CASE
             WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.cc_amount) THEN
                rc.coupon_amount
              WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.cc_amount) THEN
              (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount)
              ELSE 0
               END AS tobe_deducted_coupon,
      CASE
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
            rc.credit_amount
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
            (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
        ELSE 
            0
    END AS tobe_deducted_credits
    
        FROM 
            payments
        CROSS JOIN JSON_TABLE(
            payments.payment_details, '$[*]' COLUMNS (
                paymentType VARCHAR(255) PATH '$.paymentType', 
                amount DECIMAL(10, 2) PATH '$.amount'
            )
        ) AS jt
        INNER JOIN (
            SELECT DISTINCT payment_id, receipt_id 
            FROM transactions 
            WHERE is_paid = 1 AND is_void = 0
        ) AS t ON payments.id = t.payment_id
        LEFT JOIN (
            SELECT payment_id, SUM(refunded_amt) AS refunded_amt
            FROM refunded
            GROUP BY payment_id
        ) AS rf ON rf.payment_id = payments.id
        LEFT JOIN (
        SELECT 
            re.payment_id as payment_id,
            COALESCE(jt.cash_amount, 0) as cash_amount,
            COALESCE(jt.credit_amount, 0) as credit_amount,
            COALESCE(jt.gcash_amount, 0) as gcash_amount,
            COALESCE(jt.maya_amount, 0) as maya_amount,
            COALESCE(jt.alipay_amount, 0) as alipay_amount,
            COALESCE(jt.grab_pay_amount, 0) as grab_pay_amount,
            COALESCE(jt.shopee_pay_amount, 0) as shopee_pay_amount,
            COALESCE(jt.ewallet_amount, 0) as ewallet_amount,
            COALESCE(jt.visa_amount, 0) as visa_amount,
            COALESCE(jt.master_card_amount, 0) as master_card_amount,
            COALESCE(jt.discover_card_amount, 0) as discover_card_amount,
            COALESCE(jt.american_express_card_amount, 0) as american_express_card_amount,
            COALESCE(jt.jcb_card_amount, 0) as jcb_card_amount,
            COALESCE(jt.cc_amount, 0) as cc_amount,
            COALESCE(jt.coupon_amount, 0) as coupon_amount,
            ROUND(SUM(re.return_amount), 2) AS total_return_amount
        FROM 
            return_exchange re
        LEFT JOIN (
            SELECT 
                p.id as payment_id,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END, 0)) as coupon_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END, 0)) as cash_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END, 0)) as credit_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'gcash' THEN jt.amount ELSE 0 END, 0)) as gcash_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'maya' THEN jt.amount ELSE 0 END, 0)) as maya_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'alipay' THEN jt.amount ELSE 0 END, 0)) as alipay_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'grab pay' THEN jt.amount ELSE 0 END, 0)) as grab_pay_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'shopee pay' THEN jt.amount ELSE 0 END, 0)) as shopee_pay_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END, 0)) as ewallet_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'visa' THEN jt.amount ELSE 0 END, 0)) as visa_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'master_card' THEN jt.amount ELSE 0 END, 0)) as master_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'discover' THEN jt.amount ELSE 0 END, 0)) as discover_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'american_express' THEN jt.amount ELSE 0 END, 0)) as american_express_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'jcb' THEN jt.amount ELSE 0 END, 0)) as jcb_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('visa', 'master_card', 'discover', 'american_express', 'jcb') THEN jt.amount ELSE 0 END, 0)) as cc_amount
            FROM 
                payments p
            CROSS JOIN JSON_TABLE(
                p.payment_details, '$[*]' COLUMNS (
                    paymentType VARCHAR(255) PATH '$.paymentType', 
                    amount DECIMAL(10, 2) PATH '$.amount'
                )
            ) AS jt
            GROUP BY 
                p.id
        ) jt ON jt.payment_id = re.payment_id
        
        ) AS rc ON rc.payment_id = payments.id
       INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id,is_paid,is_void,cashier_id
        FROM transactions 
        WHERE is_paid = 1 AND is_void = 0
    ) AS transactions ON payments.id = transactions.payment_id
       INNER JOIN users AS u ON u.id = transactions.cashier_id
        WHERE 
            JSON_VALID(payments.payment_details) AND jt.amount != 0.00 
            AND transactions.is_paid = 1 AND transactions.is_void = 0
            AND u.id = :userId
     GROUP BY 
        u.id
     ORDER BY 
        u.id ASC";

                $sql = $this->connect()->prepare( $sql );
                $sql->bindParam( ':userId', $userId );
                $sql->execute();
                return $sql;

            } else if ( !$userId && $singleDateData && !$startDate && !$endDate ) {
                $sql = "SELECT 
            payments.id AS id,
            u.id as id,
            u.first_name as firstname,
            u.last_name as lastname,
            transactions.payment_id,
            transactions.cashier_id,
            transactions.is_paid,
            transactions.is_void, 
            SUM(DISTINCT payments.change_amount) AS change_amount,
            DATE(payments.date_time_of_payment) AS payment_date,
    GREATEST(
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) 
        - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0) 
        - CASE
            WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
                rc.credit_amount
            WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
                (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
            ELSE 
                0
        END, 
        0
    ) AS credit_total,
    
              GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'cash' THEN (jt.amount - payments.change_amount) 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType = 'cash' THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE
                    WHEN rc.cash_amount > 0 AND rc.total_return_amount > rc.cash_amount THEN rc.cash_amount
                    WHEN rc.cash_amount > 0 AND rc.total_return_amount <= rc.cash_amount THEN rc.total_return_amount
                    ELSE 0
                  END,
                0
            ) AS cash_total,
              GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE
                    WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount THEN rc.ewallet_amount
                    WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount THEN rc.total_return_amount - rc.cash_amount
                    ELSE 0
                  END,
                0
            ) AS e_wallet_total,
              GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE 
                    WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) > rc.cc_amount THEN rc.cc_amount
                    WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) <= rc.cc_amount THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount
                    ELSE 0
                  END,
                0
            ) AS cdcards_total,
            GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'coupon' THEN jt.amount 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE
                    WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.coupon_amount) THEN rc.coupon_amount
                    WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.coupon_amount) THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount
                    ELSE 0
                  END,
                0
            ) AS coupons_total,
        GREATEST(
            (SUM(jt.amount) - SUM(DISTINCT payments.change_amount)) 
            - COALESCE(SUM(rf.refunded_amt), 0) 
            - COALESCE(rc.total_return_amount, 0),
            0
        ) AS total_amount,
        
        
            COALESCE(rc.total_return_amount, 0) AS total_return_amount,
            COALESCE(rc.cash_amount, 0) AS return_cash_amount,
            CASE
               WHEN rc.cash_amount > 0 AND (rc.total_return_amount > rc.cash_amount) THEN 
               rc.cash_amount
               WHEN rc.cash_amount > 0 AND (rc.total_return_amount <= rc.cash_amount) THEN
               rc.total_return_amount
            ELSE 0
            END AS tobe_deducted_cash,
            CASE
               WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount) THEN
               rc.ewallet_amount
               WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount) THEN
               rc.total_return_amount - rc.cash_amount
               ELSE 0
             END AS tobe_deducted_ewallet,
                CASE 
                WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) > rc.cc_amount) THEN
                rc.cc_amount
              WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) <= rc.cc_amount)  THEN
              (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount )
             ELSE 0
            END AS tobe_deducted_cc,
            CASE
             WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.cc_amount) THEN
                rc.coupon_amount
              WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.cc_amount) THEN
              (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount)
              ELSE 0
               END AS tobe_deducted_coupon,
      CASE
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
            rc.credit_amount
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
            (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
        ELSE 
            0
    END AS tobe_deducted_credits
    
        FROM 
            payments
        CROSS JOIN JSON_TABLE(
            payments.payment_details, '$[*]' COLUMNS (
                paymentType VARCHAR(255) PATH '$.paymentType', 
                amount DECIMAL(10, 2) PATH '$.amount'
            )
        ) AS jt
        INNER JOIN (
            SELECT DISTINCT payment_id, receipt_id 
            FROM transactions 
            WHERE is_paid = 1 AND is_void = 0
        ) AS t ON payments.id = t.payment_id
        LEFT JOIN (
            SELECT payment_id, SUM(refunded_amt) AS refunded_amt
            FROM refunded
            GROUP BY payment_id
        ) AS rf ON rf.payment_id = payments.id
        LEFT JOIN (
        SELECT 
            re.payment_id as payment_id,
            COALESCE(jt.cash_amount, 0) as cash_amount,
            COALESCE(jt.credit_amount, 0) as credit_amount,
            COALESCE(jt.gcash_amount, 0) as gcash_amount,
            COALESCE(jt.maya_amount, 0) as maya_amount,
            COALESCE(jt.alipay_amount, 0) as alipay_amount,
            COALESCE(jt.grab_pay_amount, 0) as grab_pay_amount,
            COALESCE(jt.shopee_pay_amount, 0) as shopee_pay_amount,
            COALESCE(jt.ewallet_amount, 0) as ewallet_amount,
            COALESCE(jt.visa_amount, 0) as visa_amount,
            COALESCE(jt.master_card_amount, 0) as master_card_amount,
            COALESCE(jt.discover_card_amount, 0) as discover_card_amount,
            COALESCE(jt.american_express_card_amount, 0) as american_express_card_amount,
            COALESCE(jt.jcb_card_amount, 0) as jcb_card_amount,
            COALESCE(jt.cc_amount, 0) as cc_amount,
            COALESCE(jt.coupon_amount, 0) as coupon_amount,
            ROUND(SUM(re.return_amount), 2) AS total_return_amount
        FROM 
            return_exchange re
        LEFT JOIN (
            SELECT 
                p.id as payment_id,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END, 0)) as coupon_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END, 0)) as cash_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END, 0)) as credit_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'gcash' THEN jt.amount ELSE 0 END, 0)) as gcash_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'maya' THEN jt.amount ELSE 0 END, 0)) as maya_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'alipay' THEN jt.amount ELSE 0 END, 0)) as alipay_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'grab pay' THEN jt.amount ELSE 0 END, 0)) as grab_pay_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'shopee pay' THEN jt.amount ELSE 0 END, 0)) as shopee_pay_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END, 0)) as ewallet_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'visa' THEN jt.amount ELSE 0 END, 0)) as visa_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'master_card' THEN jt.amount ELSE 0 END, 0)) as master_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'discover' THEN jt.amount ELSE 0 END, 0)) as discover_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'american_express' THEN jt.amount ELSE 0 END, 0)) as american_express_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'jcb' THEN jt.amount ELSE 0 END, 0)) as jcb_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('visa', 'master_card', 'discover', 'american_express', 'jcb') THEN jt.amount ELSE 0 END, 0)) as cc_amount
            FROM 
                payments p
            CROSS JOIN JSON_TABLE(
                p.payment_details, '$[*]' COLUMNS (
                    paymentType VARCHAR(255) PATH '$.paymentType', 
                    amount DECIMAL(10, 2) PATH '$.amount'
                )
            ) AS jt
            GROUP BY 
                p.id
        ) jt ON jt.payment_id = re.payment_id
        
        ) AS rc ON rc.payment_id = payments.id
       INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id,is_paid,is_void,cashier_id
        FROM transactions 
        WHERE is_paid = 1 AND is_void = 0
    ) AS transactions ON payments.id = transactions.payment_id
       INNER JOIN users AS u ON u.id = transactions.cashier_id
        WHERE 
            JSON_VALID(payments.payment_details) AND jt.amount != 0.00 
            AND transactions.is_paid = 1 AND transactions.is_void = 0
            AND DATE(payments.date_time_of_payment) = :singleDateData
     GROUP BY 
        u.id
     ORDER BY 
        u.id ASC";

                $sql = $this->connect()->prepare( $sql );
                $sql->bindParam( ':singleDateData',  $singleDateData );
                $sql->execute();
                return $sql;
            } else if ( !$userId && !$singleDateData && $startDate && $endDate ) {
                $sql = "SELECT 
            payments.id AS id,
            u.id as id,
            u.first_name as firstname,
            u.last_name as lastname,
            transactions.payment_id,
            transactions.cashier_id,
            transactions.is_paid,
            transactions.is_void, 
            SUM(DISTINCT payments.change_amount) AS change_amount,
            DATE(payments.date_time_of_payment) AS payment_date,
    GREATEST(
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) 
        - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0) 
        - CASE
            WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
                rc.credit_amount
            WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
                (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
            ELSE 
                0
        END, 
        0
    ) AS credit_total,
    
              GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'cash' THEN (jt.amount - payments.change_amount) 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType = 'cash' THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE
                    WHEN rc.cash_amount > 0 AND rc.total_return_amount > rc.cash_amount THEN rc.cash_amount
                    WHEN rc.cash_amount > 0 AND rc.total_return_amount <= rc.cash_amount THEN rc.total_return_amount
                    ELSE 0
                  END,
                0
            ) AS cash_total,
              GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE
                    WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount THEN rc.ewallet_amount
                    WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount THEN rc.total_return_amount - rc.cash_amount
                    ELSE 0
                  END,
                0
            ) AS e_wallet_total,
              GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE 
                    WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) > rc.cc_amount THEN rc.cc_amount
                    WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) <= rc.cc_amount THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount
                    ELSE 0
                  END,
                0
            ) AS cdcards_total,
            GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'coupon' THEN jt.amount 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE
                    WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.coupon_amount) THEN rc.coupon_amount
                    WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.coupon_amount) THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount
                    ELSE 0
                  END,
                0
            ) AS coupons_total,
        GREATEST(
            (SUM(jt.amount) - SUM(DISTINCT payments.change_amount)) 
            - COALESCE(SUM(rf.refunded_amt), 0) 
            - COALESCE(rc.total_return_amount, 0),
            0
        ) AS total_amount,
        
        
            COALESCE(rc.total_return_amount, 0) AS total_return_amount,
            COALESCE(rc.cash_amount, 0) AS return_cash_amount,
            CASE
               WHEN rc.cash_amount > 0 AND (rc.total_return_amount > rc.cash_amount) THEN 
               rc.cash_amount
               WHEN rc.cash_amount > 0 AND (rc.total_return_amount <= rc.cash_amount) THEN
               rc.total_return_amount
            ELSE 0
            END AS tobe_deducted_cash,
            CASE
               WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount) THEN
               rc.ewallet_amount
               WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount) THEN
               rc.total_return_amount - rc.cash_amount
               ELSE 0
             END AS tobe_deducted_ewallet,
                CASE 
                WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) > rc.cc_amount) THEN
                rc.cc_amount
              WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) <= rc.cc_amount)  THEN
              (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount )
             ELSE 0
            END AS tobe_deducted_cc,
            CASE
             WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.cc_amount) THEN
                rc.coupon_amount
              WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.cc_amount) THEN
              (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount)
              ELSE 0
               END AS tobe_deducted_coupon,
      CASE
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
            rc.credit_amount
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
            (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
        ELSE 
            0
    END AS tobe_deducted_credits
    
        FROM 
            payments
        CROSS JOIN JSON_TABLE(
            payments.payment_details, '$[*]' COLUMNS (
                paymentType VARCHAR(255) PATH '$.paymentType', 
                amount DECIMAL(10, 2) PATH '$.amount'
            )
        ) AS jt
        INNER JOIN (
            SELECT DISTINCT payment_id, receipt_id 
            FROM transactions 
            WHERE is_paid = 1 AND is_void = 0
        ) AS t ON payments.id = t.payment_id
        LEFT JOIN (
            SELECT payment_id, SUM(refunded_amt) AS refunded_amt
            FROM refunded
            GROUP BY payment_id
        ) AS rf ON rf.payment_id = payments.id
        LEFT JOIN (
        SELECT 
            re.payment_id as payment_id,
            COALESCE(jt.cash_amount, 0) as cash_amount,
            COALESCE(jt.credit_amount, 0) as credit_amount,
            COALESCE(jt.gcash_amount, 0) as gcash_amount,
            COALESCE(jt.maya_amount, 0) as maya_amount,
            COALESCE(jt.alipay_amount, 0) as alipay_amount,
            COALESCE(jt.grab_pay_amount, 0) as grab_pay_amount,
            COALESCE(jt.shopee_pay_amount, 0) as shopee_pay_amount,
            COALESCE(jt.ewallet_amount, 0) as ewallet_amount,
            COALESCE(jt.visa_amount, 0) as visa_amount,
            COALESCE(jt.master_card_amount, 0) as master_card_amount,
            COALESCE(jt.discover_card_amount, 0) as discover_card_amount,
            COALESCE(jt.american_express_card_amount, 0) as american_express_card_amount,
            COALESCE(jt.jcb_card_amount, 0) as jcb_card_amount,
            COALESCE(jt.cc_amount, 0) as cc_amount,
            COALESCE(jt.coupon_amount, 0) as coupon_amount,
            ROUND(SUM(re.return_amount), 2) AS total_return_amount
        FROM 
            return_exchange re
        LEFT JOIN (
            SELECT 
                p.id as payment_id,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END, 0)) as coupon_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END, 0)) as cash_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END, 0)) as credit_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'gcash' THEN jt.amount ELSE 0 END, 0)) as gcash_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'maya' THEN jt.amount ELSE 0 END, 0)) as maya_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'alipay' THEN jt.amount ELSE 0 END, 0)) as alipay_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'grab pay' THEN jt.amount ELSE 0 END, 0)) as grab_pay_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'shopee pay' THEN jt.amount ELSE 0 END, 0)) as shopee_pay_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END, 0)) as ewallet_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'visa' THEN jt.amount ELSE 0 END, 0)) as visa_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'master_card' THEN jt.amount ELSE 0 END, 0)) as master_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'discover' THEN jt.amount ELSE 0 END, 0)) as discover_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'american_express' THEN jt.amount ELSE 0 END, 0)) as american_express_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'jcb' THEN jt.amount ELSE 0 END, 0)) as jcb_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('visa', 'master_card', 'discover', 'american_express', 'jcb') THEN jt.amount ELSE 0 END, 0)) as cc_amount
            FROM 
                payments p
            CROSS JOIN JSON_TABLE(
                p.payment_details, '$[*]' COLUMNS (
                    paymentType VARCHAR(255) PATH '$.paymentType', 
                    amount DECIMAL(10, 2) PATH '$.amount'
                )
            ) AS jt
            GROUP BY 
                p.id
        ) jt ON jt.payment_id = re.payment_id
        
        ) AS rc ON rc.payment_id = payments.id
       INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id,is_paid,is_void,cashier_id
        FROM transactions 
        WHERE is_paid = 1 AND is_void = 0
    ) AS transactions ON payments.id = transactions.payment_id
       INNER JOIN users AS u ON u.id = transactions.cashier_id
        WHERE 
            JSON_VALID(payments.payment_details) AND jt.amount != 0.00 
            AND transactions.is_paid = 1 AND transactions.is_void = 0
            AND DATE(payments.date_time_of_payment) BETWEEN :startDate AND :endDate
    GROUP BY 
        u.id
     ORDER BY 
        u.id ASC";

                $sql = $this->connect()->prepare( $sql );
                $sql->bindParam( ':startDate', $startDate );
                $sql->bindParam( ':endDate', $endDate );
                $sql->execute();
                return $sql;
            } else if ( $userId && $singleDateData && !$startDate && !$endDate ) {
                $sql = "SELECT 
            payments.id AS id,
            u.id as id,
            u.first_name as firstname,
            u.last_name as lastname,
            transactions.payment_id,
            transactions.cashier_id,
            transactions.is_paid,
            transactions.is_void, 
            SUM(DISTINCT payments.change_amount) AS change_amount,
            DATE(payments.date_time_of_payment) AS payment_date,
    GREATEST(
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) 
        - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0) 
        - CASE
            WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
                rc.credit_amount
            WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
                (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
            ELSE 
                0
        END, 
        0
    ) AS credit_total,
    
              GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'cash' THEN (jt.amount - payments.change_amount) 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType = 'cash' THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE
                    WHEN rc.cash_amount > 0 AND rc.total_return_amount > rc.cash_amount THEN rc.cash_amount
                    WHEN rc.cash_amount > 0 AND rc.total_return_amount <= rc.cash_amount THEN rc.total_return_amount
                    ELSE 0
                  END,
                0
            ) AS cash_total,
              GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE
                    WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount THEN rc.ewallet_amount
                    WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount THEN rc.total_return_amount - rc.cash_amount
                    ELSE 0
                  END,
                0
            ) AS e_wallet_total,
              GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE 
                    WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) > rc.cc_amount THEN rc.cc_amount
                    WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) <= rc.cc_amount THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount
                    ELSE 0
                  END,
                0
            ) AS cdcards_total,
            GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'coupon' THEN jt.amount 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE
                    WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.coupon_amount) THEN rc.coupon_amount
                    WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.coupon_amount) THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount
                    ELSE 0
                  END,
                0
            ) AS coupons_total,
        GREATEST(
            (SUM(jt.amount) - SUM(DISTINCT payments.change_amount)) 
            - COALESCE(SUM(rf.refunded_amt), 0) 
            - COALESCE(rc.total_return_amount, 0),
            0
        ) AS total_amount,
        
        
            COALESCE(rc.total_return_amount, 0) AS total_return_amount,
            COALESCE(rc.cash_amount, 0) AS return_cash_amount,
            CASE
               WHEN rc.cash_amount > 0 AND (rc.total_return_amount > rc.cash_amount) THEN 
               rc.cash_amount
               WHEN rc.cash_amount > 0 AND (rc.total_return_amount <= rc.cash_amount) THEN
               rc.total_return_amount
            ELSE 0
            END AS tobe_deducted_cash,
            CASE
               WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount) THEN
               rc.ewallet_amount
               WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount) THEN
               rc.total_return_amount - rc.cash_amount
               ELSE 0
             END AS tobe_deducted_ewallet,
                CASE 
                WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) > rc.cc_amount) THEN
                rc.cc_amount
              WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) <= rc.cc_amount)  THEN
              (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount )
             ELSE 0
            END AS tobe_deducted_cc,
            CASE
             WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.cc_amount) THEN
                rc.coupon_amount
              WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.cc_amount) THEN
              (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount)
              ELSE 0
               END AS tobe_deducted_coupon,
      CASE
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
            rc.credit_amount
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
            (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
        ELSE 
            0
    END AS tobe_deducted_credits
    
        FROM 
            payments
        CROSS JOIN JSON_TABLE(
            payments.payment_details, '$[*]' COLUMNS (
                paymentType VARCHAR(255) PATH '$.paymentType', 
                amount DECIMAL(10, 2) PATH '$.amount'
            )
        ) AS jt
        INNER JOIN (
            SELECT DISTINCT payment_id, receipt_id 
            FROM transactions 
            WHERE is_paid = 1 AND is_void = 0
        ) AS t ON payments.id = t.payment_id
        LEFT JOIN (
            SELECT payment_id, SUM(refunded_amt) AS refunded_amt
            FROM refunded
            GROUP BY payment_id
        ) AS rf ON rf.payment_id = payments.id
        LEFT JOIN (
        SELECT 
            re.payment_id as payment_id,
            COALESCE(jt.cash_amount, 0) as cash_amount,
            COALESCE(jt.credit_amount, 0) as credit_amount,
            COALESCE(jt.gcash_amount, 0) as gcash_amount,
            COALESCE(jt.maya_amount, 0) as maya_amount,
            COALESCE(jt.alipay_amount, 0) as alipay_amount,
            COALESCE(jt.grab_pay_amount, 0) as grab_pay_amount,
            COALESCE(jt.shopee_pay_amount, 0) as shopee_pay_amount,
            COALESCE(jt.ewallet_amount, 0) as ewallet_amount,
            COALESCE(jt.visa_amount, 0) as visa_amount,
            COALESCE(jt.master_card_amount, 0) as master_card_amount,
            COALESCE(jt.discover_card_amount, 0) as discover_card_amount,
            COALESCE(jt.american_express_card_amount, 0) as american_express_card_amount,
            COALESCE(jt.jcb_card_amount, 0) as jcb_card_amount,
            COALESCE(jt.cc_amount, 0) as cc_amount,
            COALESCE(jt.coupon_amount, 0) as coupon_amount,
            ROUND(SUM(re.return_amount), 2) AS total_return_amount
        FROM 
            return_exchange re
        LEFT JOIN (
            SELECT 
                p.id as payment_id,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END, 0)) as coupon_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END, 0)) as cash_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END, 0)) as credit_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'gcash' THEN jt.amount ELSE 0 END, 0)) as gcash_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'maya' THEN jt.amount ELSE 0 END, 0)) as maya_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'alipay' THEN jt.amount ELSE 0 END, 0)) as alipay_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'grab pay' THEN jt.amount ELSE 0 END, 0)) as grab_pay_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'shopee pay' THEN jt.amount ELSE 0 END, 0)) as shopee_pay_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END, 0)) as ewallet_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'visa' THEN jt.amount ELSE 0 END, 0)) as visa_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'master_card' THEN jt.amount ELSE 0 END, 0)) as master_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'discover' THEN jt.amount ELSE 0 END, 0)) as discover_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'american_express' THEN jt.amount ELSE 0 END, 0)) as american_express_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'jcb' THEN jt.amount ELSE 0 END, 0)) as jcb_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('visa', 'master_card', 'discover', 'american_express', 'jcb') THEN jt.amount ELSE 0 END, 0)) as cc_amount
            FROM 
                payments p
            CROSS JOIN JSON_TABLE(
                p.payment_details, '$[*]' COLUMNS (
                    paymentType VARCHAR(255) PATH '$.paymentType', 
                    amount DECIMAL(10, 2) PATH '$.amount'
                )
            ) AS jt
            GROUP BY 
                p.id
        ) jt ON jt.payment_id = re.payment_id
        
        ) AS rc ON rc.payment_id = payments.id
       INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id,is_paid,is_void,cashier_id
        FROM transactions 
        WHERE is_paid = 1 AND is_void = 0
    ) AS transactions ON payments.id = transactions.payment_id
       INNER JOIN users AS u ON u.id = transactions.cashier_id
        WHERE 
            JSON_VALID(payments.payment_details) AND jt.amount != 0.00 
            AND transactions.is_paid = 1 AND transactions.is_void = 0
            AND u.id = :userId AND DATE(payments.date_time_of_payment) = :singleDateData
    GROUP BY 
        u.id
     ORDER BY 
        u.id ASC";

                $sql = $this->connect()->prepare( $sql );
                $sql->bindParam( ':userId', $userId );
                $sql->bindParam( ':singleDateData',  $singleDateData );
                $sql->execute();
                return $sql;
            } else if ( $userId && !$singleDateData && $startDate && $endDate ) {
                $sql = "SELECT 
            payments.id AS id,
            u.id as id,
            u.first_name as firstname,
            u.last_name as lastname,
            transactions.payment_id,
            transactions.cashier_id,
            transactions.is_paid,
            transactions.is_void, 
            SUM(DISTINCT payments.change_amount) AS change_amount,
            DATE(payments.date_time_of_payment) AS payment_date,
    GREATEST(
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) 
        - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0) 
        - CASE
            WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
                rc.credit_amount
            WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
                (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
            ELSE 
                0
        END, 
        0
    ) AS credit_total,
    
              GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'cash' THEN (jt.amount - payments.change_amount) 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType = 'cash' THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE
                    WHEN rc.cash_amount > 0 AND rc.total_return_amount > rc.cash_amount THEN rc.cash_amount
                    WHEN rc.cash_amount > 0 AND rc.total_return_amount <= rc.cash_amount THEN rc.total_return_amount
                    ELSE 0
                  END,
                0
            ) AS cash_total,
              GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE
                    WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount THEN rc.ewallet_amount
                    WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount THEN rc.total_return_amount - rc.cash_amount
                    ELSE 0
                  END,
                0
            ) AS e_wallet_total,
              GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE 
                    WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) > rc.cc_amount THEN rc.cc_amount
                    WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) <= rc.cc_amount THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount
                    ELSE 0
                  END,
                0
            ) AS cdcards_total,
            GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'coupon' THEN jt.amount 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE
                    WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.coupon_amount) THEN rc.coupon_amount
                    WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.coupon_amount) THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount
                    ELSE 0
                  END,
                0
            ) AS coupons_total,
        GREATEST(
            (SUM(jt.amount) - SUM(DISTINCT payments.change_amount)) 
            - COALESCE(SUM(rf.refunded_amt), 0) 
            - COALESCE(rc.total_return_amount, 0),
            0
        ) AS total_amount,
        
        
            COALESCE(rc.total_return_amount, 0) AS total_return_amount,
            COALESCE(rc.cash_amount, 0) AS return_cash_amount,
            CASE
               WHEN rc.cash_amount > 0 AND (rc.total_return_amount > rc.cash_amount) THEN 
               rc.cash_amount
               WHEN rc.cash_amount > 0 AND (rc.total_return_amount <= rc.cash_amount) THEN
               rc.total_return_amount
            ELSE 0
            END AS tobe_deducted_cash,
            CASE
               WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount) THEN
               rc.ewallet_amount
               WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount) THEN
               rc.total_return_amount - rc.cash_amount
               ELSE 0
             END AS tobe_deducted_ewallet,
                CASE 
                WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) > rc.cc_amount) THEN
                rc.cc_amount
              WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) <= rc.cc_amount)  THEN
              (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount )
             ELSE 0
            END AS tobe_deducted_cc,
            CASE
             WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.cc_amount) THEN
                rc.coupon_amount
              WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.cc_amount) THEN
              (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount)
              ELSE 0
               END AS tobe_deducted_coupon,
      CASE
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
            rc.credit_amount
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
            (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
        ELSE 
            0
    END AS tobe_deducted_credits
    
        FROM 
            payments
        CROSS JOIN JSON_TABLE(
            payments.payment_details, '$[*]' COLUMNS (
                paymentType VARCHAR(255) PATH '$.paymentType', 
                amount DECIMAL(10, 2) PATH '$.amount'
            )
        ) AS jt
        INNER JOIN (
            SELECT DISTINCT payment_id, receipt_id 
            FROM transactions 
            WHERE is_paid = 1 AND is_void = 0
        ) AS t ON payments.id = t.payment_id
        LEFT JOIN (
            SELECT payment_id, SUM(refunded_amt) AS refunded_amt
            FROM refunded
            GROUP BY payment_id
        ) AS rf ON rf.payment_id = payments.id
        LEFT JOIN (
        SELECT 
            re.payment_id as payment_id,
            COALESCE(jt.cash_amount, 0) as cash_amount,
            COALESCE(jt.credit_amount, 0) as credit_amount,
            COALESCE(jt.gcash_amount, 0) as gcash_amount,
            COALESCE(jt.maya_amount, 0) as maya_amount,
            COALESCE(jt.alipay_amount, 0) as alipay_amount,
            COALESCE(jt.grab_pay_amount, 0) as grab_pay_amount,
            COALESCE(jt.shopee_pay_amount, 0) as shopee_pay_amount,
            COALESCE(jt.ewallet_amount, 0) as ewallet_amount,
            COALESCE(jt.visa_amount, 0) as visa_amount,
            COALESCE(jt.master_card_amount, 0) as master_card_amount,
            COALESCE(jt.discover_card_amount, 0) as discover_card_amount,
            COALESCE(jt.american_express_card_amount, 0) as american_express_card_amount,
            COALESCE(jt.jcb_card_amount, 0) as jcb_card_amount,
            COALESCE(jt.cc_amount, 0) as cc_amount,
            COALESCE(jt.coupon_amount, 0) as coupon_amount,
            ROUND(SUM(re.return_amount), 2) AS total_return_amount
        FROM 
            return_exchange re
        LEFT JOIN (
            SELECT 
                p.id as payment_id,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END, 0)) as coupon_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END, 0)) as cash_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END, 0)) as credit_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'gcash' THEN jt.amount ELSE 0 END, 0)) as gcash_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'maya' THEN jt.amount ELSE 0 END, 0)) as maya_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'alipay' THEN jt.amount ELSE 0 END, 0)) as alipay_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'grab pay' THEN jt.amount ELSE 0 END, 0)) as grab_pay_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'shopee pay' THEN jt.amount ELSE 0 END, 0)) as shopee_pay_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END, 0)) as ewallet_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'visa' THEN jt.amount ELSE 0 END, 0)) as visa_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'master_card' THEN jt.amount ELSE 0 END, 0)) as master_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'discover' THEN jt.amount ELSE 0 END, 0)) as discover_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'american_express' THEN jt.amount ELSE 0 END, 0)) as american_express_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'jcb' THEN jt.amount ELSE 0 END, 0)) as jcb_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('visa', 'master_card', 'discover', 'american_express', 'jcb') THEN jt.amount ELSE 0 END, 0)) as cc_amount
            FROM 
                payments p
            CROSS JOIN JSON_TABLE(
                p.payment_details, '$[*]' COLUMNS (
                    paymentType VARCHAR(255) PATH '$.paymentType', 
                    amount DECIMAL(10, 2) PATH '$.amount'
                )
            ) AS jt
            GROUP BY 
                p.id
        ) jt ON jt.payment_id = re.payment_id
        
        ) AS rc ON rc.payment_id = payments.id
       INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id,is_paid,is_void,cashier_id
        FROM transactions 
        WHERE is_paid = 1 AND is_void = 0
    ) AS transactions ON payments.id = transactions.payment_id
       INNER JOIN users AS u ON u.id = transactions.cashier_id
        WHERE 
            JSON_VALID(payments.payment_details) AND jt.amount != 0.00 
            AND transactions.is_paid = 1 AND transactions.is_void = 0
            AND u.id = :userId AND DATE(payments.date_time_of_payment) BETWEEN :startDate AND :endDate
     GROUP BY 
        u.id
     ORDER BY 
        u.id ASC";

                $sql = $this->connect()->prepare( $sql );
                $sql->bindParam( ':userId', $userId );
                $sql->bindParam( ':startDate', $startDate );
                $sql->bindParam( ':endDate', $endDate );
                $sql->execute();
                return $sql;
            } else {
                $sql = "SELECT 
            payments.id AS id,
            u.id as id,
            u.first_name as firstname,
            u.last_name as lastname,
            transactions.payment_id,
            transactions.cashier_id,
            transactions.is_paid,
            transactions.is_void, 
            SUM(DISTINCT payments.change_amount) AS change_amount,
            DATE(payments.date_time_of_payment) AS payment_date,
    GREATEST(
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) 
        - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0) 
        - CASE
            WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
                rc.credit_amount
            WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
                (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
            ELSE 
                0
        END, 
        0
    ) AS credit_total,
    
              GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'cash' THEN (jt.amount - payments.change_amount) 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType = 'cash' THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE
                    WHEN rc.cash_amount > 0 AND rc.total_return_amount > rc.cash_amount THEN rc.cash_amount
                    WHEN rc.cash_amount > 0 AND rc.total_return_amount <= rc.cash_amount THEN rc.total_return_amount
                    ELSE 0
                  END,
                0
            ) AS cash_total,
              GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE
                    WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount THEN rc.ewallet_amount
                    WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount THEN rc.total_return_amount - rc.cash_amount
                    ELSE 0
                  END,
                0
            ) AS e_wallet_total,
              GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE 
                    WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) > rc.cc_amount THEN rc.cc_amount
                    WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) <= rc.cc_amount THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount
                    ELSE 0
                  END,
                0
            ) AS cdcards_total,
            GREATEST(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'coupon' THEN jt.amount 
                        ELSE 0 
                    END
                ) 
                - COALESCE(
                    SUM(
                        CASE 
                            WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt 
                            ELSE 0 
                        END
                    ), 0
                )
                - CASE
                    WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.coupon_amount) THEN rc.coupon_amount
                    WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.coupon_amount) THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount
                    ELSE 0
                  END,
                0
            ) AS coupons_total,
        GREATEST(
            (SUM(jt.amount) - SUM(DISTINCT payments.change_amount)) 
            - COALESCE(SUM(rf.refunded_amt), 0) 
            - COALESCE(rc.total_return_amount, 0),
            0
        ) AS total_amount,
        
        
            COALESCE(rc.total_return_amount, 0) AS total_return_amount,
            COALESCE(rc.cash_amount, 0) AS return_cash_amount,
            CASE
               WHEN rc.cash_amount > 0 AND (rc.total_return_amount > rc.cash_amount) THEN 
               rc.cash_amount
               WHEN rc.cash_amount > 0 AND (rc.total_return_amount <= rc.cash_amount) THEN
               rc.total_return_amount
            ELSE 0
            END AS tobe_deducted_cash,
            CASE
               WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount) THEN
               rc.ewallet_amount
               WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount) THEN
               rc.total_return_amount - rc.cash_amount
               ELSE 0
             END AS tobe_deducted_ewallet,
                CASE 
                WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) > rc.cc_amount) THEN
                rc.cc_amount
              WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) <= rc.cc_amount)  THEN
              (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount )
             ELSE 0
            END AS tobe_deducted_cc,
            CASE
             WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.cc_amount) THEN
                rc.coupon_amount
              WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.cc_amount) THEN
              (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount)
              ELSE 0
               END AS tobe_deducted_coupon,
      CASE
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
            rc.credit_amount
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
            (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
        ELSE 
            0
    END AS tobe_deducted_credits
    
        FROM 
            payments
        CROSS JOIN JSON_TABLE(
            payments.payment_details, '$[*]' COLUMNS (
                paymentType VARCHAR(255) PATH '$.paymentType', 
                amount DECIMAL(10, 2) PATH '$.amount'
            )
        ) AS jt
        INNER JOIN (
            SELECT DISTINCT payment_id, receipt_id 
            FROM transactions 
            WHERE is_paid = 1 AND is_void = 0
        ) AS t ON payments.id = t.payment_id
        LEFT JOIN (
            SELECT payment_id, SUM(refunded_amt) AS refunded_amt
            FROM refunded
            GROUP BY payment_id
        ) AS rf ON rf.payment_id = payments.id
        LEFT JOIN (
        SELECT 
            re.payment_id as payment_id,
            COALESCE(jt.cash_amount, 0) as cash_amount,
            COALESCE(jt.credit_amount, 0) as credit_amount,
            COALESCE(jt.gcash_amount, 0) as gcash_amount,
            COALESCE(jt.maya_amount, 0) as maya_amount,
            COALESCE(jt.alipay_amount, 0) as alipay_amount,
            COALESCE(jt.grab_pay_amount, 0) as grab_pay_amount,
            COALESCE(jt.shopee_pay_amount, 0) as shopee_pay_amount,
            COALESCE(jt.ewallet_amount, 0) as ewallet_amount,
            COALESCE(jt.visa_amount, 0) as visa_amount,
            COALESCE(jt.master_card_amount, 0) as master_card_amount,
            COALESCE(jt.discover_card_amount, 0) as discover_card_amount,
            COALESCE(jt.american_express_card_amount, 0) as american_express_card_amount,
            COALESCE(jt.jcb_card_amount, 0) as jcb_card_amount,
            COALESCE(jt.cc_amount, 0) as cc_amount,
            COALESCE(jt.coupon_amount, 0) as coupon_amount,
            ROUND(SUM(re.return_amount), 2) AS total_return_amount
        FROM 
            return_exchange re
        LEFT JOIN (
            SELECT 
                p.id as payment_id,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END, 0)) as coupon_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END, 0)) as cash_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END, 0)) as credit_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'gcash' THEN jt.amount ELSE 0 END, 0)) as gcash_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'maya' THEN jt.amount ELSE 0 END, 0)) as maya_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'alipay' THEN jt.amount ELSE 0 END, 0)) as alipay_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'grab pay' THEN jt.amount ELSE 0 END, 0)) as grab_pay_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'shopee pay' THEN jt.amount ELSE 0 END, 0)) as shopee_pay_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END, 0)) as ewallet_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'visa' THEN jt.amount ELSE 0 END, 0)) as visa_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'master_card' THEN jt.amount ELSE 0 END, 0)) as master_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'discover' THEN jt.amount ELSE 0 END, 0)) as discover_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'american_express' THEN jt.amount ELSE 0 END, 0)) as american_express_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'jcb' THEN jt.amount ELSE 0 END, 0)) as jcb_card_amount,
                SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('visa', 'master_card', 'discover', 'american_express', 'jcb') THEN jt.amount ELSE 0 END, 0)) as cc_amount
            FROM 
                payments p
            CROSS JOIN JSON_TABLE(
                p.payment_details, '$[*]' COLUMNS (
                    paymentType VARCHAR(255) PATH '$.paymentType', 
                    amount DECIMAL(10, 2) PATH '$.amount'
                )
            ) AS jt
            GROUP BY 
                p.id
        ) jt ON jt.payment_id = re.payment_id
        
        ) AS rc ON rc.payment_id = payments.id
       INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id,is_paid,is_void,cashier_id
        FROM transactions 
        WHERE is_paid = 1 AND is_void = 0
    ) AS transactions ON payments.id = transactions.payment_id
       INNER JOIN users AS u ON u.id = transactions.cashier_id
        WHERE 
            JSON_VALID(payments.payment_details) AND jt.amount != 0.00 
            AND transactions.is_paid = 1 AND transactions.is_void = 0
        GROUP BY 
        u.id
     ORDER BY 
        u.id ASC";

                $stmt = $this->connect()->query( $sql );
                return $stmt;
            }

        } else {
            if ( $userId && !$singleDateData && !$startDate && !$endDate ) {
                $sql = "SELECT 
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        (SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END)-SUM(DISTINCT payments.change_amount))AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) - SUM(DISTINCT payments.change_amount) AS total_amount
    FROM 
        payments
    CROSS JOIN JSON_TABLE(
        payments.payment_details, '$[*]' COLUMNS (
            paymentType VARCHAR(255) PATH '$.paymentType', 
            amount DECIMAL(10, 2) PATH '$.amount'
        )
    ) AS jt
    INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id, cashier_id FROM transactions WHERE is_paid = 1 AND is_void = 0
    ) AS t ON payments.id = t.payment_id
    INNER JOIN users AS u ON u.id = t.cashier_id
    WHERE 
        JSON_VALID(payments.payment_details) AND jt.amount != 0.00 AND u.id = :userId
    GROUP BY 
        u.id
    ORDER BY 
        u.id ASC";

                $sql = $this->connect()->prepare( $sql );
                $sql->bindParam( ':userId', $userId );
                $sql->execute();
                return $sql;
            } else if ( !$userId && $singleDateData && !$startDate && !$endDate ) {
                $sql = "SELECT 
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        (SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END)-SUM(DISTINCT payments.change_amount))AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) - SUM(DISTINCT payments.change_amount) AS total_amount
    FROM 
        payments
    CROSS JOIN JSON_TABLE(
        payments.payment_details, '$[*]' COLUMNS (
            paymentType VARCHAR(255) PATH '$.paymentType', 
            amount DECIMAL(10, 2) PATH '$.amount'
        )
    ) AS jt
    INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id, cashier_id FROM transactions WHERE is_paid = 1 AND is_void = 0
    ) AS t ON payments.id = t.payment_id
    INNER JOIN users AS u ON u.id = t.cashier_id
    WHERE 
        JSON_VALID(payments.payment_details) AND jt.amount != 0.00 AND   DATE(payments.date_time_of_payment) = :singleDateData
    GROUP BY 
        u.id
    ORDER BY 
        u.id ASC";

                $sql = $this->connect()->prepare( $sql );
                $sql->bindParam( ':singleDateData',  $singleDateData );
                $sql->execute();
                return $sql;
            } else if ( !$userId && !$singleDateData && $startDate && $endDate ) {
                $sql = "SELECT 
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        (SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END)-SUM(DISTINCT payments.change_amount))AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) - SUM(DISTINCT payments.change_amount) AS total_amount
    FROM 
        payments
    CROSS JOIN JSON_TABLE(
        payments.payment_details, '$[*]' COLUMNS (
            paymentType VARCHAR(255) PATH '$.paymentType', 
            amount DECIMAL(10, 2) PATH '$.amount'
        )
    ) AS jt
    INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id, cashier_id FROM transactions WHERE is_paid = 1 AND is_void = 0
    ) AS t ON payments.id = t.payment_id
    INNER JOIN users AS u ON u.id = t.cashier_id
    WHERE 
        JSON_VALID(payments.payment_details) AND jt.amount != 0.00 AND   DATE(payments.date_time_of_payment) BETWEEN :startDate AND :endDate
    GROUP BY 
        u.id
    ORDER BY 
        u.id ASC";
                $sql = $this->connect()->prepare( $sql );
                $sql->bindParam( ':startDate', $startDate );
                $sql->bindParam( ':endDate', $endDate );
                $sql->execute();
                return $sql;
            } else if ( $userId && $singleDateData && !$startDate && !$endDate ) {
                $sql = "SELECT 
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        (SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END)-SUM(DISTINCT payments.change_amount))AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) - SUM(DISTINCT payments.change_amount) AS total_amount
    FROM 
        payments
    CROSS JOIN JSON_TABLE(
        payments.payment_details, '$[*]' COLUMNS (
            paymentType VARCHAR(255) PATH '$.paymentType', 
            amount DECIMAL(10, 2) PATH '$.amount'
        )
    ) AS jt
    INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id, cashier_id FROM transactions WHERE is_paid = 1 AND is_void = 0
    ) AS t ON payments.id = t.payment_id
    INNER JOIN users AS u ON u.id = t.cashier_id
    WHERE 
        JSON_VALID(payments.payment_details) AND jt.amount != 0.00 AND u.id = :userId AND  DATE(payments.date_time_of_payment) = :singleDateData
    GROUP BY 
        u.id
    ORDER BY 
        u.id ASC";

                $sql = $this->connect()->prepare( $sql );
                $sql->bindParam( ':userId', $userId );
                $sql->bindParam( ':singleDateData',  $singleDateData );
                $sql->execute();
                return $sql;
            } else if ( $userId && !$singleDateData && $startDate && $endDate ) {
                $sql = "SELECT 
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        (SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END)-SUM(DISTINCT payments.change_amount))AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) - SUM(DISTINCT payments.change_amount) AS total_amount
    FROM 
        payments
    CROSS JOIN JSON_TABLE(
        payments.payment_details, '$[*]' COLUMNS (
            paymentType VARCHAR(255) PATH '$.paymentType', 
            amount DECIMAL(10, 2) PATH '$.amount'
        )
    ) AS jt
    INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id, cashier_id FROM transactions WHERE is_paid = 1 AND is_void = 0
    ) AS t ON payments.id = t.payment_id
    INNER JOIN users AS u ON u.id = t.cashier_id
    WHERE 
        JSON_VALID(payments.payment_details) AND jt.amount != 0.00 AND u.id = :userId AND DATE(payments.date_time_of_payment) BETWEEN :startDate AND :endDate
    GROUP BY 
        u.id
    ORDER BY 
        u.id ASC";
                $sql = $this->connect()->prepare( $sql );
                $sql->bindParam( ':userId', $userId );
                $sql->bindParam( ':startDate', $startDate );
                $sql->bindParam( ':endDate', $endDate );
                $sql->execute();
                return $sql;
            } else {
                $sql = "SELECT 
            u.id as id,
            u.first_name as firstname,
            u.last_name as lastname,
            DATE(payments.date_time_of_payment) AS payment_date,
            SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
            (SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END)-SUM(DISTINCT payments.change_amount))AS cash_total,
            SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
            SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
            SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
            SUM(jt.amount) - SUM(DISTINCT payments.change_amount) AS total_amount
        FROM 
            payments
        CROSS JOIN JSON_TABLE(
            payments.payment_details, '$[*]' COLUMNS (
                paymentType VARCHAR(255) PATH '$.paymentType', 
                amount DECIMAL(10, 2) PATH '$.amount'
            )
        ) AS jt
        INNER JOIN (
            SELECT DISTINCT payment_id, receipt_id, cashier_id FROM transactions WHERE is_paid = 1 AND is_void = 0
        ) AS t ON payments.id = t.payment_id
        INNER JOIN users AS u ON u.id = t.cashier_id
        WHERE 
            JSON_VALID(payments.payment_details) AND jt.amount != 0.00
        GROUP BY 
            u.id
        ORDER BY 
            u.id ASC";

                $stmt = $this->connect()->query( $sql );
                return $stmt;
            }
        }
    }

    public function getPaymentMethodByCustomer( $customerId, $singleDateData, $startDate, $endDate, $exclude ) {
        if ( $exclude == 1 ) {
            if ( $customerId && !$singleDateData && !$startDate && !$endDate ) {
                $sql = "SELECT 
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0) AS credit_total,
        SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'cash' THEN rf.refunded_amt ELSE 0 END), 0) AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt ELSE 0 END), 0) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt ELSE 0 END), 0) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt ELSE 0 END), 0) AS coupons_total,
        SUM(jt.amount) - COALESCE(SUM(rf.refunded_amt), 0) - COALESCE(SUM(re.total_return_amount), 0) AS total_amount
    FROM 
        payments
    CROSS JOIN JSON_TABLE(
        payments.payment_details, '$[*]' COLUMNS (
            paymentType VARCHAR(255) PATH '$.paymentType', 
            amount DECIMAL(10, 2) PATH '$.amount'
        )
    ) AS jt
    INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id, user_id FROM transactions WHERE is_paid = 1 AND is_void = 0
    ) AS t ON payments.id = t.payment_id
    LEFT JOIN (
        SELECT payment_id, SUM(refunded_amt) AS refunded_amt
        FROM refunded
        GROUP BY payment_id
    ) AS rf ON rf.payment_id = payments.id
    LEFT JOIN (
        SELECT payment_id, SUM(return_amount) AS total_return_amount
        FROM return_exchange
        INNER JOIN products ON products.id = return_exchange.product_id
        GROUP BY payment_id
    ) AS re ON re.payment_id = payments.id
    INNER JOIN users AS u ON u.id = t.user_id
    WHERE 
        JSON_VALID(payments.payment_details) AND jt.amount != 0.00 AND u.id = :customerId
    GROUP BY 
    u.id
    ORDER BY 
        payment_date ASC;";

                $sql = $this->connect()->prepare( $sql );
                $sql->bindParam( ':customerId', $customerId );
                $sql->execute();
                return $sql;

            } else if ( !$customerId && $singleDateData && !$startDate && !$endDate ) {
                $sql = "SELECT 
        payments.id AS id,
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        transactions.payment_id,
        transactions.user_id,
        transactions.is_paid,
        transactions.is_void, 
        SUM(DISTINCT payments.change_amount) AS change_amount,
        DATE(payments.date_time_of_payment) AS payment_date,
GREATEST(
    SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) 
    - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0) 
    - CASE
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
            rc.credit_amount
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
            (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
        ELSE 
            0
    END, 
    0
) AS credit_total,

          GREATEST(
            SUM(
                CASE 
                    WHEN jt.paymentType = 'cash' THEN (jt.amount - payments.change_amount) 
                    ELSE 0 
                END
            ) 
            - COALESCE(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'cash' THEN rf.refunded_amt 
                        ELSE 0 
                    END
                ), 0
            )
            - CASE
                WHEN rc.cash_amount > 0 AND rc.total_return_amount > rc.cash_amount THEN rc.cash_amount
                WHEN rc.cash_amount > 0 AND rc.total_return_amount <= rc.cash_amount THEN rc.total_return_amount
                ELSE 0
              END,
            0
        ) AS cash_total,
          GREATEST(
            SUM(
                CASE 
                    WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount 
                    ELSE 0 
                END
            ) 
            - COALESCE(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt 
                        ELSE 0 
                    END
                ), 0
            )
            - CASE
                WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount THEN rc.ewallet_amount
                WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount THEN rc.total_return_amount - rc.cash_amount
                ELSE 0
              END,
            0
        ) AS e_wallet_total,
          GREATEST(
            SUM(
                CASE 
                    WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount 
                    ELSE 0 
                END
            ) 
            - COALESCE(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt 
                        ELSE 0 
                    END
                ), 0
            )
            - CASE 
                WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) > rc.cc_amount THEN rc.cc_amount
                WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) <= rc.cc_amount THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount
                ELSE 0
              END,
            0
        ) AS cdcards_total,
        GREATEST(
            SUM(
                CASE 
                    WHEN jt.paymentType = 'coupon' THEN jt.amount 
                    ELSE 0 
                END
            ) 
            - COALESCE(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt 
                        ELSE 0 
                    END
                ), 0
            )
            - CASE
                WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.coupon_amount) THEN rc.coupon_amount
                WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.coupon_amount) THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount
                ELSE 0
              END,
            0
        ) AS coupons_total,
    GREATEST(
        (SUM(jt.amount) - SUM(DISTINCT payments.change_amount)) 
        - COALESCE(SUM(rf.refunded_amt), 0) 
        - COALESCE(rc.total_return_amount, 0),
        0
    ) AS total_amount,
    
    
        COALESCE(rc.total_return_amount, 0) AS total_return_amount,
        COALESCE(rc.cash_amount, 0) AS return_cash_amount,
        CASE
           WHEN rc.cash_amount > 0 AND (rc.total_return_amount > rc.cash_amount) THEN 
           rc.cash_amount
           WHEN rc.cash_amount > 0 AND (rc.total_return_amount <= rc.cash_amount) THEN
           rc.total_return_amount
        ELSE 0
        END AS tobe_deducted_cash,
        CASE
           WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount) THEN
           rc.ewallet_amount
           WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount) THEN
           rc.total_return_amount - rc.cash_amount
           ELSE 0
         END AS tobe_deducted_ewallet,
            CASE 
            WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) > rc.cc_amount) THEN
            rc.cc_amount
          WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) <= rc.cc_amount)  THEN
          (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount )
         ELSE 0
        END AS tobe_deducted_cc,
        CASE
         WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.cc_amount) THEN
            rc.coupon_amount
          WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.cc_amount) THEN
          (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount)
          ELSE 0
           END AS tobe_deducted_coupon,
  CASE
    WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
        rc.credit_amount
    WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
        (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
    ELSE 
        0
END AS tobe_deducted_credits

    FROM 
        payments
    CROSS JOIN JSON_TABLE(
        payments.payment_details, '$[*]' COLUMNS (
            paymentType VARCHAR(255) PATH '$.paymentType', 
            amount DECIMAL(10, 2) PATH '$.amount'
        )
    ) AS jt
    INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id 
        FROM transactions 
        WHERE is_paid = 1 AND is_void = 0
    ) AS t ON payments.id = t.payment_id
    LEFT JOIN (
        SELECT payment_id, SUM(refunded_amt) AS refunded_amt
        FROM refunded
        GROUP BY payment_id
    ) AS rf ON rf.payment_id = payments.id
    LEFT JOIN (
    SELECT 
        re.payment_id as payment_id,
        COALESCE(jt.cash_amount, 0) as cash_amount,
        COALESCE(jt.credit_amount, 0) as credit_amount,
        COALESCE(jt.gcash_amount, 0) as gcash_amount,
        COALESCE(jt.maya_amount, 0) as maya_amount,
        COALESCE(jt.alipay_amount, 0) as alipay_amount,
        COALESCE(jt.grab_pay_amount, 0) as grab_pay_amount,
        COALESCE(jt.shopee_pay_amount, 0) as shopee_pay_amount,
        COALESCE(jt.ewallet_amount, 0) as ewallet_amount,
        COALESCE(jt.visa_amount, 0) as visa_amount,
        COALESCE(jt.master_card_amount, 0) as master_card_amount,
        COALESCE(jt.discover_card_amount, 0) as discover_card_amount,
        COALESCE(jt.american_express_card_amount, 0) as american_express_card_amount,
        COALESCE(jt.jcb_card_amount, 0) as jcb_card_amount,
        COALESCE(jt.cc_amount, 0) as cc_amount,
        COALESCE(jt.coupon_amount, 0) as coupon_amount,
        ROUND(SUM(re.return_amount), 2) AS total_return_amount
    FROM 
        return_exchange re
    LEFT JOIN (
        SELECT 
            p.id as payment_id,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END, 0)) as coupon_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END, 0)) as cash_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END, 0)) as credit_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'gcash' THEN jt.amount ELSE 0 END, 0)) as gcash_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'maya' THEN jt.amount ELSE 0 END, 0)) as maya_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'alipay' THEN jt.amount ELSE 0 END, 0)) as alipay_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'grab pay' THEN jt.amount ELSE 0 END, 0)) as grab_pay_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'shopee pay' THEN jt.amount ELSE 0 END, 0)) as shopee_pay_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END, 0)) as ewallet_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'visa' THEN jt.amount ELSE 0 END, 0)) as visa_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'master_card' THEN jt.amount ELSE 0 END, 0)) as master_card_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'discover' THEN jt.amount ELSE 0 END, 0)) as discover_card_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'american_express' THEN jt.amount ELSE 0 END, 0)) as american_express_card_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'jcb' THEN jt.amount ELSE 0 END, 0)) as jcb_card_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('visa', 'master_card', 'discover', 'american_express', 'jcb') THEN jt.amount ELSE 0 END, 0)) as cc_amount
        FROM 
            payments p
        CROSS JOIN JSON_TABLE(
            p.payment_details, '$[*]' COLUMNS (
                paymentType VARCHAR(255) PATH '$.paymentType', 
                amount DECIMAL(10, 2) PATH '$.amount'
            )
        ) AS jt
        GROUP BY 
            p.id
    ) jt ON jt.payment_id = re.payment_id
    
    ) AS rc ON rc.payment_id = payments.id
   INNER JOIN (
    SELECT DISTINCT payment_id, receipt_id,is_paid,is_void,user_id
    FROM transactions 
    WHERE is_paid = 1 AND is_void = 0
) AS transactions ON payments.id = transactions.payment_id
   INNER JOIN users AS u ON u.id = transactions.user_id
    WHERE 
        JSON_VALID(payments.payment_details) AND jt.amount != 0.00 
        AND transactions.is_paid = 1 AND transactions.is_void = 0
        AND DATE(payments.date_time_of_payment) = :singleDateData
       u.id
    ORDER BY 
       u.first_name ASC;";

                $sql = $this->connect()->prepare( $sql );
                $sql->bindParam( ':singleDateData',  $singleDateData );
                $sql->execute();
                return $sql;

            } else if ( !$customerId && !$singleDateData && $startDate && $endDate ) {
                $sql = "SELECT 
        payments.id AS id,
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        transactions.payment_id,
        transactions.user_id,
        transactions.is_paid,
        transactions.is_void, 
        SUM(DISTINCT payments.change_amount) AS change_amount,
        DATE(payments.date_time_of_payment) AS payment_date,
GREATEST(
    SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) 
    - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0) 
    - CASE
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
            rc.credit_amount
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
            (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
        ELSE 
            0
    END, 
    0
) AS credit_total,

          GREATEST(
            SUM(
                CASE 
                    WHEN jt.paymentType = 'cash' THEN (jt.amount - payments.change_amount) 
                    ELSE 0 
                END
            ) 
            - COALESCE(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'cash' THEN rf.refunded_amt 
                        ELSE 0 
                    END
                ), 0
            )
            - CASE
                WHEN rc.cash_amount > 0 AND rc.total_return_amount > rc.cash_amount THEN rc.cash_amount
                WHEN rc.cash_amount > 0 AND rc.total_return_amount <= rc.cash_amount THEN rc.total_return_amount
                ELSE 0
              END,
            0
        ) AS cash_total,
          GREATEST(
            SUM(
                CASE 
                    WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount 
                    ELSE 0 
                END
            ) 
            - COALESCE(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt 
                        ELSE 0 
                    END
                ), 0
            )
            - CASE
                WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount THEN rc.ewallet_amount
                WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount THEN rc.total_return_amount - rc.cash_amount
                ELSE 0
              END,
            0
        ) AS e_wallet_total,
          GREATEST(
            SUM(
                CASE 
                    WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount 
                    ELSE 0 
                END
            ) 
            - COALESCE(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt 
                        ELSE 0 
                    END
                ), 0
            )
            - CASE 
                WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) > rc.cc_amount THEN rc.cc_amount
                WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) <= rc.cc_amount THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount
                ELSE 0
              END,
            0
        ) AS cdcards_total,
        GREATEST(
            SUM(
                CASE 
                    WHEN jt.paymentType = 'coupon' THEN jt.amount 
                    ELSE 0 
                END
            ) 
            - COALESCE(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt 
                        ELSE 0 
                    END
                ), 0
            )
            - CASE
                WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.coupon_amount) THEN rc.coupon_amount
                WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.coupon_amount) THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount
                ELSE 0
              END,
            0
        ) AS coupons_total,
    GREATEST(
        (SUM(jt.amount) - SUM(DISTINCT payments.change_amount)) 
        - COALESCE(SUM(rf.refunded_amt), 0) 
        - COALESCE(rc.total_return_amount, 0),
        0
    ) AS total_amount,
    
    
        COALESCE(rc.total_return_amount, 0) AS total_return_amount,
        COALESCE(rc.cash_amount, 0) AS return_cash_amount,
        CASE
           WHEN rc.cash_amount > 0 AND (rc.total_return_amount > rc.cash_amount) THEN 
           rc.cash_amount
           WHEN rc.cash_amount > 0 AND (rc.total_return_amount <= rc.cash_amount) THEN
           rc.total_return_amount
        ELSE 0
        END AS tobe_deducted_cash,
        CASE
           WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount) THEN
           rc.ewallet_amount
           WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount) THEN
           rc.total_return_amount - rc.cash_amount
           ELSE 0
         END AS tobe_deducted_ewallet,
            CASE 
            WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) > rc.cc_amount) THEN
            rc.cc_amount
          WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) <= rc.cc_amount)  THEN
          (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount )
         ELSE 0
        END AS tobe_deducted_cc,
        CASE
         WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.cc_amount) THEN
            rc.coupon_amount
          WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.cc_amount) THEN
          (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount)
          ELSE 0
           END AS tobe_deducted_coupon,
  CASE
    WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
        rc.credit_amount
    WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
        (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
    ELSE 
        0
END AS tobe_deducted_credits

    FROM 
        payments
    CROSS JOIN JSON_TABLE(
        payments.payment_details, '$[*]' COLUMNS (
            paymentType VARCHAR(255) PATH '$.paymentType', 
            amount DECIMAL(10, 2) PATH '$.amount'
        )
    ) AS jt
    INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id 
        FROM transactions 
        WHERE is_paid = 1 AND is_void = 0
    ) AS t ON payments.id = t.payment_id
    LEFT JOIN (
        SELECT payment_id, SUM(refunded_amt) AS refunded_amt
        FROM refunded
        GROUP BY payment_id
    ) AS rf ON rf.payment_id = payments.id
    LEFT JOIN (
    SELECT 
        re.payment_id as payment_id,
        COALESCE(jt.cash_amount, 0) as cash_amount,
        COALESCE(jt.credit_amount, 0) as credit_amount,
        COALESCE(jt.gcash_amount, 0) as gcash_amount,
        COALESCE(jt.maya_amount, 0) as maya_amount,
        COALESCE(jt.alipay_amount, 0) as alipay_amount,
        COALESCE(jt.grab_pay_amount, 0) as grab_pay_amount,
        COALESCE(jt.shopee_pay_amount, 0) as shopee_pay_amount,
        COALESCE(jt.ewallet_amount, 0) as ewallet_amount,
        COALESCE(jt.visa_amount, 0) as visa_amount,
        COALESCE(jt.master_card_amount, 0) as master_card_amount,
        COALESCE(jt.discover_card_amount, 0) as discover_card_amount,
        COALESCE(jt.american_express_card_amount, 0) as american_express_card_amount,
        COALESCE(jt.jcb_card_amount, 0) as jcb_card_amount,
        COALESCE(jt.cc_amount, 0) as cc_amount,
        COALESCE(jt.coupon_amount, 0) as coupon_amount,
        ROUND(SUM(re.return_amount), 2) AS total_return_amount
    FROM 
        return_exchange re
    LEFT JOIN (
        SELECT 
            p.id as payment_id,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END, 0)) as coupon_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END, 0)) as cash_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END, 0)) as credit_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'gcash' THEN jt.amount ELSE 0 END, 0)) as gcash_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'maya' THEN jt.amount ELSE 0 END, 0)) as maya_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'alipay' THEN jt.amount ELSE 0 END, 0)) as alipay_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'grab pay' THEN jt.amount ELSE 0 END, 0)) as grab_pay_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'shopee pay' THEN jt.amount ELSE 0 END, 0)) as shopee_pay_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END, 0)) as ewallet_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'visa' THEN jt.amount ELSE 0 END, 0)) as visa_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'master_card' THEN jt.amount ELSE 0 END, 0)) as master_card_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'discover' THEN jt.amount ELSE 0 END, 0)) as discover_card_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'american_express' THEN jt.amount ELSE 0 END, 0)) as american_express_card_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'jcb' THEN jt.amount ELSE 0 END, 0)) as jcb_card_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('visa', 'master_card', 'discover', 'american_express', 'jcb') THEN jt.amount ELSE 0 END, 0)) as cc_amount
        FROM 
            payments p
        CROSS JOIN JSON_TABLE(
            p.payment_details, '$[*]' COLUMNS (
                paymentType VARCHAR(255) PATH '$.paymentType', 
                amount DECIMAL(10, 2) PATH '$.amount'
            )
        ) AS jt
        GROUP BY 
            p.id
    ) jt ON jt.payment_id = re.payment_id
    
    ) AS rc ON rc.payment_id = payments.id
   INNER JOIN (
    SELECT DISTINCT payment_id, receipt_id,is_paid,is_void,user_id
    FROM transactions 
    WHERE is_paid = 1 AND is_void = 0
) AS transactions ON payments.id = transactions.payment_id
   INNER JOIN users AS u ON u.id = transactions.user_id
    WHERE 
        JSON_VALID(payments.payment_details) AND jt.amount != 0.00 
        AND transactions.is_paid = 1 AND transactions.is_void = 0
        AND DATE(payments.date_time_of_payment) BETWEEN :startDate AND :endDate
    GROUP BY 
       u.id
    ORDER BY 
       u.first_name ASC;";

                $sql = $this->connect()->prepare( $sql );
                $sql->bindParam( ':startDate', $startDate );
                $sql->bindParam( ':endDate', $endDate );
                $sql->execute();
                return $sql;

            } else if ( $customerId && $singleDateData && !$startDate && !$endDate ) {
                $sql = "SELECT 
        payments.id AS id,
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        transactions.payment_id,
        transactions.user_id,
        transactions.is_paid,
        transactions.is_void, 
        SUM(DISTINCT payments.change_amount) AS change_amount,
        DATE(payments.date_time_of_payment) AS payment_date,
GREATEST(
    SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) 
    - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0) 
    - CASE
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
            rc.credit_amount
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
            (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
        ELSE 
            0
    END, 
    0
) AS credit_total,

          GREATEST(
            SUM(
                CASE 
                    WHEN jt.paymentType = 'cash' THEN (jt.amount - payments.change_amount) 
                    ELSE 0 
                END
            ) 
            - COALESCE(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'cash' THEN rf.refunded_amt 
                        ELSE 0 
                    END
                ), 0
            )
            - CASE
                WHEN rc.cash_amount > 0 AND rc.total_return_amount > rc.cash_amount THEN rc.cash_amount
                WHEN rc.cash_amount > 0 AND rc.total_return_amount <= rc.cash_amount THEN rc.total_return_amount
                ELSE 0
              END,
            0
        ) AS cash_total,
          GREATEST(
            SUM(
                CASE 
                    WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount 
                    ELSE 0 
                END
            ) 
            - COALESCE(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt 
                        ELSE 0 
                    END
                ), 0
            )
            - CASE
                WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount THEN rc.ewallet_amount
                WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount THEN rc.total_return_amount - rc.cash_amount
                ELSE 0
              END,
            0
        ) AS e_wallet_total,
          GREATEST(
            SUM(
                CASE 
                    WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount 
                    ELSE 0 
                END
            ) 
            - COALESCE(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt 
                        ELSE 0 
                    END
                ), 0
            )
            - CASE 
                WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) > rc.cc_amount THEN rc.cc_amount
                WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) <= rc.cc_amount THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount
                ELSE 0
              END,
            0
        ) AS cdcards_total,
        GREATEST(
            SUM(
                CASE 
                    WHEN jt.paymentType = 'coupon' THEN jt.amount 
                    ELSE 0 
                END
            ) 
            - COALESCE(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt 
                        ELSE 0 
                    END
                ), 0
            )
            - CASE
                WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.coupon_amount) THEN rc.coupon_amount
                WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.coupon_amount) THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount
                ELSE 0
              END,
            0
        ) AS coupons_total,
    GREATEST(
        (SUM(jt.amount) - SUM(DISTINCT payments.change_amount)) 
        - COALESCE(SUM(rf.refunded_amt), 0) 
        - COALESCE(rc.total_return_amount, 0),
        0
    ) AS total_amount,
    
    
        COALESCE(rc.total_return_amount, 0) AS total_return_amount,
        COALESCE(rc.cash_amount, 0) AS return_cash_amount,
        CASE
           WHEN rc.cash_amount > 0 AND (rc.total_return_amount > rc.cash_amount) THEN 
           rc.cash_amount
           WHEN rc.cash_amount > 0 AND (rc.total_return_amount <= rc.cash_amount) THEN
           rc.total_return_amount
        ELSE 0
        END AS tobe_deducted_cash,
        CASE
           WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount) THEN
           rc.ewallet_amount
           WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount) THEN
           rc.total_return_amount - rc.cash_amount
           ELSE 0
         END AS tobe_deducted_ewallet,
            CASE 
            WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) > rc.cc_amount) THEN
            rc.cc_amount
          WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) <= rc.cc_amount)  THEN
          (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount )
         ELSE 0
        END AS tobe_deducted_cc,
        CASE
         WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.cc_amount) THEN
            rc.coupon_amount
          WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.cc_amount) THEN
          (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount)
          ELSE 0
           END AS tobe_deducted_coupon,
  CASE
    WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
        rc.credit_amount
    WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
        (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
    ELSE 
        0
END AS tobe_deducted_credits

    FROM 
        payments
    CROSS JOIN JSON_TABLE(
        payments.payment_details, '$[*]' COLUMNS (
            paymentType VARCHAR(255) PATH '$.paymentType', 
            amount DECIMAL(10, 2) PATH '$.amount'
        )
    ) AS jt
    INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id 
        FROM transactions 
        WHERE is_paid = 1 AND is_void = 0
    ) AS t ON payments.id = t.payment_id
    LEFT JOIN (
        SELECT payment_id, SUM(refunded_amt) AS refunded_amt
        FROM refunded
        GROUP BY payment_id
    ) AS rf ON rf.payment_id = payments.id
    LEFT JOIN (
    SELECT 
        re.payment_id as payment_id,
        COALESCE(jt.cash_amount, 0) as cash_amount,
        COALESCE(jt.credit_amount, 0) as credit_amount,
        COALESCE(jt.gcash_amount, 0) as gcash_amount,
        COALESCE(jt.maya_amount, 0) as maya_amount,
        COALESCE(jt.alipay_amount, 0) as alipay_amount,
        COALESCE(jt.grab_pay_amount, 0) as grab_pay_amount,
        COALESCE(jt.shopee_pay_amount, 0) as shopee_pay_amount,
        COALESCE(jt.ewallet_amount, 0) as ewallet_amount,
        COALESCE(jt.visa_amount, 0) as visa_amount,
        COALESCE(jt.master_card_amount, 0) as master_card_amount,
        COALESCE(jt.discover_card_amount, 0) as discover_card_amount,
        COALESCE(jt.american_express_card_amount, 0) as american_express_card_amount,
        COALESCE(jt.jcb_card_amount, 0) as jcb_card_amount,
        COALESCE(jt.cc_amount, 0) as cc_amount,
        COALESCE(jt.coupon_amount, 0) as coupon_amount,
        ROUND(SUM(re.return_amount), 2) AS total_return_amount
    FROM 
        return_exchange re
    LEFT JOIN (
        SELECT 
            p.id as payment_id,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END, 0)) as coupon_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END, 0)) as cash_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END, 0)) as credit_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'gcash' THEN jt.amount ELSE 0 END, 0)) as gcash_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'maya' THEN jt.amount ELSE 0 END, 0)) as maya_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'alipay' THEN jt.amount ELSE 0 END, 0)) as alipay_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'grab pay' THEN jt.amount ELSE 0 END, 0)) as grab_pay_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'shopee pay' THEN jt.amount ELSE 0 END, 0)) as shopee_pay_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END, 0)) as ewallet_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'visa' THEN jt.amount ELSE 0 END, 0)) as visa_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'master_card' THEN jt.amount ELSE 0 END, 0)) as master_card_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'discover' THEN jt.amount ELSE 0 END, 0)) as discover_card_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'american_express' THEN jt.amount ELSE 0 END, 0)) as american_express_card_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'jcb' THEN jt.amount ELSE 0 END, 0)) as jcb_card_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('visa', 'master_card', 'discover', 'american_express', 'jcb') THEN jt.amount ELSE 0 END, 0)) as cc_amount
        FROM 
            payments p
        CROSS JOIN JSON_TABLE(
            p.payment_details, '$[*]' COLUMNS (
                paymentType VARCHAR(255) PATH '$.paymentType', 
                amount DECIMAL(10, 2) PATH '$.amount'
            )
        ) AS jt
        GROUP BY 
            p.id
    ) jt ON jt.payment_id = re.payment_id
    
    ) AS rc ON rc.payment_id = payments.id
   INNER JOIN (
    SELECT DISTINCT payment_id, receipt_id,is_paid,is_void,user_id
    FROM transactions 
    WHERE is_paid = 1 AND is_void = 0
) AS transactions ON payments.id = transactions.payment_id
   INNER JOIN users AS u ON u.id = transactions.user_id
    WHERE 
        JSON_VALID(payments.payment_details) AND jt.amount != 0.00 
        AND transactions.is_paid = 1 AND transactions.is_void = 0
        AND u.id = :customerId AND DATE(payments.date_time_of_payment) = :singleDateData
    GROUP BY 
       u.id
    ORDER BY 
       u.first_name ASC;";

                $sql = $this->connect()->prepare( $sql );
                $sql->bindParam( ':customerId', $customerId );
                $sql->bindParam( ':singleDateData',  $singleDateData );
                $sql->execute();
                return $sql;
            } else if ( $customerId && !$singleDateData && $startDate && $endDate ) {
                $sql = "SELECT 
        payments.id AS id,
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        transactions.payment_id,
        transactions.user_id,
        transactions.is_paid,
        transactions.is_void, 
        SUM(DISTINCT payments.change_amount) AS change_amount,
        DATE(payments.date_time_of_payment) AS payment_date,
GREATEST(
    SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) 
    - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0) 
    - CASE
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
            rc.credit_amount
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
            (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
        ELSE 
            0
    END, 
    0
) AS credit_total,

          GREATEST(
            SUM(
                CASE 
                    WHEN jt.paymentType = 'cash' THEN (jt.amount - payments.change_amount) 
                    ELSE 0 
                END
            ) 
            - COALESCE(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'cash' THEN rf.refunded_amt 
                        ELSE 0 
                    END
                ), 0
            )
            - CASE
                WHEN rc.cash_amount > 0 AND rc.total_return_amount > rc.cash_amount THEN rc.cash_amount
                WHEN rc.cash_amount > 0 AND rc.total_return_amount <= rc.cash_amount THEN rc.total_return_amount
                ELSE 0
              END,
            0
        ) AS cash_total,
          GREATEST(
            SUM(
                CASE 
                    WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount 
                    ELSE 0 
                END
            ) 
            - COALESCE(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt 
                        ELSE 0 
                    END
                ), 0
            )
            - CASE
                WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount THEN rc.ewallet_amount
                WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount THEN rc.total_return_amount - rc.cash_amount
                ELSE 0
              END,
            0
        ) AS e_wallet_total,
          GREATEST(
            SUM(
                CASE 
                    WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount 
                    ELSE 0 
                END
            ) 
            - COALESCE(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt 
                        ELSE 0 
                    END
                ), 0
            )
            - CASE 
                WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) > rc.cc_amount THEN rc.cc_amount
                WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) <= rc.cc_amount THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount
                ELSE 0
              END,
            0
        ) AS cdcards_total,
        GREATEST(
            SUM(
                CASE 
                    WHEN jt.paymentType = 'coupon' THEN jt.amount 
                    ELSE 0 
                END
            ) 
            - COALESCE(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt 
                        ELSE 0 
                    END
                ), 0
            )
            - CASE
                WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.coupon_amount) THEN rc.coupon_amount
                WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.coupon_amount) THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount
                ELSE 0
              END,
            0
        ) AS coupons_total,
    GREATEST(
        (SUM(jt.amount) - SUM(DISTINCT payments.change_amount)) 
        - COALESCE(SUM(rf.refunded_amt), 0) 
        - COALESCE(rc.total_return_amount, 0),
        0
    ) AS total_amount,
    
    
        COALESCE(rc.total_return_amount, 0) AS total_return_amount,
        COALESCE(rc.cash_amount, 0) AS return_cash_amount,
        CASE
           WHEN rc.cash_amount > 0 AND (rc.total_return_amount > rc.cash_amount) THEN 
           rc.cash_amount
           WHEN rc.cash_amount > 0 AND (rc.total_return_amount <= rc.cash_amount) THEN
           rc.total_return_amount
        ELSE 0
        END AS tobe_deducted_cash,
        CASE
           WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount) THEN
           rc.ewallet_amount
           WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount) THEN
           rc.total_return_amount - rc.cash_amount
           ELSE 0
         END AS tobe_deducted_ewallet,
            CASE 
            WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) > rc.cc_amount) THEN
            rc.cc_amount
          WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) <= rc.cc_amount)  THEN
          (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount )
         ELSE 0
        END AS tobe_deducted_cc,
        CASE
         WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.cc_amount) THEN
            rc.coupon_amount
          WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.cc_amount) THEN
          (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount)
          ELSE 0
           END AS tobe_deducted_coupon,
  CASE
    WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
        rc.credit_amount
    WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
        (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
    ELSE 
        0
END AS tobe_deducted_credits

    FROM 
        payments
    CROSS JOIN JSON_TABLE(
        payments.payment_details, '$[*]' COLUMNS (
            paymentType VARCHAR(255) PATH '$.paymentType', 
            amount DECIMAL(10, 2) PATH '$.amount'
        )
    ) AS jt
    INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id 
        FROM transactions 
        WHERE is_paid = 1 AND is_void = 0
    ) AS t ON payments.id = t.payment_id
    LEFT JOIN (
        SELECT payment_id, SUM(refunded_amt) AS refunded_amt
        FROM refunded
        GROUP BY payment_id
    ) AS rf ON rf.payment_id = payments.id
    LEFT JOIN (
    SELECT 
        re.payment_id as payment_id,
        COALESCE(jt.cash_amount, 0) as cash_amount,
        COALESCE(jt.credit_amount, 0) as credit_amount,
        COALESCE(jt.gcash_amount, 0) as gcash_amount,
        COALESCE(jt.maya_amount, 0) as maya_amount,
        COALESCE(jt.alipay_amount, 0) as alipay_amount,
        COALESCE(jt.grab_pay_amount, 0) as grab_pay_amount,
        COALESCE(jt.shopee_pay_amount, 0) as shopee_pay_amount,
        COALESCE(jt.ewallet_amount, 0) as ewallet_amount,
        COALESCE(jt.visa_amount, 0) as visa_amount,
        COALESCE(jt.master_card_amount, 0) as master_card_amount,
        COALESCE(jt.discover_card_amount, 0) as discover_card_amount,
        COALESCE(jt.american_express_card_amount, 0) as american_express_card_amount,
        COALESCE(jt.jcb_card_amount, 0) as jcb_card_amount,
        COALESCE(jt.cc_amount, 0) as cc_amount,
        COALESCE(jt.coupon_amount, 0) as coupon_amount,
        ROUND(SUM(re.return_amount), 2) AS total_return_amount
    FROM 
        return_exchange re
    LEFT JOIN (
        SELECT 
            p.id as payment_id,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END, 0)) as coupon_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END, 0)) as cash_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END, 0)) as credit_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'gcash' THEN jt.amount ELSE 0 END, 0)) as gcash_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'maya' THEN jt.amount ELSE 0 END, 0)) as maya_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'alipay' THEN jt.amount ELSE 0 END, 0)) as alipay_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'grab pay' THEN jt.amount ELSE 0 END, 0)) as grab_pay_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'shopee pay' THEN jt.amount ELSE 0 END, 0)) as shopee_pay_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END, 0)) as ewallet_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'visa' THEN jt.amount ELSE 0 END, 0)) as visa_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'master_card' THEN jt.amount ELSE 0 END, 0)) as master_card_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'discover' THEN jt.amount ELSE 0 END, 0)) as discover_card_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'american_express' THEN jt.amount ELSE 0 END, 0)) as american_express_card_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'jcb' THEN jt.amount ELSE 0 END, 0)) as jcb_card_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('visa', 'master_card', 'discover', 'american_express', 'jcb') THEN jt.amount ELSE 0 END, 0)) as cc_amount
        FROM 
            payments p
        CROSS JOIN JSON_TABLE(
            p.payment_details, '$[*]' COLUMNS (
                paymentType VARCHAR(255) PATH '$.paymentType', 
                amount DECIMAL(10, 2) PATH '$.amount'
            )
        ) AS jt
        GROUP BY 
            p.id
    ) jt ON jt.payment_id = re.payment_id
    
    ) AS rc ON rc.payment_id = payments.id
   INNER JOIN (
    SELECT DISTINCT payment_id, receipt_id,is_paid,is_void,user_id
    FROM transactions 
    WHERE is_paid = 1 AND is_void = 0
) AS transactions ON payments.id = transactions.payment_id
   INNER JOIN users AS u ON u.id = transactions.user_id
    WHERE 
        JSON_VALID(payments.payment_details) AND jt.amount != 0.00 
        AND transactions.is_paid = 1 AND transactions.is_void = 0
        AND u.id = :customerId AND DATE(payments.date_time_of_payment) BETWEEN :startDate AND :endDate
    GROUP BY 
       u.id
    ORDER BY 
       u.first_name ASC;";

                $sql = $this->connect()->prepare( $sql );
                $sql->bindParam( ':customerId', $customerId );
                $sql->bindParam( ':startDate', $startDate );
                $sql->bindParam( ':endDate', $endDate );
                $sql->execute();
                return $sql;
            } else {
                $sql = "SELECT 
        payments.id AS id,
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        transactions.payment_id,
        transactions.user_id,
        transactions.is_paid,
        transactions.is_void, 
        SUM(DISTINCT payments.change_amount) AS change_amount,
        DATE(payments.date_time_of_payment) AS payment_date,
GREATEST(
    SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) 
    - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0) 
    - CASE
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
            rc.credit_amount
        WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
            (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
        ELSE 
            0
    END, 
    0
) AS credit_total,

          GREATEST(
            SUM(
                CASE 
                    WHEN jt.paymentType = 'cash' THEN (jt.amount - payments.change_amount) 
                    ELSE 0 
                END
            ) 
            - COALESCE(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'cash' THEN rf.refunded_amt 
                        ELSE 0 
                    END
                ), 0
            )
            - CASE
                WHEN rc.cash_amount > 0 AND rc.total_return_amount > rc.cash_amount THEN rc.cash_amount
                WHEN rc.cash_amount > 0 AND rc.total_return_amount <= rc.cash_amount THEN rc.total_return_amount
                ELSE 0
              END,
            0
        ) AS cash_total,
          GREATEST(
            SUM(
                CASE 
                    WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount 
                    ELSE 0 
                END
            ) 
            - COALESCE(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt 
                        ELSE 0 
                    END
                ), 0
            )
            - CASE
                WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount THEN rc.ewallet_amount
                WHEN rc.ewallet_amount > 0 AND (rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount THEN rc.total_return_amount - rc.cash_amount
                ELSE 0
              END,
            0
        ) AS e_wallet_total,
          GREATEST(
            SUM(
                CASE 
                    WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount 
                    ELSE 0 
                END
            ) 
            - COALESCE(
                SUM(
                    CASE 
                        WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt 
                        ELSE 0 
                    END
                ), 0
            )
            - CASE 
                WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) > rc.cc_amount THEN rc.cc_amount
                WHEN rc.cc_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount) <= rc.cc_amount THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount
                ELSE 0
              END,
            0
        ) AS cdcards_total,
        GREATEST(
            SUM(
                CASE 
                    WHEN jt.paymentType = 'coupon' THEN jt.amount 
                    ELSE 0 
                END
            ) 
            - COALESCE(
                SUM(
                    CASE 
                        WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt 
                        ELSE 0 
                    END
                ), 0
            )
            - CASE
                WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.coupon_amount) THEN rc.coupon_amount
                WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.coupon_amount) THEN rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount
                ELSE 0
              END,
            0
        ) AS coupons_total,
    GREATEST(
        (SUM(jt.amount) - SUM(DISTINCT payments.change_amount)) 
        - COALESCE(SUM(rf.refunded_amt), 0) 
        - COALESCE(rc.total_return_amount, 0),
        0
    ) AS total_amount,
    
    
        COALESCE(rc.total_return_amount, 0) AS total_return_amount,
        COALESCE(rc.cash_amount, 0) AS return_cash_amount,
        CASE
           WHEN rc.cash_amount > 0 AND (rc.total_return_amount > rc.cash_amount) THEN 
           rc.cash_amount
           WHEN rc.cash_amount > 0 AND (rc.total_return_amount <= rc.cash_amount) THEN
           rc.total_return_amount
        ELSE 0
        END AS tobe_deducted_cash,
        CASE
           WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) > rc.ewallet_amount) THEN
           rc.ewallet_amount
           WHEN rc.ewallet_amount > 0 AND ((rc.total_return_amount - rc.cash_amount) <= rc.ewallet_amount) THEN
           rc.total_return_amount - rc.cash_amount
           ELSE 0
         END AS tobe_deducted_ewallet,
            CASE 
            WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) > rc.cc_amount) THEN
            rc.cc_amount
          WHEN rc.cc_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount ) <= rc.cc_amount)  THEN
          (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount )
         ELSE 0
        END AS tobe_deducted_cc,
        CASE
         WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) > rc.cc_amount) THEN
            rc.coupon_amount
          WHEN rc.coupon_amount > 0 AND ((rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount) <= rc.cc_amount) THEN
          (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount)
          ELSE 0
           END AS tobe_deducted_coupon,
  CASE
    WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) > rc.credit_amount THEN
        rc.credit_amount
    WHEN rc.credit_amount > 0 AND (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount) <= rc.credit_amount THEN
        (rc.total_return_amount - rc.cash_amount - rc.ewallet_amount - rc.cc_amount - rc.coupon_amount)
    ELSE 
        0
END AS tobe_deducted_credits

    FROM 
        payments
    CROSS JOIN JSON_TABLE(
        payments.payment_details, '$[*]' COLUMNS (
            paymentType VARCHAR(255) PATH '$.paymentType', 
            amount DECIMAL(10, 2) PATH '$.amount'
        )
    ) AS jt
    INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id 
        FROM transactions 
        WHERE is_paid = 1 AND is_void = 0
    ) AS t ON payments.id = t.payment_id
    LEFT JOIN (
        SELECT payment_id, SUM(refunded_amt) AS refunded_amt
        FROM refunded
        GROUP BY payment_id
    ) AS rf ON rf.payment_id = payments.id
    LEFT JOIN (
    SELECT 
        re.payment_id as payment_id,
        COALESCE(jt.cash_amount, 0) as cash_amount,
        COALESCE(jt.credit_amount, 0) as credit_amount,
        COALESCE(jt.gcash_amount, 0) as gcash_amount,
        COALESCE(jt.maya_amount, 0) as maya_amount,
        COALESCE(jt.alipay_amount, 0) as alipay_amount,
        COALESCE(jt.grab_pay_amount, 0) as grab_pay_amount,
        COALESCE(jt.shopee_pay_amount, 0) as shopee_pay_amount,
        COALESCE(jt.ewallet_amount, 0) as ewallet_amount,
        COALESCE(jt.visa_amount, 0) as visa_amount,
        COALESCE(jt.master_card_amount, 0) as master_card_amount,
        COALESCE(jt.discover_card_amount, 0) as discover_card_amount,
        COALESCE(jt.american_express_card_amount, 0) as american_express_card_amount,
        COALESCE(jt.jcb_card_amount, 0) as jcb_card_amount,
        COALESCE(jt.cc_amount, 0) as cc_amount,
        COALESCE(jt.coupon_amount, 0) as coupon_amount,
        ROUND(SUM(re.return_amount), 2) AS total_return_amount
    FROM 
        return_exchange re
    LEFT JOIN (
        SELECT 
            p.id as payment_id,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END, 0)) as coupon_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END, 0)) as cash_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END, 0)) as credit_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'gcash' THEN jt.amount ELSE 0 END, 0)) as gcash_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'maya' THEN jt.amount ELSE 0 END, 0)) as maya_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'alipay' THEN jt.amount ELSE 0 END, 0)) as alipay_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'grab pay' THEN jt.amount ELSE 0 END, 0)) as grab_pay_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'shopee pay' THEN jt.amount ELSE 0 END, 0)) as shopee_pay_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END, 0)) as ewallet_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'visa' THEN jt.amount ELSE 0 END, 0)) as visa_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'master_card' THEN jt.amount ELSE 0 END, 0)) as master_card_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'discover' THEN jt.amount ELSE 0 END, 0)) as discover_card_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'american_express' THEN jt.amount ELSE 0 END, 0)) as american_express_card_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType = 'jcb' THEN jt.amount ELSE 0 END, 0)) as jcb_card_amount,
            SUM(DISTINCT COALESCE(CASE WHEN jt.paymentType IN ('visa', 'master_card', 'discover', 'american_express', 'jcb') THEN jt.amount ELSE 0 END, 0)) as cc_amount
        FROM 
            payments p
        CROSS JOIN JSON_TABLE(
            p.payment_details, '$[*]' COLUMNS (
                paymentType VARCHAR(255) PATH '$.paymentType', 
                amount DECIMAL(10, 2) PATH '$.amount'
            )
        ) AS jt
        GROUP BY 
            p.id
    ) jt ON jt.payment_id = re.payment_id
    
    ) AS rc ON rc.payment_id = payments.id
   INNER JOIN (
    SELECT DISTINCT payment_id, receipt_id,is_paid,is_void,user_id
    FROM transactions 
    WHERE is_paid = 1 AND is_void = 0
) AS transactions ON payments.id = transactions.payment_id
   INNER JOIN users AS u ON u.id = transactions.user_id
    WHERE 
        JSON_VALID(payments.payment_details) AND jt.amount != 0.00 
        AND transactions.is_paid = 1 AND transactions.is_void = 0
    GROUP BY 
       u.id
    ORDER BY 
       u.first_name ASC;";

                $stmt = $this->connect()->query( $sql );
                return $stmt;
            }
        } else {
            if ( $customerId && !$singleDateData && !$startDate && !$endDate ) {
                $sql = "SELECT 
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        (SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END)-SUM(DISTINCT payments.change_amount))AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) - SUM(DISTINCT payments.change_amount) AS total_amount
        FROM 
            payments
        CROSS JOIN JSON_TABLE(
            payments.payment_details, '$[*]' COLUMNS (
                paymentType VARCHAR(255) PATH '$.paymentType', 
                amount DECIMAL(10, 2) PATH '$.amount'
            )
        ) AS jt
        INNER JOIN (
            SELECT DISTINCT payment_id, receipt_id, user_id FROM transactions
        ) AS t ON payments.id = t.payment_id
        INNER JOIN users AS u ON u.id = t.user_id
        WHERE 
            JSON_VALID(payments.payment_details) AND jt.amount != 0.00 AND u.id = :customerId
        GROUP BY 
            u.id
        ORDER BY 
            u.id ASC";

                $sql = $this->connect()->prepare( $sql );
                $sql->bindParam( ':customerId', $customerId );
                $sql->execute();
                return $sql;

            } else if ( !$customerId && $singleDateData && !$startDate && !$endDate ) {
                $sql = "SELECT 
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        (SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END)-SUM(DISTINCT payments.change_amount))AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) - SUM(DISTINCT payments.change_amount) AS total_amount
        FROM 
            payments
        CROSS JOIN JSON_TABLE(
            payments.payment_details, '$[*]' COLUMNS (
                paymentType VARCHAR(255) PATH '$.paymentType', 
                amount DECIMAL(10, 2) PATH '$.amount'
            )
        ) AS jt
        INNER JOIN (
            SELECT DISTINCT payment_id, receipt_id, user_id FROM transactions
        ) AS t ON payments.id = t.payment_id
        INNER JOIN users AS u ON u.id = t.user_id
        WHERE 
            JSON_VALID(payments.payment_details) AND jt.amount != 0.00 AND DATE(payments.date_time_of_payment) = :singleDateData
        GROUP BY 
            u.id
        ORDER BY 
            u.id ASC";

                $sql = $this->connect()->prepare( $sql );
                $sql->bindParam( ':singleDateData',  $singleDateData );
                $sql->execute();
                return $sql;
            } else if ( !$customerId && !$singleDateData && $startDate && $endDate ) {
                $sql = "SELECT 
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        (SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END)-SUM(DISTINCT payments.change_amount))AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) - SUM(DISTINCT payments.change_amount) AS total_amount
        FROM 
            payments
        CROSS JOIN JSON_TABLE(
            payments.payment_details, '$[*]' COLUMNS (
                paymentType VARCHAR(255) PATH '$.paymentType', 
                amount DECIMAL(10, 2) PATH '$.amount'
            )
        ) AS jt
        INNER JOIN (
            SELECT DISTINCT payment_id, receipt_id, user_id FROM transactions
        ) AS t ON payments.id = t.payment_id
        INNER JOIN users AS u ON u.id = t.user_id
        WHERE 
            JSON_VALID(payments.payment_details) AND jt.amount != 0.00  AND  DATE(payments.date_time_of_payment) BETWEEN :startDate AND :endDate
        GROUP BY 
            u.id
        ORDER BY 
            u.id ASC";

                $sql = $this->connect()->prepare( $sql );
                $sql->bindParam( ':startDate', $startDate );
                $sql->bindParam( ':endDate', $endDate );
                $sql->execute();
                return $sql;
            } else if ( $customerId && $singleDateData && !$startDate && !$endDate ) {
                $sql = "SELECT 
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        (SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END)-SUM(DISTINCT payments.change_amount))AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) - SUM(DISTINCT payments.change_amount) AS total_amount
        FROM 
            payments
        CROSS JOIN JSON_TABLE(
            payments.payment_details, '$[*]' COLUMNS (
                paymentType VARCHAR(255) PATH '$.paymentType', 
                amount DECIMAL(10, 2) PATH '$.amount'
            )
        ) AS jt
        INNER JOIN (
            SELECT DISTINCT payment_id, receipt_id, user_id FROM transactions
        ) AS t ON payments.id = t.payment_id
        INNER JOIN users AS u ON u.id = t.user_id
        WHERE 
            JSON_VALID(payments.payment_details) AND jt.amount != 0.00 AND u.id=:customerId AND DATE(payments.date_time_of_payment) = :singleDateData
        GROUP BY 
            u.id
        ORDER BY 
            u.id ASC";

                $sql = $this->connect()->prepare( $sql );
                $sql->bindParam( ':customerId', $customerId );
                $sql->bindParam( ':singleDateData',  $singleDateData );
                $sql->execute();
                return $sql;
            } else if ( $customerId && !$singleDateData && $startDate && $endDate ) {
                $sql = "SELECT 
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        (SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END)-SUM(DISTINCT payments.change_amount))AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) - SUM(DISTINCT payments.change_amount) AS total_amount
        FROM 
            payments
        CROSS JOIN JSON_TABLE(
            payments.payment_details, '$[*]' COLUMNS (
                paymentType VARCHAR(255) PATH '$.paymentType', 
                amount DECIMAL(10, 2) PATH '$.amount'
            )
        ) AS jt
        INNER JOIN (
            SELECT DISTINCT payment_id, receipt_id, user_id FROM transactions 
        ) AS t ON payments.id = t.payment_id
        INNER JOIN users AS u ON u.id = t.user_id
        WHERE 
            JSON_VALID(payments.payment_details) AND jt.amount != 0.00 AND u.id=:customerId AND  DATE(payments.date_time_of_payment) BETWEEN :startDate AND :endDate
        GROUP BY 
            u.id
        ORDER BY 
            u.id ASC";

                $sql = $this->connect()->prepare( $sql );
                $sql->bindParam( ':customerId', $customerId );
                $sql->bindParam( ':startDate', $startDate );
                $sql->bindParam( ':endDate', $endDate );
                $sql->execute();
                return $sql;
            } else {
                $sql = "SELECT 
            u.id as id,
            u.first_name as firstname,
            u.last_name as lastname,
            DATE(payments.date_time_of_payment) AS payment_date,
            SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
            (SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END)-SUM(DISTINCT payments.change_amount))AS cash_total,
            SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
            SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
            SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
            SUM(jt.amount) - SUM(DISTINCT payments.change_amount) AS total_amount
            FROM 
                payments
            CROSS JOIN JSON_TABLE(
                payments.payment_details, '$[*]' COLUMNS (
                    paymentType VARCHAR(255) PATH '$.paymentType', 
                    amount DECIMAL(10, 2) PATH '$.amount'
                )
            ) AS jt
            INNER JOIN (
                SELECT DISTINCT payment_id, receipt_id, user_id FROM transactions
            ) AS t ON payments.id = t.payment_id
            INNER JOIN users AS u ON u.id = t.user_id
            WHERE 
                JSON_VALID(payments.payment_details) AND jt.amount != 0.00
            GROUP BY 
                u.id
            ORDER BY 
                u.id ASC";

                $stmt = $this->connect()->query( $sql );
                return $stmt;
            }
        }
    }

    public function getVoidedSales( $selectedProduct, $userId, $singleDateData, $startDate, $endDate ) {
        if ( $selectedProduct && !$userId && !$singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT DISTINCT  t.prod_desc as prod_desc, t.prod_price, t.prod_qty as qty, t.prod_price as price, t.discount_amount as discount,t.date as dateCreated, t.subtotal as subtotal,
        u.first_name as first_name, u.last_name as last_name, vr.date_void as voided, vr.reason as note,r.barcode as barcode
        FROM transactions as t
        INNER JOIN products as p
        INNER JOIN users as u ON u.id = t.cashier_id
        LEFT JOIN receipt as r ON r.id = t.receipt_id
        LEFT JOIN void_reason AS vr ON vr.id = t.void_id
        WHERE t.is_paid IN (0,1) AND t.is_void IN (1,2) AND t.prod_id = :selectedProduct
        ORDER BY  t.prod_desc ASC';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedProduct', $selectedProduct );
            $sql->execute();
            return $sql;
        } else if ( !$selectedProduct && $userId && !$singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT DISTINCT  t.prod_desc as prod_desc, t.prod_price, t.prod_qty as qty, t.prod_price as price, t.discount_amount as discount,t.date as dateCreated, t.subtotal as subtotal,
        u.first_name as first_name, u.last_name as last_name, vr.date_void as voided, vr.reason as note,r.barcode as barcode
        FROM transactions as t
        INNER JOIN products as p
        INNER JOIN users as u ON u.id = t.cashier_id
        LEFT JOIN receipt as r ON r.id = t.receipt_id
        LEFT JOIN void_reason AS vr ON vr.id = t.void_id
        WHERE t.is_paid IN (0,1) AND t.is_void IN (1,2) AND t.cashier_id = :cashier_id
        ORDER BY  t.prod_desc ASC';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':cashier_id',  $userId );
            $sql->execute();
            return $sql;

        } else if ( !$selectedProduct && !$userId && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT DISTINCT  t.prod_desc as prod_desc, t.prod_price, t.prod_qty as qty, t.prod_price as price, t.discount_amount as discount,t.date as dateCreated, t.subtotal as subtotal,
        u.first_name as first_name, u.last_name as last_name, vr.date_void as voided, vr.reason as note,r.barcode as barcode
        FROM transactions as t
        INNER JOIN products as p
        INNER JOIN users as u ON u.id = t.cashier_id
        LEFT JOIN receipt as r ON r.id = t.receipt_id
        LEFT JOIN void_reason AS vr ON vr.id = t.void_id
        WHERE t.is_paid IN (0,1) AND t.is_void IN (1,2) AND DATE(vr.date_void) = :singleDateData
        ORDER BY  t.prod_desc ASC';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':singleDateData',  $singleDateData );
            $sql->execute();
            return $sql;
        } else if ( !$selectedProduct && !$userId && !$singleDateData && $startDate && $endDate ) {
            $sql = 'SELECT DISTINCT  t.prod_desc as prod_desc, t.prod_price, t.prod_qty as qty, t.prod_price as price, t.discount_amount as discount,t.date as dateCreated, t.subtotal as subtotal,
        u.first_name as first_name, u.last_name as last_name, vr.date_void as voided, vr.reason as note,r.barcode as barcode
        FROM transactions as t
        INNER JOIN products as p
        INNER JOIN users as u ON u.id = t.cashier_id
        LEFT JOIN receipt as r ON r.id = t.receipt_id
        LEFT JOIN void_reason AS vr ON vr.id = t.void_id
        WHERE t.is_paid IN (0,1) AND t.is_void IN (1,2) AND DATE(vr.date_void) BETWEEN :stratDate AND :endDate
        ORDER BY  t.prod_desc ASC';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':stratDate',  $startDate );
            $sql->bindParam( ':endDate',  $endDate );
            $sql->execute();
            return $sql;
        } else if ( $selectedProduct && $userId && !$singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT DISTINCT  t.prod_desc as prod_desc, t.prod_price, t.prod_qty as qty, t.prod_price as price, t.discount_amount as discount,t.date as dateCreated, t.subtotal as subtotal,
        u.first_name as first_name, u.last_name as last_name, vr.date_void as voided, vr.reason as note,r.barcode as barcode
        FROM transactions as t
        INNER JOIN products as p
        INNER JOIN users as u ON u.id = t.cashier_id
        LEFT JOIN receipt as r ON r.id = t.receipt_id
        LEFT JOIN void_reason AS vr ON vr.id = t.void_id
        WHERE t.is_paid IN (0,1) AND t.is_void IN (1,2) AND t.cashier_id = :cashier_id AND t.prod_id = :selectedProduct
        ORDER BY  t.prod_desc ASC';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedProduct', $selectedProduct );
            $sql->bindParam( ':cashier_id',  $userId );
            $sql->execute();
            return $sql;
        } else if ( $selectedProduct && !$userId && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT DISTINCT  t.prod_desc as prod_desc, t.prod_price, t.prod_qty as qty, t.prod_price as price, t.discount_amount as discount,t.date as dateCreated, t.subtotal as subtotal,
        u.first_name as first_name, u.last_name as last_name, vr.date_void as voided, vr.reason as note,r.barcode as barcode
        FROM transactions as t
        INNER JOIN products as p
        INNER JOIN users as u ON u.id = t.cashier_id
        LEFT JOIN receipt as r ON r.id = t.receipt_id
        LEFT JOIN void_reason AS vr ON vr.id = t.void_id
        WHERE t.is_paid IN (0,1) AND t.is_void IN (1,2) AND DATE(vr.date_void) = :singleDateData AND t.prod_id = :selectedProduct
        ORDER BY  t.prod_desc ASC';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedProduct', $selectedProduct );
            $sql->bindParam( ':singleDateData',  $singleDateData );
            $sql->execute();
            return $sql;

        } else if ( !$selectedProduct && $userId && $singleDateData && !$startDate && !$endDate ) {
            $sql = 'SELECT DISTINCT  t.prod_desc as prod_desc, t.prod_price, t.prod_qty as qty, t.prod_price as price, t.discount_amount as discount,t.date as dateCreated, t.subtotal as subtotal,
        u.first_name as first_name, u.last_name as last_name, vr.date_void as voided, vr.reason as note,r.barcode as barcode
        FROM transactions as t
        INNER JOIN products as p
        INNER JOIN users as u ON u.id = t.cashier_id
        LEFT JOIN void_reason AS vr ON vr.id = t.void_id
        LEFT JOIN receipt as r ON r.id = t.receipt_id
        WHERE t.is_paid IN (0,1) AND t.is_void IN (1,2) AND DATE(vr.date_void) = :singleDateData AND t.cashier_id = :cashier_id
        ORDER BY  t.prod_desc ASC';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':cashier_id',  $userId );
            $sql->bindParam( ':singleDateData',  $singleDateData );
            $sql->execute();
            return $sql;

        } else if ( $selectedProduct && !$userId && !$singleDateData && $startDate && $endDate ) {
            $sql = 'SELECT DISTINCT  t.prod_desc as prod_desc, t.prod_price, t.prod_qty as qty, t.prod_price as price, t.discount_amount as discount,t.date as dateCreated, t.subtotal as subtotal,
        u.first_name as first_name, u.last_name as last_name, vr.date_void as voided, vr.reason as note,r.barcode as barcode
        FROM transactions as t
        INNER JOIN products as p
        INNER JOIN users as u ON u.id = t.cashier_id
        LEFT JOIN receipt as r ON r.id = t.receipt_id
        LEFT JOIN void_reason AS vr ON vr.id = t.void_id
        WHERE t.is_paid IN (0,1) AND t.is_void IN (1,2) AND DATE(vr.date_void) BETWEEN :stratDate AND :endDate AND t.prod_id = :selectedProduct
        ORDER BY  t.prod_desc ASC';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedProduct', $selectedProduct );
            $sql->bindParam( ':stratDate',  $startDate );
            $sql->bindParam( ':endDate',  $endDate );
            $sql->execute();
            return $sql;

        } else if ( !$selectedProduct && $userId && !$singleDateData && $startDate && $endDate ) {
            $sql = 'SELECT DISTINCT  t.prod_desc as prod_desc, t.prod_price, t.prod_qty as qty, t.prod_price as price, t.discount_amount as discount,t.date as dateCreated, t.subtotal as subtotal,
        u.first_name as first_name, u.last_name as last_name, vr.date_void as voided, vr.reason as note,r.barcode as barcode
        FROM transactions as t
        INNER JOIN products as p
        INNER JOIN users as u ON u.id = t.cashier_id
        LEFT JOIN receipt as r ON r.id = t.receipt_id
        LEFT JOIN void_reason AS vr ON vr.id = t.void_id
        WHERE t.is_paid IN (0,1) AND t.is_void IN (1,2) AND DATE(vr.date_void) BETWEEN :stratDate AND :endDate AND t.cashier_id = :cashier_id
        ORDER BY  t.prod_desc ASC';

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':cashier_id',  $userId );
            $sql->bindParam( ':stratDate',  $startDate );
            $sql->bindParam( ':endDate',  $endDate );
            $sql->execute();
            return $sql;
        } else {
            $sql = "SELECT DISTINCT  t.prod_desc as prod_desc, t.prod_price, t.prod_qty as qty, t.prod_price as price, t.discount_amount as discount,t.date as dateCreated, t.subtotal as subtotal,
        u.first_name as first_name, u.last_name as last_name, vr.date_void as voided, vr.reason as note,r.barcode as barcode
        FROM transactions as t
        INNER JOIN products as p
        INNER JOIN users as u ON u.id = t.cashier_id
        LEFT JOIN receipt as r ON r.id = t.receipt_id
        LEFT JOIN void_reason AS vr ON vr.id = t.void_id
        WHERE t.is_paid IN (0,1) AND t.is_void IN (1,2) ORDER BY  t.prod_desc ASC;";

            $stmt = $this->connect()->query( $sql );
            return $stmt;

        }

    }

    public function getDatePayments() {
        $sql = 'SELECT DATE(date_time_of_payment) as date FROM payments GROUP BY date ORDER BY date ASC';
        $stmt = $this->connect()->query( $sql );
        return $stmt;
    }

    public function zReadingReport( $singleDateData, $startDate, $endDate ) {
        if ( $singleDateData && !$startDate && !$endDate ) {
            $sql = "SELECT 
        JSON_VALUE(all_data, '$[0].beg_si') AS beg_si,
        JSON_VALUE(all_data, '$[0].return_beg') AS return_beg,
        JSON_VALUE(all_data, '$[0].refund_beg') AS refund_beg,
        JSON_VALUE(all_data, '$[0].void_beg') AS void_beg,
        (SELECT 
        JSON_VALUE(all_data, '$.end_si') AS end_si
        FROM z_read
        ORDER BY id DESC
        LIMIT 1) as end_si,
        (SELECT 
        JSON_VALUE(all_data, '$.return_end') AS return_end
        FROM z_read
        ORDER BY id DESC
        LIMIT 1) as return_end,
        (SELECT 
        JSON_VALUE(all_data, '$.refund_end') AS refund_end
        FROM z_read
        ORDER BY id DESC
        LIMIT 1) as refund_end,
        (SELECT 
        JSON_VALUE(all_data, '$.void_end') AS void_end
        FROM z_read
        ORDER BY id DESC
        LIMIT 1) as void_end,
        (SELECT 
        IF(CURDATE() = DATE(date_time), JSON_VALUE(all_data, '$.totalSales'), 0) AS total_sales
        FROM z_read  
        ORDER BY id DESC
        LIMIT 1) as total_sales,
        (SELECT 
        IF(CURDATE() = DATE(date_time), JSON_VALUE(all_data, '$.present_accumulated_sale'), 0) AS total_present_accumulated_sale
        FROM z_read  
        ORDER BY id DESC
        LIMIT 1) AS total_present_accumulated_sale,
    (SELECT 
        IF(CURDATE() = DATE(date_time), JSON_VALUE(all_data, '$.previous_accumulated_sale'), 0)AS total_previous_accumulated_sale
        FROM z_read  
        ORDER BY id DESC
        LIMIT 1) AS total_previous_accumulated_sale,
        (SELECT 
        IF(CURDATE() = DATE(date_time), JSON_VALUE(all_data, '$.zReadCounter'), 0) AS zReadCounter
        FROM z_read  
        ORDER BY id DESC
        LIMIT 1) AS zReadCounter,
        SUM(JSON_VALUE(all_data, '$.vatable_sales')) AS total_vatable_sales,
        SUM(JSON_VALUE(all_data, '$.vat_amount')) AS total_vat_amount,
        SUM(JSON_VALUE(all_data, '$.vat_exempt')) AS total_vat_exempt,
        SUM(JSON_VALUE(all_data, '$.gross_amount')) AS total_gross_amount,
        SUM(JSON_VALUE(all_data, '$.less_discount')) AS total_less_discount,
        SUM(JSON_VALUE(all_data, '$.less_return_amount')) AS total_less_return_amount,
        SUM(JSON_VALUE(all_data, '$.less_refund_amount')) AS total_less_refund_amount,
        SUM(JSON_VALUE(all_data, '$.less_void')) AS total_less_void,
        SUM(JSON_VALUE(all_data, '$.less_vat_adjustment')) AS total_less_vat_adjustment,
        SUM(JSON_VALUE(all_data, '$.net_amount')) AS total_net_amount,
        SUM(JSON_VALUE(all_data, '$.senior_discount')) AS total_senior_discount,
        SUM(JSON_VALUE(all_data, '$.officer_discount')) AS total_officer_discount,
        SUM(JSON_VALUE(all_data, '$.pwd_discount')) AS total_pwd_discount,
        SUM(JSON_VALUE(all_data, '$.naac_discount')) AS total_naac_discount,
        SUM(JSON_VALUE(all_data, '$.solo_parent_discount')) AS total_solo_parent_discount,
        SUM(JSON_VALUE(all_data, '$.other_discount')) AS total_other_discount,
        SUM(JSON_VALUE(all_data, '$.void')) AS total_void,
        SUM(JSON_VALUE(all_data, '$.return')) AS total_return,
        SUM(JSON_VALUE(all_data, '$.refund')) AS total_refund,
        SUM(JSON_VALUE(all_data, '$.senior_citizen_vat')) AS total_senior_citizen_vat,
        SUM(JSON_VALUE(all_data, '$.officers_vat')) AS total_officers_vat,
        SUM(JSON_VALUE(all_data, '$.pwd_vat')) AS total_pwd_vat,
        SUM(JSON_VALUE(all_data, '$.zero_rated')) AS total_zero_rated,
        SUM(JSON_VALUE(all_data, '$.total_void_vat')) AS total_void_vat,
        SUM(JSON_VALUE(all_data, '$.vat_refunded')) AS total_vat_refunded,
        SUM(JSON_VALUE(all_data, '$.vat_return')) AS total_vat_return,
        SUM(JSON_VALUE(all_data, '$.cash_in_receive')) AS total_cash_in_receive,
        SUM(JSON_VALUE(all_data, '$.totalCcDb')) AS total_totalCcDb,
        SUM(JSON_VALUE(all_data, '$.credit')) AS total_credit,
        SUM(JSON_VALUE(all_data, '$.totalEwallet')) AS total_totalEwallet,
        SUM(JSON_VALUE(all_data, '$.totalCoupon')) AS total_totalCoupon,
        SUM(JSON_VALUE(all_data, '$.totalCashIn')) AS total_totalCashIn,
        SUM(JSON_VALUE(all_data, '$.totalCashOut')) AS total_totalCashOut,
        SUM(JSON_VALUE(all_data, '$.payment_receive')) AS total_payment_receive,
         date_time as date_time
      FROM z_read WHERE DATE(date_time) = :singleDateData";

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':singleDateData',  $singleDateData );
            $sql->execute();
            return $sql;
        } else if ( !$singleDateData && $startDate && $endDate ) {
            $sql = "SELECT 
        JSON_VALUE(all_data, '$[0].beg_si') AS beg_si,
        JSON_VALUE(all_data, '$[0].return_beg') AS return_beg,
        JSON_VALUE(all_data, '$[0].refund_beg') AS refund_beg,
        JSON_VALUE(all_data, '$[0].void_beg') AS void_beg,
        (SELECT 
        JSON_VALUE(all_data, '$.end_si') AS end_si
        FROM z_read
        ORDER BY id DESC
        LIMIT 1) as end_si,
        (SELECT 
        JSON_VALUE(all_data, '$.return_end') AS return_end
        FROM z_read
        ORDER BY id DESC
        LIMIT 1) as return_end,
        (SELECT 
        JSON_VALUE(all_data, '$.refund_end') AS refund_end
        FROM z_read
        ORDER BY id DESC
        LIMIT 1) as refund_end,
        (SELECT 
        JSON_VALUE(all_data, '$.void_end') AS void_end
        FROM z_read
        ORDER BY id DESC
        LIMIT 1) as void_end,
        (SELECT 
        IF(CURDATE() = DATE(date_time), JSON_VALUE(all_data, '$.totalSales'), 0) AS total_sales
        FROM z_read
        ORDER BY id DESC
        LIMIT 1) as total_sales,
        (SELECT 
    IF(CURDATE() = DATE(date_time), JSON_VALUE(all_data, '$.present_accumulated_sale'), 0) AS total_present_accumulated_sale
    FROM z_read  
    ORDER BY id DESC
    LIMIT 1) AS total_present_accumulated_sale,
 (SELECT 
    IF(CURDATE() = DATE(date_time), JSON_VALUE(all_data, '$.previous_accumulated_sale'), 0)AS total_previous_accumulated_sale
    FROM z_read  
    ORDER BY id DESC
    LIMIT 1) AS total_previous_accumulated_sale,
    (SELECT 
        IF(CURDATE() = DATE(date_time), JSON_VALUE(all_data, '$.zReadCounter'), 0) AS zReadCounter
        FROM z_read  
        ORDER BY id DESC
        LIMIT 1) AS zReadCounter,
        SUM(JSON_VALUE(all_data, '$.vatable_sales')) AS total_vatable_sales,
        SUM(JSON_VALUE(all_data, '$.vat_amount')) AS total_vat_amount,
        SUM(JSON_VALUE(all_data, '$.vat_exempt')) AS total_vat_exempt,
        SUM(JSON_VALUE(all_data, '$.gross_amount')) AS total_gross_amount,
        SUM(JSON_VALUE(all_data, '$.less_discount')) AS total_less_discount,
        SUM(JSON_VALUE(all_data, '$.less_return_amount')) AS total_less_return_amount,
        SUM(JSON_VALUE(all_data, '$.less_refund_amount')) AS total_less_refund_amount,
        SUM(JSON_VALUE(all_data, '$.less_void')) AS total_less_void,
        SUM(JSON_VALUE(all_data, '$.less_vat_adjustment')) AS total_less_vat_adjustment,
        SUM(JSON_VALUE(all_data, '$.net_amount')) AS total_net_amount,
        SUM(JSON_VALUE(all_data, '$.senior_discount')) AS total_senior_discount,
        SUM(JSON_VALUE(all_data, '$.officer_discount')) AS total_officer_discount,
        SUM(JSON_VALUE(all_data, '$.pwd_discount')) AS total_pwd_discount,
        SUM(JSON_VALUE(all_data, '$.naac_discount')) AS total_naac_discount,
        SUM(JSON_VALUE(all_data, '$.solo_parent_discount')) AS total_solo_parent_discount,
        SUM(JSON_VALUE(all_data, '$.other_discount')) AS total_other_discount,
        SUM(JSON_VALUE(all_data, '$.void')) AS total_void,
        SUM(JSON_VALUE(all_data, '$.return')) AS total_return,
        SUM(JSON_VALUE(all_data, '$.refund')) AS total_refund,
        SUM(JSON_VALUE(all_data, '$.senior_citizen_vat')) AS total_senior_citizen_vat,
        SUM(JSON_VALUE(all_data, '$.officers_vat')) AS total_officers_vat,
        SUM(JSON_VALUE(all_data, '$.pwd_vat')) AS total_pwd_vat,
        SUM(JSON_VALUE(all_data, '$.zero_rated')) AS total_zero_rated,
        SUM(JSON_VALUE(all_data, '$.total_void_vat')) AS total_void_vat,
        SUM(JSON_VALUE(all_data, '$.vat_refunded')) AS total_vat_refunded,
        SUM(JSON_VALUE(all_data, '$.vat_return')) AS total_vat_return,
        SUM(JSON_VALUE(all_data, '$.cash_in_receive')) AS total_cash_in_receive,
        SUM(JSON_VALUE(all_data, '$.totalCcDb')) AS total_totalCcDb,
        SUM(JSON_VALUE(all_data, '$.credit')) AS total_credit,
        SUM(JSON_VALUE(all_data, '$.totalEwallet')) AS total_totalEwallet,
        SUM(JSON_VALUE(all_data, '$.totalCoupon')) AS total_totalCoupon,
        SUM(JSON_VALUE(all_data, '$.totalCashIn')) AS total_totalCashIn,
        SUM(JSON_VALUE(all_data, '$.totalCashOut')) AS total_totalCashOut,
        SUM(JSON_VALUE(all_data, '$.payment_receive')) AS total_payment_receive,
         date_time as date_time
      FROM z_read WHERE DATE(date_time) BETWEEN :stratDate AND :endDate";
            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':stratDate',  $startDate );
            $sql->bindParam( ':endDate',  $endDate );
            $sql->execute();
            return $sql;
        } else {
            $sql = "SELECT 
    JSON_VALUE(all_data, '$[0].beg_si') AS beg_si,
    JSON_VALUE(all_data, '$[0].return_beg') AS return_beg,
    JSON_VALUE(all_data, '$[0].refund_beg') AS refund_beg,
    JSON_VALUE(all_data, '$[0].void_beg') AS void_beg,
    (SELECT 
    JSON_VALUE(all_data, '$.end_si') AS end_si
    FROM z_read
    ORDER BY id DESC
    LIMIT 1) as end_si,
    (SELECT 
    JSON_VALUE(all_data, '$.return_end') AS return_end
    FROM z_read
    ORDER BY id DESC
    LIMIT 1) as return_end,
    (SELECT 
    JSON_VALUE(all_data, '$.refund_end') AS refund_end
    FROM z_read
    ORDER BY id DESC
    LIMIT 1) as refund_end,
    (SELECT 
    JSON_VALUE(all_data, '$.void_end') AS void_end
    FROM z_read
    ORDER BY id DESC
    LIMIT 1) as void_end,
    (SELECT 
    IF(CURDATE() = DATE(date_time), JSON_VALUE(all_data, '$.totalSales'), 0) AS total_sales
    FROM z_read  
    ORDER BY id DESC
    LIMIT 1) as total_sales,
    (SELECT 
    IF(CURDATE() = DATE(date_time), JSON_VALUE(all_data, '$.present_accumulated_sale'), 0) AS total_present_accumulated_sale
    FROM z_read  
    ORDER BY id DESC
    LIMIT 1) AS total_present_accumulated_sale,
 (SELECT 
    IF(CURDATE() = DATE(date_time), JSON_VALUE(all_data, '$.previous_accumulated_sale'), 0)AS total_previous_accumulated_sale
    FROM z_read  
    ORDER BY id DESC
    LIMIT 1) AS total_previous_accumulated_sale,
    (SELECT 
        IF(CURDATE() = DATE(date_time), JSON_VALUE(all_data, '$.zReadCounter'), 0) AS zReadCounter
        FROM z_read  
        ORDER BY id DESC
        LIMIT 1) AS zReadCounter,
    SUM(JSON_VALUE(all_data, '$.vatable_sales')) AS total_vatable_sales,
    SUM(JSON_VALUE(all_data, '$.vat_amount')) AS total_vat_amount,
    SUM(JSON_VALUE(all_data, '$.vat_exempt')) AS total_vat_exempt,
    SUM(JSON_VALUE(all_data, '$.gross_amount')) AS total_gross_amount,
    SUM(JSON_VALUE(all_data, '$.less_discount')) AS total_less_discount,
    SUM(JSON_VALUE(all_data, '$.less_return_amount')) AS total_less_return_amount,
    SUM(JSON_VALUE(all_data, '$.less_refund_amount')) AS total_less_refund_amount,
    SUM(JSON_VALUE(all_data, '$.less_void')) AS total_less_void,
    SUM(JSON_VALUE(all_data, '$.less_vat_adjustment')) AS total_less_vat_adjustment,
    SUM(JSON_VALUE(all_data, '$.net_amount')) AS total_net_amount,
    SUM(JSON_VALUE(all_data, '$.senior_discount')) AS total_senior_discount,
    SUM(JSON_VALUE(all_data, '$.officer_discount')) AS total_officer_discount,
    SUM(JSON_VALUE(all_data, '$.pwd_discount')) AS total_pwd_discount,
    SUM(JSON_VALUE(all_data, '$.naac_discount')) AS total_naac_discount,
    SUM(JSON_VALUE(all_data, '$.solo_parent_discount')) AS total_solo_parent_discount,
    SUM(JSON_VALUE(all_data, '$.other_discount')) AS total_other_discount,
    SUM(JSON_VALUE(all_data, '$.void')) AS total_void,
    SUM(JSON_VALUE(all_data, '$.return')) AS total_return,
    SUM(JSON_VALUE(all_data, '$.refund')) AS total_refund,
    SUM(JSON_VALUE(all_data, '$.senior_citizen_vat')) AS total_senior_citizen_vat,
    SUM(JSON_VALUE(all_data, '$.officers_vat')) AS total_officers_vat,
    SUM(JSON_VALUE(all_data, '$.pwd_vat')) AS total_pwd_vat,
    SUM(JSON_VALUE(all_data, '$.zero_rated')) AS total_zero_rated,
    SUM(JSON_VALUE(all_data, '$.total_void_vat')) AS total_void_vat,
    SUM(JSON_VALUE(all_data, '$.vat_refunded')) AS total_vat_refunded,
    SUM(JSON_VALUE(all_data, '$.vat_return')) AS total_vat_return,
    SUM(JSON_VALUE(all_data, '$.cash_in_receive')) AS total_cash_in_receive,
    SUM(JSON_VALUE(all_data, '$.totalCcDb')) AS total_totalCcDb,
    SUM(JSON_VALUE(all_data, '$.credit')) AS total_credit,
    SUM(JSON_VALUE(all_data, '$.totalEwallet')) AS total_totalEwallet,
    SUM(JSON_VALUE(all_data, '$.totalCoupon')) AS total_totalCoupon,
    SUM(JSON_VALUE(all_data, '$.totalCashIn')) AS total_totalCashIn,
    SUM(JSON_VALUE(all_data, '$.totalCashOut')) AS total_totalCashOut,
    SUM(JSON_VALUE(all_data, '$.payment_receive')) AS total_payment_receive,
     date_time as date_time
  FROM z_read;";
            $stmt = $this->connect()->query( $sql );
            return $stmt;
        }

    }

    public function birSalesReport( $singleDateData, $startDate, $endDate ) {
        if ( $singleDateData && !$startDate && !$endDate ) {
            $sql = "SELECT z.id AS id,
        s.shop_tin AS tin,
        s.branch_code AS branch,
        s.min,
        MONTH(z.date_time) AS month,
        YEAR(z.date_time) AS year,
        ROUND(SUM(COALESCE(JSON_VALUE(z.all_data, '$.vatable_sales'), 0)), 2) AS total_vatable_sales,
        ROUND(SUM(COALESCE(JSON_VALUE(z.all_data, '$.vat_exempt'), 0)), 2) AS total_vat_exempt,
        max_end_si_table.max_end_si AS last_receipt  
    FROM shop AS s
    CROSS JOIN (
       SELECT
           MAX(JSON_VALUE(all_data, '$.end_si')) AS max_end_si,
           MONTH(date_time) AS month,
           YEAR(date_time) AS year
       FROM z_read
       GROUP BY MONTH(date_time), YEAR(date_time)
    ) AS max_end_si_table
    INNER JOIN z_read AS z 
       ON MONTH(z.date_time) = max_end_si_table.month        
       AND YEAR(z.date_time) = max_end_si_table.year         
    WHERE DATE(z.date_time) = :singleDateData
    GROUP BY 
        s.shop_tin, 
        s.branch_code,
        MONTH(z.date_time), 
        YEAR(z.date_time),
        max_end_si_table.max_end_si;
   ";

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':singleDateData',  $singleDateData );
            $sql->execute();
            return $sql;

        } else if ( !$singleDateData && $startDate && $endDate ) {
            $sql = "SELECT z.id AS id,
        s.shop_tin AS tin,
        s.branch_code AS branch,
        s.min,
        MONTH(z.date_time) AS month,
        YEAR(z.date_time) AS year,
        ROUND(SUM(COALESCE(JSON_VALUE(z.all_data, '$.vatable_sales'), 0)), 2) AS total_vatable_sales,
        ROUND(SUM(COALESCE(JSON_VALUE(z.all_data, '$.vat_exempt'), 0)), 2) AS total_vat_exempt,
        max_end_si_table.max_end_si AS last_receipt  
    FROM shop AS s
    CROSS JOIN (
       SELECT
           MAX(JSON_VALUE(all_data, '$.end_si')) AS max_end_si,
           MONTH(date_time) AS month,
           YEAR(date_time) AS year
       FROM z_read
       GROUP BY MONTH(date_time), YEAR(date_time)
    ) AS max_end_si_table
    INNER JOIN z_read AS z 
       ON MONTH(z.date_time) = max_end_si_table.month        
       AND YEAR(z.date_time) = max_end_si_table.year         
    WHERE DATE(z.date_time) BETWEEN :stratDate AND :endDate
    GROUP BY 
        s.shop_tin, 
        s.branch_code,
        MONTH(z.date_time), 
        YEAR(z.date_time),
        max_end_si_table.max_end_si;";

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':stratDate',  $startDate );
            $sql->bindParam( ':endDate',  $endDate );
            $sql->execute();
            return $sql;

        } else {
            $sql = "SELECT z.id AS id,
    s.shop_tin AS tin,
    s.branch_code AS branch,
    s.min,
    MONTH(z.date_time) AS month,
    YEAR(z.date_time) AS year,
    ROUND(SUM(COALESCE(JSON_VALUE(z.all_data, '$.vatable_sales'), 0)), 2) AS total_vatable_sales,
    ROUND(SUM(COALESCE(JSON_VALUE(z.all_data, '$.vat_exempt'), 0)), 2) AS total_vat_exempt,
    max_end_si_table.max_end_si AS last_receipt  
FROM shop AS s
CROSS JOIN (
   SELECT
       MAX(JSON_VALUE(all_data, '$.end_si')) AS max_end_si,
       MONTH(date_time) AS month,
       YEAR(date_time) AS year
   FROM z_read
   GROUP BY MONTH(date_time), YEAR(date_time)
) AS max_end_si_table
INNER JOIN z_read AS z 
   ON MONTH(z.date_time) = max_end_si_table.month        
   AND YEAR(z.date_time) = max_end_si_table.year         
WHERE z.id IS NOT NULL 
GROUP BY 
    s.shop_tin, 
    s.branch_code,
    MONTH(z.date_time), 
    YEAR(z.date_time),
    max_end_si_table.max_end_si;";

            $stmt = $this->connect()->query( $sql );
            return $stmt;
        }
    }

    public function zReadDate() {
        $sql = 'SELECT date_time AS date FROM z_read';

        $stmt = $this->connect()->query( $sql );
        return $stmt;
    }

    public function geProductSalesData( $selectedProduct, $selectedCategories, $selectedSubCategories, $singleDateData, $startDate, $endDate ) {

        if ( $selectedProduct && !$selectedCategories && !$selectedSubCategories && !$singleDateData && !$startDate && !$endDate ) {

            $sql = "SELECT DISTINCT  
    p.id AS id, 
    p.prod_desc AS prod_desc, 
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
    SUM(
        CASE 
            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
            ELSE 0 
        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)  AS overallDiscounts,
    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,
    CASE
        WHEN p.isVAT = 1 THEN 
            CAST(
                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                AS DECIMAL(10,2)
            )
        ELSE 0
    END AS totalVat,
    (CAST(COALESCE((cart.cartPerItem),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0)) as totalCartDiscountPerItem,
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
INNER JOIN (SELECT
    py.id AS payment_id,
    t.prod_id AS product_id,
    SUM(t.prod_qty) AS prod_qty,
    t.prod_price as prod_price,
    py.cart_discount AS total_cart_value,
    tr.total_subtotal,
    t.prod_id,
    SUM(CAST((t.prod_qty * t.prod_price) * (py.cart_discount / tr.total_subtotal)AS DECIMAL(10,2))) AS cartPerItem,
    CAST((py.cart_discount / tr.total_subtotal) AS DECIMAL(10,2)) AS cart_discount
FROM
    transactions AS t
INNER JOIN
    products AS p ON p.id = t.prod_id
INNER JOIN
    payments AS py ON py.id = t.payment_id
INNER JOIN (
    SELECT 
        payment_id, 
        SUM(subtotal) AS total_subtotal
    FROM 
        transactions 
    GROUP BY 
        payment_id
) AS tr ON tr.payment_id = py.id
WHERE
    t.is_paid = 1
    AND t.is_void = 0 AND t.prod_id = :selectedProduct
GROUP BY
    t.prod_id) AS cart on cart.prod_id = t.prod_id
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.prod_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE  t.prod_id = :selectedProduct
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.refunded_id,
        rs.payment_id,
        rs.prod_id ,
        SUM( rs.refundCart) as overallCart,
        SUM( rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                        
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.product_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE t.prod_id = :selectedProduct
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.return_id,
        rs.payment_id,
        rs.product_id,
        SUM(rs.returnCart) as overallCart,
        SUM(rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100
                        AS DECIMAL(10,2)
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    AND t.is_void = 0 AND t.prod_id = :selectedProduct
GROUP BY
    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
HAVING
newQty > 0;";

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedProduct',  $selectedProduct );
            $sql->execute();
            return $sql;

        } else if( !$selectedProduct && !$selectedCategories && !$selectedSubCategories && $singleDateData && !$startDate && !$endDate){
            $sql = "SELECT DISTINCT  
    p.id AS id, 
    p.prod_desc AS prod_desc, 
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
    SUM(
        CASE 
            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
            ELSE 0 
        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)  AS overallDiscounts,
    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,
    CASE
        WHEN p.isVAT = 1 THEN 
            CAST(
                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                AS DECIMAL(10,2)
            )
        ELSE 0
    END AS totalVat,
    (CAST(COALESCE((cart.cartPerItem),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0)) as totalCartDiscountPerItem,
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
INNER JOIN (SELECT
    py.id AS payment_id,
    t.prod_id AS product_id,
    SUM(t.prod_qty) AS prod_qty,
    t.prod_price as prod_price,
    py.cart_discount AS total_cart_value,
    tr.total_subtotal,
    t.prod_id,
    SUM(CAST((t.prod_qty * t.prod_price) * (py.cart_discount / tr.total_subtotal)AS DECIMAL(10,2))) AS cartPerItem,
    CAST((py.cart_discount / tr.total_subtotal) AS DECIMAL(10,2)) AS cart_discount
FROM
    transactions AS t
INNER JOIN
    products AS p ON p.id = t.prod_id
INNER JOIN
    payments AS py ON py.id = t.payment_id
INNER JOIN (
    SELECT 
        payment_id, 
        SUM(subtotal) AS total_subtotal
    FROM 
        transactions 
    GROUP BY 
        payment_id
) AS tr ON tr.payment_id = py.id
WHERE
    t.is_paid = 1
    AND t.is_void = 0 AND DATE(py.date_time_of_payment) = :singleDateData
GROUP BY
    t.prod_id) AS cart on cart.prod_id = t.prod_id
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.prod_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment) = :singleDateData
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.refunded_id,
        rs.payment_id,
        rs.prod_id ,
        SUM( rs.refundCart) as overallCart,
        SUM( rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                        
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.product_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment) = :singleDateData
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.return_id,
        rs.payment_id,
        rs.product_id,
        SUM(rs.returnCart) as overallCart,
        SUM(rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100
                        AS DECIMAL(10,2)
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    AND t.is_void = 0 AND DATE(py.date_time_of_payment) = :singleDateData
GROUP BY
    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
HAVING
newQty > 0;";
        
            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;

        }else if(!$selectedProduct && !$selectedCategories && !$selectedSubCategories && !$singleDateData && $startDate && $endDate){
            $sql = "SELECT DISTINCT  
    p.id AS id, 
    p.prod_desc AS prod_desc, 
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
    SUM(
        CASE 
            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
            ELSE 0 
        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)  AS overallDiscounts,
    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,
    CASE
        WHEN p.isVAT = 1 THEN 
            CAST(
                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                AS DECIMAL(10,2)
            )
        ELSE 0
    END AS totalVat,
    (CAST(COALESCE((cart.cartPerItem),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0)) as totalCartDiscountPerItem,
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
INNER JOIN (SELECT
    py.id AS payment_id,
    t.prod_id AS product_id,
    SUM(t.prod_qty) AS prod_qty,
    t.prod_price as prod_price,
    py.cart_discount AS total_cart_value,
    tr.total_subtotal,
    t.prod_id,
    SUM(CAST((t.prod_qty * t.prod_price) * (py.cart_discount / tr.total_subtotal)AS DECIMAL(10,2))) AS cartPerItem,
    CAST((py.cart_discount / tr.total_subtotal) AS DECIMAL(10,2)) AS cart_discount
FROM
    transactions AS t
INNER JOIN
    products AS p ON p.id = t.prod_id
INNER JOIN
    payments AS py ON py.id = t.payment_id
INNER JOIN (
    SELECT 
        payment_id, 
        SUM(subtotal) AS total_subtotal
    FROM 
        transactions 
    GROUP BY 
        payment_id
) AS tr ON tr.payment_id = py.id
WHERE
    t.is_paid = 1
    AND t.is_void = 0 AND DATE(py.date_time_of_payment) BETWEEN :startDate AND :endDate
GROUP BY
    t.prod_id) AS cart on cart.prod_id = t.prod_id
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.prod_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.refunded_id,
        rs.payment_id,
        rs.prod_id ,
        SUM( rs.refundCart) as overallCart,
        SUM( rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                        
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.product_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.return_id,
        rs.payment_id,
        rs.product_id,
        SUM(rs.returnCart) as overallCart,
        SUM(rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100
                        AS DECIMAL(10,2)
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    AND t.is_void = 0 AND DATE(py.date_time_of_payment) BETWEEN :startDate AND :endDate
GROUP BY
    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
HAVING
newQty > 0;";

            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':startDate',  $startDate);
            $sql->bindParam( ':endDate',  $endDate);
            $sql->execute();
            return $sql;
        }else if(!$selectedProduct && !$selectedCategories && $selectedSubCategories && !$singleDateData && !$startDate && !$endDate){
            $sql = "SELECT DISTINCT  
    p.id AS id, 
    p.prod_desc AS prod_desc, 
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
    SUM(
        CASE 
            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
            ELSE 0 
        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)  AS overallDiscounts,
    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,
    CASE
        WHEN p.isVAT = 1 THEN 
            CAST(
                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                AS DECIMAL(10,2)
            )
        ELSE 0
    END AS totalVat,
    (CAST(COALESCE((cart.cartPerItem),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0)) as totalCartDiscountPerItem,
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
INNER JOIN (SELECT
    py.id AS payment_id,
    t.prod_id AS product_id,
    SUM(t.prod_qty) AS prod_qty,
    t.prod_price as prod_price,
    py.cart_discount AS total_cart_value,
    tr.total_subtotal,
    t.prod_id,
    SUM(CAST((t.prod_qty * t.prod_price) * (py.cart_discount / tr.total_subtotal)AS DECIMAL(10,2))) AS cartPerItem,
    CAST((py.cart_discount / tr.total_subtotal) AS DECIMAL(10,2)) AS cart_discount
FROM
    transactions AS t
INNER JOIN
    products AS p ON p.id = t.prod_id
INNER JOIN
    payments AS py ON py.id = t.payment_id
INNER JOIN (
    SELECT 
        payment_id, 
        SUM(subtotal) AS total_subtotal
    FROM 
        transactions 
    GROUP BY 
        payment_id
) AS tr ON tr.payment_id = py.id
WHERE
    t.is_paid = 1
    AND t.is_void = 0 AND p.variant_id = :selectedSubCategories
GROUP BY
    t.prod_id) AS cart on cart.prod_id = t.prod_id
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.prod_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE products.variant_id = :selectedSubCategories
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.refunded_id,
        rs.payment_id,
        rs.prod_id ,
        SUM( rs.refundCart) as overallCart,
        SUM( rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                        
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.product_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE products.variant_id = :selectedSubCategories
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.return_id,
        rs.payment_id,
        rs.product_id,
        SUM(rs.returnCart) as overallCart,
        SUM(rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100
                        AS DECIMAL(10,2)
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    AND t.is_void = 0 AND p.variant_id = :selectedSubCategories
GROUP BY
    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
HAVING
newQty > 0;";
            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedSubCategories',  $selectedSubCategories);
            $sql->execute();
            return $sql;
        }else if($selectedProduct && $selectedCategories && !$selectedSubCategories && !$singleDateData && !$startDate && !$endDate){
            $sql = "SELECT DISTINCT  
    p.id AS id, 
    p.prod_desc AS prod_desc, 
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
    SUM(
        CASE 
            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
            ELSE 0 
        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)  AS overallDiscounts,
    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,
    CASE
        WHEN p.isVAT = 1 THEN 
            CAST(
                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                AS DECIMAL(10,2)
            )
        ELSE 0
    END AS totalVat,
    (CAST(COALESCE((cart.cartPerItem),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0)) as totalCartDiscountPerItem,
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
INNER JOIN (SELECT
    py.id AS payment_id,
    t.prod_id AS product_id,
    SUM(t.prod_qty) AS prod_qty,
    t.prod_price as prod_price,
    py.cart_discount AS total_cart_value,
    tr.total_subtotal,
    t.prod_id,
    SUM(CAST((t.prod_qty * t.prod_price) * (py.cart_discount / tr.total_subtotal)AS DECIMAL(10,2))) AS cartPerItem,
    CAST((py.cart_discount / tr.total_subtotal) AS DECIMAL(10,2)) AS cart_discount
FROM
    transactions AS t
INNER JOIN
    products AS p ON p.id = t.prod_id
INNER JOIN
    payments AS py ON py.id = t.payment_id
INNER JOIN (
    SELECT 
        payment_id, 
        SUM(subtotal) AS total_subtotal
    FROM 
        transactions 
    GROUP BY 
        payment_id
) AS tr ON tr.payment_id = py.id
WHERE
    t.is_paid = 1
    AND t.is_void = 0 AND  p.category_id = :selectedCategories AND p.id = :selectedProduct
GROUP BY
    t.prod_id) AS cart on cart.prod_id = t.prod_id
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.prod_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE products.category_id = :selectedCategories AND products.id = :selectedProduct
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.refunded_id,
        rs.payment_id,
        rs.prod_id ,
        SUM( rs.refundCart) as overallCart,
        SUM( rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                        
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.product_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE products.category_id = :selectedCategories AND products.id = :selectedProduct
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.return_id,
        rs.payment_id,
        rs.product_id,
        SUM(rs.returnCart) as overallCart,
        SUM(rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100
                        AS DECIMAL(10,2)
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    AND t.is_void = 0 AND p.category_id = :selectedCategories AND p.id = :selectedProduct
GROUP BY
    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
HAVING
newQty > 0;
           ";
            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedCategories',  $selectedCategories);
            $sql->bindParam( ':selectedProduct',  $selectedProduct);
            $sql->execute();
            return $sql;
        }else if(!$selectedProduct && $selectedCategories && !$selectedSubCategories && !$singleDateData && !$startDate && !$endDate){
            $sql = "SELECT DISTINCT  
    p.id AS id, 
    p.prod_desc AS prod_desc, 
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
    SUM(
        CASE 
            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
            ELSE 0 
        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)  AS overallDiscounts,
    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,
    CASE
        WHEN p.isVAT = 1 THEN 
            CAST(
                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                AS DECIMAL(10,2)
            )
        ELSE 0
    END AS totalVat,
    (CAST(COALESCE((cart.cartPerItem),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0)) as totalCartDiscountPerItem,
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
INNER JOIN (SELECT
    py.id AS payment_id,
    t.prod_id AS product_id,
    SUM(t.prod_qty) AS prod_qty,
    t.prod_price as prod_price,
    py.cart_discount AS total_cart_value,
    tr.total_subtotal,
    t.prod_id,
    SUM(CAST((t.prod_qty * t.prod_price) * (py.cart_discount / tr.total_subtotal)AS DECIMAL(10,2))) AS cartPerItem,
    CAST((py.cart_discount / tr.total_subtotal) AS DECIMAL(10,2)) AS cart_discount
FROM
    transactions AS t
INNER JOIN
    products AS p ON p.id = t.prod_id
INNER JOIN
    payments AS py ON py.id = t.payment_id
INNER JOIN (
    SELECT 
        payment_id, 
        SUM(subtotal) AS total_subtotal
    FROM 
        transactions 
    GROUP BY 
        payment_id
) AS tr ON tr.payment_id = py.id
WHERE
    t.is_paid = 1
    AND t.is_void = 0 AND p.category_id = :selectedCategories 
GROUP BY
    t.prod_id) AS cart on cart.prod_id = t.prod_id
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.prod_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE products.category_id = :selectedCategories 
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.refunded_id,
        rs.payment_id,
        rs.prod_id ,
        SUM( rs.refundCart) as overallCart,
        SUM( rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                        
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.product_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE products.category_id = :selectedCategories 
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.return_id,
        rs.payment_id,
        rs.product_id,
        SUM(rs.returnCart) as overallCart,
        SUM(rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100
                        AS DECIMAL(10,2)
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    AND t.is_void = 0 AND p.category_id = :selectedCategories 
GROUP BY
    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
HAVING
newQty > 0;
                       ";
                        $sql = $this->connect()->prepare( $sql );
                        $sql->bindParam( ':selectedCategories',  $selectedCategories);
                        $sql->execute();
                        return $sql;
        }
        else if($selectedProduct && !$selectedCategories && $selectedSubCategories && !$singleDateData && !$startDate && !$endDate){
            $sql = "SELECT DISTINCT  
    p.id AS id, 
    p.prod_desc AS prod_desc, 
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
    SUM(
        CASE 
            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
            ELSE 0 
        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)  AS overallDiscounts,
    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,
    CASE
        WHEN p.isVAT = 1 THEN 
            CAST(
                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                AS DECIMAL(10,2)
            )
        ELSE 0
    END AS totalVat,
    (CAST(COALESCE((cart.cartPerItem),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0)) as totalCartDiscountPerItem,
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
INNER JOIN (SELECT
    py.id AS payment_id,
    t.prod_id AS product_id,
    SUM(t.prod_qty) AS prod_qty,
    t.prod_price as prod_price,
    py.cart_discount AS total_cart_value,
    tr.total_subtotal,
    t.prod_id,
    SUM(CAST((t.prod_qty * t.prod_price) * (py.cart_discount / tr.total_subtotal)AS DECIMAL(10,2))) AS cartPerItem,
    CAST((py.cart_discount / tr.total_subtotal) AS DECIMAL(10,2)) AS cart_discount
FROM
    transactions AS t
INNER JOIN
    products AS p ON p.id = t.prod_id
INNER JOIN
    payments AS py ON py.id = t.payment_id
INNER JOIN (
    SELECT 
        payment_id, 
        SUM(subtotal) AS total_subtotal
    FROM 
        transactions 
    GROUP BY 
        payment_id
) AS tr ON tr.payment_id = py.id
WHERE
    t.is_paid = 1
    AND t.is_void = 0 AND p.variant_id = :selectedSubCategories AND p.id = :selectedProduct
GROUP BY
    t.prod_id) AS cart on cart.prod_id = t.prod_id
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.prod_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE products.variant_id = :selectedSubCategories AND products.id = :selectedProduct
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.refunded_id,
        rs.payment_id,
        rs.prod_id ,
        SUM( rs.refundCart) as overallCart,
        SUM( rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                        
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.product_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE products.variant_id = :selectedSubCategories AND products.id = :selectedProduct
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.return_id,
        rs.payment_id,
        rs.product_id,
        SUM(rs.returnCart) as overallCart,
        SUM(rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100
                        AS DECIMAL(10,2)
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
     AND t.is_void = 0 AND p.variant_id = :selectedSubCategories AND p.id = :selectedProduct
GROUP BY
    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
HAVING
newQty > 0;
           ";
            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedSubCategories',   $selectedSubCategories);
            $sql->bindParam( ':selectedProduct',  $selectedProduct);
            $sql->execute();
            return $sql;  
        }else if ($selectedProduct && !$selectedCategories && !$selectedSubCategories && $singleDateData && !$startDate && !$endDate){
            $sql = "SELECT DISTINCT  
    p.id AS id, 
    p.prod_desc AS prod_desc, 
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
    SUM(
        CASE 
            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
            ELSE 0 
        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)  AS overallDiscounts,
    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,
    CASE
        WHEN p.isVAT = 1 THEN 
            CAST(
                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                AS DECIMAL(10,2)
            )
        ELSE 0
    END AS totalVat,
    (CAST(COALESCE((cart.cartPerItem),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0)) as totalCartDiscountPerItem,
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
INNER JOIN (SELECT
    py.id AS payment_id,
    t.prod_id AS product_id,
    SUM(t.prod_qty) AS prod_qty,
    t.prod_price as prod_price,
    py.cart_discount AS total_cart_value,
    tr.total_subtotal,
    t.prod_id,
    SUM(CAST((t.prod_qty * t.prod_price) * (py.cart_discount / tr.total_subtotal)AS DECIMAL(10,2))) AS cartPerItem,
    CAST((py.cart_discount / tr.total_subtotal) AS DECIMAL(10,2)) AS cart_discount
FROM
    transactions AS t
INNER JOIN
    products AS p ON p.id = t.prod_id
INNER JOIN
    payments AS py ON py.id = t.payment_id
INNER JOIN (
    SELECT 
        payment_id, 
        SUM(subtotal) AS total_subtotal
    FROM 
        transactions 
    GROUP BY 
        payment_id
) AS tr ON tr.payment_id = py.id
WHERE
    t.is_paid = 1
    AND t.is_void = 0 AND DATE(py.date_time_of_payment)= :singleDateData AND p.id = :selectedProduct
GROUP BY
    t.prod_id) AS cart on cart.prod_id = t.prod_id
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.prod_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment)= :singleDateData AND products.id = :selectedProduct
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.refunded_id,
        rs.payment_id,
        rs.prod_id ,
        SUM( rs.refundCart) as overallCart,
        SUM( rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                        
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.product_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment)= :singleDateData AND p.id = :selectedProduct
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.return_id,
        rs.payment_id,
        rs.product_id,
        SUM(rs.returnCart) as overallCart,
        SUM(rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100
                        AS DECIMAL(10,2)
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    AND t.is_void = 0 AND DATE(py.date_time_of_payment)= :singleDateData AND p.id = :selectedProduct
GROUP BY
    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
HAVING
newQty > 0;
           ";
            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':singleDateData',  $singleDateData);
            $sql->bindParam( ':selectedProduct',  $selectedProduct);
            $sql->execute();
            return $sql;  
        }else if($selectedProduct && !$selectedCategories && !$selectedSubCategories && !$singleDateData && $startDate && $endDate){
            $sql = "SELECT DISTINCT  
    p.id AS id, 
    p.prod_desc AS prod_desc, 
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
    SUM(
        CASE 
            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
            ELSE 0 
        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)  AS overallDiscounts,
    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,
    CASE
        WHEN p.isVAT = 1 THEN 
            CAST(
                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                AS DECIMAL(10,2)
            )
        ELSE 0
    END AS totalVat,
    (CAST(COALESCE((cart.cartPerItem),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0)) as totalCartDiscountPerItem,
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
INNER JOIN (SELECT
    py.id AS payment_id,
    t.prod_id AS product_id,
    SUM(t.prod_qty) AS prod_qty,
    t.prod_price as prod_price,
    py.cart_discount AS total_cart_value,
    tr.total_subtotal,
    t.prod_id,
    SUM(CAST((t.prod_qty * t.prod_price) * (py.cart_discount / tr.total_subtotal)AS DECIMAL(10,2))) AS cartPerItem,
    CAST((py.cart_discount / tr.total_subtotal) AS DECIMAL(10,2)) AS cart_discount
FROM
    transactions AS t
INNER JOIN
    products AS p ON p.id = t.prod_id
INNER JOIN
    payments AS py ON py.id = t.payment_id
INNER JOIN (
    SELECT 
        payment_id, 
        SUM(subtotal) AS total_subtotal
    FROM 
        transactions 
    GROUP BY 
        payment_id
) AS tr ON tr.payment_id = py.id
WHERE
    t.is_paid = 1
    AND t.is_void = 0 DATE(py.date_time_of_payment) BETWEEN :startDate AND :endDate  AND p.id = :selectedProduct
GROUP BY
    t.prod_id) AS cart on cart.prod_id = t.prod_id
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.prod_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate  AND p.id = :selectedProduct
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.refunded_id,
        rs.payment_id,
        rs.prod_id ,
        SUM( rs.refundCart) as overallCart,
        SUM( rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                        
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.product_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate  AND products.id = :selectedProduct
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.return_id,
        rs.payment_id,
        rs.product_id,
        SUM(rs.returnCart) as overallCart,
        SUM(rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100
                        AS DECIMAL(10,2)
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
     AND t.is_void = 0 AND DATE(py.date_time_of_payment) BETWEEN :startDate AND :endDate  AND p.id = :selectedProduct
GROUP BY
    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
HAVING
newQty > 0;
           ";
            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->bindParam( ':selectedProduct',  $selectedProduct);
            $sql->execute();
            return $sql;  
           
        }else if(!$selectedProduct && $selectedCategories && $selectedSubCategories && !$singleDateData && !$startDate && !$endDate){
            $sql = "SELECT DISTINCT  
    p.id AS id, 
    p.prod_desc AS prod_desc, 
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
    SUM(
        CASE 
            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
            ELSE 0 
        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)  AS overallDiscounts,
    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,
    CASE
        WHEN p.isVAT = 1 THEN 
            CAST(
                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                AS DECIMAL(10,2)
            )
        ELSE 0
    END AS totalVat,
    (CAST(COALESCE((cart.cartPerItem),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0)) as totalCartDiscountPerItem,
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
INNER JOIN (SELECT
    py.id AS payment_id,
    t.prod_id AS product_id,
    SUM(t.prod_qty) AS prod_qty,
    t.prod_price as prod_price,
    py.cart_discount AS total_cart_value,
    tr.total_subtotal,
    t.prod_id,
    SUM(CAST((t.prod_qty * t.prod_price) * (py.cart_discount / tr.total_subtotal)AS DECIMAL(10,2))) AS cartPerItem,
    CAST((py.cart_discount / tr.total_subtotal) AS DECIMAL(10,2)) AS cart_discount
FROM
    transactions AS t
INNER JOIN
    products AS p ON p.id = t.prod_id
INNER JOIN
    payments AS py ON py.id = t.payment_id
INNER JOIN (
    SELECT 
        payment_id, 
        SUM(subtotal) AS total_subtotal
    FROM 
        transactions 
    GROUP BY 
        payment_id
) AS tr ON tr.payment_id = py.id
WHERE
    t.is_paid = 1
    AND t.is_void = 0 AND p.category_id = :selectedCategories AND p.variant_id = :selectedSubCategories
GROUP BY
    t.prod_id) AS cart on cart.prod_id = t.prod_id
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.prod_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE products.category_id = :selectedCategories AND products.variant_id = :selectedSubCategories
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.refunded_id,
        rs.payment_id,
        rs.prod_id ,
        SUM( rs.refundCart) as overallCart,
        SUM( rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                        
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.product_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE products.category_id = :selectedCategories AND products.variant_id = :selectedSubCategories
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.return_id,
        rs.payment_id,
        rs.product_id,
        SUM(rs.returnCart) as overallCart,
        SUM(rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100
                        AS DECIMAL(10,2)
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    AND t.is_void = 0 AND p.category_id = :selectedCategories AND p.variant_id = :selectedSubCategories
GROUP BY
    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
HAVING
newQty > 0;
           ";
            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':selectedSubCategories', $selectedSubCategories );
            $sql->bindParam( ':selectedCategories',  $selectedCategories);
            $sql->execute();
            return $sql;  
        }else if(!$selectedProduct && $selectedCategories && !$selectedSubCategories && $singleDateData && !$startDate && !$endDate){
            $sql = "SELECT DISTINCT  
    p.id AS id, 
    p.prod_desc AS prod_desc, 
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
    SUM(
        CASE 
            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
            ELSE 0 
        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)  AS overallDiscounts,
    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,
    CASE
        WHEN p.isVAT = 1 THEN 
            CAST(
                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                AS DECIMAL(10,2)
            )
        ELSE 0
    END AS totalVat,
    (CAST(COALESCE((cart.cartPerItem),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0)) as totalCartDiscountPerItem,
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
INNER JOIN (SELECT
    py.id AS payment_id,
    t.prod_id AS product_id,
    SUM(t.prod_qty) AS prod_qty,
    t.prod_price as prod_price,
    py.cart_discount AS total_cart_value,
    tr.total_subtotal,
    t.prod_id,
    SUM(CAST((t.prod_qty * t.prod_price) * (py.cart_discount / tr.total_subtotal)AS DECIMAL(10,2))) AS cartPerItem,
    CAST((py.cart_discount / tr.total_subtotal) AS DECIMAL(10,2)) AS cart_discount
FROM
    transactions AS t
INNER JOIN
    products AS p ON p.id = t.prod_id
INNER JOIN
    payments AS py ON py.id = t.payment_id
INNER JOIN (
    SELECT 
        payment_id, 
        SUM(subtotal) AS total_subtotal
    FROM 
        transactions 
    GROUP BY 
        payment_id
) AS tr ON tr.payment_id = py.id
WHERE
    t.is_paid = 1
    AND t.is_void = 0 AND DATE(py.date_time_of_payment) = :singleDateData AND p.category_id = :selectedCategories
GROUP BY
    t.prod_id) AS cart on cart.prod_id = t.prod_id
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.prod_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment) = :singleDateData AND products.category_id = :selectedCategories
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.refunded_id,
        rs.payment_id,
        rs.prod_id ,
        SUM( rs.refundCart) as overallCart,
        SUM( rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                        
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.product_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment) = :singleDateData AND products.category_id = :selectedCategories
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.return_id,
        rs.payment_id,
        rs.product_id,
        SUM(rs.returnCart) as overallCart,
        SUM(rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100
                        AS DECIMAL(10,2)
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
   AND t.is_void = 0 AND DATE(py.date_time_of_payment) = :singleDateData AND p.category_id = :selectedCategories
GROUP BY
    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
HAVING
newQty > 0;
           ";
            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':singleDateData', $singleDateData);
            $sql->bindParam( ':selectedCategories',  $selectedCategories);
            $sql->execute();
            return $sql;  
        }else if(!$selectedProduct && $selectedCategories && !$selectedSubCategories && !$singleDateData && $startDate && $endDate){
            $sql = "SELECT DISTINCT  
    p.id AS id, 
    p.prod_desc AS prod_desc, 
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
    SUM(
        CASE 
            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
            ELSE 0 
        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)  AS overallDiscounts,
    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,
    CASE
        WHEN p.isVAT = 1 THEN 
            CAST(
                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                AS DECIMAL(10,2)
            )
        ELSE 0
    END AS totalVat,
    (CAST(COALESCE((cart.cartPerItem),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0)) as totalCartDiscountPerItem,
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
INNER JOIN (SELECT
    py.id AS payment_id,
    t.prod_id AS product_id,
    SUM(t.prod_qty) AS prod_qty,
    t.prod_price as prod_price,
    py.cart_discount AS total_cart_value,
    tr.total_subtotal,
    t.prod_id,
    SUM(CAST((t.prod_qty * t.prod_price) * (py.cart_discount / tr.total_subtotal)AS DECIMAL(10,2))) AS cartPerItem,
    CAST((py.cart_discount / tr.total_subtotal) AS DECIMAL(10,2)) AS cart_discount
FROM
    transactions AS t
INNER JOIN
    products AS p ON p.id = t.prod_id
INNER JOIN
    payments AS py ON py.id = t.payment_id
INNER JOIN (
    SELECT 
        payment_id, 
        SUM(subtotal) AS total_subtotal
    FROM 
        transactions 
    GROUP BY 
        payment_id
) AS tr ON tr.payment_id = py.id
WHERE
    t.is_paid = 1
    AND t.is_void = 0 AND DATE(py.date_time_of_payment) BETWEEN :startDate AND :endDate AND p.category_id = :selectedCategories
GROUP BY
    t.prod_id) AS cart on cart.prod_id = t.prod_id
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.prod_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate AND products.category_id = :selectedCategories
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.refunded_id,
        rs.payment_id,
        rs.prod_id ,
        SUM( rs.refundCart) as overallCart,
        SUM( rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                        
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.product_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate AND products.category_id = :selectedCategories
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.return_id,
        rs.payment_id,
        rs.product_id,
        SUM(rs.returnCart) as overallCart,
        SUM(rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100
                        AS DECIMAL(10,2)
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    AND t.is_void = 0 AND DATE(py.date_time_of_payment) BETWEEN :startDate AND :endDate AND p.category_id = :selectedCategories
GROUP BY
    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
HAVING
newQty > 0;
           ";
            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->bindParam( ':selectedCategories',  $selectedCategories);
            $sql->execute();
            return $sql;  
        }else if(!$selectedProduct && !$selectedCategories && $selectedSubCategories && $singleDateData && !$startDate && !$endDate){
            $sql = "SELECT DISTINCT  
    p.id AS id, 
    p.prod_desc AS prod_desc, 
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
    SUM(
        CASE 
            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
            ELSE 0 
        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)  AS overallDiscounts,
    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,
    CASE
        WHEN p.isVAT = 1 THEN 
            CAST(
                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                AS DECIMAL(10,2)
            )
        ELSE 0
    END AS totalVat,
    (CAST(COALESCE((cart.cartPerItem),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0)) as totalCartDiscountPerItem,
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
INNER JOIN (SELECT
    py.id AS payment_id,
    t.prod_id AS product_id,
    SUM(t.prod_qty) AS prod_qty,
    t.prod_price as prod_price,
    py.cart_discount AS total_cart_value,
    tr.total_subtotal,
    t.prod_id,
    SUM(CAST((t.prod_qty * t.prod_price) * (py.cart_discount / tr.total_subtotal)AS DECIMAL(10,2))) AS cartPerItem,
    CAST((py.cart_discount / tr.total_subtotal) AS DECIMAL(10,2)) AS cart_discount
FROM
    transactions AS t
INNER JOIN
    products AS p ON p.id = t.prod_id
INNER JOIN
    payments AS py ON py.id = t.payment_id
INNER JOIN (
    SELECT 
        payment_id, 
        SUM(subtotal) AS total_subtotal
    FROM 
        transactions 
    GROUP BY 
        payment_id
) AS tr ON tr.payment_id = py.id
WHERE
    t.is_paid = 1
    AND t.is_void = 0 AND DATE(py.date_time_of_payment) = :singleDateData AND p.variant_id = :selectedSubCategories
GROUP BY
    t.prod_id) AS cart on cart.prod_id = t.prod_id
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.prod_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment) = :singleDateData AND products.variant_id = :selectedSubCategories
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.refunded_id,
        rs.payment_id,
        rs.prod_id ,
        SUM( rs.refundCart) as overallCart,
        SUM( rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                        
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.product_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment) = :singleDateData AND products.variant_id = :selectedSubCategories
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.return_id,
        rs.payment_id,
        rs.product_id,
        SUM(rs.returnCart) as overallCart,
        SUM(rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100
                        AS DECIMAL(10,2)
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    AND t.is_void = 0 AND DATE(py.date_time_of_payment) = :singleDateData AND p.variant_id = :selectedSubCategories
GROUP BY
    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
HAVING
newQty > 0;
           ";
            $sql = $this->connect()->prepare( $sql );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->bindParam( ':selectedSubCategories',  $selectedSubCategories);
            $sql->execute();
            return $sql;  
        }else if(!$selectedProduct && !$selectedCategories && $selectedSubCategories && !$singleDateData && $startDate && $endDate){
            $sql = "SELECT DISTINCT  
            p.id AS id, 
            p.prod_desc AS prod_desc, 
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
            SUM(
                CASE 
                    WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                        THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
                    WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                        THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
                    ELSE 0 
                END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)  AS overallDiscounts,
            ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,
            CASE
                WHEN p.isVAT = 1 THEN 
                    CAST(
                        ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                        AS DECIMAL(10,2)
                    )
                ELSE 0
            END AS totalVat,
            (CAST(COALESCE((cart.cartPerItem),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0)) as totalCartDiscountPerItem,
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
        INNER JOIN (SELECT
            py.id AS payment_id,
            t.prod_id AS product_id,
            SUM(t.prod_qty) AS prod_qty,
            t.prod_price as prod_price,
            py.cart_discount AS total_cart_value,
            tr.total_subtotal,
            t.prod_id,
            SUM(CAST((t.prod_qty * t.prod_price) * (py.cart_discount / tr.total_subtotal)AS DECIMAL(10,2))) AS cartPerItem,
            CAST((py.cart_discount / tr.total_subtotal) AS DECIMAL(10,2)) AS cart_discount
        FROM
            transactions AS t
        INNER JOIN
            products AS p ON p.id = t.prod_id
        INNER JOIN
            payments AS py ON py.id = t.payment_id
        INNER JOIN (
            SELECT 
                payment_id, 
                SUM(subtotal) AS total_subtotal
            FROM 
                transactions 
            GROUP BY 
                payment_id
        ) AS tr ON tr.payment_id = py.id
        WHERE
            t.is_paid = 1
            AND t.is_void = 0 AND DATE(py.date_time_of_payment) BETWEEN :startDate AND :endDate AND p.variant_id = :selectedSubCategories
        GROUP BY
            t.prod_id) AS cart on cart.prod_id = t.prod_id
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
            INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
            INNER JOIN products ON r.prod_id = products.id
            INNER JOIN users AS u ON t.user_id = u.id
            INNER JOIN discounts AS d ON u.discount_id = d.id
            WHERE DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate AND products.variant_id = :selectedSubCategories
        ),
        CustomerDiscounts AS (
            SELECT 
            DISTINCT
                rs.refunded_id,
                rs.payment_id,
                rs.prod_id ,
                SUM( rs.refundCart) as overallCart,
                SUM( rs.total_item_discounts) AS overAlldiscounts,
                SUM( rs.qty) AS total_qty,
                CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
                SUM(
                    CASE
                        WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                            CAST(
                                (
                                    ((rs.qty * rs.prod_price) - 
                                    (rs.total_item_discounts)
                                ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                                
                            )
                        WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                            CAST(
                                (
                                    ((rs.qty * rs.prod_price) - 
                                    (rs.total_item_discounts)
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
            INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
            INNER JOIN products ON r.product_id = products.id
            INNER JOIN users AS u ON t.user_id = u.id
            INNER JOIN discounts AS d ON u.discount_id = d.id
            WHERE DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate AND products.variant_id = :selectedSubCategories
        ),
        CustomerDiscounts AS (
            SELECT 
            DISTINCT
                rs.return_id,
                rs.payment_id,
                rs.product_id,
                SUM(rs.returnCart) as overallCart,
                SUM(rs.total_item_discounts) AS overAlldiscounts,
                SUM( rs.qty) AS total_qty,
                CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
                SUM(
                    CASE
                        WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                            CAST(
                                (
                                    ((rs.qty * rs.prod_price) - 
                                    (rs.total_item_discounts)
                                ) / 1.12) * rs.discountRate / 100
                                AS DECIMAL(10,2)
                            )
                        WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                            CAST(
                                (
                                    ((rs.qty * rs.prod_price) - 
                                    (rs.total_item_discounts)
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
            AND t.is_void = 0 AND DATE(py.date_time_of_payment) BETWEEN :startDate AND :endDate AND p.variant_id = :selectedSubCategories
        GROUP BY
            p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
        HAVING
        newQty > 0;";
        
        $sql = $this->connect()->prepare( $sql );
        $sql->bindParam( ':selectedSubCategories', $selectedSubCategories);
        $sql->bindParam( ':startDate',  $startDate);
        $sql->bindParam( ':endDate',  $endDate);
        $sql->execute();

        return $sql;
        }else{
            $sql = "SELECT DISTINCT  
    p.id AS id, 
    p.prod_desc AS prod_desc, 
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
    SUM(
        CASE 
            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
            ELSE 0 
        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)  AS overallDiscounts,
    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,
    CASE
        WHEN p.isVAT = 1 THEN 
            CAST(
                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                AS DECIMAL(10,2)
            )
        ELSE 0
    END AS totalVat,
    (CAST(COALESCE((cart.cartPerItem),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0)) as totalCartDiscountPerItem,
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
INNER JOIN (SELECT
    py.id AS payment_id,
    t.prod_id AS product_id,
    SUM(t.prod_qty) AS prod_qty,
    t.prod_price as prod_price,
    py.cart_discount AS total_cart_value,
    tr.total_subtotal,
    t.prod_id,
    SUM(CAST((t.prod_qty * t.prod_price) * (py.cart_discount / tr.total_subtotal)AS DECIMAL(10,2))) AS cartPerItem,
    CAST((py.cart_discount / tr.total_subtotal) AS DECIMAL(10,2)) AS cart_discount
FROM
    transactions AS t
INNER JOIN
    products AS p ON p.id = t.prod_id
INNER JOIN
    payments AS py ON py.id = t.payment_id
INNER JOIN (
    SELECT 
        payment_id, 
        SUM(subtotal) AS total_subtotal
    FROM 
        transactions 
    GROUP BY 
        payment_id
) AS tr ON tr.payment_id = py.id
WHERE
    t.is_paid = 1
    AND t.is_void = 0 
GROUP BY
    t.prod_id) AS cart on cart.prod_id = t.prod_id
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
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
        SUM( rs.refundCart) as overallCart,
        SUM( rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                        
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
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
        SUM(rs.returnCart) as overallCart,
        SUM(rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100
                        AS DECIMAL(10,2)
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
GROUP BY
    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
HAVING
newQty > 0;";

            $stmt = $this->connect()->query( $sql );
            return $stmt;

        }
    }

    public function taxRates( $singleDateData, $startDate, $endDate ) {
        if ( $singleDateData && !$startDate && !$endDate ) {
            $sqlQuery = "SELECT  SUM(JSON_VALUE(all_data, '$.vat_amount')) AS total_vat_amount, SUM(JSON_VALUE(all_data, '$.vatable_sales'))
     AS total_vatable_sales,date_time,
     SUM(JSON_VALUE(all_data, '$.zero_rated')) AS total_zero_rated,
    SUM(JSON_VALUE(all_data, '$.otherCustomerVat')) AS total_other

    FROM z_read
    WHERE DATE(date_time) = :singleDateData
    ";

            $sql = $this->connect()->prepare( $sqlQuery );

            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;

        } else if ( !$singleDateData && $startDate && $endDate ) {
            $sqlQuery = "SELECT  SUM(JSON_VALUE(all_data, '$.vat_amount')) AS total_vat_amount, SUM(JSON_VALUE(all_data, '$.vatable_sales'))
    AS total_vatable_sales,date_time,
    SUM(JSON_VALUE(all_data, '$.zero_rated')) AS total_zero_rated,
    SUM(JSON_VALUE(all_data, '$.otherCustomerVat')) AS total_other
   FROM z_read
   WHERE DATE(date_time) BETWEEN :startDate AND :endDate
   ";

            $sql = $this->connect()->prepare( $sqlQuery );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;
        } else {
            $sql = "SELECT  SUM(JSON_VALUE(all_data, '$.vat_amount')) AS total_vat_amount,
     SUM(JSON_VALUE(all_data, '$.vatable_sales')) AS total_vatable_sales,date_time,
     SUM(JSON_VALUE(all_data, '$.zero_rated')) AS total_zero_rated,
    SUM(JSON_VALUE(all_data, '$.otherCustomerVat')) AS total_other
      FROM z_read;";

            $stmt = $this->connect()->query( $sql );
            return $stmt;
        }
    }

    public function getProfit( $selectedProduct,$singleDateData, $startDate, $endDate ) {
      
            if ( $selectedProduct && !$singleDateData && !$startDate && !$endDate ) {
                $sqlQuery = "SELECT DISTINCT  
    p.id AS id, 
    p.prod_desc AS prod_desc, 
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
    SUM(
        CASE 
            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
            ELSE 0 
        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)  AS overallDiscounts,
    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,
    CASE
        WHEN p.isVAT = 1 THEN 
            CAST(
                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                AS DECIMAL(10,2)
            )
        ELSE 0
    END AS totalVat,
    (CAST(COALESCE((cart.cartPerItem),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0)) as totalCartDiscountPerItem,
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
INNER JOIN (SELECT
    py.id AS payment_id,
    t.prod_id AS product_id,
    SUM(t.prod_qty) AS prod_qty,
    t.prod_price as prod_price,
    py.cart_discount AS total_cart_value,
    tr.total_subtotal,
    t.prod_id,
    SUM(CAST((t.prod_qty * t.prod_price) * (py.cart_discount / tr.total_subtotal)AS DECIMAL(10,2))) AS cartPerItem,
    CAST((py.cart_discount / tr.total_subtotal) AS DECIMAL(10,2)) AS cart_discount
FROM
    transactions AS t
INNER JOIN
    products AS p ON p.id = t.prod_id
INNER JOIN
    payments AS py ON py.id = t.payment_id
INNER JOIN (
    SELECT 
        payment_id, 
        SUM(subtotal) AS total_subtotal
    FROM 
        transactions 
    GROUP BY 
        payment_id
) AS tr ON tr.payment_id = py.id
WHERE
    t.is_paid = 1
    AND t.is_void = 0 AND p.id = :selectedProduct
GROUP BY
    t.prod_id) AS cart on cart.prod_id = t.prod_id
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.prod_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE products.id = :selectedProduct
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.refunded_id,
        rs.payment_id,
        rs.prod_id ,
        SUM( rs.refundCart) as overallCart,
        SUM( rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                        
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.product_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE products.id = :selectedProduct
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.return_id,
        rs.payment_id,
        rs.product_id,
        SUM(rs.returnCart) as overallCart,
        SUM(rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100
                        AS DECIMAL(10,2)
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    AND t.is_void = 0  AND p.id = :selectedProduct
GROUP BY
    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
HAVING
newQty > 0;";
                $sql = $this->connect()->prepare( $sqlQuery );
                $sql->bindParam( ':selectedProduct', $selectedProduct );
                $sql->execute();
                return $sql;

            }else if(!$selectedProduct && $singleDateData && !$startDate && !$endDate){
                $sqlQuery = "SELECT DISTINCT  
    p.id AS id, 
    p.prod_desc AS prod_desc, 
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
    SUM(
        CASE 
            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
            ELSE 0 
        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)  AS overallDiscounts,
    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,
    CASE
        WHEN p.isVAT = 1 THEN 
            CAST(
                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                AS DECIMAL(10,2)
            )
        ELSE 0
    END AS totalVat,
    (CAST(COALESCE((cart.cartPerItem),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0)) as totalCartDiscountPerItem,
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
INNER JOIN (SELECT
    py.id AS payment_id,
    t.prod_id AS product_id,
    SUM(t.prod_qty) AS prod_qty,
    t.prod_price as prod_price,
    py.cart_discount AS total_cart_value,
    tr.total_subtotal,
    t.prod_id,
    SUM(CAST((t.prod_qty * t.prod_price) * (py.cart_discount / tr.total_subtotal)AS DECIMAL(10,2))) AS cartPerItem,
    CAST((py.cart_discount / tr.total_subtotal) AS DECIMAL(10,2)) AS cart_discount
FROM
    transactions AS t
INNER JOIN
    products AS p ON p.id = t.prod_id
INNER JOIN
    payments AS py ON py.id = t.payment_id
INNER JOIN (
    SELECT 
        payment_id, 
        SUM(subtotal) AS total_subtotal
    FROM 
        transactions 
    GROUP BY 
        payment_id
) AS tr ON tr.payment_id = py.id
WHERE
    t.is_paid = 1
    AND t.is_void = 0 AND DATE(py.date_time_of_payment) = :singleDateData
GROUP BY
    t.prod_id) AS cart on cart.prod_id = t.prod_id
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.prod_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment) = :singleDateData
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.refunded_id,
        rs.payment_id,
        rs.prod_id ,
        SUM( rs.refundCart) as overallCart,
        SUM( rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                        
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.product_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment) = :singleDateData
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.return_id,
        rs.payment_id,
        rs.product_id,
        SUM(rs.returnCart) as overallCart,
        SUM(rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100
                        AS DECIMAL(10,2)
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    AND t.is_void = 0  AND DATE(py.date_time_of_payment) = :singleDateData
GROUP BY
    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
HAVING
newQty > 0;";
                $sql = $this->connect()->prepare( $sqlQuery );
                $sql->bindParam( ':singleDateData', $singleDateData );
                $sql->execute();
                return $sql;
            }else if(!$selectedProduct && !$singleDateData && $startDate && $endDate){
                $sqlQuery = "SELECT DISTINCT  
    p.id AS id, 
    p.prod_desc AS prod_desc, 
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
    SUM(
        CASE 
            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
            ELSE 0 
        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)  AS overallDiscounts,
    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,
    CASE
        WHEN p.isVAT = 1 THEN 
            CAST(
                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                AS DECIMAL(10,2)
            )
        ELSE 0
    END AS totalVat,
    (CAST(COALESCE((cart.cartPerItem),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0)) as totalCartDiscountPerItem,
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
INNER JOIN (SELECT
    py.id AS payment_id,
    t.prod_id AS product_id,
    SUM(t.prod_qty) AS prod_qty,
    t.prod_price as prod_price,
    py.cart_discount AS total_cart_value,
    tr.total_subtotal,
    t.prod_id,
    SUM(CAST((t.prod_qty * t.prod_price) * (py.cart_discount / tr.total_subtotal)AS DECIMAL(10,2))) AS cartPerItem,
    CAST((py.cart_discount / tr.total_subtotal) AS DECIMAL(10,2)) AS cart_discount
FROM
    transactions AS t
INNER JOIN
    products AS p ON p.id = t.prod_id
INNER JOIN
    payments AS py ON py.id = t.payment_id
INNER JOIN (
    SELECT 
        payment_id, 
        SUM(subtotal) AS total_subtotal
    FROM 
        transactions 
    GROUP BY 
        payment_id
) AS tr ON tr.payment_id = py.id
WHERE
    t.is_paid = 1
    AND t.is_void = 0 AND  DATE(py.date_time_of_payment) BETWEEN :startDate AND :endDate
GROUP BY
    t.prod_id) AS cart on cart.prod_id = t.prod_id
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.prod_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.refunded_id,
        rs.payment_id,
        rs.prod_id ,
        SUM( rs.refundCart) as overallCart,
        SUM( rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                        
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.product_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.return_id,
        rs.payment_id,
        rs.product_id,
        SUM(rs.returnCart) as overallCart,
        SUM(rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100
                        AS DECIMAL(10,2)
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    AND t.is_void = 0  AND DATE(py.date_time_of_payment) BETWEEN :startDate AND :endDate
GROUP BY
    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
HAVING
newQty > 0;";

            $sql = $this->connect()->prepare( $sqlQuery);
            $sql->bindParam( ':startDate',$startDate);
            $sql->bindParam( ':endDate',$endDate);
            $sql->execute();
            return $sql;
            }else if($selectedProduct && $singleDateData && !$startDate && !$endDate){
                $sqlQuery = "SELECT DISTINCT  
    p.id AS id, 
    p.prod_desc AS prod_desc, 
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
    SUM(
        CASE 
            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
            ELSE 0 
        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)  AS overallDiscounts,
    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,
    CASE
        WHEN p.isVAT = 1 THEN 
            CAST(
                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                AS DECIMAL(10,2)
            )
        ELSE 0
    END AS totalVat,
    (CAST(COALESCE((cart.cartPerItem),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0)) as totalCartDiscountPerItem,
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
INNER JOIN (SELECT
    py.id AS payment_id,
    t.prod_id AS product_id,
    SUM(t.prod_qty) AS prod_qty,
    t.prod_price as prod_price,
    py.cart_discount AS total_cart_value,
    tr.total_subtotal,
    t.prod_id,
    SUM(CAST((t.prod_qty * t.prod_price) * (py.cart_discount / tr.total_subtotal)AS DECIMAL(10,2))) AS cartPerItem,
    CAST((py.cart_discount / tr.total_subtotal) AS DECIMAL(10,2)) AS cart_discount
FROM
    transactions AS t
INNER JOIN
    products AS p ON p.id = t.prod_id
INNER JOIN
    payments AS py ON py.id = t.payment_id
INNER JOIN (
    SELECT 
        payment_id, 
        SUM(subtotal) AS total_subtotal
    FROM 
        transactions 
    GROUP BY 
        payment_id
) AS tr ON tr.payment_id = py.id
WHERE
    t.is_paid = 1
    AND t.is_void = 0 AND DATE(py.date_time_of_payment) = :singleDateData AND p.id = :selectedProduct
GROUP BY
    t.prod_id) AS cart on cart.prod_id = t.prod_id
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.prod_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment) = :singleDateData AND products.id = :selectedProduct
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.refunded_id,
        rs.payment_id,
        rs.prod_id ,
        SUM( rs.refundCart) as overallCart,
        SUM( rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                        
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.product_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment) = :singleDateData AND products.id = :selectedProduct
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.return_id,
        rs.payment_id,
        rs.product_id,
        SUM(rs.returnCart) as overallCart,
        SUM(rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100
                        AS DECIMAL(10,2)
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    AND t.is_void = 0 AND DATE(py.date_time_of_payment) = :singleDateData AND p.id = :selectedProduct
GROUP BY
    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
HAVING
newQty > 0;";
            $sql = $this->connect()->prepare( $sqlQuery);
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->bindParam( ':selectedProduct', $selectedProduct);
            $sql->execute();
            return $sql;
            }else if ($selectedProduct && !$singleDateData && $startDate && $endDate){
                $sqlQuery = "SELECT DISTINCT  
    p.id AS id, 
    p.prod_desc AS prod_desc, 
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
    SUM(
        CASE 
            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
            ELSE 0 
        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)  AS overallDiscounts,
    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,
    CASE
        WHEN p.isVAT = 1 THEN 
            CAST(
                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                AS DECIMAL(10,2)
            )
        ELSE 0
    END AS totalVat,
    (CAST(COALESCE((cart.cartPerItem),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0)) as totalCartDiscountPerItem,
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
INNER JOIN (SELECT
    py.id AS payment_id,
    t.prod_id AS product_id,
    SUM(t.prod_qty) AS prod_qty,
    t.prod_price as prod_price,
    py.cart_discount AS total_cart_value,
    tr.total_subtotal,
    t.prod_id,
    SUM(CAST((t.prod_qty * t.prod_price) * (py.cart_discount / tr.total_subtotal)AS DECIMAL(10,2))) AS cartPerItem,
    CAST((py.cart_discount / tr.total_subtotal) AS DECIMAL(10,2)) AS cart_discount
FROM
    transactions AS t
INNER JOIN
    products AS p ON p.id = t.prod_id
INNER JOIN
    payments AS py ON py.id = t.payment_id
INNER JOIN (
    SELECT 
        payment_id, 
        SUM(subtotal) AS total_subtotal
    FROM 
        transactions 
    GROUP BY 
        payment_id
) AS tr ON tr.payment_id = py.id
WHERE
    t.is_paid = 1
    AND t.is_void = 0 AND DATE(py.date_time_of_payment) BETWEEN :startDate AND :endDate AND p.id = :selectedProduct
GROUP BY
    t.prod_id) AS cart on cart.prod_id = t.prod_id
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.prod_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate AND products.id = :selectedProduct
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.refunded_id,
        rs.payment_id,
        rs.prod_id ,
        SUM( rs.refundCart) as overallCart,
        SUM( rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                        
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
    INNER JOIN products ON r.product_id = products.id
    INNER JOIN users AS u ON t.user_id = u.id
    INNER JOIN discounts AS d ON u.discount_id = d.id
    WHERE DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate AND products.id = :selectedProduct
),
CustomerDiscounts AS (
    SELECT 
    DISTINCT
        rs.return_id,
        rs.payment_id,
        rs.product_id,
        SUM(rs.returnCart) as overallCart,
        SUM(rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100
                        AS DECIMAL(10,2)
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    AND t.is_void = 0 AND DATE(py.date_time_of_payment) BETWEEN :startDate AND :endDate AND p.id = :selectedProduct
GROUP BY
    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
HAVING
newQty > 0;";
            $sql = $this->connect()->prepare( $sqlQuery);
            $sql->bindParam( ':selectedProduct', $selectedProduct );
            $sql->bindParam( ':startDate', $startDate);
            $sql->bindParam( ':endDate', $endDate);
            $sql->execute();
            return $sql;
            }
            else {
                $sql = "SELECT DISTINCT  
    p.id AS id, 
    p.prod_desc AS prod_desc, 
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
    SUM(
        CASE 
            WHEN p.isVAT = 1 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN (((t.prod_qty * p.prod_price)-t.discount_amount) / 1.12) * (d.discount_amount / 100)
            WHEN p.isVAT = 0 AND p.is_discounted = 1 AND d.discount_amount > 0
                THEN ((t.prod_qty * p.prod_price)-t.discount_amount) * (d.discount_amount / 100)
            ELSE 0 
        END)-COALESCE(ret.total_customer_discount,0)-COALESCE(tr.total_customer_discount,0)  AS overallDiscounts,
    ((SUM(t.prod_qty) - COALESCE(tr.total_qty,0)- COALESCE(ret.total_qty,0)) * p.prod_price) AS grossAmount,
    CASE
        WHEN p.isVAT = 1 THEN 
            CAST(
                ((( COALESCE((SUM(t.prod_qty)), 0)) * p.prod_price) / 1.12) * 0.12
                AS DECIMAL(10,2)
            )
        ELSE 0
    END AS totalVat,
    (CAST(COALESCE((cart.cartPerItem),0) AS  DECIMAL(10,2))- COALESCE(tr.total_cart,0)- COALESCE(ret.total_cart,0)) as totalCartDiscountPerItem,
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
INNER JOIN (SELECT
    py.id AS payment_id,
    t.prod_id AS product_id,
    SUM(t.prod_qty) AS prod_qty,
    t.prod_price as prod_price,
    py.cart_discount AS total_cart_value,
    tr.total_subtotal,
    t.prod_id,
    SUM(CAST((t.prod_qty * t.prod_price) * (py.cart_discount / tr.total_subtotal)AS DECIMAL(10,2))) AS cartPerItem,
    CAST((py.cart_discount / tr.total_subtotal) AS DECIMAL(10,2)) AS cart_discount
FROM
    transactions AS t
INNER JOIN
    products AS p ON p.id = t.prod_id
INNER JOIN
    payments AS py ON py.id = t.payment_id
INNER JOIN (
    SELECT 
        payment_id, 
        SUM(subtotal) AS total_subtotal
    FROM 
        transactions 
    GROUP BY 
        payment_id
) AS tr ON tr.payment_id = py.id
WHERE
    t.is_paid = 1
    AND t.is_void = 0 
GROUP BY
    t.prod_id) AS cart on cart.prod_id = t.prod_id
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
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
        SUM( rs.refundCart) as overallCart,
        SUM( rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100 AS DECIMAL(10,2)
                        
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
    INNER JOIN (SELECT  * FROM transactions GROUP BY payment_id) as t on t.payment_id=p.id
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
        SUM(rs.returnCart) as overallCart,
        SUM(rs.total_item_discounts) AS overAlldiscounts,
        SUM( rs.qty) AS total_qty,
        CAST(SUM(rs.amount)AS DECIMAL(10,2)) AS total_amount,
        SUM(
            CASE
                WHEN rs.isVAT = 1 AND rs.is_discounted = 1 THEN 
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
                        ) / 1.12) * rs.discountRate / 100
                        AS DECIMAL(10,2)
                    )
                WHEN rs.isVAT = 0 AND rs.is_discounted = 1 AND rs.discountRate > 0 THEN
                    CAST(
                        (
                            ((rs.qty * rs.prod_price) - 
                            (rs.total_item_discounts)
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
GROUP BY
    p.id, p.prod_desc, p.cost, p.sku, p.markup, p.prod_price
HAVING
newQty > 0;";

            $stmt = $this->connect()->query( $sql );
            return $stmt;

            }


    }

    public function customerSales( $customerId, $singleDateData, $startDate, $endDate ) {
        if ( $customerId && !$singleDateData && !$startDate && !$endDate ) {
            $sqlQuery = "WITH RefundSums AS (
                SELECT 
    payment_id,
    SUM(credits) AS credits,
    cartRateRefund AS cartRateRefund,
    SUM(discountsTender) AS discountsTender,
    SUM(refunded_amt) AS refunded_amt,
    SUM(total_item_discounts) AS total_item_discounts,
    SUM(refundCart) AS refundCart
FROM (
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
        CAST(SUM(COALESCE(r.refunded_amt, 0) * COALESCE(
            CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
            0
        )) AS DECIMAL(10,2)) AS refundCart
    FROM 
        refunded r
    GROUP BY 
        r.reference_num
) subquery
GROUP BY 
    payment_id
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
                 CAST(SUM(COALESCE(rc.return_amount, 0) * COALESCE(
                CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
                0
            ))AS DECIMAL(10,2)) AS returnCart
                FROM 
                    return_exchange  rc
                GROUP BY 
                    rc.payment_id
            )
            SELECT
            DISTINCT
                u.first_name AS first_name,
                u.last_name AS last_name, 
                CAST(COALESCE(SUM(p.payment_amount), 0)AS DECIMAL(10,2)) AS paid_amount,
                CAST(COALESCE(SUM(p.change_amount), 0)AS DECIMAL(10,2)) AS totalChange,
                p.date_time_of_payment AS date,
                p.cart_discount AS cart_discount,
                d.discount_amount AS discountsRate,
                CAST(COALESCE(SUM(rs.refunded_amt), 0)AS DECIMAL(10,2)) AS refunded_amt,
                COALESCE(SUM(rs.total_item_discounts), 0) AS total_item_discounts,
                COALESCE(SUM(rs.credits), 0) AS totalCredits,
                COALESCE(SUM(rs.discountsTender), 0) AS totalDiscountsTender,
                COALESCE(SUM(rs.cartRateRefund), 0) AS cartRateRefundTotal,
                COALESCE(SUM(rs.refundCart), 0) AS cartRefundTotal,
           
                
                CAST(COALESCE(SUM(res.return_amt), 0)AS DECIMAL(10,2)) AS return_amt,
                COALESCE(SUM(res. total_return_item_discounts), 0) AS total_return_item_discounts,
                COALESCE(SUM(res.rc_credits), 0) AS totalReturnCredits,
                COALESCE(SUM(res.discountsReturnTender), 0) AS totalDiscountsReturnTender,
                COALESCE(SUM(res.cartRateReturn), 0) AS cartRateReturnTotal,
                COALESCE(SUM(res.returnCart), 0) AS cartReturnTotal
              
               
                
            FROM 
                payments AS p 
                INNER JOIN (SELECT payment_id,user_id,prod_id,is_paid,is_void FROM transactions
                GROUP BY payment_id) as t ON t.payment_id = p.id
                INNER JOIN users AS u ON u.id = t.user_id
                INNER JOIN discounts AS d ON d.id = u.discount_id
                INNER JOIN products AS ps ON ps.id = t.prod_id
                LEFT JOIN RefundSums rs ON rs.payment_id = p.id
                LEFT JOIN ReturnExchangeSums res ON res.payment_id = p.id
            WHERE 
                t.is_paid = 1 
                AND t.is_void = 0 AND u.id = :customerId
            GROUP BY 
                u.id;";

            $sql = $this->connect()->prepare( $sqlQuery );
            $sql->bindParam( ':customerId', $customerId );
            $sql->execute();
            return $sql;

        } else if ( !$customerId && $singleDateData && !$startDate && !$endDate ) {
            $sqlQuery = "WITH RefundSums AS (
                SELECT 
    payment_id,
    SUM(credits) AS credits,
    cartRateRefund AS cartRateRefund,
    SUM(discountsTender) AS discountsTender,
    SUM(refunded_amt) AS refunded_amt,
    SUM(total_item_discounts) AS total_item_discounts,
    SUM(refundCart) AS refundCart
FROM (
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
        CAST(SUM(COALESCE(r.refunded_amt, 0) * COALESCE(
            CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
            0
        )) AS DECIMAL(10,2)) AS refundCart
    FROM 
        refunded r
    GROUP BY 
        r.reference_num
) subquery
GROUP BY 
    payment_id
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
                 CAST(SUM(COALESCE(rc.return_amount, 0) * COALESCE(
                CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
                0
            ))AS DECIMAL(10,2)) AS returnCart
                FROM 
                    return_exchange  rc
                GROUP BY 
                    rc.payment_id
            )
            SELECT
            DISTINCT
                u.first_name AS first_name,
                u.last_name AS last_name, 
                CAST(COALESCE(SUM(p.payment_amount), 0)AS DECIMAL(10,2)) AS paid_amount,
                CAST(COALESCE(SUM(p.change_amount), 0)AS DECIMAL(10,2)) AS totalChange,
                p.date_time_of_payment AS date,
                p.cart_discount AS cart_discount,
                d.discount_amount AS discountsRate,
                CAST(COALESCE(SUM(rs.refunded_amt), 0)AS DECIMAL(10,2)) AS refunded_amt,
                COALESCE(SUM(rs.total_item_discounts), 0) AS total_item_discounts,
                COALESCE(SUM(rs.credits), 0) AS totalCredits,
                COALESCE(SUM(rs.discountsTender), 0) AS totalDiscountsTender,
                COALESCE(SUM(rs.cartRateRefund), 0) AS cartRateRefundTotal,
                COALESCE(SUM(rs.refundCart), 0) AS cartRefundTotal,
           
                
                CAST(COALESCE(SUM(res.return_amt), 0)AS DECIMAL(10,2)) AS return_amt,
                COALESCE(SUM(res. total_return_item_discounts), 0) AS total_return_item_discounts,
                COALESCE(SUM(res.rc_credits), 0) AS totalReturnCredits,
                COALESCE(SUM(res.discountsReturnTender), 0) AS totalDiscountsReturnTender,
                COALESCE(SUM(res.cartRateReturn), 0) AS cartRateReturnTotal,
                COALESCE(SUM(res.returnCart), 0) AS cartReturnTotal
              
               
                
            FROM 
                payments AS p 
                INNER JOIN (SELECT payment_id,user_id,prod_id,is_paid,is_void FROM transactions
                    GROUP BY payment_id) as t ON t.payment_id = p.id
                INNER JOIN users AS u ON u.id = t.user_id
                INNER JOIN discounts AS d ON d.id = u.discount_id
                INNER JOIN products AS ps ON ps.id = t.prod_id
                LEFT JOIN RefundSums rs ON rs.payment_id = p.id
                LEFT JOIN ReturnExchangeSums res ON res.payment_id = p.id
            WHERE 
                t.is_paid = 1 
                AND t.is_void = 0  AND DATE(p.date_time_of_payment) = :singleDateData
            GROUP BY 
                u.id;";

            $sql = $this->connect()->prepare( $sqlQuery );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;
        } else if ( !$customerId && !$singleDateData && $startDate && $endDate ) {
            $sqlQuery = "WITH RefundSums AS (
                SELECT 
    payment_id,
    SUM(credits) AS credits,
    cartRateRefund AS cartRateRefund,
    SUM(discountsTender) AS discountsTender,
    SUM(refunded_amt) AS refunded_amt,
    SUM(total_item_discounts) AS total_item_discounts,
    SUM(refundCart) AS refundCart
FROM (
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
        CAST(SUM(COALESCE(r.refunded_amt, 0) * COALESCE(
            CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
            0
        )) AS DECIMAL(10,2)) AS refundCart
    FROM 
        refunded r
    GROUP BY 
        r.reference_num
) subquery
GROUP BY 
    payment_id
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
                 CAST(SUM(COALESCE(rc.return_amount, 0) * COALESCE(
                CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
                0
            ))AS DECIMAL(10,2)) AS returnCart
                FROM 
                    return_exchange  rc
                GROUP BY 
                    rc.payment_id
            )
            SELECT
            DISTINCT
                u.first_name AS first_name,
                u.last_name AS last_name, 
                CAST(COALESCE(SUM(p.payment_amount), 0)AS DECIMAL(10,2)) AS paid_amount,
                CAST(COALESCE(SUM(p.change_amount), 0)AS DECIMAL(10,2)) AS totalChange,
                p.date_time_of_payment AS date,
                p.cart_discount AS cart_discount,
                d.discount_amount AS discountsRate,
                CAST(COALESCE(SUM(rs.refunded_amt), 0)AS DECIMAL(10,2)) AS refunded_amt,
                COALESCE(SUM(rs.total_item_discounts), 0) AS total_item_discounts,
                COALESCE(SUM(rs.credits), 0) AS totalCredits,
                COALESCE(SUM(rs.discountsTender), 0) AS totalDiscountsTender,
                COALESCE(SUM(rs.cartRateRefund), 0) AS cartRateRefundTotal,
                COALESCE(SUM(rs.refundCart), 0) AS cartRefundTotal,
           
                
                CAST(COALESCE(SUM(res.return_amt), 0)AS DECIMAL(10,2)) AS return_amt,
                COALESCE(SUM(res. total_return_item_discounts), 0) AS total_return_item_discounts,
                COALESCE(SUM(res.rc_credits), 0) AS totalReturnCredits,
                COALESCE(SUM(res.discountsReturnTender), 0) AS totalDiscountsReturnTender,
                COALESCE(SUM(res.cartRateReturn), 0) AS cartRateReturnTotal,
                COALESCE(SUM(res.returnCart), 0) AS cartReturnTotal
              
               
                
            FROM 
                payments AS p 
                INNER JOIN (SELECT payment_id,user_id,prod_id,is_paid,is_void FROM transactions
                GROUP BY payment_id) as t ON t.payment_id = p.id
                INNER JOIN users AS u ON u.id = t.user_id
                INNER JOIN discounts AS d ON d.id = u.discount_id
                INNER JOIN products AS ps ON ps.id = t.prod_id
                LEFT JOIN RefundSums rs ON rs.payment_id = p.id
                LEFT JOIN ReturnExchangeSums res ON res.payment_id = p.id
            WHERE 
                t.is_paid = 1 
                AND t.is_void = 0 AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate
            GROUP BY 
                u.id;";

            $sql = $this->connect()->prepare( $sqlQuery );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;
        } else if ( $customerId && $singleDateData && !$startDate && !$endDate ) {
            $sqlQuery = "WITH RefundSums AS (
            SELECT 
    payment_id,
    SUM(credits) AS credits,
    cartRateRefund AS cartRateRefund,
    SUM(discountsTender) AS discountsTender,
    SUM(refunded_amt) AS refunded_amt,
    SUM(total_item_discounts) AS total_item_discounts,
    SUM(refundCart) AS refundCart
FROM (
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
        CAST(SUM(COALESCE(r.refunded_amt, 0) * COALESCE(
            CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
            0
        )) AS DECIMAL(10,2)) AS refundCart
    FROM 
        refunded r
    GROUP BY 
        r.reference_num
) subquery
GROUP BY 
    payment_id
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
                 CAST(SUM(COALESCE(rc.return_amount, 0) * COALESCE(
                CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
                0
            ))AS DECIMAL(10,2)) AS returnCart
                FROM 
                    return_exchange  rc
                GROUP BY 
                    rc.payment_id
            )
            SELECT
            DISTINCT
                u.first_name AS first_name,
                u.last_name AS last_name, 
                CAST(COALESCE(SUM(p.payment_amount), 0)AS DECIMAL(10,2)) AS paid_amount,
                CAST(COALESCE(SUM(p.change_amount), 0)AS DECIMAL(10,2)) AS totalChange,
                p.date_time_of_payment AS date,
                p.cart_discount AS cart_discount,
                d.discount_amount AS discountsRate,
                CAST(COALESCE(SUM(rs.refunded_amt), 0)AS DECIMAL(10,2)) AS refunded_amt,
                COALESCE(SUM(rs.total_item_discounts), 0) AS total_item_discounts,
                COALESCE(SUM(rs.credits), 0) AS totalCredits,
                COALESCE(SUM(rs.discountsTender), 0) AS totalDiscountsTender,
                COALESCE(SUM(rs.cartRateRefund), 0) AS cartRateRefundTotal,
                COALESCE(SUM(rs.refundCart), 0) AS cartRefundTotal,
           
                
                CAST(COALESCE(SUM(res.return_amt), 0)AS DECIMAL(10,2)) AS return_amt,
                COALESCE(SUM(res. total_return_item_discounts), 0) AS total_return_item_discounts,
                COALESCE(SUM(res.rc_credits), 0) AS totalReturnCredits,
                COALESCE(SUM(res.discountsReturnTender), 0) AS totalDiscountsReturnTender,
                COALESCE(SUM(res.cartRateReturn), 0) AS cartRateReturnTotal,
                COALESCE(SUM(res.returnCart), 0) AS cartReturnTotal
              
               
                
            FROM 
                payments AS p 
                INNER JOIN (SELECT payment_id,user_id,prod_id,is_paid,is_void FROM transactions
                GROUP BY payment_id) as t ON t.payment_id = p.id
                INNER JOIN users AS u ON u.id = t.user_id
                INNER JOIN discounts AS d ON d.id = u.discount_id
                INNER JOIN products AS ps ON ps.id = t.prod_id
                LEFT JOIN RefundSums rs ON rs.payment_id = p.id
                LEFT JOIN ReturnExchangeSums res ON res.payment_id = p.id
            WHERE 
                t.is_paid = 1 
                AND t.is_void = 0 AND DATE(p.date_time_of_payment) = :singleDateData AND u.id = :customerId
            GROUP BY 
                u.id;";

            $sql = $this->connect()->prepare( $sqlQuery );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->bindParam( ':customerId', $customerId );
            $sql->execute();
            return $sql;
        } else if ( $customerId && !$singleDateData && $startDate && $endDate ) {
            $sqlQuery = "WITH RefundSums AS (
              SELECT 
    payment_id,
    SUM(credits) AS credits,
    cartRateRefund AS cartRateRefund,
    SUM(discountsTender) AS discountsTender,
    SUM(refunded_amt) AS refunded_amt,
    SUM(total_item_discounts) AS total_item_discounts,
    SUM(refundCart) AS refundCart
FROM (
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
        CAST(SUM(COALESCE(r.refunded_amt, 0) * COALESCE(
            CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
            0
        )) AS DECIMAL(10,2)) AS refundCart
    FROM 
        refunded r
    GROUP BY 
        r.reference_num
) subquery
GROUP BY 
    payment_id
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
                 CAST(SUM(COALESCE(rc.return_amount, 0) * COALESCE(
                CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].cartRate')) AS DECIMAL(20,4)),
                0
            ))AS DECIMAL(10,2)) AS returnCart
                FROM 
                    return_exchange  rc
                GROUP BY 
                    rc.payment_id
            )
            SELECT
            DISTINCT
                u.first_name AS first_name,
                u.last_name AS last_name, 
                CAST(COALESCE(SUM(p.payment_amount), 0)AS DECIMAL(10,2)) AS paid_amount,
                CAST(COALESCE(SUM(p.change_amount), 0)AS DECIMAL(10,2)) AS totalChange,
                p.date_time_of_payment AS date,
                p.cart_discount AS cart_discount,
                d.discount_amount AS discountsRate,
                CAST(COALESCE(SUM(rs.refunded_amt), 0)AS DECIMAL(10,2)) AS refunded_amt,
                COALESCE(SUM(rs.total_item_discounts), 0) AS total_item_discounts,
                COALESCE(SUM(rs.credits), 0) AS totalCredits,
                COALESCE(SUM(rs.discountsTender), 0) AS totalDiscountsTender,
                COALESCE(SUM(rs.cartRateRefund), 0) AS cartRateRefundTotal,
                COALESCE(SUM(rs.refundCart), 0) AS cartRefundTotal,
           
                
                CAST(COALESCE(SUM(res.return_amt), 0)AS DECIMAL(10,2)) AS return_amt,
                COALESCE(SUM(res. total_return_item_discounts), 0) AS total_return_item_discounts,
                COALESCE(SUM(res.rc_credits), 0) AS totalReturnCredits,
                COALESCE(SUM(res.discountsReturnTender), 0) AS totalDiscountsReturnTender,
                COALESCE(SUM(res.cartRateReturn), 0) AS cartRateReturnTotal,
                COALESCE(SUM(res.returnCart), 0) AS cartReturnTotal
              
               
                
            FROM 
                payments AS p 
                INNER JOIN (SELECT payment_id,user_id,prod_id,is_paid,is_void FROM transactions
                GROUP BY payment_id) as t ON t.payment_id = p.id
                INNER JOIN users AS u ON u.id = t.user_id
                INNER JOIN discounts AS d ON d.id = u.discount_id
                INNER JOIN products AS ps ON ps.id = t.prod_id
                LEFT JOIN RefundSums rs ON rs.payment_id = p.id
                LEFT JOIN ReturnExchangeSums res ON res.payment_id = p.id
            WHERE 
                t.is_paid = 1 
                AND t.is_void = 0 AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate AND u.id = :customerId
            GROUP BY 
                u.id";

            $sql = $this->connect()->prepare( $sqlQuery );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->bindParam( ':customerId', $customerId );
            $sql->execute();
            return $sql;
        } else {
            $sql = "WITH RefundSums AS (
                 SELECT 
    payment_id,
    SUM(credits) AS credits,
    cartRateRefund AS cartRateRefund,
    SUM(discountsTender) AS discountsTender,
    SUM(refunded_amt) AS refunded_amt,
    SUM(total_item_discounts) AS total_item_discounts,
    SUM(refundCart) AS refundCart
FROM (
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
        CAST(SUM(COALESCE(r.refunded_amt, 0) * COALESCE(
            CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
            0
        )) AS DECIMAL(10,2)) AS refundCart
    FROM 
        refunded r
    GROUP BY 
        r.reference_num
) subquery
GROUP BY 
    payment_id
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
                 CAST(SUM(COALESCE(rc.return_amount, 0) * COALESCE(
                CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
                0
            ))AS DECIMAL(10,2)) AS returnCart
                FROM 
                    return_exchange  rc
                GROUP BY 
                    rc.payment_id
            )
            SELECT
            DISTINCT
                u.first_name AS first_name,
                u.last_name AS last_name, 
                CAST(COALESCE(SUM(p.payment_amount), 0)AS DECIMAL(10,2)) AS paid_amount,
                CAST(COALESCE(SUM(p.change_amount), 0)AS DECIMAL(10,2)) AS totalChange,
                p.date_time_of_payment AS date,
                p.cart_discount AS cart_discount,
                d.discount_amount AS discountsRate,
                CAST(COALESCE(SUM(rs.refunded_amt), 0)AS DECIMAL(10,2)) AS refunded_amt,
                COALESCE(SUM(rs.total_item_discounts), 0) AS total_item_discounts,
                COALESCE(SUM(rs.credits), 0) AS totalCredits,
                COALESCE(SUM(rs.discountsTender), 0) AS totalDiscountsTender,
                COALESCE(SUM(rs.cartRateRefund), 0) AS cartRateRefundTotal,
                COALESCE(SUM(rs.refundCart), 0) AS cartRefundTotal,
           
                
                CAST(COALESCE(SUM(res.return_amt), 0)AS DECIMAL(10,2)) AS return_amt,
                COALESCE(SUM(res. total_return_item_discounts), 0) AS total_return_item_discounts,
                COALESCE(SUM(res.rc_credits), 0) AS totalReturnCredits,
                COALESCE(SUM(res.discountsReturnTender), 0) AS totalDiscountsReturnTender,
                COALESCE(SUM(res.cartRateReturn), 0) AS cartRateReturnTotal,
                COALESCE(SUM(res.returnCart), 0) AS cartReturnTotal
              
               
                
            FROM 
                payments AS p 
                INNER JOIN (SELECT payment_id,user_id,prod_id,is_paid,is_void FROM transactions
                GROUP BY payment_id) as t ON t.payment_id = p.id
                INNER JOIN users AS u ON u.id = t.user_id
                INNER JOIN discounts AS d ON d.id = u.discount_id
                INNER JOIN products AS ps ON ps.id = t.prod_id
                LEFT JOIN RefundSums rs ON rs.payment_id = p.id
                LEFT JOIN ReturnExchangeSums res ON res.payment_id = p.id
            WHERE 
                t.is_paid = 1 
                AND t.is_void = 0 
            GROUP BY 
                u.id";
            $stmt = $this->connect()->query( $sql );
            return $stmt;

        }
    }

    public function userSales( $selectedUser, $singleDateData, $startDate, $endDate ) {
        if ( $selectedUser && !$singleDateData && !$startDate && !$endDate ) {
            $sqlQuery = "WITH RefundSums AS (
             SELECT 
    payment_id,
    SUM(credits) AS credits,
    cartRateRefund AS cartRateRefund,
    SUM(discountsTender) AS discountsTender,
    SUM(refunded_amt) AS refunded_amt,
    SUM(total_item_discounts) AS total_item_discounts,
    SUM(refundCart) AS refundCart
FROM (
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
        CAST(SUM(COALESCE(r.refunded_amt, 0) * COALESCE(
            CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
            0
        )) AS DECIMAL(10,2)) AS refundCart
    FROM 
        refunded r
    GROUP BY 
        r.reference_num
) subquery
GROUP BY 
    payment_id
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
             CAST(SUM(COALESCE(rc.return_amount, 0) * COALESCE(
            CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
            0
        ))AS DECIMAL(10,2)) AS returnCart,
           CAST(SUM(COALESCE(rc.return_amount, 0)) - 
        COALESCE(
            CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].credits')) AS DECIMAL(10, 2)),
            0
        )-  COALESCE(
                        CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].discount')) AS DECIMAL(10, 2)),
                        0
                    ) - CAST(SUM(COALESCE(rc.return_amount, 0) * COALESCE(
            CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
            0
        ))AS DECIMAL(10,2))AS DECIMAL(10,2)) AS otherReturnPayments 
          
            FROM 
                return_exchange  rc
            GROUP BY 
                rc.payment_id
        )
        SELECT
        DISTINCT
            u.first_name AS first_name,
            u.last_name AS last_name, 
            CAST(COALESCE(SUM(p.payment_amount), 0)AS DECIMAL(10,2)) AS paid_amount,
            CAST(COALESCE(SUM(p.change_amount), 0)AS DECIMAL(10,2)) AS totalChange,
            p.date_time_of_payment AS date,
            p.cart_discount AS cart_discount,
            COALESCE(SUM(rs.refunded_amt), 0) AS refunded_amt,
            COALESCE(SUM(rs.total_item_discounts), 0) AS total_item_discounts,
            COALESCE(SUM(rs.credits), 0) AS totalCredits,
            COALESCE(SUM(rs.discountsTender), 0) AS totalDiscountsTender,
            COALESCE(SUM(rs.cartRateRefund), 0) AS cartRateRefundTotal,
            COALESCE(SUM(rs.refundCart), 0) AS cartRefundTotal,
            
            
            COALESCE(SUM(res.return_amt), 0) AS return_amt,
            COALESCE(SUM(res.total_return_item_discounts), 0) AS total_return_item_discounts,
            COALESCE(SUM(res.rc_credits), 0) AS totalReturnCredits,
            COALESCE(SUM(res.discountsReturnTender), 0) AS totalDiscountsReturnTender,
            COALESCE(SUM(res.cartRateReturn), 0) AS cartRateReturnTotal,
            COALESCE(SUM(res.returnCart), 0) AS cartReturnTotal
          
           
            
        FROM 
            payments AS p 
            INNER JOIN (SELECT payment_id,user_id,prod_id,is_paid,is_void,cashier_id FROM transactions
                 GROUP BY payment_id) as t ON t.payment_id = p.id
            INNER JOIN users AS u ON u.id = t.cashier_id
            INNER JOIN products AS ps ON ps.id = t.prod_id
            LEFT JOIN RefundSums rs ON rs.payment_id = p.id
            LEFT JOIN ReturnExchangeSums res ON res.payment_id = p.id
        WHERE 
            t.is_paid = 1 
            AND t.is_void = 0  AND u.id = :selectedUser
        GROUP BY 
            u.id;";

            $sql = $this->connect()->prepare( $sqlQuery );
            $sql->bindParam( ':selectedUser', $selectedUser );
            $sql->execute();
            return $sql;
        } else if ( !$selectedUser && $singleDateData && !$startDate && !$endDate ) {
            $sqlQuery = "WITH RefundSums AS (
                 SELECT 
    payment_id,
    SUM(credits) AS credits,
    cartRateRefund AS cartRateRefund,
    SUM(discountsTender) AS discountsTender,
    SUM(refunded_amt) AS refunded_amt,
    SUM(total_item_discounts) AS total_item_discounts,
    SUM(refundCart) AS refundCart
FROM (
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
        CAST(SUM(COALESCE(r.refunded_amt, 0) * COALESCE(
            CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
            0
        )) AS DECIMAL(10,2)) AS refundCart
    FROM 
        refunded r
    GROUP BY 
        r.reference_num
) subquery
GROUP BY 
    payment_id
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
                 CAST(SUM(COALESCE(rc.return_amount, 0) * COALESCE(
                CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
                0
            ))AS DECIMAL(10,2)) AS returnCart,
               CAST(SUM(COALESCE(rc.return_amount, 0)) - 
            COALESCE(
                CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].credits')) AS DECIMAL(10, 2)),
                0
            )-  COALESCE(
                            CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].discount')) AS DECIMAL(10, 2)),
                            0
                        ) - CAST(SUM(COALESCE(rc.return_amount, 0) * COALESCE(
                CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
                0
            ))AS DECIMAL(10,2))AS DECIMAL(10,2)) AS otherReturnPayments 
              
                FROM 
                    return_exchange  rc
                GROUP BY 
                    rc.payment_id
            )
            SELECT
            DISTINCT
                u.first_name AS first_name,
                u.last_name AS last_name, 
                CAST(COALESCE(SUM(p.payment_amount), 0)AS DECIMAL(10,2)) AS paid_amount,
                CAST(COALESCE(SUM(p.change_amount), 0)AS DECIMAL(10,2)) AS totalChange,
                p.date_time_of_payment AS date,
                p.cart_discount AS cart_discount,
                COALESCE(SUM(rs.refunded_amt), 0) AS refunded_amt,
                COALESCE(SUM(rs.total_item_discounts), 0) AS total_item_discounts,
                COALESCE(SUM(rs.credits), 0) AS totalCredits,
                COALESCE(SUM(rs.discountsTender), 0) AS totalDiscountsTender,
                COALESCE(SUM(rs.cartRateRefund), 0) AS cartRateRefundTotal,
                COALESCE(SUM(rs.refundCart), 0) AS cartRefundTotal,
   
                
                COALESCE(SUM(res.return_amt), 0) AS return_amt,
                COALESCE(SUM(res. total_return_item_discounts), 0) AS total_return_item_discounts,
                COALESCE(SUM(res.rc_credits), 0) AS totalReturnCredits,
                COALESCE(SUM(res.discountsReturnTender), 0) AS totalDiscountsReturnTender,
                COALESCE(SUM(res.cartRateReturn), 0) AS cartRateReturnTotal,
                COALESCE(SUM(res.returnCart), 0) AS cartReturnTotal
             
               
                
            FROM 
                payments AS p 
                INNER JOIN (SELECT payment_id,user_id,prod_id,is_paid,is_void,cashier_id FROM transactions
                GROUP BY payment_id) as t ON t.payment_id = p.id
                INNER JOIN users AS u ON u.id = t.cashier_id
                INNER JOIN products AS ps ON ps.id = t.prod_id
                LEFT JOIN RefundSums rs ON rs.payment_id = p.id
                LEFT JOIN ReturnExchangeSums res ON res.payment_id = p.id
            WHERE 
                t.is_paid = 1 
                AND t.is_void = 0 AND DATE(p.date_time_of_payment) = :singleDateData
            GROUP BY 
                u.id;";

            $sql = $this->connect()->prepare( $sqlQuery );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->execute();
            return $sql;
        } else if ( !$selectedUser && !$singleDateData && $startDate && $endDate ) {
            $sqlQuery = "WITH RefundSums AS (
                SELECT 
    payment_id,
    SUM(credits) AS credits,
    cartRateRefund AS cartRateRefund,
    SUM(discountsTender) AS discountsTender,
    SUM(refunded_amt) AS refunded_amt,
    SUM(total_item_discounts) AS total_item_discounts,
    SUM(refundCart) AS refundCart
FROM (
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
        CAST(SUM(COALESCE(r.refunded_amt, 0) * COALESCE(
            CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
            0
        )) AS DECIMAL(10,2)) AS refundCart
    FROM 
        refunded r
    GROUP BY 
        r.reference_num
) subquery
GROUP BY 
    payment_id
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
              CAST(SUM(COALESCE(rc.return_amount, 0) * COALESCE(
                CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
                0
            ))AS DECIMAL(10,2)) AS returnCart,
           CAST(SUM(COALESCE(rc.return_amount, 0)) - 
            COALESCE(
                CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].credits')) AS DECIMAL(10, 2)),
                0
            )-  COALESCE(
                            CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].discount')) AS DECIMAL(10, 2)),
                            0
                        ) - CAST(SUM(COALESCE(rc.return_amount, 0) * COALESCE(
                CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
                0
            ))AS DECIMAL(10,2))AS DECIMAL(10,2)) AS otherReturnPayments 
              
                FROM 
                    return_exchange  rc
                GROUP BY 
                    rc.payment_id
            )
            SELECT
            DISTINCT
                u.first_name AS first_name,
                u.last_name AS last_name, 
                CAST(COALESCE(SUM(p.payment_amount), 0)AS DECIMAL(10,2)) AS paid_amount,
                CAST(COALESCE(SUM(p.change_amount), 0)AS DECIMAL(10,2)) AS totalChange,
                p.date_time_of_payment AS date,
                p.cart_discount AS cart_discount,
                COALESCE(SUM(rs.refunded_amt), 0) AS refunded_amt,
                COALESCE(SUM(rs.total_item_discounts), 0) AS total_item_discounts,
                COALESCE(SUM(rs.credits), 0) AS totalCredits,
                COALESCE(SUM(rs.discountsTender), 0) AS totalDiscountsTender,
                COALESCE(SUM(rs.cartRateRefund), 0) AS cartRateRefundTotal,
                COALESCE(SUM(rs.refundCart), 0) AS cartRefundTotal,
   
                
                COALESCE(SUM(res.return_amt), 0) AS return_amt,
                COALESCE(SUM(res. total_return_item_discounts), 0) AS total_return_item_discounts,
                COALESCE(SUM(res.rc_credits), 0) AS totalReturnCredits,
                COALESCE(SUM(res.discountsReturnTender), 0) AS totalDiscountsReturnTender,
                COALESCE(SUM(res.cartRateReturn), 0) AS cartRateReturnTotal,
                COALESCE(SUM(res.returnCart), 0) AS cartReturnTotal
             
             
               
                
            FROM 
                payments AS p 
                INNER JOIN (SELECT payment_id,user_id,prod_id,is_paid,is_void,cashier_id FROM transactions
                GROUP BY payment_id) as t ON t.payment_id = p.id
                INNER JOIN users AS u ON u.id = t.cashier_id
                INNER JOIN products AS ps ON ps.id = t.prod_id
                LEFT JOIN RefundSums rs ON rs.payment_id = p.id
                LEFT JOIN ReturnExchangeSums res ON res.payment_id = p.id
            WHERE 
                t.is_paid = 1 
                AND t.is_void = 0 AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate
            GROUP BY 
                u.id;";

            $sql = $this->connect()->prepare( $sqlQuery );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->execute();
            return $sql;
        } else if ( $selectedUser && $singleDateData && !$startDate && !$endDate ) {
            $sqlQuery = "WITH RefundSums AS (
                SELECT 
    payment_id,
    SUM(credits) AS credits,
    cartRateRefund AS cartRateRefund,
    SUM(discountsTender) AS discountsTender,
    SUM(refunded_amt) AS refunded_amt,
    SUM(total_item_discounts) AS total_item_discounts,
    SUM(refundCart) AS refundCart
FROM (
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
        CAST(SUM(COALESCE(r.refunded_amt, 0) * COALESCE(
            CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
            0
        )) AS DECIMAL(10,2)) AS refundCart
    FROM 
        refunded r
    GROUP BY 
        r.reference_num
) subquery
GROUP BY 
    payment_id
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
            CAST(SUM(COALESCE(rc.return_amount, 0) * COALESCE(
                CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
                0
            ))AS DECIMAL(10,2)) AS returnCart,
             CAST(SUM(COALESCE(rc.return_amount, 0)) - 
            COALESCE(
                CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].credits')) AS DECIMAL(10, 2)),
                0
            )-  COALESCE(
                            CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].discount')) AS DECIMAL(10, 2)),
                            0
                        ) - CAST(SUM(COALESCE(rc.return_amount, 0) * COALESCE(
                CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
                0
            ))AS DECIMAL(10,2))AS DECIMAL(10,2)) AS otherReturnPayments 
              
                FROM 
                    return_exchange  rc
                GROUP BY 
                    rc.payment_id
            )
            SELECT
            DISTINCT
                 u.first_name AS first_name,
                u.last_name AS last_name, 
                CAST(COALESCE(SUM(p.payment_amount), 0)AS DECIMAL(10,2)) AS paid_amount,
                CAST(COALESCE(SUM(p.change_amount), 0)AS DECIMAL(10,2)) AS totalChange,
                p.date_time_of_payment AS date,
                p.cart_discount AS cart_discount,
                COALESCE(SUM(rs.refunded_amt), 0) AS refunded_amt,
                COALESCE(SUM(rs.total_item_discounts), 0) AS total_item_discounts,
                COALESCE(SUM(rs.credits), 0) AS totalCredits,
                COALESCE(SUM(rs.discountsTender), 0) AS totalDiscountsTender,
                COALESCE(SUM(rs.cartRateRefund), 0) AS cartRateRefundTotal,
                COALESCE(SUM(rs.refundCart), 0) AS cartRefundTotal,
   
                
                COALESCE(SUM(res.return_amt), 0) AS return_amt,
                COALESCE(SUM(res. total_return_item_discounts), 0) AS total_return_item_discounts,
                COALESCE(SUM(res.rc_credits), 0) AS totalReturnCredits,
                COALESCE(SUM(res.discountsReturnTender), 0) AS totalDiscountsReturnTender,
                COALESCE(SUM(res.cartRateReturn), 0) AS cartRateReturnTotal,
                COALESCE(SUM(res.returnCart), 0) AS cartReturnTotal
             
           
            FROM 
                payments AS p 
                INNER JOIN (SELECT payment_id,user_id,prod_id,is_paid,is_void,cashier_id FROM transactions
                    GROUP BY payment_id) as t ON t.payment_id = p.id
                INNER JOIN users AS u ON u.id = t.cashier_id
                INNER JOIN products AS ps ON ps.id = t.prod_id
                LEFT JOIN RefundSums rs ON rs.payment_id = p.id
                LEFT JOIN ReturnExchangeSums res ON res.payment_id = p.id
            WHERE 
                t.is_paid = 1 
                AND t.is_void = 0 AND DATE(p.date_time_of_payment) = :singleDateData AND u.id = :selectedUser
            GROUP BY 
                u.id;";

            $sql = $this->connect()->prepare( $sqlQuery );
            $sql->bindParam( ':singleDateData', $singleDateData );
            $sql->bindParam( ':selectedUser', $selectedUser );
            $sql->execute();
            return $sql;
        } else if ($selectedUser  && !$singleDateData && $startDate && $endDate ) {
            $sqlQuery = "WITH RefundSums AS (
                 SELECT 
    payment_id,
    SUM(credits) AS credits,
    cartRateRefund AS cartRateRefund,
    SUM(discountsTender) AS discountsTender,
    SUM(refunded_amt) AS refunded_amt,
    SUM(total_item_discounts) AS total_item_discounts,
    SUM(refundCart) AS refundCart
FROM (
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
        CAST(SUM(COALESCE(r.refunded_amt, 0) * COALESCE(
            CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
            0
        )) AS DECIMAL(10,2)) AS refundCart
    FROM 
        refunded r
    GROUP BY 
        r.reference_num
) subquery
GROUP BY 
    payment_id
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
          CAST(SUM(COALESCE(rc.return_amount, 0) * COALESCE(
                CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 20)),
                0
            ))AS DECIMAL(10,2)) AS returnCart,
               CAST(SUM(COALESCE(rc.return_amount, 0)) - 
            COALESCE(
                CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].credits')) AS DECIMAL(10, 2)),
                0
            )-  COALESCE(
                            CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].discount')) AS DECIMAL(10, 2)),
                            0
                        ) - CAST(SUM(COALESCE(rc.return_amount, 0) * COALESCE(
                CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
                0
            ))AS DECIMAL(10,2))AS DECIMAL(10,2)) AS otherReturnPayments  
              
                FROM 
                    return_exchange  rc
                GROUP BY 
                    rc.payment_id
            )
            SELECT
            DISTINCT
                u.first_name AS first_name,
                u.last_name AS last_name, 
                CAST(COALESCE(SUM(p.payment_amount), 0)AS DECIMAL(10,2)) AS paid_amount,
                CAST(COALESCE(SUM(p.change_amount), 0)AS DECIMAL(10,2)) AS totalChange,
                p.date_time_of_payment AS date,
                p.cart_discount AS cart_discount,
                COALESCE(SUM(rs.refunded_amt), 0) AS refunded_amt,
                COALESCE(SUM(rs.total_item_discounts), 0) AS total_item_discounts,
                COALESCE(SUM(rs.credits), 0) AS totalCredits,
                COALESCE(SUM(rs.discountsTender), 0) AS totalDiscountsTender,
                COALESCE(SUM(rs.cartRateRefund), 0) AS cartRateRefundTotal,
                COALESCE(SUM(rs.refundCart), 0) AS cartRefundTotal,
   
                
                COALESCE(SUM(res.return_amt), 0) AS return_amt,
                COALESCE(SUM(res.total_return_item_discounts), 0) AS total_return_item_discounts,
                COALESCE(SUM(res.rc_credits), 0) AS totalReturnCredits,
                COALESCE(SUM(res.discountsReturnTender), 0) AS totalDiscountsReturnTender,
                COALESCE(SUM(res.cartRateReturn), 0) AS cartRateReturnTotal,
                COALESCE(SUM(res.returnCart), 0) AS cartReturnTotal
             
               
                
            FROM 
                payments AS p 
                INNER JOIN (SELECT payment_id,user_id,prod_id,is_paid,is_void,cashier_id FROM transactions
                    GROUP BY payment_id) as t ON t.payment_id = p.id
                INNER JOIN users AS u ON u.id = t.cashier_id
                INNER JOIN products AS ps ON ps.id = t.prod_id
                LEFT JOIN RefundSums rs ON rs.payment_id = p.id
                LEFT JOIN ReturnExchangeSums res ON res.payment_id = p.id
            WHERE 
                t.is_paid = 1 
                AND t.is_void = 0 AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate AND u.id = :selectedUser
            GROUP BY 
                u.id;";

            $sql = $this->connect()->prepare( $sqlQuery );
            $sql->bindParam( ':startDate', $startDate );
            $sql->bindParam( ':endDate', $endDate );
            $sql->bindParam( ':selectedUser', $selectedUser );
            $sql->execute();
            return $sql;

        } else {
            $sql = "WITH RefundSums AS (
             SELECT 
    payment_id,
    SUM(credits) AS credits,
    cartRateRefund AS cartRateRefund,
    SUM(discountsTender) AS discountsTender,
    SUM(refunded_amt) AS refunded_amt,
    SUM(total_item_discounts) AS total_item_discounts,
    SUM(refundCart) AS refundCart
FROM (
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
        CAST(SUM(COALESCE(r.refunded_amt, 0) * COALESCE(
            CAST(JSON_UNQUOTE(JSON_EXTRACT(r.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
            0
        )) AS DECIMAL(10,2)) AS refundCart
    FROM 
        refunded r
    GROUP BY 
        r.reference_num
) subquery
GROUP BY 
    payment_id
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
             CAST(SUM(COALESCE(rc.return_amount, 0) * COALESCE(
            CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 20)),
            0
        )) AS DECIMAL(10,2)) AS returnCart,
           CAST(SUM(COALESCE(rc.return_amount, 0)) - 
        COALESCE(
            CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].credits')) AS DECIMAL(10, 2)),
            0
        )-  COALESCE(
                        CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].discount')) AS DECIMAL(10, 2)),
                        0
                    ) - CAST(SUM(COALESCE(rc.return_amount, 0) * COALESCE(
            CAST(JSON_UNQUOTE(JSON_EXTRACT(rc.otherDetails, '$[0].cartRate')) AS DECIMAL(20, 4)),
            0
        )) AS DECIMAL(10,2))AS DECIMAL(10,2)) AS otherReturnPayments 
          
            FROM 
                return_exchange  rc
            GROUP BY 
                rc.payment_id
               
        ), RefundItemData AS (
            SELECT 
                rd.payment_id,
                SUM( 
                    COALESCE(
                        CAST(JSON_UNQUOTE(JSON_EXTRACT( rd.otherDetails, '$[0].itemDiscountsData')) AS DECIMAL(10, 2)),
                        0
                    )
                ) AS total_item_discounts
   
            FROM 
                refunded rd
        ),
         ReturnItemData AS (
            SELECT 
                re.payment_id,
                SUM( 
                    COALESCE(
                        CAST(JSON_UNQUOTE(JSON_EXTRACT( re.otherDetails, '$[0].itemDiscountsData')) AS DECIMAL(10, 2)),
                        0
                    )
                ) AS total_return_item_discounts
   
            FROM 
                return_exchange re
        )
        SELECT
        DISTINCT
            u.first_name AS first_name,
            u.last_name AS last_name, 
            CAST(COALESCE(SUM( p.payment_amount), 0) AS DECIMAL(10,2)) AS paid_amount,
            CAST(COALESCE(SUM( p.change_amount), 0) AS DECIMAL(10,2)) AS totalChange,
            p.date_time_of_payment AS date,
            p.cart_discount AS cart_discount,
            COALESCE(SUM(rs.refunded_amt), 0) AS refunded_amt,
            COALESCE(SUM(rs.total_item_discounts), 0) AS total_item_discounts,
            COALESCE(SUM(rs.credits), 0) AS totalCredits,
            COALESCE(SUM(rs.discountsTender), 0) AS totalDiscountsTender,
            COALESCE(SUM(rs.cartRateRefund), 0) AS cartRateRefundTotal,
            COALESCE(SUM(rs.refundCart), 0) AS cartRefundTotal,
       
            
            COALESCE(SUM(res.return_amt), 0) AS return_amt,
            COALESCE(SUM(re.total_return_item_discounts), 0) AS total_return_item_discounts,
            COALESCE(SUM(res.rc_credits), 0) AS totalReturnCredits,
            COALESCE(SUM(res.discountsReturnTender), 0) AS totalDiscountsReturnTender,
            COALESCE(SUM(res.cartRateReturn), 0) AS cartRateReturnTotal,
            COALESCE(SUM(res.returnCart), 0) AS cartReturnTotal

           
            
        FROM 
            payments AS p 
            INNER JOIN (SELECT payment_id,user_id,prod_id,is_paid,is_void,cashier_id FROM transactions
                    GROUP BY payment_id) as t ON t.payment_id = p.id
            INNER JOIN users AS u ON u.id = t.cashier_id
            INNER JOIN products AS ps ON ps.id = t.prod_id
            LEFT JOIN RefundSums rs ON rs.payment_id = p.id
            LEFT JOIN ReturnExchangeSums res ON res.payment_id = p.id
            LEFT JOIN RefundItemData rd ON rd.payment_id = p.id
            LEFT JOIN ReturnItemData re ON re.payment_id = p.id
        WHERE 
            t.is_paid = 1 
            AND t.is_void = 0 
        GROUP BY 
            u.id;";

            $stmt = $this->connect()->query( $sql );
            return $stmt;
        }
    }
public function getDateRefunded(){
    $sql = "SELECT DATE(date) as date FROM refunded ORDER BY date ASC";
        $stmt = $this->connect()->query( $sql );
        return $stmt;
}
public function getDateReturned(){
    $sql = "SELECT DATE(date) as date FROM return_exchange ORDER BY date ASC";
        $stmt = $this->connect()->query( $sql );
        return $stmt;
}


}
