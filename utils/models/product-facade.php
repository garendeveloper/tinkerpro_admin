<?php

  class ProductFacade extends DBConnection {

    public function fetchProducts($searchQuery,$selectedProduct,$singleDateData,$startDate,$endDate,$selectedCategories,$selectedSubCategories, $offset, $recordsPerPage) {
    
      if (!empty($searchQuery)) {
        $sqlQuery = "SELECT 
        products.id as id, 
        products.barcode as barcode, 
        products.prod_desc as prod_desc, 
        products.cost as cost,
        products.markup as markup, 
        products.prod_price as prod_price, 
        products.isVAT as isVAT, 
        products.Description as description, 
        products.sku as sku,
        products.code as code, 
        uom.uom_name as uom_name,
        products.category_id as category_id, 
        products.status as status, 
        products.brand as brand,
        products.uom_id as uom_id, 
        products.is_discounted as discounted, 
        products.is_taxIncluded as taxIncluded, 
        products.is_serviceCharge as serviceCharge, 
        products.is_srvcChrgeDisplay as displayService, 
        products.is_otherCharges as otherCharges, 
        products.is_othrChargeDisplay as displayOthers,
        products.productImage as image, 
        products.category_details as category_details, 
        products.category_id as category_id,
        products.variant_id as variant_id,
        products.is_BOM as is_BOM,
        products.is_warranty as is_warranty,
        products.is_stockable as is_stockable,
        products.stock_status as stock_status,
        products.stock_count as stock_count,
        products.product_stock as product_stock,
        products.isSCEnabled as isSC,
        products.isPWDEnabled as isPWD,
        products.isNAACEnabled as isNAAC,
        products.isSPEnabled as isSP,
         products.isMOVEnabled as isMOV
    FROM products 
    LEFT JOIN uom ON uom.id = products.uom_id WHERE 
        products.prod_desc LIKE :searchQuery OR 
        products.barcode LIKE :searchQuery OR 
        products.sku LIKE :searchQuery OR 
        products.code LIKE :searchQuery OR 
        products.brand LIKE :searchQuery ORDER BY prod_desc ASC LIMIT  10";

        $sql = $this->connect()->prepare($sqlQuery);

        if (!empty($searchQuery)) {
          $searchParam = "%".$searchQuery . "%";
          $sql->bindParam(':searchQuery', $searchParam, PDO::PARAM_STR);
          $sql->execute();
          return $sql;
      }
      
      }else if($selectedProduct && !$singleDateData && !$startDate && !$endDate && !$selectedCategories && !$selectedSubCategories){
        $sqlQuery = "SELECT 
        products.id as id, 
        products.barcode as barcode, 
        products.prod_desc as prod_desc, 
        products.cost as cost,
        products.markup as markup, 
        products.prod_price as prod_price, 
        products.isVAT as isVAT, 
        products.Description as description, 
        products.sku as sku,
        products.code as code, 
        uom.uom_name as uom_name,
        products.category_id as category_id, 
        products.status as status, 
        products.brand as brand,
        products.uom_id as uom_id, 
        products.is_discounted as discounted, 
        products.is_taxIncluded as taxIncluded, 
        products.is_serviceCharge as serviceCharge, 
        products.is_srvcChrgeDisplay as displayService, 
        products.is_otherCharges as otherCharges, 
        products.is_othrChargeDisplay as displayOthers,
        products.productImage as image, 
        products.category_details as category_details, 
        products.category_id as category_id,
        products.variant_id as variant_id,
        products.is_BOM as is_BOM,
        products.is_warranty as is_warranty,
        products.is_stockable as is_stockable,
        products.stock_status as stock_status,
        products.stock_count as stock_count,
        products.product_stock as product_stock,
        products.isSCEnabled as isSC,
        products.isPWDEnabled as isPWD,
        products.isNAACEnabled as isNAAC,
        products.isSPEnabled as isSP,
         products.isMOVEnabled as isMOV
    FROM products 
    LEFT JOIN uom ON uom.id = products.uom_id WHERE 
        products.id = :selectedProduct ORDER BY prod_desc ASC LIMIT  $offset, $recordsPerPage";

        $sql = $this->connect()->prepare($sqlQuery);
        $sql->bindParam(':selectedProduct', $selectedProduct);
        $sql->execute();
        return $sql;

      }else if(!$selectedProduct && !$singleDateData && !$startDate && !$endDate && $selectedCategories && !$selectedSubCategories){
        $sqlQuery = "SELECT 
        products.id as id, 
        products.barcode as barcode, 
        products.prod_desc as prod_desc, 
        products.cost as cost,
        products.markup as markup, 
        products.prod_price as prod_price, 
        products.isVAT as isVAT, 
        products.Description as description, 
        products.sku as sku,
        products.code as code, 
        uom.uom_name as uom_name,
        products.category_id as category_id, 
        products.status as status, 
        products.brand as brand,
        products.uom_id as uom_id, 
        products.is_discounted as discounted, 
        products.is_taxIncluded as taxIncluded, 
        products.is_serviceCharge as serviceCharge, 
        products.is_srvcChrgeDisplay as displayService, 
        products.is_otherCharges as otherCharges, 
        products.is_othrChargeDisplay as displayOthers,
        products.productImage as image, 
        products.category_details as category_details, 
        products.category_id as category_id,
        products.variant_id as variant_id,
        products.is_BOM as is_BOM,
        products.is_warranty as is_warranty,
        products.is_stockable as is_stockable,
        products.stock_status as stock_status,
        products.stock_count as stock_count,
        products.product_stock as product_stock,
        products.isSCEnabled as isSC,
        products.isPWDEnabled as isPWD,
        products.isNAACEnabled as isNAAC,
        products.isSPEnabled as isSP,
         products.isMOVEnabled as isMOV
    FROM products 
    LEFT JOIN uom ON uom.id = products.uom_id WHERE 
        products.category_id= :selectedCategoryProduct ORDER BY prod_desc ASC LIMIT  $offset, $recordsPerPage";

        $sql = $this->connect()->prepare($sqlQuery);
        $sql->bindParam(':selectedCategoryProduct', $selectedCategories);
        $sql->execute();
        return $sql;
      }else if(!$selectedProduct && !$singleDateData && !$startDate && !$endDate && !$selectedCategories && $selectedSubCategories){
        $sqlQuery = "SELECT 
        products.id as id, 
        products.barcode as barcode, 
        products.prod_desc as prod_desc, 
        products.cost as cost,
        products.markup as markup, 
        products.prod_price as prod_price, 
        products.isVAT as isVAT, 
        products.Description as description, 
        products.sku as sku,
        products.code as code, 
        uom.uom_name as uom_name,
        products.category_id as category_id, 
        products.status as status, 
        products.brand as brand,
        products.uom_id as uom_id, 
        products.is_discounted as discounted, 
        products.is_taxIncluded as taxIncluded, 
        products.is_serviceCharge as serviceCharge, 
        products.is_srvcChrgeDisplay as displayService, 
        products.is_otherCharges as otherCharges, 
        products.is_othrChargeDisplay as displayOthers,
        products.productImage as image, 
        products.category_details as category_details, 
        products.category_id as category_id,
        products.variant_id as variant_id,
        products.is_BOM as is_BOM,
        products.is_warranty as is_warranty,
        products.is_stockable as is_stockable,
        products.stock_status as stock_status,
         products.stock_count as stock_count,
        products.product_stock as product_stock,
        products.isSCEnabled as isSC,
        products.isPWDEnabled as isPWD,
        products.isNAACEnabled as isNAAC,
        products.isSPEnabled as isSP,
         products.isMOVEnabled as isMOV
    FROM products 
    LEFT JOIN uom ON uom.id = products.uom_id WHERE 
        products.variant_id= :selectedVariantroduct ORDER BY prod_desc ASC LIMIT  $offset, $recordsPerPage";

        $sql = $this->connect()->prepare($sqlQuery);
        $sql->bindParam(':selectedVariantroduct', $selectedSubCategories);
        $sql->execute();
        return $sql;
      }else if($selectedProduct && !$singleDateData && !$startDate && !$endDate && $selectedCategories && !$selectedSubCategories){
        $sqlQuery = "SELECT 
        products.id as id, 
        products.barcode as barcode, 
        products.prod_desc as prod_desc, 
        products.cost as cost,
        products.markup as markup, 
        products.prod_price as prod_price, 
        products.isVAT as isVAT, 
        products.Description as description, 
        products.sku as sku,
        products.code as code, 
        uom.uom_name as uom_name,
        products.category_id as category_id, 
        products.status as status, 
        products.brand as brand,
        products.uom_id as uom_id, 
        products.is_discounted as discounted, 
        products.is_taxIncluded as taxIncluded, 
        products.is_serviceCharge as serviceCharge, 
        products.is_srvcChrgeDisplay as displayService, 
        products.is_otherCharges as otherCharges, 
        products.is_othrChargeDisplay as displayOthers,
        products.productImage as image, 
        products.category_details as category_details, 
        products.category_id as category_id,
        products.variant_id as variant_id,
        products.is_BOM as is_BOM,
        products.is_warranty as is_warranty,
        products.is_stockable as is_stockable,
        products.stock_status as stock_status,
        products.stock_count as stock_count,
        products.product_stock as product_stock,
        products.isSCEnabled as isSC,
        products.isPWDEnabled as isPWD,
        products.isNAACEnabled as isNAAC,
        products.isSPEnabled as isSP,
         products.isMOVEnabled as isMOV
    FROM products 
    LEFT JOIN uom ON uom.id = products.uom_id WHERE 
        products.id= :selectedProduct AND products.category_id = :selectedCategoryProduct ORDER BY prod_desc ASC LIMIT  $offset, $recordsPerPage";

        $sql = $this->connect()->prepare($sqlQuery);
        $sql->bindParam(':selectedProduct', $selectedProduct);
        $sql->bindParam(':selectedCategoryProduct', $selectedCategories);
        $sql->execute();
        return $sql;
      }else if($selectedProduct && !$singleDateData && !$startDate && !$endDate && !$selectedCategories && $selectedSubCategories){
        $sqlQuery = "SELECT 
        products.id as id, 
        products.barcode as barcode, 
        products.prod_desc as prod_desc, 
        products.cost as cost,
        products.markup as markup, 
        products.prod_price as prod_price, 
        products.isVAT as isVAT, 
        products.Description as description, 
        products.sku as sku,
        products.code as code, 
        uom.uom_name as uom_name,
        products.category_id as category_id, 
        products.status as status, 
        products.brand as brand,
        products.uom_id as uom_id, 
        products.is_discounted as discounted, 
        products.is_taxIncluded as taxIncluded, 
        products.is_serviceCharge as serviceCharge, 
        products.is_srvcChrgeDisplay as displayService, 
        products.is_otherCharges as otherCharges, 
        products.is_othrChargeDisplay as displayOthers,
        products.productImage as image, 
        products.category_details as category_details, 
        products.category_id as category_id,
        products.variant_id as variant_id,
        products.is_BOM as is_BOM,
        products.is_warranty as is_warranty,
        products.is_stockable as is_stockable,
        products.stock_status as stock_status,
         products.stock_count as stock_count,
        products.product_stock as product_stock,
        products.isSCEnabled as isSC,
        products.isPWDEnabled as isPWD,
        products.isNAACEnabled as isNAAC,
        products.isSPEnabled as isSP,
         products.isMOVEnabled as isMOV
    FROM products 
    LEFT JOIN uom ON uom.id = products.uom_id WHERE 
        products.id= :selectedProduct AND products.variant_id = :selectedVariantProduct ORDER BY prod_desc ASC LIMIT  $offset, $recordsPerPage";

        $sql = $this->connect()->prepare($sqlQuery);
        $sql->bindParam(':selectedProduct', $selectedProduct);
        $sql->bindParam(':selectedVariantProduct', $selectedSubCategories);
        $sql->execute();
        return $sql;
      }else if ($selectedProduct && !$singleDateData && !$startDate && !$endDate && $selectedCategories && $selectedSubCategories){
        $sqlQuery = "SELECT 
        products.id as id, 
        products.barcode as barcode, 
        products.prod_desc as prod_desc, 
        products.cost as cost,
        products.markup as markup, 
        products.prod_price as prod_price, 
        products.isVAT as isVAT, 
        products.Description as description, 
        products.sku as sku,
        products.code as code, 
        uom.uom_name as uom_name,
        products.category_id as category_id, 
        products.status as status, 
        products.brand as brand,
        products.uom_id as uom_id, 
        products.is_discounted as discounted, 
        products.is_taxIncluded as taxIncluded, 
        products.is_serviceCharge as serviceCharge, 
        products.is_srvcChrgeDisplay as displayService, 
        products.is_otherCharges as otherCharges, 
        products.is_othrChargeDisplay as displayOthers,
        products.productImage as image, 
        products.category_details as category_details, 
        products.category_id as category_id,
        products.variant_id as variant_id,
        products.is_BOM as is_BOM,
        products.is_warranty as is_warranty,
        products.is_stockable as is_stockable,
        products.stock_status as stock_status,
        products.stock_count as stock_count,
        products.product_stock as product_stock,
        products.isSCEnabled as isSC,
        products.isPWDEnabled as isPWD,
        products.isNAACEnabled as isNAAC,
        products.isSPEnabled as isSP,
         products.isMOVEnabled as isMOV
    FROM products
    LEFT JOIN uom ON uom.id = products.uom_id WHERE 
        products.id= :selectedProduct AND products.category_id = :selectedCategoryProduct  AND products.variant_id = :selectedVariantProduct ORDER BY prod_desc ASC LIMIT  $offset, $recordsPerPage";

        $sql = $this->connect()->prepare($sqlQuery);
        $sql->bindParam(':selectedProduct', $selectedProduct);
        $sql->bindParam(':selectedCategoryProduct', $selectedCategories);
        $sql->bindParam(':selectedVariantProduct', $selectedSubCategories);
        $sql->execute();
        return $sql;
      }
      else{
        $sqlQuery = "SELECT 
        products.id as id, 
        products.barcode as barcode, 
        products.prod_desc as prod_desc, 
        products.cost as cost,
        products.markup as markup, 
        products.prod_price as prod_price, 
        products.isVAT as isVAT, 
        products.Description as description, 
        products.sku as sku,
        products.code as code, 
        uom.uom_name as uom_name,
        products.category_id as category_id, 
        products.status as status, 
        products.brand as brand,
        products.uom_id as uom_id, 
        products.is_discounted as discounted, 
        products.is_taxIncluded as taxIncluded, 
        products.is_serviceCharge as serviceCharge, 
        products.is_srvcChrgeDisplay as displayService, 
        products.is_otherCharges as otherCharges, 
        products.is_othrChargeDisplay as displayOthers,
        products.productImage as image, 
        products.category_details as category_details, 
        products.variant_id as variant_id,
        products.is_BOM as is_BOM,
        products.is_warranty as is_warranty,
        products.is_stockable as is_stockable,
        products.stock_status as stock_status,
         products.stock_count as stock_count,
        products.product_stock as product_stock,
        products.isSCEnabled as isSC,
        products.isPWDEnabled as isPWD,
        products.isNAACEnabled as isNAAC,
        products.isSPEnabled as isSP,
         products.isMOVEnabled as isMOV
    FROM products 
    LEFT JOIN uom ON uom.id = products.uom_id ORDER BY prod_desc ASC LIMIT  $offset, $recordsPerPage";

    $sql = $this->connect()->prepare($sqlQuery);
    $sql->execute();
    return $sql;

      }
  }
  
  
 
  public function addProduct($formData) {
    date_default_timezone_set('Asia/Manila');
    $currentDate = date('Y-m-d h:i:s');

    $discount_sc = $formData['discount_sc'];
    $discount_sp = $formData['discount_sp'];
    $discount_naac = $formData['discount_naac'];
    $discount_pwd = $formData['discount_pwd'];
    $discount_mov = $formData['discount_pwd'];

    $productname = $formData['productname'];
    $barcode = $formData['barcode'];
    $brand = $formData['brand'] ?? null;
    $code = $formData['code'] ?? null;
    $cost = $formData['cost'] ?? null;
    $description = $formData['description'] ?? null;
    $discount = $formData['discount'];
    $display_other_charges = $formData['display_other_charges'];
    $display_service_charge = $formData['display_service_charge'];
    $display_tax = $formData['display_tax'];
    $markup = $formData['markup'];
    $other_charges = $formData['other_charges'];
    $oum_id = ($formData['oum_id'] === 0 || $formData['oum_id'] === '') ? null : $formData['oum_id'];
    $sellingPrice = $formData['sellingPrice'];
    $service_charge = $formData['service_charge'];
    $sku = $formData['sku'] ?? null;
    $status = $formData['status'];
    $vat = $formData['vat'];
    $uploadedFile = $_FILES['uploadedImage'] ?? null;
    $cat_id = ($formData['catID'] === 0 || $formData['catID'] === '') ? null : $formData['catID'];
    $var_id = ($formData['varID'] === 0 || $formData['varID'] === '') ? null : $formData['varID'];      
    $category_details = $formData['category_details'] ?? null;
    $bomStat = $formData['bomStat'] ?? null;
    $warranty = $formData['warranty'] ?? null;
    $stockable = $formData['stockable'] ?? null;
    $warning = $formData['warning'] ?? null;
    $stockQuantity = $formData['stockQuantity'] ?? null;
    
    $fileName = null;
    if ($uploadedFile !== null && $uploadedFile['error'] === UPLOAD_ERR_OK) {
      $tempPath = $uploadedFile['tmp_name'];
      $fileName = $uploadedFile['name'];
  
      $destination = './assets/products/' . $fileName;
      if (file_exists($destination)) {
        unlink($destination);
      }
      $imageInfo = getimagesize($tempPath);
      $imageType = $imageInfo[2];
  
      $targetWidth = 230;
      $targetHeight = 230;
    
       if ($imageType == IMAGETYPE_JPEG) {
          $image = imagecreatefromjpeg($tempPath);
          $newImage = imagecreatetruecolor($targetWidth, $targetHeight);
          imagecopyresampled($newImage, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, imagesx($image), imagesy($image));
          imagejpeg($newImage, $destination, 75); 
          imagedestroy($newImage);
      } elseif ($imageType == IMAGETYPE_PNG) {
          $image = imagecreatefrompng($tempPath);
          $newImage = imagecreatetruecolor($targetWidth, $targetHeight);
          imagealphablending($newImage, false);
          imagesavealpha($newImage, true);
          $transparent = imagecolorallocatealpha($newImage, 0, 0, 0, 127);
          imagefilledrectangle($newImage, 0, 0, $targetWidth, $targetHeight, $transparent);
          imagecopyresampled($newImage, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, imagesx($image), imagesy($image));
          imagepng($newImage, $destination, 6); 
          imagedestroy($newImage);
      } elseif ($imageType == IMAGETYPE_GIF) {
          $image = imagecreatefromgif($tempPath);
          $newImage = imagecreatetruecolor($targetWidth, $targetHeight);
          $transparent = imagecolortransparent($image);
          imagepalettecopy($image, $newImage);
          imagefill($newImage, 0, 0, $transparent);
          imagecolortransparent($newImage, $transparent);
          imagetruecolortopalette($newImage, true, imagecolorstotal($image));
          imagecopyresampled($newImage, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, imagesx($image), imagesy($image));
          imagegif($newImage, $destination);
          imagedestroy($newImage);
      } else {
          throw new Exception('Unsupported image format.');
      }
  
      imagedestroy($image); 
    }

    // Insert product information into the database
    $sql = 'INSERT INTO products(barcode, prod_desc, cost, markup, prod_price, isVAT, Description, sku, code, uom_id, is_discounted, is_taxIncluded, is_serviceCharge, is_otherCharges, is_srvcChrgeDisplay, is_othrChargeDisplay, status, productImage, brand, category_id, variant_id, category_details, is_BOM, is_warranty,is_stockable,stock_status,stock_count, isSCEnabled, isPWDEnabled, isNAACEnabled, isSPEnabled, isMOVEnabled) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?, ?,?,?,?,? )';
    $pdo = $this->connect();
    $stmt = $pdo->prepare($sql); 
    $stmt->execute([$barcode, $productname, $cost, $markup, $sellingPrice, $vat, $description, $sku, $code, $oum_id, $discount, $display_tax, $service_charge, $other_charges, $display_service_charge, $display_other_charges, $status, $fileName, $brand, $cat_id, $var_id, $category_details, $bomStat, $warranty,$stockable,$warning,$stockQuantity, $discount_sc, $discount_pwd, $discount_naac, $discount_sp, $discount_mov]);
    $lastInsertId = $pdo->lastInsertId();

  
    $sqlInventory = 'INSERT INTO inventory(product_id) VALUES (?)';
    $stmtInventory = $this->connect()->prepare($sqlInventory);
    $stmtInventory->execute([$lastInsertId]);

    $currentStock = 0;
    $newqty = 0;
    $movement = 0;
    $stock_customer = 'User';
    $document_number = "---";
    $transaction_type = "Beginning Stock";
    $stmt = $this->connect()->prepare("INSERT INTO stocks (inventory_id, stock_customer, stock_qty, stock, document_number, transaction_type, date)
                                        VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->bindParam(1, $lastInsertId, PDO::PARAM_INT);
    $stmt->bindParam(2, $stock_customer, PDO::PARAM_STR); 
    $stmt->bindParam(3, $movement, PDO::PARAM_STR); 
    $stmt->bindParam(4, $newqty, PDO::PARAM_STR); 
    $stmt->bindParam(5, $document_number, PDO::PARAM_STR); 
    $stmt->bindParam(6, $transaction_type, PDO::PARAM_STR); 
    $stmt->bindParam(7, $currentDate, PDO::PARAM_STR); 
    $stmt->execute();

  
    if ($bomStat == 1) {
        $maxIdQuery = $this->connect()->query('SELECT MAX(id) AS max_id FROM products');
        $maxIdResult = $maxIdQuery->fetch(PDO::FETCH_ASSOC);
        $maxId = $maxIdResult['max_id'];

        $bomData = $formData['productBOM'] ?? [];
        $placeholders = rtrim(str_repeat('(?, ?, ?, ?, ?),', count($bomData)), ',');
        $values = [];
        foreach ($bomData as $entry) {
            $bomEntry = json_decode($entry, true);
            $ingredients_id = $bomEntry['ingredientId'];
            $qty = $bomEntry['ingredientsQty'];
            $uom_id = $bomEntry['uom_id'];

            $values[] =   $maxId;
            $values[] = $ingredients_id;
            $values[] = $qty;
            $values[] = $uom_id;
            $values[] = 1; 
        }

        // Insert BOM entries
        $sql = 'INSERT INTO bill_of_materials(prod_id, ingredients_id, qty, uom_id, is_save) VALUES ' . $placeholders;
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($values);

        // Check for successful insertion
        $numInsertedRows = $stmt->rowCount();
        if ($numInsertedRows == count($bomData)) {
            echo "All BOM entries inserted successfully.<br>";
        } else {
            echo "Failed to insert all BOM entries.<br>";
        }
    }

    return ['success' => true, 'products' =>   $stmt];
}


public function updateProduct($formData) 
{

  $discount_sc = $formData['discount_sc'];
  $discount_sp = $formData['discount_sp'];
  $discount_naac = $formData['discount_naac'];
  $discount_pwd = $formData['discount_pwd'];
  $discount_mov = $formData['discount_mov'];
  
  


  $productname = $formData['productname'] ?? null;
  $barcode = $formData['barcode'] ?? null;
  $brand = $formData['brand'] ?? null;
  $code = $formData['code'] ?? null;
  $cost = $formData['cost'] ?? null;
  $description = $formData['description'] ?? null;
  $discount = $formData['discount'] ?? null;
  $display_other_charges = $formData['display_other_charges'] ?? null;
  $display_service_charge = $formData['display_service_charge'] ?? null;
  $display_tax = $formData['display_tax'] ?? null;
  $markup = $formData['markup'] ?? null;
  $other_charges = $formData['other_charges'] ?? null;
  $oum_id = ($formData['oum_id'] === 0 || $formData['oum_id'] === '') ? null : $formData['oum_id'];
  $sellingPrice = $formData['sellingPrice'] ?? null;
  $service_charge = $formData['service_charge'] ?? null;
  $sku = $formData['sku'] ?? null;
  $status = $formData['status'] ?? null;
  $vat = $formData['vat'] ?? null;
  $uploadedFile = $_FILES['uploadedImage'] ?? null;
  $id = $formData['product_id'] ?? null;
  $cat_id = ($formData['catID'] === 0 || $formData['catID'] === '') ? null : $formData['catID'];
  $var_id = ($formData['varID'] === 0 || $formData['varID'] === '') ? null : $formData['varID'];      
  $category_details = $formData['category_details'] ?? null;
  $bomStat = $formData['bomStat'] ?? null;
  $warranty = $formData['warranty'] ?? null;
  $stockable = $formData['stockable'] ?? null;
  $warning = $formData['warning'] ?? null;
  $stockQuantity = $formData['stockQuantity'] ?? null;

  if ($uploadedFile !== null && $uploadedFile['error'] === UPLOAD_ERR_OK) 
  {
      $tempPath = $uploadedFile['tmp_name'];
      $fileName = $uploadedFile['name'];
  
      $destination = './assets/products/' . $fileName;
  
      if (file_exists($destination)) {
        unlink($destination);
      }

      $imageInfo = getimagesize($tempPath);
      $imageType = $imageInfo[2];
  
      $targetWidth = 230;
      $targetHeight = 230;
    
       if ($imageType == IMAGETYPE_JPEG) {
          $image = imagecreatefromjpeg($tempPath);
          $newImage = imagecreatetruecolor($targetWidth, $targetHeight);
          imagecopyresampled($newImage, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, imagesx($image), imagesy($image));
          imagejpeg($newImage, $destination, 75); 
          imagedestroy($newImage);
      } elseif ($imageType == IMAGETYPE_PNG) {
          $image = imagecreatefrompng($tempPath);
          $newImage = imagecreatetruecolor($targetWidth, $targetHeight);
          imagealphablending($newImage, false);
          imagesavealpha($newImage, true);
          $transparent = imagecolorallocatealpha($newImage, 0, 0, 0, 127);
          imagefilledrectangle($newImage, 0, 0, $targetWidth, $targetHeight, $transparent);
          imagecopyresampled($newImage, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, imagesx($image), imagesy($image));
          imagepng($newImage, $destination, 6); 
          imagedestroy($newImage);
      } elseif ($imageType == IMAGETYPE_GIF) {
          $image = imagecreatefromgif($tempPath);
          $newImage = imagecreatetruecolor($targetWidth, $targetHeight);
          $transparent = imagecolortransparent($image);
          imagepalettecopy($image, $newImage);
          imagefill($newImage, 0, 0, $transparent);
          imagecolortransparent($newImage, $transparent);
          imagetruecolortopalette($newImage, true, imagecolorstotal($image));
          imagecopyresampled($newImage, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, imagesx($image), imagesy($image));
          imagegif($newImage, $destination);
          imagedestroy($newImage);
      } else {
          throw new Exception('Unsupported image format.');
      }
  
      imagedestroy($image); 
  }
  else 
  {
      $query = "SELECT productImage FROM products WHERE id = ?";
      $statement = $this->connect()->prepare($query);
      $statement->execute([$id]);
      $result = $statement->fetch(PDO::FETCH_ASSOC);
      if ($result) {
          $fileName = $result['productImage'];
     } else{
      $fileName = null;
    }
  }
  $sql = 'UPDATE products SET 
          prod_desc = ?,
          barcode = ?,
          cost = ?, 
          markup = ?, 
          prod_price = ?, 
          isVAT = ?, 
          Description = ?, 
          sku = ?, 
          code = ?, 
          uom_id = ?, 
          is_discounted = ?, 
          is_taxIncluded = ?,
          is_serviceCharge = ?,
          is_otherCharges = ?,
          is_srvcChrgeDisplay = ?,
          is_othrChargeDisplay = ?,
          status = ?,
          productImage = ?,
          brand = ?,
          category_id = ?,
          variant_id = ?,
          category_details = ?,
          is_BOM = ?,
          is_warranty = ?,
          is_multiple = ?,
          is_stockable = ?,
          stock_status = ?,
          stock_count = ?,
          isSCEnabled = ?,
          isPWDEnabled = ?,
          isNAACEnabled = ?,
          isSPEnabled = ?,
          isMOVEnabled = ?
          WHERE id = ?';

  $stmt = $this->connect()->prepare($sql);
  $stmt->execute([$productname, $barcode, $cost, $markup, $sellingPrice, $vat, $description, $sku, $code, $oum_id, $discount, $display_tax, $service_charge,
  $other_charges, $display_service_charge, $display_other_charges, $status, $fileName, $brand, $cat_id,$var_id, $category_details, $bomStat, $warranty,0,$stockable,$warning,$stockQuantity, $discount_sc, $discount_pwd, $discount_naac, $discount_sp,  $discount_mov, $id]);
  
  $bomData = $formData['productBOM'] ?? [];
  $updateData = [];
  $insertData = [];
  
  // Separate data based on whether it requires update or insert
  foreach ($bomData as $bomItem) {
      $bomItem = json_decode($bomItem, true);
      if (isset($bomItem['id'])) {
          $updateData[] = $bomItem;
      } else {
          $insertData[] = $bomItem;
      }
  }
  

  foreach ($updateData as $bomItem) {
      $sql = 'UPDATE bill_of_materials 
              SET prod_id = ?, qty = ?, uom_id = ?, is_save = ?
              WHERE id = ?';
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$bomItem['prod_id'],$bomItem['ingredientsQty'], $bomItem['uom_id'],1, $bomItem['id']]);
      if ($stmt->rowCount() === 1) {
          echo "BOM Update  successful";
      } else {
          echo "Nothing to Update";
      }
  }
  
  
  foreach ($insertData as $bomItem) {
      $sql = 'INSERT INTO bill_of_materials(prod_id, ingredients_id, qty, uom_id, is_save)
              VALUES (?, ?, ?, ?, ?)';
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([ $id , $bomItem['ingredientId'], $bomItem['ingredientsQty'], $bomItem['uom_id'], 1]);
      if ($stmt->rowCount() === 1) {
          echo "Insertion successful for new BOM record.<br>";
      } else {
          echo "Insertion failed for new BOM record.<br>";
      }
  }
  
  return ['success' => true, 'Message' => "Products Successfull updated" ];
  
  
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
      $query = "SELECT sku FROM products WHERE sku REGEXP '^[0-9]+$' ORDER BY CAST(sku AS UNSIGNED) ASC;"; 
      $statement = $this->connect()->prepare($query);
      $statement->execute();
      $skus = $statement->fetchAll(PDO::FETCH_COLUMN);
    
     
      $nextSKU = 1;
      foreach ($skus as $sku) {
          if ($sku == $nextSKU) {
              $nextSKU++; 
          } else {
              break; 
          }
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

public function getShopDetails(){
  $sql = $this->connect()->prepare("SELECT * FROM shop");
  $sql->execute();
  return $sql;
}

public function deleteCategories($id) {
  $sql = "DELETE FROM category WHERE id = :id AND NOT EXISTS (SELECT 1 FROM variants WHERE category_id = :id)";
  $stmt = $this->connect()->prepare($sql);
  $stmt->execute([':id' => $id]);

 
  $rowCount = $stmt->rowCount();

  return $rowCount > 0; 
}
public function deleteVariants($id){
  $sql = "DELETE FROM variants WHERE id = :id";
  $stmt = $this->connect()->prepare($sql);
  $stmt->execute([':id' => $id]);

  $rowCount = $stmt->rowCount();

  return $rowCount > 0; 
}

public function editVariantData($id, $variantName,$category_id){
  $sql = 'UPDATE variants SET 
  category_id = ?,
  variant_name = ?
  WHERE id = ?';

$stmt = $this->connect()->prepare($sql);
$stmt->execute([$category_id, $variantName, $id]);

return $stmt;
}

public function getProductsData() {
  $sql = 'SELECT * FROM products ORDER BY prod_desc ASC';
  $stmt = $this->connect()->query($sql);
  return $stmt;
}
public function getCategoriesData(){
  $sql = 'SELECT * FROM category';
  $stmt = $this->connect()->query($sql);
  return $stmt;
}
public function getVariantsData($categoryId) {
  $sql = 'SELECT variants.*, category.id AS categoryId 
          FROM variants
          INNER JOIN category ON category.id = variants.category_id
          WHERE variants.category_id = ?';
  $stmt = $this->connect();
  $variants = $stmt->prepare($sql);
  $variants->execute([$categoryId]);

  $result = $variants->fetchAll(PDO::FETCH_ASSOC);
  
  echo json_encode($result);

}
public function getSuppliersData(){
  $sql = 'SELECT * FROM supplier';
  $stmt = $this->connect()->query($sql);
  return $stmt;
}
public function deleteProducts($prod_id) {
  $sql = 'DELETE FROM products
      WHERE id = :prod_id
      AND NOT EXISTS (
          SELECT 1
          FROM transactions
          WHERE prod_id = :prod_id
      )';

  $stmt = $this->connect()->prepare($sql);
  $stmt->bindParam(':prod_id', $prod_id, PDO::PARAM_INT);
  $stmt->execute();

  $rowCount = $stmt->rowCount();

  return $rowCount > 0; 
}
public function importProducts($fileData) {
  $file = $fileData['tmp_name'];
  $csvData = array_map('str_getcsv', file($file));
  $headers = array_shift($csvData);

  $query = "INSERT INTO products (prod_desc, sku, barcode, cost, markup, prod_price, isVAT, is_taxIncluded, IsPriceChangeAllowed, IsUsingDefaultQuantity, IsService, status,is_discounted,is_stockable,uom_id) 
              VALUES (:prod_desc, :sku, :barcode, :cost, :markup, :prod_price, :isVAT, :is_taxIncluded, :IsPriceChangeAllowed, :IsUsingDefaultQuantity, :IsService, :status,:isDiscounted,:is_stockable,:uom_id)";
  
  $conn = $this->connect();
  $conn->beginTransaction(); 
  date_default_timezone_set('Asia/Manila');
  $currentDate = date('Y-m-d h:i:s');
  try 
  {
      $stmt = $conn->prepare($query);
    
      foreach ($csvData as $row) 
      {
          $product = array_combine($headers, $row);

          // Bind parameters
          $stmt->bindParam(':prod_desc', $product['Name']);
          $stmt->bindParam(':sku', $product['SKU']);
          $stmt->bindParam(':barcode', $product['Barcode']);
          $stmt->bindParam(':cost', $product['Cost']);
          $stmt->bindParam(':markup', $product['Markup']);
          $stmt->bindParam(':prod_price', $product['Price']);
          $stmt->bindParam(':isVAT', $product['Tax']);
          $stmt->bindParam(':is_taxIncluded', $product['IsTaxInclusivePrice']);
          $stmt->bindParam(':IsPriceChangeAllowed', $product['IsPriceChangeAllowed']);
          $stmt->bindParam(':IsUsingDefaultQuantity', $product['IsUsingDefaultQuantity']);
          $stmt->bindParam(':IsService', $product['IsService']);
          $stmt->bindParam(':status', $product['IsEnabled']);
          $stmt->bindParam(':isDiscounted', $product['isDiscounted']);
          $stmt->bindParam(':is_stockable', $product['Stockable']);
          $stmt->bindParam(':uom_id', $product['UOM']);

          $stmt->execute();
          $productId = $conn->lastInsertId();
        
          $lastInsertIds[] = $productId;
      }
      $conn->commit(); 
      foreach ($lastInsertIds as $productId) 
      {
        $sqlInventory = 'INSERT INTO inventory (product_id) VALUES (:product_id)';
        $stmtInventory = $conn->prepare($sqlInventory);
        $stmtInventory->bindParam(':product_id', $productId);
        $stmtInventory->execute();
      }
      return true;
  } catch (PDOException $e) {
      $conn->rollBack(); 
      error_log("Import failed: " . $e->getMessage());
      return false;
  }
  
}
// public function importProducts($fileData) {
//   $file = $fileData['tmp_name'];
//   $csvData = array_map('str_getcsv', file($file));
//   $headers = array_shift($csvData);

//   $query = "INSERT INTO products (prod_desc, sku, barcode, cost, markup, prod_price, isVAT, is_taxIncluded, IsPriceChangeAllowed, IsUsingDefaultQuantity, IsService, status,is_discounted,is_stockable,uom_id, product_stock, stock_count) 
//               VALUES (:prod_desc, :sku, :barcode, :cost, :markup, :prod_price, :isVAT, :is_taxIncluded, :IsPriceChangeAllowed, :IsUsingDefaultQuantity, :IsService, :status,:isDiscounted,:is_stockable,:uom_id, :product_stock, :stock_count)";
  
//   $conn = $this->connect();
//   $conn->beginTransaction(); 
//   date_default_timezone_set('Asia/Manila');
//   $currentDate = date('Y-m-d h:i:s');
//   try {
//       $stmt = $conn->prepare($query);
    
//       foreach ($csvData as $row) {
//           $product = array_combine($headers, $row);

//           // Bind parameters
//           $stmt->bindParam(':prod_desc', $product['Name']);
//           $stmt->bindParam(':sku', $product['SKU']);
//           $stmt->bindParam(':barcode', $product['Barcode']);
//           $stmt->bindParam(':cost', $product['Cost']);
//           $stmt->bindParam(':markup', $product['Markup']);
//           $stmt->bindParam(':prod_price', $product['Price']);
//           $stmt->bindParam(':isVAT', $product['Tax']);
//           $stmt->bindParam(':is_taxIncluded', $product['IsTaxInclusivePrice']);
//           $stmt->bindParam(':IsPriceChangeAllowed', $product['IsPriceChangeAllowed']);
//           $stmt->bindParam(':IsUsingDefaultQuantity', $product['IsUsingDefaultQuantity']);
//           $stmt->bindParam(':IsService', $product['IsService']);
//           $stmt->bindParam(':status', $product['IsEnabled']);
//           $stmt->bindParam(':isDiscounted', $product['isDiscounted']);
//           $stmt->bindParam(':is_stockable', $product['Stockable']);
//           $stmt->bindParam(':uom_id', $product['UOM']);
//           $stmt->bindParam(':product_stock', $product['Store Qty']);
//           $stmt->bindParam(':stock_count', $product['Low stock warning']);

//           $stmt->execute();
//           $productId = $conn->lastInsertId();
        
       
//           $currentStock = 0;
//           $newqty = $product['Store Qty'];
//           $movement = $product['Store Qty'];
//           $stock_customer = 'User';
//           $document_number = "---";
//           $transaction_type = "Beginning Stock";
//           $stmt = $conn->prepare("INSERT INTO stocks (inventory_id, stock_customer, stock_qty, stock, document_number, transaction_type, date)
//                                               VALUES (?, ?, ?, ?, ?, ?, ?)");
  
//           $stmt->bindParam(1, $productId, PDO::PARAM_INT);
//           $stmt->bindParam(2, $stock_customer, PDO::PARAM_STR); 
//           $stmt->bindParam(3, $movement, PDO::PARAM_STR); 
//           $stmt->bindParam(4, $newqty, PDO::PARAM_STR); 
//           $stmt->bindParam(5, $document_number, PDO::PARAM_STR); 
//           $stmt->bindParam(6, $transaction_type, PDO::PARAM_STR); 
//           $stmt->bindParam(7, $currentDate, PDO::PARAM_STR); 
//           $stmt->execute();

//           $lastInsertIds[] = $productId;
//       }


//       $conn->commit(); 
//       foreach ($lastInsertIds as $productId) {
//         $sqlInventory = 'INSERT INTO inventory (product_id) VALUES (:product_id)';
//         $stmtInventory = $conn->prepare($sqlInventory);
//         $stmtInventory->bindParam(':product_id', $productId);
//         $stmtInventory->execute();

      
//       }
//       return true;
//   } catch (PDOException $e) {
//       $conn->rollBack(); 
//       error_log("Import failed: " . $e->getMessage());
//       return false;
//   }
  
// }
// public function importProducts($fileData) {
//   $file = $fileData['tmp_name'];
//   $csvData = array_map('str_getcsv', file($file));
//   $headers = array_shift($csvData);

//   $productQuery = "INSERT INTO products (prod_desc, sku, barcode, cost, markup, prod_price, isVAT, is_taxIncluded, IsPriceChangeAllowed, IsUsingDefaultQuantity, IsService, status, is_discounted, is_stockable, uom_id, product_stock, stock_count) 
//                    VALUES (:prod_desc, :sku, :barcode, :cost, :markup, :prod_price, :isVAT, :is_taxIncluded, :IsPriceChangeAllowed, :IsUsingDefaultQuantity, :IsService, :status, :isDiscounted, :is_stockable, :uom_id, :product_stock, :stock_count)";

//   $stockQuery = "INSERT INTO stocks (inventory_id, stock_customer, stock_qty, stock, document_number, transaction_type, date)
//                  VALUES (:inventory_id, :stock_customer, :stock_qty, :stock, :document_number, :transaction_type, :date)";

//   $inventoryQuery = 'INSERT INTO inventory (product_id) VALUES (:product_id)';

//   $conn = $this->connect();
//   $conn->beginTransaction(); 

//   date_default_timezone_set('Asia/Manila');
//   $currentDate = date('Y-m-d H:i:s'); // Use 'H:i:s' for 24-hour format

//   try {
//       // Prepare statements once
//       $stmtProduct = $conn->prepare($productQuery);
//       $stmtStock = $conn->prepare($stockQuery);
//       $stmtInventory = $conn->prepare($inventoryQuery);

//       // Collect data for batch insert
//       $productData = [];
//       $stockData = [];
//       $inventoryData = [];

//       foreach ($csvData as $row) {
//           $product = array_combine($headers, $row);

//           // Collect product data
//           $productData[] = [
//               ':prod_desc' => $product['Name'],
//               ':sku' => $product['SKU'],
//               ':barcode' => $product['Barcode'],
//               ':cost' => $product['Cost'],
//               ':markup' => $product['Markup'],
//               ':prod_price' => $product['Price'],
//               ':isVAT' => $product['Tax'],
//               ':is_taxIncluded' => $product['IsTaxInclusivePrice'],
//               ':IsPriceChangeAllowed' => $product['IsPriceChangeAllowed'],
//               ':IsUsingDefaultQuantity' => $product['IsUsingDefaultQuantity'],
//               ':IsService' => $product['IsService'],
//               ':status' => $product['IsEnabled'],
//               ':isDiscounted' => $product['isDiscounted'],
//               ':is_stockable' => $product['Stockable'],
//               ':uom_id' => $product['UOM'],
//               ':product_stock' => $product['Stock'],
//               ':stock_count' => $product['LSW']
//           ];

//           // Collect stock data (note: handle batching of stock data separately if large)
//           $stockData[] = [
//               ':inventory_id' => null, // Placeholder for product_id
//               ':stock_customer' => 'User',
//               ':stock_qty' => $product['Store Qty'],
//               ':stock' => $product['Store Qty'],
//               ':document_number' => '---',
//               ':transaction_type' => 'Beginning Stock',
//               ':date' => $currentDate
//           ];

//           // Collect inventory data
//           $inventoryData[] = [':product_id' => null]; // Placeholder for product_id
//       }
//       return $productData;
//       // Insert products in batch
//       foreach ($productData as $product) {
//           $stmtProduct->execute($product);
//       }

//       // Fetch last insert ids and update stock and inventory data
//       foreach ($productData as $index => $product) {
//           $productId = $conn->lastInsertId();
//           $stockData[$index][':inventory_id'] = $productId;
//           $inventoryData[$index][':product_id'] = $productId;
//       }

//       // Insert stocks in batch
//       foreach ($stockData as $stock) {
//           $stmtStock->execute($stock);
//       }

//       // Insert inventories in batch
//       foreach ($inventoryData as $inventory) {
//           $stmtInventory->execute($inventory);
//       }

//       $conn->commit(); 
//       return true;
//   } catch (PDOException $e) {
//       $conn->rollBack(); 
//       error_log("Import failed: " . $e->getMessage());
//       return false;
//   }
// }
public function getTotalProductsCount() {
  try {
      $pdo = $this->connect(); 

      $query = "SELECT COUNT(*) AS total_count FROM products";
      $stmt = $pdo->query($query);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      return $result['total_count'];
  } catch (PDOException $e) {
      return 0;
  }
}

public function getServiceCharge(){

  $pdo = $this->connect();

  $sql = 'SELECT * FROM charges';
  $stmt = $pdo->query($sql);
  $serviceCharge = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $getTax = $pdo->prepare('SELECT `tax` FROM `shop` LIMIT 1');
  $getTax->execute();
  $tax = $getTax->fetch(PDO::FETCH_ASSOC);


  $getCustomerDis = $pdo->prepare('SELECT discount_amount FROM discounts WHERE name = "SC" LIMIT 1');
  $getCustomerDis->execute();
  $discount = $getCustomerDis->fetch(PDO::FETCH_ASSOC);


    // Fetching discount for Solo Parent
    $getSoloParentDis = $pdo->prepare('SELECT discount_amount FROM discounts WHERE name = "SP" LIMIT 1');
    $getSoloParentDis->execute();
    $soloParentDiscount = $getSoloParentDis->fetch(PDO::FETCH_ASSOC);

    // Fetching discount for NAAC
    $getNaacDis = $pdo->prepare('SELECT discount_amount FROM discounts WHERE name = "NAAC" LIMIT 1');
    $getNaacDis->execute();
    $naacDiscount = $getNaacDis->fetch(PDO::FETCH_ASSOC);


  $lastId = $pdo->prepare("SELECT * FROM point_system ORDER BY id DESC LIMIT 1");
  $lastId->execute();
  $loyaltyPoits = $lastId->fetch(PDO::FETCH_ASSOC);

  
  echo json_encode([
    'data' => $serviceCharge,
    'tax' => $tax,
    'cusDiscount' => $discount,
    'soloParentDiscount' => $soloParentDiscount,
    'naacDiscount' => $naacDiscount,
    'loyaltyPoits' => $loyaltyPoits,
  ]);
}

public function getOtherCharge(){
  $sql = 'SELECT * FROM charges WHERE charges = "Other Charges"';
  $stmt = $this->connect()->query($sql);
  $otherCharge =  $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $otherCharge;

}
public function updateCharges($id, $serviceValue){
   $dataValue =  $serviceValue/100;
  $updateServices = 'UPDATE charges SET rate = ? WHERE id = ?';
  $conn = $this->connect();
  $stmtUpdateAll = $conn->prepare($updateServices);
  $stmtUpdateAll->execute([number_format($dataValue,8), $id]);
  return $stmtUpdateAll;
}
public function updateOthers($id, $serviceValue){
$dataValue =  $serviceValue/100;
 $updateServices = 'UPDATE charges SET rate = ? WHERE id = ?';
 $conn = $this->connect();
 $stmtUpdateAll = $conn->prepare($updateServices);
 $stmtUpdateAll->execute([number_format($dataValue,8), $id]);
 return $stmtUpdateAll;
}



  public function getValidate($productId) {
    $pdo = $this->connect();
    $sql = $pdo->prepare("SELECT transactions.prod_id,
    products.id,
    products.barcode,
    products.prod_desc
    FROM products
    INNER JOIN transactions ON products.id = transactions.prod_id
    WHERE transactions.prod_id = $productId
    LIMIT 1;");

    $sql->execute();
    $response = $sql->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
      'data' => $response,
    ]);
  }


  public function updateStatusProduct($id) {
    $pdo = $this->connect();
    $sql = $pdo->prepare("UPDATE `products` SET `status`= 0 WHERE id = ?");
    $sql->execute([$id]);
    echo json_encode('Success');

  }


  public function getPromoSet() {
    $pdo = $this->connect();
    $sql = $pdo->prepare("SELECT `promotions` FROM `pos_settings` LIMIT 1");
    $sql->execute();
    $response = $sql->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode([
      'data' => $response,
    ]);

  } 

  public function updatePromo($promotionValues) 
  {
    $pdo = $this->connect();
    $sql = $pdo->prepare("UPDATE `pos_settings` SET `promotions`= ?");
    $sql->execute([$promotionValues]);

    $promotionTypes = json_decode($promotionValues, true);
    foreach ($promotionTypes as $key => $value)
    {
      $type = 0;
      if($value === 0)
      {
        if($key === "buy_1_take_1") $type = 1;
        if($key === "bundle_sale") $type = 2;
        if($key === "whole_sale") $type = 3;
        if($key === "point_promo") $type = 4;
        if($key === "stamp_promo") $type = 5;

        $sql = "DELETE FROM promotions WHERE promotion_type = $type";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
      }
    }
    echo json_encode($status);
  }


  public function updateSettings($returnValues) {
    $pdo = $this->connect();
    $valusToUpdate = json_decode($returnValues);

    $lastId = $pdo->prepare("SELECT * FROM point_system ORDER BY id DESC LIMIT 1");
    $lastId->execute();
    $idLast = $lastId->fetch(PDO::FETCH_ASSOC);

    $sql = $pdo->prepare("UPDATE `point_system` SET `min_amount`= ?,`equivalent_point`= ?,`points`= ?,`converted_amount`= ? WHERE id = 1");
    $sql->execute([$valusToUpdate->min_purchase, $valusToUpdate->equivalent, $valusToUpdate->points, $valusToUpdate->conver_points]);


    $update_sc_pwd_sp = $pdo->prepare("UPDATE `discounts`
    SET `discount_amount` = ?
    WHERE `name` IN ('SC', 'PWD');");
    $update_sc_pwd_sp->execute([$valusToUpdate->sc_pwd_sp]);

    
    $update_sp = $pdo->prepare("UPDATE `discounts`
    SET `discount_amount` = ?
    WHERE `name` IN ('SP');");
    $update_sp->execute([$valusToUpdate->solo_parent]);

    
    $update_naac = $pdo->prepare("UPDATE `discounts`
    SET `discount_amount` = ?
    WHERE `name` IN ('NAAC', 'MOV');");
    $update_naac->execute([$valusToUpdate->naac]);


    $update_tax = $pdo->prepare("UPDATE `shop` SET `tax`= ? WHERE 1");
    $update_tax->execute([$valusToUpdate->tax]);

    if ($valusToUpdate->other_charge) {
      $updateCharges = $pdo->prepare("UPDATE `charges` SET `rate`= (? / 100) WHERE `charges` = 'Other Charges';");
      $updateCharges->execute([$valusToUpdate->other_charge]);
    }

    if ($valusToUpdate->service_charge) {
      $updateCharges = $pdo->prepare("UPDATE `charges` SET `rate`= (? / 100) WHERE `charges` = 'Service Charge';");
      $updateCharges->execute([$valusToUpdate->service_charge]);
    }

    echo json_encode([
      'data' => "SUCCESS",
    ]);
  }



  public function getAllProducts() {
    $pdo = $this->connect();
    $product = $pdo->prepare('SELECT * FROM products ORDER BY prod_desc ASC');
    $product->execute();
    $products = $product->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($products);
  }


  public function getAllCopyProducts() {
    $pdo = $this->connect();
    $product = $pdo->prepare('SELECT * FROM products_copy ORDER BY prod_desc ASC');
    $product->execute();
    $products = $product->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($products);
  }


  }  
?>