


<style>

    .relogin-content {
        height: auto;
        border: 1px solid transparent;
    }

    .continueLogin {
        background: var(--primary-color) !important;
        border: 1px solid transparent;
        box-shadow: none;
        outline: none;
    }

    #reloginModal .modal-content {
        width: 23vw;
    }

    #reloginModal .modal-body {
        width: 23vw;
    }

</style>






<div class="modal" id="reloginModal" tabindex="-1" role="dialog" style="background-color: rgba(0, 0, 0, 0.7)">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-body">
            <div class="relogin-content w-100 text-center">
                <input type="number" hidden id="update_id" style="color: black">
                <div class=" d-flex justify-content-center text-center w-100">
                    <h2>Oops!!!</h2>
                </div>
                <h4>All data has been reset recently</h4>

                <div class="gif-container mt-2 d-flex w-100 justify-content-center align-items-center">
                    <img style="max-width: 100%; max-height: 100%;" src="./assets/img/gear.gif" alt="">
                </div>

                <div class="relogin-button">
                    <h5 style="font-size: x-large">Re-login Required</h5>
                    <button class="btn btn-secondary continueLogin" >CONTINUE</button>
                </div>

            </div>
        </div>  
    </div>
  </div>
</div>


<script>

    $(document).ready(function() {

        $('.continueLogin').off('click').on('click', function() {
            var stat_id = $('#update_id').val();

            $.ajax({
                url: 'api.php?action=updateReset',
                type: 'GET',
                data: {
                    test_stat: 0,
                    stat_id: 2,
                },
                success: function(response) {
                    console.log(response);
                    $('#reloginModal').hide();
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        })

    })


</script>