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
    public function getUOM(){
      $sql = $this->connect()->prepare("SELECT * FROM uom");
      $sql->execute();
      return $sql;
    }
    public function latestSKU() {
      $query = "SELECT MAX(sku) AS latest_sku FROM products";
      $statement = $this->connect()->prepare($query);
      $statement->execute();
      $result = $statement->fetch(PDO::FETCH_ASSOC);
  
      $latestSKU = $result['latest_sku'];
  
      if ($latestSKU === null) {
          $nextSKU = 1;
      } else {
          $nextSKU = $latestSKU + 1;
      }
  
     
      return $nextSKU;
  }
  public function getCategories(){
    $query = "SELECT * FROM category";
    $category = $this->connect()->prepare($query);
    $category->execute();
    return $category;
  }

  public function getVariants($catID){
    $query = "SELECT * FROM variants WHERE category_id = :category_id";
    $variants = $this->connect()->prepare($query);
    $variants->bindParam(':category_id', $catID);
    $variants->execute();

    return $variants->fetchAll(PDO::FETCH_ASSOC);
}

 public function addCategory($category){
  $sql = $this->connect()->prepare("INSERT INTO category(category_name) VALUES (?)");
  $sql->execute([$category]);
  return $sql;
 } 
  }  


?>