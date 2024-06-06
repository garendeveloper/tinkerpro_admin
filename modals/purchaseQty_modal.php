<style>
    #purchaseQty_modal {
        display: flex;
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        justify-content: center;
        align-items: center;
        background-color: rgba(0, 0, 0, 0.4);
    }

    #purchaseQty_content {
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
    .modal-footer button{
      height: 40px; 
      width: 200px;
    }
    #purchaseQty_modal #btn_pqtyClose:hover{
      color: #ffffffff;
    }
    .modal{
      font-family: Century Gothic;
    }
    input{
      height: 30px;
    }
</style>
<div class="modal" id = "purchaseQty_modal" tabindex="-1" role="dialog" style = "display:none">
  <div class="modal-dialog" role="document" >
    <div class="modal-content" id = "purchaseQty_content" style = "width: 550px; box-shadow: 0 4px 8px rgba(0,0,0,2); margin: 0 auto;">
      <div class="modal-header" style = "border: none">
        <h3 class="modal-title" id = "pqty_modalTitle"></h3>
        <button type="button" class="close" data-dismiss="modal" id = "btn_pqtyClose" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id = "prod_form">
        <input type="hidden" id = "pqty_inventoryId" value = "0">
        <input type="hidden" id = "item_verifier" value = "0">
        <div class="modal-body" style = "border: none" >
          <div style = "border: 1px solid #ccc; box-shadow: 0 4px 8px rgba(0,0,0,1); margin: 0 8px; ">
              <p></p>
            <div style = "text-align:center">
              <h5>Enter <b style = 'color: #FF6900'>QUANTITY</b> and supplier <b style = 'color: #FF6900'>RATE</b></h5>
              <h5 id = "product_name"></h5>
            </div>
            <div class="fieldContainer" style = "display:flex; margin-bottom: 2px;">
                <div class="form-group" >
                    <label for="p_qty" id="lbl_pqty" class="l_input" style="color: #FF6900;"><strong>QTY:</strong></label>
                    <input type="text" class="p_input" name="p_qty" id="p_qty" onkeyup="$(this).removeClass('has-error')" autocomplete="off" style = "text-align: right">
                </div>
                <div class="form-group" >
                    <label for="price" id="lbl_price" class="l_input" style="color: #FF6900; "><strong>RATE:</strong></label>
                    <input type="text" class="p_input" pattern="\d+(\.\d{1,2})?" name="price" id="price" oninput="$(this).removeClass('has-error')" autocomplete="off" style = "text-align: right">
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer" style = 'border: none'>
          <button class = "text-color button-cancel" style = "border-radius: 0; " id = "btn_pqtyCancel" data-dismiss="modal"><i class = "bi bi-x"></i>&nbsp; Cancel</button>
          <button  class = "text-color button" style = "border-radius: 0;" type = "submit"><i class = "bi bi-arrow-right-circle"></i>&nbsp; Continue</button>
        </div>
      </form>
    </div>
  </div>
</div>