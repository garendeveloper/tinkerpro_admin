<?php

  class OtherReportsFacade extends DBConnection {

   public function getRefundData($selectedProduct,$singleDateData,$startDate,$endDate ){

      if($selectedProduct && !$singleDateData && !$startDate && !$endDate){
        $sql = 'SELECT r.id AS refunded_id, p.id as payment_id, products.prod_desc as prod_desc, 
        r.refunded_qty as qty, r.reference_num as reference_num, r.refunded_amt as amount, r.date as date, r.refunded_method_id as method,
        ( SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1 ) AS receipt_id FROM refunded AS r
         INNER JOIN payments AS p ON r.payment_id = p.id 
         INNER JOIN products ON r.prod_id = products.id WHERE r.prod_id = :selectedProduct';

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedProduct', $selectedProduct);
        $sql->execute();
        return $sql;

      }else if(!$selectedProduct && $singleDateData && !$startDate && !$endDate){
        $sql = 'SELECT r.id AS refunded_id, p.id as payment_id, products.prod_desc as prod_desc, 
        r.refunded_qty as qty, r.reference_num as reference_num, r.refunded_amt as amount, 
        DATE(r.date) as date, r.refunded_method_id as method,
        (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id 
        FROM refunded AS r
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        WHERE DATE(r.date) = :singleDateData';

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':singleDateData', $singleDateData);
        $sql->execute();
        return $sql;

      }else if(!$selectedProduct && !$singleDateData && $startDate && $endDate){
        $sql = 'SELECT r.id AS refunded_id, p.id as payment_id, products.prod_desc as prod_desc, 
        r.refunded_qty as qty, r.reference_num as reference_num, r.refunded_amt as amount, 
        DATE(r.date) as date, r.refunded_method_id as method,
        (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id 
        FROM refunded AS r
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        WHERE DATE(r.date) BETWEEN :startDate AND :endDate ';

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':startDate', $startDate);
        $sql->bindParam(':endDate', $endDate);
        $sql->execute();
        return $sql;
      }else if($selectedProduct && $singleDateData && !$startDate && !$endDate){
        $sql = 'SELECT r.id AS refunded_id, p.id as payment_id, products.prod_desc as prod_desc, 
        r.refunded_qty as qty, r.reference_num as reference_num, r.refunded_amt as amount, 
        DATE(r.date) as date, r.refunded_method_id as method,
        (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id 
        FROM refunded AS r
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        WHERE r.prod_id = :selectedProduct AND DATE(r.date) = :singleDateData';

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedProduct', $selectedProduct);
        $sql->bindParam(':singleDateData', $singleDateData);
        $sql->execute();
        return $sql;

      }else if($selectedProduct && !$singleDateData && $startDate && $endDate){
        $sql = 'SELECT r.id AS refunded_id, p.id as payment_id, products.prod_desc as prod_desc, 
        r.refunded_qty as qty, r.reference_num as reference_num, r.refunded_amt as amount, 
        DATE(r.date) as date, r.refunded_method_id as method,
        (SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1) AS receipt_id 
        FROM refunded AS r
        INNER JOIN payments AS p ON r.payment_id = p.id 
        INNER JOIN products ON r.prod_id = products.id 
        WHERE r.prod_id = :selectedProduct AND DATE(r.date) BETWEEN :startDate AND :endDate';

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedProduct', $selectedProduct);
        $sql->bindParam(':startDate', $startDate);
        $sql->bindParam(':endDate', $endDate);
        $sql->execute();
        return $sql;
      }else{
        $sql = 'SELECT r.id AS refunded_id, p.id as payment_id, products.prod_desc as prod_desc, 
        r.refunded_qty as qty, r.reference_num as reference_num, r.refunded_amt as amount, r.date as date, r.refunded_method_id as method,
        ( SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1 ) AS receipt_id FROM refunded AS r
         INNER JOIN payments AS p ON r.payment_id = p.id 
         INNER JOIN products ON r.prod_id = products.id';
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
          $sql = 'SELECT r.id AS return_id, p.id as payment_id, products.prod_desc as prod_desc, 
          r.return_qty as qty, r.date as date,
          products.prod_price as prod_price, (r.return_qty* products.prod_price) as return_amount,
          ( SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1 ) AS receipt_id FROM return_exchange AS r
          INNER JOIN payments AS p ON r.payment_id = p.id 
          INNER JOIN products ON r.product_id = products.id WHERE r.product_id = :selectedProduct';

          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':selectedProduct', $selectedProduct);
          $sql->execute();
          return $sql;

    }else if(!$selectedProduct && $singleDateData && !$startDate && !$endDate ){
          $sql = 'SELECT r.id AS return_id, p.id as payment_id, products.prod_desc as prod_desc, 
          r.return_qty as qty, r.date as date,
          products.prod_price as prod_price, (r.return_qty* products.prod_price) as return_amount,
          ( SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1 ) AS receipt_id FROM return_exchange AS r
          INNER JOIN payments AS p ON r.payment_id = p.id 
          INNER JOIN products ON r.product_id = products.id WHERE DATE(r.date) = :singleDateData';

          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':singleDateData', $singleDateData);
          $sql->execute();
          return $sql;
    }else if(!$selectedProduct && !$singleDateData && $startDate && $endDate ){
          $sql = 'SELECT r.id AS return_id, p.id as payment_id, products.prod_desc as prod_desc, 
          r.return_qty as qty, r.date as date,
          products.prod_price as prod_price, (r.return_qty* products.prod_price) as return_amount,
          ( SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1 ) AS receipt_id FROM return_exchange AS r
          INNER JOIN payments AS p ON r.payment_id = p.id 
          INNER JOIN products ON r.product_id = products.id WHERE DATE(r.date) BETWEEN :startDate AND :endDate';

          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':startDate', $startDate);
          $sql->bindParam(':endDate', $endDate);
          $sql->execute();
          return $sql;
    }else if($selectedProduct && $singleDateData && !$startDate && !$endDate ){
          $sql = 'SELECT r.id AS return_id, p.id as payment_id, products.prod_desc as prod_desc, 
          r.return_qty as qty, r.date as date,
          products.prod_price as prod_price, (r.return_qty* products.prod_price) as return_amount,
          ( SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1 ) AS receipt_id FROM return_exchange AS r
          INNER JOIN payments AS p ON r.payment_id = p.id 
          INNER JOIN products ON r.product_id = products.id WHERE r.product_id = :selectedProduct AND DATE(r.date) = :singleDateData';

          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':selectedProduct', $selectedProduct);
          $sql->bindParam(':singleDateData', $singleDateData);
          $sql->execute();
          return $sql;
    }else if($selectedProduct && !$singleDateData && $startDate && $endDate ){
          $sql = 'SELECT r.id AS return_id, p.id as payment_id, products.prod_desc as prod_desc, 
          r.return_qty as qty, r.date as date,
          products.prod_price as prod_price, (r.return_qty* products.prod_price) as return_amount,
          ( SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1 ) AS receipt_id FROM return_exchange AS r
          INNER JOIN payments AS p ON r.payment_id = p.id 
          INNER JOIN products ON r.product_id = products.id WHERE  r.product_id = :selectedProduct AND DATE(r.date) BETWEEN :startDate AND :endDate';

          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':selectedProduct', $selectedProduct);
          $sql->bindParam(':startDate', $startDate);
          $sql->bindParam(':endDate', $endDate);
          $sql->execute();
          return $sql;
    }
    else{
      $sql = 'SELECT r.id AS return_id, p.id as payment_id, products.prod_desc as prod_desc, 
      r.return_qty as qty, r.date as date,
      products.prod_price as prod_price, (r.return_qty* products.prod_price) as return_amount,
      ( SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1 ) AS receipt_id FROM return_exchange AS r
       INNER JOIN payments AS p ON r.payment_id = p.id 
       INNER JOIN products ON r.product_id = products.id';
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
    $sql = 'SELECT c.cash_in_amount as amount,c.reason_note as note,c.date as date, u.first_name as first_name, u.last_name as last_name FROM cash_in_out as c INNER JOIN users as u ON u.id = c.user_id WHERE cashType = 0';
    $stmt = $this->connect()->query($sql);
    return $stmt;
  }
  }