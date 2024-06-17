<style>
    tr:hover {
        background-color: #151515;
        cursor: pointer;
    }
    #po_form input, label{
        font-size: 14px;
    }
    #tbl_purchaseOrders tbody{
        font-size: 12px;
    }
    #tbl_purchaseOrders thead th{
       border: none;
       color: #FF6900;
    }
    #tbl_purchaseOrders thead{
       border: 1px solid #FF6900;
    }
    #tbl_purchaseOrders tbody td{
        border: none;
    }

    #tbl_purchaseOrders_footer thead{
        font-size: 12px;
    }
    #tbl_purchaseOrders_footer thead th{
       border: none;
       color: #FF6900;
    }
    #tbl_purchaseOrders_footer thead{
       border: 1px solid #FF6900;
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
    #date_purchased {
        outline: none; /* Remove default focus outline (optional) */
    }

    #date_purchased:focus {
        outline: none; /* Remove focus outline when element is focused (optional) */
    }
</style>
<div class="fcontainer" id = "purchaseItems_div" style = "display: none">
    <form id="po_form">
        <input type="hidden" name="order_id" id="_order_id" value="0">
        <input type="hidden" name="inventory_id" id="_inventory_id" value="0">
        <div class="fieldContainer" >
            <label>PO#</label>
            <input type="text" name="po_number" id="pcs_no" onkeyup="$(this).removeClass('has-error')" style="height: 30px;" value=""
                readonly />
            <div class="toggle-switch-container">
                <label for="paidSwitch" class="switch-label" style="color: #28a745; ">Paid</label>
                <div class="form-check form-switch" style="margin-left: 15px; ">
                    <input class="form-check-input" type="checkbox" id="paidSwitch" name="isPaid" style="height: 15px;">
                </div>
            </div>
            <div class="date-input-container">
                <input type="text" name="date_purchased" id="date_purchased" placeholder="Select date" readonly>
                <button id="calendar-btn" class="button">
                    <i class="bi bi-calendar" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        <div class="fieldContainer" style = "margin-top: 2px;">
            <label>Supplier</label>
            <div class="custom-select" style="margin-right: 0px; ">
                <select name="supplier" id = "supplier"
                    style=" background-color: #1E1C11; color: #ffff; width: 160px; border: 1px solid #ffff; font-size: 14px; height: 30px;">
                    
                </select>
                <i class="bi bi-chevron-double-down"></i>
            </div>
          
        </div>
        <div class="fieldContainer" style = "margin-top: -3px;">
            <input type = "hidden" id = "selected_product_id" value = "0" >
            <label><img src="assets/img/barcode.png" style="color: white; height: 50px; width: 40px;"></label>
            <div class="search-container">
                <input type="text" style="width: 280px; height: 30px;" class="search-input italic-placeholder"
                    placeholder="Search Product,[Name, Barcode, Brand]" name="product" onkeyup="$(this).removeClass('has-error')" id="product"
                    autocomplete="off" autofocus="autofocus" >
            </div>
            <button style=" height: 30px; width: 120px; font-size: 12px;" id="btn_addPO">
                    Add Product</button>
        </div>
    </form>
    <table id="tbl_purchaseOrders" class="text-color table-border" style = "margin-top: -3px;">
        <thead>
            <tr>
                <th style="background-color: #1E1C11; width: 50%">ITEM DESCRIPTION</th>
                <th style="background-color: #1E1C11;  ">QTY</th>
                <th style="background-color: #1E1C11; ">PRICE</th>
                <th style="background-color: #1E1C11;  ">TOTAL</th>
            </tr>
        </thead>
        <tbody id="po_body" style="border-collapse: collapse; border: none">

        </tbody>
    </table>
    <table id = "tbl_purchaseOrders_footer" class="text-color table-border" style="position: absolute; bottom: 5px; padding: 10px;">
        <thead>
            <tr>
                <th style="background-color: #1E1C11;  text-align: left; width: 50%"
                    id="totalTax">Tax: 0.00</th>
                <th style="background-color: #1E1C11;  text-align: right" id="totalQty">0</th>
                <th style="background-color: #1E1C11; text-align: right" id="totalPrice">
                    &#x20B1;&nbsp;0.00</th>
                <th style="background-color: #1E1C11;  text-align: right" id="overallTotal">
                    &#x20B1;&nbsp;0.00</th>
            </tr>
        </thead>
    </table>
</div>


<script>
   
</script>