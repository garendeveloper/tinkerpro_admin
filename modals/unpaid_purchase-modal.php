<style>
    #unpaid_purchase_modal {
        display: flex;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 9999;
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
        margin: 15px 15px;
    }

    .l_input{
        width: 30px; 
        color: #FF6900;
    }

    .p_input {
        flex: 1; 
        box-sizing: border-box;
        padding: 5px;
        border: 1px solid #fff;
        border-radius: 0; 
    }
    .l_input1{
        width: 30px; 
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
    .fieldContainer {
      display: flex; 
      align-items: center; 
    }

    .fieldContainer label {
      margin-right: 10px; 
    }
    #tab1 .fieldContainer input{
      text-align: right;
    }
    .fieldContainer input[type="text"],
    .fieldContainer input[type="date"],
    .fieldContainer {
      margin-right: 7px; 
    }

</style>
<div class="modal" id = "unpaid_purchase_modal" tabindex="-1" role="dialog" style = "display:none">
  <div class="modal-dialog" role="document" >
    <div class="modal-content" id = "unpaidPurchase_content" style = "width: 550px; box-shadow: 0 4px 8px rgba(0,0,0,2); margin: 0 auto;">
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
            <button class="tablinks" data-tab="tab2">History</button>
            <button class="tablinks" data-tab="tab3">Settings</button>
          </div>
          <div id="tab1" class="tabcontent">
            <p></p>
            <div style = "text-align:center">
              <h5>Enter <b style = 'color: #FF6900'>QUANTITY</b> and your <b style = 'color: #FF6900'>PAYMENT</b></h5>
              <h5 id = "product_name"></h5>
            </div>
            <div class="fieldContainer">
                <div class="form-group" style = " margin-right: -2px;" >
                  <label for="loan_amount" class="l_input"><strong>Loan</strong></label>
                  <input type="text" class="p_input" id="loan_amount" name="loan_amount" required style = "width: 120px;">
                </div>
                <div class="form-group" style = " margin-right: -2px;">
                  <label for="interest_rate" class="l_input"><strong>(%):</strong></label>
                  <input type="text" class="p_input" id="interest_rate" name="interest_rate" required style = "width: 60px;">
                </div>
                <div class="form-group" style = " margin-right: -2px;">
                  <label for="withInterest" class="l_input"><strong>Int:</strong></label>
                  <input type="text" class="p_input" id="withInterest" name="withInterest" required style = "width: 90px;" readonly>
                </div>
            </div>
            <div class="fieldContainer">
              <div class="form-group"  style ="justify-content-align: center;">
                  <label for="total_withInterest"  class="l_input" style="color: #FF6900;"><strong>W/Int: </strong></label>
                  <input type="text" class="p_input" pattern="\d+(\.\d{1,2})?" name="total_withInterest" id="total_withInterest" oninput="$(this).removeClass('has-error')" value = "0.00" autocomplete="off" style = "text-align: right" readonly>
              </div>
              <div class="form-group" >
                  <label for="s_due" class="l_input" style="color: #FF6900; "><strong>DUE</strong></label>
                  <div class="date-input-container">
                    <input type="text" name="s_due" id="s_due"  placeholder="Select date" readonly style = "text-align: center; width: 120px" >
                    <button id="calendar-btn1" class="button" type = "button">
                        <i class="bi bi-calendar" aria-hidden="true"></i>
                    </button>
                  </div>
              </div>
            </div>
            <div class="fieldContainer">
              <div class="form-group">
                <label for="loan_term" class="l_input"><strong>Term</strong></label>
                <input type="text" class="p_input" id="loan_term" name="loan_term" value = "1" required >
              </div>
              <div class="form-group">
                <label for="amortization_frequency" class="l_input"><strong>Freq:</strong></label>
                <select id="amortization_frequency" class="p_input" name="amortization_frequency" style = "background-color: #1E1C11; color: #ffff; width: 150px; height: 30px; font-size: 14px;">
                    <option value="1">Annually</option>
                    <option value="12">Monthly</option>
                    <option value="52">Weekly</option>
                    <option value="365">Daily</option>
                </select>
              </div>
            </div>
            <div class="fieldContainer" >
              <div class="form-group" >
                  <label for="u_pay" id = "" class="l_input" style="color: #FF6900; "><strong>Inst: </strong></label>
                  <input type="text" class="p_input" pattern="\d+(\.\d{1,2})?" name="u_pay" id="u_pay" oninput="$(this).removeClass('has-error')" autocomplete="off" style = "text-align: right">
              </div>
              <div class="form-group" >
                  <label for="r_balance" id = "" class="l_input" style="color: #FF6900; "><strong>BAL: </strong></label>
                  <input type="text" class="p_input" pattern="\d+(\.\d{1,2})?" name="r_balance" id="r_balance" oninput="$(this).removeClass('has-error')" value = "0.00" autocomplete="off" style = "text-align: right" readonly>
              </div>
            </div>
          </div>
          <div id="tab2" class="tabcontent">
            <p></p>
            <div style = "text-align:center">
              <h5>Payment <b style = 'color: #FF6900'>HISTORY</b> for <b style = 'color: #FF6900'>SUPPLIER</b></h5>
              <h5 id = "product_name"></h5>
            </div>
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
          <div id="tab3" class="tabcontent">
            <div style = "text-align:center">
              <h5>Enter <b style = 'color: #FF6900'>PRICE</b> and the <b style = 'color: #FF6900'>DUE DATE</b></h5>
            </div>
            <div class="fieldContainer"  >
              <div class="form-group" >
                  <label for="s_price" class="l_input" style="color: #FF6900;"><strong>PRICE</strong></label>
                  <input type="text" class="p_input"  name="s_price" id="s_price" onkeyup="$(this).removeClass('has-error')" autocomplete="off" style = "text-align: right"  readonly>
              </div>
            </div>
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

<script>
  function clean_number(number)
  {
    return number.replace(/[^\d.]+/g, '');
  }
  $("#interest_rate").on('input', function(){
    var interest_rate = parseFloat($(this).val());
    var loan_amount = parseFloat(clean_number($("#loan_amount").val()));

    var withInterest = (loan_amount*interest_rate/100);
    var total_withInterest = loan_amount+withInterest;
    $("#withInterest").val("₱ "+addCommasToNumber(+withInterest.toFixed(2)));
    $("#total_withInterest").val("₱ "+addCommasToNumber(total_withInterest.toFixed(2)));
  });
  $("#loan_term").on('input', function(e){
    e.preventDefault();
    var loan_term = parseFloat($(this).val());
    var loan_freq = parseFloat($("#amortization_frequency").val());
    var total_withInterest = parseFloat(clean_number($("#total_withInterest").val()));

    var total_payments = loan_term * loan_freq;
    var installment_amount = total_withInterest / total_payments; 
    var balance = total_withInterest - installment_amount;
    $("#u_pay").val("₱ "+addCommasToNumber(installment_amount.toFixed(2)));
    $("#r_balance").val("₱ "+addCommasToNumber(balance.toFixed(2)));
  });
  $("#amortization_frequency").on('change', function(e){
    e.preventDefault();
    var loan_freq = parseFloat($(this).val());
    var loan_term = parseFloat($("#loan_term").val());
    var total_withInterest = parseFloat(clean_number($("#total_withInterest").val()));

    var total_payments = loan_term * loan_freq;
    var installment_amount = total_withInterest / total_payments; 
    var balance = total_withInterest - installment_amount;
    $("#u_pay").val("₱ "+addCommasToNumber(installment_amount.toFixed(2)));
    $("#r_balance").val("₱ "+addCommasToNumber(balance.toFixed(2)));
  })
  function addCommasToNumber(number) 
  {
    var roundedNumber = Number(number).toFixed(2);
    var parts = roundedNumber.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
  }
</script>