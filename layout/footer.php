<?php include ("./layout/admin/expiration.php") ?>
<?php include ("./modals/admin/add-products-modal.php") ?>
<script>

  $(document).ready(function () {
    $("#btn_logout").click(function () {
      if (confirm("Do you wish to proceed to logout?")) {
        window.location.href = "logout.php";
      }
    })
    $('#searchInput').on('keyup', function () {
      var value = $(this).val().toLowerCase();
      $('table tbody tr').filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
    $("#r_close").click(function () {
      $("#response_modal").hide();
    })
  })
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

    var warranty = document.getElementById('warrantyToggle');
    var warrant = warranty.checked ? 1 : 0;

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


    var formData = new FormData();
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
        console.log(response)
        refreshProductsTable()
        closeAddProductsModal()
      }).catch(function (error) {
        console.log(error)
      })
    } else {
      console.log('check fields')
    }

  }



  function toUpdateProducts(productId, productName, productSKU, productCode, productBarcode, productOUM, productuomid, productBrand, productCost, productMakup, productPrice,
    productStatus, isDiscounted, isTax, isTaxIncluded, serviceCharge, displayService, otherCharges, displayOtherCharges, status, image, desc, category, categoryid, variantid, isBOM, isWarranty) {
    $('#add_products_modal').show();
    productId ? document.getElementById('productid').value = productId : null;
    productName ? document.getElementById("productname").value = productName : null;

    var p_id = document.getElementById('productid').value
    if (p_id) {
      productName ? (document.getElementById("modalHeaderTxt").value = productName, $('.modalHeaderTxt').text(productName)) : null;
    } else {
      $('.modalHeaderTxt').text("Add New Product")
    }
    productSKU ? document.getElementById("skunNumber").value = productSKU : null;
    productCode ? document.getElementById("code").value = productCode : null;
    productBarcode ? document.getElementById("barcode").value = productBarcode : null
    productOUM ? document.getElementById("uomType").value = productOUM : null
    productuomid ? document.getElementById("uomID").value = productuomid : null
    productBrand ? document.getElementById("brand").value = productBrand : null
    productCost ? document.getElementById("cost").value = productCost : null
    productMakup ? document.getElementById("markup").value = productMakup : null
    productPrice ? document.getElementById("selling_price").value = productPrice : null
    image ? displayImage('./assets/products/' + image) : null;
    desc ? document.getElementById("description").value = desc : null
    var checkbox = document.getElementById('bomToggle');
    checkbox.checked = isBOM == 1;
    var bomText = document.getElementById('bomText');
    var disAbled = document.querySelector('.disAbled');
    var addButtons = document.getElementById('addIngredients');
    var delButtons = document.getElementById('delIngredients');
    if (checkbox.checked) {
      bomText.style.color = '#00CC00';
      disAbled.textContent = 'Enabled';
      disAbled.style.color = '#00CC00';
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


    var discountedCheckbox = document.getElementById('discountToggle');
    discountedCheckbox.checked = (isDiscounted == 1) ? true : false;


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
    service.checked = (serviceCharge == 1) ? true : false;
    if (service.checked) {
      taxLabel.style.color = '#FF6900';
    } else {
      taxLabel.style.color = '';
    }
    var displayServices = document.getElementById('displayServiceChargeReceipt');
    displayServices.checked = (displayService == 1) ? true : false

    if (displayServices.checked) {
      toggleDisplayServiceCharge(displayServices)
    } else {
      toggleDisplayServiceCharge(displayServices)
    }
    var other = document.getElementById('otherChargesToggle');
    other.checked = (otherCharges == 1) ? true : false;
    var serviceLabel = document.getElementById('serviceChargeLbl');
    if (other.checked) {
      serviceLabel.style.color = '#FF6900';
    } else {
      serviceLabel.style.color = ''
    }
    var displayOtherCharge = document.getElementById('displayReceipt');
    displayOtherCharge.checked = (displayOtherCharges == 1) ? true : false;
    if (displayOtherCharge.checked) {
      toggleOtherCharges(displayOtherCharge)
    } else {
      toggleOtherCharges(displayOtherCharge)
    }

    var stat = document.getElementById('statusValue');
    var statusLabel = document.getElementById('statusActive');
    stat.checked = (status == 1) ? true : false;
    if (stat.checked) {
      toggleStatus(stat)
      statusLabel.style.color = '#00CC00';
    } else {
      toggleStatus(stat)
      statusLabel.style.color = '';
    }

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

    //productImage
    var file = document.getElementById("fileInputs").files[0];
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
    var formData = new FormData();
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
    formData.append("product_id", p_id)
    formData.append("catID", catID);
    formData.append("varID", varID);
    formData.append("category_details", jsonString);
    formData.append("warranty", warrant);

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
        refreshProductsTable()
        closeAddProductsModal()
      }).catch(function (error) {
        console.log(error)
      })
    } else {
      console.log('check fields')
    }

  }
</script>