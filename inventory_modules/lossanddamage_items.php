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

    #tbl_lossand_damages tbody {
        font-size: 12px;
    }

    textarea {
        resize: none;
        /* Prevent resizing of textarea */
        width: 300px;
        height: 100px;
        overflow: auto;
        /* Enable scrolling if content exceeds textarea size */
    }

    textarea::placeholder {
        color: #ffff;
        /* Placeholder text color */
        font-style: italic;
        /* Placeholder font style */
    }

    #tbl_lossand_damages tbody {
        font-size: 12px;
    }

    #tbl_lossand_damages thead th {
        border: none;
        color: #FF6900;
    }

    #tbl_lossand_damages thead {
        border: 1px solid #FF6900;
    }

    #tbl_lossand_damages tbody td {
        border: none;
    }

    #footer_lossand_damages thead th {
        border: none;
        color: #FF6900;
    }

    #footer_lossand_damages thead {
        border: none;
    }

    #footer_lossand_damages tbody td {
        border: none;
    }

    #footer_lossand_damages {
        border: none;
    }
</style>
<div class="fcontainer" id="lossanddamage_div" style="display: none">
    <form id="lossanddamage_form">
        <div class="fieldContainer">
            <label>REF# </label>
            <input type="text" name="ref" id="ld_reference" name="ld_reference"
                style="width: 250px; height: 30px; font-size: 14px;" readonly>
            <div class="date-input-container">
                <input type="text" name="date_damage" oninput="$(this).removeClass('has-error')" id="date_damage"
                    style="height: 30px;  text-align: center" placeholder="Select date" readonly>
                <button id="btn_dateDamage" class="button" type="button" style="height: 30px;">
                    <i class="bi bi-calendar2" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        <div class="fieldContainer">
            <label for="" style="width:350px; font-size: 12px; font-style: italic">Choose a reason of loss
                &damage</label>
            <div class="custom-select" style="margin-right: 0px; ">
                <select name="ld_reason"
                    style=" background-color: #1E1C11; color: #ffff; width: 160px; border: 1px solid #ffff; font-size: 12px; height: 30px;">
                    <option>Disposal</option>
                    <option>Return to Supplier</option>
                    <option>Insect/Animal Infestation</option>
                    <option>Expired Products</option>
                    <option>Expiring Soon</option>
                    <option>Pin Holes</option>
                    <option>Material Deformity</option>
                    <option>Faded Color</option>
                    <option>Damage due to calamity</option>
                    <option>Liquid Damage</option>
                    <option>Impact Damage</option>
                    <option>Manufacturing Defects</option>
                    <option>Design Defects</option>
                    <option>Misuse or Negligence</option>
                    <option>Theft or Vandalism</option>
                    <option>Third-Party Damage</option>
                    <option>Recall Damage</option>
                </select>
                <i class="bi bi-chevron-double-down"></i>
            </div>
        </div>
        <div class="fieldContainer" style="margin-top: -3px;">
            <label><img src="assets/img/barcode.png" style="color: white; height: 50px; width: 40px;"></label>
            <div class="search-container">
                <input type="hidden" id="loss_and_damage_input_inventory_id" value="0">
                <input type="text" style="width: 280px; height: 30px; font-size: 12px;"
                    class="search-input italic-placeholder" placeholder="Search Prod..." name="loss_and_damage_input"
                    onkeyup="$(this).removeClass('has-error')" id="loss_and_damage_input" autocomplete="off">
            </div>
            <button style="font-size: 12px; height: 30px; width: 120px; border-radius: 4px;" id="btn_searchLDProduct">
                Add Product</button>
        </div>
    </form>
    <table id="tbl_lossand_damages" class="text-color table-border" style="margin-top: -3px; margin-bottom: 30vh">
        <thead>
            <tr>
                <th style="background-color: #1E1C11; width: 50%">ITEM DESCRIPTION</th>
                <th style="background-color: #1E1C11; text-align:center">QTY</th>
                <th style="background-color: #1E1C11; text-align:right">COST</th>
                <th style="background-color: #1E1C11; text-align:right">TOTAL COST</th>
            </tr>
        </thead>
        <tbody style="border-collapse: collapse; border: none">

        </tbody>

    </table>
    
    <div style="position: absolute;padding: 10px; width: 100%;">
    <table id="footer_lossand_damages" class="" >
        <thead style="border: none;">
            <tr>
                <th style="background-color: #1E1C11; width: 50%;" >TOTAL</th>
                <th style="background-color: #1E1C11; width: 50px; text-align:center;" id="total_qty" ></th>
                <th style="background-color: #1E1C11; text-align: right;" id="total_cost"></th>
                <th style="background-color: #1E1C11; text-align: right;" id="overall_total_cost"></th>
            </tr>
            <thead>
    </table>
    <div >
        <textarea name="loss_and_damage_note" id="loss_and_damage_note" cols="80" rows="5" placeholder="Note"
            style="background-color: #1E1C11; color: #ffff; width: 100%;">

        </textarea>
    </div>
    </div>
    
</div>


<script>
    $(document).ready(function () {
        show_reference_no();
        get_allProductInventory();
        $('#date_damage').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'M dd y',
            altFormat: 'M dd y',
            altField: '#date_damage',
            onSelect: function (dateText, inst) { }
        });
        function clean_number(number) {
            return number.replace(/[₱\s]/g, '');
        }
        $('#btn_dateDamage').on('click', function (e) {
            e.preventDefault();
            $('#date_damage').datepicker('show');
        });
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        function isDataExistInTable(data) {
            var isExist = false;
            $('#tbl_lossand_damages tbody').each(function () {
                var rowData = $(this).find('td:first').text();
                if (rowData === data) {
                    isExist = true;
                    return false;
                }
            });
            return isExist;
        }

        $("#btn_searchLDProduct").on("click", function (e) {
            e.preventDefault();
            var search_value = $("#loss_and_damage_input").val();
            if (!isDataExistInTable(search_value)) {
                var inventory_id = $("#loss_and_damage_input_inventory_id").val();
                $("#loss_and_damage_input").val("---");
                $("#loss_and_damage_input_inventory_id").val("");
                $.ajax({
                    type: 'get',
                    url: 'api.php?action=get_inventoryDataById',
                    data: { inventory_id: inventory_id },
                    success: function (data) {
                        var row = "";
                        row += "<tr data-id = "+data['inventory_id']+">";
                        row += "<td>" + data['prod_desc'] + "</td>";
                        row += "<td style = 'text-align:center'><input placeholder='QTY' style = 'text-align:center; width: 50px; height: 20px; font-size: 12px;' id = 'qty_damage' ></input></td>";
                        row += "<td style = 'text-align:right' id = 'cost' class='editable' data-id="+data['cost']+">₱ " + numberWithCommas(data['cost']) + "</td>";
                        row += "<td style = 'text-align:right' id = 'total_row_cost'></td>";
                        row += "</tr>";
                        if(data["isSerialized"] === 1)
                        {
                            var sub_row = data["sub_row"];
                            var html_sub_row = "";
                            for(var j = 0; j<sub_row.length; j++)
                            {
                                html_sub_row += "<tr class ='sub-row' data-id = " + data["inventory_id"] + ">";
                                html_sub_row += "<td ><input  id= 'serial_number' style = 'width: 130px; height: 20px; font-size: 10px;' placeholder='Serial Number' class='italic-placeholder' value = "+sub_row[j].serial_number+" readonly></input><input type = 'checkbox'  id = 'serial_ischeck' style = 'height: 20px'></input></td>";
                                html_sub_row += "</tr>";
                            }
                            row +=html_sub_row;
                        }
                        $("#tbl_lossand_damages").append(row);
                    }
                })
            }
            else {
                alert("Product is already listed in the table.");
            }
            updateTotal();
        })
        $('#tbl_lossand_damages tbody').on('click', '.editable', function () {
            $(this).attr('contenteditable', true);
        });
        $("#tbl_lossand_damages").on("input", "#qty_damage", function (e) {
            e.preventDefault();
            $(this).removeClass('has-error');
            var qty_damage = $(this).val();
            qty_damage = parseFloat(qty_damage);
            var cost = $(this).closest("tr").find("#cost").text();
            cost = clean_number(cost);
            cost = parseFloat(cost);

            var total_cost = qty_damage * cost;
            $(this).closest("tr").find("#total_row_cost").text("₱ " + numberWithCommas(total_cost))
            updateTotal();
        })
        function acceptsOnlyTwoDecimal(value) {
            value = value.replace(/[^0-9.]/g, '');
            let parts = value.split('.');
            if (parts[1] && parts[1].length > 2) {
                parts[1] = parts[1].slice(0, 2);
                value = parts.join('.');
            }
            if (parts.length > 2) {
                value = parts[0] + '.' + parts.slice(1).join('');
            }
            return value;
        }
        $('#tbl_lossand_damages tbody').on('input', 'td:nth-child(3)', function () {
            var $cell = $(this);
            var prevCost = $cell.data('id');
            var newCost = $cell.text().trim();
            if(newCost === null || newCost === "") $cell.text(prevCost);
            else
            {
                var cursorPosition = getCursorPosition($cell[0]);
                newCost = acceptsOnlyTwoDecimal(newCost);
                $cell.text(newCost);
                cursorPosition = Math.min(cursorPosition, newCost.length);
                setCursorPosition($cell[0], cursorPosition);
                newCost = parseFloat(clean_number(newCost));
                var qty_damage = $cell.closest("tr").find("#qty_damage").val();
                qty_damage = parseFloat(qty_damage);
                var newTotal = qty_damage * newCost;
                $cell.closest('tr').find('td:nth-child(4)').html("&#x20B1;&nbsp;" + newTotal);
            }
            updateTotal();
           
        });
        function updateTotal() 
        {
            var totalQty = 0; var totalCost = 0; var overall_totalCost = 0;

            $('#tbl_lossand_damages tbody tr:not(.sub-row)').each(function() {
                var quantity = parseInt($(this).find('#qty_damage').val());
                var cost = parseFloat(clean_number($(this).find('td:nth-child(3)').text().trim()));
                var subtotal = parseFloat(clean_number($(this).find('td:nth-child(4)').text().trim()));

                totalQty += quantity;
                totalCost += cost;
                overall_totalCost += subtotal;
            });
            $("#total_qty").html(totalQty);
            $("#total_cost").html("&#x20B1;&nbsp;"+addCommasToNumber(totalCost));
            $("#overall_total_cost").html("&#x20B1;&nbsp;"+addCommasToNumber(overall_totalCost));
        }
        function getCursorPosition(element) {
            var selection = window.getSelection();
            var range = selection.getRangeAt(0);
            range.setStart(element, 0);
            return range.toString().length;
        }
        $("#tbl_lossand_damages").on("input", "#qty_damage", function (e) {
            this.value = this.value.replace(/[^0-9.]/g, '');
            if (this.value.split('.').length > 2) {
                this.value = this.value.replace(/\.+$/, '');
            }
        });
        function get_allProductInventory() {
            $.ajax({
                type: 'GET',
                url: 'api.php?action=get_allInventories',
                success: function (data) {
                    var products = [];
                    for (var i = 0; i < data.length; i++) {
                        var row = {
                            inventory_id: data[i].inventory_id,
                            product: data[i].prod_desc,
                        };
                        products.push(row);
                    }
                    autocomplete_product(document.getElementById('loss_and_damage_input'), products);
                }
            })
        }
        function show_reference_no() {
            $.ajax({
                type: 'get',
                url: 'api.php?action=get_loss_and_damage_latest_reference_no',
                success: function (data) {
                    $("#ld_reference").val(data);
                }
            })
        }
        function setCursorPosition(element, position) {
            var range = document.createRange();
            var sel = window.getSelection();
            var childNode = element.childNodes[0];

            if (childNode && childNode.nodeType === Node.TEXT_NODE && childNode.length > 0) {
                position = Math.min(position, childNode.length);
                range.setStart(childNode, position);
            }
            else {
                range.setStart(element, 0);
            }
            range.collapse(true);
            sel.removeAllRanges();
            sel.addRange(range);
        }
        function autocomplete_product(inp, arr) {
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
                    if (arr[i].product.substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        const inventory_id = arr[i].inventory_id;
                        b = document.createElement("DIV");
                        b.innerHTML = "<strong style = 'color: #ffff'>" + arr[i].product.substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].product.substr(val.length);
                        b.innerHTML += "<input type='hidden'  value='" + arr[i].product + "'>";
                        b.addEventListener("click", function (e) {
                            inp.value = this.getElementsByTagName("input")[0].value;
                            $("#loss_and_damage_input_inventory_id").val(inventory_id);
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