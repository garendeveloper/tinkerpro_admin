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
        $("select[name='inventory_type']").on("change", function (e) {
            e.preventDefault();
            var value = $(this).val();
            $("#quickinventory_input_inventory_id").val("");
            $("#q_product").val("");
            $(this).css("border", '1px solid #ffff')
            get_allProductInventory();
            $("#quickinventory_form #q_product").focus();
        })
        $("#btn_searchQProduct").on("click", function (e) {
            e.preventDefault();
            var search_value = $("#q_product").val();
            display_productBy(search_value);
        })
        function get_allProductInventory() {
            $.ajax({
                type: 'GET',
                url: 'api.php?action=get_allInventories',
                success: function (data) {
                    var products = [];
                    for (var i = 0; i < data.length; i++) {
                        var stock = data[i].stock;
                        if(stock !== -1)
                        {
                            var row = {
                                inventory_id: data[i].inventory_id,
                                product: data[i].prod_desc,
                                barcode: data[i].barcode,
                                brand: data[i].brand,
                            };
                            products.push(row);
                        }
                      
                    }
                    $("#q_product").autocomplete({
                        source: function (request, response) {
                            var term = request.term.toLowerCase();
                            var filteredProducts = products.filter(function (row) {
                                return row.product.toLowerCase().includes(term) || row.barcode.includes(term) || (row.brand && row.brand.toLowerCase().includes(term)) || // Check if row.brand is not null or undefined
                                    (!row.brand && term === "");
                            });
                            response(filteredProducts.map(function (row) {
                                return {
                                    label: row.product + " (" + row.barcode + ")" + " (" + row.brand + ")",
                                    value: row.product,
                                    id: row.inventory_id
                                };
                            }));
                        },
                        select: function (event, ui) {
                            var selectedProductId = ui.item.id;
                            $("#quickinventory_input_inventory_id").val(selectedProductId);
                            return false;
                        }
                    });
                }
            })
        }
        function isDataExistInTable(data) {
            var isExist = false;
            $('#tbl_quickInventories tbody').each(function () {
                var rowData = $(this).find('td:first').text();
                if (rowData === data) {
                    isExist = true;
                    return false;
                }
            });
            return isExist;
        }
        $("#q_product").on("blur", function (e) {
            e.preventDefault();
            var search_value = $(this).val();
            if (!search_value.trim()) {
                $(this).addClass('has-error');
            } else {
                display_productBy(search_value);
            }
        })
        function display_productBy(search_value) {
            if ($("select[name='inventory_type']").val() === "") {
                $("select[name='inventory_type']").css('border', '1px solid red');
            }
            else {
                $("select[name='inventory_type']").css('border', '1px solid #ffff');
                if (!isDataExistInTable(search_value)) {
                    $("select[name='inventory_type']").removeClass('has-error');
                    var inventory_id = $("#quickinventory_input_inventory_id").val();
                    $.ajax({
                        type: 'get',
                        url: 'api.php?action=get_inventoryDataById',
                        data: { inventory_id: inventory_id },
                        success: function (data) {
                            var row = "";
                            row += "<tr data-id = " + data['inventory_id'] + ">";
                            row += "<td>" + data['prod_desc'] + "</td>";
                            row += "<td style = 'text-align:center'>" + data['stock'] + "</td>";
                            row += "<td class = 'text-center'><input placeholder='QTY' class = 'italic-placeholder required' id = 'qty' style = 'width: 60px; text-align: center; height:20px;'></input></td>";
                            row += "</tr>";
                            $("#tbl_quickInventories tbody").append(row);
                        }
                    })
                    $("#quickinventory_input_inventory_id").val("");
                }
                else {
                    alert("Product is already listed in the table.");
                }
            }

        }
    })
</script>