<?php

  class ProductFacade extends DBConnection {

    public function fetchProducts() {
      $sql = $this->connect()->prepare("SELECT products.barcode as barcode, products.prod_desc as prod_desc, products.cost as cost,
      products.markup as markup, products.prod_price as prod_price, products.isVAT as isVAT, products.Description as Description, products.sku as sku,
      products.code as code, uom.uom_name as uom_name,products.category_details as category_details, products.status as status, products.brand as brand  FROM products INNER JOIN uom on uom.id = products.uom_id");
      $sql->execute();
      return $sql;
    }

    public function addProduct($formData) {
      $productname = $formData['productname'];
      $barcode = $formData['barcode'];
      $brand = $formData['brand'];
      $code= $formData['code'];
      $cost = $formData['cost'];
      $description = $formData['description'];
      $discount = $formData['discount'];
      $display_other_charges = $formData['display_other_charges'];
      $display_service_charge = $formData['display_service_charge'];
      $display_tax = $formData['display_tax'];
      $markup = $formData['markup'];
      $other_charges = $formData['other_charges'];
      $oum_id = $formData['oum_id'];
      $sellingPrice = $formData['sellingPrice'];
      $service_charge = $formData['service_charge'];
      $sku = $formData['sku'];
      $status = $formData['status'];
      $vat = $formData['vat'];
      $uploadedFile = $_FILES['uploadedImage'] ?? null;
  
      if ($uploadedFile !== null && $uploadedFile['error'] === UPLOAD_ERR_OK) {
          $tempPath = $uploadedFile['tmp_name'];
          $fileName = $uploadedFile['name'];
  
          $destination = './assets/products/' . $fileName;
          move_uploaded_file($tempPath, $destination);
      } else {
          $fileName = null;
      }
  
      $sql = 'INSERT INTO products(barcode, prod_desc, cost, markup, prod_price, isVAT, Description, sku, code, uom_id, is_discounted, is_taxIncluded, is_serviceCharge, is_otherCharges, is_srvcChrgeDisplay, is_othrChargeDisplay, status, productImage, brand) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$barcode, $productname, $cost, $markup, $sellingPrice, $vat, $description, $sku, $code, $oum_id, $discount, $display_tax, $service_charge, $other_charges, $display_service_charge, $display_other_charges, $status, $fileName, $brand]);
  
      return ['success' => true, 'message' => 'Product added successfully'];
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
  
  $category_formatted = ucwords(strtolower($categoryname));


  $sql_check = $this->connect()->prepare("SELECT category_name FROM category WHERE category_name LIKE :categoryname");
  $sql_check->bindParam(':categoryname', $category_formatted);
  $sql_check->execute();
  $existing_categories = $sql_check->fetchAll(PDO::FETCH_COLUMN);

  
  $original_category = $category_formatted;
  $count = 0;
  while (in_array($category_formatted, $existing_categories)) {
      $category_formatted = $original_category . ++$count;
  }

 
  $sql_update = $this->connect()->prepare("UPDATE category SET category_name = :categoryname WHERE id = :categoryid");
  $sql_update->bindParam(':categoryname', $category_formatted);
  $sql_update->bindParam(':categoryid', $categoryid);
  $sql_update->execute();
  return $sql_update;
}

public function addVariants($categoryid, $variantName) {
  $sql = $this->connect()->prepare("SELECT variant_name FROM variants WHERE category_id = ?");
  $sql->execute([$categoryid]);
  $existingVariants = $sql->fetchAll(PDO::FETCH_COLUMN);

  
  $variantName = ucfirst(strtolower($variantName));

  $newVariantName = $variantName;
  $counter = 1;
  while (in_array($newVariantName, $existingVariants)) {
      $newVariantName = $variantName . $counter;
      $counter++;
  }

  
  $sql = $this->connect()->prepare("INSERT INTO variants(category_id, variant_name) VALUES (?, ?)");
  $sql->execute([$categoryid, $newVariantName]);

  return $sql;
}
public function checkSku($sku,$barcode,$code) {
  if($sku){
  $sql = "SELECT COUNT(*) FROM products WHERE sku = :sku";
  $stmt = $this->connect()->prepare($sql);
  $stmt->execute([':sku' => $sku]);
  $result = $stmt->fetchColumn();

  if ($result > 0) {
      return true;
  } else {
      return false;
  }
}
if($barcode){
  $sql = "SELECT COUNT(*) FROM products WHERE barcode = :barcode";
  $stmt = $this->connect()->prepare($sql);
  $stmt->execute([':barcode' => $barcode]);
  $result = $stmt->fetchColumn();

  if ($result > 0) {
      return true;
  } else {
      return false;
  }
}
if($code){
  $sql = "SELECT COUNT(*) FROM products WHERE code = :code";
  $stmt = $this->connect()->prepare($sql);
  $stmt->execute([':code' => $code]);
  $result = $stmt->fetchColumn();

  if ($result > 0) {
      return true;
  } else {
      return false;
  }
}
}


}  


?>