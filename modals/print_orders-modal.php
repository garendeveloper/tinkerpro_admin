<style>
#print_orders_modal {
  display: none;
  position: fixed;
  z-index: 9999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}

.print-orders-content {
    background-color: #fff;
    color: black;
    margin: 25px auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

@media print {
img {
    display: block !important;
    visibility: visible !important;
  }
}
</style>
<div id="print_orders_modal" class="modal">
  <div class="print-orders-content">
    <span class="close">&times;</span>
    <img src="assets/img/tinkerpro-logo-dark.png" style = "width: 100px; height: 60px;"></img>
    <div id = "report_toPrint">
    <div style="border: none">
        <div><strong>Supplier: &nbsp;&nbsp;</strong><span id = "rep_supplier"></span></div>
        <div><strong>Date Purchased: &nbsp;&nbsp;</strong></strong><span id = "rep_datePurchased"></span></div>
        <div><strong>Is Paid &nbsp;&nbsp;</strong></strong><span id = "rep_isPaid"></span></div>
    </div> <br>
    <div style="border: none">
        <div><strong>PURCHASE ORDER</strong></div>
        <div><strong id="rep_po"></strong></div>
    </div>
    <br>
    <table id="tbl_purchaseOrdersReport" class="text-color table-border" style=" width: 100%; border: 1px solid #FF6900; color: black; font-size: 10px">
        <thead >
            <tr>
                <th style = "border: 1px solid #FF6900; ">S/N</th>
                <th style = "border: 1px solid #FF6900; width: 50%">ITEM DESCRIPTION</th>
                <th style = "border: 1px solid #FF6900; ">QTY</th>
                <th style = "border: 1px solid #FF6900; ">PRICE(Php.)</th>
                <th style = "border: 1px solid #FF6900; ">VAT (12%)</th>
                <th style = "border: 1px solid #FF6900; ">TOTAL (Php.)</th>
            </tr>
        </thead>
        <tbody style = "border-collapse: collapse; border: none">

        </tbody>
        <tfoot>
            <tr>
            <th style = "border: 1px solid #FF6900; text-align: right" colspan="2">Total</th>
                <th style = "border: 1px solid #FF6900; text-align: center" id = "rep_qty">0</th>
                <th style = "border: 1px solid #FF6900; text-align: right" id="rep_price">0.00</th>
                <th style = "border: 1px solid #FF6900; text-align: right" id="rep_tax">0.00</th>
                <th style = "border: 1px solid #FF6900; text-align: right" id="rep_total">0.00</th>
            </tr>
        </tfoot>
    </table> <br>
    </div>
    <style>
        .modal_buttons {
            display: flex;
            justify-content: flex-end;
        }
    </style>
   <div class="modal_buttons">
        <button id="print_po" class="grid-item" style = "width: 200px; height: 40px; "><i class="bi bi-printer" ></i> Print</button>
        <button id="close_po" class="grid-item button-cancel" style = "width: 200px; height: 40px; "><i class="bi bi-x"></i> Close</button>
    </div>
  </div>
</div>