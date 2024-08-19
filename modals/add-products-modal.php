
<?php include "layout/admin/add-products-modal-css.php"?> 

<div class="modal" id="add_products_modal" tabindex="0">
  <div class="modal-dialog ">
    <div class="modal-content product-modal">
      <!-- <div id="scrollable-data"> -->
      <div class="modal-title">
        <div style="margin-top: 30px; margin-left: 20px">
           <h5 class="text-custom modalHeaderTxt" id="modalHeaderTxt" style="color:var(--primary-color);">Add New Product</h5>
        </div>
        <div class="warning-container">
          <div class="tableCard">
          <div style="margin-left: 20px;margin-right: 20px">
            <table id="addProducts" class="text-color table-border"> 
                <tbody>
                    <tr>
                        <td class="nameTd td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Name<sup>*</sup></td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input class="productname" id="productname" name="productname"/></td>
                    </tr>
                    <tr>
                        <td  class="skuTd td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">SKU</td>
                        <td class="td-height text-custom"style="font-size: 12px; height: 10px:"><input oninput="validateInputs(this)"  class="skunNumber" id="skunNumber" name="skunNumber" /></td>
                    </tr>
                    <tr>
                        <td class="codeTd td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Code</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input oninput="validateInputs(this)"  class="code" id="code" name="code"/></td>
                    </tr>
                    <tr>
                        <td class="barcodeTd td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Barcode<sup>*</sup></td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px;">
                          <div class="d-flex">
                            <input  oninput="validateNumber(this)" class="barcode" id="barcode" name="barcode" style="width: 220px"/><button class="generate" id="generate">Generate</button>
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Unit of measure</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px">
                          <div class="dropdown custom-input d-flex">
                            <input class="custom-input" readonly hidden name="uomID" id="uomID" style="width: 259px"/>
                            <input class="custom-input" readonly name="uomType" id="uomType" style="width: 259px"/>
                            <button name="uomBtn" id="uomBtn" class="custom-btn">
                              &#129171;
                            </button>
                            <div class="dropdown-content" id="uomDropDown">
                            <?php
                                 $productFacade = new ProductFacade;
                                 $uom = $productFacade->getUOM();
                                while ($row =  $uom->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<a href="#" style="color:#000000; text-decoration: none;" data-value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['uom_name']) . '</a>';
                                }
                                ?>
                            </div>
                            <div id="variants" style="display: none;">
   
                            </div>
                          </div></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Brand</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input class="brand" name="brand" id="brand"/></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Warranty &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        
                        <?php
                          $taxVat = "yes"; 
                          $other_Charge = ($taxVat== "yes") ? "no" : "yes";
                          ?>
                          <label class="warrantLbl" style="margin-left: 5px">
                              <input type="checkbox" id="warrantyToggle"<?php if($taxVat == "yes") ?> onclick="toggleShowText(this)">
                              <span class="warrantySpan round"></span>
                          </label>
                      </td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px; font-style:italic; color: #B2B2B2"><span hidden id="triggers"> &nbsp;Triggers only when the product is sold</span></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Category<input hidden id="catID"/><input hidden  id="varID"/><input hidden id="productLbl"/><input hidden id="cat_Lbl"/><input hidden id="var_Lbl"/></td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input readonly class="categoriesInput" name="categoriesInput" id="categoriesInput" style="width: 242px"/><button onclick="openCategoryModal()" class="addCategory">+ADD</button></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Discount
             
                        <?php
                          $discount = "no"; 
                          $other_Charge = ($discount== "no") ? "yes" : "no";
                          ?>
                          <label class="discount" style="margin-left: 50px; ">
                                  <input type="checkbox" id="discountToggle"<?php if($discount == "no") ?>  >
                                  <span class="discountSpan round"></span>
                              </label>
                        </td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px;">
                      

                          <!-- <div class="dropdown custom-input">
                            <input class="custom-input" readonly hidden name="disCountID" id="disCountID" style="width: 210px"/>
                            <input class="custom-input" readonly name="discountType" id="discountType" style="width: 210px"/>
                            <button name="discountBtn" id="discountBtn" class="custom-btn">
                            <svg width="13px" height="13px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                <path d="M19 5L12.7071 11.2929C12.3166 11.6834 11.6834 11.6834 11.2929 11.2929L5 5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M19 13L12.7071 19.2929C12.3166 19.6834 11.6834 19.6834 11.2929 19.2929L5 13" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                            </button>
                            <div class="dropdown-content" id="discountDropDown">
                           
                            </div> -->
                            <!-- </div> -->
                            <div class="checkbox-container" style = "width: 100%">
                            
                              <label for="sc">SC</label>
                              <input type="checkbox" id="discount_sc" class="discountList" checked />

                              <label for="sp">SP</label>
                              <input type="checkbox" id="discount_sp" class="discountList" checked />

                              <label for="naac">NAAC</label>
                              <input type="checkbox" id="discount_naac" class="discountList" checked />

                              <label for="naac">PWD</label>
                              <input type="checkbox" id="discount_pwd" class="discountList" checked />
                            </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Stockable</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px;">
                        <?php
                          $stockable = "no"; 
                          $other_Charge = ($stockable == "no") ? "yes" : "no";
                          ?>
                          <label class="stockeable" style="margin-left: 5px">
                              <input type="checkbox" id="stockeableToggle"<?php if($stockable  == "no") ?>  >
                              <span class="stockeableSpan round"></span>
                          </label>
                            </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                        <td class="costTd td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Cost Price (Php)<sup>*</sup></td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input class="cost" name="cost" id="cost"  oninput="validateNumber(this)"/></td>
                    </tr>
                    <tr>
                        <td class="markupTd td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Mark-up (%)<sup>*</sup></td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input class="markup" name="markup" id="markup"  oninput="validateNumber(this)" /></td>
                    </tr>
                    <tr> 
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Selling Price (Php)</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input style="width: 105px"  class="selling_price" name="selling_price" id="selling_price"/>
                        <span hidden class="text-custom" id="multiLbl">Multiple Prices</span>
                        <?php
                          $multi = "yes"; 
                          $other_Charge = ($taxVat== "yes") ? "no" : "yes";
                          ?>
                          <label hidden class="multiplePrice" style="margin-left: 5px">
                              <input hidden type="checkbox" id="multipleToggle"<?php if($multi == "yes")?>  onclick="toggleMultiple(this)">
                              <span hidden  class="multipleSpan round"></span>
                          </label>
                        <button hidden disabled id="addMultiple" class="addMultiple addCategory">+Add</button>
                        <button hidden disabled class="editMultiple addCategory" hidden>+Edit</button> </td>
                    </tr>
                    <tr>
                        <td id="taxtVatLbl" class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Tax (VAT) 12%</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px">  <?php
                          $taxVat = "yes"; 
                          $other_Charge = ($taxVat== "yes") ? "no" : "yes";
                          ?>
                          <label class="taxVat" style="margin-left: 5px">
                              <input type="checkbox" id="taxVatToggle"<?php if($taxVat == "yes") echo ' checked'?> onclick="toggleTaxVat(this)">
                              <span class="taxVatSpan round"></span>
                          </label>
                          <small id="showTaxVatLbl" style="margin-left: 100px">Price Includes Tax</small>
                          <?php
                          $showTheTaxVat = 'yes'; 
                          $showOn = ($showTheTaxVat == 'yes') ? 'no' : 'yes';
                          ?>
                          <label class="showIncludesTaxVat" style="display:flex;float: right; margin-right: 5px">
                              <input type="checkbox" id="showIncludesTaxVatToggle"<?php if($showTheTaxVat == 'yes') echo ' checked'; ?> onclick="toggleChangeColor(this)">
                              <span class="spanShowTaxVat round"></span>
                          </label>
                        </td>
                    </tr>
                    <tr>
                        <td id="serviceChargeLbl" class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Service Charge <span id="service_charge"></span></td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px">
                          <?php
                            $serviceCharges = "no"; 
                            $other_Charge = ($serviceCharges== "no") ? "yes" : "no";
                            ?>
                            <label class="serviceCharge" style="margin-left: 5px">
                                <input type="checkbox" id="serviceChargesToggle"<?php if($serviceCharges == "no") ?> onclick="toggleDisplayServiceCharge(this)" >
                                <span class="sliderServiceCharges round"></span>
                            </label>
                            <small id="displayOnReceiptServiceCharge" style="margin-left: 100px">Display on Receipt</small>
                            <?php
                            $showTheServiceCharge = 'no'; 
                            $showOn= (  $showTheServiceCharge== 'no') ? 'yes' :' no';
                          ?>
                          <label class="displayServiceReceipt" style="display:flex;float: right; margin-right: 5px">
                            <input type="checkbox" id="displayServiceChargeReceipt"<?php if($showTheServiceCharge== 'no') echo ' disabled'; ?> onclick=" toggleDisplayOnReceiptServiceCharge(this)" >
                            <span class="spanDisplayServiceChargeReceipt round"></span>
                          </label>
                        </td>
                    </tr>
                    <tr>
                      <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Other Charges <span id="other_charges"></span></td>
                      <td class="td-height text-custom" style="font-size: 12px; height: 10px">
                          <?php
                          $otherChanges = "no"; 
                          $other_changes = ($otherChanges == "no") ? "yes" : "no";
                          ?>
                          <label class="switchOtherCharges" style="margin-left: 5px">
                              <input type="checkbox" id="otherChargesToggle"<?php if($otherChanges == "no") ?>>
                              <span class="sliderOtherCharges round"></span>
                          </label>
                          <small id="otherChargesDisplayOnReceipt" style="margin-left: 100px">Display on Receipt</small>
                          <?php
                          $showOnReceipt = 'no'; 
                          $showOn= (  $showOnReceipt== 'no') ? 'yes' :' no';
                          ?>
                          <label class="displayReceipt" style="display:flex;float: right; margin-right: 5px">
                              <input type="checkbox" id="displayReceipt"<?php if($showOnReceipt== 'no') echo ' disabled'; ?> onclick="toggleDisplayOnReceipt(this)">
                              <span class="spanDisplayReceipt round"></span>
                          </label>
                      </td>
                  </tr>
                   <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Low-stock Warning
                      </td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px; font-style:italic; color: #B2B2B2">
                        <?php
                          $taxVat = "yes"; 
                          $other_Charge = ($taxVat== "yes") ? "no" : "yes";
                          ?>
                          <label class="stockWarning" style="margin-left: 5px">
                              <input type="checkbox" id="stockToggle"<?php if($taxVat == "yes") ?>>
                              <span class="warningSpan round"></span>
                          </label>
                          <input type="text" hidden class="quantity" id="quantity" style="width: 100px" placeholder="Stock Quantity" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); if(this.value.includes('-')) this.value = this.value.replace('-', ''); if(this.value.includes('.')) { let parts = this.value.split('.'); this.value = parts[0] + '.' + parts.slice(1).join('').slice(0, 2); }" maxlength="10"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" id="statusActive" style="font-size: 12px; height: 10px">Status (Active)</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px">
                  <?php
                  $status = 'Active'; 
                  $opposite_status = ($status == 'Active') ? 'Inactive' : 'Active';
                  ?>
                  <label class="switch" style="margin-left: 5px">
                      <input readonly type="checkbox" id="statusValue"<?php if($status == 'Active') echo ' checked' ?> onclick="toggleStatus(this)">
                      <span class="slider round"></span>
                  </label>
              </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div id="scrollable-div">
          <div class="imageCard">
                  <div  style="width:32%" class="imageProduct" id="imageProduct">
                   </div> 
                     <div  class="bomCard">
                       <div style="width: 100%; display: flex;">
                          <h6 class="bomHeader" style="margin-left: 20px"><span class="disAbled">Disabled</span>&nbsp;<span id="bomText">Bill-0f-Material (BOM)</span></h6>
                         <div>
                         <?php
                            $otherChanges = "no"; 
                            $other_changes = ($otherChanges == "no") ? "yes" : "no";
                            ?>
                            <label class="bomLbl" style="margin-left: 15px; margin-top: 5px;  margin-right: 5px">
                                <input type="checkbox" id="bomToggle"<?php if($otherChanges == "no")  ?> >
                                <span class="sliderbom round"></span>
                            </label>  
                         </div>
                      </div>
                      <h6 class="enablingTxt">By enabling BOM, you are <br>activating the ingredients module.</h6>
                      <div  style="width: 100%; display: flex; align-items: right; justify-content: right;">
                          <button class="btns-bom" id="addIngredients"  style="margin-right: 5px; width: 70px">+ Add</button>
                          <button class="btns-bom" id="delIngredients" style="margin-right: 20px; width: 70px">- Del</button>
                      </div>
                      <div class="table-containers">
                  <table id="myTable" class="text-color">
                    <tbody>
                      <tr>
                          <td class="counter-cell" style="width:5%" ></td>
                          <td id="ingredientCell" style="width:30%"></td>
                          <td id="qtyCell"style="width:5%"></td>
                          <td id="uomCell" style="width:30%"></td>
                          <td hidden class="action-cell"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                   </div>        
               </div> 
               <div class="imageButtonDiv" style="margin-left: 20px;">
                 <input hidden type="file" id="fileInputs" style="display: none;" accept="image/jpeg, image/jpg, image/png">
                 <button onclick="clearImageProduct()" style="margin-right: 2px;" class="btnCustom removeImage">- Del</button>
                 <button class="btnCustom addImage" id="addImage">+ Add Image</button>
                
          </div> 
          <h4 class="descripTion"  style="color:var(--primary-color);">Description</h4> 
          <div style="margin-left: 20px;width: 100%; margin-right: 20px">
            <textarea  id="description" style="width: 92%; height: 120px; background-color: transparent; color:#fefefe" name="description"  class="description"></textarea>
          </div>
            <div class="button-container" style="display:flex;justify-content: right;">
                <button onclick="closeAddProductsModal()" class="cancelAddProducts btn-error-custom" style="margin-right: 10px; width: 100px; height: 40px">Cancel</button>
                <button onclick="addProduct()" class="btn-success-custom saveProductsBtn" style="margin-right: 20px; width: 100px; height: 40px">Save</button>
                <button hidden onclick="updateProducts()" class="btn-success-custom updateProductsBtn" style="margin-right: 20px; width: 100px; height: 40px">Update</button>
              </div>
          </div>
          </div>
        </div>
      </div>
    </div>
 
    </div>
  </div>
<!-- </div> -->
<script>

  $(document).on("change", "#discountToggle", function(e){
    e.preventDefault();

    var isChecked = $(this).is(":checked");
    if(isChecked)
    {
      $(".discountList").prop("checked", true);
    }
    else{
      $(".discountList").prop("checked", false);
    }
  })

  document.getElementById('stockToggle').addEventListener('change', function() {
        var quantityInput = document.querySelector('.quantity');
        if (this.checked) {
            quantityInput.removeAttribute('hidden');
        } else {
            quantityInput.setAttribute('hidden', 'true');
            quantityInput.value = "";
        }
    });



document.getElementById('addMultiple').addEventListener('click', function(){
   $('#add_multiple_modal').show()
})
window.addEventListener('beforeunload', function() {
    localStorage.removeItem('bomData');
});


document.addEventListener('DOMContentLoaded', function() {
    var checkbox = document.getElementById('bomToggle');
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
    }else{
         addButtons.disabled = true;
         delButtons.disabled = true;
        
    }

 
   
});
$('#addIngredients').off('click').on('click',function(){
  if( $('#add_category_modal').is(":visible")) {
    closeModal()
  }
  var checkbox = document.getElementById('bomToggle');
  if (checkbox.checked) {
    $('#add_bom_modal').css('display', 'block');
  }

})


document.addEventListener('DOMContentLoaded', function() {
  var checkbox = document.getElementById('bomToggle');
  checkbox.addEventListener('change', updateTextColor);
  checkbox.addEventListener('change', function(){
    if(!checkbox.checked){
    if($('#add_bom_modal').is(':visible')){
      closeModalBom()
    }
  }
  });
});
  

function updateTextColor() {
    var checkbox = document.getElementById('bomToggle');
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
        bomText.style.color = '';
        disAbled.textContent = 'Disabled';
        disAbled.style.color = '';
        addButtons.disabled = true;
         delButtons.disabled = true;
    }
}

function toggleShowText(checkbox) {
    var triggers = document.getElementById('triggers');
    if (checkbox.checked) {
      triggers.removeAttribute('hidden');
    } else {
      triggers.setAttribute('hidden', 'hidden');
    }
  }

  function toggleMultiple(checkbox){
    var multiLbl = document.getElementById('multiLbl');
    var addMultiple = document.getElementById('addMultiple')
    if(checkbox.checked){
      multiLbl.style.color = "var(--primary-color)";
      addMultiple.disabled = false;
    }else{
      multiLbl.style.color = "";
      addMultiple.disabled = true;
    }
  }

    function toggleStatus(checkbox) {
            var slider = checkbox.parentNode.querySelector('.slider'); 
            var statusLabel = document.getElementById('statusActive');
            if (checkbox.checked) {
                slider.style.backgroundColor = 'var(--primary-color)'; 
                statusLabel.style.color = 'var(--primary-color)'; 
            } else {
                slider.style.backgroundColor = '#262626'; 
                statusLabel.style.color = '#fefefe'; 
            }
        }
    function toggleDisplayOnReceipt(checkbox){
      var otherChargesDisplayOnReceipt = document.getElementById('otherChargesDisplayOnReceipt')
      var spanDisplayReceipt = checkbox.parentNode.querySelector('.spanDisplayReceipt'); 
      if (checkbox.checked) {
        otherChargesDisplayOnReceipt.style.color = "var(--primary-color)";
      } else {
        otherChargesDisplayOnReceipt.style.color = "#FFFFFF";  
      }
    }


    $('#otherChargesToggle').on('change', function() {
      if($(this).prop('checked')) {
        $('#displayReceipt').prop('disabled', false);
        $('#displayReceipt').prop('checked', true);
      } else {
        $('#displayReceipt').prop('disabled', true);
        $('#displayReceipt').prop('checked', false);
      }
    })

    function toggleOtherCharges(checkbox) {
      // console.log('Hello world')
      // var otherChargesDisplayOnReceipt = document.getElementById('otherChargesDisplayOnReceipt')
      //   var otherChargesToggle= checkbox.parentNode.querySelector('.sliderOtherCharges'); 
      //   if (checkbox.checked) {
      //       var displayReceipt = document.getElementById('displayReceipt')
      //       displayReceipt.disabled = false;
      //         // $('#otherChargesDisplayOnReceipt').prop('checked', true);
      //       } else {
      //         // $('#otherChargesDisplayOnReceipt').prop('checked', true);
      //       var displayReceipt = document.getElementById('displayReceipt')
      //       displayReceipt.disabled = true;
      //       displayReceipt.checked = false;
      //       otherChargesDisplayOnReceipt.style.color = "#FFFFFF"; 
      //       }
      }

      function toggleDisplayServiceCharge(checkbox) {
        var otherServiceChargesDisplayOnReceipt = document.getElementById('displayOnReceiptServiceCharge')
        var spanDisplayServiceReceipt = checkbox.parentNode.querySelector('.sliderServiceCharges'); 
        if (checkbox.checked) {
          $('#displayServiceChargeReceipt').prop('disabled', false)
          $('#displayServiceChargeReceipt').prop('checked', true);
        } else {
          $('#displayServiceChargeReceipt').prop('disabled', true)
          $('#displayServiceChargeReceipt').prop('checked', false);
        }
      }

  function toggleDisplayOnReceiptServiceCharge(checkbox){
    var otherServiceChargesDisplayOnReceipt = document.getElementById('displayOnReceiptServiceCharge')
    var spanDisplayServiceReceipt = checkbox.parentNode.querySelector('.spanDisplayServiceChargeReceipt'); 
      if (checkbox.checked) {
         otherServiceChargesDisplayOnReceipt.style.color="var(--primary-color)"
            } else {
              otherServiceChargesDisplayOnReceipt.style.color="#FFFFFF"
            }
  }

  function toggleTaxVat(checkbox){
    var showTaxVatLbl = document.getElementById('showTaxVatLbl')
    var spanDisplayServiceReceipt = checkbox.parentNode.querySelector('.taxVatSpan'); 
    if (checkbox.checked) {
          var taxVat = document.getElementById('showIncludesTaxVatToggle')
           taxVat.disabled=false
           taxVat.checked= true
            } else {
              var taxVat = document.getElementById('showIncludesTaxVatToggle')
              taxVat.disabled=true
              taxVat.checked= false
              showTaxVatLbl.style.color="#FFFFFF"
            }
  }
  function toggleChangeColor(checkbox){
    var taxLbl = document.getElementById('showTaxVatLbl')
    var spanDisplayTaxVat = checkbox.parentNode.querySelector('.spanShowTaxVat'); 
    if (checkbox.checked) {
         taxLbl.style.color="var(--primary-color)"
            } else {
              taxLbl.style.color="#FFFFFF"
            }
  }

document.getElementById("uomBtn").addEventListener("click", function() {
  var dropdownContents = document.getElementById("uomDropDown");
  if (dropdownContents.style.display === "block") {
    dropdownContents.style.display = "none";
  } else {
    dropdownContents.style.display = "block";
  }
  event.stopImmediatePropagation();
});

document.addEventListener("click", function(event) {
  var dropdownContent = document.getElementById("uomDropDown");
  var statusBtn = document.getElementById("uomBtn");
  if (event.target !== dropdownContent && event.target !== statusBtn && dropdownContent.style.display === "block") {
    dropdownContent.style.display = "none";
  }
});

document.querySelectorAll("#uomDropDown a").forEach(item => {
  item.addEventListener("click", function(event) {
    event.preventDefault(); 
    var value = this.getAttribute("data-value");
    var roleName = this.textContent;
    document.getElementById("uomID").value = value;
    document.getElementById("uomType").value = roleName;
    document.getElementById("uomDropDown").style.display = "none";
  });
});


$('#generate').off('click').on("click", function() {
    const minDigits = 12;
    const randomNumber = generateRandomNumber(minDigits);
    document.getElementById('barcode').value = randomNumber
    
})
function generateRandomNumber(minDigits) {
    const numberOfDigits = Math.floor(Math.random() * (12 - minDigits + 1)) + minDigits; 
    let randomNumber = '';

    for (let i = 0; i < numberOfDigits; i++) {
        randomNumber += Math.floor(Math.random() * 10); 
    }

    return randomNumber;
}
function displayImage(imageUrl) {
  
    document.getElementById('imageProduct').innerHTML = '<img src="' + imageUrl + '" style="max-width: 100%; max-height: 100%;">';
}

var defaultImageUrl = './assets/img/noImage.png';
var file;
displayImage(defaultImageUrl);


document.getElementById("addImage").addEventListener("click", function() {
    document.getElementById("fileInputs").click();
});

document.getElementById('fileInputs').addEventListener('change', function(event) {
    var file = event.target.files[0];
    var reader = new FileReader();

    reader.onload = function(event) {
        var imageUrl = event.target.result;
        displayImage(imageUrl);
    };

    if (file) {
        reader.readAsDataURL(file);
    } 
});

document.getElementById("fileInputs").addEventListener("change", function(event) {
    var file = event.target.files[0];
  
});


function openCategoryModal(){
   $('#add_category_modal').show()
   if($('#add_bom_modal').is(':visible')){
      closeModalBom()
    }
}

function clearStorage() {
  var existingData = JSON.parse(localStorage.getItem('bomData')) || [];
  
  if (existingData.length > 0) {
    localStorage.removeItem('bomData');
    var tableBody = document.getElementById('myTable').getElementsByTagName('tbody')[0];
    tableBody.innerHTML = '';
  }
}

function closeAddProductsModal(){
     closeModal()
     clearStorage()
    if($('#add_bom_modal').is(':visible')){
      $('.closeBom').click()
    }
    
  $('#add_products_modal').css('animation', 'slideOutRight 0.5s forwards');
  $('.product-modal').css('animation', 'slideOutRight 0.5s forwards');
  $('.highlighteds').removeClass('highlighteds');
  $('.highlightedss').removeClass('highlightedss');
  $('#add_products_modal').one('animationend', function() {
    $(this).hide();
    $(this).css('animation', '');
    $('.product-modal').css('animation', '');
     clearProductsInputs()
     clearFileInput() 
    //  window.location.reload()
  
  });
}

  
function validateNumber(input) {
   
    input.value = input.value.replace(/[^0-9.]/g, '');
    if (input.value.startsWith('-')) {
        input.value = input.value.slice(1);
    }
}function validateInputs(input) {
    // Remove any non-alphanumeric characters
    input.value = input.value.replace(/[^a-zA-Z0-9]/g, '');
}

document.addEventListener('DOMContentLoaded', function() {
    var skunNumberInput = document.getElementById('skunNumber');
    var skuLabel = document.querySelector('.skuTd');

    skunNumberInput.addEventListener('input', function() {
        var sku = skunNumberInput.value.trim(); 
        if (sku) {
          axios.get(`api.php?action=checkSKU&sku=${sku}`)
                .then(function(response) {
                    var data = response.data;
                    if (data.success && data.sku) {
                        skunNumberInput.style.color = 'red';
                        skuLabel.style.color = 'red';
                    } else {
                        skunNumberInput.style.color = ''; 
                        skuLabel.style.color = '';
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        } else {
            skunNumberInput.style.color = ''; 
            skuLabel.style.color = '';
        }
    });
    var barcodeInput =  document.getElementById('barcode');

    barcodeInput.addEventListener('click', function() {
        this.select();
    });
        
    var barcodeLabel = document.querySelector('.barcodeTd');
    barcodeInput.addEventListener('input', function() {
  var barcode = barcodeInput.value.trim(); 
        if (barcode) {
            axios.get(`api.php?action=checkSKU&barcode=${barcode}`)
                .then(function(response) {
                    var data = response.data;
                    if (data.success && data.sku) {
                        barcodeInput.style.color = 'red';
                        barcodeLabel.style.color = 'red';
                    } else {
                        barcodeInput.style.color = ''; 
                        barcodeLabel.style.color = '';
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        } else {
            barcodeInput.style.color = ''; 
            barcodeLabel.style.color = '';
        }
    });
    var codeInput =  document.getElementById('code');
    var codeLabel = document.querySelector('.codeTd');
    codeInput.addEventListener('input', function() {
     
        var code = codeInput.value.trim(); 
        if (code) {
            axios.get(`api.php?action=checkSKU&code=${code}`)
                .then(function(response) {
                    var data = response.data;
                    if (data.success && data.sku) {
                       codeInput.style.color = 'red';
                        codeLabel.style.color = 'red';
                    } else {
                       codeInput.style.color = ''; 
                        codeLabel.style.color = '';
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        } else {
           codeInput.style.color = ''; 
            codeLabel.style.color = '';
        }
    });
    var productInput =  document.getElementById('productname');
    var nameLabel = document.querySelector('.nameTd');
    productInput.addEventListener('input', function() {
       var productname =  productInput.value.trim();
       if(productInput){
         nameLabel.style.color = '';
       }
    })
  var costLabel  = document.querySelector('.costTd');
  var costInput = document.getElementById('cost');
  costInput.addEventListener('input', function(){
    var cost =  costInput.value.trim();
    if(cost){
      costLabel.style.color = '';
    }
  })
  var markupLabel = document.querySelector('.markupTd');
  var markupInput = document.getElementById('markup')
  markupInput.addEventListener('input', function(){
     var markup = markupInput.value.trim();
     if(markup){
      markupLabel.style.color = '';
     }
  })
});
function clearFileInput() {
    var fileInput = document.getElementById('fileInputs');
    fileInput.value = '';
    if(fileInput.value == ''){
        displayImage(defaultImageUrl);
    }
}

function clearProductsInputs(){

  document.getElementById('productname').value = "";
  document.getElementById('skunNumber').value = "";
  document.getElementById('code').value = "";
  document.getElementById('barcode').value = "";
  document.getElementById('uomID').value = "";
  document.getElementById('brand').value = "";
  document.getElementById('cost').value = "";
  document.getElementById('markup').value = "";
  document.getElementById('selling_price').value = "";
  document.getElementById('uomType').value = ""
  document.getElementById('categoriesInput').value = "";
  document.getElementById('description').value = "";
  document.getElementById('productid').value = ""
  document.getElementById('catID').value = "";
  document.getElementById('varID').value = "";
  document.getElementById('productLbl').value = "";
  document.getElementById('cat_Lbl').value = "";
  document.getElementById('var_Lbl').value = "";

  var nameLabel = document.querySelector('.nameTd');
  nameLabel.style.color = ""
  var barcodeLabel = document.querySelector('.barcodeTd');
  barcodeLabel.style.color = ""
  var costLabel  = document.querySelector('.costTd');
  costLabel.style.color = ""
  var markupLabel = document.querySelector('.markupTd');
  markupLabel.style.color = ""

  var categoriesVisible = false;
    $('#categoriesDiv').hide();
    $('#showCategories').text('+ Products').removeClass('highlighted');
    $('#showCategories').off('click').click(function() {
        $('#categoriesDiv').toggle();
        categoriesVisible = !categoriesVisible; 
        $('.productsP').toggleClass('highlighted', categoriesVisible);
        $('.productsBtn').toggleClass('black-text', categoriesVisible).toggleClass('white-text', !categoriesVisible);

        if (categoriesVisible) {
            getCategories();
            $(this).text('- Products');
        } else {
            $(this).text('+ Products'); 
            $('.productsP').removeClass('highlighted');
        }
    });
    var uptBtn = document.querySelector('.updateProductsBtn');
    uptBtn.setAttribute('hidden',true);
    var saveBtn = document.querySelector('.saveProductsBtn');
    saveBtn.removeAttribute('hidden');
}



document.getElementById('selling_price').addEventListener('input', function(){
  var multipleToggle = document.getElementById('multipleToggle'); 
  var sell =  document.getElementById('selling_price').value
  if(sell){
    multipleToggle.disabled = false; 
  }else{
    multipleToggle.disabled = true; 
  }

})

document.addEventListener('DOMContentLoaded', function() {
  var multipleToggle = document.getElementById('multipleToggle'); 
  var sell =  document.getElementById('selling_price').value
  if(sell){
    multipleToggle.disabled = false; 
  }else{
    multipleToggle.disabled = true; 
  }

  var isFirstInputZeroIndex = false; 
  var isFirstInputOneIndex = false;
  var isFirstInputTwoIndex = false;

  
  var $inputs = $('#cost, #markup, #selling_price');

  var taxCheckbox = document.getElementById('taxVatToggle');
  var showTaxCheckbox = document.getElementById('showIncludesTaxVatToggle');
  var service = document.getElementById('serviceChargesToggle');
  var otherCharges = document.getElementById('otherChargesToggle');

  // if(!service.checked){
  //   otherCharges.disabled = true
  // } else {
  //   otherCharges.disabled = false
  // }

  var taxLabel = document.getElementById('taxtVatLbl');
  var serviceLabel = document.getElementById('serviceChargeLbl');
  var showTaxLbl = document.getElementById('showTaxVatLbl');

  $inputs.on('input', function() {
    handleInputChange();
    var index = $inputs.index(this);
    if ($(this).val() === '') {
      isFirstInputZeroIndex = false;
      isFirstInputOneIndex = false;
      isFirstInputTwoIndex = false;
      $('#selling_price, #markup, #cost').val('');
    return; 
  }

    
    if (!isFirstInputZeroIndex && index === 0) {
      isFirstInputZeroIndex = true;
    }
    if (!isFirstInputOneIndex && index === 1) {
      isFirstInputOneIndex = true;
    }

    if (!isFirstInputTwoIndex && index === 2) {
      isFirstInputTwoIndex = true;
    }
   
    if ((isFirstInputZeroIndex && index === 1) || (isFirstInputOneIndex && index === 0)) {
      console.log('Hello world');
      calculateSellingPrice();
    } else if ((isFirstInputZeroIndex && index === 2) || (isFirstInputTwoIndex && index === 0 )) {
      calculateMarkup();
    } 
    
    if ((isFirstInputOneIndex && index === 2) ||  (isFirstInputTwoIndex && index === 1 ) ) {
      calculateCost();
    }

  });
  var tax = 0; // Declare tax outside the event listener function

showTaxCheckbox.addEventListener('change', function() {
  var sellingPrice = 0;
  var s = parseFloat(document.getElementById('selling_price').value);
  if (s) {
    sellingPrice = parseFloat(document.getElementById('selling_price').value);
  }
  var vatable = sellingPrice / 1.12;
  if (!this.checked) {
      tax = sellingPrice - vatable;
      var newPrice = sellingPrice + tax;
      document.getElementById('selling_price').value = newPrice.toFixed(2);
  } else {
      var newPrice = sellingPrice - tax;
      showTaxLbl.style.color = ""
      document.getElementById('selling_price').value = newPrice.toFixed(2);
  }
});
var serviceCharge = 0; 
function getServiceCharges() {
  axios.get('api.php?action=getServiceCharge').then(function(response){
     serviceCharge = response.data.result[0].rate
     var displayRate = parseFloat(serviceCharge) *100;
    var text = `(${displayRate.toFixed(2)}%)`;
    document.getElementById('service_charge').textContent = text;
  }).catch(function(error){
    console.log(error)
  })
}
getServiceCharges()
// service.addEventListener('change', function() {
//   // if(!service.checked){
//   //   otherCharges.disabled = true
//   // }else{
//   //   otherCharges.disabled = false
//   // }
//   //   var sellingPrice = 0;
//   //   var s = parseFloat(document.getElementById('selling_price').value);
//   //   if(s){
//   //     sellingPrice = parseFloat(document.getElementById('selling_price').value);
//   //   }
    
//     // if (this.checked) {
//     //     var serviceFee = sellingPrice * serviceCharge;
//     //     var newPrice = sellingPrice + serviceFee;
//     //     document.getElementById('selling_price').value = newPrice.toFixed(2);
//     //     // Disable tax checkboxes
//     //     taxCheckbox.disabled = true;
//     //     showTaxCheckbox.disabled = true;
//     //     taxLabel.style.color = 'var(--primary-color)';
//     // } else {
//     //     var originalPrice = sellingPrice / (1 + serviceCharge);
//     //     document.getElementById('selling_price').value = parseFloat(0);
//     //     // Enable tax checkboxes
//     //     taxCheckbox.disabled = false;
//     //     showTaxCheckbox.disabled = false;
//     //     taxLabel.style.color = '';
//     // }
// });

var otherCharge = 0;
function getOtherCharges(){
  axios.get('api.php?action=getOtherCharges').then(function(response){
    otherCharge = response.data.result[0].rate
    var displayRate = parseFloat(otherCharge) *  100;
    var text = `(${displayRate.toFixed(2)}%)`;
    document.getElementById('other_charges').textContent = text;
  }).catch(function(error){
    console.log(error)
  })
}
getOtherCharges()

  function calculateSellingPrice() {
    var multipleToggle = document.getElementById('multipleToggle'); 
    var cost = parseFloat($('#cost').val());
    var markup = parseFloat($('#markup').val());
    if (!isNaN(cost) && !isNaN(markup)) {
      var sellingPrice = (cost + (cost * markup / 100)).toFixed(2);
      $('#selling_price').val(sellingPrice);
      multipleToggle.disabled = false; 
    } else {
      $('#selling_price').val('');
      multipleToggle.disabled = true; 
    }
  }

  function calculateMarkup() {
    var cost = parseFloat($('#cost').val());
    var sellingPrice = parseFloat($('#selling_price').val());
    if (!isNaN(cost) && !isNaN(sellingPrice) && cost !== 0) {
      var markup = (((sellingPrice - cost) / cost) * 100).toFixed(2);
      $('#markup').val(markup);
    }else{
      $('#markup').val('');
    }
  }

  function calculateCost() {
    var sellingPrice = parseFloat($('#selling_price').val());
    var markup = parseFloat($('#markup').val());
    if (!isNaN(sellingPrice) && !isNaN(markup) && markup !== 0) {
      var cost = (sellingPrice / (1 + (markup / 100))).toFixed(2);
      $('#cost').val(cost);
    } else {
      $('#cost').val('');
    }
  }
  function handleInputChange() {
    if(taxCheckbox.checked === true){
      showTaxCheckbox.checked = true; 
    
    }
    service.checked = false;
    otherCharges.checked = false;
    taxCheckbox.disabled = false;
    showTaxCheckbox.disabled = false;
    service.disabled = false
    serviceLabel.style.color = '';
   
  }

});


</script>

