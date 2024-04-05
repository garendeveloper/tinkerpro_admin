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

    #lbl_pqty{
        width: 100px; 
    }

    #p_qty {
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
      <div class="modal-body">
        <div class="form-group">
            <label for="p_qty" id = "lbl_pqty">Quantity</label>
            <input type="text" id="p_qty">
        </div>
      </div>
      <div class="modal-footer">
        <button  class = "grid-item text-color button">Save changes</button>
        <button class = "grid-item text-color button-cancel" id = "btn_pqtyCancel" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>