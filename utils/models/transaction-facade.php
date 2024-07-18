<?php

  class TransactionFacade extends DBConnection {

    public function fetchTransactions() {
      $sql = $this->connect()->prepare("SELECT * FROM transactions WHERE transact_type = '0' AND is_transact = '1'");
      $sql->execute();
      return $sql;
    }

    public function fetchTransactionsTransactionNum($transactionNum) {
      $sql = $this->connect()->prepare("SELECT * FROM transactions WHERE transaction_num = '$transactionNum'");
      $sql->execute();
      return $sql;
    }

    public function fetchPayLater() {
      $sql = $this->connect()->prepare("SELECT DISTINCT transaction_num, is_paid, payer FROM transactions WHERE transact_type = '1'");
      $sql->execute();
      return $sql;
    }

    public function sumTotal($transactionNum) {
      $sql = $this->connect()->prepare("SELECT SUM(subtotal) as subtotal FROM transactions WHERE is_transact = '1' AND transaction_num = '$transactionNum'");
      $sql->execute();

      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $result = $row["subtotal"];
        return $result;
      }
    }

    // public function fetchPayLater() {
    //   $sql = $this->connect()->prepare("SELECT * FROM transactions WHERE transact_type = '1' AND is_transact = '1'");
    //   $sql->execute();
    //   return $sql;
    // }

    public function fetchProductSales() {
      $sql = $this->connect()->prepare("SELECT SUM(subtotal) as subtotal FROM transactions WHERE is_transact = '1' AND is_paid = '1'");
      $sql->execute();

      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $result = $row["subtotal"];
        return $result;
      }
    }

    public function fetchMarkupSales() {
      $sql = $this->connect()->prepare("SELECT SUM(sales) as sales FROM transactions WHERE is_transact = '1' AND is_paid = '1'");
      $sql->execute();

      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $result = $row["sales"];
        return $result;
      }
    }

    public function fetchProductsSold() {
      $sql = $this->connect()->prepare("SELECT SUM(prod_qty) as prod_qty FROM transactions WHERE is_transact = '1' AND is_paid = '1'");
      $sql->execute();

      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $result = $row["prod_qty"];
        return $result;
      }
    }

    public function yearlySales($yearlyDate) {
      $sql = $this->connect()->prepare("SELECT SUM(sales) as sales FROM transactions WHERE YEAR(date) = '$yearlyDate'");
      $sql->execute();

      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $result = $row["sales"];
        return $result;
      }
    }

    public function janProductSales($yearlyDate) {
      $sql = $this->connect()->prepare("SELECT SUM(subtotal) as subtotal FROM transactions WHERE MONTH(date) = '01' AND YEAR(date) = '$yearlyDate' AND is_transact = '1'");
      $sql->execute();

      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $result = $row["subtotal"];
        return $result;
      }
    }

    public function febProductSales($yearlyDate) {
      $sql = $this->connect()->prepare("SELECT SUM(subtotal) as subtotal FROM transactions WHERE MONTH(date) = '02' AND YEAR(date) = '$yearlyDate' AND is_transact = '1'");
      $sql->execute();

      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $result = $row["subtotal"];
        return $result;
      }
    }

    public function marProductSales($yearlyDate) {
      $sql = $this->connect()->prepare("SELECT SUM(subtotal) as subtotal FROM transactions WHERE MONTH(date) = '03' AND YEAR(date) = '$yearlyDate' AND is_transact = '1'");
      $sql->execute();

      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $result = $row["subtotal"];
        return $result;
      }
    }

    public function aprProductSales($yearlyDate) {
      $sql = $this->connect()->prepare("SELECT SUM(subtotal) as subtotal FROM transactions WHERE MONTH(date) = '04' AND YEAR(date) = '$yearlyDate' AND is_transact = '1'");
      $sql->execute();

      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $result = $row["subtotal"];
        return $result;
      }
    }

    public function mayProductSales($yearlyDate) {
      $sql = $this->connect()->prepare("SELECT SUM(subtotal) as subtotal FROM transactions WHERE MONTH(date) = '05' AND YEAR(date) = '$yearlyDate' AND is_transact = '1'");
      $sql->execute();

      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $result = $row["subtotal"];
        return $result;
      }
    }

    public function junProductSales($yearlyDate) {
      $sql = $this->connect()->prepare("SELECT SUM(subtotal) as subtotal FROM transactions WHERE MONTH(date) = '06' AND YEAR(date) = '$yearlyDate' AND is_transact = '1'");
      $sql->execute();

      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $result = $row["subtotal"];
        return $result;
      }
    }

    public function julProductSales($yearlyDate) {
      $sql = $this->connect()->prepare("SELECT SUM(subtotal) as subtotal FROM transactions WHERE MONTH(date) = '07' AND YEAR(date) = '$yearlyDate' AND is_transact = '1'");
      $sql->execute();

      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $result = $row["subtotal"];
        return $result;
      }
    }

    public function augProductSales($yearlyDate) {
      $sql = $this->connect()->prepare("SELECT SUM(subtotal) as subtotal FROM transactions WHERE MONTH(date) = '08' AND YEAR(date) = '$yearlyDate' AND is_transact = '1'");
      $sql->execute();

      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $result = $row["subtotal"];
        return $result;
      }
    }

    public function sepProductSales($yearlyDate) {
      $sql = $this->connect()->prepare("SELECT SUM(subtotal) as subtotal FROM transactions WHERE MONTH(date) = '09' AND YEAR(date) = '$yearlyDate' AND is_transact = '1'");
      $sql->execute();

      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $result = $row["subtotal"];
        return $result;
      }
    }

    public function octProductSales($yearlyDate) {
      $sql = $this->connect()->prepare("SELECT SUM(subtotal) as subtotal FROM transactions WHERE MONTH(date) = '10' AND YEAR(date) = '$yearlyDate' AND is_transact = '1'");
      $sql->execute();

      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $result = $row["subtotal"];
        return $result;
      }
    }

    public function novProductSales($yearlyDate) {
      $sql = $this->connect()->prepare("SELECT SUM(subtotal) as subtotal FROM transactions WHERE MONTH(date) = '11' AND YEAR(date) = '$yearlyDate' AND is_transact = '1'");
      $sql->execute();

      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $result = $row["subtotal"];
        return $result;
      }
    }

    public function decProductSales($yearlyDate) {
      $sql = $this->connect()->prepare("SELECT SUM(subtotal) as subtotal FROM transactions WHERE MONTH(date) = '12' AND YEAR(date) = '$yearlyDate' AND is_transact = '1'");
      $sql->execute();

      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $result = $row["subtotal"];
        return $result;
      }
    }

    public function pay($transactionNum) {
      $sql = $this->connect()->prepare("UPDATE transactions SET is_paid = 1 WHERE transaction_num = $transactionNum");
      $sql->execute();
      return $sql;
    }

  }

?>