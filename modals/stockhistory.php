<style>
 #stockhistory_modal  .modal-dialog {
  max-width: 1000px; 
  min-width: 700px; 
  
}

@media (max-width: 1000px) {
  #stockhistory_modal  .modal-dialog {
    max-width: 90vw; 
  }
}

#stockhistory_modal .modal-content {
  color: #ffff;
  background: #262625;
  border-radius: 0;
  position: relative;
  height: 500px;
  width: 1000px

}



#stockhistory_modal .close-button {
  position: absolute;
  right: 1.6em;
  top: 10px;
  background: #FF6900;
  color: #fff;
  border: none;
  width: 40px;
  height: 40px;
  line-height: 30px;
  text-align: center;
  cursor: pointer;
  margin-top: 1vh;
}

#stockhistory_modal .modal-title {
  font-family: Century Gothic;
  font-size: 1.5em;
  margin-top: 1em;
  margin-bottom: 0.5em;
  display: flex;
  align-items: center;
}

#stockhistory_modal .warning-container {
  display: flex;
  align-items: center;
}

#stockhistory_modal .warning-container svg {
  width: 35px;
  height: 35px;
  margin-right: 0.5em;
  margin-left: 1em;
  margin-top: -0.5em;
}

.warning-title {
  font-family: Century Gothic;
  font-size: large;
}


.pdf-viewer-container {
  padding-left: 2em;
  padding-right: 2em;
  width: 100%;
  height: 100%;
  padding-bottom: 4em;
 
}
@keyframes rotate {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
#stockhistory_modal .modal-title{
  margin-left: 25px;
}
.date-picker {
    padding: 8px;
    margin: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.stockhistory_form {
    display: flex;
    align-items: center;
}

.input-group {
  display: flex;
  align-items: center;
  margin-bottom: 10px; 
}

.input-group .col-form-label {
  width: 100px; 
  margin-right: 6px; 
}

.input-group .form-control {
  flex: 1; 
  background-color: #404040;
  border: 1px solid #ccc;
  color: #ffffff;
}

.input-group .btn {
  margin-left: 40px;
}
.input-group .btn {
  flex: 1;
  height: 100%; 
  width: 100%; 
  margin-right: 20px;
  background-color: #404040;
  border: 1px solid #ccc;
  color: #ffffff;
}
.input-group .btn:hover {
  background-color: #151515;
}
#stockhistory_modal .has-error{
  border: 1px solid red;
}

table, .stockhistory_form{
  font-family: Century Gothic;
}
#start_date::placeholder{
  color: white; 
  opacity: 1; 
}
#end_date::placeholder{
  color: white; 
  opacity: 1; 
}


.stockhistory_container {
    position: sticky;
    top: 0;
    z-index: 1; 
}

.stockhistory_form {
    margin-bottom: 2px;
}

.table-container {
    max-height: 80%;
    max-width: 95%;
    height: 100%;
    width: 100%;
    overflow-y: auto;
    background: #262626;
    position: absolute;
    margin: 0;
    bottom: 0;
    top: 60px;
}

/* #tbl_stocks_history {
    width: 100%;
    border-collapse: collapse;
}

#tbl_stocks_history thead {
    position: sticky;
    top: 0;
}

#tbl_stocks_history th, #tbl_stocks_history td {
    padding: 8px;
    border: 1px solid #ccc;
    text-align: center;
}

#tbl_stocks_history tbody {
    overflow-y: auto;
    max-height: 100px; 
} */

#tbl_stocks_history {
    width: 100%;
    border-collapse: collapse;
}

#tbl_stocks_history th, #tbl_stocks_history td {
    padding: 8px;
    border: 1px solid #ccc;
    text-align: center;
}

#tbl_stocks_history thead {
    position: sticky;
    top: 0; /* Stick thead to the top */
    background-color: #f8f9fa; /* Background color of thead */
    z-index: 1; /* Ensure it's above tbody */
}
</style>

<div class="modal" id="stockhistory_modal"  tabindex="0" style="background-color: rgba(0, 0, 0, 0.7); overflow: hidden; z-index:999;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <button id="close-modal"  name="close-modal" class="close-button" style="font-size: larger;">&times;</button>
      <div class="modal-title">
        <div class="warning-container">
          <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 47.5 47.5" viewBox="0 0 47.5 47.5" id="Warning">
            <defs>
              <clipPath id="a">
                <path d="M0 38h38V0H0v38Z" fill="#000000" class="color000000 svgShape"></path>
              </clipPath>
            </defs>
            <g clip-path="url(#a)" transform="matrix(1.25 0 0 -1.25 0 47.5)" fill="#000000" class="color000000 svgShape">
              <path fill="#b50604" d="M0 0c-1.842 0-2.654 1.338-1.806 2.973l15.609 30.055c.848 1.635 2.238 1.635 3.087 0L32.499 2.973C33.349 1.338 32.536 0 30.693 0H0Z" transform="translate(3.653 2)" class="colorffcc4d svgShape"></path>
              <path fill="#131212" d="M0 0c0 1.302.961 2.108 2.232 2.108 1.241 0 2.233-.837 2.233-2.108v-11.938c0-1.271-.992-2.108-2.233-2.108-1.271 0-2.232.807-2.232 2.108V0Zm-.187-18.293a2.422 2.422 0 0 0 2.419 2.418 2.422 2.422 0 0 0 2.419-2.418 2.422 2.422 0 0 0-2.419-2.419 2.422 2.422 0 0 0-2.419 2.419" transform="translate(16.769 26.34)" class="color231f20 svgShape"></path>
            </g>
          </svg>
        </div>
      </div>
      <div hidden id="loadingImage" style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 800px; position: absolute; top: 0; left: 0; width: 100%; background: rgba(255,255,255,0.8); z-index: 9999;">
          <h3 style="color: #FF6900"><b></b>LOADING PLEASE WAIT</b></h3><br>
          <img src="assets/img/globe.png" alt="Globe Image" style="width:75px; height: 75px; animation: rotate 2s linear infinite;" />
      </div>
     <div class="modal-body" >
        <div class="stockhistory_container">
          <div class="stockhistory_form">
            <input type="hidden" id = "inventory_id">
              <div class="input-group">
                <input type="text" id="start_date" oninput="$(this).removeClass('has-error')" class="form-control date-picker" placeholder="From: " readonly>
                <input type="text" id="end_date" oninput="$(this).removeClass('has-error')" class="form-control date-picker" placeholder = "To: " readonly>
              </div>
              <div class="input-group">
               
              </div>
              <div class="input-group">
                  <button id="btn_refreshStock" class="btn btn-secondary"><i class="bi bi-arrow-right" ></i></button>
                  <button id="btn_printStockHistory" class="btn btn-secondary"><i class="bi bi-printer"></i></button>
                  <button id="btn_refreshStockHistory" class="btn btn-secondary"><i class="bi bi-arrow-clockwise"></i></button>
              </div>
          </div>
        </div>
        <div class="table-container">
          <table id = "tbl_stocks_history">
            <thead>
                <tr>
                  <th>Document Type</th>
                  <th>Document</th>
                  <th>User</th>
                  <th>Date</th>
                  <th>Stock Date</th>
                  <th>Quantity</th>
                  <th>In Stock</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
        </div>
        
     </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
    $('#stockhistory_modal #close-modal').on('click', function() {
        $('#stockhistory_modal').hide();
    });

    $("#stockhistory_modal #start_date").flatpickr({
        dateFormat: "d M Y",
        onClose: function(selectedDates) {
            if(selectedDates[0] !== undefined) {
                $("#stockhistory_modal #end_date").flatpickr().destroy();
                $("#stockhistory_modal #end_date").flatpickr({
                    minDate: selectedDates[0],
                    dateFormat: "d M Y",
                });
            }
        }
    });

   
    $("#stockhistory_modal #end_date").flatpickr({
      dateFormat: "d M Y",
    });
    $("#btn_refreshStock").on("click", function(){
      var start_date = $("#stockhistory_modal #start_date").val();
      var end_date = $("#stockhistory_modal #end_date").val();
      var id = $("#stockhistory_modal #inventory_id").val();
      
      if(start_date !== "" && end_date !== "" )
      {
        $("#stockhistory_modal #start_date").removeClass('has-error');
        $("#stockhistory_modal #end_date").removeClass('has-error');
        $.ajax({
          type: 'get',
          url: 'api.php?action=get_allStocksDataByDate',
          data: { 
            inventory_id: id, 
            start_date: start_date,
            end_date: end_date
          },
          success: function (data) {
            var stocks = data.stocks;
            var inventoryInfo = data.inventoryInfo;
            var tbl_rows = [];
            if(stocks.length > 0)
            {
              for (var i = 0, len = stocks.length; i < len; i++) 
              {
                var stockItem = stocks[i];
                var stockDate = $.datepicker.formatDate("dd M yy", new Date(stockItem.stock_date));
                var stockTimestamp = stockItem.stock_date;
                var stock = stockItem.stock > 0 ? "<span style = 'color: green'>+" + stockItem.stock + "</span>" : "<span style = 'color: red'>" + stockItem.stock + "</span>";
                var new_stock = inventoryInfo.product_stock > 0 ? "<span style = 'color: #90EE90'>" + inventoryInfo.product_stock + "</span>" : "<span style = 'color: #FFCCCC'>" + inventoryInfo.product_stock + "</span>";
                tbl_rows.push(
                  `<tr>
                    <td style = 'text-align: center;  font-size: 12px; font-weight: bold'>${stockItem.transaction_type}</td>
                    <td style = 'text-align: center;  font-size: 12px; font-weight: bold'>${stockItem.document_number}</td>
                    <td style = 'text-align: center;  font-size: 12px; font-weight: bold'>${stockItem.stock_customer}</td>
                    <td style = 'text-align: center;  font-size: 12px; font-weight: bold'>${stockDate}</td>
                    <td style = 'text-align: center;  font-size: 12px; font-weight: bold'>${stockTimestamp}</td>
                    <td style = 'text-align: center;  font-size: 12px; font-weight: bold'>${stockItem.stock_qty}</td>
                    <td style = 'text-align: center; font-size: 12px; font-weight: bold'>${stock}</td>
                </tr>`
                );
              }
              var tfoot = `<tr>
                    <td style = 'text-align: center;  font-size: 12px; font-weight: bold' colspan ='6'>Remaining Stock</td>
                    <td style = 'text-align: center; font-size: 12px; font-weight: bold; color: #ccc' >${new_stock}</td>
                </tr>`;

              $("#tbl_stocks_history tbody").html(tbl_rows);
              $("#tbl_stocks_history tfoot").html(tfoot);
            }
            else
            {
              var tfoot = `<tr>
                    <td style = 'text-align: center;  font-size: 12px; font-weight: bold' colspan ='7'>No available data found.</td>
                </tr>`;
                $("#tbl_stocks_history tbody").html(tfoot);
                $("#tbl_stocks_history tfoot").html("");
            }
          }
        })
      }
      else
      {
        $("#stockhistory_modal #start_date").addClass('has-error');
        $("#stockhistory_modal #end_date").addClass('has-error');
      }
    })
    $("#btn_printStockHistory").click(function(){

        $('#show_stockhistoryPrintModal').show()
        var start_date = $("#stockhistory_modal #start_date").val();
        var end_date = $("#stockhistory_modal #end_date").val();
        var id = $("#stockhistory_modal #inventory_id").val();
        if($('#show_stockhistoryPrintModal').is(":visible"))
        {
          var loadingImage = document.getElementById("loadingImage1");
          loadingImage.removeAttribute("hidden");
          var pdfFile= document.getElementById("pdfFile1");
          pdfFile.setAttribute('hidden',true);
          $.ajax({
              url: './toprint/stockhistory.php',
              type: 'GET',
              xhrFields: {
                  responseType: 'blob'
              },
              data: {
                  start_date: start_date,
                  end_date: end_date,
                  product_id: id
              },
              success: function(response) 
              {
                loadingImage.setAttribute("hidden",true);
                var pdfFile = document.getElementById("pdfFile1");
                pdfFile.removeAttribute('hidden')
                if( loadingImage.hasAttribute('hidden')) 
                {
                    var newBlob = new Blob([response], { type: 'application/pdf' });
                    var blobURL = URL.createObjectURL(newBlob);
                    $('#pdfViewer1').attr('src', blobURL);
                }
              },
              error: function(xhr, status, error) {
                  console.error(xhr.responseText);
              }
          });
        }
    })
});
 
</script>
