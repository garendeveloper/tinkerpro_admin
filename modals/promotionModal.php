<style>
    #promotionModal {
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

    #promotionModal .modal-content {
        background-color: #1E1C11;
        margin: 10% auto;
        max-width: 400px;
        height: 520px;
        max-height: 100%;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    @media screen and (max-width: 768px) {
        #promotionModal .modal-content {
            margin: 30% auto;
        }
    }

    #promotionModal .modal-header {
        background-color: black;
        height: 20px;
        font-size: 11px;
        color: #FF6900;
    }

    #promotionModal .modal-header,
    .modal-body {
        border: none;
    }

    /* #promotionModal .modal-body {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-gap: 15px;
        position: relative;
    } */

    #promotionModal p {
        font-size: 10px;
    }

    .image img {
        height: 160px;
        width: 160px;
        border: 1px solid #ccc;
    }

    #promotionModal #btn_cancel,
    #btn_print {
        border-radius: 3px;
        border: 1px solid #ccc;
        height: 30px;
        width: 70px;
        background-color: #1E1C11;
    }

    #promotionModal #btn_cancel:hover {
        background-color: red;
    }

    #promotionModal #btn_print:hover {
        background-color: green;
    }

    #promotionModal .action-button {
        position: absolute;
        right: 180px;
    }

    #promotionModal .firstCard button h6,
    button p {
        margin-bottom: 0;
    }

    #promotionModal p {
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
#promotionForm input{
  border: 1px solid #ccc;
  height: 25px;
}
.col-md-12{
  margin-bottom: 10px;
}
</style>

<div id="promotionModal" class="modal">
    <div class="modal-content">
        <div class="modal-header" style = "background-color: #1E1C11;padding: 20px; ">
            <h6 style = "color: var(--primary-color); font-weight: bold; margin-left: -10px;" id = "product_name"></h6>
            <span>
                <button id="close-modal">X</button>
            </span>
        </div>
        <form id = "promotionForm">
          <div class="modal-body" style = "padding: 10px;">
            <div class="row">
              <div class="col-md-12">
                  <label class = "tinker_label" for=""  style = "margin-right: 80px;">Apply to QTY</label>
                  <input  type="number" name = "qty" id = "qty" autocomplete="off">
              </div>
              <div class="col-md-12" >
                  <label class = "tinker_label" for="" style = "margin-right: 10px;">New price per bundle</label>
                  <input type="text" name = "newprice" id = "newprice" class = "inputAmount" autocomplete="off"/>  
              </div>
            </div>
            <div class = "row" style = "padding: 10px;">
              <button class = "button" style = "width: 100%; background-color: var(--primary-color); border-radius: 5px; margin-bottom:5px;">Add Bundled Product</button>
            </div>
            <div class="row" style = "padding: 10px; margin-top: -15px;">
                <table style="width: 100%; border: collapse; border: 3px solid #262626">
                    <thead>
                      <tr>
                        <th style = "background-color: #1E1C11; border: 1px solid #1E1C11">BUNDLES</th>
                        <th style = "background-color: #1E1C11; border: 1px solid #1E1C11">QTY</th>
                        <th style = "background-color: #1E1C11; border: 1px solid #1E1C11">ACTION</th>
                      </tr>
                    </thead>
                    <tbody style = "height: 120px;"></tbody>
                </table>
            </div>
            <div class="row">
              <div class="col-md-12" >
                  <label class = "tinker_label" for="">Generate New Barcode</label>
                  <input type="text" name = "newbarcode" id = "newbarcode" class = "inputAmount" autocomplete="off"/> 
              </div>
            </div>
            <div class="row">
              <div class="col-md-12" style = "margin-bottom: 10px; padding: 10px">
                  <button class = "button" style = "width: 100%; background-color: var(--primary-color); border-radius: 5px; margin-bottom:5px;">EDIT</button>
                  <button class = "button" style = "width: 100%; background-color: var(--primary-color); border-radius: 5px; margin-bottom:5px;">DELETE</button>
                  <button class = "button" style = "width: 100%; background-color: var(--primary-color); border-radius: 5px; margin-bottom:5px;">UPDATE</button>
              </div>
            </div>
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
        $("#promotionModal #close-modal, #btn_unpaidCancel").on("click", function () {
            $("#promotionModal").hide();
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