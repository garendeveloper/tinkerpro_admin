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

  include('./modals/add-expenses-modal.php');
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
    border-color: #FF6900; 
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
  background-color: #FF6900;
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
  overflow-x: auto; 
  overflow-y: hidden;
  border-radius: 8px;
  padding: 16px;
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
  overflow: scroll !important;
  max-height: 700px;
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
.highlighted-row {
    border: 3px solid green;
}
h1, label, textarea, input, table,h5{
  font-family: Century Gothic;
}
.daterangepicker {
    background-color: #f0f0f0; 
    border: 1px solid #ccc;
    border-radius: 5px;
}

.daterangepicker .calendar-table {
    background-color: #fff; 
}

.daterangepicker .calendar-table thead {
    background-color: green; 
    color: #fff;
}

.daterangepicker .calendar-table th,
.daterangepicker .calendar-table td {
    border-color: #ccc; 
}
#tbl_expenses tbody td {
    padding: 8px 8px; 
    height: 20px; 
    line-height: 0.5; 
    border: 1px solid #292928;
}
</style>

<?php include "layout/admin/css.php"?> 
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include 'layout/admin/sidebar.php' ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div style="display: flex; margin-bottom: 20px;">
           <input  class="text-color searchProducts" id = "searchInput" style="width: 60%; height: 45px; margin-right: 10px" placeholder="Search Expenses,[ Item name, Billable, Type, UOM, Supplier, Invoice Number ]" autocomplete = "off" autofocus = "autofocus"/>
            <input type="hidden" id = "start_date_value">
            <input type="hidden" id = "end_date_value">
           <input  class="text-color searchProducts" style="width: 15%; height: 45px; margin-right: 10px; text-align: center;" id = "date_range" placeholder="From Date" autocomplete = "off" />
           <button  id="searchBtn" name="productSearch" class="btn-control" style="margin-right:10px; width:120px"><svg width="30px"version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
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
            <button id = "btn_createExpense"  class="btn-control createExpense" style="margin-right:10px;width:150px "><svg width="25px" height="25px" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><defs><style>
              .cls-1 {
                fill: #699f4c;
                fill-rule: evenodd;
              }
            </style></defs><path class="cls-1" d="M1080,270a30,30,0,1,1,30-30A30,30,0,0,1,1080,270Zm14-34h-10V226a4,4,0,0,0-8,0v10h-10a4,4,0,0,0,0,8h10v10a4,4,0,0,0,8,0V244h10A4,4,0,0,0,1094,236Z"  transform="translate(-1050 -210)"/></svg>&nbsp;Add Expense</button>
            <button class="btn-control clearproductsBtn" style="width:120px;order: 1"  id = "clear_all_search"><svg height="25px" width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.001 512.001" xml:space="preserve" fill="#f20707" stroke="#f20707"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#f20707;" d="M256.001,512c141.384,0,255.999-114.615,255.999-256.001C512.001,114.615,397.386,0,256.001,0 S0.001,114.615,0.001,256.001S114.616,512,256.001,512z"></path> <path style="opacity:0.1;enable-background:new ;" d="M68.873,256.001c0-129.706,96.466-236.866,221.564-253.688 C279.172,0.798,267.681,0,256.001,0C114.616,0,0.001,114.615,0.001,256.001S114.616,512.001,256,512.001 c11.68,0,23.171-0.798,34.436-2.313C165.339,492.865,68.873,385.705,68.873,256.001z"></path> <path style="fill:#FFFFFF;" d="M313.391,256.001l67.398-67.398c4.899-4.899,4.899-12.842,0-17.74l-39.65-39.65 c-4.899-4.899-12.842-4.899-17.74,0l-67.398,67.398l-67.398-67.398c-4.899-4.899-12.842-4.899-17.74,0l-39.65,39.65 c-4.899,4.899-4.899,12.842,0,17.74l67.398,67.398l-67.398,67.398c-4.899,4.899-4.899,12.842,0,17.741l39.65,39.65 c4.899,4.899,12.842,4.899,17.74,0l67.398-67.398L323.4,380.79c4.899,4.899,12.842,4.899,17.74,0l39.65-39.65 c4.899-4.899,4.899-12.842,0-17.741L313.391,256.001z"></path> </g></svg>&nbsp;Clear</button>
            <input class="custom-input" readonly hidden name="productid" id="productid" style="width: 180px"/>
          </div>
          <div>
          <div class="row">
            <div>
              <div class="card"  style="height:700px; width: 100%">
                <div class="card-body">
                  <div id="responsive-data">
                  
                    </div>

                </div>
              </div>
              <div id="paginationDiv">

            </div>
              <div style="display: flex; margin-top: 10px; justify-content: space-between;">
                <div>
                  <button class="btn-control" id="printThis" style="width:160px; height:45px; margin-right: 10px"><svg version="1.1" id="_x32_" width="25px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="" stroke=""><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#ffff;} </style> <g> <path class="st0" d="M488.626,164.239c-7.794-7.813-18.666-12.684-30.578-12.676H409.01V77.861L331.145,0h-4.225H102.99v151.564 H53.955c-11.923-0.008-22.802,4.862-30.597,12.676c-7.806,7.798-12.665,18.671-12.657,30.574v170.937 c-0.008,11.919,4.847,22.806,12.661,30.589c7.794,7.813,18.678,12.669,30.593,12.661h49.034V512h306.02V409.001h49.037 c11.901,0.008,22.78-4.848,30.574-12.661c7.818-7.784,12.684-18.67,12.677-30.589V194.814 C501.306,182.91,496.436,172.038,488.626,164.239z M323.519,21.224l62.326,62.326h-62.326V21.224z M123.392,20.398l179.725,0.015 v83.542h85.491v47.609H123.392V20.398z M388.608,491.602H123.392v-92.801h-0.016v-96.638h265.217v106.838h0.015V491.602z M480.896,365.751c-0.004,6.353-2.546,11.996-6.694,16.17c-4.166,4.136-9.813,6.667-16.155,6.682h-49.049V281.75H102.974v106.853 H53.955c-6.365-0.015-12.007-2.546-16.166-6.682c-4.144-4.174-6.682-9.817-6.686-16.17V194.814 c0.004-6.338,2.538-11.988,6.686-16.155c4.167-4.144,9.809-6.682,16.166-6.698h49.034h306.02h49.037 c6.331,0.016,11.985,2.546,16.151,6.698c4.156,4.174,6.694,9.817,6.698,16.155V365.751z"></path> <rect x="167.59" y="336.155" class="st0" width="176.82" height="20.405"></rect> <rect x="167.59" y="388.618" class="st0" width="176.82" height="20.398"></rect> <rect x="167.59" y="435.255" class="st0" width="83.556" height="20.398"></rect> <path class="st0" d="M353.041,213.369c-9.263,0-16.767,7.508-16.767,16.774c0,9.251,7.504,16.759,16.767,16.759 c9.263,0,16.77-7.508,16.77-16.759C369.811,220.877,362.305,213.369,353.041,213.369z"></path> <path class="st0" d="M424.427,213.369c-9.262,0-16.77,7.508-16.77,16.774c0,9.251,7.508,16.759,16.77,16.759 c9.258,0,16.766-7.508,16.766-16.759C441.193,220.877,433.685,213.369,424.427,213.369z"></path> </g> </g></svg>&nbsp;Print</button>
                  <button class="btn-control" id="generatePDFBtn" style="width:160px; height:45px; margin-right: 10px"><svg width="25px" height="25px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M2.5 6.5V6H2V6.5H2.5ZM6.5 6.5V6H6V6.5H6.5ZM6.5 10.5H6V11H6.5V10.5ZM13.5 3.5H14V3.29289L13.8536 3.14645L13.5 3.5ZM10.5 0.5L10.8536 0.146447L10.7071 0H10.5V0.5ZM2.5 7H3.5V6H2.5V7ZM3 11V8.5H2V11H3ZM3 8.5V6.5H2V8.5H3ZM3.5 8H2.5V9H3.5V8ZM4 7.5C4 7.77614 3.77614 8 3.5 8V9C4.32843 9 5 8.32843 5 7.5H4ZM3.5 7C3.77614 7 4 7.22386 4 7.5H5C5 6.67157 4.32843 6 3.5 6V7ZM6 6.5V10.5H7V6.5H6ZM6.5 11H7.5V10H6.5V11ZM9 9.5V7.5H8V9.5H9ZM7.5 6H6.5V7H7.5V6ZM9 7.5C9 6.67157 8.32843 6 7.5 6V7C7.77614 7 8 7.22386 8 7.5H9ZM7.5 11C8.32843 11 9 10.3284 9 9.5H8C8 9.77614 7.77614 10 7.5 10V11ZM10 6V11H11V6H10ZM10.5 7H13V6H10.5V7ZM10.5 9H12V8H10.5V9ZM2 5V1.5H1V5H2ZM13 3.5V5H14V3.5H13ZM2.5 1H10.5V0H2.5V1ZM10.1464 0.853553L13.1464 3.85355L13.8536 3.14645L10.8536 0.146447L10.1464 0.853553ZM2 1.5C2 1.22386 2.22386 1 2.5 1V0C1.67157 0 1 0.671573 1 1.5H2ZM1 12V13.5H2V12H1ZM2.5 15H12.5V14H2.5V15ZM14 13.5V12H13V13.5H14ZM12.5 15C13.3284 15 14 14.3284 14 13.5H13C13 13.7761 12.7761 14 12.5 14V15ZM1 13.5C1 14.3284 1.67157 15 2.5 15V14C2.22386 14 2 13.7761 2 13.5H1Z" fill="#ffff"></path> </g></svg>&nbsp;Save as PDF</button>
                  <button class="btn-control" id="generateEXCELBtn" style="width:160px; height:45px;"><svg height="25px" width="25px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26 26" xml:space="preserve" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path style="fill:#ffff;" d="M25.162,3H16v2.984h3.031v2.031H16V10h3v2h-3v2h3v2h-3v2h3v2h-3v3h9.162 C25.623,23,26,22.609,26,22.13V3.87C26,3.391,25.623,3,25.162,3z M24,20h-4v-2h4V20z M24,16h-4v-2h4V16z M24,12h-4v-2h4V12z M24,8 h-4V6h4V8z"></path> <path style="fill:#ffff;" d="M0,2.889v20.223L15,26V0L0,2.889z M9.488,18.08l-1.745-3.299c-0.066-0.123-0.134-0.349-0.205-0.678 H7.511C7.478,14.258,7.4,14.494,7.277,14.81l-1.751,3.27H2.807l3.228-5.064L3.082,7.951h2.776l1.448,3.037 c0.113,0.24,0.214,0.525,0.304,0.854h0.028c0.057-0.198,0.163-0.492,0.318-0.883l1.61-3.009h2.542l-3.037,5.022l3.122,5.107 L9.488,18.08L9.488,18.08z"></path> </g> </g></svg>&nbsp;Save as Excel</button>
                </div>
                <div style = "margin-top: -40px;">
                  <style>
                    .title_div{
                      color: #FF6700;
                    }
                    .tbl_value{
                      color: #ffffff;
                    }

                  </style>
                  <Address style = "color:#ccc; font-family: Century Gothic; font-weight: bold; font-style: italic; ">
                    <div class = "title_div">Total Counts of Invoice Number: <span id = "total_invoice_numbers" class = "tbl_value"></span></div>
                    <div class = "title_div">Total Expenses: <span id = "overall_total_expenses" class = "tbl_value"></span></div>
                    <div class = "title_div">Date Period: <span id = "date_period" class = "tbl_value">---</span></div>
                  </Address>
                </div>
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

<?php 
  include("layout/footer.php");
  include("./modals/delete_expense_confirmation.php");
?>

<script>
  $(document).ready(function()
  {
    $("#expenses").addClass('active');
    $("#pointer").html("Expenses");

    show_allExpenses("", "");
    $('#date_range').daterangepicker({
        opens: 'left'
    }, function(start, end, label) {
        var start_date = start.format('YYYY-MM-DD');
        var end_date = end.format('YYYY-MM-DD');
        var formatted_start_date = start.format('MMM D, YYYY'); 
        var formatted_end_date = end.format('MMM D, YYYY'); 

        $("#start_date_value").val(start_date);
        $("#end_date_value").val(end_date);
        show_allExpenses(start_date, end_date)
        $("#date_period").text(formatted_start_date + " - "+formatted_end_date);
    });
    $("#clear_all_search").off("click").on("click", function(){
      $("#searchInput").val("");
      $("#date_range").val("");
      $("#searchInput").focus();
      show_allExpenses("", "");
    })
    $("#date_range").val(""); 
    $("#printThis").on("click", function () {
      $('#modalCashPrint').show();
      $.ajax({
        url: './reports/generate_expense_pdf.php',
        type: 'GET',
        xhrFields: {
          responseType: 'blob'
        },
        success: function (response) {
          $('#modalCashPrint').hide();
          var newBlob = new Blob([response], { type: 'application/pdf' });
          var blobURL = URL.createObjectURL(newBlob);

          var newWindow = window.open(blobURL, '_blank');
          if (newWindow) {
            newWindow.onload = function () {
              newWindow.print();
              newWindow.focus();
            };
          } 
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    })
    $("#generatePDFBtn").on("click", function () 
    {
      $('#modalCashPrint').show();
        $.ajax({
          url: './reports/generate_expense_pdf.php',
          type: 'GET',
          xhrFields: {
            responseType: 'blob'
          },
          success: function (response) {
            $('#modalCashPrint').hide();
            var blob = new Blob([response], { type: 'application/pdf' });
            var url = URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'expenses.pdf';
            document.body.appendChild(a);
            a.click();

            URL.revokeObjectURL(url);
            document.body.removeChild(a);
          },
          error: function (xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
    })
    $('#generateEXCELBtn').click(function () {
      $('#modalCashPrint').show();
      var fileName = "overall_expenses";
      $.ajax({
        url: './reports/generate_expense_excel.php',
        type: 'GET',
        xhrFields: {
          responseType: 'blob'
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
      
    });
    $("#btn_createExpense").off("click").on("click", function(){
      $("#expense_form")[0].reset();
      $('#imagePreview').attr('src', "./assets/img/invoice.png");
      $("#expense_id").val("");
      $("#item_name").focus();
      $("#add_expense_modal").find(".modalHeaderTxt").html("Add New Expense");
      createExpense();
    })
    function createExpense()
    {
      $("#add_expense_modal").addClass('slideInRight');
      $(".expense_content").addClass('slideInRight');
      setTimeout(function () {
        $("#add_expense_modal").show();
        $(".expense_content").show();
      }, 100);
    }
    function setFormattedDate(date) {
      return moment(date).format('MM-DD-YYYY');
    }
    function show_allExpenses(start_date, end_date) 
    {
      if ($.fn.DataTable.isDataTable("#responsive-data #tbl_expenses")) {
            $("#responsive-data #tbl_expenses").DataTable().destroy();
        }
        $("#paginationDiv").empty().hide();
        $("#searchInput").focus();

        var tblData = `
            <table id='tbl_expenses' class='text-color table-border display' style='font-size: 12px;'>
                <thead>
                    <tr>
                        <th class='text-center auto-fit'>No.</th>
                        <th class='auto-fit'>Item Name</th>
                        <th class='auto-fit'>Date</th>
                        <th class='auto-fit text-center'>Billable</th>
                        <th class='auto-fit text-center'>Type</th>
                        <th class='auto-fit text-center'>Quantity</th>
                        <th class='auto-fit text-center'>UOM</th>
                        <th class='auto-fit text-center'>Supplier</th>
                        <th class='auto-fit'>Invoice Number</th>
                        <th class='auto-fit text-center'>Price (Php)</th>
                        <th class='auto-fit text-center'>Discount</th>
                        <th class='auto-fit text-center'>Total Amount(Php)</th>
                        <th class='auto-fit text-center'>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>`;

        $("#responsive-data").html(tblData);

        var table = $('#responsive-data #tbl_expenses').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: 'api.php?action=get_allExpenses',
                type: 'POST',
                data: {
                  start_date: start_date,
                  end_date: end_date,
                },
            },
            columns: [
                { data: null, render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1, className: 'text-center', },
                { 
                    data: 'item_name',
                    render: (data, type, row) => {
                        if (data === null || data === '') {
                            return row.product ;
                        } else {
                            return data;
                        }
                    }
                },
                { data: 'date_of_transaction', className: 'text-center', render: data => setFormattedDate(data) },
                { data: 'billable_receipt_no', className: 'text-center' },
                { data: 'expense_type' },
                { data: 'quantity', className: 'text-center' },
                { data: 'uom_name', className: 'text-center' },
                { data: 'supplier', className: 'text-center' },
                { data: 'invoice_number', className: 'text-center' },
                { data: 'price', render: data => `<span style="text-align: right; display: block;">&#x20B1; ${addCommasToNumber(data)}</span>` },
                { data: 'discount', render: data => `<span style="text-align: right; display: block;">&#x20B1; ${addCommasToNumber(data)}</span>` },
                { data: 'total_amount', render: data => `<span style="text-align: right; display: block;">&#x20B1; ${addCommasToNumber(data)}</span>` },
                // { data: null, render: data => `<button style='border-radius: 5px; height: 25px; margin: 0;' data-id='${data.id}' id='btn_removeExpense'><i class='bi bi-trash'></i></button>`, className: 'text-center' }
                {
                  data: null,
                  render: (data, type, row) => {
                    if (data.product_id !== 0) {
                      return `<button style='border-radius: 5px; height: 25px; margin: 0;'  >NO DELETE</button>`;
                    } else {
                      return `<button style='border-radius: 5px; height: 25px; margin: 0;' data-id='${data.id}' id='btn_removeExpense'><i class='bi bi-trash'></i></button>`;
                    }
                  }, className: 'text-center',
                }
            ],
            ordering: true,
            order: [[0, 'DESC']],
            pageLength: 25,
            pagingType: 'full_numbers',
            dom: '<"row view-filter"<"col-sm-12"<"clearfix">>>t<"row"<"col-sm-12"p>>',
            fnDrawCallback: function (oSettings) {
              if (oSettings.aoData.length === 0) {
                  $("#paginationDiv").hide();
              } else {
                  $("#paginationDiv").show();
              }
              var totalSum = table
                  .column(11, { page: 'current' }) 
                  .data()
                  .reduce(function (acc, val) {
                      return acc + parseFloat(val);
                  }, 0);

              $('#overall_total_expenses').text(addCommasToNumber(totalSum));

              var uniqueInvoiceNumbers = new Set();
              var rows = table.rows({ page: 'current' }).nodes();

              $(rows).each(function () {
                  var invoiceNumber = $(this).find('td:eq(8)').text().trim(); 
                  if (invoiceNumber !== "") { 
                      uniqueInvoiceNumbers.add(invoiceNumber);
                  }
              });

              $('#total_invoice_numbers').text(uniqueInvoiceNumbers.size);
            },
            createdRow: function (row, data, dataIndex) {
              $(row).attr('data-id', data.id);
            }
        });
        table;

        $("#paginationDiv").html($(".dt-paging")).show();

        var debounceTimeout;
        $('#searchInput').on('keyup', function () {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => {
                table.search($('#searchInput').val()).draw();
            }, 100);
        });
    }
    $("#responsive-data").on("click", "#btn_removeExpense", function(){
      var id = $(this).data('id');
      $.ajax({
        type: 'get',
        url: 'api.php?action=get_expenseDataById',
        data: {
          expense_id: id
        },
        success: function(response)
        {
          $("#remove_expense_id").val(id);
          $("#expense_name").html("Item name: <span style ='color: #FF6700'>"+response['item_name'].toUpperCase() + "</span> Invoice number: <span style = 'color: #FF6700'>"+response['invoice_number'] + "</span>");
          $("#expense_msg").html("<span style ='color: red; font-weight: bold'>Deleting an item might be crucial as it can affect other transactions</span>");
          if (response['invoice_photo_url']) {
                $("#item_image").attr("src", response['invoice_photo_url']).show();
            } else {
                $('#item_image').attr('src', "./assets/img/tinkerpro-logo-light.png").show();
            }
          $("#delete_expenseConfirmation").slideDown({
            backdrop: 'static',
            keyboard: false
          });
        }
      })
    })
    $("#responsive-data").on("dblclick", "tr", function() {
        var expense_id = $(this).data("id");
        $("#tbl_expenses tbody").find("tr").removeClass('highlighted-row')
        $(this).toggleClass('highlighted-row');
        $("#add_expense_modal").find(".modalHeaderTxt").html("Edit Expense");
        $.ajax({
          type: 'get',
          url: 'api.php?action=get_expenseDataById',
          data: {
            expense_id: expense_id
          },
          success: function(response)
          {
            $("#expense_id").val(expense_id);
            var item_name = response['item_name'] === "" ? response['product'] : response['item_name'];
            $("#item_name").val(item_name);
            var formattedDate = moment(response['date_of_transaction']).format('MM-DD-YYYY');
            $("#date_of_transaction").val(formattedDate);
            $("#billable_receipt_no").val(response['billable_receipt_no']);
            $("#expense_type").val(response['expense_type']);
            $("#qty").val(response['quantity']);
            $("#supplier").val(response['supplier']);
            $("#supplier_id").val(response['supplier_id']);
            $("#uomType").val(response['uom_name']);
            $("#uomID").val(response['uom_id']);
            $("#invoice_number").val(response['invoice_number']);
            $("#price").val(response['price']);
            $("#discount").val(response['discount']);
            $("#total_amount").val(response['total_amount']);
            $("#description").val(response['description']);

            if (response['invoice_photo_url']) {
                $("#imagePreview").attr("src", response['invoice_photo_url']).show();
            } else {
                $('#imagePreview').attr('src', "./assets/img/invoice.png").show();
            }
            createExpense();
          }
        })
 
    });
    function display_settings()
    {
      $.ajax({
        type: 'get',
        url: 'api.php?action=pos_settings',
        success:function(response){
          var defaultColor = "#FF6900";
          if(!$.isEmptyObject(response))
          {
            $("table thead tr th").css("background-color", response);
            $("table th").css("background-color", response);
            $("table th").css("color", "#ffffff");
            $("table thead").css("border-color", response);
            $("table").css("border-color", response);
          }
          else
          {
            $("table thead tr th").css("background-color", defaultColor);
            $("table th").css("background-color", defaultColor);
            $("table th").css("color", "#ffffff");
            $("table thead").css("border-color", defaultColor);
            $("table").css("border-color", defaultColor);
          }
        }
      })
    }
    function addCommasToNumber(number) 
    {
      var roundedNumber = Number(number).toFixed(2);
      var parts = roundedNumber.toString().split(".");
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return parts.join(".");
    }
    function hide_modal()
    {
      $("#add_expense_modal").addClass('slideOutRight');
      $(".expense_content").addClass('slideOutRight');
      setTimeout(function () {
        $("#add_expense_modal").removeClass('slideOutRight');
        $("#add_expense_modal").hide();
        $(".expense_content").removeClass('slideOutRight');
        $(".expense_content").hide();
      }, 100);
      $("#searchInput").focus();
    }
    $("#expense_form").on("submit", function(e){
      e.preventDefault();
      var errorCount = $('#expense_form td.form-error').length;
      if(errorCount === 0)
      {
        var formData = new FormData(this);
        var expense = $("#item_name").val();
        var total_amount = $("#total_amount").val();
        var invoice_number = $("#invoice_number").val();
        var expense_id = $("#expense_id").val();
        $.ajax({
          type: 'POST',
          url: 'api.php?action=save_expense',
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function(response)
          {
            display_settings();
            $('table td').removeClass('form-error'); 
            if (!response.success) {
              var errors = "";
                $.each(response.errors, function(key, error) {
                  if(key === "qty")
                  {
                    $('#' + key + '').addClass("form-error");
                  }
                  else if(key === "image_url")
                  {
                    $('#' + key + '').addClass("form-error");
                  }
                  else{
                    $('#' + key + '').closest("td").addClass("form-error");
                  } 
                  errors += "<li>"+error+"</li>"
                });
                $("#expense_errorMessages").html(errors)
            } else {
              $("#expense_form")[0].reset();
              $("table td").removeClass('form-error');
              show_sweetReponse(response.message);
              hide_modal();
              show_allExpenses("", "");

              var userInfo = JSON.parse(localStorage.getItem('userInfo'));
              var firstName = userInfo.firstName;
              var lastName = userInfo.lastName;
              var cid = userInfo.userId;
              var role_id = userInfo.roleId; 

              if(expense_id !== "" && expense_id !== "0")
              {
                insertLogs('Expense', "Updated expense: "+expense + ", Amount: "+total_amount + ", Invoice#: "+invoice_number)
              }
              else
              {
                insertLogs('Expense', "Created expense: "+expense + ", Amount: "+total_amount + ", Invoice#: "+invoice_number)
              }

            }
          },
          error: function(e){
            console.log("server error.")
          }
        })
      }
    })
    $(".continue_deleteExpense").off("click").on("click", function(){
      $.ajax({
        type: 'get',
        url: "api.php?action=delete_expenseById",
        data: {
          expense_id: $("#remove_expense_id").val(),
        },
        success: function(response)
        {
          display_settings();
          if(response.success)
          {
            var info = response.info;
            $("#remove_expense_id").val("");
            $('#delete_expenseConfirmation').hide();
            show_sweetReponse(response.message);
            show_allExpenses("", "");
            var userInfo = JSON.parse(localStorage.getItem('userInfo'));
            var firstName = userInfo.firstName;
            var lastName = userInfo.lastName;
            var cid = userInfo.userId;
            var role_id = userInfo.roleId; 

            var item_name = info['item_name'] === "" ? info['product'] : info['item_name'];
            insertLogs('Expense', "Deleted Expense: "+item_name+ " Invoice #: "+info['invoice_number'] + " Amount: "+info['total_amount'])
          }
        },
        error: function(response){
          console.log("Error");
        }
      })
    })
    function show_sweetReponse(message) 
    {
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
      toastr.success(message);
    }
  })
</script>