<?php

  class ShopFacade extends DBConnection {

    public function fetchShop() {
      $sql = $this->connect()->prepare("SELECT * FROM shop");
      $sql->execute();
      return $sql;
    }

    public function updateShop($shopName, $shopAddress, $contactNumber) {
      $sql = $this->connect()->prepare("UPDATE shop SET shop_name = '$shopName', shop_address = '$shopAddress', contact_number = '$contactNumber'");
      $sql->execute();
      return $sql;
    }

  }

?>