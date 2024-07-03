
<link rel="stylesheet" href="assets/css/priceTags.css">

<style>
    #priceTagContent{
        background-color: '#262626';
    }
</style>
<style> 
  .mark {
    background-color: #d7ffe7 !important
  }

  .mark .gsearch{
    font-size: 20px
  }

  .unmark {
    background-color: #e8e8e8 !important
  }

  .unmark .gsearch{
    font-size: 10px
  }
  
  .marktext
  {
   font-weight:bold;
   background-color: antiquewhite;
  }
  </style>
<div class="modal" id="priceTagsModal" tabindex="0">
  <div class="modal-dialog ">
    <div class="modal-content priceTagContent" style = "background-color: #262626">
      <div class="modal-title">
        <div style="margin-top: 30px; margin-left: 20px">
           <h5 class="text-custom modalHeaderTxt" id="modalHeaderTxt" style="color:#FF6900;">PRICE TAGS #</h5>
        </div>
        <div class="warning-container">
          <div class="tableCard">
            <div class="fcontainer"  >
                <form id="priceTagForm">
                    <div class="fieldContainer" style="margin-top: -3px;">
                        <label><img src="assets/img/barcode.png" style="color: white; height: 50px; width: 40px;"></label>
                        <div class="search-container">
                            <input type="hidden" id="priceTag_id" value="0">
                            <input type="text" style="width: 280px; height: 30px; font-size: 12px;"
                                class="search-input italic-placeholder" placeholder="Search Product,[Name, Barcode, Brand]" name="priceTag"
                                onkeyup="$(this).removeClass('has-error')" id="priceTag" autocomplete="off">

                                <ul class="list-group">

                                </ul>
                                <div id="localSearchSimple"></div>
                                <div id="detail" style="margin-top:16px;"></div>
                        </div>
                        
                        <button style="font-size: 12px; height: 30px; width: 150px; border-radius: 4px;" id="btn_searchProduct">
                            Add Product</button>
                    </div>
                </form>
                <table id="tbl_priceTags" class="text-color table-border" style="margin-top: -3px; margin-bottom: 30vh">
                    <thead>
                        <tr>
                            <th style="background-color: #1E1C11; width: 50%">ITEM DESCRIPTION</th>
                            <th style="background-color: #1E1C11; text-align:center; width: 50%">BARCODE</th>
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

<script>
    $(document).ready(function () {
        show_allProducts();
        var toastDisplayed = false;

        function isDataExistInTable(data) 
        {
            var $matchingRow = $('#tbl_priceTags tbody td[data-id="' + data + '"]').closest('tr');
            return $matchingRow.length > 0;
        }
        var productsCache = [];
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
                    id: row.product_id
                };
            });
        }
        function append_to_table()
        {
            var product_id = $("#priceTag_id").val();
            $.ajax({
                type: 'get',
                url: 'api.php?action=get_productInfo',
                data: { data: product_id },
                success: function (data) {
                    var row = "";
                    row += "<tr data-id = " + data['id'] + ">";
                    row += "<td data-id = " + data['id'] + ">" + data['prod_desc'] + "</td>";
                    row += "<td style = 'text-align:center'>" +data['barcode']+ "</td>";
                    row += "</tr>";
                    $("#tbl_priceTags").append(row);
                }
                })
                $("#priceTag_id").val("");
        }
        $("#btn_searchProduct").click(function (e) {
            e.preventDefault();
            var product_id = $("#priceTag_id").val();
            if(product_id !== "" && product_id !== "0")
            {
                if (!isDataExistInTable(product_id)) {
                    append_to_table();
                }
                else {
                    show_errorResponse("Product is already listed in the table")
                }
            
            }
            else
            {
                show_errorResponse("Product not found.")
                
            }
            $("#priceTag").val("");
            $("#priceTag_id").val("0");
        })

        $("#priceTag").autocomplete({
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
            console.log('font-size')
            var slicedProductsLength = slicedProducts.length - 1;
            var selectedProductId = slicedProducts[slicedProductsLength].id;
                $("#priceTag_id").val(selectedProductId);
            },
            select: function (event, ui) {
                
                var selectedProductId = ui.item.id;
                $("#priceTag_id").val(selectedProductId);
                if(selectedProductId !== "" && selectedProductId !== "0")
                {
                    if (!isDataExistInTable(selectedProductId)) {
                        append_to_table(selectedProductId);
                    }
                    else {
                        show_errorResponse("Product is already listed in the table")
                    }
                    
                    $("#priceTag_id").val("0");
                    $("#priceTag").val("");
                }

                return false;
            },
        });
      $("#priceTag").on("input", function(e) {
        e.preventDefault();
          var term = $(this).val();
          $(this).autocomplete('search', term);
      });
      $("#priceTag").on("keypress", function(event){
        if(event.which === 13){
            var product_id = $("#priceTag_id").val();
            if(product_id !== "" && product_id !== "0")
            {
                if (!isDataExistInTable(product_id)) {
                    append_to_table();
                }
                else
                {
                    show_errorResponse("Product is already listed in the table")
                }
            }
            else
            {
                show_errorResponse("Product not found.")
            }
            $("#priceTag").val('');
        }
      
      })
    })
</script>
<!-- <script>
$(document).ready(function(){
 $('priceTag').keyup(function(){
  var query = $('priceTag').val();
  $('#detail').html('');
  $('.list-group').css('display', 'block');
  if(query.length == 2)
  {
   $.ajax({
    url:"fetch_inventory/fetchProduct.php",
    method:"POST",
    data:{search:query},
    success:function(data)
    {
     $('.list-group').html(data);
    }
   })
  }
  if(query.length == 0)
  {
   $('.list-group').css('display', 'none');
  }
 });

 $('#localSearchSimple').jsLocalSearch({
  action:"Show",
  html_search:true,
  mark_text:"marktext"
 });

 $(document).on('click', '.gsearch', function(){
  var email = $(this).text();
  $('priceTag').val(email);
  $('.list-group').css('display', 'none');
  $.ajax({
   url:"fetch_inventory/fetchProduct.php",
   method:"POST",
   data:{email:email},
   success:function(data)
   {
    $('#detail').html(data);
   }
  })
 });
});
</script> -->