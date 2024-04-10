<style>
    #unpaid_purchase_modal {
        display: flex;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        justify-content: center;
        align-items: center;
        background-color: rgba(0, 0, 0, 0.4);
    }

    #unpaidPurchase_content{
        background-color: #1E1C11;
        color: #ffff;
    }
    .form-group {
        display: flex;
        align-items: center; 
        margin-bottom: 10px;
        margin: 15px 15px;
    }

    .l_input{
        width: 30px; 
    }

    .p_input {
        flex: 1; 
        box-sizing: border-box;
        padding: 5px;
        border: 1px solid #fff;
        border-radius: 0; 
    }
    .l_input1{
        width: 180px; 
    }

    .p_input1 {
        flex: 1; 
        box-sizing: border-box;
        padding: 5px;
        border: 1px solid #fff;
        border-radius: 0; 
    }
    .has-error{
      border: 1px solid red;
    }
    .tab {
      overflow: hidden;
      border: 1px solid #ccc;
      background-color: #1E1C11;
    }
    .tab button {
      background-color: inherit;
      float: left;
      border: none;
      outline: none;
      cursor: pointer;
      padding: 14px 16px;
      transition: 0.3s;
      font-size: 17px;
    }
    .tab button:hover {
      background-color: #FF6900;
    }
    .tab button.active {
      background-color: #FF6900;
    }
    .tabcontent {
      display: none;
      padding: 6px 12px;
      border: 1px solid #ccc;
      border-top: none;
    }

</style>
<div class="modal" id = "unpaid_purchase_modal" tabindex="-1" role="dialog" style = "display:none">
  <div class="modal-dialog" role="document" >
    <div class="modal-content" id = "purchaseQty_content" style = "width: 550px; box-shadow: 0 4px 8px rgba(0,0,0,2); margin: 0 auto;">
      <div class="modal-header" style = "border: none">
        <h3 class="modal-title" id = "unpaid_modalTitle"></h3>
        <button type="button" class="close" data-dismiss="modal" id = "btn_pqtyClose" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="unpaid_form">
        <input type="hidden" name = "type" value = "unpaid">
        <div class="modal-body" style="border: none">
          <div class="tab">
            <button class="tablinks" data-tab="tab1">Payment</button>
            <button class="tablinks" data-tab="tab3">Settings</button>
            <button class="tablinks" data-tab="tab2">History</button>
          </div>
          <div id="tab1" class="tabcontent">
            <p></p>
            <div style = "text-align:center">
              <h5>Enter <b style = 'color: #FF6900'>QUANTITY</b> and your <b style = 'color: #FF6900'>PAYMENT</b></h5>
              <h5 id = "product_name"></h5>
            </div>
            <div class="fieldContainer" style = "display:flex">
                <div class="form-group" >
                    <label for="p_qty" id="lbl_pqty" class="l_input" style="color: #FF6900;"><strong>QTY:</strong></label>
                    <input type="text" class="p_input" name="u_qty" id="u_qty" onkeyup="$(this).removeClass('has-error')" autocomplete="off" style = "text-align:right">
                </div>
                <div class="form-group" >
                    <label for="u_pay" id = "" class="l_input" style="color: #FF6900; "><strong>PAY: </strong></label>
                    <input type="text" class="p_input" pattern="\d+(\.\d{1,2})?" name="u_pay" id="u_pay" oninput="$(this).removeClass('has-error')" autocomplete="off" style = "text-align: right">
                </div>
            </div>
            <div class="fieldContainer" >
                <div class="form-group" >
                    <label for="r_balance" id = "" class="l_input1" style="color: #FF6900; "><strong>REMAINING BALANCE: </strong></label>
                    <input type="text" class="p_input1" pattern="\d+(\.\d{1,2})?" name="r_balance" id="r_balance" oninput="$(this).removeClass('has-error')" value = "0.00" autocomplete="off" style = "text-align: right" readonly>
                </div>
            </div>
          </div>
          <div id="tab3" class="tabcontent">
            <div class="fieldContainer" style = "display:flex" >
                <div class="form-group" >
                    <label for="s_price" class="l_input" style="color: #FF6900;"><strong>PRICE</strong></label>
                    <input type="text" class="p_input" pattern="\d+(\.\d{1,2})?" name="s_price" id="s_price" onkeyup="$(this).removeClass('has-error')" autocomplete="off" style = "text-align: right">
                </div>
                <div class="form-group" >
                    <label for="s_due" class="l_input" style="color: #FF6900; "><strong>DUE</strong></label>
                    <input type="text" class="p_input"  name="s_due" id="s_due" oninput="$(this).removeClass('has-error')" autocomplete="off">
                </div>
            </div>
          </div>
          <div id="tab2" class="tabcontent">
            <table id="tbl_paymentHistory" class="text-color table-border" style=" width: 100%; border: 1px solid #FF6900; color: white; font-size: 10px">
              <thead >
                <tr>
                  <th style = "background-color: #1E1C11; border: 1px solid #FF6900; width: 50%">PAYMENT</th>
                  <th style = "background-color: #1E1C11; border: 1px solid #FF6900; ">DATE</th>
                  <th style = "background-color: #1E1C11; border: 1px solid #FF6900; ">BALANCE</th>
                </tr>
              </thead>
              <tbody style = "border-collapse: collapse; border: none">
    
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer" style='display: flex; justify-content: space-between; border: none'>
          <button class="grid-item text-color button-cancel" style="border-radius: 0;" id="btn_pqtyCancel" data-dismiss="modal"><i class="bi bi-x"></i>&nbsp; Cancel</button>
          <button class="grid-item text-color button" style="border-radius: 0;" type="submit"><i class="bi bi-arrow-right-circle"></i>&nbsp; Continue</button>
        </div>
      </form>
    </div>
  </div>
</div>