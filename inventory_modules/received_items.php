<style>
tr:hover {
    background-color: #151515;
    cursor: pointer;
}
.group {
    display: inline-block; 
    margin-right: 10px; 
}
strong{
    color: #FF6900;
}
#tbl_receivedItems thead tr th{
    color: #FF6900;
    border-collapse: collapse;
    border: 1px solid #FF6900;
}
</style>
<div class="fcontainer" id="received_div" style="display: none">
    <form id="receive_form">
        <div class="fieldContainer">
            <label><img src="assets/img/barcode.png"
                    style="color: white; height: 30px; width: 50px; border-radius: none;"></label>
            <div class="search-container">
                <input type="text" style="width: 210px; height: 25px; font-size: 12px;" class="search-input"
                    placeholder="Search Prod..." name="product" onkeyup="$(this).removeClass('has-error')" id="product"
                    autocomplete="off">
            </div>
            <button style="font-size: 10px; height: 25px; width: 90px;" id="btn_addPO"><i
                    class="bi bi-plus-square bi-md"></i>&nbsp; Search</button>
        </div>
        <div class="fieldContainer">
            <div class="group">
                <label>PO#: <strong>10-000012</strong></label>
                <label>SUPPLIER: <strong>Unsilver Philippines</strong></label>
            </div>

            <div class="group">
                <label>DATE: <strong>APRIL 20, 2024</strong></label>
                <label>STATUS: <strong>PAID</strong></label>
            </div>
        </div>
    </form>
    <table id="tbl_receivedItems" class="text-color table-border">
        <thead>
            <tr>
                <th style="background-color: #1E1C11; width: 30%">ITEM DESCRIPTION</th>
                <th style="background-color: #1E1C11; ">QTY</th>
                <th style="background-color: #1E1C11;">RECEIVED</th>
                <th style="background-color: #1E1C11;">EXP</th>
                <th style="background-color: #1E1C11;">SERIALIZED</th>
            </tr>
        </thead>
        <tbody id="po_body" style="border-collapse: collapse; border: none">

        </tbody>
    </table>
</div>