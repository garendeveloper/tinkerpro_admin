<?php

  class OtherReportsFacade extends DBConnection {

   public function getRefundData($selectedProduct,$singleDateData,$startDate,$endDate ){

      if($selectedProduct && !$singleDateData && !$startDate && !$endDate){
        $sql = 'SELECT r.id  AS refunded_id,r.refunded_method_id as method, p.id AS payment_id, products.prod_desc AS prod_desc,rc.qrNumber as qrNumber,
        r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, products.barcode as barcode,products.sku as sku,
        r.date AS date, r.refunded_method_id AS method, t.receipt_id
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

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedProduct', $selectedProduct);
        $sql->execute();
        return $sql;

      }else if(!$selectedProduct && $singleDateData && !$startDate && !$endDate){
        $sql = 'SELECT r.id  AS refunded_id,r.refunded_method_id as method, p.id AS payment_id, products.prod_desc AS prod_desc,rc.qrNumber as qrNumber,
        r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, products.barcode as barcode,products.sku as sku,
        r.date AS date, r.refunded_method_id AS method, t.receipt_id
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

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':singleDateData', $singleDateData);
        $sql->execute();
        return $sql;

      }else if(!$selectedProduct && !$singleDateData && $startDate && $endDate){
        $sql = 'SELECT r.id  AS refunded_id,r.refunded_method_id as method, p.id AS payment_id, products.prod_desc AS prod_desc,rc.qrNumber as qrNumber,
        r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, products.barcode as barcode,products.sku as sku,
        r.date AS date, r.refunded_method_id AS method, t.receipt_id
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

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':startDate', $startDate);
        $sql->bindParam(':endDate', $endDate);
        $sql->execute();
        return $sql;
      }else if($selectedProduct && $singleDateData && !$startDate && !$endDate){
        $sql = 'SELECT r.id  AS refunded_id,r.refunded_method_id as method, p.id AS payment_id, products.prod_desc AS prod_desc,rc.qrNumber as qrNumber,
            r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, products.barcode as barcode,products.sku as sku,
            r.date AS date, r.refunded_method_id AS method, t.receipt_id
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

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedProduct', $selectedProduct);
        $sql->bindParam(':singleDateData', $singleDateData);
        $sql->execute();
        return $sql;

      }else if($selectedProduct && !$singleDateData && $startDate && $endDate){
        $sql = 'SELECT r.id  AS refunded_id,r.refunded_method_id as method, p.id AS payment_id, products.prod_desc AS prod_desc,rc.qrNumber as qrNumber,
        r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, products.barcode as barcode,products.sku as sku,
        r.date AS date, r.refunded_method_id AS method, t.receipt_id
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

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedProduct', $selectedProduct);
        $sql->bindParam(':startDate', $startDate);
        $sql->bindParam(':endDate', $endDate);
        $sql->execute();
        return $sql;
      }else{
        $sql = 'SELECT r.id  AS refunded_id,r.refunded_method_id as method, p.id AS payment_id, products.prod_desc AS prod_desc,rc.qrNumber as qrNumber,
        r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, products.barcode as barcode,products.sku as sku,
        r.date AS date, r.refunded_method_id AS method, t.receipt_id
    FROM refunded AS r
    INNER JOIN payments AS p ON r.payment_id = p.id 
    INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id
        FROM transactions
    ) AS t ON t.payment_id = p.id
    INNER JOIN receipt AS rt ON rt.id = t.receipt_id
    LEFT JOIN return_coupon as rc ON rc.receipt_id = rt.id
    INNER JOIN products ON r.prod_id = products.id;';
        $stmt = $this->connect()->query($sql);
        return $stmt;
      }
   } 

   public function getRefundByCustomers($selectedCustomers,$singleDateData,$startDate,$endDate,$selectedRefundTypes){
    if($selectedCustomers && !$singleDateData && !$startDate && !$endDate && !$selectedRefundTypes){
          $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id, r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
          INNER JOIN payments AS p ON r.payment_id = p.id 
          INNER JOIN products ON r.prod_id = products.id 
          INNER JOIN transactions AS t ON t.payment_id = p.id 
          INNER JOIN users AS u ON t.user_id = u.id WHERE t.user_id = :selectedCustomers';


          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':selectedCustomers', $selectedCustomers);
          $sql->execute();
          return $sql;

      }else if(!$selectedCustomers && $singleDateData && !$startDate && !$endDate  && !$selectedRefundTypes){
        $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id, r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        INNER JOIN transactions AS t ON t.payment_id = p.id 
        INNER JOIN users AS u ON t.user_id = u.id WHERE DATE(r.date) = :singleDateData';


        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':singleDateData', $singleDateData);
        $sql->execute();
        return $sql;
      }else if(!$selectedCustomers && !$singleDateData && $startDate && $endDate  && !$selectedRefundTypes){
        $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id, r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        INNER JOIN transactions AS t ON t.payment_id = p.id 
        INNER JOIN users AS u ON t.user_id = u.id WHERE DATE(r.date) BETWEEN :startDate AND :endDate';


        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':startDate', $startDate);
        $sql->bindParam(':endDate', $endDate);
        $sql->execute();
        return $sql;
      }else if($selectedCustomers && $singleDateData && !$startDate && !$endDate  && !$selectedRefundTypes){
        $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id,  r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        INNER JOIN transactions AS t ON t.payment_id = p.id 
        INNER JOIN users AS u ON t.user_id = u.id WHERE t.user_id = :selectedCustomers AND DATE(r.date) = :singleDateData';


        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':singleDateData', $singleDateData);
        $sql->bindParam(':selectedCustomers', $selectedCustomers);
        $sql->execute();
        return $sql;
      }else if($selectedCustomers && !$singleDateData && $startDate && $endDate  && !$selectedRefundTypes){
        $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id,  r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        INNER JOIN transactions AS t ON t.payment_id = p.id 
        INNER JOIN users AS u ON t.user_id = u.id WHERE t.user_id = :selectedCustomers AND DATE(r.date) BETWEEN :startDate AND :endDate';


        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedCustomers', $selectedCustomers);
        $sql->bindParam(':startDate', $startDate);
        $sql->bindParam(':endDate', $endDate);
        $sql->execute();
        return $sql;
      }else if(!$selectedCustomers && !$singleDateData && !$startDate && !$endDate  && $selectedRefundTypes){
        $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id,  r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        INNER JOIN transactions AS t ON t.payment_id = p.id 
        INNER JOIN users AS u ON t.user_id = u.id WHERE r.refunded_method_id = :selectedRefundTypes';


        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedRefundTypes',  $selectedRefundTypes);
        $sql->execute();
        return $sql;
      }else if($selectedCustomers && !$singleDateData && !$startDate && !$endDate  && $selectedRefundTypes){
        $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id,  r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        INNER JOIN transactions AS t ON t.payment_id = p.id 
        INNER JOIN users AS u ON t.user_id = u.id WHERE t.user_id = :selectedCustomers AND r.refunded_method_id = :selectedRefundTypes';


        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedRefundTypes',  $selectedRefundTypes);
        $sql->bindParam(':selectedCustomers', $selectedCustomers);
        $sql->execute();
        return $sql;
      }else if (!$selectedCustomers && $singleDateData && !$startDate && !$endDate  && $selectedRefundTypes){
        $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id,  r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        INNER JOIN transactions AS t ON t.payment_id = p.id 
        INNER JOIN users AS u ON t.user_id = u.id WHERE DATE(r.date) = :singleDateData AND r.refunded_method_id = :selectedRefundTypes';


        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedRefundTypes',  $selectedRefundTypes);
        $sql->bindParam(':singleDateData', $singleDateData);
        $sql->execute();
        return $sql;
      }else if(!$selectedCustomers && !$singleDateData && $startDate && $endDate  && $selectedRefundTypes){
        $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id,  r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        INNER JOIN transactions AS t ON t.payment_id = p.id 
        INNER JOIN users AS u ON t.user_id = u.id WHERE DATE(r.date) BETWEEN :startDate AND :endDate AND r.refunded_method_id = :selectedRefundTypes';


        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedRefundTypes',  $selectedRefundTypes);
        $sql->bindParam(':startDate', $startDate);
        $sql->bindParam(':endDate', $endDate);
        $sql->execute();
        return $sql;
      }else if($selectedCustomers && $singleDateData && !$startDate && !$endDate  && $selectedRefundTypes){
        $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id,  r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        INNER JOIN transactions AS t ON t.payment_id = p.id 
        INNER JOIN users AS u ON t.user_id = u.id WHERE t.user_id = :selectedCustomers AND DATE(r.date) = :singleDateData AND r.refunded_method_id = :selectedRefundTypes';


        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedRefundTypes',  $selectedRefundTypes);
        $sql->bindParam(':selectedCustomers', $selectedCustomers);
        $sql->bindParam(':singleDateData', $singleDateData);
        $sql->execute();
        return $sql;
      }else if($selectedCustomers && !$singleDateData && $startDate && $endDate  && $selectedRefundTypes){
        $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id,  r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r 
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        INNER JOIN transactions AS t ON t.payment_id = p.id 
        INNER JOIN users AS u ON t.user_id = u.id WHERE t.user_id = :selectedCustomers AND DATE(r.date) BETWEEN :startDate AND :endDate AND r.refunded_method_id = :selectedRefundTypes';


        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedRefundTypes',  $selectedRefundTypes);
        $sql->bindParam(':selectedCustomers', $selectedCustomers);
        $sql->bindParam(':startDate', $startDate);
        $sql->bindParam(':endDate', $endDate);
        $sql->execute();
        return $sql;
      }
      else{
      $sql = 'SELECT DISTINCT r.id AS refunded_id, p.id AS payment_id,  r.refunded_method_id as refundType, r.refunded_qty AS qty, r.reference_num AS reference_num, r.refunded_amt AS amount, r.date AS date, r.refunded_method_id AS method, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM refunded AS r INNER JOIN payments AS p ON r.payment_id = p.id INNER JOIN products ON r.prod_id = products.id INNER JOIN transactions AS t ON t.payment_id = p.id INNER JOIN users AS u ON t.user_id = u.id';
      $stmt = $this->connect()->query($sql);
      return $stmt;
    }
   }
   public function getReturnAndEx($selectedProduct,$singleDateData,$startDate,$endDate ){
    if($selectedProduct && !$singleDateData&& !$startDate && !$endDate ){
          $sql = 'SELECT r.id AS return_id, p.id AS payment_id, products.prod_desc AS prod_desc, products.barcode as barcode, products.sku as sku,
          SUM(r.return_qty) AS qty, r.date AS date,
          products.prod_price AS prod_price, SUM(r.return_amount) AS amount,
          (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id
            FROM return_exchange AS r
            INNER JOIN payments AS p ON r.payment_id = p.id 
            INNER JOIN products ON r.product_id = products.id
            WHERE r.product_id = :selectedProduct
            GROUP BY p.id, products.id';

          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':selectedProduct', $selectedProduct);
          $sql->execute();
          return $sql;

    }else if(!$selectedProduct && $singleDateData && !$startDate && !$endDate ){
          $sql = 'SELECT r.id AS return_id, p.id AS payment_id, products.prod_desc AS prod_desc, products.barcode as barcode, products.sku as sku,
          SUM(r.return_qty) AS qty, r.date AS date,
          products.prod_price AS prod_price,SUM(r.return_amount) AS amount,
          (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id
            FROM return_exchange AS r
            INNER JOIN payments AS p ON r.payment_id = p.id 
            INNER JOIN products ON r.product_id = products.id
            WHERE DATE(r.date) = :singleDateData
            GROUP BY p.id, products.id';

          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':singleDateData', $singleDateData);
          $sql->execute();
          return $sql;
    }else if(!$selectedProduct && !$singleDateData && $startDate && $endDate ){
          $sql = 'SELECT r.id AS return_id, p.id AS payment_id, products.prod_desc AS prod_desc, products.barcode as barcode, products.sku as sku,
          SUM(r.return_qty) AS qty, r.date AS date,
          products.prod_price AS prod_price, SUM(r.return_amount) AS amount,
          (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id
            FROM return_exchange AS r
            INNER JOIN payments AS p ON r.payment_id = p.id 
            INNER JOIN products ON r.product_id = products.id
            WHERE DATE(r.date) BETWEEN :startDate AND :endDate 
            GROUP BY p.id, products.id';

          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':startDate', $startDate);
          $sql->bindParam(':endDate', $endDate);
          $sql->execute();
          return $sql;
    }else if($selectedProduct && $singleDateData && !$startDate && !$endDate ){
          $sql = 'SELECT r.id AS return_id, p.id AS payment_id, products.prod_desc AS prod_desc, products.barcode as barcode, products.sku as sku,
          SUM(r.return_qty) AS qty, r.date AS date,
          products.prod_price AS prod_price,SUM(r.return_amount) AS amount,
          (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id
            FROM return_exchange AS r
            INNER JOIN payments AS p ON r.payment_id = p.id 
            INNER JOIN products ON r.product_id = products.id
            WHERE r.product_id = :selectedProduct AND DATE(r.date) = :singleDateData 
            GROUP BY p.id, products.id';

          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':selectedProduct', $selectedProduct);
          $sql->bindParam(':singleDateData', $singleDateData);
          $sql->execute();
          return $sql;
    }else if($selectedProduct && !$singleDateData && $startDate && $endDate ){
          $sql = 'SELECT r.id AS return_id, p.id AS payment_id, products.prod_desc AS prod_desc, products.barcode as barcode, products.sku as sku,
          SUM(r.return_qty) AS qty, r.date AS date,
          products.prod_price AS prod_price, SUM(r.return_amount) AS amount,
          (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id
            FROM return_exchange AS r
            INNER JOIN payments AS p ON r.payment_id = p.id 
            INNER JOIN products ON r.product_id = products.id
            WHERE  r.product_id = :selectedProduct AND DATE(r.date) BETWEEN :startDate AND :endDate
            GROUP BY P.id, products.id';
          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':selectedProduct', $selectedProduct);
          $sql->bindParam(':startDate', $startDate);
          $sql->bindParam(':endDate', $endDate);
          $sql->execute();
          return $sql;
    }
    else{

        $sql= "SELECT r.id AS return_id, p.id AS payment_id, products.prod_desc AS prod_desc, products.barcode as barcode, products.sku as sku,
        SUM(r.return_qty) AS qty, r.date AS date,
        products.prod_price AS prod_price,  SUM(r.return_amount) AS amount,
        (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id
        FROM return_exchange AS r
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.product_id = products.id
        GROUP BY p.id, products.id";

      $stmt = $this->connect()->query($sql);
      return $stmt;
    }
   }

   public function getReturnExchangeCustomers($selectedCustomers,$singleDateData,$startDate,$endDate){
    if($selectedCustomers && !$singleDateData && !$startDate && !$endDate){
      $sql = 'SELECT DISTINCT r.id AS return_id, p.id AS payment_id, r.return_qty AS qty,products.prod_price as prod_price, (r.return_qty* products.prod_price) as return_amount, r.date AS date, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM return_exchange AS r 
      INNER JOIN payments AS p ON r.payment_id = p.id 
      INNER JOIN products ON r.product_id = products.id 
      INNER JOIN transactions AS t ON t.payment_id = p.id 
      INNER JOIN users AS u ON t.user_id = u.id  WHERE t.user_id = :selectedCustomers';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':selectedCustomers', $selectedCustomers);
      $sql->execute();
      return $sql;

    }else if(!$selectedCustomers && $singleDateData && !$startDate && !$endDate){
      $sql = 'SELECT DISTINCT r.id AS return_id, p.id AS payment_id, r.return_qty AS qty,products.prod_price as prod_price, (r.return_qty* products.prod_price) as return_amount, r.date AS date, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM return_exchange AS r 
      INNER JOIN payments AS p ON r.payment_id = p.id 
      INNER JOIN products ON r.product_id = products.id 
      INNER JOIN transactions AS t ON t.payment_id = p.id 
      INNER JOIN users AS u ON t.user_id = u.id WHERE DATE(r.date) = :singleDateData';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':singleDateData', $singleDateData);
      $sql->execute();
      return $sql;

    }else if(!$selectedCustomers && !$singleDateData && $startDate && $endDate){
      $sql = 'SELECT DISTINCT r.id AS return_id, p.id AS payment_id, r.return_qty AS qty,products.prod_price as prod_price, (r.return_qty* products.prod_price) as return_amount, r.date AS date, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM return_exchange AS r 
      INNER JOIN payments AS p ON r.payment_id = p.id 
      INNER JOIN products ON r.product_id = products.id 
      INNER JOIN transactions AS t ON t.payment_id = p.id 
      INNER JOIN users AS u ON t.user_id = u.id  WHERE DATE(r.date) BETWEEN :startDate AND :endDate';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':startDate', $startDate);
      $sql->bindParam(':endDate', $endDate);
      $sql->execute();
      return $sql;

    }else if($selectedCustomers && $singleDateData && !$startDate && !$endDate){
      $sql = 'SELECT DISTINCT r.id AS return_id, p.id AS payment_id, r.return_qty AS qty,products.prod_price as prod_price, (r.return_qty* products.prod_price) as return_amount, r.date AS date, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM return_exchange AS r 
      INNER JOIN payments AS p ON r.payment_id = p.id 
      INNER JOIN products ON r.product_id = products.id 
      INNER JOIN transactions AS t ON t.payment_id = p.id 
      INNER JOIN users AS u ON t.user_id = u.id WHERE t.user_id = :selectedCustomers AND DATE(r.date) = :singleDateData';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':singleDateData', $singleDateData);
      $sql->bindParam(':selectedCustomers', $selectedCustomers);
      $sql->execute();
      return $sql;
    }else if($selectedCustomers && !$singleDateData && $startDate && $endDate){
      $sql = 'SELECT DISTINCT r.id AS return_id, p.id AS payment_id, r.return_qty AS qty,products.prod_price as prod_price, (r.return_qty* products.prod_price) as return_amount, r.date AS date, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM return_exchange AS r 
      INNER JOIN payments AS p ON r.payment_id = p.id 
      INNER JOIN products ON r.product_id = products.id 
      INNER JOIN transactions AS t ON t.payment_id = p.id 
      INNER JOIN users AS u ON t.user_id = u.id  WHERE t.user_id = :selectedCustomers AND DATE(r.date) BETWEEN :startDate AND :endDate';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':selectedCustomers', $selectedCustomers);
      $sql->bindParam(':startDate', $startDate);
      $sql->bindParam(':endDate', $endDate);
      $sql->execute();
      return $sql;
    }
    else{
      $sql = 'SELECT DISTINCT r.id AS return_id, p.id AS payment_id, r.return_qty AS qty,products.prod_price as prod_price, (r.return_qty* products.prod_price) as return_amount, r.date AS date, u.last_name AS user_last_name, u.first_name AS user_first_name, (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id FROM return_exchange AS r INNER JOIN payments AS p ON r.payment_id = p.id INNER JOIN products ON r.product_id = products.id INNER JOIN transactions AS t ON t.payment_id = p.id INNER JOIN users AS u ON t.user_id = u.id';
      $stmt = $this->connect()->query($sql);
      return $stmt;

   }
  }

  public function getBOMData($selectedProduct,$selectedIngredients){
    if($selectedProduct && !$selectedIngredients){
      $sql = 'SELECT bom.id as id, p.prod_desc as prod_desc, i.name as name, u.uom_name as uom_name, bom.qty as qty
      FROM `bill_of_materials` as bom 
      INNER JOIN products as p ON p.id = bom.prod_id 
      INNER JOIN ingredients AS i ON i.id = bom.ingredients_id
      LEFT JOIN uom as u ON u.id = i.uom_id WHERE bom.prod_id = :selectedProduct';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':selectedProduct', $selectedProduct);
      $sql->execute();
      return $sql;
    }else if(!$selectedProduct && $selectedIngredients){
      $sql = 'SELECT bom.id as id, p.prod_desc as prod_desc, i.name as name, u.uom_name as uom_name, bom.qty as qty
      FROM `bill_of_materials` as bom 
      INNER JOIN products as p ON p.id = bom.prod_id 
      INNER JOIN ingredients AS i ON i.id = bom.ingredients_id
      LEFT JOIN uom as u ON u.id = i.uom_id WHERE bom.ingredients_id = :selectedIngredients';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':selectedIngredients', $selectedIngredients);
      $sql->execute();
      return $sql; 
    }else if($selectedProduct && $selectedIngredients){
      $sql = 'SELECT bom.id as id, p.prod_desc as prod_desc, i.name as name, u.uom_name as uom_name, bom.qty as qty
      FROM `bill_of_materials` as bom 
      INNER JOIN products as p ON p.id = bom.prod_id 
      INNER JOIN ingredients AS i ON i.id = bom.ingredients_id
      LEFT JOIN uom as u ON u.id = i.uom_id WHERE bom.prod_id = :selectedProduct AND bom.ingredients_id = :selectedIngredients';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':selectedIngredients', $selectedIngredients);
      $sql->bindParam(':selectedProduct', $selectedProduct);
      $sql->execute();
      return $sql; 
    }
    else{
    $sql = 'SELECT bom.id as id, p.prod_desc as prod_desc, i.name as name, u.uom_name as uom_name, bom.qty as qty
    FROM `bill_of_materials` as bom 
    INNER JOIN products as p ON p.id = bom.prod_id 
    INNER JOIN ingredients AS i ON i.id = bom.ingredients_id
    LEFT JOIN uom as u ON u.id = i.uom_id';
    $stmt = $this->connect()->query($sql);
    return $stmt;
    }
  }

  public function getCustomersData($customerId){
 
     if($customerId){
      $sql = 'SELECT u.first_name as first_name, u.last_name as last_name, c.contact as contact, c.email as email, d.name as name, d.discount_amount as rate 
      FROM `customer` as c 
      RIGHT JOIN users as u on u.id = c.user_id 
      LEFT JOIN discounts AS d ON d.id = u.discount_id WHERE u.role_id = 4 AND u.id = :customerId ';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':customerId', $customerId);
      $sql->execute();
      return $sql; 
     }else{
        
      $sql = 'SELECT u.first_name as first_name, u.last_name as last_name, c.contact as contact, c.email as email, d.name as name, d.discount_amount as rate 
      FROM `customer` as c 
      RIGHT JOIN users as u on u.id = c.user_id 
      LEFT JOIN discounts AS d ON d.id = u.discount_id WHERE u.role_id = 4;';
      $stmt = $this->connect()->query($sql);
      return $stmt;
     }
  }
  // public function voidedItemsData(){
  //   $sql = 'SELECT p.prod_desc as prod_desc, us.first_name as c_first_name, us.last_name as c_last_name, u.first_name as u_first_name, u.last_name as u_last_name, t.prod_qty as prod_qty,t.prod_price as prod_price, t.subtotal as totalAmount, t.is_void as paidStatus, py.date_time_of_payment as paymentDate FROM `transactions` as t LEFT JOIN products as p ON t.prod_id = p.id RIGHT JOIN payments as py ON py.id = t.payment_id INNER JOIN users as u ON u.id = t.user_id INNER JOIN users as us ON t.cashier_id = us.id WHERE t.is_void = 2;';
  //   $stmt = $this->connect()->query($sql);
  //   return $stmt;
  // }

  public function cashInAmountsData($userId,$singleDateData ,$startDate,$endDate){
    if($userId && !$singleDateData && !$startDate && !$endDate){
      $sql = 'SELECT c.cash_in_amount as amount,c.reason_note as note,c.date as date, u.first_name as first_name, u.last_name as last_name
      FROM cash_in_out as c 
      INNER JOIN users as u ON u.id = c.user_id 
      WHERE cashType = 0 AND u.id = :userId';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':userId', $userId);
      $sql->execute();
      return $sql; 
    }
    else if(!$userId && $singleDateData && !$startDate && !$endDate){
      $sql = 'SELECT c.cash_in_amount as amount,c.reason_note as note,c.date as date, u.first_name as first_name, u.last_name as last_name
      FROM cash_in_out as c 
      INNER JOIN users as u ON u.id = c.user_id 
      WHERE cashType = 0  AND DATE(c.date) = :singleDateData';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':singleDateData', $singleDateData);
      $sql->execute();
      return $sql; 
    }else if(!$userId && !$singleDateData && $startDate && $endDate){
      $sql = 'SELECT c.cash_in_amount as amount,c.reason_note as note,c.date as date, u.first_name as first_name, u.last_name as last_name
      FROM cash_in_out as c 
      INNER JOIN users as u ON u.id = c.user_id 
      WHERE cashType = 0  AND DATE(c.date) BETWEEN :startDate AND :endDate';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':startDate', $startDate);
      $sql->bindParam(':endDate', $endDate);
      $sql->execute();
      return $sql; 

    }else if($userId && $singleDateData && !$startDate && !$endDate){
      $sql = 'SELECT c.cash_in_amount as amount,c.reason_note as note,c.date as date, u.first_name as first_name, u.last_name as last_name
      FROM cash_in_out as c 
      INNER JOIN users as u ON u.id = c.user_id 
      WHERE cashType = 0 AND u.id = :userId AND DATE(c.date) = :singleDateData';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':userId', $userId);
      $sql->bindParam(':singleDateData', $singleDateData);
      $sql->execute();
      return $sql; 
    }else if($userId && !$singleDateData && $startDate && $endDate){
      $sql = 'SELECT c.cash_in_amount as amount,c.reason_note as note,c.date as date, u.first_name as first_name, u.last_name as last_name
      FROM cash_in_out as c 
      INNER JOIN users as u ON u.id = c.user_id 
      WHERE cashType = 0 AND u.id = :userId AND DATE(c.date) BETWEEN :startDate AND :endDate';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':userId', $userId);     
      $sql->bindParam(':startDate', $startDate);
      $sql->bindParam(':endDate', $endDate);
      $sql->execute();
      return $sql; 
    }else{
      $sql = 'SELECT c.cash_in_amount as amount,c.reason_note as note,c.date as date, u.first_name as first_name, u.last_name as last_name FROM cash_in_out as c INNER JOIN users as u ON u.id = c.user_id WHERE cashType = 0';
      $stmt = $this->connect()->query($sql);
      return $stmt;
    }
  }

  public function getUnpaidSales($selectedCustomers,$userId,$singleDateData,$startDate,$endDate){
    if($selectedCustomers && !$userId && !$singleDateData && !$startDate && !$endDate){
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
        c.first_name AS c_firstname,
        c.last_name AS c_lastname,
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
        u.first_name, u.last_name, c.first_name, c.last_name, t.user_id,cust.type ORDER BY u.first_name ASC';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':customerId', $selectedCustomers);
      $sql->execute();
      return $sql; 
    }else if(!$selectedCustomers && !$userId && $singleDateData && !$startDate && !$endDate){
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
        c.first_name AS c_firstname,
        c.last_name AS c_lastname,
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
         u.first_name, u.last_name, c.first_name, c.last_name, t.user_id,cust.type ORDER BY u.first_name ASC';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':singleDateData', $singleDateData);
      $sql->execute();
      return $sql;
    }else if(!$selectedCustomers && !$userId && !$singleDateData && $startDate && $endDate){
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
        c.first_name AS c_firstname,
        c.last_name AS c_lastname,
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
        u.first_name, u.last_name, c.first_name, c.last_name, t.user_id,cust.type ORDER BY u.first_name ASC';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':startDate', $startDate);
      $sql->bindParam(':endDate', $endDate);
      $sql->execute();
      return $sql;
    }else if($selectedCustomers && !$userId && $singleDateData && !$startDate && !$endDate){
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
        c.first_name AS c_firstname,
        c.last_name AS c_lastname,
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
        u.first_name, u.last_name, c.first_name, c.last_name, t.user_id,cust.type ORDER BY u.first_name ASC';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':customerId', $selectedCustomers);
      $sql->bindParam(':singleDateData', $singleDateData);
      $sql->execute();
      return $sql; 
    }else if($selectedCustomers && !$userId && !$singleDateData && $startDate && $endDate){
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
        c.first_name AS c_firstname,
        c.last_name AS c_lastname,
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
        u.first_name, u.last_name, c.first_name, c.last_name, t.user_id,cust.type ORDER BY u.first_name ASC';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':startDate', $startDate);
      $sql->bindParam(':endDate', $endDate);
      $sql->bindParam(':customerId', $selectedCustomers);
      $sql->execute();
      return $sql;
    }else if(!$selectedCustomers && $userId && !$singleDateData && !$startDate && !$endDate){
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
        c.first_name AS c_firstname,
        c.last_name AS c_lastname,
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
         u.first_name, u.last_name, c.first_name, c.last_name, t.user_id,cust.type ORDER BY u.first_name ASC';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':userId',  $userId);
      $sql->execute();
      return $sql; 
    }else if(!$selectedCustomers && $userId && $singleDateData && !$startDate && !$endDate){
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
        c.first_name AS c_firstname,
        c.last_name AS c_lastname,
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
        u.first_name, u.last_name, c.first_name, c.last_name, t.user_id,cust.type ORDER BY u.first_name ASC';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':userId',  $userId);
      $sql->bindParam(':singleDateData', $singleDateData);
      $sql->execute();
      return $sql; 
    }else if(!$selectedCustomers && $userId && !$singleDateData && $startDate && $endDate){
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
        c.first_name AS c_firstname,
        c.last_name AS c_lastname,
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
        u.first_name, u.last_name, c.first_name, c.last_name, t.user_id,cust.type ORDER BY u.first_name ASC';

      $sql = $this->connect()->prepare($sql);
      $sql->bindParam(':startDate', $startDate);
      $sql->bindParam(':endDate', $endDate);
      $sql->bindParam(':userId',  $userId);
      $sql->execute();
      return $sql;
    }
    else{
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
            c.first_name AS c_firstname,
            c.last_name AS c_lastname,
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
            u.first_name, u.last_name, c.first_name, c.last_name, t.user_id,cust.type ORDER BY u.first_name ASC';
        $stmt = $this->connect()->query($sql);
        return $stmt;
      }
  }
  public function getDiscountType(){
    $sql = 'SELECT * FROM discounts WHERE id NOT IN (5)';
    $stmt = $this->connect()->query($sql);
    return $stmt;
  }
  public function getDiscountDataReceipt($customerId,$discountType,$singleDateData,$startDate,$endDate){
    if($customerId && !$discountType && !$singleDateData && !$startDate && !$endDate){
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
            WHEN products.isVat = 1 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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
    
          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':customerId',  $customerId);
          $sql->execute();
          return $sql;

    }else if(!$customerId && $discountType && !$singleDateData && !$startDate && !$endDate){
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
            WHEN products.isVat = 1 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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
    
          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':discountType', $discountType);
          $sql->execute();
          return $sql;
    }else if(!$customerId && !$discountType && $singleDateData && !$startDate && !$endDate){
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
            WHEN products.isVat = 1 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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
    
          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':singleDateData', $singleDateData);
          $sql->execute();
          return $sql;
    }else if(!$customerId && !$discountType && !$singleDateData && $startDate && $endDate){
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
            WHEN products.isVat = 1 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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
    
          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':startDate', $startDate);
          $sql->bindParam(':endDate', $endDate);
          $sql->execute();
          return $sql;
    }else if($customerId && $discountType && !$singleDateData && !$startDate && !$endDate){
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
            WHEN products.isVat = 1 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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
    
          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':customerId',  $customerId);
          $sql->bindParam(':discountType', $discountType);
          $sql->execute();
          return $sql;
    }else if($customerId && !$discountType && $singleDateData && !$startDate && !$endDate){
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
    
          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':customerId',  $customerId);
          $sql->bindParam(':singleDateData', $singleDateData);
          $sql->execute();
          return $sql;
    }else if($customerId && !$discountType && !$singleDateData && $startDate && $endDate){
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
            WHEN products.isVat = 1 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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
    
          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':customerId',  $customerId);
          $sql->bindParam(':startDate', $startDate);
          $sql->bindParam(':endDate', $endDate);
          $sql->execute();
          return $sql;
    }else if(!$customerId && $discountType && $singleDateData && !$startDate && !$endDate){
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
            WHEN products.isVat = 1 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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
    
          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':discountType', $discountType);
          $sql->bindParam(':singleDateData', $singleDateData);
          $sql->execute();
          return $sql;
    }else if(!$customerId && $discountType && !$singleDateData && $startDate && $endDate){
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
            WHEN products.isVat = 1 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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
    
          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':discountType', $discountType);
          $sql->bindParam(':startDate', $startDate);
          $sql->bindParam(':endDate', $endDate);
          $sql->execute();
          return $sql;
    }else if($customerId && $discountType && $singleDateData && !$startDate && !$endDate){
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
            WHEN products.isVat = 1 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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
    
          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':customerId',  $customerId);
          $sql->bindParam(':discountType', $discountType);
          $sql->bindParam(':singleDateData', $singleDateData);
          $sql->execute();
          return $sql;
    }else if($customerId && $discountType && !$singleDateData && $startDate && $endDate){
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
            WHEN products.isVat = 1 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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
    
          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':customerId',  $customerId);
          $sql->bindParam(':discountType', $discountType);
          $sql->bindParam(':startDate', $startDate);
          $sql->bindParam(':endDate', $endDate);
          $sql->execute();
          return $sql;
    }
    else{
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
            WHEN products.isVat = 1 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        ((refunded.refunded_qty * products.prod_price) - 
                        ((refunded.refunded_qty * products.prod_price) * ((refunded.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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
            WHEN products.isVAT = 1 THEN 
                ROUND(
                    (
                        (( return_exchange.return_qty * products.prod_price) - 
                        (( return_exchange.return_qty * products.prod_price) * (( return_exchange.itemDiscount / (t.prod_qty * products.prod_price)) * 100) / 100)
                    ) / 1.12) * discounts.discount_amount / 100,
                    2
                )
            WHEN products.isVAT = 0 AND discounts.discount_amount > 0 THEN
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

        $stmt = $this->connect()->query($sql);
        return $stmt;
    }
  }
  public function getDiscountPerItem($selectedProduct,$singleDateData,$startDate,$endDate){
    if($selectedProduct && !$singleDateData && !$startDate && !$endDate){
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
    
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedProduct',  $selectedProduct);
        $sql->execute();
        return $sql;
    }else if(!$selectedProduct && $singleDateData && !$startDate && !$endDate){
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
    
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':singleDateData', $singleDateData);
        $sql->execute();
        return $sql;
    }else if(!$selectedProduct && !$singleDateData && $startDate && $endDate){
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
    
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':startDate', $startDate);
        $sql->bindParam(':endDate', $endDate);
        $sql->execute();
        return $sql;
    }else if($selectedProduct && $singleDateData && !$startDate && !$endDate){
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
    
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedProduct',  $selectedProduct);
        $sql->bindParam(':singleDateData', $singleDateData);
        $sql->execute();
        return $sql;
    }else if($selectedProduct && !$singleDateData && $startDate && $endDate){
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
    
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedProduct',  $selectedProduct);
        $sql->bindParam(':startDate', $startDate);
        $sql->bindParam(':endDate', $endDate);
        $sql->execute();
        return $sql;
    }else{
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

    $stmt = $this->connect()->query($sql);
    return $stmt;
    }
}
public function getPaymentMethod($singleDateData,$startDate,$endDate,$exclude){
    if($exclude == 1){
        if($singleDateData && !$startDate && !$endDate){
            $sql = "SELECT 
            DATE(payments.date_time_of_payment) AS payment_date,
            -- SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0) AS credit_total,
            -- SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'cash' THEN rf.refunded_amt ELSE 0 END), 0) AS cash_total,
            -- SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt ELSE 0 END), 0) AS e_wallet_total,
            -- SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt ELSE 0 END), 0) AS cdcards_total,
            -- SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt ELSE 0 END), 0) AS coupons_total,
            -- SUM(jt.amount) - COALESCE(SUM(rf.refunded_amt), 0) - COALESCE(SUM(re.total_return_amount), 0) AS total_amount
            GREATEST(SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS credit_total,
            GREATEST(SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'cash' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS cash_total,
            GREATEST(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt ELSE 0 END), 0), 0) AS e_wallet_total,
            GREATEST(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt ELSE 0 END), 0), 0) AS cdcards_total,
            GREATEST(SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS coupons_total,
            GREATEST(SUM(jt.amount) - COALESCE(SUM(rf.refunded_amt), 0) - COALESCE(SUM(re.total_return_amount), 0), 0) AS total_amount
        FROM 
            payments
        CROSS JOIN JSON_TABLE(
            payments.payment_details, '$[*]' COLUMNS (
                paymentType VARCHAR(255) PATH '$.paymentType', 
                amount DECIMAL(10, 2) PATH '$.amount'
            )
        ) AS jt
        INNER JOIN (
            SELECT DISTINCT payment_id, receipt_id FROM transactions WHERE is_paid = 1 AND is_void = 0
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
        WHERE 
            JSON_VALID(payments.payment_details) AND jt.amount != 0.00 AND DATE(payments.date_time_of_payment) = :singleDateData
        GROUP BY 
            DATE(payments.date_time_of_payment)
        ORDER BY 
            payment_date ASC;";
        
            $sql = $this->connect()->prepare($sql);
            $sql->bindParam(':singleDateData',  $singleDateData);
            $sql->execute();
            return $sql;
        }else if(!$singleDateData && $startDate && $endDate){
            $sql = "SELECT 
            DATE(payments.date_time_of_payment) AS payment_date,
            -- SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0) AS credit_total,
            -- SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'cash' THEN rf.refunded_amt ELSE 0 END), 0) AS cash_total,
            -- SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt ELSE 0 END), 0) AS e_wallet_total,
            -- SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt ELSE 0 END), 0) AS cdcards_total,
            -- SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt ELSE 0 END), 0) AS coupons_total,
            -- SUM(jt.amount) - COALESCE(SUM(rf.refunded_amt), 0) - COALESCE(SUM(re.total_return_amount), 0) AS total_amount
            GREATEST(SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS credit_total,
            GREATEST(SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'cash' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS cash_total,
            GREATEST(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt ELSE 0 END), 0), 0) AS e_wallet_total,
            GREATEST(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt ELSE 0 END), 0), 0) AS cdcards_total,
            GREATEST(SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS coupons_total,
            GREATEST(SUM(jt.amount) - COALESCE(SUM(rf.refunded_amt), 0) - COALESCE(SUM(re.total_return_amount), 0), 0) AS total_amount

        FROM 
            payments
        CROSS JOIN JSON_TABLE(
            payments.payment_details, '$[*]' COLUMNS (
                paymentType VARCHAR(255) PATH '$.paymentType', 
                amount DECIMAL(10, 2) PATH '$.amount'
            )
        ) AS jt
        INNER JOIN (
            SELECT DISTINCT payment_id, receipt_id FROM transactions WHERE is_paid = 1 AND is_void = 0
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
        WHERE 
            JSON_VALID(payments.payment_details) AND jt.amount != 0.00 AND DATE(payments.date_time_of_payment) BETWEEN :startDate AND :endDate
        GROUP BY 
            DATE(payments.date_time_of_payment)
        ORDER BY 
            payment_date ASC;";
        
            $sql = $this->connect()->prepare($sql);
            $sql->bindParam(':startDate', $startDate);
            $sql->bindParam(':endDate', $endDate);
            $sql->execute();
            return $sql;

        }else{
 
          $sql="SELECT 
          DATE(payments.date_time_of_payment) AS payment_date,
          SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END)AS credit_total,
          SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END) - COALESCE(rf_cash.total_refunded, 0) AS cash_total,
          SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) - COALESCE(rf_ewallet.total_refunded, 0) AS e_wallet_total,
          SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) - COALESCE(rf_cc.total_refunded, 0) AS cdcards_total,
          SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) - COALESCE(rf_coupons.total_refunded, 0) AS coupons_total,
          ROUND(SUM(jt.amount), 2) - COALESCE(rf_ewallet.total_refunded, 0) - COALESCE(rf_cash.total_refunded, 0) - COALESCE(rf_cc.total_refunded, 0) - COALESCE(rf_coupons.total_refunded, 0) AS total_amount,
          SUM(jt.amount) as  amount,
          COALESCE(rf_cash.total_refunded, 0) AS total_cash_refunded,
          COALESCE(rf_ewallet.total_refunded, 0) AS total_ewallet_refunded,
          COALESCE(rf_cc.total_refunded, 0) AS total_cdcards_refunded,
          COALESCE(rf_coupons.total_refunded, 0) AS total_coupons_refunded
      FROM 
          payments
      CROSS JOIN JSON_TABLE(
          payments.payment_details, '$[*]' COLUMNS (
              paymentType VARCHAR(255) PATH '$.paymentType', 
              amount DECIMAL(10, 2) PATH '$.amount'
          )
      ) AS jt
      INNER JOIN (
          SELECT DISTINCT payment_id, receipt_id FROM transactions WHERE is_paid = 1 AND is_void = 0
      ) AS t ON payments.id = t.payment_id
      LEFT JOIN (
          SELECT 
              payment_id,
              SUM(refunded_amt) AS total_refunded
          FROM 
              refunded
          WHERE 
              refunded_method_id = 1
          GROUP BY 
              payment_id
      ) AS rf_cash ON rf_cash.payment_id = payments.id
      LEFT JOIN (
          SELECT 
              payment_id,
              SUM(refunded_amt) AS total_refunded
          FROM 
              refunded
          WHERE 
              refunded_method_id IN (9,2,3,4,8)
          GROUP BY 
              payment_id
      ) AS rf_ewallet ON rf_ewallet.payment_id = payments.id
      LEFT JOIN (
          SELECT 
              payment_id,
              SUM(refunded_amt) AS total_refunded
          FROM 
              refunded
          WHERE 
              refunded_method_id = 6
          GROUP BY 
              payment_id
      ) AS rf_cc ON rf_cc.payment_id = payments.id
      LEFT JOIN (
          SELECT 
              payment_id,
              SUM(refunded_amt) AS total_refunded
          FROM 
              refunded
          WHERE 
              refunded_method_id = 7
          GROUP BY 
              payment_id
      ) AS rf_coupons ON rf_coupons.payment_id = payments.id
      WHERE 
          JSON_VALID(payments.payment_details) AND jt.amount != 0.00
      GROUP BY 
          DATE(payments.date_time_of_payment)
      ORDER BY 
          payment_date ASC;"; 
    $stmt = $this->connect()->query($sql);
    return $stmt;
    }

    }else{
    if($singleDateData && !$startDate && !$endDate){
        $sql = "SELECT 
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END) AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) AS total_amount
        FROM 
        payments
        CROSS JOIN JSON_TABLE(
        payments.payment_details, '$[*]' COLUMNS (
            paymentType VARCHAR(255) PATH '$.paymentType', 
            amount DECIMAL(10, 2) PATH '$.amount'
        )
        ) AS jt
        INNER JOIN ( 
        SELECT DISTINCT payment_id, receipt_id FROM transactions  WHERE is_paid = 1 AND is_void = 0
        ) AS t ON payments.id = t.payment_id
        WHERE 
        JSON_VALID(payments.payment_details) AND jt.amount != 0.00 AND DATE(payments.date_time_of_payment) = :singleDateData
        GROUP BY 
        DATE(payments.date_time_of_payment)
        ORDER BY 
        payment_date ASC;";
    
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':singleDateData',  $singleDateData);
        $sql->execute();
        return $sql;
    }else if(!$singleDateData && $startDate && $endDate){
        $sql = "SELECT 
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END) AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) AS total_amount
        FROM 
        payments
        CROSS JOIN JSON_TABLE(
        payments.payment_details, '$[*]' COLUMNS (
            paymentType VARCHAR(255) PATH '$.paymentType', 
            amount DECIMAL(10, 2) PATH '$.amount'
        )
        ) AS jt
        INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id FROM transactions  WHERE is_paid = 1 AND is_void = 0
        ) AS t ON payments.id = t.payment_id
        WHERE 
        JSON_VALID(payments.payment_details) AND jt.amount != 0.00 AND DATE(payments.date_time_of_payment) BETWEEN :startDate AND :endDate
        GROUP BY 
        DATE(payments.date_time_of_payment)
        ORDER BY 
        payment_date ASC;";
    
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':startDate', $startDate);
        $sql->bindParam(':endDate', $endDate);
        $sql->execute();
        return $sql;
    }else{
        $sql="SELECT 
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END) AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) AS total_amount
        FROM 
        payments
        CROSS JOIN JSON_TABLE(
        payments.payment_details, '$[*]' COLUMNS (
            paymentType VARCHAR(255) PATH '$.paymentType', 
            amount DECIMAL(10, 2) PATH '$.amount'
        )
        ) AS jt
        INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id FROM transactions  WHERE is_paid = 1 AND is_void = 0
        ) AS t ON payments.id = t.payment_id
        WHERE 
        JSON_VALID(payments.payment_details) AND jt.amount != 0.00
        GROUP BY 
        DATE(payments.date_time_of_payment)
        ORDER BY 
        payment_date ASC;"; 

            $stmt = $this->connect()->query($sql);
            return $stmt;
}
}
}

public function getPaymentMethodByUsers($userId,$singleDateData,$startDate,$endDate,$exclude){
    if($exclude == 1){
        if($userId && !$singleDateData && !$startDate && !$endDate){
            $sql = "SELECT 
            u.id as id,
            u.first_name as firstname,
            u.last_name as lastname,
            DATE(payments.date_time_of_payment) AS payment_date,
            -- SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0) AS credit_total,
            -- SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'cash' THEN rf.refunded_amt ELSE 0 END), 0) AS cash_total,
            -- SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt ELSE 0 END), 0) AS e_wallet_total,
            -- SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt ELSE 0 END), 0) AS cdcards_total,
            -- SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt ELSE 0 END), 0) AS coupons_total,
            -- SUM(jt.amount) - COALESCE(SUM(rf.refunded_amt), 0) - COALESCE(SUM(re.total_return_amount), 0) AS total_amount
            GREATEST(SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS credit_total,
            GREATEST(SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'cash' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS cash_total,
            GREATEST(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt ELSE 0 END), 0), 0) AS e_wallet_total,
            GREATEST(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt ELSE 0 END), 0), 0) AS cdcards_total,
            GREATEST(SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS coupons_total,
            GREATEST(SUM(jt.amount) - COALESCE(SUM(rf.refunded_amt), 0) - COALESCE(SUM(re.total_return_amount), 0), 0) AS total_amount
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
        INNER JOIN users AS u ON u.id = t.cashier_id
        WHERE 
            JSON_VALID(payments.payment_details) AND jt.amount != 0.00 AND u.id = :userId
        GROUP BY 
        u.id
        ORDER BY 
            payment_date ASC;";
        
            $sql = $this->connect()->prepare($sql);
            $sql->bindParam(':userId', $userId);
            $sql->execute();
            return $sql;
        
        }if(!$userId && $singleDateData && !$startDate && !$endDate){
            $sql = "SELECT 
            u.id as id,
            u.first_name as firstname,
            u.last_name as lastname,
            DATE(payments.date_time_of_payment) AS payment_date,
            -- SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0) AS credit_total,
            -- SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'cash' THEN rf.refunded_amt ELSE 0 END), 0) AS cash_total,
            -- SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt ELSE 0 END), 0) AS e_wallet_total,
            -- SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt ELSE 0 END), 0) AS cdcards_total,
            -- SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt ELSE 0 END), 0) AS coupons_total,
            -- SUM(jt.amount) - COALESCE(SUM(rf.refunded_amt), 0) - COALESCE(SUM(re.total_return_amount), 0) AS total_amount
            GREATEST(SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS credit_total,
            GREATEST(SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'cash' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS cash_total,
            GREATEST(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt ELSE 0 END), 0), 0) AS e_wallet_total,
            GREATEST(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt ELSE 0 END), 0), 0) AS cdcards_total,
            GREATEST(SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS coupons_total,
            GREATEST(SUM(jt.amount) - COALESCE(SUM(rf.refunded_amt), 0) - COALESCE(SUM(re.total_return_amount), 0), 0) AS total_amount
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
        INNER JOIN users AS u ON u.id = t.cashier_id
        WHERE 
            JSON_VALID(payments.payment_details) AND jt.amount != 0.00 AND DATE(payments.date_time_of_payment) = :singleDateData
        GROUP BY 
        u.id
        ORDER BY 
            payment_date ASC;";
        
            $sql = $this->connect()->prepare($sql);
            $sql->bindParam(':singleDateData',  $singleDateData);
            $sql->execute();
            return $sql;
        }else if(!$userId && !$singleDateData && $startDate && $endDate){
            $sql = "SELECT 
            u.id as id,
            u.first_name as firstname,
            u.last_name as lastname,
            DATE(payments.date_time_of_payment) AS payment_date,
            -- SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0) AS credit_total,
            -- SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'cash' THEN rf.refunded_amt ELSE 0 END), 0) AS cash_total,
            -- SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt ELSE 0 END), 0) AS e_wallet_total,
            -- SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt ELSE 0 END), 0) AS cdcards_total,
            -- SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt ELSE 0 END), 0) AS coupons_total,
            -- SUM(jt.amount) - COALESCE(SUM(rf.refunded_amt), 0) - COALESCE(SUM(re.total_return_amount), 0) AS total_amount
            GREATEST(SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS credit_total,
            GREATEST(SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'cash' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS cash_total,
            GREATEST(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt ELSE 0 END), 0), 0) AS e_wallet_total,
            GREATEST(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt ELSE 0 END), 0), 0) AS cdcards_total,
            GREATEST(SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS coupons_total,
            GREATEST(SUM(jt.amount) - COALESCE(SUM(rf.refunded_amt), 0) - COALESCE(SUM(re.total_return_amount), 0), 0) AS total_amount
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
        INNER JOIN users AS u ON u.id = t.cashier_id
        WHERE 
            JSON_VALID(payments.payment_details) AND jt.amount != 0.00 AND DATE(payments.date_time_of_payment) BETWEEN :startDate AND :endDate
        GROUP BY 
        u.id
        ORDER BY 
            payment_date ASC;";
        
            $sql = $this->connect()->prepare($sql);
            $sql->bindParam(':startDate', $startDate);
            $sql->bindParam(':endDate', $endDate);
            $sql->execute();
            return $sql;
        }else if($userId && $singleDateData && !$startDate && !$endDate){
            $sql = "SELECT 
            u.id as id,
            u.first_name as firstname,
            u.last_name as lastname,
            DATE(payments.date_time_of_payment) AS payment_date,
            -- SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0) AS credit_total,
            -- SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'cash' THEN rf.refunded_amt ELSE 0 END), 0) AS cash_total,
            -- SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt ELSE 0 END), 0) AS e_wallet_total,
            -- SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt ELSE 0 END), 0) AS cdcards_total,
            -- SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt ELSE 0 END), 0) AS coupons_total,
            -- SUM(jt.amount) - COALESCE(SUM(rf.refunded_amt), 0) - COALESCE(SUM(re.total_return_amount), 0) AS total_amount
            GREATEST(SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS credit_total,
            GREATEST(SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'cash' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS cash_total,
            GREATEST(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt ELSE 0 END), 0), 0) AS e_wallet_total,
            GREATEST(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt ELSE 0 END), 0), 0) AS cdcards_total,
            GREATEST(SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS coupons_total,
            GREATEST(SUM(jt.amount) - COALESCE(SUM(rf.refunded_amt), 0) - COALESCE(SUM(re.total_return_amount), 0), 0) AS total_amount
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
        INNER JOIN users AS u ON u.id = t.cashier_id
        WHERE 
            JSON_VALID(payments.payment_details) AND jt.amount != 0.00  AND u.id = :userId AND  DATE(payments.date_time_of_payment) = :singleDateData
        GROUP BY 
        u.id
        ORDER BY 
            payment_date ASC;";
        
            $sql = $this->connect()->prepare($sql);
            $sql->bindParam(':userId', $userId);
            $sql->bindParam(':singleDateData',  $singleDateData);
            $sql->execute();
            return $sql;
        }else if($userId && !$singleDateData && $startDate && $endDate){
            $sql = "SELECT 
            u.id as id,
            u.first_name as firstname,
            u.last_name as lastname,
            DATE(payments.date_time_of_payment) AS payment_date,
            -- SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0) AS credit_total,
            -- SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'cash' THEN rf.refunded_amt ELSE 0 END), 0) AS cash_total,
            -- SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt ELSE 0 END), 0) AS e_wallet_total,
            -- SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt ELSE 0 END), 0) AS cdcards_total,
            -- SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt ELSE 0 END), 0) AS coupons_total,
            -- SUM(jt.amount) - COALESCE(SUM(rf.refunded_amt), 0) - COALESCE(SUM(re.total_return_amount), 0) AS total_amount
            GREATEST(SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS credit_total,
            GREATEST(SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'cash' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS cash_total,
            GREATEST(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt ELSE 0 END), 0), 0) AS e_wallet_total,
            GREATEST(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt ELSE 0 END), 0), 0) AS cdcards_total,
            GREATEST(SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS coupons_total,
            GREATEST(SUM(jt.amount) - COALESCE(SUM(rf.refunded_amt), 0) - COALESCE(SUM(re.total_return_amount), 0), 0) AS total_amount
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
        INNER JOIN users AS u ON u.id = t.cashier_id
        WHERE 
            JSON_VALID(payments.payment_details) AND jt.amount != 0.00  AND u.id = :userId AND DATE(payments.date_time_of_payment) BETWEEN :startDate AND :endDate
        GROUP BY 
        u.id
        ORDER BY 
            payment_date ASC;";
        
            $sql = $this->connect()->prepare($sql);
            $sql->bindParam(':userId', $userId);
            $sql->bindParam(':startDate', $startDate);
            $sql->bindParam(':endDate', $endDate);
            $sql->execute();
            return $sql;
        }
        else{
            $sql="SELECT 
            u.id as id,
            u.first_name as firstname,
            u.last_name as lastname,
            DATE(payments.date_time_of_payment) AS payment_date,
            -- SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0) AS credit_total,
            -- SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'cash' THEN rf.refunded_amt ELSE 0 END), 0) AS cash_total,
            -- SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt ELSE 0 END), 0) AS e_wallet_total,
            -- SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt ELSE 0 END), 0) AS cdcards_total,
            -- SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt ELSE 0 END), 0) AS coupons_total,
            -- SUM(jt.amount) - COALESCE(SUM(rf.refunded_amt), 0) - COALESCE(SUM(re.total_return_amount), 0) AS total_amount
            GREATEST(SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'credit' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS credit_total,
            GREATEST(SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'cash' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS cash_total,
            GREATEST(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN rf.refunded_amt ELSE 0 END), 0), 0) AS e_wallet_total,
            GREATEST(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN rf.refunded_amt ELSE 0 END), 0), 0) AS cdcards_total,
            GREATEST(SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount - COALESCE(re.total_return_amount, 0) ELSE 0 END) - COALESCE(SUM(CASE WHEN jt.paymentType = 'coupon' THEN rf.refunded_amt ELSE 0 END), 0), 0) AS coupons_total,
            GREATEST(SUM(jt.amount) - COALESCE(SUM(rf.refunded_amt), 0) - COALESCE(SUM(re.total_return_amount), 0), 0) AS total_amount
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
        INNER JOIN users AS u ON u.id = t.cashier_id
        WHERE 
            JSON_VALID(payments.payment_details) AND jt.amount != 0.00
        GROUP BY 
        u.id
        ORDER BY 
            payment_date ASC;"; 
        $stmt = $this->connect()->query($sql);
        return $stmt;
        }
        
    }else{
    if($userId && !$singleDateData && !$startDate && !$endDate){
        $sql = "SELECT 
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END) AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) AS total_amount
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
    
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':userId', $userId);
        $sql->execute();
        return $sql;
    }else if(!$userId && $singleDateData && !$startDate && !$endDate){
        $sql = "SELECT 
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END) AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) AS total_amount
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
    
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':singleDateData',  $singleDateData);
        $sql->execute();
        return $sql;
    }else if(!$userId && !$singleDateData && $startDate && $endDate){
        $sql = "SELECT 
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END) AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) AS total_amount
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
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':startDate', $startDate);
        $sql->bindParam(':endDate', $endDate);
        $sql->execute();
        return $sql;
    }else if($userId && $singleDateData && !$startDate && !$endDate){
        $sql = "SELECT 
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END) AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) AS total_amount
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
    
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':userId', $userId);
        $sql->bindParam(':singleDateData',  $singleDateData);
        $sql->execute();
        return $sql;
    }else if($userId && !$singleDateData && $startDate && $endDate){
        $sql = "SELECT 
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END) AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) AS total_amount
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
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':userId', $userId);
        $sql->bindParam(':startDate', $startDate);
        $sql->bindParam(':endDate', $endDate);
        $sql->execute();
        return $sql;
    }
    else{
    $sql="SELECT 
            u.id as id,
            u.first_name as firstname,
            u.last_name as lastname,
            DATE(payments.date_time_of_payment) AS payment_date,
            SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
            SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END) AS cash_total,
            SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
            SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
            SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
            SUM(jt.amount) AS total_amount
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
        $stmt = $this->connect()->query($sql);
        return $stmt;
    }
}
}
public function getPaymentMethodByCustomer($customerId,$singleDateData,$startDate,$endDate,$exclude){
    if($exclude == 1){
      if($customerId && !$singleDateData && !$startDate && !$endDate){
        $sql="SELECT 
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

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':customerId', $customerId);
        $sql->execute();
        return $sql;

      }else if(!$customerId && $singleDateData && !$startDate && !$endDate){
        $sql="SELECT 
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
        JSON_VALID(payments.payment_details) AND jt.amount != 0.00 AND DATE(payments.date_time_of_payment) = :singleDateData
    GROUP BY 
    u.id
    ORDER BY 
        payment_date ASC;"; 

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':singleDateData',  $singleDateData);
        $sql->execute();
        return $sql;

      }else if(!$customerId && !$singleDateData && $startDate && $endDate){
        $sql="SELECT 
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
        JSON_VALID(payments.payment_details) AND jt.amount != 0.00  AND  DATE(payments.date_time_of_payment) BETWEEN :startDate AND :endDate
    GROUP BY 
    u.id
    ORDER BY 
        payment_date ASC;"; 

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':startDate', $startDate);
        $sql->bindParam(':endDate', $endDate);
        $sql->execute();
        return $sql;

      }else if($customerId && $singleDateData && !$startDate && !$endDate){
        $sql="SELECT 
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
        JSON_VALID(payments.payment_details) AND jt.amount != 0.00 AND u.id=:customerId AND DATE(payments.date_time_of_payment) = :singleDateData
    GROUP BY 
    u.id
    ORDER BY 
        payment_date ASC;"; 

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':customerId', $customerId);
        $sql->bindParam(':singleDateData',  $singleDateData);
        $sql->execute();
        return $sql;
      }else if($customerId && !$singleDateData && $startDate && $endDate){
        $sql="SELECT 
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
        JSON_VALID(payments.payment_details) AND jt.amount != 0.00 AND u.id=:customerId AND  DATE(payments.date_time_of_payment) BETWEEN :startDate AND :endDate
    GROUP BY 
    u.id
    ORDER BY 
        payment_date ASC;"; 

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':customerId', $customerId);
        $sql->bindParam(':startDate', $startDate);
        $sql->bindParam(':endDate', $endDate);
        $sql->execute();
        return $sql;
      }
      else{
        $sql="SELECT 
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
        JSON_VALID(payments.payment_details) AND jt.amount != 0.00
    GROUP BY 
    u.id
    ORDER BY 
        payment_date ASC;"; 
    $stmt = $this->connect()->query($sql);
    return $stmt;
    }
    }else{
    if($customerId && !$singleDateData && !$startDate && !$endDate){
        $sql="SELECT 
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END) AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) AS total_amount
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

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':customerId', $customerId);
        $sql->execute();
        return $sql;

    }else if(!$customerId && $singleDateData && !$startDate && !$endDate){
        $sql="SELECT 
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END) AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) AS total_amount
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

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':singleDateData',  $singleDateData);
        $sql->execute();
        return $sql;
    }else if(!$customerId && !$singleDateData && $startDate && $endDate){
        $sql="SELECT 
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END) AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) AS total_amount
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

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':startDate', $startDate);
        $sql->bindParam(':endDate', $endDate);
        $sql->execute();
        return $sql;
    }else if($customerId && $singleDateData && !$startDate && !$endDate){
        $sql="SELECT 
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END) AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) AS total_amount
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

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':customerId', $customerId);
        $sql->bindParam(':singleDateData',  $singleDateData);
        $sql->execute();
        return $sql;
    }else if($customerId && !$singleDateData && $startDate && $endDate){
        $sql="SELECT 
        u.id as id,
        u.first_name as firstname,
        u.last_name as lastname,
        DATE(payments.date_time_of_payment) AS payment_date,
        SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
        SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END) AS cash_total,
        SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
        SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
        SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
        SUM(jt.amount) AS total_amount
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

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':customerId', $customerId);
        $sql->bindParam(':startDate', $startDate);
        $sql->bindParam(':endDate', $endDate);
        $sql->execute();
        return $sql;
    }
    else{
        $sql="SELECT 
            u.id as id,
            u.first_name as firstname,
            u.last_name as lastname,
            DATE(payments.date_time_of_payment) AS payment_date,
            SUM(CASE WHEN jt.paymentType = 'credit' THEN jt.amount ELSE 0 END) AS credit_total,
            SUM(CASE WHEN jt.paymentType = 'cash' THEN jt.amount ELSE 0 END) AS cash_total,
            SUM(CASE WHEN jt.paymentType IN ('gcash', 'maya', 'alipay', 'grab pay', 'shopee pay') THEN jt.amount ELSE 0 END) AS e_wallet_total,
            SUM(CASE WHEN jt.paymentType IN ('visa', 'master card', 'discover', 'american express', 'jcb') THEN jt.amount ELSE 0 END) AS cdcards_total,
            SUM(CASE WHEN jt.paymentType = 'coupon' THEN jt.amount ELSE 0 END) AS coupons_total,
            SUM(jt.amount) AS total_amount
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
    $stmt = $this->connect()->query($sql);
    return $stmt;
        }
    }
}

public function getVoidedSales($selectedProduct,$userId,$singleDateData,$startDate,$endDate){
    if($selectedProduct && !$userId && !$singleDateData && !$startDate && !$endDate){
        $sql = 'SELECT DISTINCT  t.prod_desc as prod_desc, t.prod_price, t.prod_qty as qty, t.prod_price as price, t.discount_amount as discount,t.date as dateCreated, t.subtotal as subtotal,
        u.first_name as first_name, u.last_name as last_name, vr.date_void as voided, vr.reason as note
        FROM transactions as t
        INNER JOIN products as p
        INNER JOIN users as u ON u.id = t.cashier_id
        LEFT JOIN void_reason AS vr ON vr.id = t.void_id
        WHERE t.is_paid IN (0,1) AND t.is_void IN (1,2) AND t.prod_id = :selectedProduct
        ORDER BY  t.prod_desc ASC';

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedProduct', $selectedProduct);
        $sql->execute();
        return $sql;
    }else if(!$selectedProduct && $userId && !$singleDateData && !$startDate && !$endDate){
        $sql = 'SELECT DISTINCT  t.prod_desc as prod_desc, t.prod_price, t.prod_qty as qty, t.prod_price as price, t.discount_amount as discount,t.date as dateCreated, t.subtotal as subtotal,
        u.first_name as first_name, u.last_name as last_name, vr.date_void as voided, vr.reason as note
        FROM transactions as t
        INNER JOIN products as p
        INNER JOIN users as u ON u.id = t.cashier_id
        LEFT JOIN void_reason AS vr ON vr.id = t.void_id
        WHERE t.is_paid IN (0,1) AND t.is_void IN (1,2) AND t.cashier_id = :cashier_id
        ORDER BY  t.prod_desc ASC';

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':cashier_id',  $userId);
        $sql->execute();
        return $sql;

    }else if(!$selectedProduct && !$userId && $singleDateData && !$startDate && !$endDate){
        $sql = 'SELECT DISTINCT  t.prod_desc as prod_desc, t.prod_price, t.prod_qty as qty, t.prod_price as price, t.discount_amount as discount,t.date as dateCreated, t.subtotal as subtotal,
        u.first_name as first_name, u.last_name as last_name, vr.date_void as voided, vr.reason as note
        FROM transactions as t
        INNER JOIN products as p
        INNER JOIN users as u ON u.id = t.cashier_id
        LEFT JOIN void_reason AS vr ON vr.id = t.void_id
        WHERE t.is_paid IN (0,1) AND t.is_void IN (1,2) AND DATE(vr.date_void) = :singleDateData
        ORDER BY  t.prod_desc ASC';

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':singleDateData',  $singleDateData);
        $sql->execute();
        return $sql;
    }else if(!$selectedProduct && !$userId && !$singleDateData && $startDate && $endDate){
        $sql = 'SELECT DISTINCT  t.prod_desc as prod_desc, t.prod_price, t.prod_qty as qty, t.prod_price as price, t.discount_amount as discount,t.date as dateCreated, t.subtotal as subtotal,
        u.first_name as first_name, u.last_name as last_name, vr.date_void as voided, vr.reason as note
        FROM transactions as t
        INNER JOIN products as p
        INNER JOIN users as u ON u.id = t.cashier_id
        LEFT JOIN void_reason AS vr ON vr.id = t.void_id
        WHERE t.is_paid IN (0,1) AND t.is_void IN (1,2) AND DATE(vr.date_void) BETWEEN :stratDate AND :endDate
        ORDER BY  t.prod_desc ASC';

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':stratDate',  $startDate);
        $sql->bindParam(':endDate',  $endDate);
        $sql->execute();
        return $sql;
    }else if($selectedProduct && $userId && !$singleDateData && !$startDate && !$endDate){
        $sql = 'SELECT DISTINCT  t.prod_desc as prod_desc, t.prod_price, t.prod_qty as qty, t.prod_price as price, t.discount_amount as discount,t.date as dateCreated, t.subtotal as subtotal,
        u.first_name as first_name, u.last_name as last_name, vr.date_void as voided, vr.reason as note
        FROM transactions as t
        INNER JOIN products as p
        INNER JOIN users as u ON u.id = t.cashier_id
        LEFT JOIN void_reason AS vr ON vr.id = t.void_id
        WHERE t.is_paid IN (0,1) AND t.is_void IN (1,2) AND t.cashier_id = :cashier_id AND t.prod_id = :selectedProduct
        ORDER BY  t.prod_desc ASC';

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedProduct', $selectedProduct);
        $sql->bindParam(':cashier_id',  $userId);
        $sql->execute();
        return $sql;
    }else if($selectedProduct && !$userId && $singleDateData && !$startDate && !$endDate){
        $sql = 'SELECT DISTINCT  t.prod_desc as prod_desc, t.prod_price, t.prod_qty as qty, t.prod_price as price, t.discount_amount as discount,t.date as dateCreated, t.subtotal as subtotal,
        u.first_name as first_name, u.last_name as last_name, vr.date_void as voided, vr.reason as note
        FROM transactions as t
        INNER JOIN products as p
        INNER JOIN users as u ON u.id = t.cashier_id
        LEFT JOIN void_reason AS vr ON vr.id = t.void_id
        WHERE t.is_paid IN (0,1) AND t.is_void IN (1,2) AND DATE(vr.date_void) = :singleDateData AND t.prod_id = :selectedProduct
        ORDER BY  t.prod_desc ASC';

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedProduct', $selectedProduct);
        $sql->bindParam(':singleDateData',  $singleDateData);
        $sql->execute();
        return $sql;

    }else if(!$selectedProduct && $userId && $singleDateData && !$startDate && !$endDate){
        $sql = 'SELECT DISTINCT  t.prod_desc as prod_desc, t.prod_price, t.prod_qty as qty, t.prod_price as price, t.discount_amount as discount,t.date as dateCreated, t.subtotal as subtotal,
        u.first_name as first_name, u.last_name as last_name, vr.date_void as voided, vr.reason as note
        FROM transactions as t
        INNER JOIN products as p
        INNER JOIN users as u ON u.id = t.cashier_id
        LEFT JOIN void_reason AS vr ON vr.id = t.void_id
        WHERE t.is_paid IN (0,1) AND t.is_void IN (1,2) AND DATE(vr.date_void) = :singleDateData AND t.cashier_id = :cashier_id
        ORDER BY  t.prod_desc ASC';

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':cashier_id',  $userId);
        $sql->bindParam(':singleDateData',  $singleDateData);
        $sql->execute();
        return $sql;

    }else if($selectedProduct && !$userId && !$singleDateData && $startDate && $endDate){
        $sql = 'SELECT DISTINCT  t.prod_desc as prod_desc, t.prod_price, t.prod_qty as qty, t.prod_price as price, t.discount_amount as discount,t.date as dateCreated, t.subtotal as subtotal,
        u.first_name as first_name, u.last_name as last_name, vr.date_void as voided, vr.reason as note
        FROM transactions as t
        INNER JOIN products as p
        INNER JOIN users as u ON u.id = t.cashier_id
        LEFT JOIN void_reason AS vr ON vr.id = t.void_id
        WHERE t.is_paid IN (0,1) AND t.is_void IN (1,2) AND DATE(vr.date_void) BETWEEN :stratDate AND :endDate AND t.prod_id = :selectedProduct
        ORDER BY  t.prod_desc ASC';

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedProduct', $selectedProduct);
        $sql->bindParam(':stratDate',  $startDate);
        $sql->bindParam(':endDate',  $endDate);
        $sql->execute();
        return $sql;

    }else if(!$selectedProduct && $userId && !$singleDateData && $startDate && $endDate){
        $sql = 'SELECT DISTINCT  t.prod_desc as prod_desc, t.prod_price, t.prod_qty as qty, t.prod_price as price, t.discount_amount as discount,t.date as dateCreated, t.subtotal as subtotal,
        u.first_name as first_name, u.last_name as last_name, vr.date_void as voided, vr.reason as note
        FROM transactions as t
        INNER JOIN products as p
        INNER JOIN users as u ON u.id = t.cashier_id
        LEFT JOIN void_reason AS vr ON vr.id = t.void_id
        WHERE t.is_paid IN (0,1) AND t.is_void IN (1,2) AND DATE(vr.date_void) BETWEEN :stratDate AND :endDate AND t.cashier_id = :cashier_id
        ORDER BY  t.prod_desc ASC';

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':cashier_id',  $userId);
        $sql->bindParam(':stratDate',  $startDate);
        $sql->bindParam(':endDate',  $endDate);
        $sql->execute();
        return $sql;
    }else{
        $sql="SELECT DISTINCT  t.prod_desc as prod_desc, t.prod_price, t.prod_qty as qty, t.prod_price as price, t.discount_amount as discount,t.date as dateCreated, t.subtotal as subtotal,
        u.first_name as first_name, u.last_name as last_name, vr.date_void as voided, vr.reason as note,r.barcode
        FROM transactions as t
        INNER JOIN products as p
        INNER JOIN users as u ON u.id = t.cashier_id
        INNER JOIN receipt as r ON r.id = t.receipt_id
        LEFT JOIN void_reason AS vr ON vr.id = t.void_id
        WHERE t.is_paid IN (0,1) AND t.is_void IN (1,2) ORDER BY  t.prod_desc ASC;"; 

        $stmt = $this->connect()->query($sql);
        return $stmt; 
    }

}
public function getDatePayments(){
    $sql = 'SELECT DATE(date_time_of_payment) as date FROM payments GROUP BY date ORDER BY date ASC';
    $stmt = $this->connect()->query($sql);
    return $stmt;
}

public function zReadingReport($singleDateData,$startDate,$endDate){
    if($singleDateData && !$startDate && !$endDate ){
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
        FROM z_read  WHERE DATE(date_time) = :singleDateData
        ORDER BY id DESC
        LIMIT 1) as total_sales,
        SUM(JSON_VALUE(all_data, '$.present_accumulated_sale')) AS total_present_accumulated_sale,
        SUM(JSON_VALUE(all_data, '$.previous_accumulated_sale')) AS total_previous_accumulated_sale,
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

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':singleDateData',  $singleDateData);
        $sql->execute();
        return $sql;
    }else if(!$singleDateData && $startDate && $endDate){
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
        FROM z_read  WHERE DATE(date_time) BETWEEN :stratDate AND :endDate
        ORDER BY id DESC
        LIMIT 1) as total_sales,
        SUM(JSON_VALUE(all_data, '$.present_accumulated_sale')) AS total_present_accumulated_sale,
        SUM(JSON_VALUE(all_data, '$.previous_accumulated_sale')) AS total_previous_accumulated_sale,
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
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':stratDate',  $startDate);
        $sql->bindParam(':endDate',  $endDate);
        $sql->execute();
        return $sql;
    }else{
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
    SUM(JSON_VALUE(all_data, '$.present_accumulated_sale')) AS total_present_accumulated_sale,
    SUM(JSON_VALUE(all_data, '$.previous_accumulated_sale')) AS total_previous_accumulated_sale,
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
    $stmt = $this->connect()->query($sql);
    return $stmt;
    }

}

public function birSalesReport($singleDateData,$startDate,$endDate){
    if($singleDateData && !$startDate && !$endDate){
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

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':singleDateData',  $singleDateData);
        $sql->execute();
        return $sql;

    }else if(!$singleDateData && $startDate && $endDate){
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

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':stratDate',  $startDate);
        $sql->bindParam(':endDate',  $endDate);
        $sql->execute();
        return $sql;

    }else{
    $sql="SELECT z.id AS id,
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
$stmt = $this->connect()->query($sql);
return $stmt;
}
}

public function zReadDate(){
    $sql="SELECT date_time AS date FROM z_read"; 
    $stmt = $this->connect()->query($sql);
    return $stmt;
}

public function geProductSalesData($selectedProduct,$selectedCategories,$selectedSubCategories,$singleDateData,$startDate,$endDate,$selectedOption){
    if($selectedOption == "sold"){
        if($selectedProduct && !$selectedCategories && !$selectedSubCategories && !$singleDateData && !$startDate && !$endDate){
            $sqlQuery = "SELECT c.category_name as category_name, v.variant_name as variant_name, p.sku as sku, p.prod_desc as prod_desc,p.cost as cost, i.sold as sold,p.prod_price as prod_price,u.uom_name as measurement,(i.sold * p.prod_price) as totalAmount,
            CASE
                    WHEN p.isVAT = 1 THEN 
                        ROUND(
                            ((i.sold * p.prod_price) / 1.12) * 0.12,
                            2
                        )
                    ELSE 0
                END AS totalVat
            FROM inventory as i 
            INNER JOIN products as p ON p.id = i.product_id LEFT JOIN uom as u ON p.uom_id = u.id
            LEFT JOIN category as c ON c.id = p.category_id
            LEFT JOIN variants as v ON v.id = p.variant_id
            WHERE p.id = :selectedProduct
            HAVING i.sold > 0;";

            $sql = $this->connect()->prepare($sqlQuery);
            $sql->bindParam(':selectedProduct', $selectedProduct);
            $sql->execute();
            return $sql;

        }else if(!$selectedProduct && !$singleDateData && !$startDate && !$endDate && $selectedCategories && !$selectedSubCategories){
            $sqlQuery = "SELECT c.category_name as category_name, v.variant_name as variant_name, p.sku as sku, p.prod_desc as prod_desc,p.cost as cost, i.sold as sold,p.prod_price as prod_price,u.uom_name as measurement,(i.sold * p.prod_price) as totalAmount,
            CASE
                    WHEN p.isVAT = 1 THEN 
                        ROUND(
                            ((i.sold * p.prod_price) / 1.12) * 0.12,
                            2
                        )
                    ELSE 0
                END AS totalVat
            FROM inventory as i 
            INNER JOIN products as p ON p.id = i.product_id LEFT JOIN uom as u ON p.uom_id = u.id
            LEFT JOIN category as c ON c.id = p.category_id
            LEFT JOIN variants as v ON v.id = p.variant_id
            WHERE p.category_id = :selectedCategoryProduct
            HAVING i.sold > 0;";

            $sql = $this->connect()->prepare($sqlQuery);
            $sql->bindParam(':selectedCategoryProduct', $selectedCategories);
            $sql->execute();
            return $sql;
        }else if(!$selectedProduct && !$singleDateData && !$startDate && !$endDate && !$selectedCategories && $selectedSubCategories){
            $sqlQuery = "SELECT c.category_name as category_name, v.variant_name as variant_name, p.sku as sku, p.prod_desc as prod_desc,p.cost as cost, i.sold as sold,p.prod_price as prod_price,u.uom_name as measurement,(i.sold * p.prod_price) as totalAmount,
            CASE
                    WHEN p.isVAT = 1 THEN 
                        ROUND(
                            ((i.sold * p.prod_price) / 1.12) * 0.12,
                            2
                        )
                    ELSE 0
                END AS totalVat
            FROM inventory as i 
            INNER JOIN products as p ON p.id = i.product_id LEFT JOIN uom as u ON p.uom_id = u.id
            LEFT JOIN category as c ON c.id = p.category_id
            LEFT JOIN variants as v ON v.id = p.variant_id
            WHERE p.variant_id = :selectedVariantroduct
            HAVING i.sold > 0;";

            $sql = $this->connect()->prepare($sqlQuery);
            $sql->bindParam(':selectedVariantroduct', $selectedSubCategories);
            $sql->execute();
            return $sql;
        }else if($selectedProduct && !$singleDateData && !$startDate && !$endDate && $selectedCategories && !$selectedSubCategories){
            $sqlQuery = "SELECT c.category_name as category_name, v.variant_name as variant_name, p.sku as sku, p.prod_desc as prod_desc,p.cost as cost, i.sold as sold,p.prod_price as prod_price,u.uom_name as measurement,(i.sold * p.prod_price) as totalAmount,
            CASE
                    WHEN p.isVAT = 1 THEN 
                        ROUND(
                            ((i.sold * p.prod_price) / 1.12) * 0.12,
                            2
                        )
                    ELSE 0
                END AS totalVat
            FROM inventory as i 
            INNER JOIN products as p ON p.id = i.product_id LEFT JOIN uom as u ON p.uom_id = u.id
            LEFT JOIN category as c ON c.id = p.category_id
            LEFT JOIN variants as v ON v.id = p.variant_id
            WHERE p.category_id = :selectedCategoryProduct AND p.id = :selectedProduct
            HAVING i.sold > 0;";

            $sql = $this->connect()->prepare($sqlQuery);
            $sql->bindParam(':selectedProduct', $selectedProduct);
            $sql->bindParam(':selectedCategoryProduct', $selectedCategories);
            $sql->execute();
            return $sql;
        }else if($selectedProduct && !$singleDateData && !$startDate && !$endDate && !$selectedCategories && $selectedSubCategories){
            $sqlQuery = "SELECT c.category_name as category_name, v.variant_name as variant_name, p.sku as sku, p.prod_desc as prod_desc,p.cost as cost, i.sold as sold,p.prod_price as prod_price,u.uom_name as measurement,(i.sold * p.prod_price) as totalAmount,
            CASE
                    WHEN p.isVAT = 1 THEN 
                        ROUND(
                            ((i.sold * p.prod_price) / 1.12) * 0.12,
                            2
                        )
                    ELSE 0
                END AS totalVat
            FROM inventory as i 
            INNER JOIN products as p ON p.id = i.product_id LEFT JOIN uom as u ON p.uom_id = u.id
            LEFT JOIN category as c ON c.id = p.category_id
            LEFT JOIN variants as v ON v.id = p.variant_id
            WHERE p.variant_id = :selectedVariantroduct AND p.id = :selectedProduct
            HAVING i.sold > 0;";

            $sql = $this->connect()->prepare($sqlQuery);
            $sql->bindParam(':selectedProduct', $selectedProduct);
            $sql->bindParam(':selectedVariantroduct', $selectedSubCategories);
            $sql->execute();
            return $sql;
        }else if($selectedProduct && !$singleDateData && !$startDate && !$endDate && $selectedCategories && $selectedSubCategories){
            $sqlQuery = "SELECT c.category_name as category_name, v.variant_name as variant_name, p.sku as sku, p.prod_desc as prod_desc,p.cost as cost, i.sold as sold,p.prod_price as prod_price,u.uom_name as measurement,(i.sold * p.prod_price) as totalAmount,
            CASE
                    WHEN p.isVAT = 1 THEN 
                        ROUND(
                            ((i.sold * p.prod_price) / 1.12) * 0.12,
                            2
                        )
                    ELSE 0
                END AS totalVat
            FROM inventory as i 
            INNER JOIN products as p ON p.id = i.product_id LEFT JOIN uom as u ON p.uom_id = u.id
            LEFT JOIN category as c ON c.id = p.category_id
            LEFT JOIN variants as v ON v.id = p.variant_id
            WHERE p.variant_id = :selectedVariantroduct AND p.id = :selectedProduct AND p.category_id = :selectedCategoryProduct
            HAVING i.sold > 0;";

            $sql = $this->connect()->prepare($sqlQuery);
            $sql->bindParam(':selectedProduct', $selectedProduct);
            $sql->bindParam(':selectedVariantroduct', $selectedSubCategories);
            $sql->bindParam(':selectedCategoryProduct', $selectedCategories);
            $sql->execute();
            return $sql;
        }
        else{
        $sql="SELECT c.category_name as category_name, v.variant_name as variant_name, p.sku as sku, p.prod_desc as prod_desc,p.cost as cost, i.sold as sold,p.prod_price as prod_price,u.uom_name as measurement,(i.sold * p.prod_price) as totalAmount,
        CASE
                WHEN p.isVAT = 1 THEN 
                    ROUND(
                        ((i.sold * p.prod_price) / 1.12) * 0.12,
                        2
                    )
                ELSE 0
            END AS totalVat
        FROM inventory as i 
        INNER JOIN products as p ON p.id = i.product_id LEFT JOIN uom as u ON p.uom_id = u.id
        LEFT JOIN category as c ON c.id = p.category_id
        LEFT JOIN variants as v ON v.id = p.variant_id
        HAVING i.sold > 0;";
     
    $stmt = $this->connect()->query($sql);
    return $stmt;
    }
    }else{
        if($selectedProduct && !$selectedCategories && !$selectedSubCategories && !$singleDateData && !$startDate && !$endDate){
            $sqlQuery = "SELECT c.category_name as category_name, v.variant_name as variant_name, p.sku as sku, p.prod_desc as prod_desc,p.cost as cost, i.stock as stock,p.prod_price as prod_price,u.uom_name as measurement,(i.stock * p.prod_price) as totalAmount,
            CASE
                    WHEN p.isVAT = 1 THEN 
                        ROUND(
                            ((i.stock * p.prod_price) / 1.12) * 0.12,
                            2
                        )
                    ELSE 0
                END AS totalVat
            FROM inventory as i 
            INNER JOIN products as p ON p.id = i.product_id LEFT JOIN uom as u ON p.uom_id = u.id
            LEFT JOIN category as c ON c.id = p.category_id
            LEFT JOIN variants as v ON v.id = p.variant_id
            WHERE p.id = :selectedProduct
            HAVING i.stock > 0;";

            $sql = $this->connect()->prepare($sqlQuery);
            $sql->bindParam(':selectedProduct', $selectedProduct);
            $sql->execute();
            return $sql;

        }else if(!$selectedProduct && !$singleDateData && !$startDate && !$endDate && $selectedCategories && !$selectedSubCategories){
            $sqlQuery = "SELECT c.category_name as category_name, v.variant_name as variant_name, p.sku as sku, p.prod_desc as prod_desc,p.cost as cost, i.stock as stock,p.prod_price as prod_price,u.uom_name as measurement,(i.stock * p.prod_price) as totalAmount,
            CASE
                    WHEN p.isVAT = 1 THEN 
                        ROUND(
                            ((i.stock * p.prod_price) / 1.12) * 0.12,
                            2
                        )
                    ELSE 0
                END AS totalVat
            FROM inventory as i 
            INNER JOIN products as p ON p.id = i.product_id LEFT JOIN uom as u ON p.uom_id = u.id
            LEFT JOIN category as c ON c.id = p.category_id
            LEFT JOIN variants as v ON v.id = p.variant_id
            WHERE p.category_id = :selectedCategoryProduct
            HAVING i.stock > 0;";

            $sql = $this->connect()->prepare($sqlQuery);
            $sql->bindParam(':selectedCategoryProduct', $selectedCategories);
            $sql->execute();
            return $sql;
        }else if(!$selectedProduct && !$singleDateData && !$startDate && !$endDate && !$selectedCategories && $selectedSubCategories){
            $sqlQuery = "SELECT c.category_name as category_name, v.variant_name as variant_name, p.sku as sku, p.prod_desc as prod_desc,p.cost as cost, i.stock as stock,p.prod_price as prod_price,u.uom_name as measurement,(i.stock * p.prod_price) as totalAmount,
            CASE
                    WHEN p.isVAT = 1 THEN 
                        ROUND(
                            ((i.stock * p.prod_price) / 1.12) * 0.12,
                            2
                        )
                    ELSE 0
                END AS totalVat
            FROM inventory as i 
            INNER JOIN products as p ON p.id = i.product_id LEFT JOIN uom as u ON p.uom_id = u.id
            LEFT JOIN category as c ON c.id = p.category_id
            LEFT JOIN variants as v ON v.id = p.variant_id
            WHERE p.variant_id = :selectedVariantroduct
            HAVING i.stock > 0;";

            $sql = $this->connect()->prepare($sqlQuery);
            $sql->bindParam(':selectedVariantroduct', $selectedSubCategories);
            $sql->execute();
            return $sql;
        }else if($selectedProduct && !$singleDateData && !$startDate && !$endDate && $selectedCategories && !$selectedSubCategories){
            $sqlQuery = "SELECT c.category_name as category_name, v.variant_name as variant_name, p.sku as sku, p.prod_desc as prod_desc,p.cost as cost, i.stock as stock,p.prod_price as prod_price,u.uom_name as measurement,(i.stock * p.prod_price) as totalAmount,
            CASE
                    WHEN p.isVAT = 1 THEN 
                        ROUND(
                            ((i.stock * p.prod_price) / 1.12) * 0.12,
                            2
                        )
                    ELSE 0
                END AS totalVat
            FROM inventory as i 
            INNER JOIN products as p ON p.id = i.product_id LEFT JOIN uom as u ON p.uom_id = u.id
            LEFT JOIN category as c ON c.id = p.category_id
            LEFT JOIN variants as v ON v.id = p.variant_id
            WHERE p.category_id = :selectedCategoryProduct AND p.id = :selectedProduct
            HAVING i.stock > 0;";

            $sql = $this->connect()->prepare($sqlQuery);
            $sql->bindParam(':selectedProduct', $selectedProduct);
            $sql->bindParam(':selectedCategoryProduct', $selectedCategories);
            $sql->execute();
            return $sql;
        }else if($selectedProduct && !$singleDateData && !$startDate && !$endDate && !$selectedCategories && $selectedSubCategories){
            $sqlQuery = "SELECT c.category_name as category_name, v.variant_name as variant_name, p.sku as sku, p.prod_desc as prod_desc,p.cost as cost, i.stock as stock,p.prod_price as prod_price,u.uom_name as measurement,(i.stock * p.prod_price) as totalAmount,
            CASE
                    WHEN p.isVAT = 1 THEN 
                        ROUND(
                            ((i.stock * p.prod_price) / 1.12) * 0.12,
                            2
                        )
                    ELSE 0
                END AS totalVat
            FROM inventory as i 
            INNER JOIN products as p ON p.id = i.product_id LEFT JOIN uom as u ON p.uom_id = u.id
            LEFT JOIN category as c ON c.id = p.category_id
            LEFT JOIN variants as v ON v.id = p.variant_id
            WHERE p.variant_id = :selectedVariantroduct AND p.id = :selectedProduct
            HAVING i.stock > 0;";

            $sql = $this->connect()->prepare($sqlQuery);
            $sql->bindParam(':selectedProduct', $selectedProduct);
            $sql->bindParam(':selectedVariantroduct', $selectedSubCategories);
            $sql->execute();
            return $sql;
        }else if($selectedProduct && !$singleDateData && !$startDate && !$endDate && $selectedCategories && $selectedSubCategories){
            $sqlQuery = "SELECT c.category_name as category_name, v.variant_name as variant_name, p.sku as sku, p.prod_desc as prod_desc,p.cost as cost, i.stock as stock,p.prod_price as prod_price,u.uom_name as measurement,(i.stock * p.prod_price) as totalAmount,
            CASE
                    WHEN p.isVAT = 1 THEN 
                        ROUND(
                            ((i.stock * p.prod_price) / 1.12) * 0.12,
                            2
                        )
                    ELSE 0
                END AS totalVat
            FROM inventory as i 
            INNER JOIN products as p ON p.id = i.product_id LEFT JOIN uom as u ON p.uom_id = u.id
            LEFT JOIN category as c ON c.id = p.category_id
            LEFT JOIN variants as v ON v.id = p.variant_id
            WHERE p.variant_id = :selectedVariantroduct AND p.id = :selectedProduct AND p.category_id = :selectedCategoryProduct
            HAVING i.stock > 0;";

            $sql = $this->connect()->prepare($sqlQuery);
            $sql->bindParam(':selectedProduct', $selectedProduct);
            $sql->bindParam(':selectedVariantroduct', $selectedSubCategories);
            $sql->bindParam(':selectedCategoryProduct', $selectedCategories);
            $sql->execute();
            return $sql;
        }
        else{
        $sql="SELECT c.category_name as category_name, v.variant_name as variant_name, p.sku as sku, p.prod_desc as prod_desc,p.cost as cost, i.stock as stock,p.prod_price as prod_price,u.uom_name as measurement,(i.stock * p.prod_price) as totalAmount,
        CASE
                WHEN p.isVAT = 1 THEN 
                    ROUND(
                        ((i.stock * p.prod_price) / 1.12) * 0.12,
                        2
                    )
                ELSE 0
            END AS totalVat
        FROM inventory as i 
        INNER JOIN products as p ON p.id = i.product_id LEFT JOIN uom as u ON p.uom_id = u.id
        LEFT JOIN category as c ON c.id = p.category_id
        LEFT JOIN variants as v ON v.id = p.variant_id
        HAVING i.stock > 0;";
     
    $stmt = $this->connect()->query($sql);
    return $stmt;
    }

    }

}
public function taxRates($singleDateData,$startDate,$endDate){
 if($singleDateData && !$startDate && !$endDate){
    $sqlQuery = "SELECT  SUM(JSON_VALUE(all_data, '$.vat_amount')) AS total_vat_amount, SUM(JSON_VALUE(all_data, '$.vatable_sales'))
     AS total_vatable_sales,date_time,
     SUM(JSON_VALUE(all_data, '$.zero_rated')) AS total_zero_rated,
    SUM(JSON_VALUE(all_data, '$.otherCustomerVat')) AS total_other

    FROM z_read
    WHERE DATE(date_time) = :singleDateData
    ";

    $sql = $this->connect()->prepare($sqlQuery);

    $sql->bindParam(':singleDateData',$singleDateData);
    $sql->execute();
    return $sql;

 }else if(!$singleDateData && $startDate && $endDate){
    $sqlQuery = "SELECT  SUM(JSON_VALUE(all_data, '$.vat_amount')) AS total_vat_amount, SUM(JSON_VALUE(all_data, '$.vatable_sales'))
    AS total_vatable_sales,date_time,
    SUM(JSON_VALUE(all_data, '$.zero_rated')) AS total_zero_rated,
    SUM(JSON_VALUE(all_data, '$.otherCustomerVat')) AS total_other
   FROM z_read
   WHERE DATE(date_time) BETWEEN :startDate AND :endDate
   ";

   $sql = $this->connect()->prepare($sqlQuery);
   $sql->bindParam(':startDate',$startDate);
   $sql->bindParam(':endDate',$endDate);
   $sql->execute();
   return $sql;
 }
 else{
    $sql="SELECT  SUM(JSON_VALUE(all_data, '$.vat_amount')) AS total_vat_amount,
     SUM(JSON_VALUE(all_data, '$.vatable_sales')) AS total_vatable_sales,date_time,
     SUM(JSON_VALUE(all_data, '$.zero_rated')) AS total_zero_rated,
    SUM(JSON_VALUE(all_data, '$.otherCustomerVat')) AS total_other
      FROM z_read;";
 
$stmt = $this->connect()->query($sql);
return $stmt;
 }
}
public function getProfit($selectedProduct,$selectedCategories,$selectedSubCategories,$singleDateData,$startDate,$endDate,$selectedOption){
    if($selectedOption == "sold"){
        if($selectedProduct && !$selectedCategories && !$selectedSubCategories && !$singleDateData && !$startDate && !$endDate){
            $sqlQuery = "SELECT p.prod_desc as prod_desc,p.sku as sku,i.sold as sold,ROUND((i.sold * p.cost),2) as cost,p.prod_price as prod_price,p.markup as markup,
            ROUND(((i.sold * p.prod_price)-(i.sold * p.cost)),2) AS profit,ROUND((i.sold * p.prod_price),2)  as total
            FROM inventory as i 
            INNER JOIN products as p ON p.id = i.product_id
            WHERE p.id = :selectedProduct
            HAVING
            sold > 0;
           ";
        
           $sql = $this->connect()->prepare($sqlQuery);
           $sql->bindParam(':selectedProduct',$selectedProduct);
           $sql->execute();
           return $sql;

        }else if(!$selectedProduct && $selectedCategories && !$selectedSubCategories && !$singleDateData && !$startDate && !$endDate){
            $sqlQuery = "SELECT p.prod_desc as prod_desc,p.sku as sku,i.sold as sold,ROUND((i.sold * p.cost),2) as cost,p.prod_price as prod_price,p.markup as markup,
            ROUND(((i.sold * p.prod_price)-(i.sold * p.cost)),2) AS profit,ROUND((i.sold * p.prod_price),2)  as total
            FROM inventory as i 
            INNER JOIN products as p ON p.id = i.product_id
            WHERE p.category_id = :selectedCategories
            HAVING
            sold > 0;
           ";
        
           $sql = $this->connect()->prepare($sqlQuery);
           $sql->bindParam(':selectedCategories',$selectedCategories);
           $sql->execute();
           return $sql;
        }else if(!$selectedProduct && !$selectedCategories && $selectedSubCategories && !$singleDateData && !$startDate && !$endDate){
            $sqlQuery = "SELECT p.prod_desc as prod_desc,p.sku as sku,i.sold as sold,ROUND((i.sold * p.cost),2) as cost,p.prod_price as prod_price,p.markup as markup,
            ROUND(((i.sold * p.prod_price)-(i.sold * p.cost)),2) AS profit,ROUND((i.sold * p.prod_price),2)  as total
            FROM inventory as i 
            INNER JOIN products as p ON p.id = i.product_id
            WHERE p.category_id = :selectedSubCategories
            HAVING
            sold > 0;
           ";
        
           $sql = $this->connect()->prepare($sqlQuery);
           $sql->bindParam(':selectedSubCategories',$selectedSubCategories);
           $sql->execute();
           return $sql;
        }else if(!$selectedProduct && !$selectedCategories && $selectedSubCategories && !$singleDateData && !$startDate && !$endDate){

        }
        else{
            $sql="SELECT p.prod_desc as prod_desc,p.sku as sku,i.sold as sold,ROUND((i.sold * p.cost),2) as cost,p.prod_price as prod_price,p.markup as markup,
            ROUND(((i.sold * p.prod_price)-(i.sold * p.cost)),2) AS profit,ROUND((i.sold * p.prod_price),2)  as total
            FROM inventory as i 
            INNER JOIN products as p ON p.id = i.product_id
            HAVING
            sold > 0";
         
            $stmt = $this->connect()->query($sql);
            return $stmt; 
        }

    }else{
        if($selectedProduct && !$selectedCategories && !$selectedSubCategories && !$singleDateData && !$startDate && !$endDate){
            $sqlQuery = "SELECT p.prod_desc as prod_desc,p.sku as sku,i.stock as stock, ROUND((i.stock * p.cost),2) as cost,p.prod_price as prod_price,p.markup as markup,
            ROUND(((i.stock * p.prod_price)-(i.stock * p.cost)),2) AS profit,ROUND((i.stock * p.prod_price),2)  as total
            FROM inventory as i 
            INNER JOIN products as p ON p.id = i.product_id
            WHERE p.id = :selectedProduct
            HAVING
            stock > 0
           ";
        
           $sql = $this->connect()->prepare($sqlQuery);
           $sql->bindParam(':selectedProduct',$selectedProduct);
           $sql->execute();
           return $sql;
        }else if(!$selectedProduct && $selectedCategories && !$selectedSubCategories && !$singleDateData && !$startDate && !$endDate){
            $sqlQuery = "SELECT p.prod_desc as prod_desc,p.sku as sku,i.stock as stock, ROUND((i.stock * p.cost),2) as cost,p.prod_price as prod_price,p.markup as markup,
            ROUND(((i.stock * p.prod_price)-(i.stock * p.cost)),2) AS profit,ROUND((i.stock * p.prod_price),2)  as total
            FROM inventory as i 
            INNER JOIN products as p ON p.id = i.product_id
            WHERE p.category_id = :selectedCategories
            HAVING
            stock > 0
           ";
        
           $sql = $this->connect()->prepare($sqlQuery);
           $sql->bindParam(':selectedCategories',$selectedCategories);
           $sql->execute();
           return $sql;
        }else if(!$selectedProduct && !$selectedCategories && $selectedSubCategories && !$singleDateData && !$startDate && !$endDate){
            $sqlQuery = "SELECT p.prod_desc as prod_desc,p.sku as sku,i.stock as stock, ROUND((i.stock * p.cost),2) as cost,p.prod_price as prod_price,p.markup as markup,
            ROUND(((i.stock * p.prod_price)-(i.stock * p.cost)),2) AS profit,ROUND((i.stock * p.prod_price),2)  as total
            FROM inventory as i 
            INNER JOIN products as p ON p.id = i.product_id
            WHERE p.category_id = :selectedSubCategories
            HAVING
            stock > 0
           ";
        
           $sql = $this->connect()->prepare($sqlQuery);
           $sql->bindParam(':selectedSubCategories',$selectedSubCategories);
           $sql->execute();
           return $sql;
        }
        else{
            $sql="SELECT p.prod_desc as prod_desc,p.sku as sku,i.stock as stock, ROUND((i.stock * p.cost),2) as cost,p.prod_price as prod_price,p.markup as markup,
            ROUND(((i.stock * p.prod_price)-(i.stock * p.cost)),2) AS profit,ROUND((i.stock * p.prod_price),2)  as total
            FROM inventory as i 
            INNER JOIN products as p ON p.id = i.product_id
            HAVING
            stock > 0;";
         
            $stmt = $this->connect()->query($sql);
            return $stmt; 
        } 
    }
  
}
}
