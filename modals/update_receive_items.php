<style>

    .close-receive {
        background: none;
        box-shadow: none;
        border: none;
    }

    .close-receive i{
        font-size: medium;
    }

    .close-receive:hover {
        background: none;
        box-shadow: none;
    }


</style>

<div class="modal" id = "update_received" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5)">
    <div class="modal-dialog modal-dialog-centered " style="max-width: 100%;">
        <div class="modal-content" id = "purchaseQty_content" style = "width: 850px; box-shadow: 0 4px 8px rgba(0,0,0,2); margin: auto;">
           
            <div class="modal-body" style = "border: none" >
                <div class="received-items-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5><i class="bi bi-pencil-square"></i>
                        Edit Received Quantity</h5>
                        <button class="btn btn-secondary close-receive closeModalRec"><i class="bi bi-x-lg"></i> </button>
                    </div>

                    <table class="w-100 received_items">
                        <thead>
                            <tr>
                                <th class="text-center">ID No.</th>
                                <th class="text-center">ITEM/DESCRIPTION</th>
                                <th class="text-center">Date Expiring</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Update Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                          
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between mt-2">
                        <label for="">QTY ON HAND: <span id="totalOnHand">0.00</span></label>
                        <label for="">UPDATE QTY: <span id="UpdateQty">0.00</span></label>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mt-2">
                        <button class="btn btn-secondary close-receive quick_cancel"><i class="bi bi-x-lg"></i> Cancel </button>
                        <button class="btn btn-secondary close-receive quick_save"><i class="bi bi-x-lg"></i> Update </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>

    var data_to_update = [];
    function updateTotalQty() {
        var totalQty = 0;
        $('.received_items_row').each(function() {
            totalQty += parseFloat($(this).find('.update_qty_inputs').val()) || 0;
            var totalOnHand = $('#totalOnHand').text();
            var inputs_qty = $(this).find('.update_qty_inputs').val();
            var ids = $(this).data('receiveid');
            var product_id = $(this).data('prodid');

            var existingItem = data_to_update.find(item => item.ids === ids);
            if (existingItem) {
                existingItem.inputs_qty = inputs_qty;
            } else {
                data_to_update.push({
                    inputs_qty: inputs_qty,
                    ids: ids,
                    product_id: product_id,
                    totalQty : totalQty,
                    totalOnHand : totalOnHand,
                });
            }
        });

        $('#UpdateQty').text(totalQty);
    }

    $(document).on('input', '.update_qty_inputs', function() {
        updateTotalQty();
    });

    $('.quick_save').off('click').on('click', function() {
        axios.post('api.php?action=save_quickInventory1', {
            'data_to_update' : data_to_update,
        })
        .then(function(res) {
            console.log(res.data);
        })
        .catch(function(error) {
            console.log(error)
        })
    })

    $('.quick_cancel, .closeModalRec').off('click').on('click', function() {
        $('#update_received').hide();
    })

    
</script>