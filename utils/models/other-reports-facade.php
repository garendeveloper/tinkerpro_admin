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
        r.id AS receipt_id,
        p.date_time_of_payment as date,
        IFNULL(tp.total_paid_amount, 0) AS total_paid_amount,
        COALESCE(p.creditTotal, 0) AS credit_amount,
        COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0)  AS balance
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
    INNER JOIN 
    users as c ON c.id = t.cashier_id
    LEFT JOIN 
        TotalPaid AS tp ON tp.receipt_id = r.id
    WHERE 
        COALESCE(p.creditTotal, 0) != 0
        AND (COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0) ) != 0 AND t.user_id = :customerId
    GROUP BY
        u.first_name, u.last_name, p.creditTotal, r.id';

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
        r.id AS receipt_id,
        p.date_time_of_payment as date,
        IFNULL(tp.total_paid_amount, 0) AS total_paid_amount,
        COALESCE(p.creditTotal, 0) AS credit_amount,
        COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0)  AS balance
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
    INNER JOIN 
    users as c ON c.id = t.cashier_id
    LEFT JOIN 
        TotalPaid AS tp ON tp.receipt_id = r.id
    WHERE 
        COALESCE(p.creditTotal, 0) != 0
        AND (COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0) ) != 0 AND DATE(p.date_time_of_payment) = :singleDateData
    GROUP BY
        u.first_name, u.last_name, p.creditTotal, r.id';

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
        r.id AS receipt_id,
        p.date_time_of_payment as date,
        IFNULL(tp.total_paid_amount, 0) AS total_paid_amount,
        COALESCE(p.creditTotal, 0) AS credit_amount,
        COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0)  AS balance
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
    INNER JOIN 
    users as c ON c.id = t.cashier_id
    LEFT JOIN 
        TotalPaid AS tp ON tp.receipt_id = r.id
    WHERE 
        COALESCE(p.creditTotal, 0) != 0
        AND (COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0) ) != 0 AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate
    GROUP BY
        u.first_name, u.last_name, p.creditTotal, r.id';

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
        r.id AS receipt_id,
        p.date_time_of_payment as date,
        IFNULL(tp.total_paid_amount, 0) AS total_paid_amount,
        COALESCE(p.creditTotal, 0) AS credit_amount,
        COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0)  AS balance
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
    INNER JOIN 
    users as c ON c.id = t.cashier_id
    LEFT JOIN 
        TotalPaid AS tp ON tp.receipt_id = r.id
    WHERE 
        COALESCE(p.creditTotal, 0) != 0
        AND (COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0) ) != 0 AND t.user_id = :customerId AND DATE(p.date_time_of_payment) = :singleDateData
    GROUP BY
        u.first_name, u.last_name, p.creditTotal, r.id';

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
        r.id AS receipt_id,
        p.date_time_of_payment as date,
        IFNULL(tp.total_paid_amount, 0) AS total_paid_amount,
        COALESCE(p.creditTotal, 0) AS credit_amount,
        COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0)  AS balance
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
    INNER JOIN 
    users as c ON c.id = t.cashier_id
    LEFT JOIN 
        TotalPaid AS tp ON tp.receipt_id = r.id
    WHERE 
        COALESCE(p.creditTotal, 0) != 0
        AND (COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0) ) != 0 AND t.user_id = :customerId  AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate
    GROUP BY
        u.first_name, u.last_name, p.creditTotal, r.id';

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
        r.id AS receipt_id,
        p.date_time_of_payment as date,
        IFNULL(tp.total_paid_amount, 0) AS total_paid_amount,
        COALESCE(p.creditTotal, 0) AS credit_amount,
        COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0)  AS balance
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
    INNER JOIN 
    users as c ON c.id = t.cashier_id
    LEFT JOIN 
        TotalPaid AS tp ON tp.receipt_id = r.id
    WHERE 
        COALESCE(p.creditTotal, 0) != 0
        AND (COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0) ) != 0 AND t.cashier_id = :userId
    GROUP BY
        u.first_name, u.last_name, p.creditTotal, r.id';

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
        r.id AS receipt_id,
        p.date_time_of_payment as date,
        IFNULL(tp.total_paid_amount, 0) AS total_paid_amount,
        COALESCE(p.creditTotal, 0) AS credit_amount,
        COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0)  AS balance
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
    INNER JOIN 
    users as c ON c.id = t.cashier_id
    LEFT JOIN 
        TotalPaid AS tp ON tp.receipt_id = r.id
    WHERE 
        COALESCE(p.creditTotal, 0) != 0
        AND (COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0) ) != 0 AND t.cashier_id = :userId AND DATE(p.date_time_of_payment) = :singleDateData
    GROUP BY
        u.first_name, u.last_name, p.creditTotal, r.id';

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
        r.id AS receipt_id,
        p.date_time_of_payment as date,
        IFNULL(tp.total_paid_amount, 0) AS total_paid_amount,
        COALESCE(p.creditTotal, 0) AS credit_amount,
        COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0)  AS balance
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
    INNER JOIN 
    users as c ON c.id = t.cashier_id
    LEFT JOIN 
        TotalPaid AS tp ON tp.receipt_id = r.id
    WHERE 
        COALESCE(p.creditTotal, 0) != 0
        AND (COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0) ) != 0 AND t.cashier_id = :userId AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate
    GROUP BY
        u.first_name, u.last_name, p.creditTotal, r.id';

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
          r.id AS receipt_id,
          p.date_time_of_payment as date,
          IFNULL(tp.total_paid_amount, 0) AS total_paid_amount,
          COALESCE(p.creditTotal, 0) AS credit_amount,
          COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0)  AS balance
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
      INNER JOIN users as c ON c.id = t.cashier_id
      LEFT JOIN 
          TotalPaid AS tp ON tp.receipt_id = r.id
      WHERE 
          COALESCE(p.creditTotal, 0) != 0
          AND (COALESCE(p.creditTotal, 0) - IFNULL(tp.total_paid_amount, 0) ) != 0
      GROUP BY
          u.first_name, u.last_name, p.creditTotal, r.id;';
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
        t.receipt_id as receipt_id,
        u.first_name as first_name, 
        u.last_name as last_name, 
        d.name as discountType,
        d.discount_amount as rate,
        SUM(t.subtotal) as total,
        SUM(t.subtotal) * d.discount_amount / 100 as discountAmount,
        p.date_time_of_payment as date
    FROM 
        transactions as t
        INNER JOIN receipt as r ON r.id = t.receipt_id
        INNER JOIN users as u ON u.id = t.user_id 
        INNER JOIN discounts as d ON u.discount_id = d.id 
        INNER JOIN payments as p on p.id = t.payment_id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
        AND u.id = :customerId
    GROUP BY 
        t.receipt_id, u.first_name, u.last_name, d.name, d.discount_amount;';
    
          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':customerId',  $customerId);
          $sql->execute();
          return $sql;

    }else if(!$customerId && $discountType && !$singleDateData && !$startDate && !$endDate){
        $sql = 'SELECT 
        t.receipt_id as receipt_id,
        u.first_name as first_name, 
        u.last_name as last_name, 
        d.name as discountType,
        d.discount_amount as rate,
        SUM(t.subtotal) as total,
        SUM(t.subtotal) * d.discount_amount / 100 as discountAmount,
        p.date_time_of_payment as date
    FROM 
        transactions as t
        INNER JOIN receipt as r ON r.id = t.receipt_id
        INNER JOIN users as u ON u.id = t.user_id 
        INNER JOIN discounts as d ON u.discount_id = d.id 
        INNER JOIN payments as p on p.id = t.payment_id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
        AND d.id = :discountType
    GROUP BY 
        t.receipt_id, u.first_name, u.last_name, d.name, d.discount_amount;';
    
          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':discountType', $discountType);
          $sql->execute();
          return $sql;
    }else if(!$customerId && !$discountType && $singleDateData && !$startDate && !$endDate){
        $sql = 'SELECT 
        t.receipt_id as receipt_id,
        u.first_name as first_name, 
        u.last_name as last_name, 
        d.name as discountType,
        d.discount_amount as rate,
        SUM(t.subtotal) as total,
        SUM(t.subtotal) * d.discount_amount / 100 as discountAmount,
        p.date_time_of_payment as date
    FROM 
        transactions as t
        INNER JOIN receipt as r ON r.id = t.receipt_id
        INNER JOIN users as u ON u.id = t.user_id 
        INNER JOIN discounts as d ON u.discount_id = d.id 
        INNER JOIN payments as p on p.id = t.payment_id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
        AND DATE(p.date_time_of_payment) = :singleDateData
    GROUP BY 
        t.receipt_id, u.first_name, u.last_name, d.name, d.discount_amount;';
    
          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':singleDateData', $singleDateData);
          $sql->execute();
          return $sql;
    }else if(!$customerId && !$discountType && !$singleDateData && $startDate && $endDate){
        $sql = 'SELECT 
        t.receipt_id as receipt_id,
        u.first_name as first_name, 
        u.last_name as last_name, 
        d.name as discountType,
        d.discount_amount as rate,
        SUM(t.subtotal) as total,
        SUM(t.subtotal) * d.discount_amount / 100 as discountAmount,
        p.date_time_of_payment as date
    FROM 
        transactions as t
        INNER JOIN receipt as r ON r.id = t.receipt_id
        INNER JOIN users as u ON u.id = t.user_id 
        INNER JOIN discounts as d ON u.discount_id = d.id 
        INNER JOIN payments as p on p.id = t.payment_id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
        AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate
    GROUP BY 
        t.receipt_id, u.first_name, u.last_name, d.name, d.discount_amount;';
    
          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':startDate', $startDate);
          $sql->bindParam(':endDate', $endDate);
          $sql->execute();
          return $sql;
    }else if($customerId && $discountType && !$singleDateData && !$startDate && !$endDate){
        $sql = 'SELECT 
        t.receipt_id as receipt_id,
        u.first_name as first_name, 
        u.last_name as last_name, 
        d.name as discountType,
        d.discount_amount as rate,
        SUM(t.subtotal) as total,
        SUM(t.subtotal) * d.discount_amount / 100 as discountAmount,
        p.date_time_of_payment as date
    FROM 
        transactions as t
        INNER JOIN receipt as r ON r.id = t.receipt_id
        INNER JOIN users as u ON u.id = t.user_id 
        INNER JOIN discounts as d ON u.discount_id = d.id 
        INNER JOIN payments as p on p.id = t.payment_id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
        AND u.id = :customerId
        AND d.id = :discountType
    GROUP BY 
        t.receipt_id, u.first_name, u.last_name, d.name, d.discount_amount;';
    
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
        p.date_time_of_payment as date
    FROM 
        transactions as t
        INNER JOIN receipt as r ON r.id = t.receipt_id
        INNER JOIN users as u ON u.id = t.user_id 
        INNER JOIN discounts as d ON u.discount_id = d.id 
        INNER JOIN payments as p on p.id = t.payment_id
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
        t.receipt_id as receipt_id,
        u.first_name as first_name, 
        u.last_name as last_name, 
        d.name as discountType,
        d.discount_amount as rate,
        SUM(t.subtotal) as total,
        SUM(t.subtotal) * d.discount_amount / 100 as discountAmount,
        p.date_time_of_payment as date
    FROM 
        transactions as t
        INNER JOIN receipt as r ON r.id = t.receipt_id
        INNER JOIN users as u ON u.id = t.user_id 
        INNER JOIN discounts as d ON u.discount_id = d.id 
        INNER JOIN payments as p on p.id = t.payment_id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
        AND u.id = :customerId
        AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate
    GROUP BY 
        t.receipt_id, u.first_name, u.last_name, d.name, d.discount_amount;';
    
          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':customerId',  $customerId);
          $sql->bindParam(':startDate', $startDate);
          $sql->bindParam(':endDate', $endDate);
          $sql->execute();
          return $sql;
    }else if(!$customerId && $discountType && $singleDateData && !$startDate && !$endDate){
        $sql = 'SELECT 
        t.receipt_id as receipt_id,
        u.first_name as first_name, 
        u.last_name as last_name, 
        d.name as discountType,
        d.discount_amount as rate,
        SUM(t.subtotal) as total,
        SUM(t.subtotal) * d.discount_amount / 100 as discountAmount,
        p.date_time_of_payment as date
    FROM 
        transactions as t
        INNER JOIN receipt as r ON r.id = t.receipt_id
        INNER JOIN users as u ON u.id = t.user_id 
        INNER JOIN discounts as d ON u.discount_id = d.id 
        INNER JOIN payments as p on p.id = t.payment_id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
        AND d.id = :discountType
        AND DATE(p.date_time_of_payment) = :singleDateData
    GROUP BY 
        t.receipt_id, u.first_name, u.last_name, d.name, d.discount_amount;';
    
          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':discountType', $discountType);
          $sql->bindParam(':singleDateData', $singleDateData);
          $sql->execute();
          return $sql;
    }else if(!$customerId && $discountType && !$singleDateData && $startDate && $endDate){
        $sql = 'SELECT 
        t.receipt_id as receipt_id,
        u.first_name as first_name, 
        u.last_name as last_name, 
        d.name as discountType,
        d.discount_amount as rate,
        SUM(t.subtotal) as total,
        SUM(t.subtotal) * d.discount_amount / 100 as discountAmount,
        p.date_time_of_payment as date
    FROM 
        transactions as t
        INNER JOIN receipt as r ON r.id = t.receipt_id
        INNER JOIN users as u ON u.id = t.user_id 
        INNER JOIN discounts as d ON u.discount_id = d.id 
        INNER JOIN payments as p on p.id = t.payment_id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
        AND d.id = :discountType
        AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate
    GROUP BY 
        t.receipt_id, u.first_name, u.last_name, d.name, d.discount_amount;';
    
          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':discountType', $discountType);
          $sql->bindParam(':startDate', $startDate);
          $sql->bindParam(':endDate', $endDate);
          $sql->execute();
          return $sql;
    }else if($customerId && $discountType && $singleDateData && !$startDate && !$endDate){
        $sql = 'SELECT 
        t.receipt_id as receipt_id,
        u.first_name as first_name, 
        u.last_name as last_name, 
        d.name as discountType,
        d.discount_amount as rate,
        SUM(t.subtotal) as total,
        SUM(t.subtotal) * d.discount_amount / 100 as discountAmount,
        p.date_time_of_payment as date
    FROM 
        transactions as t
        INNER JOIN receipt as r ON r.id = t.receipt_id
        INNER JOIN users as u ON u.id = t.user_id 
        INNER JOIN discounts as d ON u.discount_id = d.id 
        INNER JOIN payments as p on p.id = t.payment_id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
        AND u.id = :customerId
        AND d.id = :discountType
        AND DATE(p.date_time_of_payment) = :singleDateData
    GROUP BY 
        t.receipt_id, u.first_name, u.last_name, d.name, d.discount_amount;';
    
          $sql = $this->connect()->prepare($sql);
          $sql->bindParam(':customerId',  $customerId);
          $sql->bindParam(':discountType', $discountType);
          $sql->bindParam(':singleDateData', $singleDateData);
          $sql->execute();
          return $sql;
    }else if($customerId && $discountType && !$singleDateData && $startDate && $endDate){
        $sql = 'SELECT 
        t.receipt_id as receipt_id,
        u.first_name as first_name, 
        u.last_name as last_name, 
        d.name as discountType,
        d.discount_amount as rate,
        SUM(t.subtotal) as total,
        SUM(t.subtotal) * d.discount_amount / 100 as discountAmount,
        p.date_time_of_payment as date
    FROM 
        transactions as t
        INNER JOIN receipt as r ON r.id = t.receipt_id
        INNER JOIN users as u ON u.id = t.user_id 
        INNER JOIN discounts as d ON u.discount_id = d.id 
        INNER JOIN payments as p on p.id = t.payment_id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
        AND u.id = :customerId
        AND d.id = :discountType
        AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate
    GROUP BY 
        t.receipt_id, u.first_name, u.last_name, d.name, d.discount_amount;';
    
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
        t.receipt_id as receipt_id,
        u.first_name as first_name, 
        u.last_name as last_name, 
        d.name as discountType,
        d.discount_amount as rate,
        SUM(t.subtotal) as total,
        SUM(t.subtotal) * d.discount_amount / 100 as discountAmount,
        p.date_time_of_payment as date
    FROM 
        transactions as t
        INNER JOIN receipt as r ON r.id = t.receipt_id
        INNER JOIN users as u ON u.id = t.user_id 
        INNER JOIN discounts as d ON u.discount_id = d.id 
        INNER JOIN payments as p on p.id = t.payment_id
    WHERE 
        t.is_paid = 1 
        AND t.is_void = 0 
        AND u.discount_id IS NOT NULL 
        AND d.id NOT IN (5) 
    GROUP BY 
        t.receipt_id, u.first_name, u.last_name, d.name, d.discount_amount;';

        $stmt = $this->connect()->query($sql);
        return $stmt;
    }
  }
  public function getDiscountPerItem($selectedProduct,$singleDateData,$startDate,$endDate){
    if($selectedProduct && !$singleDateData && !$startDate && !$endDate){
        $sql = 'SELECT t.id  as id,t.prod_desc as prod_desc,t.prod_price as prod_price,t.discount_amount as discount_amount,
        t.receipt_id as receipt_id, p.date_time_of_payment  as date, t.prod_qty as qty,t.subtotal as subtotal
        FROM `transactions`AS t
        INNER JOIN payments as p ON p.id = t.payment_id
        WHERE t.is_paid = 1 
        AND t.is_void = 0 
        AND t.discount_amount != 0
        AND t.prod_id = :selectedProduct;';
    
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedProduct',  $selectedProduct);
        $sql->execute();
        return $sql;
    }else if(!$selectedProduct && $singleDateData && !$startDate && !$endDate){
        $sql = 'SELECT t.id  as id,t.prod_desc as prod_desc,t.prod_price as prod_price,t.discount_amount as discount_amount,
        t.receipt_id as receipt_id, p.date_time_of_payment  as date, t.prod_qty as qty,t.subtotal as subtotal
        FROM `transactions`AS t
        INNER JOIN payments as p ON p.id = t.payment_id
        WHERE t.is_paid = 1 
        AND t.is_void = 0 
        AND t.discount_amount != 0
        AND DATE(p.date_time_of_payment) = :singleDateData';
    
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':singleDateData', $singleDateData);
        $sql->execute();
        return $sql;
    }else if(!$selectedProduct && !$singleDateData && $startDate && $endDate){
        $sql = 'SELECT t.id  as id,t.prod_desc as prod_desc,t.prod_price as prod_price,t.discount_amount as discount_amount,
        t.receipt_id as receipt_id, p.date_time_of_payment  as date, t.prod_qty as qty,t.subtotal as subtotal
        FROM `transactions`AS t
        INNER JOIN payments as p ON p.id = t.payment_id
        WHERE t.is_paid = 1 
        AND t.is_void = 0 
        AND t.discount_amount != 0
        AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate';
    
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':startDate', $startDate);
        $sql->bindParam(':endDate', $endDate);
        $sql->execute();
        return $sql;
    }else if($selectedProduct && $singleDateData && !$startDate && !$endDate){
        $sql = 'SELECT t.id  as id,t.prod_desc as prod_desc,t.prod_price as prod_price,t.discount_amount as discount_amount,
        t.receipt_id as receipt_id, p.date_time_of_payment  as date, t.prod_qty as qty,t.subtotal as subtotal
        FROM `transactions`AS t
        INNER JOIN payments as p ON p.id = t.payment_id
        WHERE t.is_paid = 1 
        AND t.is_void = 0 
        AND t.discount_amount != 0
        AND t.prod_id = :selectedProduct
        AND DATE(p.date_time_of_payment) = :singleDateData';
    
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedProduct',  $selectedProduct);
        $sql->bindParam(':singleDateData', $singleDateData);
        $sql->execute();
        return $sql;
    }else if($selectedProduct && !$singleDateData && $startDate && $endDate){
        $sql = 'SELECT t.id  as id,t.prod_desc as prod_desc,t.prod_price as prod_price,t.discount_amount as discount_amount,
        t.receipt_id as receipt_id, p.date_time_of_payment  as date, t.prod_qty as qty,t.subtotal as subtotal
        FROM `transactions`AS t
        INNER JOIN payments as p ON p.id = t.payment_id
        WHERE t.is_paid = 1 
        AND t.is_void = 0 
        AND t.discount_amount != 0
        AND t.prod_id = :selectedProduct
        AND DATE(p.date_time_of_payment) BETWEEN :startDate AND :endDate';
    
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedProduct',  $selectedProduct);
        $sql->bindParam(':startDate', $startDate);
        $sql->bindParam(':endDate', $endDate);
        $sql->execute();
        return $sql;
    }else{
    $sql = 'SELECT t.id  as id,t.prod_desc as prod_desc,t.prod_price as prod_price,t.discount_amount as discount_amount,
    t.receipt_id as receipt_id, p.date_time_of_payment  as date, t.prod_qty as qty,t.subtotal as subtotal
    FROM `transactions`AS t
    INNER JOIN payments as p ON p.id = t.payment_id
    WHERE t.is_paid = 1  AND t.is_void = 0 AND t.discount_amount != 0;';

    $stmt = $this->connect()->query($sql);
    return $stmt;
    }
}
public function getPaymentMethod($selectedMethod,$singleDateData,$startDate,$endDate){
    if($selectedMethod && !$singleDateData && !$startDate && !$endDate){
        $sql = "SELECT 
        jt.paymentType AS paymentType,
        jt.amount AS amount,
        t.receipt_id AS receipt_id,
        payments.date_time_of_payment AS date,
        CASE
            WHEN jt.paymentType = 'credit' THEN 
                CASE
                    WHEN jt.amount - COALESCE(pc.total_paid_amount, 0) != 0 THEN jt.amount - COALESCE(pc.total_paid_amount, 0)
                    ELSE NULL
                END
            ELSE jt.amount
        END AS adjusted_amount
    FROM 
        payments
    CROSS JOIN JSON_TABLE(
        payments.payment_details,
        '$[*]'
        COLUMNS (
            paymentType VARCHAR(255) PATH '$.paymentType',
            amount DECIMAL(10, 2) PATH '$.amount'
        )
    ) AS jt
    INNER JOIN (
        SELECT DISTINCT payment_id, receipt_id
        FROM transactions
    ) AS t ON payments.id = t.payment_id
    LEFT JOIN (
        SELECT receipt_id, SUM(paid_amount) AS total_paid_amount
        FROM paid_credits
        GROUP BY receipt_id
    ) AS pc ON t.receipt_id = pc.receipt_id
    WHERE 
        JSON_VALID(payments.payment_details)
        AND jt.amount != 0.00
        AND (jt.paymentType != 'credit' OR (jt.paymentType = 'credit' AND jt.amount - COALESCE(pc.total_paid_amount, 0) != 0))
        AND  jt.paymentType = :selectedMethod";
    
        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':selectedMethod',  $selectedMethod);
        $sql->execute();
        return $sql;
    }else{
    $sql = "SELECT 
    jt.paymentType AS paymentType,
    jt.amount AS amount,
    t.receipt_id AS receipt_id,
    payments.date_time_of_payment AS date,
    CASE
        WHEN jt.paymentType = 'credit' THEN 
            CASE
                WHEN jt.amount - COALESCE(pc.total_paid_amount, 0) != 0 THEN jt.amount - COALESCE(pc.total_paid_amount, 0)
                ELSE NULL
            END
        ELSE jt.amount
    END AS adjusted_amount
FROM 
    payments
CROSS JOIN JSON_TABLE(
    payments.payment_details,
    '$[*]'
    COLUMNS (
        paymentType VARCHAR(255) PATH '$.paymentType',
        amount DECIMAL(10, 2) PATH '$.amount'
    )
) AS jt
INNER JOIN (
    SELECT DISTINCT payment_id, receipt_id
    FROM transactions
) AS t ON payments.id = t.payment_id
LEFT JOIN (
    SELECT receipt_id, SUM(paid_amount) AS total_paid_amount
    FROM paid_credits
    GROUP BY receipt_id
) AS pc ON t.receipt_id = pc.receipt_id
WHERE 
    JSON_VALID(payments.payment_details)
    AND jt.amount != 0.00
    AND (jt.paymentType != 'credit' OR (jt.paymentType = 'credit' AND jt.amount - COALESCE(pc.total_paid_amount, 0) != 0))";

    $stmt = $this->connect()->query($sql);
    return $stmt;
}
}
}