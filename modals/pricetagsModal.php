
<link rel="stylesheet" href="assets/css/priceTags.css">
<style>
    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        top: 100%;
        left: 0;
        right: 0;
    }

.autocomplete-items div {
    padding: 10px;
    cursor: pointer;
    background-color: #1E1C11;
    border: 1px solid #fff;
    border-bottom: 1px solid #d4d4d4;
}

.autocomplete-items div:hover {
    background-color: #FF6900;
    color: #ffff;
}

.autocomplete-active {
    background-color: #FF6900 !important;
    color: #ffffff;
}
</style>
<div class="modal" id="priceTagsModal" tabindex="0">
  <div class="modal-dialog ">
    <div class="modal-content priceTagContent">
      <div class="modal-title">
        <div style="margin-top: 30px; margin-left: 20px">
           <h5 class="text-custom modalHeaderTxt" id="modalHeaderTxt" style="color:#FF6900;">PRICE TAGS #</h5>
        </div>
        <div class="warning-container">
          <div class="tableCard">
            <div class="fcontainer"  >
                <form id="priceTagForm" >
                    <div class="fieldContainer" style="margin-top: -3px;">
                        <label><img src="assets/img/barcode.png" style="color: white; height: 50px; width: 40px;"></label>
                        <div class="searchInput-container">
                            <input type="hidden" id="searchInput_id" value="0">
                            <input type="text" style="width: 280px; height: 30px; font-size: 12px;"
                                class="searchInput-input italic-placeholder" placeholder="searchInput Product,[Name, Barcode, Brand]" name="searchInput"
                                onkeyup="$(this).removeClass('has-error')" id="searchInputInput" autocomplete="off">

                               
                        </div>
                        <button style="font-size: 12px; height: 30px; width: 150px; border-radius: 4px;" id="btn_searchInputProduct">
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
        
        var toastDisplayed = false;
        var products = [];

        $("#btn_searchInputProduct").click(function (e) {
            e.preventDefault();
            var inventory_id = $("#searchInput_id").val();

                if (!isDataExistInTable(inventory_id)) 
                {
                    display_productBy(inventory_id);
                }
                else
                {
                    show_errorResponse("Product is already in the table.");
                }
        })
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
        $("#searchInput").on("input", function(e) {
            var term = $(this).val();
            $(this).autocomplete('searchInput', term);
        });

        $("#searchInput").autocomplete({
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
            
            // var slicedProductsLength = slicedProducts.length - 1;
            // var selectedProductId = slicedProducts[slicedProductsLength].id;
            //     $("#searchInput_id").val(selectedProductId);
            },
            select: function (event, ui) {
                var selectedProductId = ui.item.id;
                console.log(selectedProductId)
                alert(selectedProductId)
                $("#searchInput_id").val(selectedProductId);
                if(selectedProductId !== "" && selectedProductId !== "0")
                {
                    if (!isDataExistInTable(selectedProductId)) 
                    {
                        display_productBy(selectedProductId);
                    }
                    else
                    {
                        show_errorResponse("Product is already in the table.");
                    }
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