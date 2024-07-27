<style>
    tr:hover {
        background-color: #151515;
        cursor: pointer;
    }

    .group {
        display: inline-block;
        margin-right: 3px;
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
        transform: translateY(-50%);
    }
    #tbl_quickInventories tbody{
        font-size: 12px;
    }
    textarea {
        resize: none; 
        width: 300px;
        height: 100px;
        overflow: auto; 
    }
    textarea::placeholder {
        color: #ffff; 
        font-style: italic; 
    }
</style>
<div class="fcontainer" id="stocktransfer_div" style="display: none">
    <form id="stocktransfer_form">
        <div class="fieldContainer">
            <label>REF: </label>
            <input type="text" style= "width: 250px; height: 30px;">
            <div class="date-input-container">
                <input type="text" name="date_transfer" id="date_transfer" style = "height: 30px;" placeholder="Select date" readonly>
                <button id="btn_datetransfer" class="button" style="height: 30px;">
                    <i class="bi bi-calendar" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        <div class="fieldContainer">
            <div class="custom-select" style="margin-right: 20px; ">
                <select name="stock_from"
                    style=" background: #1E1C11; color: #ffff; width: 220px; border: 1px solid #ffff; font-size: 12px; height: 30px;">
                    <option value="">Transfer Stock From?</option>
                    <option value="">Branch 1</option>
                    <option value="">Branch 2</option>
                    <option value="">Warehouse</option>
                </select>
                <i class="bi bi-chevron-double-down"></i>
            </div>
            <div class="custom-select">
                <select name="stock_to"
                    style=" background-color: #1E1C11; color: #ffff; width: 220px; border: 1px solid #ffff; font-size: 12px; height: 30px;">
                    <option value="">Transfer Stock to?</option>
                    <option value="">Branch 1</option>
                    <option value="">Branch 2</option>
                    <option value="">Warehouse</option>
                </select>
                <i class="bi bi-chevron-double-down"></i>
            </div>
        </div>
        <div class="fieldContainer" style="margin-top: -3px;">
            <label><img src="assets/img/barcode.png" style="color: white; height: 50px; width: 40px;"></label>
            <div class="search-container">
                <input type="text" style="width: 280px;  font-size: 12px; height: 30px;"
                    class="search-input italic-placeholder" placeholder="Search Prod..." name="q_product"
                    onkeyup="$(this).removeClass('has-error')" id="q_product" autocomplete="off">
            </div>
            <button style="font-size: 12px;  height: 30px; width: 120px; border-radius: 4px;" id="btn_searchQProduct"> Add Product</button>
        </div>
    </form>
    <table  class="text-color table-border" style="margin-top: -3px;">
        <thead>
            <tr>
                <th style="background-color: #1E1C11; border: 1px solid #FF6900; color:#FF6900">ITEM DESCRIPTION</th>
                <th style="background-color: #1E1C11; border: 1px solid #FF6900; color:#FF6900">QTY</th>
                <th style="background-color: #1E1C11; border: 1px solid #FF6900; color: #FF6900">COST</th>
            </tr>
        </thead>
        <tbody style="border-collapse: collapse; border: none">

        </tbody>
    </table>
    <div style="position: absolute; bottom: 5px; padding: 10px;">
        <textarea name="stock_note" id="stock_note" cols="80" rows="5" placeholder="Note" style = "background-color: #1E1C11; color: #ffff; width: 100%;">

        </textarea>
    </div>
</div>

