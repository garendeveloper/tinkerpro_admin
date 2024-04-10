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


  }