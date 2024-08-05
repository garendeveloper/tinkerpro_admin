<?php

include (__DIR__ . '/layout/header.php');
include (__DIR__ . '/utils/db/connector.php');
include (__DIR__ . '/utils/models/product-facade.php');
include (__DIR__ . '/utils/models/ability-facade.php');
$productFacade = new ProductFacade;

$userId = 0;

$abilityFacade = new AbilityFacade;

if (isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id'];
  

    $permissions = $abilityFacade->perm($userID);

    $accessGranted = false;
    foreach ($permissions as $permission) {
        if (isset($permission['Inventory']) && $permission['Inventory'] == "Access Granted") 
        {
            $accessGranted = true;
            break;
        }
    }
    if (!$accessGranted) {
      header("Location: 403.php");
      exit;
  }
} else {
    header("Location: login.php");
    exit;

}

if (isset($_SESSION["user_id"])) {
  $userId = $_SESSION["user_id"];
}
if (isset($_SESSION["first_name"])) {
  $firstName = $_SESSION["first_name"];
}
if (isset($_SESSION["last_name"])) {
  $lastName = $_SESSION["last_name"];
}
if ($userId == 0) {
  header("Location: login");
}
if (isset($_GET["add_product"])) {
  $error = $_GET["add_product"];
  array_push($success, $error);
}
if (isset($_GET["update_product"])) {
  $error = $_GET["update_product"];
  array_push($info, $error);
}
if (isset($_GET["delete_product"])) {
  $error = $_GET["delete_product"];
  array_push($info, $error);
}
include ('./modals/optionModal.php');

?>
<style>
  .horizontal-container {
    display: flex;
    align-items: center;
    width: 100%;
    max-width: 100%;
  }

  .italic-placeholder::placeholder {
    font-style: italic;
    font-weight: bold;
  }

  body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    margin: 0;
    padding: 0;
  }

  .autofit {
    width: 1%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .text-center {
    text-align: center;
  }

  .inventoryCard button {
    height: 40px;
  }

  @media (max-width: 600px) {
    .inventoryCard button {
      height: 30px;
    }
  }

  @media (max-width: 400px) {
    .inventoryCard button {
      height: 20px;
    }
  }

  @media (max-width: 600px) {
    .horizontal-container {
      flex-direction: column;
      align-items: flex-start;
    }

    .horizontal-container img {
      margin-bottom: 5px;
    }

    .horizontal-container .icon-button {
      flex: 0 0 100%;
      margin-left: 0;
      margin-top: 10px;
    }
  }
  /* tr.normal td {
      color: black;
      background-color: white;
  } */
  tr.highlighted td {
      color: white;
      background-color: red;
  }
  .highlighteds{
     border: 1px solid #00B050; 
  }
  .paginationTag {
    text-decoration: none; 
    border: 1px solid #fefefe;
    margin-right: 1px; 
    width: 40px;
    height: 40px;
    display: inline-flex; 
    justify-content: center;
    align-items: center; 
    background-color: #888888;
    color: #fefefe;
}

.paginationTag:hover{
  color: #FF6900;
}

    #paginationDiv{
      margin-top: 20px;
      margin-bottom: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .paginationTag {
    text-decoration: none;
    padding: 5px 10px;
    margin: 2px;
    border: 1px solid #ddd;
    color: #000;
}
.paginationTag:hover {
    background-color: #f0f0f0;
}
.paginationTag.active {
    background-color: #00B050;
    color: white;
    outline: none;
}


.inventoryCard tbody tr:hover{
  background-color: #292928;
}

#main-content {
    overflow: hidden;
}
.inventoryCard{
    width: 100%;
  }
    .inventoryCard thead {
        display: table; 
        width: calc(100% - 4px);
    }

    .inventoryCard tbody {
        display: block; 
        max-height: 61vh; 
        overflow-y: scroll;
    }

    .inventoryCard th, td {
        width: 9%;
        overflow-wrap: break-word; 
        box-sizing: border-box;
    }
    .inventoryCard tr {
        display: table;
        width: 100%;
    }
    .inventoryCard, table,  tbody{
      border: 1px solid #292928;
    }
    .inventoryCard table{
        background-color: #1e1e1e;
        border: 1px solid #262626;
        height: 5px;
        padding: 10px 10px;
    }
  @media (max-width: 1200px) {
      .inventoryCard th, .inventoryCard td {
          width: 9%; 
      }
  }

  @media (max-width: 992px) {
      .inventoryCard th, .inventoryCard td {
          width: 8%; 
      }
  }

  @media (max-width: 768px) {
      .inventoryCard th, .inventoryCard td {
          width: 7%;
      }
  }

  @media (max-width: 768px) {
      .inventoryCard {
          display: block;
          overflow-x: auto;
          -webkit-overflow-scrolling: touch;
      }
  }
.inventoryCard tbody::-webkit-scrollbar {
    width: 4px; 
}
.inventoryCard tbody::-webkit-scrollbar-track {
    background: #151515;
}
.inventoryCard tbody::-webkit-scrollbar-thumb {
    background: #888; 
    border-radius: 50px; 
}
  table thead{ 
    table-layout: fixed; 
    border-collapse: collapse; 

  } 

#tbl_products tbody th,
#tbl_products tbody td {
    padding: 8px 8px; 
    height: 20px; 
    line-height: 0.5; 
    border: 1px solid #292928;
   
}
#tbl_orders tbody th,
#tbl_orders tbody td {
    /* padding: 0px 1px; 
    height: 3px; 
    line-height: 0.1; 
    border: 1px solid #292928; */
  padding: 10px 10px; 
  height: 20px; 
  line-height: 0.5; 
  border: 1px solid #292928;
}

#tbl_all_stocks  tbody th,
#tbl_all_stocks tbody td {
  /* padding: 0px 1px; 
  height: 3px; 
  line-height: 0.1; 
  border: 1px solid #292928; */
  padding: 8px 8px; 
  height: 20px; 
  line-height: 0.5; 
  border: 1px solid #292928;
}

#tbl_all_lostanddamages tbody th,
#tbl_all_lostanddamages tbody td {
  padding: 8px 8px; 
  height: 20px; 
  line-height: 0.5; 
  border: 1px solid #292928;
    /* padding: 0px 1px; 
    height: 3px; 
    line-height: 0.1; 
    border: 1px solid #292928; */
}

#tbl_all_inventoryCounts tbody th,
#tbl_all_inventoryCounts tbody td {
  padding: 6px 6px; 
  height: 15px; 
  line-height: 0.5; 
  border: 1px solid #292928;
}
#tbl_previewRecord tbody th,
#tbl_previewRecord tbody td {
  padding: 2px 2px; 
  height: 10px; 
  line-height: 0.5; 
  font-size: 14px;
  border: 1px solid #292928;
}
#tbl_preview{
  width: 100%;
}
#tbl_preview tbody th,
#tbl_preview tbody td {
    padding: 7px 7px; 
    height: 30px; 
    line-height: 1;
    font-size: 12px;
    font-weight: normal;
    
}

#tbl_expiredProducts tbody th,
#tbl_expiredProducts tbody td {
    padding: 8px 8px; 
    height: 20px; 
    line-height: 0.5; 
    border: 1px solid #292928;
}


.inventoryCard button {
    height: 10;
}
.button-compress {
    white-space: nowrap; 
    overflow: hidden; 
    text-overflow: ellipsis; 
}
i:hover{
  color: var(--primary-color);
}
.inventoryCard i{
  padding: 0px;
}
  .productAnch {
      cursor: pointer;
  }

  .td-h {
      font-size: 12px;
      margin: 0; 
      padding: 0;
      height: auto; 
  }

  .highlightedss {
      background: var(--primary-color);
      color: #fff;
  }
  
  .highlightedss:hover {
      background: var(--primary-color) !important;
      color: #fff;
  }
  table tbody td {
      border: 1px solid #292928;
  }
 .expiring{
  color: #FF7F7F
 }


  .inventoryBtn {
    height: 35px;
    border: 1px solid transparent;
    background: #7C7C7C;
    box-shadow: none;
  }

 .searchProducts {
  width: 100%; 
  height: 35px;
  border-radius: 20px 0 0 20px;
  /* margin-left: 10px; 
  margin-right: 10px;  */
  font-size: 14px; 
 }

 #btn_openOption {
  border-radius: 0 20px 20px 0;
 }

.inventoryCard table {
  max-height: 70vh !important;
 margin-left: -18px !important;
 width: 101% !important;
}
</style>

<?php include "layout/admin/css.php" ?>
<div class="container-scroller" style = "background-color: #262626">
  <div class="main">
    <?php include 'layout/admin/sidebar.php' ?>
    <input type="hidden" value = "<?php echo $_SESSION['first_name'] ?>" id = "first_name">
    <input type="hidden" value = "<?php echo $_SESSION['last_name'] ?>" id = "last_name">
    <div class="main-panel main-content" id="main-content"
      style="display: grid; grid-template-columns: 4.5rem auto auto; align-items: center;background-color:#292928">
      <div class="content-wrapper" >
          <div class="d-flex justify-content-center align-items-center mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="#fff" class="bi bi-upc-scan" viewBox="0 0 16 16">
              <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5M3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0z"/>
            </svg>
            <input id = "searchInput" class="text-color searchProducts ms-2 ps-3" placeholder="Search Product,[code, barcode, name, brand]" autocomplete="off" autofocus/>
            <span class="inventoryBtn clearproductsBtn" id = "clear_inventory_search" style="background: #7C7C7C; height: 35px; cursor: pointer">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="38" fill="#fff" class="bi bi-x" viewBox="0 0 16 16">
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
              </svg>
            </span>

            <button id="searchBtn" name="productSearch" class="inventoryBtn" style="width:auto">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
              </svg>
            </button>
            <button id="btn_openOption"  class="inventoryBtn addProducts pe-3" style="width:auto ">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-menu-button-wide-fill" viewBox="0 0 16 16">
                <path d="M1.5 0A1.5 1.5 0 0 0 0 1.5v2A1.5 1.5 0 0 0 1.5 5h13A1.5 1.5 0 0 0 16 3.5v-2A1.5 1.5 0 0 0 14.5 0zm1 2h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1 0-1m9.927.427A.25.25 0 0 1 12.604 2h.792a.25.25 0 0 1 .177.427l-.396.396a.25.25 0 0 1-.354 0zM0 8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm1 3v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2zm14-1V8a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2zM2 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5"/>
              </svg>
            </button>
            <!-- <button class="inventoryBtn clearproductsBtn" style="width:auto; order: 1" id = "clear_inventory_search">&nbsp;Clear</button> -->
          </div>
        <div style = "margin-top: 10px;">
          <div class="tbl_buttonsContainer" style = "margin-left: -15px">
            <div class="division">
              <div class="grid-container">
                <button id="inventories" class="grid-item pos-setting text-color button"><i class="bi bi-box-seam"></i>&nbsp;
                  Inventories</button>
                <button id="stocks" class="grid-item pos-setting text-color button"><i class="bi bi-graph-up"></i>&nbsp;
                  Stocks</button>
                <button id="purchase-order" class="grid-item pos-setting text-color button"><i class="bi bi-cart-check"></i>&nbsp;
                  Purchase Orders <span id="unpaidExpirations" class="badge badge-danger"
                  style="font-size: 11px; background-color: red; color: fff; "></span></button>
                <button id="inventory-count" class="grid-item pos-setting text-color button"><i class="bi bi-archive"></i>&nbsp;
                  Inventory Count</button>
                <button id="loss-damage" class="grid-item pos-setting text-color button"><i class="bi bi-bug-fill"></i>&nbsp; Loss &
                  Damage</button>
                <button id="expiration" class="grid-item pos-setting text-color button"><i class="bi bi-calendar-x-fill"></i>&nbsp;
                  Expiration <span id="expirationNotification" class="badge badge-danger"
                    style="font-size: 11px; background-color: red; color: fff; "></span></button>

                <!-- <button id="bom" class="grid-item pos-setting text-color button"><i class="bi bi-file-earmark-spreadsheet"></i>&nbsp;  B.O.M</button> -->
                <!-- <button id="low-stocks" class="grid-item pos-setting text-color button"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp; Low Stocks</button>
                        <button id="reorder-point" class="grid-item pos-setting text-color button"><i class="bi bi-arrow-up-circle"></i>&nbsp; Re-order Point</button> -->
              </div>
            </div>
          
            <div class="division">
              <div class="grid-container">
                <!-- <button id="loss-damage" class="grid-item pos-setting text-color button"><i class="bi bi-bug-fill"></i>&nbsp; Loss & Damage</button> -->
                <!-- <button id="stock-transfer" class="grid-item pos-setting text-color button"><i class="bi bi-arrow-right-circle"></i>&nbsp; Stocks Transfer</button> -->
                <!-- <button id="expiration" class="grid-item pos-setting text-color button"><i class="bi bi-calendar-x-fill"></i>&nbsp; Expiration  <span id="expirationNotification" class="badge badge-danger" style = "font-size: 11px; background-color: red; color: white; "></span></button> -->
                <!-- <button id="loss-damage2" class="grid-item pos-setting text-color button"><i class="bi bi-exclamation-diamond-fill"></i>&nbsp; Loss & Damage</button> -->
                <!-- <button id="bom2" class="grid-item pos-setting text-color button"><i class="bi bi-journal-check"></i>&nbsp; B.O.M</button> -->
                <!-- <button id="print-price-tags" class="grid-item pos-setting text-color button"><i class="bi bi-printer"></i>&nbsp; Print Price Tags</button> -->
              </div>
            </div>
            <div class="division">
              <div class="grid-container">
                <!-- <button id="recalculate-stocks" class="grid-item pos-setting text-color button"><i class="bi bi-calculator-fill"></i>&nbsp; Recalculate Stocks</button> -->
              </div>
            </div>
          </div>
        </div>
     
        <div class="row " >
          <div class="card inventoryCard" style="width: 100%; height: 64vh; background-color: #262626 !important;margin-top: -20px; margin-left: 5px;"></div>   
          <div id="paginationDiv" ></div>
        </div>


        <div style="display: flex; margin-top: -5px; justify-content: space-between; ">
          <div>
            <button class="btn-control" id="printThis" style="width:160px; height:45px; margin-right: 10px"><svg version="1.1" id="_x32_" width="25px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="" stroke=""><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#ffff;} </style> <g> <path class="st0" d="M488.626,164.239c-7.794-7.813-18.666-12.684-30.578-12.676H409.01V77.861L331.145,0h-4.225H102.99v151.564 H53.955c-11.923-0.008-22.802,4.862-30.597,12.676c-7.806,7.798-12.665,18.671-12.657,30.574v170.937 c-0.008,11.919,4.847,22.806,12.661,30.589c7.794,7.813,18.678,12.669,30.593,12.661h49.034V512h306.02V409.001h49.037 c11.901,0.008,22.78-4.848,30.574-12.661c7.818-7.784,12.684-18.67,12.677-30.589V194.814 C501.306,182.91,496.436,172.038,488.626,164.239z M323.519,21.224l62.326,62.326h-62.326V21.224z M123.392,20.398l179.725,0.015 v83.542h85.491v47.609H123.392V20.398z M388.608,491.602H123.392v-92.801h-0.016v-96.638h265.217v106.838h0.015V491.602z M480.896,365.751c-0.004,6.353-2.546,11.996-6.694,16.17c-4.166,4.136-9.813,6.667-16.155,6.682h-49.049V281.75H102.974v106.853 H53.955c-6.365-0.015-12.007-2.546-16.166-6.682c-4.144-4.174-6.682-9.817-6.686-16.17V194.814 c0.004-6.338,2.538-11.988,6.686-16.155c4.167-4.144,9.809-6.682,16.166-6.698h49.034h306.02h49.037 c6.331,0.016,11.985,2.546,16.151,6.698c4.156,4.174,6.694,9.817,6.698,16.155V365.751z"></path> <rect x="167.59" y="336.155" class="st0" width="176.82" height="20.405"></rect> <rect x="167.59" y="388.618" class="st0" width="176.82" height="20.398"></rect> <rect x="167.59" y="435.255" class="st0" width="83.556" height="20.398"></rect> <path class="st0" d="M353.041,213.369c-9.263,0-16.767,7.508-16.767,16.774c0,9.251,7.504,16.759,16.767,16.759 c9.263,0,16.77-7.508,16.77-16.759C369.811,220.877,362.305,213.369,353.041,213.369z"></path> <path class="st0" d="M424.427,213.369c-9.262,0-16.77,7.508-16.77,16.774c0,9.251,7.508,16.759,16.77,16.759 c9.258,0,16.766-7.508,16.766-16.759C441.193,220.877,433.685,213.369,424.427,213.369z"></path> </g> </g></svg>&nbsp;Print</button>
            <button class="btn-control" id="generatePDFBtn" style="width:160px; height:45px; margin-right: 10px"><svg width="25px" height="25px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M2.5 6.5V6H2V6.5H2.5ZM6.5 6.5V6H6V6.5H6.5ZM6.5 10.5H6V11H6.5V10.5ZM13.5 3.5H14V3.29289L13.8536 3.14645L13.5 3.5ZM10.5 0.5L10.8536 0.146447L10.7071 0H10.5V0.5ZM2.5 7H3.5V6H2.5V7ZM3 11V8.5H2V11H3ZM3 8.5V6.5H2V8.5H3ZM3.5 8H2.5V9H3.5V8ZM4 7.5C4 7.77614 3.77614 8 3.5 8V9C4.32843 9 5 8.32843 5 7.5H4ZM3.5 7C3.77614 7 4 7.22386 4 7.5H5C5 6.67157 4.32843 6 3.5 6V7ZM6 6.5V10.5H7V6.5H6ZM6.5 11H7.5V10H6.5V11ZM9 9.5V7.5H8V9.5H9ZM7.5 6H6.5V7H7.5V6ZM9 7.5C9 6.67157 8.32843 6 7.5 6V7C7.77614 7 8 7.22386 8 7.5H9ZM7.5 11C8.32843 11 9 10.3284 9 9.5H8C8 9.77614 7.77614 10 7.5 10V11ZM10 6V11H11V6H10ZM10.5 7H13V6H10.5V7ZM10.5 9H12V8H10.5V9ZM2 5V1.5H1V5H2ZM13 3.5V5H14V3.5H13ZM2.5 1H10.5V0H2.5V1ZM10.1464 0.853553L13.1464 3.85355L13.8536 3.14645L10.8536 0.146447L10.1464 0.853553ZM2 1.5C2 1.22386 2.22386 1 2.5 1V0C1.67157 0 1 0.671573 1 1.5H2ZM1 12V13.5H2V12H1ZM2.5 15H12.5V14H2.5V15ZM14 13.5V12H13V13.5H14ZM12.5 15C13.3284 15 14 14.3284 14 13.5H13C13 13.7761 12.7761 14 12.5 14V15ZM1 13.5C1 14.3284 1.67157 15 2.5 15V14C2.22386 14 2 13.7761 2 13.5H1Z" fill="#ffff"></path> </g></svg>&nbsp;Save as PDF</button>
            <button class="btn-control" id="generateEXCELBtn" style="width:160px; height:45px;"><svg height="25px" width="25px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26 26" xml:space="preserve" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path style="fill:#ffff;" d="M25.162,3H16v2.984h3.031v2.031H16V10h3v2h-3v2h3v2h-3v2h3v2h-3v3h9.162 C25.623,23,26,22.609,26,22.13V3.87C26,3.391,25.623,3,25.162,3z M24,20h-4v-2h4V20z M24,16h-4v-2h4V16z M24,12h-4v-2h4V12z M24,8 h-4V6h4V8z"></path> <path style="fill:#ffff;" d="M0,2.889v20.223L15,26V0L0,2.889z M9.488,18.08l-1.745-3.299c-0.066-0.123-0.134-0.349-0.205-0.678 H7.511C7.478,14.258,7.4,14.494,7.277,14.81l-1.751,3.27H2.807l3.228-5.064L3.082,7.951h2.776l1.448,3.037 c0.113,0.24,0.214,0.525,0.304,0.854h0.028c0.057-0.198,0.163-0.492,0.318-0.883l1.61-3.009h2.542l-3.037,5.022l3.122,5.107 L9.488,18.08L9.488,18.08z"></path> </g> </g></svg>&nbsp;Save as Excel</button>
          </div>
          <div >
            <style>
              .title_div{
                text-align: right;
              }
              .tbl_value{
                color: #ffffff;
                text-align: right;
                width: 120px;
              }

            </style>
            <div id = "preview_records"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include ("./modals/purchaseQty_modal.php") ?>
  <?php include ("./modals/unpaid_purchase-modal.php") ?>
  <?php include ("./modals/paid_purchase-modal.php") ?>
  <?php include ("./modals/response-modal.php") ?>
  <?php include ("./modals/purchase_modal_payment.php") ?>
  <?php include ("./modals/received_payment_confirmation.php") ?>
  <?php include ("./modals/stockhistory.php") ?>
  <?php include ("layout/admin/keyboardfunction.php") ?>
  <?php include ("./modals/purchaseOrder_response.php") ?>
  <?php include ("./modals/lossanddamage_response.php") ?>
  <?php include('./modals/loading-modal.php'); ?>
  

  <?php include ("layout/footer.php") ?>

  <script>
  
  
    $(document).ready(function () {
    
      $('.container-scroller').click(function(event) {
        if ($(event.target).is('#optionModal')) {
            $('#optionModal').fadeOut();
        }
    });
    
      $("#inventory").addClass('active');
      $("#inventories").addClass('active');
      $("#pointer").html("Inventory");
      $(".otherinput").css('border', '1px solid white')
      $(".tablinks").click(function (e) {
        e.preventDefault();
        var tabId = $(this).data("tab");
        if (validateUnpaidSettings()) {
          $(".tabcontent").hide();
          $("#" + tabId).show();
          $(".tablinks").removeClass("active");
          $(this).addClass("active");
        }
      });
      $("#tab1").show();
      $(".tablinks[data-tab='tab1']").addClass("active");
      $('#paidSwitch').change(function () {
        if ($(this).is(':checked')) {
          $('.toggle-switch-container').css('color', '#28a745');
          $('#paidSwitch').css('background-color', '#28a745');
        }
        else {
          $('.toggle-switch-container').css('color', '');
          $('#paidSwitch').css('background-color', '');
        }
      });
    // $('#calendar-btn').off('click').on('click', function () {
    //   if (!$("#date_purchased").hasClass("flatpickr-open")) {
    //     if (!$("#date_purchased").hasClass("flatpickr-initialized")) {
    //         $("#date_purchased").flatpickr({
    //             dateFormat: "M d y",
    //             onClose: function(selectedDates) {
    //             }
    //         });
    //         $("#date_purchased").addClass("flatpickr-initialized");
    //     }
    //     if ($("#date_purchased").flatpickr()) {
    //         $("#date_purchased").flatpickr().open();
    //     }
    //   }
    // });

      $('#s_due').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'M dd y',
        altFormat: 'M dd y',
        altField: '#s_due',
        minDate: 0,
        onSelect: function (dateText, inst) { }
      });


      $('#calendar-btn2').on('click',function () {
        $('#s_due').datepicker('show');
      });

      $('#date_paid').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'M dd y',
        altFormat: 'M dd y',
        altField: '#date_paid',
        minDate: 0,
        onSelect: function (dateText, inst) { }
      });


      $('#calendar-btn3').click(function () {
        $('#date_paid').datepicker('show');
      });

      function validateUnpaidSettings() {
        var isValid = true;
        $('#tab3 input[type=text], input[type=date]').each(function () {
          if ($(this).val() === '') {
            isValid = false;
            $(this).addClass('has-error');
          }
          else {
            $(this).removeClass('has-error');
          }
        });
        return isValid;
      }
      function validateTab1() {
        var isValid = true;
        $('#tab1 input[type=text], input[type=date]').each(function () {
          if ($(this).val() === '') {
            isValid = false;
            $(this).addClass('has-error');
          }
          else {
            $(this).removeClass('has-error');
          }
        });
        return isValid;
      }
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var price_ids = ['price', 's_price', 'p_qty', 'u_qty', 'u_pay', 'loan_amount', 'interest_rate', 'loan_term'];
      price_ids.forEach(function (id) {
        var element = document.getElementById(id);
        if (element) {
          element.addEventListener('input', function (event) {
            this.value = this.value.replace(/[^0-9.]/g, '');
            let parts = this.value.split('.');
            if (parts[1] && parts[1].length > 2) {
              parts[1] = parts[1].slice(0, 2);
              this.value = parts.join('.');
            }
          });
        }
      });
    });
  </script>

  <script>
    var perPage = 25;
      let inventoryCurrentPage = 1;
      const inventoryPageSize = 300;

      var selected_products = [];
      var isSaving = false;
      var lastInputTime = 0; 
      var productsCache = [];
      var toastDisplayed =false;
      $("#tbl_orders").hide();

      show_allSuppliers();
      show_purchaseOrderNo();
      display_datePurchased();

      show_allInventories();
      function show_allInventories()
      {
        $.ajax({
              url: './pagination_data/inventory-pagination.php', 
              type: 'GET',
              success: function(response) {
                  $('#paginationDiv').html(response)
                  $("#searchInput").val("");
              },
              error: function(xhr, status, error) {
                  console.error(xhr.responseText); 
              }
          });
      }
      function show_allStocks()
      {
        $.ajax({
              url: './pagination_data/stocks-pagination.php', 
              type: 'GET',
              success: function(response) {
                  $('#paginationDiv').html(response)
                  $("#searchInput").val("");
              },
              error: function(xhr, status, error) {
                  console.error(xhr.responseText); 
              }
          });
      }
      function show_allOrders()
      {
        $.ajax({
              url: './pagination_data/orders-pagination.php', 
              type: 'GET',
              success: function(response) {
                  $('#paginationDiv').html(response)
                  $("#searchInput").val("");
              },
              error: function(xhr, status, error) {
                  console.error(xhr.responseText); 
              }
          });
      }
      function show_allInventoryCounts()
      {
        $.ajax({
              url: './pagination_data/inventoryCount-pagination.php', 
              type: 'GET',
              success: function(response) {
                  $('#paginationDiv').html(response)
                  $("#searchInput").val("");
              },
              error: function(xhr, status, error) {
                  console.error(xhr.responseText); 
              }
          });
      }
      function show_allLossAndDamagesInfo()
      {
        $.ajax({
              url: './pagination_data/lossanddamages-pagination.php', 
              type: 'GET',
              success: function(response) { 
                  $('#paginationDiv').html(response)
                  $("#searchInput").val("");
              },
              error: function(xhr, status, error) {
                  console.error(xhr.responseText); 
              }
          });
      }
      function show_expiredProducts()
      {
        $.ajax({
              url: './pagination_data/expirations-pagination.php', 
              type: 'GET',
              success: function(response) { 
                  $('#paginationDiv').html(response)
                  $("#searchInput").val("");
              },
              error: function(xhr, status, error) {
                  console.error(xhr.responseText); 
              }
          });
      }
      

      $("#clear_inventory_search").on("click", function(){
        $("#searchInput").val("");
        $("#searchInput").focus();
        $('#searchInput').keypress();
      })
      function progress_bar_process(response,percentage, timer)
      {
        $('.progressText').text(percentage + '%');
        if(percentage == 100)
        {
          percentage = 0;
          clearInterval(timer);
          $('#modalCashPrint').hide();
          var percentage = 0;
          
          var newBlob = new Blob([response], { type: 'application/pdf' });
          var blobURL = URL.createObjectURL(newBlob);

          var newWindow = window.open(blobURL, '_blank');
          if (newWindow) {
            newWindow.onload = function () {
              newWindow.print();
              newWindow.focus();
            };
          } 
        }
      }
      $("#printThis").on("click", function () {
       
        var active_tbl_id = $(".inventoryCard table").attr('id');
    
        if (active_tbl_id !== 'tbl_all_inventoryCounts' && active_tbl_id !== 'tbl_all_stocks') {
          $(".progressText").text('0%');
          $('#modalCashPrint').show();
          $.ajax({
            url: './reports/generate_inventory_pdf.php',
            type: 'GET',
            xhrFields: {
              responseType: 'blob'
            },
         
            data: {
              active_type: active_tbl_id,
            },
            success: function (response) {
              var percentage = 0;
              var timer = setInterval(function(){
              percentage = percentage + 20;
              if(percentage == 100)
              {
                percentage = 100;
              }
              progress_bar_process(response, percentage, timer);
              }, 100);
            },
            error: function (xhr, status, error) {
              console.error(xhr.responseText);
            },
           
        
          });
        }
        else {
          var message = "Unfortunately, there are no download features available for this table.";
          show_errorResponse(message)
        }

      })
      $('#generateEXCELBtn').click(function () {
        var active_tbl_id = $(".inventoryCard table").attr('id');
  
        if (active_tbl_id !== 'tbl_all_inventoryCounts' && active_tbl_id !== 'tbl_all_stocks') 
        {
          $(".progressText").text('0%');
          $('#modalCashPrint').show();
          var fileName = active_tbl_id.replace("tbl_", "");
          $.ajax({
            url: './reports/generate_inventory_excel.php',
            type: 'GET',
            xhrFields: {
              responseType: 'blob'
            },
            data: {
              active_type: active_tbl_id,
            },
            success: function (response) {
              $('#modalCashPrint').hide();
              var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
              var link = document.createElement('a');
              link.href = window.URL.createObjectURL(blob);
              link.download = fileName + '.xlsx';
              document.body.appendChild(link);
              link.click();
              document.body.removeChild(link);
            },
            error: function (xhr, status, error) {
              console.error(xhr.responseText);
            }
          });
        }
        else {
          var message = "Unfortunately, there are no download features available for this table.";
          show_errorResponse(message)
        }
      });
      $("#generatePDFBtn").on("click", function () {
        var active_tbl_id = $(".inventoryCard table").attr('id');
        if (active_tbl_id !== 'tbl_all_inventoryCounts' && active_tbl_id !== 'tbl_all_stocks') {
          $(".progressText").text('0%');
          $('#modalCashPrint').show();
          $.ajax({
            url: './reports/generate_inventory_pdf.php',
            type: 'GET',
            xhrFields: {
              responseType: 'blob'
            },
            data: {
              active_type: active_tbl_id,
            },
            success: function (response) {
              $('#modalCashPrint').hide();
              var blob = new Blob([response], { type: 'application/pdf' });
              var url = URL.createObjectURL(blob);
              var a = document.createElement('a');
              a.href = url;
              a.download = 'inventory.pdf';
              document.body.appendChild(a);
              a.click();

              URL.revokeObjectURL(url);
              document.body.removeChild(a);
            },
            error: function (xhr, status, error) {
              console.error(xhr.responseText);
            }
          });
        }
        else {
          var message = "Unfortunately, there are no download features available for this table.";
          show_errorResponse(message)
        }
      })
      $("#purchase-order").on('click', function () {
        $(".grid-container button").removeClass('active');
        $(this).addClass('active');
        show_allOrders();
        $("#tbl_products").hide();
      })
      $("#purchase_modal_payment_form").on("submit", function (e) {
        e.preventDefault();
        var rem_balance = $("#rem_balance").val();
        if (rem_balance !== "₱ 0.00") {
          var formData = $(this).serialize();
          $.ajax({
            type: 'post',
            url: 'api.php?action=save_orderPayments',
            data: formData,
            success: function (response) {
              if (response.status) {
                show_allPaymentHistory();
              }
            }
          })
        }
        else {
          console.log("");
        }
      })
      function show_allPaymentHistory() {
        var order_id = $("#payment_order_id").val();
        $.ajax({
          type: 'GET',
          url: 'api.php?action=get_orderPaymentHistory',
          data: {
            order_id: order_id,
          },
          success: function (data) {
            $("#next_payment").val("");
            $("#rem_balance").val("");
            $("#payment_totalPaid").html("");
            $("#payment_balance").html("");
            $("#tbl_paymentHistory tbody").html("");
            $("#total_toPay").html("");
            var tbl_history = "";
            var total_paid = 0;
            var total_balance = 0;
            if (data.length > 0) {
              if ($("#purchase_modal_payment").is(":visible")) {
                $("#order_payment_setting_id").val(data[0].order_payment_setting_id);
                var installment = data[data.length - 1].order_balance !== "0.00" ? data[0].installment : 0;
                var balance = data[data.length - 1].order_balance !== "0.00" ? data[0].order_balance : 0;
                $("#next_payment").val("₱ " + addCommasToNumber(installment))
                $("#rem_balance").val("₱ " + addCommasToNumber(balance));
                $("#total_toPay").html("(" + "₱ " + addCommasToNumber(data[0].with_interest) + ")");
                for (var i = 0; i < data.length; i++) {
                  tbl_history += "<tr>";
                  tbl_history += "<td style = 'text-align: center'>" + date_format(data[i].date_paid) + "</td>";
                  tbl_history += "<td style = 'text-align: right'>₱ " + addCommasToNumber(data[i].payment) + "</td>";
                  tbl_history += "<td style = 'text-align: right'>₱ " + addCommasToNumber(data[i].order_balance) + "</td>";
                  tbl_history += "</tr>";
                  total_paid += parseFloat(data[i].payment);
                  total_balance += parseFloat(data[i].order_balance);
                }
                total_balance = balance === 0 ? "0.00" : total_balance;
                $("#payment_totalPaid").html("₱ " + addCommasToNumber(total_paid));
                $("#payment_balance").html("₱ " + addCommasToNumber(total_balance))
                $("#tbl_paymentHistory tbody").html(tbl_history);
              }
            }
          }
        });
      }
      $("#inventory-count").on('click', function () {
        $(".grid-container button").removeClass('active');
        $(this).addClass('active');
        show_allInventoryCounts();
      })
      $("#expiration").on('click', function () {
        $(".grid-container button").removeClass('active');
        $(this).addClass('active');
        show_expiredProducts();
      })
      $("#loss-damage").on('click', function () {
        $(".grid-container button").removeClass('active');
        $(this).addClass('active');
        show_allLossAndDamagesInfo();
      })
      $("#stocks").on('click', function () {
        $(".grid-container button").removeClass('active');
        $(this).addClass('active');
        show_allStocks();
      })
      $("#inventories").on('click', function () {
        $(".grid-container button").removeClass('active');
        $(this).addClass('active');
        show_allInventories();
      })
      $("#btn_refreshStockHistory").on("click",  function(e){
        e.preventDefault();
        var id = $("#stockhistory_modal #inventory_id").val();
        display_allStocksData(id);
      })
      function display_allStocksData(id)
      {
        $('#modalCashPrint').show();
        $.ajax({
          type: 'get',
          url: 'api.php?action=get_allStocksData',
          data: { 
            inventory_id: id
          },
          success: function (data) {
            $('#modalCashPrint').hide();
            var info = data.inventoryInfo;
            var stocks = data.stocks;
            var tbl_rows = [];
            $("#stockhistory_modal").fadeIn('show');
            $("#stockhistory_modal").find(".modal-title").html("<span style = 'font-weight: bold' class = 'text-custom'> "+info.prod_desc + "</span>&nbsp; - STOCK HISTORY")
            var tbl_rows = [];

            var stock_reference = info.product_stock > 0 ? "<span style = 'color: #90EE90'>" + info.product_stock + "</span>" : "<span style = 'color: #FFCCCC'>" + info.product_stock + "</span>";
            var new_stock = stocks.length !== 0 ? stock_reference : "0.00";

            for (var i = 0, len = stocks.length; i < len; i++) 
            {
              var stockItem = stocks[i];
              var stockDate = $.datepicker.formatDate("dd M yy", new Date(stockItem.stock_date));
              var stockTimestamp = stockItem.stock_date;
              var stock = stockItem.stock > 0 ? "<span style = 'color: #90EE90'>" + stockItem.stock + "</span>" : "<span style = 'color: #FFCCCC'>" + stockItem.stock + "</span>";

              tbl_rows.push(
                `<tr>
                  <td style = 'text-align: left;  font-size: 12px; font-weight: bold'>${stockItem.transaction_type}</td>
                  <td style = 'text-align: center;  font-size: 12px; font-weight: bold'>${stockItem.document_number}</td>
                  <td style = 'text-align: center;  font-size: 12px; font-weight: bold'>${stockItem.stock_customer}</td>
                  <td style = 'text-align: center;  font-size: 12px; font-weight: bold'>${stockDate}</td>
                  <td style = 'text-align: center;  font-size: 12px; font-weight: bold'>${stockTimestamp}</td>
                  <td style = 'text-align: right;  font-size: 12px; font-weight: bold'>${stockItem.stock_qty}</td>
                  <td style = 'text-align: right; font-size: 12px; font-weight: bold'>${stock}</td>
              </tr>`
              );
            }
            var tfoot = `<tr>
                  <td style = 'text-align: left;  font-size: 12px; font-weight: bold' colspan ='6'>Remaining Stock</td>
                  <td style = 'text-align: right; font-size: 12px; font-weight: bold; color: #ccc' >${new_stock}</td>
              </tr>`;

            $("#tbl_stocks_history tbody").html(tbl_rows);
            $("#tbl_stocks_history tfoot").html(tfoot);
          }
        })
      }
      $(".inventoryCard").on("click", "#btn_openStockHistory", function () {
        var id = $(this).data('id');
        $("#start_date").val("");
        $("#end_date").val("");
        $("#stockhistory_modal #inventory_id").val(id);
        display_allStocksData(id);
      })
      $(".inventoryCard").on("dblclick", "tr", function(){

        $(".scrollable").removeClass('hasLockImage');
        $("#inventorycount_div").removeClass('lock');
        $("#purchaseItems_div").removeClass('lock');
        $("#btn_savePO").removeClass('lockButton');


        var id = $(this).data('id');
        var active_tbl_id = $(".inventoryCard table").attr('id');
        switch(active_tbl_id)
        {
          case 'tbl_products':
            $(".purchase-grid-container button").removeClass('active');
            $("#btn_createPO").addClass('active');
            $("#expiration_div").hide();
            $("#received_div").hide()
            $("#quickinventory_div").hide();
            $("#stocktransfer_div").hide();
            $("#lossanddamage_div").hide();
            $("#inventorycount_div").hide();
            $("#purchaseItems_div").show();
            $("#po_form #product").focus();
            openOptionModal();
            $("#open_po_report").hide();
            $("#btn_omPayTerms").hide();
            $("#po_form #product").focus();

            $("#unpaid_identifier").val("0");
            $("#unpaid_order_id").val("0");
            $("#unpaid_purchase_modal .modal-content").css('height', '430px');
            $("#unpaid_purchase_modal #unpaid_toHide1").show();
            $("#unpaid_purchase_modal #unpaid_toHide2").show();

            $("#unpaid_purchase_modal #unpaid_hide1").show();
            $("#unpaid_purchase_modal #unpaid_hide2").show();
            $("#unpaid_purchase_modal #unpaid_hide3").show();
            $("#unpaid_purchase_modal #unpaid_hide4").hide();

            $("#unpaid_purchase_modal #btn_saveUnpaid").html('<i class = "bi bi-printer"></i>&nbsp; Save & Print');
            show_allSuppliers();
            break;
          case 'tbl_all_stocks':
            $("#start_date").val("");
            $("#end_date").val("");
            $("#stockhistory_modal #inventory_id").val(id);
            display_allStocksData(id);
            break;
          case 'tbl_all_inventoryCounts':
            $(".scrollable").addClass('hasLockImage');
            $("#inventorycount_div").addClass('lock');
            $("#btn_savePO").addClass('lockButton');
            show_inventoryCountDetails(id);
            break;
          case 'tbl_all_lostanddamages':
            show_lossanddamage_details(id);
            break;
          case 'tbl_orders':
            var to_received = $(this).data('to_receive');
            var po_number = $(this).data('po_number');
            if(to_received === 1)
            {
              $(".scrollable").addClass('hasLockImage');
              $("#purchaseItems_div").addClass('lock');
              $("#btn_savePO").addClass('lockButton');
            }
            if(to_received === 0)
            {
              openOptionModal();
              openReceivedItems();
              $("#r_PONumbers").val(po_number);
              $("#btn_searchPO").click();
            }
            else
            {
              orderdata(id, to_received);
            }
            break;
          default:
            break;
        }
       
      })

      $(".inventoryCard").off("click").on("click", "#btn_delete_lossanddamage", function(){
        var id = $(this).data('id');
        var reference = $(this).data('reference_no');
        $("#response_ld_id").val(id);
        $("#response_ld_reference").val(reference);
        var po_title = '<h6>Are you sure you want to delete the <i style="color: #FF6700">LOSS AND DAMAGE WITH REFERENCE: '+reference+'</i>?</h6>';
        po_title += '<h6>This action cannot be undone!</h6>';
        $("#lossanddamage_response .ld_title").html(po_title);
        $("#lossanddamage_response").slideDown({
          backdrop: 'static',
          keyboard: false,
        });
      });
      $("#ld_btn_continue").off("click").on("click", function(){
        var id = $("#response_ld_id").val();
        var reference_no = $("#response_ld_reference").val();
        $.ajax({
          type: 'get',
          url: 'api.php?action=delete_lossanddamage',
          data: {
            id: id,
            reference_no: reference_no,
            user: $("#first_name").val()+" "+$("#last_name").val(),
          },
          success: function(response){
            if(response.success)
            {
              show_allLossAndDamagesInfo();
              show_sweetReponse(response.message);
              $("#lossanddamage_response").hide();
            }
            else{
              show_errorResponse("Unable to delete the item.")
            }
          },
          error: function(error)
          {
            console.log("Server error!");
          }
        })
      });

      function show_lossanddamage_details(id)
      {
        $.ajax({
          type: 'get',
          url: 'api.php?action=get_lostanddamage_data',
          data: {
            id: id,
          },
          success: function (data) {
            var infoData = data.info;
            var ld_data = data.data;
            var tbody = $("#tbl_lossand_damages tbody");
            $("#ld_reference").val(infoData['reference_no']);
            $("#lossDamageInfoID").val(infoData['id']);
            $("#date_damage").val(date_format(infoData['date_transact']));
            $("#ld_reason").val(infoData['reason']);
            $("#footer_lossand_damages #total_qty").html(infoData['total_qty']);
            $("#footer_lossand_damages #total_cost").html("₱ " + infoData['total_cost']);
            $("#footer_lossand_damages #overall_total_cost").html("₱ " + infoData['over_all_total_cost']);
            $("#loss_and_damage_note").val(infoData['note']);
            var rows = [];
            for (var i = 0; i < ld_data.length; i++) {
              var inventory = ld_data[i];
              var row = "<tr data-id=" + inventory.inventory_id + " data-ld_id = "+inventory.loss_and_damage_id+">";
              row += "<td data-id = "+inventory.inventory_id+" style = 'width: 40%'>" + inventory.prod_desc + "</td>";
              row += "<td style='text-align:center; width: 15%'><input placeholder='QTY' style = 'text-align:center; width: 50px; height: 20px; font-size: 12px;' id = 'qty_damage' value = "+inventory.qty_damage+" ></input></td>";
              row += "<td style='text-align:right; width: 15%' id = 'cost' class='editable' data-id=" + data['cost'] + ">₱ " + addCommasToNumber(inventory.cost) + "</td>";
              row += "<td style='text-align:right; width: 15%' id = 'total_row_cost'>₱ " + addCommasToNumber(inventory.total_cost) + "</td>";
              rows.push(row);
            }
            tbody.html(rows.join(''));
          }
        })
        // $("#loss_and_damage_input").attr('disabled', true);
        // $("#btn_searchLDProduct").attr('disabled', true);
        $("#stocktransfer_div").hide();
        $("#received_div").hide()
        $("#quickinventory_div").hide()
        $("#expiration_div").hide()
        $("#lossanddamage_div").show();
        $(".purchase-grid-container button").removeClass('active');
        $("#btn_lossDamage").addClass('active');
        $("#purchaseItems_div").hide();
        $("#inventorycount_div").hide();
        $("#open_po_report").show();
        // $("#btn_savePO").attr("disabled", true);
        $("#btn_omPayTerms").hide();
        // $("#btn_omCancel").attr("disabled", true);
        $("#lossanddamage_form").find('input').removeClass('has-error');
        openOptionModal();
      }
      $(".inventoryCard").on('click', "#btn_view_lossanddamage", function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        show_lossanddamage_details(id);
      })
      function show_inventoryCountDetails(id)
      {

        $("#printcount_modal").find("#inv_id").val(id);
        $.ajax({
          type: 'get',
          url: 'api.php?action=get_inventoryCountDataById',
          data: {
            id: id,
          },
          success: function (data) {
            var infoData = data.info;
            var inventoryData = data.data;
            var tbody = $("#tbl_inventory_count tbody");
            $("#ic_reference").val(infoData['reference_no']);
            $("#inventory_count_info_id").val(infoData.id);
            $("#date_counted").val(date_format(infoData['date_counted']));

            var rows = [];
            for (var i = 0; i < inventoryData.length; i++) 
            {
              var inventory = inventoryData[i];
              var row = "<tr data-id=" + inventory.inventory_id + " data-ic_id = " + inventory.inventory_count_item_id + ">";
              row += "<td data-id=" + inventory.inventory_id + " style = 'width: 50%'>" + inventory.prod_desc + "</td>";
              row += "<td style='text-align:center' style = 'width: 20%'>" + inventory.counted_qty + "</td>";
              row += "<td class='text-right' style = 'width: 50px'><input placeholder='QTY' id = 'counted' style='text-align:center; width: 60px; height: 20px; font-size: 12px;' class='counted-input toLock' value = " + inventory.counted + " ></input></td>";
              var difference = inventory.difference;
              var differenceDisplay = difference > 0 ? "+" + difference : difference;
              row += "<td style='text-align: right; width: 50px'>" + differenceDisplay + "</td>";
              row += "</tr>";
              rows.push(row);
            }
            tbody.html(rows.join(''));
         
            $("#stocktransfer_div").hide();
            $("#received_div").hide()
            $("#quickinventory_div").hide()
            $("#expiration_div").hide()
            $("#lossanddamage_div").hide();
            $(".purchase-grid-container button").removeClass('active');
            $("#btn_inventoryCount").addClass('active');
            $("#purchaseItems_div").hide();
            $("#inventorycount_div").show();
            $("#open_po_report").show();
            $("#btn_omPayTerms").hide();
            $("#inventorycount_form").find('input').removeClass('has-error');
            openOptionModal();

          }
        })
      }
      $(".inventoryCard").on("click", "#btn_view_inventoryCount", function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        show_inventoryCountDetails();
      })
      function display_datePurchased() 
      {
        var currentDate = new Date();
        var formattedDate = formatDate(currentDate);
        $('#date_purchased').val(formattedDate);
      }
      $('#date_purchased').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'M dd y',
        altFormat: 'M dd y',
        altField: '#date_purchased',
        onSelect: function (dateText, inst) { }
      });
      $('#calendar-btn').on('click', function (e) {
          e.preventDefault();
          $('#date_purchased').datepicker('show');
      });

      function formatDate(date) {
        var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
          "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        var day = date.getDate();
        var monthIndex = date.getMonth();
        var year = date.getFullYear().toString().substr(-2);
        return monthNames[monthIndex] + ' ' + (day < 10 ? '0' : '') + day + ' ' + year;
      }
      function show_purchaseOrderNo() {
        $("#pcs_no").val("10-000000001");
        $.ajax({
          type: 'get',
          url: 'api.php?action=get_purchaseOrderNo',
          success: function (data) {
            $("#pcs_no").val(data);
          }
        })
      }
      function hideDropdownItems() {
        $('#tbl_purchaseOrders tbody tr').each(function () {
          var tableText = $(this).find('td').text();
          $('.search-dropdown-item').each(function () {
            if ($(this).text() === tableText) {
              $(this).hide();
            }
          });
        });
      }
      function resetPurchaseOrderForm() {
        show_purchaseOrderNo();
        display_datePurchased();
        $("#supplier").val("");
        $("#_order_id").val("0");
        $("#_inventory_id").val("0");
        $("#product").val("");
        $('#tbl_purchaseOrders tbody').empty();
        $("#po_form input[type=text], input[type=date]").removeClass('has-error');
      }
      $("#btn_omCancel").click(function () {
        resetPurchaseOrderForm();
      })
      var remove_inventories = [];

      // function updateTotal() {
      //   var totalQty = 0;
      //   var totalPrice = 0;
      //   var total = 0;
      //   var totalTax = 0;
      //   $('#tbl_purchaseOrders tbody tr').each(function () {
      //     var quantity = parseInt($(this).find('td:nth-child(2)').text().trim(), 10);
      //     var price = parseFloat(clean_number($(this).find('td:nth-child(3)').text().trim()));
      //     var subtotal = parseFloat(clean_number($(this).find('td:nth-child(4)').text().trim()));
      //     var tax = (price / 1.12);
      //     totalTax += (price - tax);
      //     totalQty += quantity;
      //     totalPrice += price;
      //     total += subtotal;
      //   });
      //   $("#totalTax").html("Tax: " + addCommasToNumber(totalTax));
      //   $("#totalQty").html(totalQty);
      //   $("#totalPrice").html("&#x20B1;&nbsp;" + addCommasToNumber(totalPrice));
      //   $("#overallTotal").html("&#x20B1;&nbsp;" + addCommasToNumber(total));
      // }
      $("#unpaid_form").on('submit', function (e) {
        e.preventDefault();
        var order_id = $("#_order_id").val();
        var identifier = $("#unpaid_identifier").val();
        var u_id = $("#unpaid_order_id").val(); 
        if(order_id > 0)
        {
          
          if (validateUPForUpdateForm()) 
          {
            $.ajax({
              type: 'POST',
              url: 'api.php?action=save_unpaidPaymentTerms',
              data: {
                unpaid_form: $("#unpaid_form").serialize(),
                order_id: order_id
              },
              success: function(response)
              {
                if(response.success)
                {
                  show_sweetReponse(response.message);
                  $("#unpaid_purchase_modal").hide();
                }
              },
              error: function(error){
                console.log("Error!")
              }
            })
          }
        } 
        else if(u_id > 0 && identifier > 0)
        {
          if (validateUPForUpdateForm()) 
          {
            $.ajax({
              type: 'POST',
              url: 'api.php?action=save_unpaidPayment',
              data: {
                unpaid_form: $("#unpaid_form").serialize(),
                order_id: order_id
              },
              success: function(response)
              {
                if(response.success)
                {
                  show_sweetReponse(response.message);
                  show_allOrders();
                  $("#unpaid_purchase_modal").hide();
                }
              },
              error: function(error){
                console.log("Error!")
              }
            })
          }
        }
        else
        {
          if (validateUPForUpdateForm()) {
            submit_purchaseOrder();
          }
        }
      })
      var isSavingPO = false;
      var totalPO = 0;
      let validationID;
      function submit_purchaseOrder() {
        totalPO =  $("#overallTotal").text();
        if (isSavingPO) return;
        var tbl_length = $("#tbl_purchaseOrders tbody tr").length;
        if (tbl_length > 0) {
          isSavingPO = true;
          var dataArray = [];
          $('#tbl_purchaseOrders tbody tr').each(function () {
            var rowData = {};
            $(this).find('td').each(function (index, cell) {
              if (index === 0) {
                rowData['product_id'] = $(cell).data('id');
                rowData['inventory_id'] = $(cell).data('inv_id');
              }
              rowData['column_' + (index + 1)] = $(cell).text();
            });
            dataArray.push(rowData);
          });
          var isPaid = $('#paidSwitch').prop('checked') ? 1 : 0; 
          validationID =   $("#_order_id").val();
          $.ajax({
            type: 'POST',
            url: 'api.php?action=save_purchaseOrder',
            data: {
              data: JSON.stringify(dataArray),
              po_number: $("#pcs_no").val(),
              isPaid: isPaid,
              date_purchased: $("#date_purchased").val(),
              supplier: $("#supplier").val(),
              product: $("#product").val(),
              total: $("#overallTotal").text(),
              totalPrice: $("#totalPrice").text(),
              totalTax: $("#totalTax").text(),
              totalQty: $("#totalQty").text(),
              order_id: $("#_order_id").val(),
              inventory_id: $("#_inventory_id").val(),
              remove_inventories: remove_inventories,
              unpaid_form: $("#unpaid_form").serialize(),
              amortization_frequency_text: $("#amortization_frequency option:selected").text(),
            },
            dataType: 'json',
            success: function (response) {
              isSavingPO = false;
              if (response.status) 
              {
                var order_id = response.order_id;
                var po_number = response.po_number;
                resetPurchaseOrderForm();
                $("#paid_purchase_modal").hide();
                $("#unpaid_form")[0].reset();
                $("#unpaid_purchase_modal").hide();
                $("#totalTax").html("0.00");
                $("#totalQty").html("0");
                $("#totalPrice").html("&#x20B1;&nbsp;0.00");
                $("#overallTotal").html("&#x20B1;&nbsp;0.00");
                show_sweetReponse(response.message);
                show_purchaseOrderNo();
                show_allSuppliers();
                display_datePurchased();
                show_allReceivedItems_PurchaseOrders();
                hideModals();
                $('#show_purchasePrintModal').show()
                var userInfo = JSON.parse(localStorage.getItem('userInfo'));
                var firstName = userInfo.firstName;
                var lastName = userInfo.lastName;
                var cid = userInfo.userId;
                var role_id = userInfo.roleId; 
                if(validationID > 0){
                  insertLogs('P.O Updated',firstName + ' ' + lastName + ' '+ 'P.0 #' + ' ' + po_number + ' ' + 'Amount:'+  totalPO)
                }else{
                  insertLogs('P.O Created',firstName + ' ' + lastName + ' '+ 'P.0 #' + ' ' + po_number + ' ' + 'Amount:'+  totalPO) 
                }
                if($('#show_purchasePrintModal').is(":visible"))
                {
                  $('#modalCashPrint').hide();
                    var loadingImage = document.getElementById("loadingImage");
                    loadingImage.removeAttribute("hidden");
                    var pdfFile= document.getElementById("pdfFile");
                    pdfFile.setAttribute('hidden',true);
                    $.ajax({
                        url: './toprint/purchaseorder_print.php',
                        type: 'GET',
                        xhrFields: {
                            responseType: 'blob'
                        },
                        data: {
                            order_id: order_id,
                            po_number: po_number,
                        },
                        success: function(response) {
                        loadingImage.setAttribute("hidden",true);
                        var pdfFile = document.getElementById("pdfFile");
                        pdfFile.removeAttribute('hidden')
                        if( loadingImage.hasAttribute('hidden')) {
                            var newBlob = new Blob([response], { type: 'application/pdf' });
                            var blobURL = URL.createObjectURL(newBlob);
                            
                            $('#pdfViewer').attr('src', blobURL);
                        }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
                $(".inventoryCard").html("");
                $(".grid-container button").removeClass('active');
                $("#purchase-order").addClass('active');
                show_allOrders();
              }
              else {
                $.each(response.errors, function (key, value) {
                  if (key === "isPaid") {
                    $("#" + key).addClass('switch-error');
                  }
                  else {
                    $('#' + key).addClass('has-error');
                  }
                });
              }
            },
            error: function (xhr, status, error) {
              alert("Something went wrong!");
            }
          });
        }
        else {
          show_errorResponse("The table should not be empty.")
        }
      }
      function show_allReceivedItems_PurchaseOrders() {
        $.ajax({
          type: 'GET',
          url: 'api.php?action=get_allPurchaseOrders',
          success: function (data) {
            var po_numbers = [];
            for (var i = 0; i < data.length; i++) {
              po_numbers.push(data[i].po_number);
            }
            $("#r_PONumbers").autocomplete({
              source: function (request, response) {
                var term = request.term.toLowerCase();
                var array = po_numbers.filter(function (row) {
                  return row.includes(term);
                });
                response(array.map(function (row) {
                  return {
                    label: row,
                    value: row,
                  };
                }));
              },
              select: function (event, ui) {
                var selectedItem = ui.value;
                return false;
              }
            });
          }
        });
      }
      $("#receive_form").on("submit", function(e){
           e.preventDefault();
            var po_number = $("#").val();
            if (po_number !== '') {
                if(po_number !== ""){
                    show_orders(po_number);
                    $("#receive_form #po_data_div").show();
                } else {
                    $("#receive_form #po_data_div").hide();
                    $("#receive_form #tbl_receivedItems tbody").empty();
                }
            } else {
                $("#po_data_div").hide();
            }
        });
      $("#received_payment_confirmation #btn_paidClose, #btn_paidCancel").click(function () {
        $("#received_payment_confirmation").hide();
      })
      function show_response(message) {
        var modal = $("#response_modal");
        $("#response_modal").slideDown({
          backdrop: 'static',
          keyboard: false,
        });
        $("#r_message").html("<i class = 'bi bi-check-circle-fill'></i>&nbsp;" + message);
        setTimeout(function () {
          $("#response_modal").slideUp();
        }, 3000);
      }
      function validateTableSubRowInputs(table_id) {
        var isValid = true;
        $('#' + table_id + ' tbody tr.sub-row input').each(function () {
          if (!$(this).val().trim()) {
            isValid = false;
            $(this).addClass('has-error');
          } else {
            $(this).removeClass('has-error');
          }
        });
        return isValid;
      }
      function validateTableInputs(table_id) {
        var isValid = true;
        $('#' + table_id + ' tbody tr:not(.sub-row) input').each(function () {
          if ($(this).attr('id') === 'date_expired') {
            return; 
          }
          if (!$(this).val().trim()) {
            isValid = false;
            $(this).addClass('has-error');
          } else {
            $(this).removeClass('has-error');
          }
        });
        return isValid;
      }

      function validate_loss_and_damage_form() {
        var isValid = true;
        $('#lossanddamage_form  input[type=date]').each(function () {
          if ($(this).val() === '') {
            isValid = false;
            $(this).addClass('has-error');
          }
          else {
            $(this).removeClass('has-error');
          }
        });

        return isValid;
      }

      function validate_inventorycount_form() {
        var isValid = true;
        $('#inventorycount_form input[type=text], input[type=date]').each(function () {
          if ($(this).val() === '' || $(this).val().trim() === '') {
            isValid = false;
            $(this).addClass('has-error');
          }
          else {
            $(this).removeClass('has-error');
          }
        });

        return isValid;
      }
      function show_reference_no() {
        $.ajax({
          type: 'get',
          url: 'api.php?action=get_loss_and_damage_latest_reference_no',
          success: function (data) {
            $("#ld_reference").val(data);
          }
        })
      }
      function show_inventory_count_reference_no() {
        $.ajax({
          type: 'get',
          url: 'api.php?action=get_inventorycount_latest_reference_no',
          success: function (data) {
            $("#ic_reference").val(data);
          }
        })
      }
      function show_expiration() {
        $.ajax({
          type: 'get',
          url: 'api.php?action=get_expirationNotification',
          success: function (data) {
            $("#tbl_expirationItems tbody").find("input[type=checkbox]").prop("checked", false);
            for (var i = 0; i < data.length; i++) {
              switch (data[i].notify_before) {
                case 30:
                  if (data[i].is_active === 1) {
                    $("#first_expiration").prop("checked", true);
                  }
                  break;
                case 15:
                  if (data[i].is_active === 1) {
                    $("#second_expiration").prop("checked", true);
                  }
                  break;
                case 5:
                  if (data[i].is_active === 1) {
                    $("#third_expiration").prop("checked", true);
                  }
                  break;
                case 0:
                  if (data[i].is_active === 1) {
                    $("#fourth_expiration").prop("checked", true);
                  }
                  break;
                default:
                  break;
              }
            }
          }
        })
      }
      function show_sweetReponse(message) {
        toastr.options = {
          "onShown": function () {
            $('.custom-toast').css({
              "opacity": 1,
              "width": "600px",
              "text-align": "center",
            });
          },
          "closeButton": true,
          "positionClass": "toast-top-right",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "progressBar": true,
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut",
          "tapToDismiss": false,
          "toastClass": "custom-toast",
          "onclick": function () {  }

        };
        toastr.success(message);
      }
      function show_errorResponse(message) {
        if (toastDisplayed) {
                return; 
            }

        toastDisplayed = true; 

        toastr.options = {
          "onShown": function () {
            $('.custom-toast').css({
              "opacity": 1,
              "width": "600px",
              "text-align": "center",
              "border": "2px solid #1E1C11",
            });
          },
          "closeButton": true,
          "positionClass": "toast-top-right",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "progressBar": true,
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut",
          "tapToDismiss": false,
          "toastClass": "custom-toast",
          "onclick": function () {  }

        };
        toastr.error(message);
      }

      $("#btn_savePO").off("click").on("click", function (e) {
        e.preventDefault();
   
        var activeModuleId = $("button.active").attr('id');
        if (activeModuleId === "btn_expiration") {
          $('#modalCashPrint').show();
          var tbl_data = [];
          $("#tbl_expirationItems tbody tr").each(function () {
            var row_data = {};
            var notify_before = $(this).find("td:nth-child(2)").text();
            row_data['label'] = notify_before;
            row_data['value'] = $(this).find("input[type=checkbox]").prop("checked");
            tbl_data.push(row_data);
          })
          $.ajax({
            type: 'post',
            url: 'api.php?action=save_expirationNotification',
            data: { notifications: JSON.stringify(tbl_data) },
            success: function (response) {
              if (response.status) 
              {
                show_sweetReponse(response.msg);
                hideModals();
                $(".inventoryCard").html("");
                $(".grid-container button").removeClass('active');
                $("#expiration").addClass('active');
                show_expiration();
                show_expiredProducts();

                var userInfo = JSON.parse(localStorage.getItem('userInfo'));
                var firstName = userInfo.firstName;
                var lastName = userInfo.lastName;
                var cid = userInfo.userId;
                var role_id = userInfo.roleId; 

                insertLogs('Expiration', "Updated inventory expiration settings");

                $('#modalCashPrint').hide();
              }
            }
          })
        }
        if (activeModuleId === "btn_quickInventory") {
          var rowCount = $("#tbl_quickInventories tbody tr").length;
          if(rowCount > 0)
          {
            if(validateTableInputs("tbl_quickInventories"))
            {
              $('#modalCashPrint').show();
              var formData = $("#quickinventory_form").serialize();
              var tbl_data = [];
              $("#tbl_quickInventories tbody tr").each(function () {
                var rowData = {};
                rowData['inventory_id'] = $(this).data('id');
                $(this).find("td").each(function (index, cell) {
                  if (index === 2)
                    rowData['newqty'] = $(cell).find("#qty").val();
                  rowData['col_' + (index + 1)] = $(cell).text();
                })
                tbl_data.push(rowData);
              })
          
              $.ajax({
                type: 'POST',
                url: 'api.php?action=save_quickInventory',
                data: {
                  tbl_data: JSON.stringify(tbl_data),
                  user_name: $("#first_name").val()+" "+$("#last_name").val(),
                },
                success: function (response) {
                  if (response.status) 
                  {
                    show_sweetReponse(response.msg);
                    var po_number = $("#q_product").val();
                    $("#tbl_quickInventories tbody").empty();
                    hideModals();

                    $(".inventoryCard").html("");
                    $(".grid-container button").removeClass('active');
                    $("#stocks").addClass('active');
                    show_allStocks();

                    var userInfo = JSON.parse(localStorage.getItem('userInfo'));
                    var firstName = userInfo.firstName;
                    var lastName = userInfo.lastName;
                    var cid = userInfo.userId;
                    var role_id = userInfo.roleId; 

                    $.each(tbl_data, function(index, item){
                      insertLogs('Quick Inventory', "Quick inventory: "+item.col_1 + " From: "+item.col_2 + " To: "+item.newqty);
                    })
                    $('#modalCashPrint').hide();
                  }
                }
              })
            }
          }
          else
          {
            $("#q_product").addClass('has-error');
            $("select[name='inventory_type']").addClass('has-error');
          }
        }
        if (activeModuleId === "btn_inventoryCount") {
          var rowCount = $("#tbl_inventory_count tbody tr").length;
          if(rowCount > 0)
          {
            if(validateTableInputs("tbl_inventory_count"))
            {
              $('#modalCashPrint').show();
              var tbl_data = [];
              $("#tbl_inventory_count tbody tr").each(function () {
                var rowData = {};
                rowData['inventory_id'] = $(this).data('id');
                rowData['inventory_count_item_id'] = $(this).data('ic_id');
                rowData['qty'] = $(this).find("td:nth-child(2)").text();
                rowData['counted'] = $(this).find("#counted").val();
                rowData['difference'] = $(this).find("td:nth-child(4)").text();

                tbl_data.push(rowData);
              });
              var reference_no = $("#ic_reference").val();
              var date_counted = $("#date_counted").val();
              $.ajax({
                type: 'post',
                url: 'api.php?action=save_inventory_count',
                data: {
                  tbl_data: JSON.stringify(tbl_data),
                  reference_no: $("#ic_reference").val(),
                  date_counted: $("#date_counted").val(),
                  refer_id: $("#inventory_count_info_id").val(),
                  user_name: $("#first_name").val()+" "+$("#last_name").val(),
                },
                success: function (response) {
                  if (response.status) {
                    show_sweetReponse(response.msg);
                    $("#tbl_inventory_count tbody").empty();
                    $("#inventorycount_form")[0].reset();
                    show_inventory_count_reference_no();
                    hideModals();

                    $(".inventoryCard").html("");
                    $(".grid-container button").removeClass('active');
                    $("#inventory-count").addClass('active');
                    show_allInventoryCounts();

                    var userInfo = JSON.parse(localStorage.getItem('userInfo'));
                    var firstName = userInfo.firstName;
                    var lastName = userInfo.lastName;
                    var cid = userInfo.userId;
                    var role_id = userInfo.roleId; 
                    
                    insertLogs('Inventory Count', "Successfully inventory count with reference #: "+reference_no + " Date: "+date_counted);
                    $('#modalCashPrint').hide();
                  }
                }
              })
            }
          }
          else
          {
            if (validate_inventorycount_form()) {
              var inventory_type = $("#qi_inventory_type").val();
              if (inventory_type !== "") {
                validateTableInputs("tbl_inventory_count")
              }
              else {
                $("#qi_inventory_type").css('border', '1px solid red');
              }
            }
          }
        }
        if (activeModuleId === "btn_lossDamage") {
          var loss_and_damage_length = $("#tbl_lossand_damages tbody tr:not(.sub-row)").length;
          if (validate_loss_and_damage_form()) {
            if (loss_and_damage_length > 0) {
              $('#modalCashPrint').show();
              var table_id = "tbl_lossand_damages";
              var loss_and_damage_form = $("#lossanddamage_form").serialize();
              if (validateTableInputs(table_id)) {
                var tbl_data = [];
                var subRowData = [];
                $("#tbl_lossand_damages tbody tr:not(.sub-row)").each(function () {
                  var row_data = {};
                  row_data['inventory_id'] = $(this).data('id');
                  row_data['damageID'] = $(this).data('ld_id');
                  $(this).find("td").each(function (index, cell) {
                    if (index === 1) {
                      row_data['qty_damage'] = $(cell).find("#qty_damage").val();
                    }
                    row_data['col_' + (index + 1)] = $(cell).text();
                  })
                  tbl_data.push(row_data);
                })
                $("#tbl_lossand_damages tbody .sub-row").each(function () {
                  var row_data = {};
                  row_data['inventory_id'] = $(this).data('id');
                  $(this).find("td").each(function (index, cell) {
                    row_data['is_serialCheck'] = $(cell).find("#serial_ischeck").prop('checked');
                    row_data['serial_number'] = $(cell).find("#serial_number").val();
                    row_data['serial_id'] = $(cell).data('id');
                  })
                  subRowData.push(row_data);
                })

                var reference = $("#ld_reference").val();
                var date_damage = $("#date_damage").val();
                var total_qty = $("#footer_lossand_damages thead").find("#total_qty").text();
                var total_cost = $("#footer_lossand_damages thead").find("#total_cost").text();
                var overall_total_cost = $("#footer_lossand_damages thead").find("#overall_total_cost").text();
                $.ajax({
                  type: 'post',
                  url: 'api.php?action=save_loss_and_damage',
                  data: {
                    tbl_data: JSON.stringify(tbl_data),
                    sub_row_data: JSON.stringify(subRowData),
                    note: $("#loss_and_damage_note").val(),
                    total_qty: total_qty,
                    total_cost: total_cost,
                    over_all_total_cost: overall_total_cost,
                    loss_and_damage_form: loss_and_damage_form,
                    user_name: $("#first_name").val()+" "+$("#last_name").val(),
                  },
                  success: function (response) {
                    if (response.status) {
                      show_sweetReponse(response.msg);
                      $("#lossanddamage_form")[0].reset();
                      $("#tbl_lossand_damages tbody").empty();
                      $("#footer_lossand_damages thead").find("#total_qty").html("0");
                      $("#footer_lossand_damages thead").find("#total_cost").html("₱ 0.00");
                      $("#footer_lossand_damages thead").find("#overall_total_cost").html("₱ 0.00");
                      $("#loss_and_damage_note").val("");
                      show_reference_no();
                      hideModals();

                      $(".inventoryCard").html("");
                      $(".grid-container button").removeClass('active');
                      $("#loss-damage").addClass('active');
                      show_allLossAndDamagesInfo();

                      var userInfo = JSON.parse(localStorage.getItem('userInfo'));
                      var firstName = userInfo.firstName;
                      var lastName = userInfo.lastName;
                      var cid = userInfo.userId;
                      var role_id = userInfo.roleId; 

                      insertLogs('Loss and Damages', "Declared loss and damages with reference #: "+reference + " Date: "+date_damage + " Total Amount"+overall_total_cost);
                      $('#modalCashPrint').hide();
                    }
                  }
                })
              }
            }
            else {
              show_errorResponse("Please add a product");
            }
          }
        }
        if (activeModuleId === "btn_receiveItems") {
          var table_id = "tbl_receivedItems";
          var received_items_length = $("#tbl_receivedItems tbody tr").length;
          if (received_items_length > 0) {
            if (validateTableInputs(table_id)) {
              $('#modalCashPrint').show();
                if (isSaving) return;
                isSaving = true;
                var tbl_data = [];
                var subRowData = [];
                $("#tbl_receivedItems tbody tr:not(.sub-row)").each(function () {
                  var rowData = {};
                  rowData['isSelected'] = $(this).find("#receive_item").prop("checked");
                  rowData['inventory_id'] = $(this).data('id');
                  rowData['isSerialized'] = $(this).find("#check_isSerialized").hasClass('checked');
                  rowData['qty_received'] = $(this).find("td:nth-child(4)").text();
                  rowData['date_expired'] = $(this).find("td:nth-child(5)").text();
                  tbl_data.push(rowData);
                })
                $('#tbl_receivedItems tbody .sub-row').each(function () {
                  var rowData = {};
                  rowData.inventory_id = $(this).data('id');
                  rowData.serial_number = $(this).find('input').val();
                  rowData.serial_id = $(this).find("#serial_id").data('id');
                  subRowData.push(rowData);
                });
                var receive_form = $("#receive_all").serialize();
                var po_number = $("#r_po_number").text();
                var supplier = $("#r_supplier").text();
        
                
                $.ajax({
                  type: 'POST',
                  url: 'api.php?action=save_receivedItems',
                  data: {
                    tbl_data: JSON.stringify(tbl_data),
                    receive_form: receive_form,
                    subRowData: JSON.stringify(subRowData),
                    po_number: $("#r_po_number").text(),
                    supplier: $("#r_supplier").text(),
                    is_received: $("#is_received").val(),
                    isPaid: $("#order_isPaid").val(),
                    user_name: $("#first_name").val()+" "+$("#last_name").val(),
                  },
                  success: function (response) {

                    if (response.status)
                    {
                      show_sweetReponse(response.msg);
                      $('#modalCashPrint').hide();
                      $("#r_PONumbers").val("");
                      $("#is_received").val("0");
                      $("#tbL_receivedItems tbody").empty();
                      $("#po_data_div").hide();
                      $("#received_payment_confirmation").hide();
                      show_allReceivedItems_PurchaseOrders();
                      $("#purchase-order").addClass('active');
                      show_allOrders();
                      isSaving = false;
                      hideModals();

                      var userInfo = JSON.parse(localStorage.getItem('userInfo'));
                      var firstName = userInfo.firstName;
                      var lastName = userInfo.lastName;
                      var cid = userInfo.userId;
                      var role_id = userInfo.roleId; 

                      insertLogs('Received Items', "Tender received items, PO Number: "+po_number+" Supplier: "+supplier);
                    }
                  },
                  error: function (error) {
                    console.log("server error!")
                  }
                })
              // })
            }
          }
          else {
            show_errorResponse("Please find a purchase number first!");
          }
        }
        if (activeModuleId === "btn_createPO")
        {
          var tbl_poL = $("#po_body tr").length;
          if (tbl_poL > 0) {
            $('#modalCashPrint').show();
            var order_id = $("#_order_id").val();
            if (order_id > 0) {
              submit_purchaseOrder();
            }
            else {
              if ($("#paidSwitch").prop("checked") === false) {
                $("#unpaid_purchase_modal").slideDown({
                  backdrop: 'static',
                  keyboard: false,
                });
                var amount = clean_number($("#overallTotal").text());
                amount = amount.replace(/,/g, '');
                $("#unpaid_term").focus();
                $("#unpaid_form")[0].reset();
                $("#unpaid_note").val("");
                $("#unpaid_amount").val(amount);
                $("#unpaid_amount").attr("max", amount);
                $("#unpaid_amount").on("input", function() {
                    var enteredValue = $(this).val().replace(/,/g, '');
                    if (parseFloat(enteredValue) > parseFloat(amount)) {
                      $(this).val(amount);
                    }
                });
                
              }
              else {
                submit_purchaseOrder();
              }
            }
          }
          else if (tbl_poL === 0 && validatePOForm()) {
            show_errorResponse("Kindly add a product to your cart to proceed with the purchase.");
          }
          else {
            validatePOForm();
          }
        }
      })
    
      function roundToTwoDecimalPlaces(number) {
        return parseFloat(number).toFixed(2);
      }
      function validatePOForm() {
        var isValid = true;
        $('#po_form input[type=text], #po_form input[type=date]').each(function () {
          if ($(this).val() === '') {
            isValid = false;
            $(this).addClass('has-error');
          }
          else {
            $(this).removeClass('has-error');
          }
        });

        return isValid;
      }
      function validateUPForm()
      {
          var isValid = true;
          $('#unpaid_form input[type=text], #unpaid_form input[type=number], #unpaid_form input[type=date]').each(function () {
              if ($(this).val().trim() === '') { 
                  isValid = false;
                  $(this).addClass('has-error');
              }
          });

          return isValid;
      }
      function validateUPForUpdateForm()
      {
          var isValid = true;
          $('#unpaid_form input[type=text]:visible, #unpaid_form input[type=number]:visible, #unpaid_form input[type=date]:visible').each(function () {
              if ($(this).val().trim() === '') { 
                  isValid = false;
                  $(this).addClass('has-error');
              }
          });

          return isValid;
      }
      function validatePOForm() {
        var isValid = true;
        $('#po_form input[type=text], input[type=date]').each(function () {
          if ($(this).val() === '') {
            isValid = false;
            $(this).addClass('has-error');
          }
          else {
            $(this).removeClass('has-error');
          }
        });

        return isValid;
      }

      function addCommasToNumber(number) {
        var roundedNumber = Number(number).toFixed(2);
        var parts = roundedNumber.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
      }
      $("#btn_pqtyClose, #btn_pqtyCancel").on('click', function (e) {
        e.preventDefault();
        $("#purchaseQty_modal").hide();
        $("#unpaid_purchase_modal").hide();
      })
      $("#btn_paidClose, #btn_paidCancel").on('click', function (e) {
        e.preventDefault();
        $("#paid_purchase_modal").hide();
      })
      $("#btn_pqtyCancel").click(function () {
        $("#prod_form")[0].reset();
      })
      $("#paginationDropdown").change(function () {
        perPage = $(this).val();
        show_allInventories();
      })
      // var i_quantities = ['#p_qty', '#u_qty'];

      // i_quantities.forEach(function (id) {
      //   $(id).on('input', function (e) {
      //     var inputValue = $(this).val();
      //     inputValue = inputValue.replace(/\D/g, '');
      //     $(this).val(inputValue);
      //   });
      // });
      
      $('#po_form').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
          type: "POST",
          url: "api.php?action=save_purchaseOrder",
          data: formData,
          success: function (response) {
            $.each(response.errors, function (key, value) {
              $('#' + key).addClass('has-error');
            });
          }
        });
      });
      function show_allSuppliers() {
        $.ajax({
          type: 'GET',
          url: 'api.php?action=get_allSuppliers',
          success: function (data) {
            var options = "";
            for (var i = 0; i < data.length; i++) {
              options += "<option>"+data[i].supplier+"</option>";
            }
           $("#supplier").html(options);
            $("#supplier option:first").attr('selected', 'selected');
          }
        })
      }
      

      var finish = 0;
     
      
      function date_format(date) 
      {
        var date = new Date(date);
        var formattedDate = $.datepicker.formatDate("M dd yy", date);
        return formattedDate;
      }
        $(".inventoryCard").on("click", "#btn_removeOrder", function(e){
          e.preventDefault();
          var is_received = $(this).data('isreceived');
          var order_id = $(this).data("id");
          var isPaid = $(this).data("ispaid");
        
          var po_number = $(this).data("po_number");
          if(isPaid === 1)
          {
            var po_title = '<h6 style = "color: #FF9999; font-weight: bold">Sorry, the <i style = "color: red">PURCHASE ORDER</i> cannot be removed; the order may have already been received or paid.</h6>';
            $("#purchaseOrder_response .po_title").html(po_title);
            var userInfo = JSON.parse(localStorage.getItem('userInfo'));
                var firstName = userInfo.firstName;
                var lastName = userInfo.lastName;
                var cid = userInfo.userId;
                var role_id = userInfo.roleId; 
              
              
                insertLogs('Denied','Tries to delete' + ' ' + 'P.O order id #:' + ' ' + po_number )
                
            $("#purchaseOrder_response").slideDown({
              backdrop: 'static',
              keyboard: false,
            });
            $("#response_order_id").val("0");
            $("#po_btn_continue").hide();
          }
          else
          {
            var po_title = '<h6>Are you sure you want to delete the <i style="color: #FF6700">PURCHASE ORDER</i>?</h6>';
            po_title += '<h6>This action cannot be undone!</h6>';
            $("#purchaseOrder_response .po_title").html(po_title);
            $("#purchaseOrder_response").slideDown({
              backdrop: 'static',
              keyboard: false,
            });
            $("#response_order_id").val(order_id);
            $("#po_btn_continue").show();
          }
        })
      $("#po_btn_continue").on("click", function(){
        $.ajax({
            type: 'get',
            url: 'api.php?action=delete_purchaseOrder',
            data: {
                id: $("#response_order_id").val(),
            },
            success: function(response){
      
                if(response.status)
                {
                  $("#purchaseOrder_response").hide();
                  $("#response_order_id").val("");
                  show_sweetReponse(response.message);
                  show_allOrders();
                  show_allReceivedItems_PurchaseOrders();
                }
            },
            error: function(response)
            {
                console.log("Server Error:")
            }
        })
      })
     
     
      function maskPONumber(poNumber) 
      {
          if (poNumber.length > 10) 
          {
              var firstPart = poNumber.substring(0, 2);
              var middlePart = "XXXXXXX"; 
              var lastPart = poNumber.substring(poNumber.length - 3); 

              var maskedPO = firstPart + "-" + middlePart + lastPart; 
              return maskedPO; 
          } else {
              return poNumber; 
          }
      }
      function orderdata(order_id, to_received)
      {
        if(to_received === 0)
        {
          $(".scrollable").removeClass('hasLockImage');
          $("#purchaseItems_div").removeClass('lock');
          $("#btn_savePO").removeClass('lockButton');
        }
        $("#stocktransfer_div").hide();
        $("#received_div").hide()
        $("#quickinventory_div").hide()
        $("#expiration_div").hide()
        $("#lossanddamage_div").hide()
        $("#inventorycount_div").hide();
        $(".purchase-grid-container button").removeClass('active');
        $("#btn_createPO").addClass('active');
        $("#purchaseItems_div").show();
        openOptionModal();
        $("#open_po_report").show();

        $.ajax({
          type: 'GET',
          url: 'api.php?action=get_orderData&order_id=' + order_id,
          dataType: 'json',
          success: function (data) {
            var table = "";
            var tbl_report = "";
            $("#supplier").val(data[0].supplier);
            $("#date_purchased").val(date_format(data[0].date_purchased));
            $("#_order_id").val(data[0].order_id);
            $("#_inventory_id").val(data[0].inventory_id);
            $("#pcs_no").val(data[0].po_number);

            $("#rep_po").html(data[0].po_number);
            $("#rep_supplier").html(data[0].supplier);
            $("#rep_datePurchased").html(date_format(data[0].date_purchased));
            var isPaid = data[0].isPaid === 1 ? "Yes" : "No";
            $("#rep_isPaid").html(isPaid);

            if (isPaid === "Yes") {
              $("#btn_omPayTerms").hide();
              $("#paidSwitch").css('background-color', 'green');
              $('#paidSwitch').prop('checked', true).prop('disabled', true);
            }
            else {
              $("#btn_omPayTerms").show();
              $("#paidSwitch").css('background-color', '#ffff');
              $('#paidSwitch').prop('checked', false).prop('disabled', true);
            
              $("#unpaid_identifier").val("0");
              $("#unpaid_order_id").val("0");
              $("#unpaid_purchase_modal .modal-content").css('height', '380px');
              $("#unpaid_purchase_modal #unpaid_toHide1").hide();
              $("#unpaid_purchase_modal #unpaid_toHide2").hide();

              $("#unpaid_purchase_modal #unpaid_hide1").show();
              $("#unpaid_purchase_modal #unpaid_hide2").show();
              $("#unpaid_purchase_modal #unpaid_hide3").show();
              $("#unpaid_purchase_modal #unpaid_hide4").hide();

              $("#unpaid_purchase_modal #btn_saveUnpaid").html('<i class = "bi bi-arrow-clockwise"></i>&nbsp; Update');

              var orderData = data[0];
              
              orderData.isNotification === 1 ? $("#notification_unpaid").prop('checked', true) : $("#notification_unpaid").prop('checked', false);
              orderData.isReccurring === 1 ? $("#reccurring_unpaid").prop('checked', true) : $("#reccurring_unpaid").prop('checked', false);
              $("#unpaid_amount").val(orderData.unpaid_amount);
              $("#unpaid_term").val(orderData.term);
              $("#unpaid_dueDate").val(orderData.due_date);
              $("#unpaid_note").val(orderData.note);
            }
            
            for (var i = 0; i < data.length; i++) 
            {
              var qty_purchased = to_received === 1 ? data[i].qty_received : data[i].qty_purchased; 
              table += "<tr data-rowid = "+data[i].product_id+" id = 'show_pqtymodal'>";
              table += "<td data-rowid = "+data[i].product_id+" data-id = " + data[i].product_id + " data-inv_id = " + data[i].inventory_id + ">" + data[i].prod_desc + " </td>";
              table += "<td style = 'text-align: center' class ='editable' data-qty = "+data[i].qty_purchased+" data-price= "+data[i].amount_beforeTax+">" + qty_purchased + "</td>";
              table += "<td style = 'text-align: right' class ='editable'>&#x20B1;&nbsp;" + addCommasToNumber(data[i].amount_beforeTax) + "</td>";
              table += "<td style = 'text-align: right'>&#x20B1;&nbsp;" + addCommasToNumber(data[i].total) + "</td>";
              table += "<td style = 'text-align: right; width: 0px;'><i class = 'bi bi-trash' id = 'removeOrder'></i></td>";
              table += "</tr>";
            }
            var counter = 1;
            for (var i = 0; i < data.length; i++) {
              tbl_report += "<tr>";
              tbl_report += "<td >" + counter + "</td>";
              tbl_report += "<td >" + data[i].prod_desc + "</td>";
              tbl_report += "<td style = 'text-align: center' >" + data[i].qty_purchased + "</td>";
              tbl_report += "<td style = 'text-align: right' >&#x20B1;&nbsp;" + addCommasToNumber(data[i].amount_beforeTax) + "</td>";
              tbl_report += "<td style = 'text-align: right'>&#x20B1;&nbsp;" + data[i].tax + "</td>";
              tbl_report += "<td style = 'text-align: right'>&#x20B1;&nbsp;" + data[i].total + "</td>";
              tbl_report += "<td style = 'text-align: right; width: 0px;'></td>";
              tbl_report += "</tr>";
              counter++;
            }
            $("#tbl_purchaseOrders tbody").html(table);
            $("#tbl_purchaseOrdersReport tbody").html(tbl_report);
            $("#rep_qty").html(data[0].totalQty);
            $("#rep_price").html("&#x20B1;&nbsp;" + addCommasToNumber(roundToTwoDecimalPlaces(data[0].totalPrice)));
            $("#rep_tax").html("Tax: " + roundToTwoDecimalPlaces(data[0].totalTax));
            $("#rep_total").html("&#x20B1;&nbsp;" + addCommasToNumber(roundToTwoDecimalPlaces(data[0].price)));

            $("#totalTax").html("Tax: " + roundToTwoDecimalPlaces(data[0].totalTax));
            $("#totalQty").html(data[0].totalQty);
            $("#totalPrice").html("&#x20B1;&nbsp;" + addCommasToNumber(roundToTwoDecimalPlaces(data[0].totalPrice)));
            $("#overallTotal").html("&#x20B1;&nbsp;" + addCommasToNumber(data[0].price));
          },
          error: function (data) {
           console.log("Error!");
          }
        })
      }
      $(".inventoryCard").on('click', '#btn_editOrder', function (e) {
        e.preventDefault();
        var order_id = $(this).data('id');
        orderdata(order_id, 0);
      })
      $(".inventoryCard").on('click', '#btn_openUnpaidPayment', function (e) {
        e.preventDefault();
        var order_id = $(this).data('id');
        $("#unpaid_order_id").val(order_id);
        $("#unpaid_identifier").val("1");

        $.ajax({
          type: 'get',
          url: 'api.php?action=get_unpaid_transaction',
          data: {
            order_id: order_id,
          },
          success: function(response){
            var orderdata = response['orderData'];

            $("#unpaid_purchase_modal #btn_saveUnpaid").html('<i class = "bi bi-save"></i>&nbsp; Save');

            $("#unpaid_purchase_modal .modal-content").css('height', '280px');
            $("#unpaid_purchase_modal #unpaid_toHide1").show();
            $("#unpaid_purchase_modal #unpaid_toHide2").show();

            $("#unpaid_purchase_modal #unpaid_hide1").hide();
            $("#unpaid_purchase_modal #unpaid_hide2").hide();
            $("#unpaid_purchase_modal #unpaid_hide3").hide();
            $("#unpaid_purchase_modal #unpaid_hide4").show();
            $("#unpaid_purchase_modal").slideDown({
              backdrop: 'static',
              keyboard: false,
            });
                
      
            var amount = orderdata['unpaid_amount'];
            amount = amount.replace(/,/g, '');
            $("#unpaid_amount").focus();
            $("#unpaid_note").val("");
            $("#unpaid_amount").val("");
            $("#unpaid_balance").val(amount);
            $("#unpaid_amount").attr("max", amount);
            $("#unpaid_amount").on("input", function() {
                var enteredValue = $(this).val().replace(/,/g, '');
                if (parseFloat(enteredValue) > parseFloat(amount)) {
                    $(this).val(amount);
                }
            });
          }
        })
      })

      function clean_number(number) {
        return number.replace(/[₱\s]/g, '');
      }

      function filterPO(barcode) {
        $('.search-dropdown-item').each(function () {
          var $row = $(this);
          var rowBarcode = $row.text().trim().toLowerCase();
          if (rowBarcode.includes(barcode)) {
            $row.show();
          }
          else {
            $row.hide();
          }
        });
      }
      function openReceivedItems()
      {
        $(".purchase-grid-container button").removeClass('active');
        $("#btn_receiveItems").addClass('active');
        $("#po_data_div").hide();
        $("#expiration_div").hide();
        $("#purchaseItems_div").hide();
        $("#received_div").show();
        $("#quickinventory_div").hide();
        $("#stocktransfer_div").hide();
        $("#lossanddamage_div").hide()
        $("#inventorycount_div").hide();
        $("#open_po_report").show();
        $("#receive_form #r_PONumbers").focus();
        $("#receive_form #r_PONumbers").val("");
        $("#btn_omPayTerms").hide();
        $("#btn_savePO").attr('disabled', false);
      }
      function hideModals() {
        $("#optionModal").addClass('slideOutRight');
        $(".optionmodal-content").addClass('slideOutRight');
        setTimeout(function () {
          $("#optionModal").removeClass('slideOutRight');
          $("#optionModal").hide();
          $(".optionmodal-content").removeClass('slideOutRight');
          $(".optionmodal-content").hide();
        }, 100);
      }
      $('#btn_minimizeModal').click(function () {
        $(".purchase-grid-container button").removeClass('active');
        hideModals();
        $("#searchInput").focus();
      });
      $("#product-form").on("submit", function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
      })
      function reset_poFooter()
      {
        $("#totalTax").html("Tax: 0.0");
        $("#totalQty").html("0.0");
        $("#totalPrice").html("0.0");
        $("#overallTotal").html("0.0");
      }
      $("#btn_openOption").click(function (e) {
        e.preventDefault();
        reset_poFooter();

        $(".scrollable").removeClass('hasLockImage');
        $("#inventorycount_div").removeClass('lock');
        $("#purchaseItems_div").removeClass('lock');
        $("#received_div").removeClass('lock');
        $("#btn_savePO").removeClass('lockButton');

        $(".purchase-grid-container button").removeClass('active');
        $("#btn_createPO").addClass('active');
        $("#expiration_div").hide();
        $("#received_div").hide()
        $("#quickinventory_div").hide();
        $("#stocktransfer_div").hide();
        $("#lossanddamage_div").hide();
        $("#inventorycount_div").hide();
        $("#purchaseItems_div").show();
        $("#po_form #product").focus();
        openOptionModal();
        $("#open_po_report").hide();
        $("#btn_omPayTerms").hide();
        $("#po_form #product").focus();

        $("#unpaid_identifier").val("0");
        $("#unpaid_order_id").val("0");
        $("#unpaid_purchase_modal .modal-content").css('height', '430px');
        $("#unpaid_purchase_modal #unpaid_toHide1").show();
        $("#unpaid_purchase_modal #unpaid_toHide2").show();

        $("#unpaid_purchase_modal #unpaid_hide1").show();
        $("#unpaid_purchase_modal #unpaid_hide2").show();
        $("#unpaid_purchase_modal #unpaid_hide3").show();
        $("#unpaid_purchase_modal #unpaid_hide4").hide();

        $("#unpaid_purchase_modal #btn_saveUnpaid").html('<i class = "bi bi-printer"></i>&nbsp; Save & Print');
        show_allSuppliers();
      })
      $("#btn_createPO").click(function (e) {
        e.preventDefault();
        reset_poFooter();

        $(".scrollable").removeClass('hasLockImage');
        $("#inventorycount_div").removeClass('lock');
        $("#purchaseItems_div").removeClass('lock');
        $("#received_div").removeClass('lock');
        $("#btn_savePO").removeClass('lockButton');

        $(".purchase-grid-container button").removeClass('active');
        $(this).addClass('active');
        $("#expiration_div").hide();
        $("#received_div").hide()
        $("#quickinventory_div").hide();
        $("#stocktransfer_div").hide();
        $("#lossanddamage_div").hide()
        $("#inventorycount_div").hide();
        $("#purchaseItems_div").show();
        openOptionModal();
        $("#open_po_report").hide();
        $("#btn_omPayTerms").hide();
        $("#po_form #product").focus();

        $("#unpaid_identifier").val("0");
        $("#unpaid_order_id").val("0");
        $("#unpaid_purchase_modal .modal-content").css('height', '430px');
        $("#unpaid_purchase_modal #unpaid_toHide1").show();
        $("#unpaid_purchase_modal #unpaid_toHide2").show();

        $("#unpaid_purchase_modal #unpaid_hide1").show();
        $("#unpaid_purchase_modal #unpaid_hide2").show();
        $("#unpaid_purchase_modal #unpaid_hide3").show();
        $("#unpaid_purchase_modal #unpaid_hide4").hide();
        $("#btn_savePO").attr('disabled', false);
        $("#unpaid_purchase_modal #btn_saveUnpaid").html('<i class = "bi bi-printer"></i>&nbsp; Save & Print');
        show_allSuppliers();
      })
      $("#btn_receiveItems").click(function (e) {
        e.preventDefault();
        $(".scrollable").removeClass('hasLockImage');
        $("#inventorycount_div").removeClass('lock');
        $("#purchaseItems_div").removeClass('lock');
        $("#received_div").removeClass('lock');
        $("#btn_savePO").removeClass('lockButton');
        openReceivedItems();
      })
      $("#btn_stockTransfer").click(function (e) {
        e.preventDefault();
        $(".scrollable").removeClass('hasLockImage');
        $("#inventorycount_div").removeClass('lock');
        $("#purchaseItems_div").removeClass('lock');
        $("#received_div").removeClass('lock');
        $("#btn_savePO").removeClass('lockButton');

        $(".purchase-grid-container button").removeClass('active');
        $(this).addClass('active');
        $("#purchaseItems_div").hide();
        $("#received_div").hide();
        $("#quickinventory_div").hide();
        $("#expiration_div").hide();
        $("#lossanddamage_div").hide()
        $("#inventorycount_div").hide();
        $("#stocktransfer_div").show();
      })
      $("#btn_expiration").click(function (e) {
        e.preventDefault();
        $(".scrollable").removeClass('hasLockImage');
        $("#inventorycount_div").removeClass('lock');
        $("#purchaseItems_div").removeClass('lock');
        $("#received_div").removeClass('lock');
        $("#btn_savePO").removeClass('lockButton');

        $("#open_po_report").hide();
        $(".purchase-grid-container button").removeClass('active');
        $(this).addClass('active');
        $("#purchaseItems_div").hide();
        $("#received_div").hide();
        $("#quickinventory_div").hide();
        $("#stocktransfer_div").hide();
        $("#lossanddamage_div").hide()
        $("#inventorycount_div").hide();
        $("#expiration_div").show();
        $("#btn_omPayTerms").hide();
        $("#btn_savePO").attr('disabled', false);
      })
      $("#btn_quickInventory").click(function (e) {
        e.preventDefault();
        $(".scrollable").removeClass('hasLockImage');
        $("#inventorycount_div").removeClass('lock');
        $("#purchaseItems_div").removeClass('lock');
        $("#received_div").removeClass('lock');
        $("#btn_savePO").removeClass('lockButton');

        $(".purchase-grid-container button").removeClass('active');
        $(this).addClass("active");
        $("#purchaseItems_div").hide();
        $("#received_div").hide();
        $("#expiration_div").hide();
        $("#stocktransfer_div").hide();
        $("#lossanddamage_div").hide()
        $("#inventorycount_div").hide();
        $("#quickinventory_div").show();
        $("#quickinventory_form #q_product").focus();
        $("#btn_savePO").attr('disabled', false);
      })
      $("#btn_lossDamage").click(function (e) {
        e.preventDefault();
        $(".scrollable").removeClass('hasLockImage');
        $("#inventorycount_div").removeClass('lock');
        $("#purchaseItems_div").removeClass('lock');
        $("#received_div").removeClass('lock');
        $("#btn_savePO").removeClass('lockButton');

        $("#loss_and_damage_input").focus();
        $("#loss_and_damage_input").attr('disabled', false);
        $("#btn_searchLDProduct").attr('disabled', false);
        $("#lossanddamage_form")[0].reset();
        $("#lossDamageInfoID").val("");
        $("#footer_lossand_damages #total_qty").html("0");
        $("#footer_lossand_damages #total_cost").html("₱ 0.0");
        $("#footer_lossand_damages #overall_total_cost").html("₱ 0.0");
        $("#loss_and_damage_note").val("");
        show_reference_no();
        $("#tbl_lossand_damages tbody").empty();
        $("#btn_savePO").attr("disabled", false);
        $("#btn_omCancel").attr("disabled", false);
        $(".purchase-grid-container button").removeClass('active');
        $("#loss_and_damage_input").focus();
        $(this).addClass("active");
        $("#purchaseItems_div").hide();
        $("#received_div").hide();
        $("#expiration_div").hide();
        $("#stocktransfer_div").hide();
        $("#quickinventory_div").hide();
        $("#inventorycount_div").hide();
        $("#lossanddamage_div").show();
        var currentDate = new Date();
        var formattedDate = formatDate(currentDate);
        $('#date_damage').datepicker('setDate', currentDate);
        $('#date_damage').val(formattedDate);
        $("#lossanddamage_form #loss_and_damage_input").focus();
        $("#btn_omPayTerms").hide();
        $("#btn_savePO").attr('disabled', false);
      })
      $("#btn_inventoryCount").click(function (e) {
        e.preventDefault();
        $(".scrollable").removeClass('hasLockImage');
        $("#inventorycount_div").removeClass('lock');
        $("#purchaseItems_div").removeClass('lock');
        $("#received_div").removeClass('lock');
        $("#btn_savePO").removeClass('lockButton');

        $("#btn_savePO").attr("disabled", false);
        $("#btn_omCancel").attr("disabled", false);
        $("#inventorycount_form")[0].reset();
        $("#inventory_count_info_id").val("");
        $("#qi_inventory_type").attr("disabled", false);
        $("#btn_go_inventory").attr("disabled", false);
        $("#tbl_inventory_count tbody").empty();
        var currentDate = new Date();
        var formattedDate = formatDate(currentDate);
        $('#date_counted').datepicker('setDate', currentDate);
        $('#date_counted').val(formattedDate);
        show_inventory_count_reference_no();
        $(".purchase-grid-container button").removeClass('active');
        $(this).addClass("active");
        $("#purchaseItems_div").hide();
        $("#received_div").hide();
        $("#expiration_div").hide();
        $("#stocktransfer_div").hide();
        $("#quickinventory_div").hide();
        $("#lossanddamage_div").hide();
        $("#inventorycount_div").show();
        $("#btn_omPayTerms").hide();
        $("#btn_savePO").attr('disabled', false);
      })
      function openOptionModal() {
        resetPurchaseOrderForm();

        $("#paidSwitch").css('background-color', 'green');
        $('#paidSwitch').prop('checked', true).prop('disabled', false);
        $("#optionModal").addClass('slideInRight');
        $(".optionmodal-content").addClass('slideInRight');
        setTimeout(function () {
          $("#optionModal").show();
          $(".optionmodal-content").show();
        }, 100);
        $("#po_form #product").focus();
        $("#btn_savePO").attr('disabled', false);
      }
      $(document).click(function(event) {
        var $target = $(event.target);

        if (!$target.closest('#optionModal, #btn_openOption, #purchaseQty_modal, #removeOrder, .removeItem, #show_purchasePrintModal, #unpaid_purchase_modal').length) {
            if ($('#optionModal').is(':visible')) {
                hideModals();
            }
        }
    });

  </script>