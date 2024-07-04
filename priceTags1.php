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
  include ('./modals/pricetagsModal.php'); 
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
  height:30px;

  color: #ffff;      
}

.description-text p{
  position: relative;
  font-size: 14px;
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

</style>
<style>
.previewContainer {
  display: grid;
  grid-template-columns: 400px 500px auto 30px;
  gap: 10px;
  background-color: #262626;
  padding: 10px;
}

.previewContainer > div {
  background-color: none;
  text-align: center;
  padding:15px 0;
  font-size: 30px;
}
.search-input{
  font-size: 16px;
  height: 30px;
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
              <div id="title">
                <h1>PRICE TAGS AND BARCODES</h1>

              </div>
            </div>
          </div>
          
          <div class="previewContainer" style = "margin-top: 20px;">
            <div style = " " class = "">
              <div id="" style = "">
                <div class="container">
                  <div class="row search-bar">
                    <div class="col-md-3 col-md-offset-2">
                      <div class="input-group margin-bottom-sm">
                        <span class="input-group-addon"><i class="fa fa-barcode fa-fw" hidden></i></span>
                        <input class="form-control" id="userInput" type="text" value="Example 1234" placeholder="Barcode" hidden autofocus>
                        <span class="input-group-btn">
                          <select class="btn barcode-select" id="barcodeType" title="CODE128">
                            <option value="CODE128">CODE128 auto</option>
                            <option value="CODE128A">CODE128 A</option>
                            <option value="CODE128B">CODE128 B</option>
                            <option value="CODE128C">CODE128 C</option>
                            <option value="EAN13">EAN13</option>
                            <option value="EAN8">EAN8</option>
                            <option value="UPC">UPC</option>
                            <option value="CODE39">CODE39</option>
                            <option value="ITF14">ITF14</option>
                            <option value="ITF">ITF</option>
                            <option value="MSI">MSI</option>
                            <option value="MSI10">MSI10</option>
                            <option value="MSI11">MSI11</option>
                            <option value="MSI1010">MSI1010</option>
                            <option value="MSI1110">MSI1110</option>
                            <option value="pharmacode">Pharmacode</option>
                          </select>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="description-text"><p>Bar Width</p></div>
                    <div class="  slider-container"><input id="bar-width" type="range" min="1" max="4" step="1" value="2"/></div>
                    <div class="col-md-1   value-text"><p><span id="bar-width-display"></span></p></div>
                  </div>
                  <!-- Height -->
                  <div class="row">
                    <div class="description-text"><p>Height</p></div>
                    <div class="  slider-container"><input id="bar-height" type="range" min="10" max="150" step="5" value="100"/></div>
                    <div class="col-md-1  value-text"><p><span id="bar-height-display"></span></p></div>
                  </div>
                  <!-- Margin -->
                  <div class="row">
                    <div class="description-text"><p>Margin</p></div>
                    <div class=" slider-container"><input id="bar-margin" type="range" min="0" max="25" step="1" value="10"/></div>
                    <div class="col-md-1  value-text"><p><span id="bar-margin-display"></span></p></div>
                  </div>
                  <!-- Background (color) -->
                  <div class="row">
                    <div class="description-text"><p>Background</p></div>
                    <div class=" input-container"><input id="background-color" class="search-input color" value="#FFFFFF"/></div>
                    <div class="col-md-1  value-text"></div>
                  </div>
                  <!-- Line color -->
                  <div class="row">
                    <div class="description-text"><p>Line Color</p></div>
                    <div class="  input-container"><input id="line-color" class="search-input color" value="#ffff000"/></div>
                    <div class=" value-text"></div>
                  </div>
                  <!-- Show text -->
                  <div class="row checkbox-options">
                    <div class="description-text"><p>Show text</p></div>
                    <div class="center-text">
                      <div class="col-md-2 btn-group btn-group-md" role="toolbar">
                        <button type="button" class="btn btn-default btn-sm btn-primary display-text" value="true">Show</button>
                        <button type="button" class="btn btn-default btn-sm display-text" value="false">Hide</button>
                      </div>
                    </div>
                    <div class="col-md-1"></div>
                  </div>
                  <div id="font-options">
                    <!-- Text align -->
                    <div class="checkbox-options">
                      <div class="description-text"><p>Text Align</p></div>
                      <div class=" center-text">
                        <div class="col-md-2 btn-group btn-group-md " role="toolbar" style = "">
                          <button type="button" class="btn btn-default btn-sm text-align" value="left">Left</button>
                          <button type="button" class="btn btn-default btn-sm btn-primary text-align" value="center">Center</button>
                          <button type="button" class="btn btn-default btn-sm text-align" value="right">Right</button>
                        </div>
                      </div>
                      <div class="col-md-1"></div>
                    </div>
                    <!-- Font -->
                    <div class="row">
                      <div class="description-text"><p>Font</p></div>
                      <div class=" center-text">
                        <select class="col-md-1" id="font" style="font-family: monospace">
                          <option value="monospace" style="font-family: monospace" selected="selected">Monospace</option>
                          <option value="sans-serif" style="font-family: sans-serif">Sans-serif</option>
                          <option value="serif" style="font-family: serif">Serif</option>
                          <option value="fantasy" style="font-family: fantasy">Fantasy</option>
                          <option value="cursive" style="font-family: cursive">Cursive</option>
                        </select>
                      </div>
                      <div class="col-md-1"></div>
                    </div>
                    <!-- Font options -->
                    <div class="checkbox-options">
                      <div class="description-text"><p>Font Options</p></div>
                      <div class=" center-text">
                        <div class="col-md-1 btn-group btn-group-md" role="toolbar">
                          <button type="button" class="btn btn-default btn-sm " value="bold" style="font-weight: bold">Bold</button>
                          <button type="button" class="btn btn-default btn-sm " value="italic" style="font-style: italic">Italic</button>
                        </div>
                      </div>
                      <div class="col-md-1"></div>
                    </div>
                    <!-- Font size -->
                    <div class="row">
                      <div class="description-text"><p>Font Size</p></div>
                      <div class=" slider-container"><input id="bar-fontSize" type="range" min="8" max="36" step="1" value="20"/></div>
                      <div class="col-md-1 value-text"><p><span id="bar-fontSize-display"></span></p></div>
                    </div>
                    <!-- Text margin -->
                    <div class="row">
                      <div class="description-text"><p>Text Margin</p></div>
                      <div class="slider-container"><input id="bar-text-margin" type="range" min="-15" max="40" step="1" value="0"/></div>
                      <div class="col-md-1 value-text"><p><span id="bar-text-margin-display"></span></p></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div style = "">
              <div class="barcode-container">
                  <svg id="barcode"></svg>
                  <span id="invalid">Not valid data for this barcode type!</span>
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
	var defaultValues = {
    CODE128 : $("#priceTag").val(),
    CODE128A : "EXAMPLE",
    CODE128B : "Example text",
    CODE128C : "12345678",
    EAN13 : "1234567890128",
    EAN8 : "12345670",
    UPC : "123456789999",
    CODE39 : "EXAMPLE TEXT",
    ITF14 : "10012345000017",
    ITF : "123456",
    MSI : "123456",
    MSI10 : "123456",
    MSI11 : "123456",
    MSI1010 : "123456",
    MSI1110 : "123456",
    pharmacode : "1234"
};

$(document).ready(function(){
    $("#userInput").on('input',newBarcode);
    $("#barcodeType").change(function(){
        $("#userInput").val($("#priceTag").val());
        newBarcode();
        
    });

    $(".text-align").click(function(){
      $(".text-align").removeClass("btn-primary");
      $(this).addClass("btn-primary");

      newBarcode();
    });

    $(".font-option").click(function(){
      if($(this).hasClass("btn-primary")){
        $(this).removeClass("btn-primary");
      }
      else{
        $(this).addClass("btn-primary");
      }

      newBarcode();
    });

    $(".display-text").click(function(){
      $(".display-text").removeClass("btn-primary");
      $(this).addClass("btn-primary");

      if($(this).val() == "true"){
        $("#font-options").slideDown("fast");
      }
      else{
        $("#font-options").slideUp("fast");
      }

      newBarcode();
    });

    $("#font").change(function(){
      $(this).css({"font-family": $(this).val()});
      newBarcode();
    });

    $('input[type="range"]').rangeslider({
        polyfill: false,
        rangeClass: 'rangeslider',
        fillClass: 'rangeslider__fill',
        handleClass: 'rangeslider__handle',
        onSlide: newBarcode,
        onSlideEnd: newBarcode
    });

    $('.color').colorPicker({renderCallback: newBarcode});

    newBarcode();
});

var newBarcode = function() {
    $("#barcode").JsBarcode(
        $("#userInput").val(),
        {
          "format": $("#barcodeType").val(),
          "background": $("#background-color").val(),
          "lineColor": $("#line-color").val(),
          "fontSize": parseInt($("#bar-fontSize").val()),
          "height": parseInt($("#bar-height").val()),
          "width": $("#bar-width").val(),
          "margin": parseInt($("#bar-margin").val()),
          "textMargin": parseInt($("#bar-text-margin").val()),
          "displayValue": $(".display-text.btn-primary").val() == "true",
          "font": $("#font").val(),
          "fontOptions": $(".font-option.btn-primary").map(function(){return this.value;}).get().join(" "),
          "textAlign": $(".text-align.btn-primary").val(),
          "valid":
            function(valid){
              if(valid){
                $("#barcode").show();
                $("#invalid").hide();
              }
              else{
                $("#barcode").hide();
                $("#invalid").show();
              }
            }
        });

    $("#bar-width-display").text($("#bar-width").val());
    $("#bar-height-display").text($("#bar-height").val());
    $("#bar-fontSize-display").text($("#bar-fontSize").val());
    $("#bar-margin-display").text($("#bar-margin").val());
    $("#bar-text-margin-display").text($("#bar-text-margin").val());
};

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