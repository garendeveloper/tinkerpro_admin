<?php
    include( __DIR__ . '/utils/db/connector.php');
    include( __DIR__ . '/utils/models/user-facade.php');
    include( __DIR__ . '/utils/models/product-facade.php');
    include( __DIR__ . '/utils/models/inventory-facade.php');
    include( __DIR__ . '/utils/models/order-facade.php');
   
    $userFacade = new UserFacade();
    $products = new ProductFacade();
    $inventory = new InventoryFacade();
    $order = new OrderFacade();

    include( __DIR__ . '/utils/models/ingredients-facade.php');
   
    $userFacade = new UserFacade();
    $products = new ProductFacade();
    $ingredients = new IngredientsFacade();

    header("Content-Type: application/json");
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    
    $response = array("message" => "Hello from API");
    $action = isset($_GET['action']) ? $_GET['action'] : null;
    switch ($action) {
        case 'user_role':
           $roleId = isset($_GET['roleId']) ? $_GET['roleId'] : null;
           $role = $userFacade->checkUsersIdentificationNumber($roleId);
           echo json_encode(["success" => true,'role_id' => $role]);
            break;
          
        case 'addUsersData': 
            $formData = $_POST;
            $result = $userFacade->addNewUsers($formData);
            echo json_encode( $formData);
            break; 
        case 'updateUserData':
            $formData = $_POST;
            $result = $userFacade->updateDataUsers($formData);
            echo json_encode( $formData);
            break;
        case 'getlatestSkuData':
            $nextSKU = $products->latestSKU(); 
            echo json_encode(['success' => true, 'nextSKU' => $nextSKU]);
            break; 
        case 'getVariantsData':
            $catID = isset($_GET['cat_id']) ? $_GET['cat_id'] : null; 
            $variants = $products->getVariants($catID); 
            echo json_encode(['success' => true, 'variants' => $variants]);
            break;
        case 'addCategory':
            $postData = json_decode(file_get_contents('php://input'), true);
            $category = isset($postData['category']) ? $postData['category'] : null;
            $products->addCategory($category); 
            break;
        case 'getDataCategory':
            $categories = $products->getCategories();
            $result = $categories->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'categories' => $result]);
            break;
        case 'get_allInventories':
            $currentPage = isset($_GET['currentPage']) ? $_GET['currentPage'] : 1;
            $perPage = isset($_GET['perPage']) ? $_GET['perPage'] : 10;
            echo json_encode($inventory->get_allInventories($currentPage, $perPage));
            break;
        case 'get_allProducts':
            echo json_encode($products->fetchProducts());
            break;
        case 'get_productInfo':
            $product = $_GET['data'];
            echo json_encode($inventory->get_productInfo($product));
            break;
        case 'save_purchaseOrder':
            $formData = $_POST;
            echo json_encode($inventory->save_purchaseOrder($formData));
            break;
        case 'get_allSuppliers':
            echo json_encode($inventory->get_allSuppliers());
            break;
        case 'get_purchaseOrderNo':
            echo json_encode($inventory->fetch_latestPONo());
            break;
        case 'get_allOrders':
            $currentPage = isset($_GET['currentPage']) ? $_GET['currentPage'] : 1;
            $perPage = isset($_GET['perPage']) ? $_GET['perPage'] : 10;
            echo json_encode($order->get_allOrders($currentPage, $perPage));
            break;
        case 'get_orderData':
            $order_id = $_GET['order_id'];
            echo json_encode($order->get_orderData($order_id));
        case 'updateDataCategory':// updateCategory($categoryname, $categoryid)
            $postData = json_decode(file_get_contents('php://input'), true);
            $categoryid = isset($postData['id']) ? $postData['id'] : null;
            $categoryname =  isset($postData['name']) ? $postData['name'] : null;
            $products->updateCategory($categoryname, $categoryid);
            break;
        case "addVariant":
            $postData = json_decode(file_get_contents('php://input'), true);//variantName
            $categoryid = isset($postData['id']) ? $postData['id'] : null;
            $variantName = isset($postData['variantName']) ? $postData['variantName'] : null;
            $products->addVariants($categoryid ,$variantName);
            // echo json_encode(['success' => true, 'variant' =>  $categoryid]);
            break;
        case "addProduct":
             $formData = $_POST;
             $result = $products->addProduct($formData);
             echo json_encode([ 'success' => true, 'result' => $result]);
             break; 
        case "checkSKU":
            $sku = isset($_GET['sku']) ? $_GET['sku'] : null;
            $barcode = isset($_GET['barcode']) ? $_GET['barcode'] : null;
            $code = isset($_GET['code']) ? $_GET['code'] : null;
            $result = $products->checkSku($sku,$barcode,$code);
            echo json_encode(['success'=> true,'sku' => $result]);
            break;
        case "updateProduct":
             $formData = $_POST;
             $result = $products->updateProduct($formData);
             echo json_encode( $result);
             break;
        case "deleteCategory":
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            $success = $products->deleteCategories($id);
            if ($success) {
                echo json_encode(['success' => true, 'id' => $id]); 
            } else {
                echo json_encode(['success' => false]); 
            }
            break;
        case "deleteVariants":
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            $success = $products->deleteVariants($id);
            if ($success) {
                echo json_encode(['success' => true, 'id' => $id]); 
            } else {
                echo json_encode(['success' => false]); 
            }
            break;
        case "checkBarcode":
            $barcode = isset($_GET['barcode']) ? $_GET['barcode'] : null;
            $result = $ingredients->checkBarcode($barcode);
            echo json_encode(['success' => true, 'barcode' =>  $result]); 
            break;
        case "addIngredients":
            $postData = json_decode(file_get_contents('php://input'), true);
            $ingredientName = isset($postData['ingredientName']) ? $postData['ingredientName'] : null;
            $barcode = isset($postData['barcode']) ? $postData['barcode'] : null;
            $uom_id = isset($postData['uom_id']) ? $postData['uom_id'] : null;
            $cost = isset($postData['cost']) ? $postData['cost'] : null;
            $status = isset($postData['status']) ? $postData['status'] : null;
            $description = isset($postData['description']) ? $postData['description'] : null;
            $result = $ingredients->addIngredient($ingredientName,$barcode,$uom_id,$cost, $status, $description);
            echo json_encode(['success' => true, 'name' =>   $ingredientName]);
            break;
        case "getBOMData":
            $productid = isset($_GET['product_id']) ? $_GET['product_id'] : null;
            $result = $ingredients->getBom($productid);
            echo json_encode(['success' => true, 'bom' =>   $result]); 
            break;
        case "deleteBOM":
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            $result = $ingredients->deleteBOM($id);
            echo json_encode(['success' => true, 'result' =>  $result ]); 
            break;
        case "updateIngredients":
            $postData = json_decode(file_get_contents('php://input'), true);
            $ingredientName = isset($postData['ingredientName']) ? $postData['ingredientName'] : null;
            $barcode = isset($postData['barcode']) ? $postData['barcode'] : null;
            $uom_id = isset($postData['uom_id']) ? $postData['uom_id'] : null;
            $cost = isset($postData['cost']) ? $postData['cost'] : null;
            $status = isset($postData['status']) ? $postData['status'] : null;
            $description = isset($postData['description']) ? $postData['description'] : null;
            $id = isset($postData['ing_id']) ? $postData['ing_id'] : null;
            $result = $ingredients->updateIngrednts($ingredientName, $barcode,$uom_id,$cost,$status,$description,$id);
            echo json_encode(['success' => true, 'result' => $result ]); 
            break;
        default:
            header("HTTP/1.0 400 Bad Request");
            break;
       

    }

