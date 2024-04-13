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
public function deleteBOM($id){
  $sql = "DELETE FROM bill_of_materials WHERE id = :id ";
  $stmt = $this->connect()->prepare($sql);
  $stmt->execute([':id' => $id]);
  $rowCount = $stmt->rowCount();
  return $rowCount > 0; 
}
public function getAllIngredients($searchQuery) {
  $sqlQuery = "SELECT i.id as id, i.name as name, i.barcode as barcode, i.cost as cost, i.status as status, i.description as description, i.uom_id as uom_id, uom.uom_name as uom_name FROM ingredients AS i INNER JOIN uom ON uom.id = i.uom_id ";

  if (!empty($searchQuery)) {
      $sqlQuery .= " WHERE 
          i.name LIKE :searchQuery OR 
          i.barcode LIKE :searchQuery OR 
          i.status LIKE :searchQuery";
  }

  $sql = $this->connect()->prepare($sqlQuery);

  if (!empty($searchQuery)) {
      $searchParam = "%" . $searchQuery . "%";
      $sql->bindParam(':searchQuery', $searchParam, PDO::PARAM_STR);
  }

  $sql->execute();
  return $sql;
}

public function updateIngrednts($ingredientName, $barcode,$uom_id,$cost,$status,$description,$id){
  $uom_id = ($uom_id == 0) ? null : $uom_id;

  $sql = 'UPDATE ingredients SET 
  name = ?,
  uom_id = ?,
  barcode = ?,
  cost = ?,
  status = ?,
  description = ?
  WHERE id = ?';
  $stmt = $this->connect()->prepare($sql);
  $stmt->execute([$ingredientName, $uom_id, $barcode,  $cost, $status, $description, $id]);

  return ['success' => true, 'id' => $status];

}


  }