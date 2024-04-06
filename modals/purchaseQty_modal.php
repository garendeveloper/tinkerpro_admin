<style>
    #purchaseQty_modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 20px;
        width: 100%;
        height: 100%;
        overflow: auto;
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
    }

    .l_input{
        width: 100px; 
    }

    .p_input {
        flex: 1; 
        box-sizing: border-box;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>
<div class="modal" id = "purchaseQty_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id = "purchaseQty_content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" id = "btn_pqtyClose" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id = "prod_form">
        <div class="modal-body">
          <div class="form-group">
              <label for="p_qty" id = "lbl_pqty" class = "l_input">Quantity</label>
              <input type="text p_input" name = "p_qty" id="p_qty">
          </div>
          <div class="form-group">
              <label for="p_qty" id = "lbl_pqty" class = "l_input">Batch No.</label>
              <input type="text p_input"  name = "batch_no" id="batch_no">
          </div>
          <div class="form-group">
              <label for="p_qty" id = "lbl_pqty" class = "l_input">Serial Number.</label>
              <input type="text p_input"  name = "serial_number" id="serial_number">
          </div>
          <div class="form-group">
              <label for="p_qty" id = "lbl_pqty" class = "l_input">Price</label>
              <input type="number p_input"  pattern="\d+(\.\d{1,2})?" name = "price" id="price" >
          </div>
        </div>
        <div class="modal-footer">
          <button  class = "grid-item text-color button" type = "submit"><i class = "bi bi-save"></i>&nbsp; Add Product</button>
          <button class = "grid-item text-color button-cancel" id = "btn_pqtyCancel" data-dismiss="modal"><i class = "bi bi-x"></i>&nbsp; Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>