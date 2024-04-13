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
  include('./layout/admin/table-pagination-css.php');

?>

<?php include "layout/admin/css.php"?>
<?php include "layout/admin/table.php"?>
  <div class="container-scroller">
    <div class="" >
      <?php include 'layout/admin/sidebar.php' ?>
      <div class="main-panel">
        <div class="content-wrapper" >
          <div style="display: flex; margin-bottom: 20px;">
            <label><img src="assets/img/barcode.png" style="color: white; height: 35px; width: 50px;"></label>
            <input  class="text-color" id = "searchInput" style="width: 60%; height: 35px; margin-right: 10px" placeholder="Search Product,[code,serial no., barcode, name, brand]"/>
            
            <button class="icon-button">
              <span class="search-icon"></span>
              Search
            </button>
            <select id="paginationDropdown" class = "icon-button" >
              <option value="">Select<i class = "bi bi-dropdown"></i></option>
              <option value="25">25</option>
              <option value="50">50</option>
              <option value="75">75</option>
              <option value="100">100</option>
              <option value="all">Show All</option>
            </select>
            <button class="icon-button" style = "width: 200px;">
              <span class="plus-icon"></span>
              Add Qty
            </button>
            <button class="icon-button" id = "btn_openOption">
              <span class="plus-icon"></span>
               Option
            </button>
          </div>
          <div>
            <div class="tbl_buttonsContainer">
                <div class="division">
                    <div class="grid-container">
                        <button id="stocks" class="grid-item text-color button"><i class="bi bi-graph-up"></i>&nbsp; Stocks</button>
                        <button id="purchase-order" class="grid-item text-color button"><i class="bi bi-cart-check"></i>&nbsp; Purchase Order</button>
                        <button id="inventory-count" class="grid-item text-color button"><i class="bi bi-archive"></i>&nbsp; Inventory Count</button>
                        <button id="bom" class="grid-item text-color button"><i class="bi bi-file-earmark-spreadsheet"></i>&nbsp;  B.O.M</button>
                        <button id="low-stocks" class="grid-item text-color button"><i class="bi bi-exclamation-triangle-fill"></i>&nbsp; Low Stocks</button>
                        <button id="reorder-point" class="grid-item text-color button"><i class="bi bi-arrow-up-circle"></i>&nbsp; Re-order Point</button>
                    </div>
                </div>
                <div class="division">
                    <div class="grid-container">
                        <button id="loss-damage1" class="grid-item text-color button"><i class="bi bi-bug-fill"></i>&nbsp; Loss & Damage</button>
                        <button id="stock-transfer" class="grid-item text-color button"><i class="bi bi-arrow-right-circle"></i>&nbsp; Stocks Transfer</button>
                        <button id="expiration" class="grid-item text-color button"><i class="bi bi-calendar-x-fill"></i>&nbsp; Expiration</button>
                        <button id="loss-damage2" class="grid-item text-color button"><i class="bi bi-exclamation-diamond-fill"></i>&nbsp; Loss & Damage</button>
                        <button id="bom2" class="grid-item text-color button"><i class="bi bi-journal-check"></i>&nbsp; B.O.M</button>
                        <button id="print-price-tags" class="grid-item text-color button"><i class="bi bi-printer"></i>&nbsp; Print Price Tags</button>
                    </div>
                </div>
                <div class="division">
                    <div class="grid-container">
                        <button id="recalculate-stocks" class="grid-item text-color button"><i class="bi bi-calculator-fill"></i>&nbsp; Recalculate Stocks</button>
                    </div>
                </div>
            </div>
          </div>
          <div class="row">
            <div class="card" style = "width: 100%; ">
              <table id="tbl_products" class="text-color table-border" style ="font-size: 12px;">
                <thead>
                  <tr>
                    <th class="text-center" style="width: 4%;">ID</th>
                    <th style="width: 8%;">Supplier</th>
                    <th style="width: 4%;">Barcode</th>
                    <th class="text-center" style="width: 2%;">Unit</th>
                    <th class="text-center" style="width: 2%;">Qty in Store</th>
                    <th class="text-center" style="width: 2%;">Qty in Warehouse</th>
                    <th class="text-center" style="width: 3%;">Amount Before Tax </th>
                    <th class="text-center" style="width: 3%;">Amount After Tax</th>
                    <th class="text-center" style="width: 3%;">Markup Profit</th>
                    <th class="text-center" style="width: 2%;">Action</th>
                  </tr>
                </thead>
                <tbody >
                  
                </tbody>
              </table>
              <table id="tbl_orders" class="text-color table-border" style ="font-size: 12px;">
                <thead>
                  <tr>
                    <th style="width: 2%;">PO#</th>
                    <th style="width: 4%;">Supplier</th>
                    <th style="width: 2%;">Date Purchased</th>
                    <th style="width: 2%;">Due Date</th>
                    <th style="width: 2%;">Total</th>
                    <th style="width: 2%;">Is Paid</th>
                    <th style="width: 1%;">Action</th>
                  </tr>
                </thead>
                <tbody >
                  
                </tbody>
              </table>
              <div id="pagination" class="pagination-container">
                  <button class="paginate grid-item text-color" id="previous"><i class="bi bi-arrow-left"></i>&nbsp; Previous</button> |
                  <button class="paginate grid-item text-color" id="next">Next <i class="bi bi-arrow-right"></i>&nbsp;</button>
              </div>
          </div>
        </div>
      </div>
      <footer>
        <div class="footer-content">
            <button class="btn-control" id="printThis" style="width:160px; height:45px; margin-right: 10px; font-size: 15px;"><svg version="1.1" id="_x32_" width="25px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="" stroke=""><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#ffff;} </style> <g> <path class="st0" d="M488.626,164.239c-7.794-7.813-18.666-12.684-30.578-12.676H409.01V77.861L331.145,0h-4.225H102.99v151.564 H53.955c-11.923-0.008-22.802,4.862-30.597,12.676c-7.806,7.798-12.665,18.671-12.657,30.574v170.937 c-0.008,11.919,4.847,22.806,12.661,30.589c7.794,7.813,18.678,12.669,30.593,12.661h49.034V512h306.02V409.001h49.037 c11.901,0.008,22.78-4.848,30.574-12.661c7.818-7.784,12.684-18.67,12.677-30.589V194.814 C501.306,182.91,496.436,172.038,488.626,164.239z M323.519,21.224l62.326,62.326h-62.326V21.224z M123.392,20.398l179.725,0.015 v83.542h85.491v47.609H123.392V20.398z M388.608,491.602H123.392v-92.801h-0.016v-96.638h265.217v106.838h0.015V491.602z M480.896,365.751c-0.004,6.353-2.546,11.996-6.694,16.17c-4.166,4.136-9.813,6.667-16.155,6.682h-49.049V281.75H102.974v106.853 H53.955c-6.365-0.015-12.007-2.546-16.166-6.682c-4.144-4.174-6.682-9.817-6.686-16.17V194.814 c0.004-6.338,2.538-11.988,6.686-16.155c4.167-4.144,9.809-6.682,16.166-6.698h49.034h306.02h49.037 c6.331,0.016,11.985,2.546,16.151,6.698c4.156,4.174,6.694,9.817,6.698,16.155V365.751z"></path> <rect x="167.59" y="336.155" class="st0" width="176.82" height="20.405"></rect> <rect x="167.59" y="388.618" class="st0" width="176.82" height="20.398"></rect> <rect x="167.59" y="435.255" class="st0" width="83.556" height="20.398"></rect> <path class="st0" d="M353.041,213.369c-9.263,0-16.767,7.508-16.767,16.774c0,9.251,7.504,16.759,16.767,16.759 c9.263,0,16.77-7.508,16.77-16.759C369.811,220.877,362.305,213.369,353.041,213.369z"></path> <path class="st0" d="M424.427,213.369c-9.262,0-16.77,7.508-16.77,16.774c0,9.251,7.508,16.759,16.77,16.759 c9.258,0,16.766-7.508,16.766-16.759C441.193,220.877,433.685,213.369,424.427,213.369z"></path> </g> </g></svg>&nbsp;&nbsp;&nbsp;Print</button>
            <button class="btn-control" id="generatePDFBtn"style="width:160px; height:45px; margin-right: 10px; font-size: 15px;"><svg width="25px" height="25px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M2.5 6.5V6H2V6.5H2.5ZM6.5 6.5V6H6V6.5H6.5ZM6.5 10.5H6V11H6.5V10.5ZM13.5 3.5H14V3.29289L13.8536 3.14645L13.5 3.5ZM10.5 0.5L10.8536 0.146447L10.7071 0H10.5V0.5ZM2.5 7H3.5V6H2.5V7ZM3 11V8.5H2V11H3ZM3 8.5V6.5H2V8.5H3ZM3.5 8H2.5V9H3.5V8ZM4 7.5C4 7.77614 3.77614 8 3.5 8V9C4.32843 9 5 8.32843 5 7.5H4ZM3.5 7C3.77614 7 4 7.22386 4 7.5H5C5 6.67157 4.32843 6 3.5 6V7ZM6 6.5V10.5H7V6.5H6ZM6.5 11H7.5V10H6.5V11ZM9 9.5V7.5H8V9.5H9ZM7.5 6H6.5V7H7.5V6ZM9 7.5C9 6.67157 8.32843 6 7.5 6V7C7.77614 7 8 7.22386 8 7.5H9ZM7.5 11C8.32843 11 9 10.3284 9 9.5H8C8 9.77614 7.77614 10 7.5 10V11ZM10 6V11H11V6H10ZM10.5 7H13V6H10.5V7ZM10.5 9H12V8H10.5V9ZM2 5V1.5H1V5H2ZM13 3.5V5H14V3.5H13ZM2.5 1H10.5V0H2.5V1ZM10.1464 0.853553L13.1464 3.85355L13.8536 3.14645L10.8536 0.146447L10.1464 0.853553ZM2 1.5C2 1.22386 2.22386 1 2.5 1V0C1.67157 0 1 0.671573 1 1.5H2ZM1 12V13.5H2V12H1ZM2.5 15H12.5V14H2.5V15ZM14 13.5V12H13V13.5H14ZM12.5 15C13.3284 15 14 14.3284 14 13.5H13C13 13.7761 12.7761 14 12.5 14V15ZM1 13.5C1 14.3284 1.67157 15 2.5 15V14C2.22386 14 2 13.7761 2 13.5H1Z" fill="#ffff"></path> </g></svg>&nbsp;&nbsp;&nbsp;Save as PDF</button>
            <button class="btn-control" id="generateEXCELBtn" style="width:160px; height:45px; font-size: 15px;"><svg height="25px" width="25px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26 26" xml:space="preserve" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path style="fill:#ffff;" d="M25.162,3H16v2.984h3.031v2.031H16V10h3v2h-3v2h3v2h-3v2h3v2h-3v3h9.162 C25.623,23,26,22.609,26,22.13V3.87C26,3.391,25.623,3,25.162,3z M24,20h-4v-2h4V20z M24,16h-4v-2h4V16z M24,12h-4v-2h4V12z M24,8 h-4V6h4V8z"></path> <path style="fill:#ffff;" d="M0,2.889v20.223L15,26V0L0,2.889z M9.488,18.08l-1.745-3.299c-0.066-0.123-0.134-0.349-0.205-0.678 H7.511C7.478,14.258,7.4,14.494,7.277,14.81l-1.751,3.27H2.807l3.228-5.064L3.082,7.951h2.776l1.448,3.037 c0.113,0.24,0.214,0.525,0.304,0.854h0.028c0.057-0.198,0.163-0.492,0.318-0.883l1.61-3.009h2.542l-3.037,5.022l3.122,5.107 L9.488,18.08L9.488,18.08z"></path> </g> </g></svg>&nbsp;&nbsp;&nbsp;Save as Excel</button>
        </div>
      </footer>
    </div>
  </div>
<?php include("./modals/purchaseQty_modal.php")?>
<?php include("./modals/unpaid_purchase-modal.php")?>
<?php include("./modals/paid_purchase-modal.php")?>
<?php include("./modals/response-modal.php")?>
<?php include("layout/footer.php") ?>
<?php include("layout/admin/keyboardfunction.php") ?>

<script>
  $(document).ready(function() {
    $(".tablinks").click(function(e) {
      e.preventDefault();
      var tabId = $(this).data("tab");
      if(validateUnpaidSettings())
      {
        $(".tabcontent").hide();
        $("#" + tabId).show();
        $(".tablinks").removeClass("active");
        $(this).addClass("active");
      }
    });
    $('#paidSwitch').change(function() {
        if ($(this).is(':checked')) 
        {
          $('.toggle-switch-container').css('color', '#28a745');
          $('#paidSwitch').css('background-color', '#28a745');
        } 
        else 
        {
          $('.toggle-switch-container').css('color', '');
          $('#paidSwitch').css('background-color', ''); 
        }
    });
    $('#date_purchased').datepicker({
      dateFormat: 'M dd y', 
      altFormat: 'M dd y', 
      altField: '#date_purchased',
      maxDate: 0,
      onSelect: function(dateText, inst)
      {}
    });
 
    $('#s_due').datepicker({
      dateFormat: 'M dd y', 
      altFormat: 'M dd y', 
      altField: '#s_due',
      minDate: 0,
      onSelect: function(dateText, inst)
      {}
    });
 
    $('#calendar-btn').click(function() {
        $('#date_purchased').datepicker('show');
    });
    $('#calendar-btn1').click(function() {
        $('#s_due').datepicker('show');
    });
    function validateUnpaidSettings() 
    {
      var isValid = true;
      $('#tab3 input[type=text], input[type=date]').each(function() {
        if($(this).val() === '') 
        {
          isValid = false;
          $(this).addClass('has-error');
        } 
        else 
        {
          $(this).removeClass('has-error');
        }
      });
      return isValid;
    }
    function validateTab1() 
    {
      var isValid = true;
      $('#tab1 input[type=text], input[type=date]').each(function() {
        if($(this).val() === '') 
        {
          isValid = false;
          $(this).addClass('has-error');
        } 
        else 
        {
          $(this).removeClass('has-error');
        }
      });
      return isValid;
    }
    $("#tab3").show();
    $(".tablinks[data-tab='tab3']").addClass("active");
    $("#unpaid_form").on('submit', function(e){
      e.preventDefault();
      if(validateUnpaidSettings())
      {
        if(validateTab1())
        {
          var tab1FormData = $(this).serialize();
          $.ajax({
            type: 'post',
            url: 'api.php?action=save_order',
            data: tab1FormData,
            success: function(response)
            { 
              if(response.status === true)
              {
                submit_purchaseOrder();
              }
            },
            error: function(error)
            {
              alert("Failed on submitting the data!");
            }
          })
        }
        else
        {
          $(".tabcontent").hide();
          $("#tab1").show();
          $(".tablinks").removeClass("active");
          $(".tablinks[data-tab='tab1']").addClass("active");
        }
      }
      else
      {
        $(".tabcontent").hide();
        $("#tab3").show();
        $(".tablinks").removeClass("active");
        $(".tablinks[data-tab='tab3']").addClass("active");
      }
    })
  });
</script>
<script>
  var price_ids = ['price', 's_price', 'u_pay'];
  price_ids.forEach(function(id) 
  {
    document.getElementById(id).addEventListener('input', function(event) {
        this.value = this.value.replace(/[^0-9.]/g, '');
        let parts = this.value.split('.');
        if (parts[1] && parts[1].length > 2) {
            parts[1] = parts[1].slice(0, 2);
            this.value = parts.join('.');
        }
    });
});
  $(document).ready(function() {
      $('#paidSwitch').prop('checked', true); 
  });
</script>

<script>
  var perPage = 25;
  $(document).ready(function()
  {
    var totalTax = 0;
    var totalQty = 0;
    var totalPrice = 0;
    var overallTotal = 0;
    var selected_products = [];
    $("#tbl_orders").hide();
    show_allInventories(1, perPage); 
    show_allSuppliers();
    show_allProducts();
    show_purchaseOrderNo();
    display_datePurchased();

    $("#purchase-order").on('click', function(){
      $("button").removeClass('active');
      $(this).addClass('active');
      show_allOrders(1, perPage); 
      $("#tbl_products").hide();
    })
    $("#inventory-count").on('click', function(){
      $("button").removeClass('active');
      $(this).addClass('active');
      var modal = $("#response_modal");
      $("#response_modal").slideDown({
        backdrop: 'static',
        keyboard: false,
      });
      var inventory_count = $("#tbl_products tbody tr").length;
      $("#r_message").html("<i class = 'bi bi-box-seam'></i>&nbsp; Inventory Count: "+inventory_count);
      setTimeout(function() {
        $("#response_modal").slideUp();
        $("#inventory-count").removeClass('active');
      }, 10000);
    })
    function display_datePurchased()
    {
      var currentDate = new Date();
      var formattedDate = formatDate(currentDate);
      $('#date_purchased').val(formattedDate);
      $('#s_due').val(formattedDate);
    }
    function formatDate(date) 
    {
        var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                          "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        var day = date.getDate();
        var monthIndex = date.getMonth();
        var year = date.getFullYear().toString().substr(-2);
        return monthNames[monthIndex] + ' ' + (day < 10 ? '0' : '') + day + ' ' + year;
    }
    function show_purchaseOrderNo()
    {
      $("#pcs_no").val("10-000000001");
      $.ajax({
        type: 'get',
        url: 'api.php?action=get_purchaseOrderNo',
        success: function(data)
        {
          $("#pcs_no").val(data);
        }
      })
    }
    function hideDropdownItems()
    {
      $('#tbl_purchaseOrders tbody tr').each(function() {
        var tableText = $(this).find('td').text();
        $('.search-dropdown-item').each(function() { 
            if ($(this).text() === tableText)  {
              $(this).hide(); 
            }
          });
      });
    }
    function resetPurchaseOrderForm()
    {
      $("#supplier").val("");
      $("#date_purchased").val("");
      $("#product").val("");
      $('#tbl_purchaseOrders tbody').empty();
    }
    $("#btn_omCancel").click(function(){
      resetPurchaseOrderForm();
    })
    function submit_purchaseOrder()
    {
      var dataArray = [];
        $('#tbl_purchaseOrders tbody tr').each(function() {
            var rowData = {};
            $(this).find('td').each(function(index, cell) {
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
          total: overallTotal,
          totalTax: totalTax,
        },
        dataType: 'json',
        success: function(response) 
        {
          if(response.status)
          {
            resetPurchaseOrderForm();
            $("#paid_purchase_modal").hide();
            $("#totalTax").html("0.00");
            $("#totalQty").html("0");
            $("#totalPrice").html("&#x20B1;&nbsp;0.00");
            $("#overallTotal").html("&#x20B1;&nbsp;0.00");
            show_allInventories(1, perPage); 
            show_response(response.message);
            show_purchaseOrderNo();
            show_allProducts();
            show_allSuppliers();
            display_datePurchased();
            selected_products = [];
          }
          else
          {
            $.each(response.errors, function(key, value) {
              if(key === "isPaid")
              {
                $("#"+key).addClass('switch-error');
              }
              else
              {
                $('#' + key).addClass('has-error');
              }
            });
          }
        },
        error: function(xhr, status, error) {
          alert("Something went wrong!");
        }
      });
    }
    function show_response(message)
    {
      var modal = $("#response_modal");
      $("#response_modal").slideDown({
        backdrop: 'static',
        keyboard: false,
      });
      $("#r_message").html("<i class = 'bi bi-check-circle-fill'></i>&nbsp;"+message);
      setTimeout(function() {
        $("#response_modal").slideUp();
      }, 3000);
    }
    $("#btn_savePO").click(function(e){
      e.preventDefault();
      var tbl_poL = $("#po_body tr").length;
      if(tbl_poL > 0)
      {
        if($("#paidSwitch").prop("checked") === false)
        {
          $("#unpaid_purchase_modal").slideDown({
            backdrop: 'static',
            keyboard: false,
          });
          $("#product_name").text($("#product").val());
          $("#s_price").val($("#overallTotal").text());
          $("#unpaid_modalTitle").html("<i class = 'bi bi-exclamation-triangle style = 'color: red;' '></i>&nbsp; <strong>ATTENTION REQUIRED!</strong> ");
        }
        else
        {
          $("#paid_purchase_modal").slideDown({
            backdrop: 'static',
            keyboard: false,
          });
          $("#total_paid").html($("#overallTotal").text());
          $("#paid_modalTitle").html("<i class = 'bi bi-exclamation-triangle style = 'color: red;' '></i>&nbsp; <strong>ATTENTION REQUIRED!</strong> ");
          $("#btn_confirmPayment").click(function(){
            submit_purchaseOrder();
          })
        }
      }
      else if(tbl_poL === 0 && validatePOForm())
      {
        alert("Please a product to purchase");
      }
      else
      {
        validatePOForm();
      }
    })
    $("#btn_addPO").click(function(e){
      e.preventDefault();
      if(validatePOForm())
      {
        var product = $("#product").val();
        $("#purchaseQty_modal").slideDown({
          backdrop: 'static',
          keyboard: false,
        });
        $("#product_name").text(product);
        $("#pqty_modalTitle").html("<i class = 'bi bi-exclamation-triangle style = 'color: red;' '></i>&nbsp; <strong>ATTENTION REQUIRED!</strong> ");
      }
    })
    function roundToTwoDecimalPlaces(number) 
    {
      return parseFloat(number).toFixed(2);
    }
    function validatePOForm() 
    {
      var isValid = true;
      $('#po_form input[type=text], input[type=date]').each(function() {
        if ($(this).val() === '') 
        {
          isValid = false;
          $(this).addClass('has-error');
        } 
        else 
        {
          $(this).removeClass('has-error');
        }
      });

      return isValid;
    }
    function validatePOForm() 
    {
      var isValid = true;
      $('#po_form input[type=text], input[type=date]').each(function() {
        if ($(this).val() === '') 
        {
          isValid = false;
          $(this).addClass('has-error');
        } 
        else 
        {
          $(this).removeClass('has-error');
        }
      });

      return isValid;
    }
    function validateProductForm() 
    {
      var isValid = true;
      $('#prod_form input[type=text]').each(function() {
          if ($(this).val() === '') 
          {
            isValid = false;
            $(this).addClass('has-error');
          } 
          else 
          {
            $(this).removeClass('has-error');
          }
      });

      return isValid;
    }
    function addCommasToNumber(number) 
    {
      var roundedNumber = Number(number).toFixed(2);
      var parts = roundedNumber.toString().split(".");
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return parts.join(".");
    }
    $("#btn_pqtyClose, #btn_pqtyCancel").on('click', function(e){
      e.preventDefault();
      $("#purchaseQty_modal").hide();
      $("#unpaid_purchase_modal").hide();
    })
    $("#btn_paidClose, #btn_paidCancel").on('click', function(e){
      e.preventDefault();
      $("#paid_purchase_modal").hide();
    })
    $("#btn_pqtyCancel").click(function(){
      $("#prod_form")[0].reset();
    })
    $("#paginationDropdown").change(function(){
      perPage = $(this).val();
      show_allInventories(1, perPage); 
    })
    var i_quantities = ['#p_qty', '#u_qty']; 

    i_quantities.forEach(function(id) {
        $(id).on('input', function(e) {
            var inputValue = $(this).val();
            inputValue = inputValue.replace(/\D/g, '');
            $(this).val(inputValue);
        });
    });
    $("#supplier").change(function(e){
      e.preventDefault()
      $('#tbl_purchaseOrders tbody').empty();
    })
    $("#prod_form").submit(function(e){
      e.preventDefault();

      if(validateProductForm())
      {
        var p_qty = parseInt($("#p_qty").val());
        var price = parseFloat($("#price").val());
        var product = $("#product").val();
        var total = parseFloat(price * p_qty);  

        $.ajax({
          type: 'get',
          url: 'api.php?action=get_productInfo',
          data: {data:product},
          success: function(data)
          {
            var tax = 0;
            if(data['isVat'] === 1)
            {
              tax = (price/1.12);
              totalTax += (price-tax);
            }
            else totalTax += 0;

            totalQty += p_qty;
            totalPrice += price;
            overallTotal += total;
            $("#totalTax").html(totalTax.toFixed(2));
            $("#tbl_purchaseOrders tbody").append(
              "<tr>"+
                "<td>"+product+"</td>"+
                "<td style = 'text-align: center'>"+p_qty+"</td>"+
                "<td style = 'text-align: right'>&#x20B1;&nbsp;"+addCommasToNumber(price)+"</td>"+
                "<td style = 'text-align: right'>&#x20B1;&nbsp;"+addCommasToNumber(total)+"</td>"+
              "</tr>"
            );
            
            $("#d_products").find(".search-dropdown-item").filter(function() {
                if($(this).text() === product)
                {
                  selected_products.push($(this).text());
                }
            });
            show_allProducts();
            $("#totalQty").html(totalQty);
            $("#totalPrice").html("&#x20B1;&nbsp;"+addCommasToNumber(totalPrice.toFixed(2)));
            $("#overallTotal").html("&#x20B1;&nbsp;"+addCommasToNumber(overallTotal.toFixed(2)));

            $("#purchaseQty_modal").hide();
            $("#prod_form")[0].reset();
            $("#product").val("");
          }
        })
      }
    })
    $('#po_form').submit(function(e){
        e.preventDefault(); 
        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "api.php?action=save_purchaseOrder",
            data: formData,
            success: function(response){
              $.each(response.errors, function(key, value) {
                  $('#' + key).addClass('has-error');
              });
            }
        });
    });
    $("#pagination").on("click", "#previous", function() {
      var currentPage = $(this).data("page");
      if (currentPage > 1) 
      {
        show_allInventories(currentPage - 1, perPage);
      }
    });
    $("#pagination").on("click", "#next", function() {
        var currentPage = $(this).data("page");
        show_allInventories(currentPage + 1, perPage);
    });
    function show_allSuppliers()
    {
      $.ajax({
        type: 'GET',
        url: 'api.php?action=get_allSuppliers',
        success: function(data){
          var option = '';
          for(var i = 0; i<data.length; i++)
          {
            // option += '<div class="search-dropdown-item1" tabindex="0">'+data[i].supplier+'</div>';
            option += '<option>'+data[i].supplier+'</option>';
          }
          $("#d_suppliers").html(option);
        }
      })
    }
    function show_allProducts()
    {
      $.ajax({
        type: 'GET',
        url: 'api.php?action=get_allProducts',
        success: function(data){
          var option = '';
          for(var i = 0; i<data.length; i++)
          {
            var isSelected = selected_products.includes(data[i].prod_desc+" : "+data[i].barcode);
            if(!isSelected)
            {
              option += '<div class="search-dropdown-item" tabindex="0">'+data[i].prod_desc+" : "+data[i].barcode+'</div>';
            }
          }
          $("#d_products").html(option);
        }
      })
    }
    function show_allInventories(currentPage, perPage)
    {
      $.ajax({
        type: 'GET',
        url: 'api.php?action=get_allInventories&currentPage=' + currentPage + '&perPage=' + perPage,
        success: function(data)
        {
          var tbl_data = "";
          if(data.length > 0)
          {
            for(var i = 0; i < data.length; i++)
            {
              tbl_data += "<tr>";
              tbl_data += "<td style = 'text-align: center'>"+data[i].inventory_id+"</td>";
              tbl_data += "<td>"+data[i].supplier+"</td>";
              tbl_data += "<td>"+data[i].barcode+"</td>";
              tbl_data += "<td style = 'text-align: center'>"+data[i].uom_name+"</td>";
              tbl_data += "<td style = 'text-align: center'>"+data[i].qty_purchased+"</td>";
              tbl_data += "<td style = 'text-align: center'>"+ (data[i].qty_received === null ? 0 : "") +"</td>";
              tbl_data += "<td style = 'text-align: right'>&#x20B1; "+addCommasToNumber(data[i].amount_beforeTax)+"</td>";
              tbl_data += "<td style = 'text-align: right'>&#x20B1; "+addCommasToNumber(data[i].amount_afterTax)+"</td>";
              tbl_data += "<td>"+data[i].isPaid == 1 ? "YES" : "NO" +"</td>";
              tbl_data += "<td></td>";
              tbl_data += "<td style = 'text-align: center'><button class = 'grid-item button'><i  class = 'bi bi-pencil-fill'></i></button></td>";
              tbl_data += "</tr>";
            }
          } 
          else
          {
            tbl_data = "<tr><td colspan = '10'>No more available data.</td></tr>";
          }
          $("#tbl_products tbody").html(tbl_data);
          $("#previous, #next").data("page", currentPage);
        }
      });
    }
    function date_format(date)
    {
      var date = new Date(date);
      var formattedDate = $.datepicker.formatDate("M dd yy", date);
      return formattedDate;
    }
    function show_allOrders(currentPage, perPage)
    {
      $("#tbl_orders").show();
      $.ajax({
        type: 'GET',
        url: 'api.php?action=get_allOrders&currentPage=' + currentPage + '&perPage=' + perPage,
        success: function(data)
        {
          var tbl_data = "";
          if(data.length > 0)
          {
            for(var i = 0; i < data.length; i++)
            {
              if(data[i].order_type === 1)
              {
                tbl_data += "<tr>";
                tbl_data += "<td style = 'text-align: center'>"+data[i].po_number+"</td>";
                tbl_data += "<td>"+data[i].supplier+"</td>";
                tbl_data += "<td class = 'text-center'>"+date_format(data[i].date_purchased)+"</td>";
                if(data[i].due_date === null)
                  tbl_data += "<td class = 'text-center'> Not Available </td>";
                else 
                  tbl_data += "<td class = 'text-center'>"+date_format(data[i].due_date)+"</td>";
                tbl_data += "<td style = 'text-align: right'>"+data[i].price+"</td>";
                if(data[i].isPaid === 1)
                  tbl_data += "<td class = 'text-center'>Paid</td>";
                else 
                  tbl_data += "<td class = 'text-center'>Unpaid</td>";
                tbl_data += "<td style = 'text-align: center'><button data-id = "+data[i].order_id+" class = 'grid-item button' id = 'btn_editOrder'><i  class = 'bi bi-pencil-fill'></i></button></td>";
                tbl_data += "</tr>";
              }
            }
          } 
          else
          {
            tbl_data = "<tr><td colspan = '10'>No more available data.</td></tr>";
          }
          $("#tbl_orders tbody").html(tbl_data);
          $("#previous, #next").data("page", currentPage);
        }
      });
    }
    $("#tbl_orders tbody").on('click', '#btn_editOrder', function(e){
      e.preventDefault();
      var order_id = $(this).data('id');
      openOptionModal(); 
      $.ajax({
        type: 'GET',
        url: 'api.php?action=get_orderData&order_id='+order_id,
        dataType: 'json',
        success: function(data)
        {
          console.log(data)
          var table = "";
          $("#supplier").val(data[0].supplier);
          $("#date_purchased").val(data[0].date_purchased);

          var at = 0;
          var qt = 0;
          var pt = 0;
          var tt = 0;
          for(var i = 0; i<data.length; i++)
          {
            table +=  "<tr>";
            table += "<td>"+data[i].prod_desc+"</td>";
            table += "<td style = 'text-align: center'>"+data[i].qty_purchased+"</td>";
            table += "<td style = 'text-align: right'>&#x20B1;&nbsp;"+addCommasToNumber(data[i].amount_beforeTax)+"</td>";
            table += "<td style = 'text-align: right'>&#x20B1;&nbsp;"+addCommasToNumber(data[i].amount_beforeTax*data[i].qty_purchased)+"</td>";
            table += "</tr>";
            qt += parseInt(data[i].qty_purchased);
            pt += data[i].total;
          }
          $("#tbl_purchaseOrders tbody").html(table);
          $("#totalTax").html("Tax: "+roundToTwoDecimalPlaces(data[0].totalTax));
          $("#totalQty").html(qt);
          $("#totalPrice").html("&#x20B1;&nbsp;"+addCommasToNumber(roundToTwoDecimalPlaces(pt)));
          $("#overallTotal").html("&#x20B1;&nbsp;"+addCommasToNumber(data[0].price));
        },
        error: function(data){
          alert("No response")
        }
      })
    })
    $('#searchInput').on('input', function() {
        var barcode = $(this).val().trim().toLowerCase();
        filterTable(barcode); 
    });
    $('#product').on('input', function() {
      var barcode = $(this).val().trim().toLowerCase();
      filterPO(barcode); 
    });
    function filterPO(barcode) 
    {
      $('.search-dropdown-item').each(function() 
      { 
        var $row = $(this);
        var rowBarcode = $row.text().trim().toLowerCase();
        if (rowBarcode.includes(barcode)) 
        {
          $row.show(); 
        }
        else 
        {
          $row.hide(); 
        }
      });
    }
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
      $("button").removeClass('active');
      hideModals();
    });
    $("#product-form").on("submit", function(e){
      e.preventDefault();
      var formData = $(this).serialize();
      console.log(formData);
    })
    $("#btn_openOption").click(function(e){
      e.preventDefault();
      openOptionModal();
    })
    function openOptionModal()
    {
      $("#optionModal").addClass('slideInRight');
      $(".optionmodal-content").addClass('slideInRight');
      setTimeout(function() {
          $("#optionModal").show();
          $(".optionmodal-content").show();
      }, 100); 
      $("#btn_createPO").addClass('active');
    }
  })
</script>
<script>
    $(document).on('input', '#product', function() {
      var searchTerm = $(this).val().trim().toLowerCase();
      $('.search-dropdown-item').each(function() {
          var text = $(this).text().trim().toLowerCase();
          if (text.includes(searchTerm)) 
          {
            $(this).show();
          } 
          else 
          {
            $(this).hide();
          }
      });
      $("#d_products").css('display', searchTerm ? 'block' : 'none');
    });
    $(document).on('click', '.search-dropdown-item', function() {
        var clickedItem = $(this);
        $("#product").val(clickedItem.text());
        $("#d_products").css('display', 'none');
    });
    // $(document).on('input', '#supplier', function() {
    //   var searchTerm = $(this).val().trim().toLowerCase();
    //   $('.search-dropdown-item1').each(function() {
    //       var text = $(this).text().trim().toLowerCase();
    //       if (text.includes(searchTerm)) {
    //           $(this).show();
    //       } else {
    //           $(this).hide();
    //       }
    //   });
    //   $("#d_suppliers").css('display', searchTerm ? 'block' : 'none');
    // });
  
    $("#supplier").on('change', function(){
      $("#tbl_purchaseOrders tbody").empty();
    })
    $(document).on('click', '.search-dropdown-item1', function() {
        var clickedItem = $(this);
        $("#supplier").val(clickedItem.text());
        $("#d_suppliers").css('display', 'none');
    });
</script>