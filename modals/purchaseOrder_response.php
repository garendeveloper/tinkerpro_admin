<style>
    #purchaseOrder_response {
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

    #purchaseOrder_response .modal-content {
        background-color: #1E1C11;
        margin: 10% auto;
        max-width: 500px;
        height: 200px;
        max-height: 100%;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    #purchaseOrder_response .modal-header {
        background-color: black;
        height: 20px;
        font-size: 11px;
        color: #FF6900;
    }

    #btn_ic_bondpaper,
    #btn_ic_thermal {
        width: 300px;
        border: 1px solid #ccc;
        margin-bottom: 20px;
        padding-bottom: 3px;
    }

    #btn_ic_bondpaper {
        border: 1px solid greenyellow;
    }

    #btn_ic_bondpaper:hover,
    #btn_ic_thermal:hover {
        background-color: #151515;
        border: 1px solid greenyellow;
    }

    #purchaseOrder_response p {
        font-size: 10px;
    }

    .image img {
        height: 160px;
        width: 160px;
        border: 1px solid #ccc;
    }

    #purchaseOrder_response #btn_cancel,
    #btn_print {
        border-radius: 3px;
        border: 1px solid #ccc;
        height: 30px;
        width: 70px;
        background-color: #1E1C11;
    }

    #purchaseOrder_response #btn_cancel:hover {
        background-color: red;
    }

    #purchaseOrder_response #btn_print:hover {
        background-color: green;
    }

    #purchaseOrder_response .action-button {
        position: absolute;
        right: 180px;
    }

    #purchaseOrder_response .firstCard button h6,
    button p {
        margin-bottom: 0;
    }

    #purchaseOrder_response p {
        font-weight: normal;
    }
    #purchaseOrder_response  .modal-footer {
        display: flex;
        justify-content: space-between;
    }
    #purchaseOrder_response .modal-footer button{
        height: 30px;
        color: white;
        font-size: 12px;
    }
</style>

<div id="purchaseOrder_response" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h6> <i class="bi bi-exclamation-triangle" style = "color: red"></i> TINKER PRO MESSAGE </h6>
            <span>
                <button id="close-modal">X</button>
            </span>
        </div>
        <div class="modal-body" style = "text-align: center; color: white; font-size: 15px;">
            <input type="hidden" id = "response_order_id" value = "0">
            <div class="po_title">

            </div>
        </div>
        <div class="modal-footer">
            <button id="po_btn_cancel" class="btn btn-danger">Cancel</button>
            <button id="po_btn_continue" class="btn btn-success">Continue</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#purchaseOrder_response #close-modal, #po_btn_cancel").on("click", function () {
            $("#purchaseOrder_response").hide();
        })
       
    });
</script>