<?php

  include( __DIR__ . '/layout/header.php');
  include( __DIR__ . '/utils/db/connector.php');
  include( __DIR__ . '/utils/models/user-facade.php');
  include(__DIR__ . '/utils/models/ability-facade.php');


//   $userId = 0;
//   $abilityFacade = new AbilityFacade;

// if (isset($_SESSION['user_id'])) {
 
//     $userID = $_SESSION['user_id'];

    
//     $permissions = $abilityFacade->perm($userID);

    
//     $accessGranted = false;
//     foreach ($permissions as $permission) {
//         if (isset($permission['Pricelist']) && $permission['Pricelist'] == "Access Granted") {
//             $accessGranted = true;
//             break;
//         }
//     }
//     if (!$accessGranted) {
//       header("Location: 403.php");
//       exit;
//   }
// } else {
//     header("Location: login.php");
//     exit;

// }

//   if (isset($_SESSION["user_id"])){
//     $userId = $_SESSION["user_id"];
//   }
//   if (isset($_SESSION["first_name"])){
//     $firstName = $_SESSION["first_name"];
//   }
//   if (isset($_SESSION["last_name"])){
//     $lastName = $_SESSION["last_name"];
//   }
//   if ($userId == 0) {
//     header("Location: login");
//   }
//   if (isset($_GET["add_user"])) {
// 		$error = $_GET["add_user"];
//     array_push($success, $error);
// 	}
//   if (isset($_GET["update_user"])) {
// 		$error = $_GET["update_user"];
//     array_push($info, $error);
// 	}
//   if (isset($_GET["delete_user"])) {
// 		$error = $_GET["delete_user"];
//     array_push($info, $error);
// 	}

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
        background-color: #10253F;
        border-color: #10253F;
        height: 15px; 
        line-height: 0.3; 
        /* font-size: 14px; */
        padding: 2px 2px;
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
    .promotionForm input{
        height: 35px;
    }
    .promo_datePeriod{
        width: 200px;
    }
    .active-row{
        background-color: var(--primary-color);
    }

    
#responsive-data thead th,
    #responsive-data tbody td {
      padding: 6px 6px; 
      height: auto; 
      line-height: 0.5; 
      border: 1px solid #10253F;
      color: #ffff;
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
      max-height: 76vh; 
      overflow-y: scroll;
  }

  #responsive-data th, td {
      width: 9%;
      overflow-wrap: break-word; 
      box-sizing: border-box;
      font-size: 13px;
  }
  #responsive-data tr {
      display: table;
      width: 100%;
  }
  #responsive-data, table,  tbody{
    border: 1px solid #10253F;
  }
  #responsive-data table{
      background-color: #10253F;
   
      height: 5px;
      padding: 10px 10px;
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
 .main-panel, .container-scroller, .card, .card-body, .content-wrapper{
  overflow: hidden !important;
 }
 .child-a{
  width: 3% !important;
 }
 .child-b{
  width: 12% !important;
 }
 .child-c{
  width: 5% !important;
 }
 .child-d{
  width: 5% !important;
 }
 .child-e{
  width: 5% !important;
 }
 .child-f{
  width: 5% !important;
 }
 .child-g{
  width: 5% !important;
 }
 .child-h{
  width: 3% !important;
 }
 .adminTableHead th{
  font-weight: bold !important;
  font-size: 12px !important;
  line-height: 18px !important;
 }
 .adminTableHead tbody td{
  padding-left: 10px !important;
 }


</style>
<?php include "layout/admin/css.php"?>
  <div class="container-scroller">
    <?php include 'layout/admin/sidebar.php' ?>
      <div class="main-panel ms-2 h-100" style = "overflow: hidden">
        <div class="row">
            <div class="d-flex justify-content-between">
                <label class="titeClass mb-2">PRICE LIST</label>
                <button class="btn btn-secondary" id="addPromotion" style="background-color: var(--primary-color);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-slash-minus" viewBox="0 0 16 16">
                        <path d="m1.854 14.854 13-13a.5.5 0 0 0-.708-.708l-13 13a.5.5 0 0 0 .708.708M4 1a.5.5 0 0 1 .5.5v2h2a.5.5 0 0 1 0 1h-2v2a.5.5 0 0 1-1 0v-2h-2a.5.5 0 0 1 0-1h2v-2A.5.5 0 0 1 4 1m5 11a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5A.5.5 0 0 1 9 12"/>
                    </svg> ADD / REMOVE NEW PRICE LIST
                </button>
            </div>

            <div class="col-12 promotions_table" >
                <div class="table-cotainers p-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="45" height="35" fill="var(--text-color)" class="bi bi-upc-scan" viewBox="0 0 16 16">
                            <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5M3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0z"/>
                        </svg>
                        <input type="hidden" class="w-100 search_product_id me-2 ms-2">
                        <input type="text"  placeholder="SEARCH BARCODE/CODE/NAME" class="w-100 search_product ">

                        <div class="btn-container">
                            <button class="btn btn-secondary clearInput ">
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
                    <div class = "scrollable" id = "responsive-data" style = "overflow-y:auto; height: 80vh; margin-top: 10px;">
                        <table id = "tbl_allPriceLists" >
                            <thead class = "adminTableHead">
                                <tr>
                                    <th class = "child-a">No</th>
                                    <th class = "child-b">Price List</th>
                                    <th class = "child-c">Rule</th>
                                    <th class = "child-d">Type</th>
                                    <th class = "child-e text-center">Adjustment</th>
                                    <th class = "child-f text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                       </table>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>

<?php 
    include("layout/footer.php");
    include("modals/priceListModal.php")
?>

<script>



 $("#price_list").addClass('active');
 $("#pointer").html("Price List");

 $(document).ready(function() {
    $('.search_product').focus();
    var isClick = false;

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
        $('#dateTimeModal').show();
    })

    $('#addPromotion').on('click', function() {
        $(".errorMessages").html("");
        $('#priceListModal').fadeIn(100);
        $(".submitPriceList").text("ADD");
        $(".promo-error").html("");
        $("#priceListName").focus();
    });

    $('.closeModalPromotion').click(function() {
        $('#priceListModal').fadeOut(100);
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
    .ui-menu {
        border: 1px solid #333333 !important;
        font-family: Century Gothic;
        z-index: 2999; 
    }

    .ui-menu-item {
        background-color: #333333 !important;
        color: #ffffff; 
        padding: 2px 2px; 
        line-height: 0.7;
    }

    .ui-state-hover {
        background-color: var(--primary-color) !important; 
        color: #ffffff; 
    }
    .form-error{
        border: 2px solid red;
    }
    .highlight{
        background-color: var(--primary-color) !important;
        color: white;
    }
    .highlight:hover{
        background-color: var(--primary-color) !important;
        color: white;
    }
    #tbl_allPriceLists tbody tr:hover{
        background-color: #333333;
    }
</style>

<script>
    var currentRow = "";
    var id = "";
    var pricelist = "";
    var rule = "";
    var type = "";
    $(document).ready(function(e){
        show_allPriceList();
    })
    $(document).on("click", "#tbl_allPriceLists tbody tr", function(e){
        e.preventDefault();
        $(this).siblings().removeClass('highlight');
        $(this).addClass('highlight');
    })
    $(".search_product").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tbl_allPriceLists tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    function editPriceList(currentRow)
    {   
        $(".errorMessages").html("");
        $(".submitPriceList").html("UPDATE");
        $("#priceListName").focus();
        id = currentRow.data('id');
        pricelist = currentRow.find("td").eq(1).text();
        rule = currentRow.find("td").eq(2).text();
        type = currentRow.find("td").eq(3).text();
        adjustment = currentRow.find("td").eq(4).text();
 
        $("#priceListModal").fadeIn(100);
        $(".priceListForm").find(".priceList_id").val(id);
        $(".priceListForm").find("#priceListName").val(pricelist);
        $(".priceListForm").find("#rule").val(rule);
        $(".priceListForm").find("#type").val(type);
        $(".priceListForm").find("#priceAdjustment").val(adjustment);
    }
    $(".priceListForm").on("submit", function(e){
        e.preventDefault();
        save_priceList();
    })
    $(document).on("dblclick", "#tbl_allPriceLists tbody tr", function(e){
        e.preventDefault();
        currentRow = $(this);
        editPriceList(currentRow);
    });
    $(document).on("click", "#tbl_allPriceLists tbody tr .editItem", function(e){
        e.preventDefault();
        currentRow = $(this).closest("tr");
        editPriceList(currentRow);
    });
    function show_allPriceList()
    {
        $.ajax({
            type: 'get',
            url: 'api.php?action=get_allPriceList',
            success: function(response)
            {
                var html = "";
                var counter = 1;
                response.forEach(item => {
                    html += "<tr data-id = "+item['id']+">";
                    html += "<td class = 'child-a'>"+counter+"</td>";
                    html += "<td class = 'child-b'>"+item['price_list_name']+"</td>";
                    html += "<td class = 'child-c'>"+item['rule']+"</td>";
                    html += "<td class = 'child-d'>"+item['type']+"</td>";
                    html += "<td class = 'child-e' style = 'text-align: right'>"+item['adjustment']+"</td>";
                    html += "<td class = 'child-f' style = 'text-align: right'><i class='bi bi-pencil-square editItem'></i>&nbsp;<i class = 'bi bi-trash3deleteItem'></i></td>";
                    html += "</tr>";
                    counter++;
                });
                $("#tbl_allPriceLists tbody").html(html);
            }
        })
    }
    function save_priceList()
    {
        if(validatePriceListForm())
        {
            var priceListID = $(".priceList_id").val();
            $.ajax({
                type: 'post',
                url: 'api.php?action=save_priceList',
                data: $(".priceListForm").serialize(),
                success: function(response)
                {
                    if(!response.success)
                    {
                       $("#priceListName").addClass('has-error');
                       $(".errorMessages").html("*"+response.message);
                    }
                    else
                    {
                        $("#priceListModal").fadeOut(100);
                        if(priceListID !== "")
                        {
                            currentRow.find("td").eq(1).html($(".priceListForm").find("#priceListName").val());
                            currentRow.find("td").eq(2).html($(".priceListForm").find("#rule").val());
                            currentRow.find("td").eq(3).html($(".priceListForm").find("#type").val());
                            currentRow.find("td").eq(4).html($(".priceListForm").find("#priceAdjustment").val());
                        }
                        else
                        {
                            show_allPriceList();
                        }
                        resetPriceListForm();
                    }
                }
            })
        }
    }
    function resetPriceListForm()
    {
        $("#priceListModal input").val("");
        $("#priceListModal *").removeClass('has-error');
    }
    function validatePriceListForm()
    {
        var pricelist = $("#priceListName").val().trim() !== "";
        var priceAdjustment = $("#priceAdjustment").val().trim() !== "";
        if(pricelist || priceAdjustment) return true;
        else
        {
            $("#priceListName").addClass('has-error');
            $("#priceAdjustment").addClass('has-error');
        }
    }
    $(document).on("click", "#priceListModal #close-modal", function(e){
        e.preventDefault();
        $("#priceListModal").fadeOut(100);
        resetPriceListForm();
    })
    $(document).on("keydown", "#priceListModal", function(e){
        if(e.key == "Enter")
        {
            e.preventDefault();
            save_priceList();
        }
    })
</script>