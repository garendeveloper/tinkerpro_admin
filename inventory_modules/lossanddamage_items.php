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
    #tbl_lossand_damages tbody{
        font-size: 12px;
    }
    textarea {
        resize: none; /* Prevent resizing of textarea */
        width: 300px;
        height: 100px;
        overflow: auto; /* Enable scrolling if content exceeds textarea size */
    }
    textarea::placeholder {
        color: #ffff; /* Placeholder text color */
        font-style: italic; /* Placeholder font style */
    }
    #tbl_lossand_damages tbody{
        font-size: 12px;
    }
    #tbl_lossand_damages thead th{
       border: none;
       color: #FF6900;
    }
    #tbl_lossand_damages thead{
       border: 1px solid #FF6900;
    }
    #tbl_lossand_damages tbody td{
        border: none;
    }
    #footer_lossand_damages thead th{
       border: none;
       color: #FF6900;
    }
    #footer_lossand_damages thead{
       border: none;
    }
    #footer_lossand_damages tbody td{
        border: none;
    }
    #footer_lossand_damages{
        border: none;
    }
</style>
<div class="fcontainer" id="lossanddamage_div" style="display: none">
    <form id="lossanddamage_form">
        <div class="fieldContainer">
            <label>REF# </label>
            <input type="text" name = "ref" id = "ld_reference"  name = "ld_reference" style= "width: 250px; height: 30px; font-size: 14px;" readonly>
            <div class="date-input-container">
                <input type="text" name="date_damage" id="date_damage" style="height: 30px;  text-align: center" placeholder="Select date" readonly>
                <button id="btn_dateDamage" class="button" type = "button" style="height: 30px;">
                    <i class="bi bi-calendar2" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        <div class="fieldContainer">
           <label for="" style="width:350px; font-size: 12px; font-style: italic">Choose a reason of loss &damage</label>
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
                <input type="hidden" id = "loss_and_damage_input_inventory_id" value = "0">
                <input type="text" style="width: 280px; height: 30px; font-size: 12px;"
                    class="search-input italic-placeholder" placeholder="Search Prod..." name="loss_and_damage_input"
                    onkeyup="$(this).removeClass('has-error')" id="loss_and_damage_input" autocomplete="off">
            </div>
            <button style="font-size: 12px; height: 30px; width: 120px; border-radius: 4px;" id="btn_searchLDProduct"> Add Product</button>
        </div>
    </form>
    <table id="tbl_lossand_damages" class="text-color table-border" style="margin-top: -3px;">
        <thead>
            <tr>
                <th style="background-color: #1E1C11; ">ITEM DESCRIPTION</th>
                <th style="background-color: #1E1C11; ">QTY</th>
                <th style="background-color: #1E1C11; ">COST</th>
            </tr>
        </thead>
        <tbody style="border-collapse: collapse; border: none">

        </tbody>
        
    </table>
    <table id="footer_lossand_damages" class="" style = "position: absolute; bottom: 120px; width: 100%;">
        <thead style="border: none;">
            <tr>
                <th style="background-color: #1E1C11">TOTAL</th>
                <th style="background-color: #1E1C11" id = "total_qty"></th>
                <th style="background-color: #1E1C11" id ="total_cost"></th>
            </tr>
        <thead>
    </table>
    <div style="position: absolute; bottom: 5px; padding: 10px;">
        <textarea name="stock_note" id="stock_note" cols="80" rows="5" placeholder="Note" style = "background-color: #1E1C11; color: #ffff; width: 100%;">

        </textarea>
    </div>
</div>


<script>
    $(document).ready(function(){
        show_reference_no();
        get_allProductInventory();

        $('#date_damage').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'M dd y', 
            altFormat: 'M dd y', 
            altField: '#date_damage',
            onSelect: function(dateText, inst)
            {}
        });
    
    
        $('#btn_dateDamage').on('click', function(e) {
            e.preventDefault();
            $('#date_damage').datepicker('show');
        });

        $("#btn_searchLDProduct").on("click", function(e){
            e.preventDefault();
            var inventory_id = $("#loss_and_damage_input").data('id');
            $.ajax({
                type:'get',
                url: 'api.php?action=get_inventoryDataById',
                data: {inventory_id: inventory_id},
                success: function(data){
                    var row = "";
                    row += "<tr>";
                    row += "<td>"+data['prod_desc']+"</td>";
                    row += "<td style = 'text-align:center'>"+data['qty_received']+"</td>";
                    row += "<td style = 'text-align:right'>"+data['total']+"</td>";
                    row += "</tr>";
                    $("#tbl_lossand_damages").append(row);
                }
            })
        })

        function get_allProductInventory()
        {
            $.ajax({
                type: 'GET',
                url: 'api.php?action=get_allInventories',
                success: function(data){
                    var products = [];
                    for(var i = 0; i<data.length; i++)
                    {
                        var row = {
                            inventory_id:data[i].inventory_id,
                           product:data[i].prod_desc,
                        };
                        products.push(row);
                    }
                    autocomplete_product(document.getElementById('loss_and_damage_input'), products);
                }
            })
        }
        function show_reference_no()
        {
            $.ajax({
                type: 'get',
                url: 'api.php?action=get_loss_and_damage_latest_reference_no',
                success: function(data){
                    $("#ld_reference").val(data);
                }
            })
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
                        var inventory_id = arr[i].inventory_id;
                        b = document.createElement("DIV");
                        b.innerHTML = "<strong style = 'color: #ffff'>" + arr[i].product.substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].product.substr(val.length);
                        b.innerHTML += "<input type='hidden'  value='" + arr[i].product + "'>";
                        b.addEventListener("click", function (e) {
                            inp.value = this.getElementsByTagName("input")[0].value;
                            inp.setAttribute("data-id", inventory_id);
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