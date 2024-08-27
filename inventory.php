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

  
/* for 1336px screen */

@media screen and (max-width: 1400px) {
     
     .inventoryCard th, .inventoryCard td {
           width: 9%; 
       }
       .division{
         zoom:70%;
       
       }
       .main-panel{
         margin-left: -30px;
     
         width: 100%;
       }
 
       .row{
         zoom:70%;
       }
       .modal{
      zoom: 70%;
       }

       #paginationDiv{
        margin-top: 150px;
    
       }
       #preview_records{
         zoom:80%;
       }
       .btn-control{
         zoom:70%;
         margin-top: 50px;
       }
       .search{
        zoom:70%;
       }

       .inventoryCard tbody {
        display: block; 
        max-height: 100vh; 
        overflow-y: scroll;
        max-width: 120% ;
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
height: auto; 
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
  height: auto; 
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
  height: auto; 
  line-height: 0.5; 
  border: 1px solid #292928;
}

#tbl_all_lostanddamages tbody th,
#tbl_all_lostanddamages tbody td {
  padding: 8px 8px; 
  height: auto; 
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
  height: auto; 
  line-height: 0.5; 
  border: 1px solid #292928;
}
#tbl_previewRecord tbody th,
#tbl_previewRecord tbody td {
  padding: 2px 2px; 
  height: auto; 
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
    height: auto; 
    line-height: 1;
    font-size: 12px;
    font-weight: normal;
    
}

#tbl_expiredProducts tbody th,
#tbl_expiredProducts tbody td {
    padding: 8px 8px; 
    height: auto; 
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

/*   start for search bar css*/

::selection {
  color: black;
  background: white;
}


#searchInput{
    caret-color: white; 
    color: white; 
    background-color: #555; 
    font-size: 15px; 
  
}


.inventoryBtn{
  background-color: #555;  
  margin-left: -5px;
}

#clear_inventory_search{
  background-color: #555;  
  height: 35px; 
  margin-left: -5px;
  cursor: pointer;
}



.inventoryBtn.clearproductsBtn svg {
  transition: fill 0.3s ease, transform 0.3s ease; 
}


.inventoryBtn.clearproductsBtn:hover svg {
  fill: var(--primary-color); 
  transform: scale(1.1);
}

/*   end for search bar css*/



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

        <div class="search">
          <div class="d-flex justify-content-center align-items-center mb-3" style= "margin-top: -10px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="#fff" class="bi bi-upc-scan" viewBox="0 0 16 16">
              <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5M3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0z"/>
            </svg>
            <input id = "searchInput" class="text-color searchProducts ms-2 ps-3" placeholder="Search Product,[code, barcode, name, brand]" autocomplete="off" autofocus/>
            
            <span class="inventoryBtn clearproductsBtn" id = "clear_inventory_search">
              <svg xmlns="http://www.w3.org/2000/svg" width="25" height="35" fill="#fff" class="bi bi-x" viewBox="0 0 16 16">
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
  <script src="assets/adminjs/inventory.js"></script>

  

  <script>
  
  const searchInput = document.getElementById('searchInput');
  const clearInventorySearch = document.getElementById('clear_inventory_search');


  function toggleSVGVisibility() {
    if (searchInput.value.trim() === '') {
      clearInventorySearch.style.display = 'none'; 
      
    } else {
      clearInventorySearch.style.display = 'inline-block'; 
    }
  }

 
  searchInput.addEventListener('input', toggleSVGVisibility);


  toggleSVGVisibility();
  </script> 