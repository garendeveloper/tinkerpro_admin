<style>
tr:hover {
    background-color: #151515;
    cursor: pointer;
}

.group {
    display: inline-block;
    margin-right: 3px;
}

strong {
    color: #FF6900;
}

#tbl_receivedItems {
    margin-left: 10px;
}

#tbl_receivedItems thead {
    color: #FF6900;
    border-collapse: collapse;
    border: 1px solid #FF6900;
}

#tbl_receivedItems tbody td,
thead th {
    border: none;
    font-size: 12px;
}

#tbl_receivedItems tbody {
    border: none;
    border-collapse: collapse;
    border: 1px solid #ffff;
}

.italic-placeholder::placeholder {
    font-style: italic;
}

.custom-checkbox {
    width: 12px;
    height: 15px;
    border: 2px solid #ffff;
    cursor: pointer;
    text-align: center;
    display: inline-block;
}

.checked {
    background-color: #FF6900;
}

.switch {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    border-radius: 20px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 16px;
    width: 16px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    border-radius: 50%;
}

input:checked+.slider {
    background-color: #28A745;
}

input:focus+.slider {
    box-shadow: 0 0 1px #28A745;
}

input:checked+.slider:before {
    transform: translateX(20px);
}

.slider.round:before {
    height: 16px;
    width: 16px;
}

#tbl_receivedItems td:nth-child(1) {
    width: 150px;
}

#tbl_receivedItems td:nth-child(2) {
    width: 30px;
}

#tbl_receivedItems td:nth-child(3) {
    width: 30px;
}

#tbl_receivedItems td:nth-child(4) {
    width: 60px;
}

#tbl_receivedItems td:nth-child(5) {
    width: 20px;
}

.table-placeholder td {
    position: relative;
}

.table-placeholder td:empty::before {
    content: "Placeholder Text";
    color: #999;
    font-style: italic;
    position: absolute;
    top: 50%;
    left: 5px;
    transform: translateY(-50%);
}
</style>
<div class="fcontainer" id="received_div" style="display: none">
    <form id="receive_form">
        <div class="fieldContainer">
            <img src="assets/img/barcode.png"
                style="height: 60px; width: 50px; border-radius: 0;  margin-right: 2px; margin-left: 0px;">
            <div class="search-container">
                <input type="text" style="width: 210px; height: 35px; font-size: 16px;"
                    class="search-input italic-placeholder" placeholder="Search Purchase Order No." name="r_PONumbers"
                    id="r_PONumbers" onkeyup="$(this).removeClass('has-error')" autocomplete="off">
            </div>
            <button type="button" style="font-size: 12px; height: 35px; width: 90px;" id="btn_searchPO"><i
                    class="bi bi-search bi-md"></i>&nbsp; Search</button>
        </div>
        <div id="po_data_div" style="display: none">
            <div class="fieldContainer">
                <div class="group">
                    <label>PO#: <strong id="r_po_number"></strong></label>
                    <label>SUPPLIER: <strong id="r_supplier"></strong></label>
                </div>

                <div class="group">
                    <label>DATE: <strong id="r_datePurchased"></strong></label>
                    <label>STATUS: <strong id="r_isPaid"></strong></label>
                </div>
            </div>
            <div class="fieldContainer">
                <div class="group">
                    <label for=""><strong style="color: #ffff;">RECEIVE ALL</strong></label>
                    <label class="switch">
                        <input type="checkbox" name = "receive_all" id = "receive_all" checked>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <table id="tbl_receivedItems" class="text-color">
                <thead>
                    <tr>
                        <th style="background-color: #1E1C11; width: 40%">ITEM DESCRIPTION</th>
                        <th style="background-color: #1E1C11; ">QTY</th>
                        <th style="background-color: #1E1C11;">REC</th>
                        <th style="background-color: #1E1C11;">EXP</th>
                        <th style="background-color: #1E1C11;">SER.</th>
                    </tr>
                </thead>
                <tbody id="po_body" style="border-collapse: collapse; border: none">

                </tbody>
            </table>
        </div>
    </form>
</div>
<script>
$(document).ready(function() {
    show_allPurchaseOrders();
    var po_numbers = [];

    function show_allPurchaseOrders() {
        $.ajax({
            type: 'GET',
            url: 'api.php?action=get_allPurchaseOrders',
            success: function(data) {
                for (var i = 0; i < data.length; i++) {
                    po_numbers.push(data[i].po_number);
                }
                autocomplete(document.getElementById("r_PONumbers"), po_numbers);
            }
        });
    }

    $("#btn_searchPO").click(function(e) {
        e.preventDefault();
        var po_number = $("#r_PONumbers").val().trim();
        if (po_number !== '') {
            po_number = $("#r_PONumbers").val();
            if ($.inArray(po_number, po_numbers) !== -1) {
                show_orders(po_number);
                $("#po_data_div").show();
            } else {
                $("#po_data_div").hide();
                $("#tbl_receivedItems tbody").empty();
            }

        } else {
            $("#po_data_div").hide();
        }
    })
    function show_orders(po_number) {
        $.ajax({
            type: 'GET',
            url: 'api.php?action=get_orderDataByPurchaseNumber&po_number=' + po_number,
            dataType: 'json',
            success: function(data) {
                var table = "";

                $("#r_supplier").html(data[0].supplier);
                $("#r_datePurchased").html(date_format(data[0].date_purchased));
                $("#r_po_number").html(data[0].po_number);
                var isPaid = data[0].isPaid === 1 ?
                    "<span style = 'color: lightgreen'>PAID</span>" :
                    "<span style = 'color: red'>UNPAID</span>"
                $("#r_isPaid").html(isPaid);

                for (var i = 0; i < data.length; i++) {
                    table += "<tr>";
                    table += "<td data-id = "+data[i].inventory_id+">" + data[i].prod_desc + "</td>";
                    table += "<td style = 'text-align: center; '>" + data[i]
                        .qty_purchased + "</td>";
                    if(data[i].qty_received === null)
                    {
                        table +=
                        "<td style = 'text-align: center; background-color: #262626; border: 1px solid #ccc;' class ='editable'></td>";
                    }
                    else
                    {
                        table +=
                        "<td style = 'text-align: center; background-color: #262626; border: 1px solid #ccc;' class ='editable'>"+ data[i].qty_received+"</td>";
                    }
                    table +=
                        "<td style = 'text-align: center; background-color: #262626; border: 1px solid #ccc;'></td>";
                    table +=
                        "<td style = 'text-align: center'><div class='custom-checkbox' id='check_isSerialized'></div></td>";
                    table += "</tr>";
                }
                $("#tbl_receivedItems tbody").html(table);
            },
            error: function(data) {
                alert("No response")
            }
        })
    }
    $('#tbl_receivedItems tbody').on('keypress', 'td:nth-child(3)', function(event) {

        var charCode = event.which ? event.which : event.keyCode;
        if (charCode < 48 || charCode > 57) {
            event.preventDefault();
        }
    });
    $('#tbl_receivedItems tbody').on('input', 'td:nth-child(3)', function() {
        var qty_purchased = $(this).prev().text();
        var currentValue = parseInt($(this).text().trim(), 10);
        if (!isNaN(currentValue) && currentValue > qty_purchased) {
            $(this).text(qty_purchased);
        }
    });
    $('#tbl_receivedItems tbody').on('click', 'td:nth-child(4)', function() {
        var input = $('<input type="text">');
        $(this).empty().append(input);
        input.datepicker({
            dateFormat: "M dd yy",
            onSelect: function(dateText) {
                $(this).closest('td').text(dateText);
                $(this).datepicker('hide');
            },
            onClose: function() {
                $(this).datepicker('hide');
            }
        }).datepicker('show');
    });
    $('#tbl_receivedItems tbody').on('click', '#check_isSerialized', function() {
        if ($(this).hasClass('checked')) {
            $(this).removeClass('checked');
        } else {
            $(this).addClass('checked');
        }
    });
    $('#tbl_receivedItems tbody').on('click', '.editable', function() {
        $(this).attr('contenteditable', true);
    });

    function date_format(date) {
        var date = new Date(date);
        var formattedDate = $.datepicker.formatDate("M dd yy", date);
        return formattedDate;
    }

    function autocomplete(inp, arr) {
        var currentFocus;
        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            closeAllLists();
            if (!val) {
                return false;
            }
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
                    b.addEventListener("click", function(e) {
                        inp.value = this.getElementsByTagName("input")[0].value;
                        closeAllLists();
                    });
                    a.appendChild(b);
                }
            }
        });
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                currentFocus++;
                addActive(x);
            } else if (e.keyCode == 38) {
                currentFocus--;
                addActive(x);
            } else if (e.keyCode == 13) {
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
        document.addEventListener("click", function(e) {
            closeAllLists(e.target);
        });
    }
});
</script>