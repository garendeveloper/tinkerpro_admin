<style>
    .priceListModal {
        display: none;
        position: fixed;
        z-index: 99;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    #priceListModal .modal-content {
        background-color: #333333;
        margin: 15% auto;
        max-width: 430px;
        height: 200px;
        max-height: 100%;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    @media screen and (max-width: 768px) {
        #priceListModal .modal-content {
            margin: 30% auto;
        }
    }

    #priceListModal .modal-header {
        background-color: black;
        height: 20px;
        font-size: 11px;
        color: #FF6900;
    }

    #priceListModal .modal-header,
    .modal-body {
        border: none;
    }

    /* #priceListModal .modal-body {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-gap: 15px;
        position: relative;
    } */

    #priceListModal p {
        font-size: 10px;
    }

    .image img {
        height: 160px;
        width: 160px;
        border: 1px solid #ccc;
    }

    #priceListModal #btn_cancel,
    #btn_print {
        border-radius: 3px;
        border: 1px solid #ccc;
        height: 30px;
        width: 70px;
        background-color: #333333;
    }

    #priceListModal #btn_cancel:hover {
        background-color: red;
    }

    #priceListModal #btn_print:hover {
        background-color: green;
    }

    #priceListModal .action-button {
        position: absolute;
        right: 180px;
    }

    #priceListModal .firstCard button h6,
    button p {
        margin-bottom: 0;
    }

    #priceListModal p {
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
  height: 50px;
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


.myModalBody, .myContent {
  background: #333333;
  border-radius: 10px;
}

.my-content label{
  font-size: 14px;
}


.promotionList {
  border: 1px solid var(--border-color); 
  padding: 8px; 
  border-radius: 5px;
}

#tbl_bundled tbody td{
  border: 1px solid #333333;
  color: white;
  line-height: 0.5;
  height: 5px;
  padding: 2px 2px;
}

td[contenteditable="true"]:focus {
      outline: none; 
  }
.editable {
    background-color: #f9f9f9;
    cursor: pointer;
}
.editing {
    background-color: #262626;
}
</style>

<div id="priceListModal" class="modal">
    <div class="modal-content">
        <div class="modal-header" style = "background-color: #1E1C11;padding: 20px; ">
            <h6 style = "color: var(--primary-color); font-weight: bold; margin-left: -10px;" class = "product_name">Add Price List</h6>
            <span id="close-modal">
              <i class="bi bi-x" aria-hidden="true" style = "font-size: 30px; font-weight: bold"></i>
            </span>
        </div>
        <form class = "promotionForm">
          <input type="hidden" name = "product_id" class = "product_id">
          <div class="modal-body" style = "padding: 10px;">
            <div class="row">
              <div class="col-md-12">
                  <label class = "tinker_label" for=""  style = "margin-right: 90px;">PRICE LIST NAME</label>
                  <input  type="number" name = "qty" id = "qty" class = "inputAmount appQty"  autocomplete="off">
              </div>
              <div class="col-md-12" >
                  <label class = "tinker_label" for="" style = "margin-right: 70px;">PRICE ADJUSTMENT</label>
                  <div class="custom-select" style="margin-right: 0px; ">
                      <select name="supplier" id = "supplier"
                          style=" background-color: #262626; color: #ffff; width:80px; font-size: 14px; height: 30px;">
                          <option value="1">%</option>
                          <option value="2">Amt</option>
                      </select>
                      <i class="bi bi-menu-up"></i>
                  </div>
                  <input type="text" name = "newprice" id = "newprice" class = "inputAmount"   autocomplete="off" style=" background-color: #262626; color: #ffff; width:100px; font-size: 14px; height: 30px;"/>  
              </div>
            </div>
            <div class="row">
              <div class="col-md-12" style = "padding: 10px; bottom: 0px;">
                  <button class = "button submitPromotion" type = "submit" style = "width: 100%; background-color: var(--primary-color); border-radius: 5px; margin-bottom:5px;">UPDATE</button>
              </div>
            </div>
        </div>
      </form>
    </div>
</div>
<script>
    $("#priceListModal #close-modal, #btn_unpaidCancel").on("click", function () {
        $("#priceListModal").hide();
    })
</script>