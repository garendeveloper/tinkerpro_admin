<?php

  class WithdrawFacade extends DBConnection {

    public function fetchWithdraws() {
      $sql = $this->connect()->prepare("SELECT * FROM withdraw");
      $sql->execute();
      return $sql;
    }

    public function fetchWithdrawsTotal() {
      $sql = $this->connect()->prepare("SELECT SUM(amount) as withdraw FROM withdraw");
      $sql->execute();

      while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $result = $row["withdraw"];
        return $result;
      }
    }

    public function settleWithdraw($withdrawId) {
      $sql = $this->connect()->prepare("DELETE FROM withdraw WHERE id = $withdrawId");
      $sql->execute();
      return $sql;
    }

  }

?>