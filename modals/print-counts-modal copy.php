<style>
    #printcount_modal {
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

    #printcount_modal .modal-content {
        background-color: #1E1C11;
        margin: 15% auto;
        max-width: 800px;
        height: 50%;
        max-height: 100%;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        text-align: center;
    }



    @media screen and (max-width: 768px) {
        #printcount_modal .modal-content {
            margin: 30% auto;
        }
    }

    .print-count-sheet-container {
        background-color: #1E1C11;
        color: #ffff;
        padding: 24px;
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .print-details {
        flex: 1;
    }

    .title {
        font-size: 1.25rem;
        font-weight: bold;
        margin-bottom: 1rem;
        margin-top: 0;
        text-align: left;
    }

    .details {
        margin-bottom: 1rem;
    }

    .paper-size {
        padding: 10px;
        background-color: #1E1C11;
        border: 1px solid #cccc;
        margin-bottom: 1rem;
        height: 80px;
        width: 500px;
    }

    .thermal {
        border: 2px solid #2ecc71;
    }

    .button-group {
        display: flex;
        width: 500px;
    }
    .paper-size:hover{
        background-color: #151515;
    }

    .cancel-button,
    .print-button {
        background-color: #e74c3c;
        color: #ffffff;
        font-weight: bold;
        padding: 8px 10px;
        cursor: pointer;
    }

    .print-button {
        background-color: #2ecc71;
    }

    .image img {
        width: 200px;
        height: 250px;
        object-fit: cover;
        border: 1px solid #ccc;
    }
    .font-semibold{
        font-size: 15px;
    }
</style>

<div id="printcount_modal" class="modal">
    <div class="modal-content">
        <div style = "justify-content: space-between">
            <h2 class="title">Print Count Sheet</h2>
            <span class="close">&times;</span>
        </div>
        <div class="print-count-sheet-container">
            
            <div class="print-details">
                
                <div class="details">
                    <button id = "btn_ic_bondpaper" class="paper-size">
                        <p class="font-semibold">Print on Bond Paper Size</p>
                        <p>A4, Letter, Legal</p>
                    </button>
                    <button id="btn_ic_thermal" class="paper-size thermal">
                        <p class="font-semibold">Print on Thermal Paper Size</p>
                        <p>58mm, 80mm</p>
                    </button>
                    <div class="button-group">
                        <button class="cancel-button">Cancel</button>
                        <button class="print-button">Print</button>
                    </div>
                </div>
            </div>
            <div class="image">
                <img src="assets/img/bond-papersize.png" id = "ic_img_preview" alt="Thermal Paper Rolls">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#btn_ic_bondpaper").on("click", function () {
            $("#ic_img_preview").attr("src", "assets/img/bond-papersize.png");
            $("#btn_ic_thermal").css('border', '1px solid #ccc');
            $(this).css('border', '1px solid greenyellow');
        })
        $("#btn_ic_thermal").on("click", function () {
            $("#ic_img_preview").attr("src", "assets/img/thermal-paper.png");
            $("#btn_ic_bondpaper").css('border', '1px solid #ccc');
            $(this).css('border', '1px solid greenyellow');
        })
    })
</script>