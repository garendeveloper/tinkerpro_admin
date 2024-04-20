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

  }