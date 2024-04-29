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
        width: 80%;
        max-width: 800px;
        height: 50%;
        max-height: 100%;
        /* Set maximum height */
        overflow-y: auto;
        /* Enable vertical scrolling */
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        text-align: center;
    }

    #printcount_modal .modal-header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        padding: 10px;
        z-index: 1000;
    }

    #printcount_modal .modal-header.fixed-top {
        margin: 0;
    }

    #printcount_modal .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    #printcount_modal .close:hover,
    #printcount_modal .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    #printcount_modal .modal-content img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    #printcount_modal .close-button {
        display: block;
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #FF6900;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    #printcount_modal .close-button:hover {
        background-color: #FF6900;
    }

    @media screen and (max-width: 768px) {
        #printcount_modal .modal-content {
            margin: 30% auto;
        }
    }

    /* Adjustments for grid container and items */
    #printcount_modal .grid-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3px;
        padding: 20px;
        margin-top: 60px;
    }

    #printcount_modal .grid-item {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        border: none;
        height: 150px;
    }

    #printcount_modal .grid-item img {
        max-width: 100%;
        height: auto;
    }

    /* Adjustments for button and text inside grid item */
    #printcount_modal .grid-item button {
        padding: 5px 10px;
        border: 1px solid #ffff;
        color: white;
        border: none;
        border-radius: 5px;
        width: 500px;
        height: 60px;
        cursor: pointer;
        margin-bottom: 10px;
    }

    #printcount_modal .grid-item h5 {
        margin-bottom: 5px;
        c
    }

    #printcount_modal .grid-item p {
        margin-bottom: 20px;
    }
    #printcount_modal .grid-item .button-container {
        display: flex;
        justify-content: center;
        gap: 20px;
        width: 60px;
        margin-top: 2px;
    }
</style>

<div id="printcount_modal" class="modal">
    <div class="modal-content">
        <div
            style=" margin: 0; left: 2px auto; right: 2px auto; top: 0; display: flex; justify-content: space-between; align-items: center; color: #FF6900; background-color: #151515; width: 100%;">
            <h5>Print Count Sheet</h5>
            <span class="close">&times;</span>
        </div>
        <div class="grid-container">
            <div class="grid-item">
                <button>
                    <h5>Print on Bond Paper Size</h5>
                    <p>A4, Letter, Legal</p>
                </button>
                <button>
                    <h5>Print on Thermal Paper Size</h5>
                    <p>58mm, 80mm</p>
                </button>
                
            </div>
            <div class="grid-item">
                <img src="assets/img/bond-papersize.png" alt="Responsive Image">
            </div>
            <div class="grid-item">
            <div class="button-container">
                    <button>Close</button>
                    <button>Print</button>
                </div>
            </div>
        </div>
      
    </div>
</div>