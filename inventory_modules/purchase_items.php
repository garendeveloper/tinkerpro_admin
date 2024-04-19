<style>
    tr:hover {
        background-color: #151515;
        cursor: pointer;
    }
</style>
<div class="fcontainer" id = "purchaseItems_div" style = "display: none">
    <form id="po_form">
        <input type="hidden" name="order_id" id="_order_id" value="0">
        <input type="hidden" name="inventory_id" id="_inventory_id" value="0">
        <div class="fieldContainer">
            <label>PO#</label>
            <input type="text" name="po_number" id="pcs_no" onkeyup="$(this).removeClass('has-error')" value=""
                readonly />
            <div class="toggle-switch-container">
                <label for="paidSwitch" class="switch-label" style="color: #28a745; ">Paid</label>
                <div class="form-check form-switch" style="margin-left: 30px; ">
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
        <div class="fieldContainer">
            <label>Supplier</label>
            <div class="search-container">
                <input type="text" class="search-input" autocomplete="off" type="text"
                    onkeyup="$(this).removeClass('has-error')" name="supplier" id="supplier" value=""
                    style="width: 280px; height: 25px" autocomplete="off">
            </div>
        </div>
        <div class="fieldContainer">
            <label><img src="assets/img/barcode.png" style="color: white; height: 40px; width: 40px;"></label>
            <div class="search-container">
                <input type="text" style="width: 210px; height: 25px; font-size: 12px;" class="search-input"
                    placeholder="Search Prod..." name="product" onkeyup="$(this).removeClass('has-error')" id="product"
                    autocomplete="off">
            </div>
            <button style="font-size: 10px; height: 25px; width: 90px;" id="btn_addPO"><i
                    class="bi bi-plus-square bi-md"></i>&nbsp; Add</button>
        </div>
    </form>
    <table id="tbl_purchaseOrders" class="text-color table-border">
        <thead>
            <tr>
                <th style="background-color: #1E1C11; border: 1px solid #FF6900; width: 50%">ITEM DESCRIPTION</th>
                <th style="background-color: #1E1C11; border: 1px solid #FF6900; ">QTY</th>
                <th style="background-color: #1E1C11; border: 1px solid #FF6900; ">PRICE</th>
                <th style="background-color: #1E1C11; border: 1px solid #FF6900; ">TOTAL</th>
            </tr>
        </thead>
        <tbody id="po_body" style="border-collapse: collapse; border: none">

        </tbody>
    </table>
    <table class="text-color table-border" style="position: absolute; bottom: 5px; padding: 10px;">
        <thead>
            <tr>
                <th style="background-color: #1E1C11; border: 1px solid #FF6900; text-align: left; width: 50%"
                    id="totalTax">Tax: 0.00</th>
                <th style="background-color: #1E1C11; border: 1px solid #FF6900; text-align: right" id="totalQty">0</th>
                <th style="background-color: #1E1C11; border: 1px solid #FF6900; text-align: right" id="totalPrice">
                    &#x20B1;&nbsp;0.00</th>
                <th style="background-color: #1E1C11; border: 1px solid #FF6900; text-align: right" id="overallTotal">
                    &#x20B1;&nbsp;0.00</th>
            </tr>
        </thead>
    </table>
</div>