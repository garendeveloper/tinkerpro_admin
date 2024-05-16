<div class="modal" id="modifiedMessageModal" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);z-index:2500">
  <div class="modal-dialog modal-dialog-centered modal-xl" style="max-width: 100%;">
    <div class="modal-content" style="opacity: 0.8 !important">
      <div class="modal-body" style="background: #000; color: #ffff; border-radius: 0;">
        <input type="text" id="triggerF">
        <div class="col-lg-12 d-flex align-items-center justify-content-center">
          <h4 class="text-center" style="font-weight: bold" id="modalTitle"></h4>
          <input type="number" hidden class="form-control shadow-none" id="productId" name="product_id" required autofocus>
          <button class="d-none" id="delProduct" name="btnSbtDelete"></button>
        </div>
        
        <div class="row mt-lg-4 justify-content-center">
          <div class="col-lg-12 d-flex align-items-center justify-content-center" style="width: 30%">
            <p class="lead text-end mb-0" id="yesBtn"></p>
            <p class="lead text-start mb-0"></p>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>