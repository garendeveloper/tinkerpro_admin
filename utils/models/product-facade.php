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
    $query = "SELECT * FROM category ORDER BY CASE 
               WHEN category_name REGEXP '^[0-9]' THEN 1 
               WHEN category_name REGEXP '^[A-Za-z]' THEN 2 
               ELSE 3 END, category_name";
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

//  public function addCategory($category){
//   $sql = $this->connect()->prepare("INSERT INTO category(category_name) VALUES (?)");
//   $sql->execute([$category]);
//   return $sql;
//  } 
public function addCategory($category){
  
  $category_lowercase = strtolower($category);
  $category_formatted = ucwords(strtolower($category));

  $sql_check = $this->connect()->prepare("SELECT category_name FROM category");
  $sql_check->execute();
  $existing_categories = $sql_check->fetchAll(PDO::FETCH_COLUMN);

  $original_category = $category_formatted;
  $count = 1;
  while (in_array(strtolower($category_formatted), array_map('strtolower', $existing_categories))) {
      $category_formatted = $original_category . $count++;
  }


  $sql = $this->connect()->prepare("INSERT INTO category(category_name) VALUES (?)");
  $sql->execute([$category_formatted]);
  return $sql;
}

public function updateCategory($categoryname, $categoryid) {
  // Format the category name with the first letter capitalized and the rest lowercase
  $category_formatted = ucwords(strtolower($categoryname));

  // Check if the category name already exists
  $sql_check = $this->connect()->prepare("SELECT category_name FROM category WHERE category_name LIKE :categoryname");
  $sql_check->bindParam(':categoryname', $category_formatted);
  $sql_check->execute();
  $existing_categories = $sql_check->fetchAll(PDO::FETCH_COLUMN);

  // If the category name already exists, append a number to make it unique
  $original_category = $category_formatted;
  $count = 0;
  while (in_array($category_formatted, $existing_categories)) {
      $category_formatted = $original_category . ++$count;
  }

  // Update the category name in the database
  $sql_update = $this->connect()->prepare("UPDATE category SET category_name = :categoryname WHERE id = :categoryid");
  $sql_update->bindParam(':categoryname', $category_formatted);
  $sql_update->bindParam(':categoryid', $categoryid);
  $sql_update->execute();
  return $sql_update;
}

}  


?>