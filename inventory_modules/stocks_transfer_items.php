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
    textarea {
        resize: none; 
        width: 300px;
        height: 100px;
        overflow: auto; 
    }
    textarea::placeholder {
        color: #ffff; 
        font-style: italic; 
    }
</style>
<div class="fcontainer" id="stocktransfer_div" style="display: none">
    <form id="stocktransfer_form">
        <div class="fieldContainer">
            <label>REF: </label>
            <input type="text" style= "width: 250px; height: 30px;">
            <div class="date-input-container">
                <input type="text" name="date_transfer" id="date_transfer" style = "height: 30px;" placeholder="Select date" readonly>
                <button id="btn_datetransfer" class="button" style="height: 30px;">
                    <i class="bi bi-calendar" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        <div class="fieldContainer">
            <div class="custom-select" style="margin-right: 20px; ">
                <select name="stock_from"
                    style=" background: #1E1C11; color: #ffff; width: 220px; border: 1px solid #ffff; font-size: 12px; height: 30px;">
                    <option value="">Transfer Stock From?</option>
                    <option value="">Branch 1</option>
                    <option value="">Branch 2</option>
                    <option value="">Warehouse</option>
                </select>
                <i class="bi bi-chevron-double-down"></i>
            </div>
            <div class="custom-select" s>
                <select name="stock_to"
                    style=" background-color: #1E1C11; color: #ffff; width: 220px; border: 1px solid #ffff; font-size: 12px; height: 30px;">
                    <option value="">Transfer Stock to?</option>
                    <option value="">Branch 1</option>
                    <option value="">Branch 2</option>
                    <option value="">Warehouse</option>
                </select>
                <i class="bi bi-chevron-double-down"></i>
            </div>
        </div>
        <div class="fieldContainer" style="margin-top: -3px;">
            <label><img src="assets/img/barcode.png" style="color: white; height: 50px; width: 40px;"></label>
            <div class="search-container">
                <input type="text" style="width: 280px;  font-size: 12px; height: 30px;"
                    class="search-input italic-placeholder" placeholder="Search Prod..." name="q_product"
                    onkeyup="$(this).removeClass('has-error')" id="q_product" autocomplete="off">
            </div>
            <button style="font-size: 12px;  height: 30px; width: 120px; border-radius: 4px;" id="btn_searchQProduct"> Add Product</button>
        </div>
    </form>
    <table  class="text-color table-border" style="margin-top: -3px;">
        <thead>
            <tr>
                <th style="background-color: #1E1C11; border: 1px solid #FF6900; color:#FF6900">ITEM DESCRIPTION</th>
                <th style="background-color: #1E1C11; border: 1px solid #FF6900; color:#FF6900">QTY</th>
                <th style="background-color: #1E1C11; border: 1px solid #FF6900; color: #FF6900">COST</th>
            </tr>
        </thead>
        <tbody style="border-collapse: collapse; border: none">

        </tbody>
    </table>
    <div style="position: absolute; bottom: 5px; padding: 10px;">
        <textarea name="stock_note" id="stock_note" cols="80" rows="5" placeholder="Note" style = "background-color: #1E1C11; color: #ffff; width: 100%;">

        </textarea>
    </div>
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
                        if(negative_inventory)
                        {
                            if(data[i].qty_received <= data[i].qty_purchased)
                            {
                                table += "<tr data-id = " + data[i].inventory_id + ">";
                                table += "<td>"+data[i].prod_desc+"</td>";
                                table += "<td class = 'text-center'>" + (data[i].qty_received === null ? 0 : data[i].qty_received) + "</td>";
                                table += "<td class = 'text-center'><input placeholder='QTY' id='qty' title='Please enter only digits' class = 'italic-placeholder' style = 'width: 60px'></input></td>";
                                table += "</tr>";
                            }
                        }
                        else
                        {
                            if(data[i].qty_received >= data[i].qty_purchased)
                            {
                                table += "<tr data-id = " + data[i].inventory_id + ">";
                                table += "<td>"+data[i].prod_desc+"</td>";
                                table += "<td class = 'text-center'>" + (data[i].qty_received === null ? 0 : data[i].qty_received) + "</td>";
                                table += "<td class = 'text-center'><input placeholder='QTY' id='qty'  title='Please enter only digits' class = 'italic-placeholder' style = 'width: 60px'></input></td>";
                                table += "</tr>";
                            }
                        }
                    }
                    $("#tbl_quickInventories tbody").html(table);
                },
                error: function (data) {
                    alert("No response")
                }
            })
        }
        $("#tbl_quickInventories tbody").on("input", '#qty', function(e){
            e.preventDefault();
            $(this).val($(this).val().replace(/\D/g, ''));
        })
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