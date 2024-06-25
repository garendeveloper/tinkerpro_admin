<?php
    include( __DIR__ . '/utils/db/connector.php');
    include( __DIR__ . '/utils/models/user-facade.php');
    include( __DIR__ . '/utils/models/product-facade.php');
    include( __DIR__ . '/utils/models/inventory-facade.php');
    include( __DIR__ . '/utils/models/order-facade.php');
    include( __DIR__ . '/utils/models/loss_and_damage-facade.php');
    include( __DIR__ . '/utils/models/supplier-facade.php');
    include( __DIR__ . '/utils/models/inventorycount-facade.php');
    include( __DIR__ . '/utils/models/ability-facade.php');
    include( __DIR__ . '/utils/models/customer-facade.php');
    include( __DIR__ . '/utils/models/dashboard-facade.php');
    include( __DIR__ . '/utils/models/expense-facade.php');
   
    $userFacade = new UserFacade();
    $products = new ProductFacade();
    $inventory = new InventoryFacade();
    $order = new OrderFacade();
    $inventory_count = new InventoryCountFacade();
    $loss_and_damage = new Loss_and_damage_facade();
    $expense_facade = new ExpenseFacade();

    include( __DIR__ . '/utils/models/ingredients-facade.php');
   
    // $userFacade = new UserFacade();
    // $products = new ProductFacade();
    $ingredients = new IngredientsFacade();
    $supplier = new SupplierFacade();
    $abilitties = new AbilityFacade();
    $customer = new CustomerFacade();
    $dashboard = new DashboardFacade();

    header("Content-Type: application/json");
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    
    $response = array("message" => "Hello from API");
    $action = isset($_GET['action']) ? $_GET['action'] : null;
    switch ($action) {
        case 'pos_settings':
            echo json_encode($dashboard->pos_settings());
            break;
        //Dashboard
        case 'get_allTopProducts':
            echo json_encode($dashboard->get_allTopProducts($_GET['item'], $_GET['start_date'], $_GET['end_date']));
            break;
        case 'get_salesDataByHour':
            echo json_encode($dashboard->get_salesDataByHour($_GET['start_date'], $_GET['end_date']));
            break;
        case 'get_salesData':
            echo json_encode($dashboard->get_salesDataByYear($_GET['year']));
            break;
            
        //Expenses
        case 'get_expenseDataById':
            echo json_encode($expense_facade->get_expenseDataById($_GET['expense_id']));
            break;
        case 'delete_expenseById':
            echo json_encode($expense_facade->delete_expense($_GET['expense_id']));
            break;
        case 'save_expense':
            echo json_encode($expense_facade->save_expense($_POST));
            break;
        case 'get_allExpenses':
            echo json_encode($expense_facade->get_allExpenses($_POST['start_date'], $_POST['end_date']));
            break;
        //
        case 'user_role':
           $roleId = isset($_GET['roleId']) ? $_GET['roleId'] : null;
           $role = $userFacade->checkUsersIdentificationNumber($roleId);
           echo json_encode(["success" => true,'role_id' => $role]);
            break;
          
        case 'addUsersData': 
            $formData = $_POST;
            $result = $userFacade->addNewUsers($formData);
            echo json_encode( $result);
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
        case 'delete_purchaseOrder':
            echo json_encode($order->delete_purchaseOrder($_GET["id"]));
            break;
        case 'get_allInventories':
            $currentPage = isset($_GET['pageSize']) ? $_GET['pageSize'] : 1;
            $page = isset($_GET['page']) ? $_GET['page'] : 300;
            echo json_encode($inventory->get_allInventories($page, $currentPage));
            break;
        case 'get_allStocksData':
            echo json_encode($inventory->get_allStocksData($_GET['inventory_id']));
            break;
        case 'get_allStocksDataByDate':
            echo json_encode($inventory->get_allStocksDataByDate($_GET['inventory_id'], $_GET['start_date'], $_GET['end_date']));
            break;
        case 'get_allProductByInventoryType':
            $inventory_type = $_GET['type'];
            echo json_encode($inventory->get_allProductByInventoryType($inventory_type));
            break;
        case 'get_inventorycount_latest_reference_no':
            echo json_encode($inventory_count->get_latest_reference_no());
            break;
        case 'get_inventoryDataById':
            $inventory_id = $_GET['inventory_id'];
            echo json_encode($inventory->get_inventoryDataById($inventory_id));
            break;
        case 'get_orderPaymentHistory':
            $order_id = $_GET['order_id'];
            echo json_encode($inventory->get_orderPaymentHistory($order_id));
            break;
        case 'get_all_lostanddamageinfo':
            echo json_encode($loss_and_damage->get_all_lostanddamageinfo());
            break;
        case 'get_lostanddamage_data':
            $id = $_GET['id'];
            echo json_encode($loss_and_damage->get_lostanddamage_data($id));
            break;
        case 'get_inventoryCountDataById':
            $inventorycount_id = $_GET['id'];
            echo json_encode($inventory_count->get_inventoryCountDataById($inventorycount_id));
            break;
        case 'get_allProducts':
            echo json_encode($inventory->get_allProducts());
            break;
        case 'get_productInfo':
            $product = $_GET['data'];
            echo json_encode($inventory->get_productInfo($product));
            break;
        case 'get_allInventoryCounts':
            echo json_encode($inventory_count->get_allData());
            break;
        case 'get_realtime_notifications':
            echo json_encode($inventory->get_realtime_notifications());
            break;
        case 'save_purchaseOrder':
            $formData = $_POST;
            echo json_encode($inventory->save_purchaseOrder($formData));
            break;
        case 'get_expirationNotification':
            echo json_encode($inventory->get_expirationNotification());
            break;
        case 'save_expirationNotification':
            echo json_encode($inventory->save_expirationNotification($_POST));
            break;
        case 'save_orderPayments':
            $formData = $_POST;
            echo json_encode($inventory->save_orderPayments($formData));
            break;
        case 'save_inventory_count':
            $formData = $_POST;
            echo json_encode($inventory_count->save_inventory_count($formData));
            break;
        case 'save_loss_and_damage':
            $formData = $_POST;
            echo json_encode($loss_and_damage->save_loss_and_damage($formData));
            break;
        case 'save_receivedItems':
            $formData = $_POST;
            echo json_encode($inventory->save_receivedItems($formData));
            break;
        case 'save_quickInventory':
            $formData = $_POST;
            echo json_encode($inventory->save_quickInventory($formData));
            break;
        case 'get_allSuppliers':
            echo json_encode($inventory->get_allSuppliers());
            break;
        case 'get_purchaseOrderNo':
            echo json_encode($inventory->fetch_latestPONo());
            break;
        case 'get_allPurchaseOrders':
            echo json_encode($order->get_allPurchaseOrders());
            break;
        case 'get_allOrders':
            echo json_encode($order->get_allOrders());
            break;
        case 'get_orderData':
            $order_id = $_GET['order_id'];
            echo json_encode($order->get_orderData($order_id));
            break;
        case 'get_orderDataByPurchaseNumber':
            $po_number = $_GET['po_number'];
            echo json_encode($order->get_orderDataByPurchaseNumber($po_number));
            break;
        case 'get_orderDataById':
            $id = $_GET['id'];
            echo json_encode($order->get_orderDataById($id));
            break;
        case 'get_loss_and_damage_latest_reference_no':
            echo json_encode($loss_and_damage->get_latest_reference_no());
            break;
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
        case "updateVariants":
            $postData = json_decode(file_get_contents('php://input'), true);
            $id = isset($postData['id']) ? $postData['id'] : null;
            $variantName = isset($postData['variantName']) ? $postData['variantName'] : null;
            $category_id = isset($postData['category_id']) ? $postData['category_id'] : null;
            $result = $products->editVariantData($id, $variantName,$category_id);
            echo json_encode(['success' => true, 'result' =>$result]); 
            break;
        case "addSupplier":
            $formData = $_POST;
            $result =  $supplier->addSupplier($formData);
            echo json_encode([ 'success' => true, 'result' => $formData]);
            break; 
        case "getSuppliedProductsData";//supplier_id
            $supplier_id = isset($_GET['supplier_id']) ? $_GET['supplier_id'] : null;
            $result =  $supplier->getSuppliedProducts($supplier_id);
            echo json_encode(['success' => true, 'result' =>  $result]); 
            break;
        case "getSuppliedIngData":
            $supplier_id = isset($_GET['supplier_id']) ? $_GET['supplier_id'] : null;
            $result =  $supplier->getSuppliedIng($supplier_id);
            echo json_encode(['success' => true, 'result' =>  $result]); 
            break;
        case "updateSupplier":
            $formData = $_POST;
            $result =  $supplier->updateSupplier($formData);
            echo json_encode([ 'success' => true, 'result' => $formData]);
            break;
        case "addCustomer":
            $formData = $_POST;
            $result =  $userFacade->addCustomer($formData);
            echo json_encode([ 'success' => true, 'result' =>  $result]);
            break;
       case 'credentialsAdmin':
                $inputPassword = isset($_GET['credentials']) ? $_GET['credentials'] : null;
                $crdentials = $abilitties->checkCredentials($inputPassword);
                echo json_encode(["success" => true,
                "credentials" =>  $crdentials
                ]);
        break; 
        case 'getPermissionLevel':
            $userID =  isset($_GET['userID']) ? $_GET['userID'] : null;
            $permission = $abilitties->permission($userID);

            echo json_encode( ["success" => true,
            "permission" =>   $permission 
        ]);
        break; 
        case 'deleteProduct':
            $prod_id =  isset($_GET['prod_id']) ? $_GET['prod_id'] : null;
            $delete = $products->deleteProducts($prod_id);
            if ($delete) {
                echo json_encode(['success' => true, 'id' => $delete]); 
            } else {
                echo json_encode(['success' => false]); 
            }
            break;
        case 'importProduct':
                if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                    $formData = $_FILES['file'];
                    $importProduct = $products->importProducts($formData);
                    if ($importProduct) {
                        echo json_encode(['success' => true, 'message' => 'Products imported successfully']);
                    } else {
                        echo json_encode(['success' => false, 'error' => 'Failed to import products']);
                    }
                } else {
                    echo json_encode(['success' => false, 'error' => 'File upload failed']);
                }
                break;
            
        case 'updateCustomer':
            $formData = $_POST;
            $result =  $customer->updateCustomer($formData);
            echo json_encode([ 'success' => true, 'result' => $formData]);
            break;
        default:
            header("HTTP/1.0 400 Bad Request");
            break;
    }

