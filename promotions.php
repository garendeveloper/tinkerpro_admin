<?php

  include( __DIR__ . '/layout/header.php');
  include( __DIR__ . '/utils/db/connector.php');
  include( __DIR__ . '/utils/models/user-facade.php');
  include(__DIR__ . '/utils/models/ability-facade.php');


  $userId = 0;
  
  $abilityFacade = new AbilityFacade;

if (isset($_SESSION['user_id'])) {
 
    $userID = $_SESSION['user_id'];

    
    $permissions = $abilityFacade->perm($userID);

    
    $accessGranted = false;
    foreach ($permissions as $permission) {
        if (isset($permission['Users']) && $permission['Users'] == "Access Granted") {
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
  if (isset($_GET["add_user"])) {
		$error = $_GET["add_user"];
    array_push($success, $error);
	}
  if (isset($_GET["update_user"])) {
		$error = $_GET["update_user"];
    array_push($info, $error);
	}
  if (isset($_GET["delete_user"])) {
		$error = $_GET["delete_user"];
    array_push($info, $error);
	}

?>
<style>
    .inputAmount{
        border: 1px solid #757575 !important;
        height: 35px;
        border-radius: 5px;
    }
    .form-error{
        border: 2px solid red;
    }
    .table-cotainer{
        padding: 10px 10px;
    }
    #tbl_promotions thead tr th{
        color: var(--primary-color);
        background-color: #10253F;
        border-color: #10253F;
    }
    #tbl_promotions tbody tr td{
        color: #ffff;
        font-style: italic;
        background-color: #10253F;
        border-color: #10253F;
        height: 20px; 
        line-height: 0.5; 
        font-size: 12px;
    }
    .barcode-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .generate-button {
        position: absolute;
        right: 5px; 
        background: none;
        border: none;
        cursor: pointer;
        color: #333; 
    }

    .generate-button i {
        font-size: 24px; 
        background-color: #333333;
        color: white;
    }
    .generate-button i:hover {
        color: var(--primary-color);
    }
</style>
<?php include "layout/admin/css.php"?>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include 'layout/admin/sidebar.php' ?>
      <!-- partial -->
      <div class="main-panel ms-2 h-100">
         
        <div class="row">
            <label class="titeClass mb-2">PROMOTION & ACTION</label>

            <div class="col-3 h-100 ps-2 pb-2 p-0">

                <div class="promotion-container ">
                    <input type="hidden" id = "promotion_type" value = "0">
                    <div class="buy-to-take-one promotionType"  data-id="1">
                        <div class="d-flex justify-content-between">
                            <label for="" class="titleBtn">Buy 1 Take 1</label>
                            <button class="btn btn-secondary editBtns">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </button>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <label class="promoLabel" for="">Promo Period</label>
                            <input class="text-center" readonly type="text" id="date_picker_buy1" placeholder="SELECT DATE">
                        </div>
                    </div>

                    <div class="bundle-sale mt-2 promotionType" data-id="2">
                        <div class="d-flex justify-content-between">
                            <label for="" class="titleBtn">Bundle Sale</label>
                            <button class="btn btn-secondary editBtns" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </button>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <label class="promoLabel" for="">Promo Period</label>
                            <input class="text-center" readonly type="text" id="date_picker_bundle" placeholder="SELECT DATE">
                        </div>
                    </div>

                    <div class="whole-sale mt-2 promotionType" data-id="3">
                        <div class="d-flex justify-content-between">
                            <label for="" class="titleBtn">Wholesale</label>
                            <button class="btn btn-secondary editBtns" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </button>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <label class="promoLabel" for="">Promo Period</label>
                            <input class="text-center" readonly type="text" id="date_picker_wholeSale" placeholder="SELECT DATE">
                        </div>
                    </div>
                    
                </div>

            </div>


            <div class="col-9">

                <div class="table-cotainers p-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="45" height="35" fill="var(--text-color)" class="bi bi-upc-scan" viewBox="0 0 16 16">
                            <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5M3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0z"/>
                        </svg>
                    <input type="hidden" id="search_product_id" class="w-100 search_product me-2 ms-2">
                    <input type="text" id="search_product" placeholder="SEARCH BARCODE/CODE/NAME" class="w-100 search_product ">

                    <div class="btn-container">
                        <button class="btn btn-secondary clearInput d-none">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-x" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                </svg>
                            </span>
                        </button>
                    </div>

                    <div class="btn-container">
                        <button class="btn btn-secondary searchIcon">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                            </span>
                        </button>
                    </div>

                    <div class="btn-container">
                        <button class="btn btn-secondary" id= "btn_addProduct">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-plus" viewBox="0 0 16 16">
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                </svg>
                            </span>
                        </button>
                    </div>

                    </div>


                    <table id = "tbl_promotions" >
                      
                    </table>
                </div>
                
            </div>
        </div>
      </div>
    </div>
  </div>

<?php 

    include("layout/footer.php");
    include('./modals/datePickerModal.php');
    include('./modals/promotionModal.php');
    include('./modals/wholesaleModal.php');
    include('./modals/buy1Take1Modal.php');

?>

<script>



 $("#promotions").addClass('active');
 $("#pointer").html("Promotion & Action");


 $(document).ready(function() {
    $('#search_product').focus();
    var isClick = false;

    $('#search_product').on('input', function() {
        if ($(this).val() != '') {
            $('.clearInput').removeClass('d-none');
        } else {
            $('.clearInput').addClass('d-none');
        }
    })

    $('.clearInput').off('click').on('click', function() {
        $('#search_product').val('').focus();
        $('.clearInput').addClass('d-none');
    })


    $('.editBtns').click(function() {
        isClick = true;
        if (isClick) {
            $(this).css('background-color', 'var(--primary-color)')
            $('#date_picker_buy1, #date_picker_bundle, #date_picker_bundle').off('click').on('click', function() {
                $('#dateTimeModal').show();
            })
        }
        
    })

  
   

 })


</script>



<style>


    .selected-promo {
        background: #10253F;
       
    }

    .editBtns {
        background: none;
        border: none;
        box-shadow: none;
    }



    .titleBtn, .promoLabel {
        font-weight: bold;
        color: #757575;
    }

    .btn-container {
        width: auto;
    }

    .btn-container button {
        background: transparent;
        box-shadow: none;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;

        border-top-left-radius: 0;
        border-bottom-left-radius: 0;

        border-left: none;
        border-right: 1px solid var(--border-color);
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
        height: 40px;
    }


    .btn-container .clearInput, .btn-container .searchIcon {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;

        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        border-right: none;
    }


    .btn-container .clearInput:hover, .btn-container .searchIcon:hover {

        background: none;
        box-shadow: none;
    }

    .btn-container button:hover {
        background: var(--primary-color);
    }

    .search_product {
        height: 40px;

        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;


        border-left: 1px solid var(--border-color) !important;
        border-top: 1px solid var(--border-color) !important;
        border-bottom: 1px solid var(--border-color) !important;
    
        padding-left: 10px;
    }
    .table-cotainers {
     
        width: 100%;
        height: 85vh;
        background: #10253F;
    }

    .buy-to-take-one, .bundle-sale, .whole-sale {
        border: 1px solid var(--border-color);
        height: auto;
        width: 100%;
        border-radius: 10px;
        cursor: pointer;
        padding: 10px;
        color: var(--text-color);
    }

    .titeClass {
        font-size: 35px;
        color: var(--primary-color)
    }
    .ui-autocomplete {
        background-color: var(--primary-color); 
        border-radius: 4px; 
        border: 1px solid #262626;
    }

    .ui-menu-item {
        background-color: #262626; 
        color: #ffffff; 
        padding: 5px 10px; 
    }

    .ui-state-hover {
        background-color: var(--primary-color); 
        color: #ffffff; 
    }
    .form-error{
        border: 2px solid red;
    }
</style>


<script>
    var products = [];
    let productsCache = [];
    var toastDisplayed = false;
    show_allProducts();
    $("#btn_addProduct").click(function (e) {
        e.preventDefault();
        var prod_id = $("#search_product_id").val();
        var barcode = $("#barcode_value").val();

        if(prod_id !== "" && prod_id !== "0")
        {
            if (!isDataExistInTable(prod_id)) 
            {
              open_modal("Product", prod_id);
            }
            else
            {
              show_errorResponse("Product is already in the table.");
            }
            $("#search_product").val("");
            $("#search_product_id").val("0");
        }
        else
        {
          show_errorResponse("Product is not found.");
        }
    })
    function show_allProducts() 
    {
        $.ajax({
        type: 'GET',
        url: 'api.php?action=get_allProducts',
        success: function (data) {
            for (var i = 0; i < data.length; i++) 
            {
                var row = 
                {
                    product_id: data[i].id,
                    product: data[i].prod_desc,
                    barcode: data[i].barcode,
                };
                productsCache.push(row);
            }
        }
        });
    }

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
                value: row.product,
                id: row.product_id,
            };
        });
    }
    function show_errorResponse(message) 
    {
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
                    "border": "1px solid #1E1C11",
                });
            },
            "onHidden": function () {
                toastDisplayed = false; 
            },
            "closeButton": true,
            "positionClass": "toast-top-right",
            "timeOut": "3500",
            "extendedTimeOut": "1000",
            "progressBar": true,
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "tapToDismiss": false,
            "toastClass": "custom-toast",
            "onclick": function () { 
                toastr.clear();
                toastDisplayed = false;
                }
        };

        toastr.error(message);
    }

    $("#search_product").autocomplete({
        minLength: 2,
        source: function (request, response) {
            var term = request.term;
            var filteredProducts = filterProducts(term);
            var slicedProducts = filteredProducts.slice(0, 5);
            response(slicedProducts);
            if (slicedProducts.length > 0) {
                $('#filters').show();
                var slicedProductsLength = slicedProducts.length - 1;
                var selectedProductId = slicedProducts[slicedProductsLength].id;
                
            } else {
                $('#filters').hide();
            }
        },
        select: function (event, ui) {
            var selectedProductId = ui.item.id;
            $("#search_product_id").val(selectedProductId);
            var product_name = ui.item.value;
            if(selectedProductId !== "" && selectedProductId !== "0")
            {
                if (!isDataExistInTable(selectedProductId)) 
                {
            
                    open_modal(product_name, selectedProductId);
                }
                else
                {
                    show_errorResponse("Product is already in the table.");
                }
                $("#search_product").val("");
                $("#search_product_id").val("0");
            }
            return false;
        },
    });
    
    function isDataExistInTable(data) 
    {
        var $matchingRow = $('#tbl_priceTags tbody td[data-id="' + data + '"]').closest('tr');
        return $matchingRow.length > 0;
    }
    
    function showPromotionContent(promotionType) 
    {
        $("#tbl_promotions").html("");
        switch (promotionType) {
          case 1:
            show_allBuy1Take1();
            break;
          case 2:
    
            break;
          case 3:
            break;
          default:
          $("#tbl_promotions").html("");
            break;
        }
      }
      $('.promotionType').off('click').on('click', function() {
            var id = $(this).data('id');
            console.log(id)
            $("#promotion_type").val(id);
            $('.promotionType').removeClass('selected-promo').css('border-color', 'var(--border-color)');
            $('.titleBtn').css('color', '#757575');
            $('.promoLabel').css('color', '#757575');
 
            $(this).addClass('selected-promo').css('border-color', 'transparent');
            $(this).find('.titleBtn').css('color', 'var(--primary-color)');
            $(this).find('.promoLabel').css('color', '#fff');


            showPromotionContent(id);
        });

    function open_modal(product_name, product_id)
    {
        var promotion_type = $("#promotion_type").val();

        if(promotion_type === "0") show_errorResponse("Please choose a promotion type!");
        if(promotion_type === "1")
        {
            $("#buy1Take1Modal").show();
            $("#buy1Take1Modal #newprice").focus();
        }
        if(promotion_type === "2") $("#promotionModal").show();
        if(promotion_type === "3") $("#wholesaleModal").show();

        $("#qty").focus();
        $(".product_name").html(product_name);
        $(".product_id").val(product_id);
    }


    $("#buy1Take1Form").on("submit", function(e){
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'post',
            url: 'api.php?action=save_promotion',
            data: formData,
            success: function(response)
            {
                if (!response.success) 
                {
                    $.each(response.errors, function(key, error) {
                        $('#buy1Take1Form #' + key + '').addClass("error-highlight");
                    });
                }
                else
                {
                    $("#buy1Take1Modal").fadeOut(300);
                    $("#buy1Take1Form")[0].reset();
                    show_allBuy1Take1();
                }
            },
            error: function(error)
            {
                console.log("error");
            }
        })
    })
    
    function show_allBuy1Take1()
    {
        $.ajax({
            type: 'get',
            url: 'api.php?action=get_allPromotions',
            success: function(data)
            {
                var html = " <thead>";
                html += "<tr>";
                html += "<th>SN</th>";
                html += "<th>PRODUCTS</th>";
                html += "<th>BARCODE</th>";
                html += "<th style = 'text-align: right'>APPLY TO QTY</th>";
                html += "<th style = 'text-align: right'>PRICE</th>"
                html += "</tr>";
                html += "</thead>";
                for(var i = 0; i<data.length; i++)
                {
                    html += "<tr>";
                    html += "<td>"+data[i].sku+"</td>";
                    html += "<td>"+data[i].prod_desc+"</td>";
                    html += "<td>"+data[i].promotion_barcode+"</td>";
                    html += "<td style = 'text-align: right'>"+data[i].qty+"</td>";
                    html += "<td style = 'text-align: right'>"+data[i].newprice+"</td>";
                    html += "</tr>";
                }
                $("#tbl_promotions").html(html);
            }
        })
    }
    $(".generate-button").on("click", function(){
        generateEAN();
    })
    function generateEAN() 
    {
      let eanBase = Math.floor(100000000000 + Math.random() * 900000000000).toString();
      let checkDigit = calculateCheckDigit(eanBase);
      let fullEAN = eanBase + checkDigit;
      $(".displayBarcode").val(fullEAN);
    }

    function calculateCheckDigit(eanBase) 
    {
      let sum = 0;
      for (let i = 0; i < eanBase.length; i++) {
        let digit = parseInt(eanBase.charAt(i));
        if (i % 2 === 0) {
          sum += digit;
        } else {
          sum += digit * 3;
        }
      }
      let checkDigit = (10 - (sum % 10)) % 10;
      return checkDigit;
    }
        
</script>