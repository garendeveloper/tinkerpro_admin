<?php

  class ProductFacade extends DBConnection {

    public function fetchProducts() {
      $sql = $this->connect()->prepare("SELECT * FROM products");
      $sql->execute();
      return $sql;
    }

    public function addProduct($barcode, $prodDesc, $stocks, $cost, $markup, $prodPrice) {
      $sql = $this->connect()->prepare("INSERT INTO products(barcode, prod_desc, stocks, cost, markup, prod_price) VALUES (?, ?, ?, ?, ?, ?)");
      $sql->execute([$barcode, $prodDesc, $stocks, $cost, $markup, $prodPrice]);
      return $sql;
    }

    public function updateProduct($barcode, $prodDesc, $stocks, $cost, $markup, $prodPrice) {
      $sql = $this->connect()->prepare("UPDATE products SET barcode = '$barcode', prod_desc = '$prodDesc', stocks = '$stocks', cost = '$cost', markup = '$markup', prod_price = '$prodPrice'");
      $sql->execute();
      return $sql;
    }

    public function deleteProduct($productId) {
      $sql = $this->connect()->prepare("DELETE FROM products WHERE id = $productId");
      $sql->execute();
      return $sql;
    }

  }

?>