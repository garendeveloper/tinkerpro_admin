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
        color: #FF6900;
    }

    #tbl_quickInventories thead {
        border: 1px solid #FF6900;
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
                    <option value="">Select Inventory</option>
                    <!-- <option value="1">B.O.M Inventory</option> -->
                    <option value="2">Product Inventory</option>
                    <!-- <option value="3">All</option> -->
                </select>
                <i class="bi bi-chevron-double-down"></i>
            </div>
            <div class="group" style="margin-right: -22px;">
                <label for=""><strong style="color: #ffff; font-size: 12px;">Negative Inventory: </label>
                <label class="switch">
                    <input type="checkbox" name="negative_inventory" id="negative_inventory" checked>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
        <div class="fieldContainer" style="margin-top: -3px;">
            <label><img src="assets/img/barcode.png" style="color: white; height: 50px; width: 40px;"></label>
            <div class="search-container">
                <input type="hidden" id="quickinventory_input_inventory_id" value="0">
                <input type="text" style="width: 280px; height: 30px; font-size: 14px;"
                    class="search-input italic-placeholder" placeholder="Search Product [barcode,name,brand]"
                    name="q_product" onkeyup="$(this).removeClass('has-error')" id="q_product" autocomplete="off">
            </div>
            <button style="font-size: 12px; height: 30px; width: 120px; border: 1px solid #FF6900; border-radius: 5px;"
                id="btn_searchQProduct">
                Search</button>
        </div>
    </form>
    <table id="tbl_quickInventories" class="text-color table-border" style="margin-top: -3px;">
        <thead>
            <tr>
                <th style="background-color: #1E1C11;  width: 50%">ITEM DESCRIPTION</th>
                <th style="background-color: #1E1C11;  ">QTY ON HAND</th>
                <th style="background-color: #1E1C11;  ">NEW QTY</th>
            </tr>
        </thead>
        <tbody style="border-collapse: collapse; border: none">

        </tbody>
    </table>
</div>


<script>
    $(document).ready(function () {
        
        var products_forquickInventory = [];
        var toastDisplayed = false;
        var products = [];
        $("select[name='inventory_type']").on("change", function (e) {
            e.preventDefault();
            var value = $(this).val();
            $("#quickinventory_input_inventory_id").val("");
            $("#q_product").val("");
            $(this).css("border", '1px solid #ffff')
            show_allProducts();
            $("#quickinventory_form #q_product").focus();
        })
        $("#btn_searchQProduct").click(function (e) {
            e.preventDefault();
            var inventory_id = $("#quickinventory_input_inventory_id").val();
            if(inventory_id !== 0)
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
            return productsCache.filter(function (row) {
            return row.product.toLowerCase().includes(term) ||
                row.barcode.includes(term) ||
                (row.brand && row.brand.toLowerCase().includes(term)) ||
                (!row.brand && term === "");
            }).map(function (row) {
            var brand = row.brand === null ? " " : row.brand;
            return {
                label: row.product + " (" + row.barcode + ")" + " (" + brand + ")",
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
                return false;
            },
        });
      $("#q_product").on("input", function(e) {
        e.preventDefault();
          var term = $(this).val();
          $(this).autocomplete('search', term);
      });
    //   $("#q_product").on("keypress", function(event){
    //     if(event.which === 13){
    //         var product_id = $("#quickinventory_input_inventory_id").val();
      
    //       if (!isDataExistInTable(product_id)) {
    //         display_productBy(product_id);
    //       }
    //       else
    //       {
    //         show_errorResponse("Product already in the table")
    //       }
    //       $("#q_product").val('');
    //     }
      
    //   })

    //   $("#q_product").on("autocompletechange", function(event, ui) {
    //     var product_id = $("#quickinventory_input_inventory_id").val();
        
    //     if (!isDataExistInTable(product_id)) {
    //         display_productBy(product_id)
    //     }
    //     else
    //     {
    //       show_errorResponse("Product already in the table");
    //     }
    //       $(this).val('');
    //   });
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
                    row += "<td data-id = " + data['id'] + ">" + data['prod_desc'] + "</td>";
                    row += "<td style = 'text-align:center'>" + data['product_stock'] + "</td>";
                    row += "<td class = 'text-center'><input placeholder='QTY' class = 'italic-placeholder required' id = 'qty' style = 'width: 60px; text-align: center; height:20px;'></input></td>";
                    row += "</tr>";
                    $("#tbl_quickInventories tbody").append(row);
                }
            })
        }
    })
</script>