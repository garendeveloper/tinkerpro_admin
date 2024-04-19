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
        r.refunded_qty as qty, r.reference_num as reference_num, r.refunded_amt as amount, r.date as date, r.refunded_method_id as method,
        ( SELECT t.receipt_id FROM transactions AS t WHERE t.payment_id = p.id LIMIT 1 ) AS receipt_id FROM refunded AS r
         INNER JOIN payments AS p ON r.payment_id = p.id 
         INNER JOIN products ON r.prod_id = products.id WHERE r.date = :singleDateData';

        $sql = $this->connect()->prepare($sql);
        $sql->bindParam(':singleDateData', $singleDateData);
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

  }