
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
      height: 30px; 
      width: 100px;
      font-size: 14px;
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
    strong{
      color: var(--primary-color);
    }
    .titleText{
      font-size: 18px;
    }
    .textCode{
      color: white;
      font-size: 18px;
    }

    #purchaseQty_modal .modal-header {
        border: none;
        background: #262626;
        height: 45px;
        padding: 8px 8px;
        color: white;
        font-size: 16px;
        font-weight: bold;
    }
    #purchaseQty_modal  .modal-title {
        color: #fff;
        display: flex;
        align-items: center;
    }
    #purchaseQty_modal .modal-title i {
        color: red;
        margin-right: 5px; /* Adjust spacing between icon and text */
    }
    #purchaseQty_modal .close-button {
        height: 20px;
        font-size: 30px;
        font-weight: bold;
        color: #fff;
        background: transparent;
        border: none;
    }
    #purchaseQty_modal input{
      height: 30px;
      font-size: 18px;
    }
    #purchaseQty_modal label{
      font-size: 18px;
    }

</style>
<div class="modal" id="purchaseQty_modal" tabindex="0" style="background-color: rgba(0, 0, 0, 0.5); display: none">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 30vw; ">
    <div class="modal-content" style = "background: #262626;">
      <div class="modal-header">
          <h6 style = "font-size: 18px; font-weight: bold"> <i class="bi bi-exclamation-triangle" style = "color: red; font-size: 18px; font-weight: bold"></i> ATTENTION REQUIRED</h6>
          <span >
              <button id = "btn_pqtyClose" type = "button">x</button>
          </span>
      </div>
      <form id = "prod_form">
        <input type="hidden" id = "pqty_inventoryId" value = "0">
        <input type="hidden" id = "item_verifier" value = "0">
        <div class="modal-body" style="background: #262626; color: #ffff; border-radius: 0; border: 1px solid #333333; margin-right: 20px; margin-left: 20px;">
          <div class="row">
            <div class="col-6 itemInfo">
              <div class="row" style = "margin-bottom: 20px;">
                <label class = "titleText ">ITEM: <span class="product_name" style = 'color: var(--primary-color); font-weight:bold'></span></label>
                <label class = "titleText ">Barcode: <span class=" barcode_val" style = 'color: var(--primary-color); font-weight:bold'></span></label>
              </div>
             <div class="row">
              <label>Quantity: <input type="text" class=" pqty" name="p_qty" id="p_qty" onkeyup="$(this).removeClass('has-error')" autocomplete="off" style = "text-align: right" autofocus="autofocus "></label>
              <label>Cost: <input type="text" class="" pattern="\d+(\.\d{1,2})?" name="price" id="price" oninput="$(this).removeClass('has-error')" autocomplete="off" style = "text-align: right"></label>
             </div>
            </div>

            <div class="col-6 itemImage" style = "border: 1px solid #262626">
                <img src="" alt="productImage" class = "productImage">
            </div>
          </div>

          <!-- <div class="d-flex" style="margin-top: 10px">
            <button class="btn btn-secondary primary_button_style search_cancel" id = "btn_pqtyCancel"><span>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
              </svg>
              </span>CANCEL</button>
            <button class="btn btn-secondary primary_button_style addToCart" tabindex="0" type = "submit"><span>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
              <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
            </span>CONTINUE</button>
          </div> -->
        </div>
        <div class="modal-footer justify-content-between" style = 'border: none; background: #262626; color: #ffff; '>
          <button class = "text-color button-cancel" style = "border-radius: 0; " id = "btn_pqtyCancel" data-dismiss="modal"><i class = "bi bi-x"></i>&nbsp; Cancel</button>
          <button  class = "text-color button" style = "border-radius: 0;" type = "submit"><i class = "bi bi-arrow-right-circle"></i>&nbsp; Continue</button>
        </div>
      </form>
    </div>
  </div>
</div>


