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

                    <div class="buy-to-take-one">
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
                            <input class="text-center" readonly type="text" id="date_picker_buy1" placeholder="SELEC DATE">
                        </div>
                    </div>

                    <div class="bundle-sale mt-2">
                        <div class="d-flex justify-content-between">
                            <label for="" class="titleBtn">Bundle Sale</label>
                            <button class="btn btn-secondary editBtns">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </button>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <label class="promoLabel" for="">Promo Period</label>
                            <input class="text-center" readonly type="text" id="date_picker_bundle" placeholder="SELEC DATE">
                        </div>
                    </div>

                    <div class="whole-sale mt-2">
                        <div class="d-flex justify-content-between">
                            <label for="" class="titleBtn">Wholesale</label>
                            <button class="btn btn-secondary editBtns">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </button>
                        </div>


                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <label class="promoLabel" for="">Promo Period</label>
                            <input class="text-center" readonly type="text" id="date_picker_wholeSale" placeholder="SELEC DATE">
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

  
    $('.buy-to-take-one, .bundle-sale, .whole-sale').off('click').on('click', function() {
        
        $('.buy-to-take-one, .bundle-sale, .whole-sale').removeClass('selected-promo').css('border-color', 'var(--border-color)');
        $('.titleBtn').css('color', '#757575');
        $('.promoLabel').css('color', '#757575');
        
        // if () {
            isClick = false;
            // $('.editBtns').css('background-color', '')
        // }

        $(this).addClass('selected-promo').css('border-color', 'transparent');
        $(this).find('.titleBtn').css('color', 'var(--primary-color)');
        $(this).find('.promoLabel').css('color', '#fff');
    });

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
</style>


<script>
    var products = [];
    let productsCache = [];
    show_allProducts();

    $("#btn_addProduct").click(function (e) {
        e.preventDefault();
        var prod_id = $("#search_product_id").val();
        var barcode = $("#barcode_value").val();
        if(prod_id !== "" && prod_id !== "0")
        {
            if (!isDataExistInTable(prod_id)) 
            {
              open_modal("Product");
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
                        "border": "2px solid #1E1C11",
                    });
                },
                "onHidden": function () {
                    toastDisplayed = false; 
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
                        open_modal(product_name);
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
        function open_modal(product_name)
        {
            $("#product_name").html(product_name);
            $("#promotionModal").show();
        }

</script>