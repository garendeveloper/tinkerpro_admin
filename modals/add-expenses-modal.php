<?php include "layout/admin/add-expenses-modal-css.php"?> 

<div class="modal" id="add_expense_modal" tabindex="0">
  <div class="modal-dialog " >
    <div class="modal-content expense_content scrollable" style = "overflow:auto;">
      <div class="modal-title">
        <div style="margin-top: 30px; margin-left: 20px">
           <h5 class="text-custom modalHeaderTxt" id="modalHeaderTxt" style="color: var(--primary-color)">EXPENSES</h5>
        </div>
        <form id = "expense_form" enctype="multipart/form-data">
        <div class="warning-container" >
          <div class="tableCard" >
          <div style="margin-left: 20px;margin-right: 20px">
          <input type="hidden" name = "isProductIDExist" id = "isProductIDExist" value = "0">
          <input type="hidden" name = "expense_id" id = "expense_id" value = "">
            <table id="tbl_createExpense" class="text-color table-border expense-hide" > 
                <tbody>
                    <tr>
                        <td class="nameTd td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Item Name<sup>*</sup></td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input class="productname" id="item_name" oninput = "$(this).closest('td').removeClass('form-error')" name="item_name" autocomplete="off" autofocus/></td>
                    </tr>
                    <tr>
                        <td  class="skuTd td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Date(MM-DD-YYYY)</td>
                        <td class="td-height text-custom"style="font-size: 12px; height: 10px:"><input id="date_of_transaction" type = "date" name="date_of_transaction" oninput = "$(this).closest('td').removeClass('form-error')" autocomplete="off"/></td>
                    </tr>
                    <tr>
                        <td class="codeTd td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Billable (Receipt No.)</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input id="billable_receipt_no" name="billable_receipt_no" oninput = "$(this).closest('td').removeClass('form-error')" autocomplete="off"/></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Type</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><div class="dropdown custom-input" >
                            <input class="custom-input" placeholder = "Search Expense Type" name="expense_type" id="expense_type"  style="width: 259px" autocomplete="off"/>
                            <button type = "button"  id="btn_expense_type" class="custom-btn dropdown_btn">
                            <svg width="13px" height="13px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                <path d="M19 5L12.7071 11.2929C12.3166 11.6834 11.6834 11.6834 11.2929 11.2929L5 5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M19 13L12.7071 19.2929C12.3166 19.6834 11.6834 19.6834 11.2929 19.2929L5 13" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                            </button>
                            <div class="dropdown-content" id="expense_type_dropdown" >
                                <a href="#" data-value="rent">Rent</a>
                                <a href="#" data-value="utilities">Utilities</a>
                                <a href="#" data-value="salaries wages">Salaries and Wages</a>
                                <a href="#" data-value="maintenance repairs">Maintenance and Repairs</a>
                                <a href="#" data-value="promotions">Promotions</a>
                                <a href="#" data-value="advertising">Advertising</a>
                                <a href="#" data-value="public relations">Public Relations</a>
                                <a href="#" data-value="office supplies">Office Supplies</a>
                                <a href="#" data-value="professional services">Professional Services</a>
                                <a href="#" data-value="software subsciptions">Software Subscriptions</a>
                                <a href="#" data-value="interest">Interest</a>
                                <a href="#" data-value="bank fees">Bank Fees</a>
                                <a href="#" data-value="insurance">Insurance</a>
                                <a href="#" data-value="travel expenses">Travel Expenses</a>
                                <a href="#" data-value="client entertainment">Client Entertainment</a>
                                <a href="#" data-value="taxes">Taxes</a>
                                <a href="#" data-value="income tax">Income Tax</a>
                                <a href="#" data-value="Property Tax">Property Tax</a>
                                <a href="#" data-value="depreciation">Depreciation</a>
                                <a href="#" data-value="amortization">Amortization</a>
                                <a href="#" data-value="miscellaneous">Miscellaneous</a>
                                <a href="#" data-value="charitable donations">Charitable Donations</a>
                                <a href="#" data-value="employee training">Employee Training</a>
                                <a href="#" data-value="unplanned expenses">Unplanned Expenses / Others</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Quantity</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><div class="dropdown custom-input">
                            <input class="custom-input" name="qty" id="qty" style="width: 125px" oninput = "$(this).removeClass('form-error')" autocomplete="off"/>
                            <input class="custom-input" readonly hidden name="uomID" id="uomID" style="width: 125px"/>
                            <input class="custom-input"  name="uomType" id="uomType" placeholder = "Unit of Measure" style="width: 126px" autocomplete="off"/>
                            <button type  ="button" name="uomBtn" id="uomBtn" class="custom-btn">
                            <svg width="13px" height="13px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                <path d="M19 5L12.7071 11.2929C12.3166 11.6834 11.6834 11.6834 11.2929 11.2929L5 5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M19 13L12.7071 19.2929C12.3166 19.6834 11.6834 19.6834 11.2929 19.2929L5 13" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                            </button>
                            <div class="dropdown-content uom_dropdown" >
                            <?php
                                 $productFacade = new ProductFacade;
                                 $uom = $productFacade->getUOM();
                                while ($row =  $uom->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<a href="#" style=" text-decoration: none;" data-value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['uom_name']) . '</a>';
                                }
                                ?>
                            </div>
                          </td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Supplier</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><div class="dropdown custom-input">
                            <input class="custom-input" hidden readonly name="supplier_id" id="supplier_id" style="width: 259px" />
                            <input class="custom-input" placeholder = "Search Supplier" name="supplier" id="supplier" style="width: 259px " autocomplete="off"/>
                            <button type = "button" name="btn_supplier" id="btn_supplier" class="custom-btn">
                            <svg width="13px" height="13px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                <path d="M19 5L12.7071 11.2929C12.3166 11.6834 11.6834 11.6834 11.2929 11.2929L5 5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M19 13L12.7071 19.2929C12.3166 19.6834 11.6834 19.6834 11.2929 19.2929L5 13" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                            </button>
                            <div class="dropdown-content" id="supplier_dropdown">
                            <?php
                                 $supplierFacade = new SupplierFacade;
                                 $suppliers = $supplierFacade->get_allSuppliers();
                                while ($row =  $suppliers->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<a href="#" style=" text-decoration: none;" data-value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['supplier']) . '</a>';
                                }
                                ?>
                            </div></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Invoice Number</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input class="brand" name="invoice_number" id="invoice_number" oninput = "$(this).closest('td').removeClass('form-error')"  autocomplete="off"/></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Price (Php)</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input class="brand" name="price" id="price" oninput = "$(this).closest('td').removeClass('form-error')" autocomplete="off"/></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Discount</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px;"><input class="brand" name="discount" id="discount" autocomplete="off"/></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Total Amount (Php)</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px;"><input class="brand" name="total_amount" id="total_amount" readonly autocomplete="off"/></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Is Tax Exlusive?&nbsp;&nbsp;&nbsp;
                          <label class="taxExlusive" style="margin-left: 5px">
                              <input type="checkbox" id="toggleTaxIn">
                              <span class="warrantySpan round"></span>
                          </label>
                      </td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px; font-style:italic; color: #B2B2B2">
                          <input type="hidden" id = "isVatable" name = "isVatable" value = "0">
                          <input type="text"value = "0" class="vatable_amount" id="vatable_amount" name = "vatable_amount" style="width: 80px" placeholder="Gross Amount (Inclusive of VAT):" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); if(this.value.includes('-')) this.value = this.value.replace('-', ''); if(this.value.includes('.')) { let parts = this.value.split('.'); this.value = parts[0] + '.' + parts.slice(1).join('').slice(0, 2); }" maxlength="10" readonly/>
                        </td>
                    </tr>
                 
            </table>

            <br>
            <table>
                <thead>
                  <tr>
                      <td class="td-height text-custom td-style td-bg" colspan = "2" style="font-size: 12px; height: 10px">Landed Cost&nbsp;&nbsp;&nbsp;
                        <label class="taxExlusive" style="margin-left: 5px">
                            <input type="checkbox" name = "toggleLandingCost" id="toggleLandingCost">
                            <span class="warrantySpan round"></span>
                        </label>
                      </td>
                  </tr>
                </thead>
                <tbody id="landingCostDiv" style = "display: none">
                   
                  <tr>
                      <td class="td-height text-custom td-style td-bg">Freight Charges</td>
                      <td class="td-height text-custom"><input class="landingCost" name="freightCharges" id="freightCharges" autocomplete="off" value="0"/></td>
                  </tr>
                  <tr>
                      <td class="td-height text-custom td-style td-bg">Insurance Fees</td>
                      <td class="td-height text-custom"><input class="landingCost" name="insuranceFees" id="insuranceFees" autocomplete="off" value="0"/></td>
                  </tr>
                  <tr>
                      <td class="td-height text-custom td-style td-bg">Import Duties</td>
                      <td class="td-height text-custom"><input class="landingCost" name="importDuties" id="importDuties" autocomplete="off" value="0"/></td>
                  </tr>
                  <tr>
                      <td class="td-height text-custom td-style td-bg">Customs Fees</td>
                      <td class="td-height text-custom"><input class="landingCost" name="customsFees" id="customsFees" autocomplete="off" value="0"/></td>
                  </tr>
                  <tr>
                      <td class="td-height text-custom td-style td-bg">VAT</td>
                      <td class="td-height text-custom"><input class="landingCost" name="vat" id="vat" autocomplete="off" value="0"/></td>
                  </tr>
                  <tr>
                      <td class="td-height text-custom td-style td-bg">Custom Broker Fees</td>
                      <td class="td-height text-custom"><input class="landingCost" name="customBrokerFees" id="customBrokerFees" autocomplete="off" value="0"/></td>
                  </tr>
                  <tr>
                      <td class="td-height text-custom td-style td-bg">Port Handling Fees</td>
                      <td class="td-height text-custom"><input class="landingCost" name="portHandlingFees" id="portHandlingFees" autocomplete="off" value="0"/></td>
                  </tr>
                  <tr>
                      <td class="td-height text-custom td-style td-bg">Storage Fees</td>
                      <td class="td-height text-custom"><input class="landingCost" name="storageFees" id="storageFees" autocomplete="off" value="0"/></td>
                  </tr>
                  <tr>
                      <td class="td-height text-custom td-style td-bg">Inland Transport</td>
                      <td class="td-height text-custom"><input class="landingCost" name="inlandTransport" id="inlandTransport" autocomplete="off" value="0"/></td>
                  </tr>
                  <tr>
                      <td class="td-height text-custom td-style td-bg">Documentation Fees</td>
                      <td class="td-height text-custom"><input class="landingCost" name="documentationFees" id="documentationFees" autocomplete="off" value="0"/></td>
                  </tr>
                  <tr>
                      <td class="td-height text-custom td-style td-bg">Inspection Fees</td>
                      <td class="td-height text-custom"><input class="landingCost" name="inspectionFees" id="inspectionFees" autocomplete="off" value="0"/></td>
                  </tr>
                  <tr>
                      <td class="td-height text-custom td-style td-bg">Bank Fees</td>
                      <td class="td-height text-custom"><input class="landingCost" name="bankFees" id="bankFees" autocomplete="off" value="0"/></td>
                  </tr>
                  <tr>
                      <td class="td-height text-custom td-style td-bg">Currency Conversion Fees</td>
                      <td class="td-height text-custom"><input class="landingCost" name="currencyConversionFees" id="currencyConversionFees" autocomplete="off" value="0"/></td>
                  </tr>
                  <tr>
                      <td class="td-height text-custom td-style td-bg">Others</td>
                      <td class="td-height text-custom"><input class="landingCost" name="others" id="others" autocomplete="off" value="0"/></td>
                  </tr>
                  <tr >
                      <td class="td-height  td-bg" style = "color: white; font-style: normal; font-weight: bold; padding: 8px;">Total Landed Cost</td>
                      <td class="td-height"><input style = " font-weight: bold; " class="landingCostTotal" name="totalLandingCost" id="totalLandingCost" autocomplete="off" value="0" readonly/></td>
                  </tr>
                  <tr>
                      <td class="td-height  td-bg" style = "color: white; font-style: normal; font-weight: bold; padding: 8px; ">Total Landed Cost Per Peice</td>
                      <td class="td-height "><input style = " font-weight: bold; " class="landingCostTotal" name="totalLandingCostPerPiece" id="totalLandingCostPerPiece" autocomplete="off" value="0" readonly/></td>
                  </tr>
              </tbody>
            </table>
          </div>
          <div style="margin-top: 10px; margin-left: 20px" class = "expense-hide" >
            <label class="text-custom"  style="color:var(--primary-color);">Description</label><br>
            <textarea id="description" name = "description" class="item_description expense-hide"></textarea>
          </div>
          <div id="scrollable-div" >
              <div class="imageCard" >
                  <div  style="width:180px; display: flex; flex-direction: column; justify-content: center; align-items: center; border: 2px solid gray; background-color: #151515" class="imageExpense" id="imageExpense">
                      <img src="./assets/img/invoice.png" id= "imagePreview" alt="Image Preview" style = "width: 175px; height: 195px"></img>
                      <p style = "color: red; font-size: 0.80rem" id = "dd_r">Drag or Drop your Receipt</p>
                   </div>   
                   <input type="file" hidden id = "image-input" accept="image/*" name = "image_url">
                   <div class="picture-button-container">
                      <button class="cancelAddProducts " type = "button" id = "open_image" style="margin-right: 10px; width: 200px; height: 40px"><i class = 'bi bi-images'></i>&nbsp; Browse Picture</button>
                      <button class="cancelAddProducts " type = "button" id = "remove_image" style="margin-right: 20px;width: 200px; height: 40px"><i class = 'bi bi-trash'></i>&nbsp; Remove Picture</button>
                    </div>
               </div>
              </div>
              <div style = "margin-left: 20px">
                <p id = "expense_errorMessages" style = "color: red">  
              </div>
              <div class="button-container" style="display:flex;justify-content: space-between; position: fixed;">
                <button  type = "button" class="btn-success-custom btn-error-custom" id = "btn_cancelExpense" style="margin-left:20px; margin-right: 10px; width: 100px; height: 40px">CANCEL</button>
                <button  class="btn-success-custom saveProductsBtn" type = "submit" style="margin-right: 10px; width: 100px; height: 40px">SAVE</button>
              </div>
            </div>
          </div>
          </form>
        </div>
      </div>
    </div>
 
    </div>
  </div>
<!-- </div> -->
<script>

$(document).ready(function(){
  const TAX_RATE = 0.12; 
  $(window).on("click", function(event) {
    if (!$(event.target).hasClass("custom-btn") && !$(event.target).closest('.dropdown-content').length) {
      $(".dropdown-content").each(function() {
        if ($(this).hasClass("show")) {
          $(this).removeClass("show");
        }
      });
    }
  });
  function removeCommas(str) {
      return str.replace(/,/g, '');
  }
  function numberWithCommas(number) 
  {
      var numString = number.toString();
      var parts = numString.split('.');
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      return parts.join('.');
  }
  function sumLandingCost(total)
  {
    $('.landingCost').each(function() {
        var value = parseFloat(removeCommas($(this).val())) || 0;
        total += value;
    });
    $('#totalLandingCost').val(numberWithCommas(total.toFixed(2)));
    var totalLandingCost = total;
    var purchaseQty = parseFloat($("#qty").val());
    var totalLandingCostPerPiece = parseFloat(totalLandingCost / purchaseQty);
    $("#totalLandingCostPerPiece").val(numberWithCommas(totalLandingCostPerPiece.toFixed(2)));
  }
  $('.landingCost').on('input', function(){
    var total = parseFloat(removeCommas($("#vatable_amount").val()));
    sumLandingCost(total);
  })

  function hide_dropdown()
  {
    $(".dropdown-content").each(function() {
      if ($(this).hasClass("show")) {
        $(this).removeClass("show");
      }
    });
  }
  $("#btn_expense_type").on("click", function(event) {
    event.stopPropagation();
    hide_dropdown();
    $("#expense_type_dropdown").toggleClass("show");
  });

  $("#expense_type_dropdown a").on("click", function(event) {
    event.preventDefault();
    $(this).closest('td').removeClass('form-error');
    var value = $(this).data("value");
    var roleName = $(this).text();
    $("#expense_type").val(roleName);
    $("#expense_type_dropdown").removeClass("show")
  });
  $('#expense_type').on('keyup', function() {
      var searchText = $(this).val().toLowerCase();
      $('#expense_type_dropdown a').each(function() {
          var linkText = $(this).text().toLowerCase();
          if (linkText.includes(searchText)) {
            $("#expense_type_dropdown").toggleClass("show");
            $(this).show();
            $(this).closest("td").removeClass('form-error');
          } else {
              $(this).hide();
              $(this).closest("td").addClass('form-error');
          }
      });
  });
  $('#expense_type').on('input', function() {
      if ($(this).val().trim() === '') {
          $('#expense_type_dropdown a').show();
      }
  });

  $("#uomBtn").on("click", function(event) {
    event.stopPropagation();
    hide_dropdown();
    $(".uom_dropdown").toggleClass("show");
  });

  $(".uom_dropdown a").on("click", function(event) {
    event.preventDefault();
    var value = $(this).data("value");
    var roleName = $(this).text();
    $("#uomID").val(value); 
    $("#uomType").val(roleName);
    $(".uom_dropdown").removeClass("show")
  });
  $('#uomType').on('keyup', function() {
    var inputField = $("#uomType");
    var searchText = inputField.val().toLowerCase();
    var foundMatch = false; 

    $('.uom_dropdown a').each(function() {
        var linkText = $(this).text().toLowerCase();
        
        if (linkText.includes(searchText)) {
            $(".uom_dropdown").addClass("show");
            $(this).show();
            foundMatch = true;
        } else {
            $(this).hide();
        }
    });
    if (foundMatch) {
      $(this).closest("td").removeClass('form-error');
    } else {
      $(this).closest("td").addClass('form-error');
    }
  });
  $('#uomType').on('input', function() {
      if ($(this).val().trim() === '') {
          $('.uom_dropdown a').show();
      }
  });

  $("#btn_supplier").on("click", function(event) {
    event.stopPropagation();
    hide_dropdown();
    $("#supplier_dropdown").toggleClass("show");
  });

  $("#supplier_dropdown a").on("click", function(event) {
    event.preventDefault();
    var value = $(this).data("value");
    var roleName = $(this).text();
    $("#supplier_id").val(value); 
    $("#supplier").val(roleName);
    $("#supplier_dropdown").removeClass("show")
  });
  $('#supplier').on('keyup', function() {
      var searchText = $(this).val().toLowerCase();
      var foundMatch = false;
      $('#supplier_dropdown a').each(function() {
          var linkText = $(this).text().toLowerCase();
          if (linkText.includes(searchText)) {
            $("#supplier_dropdown").toggleClass("show");
            $(this).show();
            foundMatch = true;
          } else {
              $(this).hide();
          }
      });
      if (foundMatch) {
        $(this).closest("td").removeClass('form-error');
      } else {
        $(this).closest("td").addClass('form-error');
      }
  });
  $('#supplier').on('input', function() {
      if ($(this).val().trim() === '') {
          $('#supplier_dropdown a').show();
      }
  });


  $("#date_of_transaction").prop("readonly", true).flatpickr({
    dateFormat: "m-d-Y",
    onClose: function(selectedDates) {
    }
  });

  $("#toggleLandingCost").on("change", function(){
    if($(this).is(":checked")) {
      var vatable_amount = parseFloat(removeCommas($("#vatable_amount").val()));
      var qty = parseFloat(removeCommas($("#qty").val()));
      var perPiece = parseFloat(vatable_amount / qty);

      $("#totalLandingCost").val(numberWithCommas(vatable_amount.toFixed(2)));
      $("#totalLandingCostPerPiece").val(numberWithCommas(perPiece.toFixed(2)));
      $("#landingCostDiv").show();
    }
    else $("#landingCostDiv").hide();
  })
  $("#qty, #price, #discount").on("input", function() {
    var price = parseFloat($("#price").val()) || 0;
    var qty = parseFloat($("#qty").val()) || 0;
    var discount = parseFloat($("#discount").val()) || 0;
    var totalLandingCostValue = parseFloat($("#totalLandingCost").val()) || 0;
    
    var total_amount = (qty * price) - discount;
    var newTotalLandingCost = total_amount + totalLandingCostValue;
    $("#total_amount").val(numberWithCommas(total_amount.toFixed(2)));

    sumLandingCost(total_amount);

    if ($("#toggleTaxIn").is(":checked")) {
      computeTax(total_amount);
    }
    else
    {
      $("#vatable_amount").val(numberWithCommas(total_amount.toFixed(2)));
    }
  });
  $("#toggleTaxIn").on("change", function(){
    var total_amount = parseFloat(removeCommas($("#total_amount").val()));
    if($(this).is(":checked"))
    {
      computeTax(total_amount);
      $("#isVatable").val("1");
    }
    else
    {
      $("#isVatable").val("0");
      $("#vatable_amount").val(numberWithCommas(total_amount));
    }
    var vatable_amount = parseFloat(removeCommas($("#vatable_amount").val()));
    sumLandingCost(vatable_amount);
  })
  function computeTax(amount)
  {
    var currentAmount = parseFloat(amount);
    var tax_amount = parseFloat(amount / 1.12);
    var tax = parseFloat(tax_amount * 0.12);
    var vatable_amount = parseFloat(currentAmount + tax);
    $("#vatable_amount").val(numberWithCommas(vatable_amount.toFixed(2)));
  }


// function computeTax(amount) {
//   const taxAmount = amount / (1 + TAX_RATE);
//   const tax = taxAmount * TAX_RATE;
//   const vatableAmount = amount + tax;
//   const total = parseFloat()
//   $("#vatable_amount").val(vatableAmount.toFixed(2));
// }
  function computeInclusive(amount)
  {
    var currentAmount = parseFloat(amount);
    var tax_amount = parseFloat(amount / 1.12)
    var tax = parseFloat(tax_amount * 0.12);
    var vatable_amount = parseFloat(currentAmount - tax);
    $("#vatable_amount").val(numberWithCommas(vatable_amount.toFixed(2)));
  }
  $("#price, #discount, #qty").on("input", function() {
    var value = parseFloat(removeCommas($(this).val()));
    var formatted = value.replace(/[^0-9.]/g, '');
    var decimalIndex = formatted.indexOf('.');
    if (decimalIndex !== -1) {
      var decimalPart = formatted.substring(decimalIndex + 1);
      if (decimalPart.length > 2) {
        formatted = formatted.substring(0, decimalIndex + 3);
      }
    }
    $(this).val(formatted);
  });


  $("#total_amount").on("input", function() {
    var input = parseFloat(removeCommas($(this).val()));
    var formatted = input.replace(/[^0-9.]/g, '');
                
    var decimalIndex = formatted.indexOf('.');
    if (decimalIndex !== -1) {
        var decimalPart = formatted.substring(decimalIndex + 1);
        if (decimalPart.length > 2) {
            formatted = formatted.substring(0, decimalIndex + 3);
        }
    }
    $(this).val(formatted);
  });

  $("#open_image").on("click", function() {
    $("#image-input").click();
  });

  $("#image-input").on("change", function() {
    var file = this.files[0];
    $("#dd_r").hide();
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $("#imagePreview").attr("src", e.target.result).show();
        };
        reader.readAsDataURL(file);
    } else {
        $("#imagePreview").hide();
    }
  });
  $("#remove_image").on("click", function() {
    $("#imagePreview").attr("src", "./assets/img/invoice.png").show(); 
    $("#image-input").val(''); 
    $("#dd_r").show();
  });
  $("#btn_cancelExpense").on("click", function(){
    $("#expense_form")[0].reset();
    $("#expense_id").val("");
    hide_modal();
  })
  function hide_modal()
  {
    $("#add_expense_modal").addClass('slideOutRight');
    $(".expense_content").addClass('slideOutRight');
    setTimeout(function () {
      $("#add_expense_modal").removeClass('slideOutRight');
      $("#add_expense_modal").hide();
      $(".expense_content").removeClass('slideOutRight');
      $(".expense_content").hide();
    }, 100);
    $("#searchInput").focus();
  }
 
})

$(document).ready(function() {
  $('#imageExpense').on('dragover', function(e) {
    e.preventDefault();
    $(this).addClass('dragover');
  });

  $('#imageExpense').on('dragleave', function(e) {
    e.preventDefault();
    $(this).removeClass('dragover');
  });

  $('#imageExpense').on('drop', function(e) {
    e.preventDefault();
    $(this).removeClass('dragover');
    var file = e.originalEvent.dataTransfer.files[0];

    if (file.type.match('image.*')) {
      $("#dd_r").hide();
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#imagePreview').attr('src', e.target.result);
      };
      reader.readAsDataURL(file);
      $('#image-input').val(file);
    } else {
      show_errorResponse("Only images are allowed.")
    }
  });
  function show_errorResponse(message) 
  {
    toastr.options = {
      "onShown": function () {
        $('.custom-toast').css({
          "opacity": 1,
          "width": "600px",
          "text-align": "center",
          "border": "2px solid #1E1C11",
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
      "onclick": function () {}

    };
    toastr.error(message);
  }
});
</script>

