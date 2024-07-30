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
        width: 300px;
        height: 100px;
        overflow: auto;
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
    .ui-autocomplete {
        background-color: #151515;
        color: #ffff;
    }
    .ui-menu-item {
        padding: 5px 10px;
    }

    .ui-menu-item:hover {
        background-color: #FF6900; 
        color: #ccc;
    }
    .ui-autocomplete .ui-menu-item.ui-state-focus, .ui-menu-item:hover {
        background-color: #FF6900; 
    }
    .fcontainer {
        display: flex;
        flex-direction: column;
        height: 75vh; 
        position: relative;
    }
    .bottom-area {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 10px;
    border-top: 1px solid #ccc;
    }

    .bottom-area {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    }
</style>
<div class="fcontainer" id="lossanddamage_div" style="display: none">
    <form id="lossanddamage_form">
        <div class="fieldContainer">
            <label>REF# </label>
            <input type="text" name="ref" id="ld_reference" name="ld_reference" style="width: 250px; height: 30px; font-size: 14px;" readonly />
            <input type = "hidden" name ="lossDamageInfoID" id = "lossDamageInfoID" value = ""/>
            <!-- <div class="date-input-container">
                <input type="text" name="date_damage" oninput="$(this).removeClass('has-error')" id="date_damage"
                    style="height: 30px;  text-align: center" placeholder="Select date" readonly>
                <button id="btn_dateDamage" class="button" type="button" style="height: 30px;">
                    <i class="bi bi-calendar2" aria-hidden="true"></i>
                </button>
            </div> -->
            <div class="date-input-container" id="btn_dateDamage">
                <input type="text" name="date_damage" id="date_damage" style="height: 30px;  text-align: center" placeholder="Select date" oninput="$(this).removeClass('has-error')" readonly>
                <i id="calendar-btn" class="bi bi-calendar3 calendar-icon"   aria-hidden="true"></i>
            </div>
        </div>
        <div class="fieldContainer">
            <label for="" style="width:350px; font-size: 12px; font-style: italic">Choose a reason of loss
                &damage</label>
            <div class="custom-select" style="margin-right: 0px; ">
                <select name="ld_reason" id = "ld_reason"
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
            <label>
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="50" fill="#fff" class="bi bi-upc-scan" viewBox="0 0 16 16">
                <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5M3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0z"/>
              </svg>
             </label>
            <div class="search-container">
                <input type="hidden" id="loss_and_damage_input_inventory_id" value="0">
                <input type="text" style="width: 280px; height: 30px; font-size: 12px;"
                    class="search-input italic-placeholder" placeholder="Search Product,[Name, Barcode, Brand]" name="loss_and_damage_input"
                    onkeyup="$(this).removeClass('has-error')" id="loss_and_damage_input" autocomplete="off">
            </div>
            <button style="font-size: 12px; height: 30px; width: 120px; border-radius: 4px;" id="btn_searchLDProduct">
                Add Product</button>
        </div>
    </form>
    <table  class="text-color table-border tableHead" style="margin-top: -3px; ">
        <thead>
            <tr>
                <th style="background-color: #1E1C11; color:#ffffff; width: 50%">ITEM DESCRIPTION</th>
                <th style="background-color: #1E1C11; color:#ffffff; text-align:center">QTY</th>
                <th style="background-color: #1E1C11; color:#ffffff; text-align:right">COST</th>
                <th style="background-color: #1E1C11; color:#ffffff; text-align:right">TOTAL COST</th>
            </tr>
        </thead>
    </table>
   <div class="scrollable">
    <table id="tbl_lossand_damages" class="text-color table-border" style="margin-top: -3px; margin-bottom: 30vh">
            <tbody style="border-collapse: collapse; border: none">

            </tbody>
        </table>
   </div>

    <div style="position: absolute;padding: 10px; width: 100%;" class = "bottom-area">
        <table id="footer_lossand_damages" class="text-color table-border">
            <thead style="border: none;">
                <tr>
                    <th style="background-color: #1E1C11; color:#ffffff; width: 50%;">TOTAL</th>
                    <th style="background-color: #1E1C11; color:#ffffff; width: 50px; text-align:center;" id="total_qty">0</th>
                    <th style="background-color: #1E1C11; color:#ffffff; text-align: right;" id="total_cost">₱ 0.00</th>
                    <th style="background-color: #1E1C11; color:#ffffff; text-align: right;" id="overall_total_cost">₱ 0.00</th>
                </tr>
                <thead>
        </table>
        <div>
            <textarea name="loss_and_damage_note" id="loss_and_damage_note" cols="80" rows="5" placeholder="Note"
                style="background-color: #1E1C11; color: #ffff; width: 100%;">

            </textarea>
        </div>
    </div>

</div>


<script>
    $(document).ready(function () {
        show_reference_no();
        show_allProducts();
        var toastDisplayed = false;
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
        // function isDataExistInTable(data) {
        //     var isExist = false;
        //     $('#tbl_lossand_damages tbody').each(function () {
        //         var rowData = $(this).find('td:first').data('id');
        //         if (rowData === data) {
        //             isExist = true;
        //             return false;
        //         }
        //     });
        //     return isExist;
        // }
        function isDataExistInTable(data) 
        {
            var $matchingRow = $('#tbl_lossand_damages tbody td[data-id="' + data + '"]').closest('tr');
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
                    label: row.product,
                    value: row.product,
                    id: row.product_id
                };
            });
        }
        function append_to_table()
        {
            var product_id = $("#loss_and_damage_input_inventory_id").val();
            $.ajax({
                type: 'get',
                url: 'api.php?action=get_productInfo',
                data: { data: product_id },
                success: function (data) {
                    var row = "";
                    row += "<tr data-id = " + data['id'] + " data-ld_id = ''>";
                    row += "<td data-id = " + data['id'] + " style = 'width: 50%'>" + data['prod_desc'] + "</td>";
                    row += "<td style = 'text-align:center; width: 50px' ><input placeholder='QTY' style = 'text-align:center; width: 50px; height: 20px; font-size: 12px;' id = 'qty_damage' autocomplete = 'off'></input></td>";
                    row += "<td style = 'text-align:right' id = 'cost' class='editable' data-id=" + data['cost'] + ">₱ " + numberWithCommas(data['cost']) + "</td>";
                    row += "<td style = 'text-align:right' id = 'total_row_cost'></td>";
                    row += "</tr>";
                    // if (data["isSerialized"] === 1) {
                    //     var sub_row = data["sub_row"];
                    //     var html_sub_row = "";
                    //     for (var j = 0; j < sub_row.length; j++) {
                    //         html_sub_row += "<tr class ='sub-row' data-id = " + data["inventory_id"] + ">";
                    //         html_sub_row += "<td data-id=" + sub_row[j].serial_id + "><input  id= 'serial_number' style = 'width: 130px; height: 20px; font-size: 10px;' placeholder='Serial Number' class='italic-placeholder' value = " + sub_row[j].serial_number + " readonly></input><input type = 'checkbox'  id = 'serial_ischeck' style = 'height: 20px'></input></td>";
                    //         html_sub_row += "</tr>";
                    //     }
                    //     row += html_sub_row;
                    // }
                    $("#tbl_lossand_damages").append(row);
                }
                })
                $("#loss_and_damage_input_inventory_id").val("");
        }
        $("#btn_searchLDProduct").click(function (e) {
            e.preventDefault();
            var product_id = $("#loss_and_damage_input_inventory_id").val();
            if(product_id !== "" && product_id !== "0")
            {
                if (!isDataExistInTable(product_id)) {
                    append_to_table();
                }
                else {
                    show_errorResponse("Product is already listed in the table")
                }
                updateTotal();
            }
            else
            {
                show_errorResponse("Product not found.")
                
            }
            $("#loss_and_damage_input").val("");
            $("#loss_and_damage_input_inventory_id").val("0");
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
            total_cost = total_cost.toFixed(2);
            $(this).closest("tr").find("#total_row_cost").text("₱ " + numberWithCommas(total_cost))

            // var cursorPosition = getCursorPosition($cell[0]);
            // newCost = acceptsOnlyTwoDecimal(newCost);
            // $cell.text(newCost);
            // cursorPosition = Math.min(cursorPosition, newCost.length);
            // setCursorPosition($cell[0], cursorPosition);
            // newCost = parseFloat(clean_number(newCost));
            // var qty_damage = $cell.closest("tr").find("#qty_damage").val();
            // qty_damage = parseFloat(qty_damage);
            // var newTotal = qty_damage * newCost;
            // $cell.closest('tr').find('td:nth-child(4)').html("&#x20B1;&nbsp;" + newTotal);
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
            if (newCost === null || newCost === "") $cell.text(prevCost);
            else {
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
        function updateTotal() {
            var totalQty = 0; var totalCost = 0; var overall_totalCost = 0;

            $('#tbl_lossand_damages tbody tr:not(.sub-row)').each(function () {
                var quantity = parseInt($(this).find('#qty_damage').val());;
                var cost = $(this).find('td:nth-child(3)').text();
                cost =  cost.replace(/[^0-9.]/g, '');
                cost = parseFloat(cost);
                var subtotal = $(this).find('td:nth-child(4)').text();
                subtotal =subtotal.replace(/[^0-9.]/g, '');
                subtotal = parseFloat(subtotal);

                totalQty += quantity;
                totalCost += cost;
                overall_totalCost += subtotal;
            });
            $("#total_qty").html(totalQty);
            $("#total_cost").html("&#x20B1;&nbsp;" + addCommasToNumber(totalCost));
            $("#overall_total_cost").html("&#x20B1;&nbsp;" + addCommasToNumber(overall_totalCost));
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

        $('#tbl_inventory_count tbody').on('keypress', '#qty_damage', function (event) {
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
     
        $("#loss_and_damage_input").autocomplete({
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
                $("#loss_and_damage_input_inventory_id").val(selectedProductId);
            },
            select: function (event, ui) {
                
                var selectedProductId = ui.item.id;
                $("#loss_and_damage_input_inventory_id").val(selectedProductId);
                if(selectedProductId !== "" && selectedProductId !== "0")
                {
                    if (!isDataExistInTable(selectedProductId)) {
                        append_to_table(selectedProductId);
                    }
                    else {
                        show_errorResponse("Product is already listed in the table")
                    }
                    updateTotal();
                    $("#loss_and_damage_input_inventory_id").val("0");
                    $("#loss_and_damage_input").val("");
                }

                return false;
            },
        });
      $("#loss_and_damage_input").on("input", function(e) {
        e.preventDefault();
          var term = $(this).val();
          $(this).autocomplete('search', term);
      });
      $("#loss_and_damage_input").on("keypress", function(event){
        if(event.which === 13){
            var product_id = $("#loss_and_damage_input_inventory_id").val();
            if(product_id !== "" && product_id !== "0")
            {
                if (!isDataExistInTable(product_id)) {
                    append_to_table();
                }
                else
                {
                    show_errorResponse("Product is already listed in the table")
                }
                updateTotal();
            }
            else
            {
                show_errorResponse("Product not found.")
            }
            $("#loss_and_damage_input").val('');
        }
      
      })

    //   $("#loss_and_damage_input").on("autocompletechange", function(event, ui) {
    //     var product_id = $("#loss_and_damage_input_inventory_id").val();
        
    //     if (!isDataExistInTable(product_id)) {
    //         append_to_table();
    //     }
    //     else
    //     {
    //       show_errorResponse("Product already in the table");
    //     }
    //       $(this).val('');
    //   });
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
    })
</script>