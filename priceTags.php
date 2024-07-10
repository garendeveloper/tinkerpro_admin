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

  include('./modals/loading-modal.php');
  // include ('./modals/pricetagsModal.php'); 
?>

<style>
	.rangeslider,
.rangeslider__fill {
  background: #e6e6e6;
  display: block;
  height: 10px;
  width: 100%;
  -webkit-box-shadow: inset 0px 1px 3px rgba(0, 0, 0, 0.15);
  -moz-box-shadow: inset 0px 1px 3px rgba(0, 0, 0, 0.15);
  box-shadow: inset 0px 1px 3px rgba(0, 0, 0, 0.15);
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  -ms-border-radius: 5px;
  -o-border-radius: 5px;
  border-radius: 5px;
}

.rangeslider {
  position: relative;
  margin-bottom:20px;
}

.rangeslider--disabled {
  filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=40);
  opacity: 0.4;
}

.rangeslider__fill {
  background: #3BB2D6;
  position: absolute;
  top: 0;
}

.rangeslider__handle {
  background: white;
  border: 1px solid #ccc;
  cursor: pointer;
  display: inline-block;
  width: 20px;
  height: 20px;
  position: absolute;
  top: -5px;
  background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, rgba(255, 255, 255, 0)), color-stop(100%, rgba(0, 0, 0, 0.1)));
  background-image: -webkit-linear-gradient(rgba(255, 255, 255, 0), rgba(0, 0, 0, 0.1));
  background-image: -moz-linear-gradient(rgba(255, 255, 255, 0), rgba(0, 0, 0, 0.1));
  background-image: -o-linear-gradient(rgba(255, 255, 255, 0), rgba(0, 0, 0, 0.1));
  background-image: linear-gradient(rgba(255, 255, 255, 0), rgba(0, 0, 0, 0.1));
  -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: 0 0 8px rgba(0, 0, 0, 0.3);
  box-shadow: 0 0 8px rgba(0, 0, 0, 0.3);
  -webkit-border-radius: 50%;
  -moz-border-radius: 50%;
  -ms-border-radius: 50%;
  -o-border-radius: 50%;
  border-radius: 50%;
}
.rangeslider__handle:after {
  content: "";
  display: block;
  width: 9px;
  height: 9px;
  margin: auto;
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, rgba(0, 0, 0, 0.13)), color-stop(100%, rgba(255, 255, 255, 0)));
  background-image: -webkit-linear-gradient(rgba(0, 0, 0, 0.13), rgba(255, 255, 255, 0));
  background-image: -moz-linear-gradient(rgba(0, 0, 0, 0.13), rgba(255, 255, 255, 0));
  background-image: -o-linear-gradient(rgba(0, 0, 0, 0.13), rgba(255, 255, 255, 0));
  background-image: linear-gradient(rgba(0, 0, 0, 0.13), rgba(255, 255, 255, 0));
  -webkit-border-radius: 50%;
  -moz-border-radius: 50%;
  -ms-border-radius: 50%;
  -o-border-radius: 50%;
  border-radius: 50%;
}
.rangeslider__handle:active {
  background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, rgba(0, 0, 0, 0.1)), color-stop(100%, rgba(0, 0, 0, 0.12)));
  background-image: -webkit-linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.12));
  background-image: -moz-linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.12));
  background-image: -o-linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.12));
  background-image: linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.12));
}

input[type="range"]:focus + .rangeslider .rangeslider__handle {
  -webkit-box-shadow: 0 0 8px rgba(255, 0, 255, 0.9);
  -moz-box-shadow: 0 0 8px rgba(255, 0, 255, 0.9);
  box-shadow: 0 0 8px rgba(255, 0, 255, 0.9);
}

	</style>
    <style>

#barcodeContainer{
    margin: 0 auto;
    -moz-border-radius: 5px;
    border-radius: 5px;
    /* box-shadow:0 1px 2px hsla(0, 0%, 0%, 0.3); */
    margin-top:0px;
    margin-bottom:50px;
    min-width:100px;
    width: 200px;
    padding-bottom: 20px;
    padding-top: 1px;
    display: inline-block;
}

.container{
  width: 300px;
  text-align: left;
}

@media (max-width: 800px) {
  #barcodeContainer{
    margin-top:0;
    margin-bottom:0;
    margin-left:0;
    margin-right:0;
    padding-left: 10px;
    padding-right: 10px;
    -moz-border-radius: 0px;
    border-radius: 0px;
    width: 100%;
    min-width:0px;
  }

  .container{
    width: 100%;
  }

  .github-banner{
    display: none;
  }
}

#userInput{
  height:35px;
}

#barcode{
    vertical-align: middle;
}

#title{
    margin-left: auto;
    margin-right: auto;
    text-align: left;
    line-height: 90%;
    color: white;
}

#title a:link{
    text-decoration: none;
    color: #ffff;
}

#title a:visited {
    text-decoration: none;
    color: #ffff;
}

#title a:hover {
    text-decoration: underline;
    color: #ffff;
}

#title a:active {
    text-decoration: underline;
    color: #ffff;
}

#invalid{
    display: none;
    color:#DE0000;
    margin-top:10px;
    font-size:14pt;
    vertical-align: middle;
}

#barcodeType{
  height:35px;
}

.barcode-container{
  height:200px;
  line-height: 200px;
  text-align: center;
  vertical-align: middle;
  margin-left: 25px;
  margin-right: 25px;
}

.description-text{
  height:42px;
  color: #ffff;      
}

.description-text p{
  position: relative;
  top: 50%;
  -webkit-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
}

.value-text{
  height:42px;
  text-align: right;
}

.value-text p{
  position: relative;
  top: 50%;
  -webkit-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
}

.center-text{
  text-align: center;
}

.search-bar{
  margin-bottom: 20px;
}

.slider-container{
  margin-top: 17px;
  width: 100px;
}

.input-container{
  margin-top: 5px;
  width: 200px;
}

.barcode-select{
  border-color: #ccc;
}
body{
  font-family: 'Century Gothic', sans-serif;
}

.not_scrollable {
  position: fixed;
}
.fcontainer {
    display: flex;
    flex-direction: column;
    position: relative;
}
.fieldContainer {
      margin-top: 8px;
      margin-left: 10px;
      margin-right: 10px;
      color: white;
   
  }
  .fieldContainer {
      display: flex;
      align-items: center;
  }
  
  .fieldContainer label {
      margin-right: 10px;
  }
  
  .fieldContainer input[type="text"],
  .fieldContainer input[type="date"],
  .fieldContainer .switch {
      margin-right: 10px;
  }
  .tableCard{
    border-radius: 0;
    width: 100%;
    max-width: 800px;  
    height: 100%;
    margin-top: 0px;
    margin-bottom: 15px;
    height: 85vh;
    background-color: #151515;
  }
  table thead th{
    font-size: 14px;
  }
  tbody {
    display: block;
    overflow: auto;
    border: 1px solid #151515;
}
thead, tbody tr {
    display: table;
    width: 100%;
    table-layout: fixed;
    height: 1px;
}
tbody td {
    /* border: 1px solid #dddddd;  */
    border: 1px solid #151515;
    padding: 5px 5px; 
    height: 2px; 
    line-height:1;
}


input{
  font-family: Century Gothic;
}

.mainDiv {
    background: #151515;
    padding: 5px;
    margin-top: 0px;
    height: 85vh;
    text-align: justify;
    display: flex;
    flex-direction: column;
    margin: 0px auto;
}

.mainDiv .row {
    margin-bottom: 20px;
    overflow: hidden;
}

label {
    margin: 5px;
    color: lightgrey;
}

h4 {
    margin-bottom: 10px;
    color: white
}

.input_box {
    padding: 10px;
    border: none;
    background-color: white;
    width: 100%;
    margin-top: 5px;
}

.button {
    background-color: grey;
    padding: 10px 40px;
    color: white;
    border: none;
}
.print_output{
  margin-top: 10px;
}
#productInfo{
  font-size:9px;
}
.title{
  color: #ffff;
}


#barcode-container {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.barcode-container {
  display: inline-block;
  position: relative;
  padding: 10px; /* Adjust padding as necessary */
  font-family: Century Gothic;
  margin-bottom: 2mm; /* Adjust spacing between rows */
  width: 30mm;
  height: 40mm;
  box-sizing: border-box;
}

.product-info {
  background-color: white;
  padding: 5px;
  font-size: 12px;
  line-height: 1.2;
  width: 200px;
  text-align: left;
}

.generated-barcode {
  display: block;
  margin: 0 auto;
  width: 200px;
  height: auto;
  margin-top: -10px;
}
@media print {
  /* styles for printing */
  @page {
        size: 40mm 297mm; /* Set width and height for thermal paper */
    }
  body * {
        visibility: hidden;
    }
     .printable-area, .printable-area * {
        visibility: visible;
    }
  .printable-area {
    width: 100%;
    margin: 0;
    padding: 0;
    margin-top:0px;
    top:0;
    left:0;
    font-size: 12pt;
    font-family: Arial, sans-serif;
  }
  .barcode-container {
    width: 30mm;
    height: 40mm;
    margin: 0 auto;
    padding: 10px;
    border: 1px solid #ccc;
  }
  .product-info {
    font-size: 10pt;
    margin-bottom: 2mm;
  }
  .generated-barcode {
    width: 100%;
    height: auto;
    margin-top: -1mm;
  }
}
    /* .printable-area, .printable-area * {
        visibility: visible;
    }
    .printable-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        padding: 0;
        border: none;
        display: block;
        clear: both; 
    }
    .barcode-container {
        margin-top: 2mm; 
        height: 30mm; 
        width: 40mm; 
        text-align: center;
        vertical-align: middle;
        margin-left: 0; 
        display: inline-block;
        clear: both; 
    }
    .product-info {
        background-color: white; 
        padding: 5px;
        font-size: 10px;
        line-height: 1.2;
        width: 80mm;
        text-align: left;
        box-sizing: border-box;
    }
    .generated-barcode {
        display: block;
        width: 100%; 
        height: auto; 
        margin-top: -1mm; 
    }
} */
</style>
<script>
		Number.prototype.zeroPadding = function(){
			var ret = "" + this.valueOf();
			return ret.length == 1 ? "0" + ret : ret;
		};
	</script>

<?php include "layout/admin/css.php"?> 
<?php include "layout/admin/barcodeassets.php"?> 
<style>
  body{
    font-family: "Century Gothic"
  }
</style>
  <div class="container-scroller">
    <?php include 'layout/admin/sidebar.php' ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row not_scrollable" style = "margin-bottom: 10px; margin-top: -20px;">
            <div class="col-md-12">
              <div id="title" class = "text-custom">
                <h1 style = "font-weight: bold">PRICE TAGS AND BARCODES</h1>

              </div>
            </div>
            <div class = "row">
                <div  style = "width:600px; background-color: #151515;">
                  <div class="mainDiv" style = "margin-left: 25px;">
                    <div class="tableCard" >
                        <div class="fcontainer"  >
                            <form id="priceTagForm" >
                                <div class="fieldContainer" style="margin-top: -3px;">
                                    <label style = "margin-left: -10px;"><img src="assets/img/barcode.png" style="color: white; height: 70px; width: 50px;"></label>
                                    <div class="search-container">
                                        <input type="hidden" id="searchInput_id" value="0">
                                        <input type="hidden" id="barcode_value" value = "0">
                                        <input type="hidden" id="product_name" value = "0">
                                        <input type="hidden" id="product_price" value = "0">
                                        <input type="hidden" id="sku" value = "0">
                                        <input type="hidden" id="uom" value = "0">
                                        <input type="text" style="width: 360px; height: 40px; font-size: 14px; border: 1px solid white;"
                                            class="search-input italic-placeholder" placeholder="Search Product,[Name, Barcode, Brand]" name="searchInput"
                                            onkeyup="$(this).removeClass('has-error')" id="searchInput" autocomplete="off">
                                          
                                    </div>
                                    <button style="font-size: 1.5rem; height: 40px; width: 230px; border-radius: 4px;" id="btn_searchInputProduct">
                                        Add Product</button>
                                </div>
                            </form>
                        
                            <table id="tbl_priceTags" class="text-color table-border " style="margin-top: -3px; border: none;">
                                <thead>
                                    <tr>
                                        <th class = "otherinput" style="background-color: #1E1C11; width: 80%; font-size: 12px;">ITEM DESCRIPTION</th>
                                        <th class = "otherinput" style="background-color: #1E1C11; text-align:left; width: 20%; font-size: 12px;">BARCODE</th>
                                    </tr>
                                </thead>
                                <tbody style="border-collapse: collapse; border: none">

                                </tbody>
                            </table>
                      </div> 
                    </div>
                  </div>
                </div>
                <div  style = "width: 1100px;" >
                  <div class="printable-area"  style = "width: 100%;  ">
                    <div class="row" id = "barcodeContainer" style = "margin-left: 20px;  ">
                 
                    </div>
                  </div>
                  <div style = "position: absolute; bottom: 0; right: 20px; margin-right: 4vh;">
                      <button class="button" style="width: 200px; background-color: #151515; border: 1px solid red; color: white; height: 40px; " id="btnPrintBarcode">Print Barcode</button>
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
?>
  <script>
  $(document).ready(function(){
    var toastDisplayed = false;
    var products = [];
    let productsCache = [];
    show_allProducts();

    $("#price_tags").addClass('active');
    $("#pointer").html("Price Tags");

    $("#btnPrintBarcode").off("click").on("click", function(){
      window.print();
    })
    $("#btn_searchInputProduct").click(function (e) {
        e.preventDefault();
        var inventory_id = $("#searchInput_id").val();
        var barcode = $("#barcode_value").val();
        var productPrice = $("#product_price").val();
        var productName = $("#product_name").val();
        var uom = $("#uom").val();
        var sku = $("#sku").val();
        if(inventory_id !== "" && inventory_id !== "0")
        {
            if (!isDataExistInTable(inventory_id)) 
            {
              display_productBy(inventory_id);
              generateBarcode(barcode, productName, productPrice, sku, uom);
            }
            else
            {
              show_errorResponse("Product is already in the table.");
            }
            $("#searchInput").val("");
            $("#searchInput_id").val("0");
            $("#barcode_value").val("0");
            $("#product_name").val("0");
            $("#product_value").val("0");
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
                        brand: data[i].brand,
                        prod_price: data[i].prod_price,
                        sku: data[i].sku,
                        uom: data[i].uom,
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
                    value: row.barcode ?? row.product,
                    id: row.product_id,
                    barcode: row.barcode,
                    productPrice: row.prod_price,
                    productName: row.product,
                    sku: row.sku,
                    uom: row.uom,
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

        function generateBarcode(barcode, productName, price, sku, uom) 
        {
          try {
              var barcodeContainer = $("<div>").addClass("barcode-container");

              var productInfoElement = $("<div>").addClass("product-info").css({
                  'margin-bottom': '2px'
              });

              productInfoElement.html(`
                  <div style = 'font-weight: bold'>${productName}&nbsp;${uom} <br></div>
                  <div>${price}</div>
                  <div>SKU:${sku}</div>
              `);

              var barcodeElement = $("<img>").addClass("generated-barcode");
              JsBarcode(barcodeElement[0], barcode, {
                  format: "EAN13",
                  displayValue: true,
                  fontSize: 20,
                  height: 40,
                  width: 2,
                  textAlign: "center"
              });

              barcodeContainer.append(productInfoElement);

              barcodeContainer.append(barcodeElement);

              $("#barcodeContainer").append(barcodeContainer);
          } catch (error) {
              console.error("Error in generateBarcode:", error);
          }
      }


      
        $("#searchInput").autocomplete({
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
                    var selectedBarcode = slicedProducts[slicedProductsLength].barcode;
                    var selectedProdPrice = slicedProducts[slicedProductsLength].productPrice;
                    var selectedProdName = slicedProducts[slicedProductsLength].productName;
                    var uom = slicedProducts[slicedProductsLength].uom;
                    var sku = slicedProducts[slicedProductsLength].sku;
                    $("#searchInput_id").val(selectedProductId);
                    $("#barcode_value").val(selectedBarcode);
                    $("#product_price").val(selectedProdPrice);
                    $("#product_name").val(selectedProdName);
                    $("#uom").val(uom);
                    $("#sku").val(sku);
                } else {
                    $('#filters').hide();
                }
            },
            select: function (event, ui) {
                var selectedProductId = ui.item.id;
                $("#searchInput_id").val(selectedProductId);
                var barcode = ui.item.barcode;
                var price = ui.item.productPrice;
                var productName = ui.item.productName;
                var sku = ui.item.sku;
                var uom = ui.item.uom;
                if(selectedProductId !== "" && selectedProductId !== "0")
                {
                    if (!isDataExistInTable(selectedProductId)) 
                    {
                        display_productBy(selectedProductId);
                        generateBarcode(barcode, productName, price, sku, uom);
                    }
                    else
                    {
                        show_errorResponse("Product is already in the table.");
                    }
                    $("#searchInput").val("");
                    $("#searchInput_id").val("0");
                    $("#barcode_value").val("0");
                    $("#product_name").val("0");
                    $("#product_value").val("0");
                    $("#sku").val("0");
                    $("#uom").val("0");
                }
                return false;
            },
        });
     
        function isDataExistInTable(data) 
        {
            var $matchingRow = $('#tbl_priceTags tbody td[data-id="' + data + '"]').closest('tr');
            return $matchingRow.length > 0;
        }
        function display_productBy(inventory_id) 
        {
            $.ajax({
                type: 'get',
                url: 'api.php?action=get_productInfo',
                data: { data: inventory_id },
                success: function (data) {
                    var row = "";
                    row += "<tr data-id = " + data['id'] + ">";
                    row += "<td style= 'width: 80%' data-id = " + data['id'] + ">" + data['prod_desc'] + "</td>";
                    row += "<td style= 'width: 20%'>" + data['barcode'] + "</td>";
                    row += "</tr>";
                    $("#tbl_priceTags tbody").append(row);
                }
            })
        }

    $("#priceTagsModal").addClass('slideInRight');
    $(".priceTagsContent").addClass('slideInRight');
    setTimeout(function () {
      $("#priceTagsModal").show();
      $(".priceTagsContent").show();
    }, 100);
  })
</script>