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
        height: 350px;
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
        color: #FF6900;
    }

    #unpaid_purchase_modal .modal-header,
    .modal-body {
        border: none;
    }

    /* #unpaid_purchase_modal .modal-body {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-gap: 15px;
        position: relative;
    } */

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
  background-color: #FF6900;
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
  background-color: #FF6900;
}
textarea::placeholder{
  font-size: 12px;
}
.inputAmount{
  text-align: right;
}
</style>

<div id="unpaid_purchase_modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h6 style = "color: #FF6900; font-weight: bold">UPDATE PAYMENT TERMS </h6>
            <span>
                <button id="close-modal">X</button>
            </span>
        </div>
        <form id = "unpaid_form">
        <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                  <label class = "tinker_label" for="">Amount (Php)</label>
                  <input  type="text" name = "unpaid_amount" id = "unpaid_amount"class = "inputAmount" readonly>
              </div>
              <div class="col-md-6">
                  <label class = "tinker_label" for="">Term (No. of Days)</label>
                  <input type="text" name = "unpaid_term" id = "unpaid_term" class = "inputAmount"/> 
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                  <label class="tinker_label">Due Date</label>
                  <div style="display: flex; margin-top: 20px; width: 100%;">
                    <input type="text" id="unpaid_dueDate" name = "unpaid_dueDate" style="text-align: center; width: 100%; margin-right: 5px;" placeholder="Choose date" readonly >
                    <a href="#" id = "btn_unpaidDueDate"><i class="bi bi-calendar" style = "font-size: 20px;"></i></a>
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
              <div class="col-md-6">
                <label for="" class = "tinker_label">Reccurring</label>
                <label class="stockeable" >
                  <input type="checkbox" name = "reccurring_unpaid" id="reccurring_unpaid">
                  <span class="stockeableSpan round"></span>
                </label>
              </div>
            </div>
            <div class="row">
              <textarea name="unpaid_note" id="unpaid_note" cols="60" rows="5" placeholder="Note" style="background-color: #1E1C11; color: #ffff; width: 95%; margin-left: 15px; ">
              </textarea>
            </div>
        </div>
        <div class="modal-footer" style = 'border: none; margin-top: -20px;'>
          <button class = "text-color button-cancel" style = "border-radius: 0; font-size: 12px; height: 30px;width: 140px" id = "btn_paidCancel" data-dismiss="modal"><i class = "bi bi-x"></i>&nbsp; Cancel</button>
          <button  class = "text-color button" type="submit" style = "border-radius: 0; font-size: 12px; height: 30px; width: 140px" type = "button" id = "btn_saveUnpaid"><i class = "bi bi-printer"></i>&nbsp; Save & Print</button>
        </div>
      </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#unpaid_purchase_modal #close-modal, #btn_cancel").on("click", function () {
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
    });
</script>