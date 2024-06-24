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
        if (isset($permission['Inventory']) && $permission['Inventory'] == "Access Granted") {
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
include ('./layout/admin/table-pagination-css.php');

?>
<style>
  .horizontal-container {
    display: flex;
    align-items: center;
    margin-right: 10px;
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
     border: 2px solid #00B050; 
  }
  .dt-paging-button {
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

.dt-paging:hover{
  color: #FF6900;
}
  .dt-paging{
    margin-top: 20px;
    margin-bottom: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
  }

.dt-paging-button:hover{
  color: #FF6900;
}
.first{
  display: none;
}
.last{
  display: none;
}
.dt-paging-button {
    text-decoration: none;
    padding: 5px 10px;
    margin: 2px;
    border: 1px solid #ddd;
    color: #000;
}
.dt-paging-button:hover {
    background-color: #f0f0f0;
}
.dt-paging-button.active {
    background-color: #00B050;
    color: white;
    outline: none;
}
#main-content {
    overflow: hidden;
}
.inventoryCard{
    width: 100%;
    max-height: 700px; 
    overflow-y: auto; 
    overflow-x: auto; 
  }
  table thead{ 
      table-layout: fixed; 
      border-collapse: collapse; 
    } 

</style>

<?php include "layout/admin/css.php" ?>
<div class="container-scroller">
  <div class="main">
    <?php include 'layout/admin/sidebar.php' ?>
    <input type="hidden" value = "<?php echo $_SESSION['first_name'] ?>" id = "first_name">
    <input type="hidden" value = "<?php echo $_SESSION['last_name'] ?>" id = "last_name">
    <div class="main-panel main-content" id="main-content"
      style="display: grid; grid-template-columns: 4.5rem auto auto; align-items: center">
      <div class="content-wrapper">
        <div
          style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-left: 15px; margin-bottom: 20px;">
          <!-- <div class="horizontal-container" style="display: flex; align-items: center;">
            <img src="assets/img/barcode.png" style="color: white; height: 80px; width: 70px; margin-right:5px;">
            <input class="text-color italic-placeholder" id="searchInput" style="flex: 1 1 90%; height: 45px; font-size: 14px;"
              placeholder="Search Product,[code,serial no., barcode, name, brand]" autocomplete="off" autofocus />
          </div>
          <div style="display: flex; align-items: center;">
            <button class="grid-item" style="margin-right: 10px;">
              <span class="search-icon"></span>
              Search
            </button>
            <button class="grid-item" id="btn_openOption">
              <span class="plus-icon"></span>
              Option
            </button>
          </div> -->
          <input id = "searchInput" class="text-color searchProducts" style="width: 75%; height: 45px; margin-right: 10px" placeholder="Search Product,[code, barcode, name, brand]"/>
           <button onclick="searchProducts()" id="searchBtn" name="productSearch" class="btn-control" style="margin-right:10px; width:120px"><svg width="30px"version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
              viewBox="0 0 491.52 491.52" xml:space="preserve">
            <ellipse style="opacity:0.5;fill:#27A2DB;enable-background:new    ;" cx="158.537" cy="158.536" rx="129.777" ry="129.777"/>
            <path style="opacity:0.5;fill:#FFFFFF;enable-background:new    ;" d="M98.081,234.62c-43.316-43.315-43.882-112.979-1.264-155.595
              c9.509-9.511,20.41-16.745,32.021-21.96c-16.497,4.812-32.056,13.702-45.064,26.71c-41.288,41.289-41.289,108.231,0,149.521
              c18.282,18.281,41.596,28.431,65.483,30.523C130.561,258.986,112.79,249.33,98.081,234.62z"/>
            <path style="fill:#3A556A;" d="M270.636,46.433c-61.912-61.912-162.291-61.911-224.202,0.001s-61.912,162.291-0.001,224.202
              c57.054,57.054,146.703,61.394,208.884,13.294l14.18,14.182l28.615-28.613l-14.182-14.182
              C332.029,193.137,327.69,103.487,270.636,46.433z M250.301,250.302c-50.681,50.681-132.852,50.681-183.534,0
              c-50.68-50.681-50.68-132.852,0.002-183.533s132.85-50.681,183.531,0C300.982,117.45,300.982,199.621,250.301,250.302z"/>
            <path style="fill:#E56353;" d="M305.823,258.865l-46.959,46.958c-2.669,2.67-2.669,6.996,0,9.665l174.339,174.338
              c12.132,12.133,68.755-44.49,56.623-56.623L315.488,258.865C312.819,256.196,308.493,256.196,305.823,258.865z"/>
            <g>
            <rect x="409.379" y="442.628" transform="matrix(-0.7071 0.7071 -0.7071 -0.7071 1084.9951 449.4294)" style="fill:#EBF0F3;" width="80.077" height="13.594"/>
            <rect x="260.671" y="293.889" transform="matrix(-0.7071 0.7071 -0.7071 -0.7071 725.9606 300.6683)" style="fill:#EBF0F3;" width="80.077" height="13.594"/>
                </g>
                </svg>&nbsp;Search</button>
           <button id="btn_openOption"  class="btn-control addProducts" style="margin-right:10px;width:150px "><svg width="25px" height="25px" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><defs>
            <style>
              .cls-1 {
                fill: #699f4c;
                fill-rule: evenodd;
              }
            </style></defs><path class="cls-1" d="M1080,270a30,30,0,1,1,30-30A30,30,0,0,1,1080,270Zm14-34h-10V226a4,4,0,0,0-8,0v10h-10a4,4,0,0,0,0,8h10v10a4,4,0,0,0,8,0V244h10A4,4,0,0,0,1094,236Z"  transform="translate(-1050 -210)"/></svg>&nbsp;Option</button>
            <button class="btn-control clearproductsBtn" style="width:120px;order: 1" id = "clear_inventory_search"><svg height="25px" width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.001 512.001" xml:space="preserve" fill="#f20707" stroke="#f20707"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#f20707;" d="M256.001,512c141.384,0,255.999-114.615,255.999-256.001C512.001,114.615,397.386,0,256.001,0 S0.001,114.615,0.001,256.001S114.616,512,256.001,512z"></path> <path style="opacity:0.1;enable-background:new ;" d="M68.873,256.001c0-129.706,96.466-236.866,221.564-253.688 C279.172,0.798,267.681,0,256.001,0C114.616,0,0.001,114.615,0.001,256.001S114.616,512.001,256,512.001 c11.68,0,23.171-0.798,34.436-2.313C165.339,492.865,68.873,385.705,68.873,256.001z"></path> <path style="fill:#FFFFFF;" d="M313.391,256.001l67.398-67.398c4.899-4.899,4.899-12.842,0-17.74l-39.65-39.65 c-4.899-4.899-12.842-4.899-17.74,0l-67.398,67.398l-67.398-67.398c-4.899-4.899-12.842-4.899-17.74,0l-39.65,39.65 c-4.899,4.899-4.899,12.842,0,17.74l67.398,67.398l-67.398,67.398c-4.899,4.899-4.899,12.842,0,17.741l39.65,39.65 c4.899,4.899,12.842,4.899,17.74,0l67.398-67.398L323.4,380.79c4.899,4.899,12.842,4.899,17.74,0l39.65-39.65 c4.899-4.899,4.899-12.842,0-17.741L313.391,256.001z"></path> </g></svg>&nbsp;Clear</button>
        </div>
        <div>
          <div class="tbl_buttonsContainer">
            <div class="division">
              <div class="grid-container">
                <button id="inventories" class="grid-item text-color button"><i class="bi bi-box-seam"></i>&nbsp;
                  Inventories</button>
                <button id="stocks" class="grid-item text-color button"><i class="bi bi-graph-up"></i>&nbsp;
                  Stocks</button>
                <button id="purchase-order" class="grid-item text-color button"><i class="bi bi-cart-check"></i>&nbsp;
                  Purchase Orders</button>
                <button id="inventory-count" class="grid-item text-color button"><i class="bi bi-archive"></i>&nbsp;
                  Inventory Count</button>
                <button id="loss-damage" class="grid-item text-color button"><i class="bi bi-bug-fill"></i>&nbsp; Loss &
                  Damage</button>
                <button id="expiration" class="grid-item text-color button"><i class="bi bi-calendar-x-fill"></i>&nbsp;
                  Expiration <span id="expirationNotification" class="badge badge-danger"
                    style="font-size: 11px; background-color: red; color: white; "></span></button>
                <!-- <button id="bom" class="grid-item text-color button"><i class="bi bi-file-earmark-spreadsheet"></i>&nbsp;  B.O.M</button> -->
                <!-- <button id="low-stocks" class="grid-item text-color button"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp; Low Stocks</button>
                        <button id="reorder-point" class="grid-item text-color button"><i class="bi bi-arrow-up-circle"></i>&nbsp; Re-order Point</button> -->
              </div>
            </div>
          
            <div class="division">
              <div class="grid-container">
                <!-- <button id="loss-damage" class="grid-item text-color button"><i class="bi bi-bug-fill"></i>&nbsp; Loss & Damage</button> -->
                <!-- <button id="stock-transfer" class="grid-item text-color button"><i class="bi bi-arrow-right-circle"></i>&nbsp; Stocks Transfer</button> -->
                <!-- <button id="expiration" class="grid-item text-color button"><i class="bi bi-calendar-x-fill"></i>&nbsp; Expiration  <span id="expirationNotification" class="badge badge-danger" style = "font-size: 11px; background-color: red; color: white; "></span></button> -->
                <!-- <button id="loss-damage2" class="grid-item text-color button"><i class="bi bi-exclamation-diamond-fill"></i>&nbsp; Loss & Damage</button> -->
                <!-- <button id="bom2" class="grid-item text-color button"><i class="bi bi-journal-check"></i>&nbsp; B.O.M</button> -->
                <!-- <button id="print-price-tags" class="grid-item text-color button"><i class="bi bi-printer"></i>&nbsp; Print Price Tags</button> -->
              </div>
            </div>
            <div class="division">
              <div class="grid-container">
                <!-- <button id="recalculate-stocks" class="grid-item text-color button"><i class="bi bi-calculator-fill"></i>&nbsp; Recalculate Stocks</button> -->
              </div>
            </div>
          </div>
        </div>
        <div class="row" style="margin-top: -20px;">
          <div class="card inventoryCard" style="width: 100%; height: 70vh;">

          </div>
          <div id="paginationDiv"></div>
          <div style="display: flex; margin-top: 20px">
            <button class="btn-control" id="printThis" style="width:160px; height:45px; margin-right: 10px"><svg
                version="1.1" id="_x32_" width="25px" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="" stroke="">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                  <style type="text/css">
                    .st0 {
                      fill: #ffff;
                    }
                  </style>
                  <g>
                    <path class="st0"
                      d="M488.626,164.239c-7.794-7.813-18.666-12.684-30.578-12.676H409.01V77.861L331.145,0h-4.225H102.99v151.564 H53.955c-11.923-0.008-22.802,4.862-30.597,12.676c-7.806,7.798-12.665,18.671-12.657,30.574v170.937 c-0.008,11.919,4.847,22.806,12.661,30.589c7.794,7.813,18.678,12.669,30.593,12.661h49.034V512h306.02V409.001h49.037 c11.901,0.008,22.78-4.848,30.574-12.661c7.818-7.784,12.684-18.67,12.677-30.589V194.814 C501.306,182.91,496.436,172.038,488.626,164.239z M323.519,21.224l62.326,62.326h-62.326V21.224z M123.392,20.398l179.725,0.015 v83.542h85.491v47.609H123.392V20.398z M388.608,491.602H123.392v-92.801h-0.016v-96.638h265.217v106.838h0.015V491.602z M480.896,365.751c-0.004,6.353-2.546,11.996-6.694,16.17c-4.166,4.136-9.813,6.667-16.155,6.682h-49.049V281.75H102.974v106.853 H53.955c-6.365-0.015-12.007-2.546-16.166-6.682c-4.144-4.174-6.682-9.817-6.686-16.17V194.814 c0.004-6.338,2.538-11.988,6.686-16.155c4.167-4.144,9.809-6.682,16.166-6.698h49.034h306.02h49.037 c6.331,0.016,11.985,2.546,16.151,6.698c4.156,4.174,6.694,9.817,6.698,16.155V365.751z">
                    </path>
                    <rect x="167.59" y="336.155" class="st0" width="176.82" height="20.405"></rect>
                    <rect x="167.59" y="388.618" class="st0" width="176.82" height="20.398"></rect>
                    <rect x="167.59" y="435.255" class="st0" width="83.556" height="20.398"></rect>
                    <path class="st0"
                      d="M353.041,213.369c-9.263,0-16.767,7.508-16.767,16.774c0,9.251,7.504,16.759,16.767,16.759 c9.263,0,16.77-7.508,16.77-16.759C369.811,220.877,362.305,213.369,353.041,213.369z">
                    </path>
                    <path class="st0"
                      d="M424.427,213.369c-9.262,0-16.77,7.508-16.77,16.774c0,9.251,7.508,16.759,16.77,16.759 c9.258,0,16.766-7.508,16.766-16.759C441.193,220.877,433.685,213.369,424.427,213.369z">
                    </path>
                  </g>
                </g>
              </svg>&nbsp;Print</button>
            <button class="btn-control" id="generatePDFBtn" style="width:160px; height:45px; margin-right: 10px"><svg
                width="25px" height="25px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                  <path
                    d="M2.5 6.5V6H2V6.5H2.5ZM6.5 6.5V6H6V6.5H6.5ZM6.5 10.5H6V11H6.5V10.5ZM13.5 3.5H14V3.29289L13.8536 3.14645L13.5 3.5ZM10.5 0.5L10.8536 0.146447L10.7071 0H10.5V0.5ZM2.5 7H3.5V6H2.5V7ZM3 11V8.5H2V11H3ZM3 8.5V6.5H2V8.5H3ZM3.5 8H2.5V9H3.5V8ZM4 7.5C4 7.77614 3.77614 8 3.5 8V9C4.32843 9 5 8.32843 5 7.5H4ZM3.5 7C3.77614 7 4 7.22386 4 7.5H5C5 6.67157 4.32843 6 3.5 6V7ZM6 6.5V10.5H7V6.5H6ZM6.5 11H7.5V10H6.5V11ZM9 9.5V7.5H8V9.5H9ZM7.5 6H6.5V7H7.5V6ZM9 7.5C9 6.67157 8.32843 6 7.5 6V7C7.77614 7 8 7.22386 8 7.5H9ZM7.5 11C8.32843 11 9 10.3284 9 9.5H8C8 9.77614 7.77614 10 7.5 10V11ZM10 6V11H11V6H10ZM10.5 7H13V6H10.5V7ZM10.5 9H12V8H10.5V9ZM2 5V1.5H1V5H2ZM13 3.5V5H14V3.5H13ZM2.5 1H10.5V0H2.5V1ZM10.1464 0.853553L13.1464 3.85355L13.8536 3.14645L10.8536 0.146447L10.1464 0.853553ZM2 1.5C2 1.22386 2.22386 1 2.5 1V0C1.67157 0 1 0.671573 1 1.5H2ZM1 12V13.5H2V12H1ZM2.5 15H12.5V14H2.5V15ZM14 13.5V12H13V13.5H14ZM12.5 15C13.3284 15 14 14.3284 14 13.5H13C13 13.7761 12.7761 14 12.5 14V15ZM1 13.5C1 14.3284 1.67157 15 2.5 15V14C2.22386 14 2 13.7761 2 13.5H1Z"
                    fill="#ffff"></path>
                </g>
              </svg>&nbsp;Save as PDF</button>
            <button class="btn-control" id="generateEXCELBtn" style="width:160px; height:45px;"><svg height="25px"
                width="25px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26 26" xml:space="preserve" fill="#ffffff">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                  <g>
                    <path style="fill:#ffff;"
                      d="M25.162,3H16v2.984h3.031v2.031H16V10h3v2h-3v2h3v2h-3v2h3v2h-3v3h9.162 C25.623,23,26,22.609,26,22.13V3.87C26,3.391,25.623,3,25.162,3z M24,20h-4v-2h4V20z M24,16h-4v-2h4V16z M24,12h-4v-2h4V12z M24,8 h-4V6h4V8z">
                    </path>
                    <path style="fill:#ffff;"
                      d="M0,2.889v20.223L15,26V0L0,2.889z M9.488,18.08l-1.745-3.299c-0.066-0.123-0.134-0.349-0.205-0.678 H7.511C7.478,14.258,7.4,14.494,7.277,14.81l-1.751,3.27H2.807l3.228-5.064L3.082,7.951h2.776l1.448,3.037 c0.113,0.24,0.214,0.525,0.304,0.854h0.028c0.057-0.198,0.163-0.492,0.318-0.883l1.61-3.009h2.542l-3.037,5.022l3.122,5.107 L9.488,18.08L9.488,18.08z">
                    </path>
                  </g>
                </g>
              </svg>&nbsp;Save as Excel</button>
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
  <?php include ("layout/footer.php") ?>
  <?php include ("layout/admin/keyboardfunction.php") ?>
  <?php include ("./modals/purchaseOrder_response.php") ?>
  <?php include('./modals/loading-modal.php'); ?>

  <script>

    // var tableOffset = $(".inventoryCard table").offset().top;
    // var $header = $(".inventoryCard table > thead").clone();
    // var $fixedHeader = $("#header-fixed").append($header);

    // $(window).bind("scroll", function() {
    //   var offset = $(this).scrollTop();
    //   if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
    //     $fixedHeader.show();
    //   } else if (offset < tableOffset) {
    //     $fixedHeader.hide();
    //   }
    // });
    
    hidePopups();
        document.addEventListener('DOMContentLoaded', function() {
            var dateInput = document.getElementById('date_purchased');
            dateInput.removeAttribute('autofocus'); 
        });
        function hidePopups() {
        $('#date_purchased').removeAttr('autofocus');
        $("#p_qty").focus();
        $("#date_purchased").flatpickr().destroy();
        $("#date_purchased").flatpickr().close();
      }
     
    </script>
  
  <script>
  
    $(document).ready(function () {
    

      $("#inventory").addClass('active');
      $("#inventories").addClass('active');
      $("#pointer").html("Inventory");

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
      // $('#date_purchased').datepicker({
      //   changeMonth: true,
      //   changeYear: true,
      //   dateFormat: 'M dd y',
      //   altFormat: 'M dd y',
      //   altField: '#date_purchased',
      //   maxDate: 0,
      //   onSelect: function (dateText, inst) { }
      // });
      $("#date_purchased").prop("readonly", true).flatpickr({
        dateFormat: "M d y",
        onClose: function(selectedDates) {
        }
      });

    // Event handler for the calendar button
    // $('#calendar-btn').off('click').on('click', function () {

    //   if (!$("#date_purchased").hasClass("flatpickr-open")) {
    //       if (!$("#date_purchased").hasClass("flatpickr-initialized")) {
    //           $("#date_purchased").flatpickr();
    //           $("#date_purchased").addClass("flatpickr-initialized");
    //       }
    //       $("#date_purchased").flatpickr().open();
    //     }
    // });
    $('#calendar-btn').off('click').on('click', function () {
      if (!$("#date_purchased").hasClass("flatpickr-open")) {
        if (!$("#date_purchased").hasClass("flatpickr-initialized")) {
            $("#date_purchased").flatpickr({
                dateFormat: "M d y",
                onClose: function(selectedDates) {
                }
            });
            $("#date_purchased").addClass("flatpickr-initialized");
        }
        if ($("#date_purchased").flatpickr()) {
            $("#date_purchased").flatpickr().open();
        }
      }
    });
      // $('#calendar-btn').on('click',function () {
      //   $('#date_purchased').datepicker('show');
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
    $(document).ready(function () {
      let inventoryCurrentPage = 1;
      const inventoryPageSize = 300;

      var totalTax = 0;
      var totalQty = 0;
      var totalPrice = 0;
      var overallTotal = 0;
      var selected_products = [];
      var isSaving = false;
      var lastInputTime = 0; 
      var productsCache = [];
      $("#tbl_orders").hide();
      show_allInventories();
      show_allSuppliers();
      show_purchaseOrderNo();
      display_datePurchased();

      $("#clear_inventory_search").on("click", function(){
        $("#searchInput").val("");
        $("#searchInput").focus();
        $('#searchInput').keypress();
      })
      $("#printThis").on("click", function () {
        var active_tbl_id = $(".inventoryCard table").attr('id');
        if (active_tbl_id !== 'tbl_all_inventoryCounts' && active_tbl_id !== 'tbl_all_stocks') {
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
              var newBlob = new Blob([response], { type: 'application/pdf' });
              var blobURL = URL.createObjectURL(newBlob);

              var newWindow = window.open(blobURL, '_blank');
              if (newWindow) {
                newWindow.onload = function () {
                  newWindow.print();
                  newWindow.focus();
                };
              } else {
                alert('Please allow popups for this website');
              }
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
      $('#generateEXCELBtn').click(function () {
        var active_tbl_id = $(".inventoryCard table").attr('id');
        if (active_tbl_id !== 'tbl_all_inventoryCounts' && active_tbl_id !== 'tbl_all_stocks') {
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
              console.log(response);
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
      $(".inventoryCard").on('click', '.btn_openPayment', function () {
        $("#purchase_modal_payment #modalTitle").html("<i class = 'bi bi-exclamation-triangle bi-lg exclamation-icon'></i>&nbsp; <strong style = 'color: #ffff'>ATTENTION REQUIRED!</strong> ");
        $("#purchase_modal_payment").slideDown({
          backdrop: 'static',
          keyboard: false,
        });
        $("#payment_order_id").val($(this).data('id'))
        show_allPaymentHistory();
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
                alert(response.msg);
                show_allPaymentHistory();
              }
            }
          })
        }
        else {
          alert("This payment already been paid");
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
      $("#btn_refreshStockHistory").on("click", function(e){
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
            $("#stockhistory_modal").slideDown({
              backdrop: 'static',
              keyboard: false,
            });
            $("#stockhistory_modal").find(".modal-title").html("<span style = 'color: #FF6700; font-weight: bold'> "+info.prod_desc + "</span>&nbsp; - STOCK HISTORY")
            var tbl_rows = [];
            for (var i = 0, len = stocks.length; i < len; i++) {
              var stockItem = stocks[i];
              var stockDate = $.datepicker.formatDate("dd M yy", new Date(stockItem.stock_date));
              var stockTimestamp = stockItem.stock_date;
              var stock = stockItem.product_stock > 0 ? "<span style = 'color: green'>" + stockItem.stock + "</span>" : "<span style = 'color: red'>" + stockItem.stock + "<span>";
              tbl_rows.push(
                `<tr>
                  <td style = 'text-align: center;  font-size: 12px; font-weight: bold'>${stockItem.transaction_type}</td>
                  <td style = 'text-align: center;  font-size: 12px; font-weight: bold'>${stockItem.document_number}</td>
                  <td style = 'text-align: center;  font-size: 12px; font-weight: bold'>${stockItem.stock_customer}</td>
                  <td style = 'text-align: center;  font-size: 12px; font-weight: bold'>${stockDate}</td>
                  <td style = 'text-align: center;  font-size: 12px; font-weight: bold'>${stockTimestamp}</td>
                  <td style = 'text-align: center;  font-size: 12px; font-weight: bold'>${stockItem.stock_qty}</td>
                  <td style = 'text-align: center; font-size: 12px; font-weight: bold'>${stock}</td>
              </tr>`
              );
            }
            var tfoot = `<tr>
                  <td style = 'text-align: center;  font-size: 12px; font-weight: bold' colspan ='6'>Remaining Stock</td>
                  <td style = 'text-align: center; font-size: 12px; font-weight: bold; color: #ccc' >${info.product_stock}</td>
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
        var id = $(this).data('id');
        var active_tbl_id = $(".inventoryCard table").attr('id');
        $("#"+active_tbl_id+" tbody").find("tr").removeClass('highlighted-row')
        $(this).toggleClass('highlighted-row');
        switch(active_tbl_id)
        {
          case 'tbl_all_stocks':
            $("#start_date").val("");
            $("#end_date").val("");
            $("#stockhistory_modal #inventory_id").val(id);
            display_allStocksData(id);
            break;
          case 'tbl_orders':
            var order_id = $(this).data('id');
            $("#stocktransfer_div").hide();
            $("#received_div").hide()
            $("#quickinventory_div").hide()
            $("#expiration_div").hide()
            $("#lossanddamage_div").hide()
            $("#inventorycount_div").hide();
            $(".purchase-grid-container button").removeClass('active');
            $("#btn_createPO").addClass('active');
            $("#purchaseItems_div").show()
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
                  $("#paidSwitch").css('background-color', 'green');
                  $('#paidSwitch').prop('checked', true).prop('disabled', true);
                }
                else {
                  $("#paidSwitch").css('background-color', '#ffff');
                  $('#paidSwitch').prop('checked', false).prop('disabled', true);
                }
              
                for (var i = 0; i < data.length; i++) 
                {
                  table += "<tr data-rowid = "+data[i].product_id+" id = 'show_pqtymodal'>";
                  table += "<td data-rowid = "+data[i].product_id+" data-id = " + data[i].product_id + " data-inv_id = " + data[i].inventory_id + ">" + data[i].prod_desc + " </td>";
                  table += "<td style = 'text-align: center' class ='editable' data-qty = "+data[i].qty_purchased+" data-price= "+data[i].amount_beforeTax+">" + data[i].qty_purchased + "</td>";
                  table += "<td style = 'text-align: right' class ='editable'>&#x20B1;&nbsp;" + addCommasToNumber(data[i].amount_beforeTax) + "</td>";
                  table += "<td style = 'text-align: right'>&#x20B1;&nbsp;" + addCommasToNumber(data[i].total) + "</td>";
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
                console.log("Server Error")
              }
            })
            break;
          default:
            break;
        }
       
      })
    
      function show_allStocks() 
      {
        $("#searchInput").focus();
        if ($.fn.DataTable.isDataTable(".inventoryCard #tbl_all_stocks")) {
            $(".inventoryCard #tbl_all_stocks").DataTable().destroy();
        }
        $("#paginationDiv").empty().hide();

        var tblData = `
            <table tabindex='0' id='tbl_all_stocks' class='text-color table-border display' style='font-size: 12px;'>
                <thead>
                    <tr>
                        <th class='autofit text-center'>No.</th>
                        <th class=''>Product</th>
                        <th >Barcode</th>
                        <th style='text-align: center'>Unit</th>
                        <th  style='text-align: center'>Qty in Store</th>
                        <th class='autofit' style='text-align: center'>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>`;

        $(".inventoryCard").html(tblData);

        var table = $('.inventoryCard #tbl_all_stocks').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: 'api.php?action=get_allInventories',
                type: 'POST'
            },
            columns: [
                { data: null, render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }, className: 'text-center'},
                { data: 'prod_desc'},
                { data: 'barcode', className: 'text-center' },
                { data: 'uom_name', className: 'text-center' },
                { data: 'product_stock', className: 'text-center', render: function (data) {
                    if (data > 10) return "<span style='color: yellowgreen'>" + data + "</span>";
                    if (data <= 10 && data > 0) return "<span style='color: red'>" + data + "</span>";
                    return data === -1 ? 0 : data;
                }, className: 'text-center' },
                { data: null, render: function (data) {
                    return `<i data-id='${data.product_id}' id='btn_openStockHistory' class="bi bi-graph-up icon-button"></i>`;
                }, className: 'text-center' }
            ],
            ordering: true,
            order: [[1, 'asc']],
            pageLength: 100,
            // pagingType: 'full_numbers',
            // columnDefs: [
            //     { targets: '_all', className: 'auto-fit' } 
            // ],
            dom: '<"row view-filter"<"col-sm-12"<"clearfix">>>t<"row"<"col-sm-12"p>>',
            fnDrawCallback: function (oSettings) {
                if (oSettings.aoData.length === 0) {
                    $("#paginationDiv").hide();
                } else {
                    $("#paginationDiv").show();
                }
            },
        
            createdRow: function (row, data, dataIndex) {
              $(row).attr('data-id', data.product_id);
            }
        });
        table;
        $("#paginationDiv").html($(".dt-paging")).show();
        var debounceTimeout;
        $('#searchInput').on('keyup', function (event) {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(function () {
                table.search($('#searchInput').val()).draw();
            }, 100); 
        });
      }
      function show_allLossAndDamagesInfo() {
        if ($.fn.DataTable.isDataTable(".inventoryCard #tbl_all_lostanddamages")) {
            $(".inventoryCard #tbl_all_lostanddamages").DataTable().destroy();
        }
        $("#paginationDiv").empty().hide();

        $.ajax({
          type: 'get',
          url: 'api.php?action=get_all_lostanddamageinfo',
          success: function (data) {
            var rows;
            rows = data.map(function (item) {
              return "<tr>" +
                "<td class='autofit'>" + item.reference_no + "</td>" +
                "<td class='autofit' style='text-align: center'>" + date_format(item.date_transact) + "</td>" +
                "<td class='autofit' style='text-align: center'>" + item.reason + "</td>" +
                "<td class='autofit' style='text-align: center'>" + item.total_qty + "</td>" +
                "<td class='autofit' style='text-align: right'>₱ " + addCommasToNumber(item.total_cost) + "</td>" +
                "<td class='autofit' style='text-align: right'>₱ " + addCommasToNumber(item.over_all_total_cost) + "</td>" +
                "<td class='autofit' style='text-align: center'>" + item.note + "</td>" +
                "<td style='text-align: center' class='autofit'><button data-id = " + item.id + " id='btn_view_lossanddamage'><i class='bi bi-eye'></i></button></td>" +
                "</tr>";
            }).join('');

            var tbl = "<table id='tbl_all_lostanddamages' class='text-color table-border' style='font-size: 12px;'>" +
              "<thead>" +
              "<tr>" +
              "<th >Reference No.</th>" +
              "<th style = 'text-align:center'>Date of Transaction</th>" +
              "<th style = 'text-align:center; background-color:red'>Reason</th>" +
              "<th style = 'text-align:center'>Total Qty</th>" +
              "<th style = 'text-align:center'>Total Cost</th>" +
              "<th style = 'text-align:center'>Overall Cost</th>" +
              "<th style = 'text-align:center'>Note</th>" +
              "<th style = 'text-align:center'>Action</th>" +
              "</tr>" +
              "</thead>" +
              "<tbody>" +
              rows +
              "</tbody>" +
              "</table>";

            $(".inventoryCard").html(tbl);

            // $('.inventoryCard #tbl_all_lostanddamages').DataTable({
            //     ordering: true,
            //     order: [[0, 'asc']], 
            //     pageLength: 50,
            //     sDom: '<"row view-filter"<"col-sm-12"<"clearfix">>>t<"row view-pager"<"col-sm-12"<"pull-center"ip>>>',
            //     language: {
            //         paginate: {
            //             previous: '<i class="fa fa-angle-left"></i>',
            //             next: '<i class="fa fa-angle-right"></i>'
            //         }
            //     },
            // });
            $('.inventoryCard #tbl_all_lostanddamages').DataTable({
              ordering: true,
              order: [[0, 'asc']], 
              pageLength: 300,
              pagingType: 'full_numbers',
              dom: '<"row view-filter"<"col-sm-12"<"clearfix">>>t<"row"<"col-sm-12"p>>',
              fnDrawCallback: function(oSettings) {
                if (oSettings.aoData.length === 0) {
                  $("#paginationDiv").hide();
                } else {
                  $("#paginationDiv").show();
                }
              }
            })
            $("#paginationDiv").html($(".dt-paging")).show();

            $('#searchInput').on('keyup', function(event) {
              $('.inventoryCard #tbl_all_lostanddamages').DataTable().search($(this).val()).draw();
            });
          }
        })
      }
      function show_expiredProducts() {
        if ($.fn.DataTable.isDataTable(".inventoryCard #tbl_products")) {
            $(".inventoryCard #tbl_products").DataTable().destroy();
        }
        $("#paginationDiv").empty().hide();

        $.ajax({
          type: 'get',
          url: 'api.php?action=get_realtime_notifications',
          success: function (resp_data) {
            var data = resp_data.products;
            var notifications = resp_data.notifications;
            function isActive(value) {
              return value === 1;
            }
            var firstNotif_isActive = isActive(notifications[0].is_active);//30
            var secondNotif_isActive = isActive(notifications[1].is_active);//15
            var thirdNotif_isActive = isActive(notifications[2].is_active);//5
            var fourthNotif_isActive = isActive(notifications[3].is_active);//0
            var totalExpired = 0;
            var temp = false;
            var verifier = false;
            var expiry = data.map(function (item) {
              var days_remaining = item.days_remaining;
              if (firstNotif_isActive && days_remaining <= 30 && days_remaining >= 16) {
                temp = true;
                verifier = true;
              } else if (secondNotif_isActive && days_remaining <= 15 && days_remaining >= 6) {
                temp = true;
                verifier = true;
              } else if (days_remaining <= 5 && days_remaining >= 1) {
                temp = true;
                verifier = true;
              }
              else if (fourthNotif_isActive && days_remaining === 0) {
                temp = true;
                verifier = true;
              }
              else {
                temp = false;
              }
              if (temp) {
                return `<tr>
                    <td class="autofit">${item.prod_desc}</td>
                    <td class="autofit">${item.barcode}</td>
                    <td class="autofit" style="text-align: center">${date_format(item.date_expired)}</td>
                    <td class="autofit" style="text-align: center">This product has a remaining shelf life of <span style = 'color: red; font-size: 14px;'>${days_remaining}</span> days</td>
                </tr>`;
              }
            });
            var tbl_expiry = `
                      <table id="tbl_expiredProducts" class="text-color table-border" style="font-size: 12px;">
                          <thead>
                              <tr>
                                  <th>Product</th>
                                  <th>Barcode</th>
                                  <th style="text-align: center">Expiration Date</th>
                                  <th style="text-align: center; background-color: red">Days Remaining</th>
                              </tr>
                          </thead>
                          <tbody>
                              ${ expiry.join('') }
                          </tbody>
                      </table>`;


            $(".inventoryCard").html(tbl_expiry);

            // $('.inventoryCard #tbl_expiredProducts').DataTable({
            //     ordering: true,
            //     order: [[0, 'asc']], 
            //     pageLength: 50,
            //     sDom: '<"row view-filter"<"col-sm-12"<"clearfix">>>t<"row view-pager"<"col-sm-12"<"pull-center"ip>>>',
            //     language: {
            //         paginate: {
            //             previous: '<i class="fa fa-angle-left"></i>',
            //             next: '<i class="fa fa-angle-right"></i>'
            //         }
            //     },
            // });
            $('.inventoryCard #tbl_expiredProducts').DataTable({
                ordering: true,
                order: [[0, 'asc']], 
                pageLength: 300,
                pagingType: 'full_numbers',
                dom: '<"row view-filter"<"col-sm-12"<"clearfix">>>t<"row"<"col-sm-12"p>>',
                fnDrawCallback: function(oSettings) {
                  if (oSettings.aoData.length === 0) {
                    $("#paginationDiv").hide();
                  } else {
                    $("#paginationDiv").show();
                  }
                }
              })
              $("#paginationDiv").html($(".dt-paging")).show();

              $('#searchInput').on('keyup', function(event) {
                $('.inventoryCard #tbl_expiredProducts').DataTable().search($(this).val()).draw();
              });
          }
        })
      }
      function show_allInventoryCounts() {
        if ($.fn.DataTable.isDataTable(".inventoryCard #tbl_all_inventoryCounts")) {
            $(".inventoryCard #tbl_all_inventoryCounts").DataTable().destroy();
        }
        $("#paginationDiv").empty().hide();
  
        $.ajax({
          type: 'get',
          url: 'api.php?action=get_allInventoryCounts',
          success: function (data) {
            var inv_count_rows;
            if (data.length > 0) {
              inv_count_rows = data.map(function (item) {
                return "<tr>" +
                  "<td class='autofit'>" + item.reference_no + "</td>" +
                  "<td class='autofit' style='text-align: center'>" + date_format(item.date_counted) + "</td>" +
                  "<td style='text-align: center' class='autofit'><button data-id = " + item.id + " id='btn_view_inventoryCount'><i class='bi bi-eye'></i></button></td>" +
                  "</tr>";
              }).join('');
            }

            var inv_count_tbl = "<table id='tbl_all_inventoryCounts' class='text-color table-border' style='font-size: 12px;'>" +
              "<thead>" +
              "<tr>" +
              "<th >Reference No.</th>" +
              "<th style = 'text-align:center'>Date of Transaction</th>" +
              "<th style = 'text-align:center'>Action</th>" +
              "</tr>" +
              "</thead>" +
              "<tbody>" +
              inv_count_rows +
              "</tbody>" +
              "</table>";

            $(".inventoryCard").html(inv_count_tbl);

            // $('.inventoryCard #tbl_all_inventoryCounts').DataTable({
            //     ordering: true,
            //     order: [[0, 'asc']], 
            //     pageLength: 50,
            //     sDom: '<"row view-filter"<"col-sm-12"<"clearfix">>>t<"row view-pager"<"col-sm-12"<"pull-center"ip>>>',
            //     language: {
            //         paginate: {
            //             previous: '<i class="fa fa-angle-left"></i>',
            //             next: '<i class="fa fa-angle-right"></i>'
            //         }
            //     },
            // });
            $('.inventoryCard #tbl_all_inventoryCounts').DataTable({
              ordering: true,
              order: [[0, 'asc']], 
              pageLength: 300,
              pagingType: 'full_numbers',
              dom: '<"row view-filter"<"col-sm-12"<"clearfix">>>t<"row"<"col-sm-12"p>>',
              fnDrawCallback: function(oSettings) {
                if (oSettings.aoData.length === 0) {
                  $("#paginationDiv").hide();
                } else {
                  $("#paginationDiv").show();
                }
              }
            })
            $("#paginationDiv").html($(".dt-paging")).show();

            $('#searchInput').on('keyup', function(event) {
              $('.inventoryCard #tbl_all_inventoryCounts').DataTable().search($(this).val()).draw();
            });
          }
        })
      }

      $(".inventoryCard").on('click', "#btn_view_lossanddamage", function (e) {
        e.preventDefault();
        var id = $(this).data('id');
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
            $("#date_damage").val(date_format(infoData['date_transact']));
            $("#ld_reason").val(infoData['reason']);
            $("#footer_lossand_damages #total_qty").html(infoData['total_qty']);
            $("#footer_lossand_damages #total_cost").html("₱ " + infoData['total_cost']);
            $("#footer_lossand_damages #overall_total_cost").html("₱ " + infoData['over_all_total_cost']);
            $("#loss_and_damage_note").val(infoData['note']);
            var rows = [];
            for (var i = 0; i < ld_data.length; i++) {
              var inventory = ld_data[i];
              var row = "<tr data-id=" + inventory.inventory_id + ">";
              row += "<td>" + inventory.prod_desc + "</td>";
              row += "<td style='text-align:center'>" + inventory.qty_damage + "</td>";
              row += "<td style='text-align:right'>₱ " + addCommasToNumber(inventory.cost) + "</td>";
              row += "<td style='text-align:right'>₱ " + addCommasToNumber(inventory.total_cost) + "</td>";
              rows.push(row);
            }
            tbody.html(rows.join(''));
          }
        })
        $("#loss_and_damage_input").attr('disabled', true);
        $("#btn_searchLDProduct").attr('disabled', true);
        $("#stocktransfer_div").hide();
        $("#received_div").hide()
        $("#quickinventory_div").hide()
        $("#expiration_div").hide()
        $("#lossanddamage_div").show();
             $(".purchase-grid-container button").removeClass('active');
        $("#btn_lossDamage").addClass('active');
        $("#purchaseItems_div").hide();
        $("#inventorycount_div").hide();
        $("#open_po_report").hide();
        $("#btn_savePO").attr("disabled", true);
        $("#btn_omCancel").attr("disabled", true);
        $("#lossanddamage_form").find('input').removeClass('has-error');
        openOptionModal();
      })
      $(".inventoryCard").on("click", "#btn_view_inventoryCount", function (e) {
        e.preventDefault();
        var id = $(this).data('id');
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
            for (var i = 0; i < inventoryData.length; i++) {
              var inventory = inventoryData[i];
              var row = "<tr data-id=" + inventory.inventory_id + " data-ic_id = " + inventory.inventory_count_item_id + ">";
              row += "<td>" + inventory.prod_desc + "</td>";
              row += "<td style='text-align:center'>" + inventory.counted_qty + "</td>";
              row += "<td class='text-center'><input placeholder='QTY' style='text-align:center; width: 60px; height: 20px; font-size: 12px;' class='counted-input' value = " + inventory.counted + " disabled></input></td>";
              var difference = inventory.difference;
              var differenceDisplay = difference > 0 ? "+" + difference : difference;
              row += "<td style='text-align: right'>" + differenceDisplay + "</td>";
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
            $("#open_po_report").hide();
            $("#qi_inventory_type").attr("disabled", true);
            $("#btn_go_inventory").attr("disabled", true);
            $("#btn_savePO").attr("disabled", true);
            $("#btn_omCancel").attr("disabled", true);
            $("#inventorycount_form").find('input').removeClass('has-error');
            openOptionModal();

          }
        })
      })
      function display_datePurchased() {
        var currentDate = new Date();
        var formattedDate = formatDate(currentDate);
        $('#date_purchased').val(formattedDate);
      }
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

      function updateTotal() {
        var totalQty = 0;
        var totalPrice = 0;
        var total = 0;
        var totalTax = 0;
        $('#tbl_purchaseOrders tbody tr').each(function () {
          var quantity = parseInt($(this).find('td:nth-child(2)').text().trim(), 10);
          var price = parseFloat(clean_number($(this).find('td:nth-child(3)').text().trim()));
          var subtotal = parseFloat(clean_number($(this).find('td:nth-child(4)').text().trim()));
          var tax = (price / 1.12);
          totalTax += (price - tax);
          totalQty += quantity;
          totalPrice += price;
          total += subtotal;
        });
        $("#totalTax").html("Tax: " + addCommasToNumber(totalTax));
        $("#totalQty").html(totalQty);
        $("#totalPrice").html("&#x20B1;&nbsp;" + addCommasToNumber(totalPrice));
        $("#overallTotal").html("&#x20B1;&nbsp;" + addCommasToNumber(total));
      }
      $("#unpaid_form").on('submit', function (e) {
        e.preventDefault();
        if (validateUPForm()) {
          submit_purchaseOrder();
        }
      })
      var isSavingPO = false;
      function submit_purchaseOrder() {
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

          $.ajax({
            type: 'POST',
            url: 'api.php?action=save_purchaseOrder',
            data: {
              data: JSON.stringify(dataArray),
              po_number: $("#pcs_no").val(),
              isPaid: $('#paidSwitch').prop('checked'),
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
              payment_settings: $("#unpaid_form").serialize(),
              amortization_frequency_text: $("#amortization_frequency option:selected").text(),
            },
            dataType: 'json',
            success: function (response) {
              isSavingPO = false;
              console.log(response)
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
                show_allProducts();
                show_allSuppliers();
                display_datePurchased();
                show_allReceivedItems_PurchaseOrders();
                hideModals();
                $('#show_purchasePrintModal').show()
                if($('#show_purchasePrintModal').is(":visible"))
                {
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
                $(".inventoryCard table").attr('id') === "tbl_orders" ? show_allOrders() : show_allInventories();
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
          "onclick": function () { alert('Clicked'); }

        };
        toastr.success(message);
      }
      function show_errorResponse(message) {
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
          "onclick": function () { alert('Clicked'); }

        };
        toastr.error(message);
      }

      $("#btn_savePO").click(function (e) {
        e.preventDefault();
        var activeModuleId = $("button.active").attr('id');
        if (activeModuleId === "btn_expiration") {
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
              if (response.status) {

                show_sweetReponse(response.msg);
                show_expiration();
              }
            }
          })
        }
        if (activeModuleId === "btn_quickInventory") {
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
              if (response.status) {
                show_sweetReponse(response.msg);
                var po_number = $("#q_product").val();
                $("#tbl_quickInventories tbody").empty();
                hideModals();
              }
            }
          })
        }
        if (activeModuleId === "btn_inventoryCount") {
          var rowCount = $("#tbl_inventory_count tbody tr").length;
          if(rowCount > 0)
          {
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
                  show_allInventories();
                  hideModals();
                }
              }
            })
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
              var table_id = "tbl_lossand_damages";
              var loss_and_damage_form = $("#lossanddamage_form").serialize();
              if (validateTableInputs(table_id)) {
                var tbl_data = [];
                var subRowData = [];
                $("#tbl_lossand_damages tbody tr:not(.sub-row)").each(function () {
                  var row_data = {};
                  row_data['inventory_id'] = $(this).data('id');
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
                      show_allInventories();
                      hideModals();
                    }
                  }
                })
              }
            }
            else {
              alert("Please add a product");
            }
          }
        }
        if (activeModuleId === "btn_receiveItems") {
          var table_id = "tbl_receivedItems";
          var received_items_length = $("#tbl_receivedItems tbody tr").length;
          if (received_items_length > 0) {
            if (validateTableInputs(table_id)) {
              $("#received_payment_confirmation").slideDown({
                backdrop: 'static',
                keyboard: false,
              });
              $("#received_payment_confirmation #paid_title").html("Before proceeding, would you like to <b style = 'color: #FF6900'>UPDATE</b> the data for these <b style = 'color: #FF6900'>ITEMS?</b><br><br>");
              $("#received_payment_confirmation #total_paid").html($("#overallTotal").text());
              $("#received_payment_confirmation #paid_modalTitle").html("<i class = 'bi bi-exclamation-triangle style = 'color: red;'></i>&nbsp; <strong style = 'color: #FF6700;'>ATTENTION REQUIRED!</strong> ");
              $("#received_payment_confirmation #btn_confirmPayment").on("click", function (e) {

                e.preventDefault();
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
                    user_name: $("#first_name").val()+" "+$("#last_name").val(),
                  },
                  success: function (response) {

                    if (response.status) {
                      show_sweetReponse(response.msg);
                      $("#r_PONumbers").val("");
                      $("#is_received").val("0");
                      $("#tbL_receivedItems tbody").empty();
                      $("#po_data_div").hide();
                      $("#received_payment_confirmation").hide();
                      show_allReceivedItems_PurchaseOrders();
                      show_allInventories();
                      isSaving = false;
                      hideModals();
                    }

                  },
                  error: function () {
                  }
                })
              })
            }
          }
          else {
            alert("Please find a purchase number first!");
          }
        }
        else {
          var tbl_poL = $("#po_body tr").length;
          if (tbl_poL > 0) {
            var order_id = $("#_order_id").val();
            if (order_id > 0) {
              $("#paid_purchase_modal").slideDown({
                backdrop: 'static',
                keyboard: false,
              });
              $("#paid_title").html("Would you like to <b style = 'color: #FF6900'>UPDATE</b> the data for these <b style = 'color: #FF6900'>ITEMS?</b><br><br>Please <b style = 'color: #FF6900'>CONFIRM</b> your <b style = 'color: #FF6900'>PAYMENT: </b>");
              $("#total_paid").html($("#overallTotal").text());
              $("#paid_modalTitle").html("<i class = 'bi bi-exclamation-triangle style = 'color: red;' '></i>&nbsp; <strong>ATTENTION REQUIRED!</strong> ");
              $("#btn_confirmPayment").click(function () {
                submit_purchaseOrder();
              })
            }
            else {
              if ($("#paidSwitch").prop("checked") === false) {
                $("#unpaid_purchase_modal").slideDown({
                  backdrop: 'static',
                  keyboard: false,
                });
                $("#unpaid_form")[0].reset();
                $("#product_name").text($("#product").val());
                $("#s_price").val($("#overallTotal").text());
                $("#r_balance").val($("#overallTotal").text());
                $("#loan_amount").val($("#overallTotal").text());
                $("#unpaid_modalTitle").html("<i class = 'bi bi-exclamation-triangle' style = 'color: red;'></i>&nbsp; <strong>ATTENTION REQUIRED!</strong> ");
              }
              else {
                $("#paid_purchase_modal").slideDown({
                  backdrop: 'static',
                  keyboard: false,
                });
                $("#total_paid").html($("#overallTotal").text());
                $("#paid_modalTitle").html("<i class = 'bi bi-exclamation-triangle style = 'color: red;' '></i>&nbsp; <strong>ATTENTION REQUIRED!</strong> ");
                $("#btn_confirmPayment").click(function () {
                  submit_purchaseOrder();
                })
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
      function isDataExistInTable(data) {
        var data = data;
        var isExist = false;
        $('#tbl_purchaseOrders tbody').each(function () {
          var rowData = $(this).find('td:first').data('rowid');
          if (rowData == data) {
            isExist = true;
          }
        });
        return isExist;
      }
     
      $("#btn_addPO").click(function (e) {
        e.preventDefault();
        var product = $("#product").val();
        var product_id = $("#selected_product_id").val();
        if (!isDataExistInTable(product_id)) {
          if (validatePOForm()) {
            var qty = 0;
            var price = 0;
            hidePopups();
           show_purchaseQtyModal(product_id, qty, price);
          }
        }
        else {
          show_errorResponse("Item is already in the table");
          $("#product").val("");
          $("#selected_product_id").val("0");
        }
      })
      function roundToTwoDecimalPlaces(number) {
        return parseFloat(number).toFixed(2);
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
      function validateUPForm() {
        var isValid = true;
        $('#unpaid_form   input[type=text], input[type=number], input[type=date]').each(function () {
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
      function validateProductForm() {
        var isValid = true;
        $('#prod_form input[type=text]').each(function () {
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
      $('#prod_form input').on('keypress', function(event) {
          if (event.keyCode === 13) {
            $(this).submit();
          }
      });
      $('#date_purchased').on('focus click', function(event) {
                event.preventDefault();
              hidePopups();
            });
      $("#prod_form").on("submit", function (event) {
        event.preventDefault();
        
        if (validateProductForm()) {
          var p_qty = parseFloat($("#p_qty").val());
          var price = parseFloat($("#price").val());
          var product_id = $("#selected_product_id").val();
          var total = (price * p_qty);
          $.ajax({
            type: 'get',
            url: 'api.php?action=get_productInfo',
            data: { data: product_id },
            success: function (data) {
              var tax = 0;
              if (data['isVat'] === 1) {
                tax = (price / 1.12);
                totalTax += (price - tax);
              }
              else totalTax += 0;

              totalQty += p_qty;
              totalPrice += price;
              overallTotal += total;
              $("#totalTax").html(totalTax.toFixed(2));

              var $rowToUpdate = $("#tbl_purchaseOrders tbody").find("tr[data-rowid='" + product_id + "']");
                if ($rowToUpdate.length > 0) {
                    $rowToUpdate.find("td").eq(0).text(data['prod_desc']);
                    $rowToUpdate.find("td").eq(1).text(p_qty); 
                    $rowToUpdate.find("td").eq(2).html("&#x20B1;&nbsp;" + addCommasToNumber(price)); 
                    $rowToUpdate.find("td").eq(3).html("&#x20B1;&nbsp;" + addCommasToNumber(total)); 
                } 
              else
              {
                console.log("No")
                $("#tbl_purchaseOrders tbody").append(
                  "<tr data-rowid = "+data['id']+">" +
                  "<td data-rowid = "+data['id']+" data-id = " + data['id'] + " data-inv_id = " + data['inventory_id']+ " data-qty = " + p_qty+ " data-price = " + price + " >" + data['prod_desc'] + "</td>" +
                  "<td style = 'text-align: center' class ='editable'>" + p_qty + "</td>" +
                  "<td style = 'text-align: right' class ='editable'>&#x20B1;&nbsp;" + addCommasToNumber(price) + "</td>" +
                  "<td style = 'text-align: right'>&#x20B1;&nbsp;" + addCommasToNumber(total) + "</td>" +
                  "</tr>"
                );
              }
            

              $("#totalQty").html(totalQty);
              $("#totalPrice").html("&#x20B1;&nbsp;" + addCommasToNumber(totalPrice.toFixed(2)));
              $("#overallTotal").html("&#x20B1;&nbsp;" + addCommasToNumber(overallTotal.toFixed(2)));

              $("#purchaseQty_modal").hide();
              $("#prod_form")[0].reset();
              $("#product").val("");
              show_allProducts();
              $("#item_verifier").val("");
            }
          })
        }
      })
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

      // function show_allSuppliers() {
      //   $.ajax({
      //     type: 'GET',
      //     url: 'api.php?action=get_allSuppliers',
      //     success: function (data) {
      //       var suppliers = [];
      //       for (var i = 0; i < data.length; i++) {
      //         suppliers.push(data[i].supplier)
      //       }
      //       autocomplete(document.getElementById("supplier"), suppliers);
      //     }
      //   })
      // }
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
          }
        })
      }
      function autocomplete(inp, arr) {
        var currentFocus;
        inp.addEventListener("input", function (e) {
          var a, b, i, val = this.value;
          closeAllLists();
          if (!val) { return false; }
          currentFocus = -1;
          a = document.createElement("DIV");
          a.setAttribute("id", this.id + "autocomplete-list");
          a.setAttribute("class", "autocomplete-items");
          this.parentNode.appendChild(a);
          for (i = 0; i < arr.length; i++) {
            if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
              b = document.createElement("DIV");
              b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
              b.innerHTML += arr[i].substr(val.length);
              b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
              b.addEventListener("click", function (e) {
                inp.value = this.getElementsByTagName("input")[0].value;
                closeAllLists();
              });
              a.appendChild(b);
            }
          }
        });
        inp.addEventListener("keydown", function (e) {
          var x = document.getElementById(this.id + "autocomplete-list");
          if (x) x = x.getElementsByTagName("div");
          if (e.keyCode == 40) {
            currentFocus++;
            addActive(x);
          }
          else if (e.keyCode == 38) {
            currentFocus--;
            addActive(x);
          }
          else if (e.keyCode == 13) {
            e.preventDefault();
            if (currentFocus > -1) {
              if (x) x[currentFocus].click();
            }
          }
        });
        function addActive(x) {
          if (!x) return false;
          removeActive(x);
          if (currentFocus >= x.length) currentFocus = 0;
          if (currentFocus < 0) currentFocus = (x.length - 1);
          x[currentFocus].classList.add("autocomplete-active");
        }
        function removeActive(x) {
          for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
          }
        }
        function closeAllLists(elmnt) {
          var x = document.getElementsByClassName("autocomplete-items");
          for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
              x[i].parentNode.removeChild(x[i]);
            }
          }
        }
        document.addEventListener("click", function (e) {
          closeAllLists(e.target);
        });
      }

      var finish = 0;
      show_allProducts();
      $("#product").autocomplete({
        minLength: 2,
        source: function (request, response) {
          var term = request.term;
          var filteredProducts = filterProducts(term);
          var slicedProducts = filteredProducts.slice(0, 5);
          response(slicedProducts);
          if (slicedProducts.length > 0) {
            $('#filters').show();
          } else {
              $('#filters').hide();
          }
          hidePopups();
          var slicedProductsLength = slicedProducts.length - 1;
          var selectedProductId = slicedProducts[slicedProductsLength].id;
            $("#selected_product_id").val(selectedProductId);
          },
          select: function (event, ui) {
            hidePopups();
            var selectedProductId = ui.item.id;
            $("#selected_product_id").val(selectedProductId);
            return false;
          },
      });
      $("#product").on("input", function() {
        hidePopups();
          var term = $(this).val();
          $(this).autocomplete('search', term);
      });
      $("#product").on("keypress", function(event){
        if(event.which === 13){
          $('#date_purchased').attr('readonly', true);
          $('#calendar-btn').attr('readonly', true);
          hidePopups();
          var product_id = $("#selected_product_id").val();
          if (!isDataExistInTable(product_id)) {
            var qty = 0;
            var price = 0;
           show_purchaseQtyModal(product_id, qty, price);
          }
          else
          {
            show_errorResponse("Product already exists in the purchase table")
          }
          $("#product").val('');
        }
      
      })

      $("#product").on("autocompletechange", function(event, ui) {
        var product_id = $("#selected_product_id").val();
        hidePopups();
        if (!isDataExistInTable(product_id)) {
          var qty = 0;
          var price = 0;
          show_purchaseQtyModal(product_id, qty, price);
        }
        else
        {
          show_errorResponse("Product already exists in the purchase table")
        }
          $(this).val('');
      });
      // function filterProducts(term) {
      //   return productsCache.filter(function (row) {
      //     return row.product.toLowerCase().includes(term) ||
      //       row.barcode.includes(term) ||
      //       (row.brand && row.brand.toLowerCase().includes(term)) ||
      //       (!row.brand && term === "");
      //   }).map(function (row) {
      //     var brand = row.brand === null ? " " : row.brand;
      //     return {
      //       label: row.product + " (" + row.barcode + ")" + " (" + brand + ")",
      //       value: row.barcode ?? row.product,
      //       inventory_id: row.inventory_id,
      //       id: row.product_id
      //     };
      //   });
      // }
      function filterProducts(term) {
          return productsCache.filter(function(row) {
              var lowercaseTerm = term.toLowerCase();
              return row.product.toLowerCase().includes(lowercaseTerm) ||
                  row.barcode.includes(lowercaseTerm) ||
                  (row.brand && row.brand.toLowerCase().includes(lowercaseTerm)) ||
                  (!row.brand && lowercaseTerm === "");
          }).map(function(row) {
              var brand = row.brand === null ? " " : "( " + row.brand + " )";
              return {
                  label: row.product + " (" + row.barcode + ")",
                  value: row.barcode ?? row.product,
                  inventory_id: row.inventory_id,
                  id: row.product_id
              };
          });
      }
      function check_ifProductCacheExists(product_id)
      {
        var searchDataExists = false;
 
        $.each(productsCache, function(index, item){
            if(item.product_id === product_id){
                searchDataExists = true;
                return false; 
            }
        });
        return searchDataExists;
      }
      function hidePopups() {
        $('#date_purchased').removeAttr('autofocus');
        $('#calendar-btn').removeAttr('autofocus');
        $("#p_qty").focus();
        $("#date_purchased").flatpickr().destroy();
        $("#date_purchased").blur();
        $("#date_purchased").flatpickr().close();
      }
      function show_purchaseQtyModal(product_id, qty, price )
      {
        hidePopups();
        $("#prod_form #p_qty").focus();
        if(product_id !== -1)
        {
          $("#selected_product_id").val(product_id);
          $("#purchaseQty_modal").slideDown({
            backdrop: 'static',
            keyboard: false,
          });
          $.ajax({
            type: 'get',
            url: 'api.php?action=get_productInfo',
            data: { data: product_id },
            success: function (data) {
         
              var _price = price === 0 ? data['cost'] : price;
              var _qty = qty === 0 ? data['qty_purchased'] : qty;
              $("#product_name").text(data['prod_desc'] + " : " + data['barcode']);
              $("#purchaseQty_modal #p_qty").val(_qty);
              $("#purchaseQty_modal #price").val(_price);
              $("#pqty_modalTitle").html("<i class = 'bi bi-exclamation-triangle style = 'color: red;'></i>&nbsp; <strong style = 'color:  #ffff'>ATTENTION REQUIRED!</strong> ");
            }
          });
        }
      }
      function show_allProducts() {
        $.ajax({
          type: 'GET',
          url: 'api.php?action=get_allProducts',
          success: function (data) {
            for (var i = 0; i < data.length; i++) {
              var row = {
                inventory_id: data[i].inventory_id,
                product_id: data[i].id,
                product: data[i].prod_desc,
                barcode: data[i].barcode,
                brand: data[i].brand,
              };
              productsCache.push(row);
            }
          }
        });
      }
      function show_allInventories() 
      {
        if ($.fn.DataTable.isDataTable(".inventoryCard #tbl_products")) {
            $(".inventoryCard #tbl_products").DataTable().destroy();
        }
        $("#paginationDiv").empty().hide();
        $("#searchInput").focus();

        var tblData = `
            <table tabindex='0' id='tbl_products' class='text-color table-border display' style='font-size: 12px;'>
                <thead>
                    <tr>
                        <th class='text-center auto-fit'>No.</th>
                        <th class='auto-fit'>Product</th>
                        <th class='auto-fit'>Barcode</th>
                        <th class='auto-fit' style='text-align: center'>Unit</th>
                        <th class='auto-fit' style='text-align: center'>Qty Purchased</th>
                        <th class='auto-fit' style='text-align: center'>Qty Received</th>
                        <th class='auto-fit' style='text-align: center'>Qty in Store</th>
                        <th class='auto-fit' style='text-align: center'>Amount Before Tax</th>
                        <th class='auto-fit' style='text-align: center'>Amount After Tax</th>
                        <th class='auto-fit' style='text-align: center'>Document Type</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>`;

        $(".inventoryCard").html(tblData);
   

        var table = $('.inventoryCard #tbl_products').DataTable({
          serverSide: true,
          processing: true,
          ajax: {
            url: 'api.php?action=get_allInventories',
            type: 'POST'
          },
          columns: [
              { data: null, render: function (data, type, row, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
              }},
              { data: 'prod_desc' },
              { data: 'barcode' },
              { data: 'uom_name', className: 'text-center' },
              { data: 'qty_purchased', className: 'text-center' },
              { data: 'qty_received', className: 'text-center' },
              { data: 'product_stock', className: 'text-center' },
              { data: 'cost', render: function (data) { return '<span style="text-align: right; display: block;">&#x20B1; ' + addCommasToNumber(data) + '</span>'; } },
              { data: 'prod_price', render: function (data) { return '<span style="text-align: right; display: block;">&#x20B1; ' + addCommasToNumber(data) + '</span>'; } },
              { data: null, render: function (data) {
                  var stock = data.product_stock !== null ? data.product_stock : 0;
                  if (stock <= 10 && data.isReceived == 0) {
                      return "<span style='color: violet'><i>TO PURCHASE</i></span>";
                  } else if (stock > 0 && data.isReceived == 2) {
                      return "<span style='color: yellow'>PURCHASED</span>";
                  } else {
                      return "<span style='color: lightgreen'>RECEIVED</span>";
                  }
              }, className: 'text-center' }
          ],
          ordering: true,
          order: [[1, 'asc']],
          pageLength: 100,
          pagingType: 'full_numbers',
          dom: '<"row view-filter"<"col-sm-12"<"clearfix">>>t<"row"<"col-sm-12"p>>',
          fnDrawCallback: function (oSettings) {
              if (oSettings.aoData.length === 0) {
                  $("#paginationDiv").hide();
              } else {
                  $("#paginationDiv").show();
              }
              }
          });
          table;
          $("#paginationDiv").html($(".dt-paging")).show();
          var debounceTimeout;
          $('#searchInput').on('keyup', function (event) {
              clearTimeout(debounceTimeout);
              debounceTimeout = setTimeout(function () {
                  table.search($('#searchInput').val()).draw();
              }, 100); 
          });
        }
        $('#product').on('keypress', function(event) {
          if (event.keyCode === 13 || event.keyCode === 27) { 
            hidePopups();
          }
        });
        function date_format(date) {
          var date = new Date(date);
          var formattedDate = $.datepicker.formatDate("M dd yy", date);
          return formattedDate;
        }
        $(".inventoryCard").on("click", "#btn_removeOrder", function(e){
          e.preventDefault();
          var is_received = $(this).data('isreceived');
          var order_id = $(this).data("id");
          if(is_received === 1)
          {
            var po_title = '<h6 style = "color: #FF9999; font-weight: bold">Sorry, the <i style = "color: red">PURCHASE ORDER</i> cannot be removed as it has already been received.</h6>';
            $("#purchaseOrder_response .po_title").html(po_title);
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
                  }
              },
              error: function(response)
              {
                  console.log("Server Error:")
              }
          })
        })
        function show_allOrders() {
          if ($.fn.DataTable.isDataTable(".inventoryCard #tbl_orders")) {
              $(".inventoryCard #tbl_orders").DataTable().destroy();
          }
          $("#paginationDiv").empty().hide();
          $("#searchInput").focus();

          var tblData = `
              <table tabindex = '0' id='tbl_orders' class='text-color table-border display' style='font-size: 12px;'>
                  <thead>
                      <tr>
                          <th style='width: 2%;'>PO#</th>
                          <th style='width: 4%;'>Supplier</th>
                          <th style='width: 2%;'>Date Purchased</th>
                          <th style='width: 2%;'>Due Date</th>
                          <th style='width: 2%;'>Total</th>
                          <th style='width: 2%;'>Is Paid</th>
                          <th style='width: 2%;'>Status</th>
                          <th style='width: 1%;'>Action</th>
                      </tr>
                  </thead>
                  <tbody></tbody>
              </table>`;

          $(".inventoryCard").html(tblData);

          var table = $('.inventoryCard #tbl_orders').DataTable({
              serverSide: true,
              processing: true,
              ajax: {
                  url: 'api.php?action=get_allOrders',
                  type: 'GET'
              },
              columns: [
                  { data: 'po_number', className: 'text-center' },
                  { data: 'supplier' },
                  { data: 'date_purchased', className: 'text-center' },
                  {
                      data: 'due_date',
                      className: 'text-center',
                      render: function (data) {
                          return data ? date_format(data) : 'Not Available';
                      }
                  },
                  {
                      data: 'price',
                      className: 'text-right',
                      render: function (data) {
                          return '&#x20B1;&nbsp;' + addCommasToNumber(data);
                      }
                  },
                  {
                      data: 'isPaid',
                      className: 'text-center',
                      render: function (data) {
                          return data === 1 ? "<span class='text-center badge-success'>Paid</span>" : "<span class='text-center badge-danger'>Unpaid</span>";
                      }
                  },
                  {
                      data: 'is_received',
                      className: 'text-center',
                      render: function (data) {
                          return data === 1 ? "<span class='text-center badge-success' >Received</span>" : "<span class='text-center badge-warning' style = 'color: yellow;'>To Receive</span>";
                      }
                  },
                  {
                      data: null,
                      className: 'text-center',
                      render: function (data) {
                        return `
                            <div class = 'icon-container'>
                              <i data-id='${data.order_id}' id='btn_openPayment' ${data.isPaid === 1 ? "disabled" : ""} class='bi bi-cash bi-md icon-button'></i>
                              <i data-id='${data.order_id}' id='btn_editOrder' class='bi bi-pencil-fill bi-md icon-button'></i>
                              <i data-id='${data.order_id}' data-isReceived='${data.is_received}' id='btn_removeOrder' class='bi bi-trash bi-md icon-button'></i>
                            </div>`;
                          // return `
                          //     <button data-id='${data.order_id}' class='grid-item button btn_openPayment' id='btn_openPayment' ${data.isPaid === 1 ? "disabled" : ""}><i class='bi bi-cash bi-md'></i></button>
                          //     <button data-id='${data.order_id}' class='grid-item button btn_editOrder' id='btn_editOrder'><i class='bi bi-pencil-fill bi-md'></i></button>
                          //     <button data-id='${data.order_id}' data-isReceived='${data.is_received}' class='grid-item button btn_removeOrder' id='btn_removeOrder'><i class='bi bi-trash bi-md'></i></button>
                          // `;
                      }
                  }
              ],
              ordering: true,
              order: [[0, 'asc']],
              pageLength: 100,
              dom: '<"row view-filter"<"col-sm-12"<"clearfix">>>t<"row"<"col-sm-12"p>>',
              fnDrawCallback: function (oSettings) {
                  if (oSettings.aoData.length === 0) {
                      $("#paginationDiv").hide();
                  } else {
                      $("#paginationDiv").show();
                  }
              },
              createdRow: function (row, data, dataIndex) {
                $(row).attr('data-id', data.order_id);
              }
          });

          table;
          $("#paginationDiv").html($(".dt-paging")).show();
          var debounceTimeout;
          $('#searchInput').on('keyup', function (event) {
              clearTimeout(debounceTimeout);
              debounceTimeout = setTimeout(function () {
                  table.search($('#searchInput').val()).draw();
              }, 100); 
          });
      }
      
      $("#tbl_purchaseOrders tbody").on("dblclick", "tr", function() {
          var productId = $(this).find("td[data-id]").data("id");
          var qty_purchased = $(this).find("td:nth-child(2)").text();
          var price = clean_number($(this).find("td:nth-child(3)").text());

          $("#selected_product_id").val(productId);
          show_purchaseQtyModal(productId, qty_purchased, price);
      });
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

      $(".inventoryCard").on('click', '.btn_editOrder', function (e) {
        e.preventDefault();
        var order_id = $(this).data('id');
        $("#stocktransfer_div").hide();
        $("#received_div").hide()
        $("#quickinventory_div").hide()
        $("#expiration_div").hide()
        $("#lossanddamage_div").hide()
        $("#inventorycount_div").hide();
        $(".purchase-grid-container button").removeClass('active');
        $("#btn_createPO").addClass('active');
        $("#purchaseItems_div").show()
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
              $("#paidSwitch").css('background-color', 'green');
              $('#paidSwitch').prop('checked', true).prop('disabled', true);
            }
            else {
              $("#paidSwitch").css('background-color', '#ffff');
              $('#paidSwitch').prop('checked', false).prop('disabled', true);
            }
          
            for (var i = 0; i < data.length; i++) 
            {
              table += "<tr data-rowid = "+data[i].product_id+" id = 'show_pqtymodal'>";
              table += "<td data-rowid = "+data[i].product_id+" data-id = " + data[i].product_id + " data-inv_id = " + data[i].inventory_id + ">" + data[i].prod_desc + " </td>";
              table += "<td style = 'text-align: center' class ='editable' data-qty = "+data[i].qty_purchased+" data-price= "+data[i].amount_beforeTax+">" + data[i].qty_purchased + "</td>";
              table += "<td style = 'text-align: right' class ='editable'>&#x20B1;&nbsp;" + addCommasToNumber(data[i].amount_beforeTax) + "</td>";
              table += "<td style = 'text-align: right'>&#x20B1;&nbsp;" + addCommasToNumber(data[i].total) + "</td>";
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
            alert("No response")
          }
        })

      })
      function clean_number(number) {
        return number.replace(/[₱\s]/g, '');
      }
      // $('#searchInput').on('input', function(){
      //     var searchText = $(this).val().toLowerCase();

      //     $('.inventoryCard table tbody tr').each(function(){
      //         var rowText = $(this).text().toLowerCase();
      //         if(rowText.includes(searchText)){
      //             $(this).show();
      //         } else {
      //             $(this).hide();
      //         }
      //     });
          
      // });


      // $('#searchInput').on('keyup', function (event) {
      //   if (event.keyCode === 13 || $(this).val().length >= 12)
      //     {
      //       $(this).val(''); 
      //     }
      // });

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
      $("#btn_openOption").click(function (e) {
        e.preventDefault();
        
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
       
      })
      $("#btn_createPO").click(function (e) {
        e.preventDefault();
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
        $("#po_form #product").focus();
      })
      $("#btn_receiveItems").click(function (e) {
        e.preventDefault();
        $(".purchase-grid-container button").removeClass('active');
        $(this).addClass('active');
        $("#po_data_div").hide();
        $("#expiration_div").hide();
        $("#purchaseItems_div").hide();
        $("#received_div").show();
        $("#quickinventory_div").hide();
        $("#stocktransfer_div").hide();
        $("#lossanddamage_div").hide()
        $("#inventorycount_div").hide();
        $("#open_po_report").hide();
        $("#receive_form #r_PONumbers").focus();
      })
      $("#btn_stockTransfer").click(function (e) {
        e.preventDefault();
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
      })
      $("#btn_quickInventory").click(function (e) {
        e.preventDefault();
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
      })
      $("#btn_lossDamage").click(function (e) {
        e.preventDefault();
        $("#loss_and_damage_input").focus();
        $("#loss_and_damage_input").attr('disabled', false);
        $("#btn_searchLDProduct").attr('disabled', false);
        $("#lossanddamage_form")[0].reset();
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
      })
      $("#btn_inventoryCount").click(function (e) {
        e.preventDefault();
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
        hidePopups();
        $("#po_form #product").focus();
      }
    })
  </script>
  <script>
    // $(document).on('input', '#product', function () {
    //   var searchTerm = $(this).val().trim().toLowerCase();
    //   $('.search-dropdown-item').each(function () {
    //     var text = $(this).text().trim().toLowerCase();
    //     if (text.includes(searchTerm)) {
    //       $(this).show();
    //     }
    //     else {
    //       $(this).hide();
    //     }
    //   });
    //   $("#d_products").css('display', searchTerm ? 'block' : 'none');
    // });
    // $(document).on('click', '.search-dropdown-item', function () {
    //   var clickedItem = $(this);
    //   $("#product").val(clickedItem.text());
    //   $("#d_products").css('display', 'none');
    // });
  
    $(document).on('click', '.search-dropdown-item1', function () {
      var clickedItem = $(this);
      $("#supplier").val(clickedItem.text());
      $("#d_suppliers").css('display', 'none');
    });
  </script>