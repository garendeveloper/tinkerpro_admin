<?php

  include( __DIR__ . '/layout/header.php');
  include( __DIR__ . '/utils/db/connector.php');
  include( __DIR__ . '/utils/models/product-facade.php');
  include( __DIR__ . '/utils/models/ingredients-facade.php');
  include(__DIR__ . '/utils/models/ability-facade.php');
  
  $productFacade = new ProductFacade;

  $userId = 0;
  
  $abilityFacade = new AbilityFacade;

  if (isset($_SESSION['totalPages'])) {
    $totalPages = $_SESSION['totalPages'];
    unset($_SESSION['totalPages']); 
}

if (isset($_SESSION['user_id'])) {
 
    $userID = $_SESSION['user_id'];

    
    $permissions = $abilityFacade->perm($userID);

    
    $accessGranted = false;
    foreach ($permissions as $permission) {
        if (isset($permission['Products']) && $permission['Products'] == "Access Granted") {
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

  if (isset($_SESSION["user_id"])){
    $userId = $_SESSION["user_id"];
  }
  if (isset($_SESSION["first_name"])){
    $firstName = $_SESSION["first_name"];
  }
  if (isset($_SESSION["last_name"])){
    $lastName = $_SESSION["last_name"];
  }


  // Redirect to login page if user has not been logged in
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

  include('./modals/add-products-modal.php');
  include('./modals/category-modal.php');
  include('./modals/add-bom.php');
  include('./modals/add-price-list.php');
  include('./modals/loading-modal.php');
?>
<style>
  #topBar{
  background-color:#262626
}
.content-wrapper{
    background-color: #262626;
  
  }
  .searchProducts{
  background-color: #7C7C7C;
  }
  .text-color::placeholder {
  color: #ffff;
}
.btn-control{
  font-family: Century Gothic;
  border-radius: none;
  border-color: #33557F;
}
.btn-success-custom{
  background-color: #00B050
}
.btn-error-custom{
  background-color: red;
}
.btn-control:hover {
    border-color: var(--primary-color); 
    color: #fefefe !important; 
}
.productTable{
    position: absolute; 
    left: 2px;
    right:2px;
    top:2px;
    
}
.table-border{
    border-collapse: collapse;
    border: 1px solid white;
}

.table-border th, td {
  border: 1px solid white;
  padding: 8px;
}
.table-border th{
  background-color: none;
}




.text-color{
    color: #ffff;
    font-family: Century Gothic;
  }
  .table-responsive {
    max-height: 600px;

   
}

.table-responsive table {
    width: 100px;
    border-collapse: collapse;
}
.card {
  background-color: #151515;
  border-color: #242424;
  height: 200px;
overflow: hidden;
  border-radius: 8px;
  padding: 16px;
}


.deleteBtn {
  background: transparent;
  border-radius: 0;
}

button.btn.btn-secondary.deleteBtn.deleteProductItem {
  border: 1px solid var(--border-color);

}

  .highlighteds{
     border: 2px solid #00B050 !important; 
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

    .paginactionClass{
      margin-top: 20px;
      margin-bottom: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
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

#responsive-data {
  overflow-x: hidden;
  max-height: 80vh;
  position: absolute;
  left: 2px;
  right: 2px;
  top: 2px;
}


#responsive-data{
    width: 100%;
  }
    #responsive-data thead {
        display: table; 
        width: calc(100% - 4px);
    }

    #responsive-data tbody {
        display: block; 
        max-height: 78vh; 
        overflow-y: scroll;
    }

    #responsive-data th, td {
        width: auto;
        overflow-wrap: break-word; 
        box-sizing: border-box;
    }
    #responsive-data tr {
        display: table;
        width: 100%;
    }
    #responsive-data, table, thead, tbody{
      border: 1px solid #292928;
    }
    #responsive-data table{
        background-color: #1e1e1e;
        border: 1px solid #262626;
        height: 5px;
        padding: 10px 10px;
    }
  @media (max-width: 1200px) {
      #responsive-data th, #responsive-data td {
          width: 9%; 
      }
  }

  @media (max-width: 992px) {
      #responsive-data th, #responsive-data td {
          width: 8%; 
      }
  }

  @media (max-width: 768px) {
      #responsive-data th, #responsive-data td {
          width: 7%;
      }
  }

  @media (max-width: 768px) {
      #responsive-data {
          display: block;
          overflow-x: auto;
          -webkit-overflow-scrolling: touch;
      }
  }
#responsive-data tbody::-webkit-scrollbar {
    width: 4px; 
}
#responsive-data tbody::-webkit-scrollbar-track {
    background: #151515;
}
#responsive-data tbody::-webkit-scrollbar-thumb {
    background: #888; 
    border-radius: 50px; 
}





.productHeader tr th {
  background: none;
  border: 1px solid #262626;
 }



 .productBTNs  {
  border: 1px solid transparent; 
  width: 3vw; 
  border-radius: 0;
  height: 35px;
 }


/* #responsive-data {
  max-height: 700px;
  position: absolute;
  left: 2px;
  right: 2px;
  top: 2px;
 
}

#responsive-data thead {
  display: block;
}

#responsive-data tbody {
  display: block;
  max-height: 600px;
  overflow-y: auto; 
  max-width: fit-content;
}
 */
.font-size{
  font-size: 12px !important;
}


.main-panel {
    /* -webkit-user-select: none; 
    -moz-user-select: none;   
    -ms-user-select: none;  
    user-select: none;    */
}


.search_design {
 width: 100%; 
 height: 35px; 
 font-style: italic; 
 border-top-left-radius: 100px;
 border-bottom-left-radius: 100px;
 margin-right: 0;
}

.searchIconD {
  background: #7C7C7C;

}


.addProducts {

  background: #7C7C7C;
  border-top-right-radius : 100px;
  border-bottom-right-radius : 100px;
}
 .addProducts.productBTNs {
  width: 1550px;
}






</style>

<?php include "layout/admin/css.php"?> 
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include 'layout/admin/sidebar.php' ?>
      <!-- partial -->
      <div class="main-panel" style="height: 100vh">
        <div class="content-wrapper" style="height: 95vh">
          <div class="d-flex mb-2 justify-content-center align-items-center">
            <input  class="text-color searchProducts ms-1 ps-3 search_design" placeholder="Search Product,[code, barcode, name, brand]"/>
            <span class="clear-button d-none d-flex" id="clearButton">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="38" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
              <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
            </svg>
            </span>
            <button onclick="searchProducts()" id="searchBtn" name="productSearch" class="productBTNs searchIconD">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
              </svg>
            </button>

            <button onclick="addproducts()" class="addProducts productBTNs" style="width: auto">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
              </svg> 
            </button>

           <div style="display: flex;">
            <button class="clearproductsBtn productBTNs d-none">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
              </svg>
            </button>
          </div>

            <input class="custom-input" readonly hidden name="productid" id="productid" style="width: 180px"/>
          </div>
          <div>
          <div class="row">
            <div>
              <div class="card p-0" style="height: 78vh; width: 100%; overflow: hidden">
                <!-- <div class="card-body" style="max-height: 80vh; border-radius: 0;"> -->
                  <?php include('errors.php'); ?>

                  <!-- <table class="text-color table-border p-0">
                    
                  </table> -->

                  <div id="responsive-data" style="height: 100%; overflow: hidden">
                    <table id="recentusers" class="text-color table-border">

                      <thead class="productHeader">
                        <tr>
                          <th class="text-center font-size" style="width: 5%;">No.</th>
                          <th class="text-center font-size" style="width: 20%">Name</th>
                          <th class="text-center font-size" style="width: 6%" >Barcode</th>
                          <th class="text-center font-size" style="width: 6%" >SKU</th>
                          <th class="text-center font-size" style="width: 6%" >Code</th>
                          <th class="text-center font-size" style="width: 6%"  >Unit</th>
                          <th class="text-center font-size"  style="width: 6%" >Brand</th>
                          <th class="text-center font-size"  style="width: 6%" >Price (Php)</th>
                          <th class="text-center font-size"  style="width: 6%" >Mark-up (%)</th>
                          <th class="text-center font-size" style="width: 6%"  >Cost (Php)</th>
                          <!-- <th class="text-center" style="width: 7%;">Serial No.</th> -->
                          <th class="text-center font-size"  style="width: 10%" >Category</th>
                          <th class="text-center font-size" style="width: 6%" >Status</th>
                          <th class="text-center font-size"  style="width: 6%" >Action</th>
                        </tr>
                      </thead> 

                      <tbody id="productTable">

                      </tbody> 
                     
                    </table>
                   
                    </div>

                <!-- </div> -->
              </div>
              <div id="paginationDiv" class="paginactionClass" style="position: absolute; bottom: 33px;">

              </div >
              <div class="d-flex w-100 text-center justify-content-center" style="position: absolute; bottom: 0;">
                <input type="file" id="fileImports" style="display: none;" accept=".csv, text/csv">
                <button class="btn-control ps-2 pe-2" id="printProduct" style="width:auto; height:45px; margin-right: 10px;"><svg version="1.1" id="_x32_" width="25px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="" stroke=""><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#ffff;} </style> <g> <path class="st0" d="M488.626,164.239c-7.794-7.813-18.666-12.684-30.578-12.676H409.01V77.861L331.145,0h-4.225H102.99v151.564 H53.955c-11.923-0.008-22.802,4.862-30.597,12.676c-7.806,7.798-12.665,18.671-12.657,30.574v170.937 c-0.008,11.919,4.847,22.806,12.661,30.589c7.794,7.813,18.678,12.669,30.593,12.661h49.034V512h306.02V409.001h49.037 c11.901,0.008,22.78-4.848,30.574-12.661c7.818-7.784,12.684-18.67,12.677-30.589V194.814 C501.306,182.91,496.436,172.038,488.626,164.239z M323.519,21.224l62.326,62.326h-62.326V21.224z M123.392,20.398l179.725,0.015 v83.542h85.491v47.609H123.392V20.398z M388.608,491.602H123.392v-92.801h-0.016v-96.638h265.217v106.838h0.015V491.602z M480.896,365.751c-0.004,6.353-2.546,11.996-6.694,16.17c-4.166,4.136-9.813,6.667-16.155,6.682h-49.049V281.75H102.974v106.853 H53.955c-6.365-0.015-12.007-2.546-16.166-6.682c-4.144-4.174-6.682-9.817-6.686-16.17V194.814 c0.004-6.338,2.538-11.988,6.686-16.155c4.167-4.144,9.809-6.682,16.166-6.698h49.034h306.02h49.037 c6.331,0.016,11.985,2.546,16.151,6.698c4.156,4.174,6.694,9.817,6.698,16.155V365.751z"></path> <rect x="167.59" y="336.155" class="st0" width="176.82" height="20.405"></rect> <rect x="167.59" y="388.618" class="st0" width="176.82" height="20.398"></rect> <rect x="167.59" y="435.255" class="st0" width="83.556" height="20.398"></rect> <path class="st0" d="M353.041,213.369c-9.263,0-16.767,7.508-16.767,16.774c0,9.251,7.504,16.759,16.767,16.759 c9.263,0,16.77-7.508,16.77-16.759C369.811,220.877,362.305,213.369,353.041,213.369z"></path> <path class="st0" d="M424.427,213.369c-9.262,0-16.77,7.508-16.77,16.774c0,9.251,7.508,16.759,16.77,16.759 c9.258,0,16.766-7.508,16.766-16.759C441.193,220.877,433.685,213.369,424.427,213.369z"></path> </g> </g></svg>&nbsp;Print</button>
                <button class="btn-control ps-2 pe-2" id="generateProductPDFBtn" style="width:auto; height:45px; margin-right: 10px;"><svg width="25px" height="25px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M2.5 6.5V6H2V6.5H2.5ZM6.5 6.5V6H6V6.5H6.5ZM6.5 10.5H6V11H6.5V10.5ZM13.5 3.5H14V3.29289L13.8536 3.14645L13.5 3.5ZM10.5 0.5L10.8536 0.146447L10.7071 0H10.5V0.5ZM2.5 7H3.5V6H2.5V7ZM3 11V8.5H2V11H3ZM3 8.5V6.5H2V8.5H3ZM3.5 8H2.5V9H3.5V8ZM4 7.5C4 7.77614 3.77614 8 3.5 8V9C4.32843 9 5 8.32843 5 7.5H4ZM3.5 7C3.77614 7 4 7.22386 4 7.5H5C5 6.67157 4.32843 6 3.5 6V7ZM6 6.5V10.5H7V6.5H6ZM6.5 11H7.5V10H6.5V11ZM9 9.5V7.5H8V9.5H9ZM7.5 6H6.5V7H7.5V6ZM9 7.5C9 6.67157 8.32843 6 7.5 6V7C7.77614 7 8 7.22386 8 7.5H9ZM7.5 11C8.32843 11 9 10.3284 9 9.5H8C8 9.77614 7.77614 10 7.5 10V11ZM10 6V11H11V6H10ZM10.5 7H13V6H10.5V7ZM10.5 9H12V8H10.5V9ZM2 5V1.5H1V5H2ZM13 3.5V5H14V3.5H13ZM2.5 1H10.5V0H2.5V1ZM10.1464 0.853553L13.1464 3.85355L13.8536 3.14645L10.8536 0.146447L10.1464 0.853553ZM2 1.5C2 1.22386 2.22386 1 2.5 1V0C1.67157 0 1 0.671573 1 1.5H2ZM1 12V13.5H2V12H1ZM2.5 15H12.5V14H2.5V15ZM14 13.5V12H13V13.5H14ZM12.5 15C13.3284 15 14 14.3284 14 13.5H13C13 13.7761 12.7761 14 12.5 14V15ZM1 13.5C1 14.3284 1.67157 15 2.5 15V14C2.22386 14 2 13.7761 2 13.5H1Z" fill="#ffff"></path> </g></svg>&nbsp;Save as PDF</button>
                <button class="btn-control ps-2 pe-2" id="generateProductsEXCELBtn" style="width:auto; height:45px;"><svg height="25px" width="25px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26 26" xml:space="preserve" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path style="fill:#ffff;" d="M25.162,3H16v2.984h3.031v2.031H16V10h3v2h-3v2h3v2h-3v2h3v2h-3v3h9.162 C25.623,23,26,22.609,26,22.13V3.87C26,3.391,25.623,3,25.162,3z M24,20h-4v-2h4V20z M24,16h-4v-2h4V16z M24,12h-4v-2h4V12z M24,8 h-4V6h4V8z"></path> <path style="fill:#ffff;" d="M0,2.889v20.223L15,26V0L0,2.889z M9.488,18.08l-1.745-3.299c-0.066-0.123-0.134-0.349-0.205-0.678 H7.511C7.478,14.258,7.4,14.494,7.277,14.81l-1.751,3.27H2.807l3.228-5.064L3.082,7.951h2.776l1.448,3.037 c0.113,0.24,0.214,0.525,0.304,0.854h0.028c0.057-0.198,0.163-0.492,0.318-0.883l1.61-3.009h2.542l-3.037,5.022l3.122,5.107 L9.488,18.08L9.488,18.08z"></path> </g> </g></svg>&nbsp;Save as Excel</button>
                <button class="btn-control ps-2 pe-2" id="importProducts" style="width:auto; height:45px;"><svg height="25px" width="25px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26 26" xml:space="preserve" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path style="fill:#ffff;" d="M25.162,3H16v2.984h3.031v2.031H16V10h3v2h-3v2h3v2h-3v2h3v2h-3v3h9.162 C25.623,23,26,22.609,26,22.13V3.87C26,3.391,25.623,3,25.162,3z M24,20h-4v-2h4V20z M24,16h-4v-2h4V16z M24,12h-4v-2h4V12z M24,8 h-4V6h4V8z"></path> <path style="fill:#ffff;" d="M0,2.889v20.223L15,26V0L0,2.889z M9.488,18.08l-1.745-3.299c-0.066-0.123-0.134-0.349-0.205-0.678 H7.511C7.478,14.258,7.4,14.494,7.277,14.81l-1.751,3.27H2.807l3.228-5.064L3.082,7.951h2.776l1.448,3.037 c0.113,0.24,0.214,0.525,0.304,0.854h0.028c0.057-0.198,0.163-0.492,0.318-0.883l1.61-3.009h2.542l-3.037,5.022l3.122,5.107 L9.488,18.08L9.488,18.08z"></path> </g> </g></svg>&nbsp;Import Products</button>
                <button class="btn-control ps-2 pe-2" id="exportProducts" style="width:auto; height:45px;"><svg height="25px" width="25px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26 26" xml:space="preserve" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path style="fill:#ffff;" d="M25.162,3H16v2.984h3.031v2.031H16V10h3v2h-3v2h3v2h-3v2h3v2h-3v3h9.162 C25.623,23,26,22.609,26,22.13V3.87C26,3.391,25.623,3,25.162,3z M24,20h-4v-2h4V20z M24,16h-4v-2h4V16z M24,12h-4v-2h4V12z M24,8 h-4V6h4V8z"></path> <path style="fill:#ffff;" d="M0,2.889v20.223L15,26V0L0,2.889z M9.488,18.08l-1.745-3.299c-0.066-0.123-0.134-0.349-0.205-0.678 H7.511C7.478,14.258,7.4,14.494,7.277,14.81l-1.751,3.27H2.807l3.228-5.064L3.082,7.951h2.776l1.448,3.037 c0.113,0.24,0.214,0.525,0.304,0.854h0.028c0.057-0.198,0.163-0.492,0.318-0.883l1.61-3.009h2.542l-3.037,5.022l3.122,5.107 L9.488,18.08L9.488,18.08z"></path> </g> </g></svg>&nbsp;Save as CSV</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->



  <div class="modal" id="deleteProdModal" tabindex="0" style="background-color: rgba(0, 0, 0, 0.5)">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 35vw">
    <div class="modal-content">
      <div class="modal-body" style="background: #262626; color: #ffff; border-radius: 0;">

        <div style="position: relative; width: 100%;" class="d-flex">
            <div  style="margin-right: 10px; color:#ffff;">
              <h4><span>
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                    <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
                    <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                  </svg>
              </span>Delete <span class="ProdName"></span></h4>
            </div>
        </div>

        <div class="show_product_info">
          
        </div>

        <div class="d-flex justify-content-between" style="margin-top: 10px">
          <button class="btn btn-secondary deleteBtn deleteCancel" style="border: 1px solid #4B413E; box-shadow: none;"><span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-x-lg" viewBox="0 0 16 16">
              <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
            </svg>
            </span>CANCEL</button>
          <button class="btn btn-secondary deleteBtn deleteProductItem" tabindex="0" style="border: 1px solid #4B413E; box-shadow: none;"><span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-trash3" viewBox="0 0 16 16">
              <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
            </svg>
          </span>DELETE</button>

          <button class="btn btn-secondary deleteBtn inactiveBtn d-none" tabindex="0" style="border: 1px solid #4B413E; box-shadow: none;"><span>
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#fff" class="bi bi-check2" viewBox="0 0 16 16">
            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0"/>
          </svg>
          </span>YES</button>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("layout/footer.php") ?>
<script>

$(document).ready(function() {

  var editClicked = false;

  $('#recentusers').click(function() {
    if (!$(event.target).closest('.editProductBtn').length) { // Excluded the button
      editClicked = false;
      if ($('#add_products_modal').is(':visible') && !editClicked) {
        $('.cancelAddProducts').click();
      }
    }
  
  });

  $('.editProductBtn').on('click', function() {
      openModal($(this).closest('tr'));
  });


  $('.searchProducts').on('input', function() {
    if($(this).val() != '') {
      $('#clearButton').removeClass('d-none');
    } else {
      $('#clearButton').addClass('d-none');
    }
  })

  $('#clearButton').click(function() {
    $(this).addClass('d-none');
    $('.clearproductsBtn').click();
    $('.searchProducts').focus();
  })

});


document.getElementById("importProducts").addEventListener("click", function() {
   
    document.getElementById("fileImports").click();
});
document.getElementById("fileImports").addEventListener("change", function(e) {
  $('#modalCashPrint').show()
    const file = this.files[0];
    const formData = new FormData();
    formData.append('file', file);
    axios.post('api.php?action=importProduct',formData)
    .then(function(response) {
        refreshProductsTable();
        show_allProducts()
    })
    .catch(function(error) {
        console.error(error);
    });
});

   $("#products").addClass('active');
    $("#pointer").html("Products");
  function addproducts(){
    getSku();
     $('#add_products_modal').show()
     var p_id = document.getElementById('productid').value;
     $('.modalHeaderTxt').text(!p_id ? "Add New Product" : $('.modalHeaderTxt').text());
     var checkbox = document.getElementById('showIncludesTaxVatToggle');
     var taxCheckbox = document.getElementById('taxVatToggle');
      checkbox.checked = true
      taxCheckbox.checked = true
      if(checkbox.checked){
        toggleChangeColor(checkbox);
      }else{
        toggleChangeColor(checkbox);
      }

      var multiple = document.getElementById('multipleToggle');
      var multiLbl = document.getElementById('multiLbl');
      multiple.checked = false
      if(multiple.checked){
        ultiLbl.style.color = "#FF6900";
        toggleMultiple(multiple)
      }else{
        toggleMultiple(multiple)
        multiLbl.style.color = "";
      }

    
      var service = document.getElementById('serviceChargesToggle');
      service.checked = false
      var taxLabel = document.getElementById('taxtVatLbl');
      if(!service.checked){
        taxLabel.style.color = ''
      }else{
        taxLabel.style.color = '#FF6900'
      }
      var other =  document.getElementById('otherChargesToggle');
      other.checked =false
      var serviceLabel = document.getElementById('serviceChargeLbl');
      if(!other.checked){
        serviceLabel.style.color = ''
      }else{
        serviceLabel.style.color = '#FF6900'
      }
      var displayServices = document.getElementById('displayServiceChargeReceipt');
      var serviceLabel = document.getElementById('serviceChargeLbl');
        displayServices.checked = false;
      if(!displayServices.checked){
        toggleDisplayServiceCharge(displayServices)
      }

      var displayOtherCharge = document.getElementById('displayReceipt');
      displayOtherCharge.checked =false
      if(!displayOtherCharge.checked){
        toggleOtherCharges(displayOtherCharge)
      }

      var bom = document.getElementById('bomToggle');
      bom.checked = false
      if(!bom.checked){
        updateTextColor()
      }else{
        updateTextColor()
      }
      var discountedCheckbox = document.getElementById('discountToggle');
      discountedCheckbox.checked = false;
      var warrantyToggle = document.getElementById('warrantyToggle');
      warrantyToggle.checked = false;
      var warningNum = document.getElementById('quantity');
      warningNum.setAttribute('hidden',true)
      if(warrantyToggle.checked){
        toggleShowText(warrantyToggle)
      }else{
        toggleShowText(warrantyToggle)
      }
      var stockWarning= document.getElementById('stockToggle');
      stockWarning.checked = false
     if( $('#add_products_modal').is(':visible')){
      var toggle = document.getElementById('statusValue');
      toggle.checked = true;
      var statusLabel = document.getElementById('statusActive');
          if(toggle.checked){
            toggleStatus(toggle)
            statusLabel.style.color = '#00CC00'; 
          }else{
            toggleStatus(toggle)
            statusLabel.style.color = ''; 
          }
           
     }
  }
  function getSku() {
    $.ajax({
        url: 'api.php?action=getlatestSkuData', 
        type: 'GET',
        success: function(response) {
            var latestSku = response.nextSKU; 
            document.getElementById('skunNumber').value = latestSku;
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}


showPaginationBtn('products')


function searchProducts(){
 
  var searchData = $('.searchProducts').val();
    $.ajax({
        url: './fetch-data/fetch-products.php', 
        type: 'GET',
        data: {
            searchQuery: searchData 
        },
        success: function(response) {
          $('#productTable').html(response); 
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText); 
        }
    });
}

  $(document).ready(function() {
  
    $('#generateProductPDFBtn').click(function() {
    $('#modalCashPrint').show()
    var searchData = $('.searchProducts').val();
    $.ajax({
        url: './reports/generate_products_pdf.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
        data: {
            searchQuery: searchData
        },
        success: function(response) {
            var blob = new Blob([response], { type: 'application/pdf' });
            var url = window.URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'product_list.pdf';
            document.body.appendChild(a);
            a.click();

            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
            var userInfo = JSON.parse(localStorage.getItem('userInfo'));
            var firstName = userInfo.firstName;
            var lastName = userInfo.lastName;
            var cid = userInfo.userId;
            var role_id = userInfo.roleId; 
            insertLogs('Products',firstName + ' ' + lastName + ' '+ 'Generate a pdf')
            $('#modalCashPrint').hide()
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            console.log(searchData)
        }
    });
});
$('#printProduct').click(function() {
    var searchData = $('.searchProducts').val();
 
    $('#modalCashPrint').show()
    $.ajax({
        url: './reports/generate_products_pdf.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
        data: {
            searchQuery: searchData 
        },
        success: function(response) {
          var blob = new Blob([response], { type: 'application/pdf' });
            var url = window.URL.createObjectURL(blob);
            var win = window.open(url);
            win.onload = function() {
                win.print();
                win.onafterprint = function() {
                    window.focus(); 
                    win.close();
                }
            }

            window.URL.revokeObjectURL(url);
            var userInfo = JSON.parse(localStorage.getItem('userInfo'));
            var firstName = userInfo.firstName;
            var lastName = userInfo.lastName;
            var cid = userInfo.userId;
            var role_id = userInfo.roleId; 
            insertLogs('Products',firstName + ' ' + lastName + ' '+ 'Printing a pdf')
            $('#modalCashPrint').hide()
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            console.log(searchData)
        }
    });
  });
  $('#generateProductsEXCELBtn').click(function() {
    $('#modalCashPrint').show()
    var searchData = $('.searchProducts').val();
    console.log(searchData)
    $.ajax({
        url: './reports/generateProductsExcel.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
        data: {
            searchQuery: searchData 
        },
       success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'productList.xlsx'; 
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
            var userInfo = JSON.parse(localStorage.getItem('userInfo'));
            var firstName = userInfo.firstName;
            var lastName = userInfo.lastName;
            var cid = userInfo.userId;
            var role_id = userInfo.roleId; 
            insertLogs('Products',firstName + ' ' + lastName + ' '+ 'Exported'+' ' + 'productList.xlsx')
            $('#modalCashPrint').hide()
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
var timeout = null;

$('.searchProducts').on('input', function() {
    var searchData = $(this).val();
      
            $.ajax({
                url: './fetch-data/fetch-products.php',
                type: 'GET',
                data: {
                    searchQuery: searchData
                },
                success: function(response) {
                    $('#productTable').html(response);
                   
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

   
});

$('#exportProducts').click(function() {
    $('#modalCashPrint').show();
    var searchData = $('.searchProducts').val();
    console.log(searchData);
    $.ajax({
        url: './reports/export-products-csv.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
        data: {
            searchQuery: searchData 
        },
        success: function(response) {
            var a = document.createElement('a');
            var url = window.URL.createObjectURL(response);
            a.href = url;
            a.download = 'productList.csv';
            document.body.append(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);
            var userInfo = JSON.parse(localStorage.getItem('userInfo'));
            var firstName = userInfo.firstName;
            var lastName = userInfo.lastName;
            var cid = userInfo.userId;
            var role_id = userInfo.roleId; 
            insertLogs('Products',firstName + ' ' + lastName + ' '+ 'Exported'+' ' + 'productList.csv')
            $('#modalCashPrint').hide();
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});


  $('.searchProducts').keydown(function(e) {
        switch(e.which){
         case 13:
         $('button[name="productSearch"]').click();
         break;
        default: return; 
        }
      e.preventDefault(); 
    });

 $('.clearproductsBtn').on('click', function(){
  $('.searchProducts').val("")
  refreshProductsTable()
  $('#categoriesDiv').hide();
 })
  });

  $(document.body).off('click').on('click', '.editProductBtn', function() {
        var productId = $(this).closest('tr').find('.productsId').text();
        var productName =  $(this).closest('tr').find('.productsName').text();
        var productSKU = $(this).closest('tr').find('.sku').text();
        var productCode = $(this).closest('tr').find('.code').text();
        var productBarcode = $(this).closest('tr').find('.barcode').text();
        var productOUM = $(this).closest('tr').find('.uom_name').text();
        var productBrand =  $(this).closest('tr').find('.brand').text();
        var productCost =  $(this).closest('tr').find('.cost').text();
        var productMakup = $(this).closest('tr').find('.markup').text();
        var productPrice = $(this).closest('tr').find('.prod_price').text();
        var productStatus = $(this).closest('tr').find('.status').text();
        var productuomid = $(this).closest('tr').find('.oumId').text();
        var isDiscounted = $(this).closest('tr').find('.isDiscounted').text();
        var isTax = $(this).closest('tr').find('.isTax').text();
        var isTaxIncluded = $(this).closest('tr').find('.isTaxIncluded').text();
        var serviceCharge = $(this).closest('tr').find('.service').text();
        var displayService = $(this).closest('tr').find('.displayService').text();
        var otherCharges = $(this).closest('tr').find('.other').text();
        var displayOtherCharges = $(this).closest('tr').find('.displayOthers').text();
        var status = $(this).closest('tr').find('.statusData').text();
        var image = $(this).closest('tr').find('.productImgs').text();
        var desc = $(this).closest('tr').find('.description').text();
        var isBOM = $(this).closest('tr').find('.isBOM').text();
        var isWarranty = $(this).closest('tr').find('.isWarranty').text();
        var is_stockable = $(this).closest('tr').find('.is_stockable').text();
        var stock_status = $(this).closest('tr').find('.stock_status').text();
        var stock_count = $(this).closest('tr').find('.stock_count').text();
       
        $('.highlighteds').removeClass('highlighteds');
        $('.highlightedss').removeClass('highlightedss')
      
        var $row = $(this).closest('tr').addClass('highlighteds');
        if(isTax == 0){
           var showTaxCheckbox = document.getElementById('showIncludesTaxVatToggle');
           showTaxCheckbox.disabled = true;
        }
        var category = $(this).closest('tr').find('.categoryDetails').text();
        var categoryid = $(this).closest('tr').find('.categoryid').text();
        var variantid = $(this).closest('tr').find('.variantid').text();

        toUpdateProducts(productId,productName,productSKU,productCode,productBarcode,productOUM, productuomid,productBrand,productCost, productMakup, productPrice, productStatus, 
        isDiscounted,isTax,isTaxIncluded,serviceCharge,displayService,otherCharges,displayOtherCharges, status,image ,desc, category,categoryid,variantid,isBOM, isWarranty,is_stockable,
        stock_status,stock_count)
    });

    $(document.body).off('click').on('click', '.deleteProducts', function() {
      var productId = $(this).closest('tr').find('.productsId').text();
      var productName =  $(this).closest('tr').find('.productsName').text();
      var productBarcode = $(this).closest('tr').find('.barcode').text();
      $('#deleteProdModal').show();
      $('.ProdName').text(productName);
        axios.post('api.php?action=getValidate', {
          'productId' : parseInt(productId),
        })
        .then(function(response) {
          var matchProduct = response.data.data;

          if(matchProduct != false) {
            $('.deleteProductItem').addClass('d-none');
            $('.inactiveBtn').removeClass('d-none');
            var warningDelete = `
             <div class="d-flex justify-content-center text-center align-items-center w-100">
              <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" fill="red" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4m.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
              </svg>
            </div>
            <div class="d-flex align-items-center justify-content text-center mt-2">
              <h4 class="w-100">Unable to delete. Would you like to change the status to <span style="color: var(--primary-color)" >"INACTIVE"</span> ?</h4>
            </div>`;
           
            $('.show_product_info').html(warningDelete)
            $('.inactiveBtn').off('click').on('click', function() {
              axios.post('api.php?action=updateProductStat', {
                'productId' : parseInt(productId),
              })
              .then(function(response) {
                insertLogs('Products',firstName + ' ' + lastName + ' '+ 'Updated the status to "INACTIVE" :' + ' ' +  productName +' '+ 'Barcode #:'+ productBarcode)
                $('#deleteProdModal').hide();
              })
              .catch(function(error) {
                console.log(error);
              })

            })

          } else {
            var warningDelete = `

            <div class="d-flex justify-content-center text-center align-items-center w-100">
              <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" fill="red" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4m.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
              </svg>
            </div>

            <div class="d-flex align-items-center justify-content text-center mt-3">
              <h4 class="w-100">Are you sure you want to delete this product?</h4>
            </div>`;
            
            $('.show_product_info').html(warningDelete)

            $('.deleteProductItem').off('click').on('click', function() {
              axios.delete(`api.php?action=deleteProduct&prod_id=${productId}`)
              .then(function(response){
                if (response.data.success) {
                  $('#deleteProdModal').hide();
                    refreshProductsTable()
                    var userInfo = JSON.parse(localStorage.getItem('userInfo'));
                    var firstName = userInfo.firstName;
                    var lastName = userInfo.lastName;
                    var cid = userInfo.userId;
                    var role_id = userInfo.roleId; 

                    insertLogs('Products',firstName + ' ' + lastName + ' '+ 'Deleted' + ' ' +  productName +' '+ 'Barcode #:'+ productBarcode)
                    Swal.fire({
                      icon: 'success',
                      title: 'Success!',
                      text: 'Product Deleted Succesfully!',
                      timer: 1000, 
                      timerProgressBar: true, 
                      showConfirmButton: false 
                    });

                    } else {
                      $('#deleteProdModal').hide();
                    var userInfo = JSON.parse(localStorage.getItem('userInfo'));
                    var firstName = userInfo.firstName;
                    var lastName = userInfo.lastName;
                    var cid = userInfo.userId;
                    var role_id = userInfo.roleId; 
                    insertLogs('Products',firstName + ' ' + lastName + ' '+ 'Tries to delete' + ' ' +  productName +' '+ 'Barcode #:'+ productBarcode)
                    Swal.fire({
                      icon: 'error',
                      title: 'Error!',
                      text: 'Unable to delete products!',
                      timer: 1000, 
                      timerProgressBar: true, 
                      showConfirmButton: false 
                    });
                  }
              }).catch(function(error){
                Swal.fire({
                  icon: 'error',
                  title: 'Error!',
                  text: 'Unable to delete products!',
                  timer: 1000, 
                  timerProgressBar: true, 
                  showConfirmButton: false 
                });
              })
            }) 
          }
         
        })
        .catch(function(error) {
          console.log(error);
        });
        
        $('.deleteCancel').off('click').on('click', function() {
          $('#deleteProdModal').hide();
        })

        $(document).off('keydown').on('keydown', function(e) {
          if(e.which == 27) {
            $('.deleteCancel').click();
          }
        })
    });
    
    var currentRow = null;
    function openModal(row){
    currentRow = row;
    var productId = row.querySelector('.productsId').innerText;
    var productName =  row.querySelector('.productsName').innerText
    var productSKU = row.querySelector('.sku').innerText
    var productCode = row.querySelector('.code').innerText
    var productBarcode = row.querySelector('.barcode').innerText;
    var productOUM = row.querySelector('.uom_name').innerText;
    var productBrand = row.querySelector('.brand').innerText;
    var productCost = row.querySelector('.cost').innerText;
    var productMakup = row.querySelector('.markup').innerText;
    var productPrice = row.querySelector('.prod_price').innerText;
    var productStatus = row.querySelector('.status').innerText;
    var productuomid  = row.querySelector('.oumId').innerText;
    var isDiscounted = row.querySelector('.isDiscounted').innerText;
    var isTax = row.querySelector('.isTax').innerText;
    var isTaxIncluded = row.querySelector('.isTaxIncluded').innerText;
    var serviceCharge = row.querySelector('.service').innerText;
    var displayService = row.querySelector('.displayService').innerText;
    var otherCharges = row.querySelector('.other').innerText;
    var displayOtherCharges = row.querySelector('.displayOthers').innerText;
    var status = row.querySelector('.statusData').innerText;
    var image = row.querySelector('.productImgs').innerText;
    var desc = row.querySelector('.description').innerText;
    var isBOM = row.querySelector('.isBOM').innerText;
    var isWarranty = row.querySelector('.isWarranty').innerText;
    var category = row.querySelector('.categoryDetails').innerText;
    var categoryid  = row.querySelector('.categoryid').innerText;
    var variantid = row.querySelector('.variantid').innerText;
    var is_stockable = row.querySelector('.is_stockable').innerText;
    var stock_status = row.querySelector('.stock_status').innerText;
    var stock_count = row.querySelector('.stock_count').innerText;
  
    $('.highlighteds').removeClass('highlightedss');
    $('.highlightedss').removeClass('highlightedss');

    $(row).addClass('highlightedss');

    toUpdateProducts(productId,productName,productSKU,productCode,productBarcode,productOUM, productuomid,productBrand,productCost, productMakup, productPrice, productStatus, 
        isDiscounted,isTax,isTaxIncluded,serviceCharge,displayService,otherCharges,displayOtherCharges, status,image ,desc, category,categoryid,variantid,isBOM, isWarranty,is_stockable,
        stock_status,stock_count)
    }

</script>