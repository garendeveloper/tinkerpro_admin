<style>
    #received_payment_confirmation {
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

    #received_payment_confirmation_content {
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
    .has-error{
      border: 1px solid red;
    }
</style>
<div class="modal" id = "received_payment_confirmation" tabindex="-1" role="dialog" style = "display:none">
  <div class="modal-dialog" role="document" >
    <div class="modal-content" id = "received_payment_confirmation_content" style = "width: 550px; box-shadow: 0 4px 8px rgba(0,0,0,2); margin: 0 auto;">
      <div class="modal-header" style = "border: none">
        <h3 class="modal-title" id = "paid_modalTitle"></h3>
        <button type="button" class="close" data-dismiss="modal" id = "btn_paidClose" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form>
        <div class="modal-body" style = "border: none" >
          <div style = "border: 1px solid #ccc; box-shadow: 0 4px 8px rgba(0,0,0,1); margin: 0 8px; ">
              <p></p>
            <div style = "text-align:center">
              <h5 id = "paid_title"></h5>
            </div>
          </div>
        </div>
        <div class="modal-footer" style = ' border: none'>
          <button class = "text-color button-cancel" style = "border-radius: 0;" id = "btn_paidCancel" data-dismiss="modal"><i class = "bi bi-x"></i>&nbsp; Cancel</button>
          <button  class = "text-color button" style = "border-radius: 0;" type = "button" id = "btn_confirmPayment"><i class = "bi bi-arrow-right-circle"></i>&nbsp; Continue</button>
        </div>
      </form>
    </div>
  </div>
</div>