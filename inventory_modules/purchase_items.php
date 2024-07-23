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
       color: #FF6900;
    }
    #tbl_purchaseOrders thead{
       border: 1px solid #FF6900;
    }
    #tbl_purchaseOrders tbody td{
        border: none;
    }

    #tbl_purchaseOrders_footer thead{
        font-size: 12px;
    }
    #tbl_purchaseOrders_footer thead th{
       border: none;
       color: #FF6900;
    }
    #tbl_purchaseOrders_footer thead{
       border: 1px solid #FF6900;
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
    }

    .custom-select i {
        position: absolute;
        top: 50%;
        right: 5px;
        transform: translateY(-50%);
    }
    #date_purchased {
        outline: none; /* Remove default focus outline (optional) */
    }

    #date_purchased:focus {
        outline: none; /* Remove focus outline when element is focused (optional) */
    }

    #tbl_purchaseOrders tbody th,
    #tbl_purchaseOrders tbody td {
        padding: 5px 5px; 
        height: 20px; 
        line-height: 0.5; 
    }
    #tbl_purchaseOrders {
        border: none;
    }
</style>
<div class="fcontainer" id = "purchaseItems_div" style = "display: none">
    <form id="po_form">
        <input type="hidden" name="order_id" id="_order_id" value="0">
        <input type="hidden" name="inventory_id" id="_inventory_id" value="0">
        <div class="fieldContainer" >
            <label>PO#</label>
            <input type="text" name="po_number" id="pcs_no" onkeyup="$(this).removeClass('has-error')" style="height: 30px;" value=""
                readonly />
            <div class="toggle-switch-container">
                <label for="paidSwitch" class="switch-label" style="color: #28a745; ">Paid</label>
                <div class="form-check form-switch" style="margin-left: 15px; ">
                    <input class="form-check-input" type="checkbox" id="paidSwitch" name="isPaid" style="height: 15px;">
                </div>
            </div>
            <div class="date-input-container">
                <input type="text" name="date_purchased" id="date_purchased" placeholder="Select date" readonly>
                <button id="calendar-btn" class="button">
                    <i class="bi bi-calendar" aria-hidden="true"></i>
                </button>
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
            <!-- <label><img src="assets/img/barcode.png" style="color: white; height: 50px; width: 40px;"></label> -->
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
    <table id="tbl_purchaseOrders" class="text-color table-border" style = "margin-top: -3px;">
        <thead>
            <tr>
                <th style="background-color: #1E1C11; width: 50%">ITEM DESCRIPTION</th>
                <th style="background-color: #1E1C11;  ">QTY</th>
                <th style="background-color: #1E1C11; ">PRICE</th>
                <th style="background-color: #1E1C11;" colspan = "2">TOTAL</th>
            </tr>
        </thead>
        <tbody id="po_body" style="border-collapse: collapse; border: none">

        </tbody>
    </table>
    <table id = "tbl_purchaseOrders_footer" class="text-color table-border" style="position: absolute; bottom: 5px; padding: 10px;">
        <thead>
            <tr>
                <th style="background-color: #1E1C11;  text-align: left; width: 50%"
                    id="totalTax">Tax: 0.00</th>
                <th style="background-color: #1E1C11;  text-align: right" id="totalQty">0</th>
                <th style="background-color: #1E1C11; text-align: right" id="totalPrice">
                    &#x20B1;&nbsp;0.00</th>
                <th style="background-color: #1E1C11;  text-align: right" id="overallTotal">
                    &#x20B1;&nbsp;0.00</th>
                <th style="background-color: #1E1C11;  text-align: right" id="overallTotal">
               </th>
            </tr>
        </thead>
    </table>
</div>


<script>
    $(document).ready(function(){
        var productsCache = [];
        $("#btn_omPayTerms").off('click').on("click", function(e){
        e.preventDefault();
        $("#unpaid_purchase_modal").slideDown({
            backdrop: 'static',
            keyboard: false,
        });
      })
      show_allProducts();
      $("#tbl_purchaseOrders tbody").off('click').on("click", "#removeOrder", function(){
            $(this).closest('tr').remove();
            updateTotal();
        });
    function isDataExistInTables(data) {
        var data = data;
        var isExist = false;
        $('#tbl_purchaseOrders tbody').each(function () {
          var rowData = $(this).find('td:first').data('rowid');
          if (rowData == data) {
            isExist = true;
          }
        });
        return isExist;
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
                  inventory_id: row.inventory_id,
                  id: row.product_id
              };
          });
      }

        $("#product").on("keypress", function(event){
        if(event.which === 13){
          $('#date_purchased').attr('readonly', true);
          $('#calendar-btn').attr('readonly', true);
          hidePopups();
          var product_id = $("#selected_product_id").val();
          if(product_id !== "" && product_id !== "0")
          {
            if (!isDataExistInTables(product_id)) {
              var qty = 0;
              var price = 0;
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
          $("#product").val('');
          $("#selected_product_id").val();
        }
      
      })

    //   $("#product").on("autocompletechange", function(event, ui) {
    //     var product_id = $("#selected_product_id").val();
    //     hidePopups();
    //     if(product_id !== "" || product_id !== "0")
    //     {
          
    //       if (!isDataExistInTables(product_id)) {
    //         var qty = 0;
    //         var price = 0;
    //         show_purchaseQtyModal(product_id, qty, price);
    //       }
    //       else
    //       {
    //         show_errorResponse("Product already exists in the purchase table")
    //       }
    //     }
    //     $("#selected_product_id").val("0");
    //     $("#product").val("");
    //   });
    
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
        $('#calendar-btn').prop('disabled', true);
        $("#p_qty").focus();
      }
    //   $('#product').on('keypress', function(event) {
    //     if (event.keyCode === 13 || event.keyCode === 27) { 
    //     hidePopups();
    //     }
    // });
    function updateTotal() {
        var totalQty = 0;
        var totalPrice = 0;
        var total = 0;
        var totalTax = 0;
        $('#tbl_purchaseOrders tbody tr').each(function () {
          var quantity = parseInt($(this).find('td:nth-child(2)').text().trim(), 10);
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
        hidePopups();
        $("#p_qty").focus();
        if(product_id !== "" && product_id !== "0")
        {
          $("#selected_product_id").val(product_id);
          $("#purchaseQty_modal").slideDown({
            backdrop: 'static',
            keyboard: false,
          });
          $.ajax({
            type: 'get',
            url: 'api.php?action=get_productInfo',
            data: { data: product_id },
            success: function (data) {
         
              var _price = price === 0 ? data['cost'] : price;
              var _qty = qty === 0 ? data['qty_purchased'] : qty;
              $("#product_name").text(data['prod_desc'] + " : " + data['barcode']);
              $("#purchaseQty_modal #p_qty").val(_qty);
              $("#purchaseQty_modal #price").val(_price);
              $("#pqty_modalTitle").html("<i class = 'bi bi-exclamation-triangle style = 'color: red;'></i>&nbsp; <strong style = 'color:  #ffff'>ATTENTION REQUIRED!</strong> ");
            }
          });
        }
        else
        {
          show_errorResponse("Product not found.")
        }
      }
      
      $("#product").autocomplete({
        minLength: 2,
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
            hidePopups();
            var selectedProductId = ui.item.id;
            $("#selected_product_id").val(selectedProductId);
            if(selectedProductId !== "" && selectedProductId !== "0")
            {
                $("#prod_form #p_qty").focus();
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
          },
      });
     
     
      $("#btn_addPO").click(function (e) {
        e.preventDefault();
        var product = $("#product").val();
        var product_id = $("#selected_product_id").val();
        if(product_id !== "0" && product_id !== "")
        {
          if (!isDataExistInTables(product_id)) {
            if (validatePOForm()) {
              var qty = 0;
              var price = 0;
              hidePopups();
              show_purchaseQtyModal(product_id, qty, price);
            }
          }
          else {
            show_errorResponse("Item is already in the table");
          }
        }
        else {
            show_errorResponse("Product not found.");
        }
        $("#product").val("");
        $("#selected_product_id").val("0");
      })
    })
</script>