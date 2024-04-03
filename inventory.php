<?php

  include( __DIR__ . '/layout/header.php');
  include( __DIR__ . '/utils/db/connector.php');
  include( __DIR__ . '/utils/models/product-facade.php');

  $productFacade = new ProductFacade;

  $userId = 0;

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
  include('./modals/optionModal.php');

?>
<?php include "layout/admin/css.php"?>
<?php include "layout/admin/table.php"?>
  <div class="container-scroller">
    <div class="" >
      <?php include 'layout/admin/sidebar.php' ?>
      <div class="main-panel">
        <div class="content-wrapper" >
          <div style="display: flex; margin-bottom: 20px;">
            <label><img src="assets/img/barcode.jpg" style="color: white; height: 35px; width: 50px;"></label>
            <input  class="text-color searchProducts" style="width: 60%; height: 35px; margin-right: 10px" placeholder="Search Product,[code,serial no., barcode, name, brand]"/>
            <button class="icon-button">
              <span class="search-icon"></span>
              Search
            </button>
            <button class="icon-button" style = "width: 200px;">
              <span class="plus-icon"></span>
              Add Qty
            </button>
            <button class="icon-button" onclick="openOptionModal()">
              <span class="plus-icon"></span>
               Option
            </button>
          </div>
          <div>
            <style>
              .tbl_buttonsContainer {
                display: flex; 
              }
              .division {
                  flex-grow: 1; 
                  margin: 0 10px;
              }
              .grid-container {
                  display: grid;
                  grid-template-columns: repeat(3, auto); 
                  gap: 10px; 
              }
              .grid-item{
                height: 35px;
                border-radius: 10px;
              }
            </style>
          <div class="tbl_buttonsContainer">
              <div class="division">
                  <div class="grid-container">
                      <button id="stocks" class="grid-item text-color">Stocks</button>
                      <button id="purchase-order" class="grid-item text-color">Purchase Order</button>
                      <button id="inventory-count" class="grid-item text-color">Inventory Count</button>
                      <button id="bom" class="grid-item text-color">B.O.M</button>
                      <button id="low-stocks" class="grid-item text-color">Low Stocks</button>
                      <button id="reorder-point" class="grid-item text-color">Re-order Point</button>
                  </div>
              </div>
              <div class="division">
                  <div class="grid-container">
                      <button id="loss-damage1" class="grid-item text-color">Loss & Damage</button>
                      <button id="stock-transfer" class="grid-item text-color">Stocks Transfer</button>
                      <button id="expiration" class="grid-item text-color">Expiration</button>
                      <button id="loss-damage2" class="grid-item text-color">Loss & Damage</button>
                      <button id="bom2" class="grid-item text-color">B.O.M</button>
                      <button id="print-price-tags" class="grid-item text-color">Print Price Tags</button>
                  </div>
              </div>
              <div class="division">
                  <div class="grid-container">
                      <button id="recalculate-stocks" class="grid-item text-color">Recalculate Stocks</button>
                  </div>
              </div>
          </div>
          </div>
          <p></p>
          <div class="row">
            <div>
              <div class="card">
                <div class="card-body">
                  <?php include('errors.php'); ?>
                  <div class="table-responsive productTable">
                    <table id="tbl_products" class="text-color table-border" style ="font-size: 12px;">
                      <thead>
                        <tr>
                          <th class="text-center" style="width: 2%;">No.</th>
                          <th class="text-center" style="width: 12%;">Name</th>
                          <th class="text-center" style="width: 6%;">Barcode</th>
                          <th class="text-center" style="width: 6%;">Unit</th>
                          <th class="text-center" style="width: 2%;">Qty in Store</th>
                          <th class="text-center" style="width: 2%;">Qty in Warehouse</th>
                          <th class="text-center" style="width: 3%;">Amount Before Tax </th>
                          <th class="text-center" style="width: 3%;">Amount After Tax</th>
                          <th class="text-center" style="width: 3%;">Markup Profit</th>
                          <th class="text-center" style="width: 7%;">Action</th>
                        </tr>
                      </thead>
                      <tbody id="productTable">
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- main-panel ends -->
      <footer>
        <div class="footer-content">
            <button class="btn-control" id="printThis" style="width:160px; height:45px; margin-right: 10px; font-size: 15px;"><svg version="1.1" id="_x32_" width="25px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="" stroke=""><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#ffff;} </style> <g> <path class="st0" d="M488.626,164.239c-7.794-7.813-18.666-12.684-30.578-12.676H409.01V77.861L331.145,0h-4.225H102.99v151.564 H53.955c-11.923-0.008-22.802,4.862-30.597,12.676c-7.806,7.798-12.665,18.671-12.657,30.574v170.937 c-0.008,11.919,4.847,22.806,12.661,30.589c7.794,7.813,18.678,12.669,30.593,12.661h49.034V512h306.02V409.001h49.037 c11.901,0.008,22.78-4.848,30.574-12.661c7.818-7.784,12.684-18.67,12.677-30.589V194.814 C501.306,182.91,496.436,172.038,488.626,164.239z M323.519,21.224l62.326,62.326h-62.326V21.224z M123.392,20.398l179.725,0.015 v83.542h85.491v47.609H123.392V20.398z M388.608,491.602H123.392v-92.801h-0.016v-96.638h265.217v106.838h0.015V491.602z M480.896,365.751c-0.004,6.353-2.546,11.996-6.694,16.17c-4.166,4.136-9.813,6.667-16.155,6.682h-49.049V281.75H102.974v106.853 H53.955c-6.365-0.015-12.007-2.546-16.166-6.682c-4.144-4.174-6.682-9.817-6.686-16.17V194.814 c0.004-6.338,2.538-11.988,6.686-16.155c4.167-4.144,9.809-6.682,16.166-6.698h49.034h306.02h49.037 c6.331,0.016,11.985,2.546,16.151,6.698c4.156,4.174,6.694,9.817,6.698,16.155V365.751z"></path> <rect x="167.59" y="336.155" class="st0" width="176.82" height="20.405"></rect> <rect x="167.59" y="388.618" class="st0" width="176.82" height="20.398"></rect> <rect x="167.59" y="435.255" class="st0" width="83.556" height="20.398"></rect> <path class="st0" d="M353.041,213.369c-9.263,0-16.767,7.508-16.767,16.774c0,9.251,7.504,16.759,16.767,16.759 c9.263,0,16.77-7.508,16.77-16.759C369.811,220.877,362.305,213.369,353.041,213.369z"></path> <path class="st0" d="M424.427,213.369c-9.262,0-16.77,7.508-16.77,16.774c0,9.251,7.508,16.759,16.77,16.759 c9.258,0,16.766-7.508,16.766-16.759C441.193,220.877,433.685,213.369,424.427,213.369z"></path> </g> </g></svg>&nbsp;&nbsp;&nbsp;Print</button>
            <button class="btn-control" id="generatePDFBtn"style="width:160px; height:45px; margin-right: 10px; font-size: 15px;"><svg width="25px" height="25px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M2.5 6.5V6H2V6.5H2.5ZM6.5 6.5V6H6V6.5H6.5ZM6.5 10.5H6V11H6.5V10.5ZM13.5 3.5H14V3.29289L13.8536 3.14645L13.5 3.5ZM10.5 0.5L10.8536 0.146447L10.7071 0H10.5V0.5ZM2.5 7H3.5V6H2.5V7ZM3 11V8.5H2V11H3ZM3 8.5V6.5H2V8.5H3ZM3.5 8H2.5V9H3.5V8ZM4 7.5C4 7.77614 3.77614 8 3.5 8V9C4.32843 9 5 8.32843 5 7.5H4ZM3.5 7C3.77614 7 4 7.22386 4 7.5H5C5 6.67157 4.32843 6 3.5 6V7ZM6 6.5V10.5H7V6.5H6ZM6.5 11H7.5V10H6.5V11ZM9 9.5V7.5H8V9.5H9ZM7.5 6H6.5V7H7.5V6ZM9 7.5C9 6.67157 8.32843 6 7.5 6V7C7.77614 7 8 7.22386 8 7.5H9ZM7.5 11C8.32843 11 9 10.3284 9 9.5H8C8 9.77614 7.77614 10 7.5 10V11ZM10 6V11H11V6H10ZM10.5 7H13V6H10.5V7ZM10.5 9H12V8H10.5V9ZM2 5V1.5H1V5H2ZM13 3.5V5H14V3.5H13ZM2.5 1H10.5V0H2.5V1ZM10.1464 0.853553L13.1464 3.85355L13.8536 3.14645L10.8536 0.146447L10.1464 0.853553ZM2 1.5C2 1.22386 2.22386 1 2.5 1V0C1.67157 0 1 0.671573 1 1.5H2ZM1 12V13.5H2V12H1ZM2.5 15H12.5V14H2.5V15ZM14 13.5V12H13V13.5H14ZM12.5 15C13.3284 15 14 14.3284 14 13.5H13C13 13.7761 12.7761 14 12.5 14V15ZM1 13.5C1 14.3284 1.67157 15 2.5 15V14C2.22386 14 2 13.7761 2 13.5H1Z" fill="#ffff"></path> </g></svg>&nbsp;&nbsp;&nbsp;Save as PDF</button>
            <button class="btn-control" id="generateEXCELBtn" style="width:160px; height:45px; font-size: 15px;"><svg height="25px" width="25px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26 26" xml:space="preserve" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path style="fill:#ffff;" d="M25.162,3H16v2.984h3.031v2.031H16V10h3v2h-3v2h3v2h-3v2h3v2h-3v3h9.162 C25.623,23,26,22.609,26,22.13V3.87C26,3.391,25.623,3,25.162,3z M24,20h-4v-2h4V20z M24,16h-4v-2h4V16z M24,12h-4v-2h4V12z M24,8 h-4V6h4V8z"></path> <path style="fill:#ffff;" d="M0,2.889v20.223L15,26V0L0,2.889z M9.488,18.08l-1.745-3.299c-0.066-0.123-0.134-0.349-0.205-0.678 H7.511C7.478,14.258,7.4,14.494,7.277,14.81l-1.751,3.27H2.807l3.228-5.064L3.082,7.951h2.776l1.448,3.037 c0.113,0.24,0.214,0.525,0.304,0.854h0.028c0.057-0.198,0.163-0.492,0.318-0.883l1.61-3.009h2.542l-3.037,5.022l3.122,5.107 L9.488,18.08L9.488,18.08z"></path> </g> </g></svg>&nbsp;&nbsp;&nbsp;Save as Excel</button>
        </div>
      </footer>
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  

<?php include("layout/footer.php") ?>
<script>
  $(document).ready(function()
  {
    var url = window.location.href;
    var urlEnding = url.substring(url.lastIndexOf('/') + 1);
    $("#"+urlEnding).css('background-color', '#FF6700');

    function hideModals()
    {
      $("#optionModal").addClass('slideOutRight');
        $(".optionmodal-content").addClass('slideOutRight');
        setTimeout(function() {
            $("#optionModal").removeClass('slideOutRight');
            $("#optionModal").hide();
            $(".optionmodal-content").removeClass('slideOutRight');
            $(".optionmodal-content").hide();
        }, 100);
    }
    $('#btn_minimizeModal').click(function() 
    {
      hideModals();
    });
  })
</script>
<script>
  
    $("#product-form").on("submit", function(e){
      e.preventDefault();
      var formData = $(this).serialize();
      console.log(formData);
    })
    $("#purchase-order").on('click', function(){
      openOptionModal();
      $(this).addClass('active');
      $("#btn_createPO").addClass('active');
    })
    function openOptionModal()
    {
      getSku();
      $("#optionModal").addClass('slideInRight');
      $(".optionmodal-content").addClass('slideInRight');
      setTimeout(function() {
          $("#optionModal").show();
          $(".optionmodal-content").show();
      }, 100); 

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

</script>