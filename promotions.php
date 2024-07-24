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
        font-size: 14px;
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
    table .edit:hover{
        color: var(--primary-color);
    }
    table .delete:hover{
        color: red;
    }
    .submitPromotion{
        height: 40px;
        margin-bottom: -20px;
    }
    
    .bundledDiv::-webkit-scrollbar {
        width: 6px; 
    }
    .bundledDiv::-webkit-scrollbar-track {
        background: #151515;
    }
    .bundledDiv::-webkit-scrollbar-thumb {
        background: #888; 
        border-radius: 20px; 
    }
    .displayBarcode{
        text-align: center;
    }
    body{
        font-family: Century Gothic;
    }
</style>
<?php include "layout/admin/css.php"?>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include 'layout/admin/sidebar.php' ?>


      <!-- partial -->
      <div class="main-panel ms-2 h-100">
        <div class="row">
            <div class="d-flex justify-content-between">
                <label class="titeClass mb-2">PROMOTION & ACTION</label>
                <button class="btn btn-secondary" id="addPromotion" style="background-color: var(--primary-color);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                    </svg> ADD NEW PROMOTION
                </button>
            </div>
            
            <div class="col-3 h-100 ps-2 pb-2 p-0" id="promotions_title">

                <div class="promotion-container">
                    <input type="hidden" class = "promotion_type" value = "0">
                    <div class="buy-to-take-one promotionType d-none"  data-id="1">
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

                    <div class="bundle-sale mt-2 promotionType d-none" data-id="2">
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

                    <div class="whole-sale mt-2 promotionType d-none" data-id="3">
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
                            <input class="text-center" readonly type="text" id="date_picker_wholeSale" placeholder="SELEC DATE">
                        </div>
                    </div>

                    <div class="point_promo mt-2 promotionType d-none" data-id="4">
                        <div class="d-flex justify-content-between">
                            <label for="" class="titleBtn">Point Promo</label>
                            <button class="btn btn-secondary editBtns">
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

                    <div class="stamp_promo mt-2 promotionType d-none" data-id="5">
                        <div class="d-flex justify-content-between">
                            <label for="" class="titleBtn">Stamp Card Promo</label>
                            <button class="btn btn-secondary editBtns">
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


            <div class="col-9 d-none promotions_table">

                <div class="table-cotainers p-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="45" height="35" fill="var(--text-color)" class="bi bi-upc-scan" viewBox="0 0 16 16">
                            <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5M3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0z"/>
                        </svg>
                    <input type="hidden" class="w-100 search_product_id me-2 ms-2">
                    <input disabled type="text"  placeholder="SEARCH BARCODE/CODE/NAME" class="w-100 search_product ">

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
    include('./modals/delete_modal.php');

?>

<script>



 $("#promotions").addClass('active');
 $("#pointer").html("Promotion & Action");



 function getPromoSet() {
    axios.get('api.php?action=getPromotionSet')
    .then(function(response) {
        var promotionSet = response.data.data.promotions;
        var promos = JSON.parse(promotionSet);

     
        function allValuesZero(obj) {
            for (var key in obj) {
                if (obj.hasOwnProperty(key) && obj[key] !== 0) {
                    console.log('Hello world');
                    $('.promotions_table').addClass('d-none');
                    return false;
                }
            }
            return true; 
        }

        var allZero = true;
        $.each(promos, function(index, promo) {
            if (!allValuesZero(promo)) {
                allZero = false;
                $('.promotions_table').removeClass('d-none');
            }
        });


        
        if (promos[0].buy_1_take_1 == 1) {
            $('#buy_1_take_1').prop('checked', true);
            $('.buy-to-take-one').removeClass('d-none');
            
        } else {
            $('#buy_1_take_1').prop('checked', false);
            $('.buy-to-take-one').addClass('d-none');
        }

        if (promos[0].bundle_sale == 1) {
            $('#bundle_sale').prop('checked', true);
            $('.bundle-sale').removeClass('d-none');
           
        } else {
            $('#bundle_sale').prop('checked', false);
            $('.bundle-sale').addClass('d-none');
        }

        if (promos[0].whole_sale == 1) {
            $('#whole_sale').prop('checked', true);
            $('.whole-sale').removeClass('d-none');
           
        } else {
            $('#whole_sale').prop('checked', false);
            $('.whole-sale').addClass('d-none');
        }

        if (promos[0].point_promo == 1) {
            $('#point_promo').prop('checked', true);
            $('.point_promo').removeClass('d-none');
           
        } else {
            $('#point_promo').prop('checked', false);
            $('.point_promo').addClass('d-none');
        }


        if (promos[0].stamp_promo == 1) {
            $('#stam_card').prop('checked', true);
            $('.stamp_promo').removeClass('d-none');
        } else {
            $('#stam_card').prop('checked', false);
            $('.stamp_promo').addClass('d-none');
        }
    })
    .catch(function(error) {
        console.log(error);
    });
 }


 function toUpdatePromo() {
    var take1 = $('#buy_1_take_1').prop('checked') ? 1 : 0;
    var bundle = $('#bundle_sale').prop('checked') ? 1 : 0;
    var wholesale = $('#whole_sale').prop('checked') ? 1 : 0;
    var point_promo = $('#point_promo').prop('checked') ? 1 : 0;
    var stamp_promo = $('#stam_card').prop('checked') ? 1 : 0;

    axios.post('api.php?action=updatePromo', {
        'bundle' : bundle,
        'take1' : take1,
        'point_promo' : point_promo,
        'wholesale' : wholesale,
        'stamp_promo' : stamp_promo,
    })
    .then(function(response) {
        console.log(response.data)
    })
    .catch(function(error) {
        console.log(error);
    });

 }


 $(document).ready(function() {
    getPromoSet();

    $('.search_product').focus();
    var isClick = false;


    $('#updatePromotion').off('click').on('click', function() {
        toUpdatePromo();
        getPromoSet();
        $('.closeModalPromotion').click();
    })

    $('.search_product').on('input', function() {
        if ($(this).val() != '') {
            $('.clearInput').removeClass('d-none');
        } else {
            $('.clearInput').addClass('d-none');
        }
    })

    $('.clearInput').off('click').on('click', function() {
        $('.search_product').val('').focus();
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


    $('#addPromotion').on('click', function() {
        $('#promoteModal').fadeIn();
        if ($('#promoteModal').is(':visible')) {

           
        }
    });

    $('.closeModalPromotion').click(function() {
        $('#promoteModal').fadeOut();
    });
 })


</script>



<style>

    .main-panel {
        -webkit-user-select: none; 
        -moz-user-select: none;   
        -ms-user-select: none;  
        user-select: none;   
    }

    #addPromotion {
        border: none; 
        outline: none;
        cursor: pointer;
        height: 50px;
    }

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

    .search_product, .search_product_b {
        height: 40px;

        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;


        border-left: 1px solid var(--border-color) !important;
        border-top: 1px solid var(--border-color) !important;
        border-bottom: 1px solid var(--border-color) !important;
    
        padding-left: 10px;
    }
    .table-cotainers {
        border-radius: 10px;
        width: 100%;
        height: 85vh;
        background: #10253F;
    }

    .buy-to-take-one, .bundle-sale, .whole-sale, .point_promo, .stamp_promo {
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
    /* .
    .ui-autocomplete {
        background-color: var(--primary-color); 
        border-radius: 4px; 
        border: 1px solid #262626;
        font-family: Century Gothic;
        z-index: 999;
    } */
    .ui-menu {
        background-color: var(--primary-color);
        border-radius: 4px;
        border: 1px solid #262626;
        font-family: Century Gothic;
        z-index: 2999; /* Ensure this is higher than your modal's z-index */
    }

    .ui-menu-item {
        background-color: #262626; 
        color: #ffffff; 
        padding: 2px 2px; 
        line-height: 0.7;
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
    var promoType = 0;
    show_allProducts();
    $("#btn_addProduct").click(function (e) {
        e.preventDefault();
        var prod_id = $(".search_product_id").val();

        if(prod_id !== "" && prod_id !== "0")
        {
            if (!isDataExistInTable(prod_id)) 
            {
              open_modal("Product", prod_id);
            }
            else
            {
              show_response("Product is already in the table.", 2);
            }
            $(".search_product").val("");
            $(".search_product_id").val("0");
        }
        else
        {
          show_response("Product is not found.", 2);
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
    function show_response(message, type) 
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

        type === 1 ? toastr.success(message) : toastr.error(message);
    }

    $(".search_product").autocomplete({
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
            $(".search_product_id").val(selectedProductId);
            var product_name = ui.item.value;
            if(selectedProductId !== "" && selectedProductId !== "0")
            {
                console.log(isDataExistInTable(selectedProductId))
                if (!isDataExistInTable(selectedProductId)) 
                {
            
                    open_modal(product_name, selectedProductId);
                }
                else
                {
                    show_response("Product is already in the table.",2);
                }
                $(".search_product").val("");
                $(".search_product_id").val("0");
            }
            return false;
        },
    });
    
    function isDataExistInTable(data) 
    {
        var $matchingRow = $('#tbl_promotions tbody tr[data-product_id="' + data + '"]');
        return $matchingRow.length > 0;
    }

      $('.promotionType').off('click').on('click', function() {
        $('.search_product').prop('disabled', false)
        var id = $(this).data('id');
        promoType = id;
        $(".promotion_type").val(id);
        $("._promotionType").val(id);
        $('.promotionType').removeClass('selected-promo').css('border-color', 'var(--border-color)');
        $('.titleBtn').css('color', '#757575');
        $('.promoLabel').css('color', '#757575');

        $(this).addClass('selected-promo').css('border-color', 'transparent');
        $(this).find('.titleBtn').css('color', 'var(--primary-color)');
        $(this).find('.promoLabel').css('color', '#fff');

        show_promotionByType(id)
    });
    function reset_form()
    {
        $(".promotion_id").val("");
        $(".product_id").val("");
        $(".promotionForm input").val("");
        $("body").find(".error-highlight").removeClass("error-highlight");
        $("#tbl_bundled tbody").html("");
    }
    function open_modal(product_name, product_id)
    {
        reset_form();
        var promotion_type = $(".promotion_type").val();
        $("._promotionType").val(promotion_type);
        $(".submitPromotion").text("ADD");
        if(promotion_type === "0") show_response("Please choose a promotion type!");
        if(promotion_type === "1")
        {
            $(".qty").val("1");
            $("#buy1Take1Modal").show();
            $("#buy1Take1Modal #newprice").focus();
        }
        if(promotion_type === "2") $("#promotionModal").show();
        if(promotion_type === "3") $("#wholesaleModal").show();

        $("#qty").focus();
        $(".product_name").html(product_name);
        $(".product_id").val(product_id);
    }


    $(".promotionForm").on("submit", function(e){
        e.preventDefault();
        var type = $("._promotionType").val();
        var formData = $(this).serialize();
        var tbl_data = [];
        $("#tbl_bundled tbody tr").each(function () {
            var rowData = {};
            rowData['product_id'] = $(this).data('id');
            rowData['product_name'] = $(this).find("td:nth-child(1)").text();
            rowData['qty'] = $(this).find("td:nth-child(2)").text();
            tbl_data.push(rowData);
        })
    
        $.ajax({
            type: 'post',
            url: 'api.php?action=save_promotion',
            data: {
                formData: formData,
                bundledData: JSON.stringify(tbl_data),
            },
            success: function(response)
            {
                if (!response.success) 
                {
                    $.each(response.errors, function(key, error) {
                        $('.promotionForm #' + key + '').addClass("error-highlight");
                    });
                }
                else
                {
                    reset_form();
                    show_promotionByType(promoType);
                    $('.modal').fadeOut(300);
                    show_response(response.message, 1);
                }
            },
            error: function(error)
            {
                console.log("error");
            }
        })
    })
    
    function show_promotionByType(type)
    {
        $("#tbl_promotions").html("");
        $.ajax({
            type: 'get',
            url: 'api.php?action=get_allPromotions',
            success: function(data)
            {
                var html = "";
                switch(type)
                {
                    case 1:
                        html = " <thead>";
                        html += "<tr>";
                        html += "<th>SN</th>";
                        html += "<th>PRODUCTS</th>";
                        html += "<th>BARCODE</th>";
                        html += "<th style = 'text-align: right'>APPLY TO QTY</th>";
                        html += "<th style = 'text-align: right'>PRICE</th>"
                        html += "<th style = 'text-align: center; width: 1%;'>ACTION</th>"
                        html += "</tr>";
                        html += "</thead>";
                        for(var i = 0; i<data.length; i++)
                        {
                            if(data[i].promotion_type === 1)
                            {
                                html += "<tr data-product_id = "+data[i].product_id+">";
                                html += "<td>"+data[i].sku+"</td>";
                                html += "<td>"+data[i].prod_desc+"</td>";
                                html += "<td>"+data[i].promotion_barcode+"</td>";
                                html += "<td style = 'text-align: right'>"+data[i].qty+"</td>";
                                html += "<td style = 'text-align: right'>"+data[i].newprice+"</td>";
                                html += "<td style = 'text-align: center;'><i class='bi bi-pencil-square edit' onclick='editItem("+data[i].promotion_id+ ", " +data[i].promotion_type+")' data-id = "+data[i].promotion_id+"></i>&nbsp;<i class='bi bi-trash3 delete' onclick='deleteItem("+data[i].promotion_id+", "+data[i].promotion_type+")' data-id="+data[i].promotion_id+" ></i></td>";
                                html += "</tr>";   
                            }
                        }
                        break;
                    case 2:
                        html = " <thead>";
                        html += "<tr>";
                        html += "<th>SN</th>";
                        html += "<th>PRODUCTS</th>";
                        html += "<th>BARCODE</th>";
                        html += "<th style = 'text-align: right'>APPLY TO QTY</th>";
                        html += "<th style = 'text-align: right'>PRICE</th>"
                        html += "<th style = 'text-align: center; width: 1%;'>ACTION</th>"
                        html += "</tr>";
                        html += "</thead>";
                        for(var i = 0; i<data.length; i++)
                        {
                            if(data[i].promotion_type === 2)
                            {
                                html += "<tr data-product_id = "+data[i].product_id+">";
                                html += "<td>"+data[i].sku+"</td>";
                                html += "<td>"+data[i].prod_desc+"</td>";
                                html += "<td>"+data[i].promotion_barcode+"</td>";
                                html += "<td style = 'text-align: right'>"+data[i].qty+"</td>";
                                html += "<td style = 'text-align: right'>"+data[i].newprice+"</td>";
                                html += "<td style = 'text-align: center;'><i class='bi bi-pencil-square edit' onclick='editItem("+data[i].promotion_id+ ", " +data[i].promotion_type+")' data-id = "+data[i].promotion_id+"></i>&nbsp;<i class='bi bi-trash3 delete' onclick='deleteItem("+data[i].promotion_id+", "+data[i].promotion_type+")' data-id="+data[i].promotion_id+" ></i></td>";
                                html += "</tr>";   
                            }
                        }
                        break;
                    default: break;
                }
              
                $("#tbl_promotions").html(html);
            }
        })
    }
    function editItem(id, promotion_type)
    { 
        reset_form();
        $("._promotionType").val(promotion_type)
        $(".promotion_id").val(id);
        $.ajax({
            type: 'get',
            url: 'api.php?action=get_promotionDetails',
            data: {
                promotion_id: id,
            },
            success: function(responseData)
            {
                $(".product_id").val(responseData['product_id']);
                $(".submitPromotion").text("UPDATE");
                $(".product_name").text(responseData['prod_desc']);
                switch(promotion_type)
                {
                    case 1:
                        $("#buy1Take1Modal #qty").val(responseData['qty']);
                        $("#buy1Take1Modal #newprice").val(responseData['newprice']);
                        $("#buy1Take1Modal #newbarcode").val(responseData['promotion_barcode']);
                        $("#buy1Take1Modal").fadeIn(200);
                        break;
                    case 2:
                        $("#promotionModal #qty").val(responseData['qty']);
                        $("#promotionModal #newprice").val(responseData['newprice']);
                        $("#promotionModal #newbarcode").val(responseData['promotion_barcode']);
                        var bundleData = JSON.parse(responseData['promotion_items']);
                        var row = "";
                        for(var i = 0; i<bundleData.length; i++)
                        {
                            row += "<tr data-id = " + bundleData[i].product_id + ">";
                            row += "<td>" + bundleData[i].product_name + "</td>";
                            row += "<td style = 'text-align:center'>1</td>";
                            row += "<td style = 'text-align:center' ><i class = 'bi bi-trash3 delete' onclick='removeItem.call(this)'></i></td>";
                            row += "</tr>";
                        }
                        $("#tbl_bundled tbody").html(row);
                        $("#promotionModal").fadeIn(200);
                        break;
                    default:
                        break;
                }
              
            }
        });
    }
    function deleteItem(id, promotion_type)
    { 
        $(".promotion_id").val(id);
        $.ajax({
            type: 'get',
            url: 'api.php?action=get_promotionDetails',
            data: {
                promotion_id: id,
            },
            success: function(responseData)
            {
                $(".product_id").val(responseData['product_id']);
                $(".ProdName").text(responseData['prod_desc']);
             
                var info = "";
                switch(promotion_type)
                {
                    case 1:
                        info += `<div class="d-flex justify-content-center text-center align-items-center w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" fill="red" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4m.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
                                </svg>
                                </div>
                                <div class="d-flex align-items-center justify-content text-center mt-2">
                                <h4 class="w-100">Are you sure you want to delete this item in the Buy 1 Take 1 promotion?</h4>
                                </div>`;
                        break;
                    case 2:
                    info += `<div class="d-flex justify-content-center text-center align-items-center w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" fill="red" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4m.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
                            </svg>
                            </div>
                            <div class="d-flex align-items-center justify-content text-center mt-2">
                            <h4 class="w-100">Are you sure you want to delete this item in the Bundle Sale?</h4>
                            </div>`;
                     break;
                    default: break;
                }
                $(".show_product_info").html(info);
                $("#deleteProdModal").fadeIn(200);
            }
        });
    }
    $(".deleteProductItem").on("click", function(){
        var id = $(".promotion_id").val();
        var type = $(".promotion_type").val();
        $.ajax({
            type: 'get',
            url: 'api.php?action=deletePromotion',
            data: {
                promotion_id: id,
            },
            success: function(response)
            {
                if(response.success)
                {
                    $("#deleteProdModal").hide();
                    show_promotionByType(promoType);
                    show_response(response.message, 1);
                }
            }
        })
    })
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
    $("input").on("input", function(){
        $(this).removeClass('error-highlight');
    })
</script>