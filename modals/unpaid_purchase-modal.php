<style>
    #unpaid_purchase_modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    #unpaid_purchase_modal .modal-content {
        background-color: #1E1C11;
        margin: 10% auto;
        max-width: 400px;
        height: 430px;
        max-height: 100%;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    @media screen and (max-width: 768px) {
        #unpaid_purchase_modal .modal-content {
            margin: 30% auto;
        }
    }

    #unpaid_purchase_modal .modal-header {
        background-color: black;
        height: 20px;
        font-size: 11px;
        color: var(--primary-color);
    }

    #unpaid_purchase_modal .modal-header,
    .modal-body {
        border: none;
    }
    #unpaid_purchase_modal p {
        font-size: 10px;
    }

    .image img {
        height: 160px;
        width: 160px;
        border: 1px solid #ccc;
    }

    #unpaid_purchase_modal #btn_cancel,
    #btn_print {
        border-radius: 3px;
        border: 1px solid #ccc;
        height: 30px;
        width: 70px;
        background-color: #1E1C11;
    }

    #unpaid_purchase_modal #btn_cancel:hover {
        background-color: red;
    }

    #unpaid_purchase_modal #btn_print:hover {
        background-color: green;
    }

    #unpaid_purchase_modal .action-button {
        position: absolute;
        right: 180px;
    }

    #unpaid_purchase_modal .firstCard button h6,
    button p {
        margin-bottom: 0;
    }

    #unpaid_purchase_modal p {
        font-weight: normal;
    }
    .tinker_label{
      color: #fff;
    }
    .stockeable {
      position: relative;
      display: inline-block;
      width: 40px; 
      height: 20px; 
      outline: none; 
      margin-left: 10px;
    }

.stockeable input {
  opacity: 0;
  width: 0;
  height: 0;
}

.stockeableSpan {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #262626;
  -webkit-transition: .4s;
  transition: .4s;
  outline: none;
  border-radius: 10px; 
}

.stockeableSpan:before {
  position: absolute;
  content: "";
  height: 16px; 
  width: 16px;
  left: 2px; 
  bottom: 2px;
  background-color: #888888;
  -webkit-transition: .4s;
  transition: .4s;
  border-radius: 50%; 
}

input:checked + .stockeableSpan {
  background-color: var(--primary-color);
}

input:focus + .stockeableSpan {
  box-shadow: 0 0 1px #262626;
}

input:checked + .stockeableSpan:before {
  -webkit-transform: translateX(20px); 
  -ms-transform: translateX(20px);
  transform: translateX(20px); 
}

.stockeableSpan.round {
  border-radius: 10px; 
}

.stockeableSpan.round:before {
  border-radius: 50%; 
}

.stockeableSpan.active {
  background-color: var(--primary-color);
}
textarea::placeholder{
  font-size: 12px;
}
.inputAmount{
  text-align: right;
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
    color: #fff;
    transform: translateY(-50%);
}
.calendar-icon1{
  color: #fff;
}
</style>

<div id="unpaid_purchase_modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h6 style = "color: var(--primary-color); font-weight: bold">UPDATE PAYMENT TERMS </h6>
            <span>
                <button id="close-modal">X</button>
            </span>
        </div>
        <form id = "unpaid_form">
          <input type="hidden" id = "unpaid_order_id" name = "unpaid_order_id" value = "0">
          <input type="hidden" id = "unpaid_identifier" name = "unpaid_identifier" value = "0">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                  <label class = "tinker_label" for="">Amount (Php)</label>
                  <input  type="text" name = "partialPayment" id = "unpaid_amount" class = "inputAmount" autocomplete="off">
              </div>
              <div class="col-md-6" id = "unpaid_hide4">
                  <label class = "tinker_label" for="">Balance (Php)</label>
                  <input type="text" name = "unpaid_balance" id = "unpaid_balance" class = "inputAmount" autocomplete="off"/> 
              </div>
              <div class="col-md-6"  id = "unpaid_hide1">
                  <label class = "tinker_label" for="">Term (No. of Days)</label>
                  <input type="number" name = "unpaid_term" id = "unpaid_term" class = "inputAmount" autocomplete="off"/> 
              </div>
            </div>
            <div class="row" id = "unpaid_toHide1">
              <div class="col-md-6">
                  <label class="tinker_label">Date Paid</label>
                  <div style="display: flex; margin-top: 20px; width: 100%;">
                    <input type="text" id="date_paid" name = "date_paid" style="text-align: center; width: 100%; margin-right: 5px;" placeholder="Choose date" readonly autocomplete="off">
                    <a href="#" id = "btn_datePaid"><i class="bi bi-calendar3 calendar-icon1" style = "font-size: 20px;"></i></a>
                  </div>
              </div>
              <div class="col-md-6">
                  <label class = "tinker_label" for="">Payment Method</label>
                  <div class="custom-select" style="margin-right: 0px; width: 100%;">
                  <select name="payment_method"  id = "payment_method"
                      style=" background-color: #262626; color: #ffff; width: 100%; font-size: 14px; height: 30px;">
                      <option value="">
                  
                      </option>
                  </select>
                  <i class="bi bi-chevron-double-down"></i>
                </div>
              </div>
            </div>
            <div class="row" id = "unpaid_hide1">
              <div class="col-md-6">
                  <label class="tinker_label">Due Date</label>
                  <div style="display: flex; margin-top: 20px; width: 100%;">
                    <input type="text" id="unpaid_dueDate" name = "unpaid_dueDate" style="text-align: center; width: 100%; margin-right: 5px;" placeholder="Choose date" readonly autocomplete="off">
                    <a href="#" id = "btn_unpaidDueDate"><i class="bi bi-calendar3 calendar-icon1" style = "font-size: 20px;"></i></a>
                  </div>
              </div>
              <div class="col-md-6">
                  <br>
                  <label for="" class = "tinker_label">Notification</label>
                  <label class="stockeable" >
                      <input type="checkbox" name = "notification_unpaid" id="notification_unpaid">
                      <span class="stockeableSpan round"></span>
                  </label>
                </div>
            </div>
            <div class="row">
              <div class="col-md-6" id = "unpaid_toHide2">
                  <label class = "tinker_label" for="">Reference No.</label>
                  <input type="text" name = "reference_no" id = "reference_no" class = "inputAmount" autocomplete="off"/> 
              </div>
              <div class="col-md-6" id = "unpaid_hide2">
                <br>
                <label for="" class = "tinker_label">Reccurring</label>
                <label class="stockeable" >
                  <input type="checkbox" name = "reccurring_unpaid" id="reccurring_unpaid">
                  <span class="stockeableSpan round"></span>
                </label>
              </div>
            </div>
            <div class="row" id = "unpaid_hide3">
              <textarea name="unpaid_note" id="unpaid_note" cols="60" rows="5" placeholder="Note" style="background-color: #1E1C11; color: #ffff; width: 95%; margin-left: 15px; margin-top: 5px; font-size: 12px;">
              </textarea>
            </div>
        </div>
        <div class="modal-footer" style = 'border: none; margin-top: -20px;'>
          <button class = "text-color button-cancel" style = "border-radius: 0; font-size: 12px; height: 30px;width: 140px" type = "button" id = "btn_unpaidCancel" data-dismiss="modal"><i class = "bi bi-x"></i>&nbsp; Cancel</button>
          <button  class = "text-color button" type="submit" style = "border-radius: 0; font-size: 12px; height: 30px; width: 140px"  id = "btn_saveUnpaid"><i class = "bi bi-printer"></i>&nbsp; Save & Print</button>
          <!-- <button  class = "text-color button" type="submit" style = "border-radius: 0; font-size: 12px; height: 30px; width: 140px" type = "button" id = "btn_updatePaymentTerms"><i class = "bi bi-save"></i>&nbsp; Update</button> -->
        </div>
      </form>
    </div>
</div>

<script>
    $(document).ready(function () {
      show_allPaymentMethods();
        function show_allPaymentMethods()
        {
          $.ajax({
            type: 'get',
            url: 'api.php?action=get_allPaymentMethods',
            success: function(data){
              var option = "<option value = '0'>Select Here</option>";
              for(var i = 0; i<data.length; i++)
              {
                option += "<option value = "+data[i].id+">"+data[i].method+"</option>";
              }
              option += "<option value = '0'>None</option>";
              $("#payment_method").html(option);
            }
          })
        }
        $("#unpaid_purchase_modal #unpaid_amount").on("input", function() {
            var inputValue = $(this).val();
            
            inputValue = inputValue.replace(/[^0-9.]/g, '');
            
            var parts = inputValue.split('.');
            if (parts.length > 2) 
            {
               inputValue = parts[0] + '.' + parts.slice(1).join('');
            }
            
            if (parts.length === 2) 
            {
              inputValue = parts[0] + '.' + parts[1].slice(0, 2);
            }
            
            $(this).val(inputValue);
        });
        $("#unpaid_purchase_modal #close-modal, #btn_unpaidCancel").on("click", function () {
            $("#unpaid_purchase_modal").hide();
        })
        $('#unpaid_dueDate').datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat: 'M dd y',
          altFormat: 'M dd y',
          altField: '#unpaid_dueDate',
          minDate: 0,
          onSelect: function (dateText, inst) { }
        });
        $('#btn_unpaidDueDate').click(function () {
          $('#unpaid_dueDate').datepicker('show');
        });

        $('#date_paid').datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat: 'M dd y',
          altFormat: 'M dd y',
          altField: '#date_paid',
          minDate: 0,
          onSelect: function (dateText, inst) { }
        });
        $('#btn_datePaid').click(function () {
          $('#btn_datePaid').datepicker('show');
        });
    });
</script>