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

    #tbl_inventory_count tbody {
        font-size: 12px;
    }

    #tbl_inventory_count tbody {
        font-size: 12px;
    }

    #tbl_inventory_count thead th {
        border: none;
        color: #FF6900;
    }

    #tbl_inventory_count thead {
        border: 1px solid #FF6900;
    }

    #tbl_inventory_count tbody td {
        border: none;
    }
</style>
<div class="fcontainer" id="inventorycount_div" style="display: none">
    <form id="inventorycount_form">
        <div class="fieldContainer">
            <label>REF# </label>
            <input type="text" name="ref" id="ic_reference" name="ic_reference"
                style="width: 250px; height: 30px; font-size: 14px;" readonly>
            <div class="date-input-container">
                <input type="text" name="date_counted" oninput="$(this).removeClass('has-error')" id="date_counted"
                    style="height: 30px;  text-align: center" placeholder="Select date" readonly>
                <button id="btn_dateCounted" class="button" type="button" style="height: 30px;">
                    <i class="bi bi-calendar2" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        <div class="fieldContainer">
            <div class="custom-select" style = "margin-right: 5px;">
                <select name="qi_inventory_type" id = "qi_inventory_type"
                    style=" background-color: #1E1C11; color: #ffff; width: 160px; border: 1px solid #ffff; font-size: 12px; height: 30px;">
                    <option value="0">Select inventory type</option>
                    <option value="1">B.O.M Inventory</option>
                    <option value="2">Product Inventory</option>
                </select>
                <i class="bi bi-chevron-double-down"></i>
            </div>
            <button style="font-size: 12px; height: 30px; border-radius: 4px;" id="btn_go_inventory">
                GO</button>
        </div>
    </form>
    <table id="tbl_inventory_count" class="text-color table-border" style=" margin-bottom: 30vh">
        <thead>
            <tr>
                <th style="background-color: #1E1C11; width: 50%">ITEM DESCRIPTION</th>
                <th style="background-color: #1E1C11; text-align:center">QTY</th>
                <th style="background-color: #1E1C11; text-align:center">COUNTED</th>
                <th style="background-color: #1E1C11; text-align:right">DIF.</th>
            </tr>
        </thead>
        <tbody style="border-collapse: collapse; border: none">

        </tbody>
    </table>
</div>


<script>
    $(document).ready(function () {
        show_reference_no();
        function show_reference_no() {
            $.ajax({
                type: 'get',
                url: 'api.php?action=get_inventorycount_latest_reference_no',
                success: function (data) {
                    $("#ic_reference").val(data);
                }
            })
        }
        $('#date_counted').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'M dd y',
            altFormat: 'M dd y',
            altField: '#date_counted',
            minDate: 0,
            onSelect: function (dateText, inst) { }
        });
        $("#qi_inventory_type").on("change", function(){
            $(this).css("border", "1px solid #ffff")
        })
        function clean_number(number) {
            return number.replace(/[₱\s]/g, '');
        }
        $('#btn_dateCounted').on('click', function (e) {
            e.preventDefault();
            $('#date_counted').datepicker('show');
        });
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        function isDataExistInTable(data) {
            var isExist = false;
            $('#tbl_inventory_count tbody').each(function () {
                var rowData = $(this).find('td:first').text();
                if (rowData === data) {
                    isExist = true;
                    return false;
                }
            });
            return isExist;
        }

        $("#btn_go_inventory").on("click", function (e) {
            e.preventDefault();
            var search_value = $("#qi_inventory_type").val();
            $.ajax({
                type: 'get',
                url: 'api.php?action=get_allProductByInventoryType&type='+search_value,
                success: function (data) {
                    var row = "";
                    for(var i =0 ;i<data.length; i++)
                    {
                        row += "<tr data-id = "+data[i].inventory_id+">";
                        row += "<td>" + data[i].prod_desc + "</td>";
                        row += "<td style = 'text-align:center'>"+data[i].stock+"</td>";
                        row += "<td class = 'text-center'><input placeholder='QTY' style = 'text-align:center; width: 60px; height: 20px; font-size: 12px;'  id = 'counted' ></input></td>";
                        row += "<td style = 'text-align: right'></td>";
                        row += "</tr>";
                    }
                    $("#tbl_inventory_count tbody").html(row);
                }
            })
           
        })
        $("#tbl_inventory_count").on("input", "#counted", function (e) {
            e.preventDefault();
            $(this).removeClass('has-error');
            var counted = $(this).val();
            counted = parseFloat(counted);
            var stock = $(this).closest("tr").find("td:nth-child(2)").text();
            stock =parseFloat(stock);

            if(stock < 0)
            {
                var difference = stock + counted
                if(difference > 0) difference = "+"+difference;
                $(this).closest("tr").find("td:nth-child(4)").text(difference);
            }
            else
            {
                var difference = counted - stock;
                if(difference > 0) difference = "+"+difference;
                $(this).closest("tr").find("td:nth-child(4)").text(difference);
            }
        })
      
    })
</script>