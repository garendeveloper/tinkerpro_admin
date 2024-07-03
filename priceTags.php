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
    box-shadow:0 1px 2px hsla(0, 0%, 0%, 0.3);
    margin-top:0px;
    margin-bottom:50px;
    min-width:100px;
    width: 200px;
    padding-bottom: 20px;
    padding-top: 1px;
    display: inline-block;
    background-color: #151515;
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
    margin-top: 15px;
    margin-bottom: 15px;
    height: 85vh;
    background-color: #151515;
  }
  table thead th{
    font-size: 14px;
  }

.printable-area{
  width: 100%;
  height: 100%;
  display: block;
}
input{
  font-family: Century Gothic;
}
@media print {
  .printable-area {
    display: block !important; 
  }
  .no-print {
    display: none; 
  }
}

.mainDiv {
            background: green;
            font-family: Arial;
            padding: 25px;
            max-height: 73s0px;
            width: 300px;
            text-align: justify;
            display: flex;
            flex-direction: column;
            margin: 20px auto;
        }
 
        .mainDiv .row {
            margin-bottom: 20px;
            overflow: hidden;
        }
 
        label {
            margin: 5px;
            color: lightgrey;
        }
 
        h2 {
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
</style>

<?php include "layout/admin/css.php"?> 
<?php include "layout/admin/barcodeassets.php"?> 
  <div class="container-scroller">
    <?php include 'layout/admin/sidebar.php' ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row not_scrollable" style = "margin-bottom: 20px;">
            <div class="col-md-12">
              <div id="title" class = "text-custom">
                <h1>PRICE TAGS AND BARCODES</h1>

              </div>
            </div>
            <div class = "row">
                <div class="col-md-4" style = "width: 33.33%">
                  <div class="mainDiv">
                    <div class="row">
                        <label>Type The Text</label>
                        <br />
                        <input type="text"
                              id="textValue"
                              value="92312342432"
                              class="input_box">
                    </div>
                    <div class="row">
                        <div>
                            <h2>Choose Barcode Type:</h2>
                            <input type="radio"
                                  name="barcodeType"
                                  value="ean8"
                                  checked="checked">
                            <label>EAN 8</label>
                            <br />
                            <input type="radio"
                                  name="barcodeType"
                                  value="ean13">
                            <label>EAN 13</label>
                            <br />
                            <input type="radio"
                                  name="barcodeType"
                                  value="datamatrix">
                            <label>Data Matrix (2D barcode)</label>
                            <br />
                            <input type="radio"
                                  name="barcodeType"
                                  value="upc">
                            <label>UPC</label>
                            <br />
                            <input type="radio"
                                  name="barcodeType"
                                  value="code11">
                            <label>code 11</label>
                            <br />
                            <input type="radio"
                                  name="barcodeType"
                                  value="code39">
                            <label>code 39</label>
                            <br />
                            <input type="radio"
                                  name="barcodeType"
                                  value="code93">
                            <label>code 93</label>
                            <br />
                            <input type="radio"
                                  name="barcodeType"
                                  value="code128">
                            <label>code 128</label>
                            <br />
                            <input type="radio"
                                  name="barcodeType"
                                  value="codabar">
                            <label>codabar</label>
                            <br />
                            <input type="radio"
                                  name="barcodeType"
                                  value="std25">
                            <label>standard 2 of 5 (industrial)</label>
                            <br />
                            <input type="radio"
                                  name="barcodeType"
                                  value="int25">
                            <label>interleaved 2 of 5</label>
                            <br />
                            <input type="radio"
                                  name="barcodeType"
                                  value="msi">
                            <label>MSI</label>
                            <br />
                        </div>
                        <div>
                            <h2>Choose Barcode Format</h2>
                            <input type="radio"
                                  name="rendererType"
                                  value="css"
                                  checked="checked">
                            <label>CSS</label>
                            <br />
                            <input type="radio"
                                  name="rendererType"
                                  value="canvas">
                            <label>Canvas</label>
                            <br />
                            <input type="radio"
                                  name="rendererType"
                                  value="bmp">
                            <label>BMP</label>
                            <br />
                            <input type="radio"
                                  name="rendererType"
                                  value="svg">
                            <label>SVG</label>
                            <br />
                        </div>
                    </div>
                    <div class="row">
                        <input type="button"
                        id = "generate_barcode"
                              value="Generate the barcode"
                              class="button">
                    </div>
                  
                </div>

                  
                </div>
                <div class="col-md-4" style = "width: 33.33%">
                  <div class="printable-area" width = "950px" style = "width: 900px;">
                    <div class="row">
                        <div id="barcodeoutput"></div>
                        <canvas id="canvasOutput"
                                width="200"
                                height="130"></canvas>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 "style = "width: 30%; height: 100%;" >
                  <div class="tableCard">
                      <div class="fcontainer"  >
                          <form id="priceTagForm" >
                              <div class="fieldContainer" style="margin-top: -3px;">
                                  <label><img src="assets/img/barcode.png" style="color: white; height: 50px; width: 50px;"></label>
                                  <div class="search-container">
                                      <input type="hidden" id="searchInput_id" value="0">
                                      <input type="hidden" id="barcode_value" value = "0">
                                      <input type="text" style="width: 300px; height: 30px; font-size: 14px; border: 1px solid white;"
                                          class="search-input italic-placeholder" placeholder="Search Product,[Name, Barcode, Brand]" name="searchInput"
                                          onkeyup="$(this).removeClass('has-error')" id="searchInput" autocomplete="off">
                                        
                                  </div>
                                  <button style="font-size: 12px; height: 30px; width: 160px; border-radius: 4px;" id="btn_searchInputProduct">
                                      Add Product</button>
                              </div>
                          </form>
                          <table id="tbl_priceTags" class="text-color table-border " style="margin-top: -3px; ">
                              <thead>
                                  <tr>
                                      <th style="background-color: #1E1C11; width: 50%; font-size: 12px;">ITEM DESCRIPTION</th>
                                      <th style="background-color: #1E1C11; text-align:center; width: 50%; font-size: 12px;">BARCODE</th>
                                  </tr>
                              </thead>
                              <tbody style="border-collapse: collapse; border: none">

                              </tbody>
                          </table>
                      </div>
                    </div>
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
    $(document).ready(function () {
        
        var toastDisplayed = false;
        var products = [];
        let productsCache = [];
        show_allProducts();

        function generateBarcode(inputValue) 
        {
          let barcodeType = $("input[name=barcodeType]:checked").val();
          let rendererType = $("input[name=rendererType]:checked").val();

          let settings = {
              output: rendererType,
              bgColor: '#FFFFFF',
              color: '#000000',
              barWidth: '1.5',
              barHeight: '70',
              moduleSize: '5',
              posX: '15',
              posY: '30',
              addQuietZone: '1'
          };

          if (rendererType != 'canvas') {
              $("#canvasOutput").hide();
              $("#barcodeoutput").html("").show();
              $("#barcodeoutput").barcode(inputValue,
                  barcodeType,
                  settings);
          } else {
              createCanvas();
              $("#barcodeoutput").hide();
              $("#canvasOutput").show();
              $("#canvasOutput").barcode(inputValue,
                  barcodeType,
                  settings);
          }
          }

          // Function to clear canvas.
          function createCanvas() {

          let canvas = $('#canvasOutput').get(0);
          let ctx = canvas.getContext('2d');
          ctx.clearRect(0, 0, canvas.width, canvas.height);
          ctx.strokeRect(0, 0, canvas.width, canvas.height);
          }


        $("#btn_searchInputProduct").click(function (e) {
            e.preventDefault();
            var inventory_id = $("#searchInput_id").val();
            var barcode = $("#barcode_value").val();
            if(inventory_id !== "" && inventory_id !== "0")
            {
                if (!isDataExistInTable(inventory_id)) 
                {
                    display_productBy(inventory_id);
                    generateBarcode(barcode);
                }
                else
                {
                    show_errorResponse("Product is already in the table.");
                }
                $("#searchInput").val("");
                $("#searchInput_id").val("0");
                $("#barcode_value").val("0");
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
                    barcode: row.barcode
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
                    $("#searchInput_id").val(selectedProductId);
                    $("#barcode_value").val(selectedBarcode);
                } else {
                    $('#filters').hide();
                }
            },
            select: function (event, ui) {
                var selectedProductId = ui.item.id;
                $("#searchInput_id").val(selectedProductId);
                var barcode = ui.item.barcode;
                if(selectedProductId !== "" && selectedProductId !== "0")
                {
                    if (!isDataExistInTable(selectedProductId)) 
                    {
                        display_productBy(selectedProductId);
                        generateBarcode(barcode);
                    }
                    else
                    {
                        show_errorResponse("Product is already in the table.");
                    }
                    $("#searchInput_id").val("0");
                    $("#searchInput").val("");
                    $("#barcode_value").val("0");
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
                    row += "<td data-id = " + data['id'] + ">" + data['prod_desc'] + "</td>";
                    row += "<td style = 'text-align:center'>" + data['barcode'] + "</td>";
                    row += "</tr>";
                    $("#tbl_priceTags tbody").append(row);
                }
            })
        }
    })
</script>
<script>
  $(document).ready(function(){
    $("#price_tags").addClass('active');
    $("#pointer").html("Price Tags");

    $("#priceTagsModal").addClass('slideInRight');
    $(".priceTagsContent").addClass('slideInRight');
    setTimeout(function () {
      $("#priceTagsModal").show();
      $(".priceTagsContent").show();
    }, 100);
  })
</script>