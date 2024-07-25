<style>
    #pointPromoModal {
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

    #pointPromoModal .modal-content {
        background-color: #333333;
        margin: 15% auto;
        max-width: 430px;
        height: 300px;
        max-height: 100%;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    @media screen and (max-width: 768px) {
        #pointPromoModal .modal-content {
            margin: 30% auto;
        }
    }

    #pointPromoModal .modal-header {
        background-color: black;
        height: 20px;
        font-size: 11px;
        color: #FF6900;
    }

    #pointPromoModal .modal-header,
    .modal-body {
        border: none;
    }

    /* #pointPromoModal .modal-body {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-gap: 15px;
        position: relative;
    } */

    #pointPromoModal p {
        font-size: 10px;
    }

    .image img {
        height: 160px;
        width: 160px;
        border: 1px solid #ccc;
    }

    #pointPromoModal #btn_cancel,
    #btn_print {
        border-radius: 3px;
        border: 1px solid #ccc;
        height: 30px;
        width: 70px;
        background-color: #1E1C11;
    }

    #pointPromoModal #btn_cancel:hover {
        background-color: red;
    }

    #pointPromoModal #btn_print:hover {
        background-color: green;
    }

    #pointPromoModal .action-button {
        position: absolute;
        right: 180px;
    }

    #pointPromoModal .firstCard button h6,
    button p {
        margin-bottom: 0;
    }

    #pointPromoModal p {
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

.col-md-12{
  margin-bottom: 10px;
}
</style>

<div id="pointPromoModal" class="modal">
    <div class="modal-content">
        <div class="modal-header" style = "background-color: #1E1C11;padding: 20px; ">
            <h6 style = "color: var(--primary-color); font-weight: bold; margin-left: -10px;" class = "product_name"></h6>
            <span id="close-modal">
              <i class="bi bi-x" aria-hidden="true" style = "font-size: 30px; font-weight: bold"></i>
            </span>
        </div>
        <form class = "promotionForm">
          <input type="hidden" name = "product_id" class = "product_id">
          <input type="hidden" name = "promotion_id" class = "promotion_id" value = "">
          <input type="hidden" name = "promotion_type" value = "3" class = "_promotionType">
          <div class="modal-body" style = "padding: 10px;">
            <div class="row">
              <div class="col-md-12">
                  <label class = "tinker_label" for=""  style = "margin-right: 113px;">Apply to QTY</label>
                  <input  type="number" name = "qty" id = "qty"  class = "inputAmount appQty"   autocomplete="off">
              </div>
              <div class="col-md-12">
                  <label class = "tinker_label" for=""  style = "margin-right: 110px;">Points to earn</label>
                  <input  type="number" name = "points" id = "points"  class = "inputAmount"  autocomplete="off">
              </div>
              <div class="col-md-12" >
                  <label class = "tinker_label" for="" style = "margin-right: 55px;">New price per piece</label>
                  <input type="text" name = "newprice" id = "newprice" class = "inputAmount"  autocomplete="off"/>  
              </div>
              <div class="col-md-12" >
                  <div class="barcode-container">
                    <label class="tinker_label" for="newbarcode" style="margin-right: 32px;">Generate New Barcode</label>
                    <div class="input-icon-wrapper">
                      <input type="text" name="newbarcode" id="newbarcode" style = "text-align: center; " class="inputAmount displayBarcode w-barcode"  autocomplete="off"/>
                      <div class="generate-button">
                        <i class="bi bi-arrow-down-circle"></i>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12" style = "margin-bottom: 10px; padding: 10px">
                  <button class = "button submitPromotion" type = "submit" style = "width: 100%; background-color: var(--primary-color); border-radius: 5px; margin-bottom:5px;">UPDATE</button>
              </div>
            </div>
         </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#pointPromoModal #close-modal, #btn_unpaidCancel").on("click", function () {
            $("#pointPromoModal").hide();
        })
        $("#pointPromoModal #qty, #pointPromoModal #newprice").on('input', function(){
            var qty = $("#pointPromoModal #qty").val();
            var newprice = $("#pointPromoModal #newprice").val();
            var total = qty * newprice;
            $("#pointPromoModal #totalPrice").val(total);
        })
    });
</script>