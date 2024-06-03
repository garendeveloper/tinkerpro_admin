<style>
    #stockhistory_modal {
        display: flex;
        position: fixed;
        top: 0;
        margin-top: -10px;
        left: 0;
        width: 100%;
        z-index: 9999;
        height: 100%;
        justify-content: center;
        align-items: center;
        background-color: rgba(0, 0, 0, 0.4);
    }

    #stockhistory_modal_content{
        background-color: #1E1C11;
        color: #ffff;
        border-radius: none;
        border: 1px solid #ccc;
    }
    #stockhistory_modal .modal-header{
        height: 20px;
        top: 0;
        background-color: black
        
    }
    #stockhistory_modal table{
        margin-top: 4px;
    }
</style>
<div class="modal" id = "stockhistory_modal" tabindex="-1" role="dialog" style = "display:none">
  <div class="modal-dialog" role="document" >
    <div class="modal-content" id = "stockhistory_modal_content" style = "width: 550px; box-shadow: 0 4px 8px rgba(0,0,0,2); margin: 0 auto;">
      <div class="modal-header" style = "border: none">
        <h6 class="modal-title"></h6>
        <span class="close" data-dismiss="modal" id = "close-modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </span>
      </div>
      <div class = "modal-body">
        <table id = "tbl_stocks_history">
            <thead>
                <tr>
                    <th style = 'text-align:center;'>Document Type</th>
                    <th style = 'text-align:center'>Document </th>
                    <th style = 'text-align:center'>Customer</th>
                    <th style = 'text-align:center'>Transaction Date</th>
                    <th style = 'text-align:center'>Quantity</th>
                    <th style = 'text-align:center'>In Stock</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
    $("#stockhistory_modal #close-modal").on("click", function(){
        $("#stockhistory_modal").hide();
    })
</script>