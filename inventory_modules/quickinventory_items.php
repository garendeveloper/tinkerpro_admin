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
    #tbl_quickInventories tbody{
        font-size: 12px;
    }
    #tbl_quickInventories thead th{
       border: none;
       color: #FF6900;
    }
    #tbl_quickInventories thead{
       border: 1px solid #FF6900;
    }
    #tbl_quickInventories tbody td{
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
                    <option value="1">B.O.M Inventory</option>
                    <option value="2">Product Inventory</option>
                    <option value="3">All</option>
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
                <input type="text" style="width: 280px; height: 30px; font-size: 12px;"
                    class="search-input italic-placeholder" placeholder="Search Prod..." name="q_product"
                    onkeyup="$(this).removeClass('has-error')" id="q_product" autocomplete="off">
            </div>
            <button style="font-size: 12px; height: 30px; width: 120px;" id="btn_searchQProduct"><i
                    class="bi bi-search"></i>&nbsp; Search</button>
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
        $("select[name='inventory_type']").on("change", function (e) {
            e.preventDefault();
            var value = $(this).val();
            show_allProductsByInventoryType(value);
        })
        $("#btn_searchQProduct").on("click", function (e) {
            e.preventDefault();
            var po_number = $("#q_product").val();
            show_orders(po_number);
        })
        function show_orders(po_number) {
            var negative_inventory = $("#negative_inventory").prop("checked");
            $.ajax({
                type: 'GET',
                url: 'api.php?action=get_orderDataByPurchaseNumber&po_number=' + po_number,
                dataType: 'json',
                success: function (data) {
                    var table = "";
                    for (var i = 0; i < data.length; i++) {
                        table += "<tr data-id = " + data[i].inventory_id + ">";
                        table += "<td>"+data[i].prod_desc+"</td>";
                        table += "<td class = 'text-center'>" + (data[i].qty_received === null ? 0 : data[i].qty_received) + "</td>";
                        table += "<td class = 'text-center'><input placeholder='QTY' class = 'italic-placeholder required' id = 'qty' style = 'width: 60px; text-align: right; height:15px;'></input></td>";
                        table += "</tr>";
                        // if(negative_inventory)
                        // {
                        //     if(data[i].qty_received <= data[i].qty_purchased)
                        //     {
                        //         table += "<tr data-id = " + data[i].inventory_id + ">";
                        //         table += "<td>"+data[i].prod_desc+"</td>";
                        //         table += "<td class = 'text-center'>" + (data[i].qty_received === null ? 0 : data[i].qty_received) + "</td>";
                        //         table += "<td class = 'text-center'><input placeholder='QTY' class = 'italic-placeholder' style = 'width: 60px; text-align: right'></input></td>";
                        //         table += "</tr>";
                        //     }
                        // }
                        // else
                        // {
                        //     if(data[i].qty_received >= data[i].qty_purchased)
                        //     {
                        //         table += "<tr data-id = " + data[i].inventory_id + ">";
                        //         table += "<td>"+data[i].prod_desc+"</td>";
                        //         table += "<td class = 'text-center'>" + (data[i].qty_received === null ? 0 : data[i].qty_received) + "</td>";
                        //         table += "<td class = 'text-center'><input placeholder='QTY' class = 'italic-placeholder' style = 'width: 60px; text-align: right'></input></td>";
                        //         table += "</tr>";
                        //     }
                        // }
                    }
                    $("#tbl_quickInventories tbody").html(table);
                },
                error: function (data) {
                    alert("No response")
                }
            })
        }
        function show_allProductsByInventoryType(inventory_type) {
            $.ajax({
                type: 'GET',
                url: 'api.php?action=get_allProductByInventoryType',
                data: { type: inventory_type },
                success: function (data) {
                    var tbody = "";
                    var products = [];

                    if (inventory_type === "2") {
                        for (var i = 0; i < data.length; i++) {
                            products.push(data[i].po_number);
                        }
                    }
                    else {

                    }
                    autocomplete(document.getElementById("q_product"), products);
                }
            })
        }
        function autocomplete(inp, arr) {
            var currentFocus;
            inp.addEventListener("input", function (e) {
                var a, b, i, val = this.value;
                closeAllLists();
                if (!val) { return false; }
                currentFocus = -1;
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                this.parentNode.appendChild(a);
                for (i = 0; i < arr.length; i++) {
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        b = document.createElement("DIV");
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        b.addEventListener("click", function (e) {
                            inp.value = this.getElementsByTagName("input")[0].value;
                            closeAllLists();
                        });
                        a.appendChild(b);
                    }
                }
            });
            inp.addEventListener("keydown", function (e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    currentFocus++;
                    addActive(x);
                }
                else if (e.keyCode == 38) {
                    currentFocus--;
                    addActive(x);
                }
                else if (e.keyCode == 13) {
                    e.preventDefault();
                    if (currentFocus > -1) {
                        if (x) x[currentFocus].click();
                    }
                }
            });
            function addActive(x) {
                if (!x) return false;
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                x[currentFocus].classList.add("autocomplete-active");
            }
            function removeActive(x) {
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }
            function closeAllLists(elmnt) {
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            document.addEventListener("click", function (e) {
                closeAllLists(e.target);
            });
        }
    })
</script>