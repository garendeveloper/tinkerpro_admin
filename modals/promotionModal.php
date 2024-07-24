<style>
    .promotionModal {
        display: none;
        position: fixed;
        z-index: 99;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    #promotionModal .modal-content {
        background-color: #333333;
        margin: 10% auto;
        max-width: 430px;
        height: 490px;
        max-height: 100%;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    @media screen and (max-width: 768px) {
        #promotionModal .modal-content {
            margin: 30% auto;
        }
    }

    #promotionModal .modal-header {
        background-color: black;
        height: 20px;
        font-size: 11px;
        color: #FF6900;
    }

    #promotionModal .modal-header,
    .modal-body {
        border: none;
    }

    /* #promotionModal .modal-body {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-gap: 15px;
        position: relative;
    } */

    #promotionModal p {
        font-size: 10px;
    }

    .image img {
        height: 160px;
        width: 160px;
        border: 1px solid #ccc;
    }

    #promotionModal #btn_cancel,
    #btn_print {
        border-radius: 3px;
        border: 1px solid #ccc;
        height: 30px;
        width: 70px;
        background-color: #333333;
    }

    #promotionModal #btn_cancel:hover {
        background-color: red;
    }

    #promotionModal #btn_print:hover {
        background-color: green;
    }

    #promotionModal .action-button {
        position: absolute;
        right: 180px;
    }

    #promotionModal .firstCard button h6,
    button p {
        margin-bottom: 0;
    }

    #promotionModal p {
        font-weight: normal;
    }
    .tinker_label{
      color: #fff;
    }
    .stockeable {
      position: relative;
      display: inline-block;
      width: 40px; 
      height: 20px; 
      outline: none; 
      margin-left: 10px;
    }

.stockeable input {
  opacity: 0;
  width: 0;
  height: 0;
}

.stockeableSpan {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #262626;
  -webkit-transition: .4s;
  transition: .4s;
  outline: none;
  border-radius: 10px; 
}

.stockeableSpan:before {
  position: absolute;
  content: "";
  height: 16px; 
  width: 16px;
  left: 2px; 
  bottom: 2px;
  background-color: #888888;
  -webkit-transition: .4s;
  transition: .4s;
  border-radius: 50%; 
}

input:checked + .stockeableSpan {
  background-color: #FF6900;
}

input:focus + .stockeableSpan {
  box-shadow: 0 0 1px #262626;
}

input:checked + .stockeableSpan:before {
  -webkit-transform: translateX(20px); 
  -ms-transform: translateX(20px);
  transform: translateX(20px); 
}

.stockeableSpan.round {
  border-radius: 10px; 
}

.stockeableSpan.round:before {
  border-radius: 50%; 
}

.stockeableSpan.active {
  background-color: #FF6900;
}
textarea::placeholder{
  font-size: 12px;
}
.inputAmount{
  text-align: right;
  height: 50px;
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
    color: #fff;
    transform: translateY(-50%);
}

.col-md-12{
  margin-bottom: 10px;
}


.myModalBody, .myContent {
  background: #333333;
  border-radius: 10px;
}

.my-content label{
  font-size: 14px;
}


.promotionList {
  border: 1px solid var(--border-color); 
  padding: 8px; 
  border-radius: 5px;
}

#tbl_bundled tbody td{
  border: 1px solid #333333;
  color: white;
  line-height: 0.5;
  height: 5px;
  padding: 2px 2px;
}
</style>

<div id="promotionModal" class="modal">
    <div class="modal-content">
        <div class="modal-header" style = "background-color: #333333;padding: 20px; ">
            <h6 style = "color: var(--primary-color); font-weight: bold; margin-left: -10px;" class = "product_name"></h6>
            <span id="close-modal">
              <i class="bi bi-x" aria-hidden="true" style = "font-size: 30px; font-weight: bold"></i>
            </span>
        </div>
        <form class = "promotionForm">
          <input type="hidden" name = "product_id" class = "product_id">
          <input type="hidden" name = "promotion_id" class = "promotion_id" value = "">
          <input type="hidden" name = "promotion_type" value = "2" class = "_promotionType">
          <div class="modal-body" style = "padding: 10px;">
            <div class="row">
              <div class="col-md-12">
                  <label class = "tinker_label" for=""  style = "margin-right: 110px;">Apply to QTY</label>
                  <input  type="number" name = "qty" id = "qty" class = "inputAmount"  style ="height: 40px;" autocomplete="off">
              </div>
              <div class="col-md-12" >
                  <label class = "tinker_label" for="" style = "margin-right: 42px;">New price per bundle</label>
                  <input type="text" name = "newprice" id = "newprice" class = "inputAmount" style ="height: 40px;"  autocomplete="off"/>  
              </div>
            </div>
            <div class = "row" style = "padding: 10px;">
              <div class="table-cotainer p-2">
                <div class="d-flex justify-content-between align-items-center">
                    <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="45" height="35" fill="var(--text-color)" class="bi bi-upc-scan" viewBox="0 0 16 16">
                        <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5M3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0z"/>
                    </svg>
                    <input type="hidden" class="w-100 search_product_b_id me-2 ms-2">
                    <input type="text"  placeholder="SEARCH BARCODE/CODE/NAME" style = "height: 40px" class="w-100 search_product_b ">
                    <div class="btn-container">
                        <button class="btn btn-secondary" id= "btn_addBProduct">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-plus" viewBox="0 0 16 16">
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                </svg>
                            </span>
                        </button>
                    </div>
                  </div>
                </div>
            </div>
            <div class="row bundledDiv" style = "margin-top: -5px; border: 1px solid #757575 !important; margin-left: 3px; margin-right: 3px; height: 150px;overflow: auto; ">
              <div class = "table-responsive" >
                <table  style="width: 100%; border: collapse;  font-size: 12px;" id = "tbl_bundled">
                    <thead style = "font-weight: bold">
                      <tr>
                        <th style = "background-color: #333333; border: 1px solid #333333">BUNDLES</th>
                        <th style = "background-color: #333333; border: 1px solid #333333; text-align: center;">QTY</th>
                        <th style = "background-color: #333333; border: 1px solid #333333; text-align: center">ACTION</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                </table>
              </div>
            </div>
            <div class="row" style = "margin-top: 10px;">
              <div class="col-md-12" >
                  <div class="barcode-container">
                    <label class="tinker_label" for="newbarcode" style="margin-right: 24px;">Generate New Barcode</label>
                    <div class="input-icon-wrapper">
                      <input type="text" name="newbarcode" id="newbarcode" style = "text-align: center; height: 40px;" class="inputAmount displayBarcode"  autocomplete="off"/>
                      <div class="generate-button">
                        <i class="bi bi-arrow-down-circle"></i>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12" style = "padding: 10px; bottom: 0px;">
                  <button class = "button submitPromotion" type = "submit" style = "width: 100%; background-color: var(--primary-color); border-radius: 5px; margin-bottom:5px;">UPDATE</button>
              </div>
            </div>
        </div>
      </form>
    </div>
</div>



<div id="promoteModal" class="modal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content myContent">
          <div class="modal-body myModalBody" >

            <!-- My temporar header -->
            <div class="d-flex justify-content-between text-light">
              <label for="">ADD PREDEFINED PROMOTION</label>
              <label class="closeModalPromotion" style="cursor: pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>
              </label>
            </div>


            <div class="my-content mt-2 text-light">

              <div class="d-flex justify-content-between mb-2 promotionList">
                  <label for="">Wholesale Promo</label>
                  <input type="checkbox" class="my-checkbox" id="whole_sale">
              
              </div>

              <div class="d-flex justify-content-between mb-2 promotionList">
                  <label for="">Point Promo</label>
                  <input type="checkbox" class="my-checkbox" id="point_promo">
              </div>

              <div class="d-flex justify-content-between mb-2 promotionList">
                  <label for="">Stamp Card Promo</label>
                  <input type="checkbox" class="my-checkbox" id="stam_card">
              </div>

              <div class="d-flex justify-content-between mb-2 promotionList">
                  <label for="">Buy 1 take 1</label>
                  <input type="checkbox" class="my-checkbox" id="buy_1_take_1">
              </div>

              <div class="d-flex justify-content-between mb-2 promotionList">
                  <label for="">Bundled Promo</label>
                  <input type="checkbox" class="my-checkbox" id="bundle_sale">
              </div>

              <button class="btn btn-secondary w-100" id="updatePromotion" style="background: var(--primary-color); border: none">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
              </svg> Add Promotion
              </button>

            </div>

          </div>
      </div>
    </div>
</div>



<script>
    $("#promotionModal #close-modal, #btn_unpaidCancel").on("click", function () {
        $("#promotionModal").hide();
    })
    show_allBProducts();
  $("#btn_addBProduct").click(function (e) {
      e.preventDefault();
      var prod_id = $(".search_product_b_id").val();

      if(prod_id !== "" && prod_id !== "0")
      {
          if (!isExist(prod_id)) 
          {
            appendRow();
          }
          else
          {
            show_response("Product is already in the table.", 2);
          }
          $(".search_product_b").val("");
          $(".search_product_b_id").val("0");
      }
      else
      {
        show_response("Product is not found.", 2);
      }
  })
  function show_allBProducts() 
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
              value: row.product,
              id: row.product_id,
          };
      });
  }
  function show_response(message, type) 
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
                  "border": "1px solid #1E1C11",
              });
          },
          "onHidden": function () {
              toastDisplayed = false; 
          },
          "closeButton": true,
          "positionClass": "toast-top-right",
          "timeOut": "3500",
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

      type === 1 ? toastr.success(message) : toastr.error(message);
  }

  $(".search_product_b").autocomplete({
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
              
          } else {
              $('#filters').hide();
          }
      },
      select: function (event, ui) {
          var selectedProductId = ui.item.id;
          $(".search_product_b_id").val(selectedProductId);
          var product_name = ui.item.value;
          if(selectedProductId !== "" && selectedProductId !== "0")
          {
              if (!isExist(selectedProductId)) 
              {
                appendRow();
              }
              else
              {
                show_response("Product is already in the table.",2);
              }
              $(".search_product_b").val("");
              $(".search_product_b_id").val("0");
          }
          return false;
      },
  });

  
  function isExist(data) 
  {
      var $matchingRow = $('#tbl_bundled tbody tr[data-id="' + data + '"]');
      return $matchingRow.length > 0;
  }
  function removeItem()
  {
    $(this).closest('tr').remove();
  }
  function appendRow()
  {
      var product_id = $(".search_product_b_id").val();
      $.ajax({
        type: 'get',
        url: 'api.php?action=get_productInfo',
        data: { data: product_id },
        success: function (data) {
            var row = "";
            row += "<tr data-id = " + data['id'] + ">";
            row += "<td>" + data['prod_desc'] + "</td>";
            row += "<td style = 'text-align:center'>1</td>";
            row += "<td style = 'text-align:center' ><i class = 'bi bi-trash3 delete' onclick='removeItem.call(this)'></i></td>";
            row += "</tr>";
            $("#tbl_bundled tbody").append(row);
        }
      })
    }
</script>