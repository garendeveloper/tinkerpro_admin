<style>
    tr:hover {
        background-color: #151515;
        cursor: pointer;
    }
    #po_form input, label{
        font-size: 14px;
    }
    #tbl_purchaseOrders tbody{
        font-size: 12px;
    }
    #tbl_purchaseOrders thead th{
       border: none;
       color: var(--primary-color);
    }
    #tbl_purchaseOrders thead{
       border: 1px solid var(--primary-color);
    }
    #tbl_purchaseOrders tbody td{
        border: none;
    }

    #tbl_purchaseOrders_footer thead{
        font-size: 12px;
    }
    #tbl_purchaseOrders_footer thead th{
       border: none;
       color: var(--primary-color);
    }
    #tbl_purchaseOrders_footer thead{
       border: 1px solid var(--primary-color);
    }
    .custom-select {
        position: relative;
        display: inline-block;
    }

    .custom-select select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        padding-right: 25px;
        text-indent: 0.5em;
        padding: 5px 5px;
        
    }
    .custom-select select option{
      padding: 10px 10px;
    }

    .custom-select select option:hover{
      background-color: var(--primary-color);
    }

    .custom-select i {
        position: absolute;
        top: 50%;
        right: 5px;
        transform: translateY(-50%);
    }
    #date_purchased {
        outline: none; 
    }

    #date_purchased:focus {
        outline: none;
    }

    #tbl_purchaseOrders tbody th,
    #tbl_purchaseOrders tbody td {
        padding: 8px 8px; 
        height: 30px; 
        line-height: 0.5; 
    }
    #tbl_purchaseOrders {
        border: none;
    }

    .date-input-container {
      position: relative;
      display: inline-block;
      width: 250px; 
  }
.date-input-container input {
    width: 100%;
    height: 45px;
    padding-right: 30px; 
    box-sizing: border-box; 
    text-align: center;
    font-size: 16px; 
}
.calendar-icon {
    position: absolute;
    right: 10px; 
    top: 50%;
    transform: translateY(-50%); 
    cursor: pointer;
    font-size: 2em; 
    color: #ffffff; 
}
table thead th{
    color: #ffffff;
}
.group {
        display: inline-block;
        margin-right: 3px;
    }
    .f1 {
        display: flex;
        align-items: center; 
        gap: 20px; 
    }

    .f1 .group {
        display: flex;
        align-items: center;
    }

    .f1 .date-input-container {
        display: flex;
        align-items: center;
    }

    .f1label {
        margin: 0 10px 0 0;
    }

    .f1 input[type="text"] {
        height: 30px;
        margin-right: 10px;
    }

    .f1.date-input-container input[type="text"] {
        height: 30px;
        margin-right: 5px;
    }

  .switch {
      display: flex;
      align-items: center;
      margin-left: 10px; 
  }

  .calendar-icon {
      font-size: 40px; 
      margin-left: 5px;
  }
  .bottom-area {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 10px;
    border-top: 1px solid #ccc;
    }

    .bottom-area {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    }
</style>
<div class="fcontainer" id = "purchaseItems_div" style = "display: none">
    <form id="po_form">
        <input type="hidden" name="order_id" id="_order_id" value="0">
        <input type="hidden" name="inventory_id" id="_inventory_id" value="0">
        <div class="fieldContainer f1">
            <label for="pcs_no">PO#</label>
            <input type="text" name="po_number" id="pcs_no" onkeyup="$(this).removeClass('has-error')" readonly />

            <div class="group">
                <label for="negative_inventory" style="margin-right: 10px;"><strong style="color: #ffff; font-size: 12px;">Paid</strong></label>
                <label class="switch">
                    <input type="checkbox" id="paidSwitch" name="isPaid"  checked>
                    <span class="slider round"></span>
                </label>
            </div>

            <div class="date-input-container">
                <input type="text" name="date_purchased" id="date_purchased" placeholder="Select date" readonly>
                <i id="calendar-btn" class="bi bi-calendar3 calendar-icon" aria-hidden="true"></i>
            </div>
        </div>
        <div class="fieldContainer" style = "margin-top: 2px;">
            <label>Supplier</label>
            <div class="custom-select" style="margin-right: 0px; ">
                <select name="supplier" id = "supplier"
                    style=" background-color: #262626; color: #ffff; width:390px; font-size: 14px; height: 30px;">
                </select>
                <i class="bi bi-chevron-double-down"></i>
            </div>
          
        </div>
        <div class="fieldContainer" style = "margin-top: -3px;">
            <input type = "hidden" id = "selected_product_id" value = "0" >
             <label>
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="50" fill="#fff" class="bi bi-upc-scan" viewBox="0 0 16 16">
                <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5M3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0z"/>
              </svg>
             </label>
            <div class="search-container">
                <input type="text" style="width: 280px; height: 30px;" class="search-input italic-placeholder"
                    placeholder="Search Product,[Name, Barcode, Brand]" name="product" onkeyup="$(this).removeClass('has-error')" id="product"
                    autocomplete="off" autofocus="autofocus" >
            </div>
            <button style=" height: 30px; width: 120px; font-size: 12px;" id="btn_addPO">
                    Add Product</button>
        </div>
    </form>
    <table  class="text-color table-border tableHead" style = "margin-top: -3px;">
        <thead>
            <tr>
                <th style="background-color: #1E1C11; width: 50%; color: #ffffff">ITEM DESCRIPTION</th>
                <th style="background-color: #1E1C11; color: #ffffff ">QTY</th>
                <th style="background-color: #1E1C11; color: #ffffff">PRICE</th>
                <th style="background-color: #1E1C11; color: #ffffff" colspan = "2">TOTAL</th>
            </tr>
        </thead>
    </table>
    <div class = "scrollable" style = "height: 52vh">
      <table id="tbl_purchaseOrders" class="text-color table-border" style = "margin-top: -3px;">
          <tbody id="po_body" style="border-collapse: collapse; border: none">

          </tbody>
      </table>
    </div>
    <div style="position: absolute;padding: 3px; width: 100%;" class = "bottom-area">
      <table id = "tbl_purchaseOrders_footer" class="text-color table-border" >
          <thead>
              <tr>
                  <th style="background-color: #1E1C11;  text-align: left; width: 50%; color: #ffffff"
                      id="totalTax">Tax: 0.00</th>
                  <th style="background-color: #1E1C11;  text-align: right; color: #ffffff" id="totalQty">0</th>
                  <th style="background-color: #1E1C11; text-align: right; color: #ffffff" id="totalPrice">
                      &#x20B1;&nbsp;0.00</th>
                  <th style="background-color: #1E1C11;  text-align: right; color: #ffffff" id="overallTotal">
                      &#x20B1;&nbsp;0.00</th>
                  <th style="background-color: #1E1C11;  text-align: right; color: #ffffff" id="overallTotal">
                </th>
              </tr>
          </thead>
      </table>
    </div>
</div>


<script>
    $(document).ready(function(){
        var productsCache = [];
        $("#btn_omPayTerms").off('click').on("click", function(e){
        e.preventDefault();
        $("#unpaid_purchase_modal").fadeIn(200);
      })
      
      show_allProducts();
      $('#prod_form input').on('keypress', function(event) {
          if (event.keyCode === 13) {
            $(this).submit();
            $("#product").focus();
            $('#calendar-btn').prop('disabled', false);
            $('#tbl_purchaseOrders').click();
            updateTotal();
          }
      });
      function validatePurchaseQtyModal() {
        var isValid = true;
        $('#po_form input[type=text], #po_form input[type=date]').each(function () {
          if ($(this).val() === '') {
            isValid = false;
            $(this).addClass('has-error');
          }
          else {
            $(this).removeClass('has-error');
          }
        });

        return isValid;
      }
      $("#btn_addPO").off("click").on("click",function (e) {
        e.preventDefault();
        var product = $("#product").val();
        var product_id = $("#selected_product_id").val();

        if (validatePurchaseQtyModal())
        {
          if(product_id !== "0" && product_id !== "")
          {
            if (!isDataExistInTables(product_id)) {
          
                var qty = 0;
                var price = 0;
                hidePopups();
                show_purchaseQtyModal(product_id, qty, price);
            
            }
            else {
              show_errorResponse("Item is already in the table");
            }
          }
          else {
              show_errorResponse("Product not found.");
          }
        }
      })
      $("#tbl_purchaseOrders tbody").on("dblclick", "tr", function() {
          $("#prod_form #p_qty").focus();
          var productId = $(this).data("rowid");
          var qty_purchased = $(this).find("td:nth-child(2)").text();
          var price = clean_number($(this).find("td:nth-child(3)").text());

          $("#selected_product_id").val(productId);
          show_purchaseQtyModal(productId, qty_purchased, price);
      });
      $("#tbl_purchaseOrders tbody").off('click').on("click", "#removeOrder", function(){
        reset_poFooter();
            $(this).closest('tr').remove();
            updateTotal();
        });
    function isDataExistInTables(data) {
      var $matchingRow = $('#tbl_purchaseOrders tbody td[data-rowid="' + data + '"]').closest('tr');
      return $matchingRow.length > 0;
      }
        function show_allProducts() 
        {
            $.ajax({
            type: 'GET',
            url: 'api.php?action=get_allProducts',
            success: function (data) {
                for (var i = 0; i < data.length; i++) 
                {
                    var row = {
                        inventory_id: data[i].inventory_id,
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
        function filterProducts(term) {
            var regexPattern = term
                .replace(/_/g, '.') 
                .replace(/%/g, '.*'); 

            var regex = new RegExp('^' + regexPattern, 'i'); 

            return productsCache.filter(function(row) {
                var productMatch = row.product && regex.test(row.product);
                var barcodeMatch = row.barcode && regex.test(row.barcode);
                var brandMatch = row.brand && regex.test(row.brand);

                return productMatch || barcodeMatch || brandMatch;
            }).map(function(row) {
                var brand = row.brand === null ? " " : "( " + row.brand + " )";
                return {
                    label: row.product,
                    value: row.product,
                    inventory_id: row.inventory_id,
                    id: row.product_id
                };
            });
        }
      $("#product").on("input", function(e) {
        e.preventDefault();
          var term = $(this).val();
          $(this).autocomplete('search', term);
      });
        $("#product").on("keypress", function(event){
        if(event.which === 13 ){
          var product_id = $("#selected_product_id").val();
          if(validatePurchaseQtyModal())
          {
            if(product_id !== "" && product_id !== "0")
            {
              if (!isDataExistInTables(product_id)) {
                var qty = 0;
                var price = 0;
                hidePopups();
                show_purchaseQtyModal(product_id, qty, price);
              }
              else
              {
                show_errorResponse("Product already exists in the purchase table")
              }
            }
            else
            {
              show_errorResponse("Product not found.")
            }
          }
        }
      
      })
    
      function check_ifProductCacheExists(product_id)
      {
        var searchDataExists = false;
 
        $.each(productsCache, function(index, item){
            if(item.product_id === product_id){
                searchDataExists = true;
                return false; 
            }
        });
        return searchDataExists;
      }
      function hidePopups() {
        $('#date_purchased').attr('readonly', true);
        $('#calendar-btn').prop('disabled', true);
      }
      function clean_number(number) {
        return number.replace(/[₱\s]/g, '');
      }

    function updateTotal() {
  
      var totalQty = 0;
      var totalPrice = 0;
      var total = 0;
      var totalTax = 0;

         
      $('#tbl_purchaseOrders tbody tr').each(function () {
        var quantity = parseInt($(this).find('td:nth-child(2)').text().trim());
        var price = parseFloat(clean_number($(this).find('td:nth-child(3)').text().trim()));
        var subtotal = parseFloat(clean_number($(this).find('td:nth-child(4)').text().trim()));
        var tax = (price / 1.12);
        totalTax += (price - tax);
        totalQty += quantity;
        totalPrice += price;
        total += subtotal;
      });
      $("#totalTax").html("Tax: " + addCommasToNumber(totalTax));
      $("#totalQty").html(totalQty);
      $("#totalPrice").html("&#x20B1;&nbsp;" + addCommasToNumber(totalPrice));
      $("#overallTotal").html("&#x20B1;&nbsp;" + addCommasToNumber(total));
    
      }
      function show_purchaseQtyModal(product_id, qty, price )
      {
        if(product_id !== "" && product_id !== "0")
        {
          hidePopups();
          
          $("#selected_product_id").val(product_id);
          $("#purchaseQty_modal").fadeIn(200);
          $.ajax({
            type: 'get',
            url: 'api.php?action=get_productInfo',
            data: { data: product_id },
            success: function (data) {
         
              var _price = price === 0 ? data['cost'] : price;
              var _qty = qty === 0 ? data['qty_purchased'] : qty;
              $(".product_name").text('"'+data['prod_desc']+'"');
              $(".barcode_val").text('"'+data['barcode']+'"');
              $("#purchaseQty_modal #price").val(_price);
              var src = "./assets/img/no-image.png";
              if(data['productImage'] !== null && data['productImage'] !== "") src  = "./assets/products/"+data['productImage'] 
              $(".productImage").attr("src", src);
            }
          });
          
          $("#prod_form #p_qty").focus();
    
        }
        else
        {
          show_errorResponse("Product not found.")
        }
      }
      
      $("#product").autocomplete({
        minLength: 1,
        source: function (request, response) {
          var term = request.term;
          var filteredProducts = filterProducts(term);
          var slicedProducts = filteredProducts.slice(0, 5);
          response(slicedProducts);
          if (slicedProducts.length > 0) {
            $('#filters').show();
          } else {
              $('#filters').hide();
          }
          hidePopups();
            var slicedProductsLength = slicedProducts.length - 1;
            var selectedProductId = slicedProducts[slicedProductsLength].id;
            $("#selected_product_id").val(selectedProductId);
          },
          select: function (event, ui) {
            var selectedProductId = ui.item.id;
            $("#selected_product_id").val(selectedProductId);
            if(validatePurchaseQtyModal())
            {
              hidePopups();
              if(selectedProductId !== "" && selectedProductId !== "0")
              {
                  $("#prod_form .pqty").focus();
                if (!isDataExistInTables(selectedProductId)) {
                  var qty = 0;
                  var price = 0;
                  show_purchaseQtyModal(selectedProductId, qty, price);
                }
                else
                {
                  show_errorResponse("Product already exists in the purchase table")
                }
              }
              return false;
            }
           
          },
      });
      function validateProductForm() {
        var isValid = true;
        $('#prod_form input[type=text]').each(function () {
          if ($(this).val() === '') {
            isValid = false;
            $(this).addClass('has-error');
          }
          else {
            $(this).removeClass('has-error');
          }
        });

        return isValid;
      }
      function reset_poFooter()
      {
        $("#totalTax").html("Tax: 0.00");
        $("#totalQty").html("0");
        $("#totalPrice").html("0.00");
        $("#overallTotal").html("0.00");
      }
      $("#prod_form").on("submit", function (event) {
        event.preventDefault();
   
        if (validateProductForm()) {
          var p_qty = parseFloat($("#p_qty").val());
          var price = parseFloat($("#price").val());
          var product_id = $("#selected_product_id").val();
          var total = (price * p_qty);
          $.ajax({
            type: 'get',
            url: 'api.php?action=get_productInfo',
            data: { data: product_id },
            success: function (data) {
              var tax = 0;
              if (data['isVat'] === 1) {
                tax = (price / 1.12);
                totalTax += (price - tax);
              }


              var $rowToUpdate = $("#tbl_purchaseOrders tbody").find("tr[data-rowid='" + product_id + "']");
                if ($rowToUpdate.length > 0) {
                    $rowToUpdate.find("td").eq(0).text(data['prod_desc']);
                    $rowToUpdate.find("td").eq(1).text(p_qty); 
                    $rowToUpdate.find("td").eq(2).html("&#x20B1;&nbsp;" + addCommasToNumber(price)); 
                    $rowToUpdate.find("td").eq(3).html("&#x20B1;&nbsp;" + addCommasToNumber(total)); 
                } 
              else
              {
                $("#tbl_purchaseOrders tbody").append(
                  "<tr data-rowid = "+data['id']+">" +
                  "<td style = 'width: 55%' data-rowid = "+data['id']+" data-id = " + data['id'] + " data-inv_id = " + data['inventory_id']+ " data-qty = " + p_qty+ " data-price = " + price + " >" + data['prod_desc'] + "</td>" +
                  "<td style = 'text-align: center; width: 10%' class ='editable'>" + p_qty + "</td>" +
                  "<td style = 'text-align: right; width: 10%' class ='editable'>&#x20B1;&nbsp;" + addCommasToNumber(price) + "</td>" +
                  "<td style = 'text-align: right; width: 10%'>&#x20B1;&nbsp;" + addCommasToNumber(total) + "</td>" +
                  "<td style = 'text-align: right;  width: 10%'><i class = 'bi bi-trash' id = 'removeOrder'></i></td>"+
                  "</tr>"
                );
              }
              

                var totalQty = 0;
                var totalPrice = 0;
                var overalltotal = 0;
                var totalTax = 0;

              $("#purchaseQty_modal").hide();
              $("#prod_form")[0].reset();
              $("#product").val("");
              $("#item_verifier").val("");
              var totalQty = 0;
                var totalPrice = 0;
                var overalltotal = 0;
                var totalTax = 0;


                $('#tbl_purchaseOrders tbody tr').each(function () {
                  var quantity = parseInt($(this).find('td:nth-child(2)').text().trim());
                  var price = parseFloat(clean_number($(this).find('td:nth-child(3)').text().trim()));
                  var subtotal = parseFloat(clean_number($(this).find('td:nth-child(4)').text().trim()));
                  var tax = (price / 1.12);
                  totalTax += (price - tax);
                  totalQty += quantity;
                  totalPrice += price;
                  overalltotal += subtotal;
                });
                $("#totalTax").html("Tax: " + addCommasToNumber(totalTax));
                $("#totalQty").html(totalQty);
                $("#totalPrice").html("&#x20B1;&nbsp;" + addCommasToNumber(totalPrice));
                $("#overallTotal").html("&#x20B1;&nbsp;" + overalltotal);
            }
          })

          
          $("#product").val('');
            $("#selected_product_id").val("0");
        }
      })
    
    })
</script>