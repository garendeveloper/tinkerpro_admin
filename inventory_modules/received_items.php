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
        color: var(--primary-color);
    }

    #tbl_receivedItems {
        margin-left: 10px;
    }

    #tbl_receivedItems thead {
        color: var(--primary-color);
        border-collapse: collapse;
        border: 1px solid var(--primary-color);
    }

    #tbl_receivedItems tbody td,
    thead th {
        border: none;
        font-size: 12px;
        height: 8px;
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
        background-color: #ffff;
        display: inline-block;
    }

    .checked {
        background-color: var(--primary-color);
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

    #tbl_receivedItems {
        height: 3px;
    }

    #tbl_receivedItems td:nth-child(1) {
        width: 5px;
        height: 8px;
    }

    #tbl_receivedItems td:nth-child(2) {
        width: 100px;
        height: 8px;
    }

    #tbl_receivedItems td:nth-child(3) {
        width: 20px;
        height: 8px;
    }

    #tbl_receivedItems td:nth-child(4) {
        width: 20px;
        height: 8px;
    }

    #tbl_receivedItems td:nth-child(5) {
        width: 80px;
        height: 8px;
    }

    #tbl_receivedItems td:nth-child(6) {
        width: 3px;
        height: 8px;
    }

    #tbl_receivedItems tbody {
        font-size: 12px;
        border: none;
    }

    #tbl_receivedItems thead th {
        border: none;
        color: var(--primary-color);
    }

    #tbl_receivedItems thead {
        border: 1px solid var(--primary-color);
    }

    #tbl_receivedItems tbody td {
        border: none;

    }

    .custom-checkbox.disabled {
        opacity: 0.5;
        pointer-events: none;
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
    #tbl_receivedItems tbody th,
    #tbl_receivedItems tbody td {
        padding: 5px 5px; 
        height: 20px; 
        line-height: 1; 
    }
    #tbl_receivedItems {
        border: none;
    }
</style>
<div class="fcontainer" id="received_div" style="display: none;">
    <form id="receive_form">
        <div class="fieldContainer" style="margin-top: -5px;">
            <!-- <img src="assets/img/barcode.png"
                style="height: 50px; width: 50px; border-radius: 0;  margin-right: 2px; margin-left: 0px;"> -->
                <label>
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="50" fill="#fff" class="bi bi-upc-scan" viewBox="0 0 16 16">
                <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5M3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0z"/>
              </svg>
             </label>
            <div class="search-container">
                <input type="hidden" id="is_received" name="is_received" value="0">
                <input type="text" style="width: 280px; height: 30px; font-size: 16px;"
                    class="search-input italic-placeholder" placeholder="Search Purchase Order No." name="r_PONumbers"
                    id="r_PONumbers" onkeyup="$(this).removeClass('has-error')" autofocus="autofocus">
            </div>
            <button type="button" style="font-size: 14px; height: 30px; width: 120px;" id="btn_searchPO"><i
                    class="bi bi-search bi-md"></i>&nbsp; Search</button>
        </div>
        <div id="po_data_div" style="display: none">
            <div class="fieldContainer">
                <div class="group" style="margin-right: 140px;">
                    <label>PO#: <strong id="r_po_number"></strong></label>
                    <label>SUPPLIER: <strong id="r_supplier"></strong></label>
                </div>
                <input type="hidden" id = "order_isPaid" value = "0">
                <div class="group">
                    <label>DATE: <strong id="r_datePurchased"></strong></label>
                    <label>STATUS: <strong id="r_isPaid"></strong></label>
                </div>
            </div>
            <style>
                #f_receive {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }

                .left-aligned {
                    margin-right: auto;
                }

                .right-aligned {
                    margin-left: auto;
                }
                th{
                    color: #ffffff;
                }
            </style>
            <div class="fieldContainer" id="f_receive">
                <div class="group left-aligned">
                    <label for=""><strong style="color: #ffff;">RECEIVE ALL</strong></label>
                    <label class="switch">
                        <input type="checkbox" name="receive_all" id="receive_all" checked>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="group">
                    <label>RECEIVED STATUS: <strong id="received_status">RECEIVED</strong></label>
                </div>
            </div>
            <table id="tbl_receivedItems" class="text-color" >
                <thead>
                    <tr>
                        <th style="background-color: #1E1C11; color: #ffffff;  width: 40%" colspan="2">ITEM DESCRIPTION</th>
                        <th style="background-color: #1E1C11; color: #ffffff">QTY</th>
                        <th style="background-color: #1E1C11; color: #ffffff">RECEIVED</th>
                        <th style="background-color: #1E1C11; color: #ffffff; text-align: center">EXP. DATE</th>
                        <!-- <th style="background-color: #1E1C11;">SER.</th> -->
                    </tr>
                </thead>
                <tbody style="border-collapse: collapse; border: 1px solid #1E1C11">

                </tbody>
            </table>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        show_allPurchaseOrders();
        var toastDisplayed = false;
        var po_numbers = [];
       
        function show_allPurchaseOrders() {
            $.ajax({
                type: 'GET',
                url: 'api.php?action=get_allPurchaseOrders',
                success: function (data) {
                    for (var i = 0; i < data.length; i++) {
                        po_numbers.push(data[i].po_number);

                    }
                    $("#r_PONumbers").autocomplete({
                        source: function (request, response) {
                            var term = request.term.toLowerCase();
                            var array = po_numbers.filter(function (row) {
                                return row.includes(term);
                            });
                            response(array.map(function (row) {
                                return {
                                    label: row,
                                    value: row,
                                };
                            }));
                        },
                        select: function (event, ui) {
                            var selectedItem = ui.value;
                            // $("#r_PONumbers").val(selectedItem);
                            return false;
                        }
                    });
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
        var is_purchasefound = false;
        $("#r_PONumbers").on("keydown", function(event)
        {
            if (event.keyCode === 13 || $(this).val().length >= 12)
            {
                var scannedBarcode = $(this).val();
                if(scannedBarcode !== ""){
                    show_orders(scannedBarcode);
                 
                } else {
                    $("#po_data_div").hide();
                    $("#tbl_receivedItems tbody").empty();
                }
            }
        })
        $("#tbl_receivedItems tbody").on("input", 'tr.sub-row input', function () {
            $(this).removeClass("has-error");
        })
        $("#receive_all").change(function () {
            var isChecked = $(this).prop("checked");
            if (isChecked) {
                $("#tbl_receivedItems #receive_item").prop("checked", true);
                $('#tbl_receivedItems tbody tr').each(function() {
                    var qty_on_hand = $(this).find('td').eq(2).text();
                    $(this).find('td').eq(3).find('#qty_received').val(qty_on_hand); 
                });
            }
            else {
                $("#tbl_receivedItems #receive_item").prop("checked", false);
                $('#tbl_receivedItems tbody tr').each(function() {
                    $(this).find('td').eq(3).find('#qty_received').val('');
                });
            }
        })

       
        $("#btn_searchPO").click(function (e) {
            e.preventDefault();
            var po_number = $("#r_PONumbers").val().trim();
            if (po_number !== '') {
                po_number = $("#r_PONumbers").val();
                if(po_number !== ""){
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
                    success: function (data) {
                        var length = data.length;
                        if(length > 0 )
                        {
                            var table = "";
                            if (data[0].isReceived === 1) $("#received_status").html("RECEIVED");
                            else $("#received_status").html("PENDING");
                            $("#r_supplier").html(data[0].supplier);
                            $("#is_received").val(data[0].isReceived);
                            $("#r_datePurchased").html(date_format(data[0].date_purchased));
                            $("#r_po_number").html(data[0].po_number);
                            var isPaid = data[0].isPaid === 1 ?
                                "<span style = 'color: lightgreen'>PAID</span>" :
                                "<span style = 'color: red'>UNPAID</span>"
                            $("#r_isPaid").html(isPaid);
                            $("#order_isPaid").val(data[0].isPaid);
                            
                            for (var i = 0; i < data.length; i++) {
                               
                                var item = data[i];
                                var expired_date = item.date_expired !== "0000-00-00"? date_format(item.date_expired) : "";
                                table += "<tr data-id = " + data[i].inventory_id + ">";
                                if(item.qty_purchased === 0)
                                {
                                    table += "<td data-id = " + data[i].inventory_id + " colspan = '2'>" + data[i].prod_desc + "</td>";
                                }
                                else
                                {
                                    table += "<td data-id = " + data[i].inventory_id + " class='text-center' style = 'width: 5px;'><input type = 'checkbox' id = 'receive_item' class='custom-checkbox' checked style = 'height: 10px; width: 10px'></input></td>";
                                    table += "<td data-id = " + data[i].inventory_id + ">" + data[i].prod_desc + "</td>";
                                }

                                table += "<td style = 'text-align: center; '>" + data[i].qty_purchased + "</td>";

                                if(item.qty_purchased === 0)
                                {
                                    table += "<td style = 'text-align: center; background-color: #262626; font-style: italic; color: green' colspan = '2'><b>Fully Received</b></td>";
                                }
                                else
                                {
                                    table += "<td style = 'text-align: center; background-color: #262626; '  ><input id = 'qty_received'  placeholder='QTY' value = "+data[i].qty_purchased+" style = 'text-align:center; width: 50px; height: 20px;'></input></td>";

                                    table +=
                                            "<td style = 'text-align: center; background-color: #262626; '><input placeholder = 'Date Expired' style = 'width: 90px; height: 20px;' id = 'date_expired'></input></td>";
                                 
                                    // if (data[i].isSerialized === 1) {
                                    //     table +=
                                    //         "<td style = 'text-align: center'><div class='custom-checkbox checked disabled' id='check_isSerialized'></div></td>";
                                    // }
                                    // if (data[i].isSerialized === 0) {
                                    //     table +=
                                    //         "<td style = 'text-align: center'><div class='custom-checkbox' id='check_isSerialized'></div></td>";
                                    // }
                                    // table += "</tr>";
                                    // if (data[i].isSerialized === 1) {
                                    //     var sub_row = data[i].sub_row;
                                    //     var html_sub_row = "";
                                    //     var counter = 1;
                                    //     for (var j = 0; j < sub_row.length; j++) {
                                    //         html_sub_row += "<tr class ='sub-row' data-id = " + data[i].inventory_id + ">";
                                    //         html_sub_row += "<td>" + counter + "</td>";
                                    //         html_sub_row += "<td data-id = " + sub_row[j].serial_id + " id = 'serial_id'><input  style = 'width: 130px; height: 20px; font-size: 12px;' placeholder='Serial Number' class='italic-placeholder' value = " + sub_row[j].serial_number + "></input></td>";
                                    //         html_sub_row += "<td><button class='btn_removeSerial button-cancel'><i class='bi bi-x'></i></button></td>";
                                    //         html_sub_row += "</tr>";
                                    //         counter++;
                                    //     }

                                    //     table += html_sub_row;

                                    // }
                                }
                            }
                            $("#tbl_receivedItems tbody").html(table);
                            $("#po_data_div").show();
                        }
                        else
                        {
                            show_errorResponse("No purchase order found!");
                        }
                        is_purchasefound = false;
                    },
                    error: function (data) {
                        alert("No response")
                    }
                })
        }
        $('#tbl_receivedItems tbody').on('keypress', '#qty_received', function (event) {
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
        // function acceptsOnlyTwoDecimal(value) 
        // {
        //     value = value.replace(/[^0-9.]/g, '');
        //     let parts = value.split('.');
        //     if(parts[1] && parts[1].length > 2) 
        //     {
        //         parts[1] = parts[1].slice(0, 2); 
        //         value = parts.join('.'); 
        //     }
        //     if(parts.length > 2) 
        //     {
        //         value = parts[0] + '.' + parts.slice(1).join('');
        //     }
        //     return value; 
        // }
        $('#tbl_receivedItems tbody').on('input', '#qty_received', function () {
            var closestTr = $(this).closest('tr');
            var qtyPurchasedTd = closestTr.find('td:nth-child(3)');
            var qty_purchased = parseFloat(qtyPurchasedTd.text());
            var currentValue = parseFloat($(this).val());
            if (!isNaN(currentValue) && currentValue > qty_purchased) {
                $(this).val(qty_purchased);
                // $(this).closest('tr').nextUntil(':not(.sub-row)').remove();
            }
        });
        $("#tbl_receivedItems tbody").on('blur', "#qty_received", function () {
            var currentValue = $(this).val();
            if (!isNaN(currentValue) && currentValue !== "") {
                $(this).removeClass('has-error');
                $(this).closest("td").text(currentValue);
            }
            else{
                $(this).addClass('has-error');
            }
        })
        $('#tbl_receivedItems tbody').on('click', 'td:nth-child(4)', function () {
            var text = $(this).text();
            if (text !== "") {
                var input = "<input id  = 'qty_received' style = 'width: 50px;text-align:center; height: 20px;'  placeholder='QTY'></input>";
                $(this).empty().append(input);
            }
        });
        $('#tbl_receivedItems tbody').on('click', 'td:nth-child(5)', function () {
            var currentText = $(this).text();
            var input = $('<input type="text" placeholder = "Date Expired" style = "width: 90px; height: 20px;">');
            $(this).empty().append(input);
            input.datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "M dd yy",
                minDate: 0,
                onSelect: function (dateText) {
                    $(this).closest('td').text(dateText);
                    $(this).datepicker('hide');
                },
                onClose: function () {
                    $(this).closest('td').text(currentText);
                    $(this).datepicker('hide');
                },
            }).datepicker('show');
        });
        var subRowCount = 0;
        $('#tbl_receivedItems tbody').on('click', '#check_isSerialized', function () {
            var parentRow = $(this).closest("tr");
            var qty_received = parentRow.find("td:nth-child(4)").text();
            if (qty_received != "") {
                parentRow.find("#qty_received").removeClass('has-error');
                var inventory_id = parentRow.data('id');
                if ($(this).hasClass('checked')) {
                    $(this).removeClass('checked');
                    $(this).closest('tr').nextUntil(':not(.sub-row)').remove();
                } else {
                    $(this).addClass('checked');
                    $(this).closest('tr').nextUntil(':not(.sub-row)').remove();
                    for (var i = qty_received; i >= 1; i--) {
                        var subRow = $("<tr class ='sub-row' data-id = " + inventory_id + "><td>" + i + "</td><td><input  style = 'width: 100px' placeholder='Serial Number' class='italic-placeholder'></input></td><td><button class='btn_removeSerial button-cancel'><i class='bi bi-x'></i></button></td></tr>");
                        parentRow.after(subRow);
                    }
                }
            }
            else {
                parentRow.find("#qty_received").addClass('has-error');
            }

        });
        $('#tbl_receivedItems tbody').on('click', '.btn_removeSerial', function (e) {
            e.preventDefault();
            var subrow = $(this).closest("tr");
            subrow.find("td input").val("");
        });
        $('#tbl_receivedItems tbody').on('click', '.editable', function () {
            $(this).attr('contenteditable', true);
        });

        function date_format(date) {
            var date = new Date(date);
            var formattedDate = $.datepicker.formatDate("M dd yy", date);
            return formattedDate;
        }

        $('#print_received_items').on('click', function () {
            $('#print_received_items').show()
            if ($('#print_received_items').is(":visible")) {
                var loadingImage = document.getElementById("loadingImage");
                loadingImage.removeAttribute("hidden");
                var pdfFile = document.getElementById("pdfFile");
                pdfFile.setAttribute('hidden', true)
                var usersSelect = document.getElementById("usersSelect");
                var selectedUser = usersSelect.value;
                var datepicker = document.getElementById('datepicker').value
                var singleDateData = null;
                var startDate;
                var endDate;
                if (datepicker.includes('-')) {

                    var dateRange = datepicker.split(' - ');
                    var startDates = new Date(dateRange[0].trim());
                    var endDate = new Date(dateRange[1].trim());

                    var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth() + 1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
                    var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth() + 1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

                    startDate = formattedStartDate;
                    endDate = formattedEndDate;
                } else {
                    var singleDate = datepicker.trim();
                    var singleDate = datepicker.trim();
                    var dateObj = new Date(singleDate);
                    var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth() + 1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
                    singleDateData = formattedDate

                }
                if (singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null) {
                    singleDateData = ""
                }
                if (startDate == "" || startDate == null) {
                    startDate = ""
                }
                if (endDate == "" || endDate == null) {
                    endDate = ""
                }
                $.ajax({
                    url: 'inventory_modules/receive_items_pdf_report.php',
                    type: 'GET',
                    xhrFields: {
                        responseType: 'blob'
                    },
                    data: {
                        selectedUser: selectedUser,
                        singleDateData: singleDateData,
                        startDate: startDate,
                        endDate: endDate
                    },
                    success: function (response) {
                        loadingImage.setAttribute("hidden", true);
                        var pdfFile = document.getElementById("pdfFile");
                        pdfFile.removeAttribute('hidden')
                        if (loadingImage.hasAttribute('hidden')) {
                            var pdfUrl = './assets/pdf/users/usersList.pdf';
                            $('#pdfViewer').attr('src', pdfUrl);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        console.log(searchData)
                    }
                });
            }
        })
    });
</script>