<style>
    #purchase_modal_payment {
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

    #purchase_modal_payment_content{
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
    .exclamation-icon  {
       color: red;
      }
</style>
<div class="modal" id = "purchase_modal_payment" tabindex="-1" role="dialog" style = "display:none">
  <div class="modal-dialog" role="document" >
    <div class="modal-content" id = "purchase_modal_payment_content" style = "width: 550px; box-shadow: 0 4px 8px rgba(0,0,0,2); margin: 0 auto;">
      <div class="modal-header" style = "border: none">
        <h3 class="modal-title" id = "modalTitle"></h3>
        <button type="button" class="close" data-dismiss="modal" id = "btn_pqtyClose" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="purchase_modal_payment_form">
        <input type="hidden" id = "payment_order_id" value = "0">
        <input type="hidden" id = "order_payment_setting_id" value = "0" name = "order_setting_id">
        <div class="modal-body" style="border: none">
          <div class="tab">
            <button class="tablinks" data-tab="tab1">Payment</button>
          </div>
          <div id="tab1" class="tabcontent">
            <p></p>
            <div style = "text-align:center">
              <h5>Payment <b style = 'color: #FF6900'>HISTORY</b> for <b style = 'color: #FF6900'>SUPPLIER</b></h5>
              <h5 id = "product_name"></h5>
            </div> 
            <div class="fieldContainer"  >
              <div class="form-group" >
                  <label for="next_payment"  class="l_input" style="color: #FF6900; "><strong>Pay: </strong></label>
                  <input type="text" class="p_input"  name="next_payment" id="next_payment" oninput="$(this).removeClass('has-error')" autocomplete="off" style = "text-align: right">
              </div>
              <div class="form-group" >
                  <label for="rem_balance" id = "" class="l_input" style="color: #FF6900; "><strong>BAL: </strong></label>
                  <input type="text" class="p_input" name="rem_balance" id="rem_balance" oninput="$(this).removeClass('has-error')" value = "0.00" autocomplete="off" style = "text-align: right" readonly>
              </div>
              <div class="form-group" >
                <label for="date_paid" class="l_input" style="color: #FF6900; "><strong>DATE</strong></label>
                <div class="date-input-container" style = "  display: flex; align-items: center">
                  <input type="text" name="date_paid" id="date_paid"  class = "p_input" placeholder="Select date" readonly style = "text-align: center; " >
                  <button id="calendar-btn3" class="button p-input" type = "button">
                      <i class="bi bi-calendar" aria-hidden="true"></i>
                  </button>
                </div>
              </div>
            </div>
            <table id="tbl_paymentHistory" class="text-color table-border" style=" width: 100%; border: 1px solid #FF6900; color: white; font-size: 10px">
              <thead >
                <tr>
                  <th style = "background-color: #1E1C11; border: 1px solid #FF6900; ">DATE PAID</th>
                  <th style = "background-color: #1E1C11; border: 1px solid #FF6900; width: 30%">PAYMENT <span id = "total_toPay" style = 'text-align: right'></span></th>
                  <th style = "background-color: #1E1C11; border: 1px solid #FF6900; width: 30%">BALANCE</th>
                </tr>
              </thead>
              <tbody style = "border-collapse: collapse; border: none">
    
              </tbody>
              <tfoot>
                <tr>
                  <th style = 'text-align: right'>Total</th>
                  <th id = "payment_totalPaid" style = 'text-align: right'></th>
                  <th id = "payment_balance" style = 'text-align: right'></th>
                </tr>
              </tfoot>
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

<script>

  $("#purchase_modal_payment .tablinks").click(function(e) {
    e.preventDefault();
      var tabId = $(this).data("tab");
      $("#purchase_modal_payment .tabcontent").hide();
      $("#purchase_modal_payment #" + tabId).show();
      $("#purchase_modal_payment .tablinks").removeClass("active");
      $(this).addClass("active");
  });
  $("#purchase_modal_payment .tablinks[data-tab='tab1']").addClass("active");
  $("#purchase_modal_payment #tab1").show();
  $("#purchase_modal_payment #btn_pqtyCancel, #btn_pqtyClose").click(function(){
    $("#purchase_modal_payment").hide();
  })
  $('#purchase_modal_payment #s_due').datepicker({
      dateFormat: 'M dd y', 
      altFormat: 'M dd y', 
      altField: '#purchase_modal_payment #s_due',
      minDate: 0,
      onSelect: function(dateText, inst)
      {}
    });
 
 
  $('#purchase_modal_payment #calendar-btn1').click(function() {
      $('#purchase_modal_payment #s_due').datepicker('show');
  });
  function clean_number(number)
  {
    return number.replace(/[^\d.]+/g, '');
  }
  $("#purchase_modal_payment #interest_rate").on('input', function(){
    var interest_rate = parseFloat($(this).val());
    var loan_amount = parseFloat(clean_number($("#purchase_modal_payment #loan_amount").val()));

    var withInterest = (loan_amount*interest_rate/100);
    var total_withInterest = loan_amount+withInterest;
    $("#purchase_modal_payment #withInterest").val("₱ "+addCommasToNumber(+withInterest.toFixed(2)));
    $("#purchase_modal_payment #total_withInterest").val("₱ "+addCommasToNumber(total_withInterest.toFixed(2)));
  });
  $("#purchase_modal_payment #loan_term").on('input', function(e){
    e.preventDefault();
    var loan_term = parseFloat($(this).val());
    var loan_freq = parseFloat($("#amortization_frequency").val());
    var total_withInterest = parseFloat(clean_number($("#purchase_modal_payment #total_withInterest").val()));

    var total_payments = loan_term * loan_freq;
    var installment_amount = total_withInterest / total_payments; 
    var balance = total_withInterest - installment_amount;
    $("#purchase_modal_payment #u_pay").val("₱ "+addCommasToNumber(installment_amount.toFixed(2)));
    $("#purchase_modal_payment #r_balance").val("₱ "+addCommasToNumber(balance.toFixed(2)));
  });
  $("#purchase_modal_payment #amortization_frequency").on('change', function(e){
    e.preventDefault();
    var loan_freq = parseFloat($(this).val());
    var loan_term = parseFloat($("#loan_term").val());
    var total_withInterest = parseFloat(clean_number($("#purchase_modal_payment #total_withInterest").val()));

    var total_payments = loan_term * loan_freq;
    var installment_amount = total_withInterest / total_payments; 
    var balance = total_withInterest - installment_amount;
    $("#purchase_modal_payment #u_pay").val("₱ "+addCommasToNumber(installment_amount.toFixed(2)));
    $("#purchase_modal_payment #r_balance").val("₱ "+addCommasToNumber(balance.toFixed(2)));
  })
  function addCommasToNumber(number) 
  {
    var roundedNumber = Number(number).toFixed(2);
    var parts = roundedNumber.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
  }
</script>