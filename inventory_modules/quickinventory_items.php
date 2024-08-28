<style>
    tr:hover {
        background-color: #151515;
        cursor: pointer;
    }

    .group {
        display: inline-block;
        margin-right: 3px;
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

    #tbl_quickInventories tbody {
        font-size: 12px;
    }

    #tbl_quickInventories thead th {
        border: none;
        color: var(--primary-color);
    }

    #tbl_quickInventories thead {
        border: 1px solid var(--primary-color);
    }

    #tbl_quickInventories tbody td {
        border: none;
    }
</style>
<div class="fcontainer" id="quickinventory_div" style="display: none">
    <form id="quickinventory_form">
        <div class="fieldContainer">
            <div class="custom-select" style="margin-right: 30px; ">
                <select name="inventory_type"
                    style=" background: #1E1C11; color: #ffff; width: 250px; border: 1px solid #ffff; font-size: 12px; height: 30px;">
                    <option value="2">Product Inventory</option>
                    <option value="">Select Inventory</option>
                    <!-- <option value="1">B.O.M Inventory</option> -->
                  
                    <!-- <option value="3">All</option> -->
                </select>
                <i class="bi bi-chevron-double-down"></i>
            </div>
            <div class="group" style="margin-right: -22px;">
                <label for=""><strong style="color: #ffff; font-size: 12px;">All Inventory: </label>
                <label class="switch">
                    <input type="checkbox" name="negative_inventory" id="negative_inventory" checked>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
        <div class="fieldContainer" style="margin-top: -3px;">
            <label>
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="50" fill="#fff" class="bi bi-upc-scan" viewBox="0 0 16 16">
                <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5M3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0z"/>
              </svg>
             </label>
            <div class="search-container">
                <input type="hidden" id="quickinventory_input_inventory_id" value="0">
                <input type="text" style="width: 280px; height: 30px; font-size: 14px;"
                    class="search-input italic-placeholder" placeholder="Search Product [barcode,name,brand]"
                    name="q_product" onkeyup="$(this).removeClass('has-error')" id="q_product" autocomplete="off">
            </div>
            <button style="font-size: 12px; height: 30px; width: 120px; border: 1px solid var(--primary-color); border-radius: 5px;"
                id="btn_searchQProduct">
                <i class = "bi bi-search"></i>
                Search</button>
        </div>
    </form>
    <table  class="text-color table-border tableHead" style="margin-top: -3px;">
        <thead>
            <tr>
                <th style="background-color: #1E1C11; color: #ffffff; width: 50%">ITEM DESCRIPTION</th>
                <th style="background-color: #1E1C11;  color: #ffffff; ">QTY ON HAND</th>
                <th style="background-color: #1E1C11;   color: #ffffff; ">NEW QTY</th>
                <th style="background-color: #1E1C11;   color: #ffffff; "></th>
            </tr>
        </thead>
    </table>
    <div class = "scrollable">
        <table id="tbl_quickInventories" class="text-color table-border" style="margin-top: -3px;">
            <tbody style="border-collapse: collapse; border: none">

            </tbody>
        </table>
    </div>
</div>


<script>
    $(document).ready(function () {
        
        var products_forquickInventory = [];
        var toastDisplayed = false;
        var products = [];
        var productsCache = [];
        $("select[name='inventory_type']").on("change", function (e) {
            e.preventDefault();
            productsCache = [];
            var value = $(this).val();
            $("#quickinventory_input_inventory_id").val("");
            $("#q_product").val("");
            $(this).css("border", '1px solid #ffff')
            show_allProducts();
            $("#quickinventory_form #q_product").focus();
        })
        // $("#negative_inventory").change(function() {
        //     productsCache = [];
        //     var inventory_type = $("select[name='inventory_type']").val();
        //     var isNegativeInventoryChecked = $(this).prop("checked") ? 1 : 0;
        //     if(inventory_type !== "" && inventory_type) show_allProducts(isNegativeInventoryChecked);
        //     else $("select[name='inventory_type']").css('border', '1px solid red')
        // });
        $("#btn_searchQProduct").click(function (e) {
            e.preventDefault();
            var inventory_id = $("#quickinventory_input_inventory_id").val();
            if(inventory_id !== "0" && inventory_id !== "")
            {
                if ($("select[name='inventory_type']").val() === "") {
                    $("select[name='inventory_type']").css('border', '1px solid red');
                }
                else {
                    $("select[name='inventory_type']").css('border', '1px solid #ffff');
                    if (!isDataExistInTable(inventory_id)) 
                    {
                        display_productBy(inventory_id);
                    }
                    else
                    {
                        show_errorResponse("Product is already in the table.");
                    }
                }
            }
            else
            {
                show_errorResponse("Product not found.");
            }
            $("#quickinventory_input_inventory_id").val("0");
            $("#q_product").val("");
        })
     
        function show_allProducts(isNegativeInventoryChecked) 
        {
            $.ajax({
            type: 'GET',
            url: 'api.php?action=get_allProducts',
            data: {
                isNegativeInventoryChecked: isNegativeInventoryChecked
            },  
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
        $('#tbl_quickInventories tbody').on('keypress', '#qty', function (event) {
            var charCode = event.which ? event.which : event.keyCode;
            var inputVal = $(this).val();

            if ((charCode < 48 || charCode > 57) && charCode !== 46) {
                event.preventDefault();
                return;
            }

            if (inputVal.indexOf('.') !== -1) {
                if (charCode === 46) {
                    event.preventDefault();
                    return;
                }

                var decimalPos = inputVal.indexOf('.');
                var decimalPart = inputVal.substring(decimalPos + 1);
                if (decimalPart.length >= 2) {
                    event.preventDefault();
                    return;
                }
            }
        });
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
                    label: row.product,
                    value: row.product,
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
        $("#q_product").on("input", function(e) {
            var term = $(this).val();
            $(this).autocomplete('search', term);
        });

        $("#q_product").autocomplete({
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
            
            var slicedProductsLength = slicedProducts.length - 1;
            var selectedProductId = slicedProducts[slicedProductsLength].id;
                $("#quickinventory_input_inventory_id").val(selectedProductId);
            },
            select: function (event, ui) {
                
                var selectedProductId = ui.item.id;
                $("#quickinventory_input_inventory_id").val(selectedProductId);
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
                    $("#quickinventory_input_inventory_id").val("0");
                    $("#q_product").val("");
                }
                return false;
            },
        });
        $("#tbl_quickInventories tbody").off('click').on("click", ".removeItem", function(){
            $(this).closest('tr').remove();
        });
        function isDataExistInTable(data) 
        {
            var $matchingRow = $('#tbl_quickInventories tbody td[data-id="' + data + '"]').closest('tr');
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
                    row += "<td data-id = " + data['id'] + " style = 'width: 50%'>" + data['prod_desc'] + "</td>";
                    row += "<td style = 'text-align:center; width: 30%' '>" + data['product_stock'] + "</td>";
                    row += "<td class = 'text-right'><input placeholder='QTY' class = 'italic-placeholder required' id = 'qty' style = 'width: 60px; text-align: center; height:20px;'></input></td>";
                    row += "<td class = 'text-center removeItem'><i class = 'bi bi-trash3'></i></td>";
                    row += "</tr>";
                    $("#tbl_quickInventories tbody").append(row);
                }
            })
        }
    })
</script>