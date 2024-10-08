<?php

  include( __DIR__ . '/layout/header.php');
  include( __DIR__ . '/utils/db/connector.php');
  include( __DIR__ . '/utils/models/product-facade.php');
  include( __DIR__ . '/utils/models/ingredients-facade.php');
  include(__DIR__ . '/utils/models/ability-facade.php');
  include(__DIR__ . '/utils/models/supplier-facade.php');
  
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

  include('./modals/add-expenses-modal.php');
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
  border-radius: 10px;
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



.card {
  background-color: #1e1e1e;
  border-color: #242424;
  height: 200px;
  /* overflow-x: auto; 
  overflow-y: hidden; */
  border-radius: 8px;
  padding: 16px;
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
  color: var(--primary-color);
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
#responsive-data{
  max-height: 700px;
  width: 100%;
  position: absolute; 
  left: 2px;
  right:2px;
  top:2px;
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
  color: var(--primary-color);
}
  .dt-paging{
    margin-top: 20px;
    margin-bottom: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
  }

.dt-paging-button:hover{
  color: var(--primary-color);
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
.daterangepicker {
    background-color: #f0f0f0; 
    border: 1px solid #ccc;
    border-radius: 5px;
}


#tbl_expenses tbody td {
    line-height: 1.1; 
    border: 1px solid #292928;
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 4px;
    padding-bottom: 4px;
}
#tbl_expenses tbody tr:hover{
  background-color: #242424;
}

.input-wrapper {
    position: relative;
    display: inline-block;
    margin-right: 20px;
    
}
.input-wrapper input {
    border-radius: 5px;
    width: 100%;
    height: 35px;
    padding-right: 40px; 
    text-align: center;
}
.input-wrapper .calendar-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #ffffff;
}
#tbl_previewRecord tbody th,
#tbl_previewRecord tbody td {
  padding: 2px 2px; 
  height: 10px; 
  line-height: 0.5; 
  border: 1px solid #292928;
  color: #ccc;
  font-size: 14px;
}
#tbl_preview{
  width: 100%;
}
#tbl_preview tbody th,
#tbl_preview tbody td {
    padding: 8px 8px; 
    height: 35px; 
    line-height: 1.5;
    font-weight: normal;
    font-size: 12px;
}


  #searchInput {
    height: 35px; 
    /* margin-right: 10px;  */
    font-style: italic;
    border-radius: 20px 0 0 20px
  }

  .createExpense {
    border-radius: 0 20px 20px 0;
  }


  .expensesBtn {
    background: #7c7c7c;
    border: 1px solid transparent;
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
        max-height: 66vh; 
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



  /* start for search bar css*/

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

#searchInput::placeholder {
    color: rgba(255, 255, 255, 0.8);
}

.expensesBtn{
  background-color: #555;  
  margin-left: -5px;
}

#clear_all_search{
  background-color: #555;  
  height: 35px; 
  margin-left: -5px;
  cursor: pointer;
}

.expensesBtn.clearproductsBtn svg {
  transition: fill 0.3s ease, transform 0.3s ease; 
 

}

.expensesBtn.clearproductsBtn:hover svg {
  fill: var(--primary-color); 
  transform: scale(1.1);
}

.text-color.searchProducts {
    background-color: #555;
}

/*   end for search bar css */


@media screen and (max-width: 1400px) {
     
     .d-flex{
       zoom: 90%;
     }
     
      .modal{
       zoom: 80%;
   
    
      }
   .modal-content{
    height:1000px !important;
   }
    
     
    

      #tbl_expenses th:nth-child(1),
    #tbl_expenses th:nth-child(2),
    #tbl_expenses th:nth-child(3),
    #tbl_expenses th:nth-child(4),
    #tbl_expenses th:nth-child(5),
    #tbl_expenses th:nth-child(6),
    #tbl_expenses th:nth-child(7),
    #tbl_expenses th:nth-child(8),
    #tbl_expenses th:nth-child(9),
    #tbl_expenses th:nth-child(10),
    #tbl_expenses th:nth-child(11),
    #tbl_expenses th:nth-child(12),
    #tbl_expenses th:nth-child(13) {
        padding-top: 0;
        text-align: center !important;
    }
   
    #tbl_expenses th:nth-child(12) {
        width: 130px !important;
    }
    
    #tbl_expenses td {
        font-size: 12px;
        padding: 2 !important;
    }

    #tbl_expenses th {
        font-size: 12px;
        padding: 0 !important;
    }
    
    
      #tbl_expenses{
        width: 1800px !important;
      }

      .table-wrapper {
        overflow-x: auto ;
  overflow-y: hidden;
    -webkit-overflow-scrolling: touch; 
    scrollbar-color: #333 ; 
}


.table-wrapper::-webkit-scrollbar {
    height: 5px !important; 
}
/* Track */
.table-wrapper::-webkit-scrollbar-track {
  background: #333; 

}
 
/* Handle */
.table-wrapper::-webkit-scrollbar-thumb {
  background: #888; 
  border-radius: 10px;
}





#paginationDiv{
  zoom: 80%;
  margin-top: 10px;
   z-index: 1000;
}
.printer{
  zoom: 70%;
}

#preview_records{
zoom: 110%;
margin-top: -20px;
font-weight: bold;
}

.btn-control{
  margin-top: 2vh;
 
}
       }
    

</style>

<?php include "layout/admin/css.php"?> 
  <div class="container-scroller" style = "background-color: #262626">
    <?php include 'layout/admin/sidebar.php' ?>
      <!-- partial -->
      <div class="main-panel" style = "overflow: hidden">
        <div class="content-wrapper" >
          <div class="d-flex mb-3 justify-content-between" >
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="#fff" class="bi bi-upc-scan" viewBox="0 0 16 16" style = "margin-right: 10px; margin-left: 10px;">
              <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5M3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0z"/>
            </svg>

            <input  class="text-color searchProducts w-100 ps-3" id = "searchInput" placeholder="Search Expenses,[ Item name, Billable, Type, UOM, Supplier, Invoice Number ]" autocomplete = "off" autofocus = "autofocus"/>
            <span class="expensesBtn clearproductsBtn" id = "clear_all_search" >
              <svg xmlns="http://www.w3.org/2000/svg" width="25" height="35" fill="#fff" class="bi bi-x" viewBox="0 0 16 16">
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
              </svg>
            </span>

            <input type="hidden" id = "start_date_value">
            <input type="hidden" id = "end_date_value">
            
            <button  id="searchBtn" name="productSearch" class="expensesBtn" style="width:auto">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
              </svg>
            </button>
            <button id = "btn_createExpense"  class="expensesBtn createExpense pe-3" style="width:auto">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
              </svg> 
            </button>
            <div class="input-wrapper ms-2 w-auto">
                <input class="text-color searchProducts" id="date_range" placeholder="Select Period" autocomplete="off" readonly style="cursor: pointer;">
                <span class="calendar-icon" style="cursor: pointer;">
                  <i class="bi bi-calendar3" style="color: #ffffff"></i>
                </span>
            </div>

            <input class="custom-input" readonly hidden name="productid" id="productid" style="width: 180px"/>
          </div>
          <div>
          <div class="row">
            <div>
              <div class="card"  style="height: 72vh; width: 100%; margin-top: -10px;">
                <div class="card-body" >
                  <div id="responsive-data" style = "height: 70vh">
                  
                  </div>

                </div>
              </div>
              <div id="paginationDiv"></div>

              <div class="printer" style="display: flex; margin-top: -10px; justify-content: space-between;">
                <div>
                  <button class="btn-control" id="printThis" style="width:160px; height:45px; margin-right: 10px"><svg version="1.1" id="_x32_" width="25px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="" stroke=""><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#ffff;} </style> <g> <path class="st0" d="M488.626,164.239c-7.794-7.813-18.666-12.684-30.578-12.676H409.01V77.861L331.145,0h-4.225H102.99v151.564 H53.955c-11.923-0.008-22.802,4.862-30.597,12.676c-7.806,7.798-12.665,18.671-12.657,30.574v170.937 c-0.008,11.919,4.847,22.806,12.661,30.589c7.794,7.813,18.678,12.669,30.593,12.661h49.034V512h306.02V409.001h49.037 c11.901,0.008,22.78-4.848,30.574-12.661c7.818-7.784,12.684-18.67,12.677-30.589V194.814 C501.306,182.91,496.436,172.038,488.626,164.239z M323.519,21.224l62.326,62.326h-62.326V21.224z M123.392,20.398l179.725,0.015 v83.542h85.491v47.609H123.392V20.398z M388.608,491.602H123.392v-92.801h-0.016v-96.638h265.217v106.838h0.015V491.602z M480.896,365.751c-0.004,6.353-2.546,11.996-6.694,16.17c-4.166,4.136-9.813,6.667-16.155,6.682h-49.049V281.75H102.974v106.853 H53.955c-6.365-0.015-12.007-2.546-16.166-6.682c-4.144-4.174-6.682-9.817-6.686-16.17V194.814 c0.004-6.338,2.538-11.988,6.686-16.155c4.167-4.144,9.809-6.682,16.166-6.698h49.034h306.02h49.037 c6.331,0.016,11.985,2.546,16.151,6.698c4.156,4.174,6.694,9.817,6.698,16.155V365.751z"></path> <rect x="167.59" y="336.155" class="st0" width="176.82" height="20.405"></rect> <rect x="167.59" y="388.618" class="st0" width="176.82" height="20.398"></rect> <rect x="167.59" y="435.255" class="st0" width="83.556" height="20.398"></rect> <path class="st0" d="M353.041,213.369c-9.263,0-16.767,7.508-16.767,16.774c0,9.251,7.504,16.759,16.767,16.759 c9.263,0,16.77-7.508,16.77-16.759C369.811,220.877,362.305,213.369,353.041,213.369z"></path> <path class="st0" d="M424.427,213.369c-9.262,0-16.77,7.508-16.77,16.774c0,9.251,7.508,16.759,16.77,16.759 c9.258,0,16.766-7.508,16.766-16.759C441.193,220.877,433.685,213.369,424.427,213.369z"></path> </g> </g></svg>&nbsp;Print</button>
                  <button class="btn-control" id="generatePDFBtn" style="width:160px; height:45px; margin-right: 10px"><svg width="25px" height="25px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M2.5 6.5V6H2V6.5H2.5ZM6.5 6.5V6H6V6.5H6.5ZM6.5 10.5H6V11H6.5V10.5ZM13.5 3.5H14V3.29289L13.8536 3.14645L13.5 3.5ZM10.5 0.5L10.8536 0.146447L10.7071 0H10.5V0.5ZM2.5 7H3.5V6H2.5V7ZM3 11V8.5H2V11H3ZM3 8.5V6.5H2V8.5H3ZM3.5 8H2.5V9H3.5V8ZM4 7.5C4 7.77614 3.77614 8 3.5 8V9C4.32843 9 5 8.32843 5 7.5H4ZM3.5 7C3.77614 7 4 7.22386 4 7.5H5C5 6.67157 4.32843 6 3.5 6V7ZM6 6.5V10.5H7V6.5H6ZM6.5 11H7.5V10H6.5V11ZM9 9.5V7.5H8V9.5H9ZM7.5 6H6.5V7H7.5V6ZM9 7.5C9 6.67157 8.32843 6 7.5 6V7C7.77614 7 8 7.22386 8 7.5H9ZM7.5 11C8.32843 11 9 10.3284 9 9.5H8C8 9.77614 7.77614 10 7.5 10V11ZM10 6V11H11V6H10ZM10.5 7H13V6H10.5V7ZM10.5 9H12V8H10.5V9ZM2 5V1.5H1V5H2ZM13 3.5V5H14V3.5H13ZM2.5 1H10.5V0H2.5V1ZM10.1464 0.853553L13.1464 3.85355L13.8536 3.14645L10.8536 0.146447L10.1464 0.853553ZM2 1.5C2 1.22386 2.22386 1 2.5 1V0C1.67157 0 1 0.671573 1 1.5H2ZM1 12V13.5H2V12H1ZM2.5 15H12.5V14H2.5V15ZM14 13.5V12H13V13.5H14ZM12.5 15C13.3284 15 14 14.3284 14 13.5H13C13 13.7761 12.7761 14 12.5 14V15ZM1 13.5C1 14.3284 1.67157 15 2.5 15V14C2.22386 14 2 13.7761 2 13.5H1Z" fill="#ffff"></path> </g></svg>&nbsp;Save as PDF</button>
                  <button class="btn-control" id="generateEXCELBtn" style="width:160px; height:45px;"><svg height="25px" width="25px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26 26" xml:space="preserve" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path style="fill:#ffff;" d="M25.162,3H16v2.984h3.031v2.031H16V10h3v2h-3v2h3v2h-3v2h3v2h-3v3h9.162 C25.623,23,26,22.609,26,22.13V3.87C26,3.391,25.623,3,25.162,3z M24,20h-4v-2h4V20z M24,16h-4v-2h4V16z M24,12h-4v-2h4V12z M24,8 h-4V6h4V8z"></path> <path style="fill:#ffff;" d="M0,2.889v20.223L15,26V0L0,2.889z M9.488,18.08l-1.745-3.299c-0.066-0.123-0.134-0.349-0.205-0.678 H7.511C7.478,14.258,7.4,14.494,7.277,14.81l-1.751,3.27H2.807l3.228-5.064L3.082,7.951h2.776l1.448,3.037 c0.113,0.24,0.214,0.525,0.304,0.854h0.028c0.057-0.198,0.163-0.492,0.318-0.883l1.61-3.009h2.542l-3.037,5.022l3.122,5.107 L9.488,18.08L9.488,18.08z"></path> </g> </g></svg>&nbsp;Save as Excel</button>
                </div>
                <div >
                  <style>
                    .title_div{
                      color: var(--primary-color);
                    }
                    .tbl_value{
                      color: #ffffff;
                    }
                  </style>
                  <div id = "preview_records"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php 
  include("layout/footer.php");
  include("./modals/delete_expense_confirmation.php");
  include ("./modals/period-reports-modal.php");
?>

<script src="assets/adminjs/expenses.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function() {
  var searchInput = document.getElementById('searchInput');
  var clearBtn = document.getElementById('clear_all_search');


  function toggleClearButton() {
    if (searchInput.value.length > 0) {
      clearBtn.style.display = 'block';
    } else {
      clearBtn.style.display = 'none';
    }
  }

  toggleClearButton();

 
  searchInput.addEventListener('input', toggleClearButton);

  clearBtn.addEventListener('click', function() {
    searchInput.value = '';
    toggleClearButton();
    searchInput.focus();
  });
});




  // for moving up and down using keyboard
  $(document).ready(function() {
  // Handle row click to highlight
  $(document).on("click", "#tbl_expenses tbody tr", function(e) {
    e.preventDefault();
    $(this).siblings().removeClass('highlighteds');
    $(this).addClass('highlighteds');
  });

  // Handle keyboard navigation
  $(document).on("keydown", function(e) {
    var $highlighted = $("#tbl_expenses tbody tr.highlighteds");
    if ($highlighted.length) {
      var $next, $prev;
      if (e.key === "ArrowDown") {
        // Move to the next row
        $next = $highlighted.next('tr');
        if ($next.length) {
          $highlighted.removeClass('highlighteds');
          $next.addClass('highlighteds');
        }
        e.preventDefault();
      } else if (e.key === "ArrowUp") {
        // Move to the previous row
        $prev = $highlighted.prev('tr');
        if ($prev.length) {
          $highlighted.removeClass('highlighteds');
          $prev.addClass('highlighteds');
        }
        e.preventDefault();
      }else if (e.key === "Enter") {
      
      var $editButton = $highlighted.find('#add_expense_modal');
      if ($editButton.length) {
        $editButton.click();
      }
      e.preventDefault();
    }
    }
  });
});



</script>