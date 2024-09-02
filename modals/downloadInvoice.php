

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

    .modal-body {
        color: var(--text-color);
        background: var(--background-color);
        border-radius: 5px;
    }

    .express-entry {
        border-radius: 5px;
    }

    .express-search,  .express-enter{
        border: none;
        background: var(--primary-color);
        box-shadow: none;
        outline: none;
    }

    .express-cancel {
        box-shadow: none;
        outline: none;
        border: none;
    }

    .express-search:hover, .express-enter:hover { 
        background: var(--primary-color);
        box-shadow: none;
    }
    
    .express-label {
        font-size: medium;
    }

    .product_detail_text, .empty-details {
        align-content: center;
    }

    .empty-details {
        text-align: center;
        color: gray;
        max-height: 200px;
        min-height: 200px;
    }

    .product_image {
        text-align: center;
        max-height: 200px;
    }

    .product_image img{
        max-height: 200px;
    }

    /* .express-entry {
        max-width : 28.4vw;
        min-width : 28.4vw;
    } */

</style>

<div class="modal" id = "saveToLocalStorageModal" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5)">
    <div class="modal-dialog modal-dialog-centered " style="max-width: 100%;">
        <div class="modal-content" style = "width: 650px; margin: auto;">
            <div class="modal-body" style = "border: none" >
                <div class="express-add-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 style="color: var(--primary-color)">SAVE THE TEXT FILE</h5>
                        <button class="btn btn-secondary close-receive closeModalExpress"><i style="color: var(--primary-color)" class="bi bi-x-lg"></i></button>
                    </div>

                    <div class="d-flex justify-content-center mt-2 mb-3">
                        <input type="text" id="directoryPath" class="w-100 me-2 p-2" style="border: 1px solid var(--border-color); border-radius : 5px;" placeholder="PASTE HERE THE DESIRED FOLDER PATH...">
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-secondary express-cancel me-2" style="width: 200px" >[ESC] CANCEL</button>
                        <button class="btn btn-secondary express-enter w-100" id="downloadTxt">[ENTER] SAVE AND DOWNLOAD</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

