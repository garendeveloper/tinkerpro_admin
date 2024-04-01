<?php
    include( __DIR__ . '/utils/db/connector.php');
    include( __DIR__ . '/utils/models/user-facade.php');
    include( __DIR__ . '/utils/models/product-facade.php');
   
    $userFacade = new UserFacade();
    $products = new ProductFacade();
   

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
        default:
            header("HTTP/1.0 400 Bad Request");
            break;
       

    }

