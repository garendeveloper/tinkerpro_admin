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
            break;
        default:
            header("HTTP/1.0 400 Bad Request");
            break;
       

    }

