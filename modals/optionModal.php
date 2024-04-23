<style>
#optionModal {
    display: none;
    position: fixed;
    z-index: 9999;
    top: 0;
    bottom: 0;
    left: calc(100% - 400px);
    width: 400px;
    background-color: transparent;
    overflow: hidden;
    height: 100%;
    animation: slideInRight 0.5s;
}

.optionmodal-content {
    background-color: #1E1C11;
    margin: 0 auto;
    border: none;
    width: 100%;
    height: 1000px;
    animation: slideInRight 0.5s;
    border-radius: 0;
    margin-top: -28px;
    border-color: #1E1C11;

}

@keyframes slideInRight {
    from {
        margin-right: -100%;
        opacity: 0;
    }

    to {
        margin-right: 0;
        opacity: 1;
    }
}

.text-custom {
    color: #fefefe;
    font-family: Century Gothic;
    font-weight: bold;
}

.tableCard {
    border-radius: 0;
    width: 100%;
    max-width: 500px;
    height: fit-content;
    margin-top: 15px;
    margin-bottom: 15px;

}



@media (max-width: 768px) {
    .modal {
        left: 0;
        width: 100%;
        max-width: 100%;
    }

    /* #FF6900; */
    .tableCard {
        height: auto;
        max-height: none;
    }
}

.td-height {
    font-size: 12px;
    padding: 0;
    margin: 0;
    height: auto;
}

.td-style {
    font-style: italic;
    padding: 5px;
}

.td-bg {
    background-color: #404040;
}

.td-height input {
    /* border: 1px solid #000; */
    margin: 0;
    padding: 2px;
    width: 100%;
    /* box-sizing: border-box;  */
    position: relative;
    height: 20px;
    margin-left: 4px;
}

.imageCard {
    /* border: 2px solid #4B413E; 
    box-sizing: border-box;  */
    border-radius: 0;
    min-width: 500px;
    width: 100%;
    max-width: 500px;
    height: 205px;
    min-height: 30%;
    max-height: 250px;
    display: flex;
    margin-top: 10px;
}

.imageProduct {
    border: 1px solid #ffff;
    box-sizing: border-box;
    border-radius: 0;
    margin-right: 20px;
    margin-left: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 150px;
}

.bomCard {
    border: 1px solid #ffff;
    box-sizing: border-box;
    border-radius: 20px;
    height: 200px;
    position: absolute;
    right: 0;
    left: 190px;
    margin-right: 20px;
    border-color: #595959;
    background-color: #404040;
}

.btnCustom {
    font-size: 11px;
    font-family: Century Gothic;
    color: #FF6900;
    border-radius: 5px;
}

.imageButtonDiv {
    position: absolute;
    top: 658px;
    left: 20px
}

.removeImage {
    width: 60px
}

.addImage {
    width: 97px
}

.descripTion {
    margin-left: 20px;
    font-family: Century Gothic;
    font-weight: bold;
    position: absolute;
    top: 710px
}




input:checked+.slider {
    background-color: #00CC00;
}

input:focus+.slider {
    box-shadow: 0 0 1px #262626;
}

input:checked+.slider:before {
    -webkit-transform: translateX(20px);
    -ms-transform: translateX(20px);
    transform: translateX(20px);
}

.slider.round {
    border-radius: 10px;
}

.slider.round:before {
    border-radius: 50%;
}

.slider.active {
    background-color: #00CC00;
}

.switchOtherCharges {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
    outline: none;
}

.switchOtherCharges input {
    opacity: 0;
    width: 0;
    height: 0;
}

.sliderOtherCharges {
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

.sliderOtherCharges:before {
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

input:checked+.sliderOtherCharges {
    background-color: #FF6900;
}

input:focus+.sliderOtherCharges {
    box-shadow: 0 0 1px #262626;
}

input:checked+.sliderOtherCharges:before {
    -webkit-transform: translateX(20px);
    -ms-transform: translateX(20px);
    transform: translateX(20px);
}

.sliderOtherCharges.round {
    border-radius: 10px;
}

.sliderOtherCharges.round:before {
    border-radius: 50%;
}

.sliderOtherCharges.active {
    background-color: #FF6900;
}

.displayReceipt {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
    outline: none;
}

.displayReceipt input {
    opacity: 0;
    width: 0;
    height: 0;
}

.spanDisplayReceipt {
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

.spanDisplayReceipt:before {
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

input:checked+.spanDisplayReceipt {
    background-color: #FF6900;
}

input:focus+.spanDisplayReceipt {
    box-shadow: 0 0 1px #262626;
}

input:checked+.spanDisplayReceipt:before {
    -webkit-transform: translateX(20px);
    -ms-transform: translateX(20px);
    transform: translateX(20px);
}

.spanDisplayReceipt.round {
    border-radius: 10px;
}

.spanDisplayReceipt.round:before {
    border-radius: 50%;
}

.spanDisplayReceipt.active {
    background-color: #FF6900;
}

.serviceCharge {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
    outline: none;
}

.serviceCharge input {
    opacity: 0;
    width: 0;
    height: 0;
}

.sliderServiceCharges {
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

.sliderServiceCharges:before {
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

input:checked+.sliderServiceCharges {
    background-color: #FF6900;
}

input:focus+.sliderServiceCharges {
    box-shadow: 0 0 1px #262626;
}

input:checked+.sliderServiceCharges:before {
    -webkit-transform: translateX(20px);
    -ms-transform: translateX(20px);
    transform: translateX(20px);
}

.sliderServiceCharges.round {
    border-radius: 10px;
}

.sliderServiceCharges.round:before {
    border-radius: 50%;
}

.sliderServiceCharges.active {
    background-color: #FF6900;
}

/* new */
.displayServiceReceipt {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
    outline: none;
}

.displayServiceReceipt input {
    opacity: 0;
    width: 0;
    height: 0;
}

.spanDisplayServiceChargeReceipt {
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

.spanDisplayServiceChargeReceipt:before {
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

input:checked+.spanDisplayServiceChargeReceipt {
    background-color: #FF6900;
}

input:focus+.spanDisplayServiceChargeReceipt {
    box-shadow: 0 0 1px #262626;
}

input:checked+.spanDisplayServiceChargeReceipt:before {
    -webkit-transform: translateX(20px);
    -ms-transform: translateX(20px);
    transform: translateX(20px);
}

.spanDisplayServiceChargeReceipt.round {
    border-radius: 10px;
}

.spanDisplayServiceChargeReceipt.round:before {
    border-radius: 50%;
}

.spanDisplayServiceChargeReceipt.active {
    background-color: #FF6900;
}

/* new */
.taxVat {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
    outline: none;
}

.taxVat input {
    opacity: 0;
    width: 0;
    height: 0;
}

.taxVatSpan {
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

.taxVatSpan:before {
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

input:checked+.taxVatSpan {
    background-color: #FF6900;
}

input:focus+.taxVatSpan {
    box-shadow: 0 0 1px #262626;
}

input:checked+.taxVatSpan:before {
    -webkit-transform: translateX(20px);
    -ms-transform: translateX(20px);
    transform: translateX(20px);
}

.taxVatSpan.round {
    border-radius: 10px;
}

.taxVatSpan.round:before {
    border-radius: 50%;
}

.taxVatSpan.active {
    background-color: #FF6900;
}

/* new */
.includesTaxVat {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
    outline: none;
}

.includesTaxVat input {
    opacity: 0;
    width: 0;
    height: 0;
}

.spanTaxVat {
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

.spanTaxVat:before {
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

input:checked+.spanTaxVat {
    background-color: #FF6900;
}

input:focus+.spanTaxVat {
    box-shadow: 0 0 1px #262626;
}

input:checked+.spanTaxVat:before {
    -webkit-transform: translateX(20px);
    -ms-transform: translateX(20px);
    transform: translateX(20px);
}

.spanTaxVat.round {
    border-radius: 10px;
}

.spanTaxVat.round:before {
    border-radius: 50%;
}

.spanTaxVat.active {
    background-color: #FF6900;
}

/* new */
.showIncludesTaxVat {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
    outline: none;
}

.showIncludesTaxVat input {
    opacity: 0;
    width: 0;
    height: 0;
}

.spanShowTaxVat {
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

.spanShowTaxVat:before {
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

input:checked+.spanShowTaxVat {
    background-color: #FF6900;
}

input:focus+.spanShowTaxVat {
    box-shadow: 0 0 1px #262626;
}

input:checked+.spanShowTaxVat:before {
    -webkit-transform: translateX(20px);
    -ms-transform: translateX(20px);
    transform: translateX(20px);
}

.spanShowTaxVat.round {
    border-radius: 10px;
}

.spanShowTaxVat.round:before {
    border-radius: 50%;
}

.spanShowTaxVat.active {
    background-color: #FF6900;
}

/* new */
.discount {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
    outline: none;
}

.discount input {
    opacity: 0;
    width: 0;
    height: 0;
}

.discountSpan {
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

.discountSpan:before {
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

input:checked+.discountSpan {
    background-color: #FF6900;
}

input:focus+.discountSpan {
    box-shadow: 0 0 1px #262626;
}

input:checked+.discountSpan:before {
    -webkit-transform: translateX(20px);
    -ms-transform: translateX(20px);
    transform: translateX(20px);
}

.discountSpan.round {
    border-radius: 10px;
}

.discountSpan.round:before {
    border-radius: 50%;
}

.discountSpan.active {
    background-color: #FF6900;
}

/* new */
.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    z-index: 1;
}


.dropdown-content a {
    display: block;
    width: 100%;
    padding: 10px;
    min-width: 210px;
    border: none;
    background-color: transparent;
    color: #000000;
    text-decoration: none;
    padding-top: 0;
    padding-bottom: 0;
    margin-top: 0;
    margin-bottom: 0;
}


.dropdown-content a:hover {
    background-color: #ddd;
}

.custom-btn {
    border-radius: 25%;
    background-color: #A6A6A6;
    transition: background-color 0.3s;
}

.custom-btn:hover {
    background-color: #808080;
}

#discountType {
    text-align: right;
}

#uomDropDown {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    z-index: 1;
    top: 25px;
    left: 82px;

}

.serial::placeholder {
    font-style: italic;
    color: #503C1F;
    font-size: small;
    font-weight: bold;
}

.generate {
    color: #E46C0A;
    border-radius: 5px;
    background-color: #404040;
    border-color: #595959;
}

.generate:hover {
    background-color: #FF6900;
    color: #fefefe;
}

.btnCustom:hover {
    background-color: #FF6900;
    color: #fefefe;

}

.addCategory {
    color: #E46C0A;
    border-radius: 5px;
    background-color: #404040;
    border-color: #595959;
}

.addCategory:hover {
    background-color: #FF6900;
    color: #fefefe;
}

.grid-container {
    margin-top: -10px;
    margin-left: 10px;
    margin-right: 10px;
    margin-bottom: 10px;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-gap: 7px;
    /* Adjust the gap between grid items as needed */
}

.grid-item {
    padding: 6px 10px;
    margin-bottom: -3px;
    border: 1px solid #4B413E;
    border-radius: 10px;
    color: #fff;
    font-size: 12px;
    cursor: pointer;
    outline: none;
}

.fieldContainer {
    margin-top: 8px;
    margin-left: 10px;
    margin-right: 10px;
    color: white;
}

.flex-container {
    display: flex;
}

.flex-item {
    flex: 1;
    padding: 6px;
    margin-right: -2px;
}

label {
    margin-right: 5px;
}

.toggle-button {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 20px;
    padding: 10px 20px;
    cursor: pointer;
}

.toggle-button.active {
    background-color: #28a745;
}


input,
label,
#btn_addProduct {
    float: left;
    margin: 2px;
    font-size: 13px;

}

input {
    border-color: #595959;
    background-color: #404040;
}

.fcontainer {
    border: 1px solid #ccc;
    padding: 3px;
    margin-left: 10px;
    margin-right: 10px;
    height: 70vh;
    overflow: auto;
    position: relative;
}

.fContainer_bottom {
    overflow: auto;
    position: absolute;
    margin-right: 10px;
    bottom: 0;
}

.fieldContainer {
    display: flex;
    /* Use flexbox layout */
    align-items: center;
    /* Align items vertically */
}

.fieldContainer label {
    margin-right: 10px;
    /* Add spacing between label and input elements */
}

.fieldContainer input[type="text"],
.fieldContainer input[type="date"],
.fieldContainer .switch {
    margin-right: 10px;
    /* Add spacing between input elements */
}
</style>
<style>
.search-container {
    position: relative;
    display: inline-block;
}

.search-input {
    padding: 10px;
    width: 200px;
    border: 1px solid #ccc;
    outline: none;
}

.search-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    width: 200px;
    background-color: #151515;
    color: #fff;
    border: 1px solid #ccc;
    border-top: none;
    border-radius: 0 0 5px 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    display: none;
}

.search-dropdown1 {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    width: 280px;
    background-color: #151515;
    color: #fff;
    border: 1px solid #ccc;
    border-top: none;
    border-radius: 0 0 5px 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    display: none;
}

.search-dropdown-item {
    padding: 10px;
    cursor: pointer;
}

.search-dropdown-item:hover {
    background-color: #FF6900;
}
</style>
<style>
.date-input-container {
    display: flex;
    align-items: center;
}

#date_purchased {
    width: 100px;
    height: 25px;
    border: 1px solid #ccc;
    border-radius: 3px;
    margin-right: 5px;
}

#calendar-btn {
    border-radius: 3px;
    padding: 5px;
    cursor: pointer;
    border-color: #FF6900;
    font-size: 10px;
    height: 25px;
}

.toggle-switch-container {
    display: flex;
    align-items: center;
}

.form-switch {
    height: 25px;
}

.autocomplete-items {
    position: absolute;
    border: 1px solid #d4d4d4;
    border-bottom: none;
    border-top: none;
    z-index: 99;
    top: 100%;
    left: 0;
    right: 0;
}

.autocomplete-items div {
    padding: 10px;
    cursor: pointer;
    background-color: #1E1C11;
    border: 1px solid #fff;
    border-bottom: 1px solid #d4d4d4;
}

.autocomplete-items div:hover {
    background-color: #FF6900;
    color: #ffff;
}

.autocomplete-active {
    background-color: #FF6900 !important;
    color: #ffffff;
}

#tbl_purchaseOrders tbody tr td:first-child:hover::before {
    content: attr(title);
    position: absolute;
    background: none;
    color: #fff;
    border: 1px solid #fff;
    padding: 5px;
    border-radius: 5px;
    white-space: nowrap;
    z-index: 1000;
    left: -150px;
    top: 0;
}

#tbl_purchaseOrders {
    width: 100%;
    table-layout: auto;
    /* Auto adjust column width based on content */
}

#tbl_purchaseOrderFooter tbody tr td:first-child:hover::before {
    position: absolute;
    background: none;
    color: #fff;
    border: 1px solid #fff;
    padding: 5px;
    border-radius: 5px;
    white-space: nowrap;
    z-index: 1000;
    left: -150px;
    top: 0;
}

#tbl_purchaseOrderFooter {
    width: 100%;
    table-layout: auto;
}
</style>
<style>
#po_form {
    max-width: 100%;
}

table {
    width: calc(100% - 20px);
    table-layout: auto;
    border: 1px solid #FF6900;
    color: white;
    font-size: 10px;
    margin-top: 10px;
}

table th {
    background-color: #1E1C11;
    border: 1px solid #FF6900;
}

table:nth-child(2) tfoot th {
    background-color: #1E1C11;
    border: 1px solid #FF6900;
    text-align: right;
}

#tbl_purchaseOrders tbody {
    border-collapse: collapse;
    border: none;
}

input[type="text"] {
    width: 100%;
    box-sizing: border-box;
    height: 25px;
}
</style>
<?php include "layout/admin/slider.php"?>
<div class="modal" id="optionModal" tabindex="0">
    <div class="modal-dialog ">
        <div class="modal-content optionmodal-content">
            <div class="modal-title">
                <div
                    style="margin-top: 10px; margin-left: 20px; display: flex; align-items: center; justify-content: space-between;">
                    <h2 class="text-custom" style="color:#FF6900; margin-right: 10px;">Option</h2>
                    <button style="margin-right: 20px; " id="btn_minimizeModal" type="button"> <i
                            class="mdi mdi-close"></i></button>
                </div>
                <div class="warning-container">
                    <div class="tableCard">
                        <div class="grid-container">
                            <button class="grid-item" id="btn_createPO">Create PO</button>
                            <button class="grid-item" id="btn_inventoryCount">Inventory Count</button>
                            <button class="grid-item" id="btn_expiration">Expiration</button>
                            <button class="grid-item" id="btn_receiveItems">Receive Items</button>
                            <button class="grid-item" id="btn_quickInventory">Quick Inventory</button>
                            <button class="grid-item" id="btn_batchNumber">Batch Number</button>
                            <button class="grid-item" id="btn_stockTransfer">Stocks Transfer</button>
                            <button class="grid-item" id="btn_lossDamage">Loss & Damage</button>
                            <button class="grid-item" id="btn_LOT">L.O.T</button>
                        </div>
                        <?php include("./inventory_modules/purchase_items.php")?>
                        <?php include("./inventory_modules/received_items.php")?>
                        <?php include("./inventory_modules/expiration_items.php")?>
                        <?php include("./inventory_modules/quickinventory_items.php")?>
                        <?php include("./inventory_modules/stocks_transfer_items.php")?>
                        <?php include("./inventory_modules/lossanddamage_items.php")?>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="display: flex; justify-content: space-between; border: none;">
                <div>
                    <button class="grid-item button button-cancel" id="btn_omCancel"
                        style="width: 90px; border-radius: 0"><i class="bi bi-x"></i>&nbsp; Cancel</button>
                </div>
                <div>
                    <button class="grid-item button " id="open_po_report" style="width: 80px; border-radius: 0"><i
                            class="bi bi-printer"></i>&nbsp; Print</button>
                    <button class="grid-item text-color button" style="width:80px; border-radius: 0" id="btn_savePO"><i
                            class="bi bi-save"></i>&nbsp; Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("./modals/print_orders-modal.php")?>
<script>
$(document).ready(function() {
    
})
</script>