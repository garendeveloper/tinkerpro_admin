<?php

  class IngredientsFacade extends DBConnection {

   public function checkBarcode($barcode){
    if($barcode){
        $sql = "SELECT COUNT(*) FROM ingredients WHERE barcode = :barcode";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':barcode' => $barcode]);
        $result = $stmt->fetchColumn();
      
        if ($result > 0) {
            return true;
        } else {
            return false;
        }
      }
   }
   public function addIngredient($ingredientName, $barcode, $uom_id, $cost, $status, $description) {
    $uom_id = ($uom_id == 0) ? null : $uom_id;

    $sql = 'INSERT INTO ingredients(name,barcode, uom_id, cost, status,  description) VALUES (?, ?, ?, ?, ?, ?)';
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$ingredientName, $barcode, $uom_id, $cost, $status, $description]);

    return ['success' => true, 'message' => 'Ingredient added successfully'];
}

 public function ingredients(){
  $sql = $this->connect()->prepare("SELECT * FROM ingredients ORDER BY name ASC");
  $sql->execute();
  return $sql;
 }

 public function getBom($productid) {
  $sql = 'SELECT  bom.id as id, bom.uom_id as uom_id,  bom.prod_id as prod_id, ingredients.name 
  as ingredientsname, bom.ingredients_id as ingredientId, uom.uom_name as oumTypes ,bom.qty as ingredientsQty
  FROM bill_of_materials as bom 
  INNER JOIN uom ON uom.id = bom.uom_id 
  INNER JOIN ingredients ON ingredients.id = bom.ingredients_id 
  WHERE prod_id = ?';
  
  $stmt = $this->connect()->prepare($sql);
  $stmt->execute([$productid]);
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  return $result;
}


  }