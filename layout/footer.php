<?php include ("./layout/admin/expiration.php") ?>
<?php include ("./layout/admin/unpaid_orders_expiration.php") ?>
<?php include ("./modals/admin/add-products-modal.php") ?>
<?php include ("./modals/alertModal.php") ?>
<?php include ("./modals/permissionModal.php") ?>
<?php include ("./modals/access_granted.php") ?>
<?php include ("./modals/access_denied.php") ?>
<?php include ("./modals/logoutModal.php"); 
      include ("./modals/relogin.php");
?>


<?php


$userId = 0;
$firstName = "";
$lastName = "";

if (isset($_SESSION["user_id"])) {
    $userId = $_SESSION["user_id"];
}
if (isset($_SESSION["first_name"])) {
    $firstName = $_SESSION["first_name"];
}
if (isset($_SESSION["last_name"])) {
    $lastName = $_SESSION["last_name"];
}


if ($userId == 0) {
    header("Location: login");
}

$success = [];
$info = [];

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


<script>

document.documentElement.style.setProperty('--primary-color', localStorage.colorPallete);

$(document).ready(function() {


  $('.highlight').css('background-color', localStorage.colorPallete)
  $(".sidebar nav ul li").css("--hover-bg-color", localStorage.colorPallete)
  $(".pos-setting").css("--hover-bg-color", localStorage.colorPallete)
  $(".pos-setting").css("--active-bg-color", localStorage.colorPallete)

  $(".purchase-grid-item").css("--hover-bg-color", localStorage.colorPallete)
  $(".purchase-grid-item").css("--active-bg-color", localStorage.colorPallete)
  $("button").css("--hover-bg-color", localStorage.colorPallete)
  $("button").css("--active-bg-color", localStorage.colorPallete)
  // $("button").css("border-color", localStorage.colorPallete)

  $(".pos-setting:active").css("background-color", localStorage.colorPallete);
  // $(".inventoryCard table thead tr th").css("background-color", "#292928");
  // $(".inventoryCard table th").css("background-color", "#292928");

  $(".productHeader tr th").css({
    'border-color': '#292928',
    'color': localStorage.colorPallete
  });


  // $("table tr").css("--active-bg-color", localStorage.colorPallete)
  // $("table thead tr th").css("background-color", '');
  // $("table th").css("background-color", '');


  $(".font-size").css('color', localStorage.colorPallete)

  // $("table th").css("color", "#ffffff");
  $("table thead").css("border-color", localStorage.colorPallete);
  // $("table").css("border-color", localStorage.colorPallete);
  $("#pointer").css("color", localStorage.colorPallete);
  $(".text-custom").css('color', localStorage.colorPallete);
  $("span:not(.dynamic-color)").css('color', localStorage.colorPallete);
  $(".dt-column-title").css('color', "#FFFFF");
  $(".title_div").css('color', localStorage.colorPallete);
  $(".title_div span").css('color', "#FFFFF");
  $(".otherinput").css('background-color', "#262626");
  $(".otherinput").css('border', "1px solid "+localStorage.colorPallete);
  $(".inputGray").css('background-color', "#7C7C7C");
  $(".inputGray").css('border', "1px solid "+localStorage.colorPallete);
  $(".th-noborder").css('border', 'none')
  $(".highlighted").css("--hover-bg-color", localStorage.colorPallete)

    
    $('#toggle-sidebar').click(function() {
        $('#sidebar').toggleClass('collapsed');
        $('.main-panel').toggleClass('expanded');
        if ($('#sidebar').hasClass('collapsed')) {
            $('#toggle-sidebar').find('i').removeClass('bi-chevron-double-left').addClass('bi-chevron-double-right');
        } else {
            $('#toggle-sidebar').find('i').removeClass('bi-chevron-double-right').addClass('bi-chevron-double-left');
        }
    });
    display_settings();
    function display_settings()
    {
      $.ajax({
        type: 'get',
        url: 'api.php?action=pos_settings',
        success:function(response){
          var defaultColor = "var(--primary-color)";

          
          if(!$.isEmptyObject(response))
          {
            localStorage.setItem('colorPallete', response);
          }
          else
          {
            $(".sidebar nav ul li").css("--hover-bg-color", defaultColor)
            $(".pos-setting").css("--hover-bg-color", defaultColor)
            $(".pos-setting").css("--active-bg-color", defaultColor)
          
            $(".purchase-grid-item").css("--hover-bg-color", defaultColor)
            $(".purchase-grid-item").css("--active-bg-color", defaultColor)
            $("button").css("--hover-bg-color", defaultColor)
            $("button").css("--active-bg-color", defaultColor)
            $("button").css("border-color", defaultColor)

            $(".pos-setting:active").css("background-color", defaultColor);
            $(".inventoryCard table thead tr th").css("background-color", defaultColor);
            $(".inventoryCard table th").css("background-color", defaultColor);

            $("table thead tr th").css("background-color", defaultColor);
            $("table th").css("background-color", defaultColor);
            $("table th").css("color", "#ffffff");
            $("table thead").css("border-color", defaultColor);
            $("table").css("border-color", defaultColor);
            $(".text-custom").css('color', defaultColor);
            $("span:not(.dynamic-color)").css('color', defaultColor);
            $("span:not(th)").css('color', defaultColor);

          }
        }
      })
    }
  });
  $(document).ready(function () {
    $("#btn_logout").click(function () {
      $("#logoutModal").slideDown({
        backdrop: 'static',
        keyboard: false
      });
    })
   
    $("#r_close").click(function () {
      $("#response_modal").hide();
    })
  })
let deleteValidation = "false";
  function clearImageProduct() {
    deleteValidation = "true"
    var fileInput = document.getElementById('fileInputs');
    fileInput.value = '';
    if(fileInput.value == ''){
        displayImage(defaultImageUrl);
    }
}


  function showPaginationBtn(table){
    $.ajax({
        url: './fetch-data/pagination-data.php', 
        type: 'GET',
        data: {pageType : table},
        success: function(response) {
            $('.paginactionClass').html(response)
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText); 
        }
    });
  }



  function addProduct() {
    //products
    var productname = document.getElementById('productname').value;
    var sku = document.getElementById('skunNumber').value;
    var code = document.getElementById('code').value;
    var barcode = document.getElementById('barcode').value;
    var oum_id = document.getElementById('uomID').value;
    var brand = document.getElementById('brand').value;
    var cost = document.getElementById('cost').value;
    var markup = document.getElementById('markup').value;
    var sellingPrice = document.getElementById('selling_price').value
    //discount
    var discountCheckbox = document.getElementById('discountToggle');
    var discount = discountCheckbox.checked ? 1 : 0;
    //vat
    var vatCheckbox = document.getElementById('taxVatToggle');
    var vat = vatCheckbox.checked ? 1 : 0;
    var displayTax = document.getElementById('showIncludesTaxVatToggle');
    var display_tax = displayTax.checked ? 1 : 0;

    //service Charge
    var serviceCharge = document.getElementById('serviceChargesToggle');
    var service_charge = serviceCharge.checked ? 1 : 0;
    var displaySrvCharge = document.getElementById('displayServiceChargeReceipt');
    var display_service_charge = displaySrvCharge.checked ? 1 : 0;

    //other charges
    var otherCharges = document.getElementById('otherChargesToggle');
    var other_charges = otherCharges.checked ? 1 : 0;
    var displayOtherCharges = document.getElementById('displayReceipt');
    var display_other_charges = displayOtherCharges.checked ? 1 : 0;

    //status
    var stat = document.getElementById('statusValue');
    var status = stat.checked ? 1 : 0;

    //productImage
    var file = document.getElementById("fileInputs").files[0];
    var description = document.getElementById('description').value

    //warranty
    var warranty = document.getElementById('warrantyToggle');
    var warrant = warranty.checked ? 1 : 0;
    //stockable
    var stockable = document.getElementById('stockeableToggle');
    var stckble = stockable.checked ? 1 : 0;

    //category details
    var catID = document.getElementById('catID').value ?? null;
    var varID = document.getElementById('varID').value ?? null;
    var productLbl = document.getElementById('productLbl').value !== null ? document.getElementById('productLbl').value : "Product";
    var cat_lbl = document.getElementById('cat_Lbl').value ?? null;
    var var_lbl = document.getElementById('var_Lbl').value ?? null
    var jsonData = [{
      "productLbl": productLbl,
      "catLbl": cat_lbl,
      "varLbl": var_lbl
    }];
    var jsonString = JSON.stringify(jsonData);

    var nameLabel = document.querySelector('.nameTd');
    var barcodeLabel = document.querySelector('.barcodeTd');
    var costLabel = document.querySelector('.costTd');
    var markupLabel = document.querySelector('.markupTd');

    productname ? nameLabel.style.color = '' : nameLabel.style.color = 'red';
    barcode ? barcodeLabel.style.color = '' : barcodeLabel.style.color = 'red';
    cost ? costLabel.style.color = '' : costLabel.style.color = 'red';
    markup ? markupLabel.style.color = '' : markupLabel.style.color = 'red';

    var existingData = JSON.parse(localStorage.getItem('bomData')) || [];
    var checkbox = document.getElementById('bomToggle');

    //stockwarning
    var stockWarning= document.getElementById('stockToggle');
    var stocksWarning = stockWarning.checked ? 1 : 0;
    var stockQuantity = document.getElementById('quantity').value;


    var discount_sc = $("#discount_sc").is(":checked") ? 1 : 0;
    var discount_sp = $("#discount_sp").is(":checked") ? 1 : 0;
    var discount_naac = $("#discount_naac").is(":checked") ? 1 : 0;
    var discount_pwd = $("#discount_pwd").is(":checked") ? 1 : 0;
    var discount_mov = $("#discount_mov").is(":checked") ? 1 : 0;


    var formData = new FormData();
    formData.append("discount_sc", discount_sc);
    formData.append("discount_sp", discount_sp);
    formData.append("discount_naac", discount_naac);
    formData.append("discount_pwd", discount_pwd);
    formData.append("discount_mov", discount_mov);
    formData.append("uploadedImage", file);
    formData.append("productname", productname);
    formData.append("sku", sku);
    formData.append("code", code);
    formData.append("barcode", barcode);
    formData.append("oum_id", oum_id);
    formData.append("brand", brand);
    formData.append("cost", cost);
    formData.append("markup", markup);
    formData.append("sellingPrice", sellingPrice);
    formData.append("discount", discount);
    formData.append("vat", vat);
    formData.append("display_tax", display_tax);
    formData.append("service_charge", service_charge);
    formData.append("display_service_charge", display_service_charge);
    formData.append("other_charges", other_charges);
    formData.append("display_other_charges", display_other_charges);
    formData.append("status", status);
    formData.append("description", description);
    formData.append("catID", catID);
    formData.append("varID", varID);
    formData.append("category_details", jsonString);
    formData.append("warranty", warrant);
    formData.append("stockable", stckble);
    formData.append("warning", stocksWarning);
    formData.append("stockQuantity", stockQuantity);
    if (checkbox.checked) {
      var bomValue = 1;
      formData.append('bomStat', bomValue);
      existingData.forEach(function (entry, index) {
        var jsonData = {
          ingredientsQty: entry.ingredientsQty,
          uom_id: entry.uom_id,
          ingredientId: entry.ingredientId
        }

        formData.append('productBOM[' + index + ']', JSON.stringify(jsonData));
      });
    } else {
      var bomValue = 0;
      formData.append('bomStat', bomValue);
    }
    if (productname && barcode && cost && markup) {

      axios.post('api.php?action=addProduct', formData).then(function (response) {
        showResponse("Product has been successfully added", 1);
        var userInfo = JSON.parse(localStorage.getItem('userInfo'));
        var firstName = userInfo.firstName;
        var lastName = userInfo.lastName;
        var cid = userInfo.userId;
        var role_id = userInfo.roleId; 
        insertLogs('Products',firstName + ' ' + lastName + ' '+ 'Added' + ' ' +  productname +' '+ 'Barcode #:'+barcode)
        refreshProductsTable()
        // show_allProducts();
        closeAddProductsModal()
      }).catch(function (error) {
        console.log(error)
      })
    } else {
      console.log('check fields')
    }

  }

  function showResponse(message, type) {
    toastr.options = {
      "onShown": function () {
        $('.custom-toast').css({
          "opacity": 1,
          "width": "600px",
          "text-align": "center",
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
    type === 1 ? toastr.success(message) : toastr.error(message);
  }

  var DisplayService = '';
  var s_charge = '';

  var OtherDisplayService = '';
  var Others_charge = '';

  function toUpdateProducts(productId, productName, productSKU, productCode, productBarcode, productOUM, productuomid, productBrand, productCost, productMakup, productPrice,
    productStatus, isDiscounted, isTax, isTaxIncluded, serviceCharge, displayService, otherCharges, displayOtherCharges, status, image, desc, category, categoryid, variantid, isBOM, isWarranty,is_stockable,
    stock_status,stock_count , isSC, isPWD, isNAAC, isSP, isMOV) {

    $('#add_products_modal').show();
    productId ? document.getElementById('productid').value = productId : null;
    productName ? document.getElementById("productname").value = productName : null;

    var p_id = document.getElementById('productid').value
    if (p_id) {
      const limitedName = productName.split(' ').slice(0, 8
        
      ).join(' ');
      productName ? (document.getElementById("modalHeaderTxt").value = productName, $('.modalHeaderTxt').text(limitedName)) : null;
    } else {
      $('.modalHeaderTxt').text("Add New Product")
    }

    $("#discount_sc").prop("checked", isSC == 1);
    $("#discount_pwd").prop("checked", isPWD == 1);
    $("#discount_naac").prop("checked", isNAAC == 1);
    $("#discount_sp").prop("checked", isSP == 1);
    $("#discount_mov").prop("checked", isMOV == 1);

    productSKU ? document.getElementById("skunNumber").value = productSKU : null;
    productCode ? document.getElementById("code").value = productCode : null;
    productBarcode ? document.getElementById("barcode").value = productBarcode : null
    productOUM ? document.getElementById("uomType").value = productOUM : null
    productuomid ? document.getElementById("uomID").value = productuomid : null
    productBrand ? document.getElementById("brand").value = productBrand : null
    productCost ? document.getElementById("cost").value = productCost : null
    productMakup ? document.getElementById("markup").value = productMakup : null
    productPrice ? document.getElementById("selling_price").value = productPrice : null
    image ? displayImage('./assets/products/' + image) : displayImage('./assets/img/noImage.png' ) ;

    desc ? document.getElementById("description").value = desc : null
    var checkbox = document.getElementById('bomToggle');
    checkbox.checked = isBOM == 1;
    var bomText = document.getElementById('bomText');
    var disAbled = document.querySelector('.disAbled');
    var addButtons = document.getElementById('addIngredients');
    var delButtons = document.getElementById('delIngredients');
    if (checkbox.checked) {
      bomText.style.color = 'var(--primary-color)';
      disAbled.textContent = 'Enabled';
      disAbled.style.color = 'var(--primary-color)';
      addButtons.disabled = false;
      delButtons.disabled = false;
    } else {
      addButtons.disabled = true;
      delButtons.disabled = true;
      bomText.style.color = ""
      disAbled.style.color = ""
    }


    //category
    if (category) {
      var categoryArray = JSON.parse(category);
      var concatenatedValue = '';
      categoryArray.forEach(function (item) {
        concatenatedValue += item.productLbl + item.catLbl + item.varLbl;

      });
      document.getElementById("categoriesInput").value = concatenatedValue
      document.getElementById('productLbl').value = categoryArray[0].productLbl;
      document.getElementById('cat_Lbl').value = categoryArray[0].catLbl;
      document.getElementById('var_Lbl').value = categoryArray[0].varLbl

    }
    categoryid ? document.getElementById('catID').value = categoryid : null;
    variantid ? document.getElementById('varID').value = variantid : null;


    // var discountedCheckbox = document.getElementById('discountToggle');
    // discountedCheckbox.checked = (isDiscounted == 1) ? true : false;

    $("#discountToggle").prop("checked", isDiscounted == 1);

  
    var stockable = document.getElementById('stockeableToggle');
    stockable.checked = (is_stockable == 1) ? true : false;

    var taxCheckbox = document.getElementById('taxVatToggle');
    taxCheckbox.checked = (isTax == 1) ? true : false;

    var showTaxCheckbox = document.getElementById('showIncludesTaxVatToggle');
    showTaxCheckbox.checked = (isTaxIncluded == 1) ? true : false;

    var warranty = document.getElementById('warrantyToggle');
    warranty.checked = (isWarranty == 1) ? true : false

    if (showTaxCheckbox.checked) {
      toggleChangeColor(showTaxCheckbox);
    } else {
      toggleChangeColor(showTaxCheckbox);
    }
    var service = document.getElementById('serviceChargesToggle');
    var taxLabel = document.getElementById('taxtVatLbl');

    // console.log(displayService);
    $('#displayServiceChargeReceipt, #serviceChargesToggle').on('change', function () {
      var isDisplayServiceChargeReceiptChecked = $('#displayServiceChargeReceipt').is(':checked');
      var isServiceChargesToggleChecked = $('#serviceChargesToggle').is(':checked');
      if (isDisplayServiceChargeReceiptChecked) {
        DisplayService = 1
      } else {
        DisplayService = 0
      }
      
      if (isServiceChargesToggleChecked) {
        s_charge = 1 
      } else {
        s_charge = 0
      }
    });

    if (displayService == '1') {
      $('#displayServiceChargeReceipt').prop('checked', true);
    } else {
      $('#displayServiceChargeReceipt').prop('checked', false);
    }

    if (serviceCharge == '1') {
      $('#serviceChargesToggle').prop('checked', true);
    } else {
      $('#serviceChargesToggle').prop('checked', false);
    }
   
    $('#otherChargesToggle, #displayReceipt').on('change', function() {
      var displayOtherCharge = $('#displayReceipt').is(':checked'); 
      var other = $('#otherChargesToggle').is(':checked'); 

      if (displayOtherCharge) {
        OtherDisplayService = 1
      } else {
        OtherDisplayService = 0
      }

      if (other) {
        Others_charge = 1 
      } else {
        Others_charge = 0
      }
    })

    if (otherCharges == '1') {
      $('#otherChargesToggle').prop('checked', true);
    } else {
      $('#otherChargesToggle').prop('checked', false);
    }

    if (displayOtherCharges == '1') {
      $('#displayReceipt').prop('checked', true);
    } else {
      $('#displayReceipt').prop('checked', false);
    }

    var stat = document.getElementById('statusValue');
    var statusLabel = document.getElementById('statusActive');
    stat.checked = (status == 1) ? true : false;
    if (stat.checked) {
      toggleStatus(stat)
      statusLabel.style.color = 'var(--primary-color)';
    } else {
      toggleStatus(stat)
      statusLabel.style.color = '';
    }

    var stockWarning = document.getElementById('stockToggle');
    stockWarning.checked = (stock_status == 1) ? true : false;
    if(stockWarning.checked){
      var value = document.getElementById('quantity')
      value.removeAttribute('hidden')
    }else{
      var value = document.getElementById('quantity')
      value.setAttribute('hidden',true)
    }
    stock_count ? document.getElementById('quantity').value = stock_count : null;

    var uptBtn = document.querySelector('.updateProductsBtn');
    var saveBtn = document.querySelector('.saveProductsBtn');
    productId ? (uptBtn.removeAttribute('hidden'), saveBtn.setAttribute('hidden', true)) : (uptBtn.setAttribute('hidden', true), saveBtn.removeAttribute('hidden'));

    var product_id = document.getElementById("productid").value
    if (product_id) {
      axios.get(`api.php?action=getBOMData&product_id=${product_id}`).then(function (response) {
        // console.log(response)
        var data = response.data.bom;
        var existingData = JSON.parse(localStorage.getItem('bomData')) || [];
        existingData.push(...data);
        localStorage.setItem('bomData', JSON.stringify(existingData));
        updateTable(existingData);
      }).catch(function (error) {
        console.log(error)
      })
    }

  }

 

  
  function updateProducts() {
    var p_id = document.getElementById('productid').value
    var productname = document.getElementById('productname').value;
    var sku = document.getElementById('skunNumber').value;
    var code = document.getElementById('code').value;
    var barcode = document.getElementById('barcode').value;
    var oum_id = document.getElementById('uomID').value;
    var brand = document.getElementById('brand').value;
    var cost = document.getElementById('cost').value;
    var markup = document.getElementById('markup').value;
    var sellingPrice = document.getElementById('selling_price').value
    //discount
    var discountCheckbox = document.getElementById('discountToggle');
    var discount = discountCheckbox.checked ? 1 : 0;
    //vat
    var vatCheckbox = document.getElementById('taxVatToggle');
    var vat = vatCheckbox.checked ? 1 : 0;
    var displayTax = document.getElementById('showIncludesTaxVatToggle');
    var display_tax = displayTax.checked ? 1 : 0;

    //service Charge
    var serviceCharge = document.getElementById('serviceChargesToggle');
    var service_charge = serviceCharge.checked ? 1 : 0;
    var displaySrvCharge = document.getElementById('displayServiceChargeReceipt');
    var display_service_charge = displaySrvCharge.checked ? 1 : 0;

    //other charges
    var otherCharges = document.getElementById('otherChargesToggle');
    var other_charges = otherCharges.checked ? 1 : 0;
    var displayOtherCharges = document.getElementById('displayReceipt');
    var display_other_charges = displayOtherCharges.checked ? 1 : 0;

    //status
    var stat = document.getElementById('statusValue');
    var status = stat.checked ? 1 : 0;

    // warranty
    var warranty = document.getElementById('warrantyToggle');
    var warrant = warranty.checked ? 1 : 0;
    //stockable
    var stockable = document.getElementById('stockeableToggle');
    var stckble = stockable.checked ? 1 : 0;


    //stockwarning
    var stockWarning= document.getElementById('stockToggle');
    var stocksWarning = stockWarning.checked ? 1 : 0;
    var stockQuantity = document.getElementById('quantity').value;

    //productImage
    var file = '';
    var filename = '';
    var fileInput = document.getElementById('fileInputs');
    if(fileInput.files.length>0)
    {
      file = fileInput.files[0];
      filename = file.name;
    }

    var description = document.getElementById('description').value

    var nameLabel = document.querySelector('.nameTd');
    var barcodeLabel = document.querySelector('.barcodeTd');
    var costLabel = document.querySelector('.costTd');
    var markupLabel = document.querySelector('.markupTd');

    productname ? nameLabel.style.color = '' : nameLabel.style.color = 'red';
    barcode ? barcodeLabel.style.color = '' : barcodeLabel.style.color = 'red';
    cost ? costLabel.style.color = '' : costLabel.style.color = 'red';
    markup ? markupLabel.style.color = '' : markupLabel.style.color = 'red';

    //category details
    var catID = document.getElementById('catID').value ?? null;
    var varID = document.getElementById('varID').value ?? null;
    var productLbl = document.getElementById('productLbl').value !== null ? document.getElementById('productLbl').value : "Product";
    var cat_lbl = document.getElementById('cat_Lbl').value ?? null;
    var var_lbl = document.getElementById('var_Lbl').value ?? null
    var jsonData = [{
      "productLbl": productLbl,
      "catLbl": cat_lbl,
      "varLbl": var_lbl
    }];
    var jsonString = JSON.stringify(jsonData);

   
    var existingData = JSON.parse(localStorage.getItem('bomData')) || [];
    // console.log(existingData,'checking');

    var discount_sc = $("#discount_sc").is(":checked") ? 1 : 0;
    var discount_sp = $("#discount_sp").is(":checked") ? 1 : 0;
    var discount_naac = $("#discount_naac").is(":checked") ? 1 : 0;
    var discount_pwd = $("#discount_pwd").is(":checked") ? 1 : 0;
    var discount_mov = $("#discount_mov").is(":checked") ? 1 : 0;

    var formData = new FormData();
    formData.append("discount_sc", discount_sc);
    formData.append("discount_sp", discount_sp);
    formData.append("discount_naac", discount_naac);
    formData.append("discount_pwd", discount_pwd);
    formData.append("discount_mov", discount_mov);
    formData.append("uploadedImage", file);
    formData.append("productname", productname);
    formData.append("sku", sku);
    formData.append("code", code);
    formData.append("barcode", barcode);
    formData.append("oum_id", oum_id);
    formData.append("brand", brand);
    formData.append("cost", cost);
    formData.append("markup", markup);
    formData.append("sellingPrice", sellingPrice);
    formData.append("discount", discount);
    formData.append("vat", vat);
    formData.append("display_tax", display_tax);
    formData.append("service_charge", s_charge);
    formData.append("display_service_charge", DisplayService);
    formData.append("other_charges", Others_charge);
    formData.append("display_other_charges", OtherDisplayService);
    formData.append("status", status);
    formData.append("description", description);
    formData.append("product_id", p_id)
    formData.append("catID", catID);
    formData.append("varID", varID);
    formData.append("category_details", jsonString);
    formData.append("warranty", warrant);
    formData.append("stockable", stckble);
    formData.append("warning", stocksWarning);
    formData.append("stockQuantity", stockQuantity);
    formData.append("deleteValidation", deleteValidation);
    var checkbox = document.getElementById('bomToggle');
    if (checkbox.checked) {
      var bomValue = 1;
      formData.append('bomStat', bomValue);
      existingData.forEach(function (entry, index) {
        var jsonData = {
          id: entry.id,
          prod_id: entry.prod_id,
          ingredientsQty: entry.ingredientsQty,
          uom_id: entry.uom_id,
          ingredientId: entry.ingredientId
        };

        formData.append('productBOM[' + index + ']', JSON.stringify(jsonData));
      });

    } else {
      var bomValue = 0;
      formData.append('bomStat', bomValue);
    }

    if (productname && barcode && cost && markup) {

      axios.post('api.php?action=updateProduct', formData).then(function (response) {
        showResponse("Product has been successfully updated", 1);
        var userInfo = JSON.parse(localStorage.getItem('userInfo')) || {};
        var firstName = localStorage.getItem('firstName') ?? userInfo.firstName;
        var lastName = localStorage.getItem('lastName') ?? userInfo.lastName;
        var cid = localStorage.getItem('userId') ?? userInfo.userId;
        var role_id = localStorage.getItem('roleId') ?? userInfo.roleId;
        insertLogs('Products',firstName + ' ' + lastName + ' '+ 'Updated' + ' ' +  productname +' '+ 'Barcode #:'+barcode)
        refreshProductsTable()
        deleteValidation = "false";
        // refreshProductsTable()
        closeAddProductsModal()
        if (currentRow) 
        {
          
          var isDiscounted = $("#discountToggle").is(":checked") ? 1 : 0;
  
          var discount_sc = $("#discount_sc").is(":checked") ? 1 : 0;
          var discount_sp = $("#discount_sp").is(":checked") ? 1 : 0;
          var discount_naac = $("#discount_naac").is(":checked") ? 1 : 0;
          var discount_pwd = $("#discount_pwd").is(":checked") ? 1 : 0;
          var discount_mov = $("#discount_mov").is(":checked") ? 1 : 0;
          var discountTypesElement = currentRow.querySelector('.discountTypes');

          discountTypesElement.setAttribute('data-isSC', discount_sc);
          discountTypesElement.setAttribute('data-isPWD', discount_pwd);
          discountTypesElement.setAttribute('data-isNAAC', discount_naac);
          discountTypesElement.setAttribute('data-isSP', discount_sp);
          discountTypesElement.setAttribute('data-isMOV', discount_mov);
          
          currentRow.querySelector('.isDiscounted').innerText = isDiscounted;
          currentRow.querySelector('.service').innerText = s_charge;
          currentRow.querySelector('.displayService').innerText = DisplayService;

          currentRow.querySelector('.other').innerText = Others_charge;
          currentRow.querySelector('.displayOthers').innerText = OtherDisplayService;
        
          currentRow.querySelector('.previewImg .productImgs').textContent = filename;
          currentRow.querySelector('.productsName').innerText = productname;
          currentRow.querySelector('.sku').innerText = sku;
          currentRow.querySelector('.code').innerText = code;
          currentRow.querySelector('.barcode').innerText = barcode;
          currentRow.querySelector('.uom_name').innerText = uomType.value; 
          currentRow.querySelector('.brand').innerText = brand;
          currentRow.querySelector('.prod_price').innerText = sellingPrice;
          currentRow.querySelector('.markup').innerText = markup;
          currentRow.querySelector('.cost').innerText = cost;
          currentRow.querySelector('.status').innerText = status ? "Active" : "Inactive";
          currentRow.querySelector('.status').style.color = status ? "green" : "red";
          currentRow.querySelector('.description').innerText = description;
          // Update hidden fields
          currentRow.querySelector('.stock_status').innerText = stockable ? 1 : 0;
          currentRow.querySelector('.stock_count').innerText = stockQuantity;
          currentRow.querySelector('.isBOM').innerText = bomValue;
          currentRow.querySelector('.isWarranty').innerText = warrant;
          currentRow.querySelector('.is_stockable').innerText = stckble;
          currentRow.querySelector('.categoryDetails').innerText = JSON.stringify(jsonData);
          currentRow.querySelector('.categoryid').innerText = catID;
          currentRow.querySelector('.variantid').innerText = varID;
          currentRow.querySelector('.isTaxIncluded').innerText = display_tax;
          currentRow.querySelector('.other').innerText = other_charges;
          // currentRow.querySelector('.discount').innerText = discount;
          currentRow.querySelector('.service_charge').innerText = service_charge;
          currentRow.querySelector('.statusData').innerText = status ? 1 : 0;
   
        }
        // show_allProducts()
      }).catch(function (error) {
        console.log(error)
      })
    } else {
      console.log('check fields')
    }

  }
  var modifiedMessageModal = $('#modifiedMessageModal');
function modifiedMessageAlert(type, message, color, isButtonYes, isButtonCancel) {
  
  if (type == 'error') {
    document.getElementById('modalTitle').innerText = message;
    document.getElementById('modalTitle').style.color = 'red';
  } else {
    document.getElementById('modalTitle').innerText = message;
    document.getElementById('modalTitle').style.color = 'green';
  }


  if (isButtonYes) {
    document.getElementById('yesBtn').classList.remove('d-none');
  } else {
    document.getElementById('yesBtn').classList.add('d-none');
  }


  var setIntervalMessage = setInterval(function () {
    modifiedMessageModal.fadeIn('fast');
    
  }, 1);

  setTimeout(function () {
    clearInterval(setIntervalMessage);
    modifiedMessageModal.fadeOut('fast');
   
  }, 1500);
}

</script>

<style>
   #permModal .modal-dialog {
    max-width: fit-content;
    min-width: 600px;

  }

  @media (max-width: 768px) {
    #permModal .modal-dialog {
      max-width: 90vw;
    }
  }

  .modal-perm {
    color: #ffff;
    background: #262625;
    border-radius: 0;
    min-height: 300px;
    position: relative;
 
  }

  #permModal .close-button {
    position: absolute;
    right: 1.6em;
    top: 10px;
    background: #262625;
    color: #fff;
    border: none;
    width: 40px;
    height: 40px;
    line-height: 30px;
    text-align: center;
    cursor: pointer;
    margin-top: 2px;
    margin-left: 30px;
    font-size: 25px;
   transition: background-color 0.3s ease, transform 0.2s ease;
}

#permModal .close-button:hover {
 
    transform: scale(1.1);
    color:#fff
}




  #permModalLabel{
    font-family: Century Gothic;
    font-size: 1.5em;
    margin-top: 1em;
    margin-bottom: 0.5em;
    display: flex;
    align-items: center;
   
  }

  #permModal .warning-container {
    display: flex;
    align-items: center;
  }

  #permModal .warning-container img {
    width: 35px;
    height: 35px;
    margin-right: 0.5em;
    margin-left: 1vh;
    margin-top: -0.5em;
  }

.warningCards{
    min-width: fit-content;
    height: 180px;
    margin-left: 2em;
    border: 2px solid #4B413E;
    border-radius: 0;
    padding: 1.5vw;
    box-sizing: border-box;
    justify-content: flex-start;
    align-items: center;
    background: #262625;
    margin-right: 2em;
    flex-shrink: 0;
    margin-top: -5px;
    z-index: 1060;
  }

  #permModal .warningText {
    color: #fff;
    margin-right: 2vw;
    font-size: 1.5em;
    font-family: "Century Gothic", sans-serif;
    white-space: nowrap;
    text-align: center;
  }

  #permModal .warning-container svg {
    width: 35px;
    height: 35px;
    margin-right: 0.5em;
    margin-left: 1em;
    margin-top: -0.5em;
  }

  .confirmation-container {
    margin-top: 1em;
    margin-bottom: 1em;
    display: flex;
    z-index: 1060;
  }

  .requestPermissionBtn {
    font-family: Century Gothic;
    width: 180px;
    height: 40px;
    margin-right: 2em;
  
  }

  #adminCredentials {
    margin-top: 1vh;
 
  }

.permissions:active,
.permissions:focus {
  background-color: var(--primary-color) !important;
  color: #fff;
  outline: 0 !important;
}
.permissions{
  background-color: var(--primary-color) !important;
  color:#fff;
  outline: 0 !important;
}
</style>

<?php include ("./modals/noriel-lockscreen.php") ?>
<?php include ("./modals/noriel-unlockscreen.php") ?>

<script>


    $(document).ready(function() {
      let inactivityTime = function () {
          let timer;
          let lockScreen = $('#lockscreen');
          let modalfooter = $('#modalFooter');

          function resetTimer() {
              clearTimeout(timer);
              timer = setTimeout(function() {

                console.log("Inactivity detected. Showing lock screen and modal footer.");
                  lockScreen.show(); 
                  modalfooter.show(); 
                 
                  disableRefresh();
              }, 300000); 
          }
          $(window).on('mousemove keypress click scroll', resetTimer);
          resetTimer();
      };
      inactivityTime();
  });
  function openPasswordUnlock()
  {
    $("#unlockscreen").fadeIn(100);
    $("#unlockPasswordTxt").focus();
    $("#unlockPasswordTxt").val("");

    console.log("Hiding modal footer.");
    $('#modalFooter').hide();
  }


  
   $(document).on("keydown", "#lockscreen", function(event) {
        if (event.key === 'Enter') {
            openPasswordUnlock();
            event.preventDefault();
        }
    });

    $('.cancelT').on('click', function(){
      console.log("Cancel button clicked. Opening password unlock screen.");
      $('#modalFooter').hide();
      openPasswordUnlock();
      
    })
    
    $(document).off("click").on("click", ".continueT", function(){
      $('#lockscreen').hide();
      $(".continue_logout").click();
    })


    // $(document).on("click", "#unlockscreen #btnCancelUnlock", function(){
    //   $("#unlockscreen").hide();
    //   $('#lockscreen').show(); 
    //   $('#modalFooter').show(); 
     
    // })

    // Add Esc key functionality
$(document).on("keydown", function(event) {
    if (event.key === "Escape") {
        console.log("Esc key pressed. Hiding unlock screen and showing lock screen.");
        if ($("#unlockscreen").is(":visible")) {
            $("#unlockscreen").hide();
            $('#lockscreen').show(); 
        
        }
    }
});

    
    function disableRefresh()
    {
      $(document).on("keydown", function(event){
  
          // if (event.ctrlKey && (event.keyCode === 82 || event.keyCode === 116)) {
          //     event.preventDefault();
          // }
          $(document).on("keydown", function(event){
        if (event.keyCode === 116 || (event.ctrlKey && (event.keyCode === 82 || event.keyCode === 116))) {
          event.preventDefault();
        }
      });
      })
    }
    function handleUnlock() {
      var unlockPasswordTxt = $("#unlockPasswordTxt").val();
      if (unlockPasswordTxt.trim() !== "") {
        $("#unlockPasswordTxt").removeClass('has-error');
        $.ajax({
          type: 'get',
          url: 'api.php?action=unlockAdminUser',
          data: {
            password: unlockPasswordTxt,
          },
          success: function(response)
          {
            if(response.status)
            {
              $("#unlockscreen").hide();
              $('#lockscreen').hide();
            }
            else
            {
              $("#unlockPasswordTxt").addClass('has-error');
              $(".errorResponse").html(response.message);
            }
          }
        })
      } else {
        $(".errorResponse").html("Password is required!");
        $("#unlockPasswordTxt").addClass('has-error');
      }
    }

    $(document).on("click", "#unlockscreen #btnContinueUnlock", function() {
      handleUnlock();
    });
  
    $(document).on("keydown", "#unlockPasswordTxt", function(event) {
      if (event.key === "Enter") {
        event.preventDefault();
        handleUnlock();
      }
    });
</script>
<!-- <script>
  $(document).ready(function() {
    let inactivityTime = function () {
      let timer;
      let lockScreen = $('#lockscreen');

      function resetTimer() {
        clearTimeout(timer);
        timer = setTimeout(function() {
          setCookie('locked', 'true', 1); // Set cookie to lock the screen after inactivity
          lockScreen.show(); 
          disableRefresh();
        }, 300000); // 5 minutes of inactivity
      }

      function checkLockStatus() {
        if (getCookie('locked') === 'true') {
          lockScreen.show();
          disableRefresh();
        }
      }

      $(window).on('mousemove keypress click scroll', function() {
        resetTimer();
        if (getCookie('locked') === 'true') {
          eraseCookie('locked'); // Remove the lock cookie if activity is detected
          lockScreen.hide();
          enableRefresh();
        }
      });

      resetTimer();
      checkLockStatus();
    };

    inactivityTime();

    function setCookie(name, value, days) {
      let expires = "";
      if (days) {
        let date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
      }
      document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }

    function getCookie(name) {
      let nameEQ = name + "=";
      let ca = document.cookie.split(';');
      for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
      }
      return null;
    }

    function eraseCookie(name) {
      document.cookie = name + '=; Max-Age=-99999999;';
    }

    function openPasswordUnlock() {
      $("#unlockscreen").fadeIn(100);
      $("#unlockPasswordTxt").focus();
      $("#unlockPasswordTxt").val("");
    }

    $(document).on("keydown", "#lockscreen", function(event) {
      if (event.key === 'Enter') {
        openPasswordUnlock();
        event.preventDefault();
      }
    });

    $('.cancelT').on('click', function(){
      openPasswordUnlock();
    });

    $(document).on("click", ".continueT", function(){
      $('#lockscreen').hide();
      eraseCookie('locked'); 
      $(".continue_logout").click();
    });

    $(document).on("click", "#unlockscreen #btnCancelUnlock", function(){
      $("#unlockscreen").hide();
    });

    function disableRefresh() {
      $(document).on("keydown", function(event){
        if (event.keyCode === 116 || (event.ctrlKey && (event.keyCode === 82 || event.keyCode === 116))) {
          event.preventDefault();
        }
      });
    }

    function enableRefresh() {
      $(document).off("keydown");
    }

    function handleUnlock() {
      var unlockPasswordTxt = $("#unlockPasswordTxt").val();
      if (unlockPasswordTxt.trim() !== "") {
        $("#unlockPasswordTxt").removeClass('has-error');
        $.ajax({
          type: 'get',
          url: 'api.php?action=unlockAdminUser',
          data: {
            password: unlockPasswordTxt,
          },
          success: function(response) {
            if(response.status) {
              $("#unlockscreen").hide();
              $('#lockscreen').hide();
              eraseCookie('locked'); 
              enableRefresh(); // Re-enable refresh functionality
            } else {
              $("#unlockPasswordTxt").addClass('has-error');
              $(".errorResponse").html(response.message);
            }
          }
        });
      } else {
        $(".errorResponse").html("Password is required!");
        $("#unlockPasswordTxt").addClass('has-error');
      }
    }

    $(document).on("click", "#unlockscreen #btnContinueUnlock", function() {
      handleUnlock();
    });

    $(document).on("keydown", "#unlockPasswordTxt", function(event) {
      if (event.key === "Enter") {
        event.preventDefault();
        handleUnlock();
      }
    });
  });
</script> -->