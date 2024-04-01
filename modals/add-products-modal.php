<style>

#add_products_modal {
  display: none;
  position: fixed; 
  z-index: 9999;
  top: 0;
  top: 0;
  bottom: 0;
  left: calc(100% - 500px); 
  width: 500px;
   background-color: transparent;
  overflow: hidden;
  height: 100%; 
  animation: slideInRight 0.5s; 
}


.modal-content {
  background-color: #fefefe;
  margin: 0 auto; 
  border: none;
  width: 100%;
  height: 1000px; 
  animation: slideInRight 0.5s; 
  border-radius: 0;
  margin-top: -28px;
  background-color: #1E1C11;  
  border-color:  #1E1C11;
  
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
.text-custom{
   color: #fefefe;
   font-family: Century Gothic;
   font-weight: bold;
}
.tableCard{
    /* border: 2px solid #4B413E; 
    box-sizing: border-box;  */
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
.tableCard{
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

.td-style{
    font-style: italic;
    padding: 5px;
}
.td-bg{
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
.imageCard{
    /* border: 2px solid #4B413E; 
    box-sizing: border-box;  */
    border-radius: 0;
    min-width: 500px;
    width: 100%;
    max-width: 500px; 
    height: 205px;
    min-height: 30%;
    max-height: 250px; 
    display:flex;
    margin-top:10px;
}
.imageProduct{
    border:1px solid #ffff; 
    box-sizing: border-box; 
    border-radius: 0;
    margin-right: 20px;
    margin-left:20px;
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
.btnCustom{
  font-size: 11px;
  font-family: Century Gothic;
  color:#FF6900;
  border-radius: 5px;
}
.imageButtonDiv{
  position:absolute;
  top: 658px;
  left: 20px
}
.removeImage{
  width:60px
}
.addImage{
  width:97px
}
.descripTion{
  margin-left: 20px;
  font-family: Century Gothic;
  font-weight: bold;
  position: absolute;
  top: 710px
}

.switch {
  position: relative;
  display: inline-block;
  width: 40px; 
  height: 20px; 
  outline: none;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
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


.slider:before {
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

input:checked + .slider {
  background-color: #00CC00;
}

input:focus + .slider {
  box-shadow: 0 0 1px #262626;
}

input:checked + .slider:before {
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

input:checked + .sliderOtherCharges {
  background-color: #FF6900;
}

input:focus + .sliderOtherCharges {
  box-shadow: 0 0 1px #262626;
}

input:checked + .sliderOtherCharges:before {
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

input:checked + .spanDisplayReceipt {
  background-color: #FF6900;
}

input:focus + .spanDisplayReceipt {
  box-shadow: 0 0 1px #262626;
}

input:checked + .spanDisplayReceipt:before {
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

input:checked + .sliderServiceCharges {
  background-color: #FF6900;
}

input:focus + .sliderServiceCharges {
  box-shadow: 0 0 1px #262626;
}

input:checked + .sliderServiceCharges:before {
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

input:checked + .spanDisplayServiceChargeReceipt {
  background-color: #FF6900;
}

input:focus + .spanDisplayServiceChargeReceipt {
  box-shadow: 0 0 1px #262626;
}

input:checked + .spanDisplayServiceChargeReceipt:before {
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

input:checked + .taxVatSpan {
  background-color: #FF6900;
}

input:focus + .taxVatSpan {
  box-shadow: 0 0 1px #262626;
}

input:checked + .taxVatSpan:before {
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

input:checked + .spanTaxVat {
  background-color: #FF6900;
}

input:focus + .spanTaxVat {
  box-shadow: 0 0 1px #262626;
}

input:checked + .spanTaxVat:before {
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

input:checked + .spanShowTaxVat {
  background-color: #FF6900;
}

input:focus + .spanShowTaxVat {
  box-shadow: 0 0 1px #262626;
}

input:checked + .spanShowTaxVat:before {
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

input:checked + .discountSpan {
  background-color: #FF6900;
}

input:focus + .discountSpan {
  box-shadow: 0 0 1px #262626;
}

input:checked + .discountSpan:before {
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
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
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

#discountType{
text-align: right;
}

#uomDropDown {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    z-index: 1;
    top: 25px; 
    left: 82px; 
    
}
.serial::placeholder{
font-style: italic;
color: #503C1F;
font-size: small;
font-weight: bold;
}
.generate{
  color: #E46C0A;
  border-radius: 5px;
  background-color: #404040;
  border-color: #595959;
}
.generate:hover{
  background-color: #FF6900;
  color: #fefefe;
}
.btnCustom:hover {
    background-color: #FF6900;
    color: #fefefe;

}
.addCategory{
  color: #E46C0A;
  border-radius: 5px;
  background-color: #404040;
  border-color: #595959;
}
.addCategory:hover{
  background-color: #FF6900;
  color: #fefefe;
}
</style>

<div class="modal" id="add_products_modal" tabindex="0">
  <div class="modal-dialog ">
    <div class="modal-content user-modal">
      <div class="modal-title">
        <div style="margin-top: 10px; margin-left: 20px">
           <h2 class="text-custom" style="color:#FF6900;">Add New Product</h2>
        </div>
        <div class="warning-container">
          <div class="tableCard">
          <div style="margin-left: 20px;margin-right: 20px">
            <table id="addProducts" class="text-color table-border"> 
                <tbody>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Name<sup>*</sup></td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input /></td>
                    </tr>
                    <tr>
                        <td  class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Code / SKU<sup>*</sup></td>
                        <td class="td-height text-custom"style="font-size: 12px; height: 10px:"><input readonly class="skunNumber" id="skunNumber" /></td>
                    </tr>
                  
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Barcode</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px;"><input class="barcode" id="barcode" style="width: 220px"/><button class="generate" id="generate">Generate</button></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Unit of measure</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><div class="dropdown custom-input">
                            <input class="custom-input" readonly hidden name="uomID" id="uomID" style="width: 259px"/>
                            <input class="custom-input" readonly name="uomType" id="uomType" style="width: 259px"/>
                            <button name="uomBtn" id="uomBtn" class="custom-btn">
                            <svg width="13px" height="13px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                <path d="M19 5L12.7071 11.2929C12.3166 11.6834 11.6834 11.6834 11.2929 11.2929L5 5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M19 13L12.7071 19.2929C12.3166 19.6834 11.6834 19.6834 11.2929 19.2929L5 13" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                            </button>
                            <div class="dropdown-content" id="uomDropDown">
                            <?php
                                 $productFacade = new ProductFacade;
                                 $uom = $productFacade->getUOM();
                                while ($row =  $uom->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<a href="#" style="color:#000000; text-decoration: none;" data-value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['uom_name']) . '</a>';
                                }
                                ?>
                            </div>
                            <div id="variants" style="display: none;">
   
                            </div>
                        </div></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Brand</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input /></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Serial No.</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input class="serial" placeholder="For serialized products"/></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Category</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input  style="width: 242px"/><button onclick="openCategoryModal()" class="addCategory">+Add</button></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Discount (SR/PWD/UP)</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px;">
                        <?php
                          $discount = "no"; 
                          $other_Charge = ($discount== "no") ? "yes" : "no";
                          ?>
                          <label class="discount" style="margin-left: 5px">
                              <input type="checkbox" id="discountToggle"<?php if($discount == "no") ?> >
                              <span class="discountSpan round"></span>
                          </label>

                          <!-- <div class="dropdown custom-input">
                            <input class="custom-input" readonly hidden name="disCountID" id="disCountID" style="width: 210px"/>
                            <input class="custom-input" readonly name="discountType" id="discountType" style="width: 210px"/>
                            <button name="discountBtn" id="discountBtn" class="custom-btn">
                            <svg width="13px" height="13px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                <path d="M19 5L12.7071 11.2929C12.3166 11.6834 11.6834 11.6834 11.2929 11.2929L5 5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M19 13L12.7071 19.2929C12.3166 19.6834 11.6834 19.6834 11.2929 19.2929L5 13" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                            </button>
                            <div class="dropdown-content" id="discountDropDown">
                           
                            </div> -->
                            </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Cost Price (Php)</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input /></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Mark-up (%)</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input /></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Selling Price (Php)</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input /></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Tax (VAT) 12%</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px">  <?php
                          $taxVat = "no"; 
                          $other_Charge = ($taxVat== "no") ? "yes" : "no";
                          ?>
                          <label class="taxVat" style="margin-left: 5px">
                              <input type="checkbox" id="taxVatToggle"<?php if($taxVat == "no") ?> onclick="toggleTaxVat(this)">
                              <span class="taxVatSpan round"></span>
                          </label>
                          <small id="showTaxVatLbl" style="margin-left: 100px">Price Includes Tax</small>
                          <?php
                          $showTheTaxVat = 'no'; 
                          $showOn= (  $showTheTaxVat== 'no') ? 'yes' :' no';
                          ?>
                          <label class="showIncludesTaxVat" style="display:flex;float: right; margin-right: 5px">
                              <input type="checkbox" id="showIncludesTaxVatToggle"<?php if($showTheTaxVat== 'no') echo ' disabled'; ?> onclick="toggleChangeColor(this)" >
                              <span class="spanShowTaxVat round"></span>
                          </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Service Charge (1%)</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px">  
                        <?php
                          $serviceCharges = "no"; 
                          $other_Charge = ($serviceCharges== "no") ? "yes" : "no";
                          ?>
                          <label class="serviceCharge" style="margin-left: 5px">
                              <input type="checkbox" id="serviceChargesToggle"<?php if($serviceCharges == "no") ?> onclick="toggleDisplayServiceCharge(this)" >
                              <span class="sliderServiceCharges round"></span>
                          </label>
                          <small id="displayOnReceiptServiceCharge" style="margin-left: 100px">Display on Receipt</small>
                          <?php
                          $showTheServiceCharge = 'no'; 
                          $showOn= (  $showTheServiceCharge== 'no') ? 'yes' :' no';
                          ?>
                          <label class="displayServiceReceipt" style="display:flex;float: right; margin-right: 5px">
                              <input type="checkbox" id="displayServiceChargeReceipt"<?php if($showTheServiceCharge== 'no') echo ' disabled'; ?> onclick=" toggleDisplayOnReceiptServiceCharge(this)" >
                              <span class="spanDisplayServiceChargeReceipt round"></span>
                          </label>
                        </td>
                    </tr>
                    <tr>
                      <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Other Charges (2%)</td>
                      <td class="td-height text-custom" style="font-size: 12px; height: 10px">
                          <?php
                          $otherChanges = "no"; 
                          $other_changes = ($otherChanges == "no") ? "yes" : "no";
                          ?>
                          <label class="switchOtherCharges" style="margin-left: 5px">
                              <input type="checkbox" id="otherChargesToggle"<?php if($otherChanges == "no") ?> onclick="toggleOtherCharges(this)">
                              <span class="sliderOtherCharges round"></span>
                          </label>
                          <small id="otherChargesDisplayOnReceipt" style="margin-left: 100px">Display on Receipt</small>
                          <?php
                          $showOnReceipt = 'no'; 
                          $showOn= (  $showOnReceipt== 'no') ? 'yes' :' no';
                          ?>
                          <label class="displayReceipt" style="display:flex;float: right; margin-right: 5px">
                              <input type="checkbox" id="displayReceipt"<?php if($showOnReceipt== 'no') echo ' disabled'; ?> onclick="toggleDisplayOnReceipt(this)">
                              <span class="spanDisplayReceipt round"></span>
                          </label>
                      </td>
                  </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" id="statusActive" style="font-size: 12px; height: 10px">Status (Active)</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px">
                  <?php
                  $status = 'Active'; 
                  $opposite_status = ($status == 'Active') ? 'Inactive' : 'Active';
                  ?>
                  <label class="switch" style="margin-left: 5px">
                      <input readonly type="checkbox" id="statusValue"<?php if($status == 'Active')?> onclick="toggleStatus(this)">
                      <span class="slider round"></span>
                  </label>
              </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="imageCard">
                 <div  style="width:32%" class="imageProduct" id="imageProduct">
                   
                   </div> 
                    <div  class="bomCard">
                    
                   </div>        
               </div>     
          </div>
          <div class="imageButtonDiv">
            <input hidden type="file" id="fileInputs" style="display: none;" accept="image/jpeg, image/jpg, image/png">
            <button onclick="clearImageProduct()" class="btnCustom removeImage">-Del</button>
            <button class="btnCustom addImage" id="addImage">+ Add Image</button>
          </div>
          <div style="margin-bottom: 30px">
            <h4 class="descripTion" style="color:#FF6900;">Description</h4>
          </div>
          <div style="margin-left: 20px;width: 100%; margin-right: 20px">
            <textarea style="width: 92%; height: 120px; background-color: transparent; color:#fefefe"></textarea>
          </div>
        
            <div class="button-container" style="display:flex;justify-content: right">
                <button  class="btn-success-custom saveProductsBtn" style="margin-right: 10px; width: 100px; height: 40px">Save</button>
                <button hidden class="btn-success-custom updateProductsBtn" style="margin-right: 10px; width: 100px; height: 40px">Update</button>
                <button  class="cancelAddProducts btn-error-custom" style="margin-right: 20px;width: 100px; height: 40px">Cancel</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    function toggleStatus(checkbox) {
            var slider = checkbox.parentNode.querySelector('.slider'); 
            var statusLabel = document.getElementById('statusActive');
            if (checkbox.checked) {
                slider.style.backgroundColor = '#00CC00'; 
                statusLabel.style.color = '#00CC00'; 
            } else {
                slider.style.backgroundColor = '#262626'; 
                statusLabel.style.color = '#fefefe'; 
            }
        }
    function toggleDisplayOnReceipt(checkbox){
      var otherChargesDisplayOnReceipt = document.getElementById('otherChargesDisplayOnReceipt')
      var spanDisplayReceipt = checkbox.parentNode.querySelector('.spanDisplayReceipt'); 
      if (checkbox.checked) {
        otherChargesDisplayOnReceipt.style.color = "#FF6900";
            } else {
              otherChargesDisplayOnReceipt.style.color = "#FFFFFF";  
            }
    }

    function toggleOtherCharges(checkbox){
      var otherChargesDisplayOnReceipt = document.getElementById('otherChargesDisplayOnReceipt')
        var otherChargesToggle= checkbox.parentNode.querySelector('.sliderOtherCharges'); 
        if (checkbox.checked) {
            var displayReceipt = document.getElementById('displayReceipt')
            displayReceipt.disabled = false;
            } else {
            var displayReceipt = document.getElementById('displayReceipt')
            displayReceipt.disabled = true;
            displayReceipt.checked = false;
            otherChargesDisplayOnReceipt.style.color = "#FFFFFF"; 
            }
      }

      function toggleDisplayServiceCharge(checkbox){
      var otherServiceChargesDisplayOnReceipt = document.getElementById('displayOnReceiptServiceCharge')
      var spanDisplayServiceReceipt = checkbox.parentNode.querySelector('.sliderServiceCharges'); 
      if (checkbox.checked) {
          var showServiceCharge = document.getElementById('displayServiceChargeReceipt')
          showServiceCharge.disabled=false
            } else {
              var showServiceCharge = document.getElementById('displayServiceChargeReceipt')
              showServiceCharge.disabled=true
              showServiceCharge.checked= false
              otherServiceChargesDisplayOnReceipt.style.color="#FFFFFF"
            }
    }

  function toggleDisplayOnReceiptServiceCharge(checkbox){
    var otherServiceChargesDisplayOnReceipt = document.getElementById('displayOnReceiptServiceCharge')
    var spanDisplayServiceReceipt = checkbox.parentNode.querySelector('.spanDisplayServiceChargeReceipt'); 
      if (checkbox.checked) {
         otherServiceChargesDisplayOnReceipt.style.color="#FF6900"
            } else {
              otherServiceChargesDisplayOnReceipt.style.color="#FFFFFF"
            }
  }

  function toggleTaxVat(checkbox){
    var showTaxVatLbl = document.getElementById('showTaxVatLbl')
    var spanDisplayServiceReceipt = checkbox.parentNode.querySelector('.taxVatSpan'); 
    if (checkbox.checked) {
          var taxVat = document.getElementById('showIncludesTaxVatToggle')
           taxVat.disabled=false
            } else {
              var taxVat = document.getElementById('showIncludesTaxVatToggle')
              taxVat.disabled=true
              taxVat.checked= false
              showTaxVatLbl.style.color="#FFFFFF"
            }
  }
  function toggleChangeColor(checkbox){
    var taxLbl = document.getElementById('showTaxVatLbl')
    var spanDisplayTaxVat = checkbox.parentNode.querySelector('.spanShowTaxVat'); 
    if (checkbox.checked) {
         taxLbl.style.color="#FF6900"
            } else {
              taxLbl.style.color="#FFFFFF"
            }
  }

document.getElementById("uomBtn").addEventListener("click", function() {
  var dropdownContents = document.getElementById("uomDropDown");
  if (dropdownContents.style.display === "block") {
    dropdownContents.style.display = "none";
  } else {
    dropdownContents.style.display = "block";
  }
  event.stopImmediatePropagation();
});

document.addEventListener("click", function(event) {
  var dropdownContent = document.getElementById("uomDropDown");
  var statusBtn = document.getElementById("uomBtn");
  if (event.target !== dropdownContent && event.target !== statusBtn && dropdownContent.style.display === "block") {
    dropdownContent.style.display = "none";
  }
});

document.querySelectorAll("#uomDropDown a").forEach(item => {
  item.addEventListener("click", function(event) {
    event.preventDefault(); 
    var value = this.getAttribute("data-value");
    var roleName = this.textContent;
    document.getElementById("uomID").value = value;
    document.getElementById("uomType").value = roleName;
    document.getElementById("uomDropDown").style.display = "none";
  });
});

document.getElementById("generate").addEventListener("click", function() {
    const minDigits = 9;
    const randomNumber = generateRandomNumber(minDigits);
    document.getElementById('barcode').value = randomNumber
    
})
function generateRandomNumber(minDigits) {
    const numberOfDigits = Math.floor(Math.random() * (30 - minDigits + 1)) + minDigits; 
    let randomNumber = '';

    for (let i = 0; i < numberOfDigits; i++) {
        randomNumber += Math.floor(Math.random() * 10); 
    }

    return randomNumber;
}
function displayImage(imageUrl) {
    document.getElementById('imageProduct').innerHTML = '<img src="' + imageUrl + '" style="max-width: 100%; max-height: 100%;">';
}

var defaultImageUrl = './assets/img/noImage.png';
var file;
displayImage(defaultImageUrl);


document.getElementById("addImage").addEventListener("click", function() {
    document.getElementById("fileInputs").click();
});

document.getElementById('fileInputs').addEventListener('change', function(event) {
    var file = event.target.files[0];
    var reader = new FileReader();

    reader.onload = function(event) {
        var imageUrl = event.target.result;
        displayImage(imageUrl);
    };

    if (file) {
        reader.readAsDataURL(file);
    } 
});

document.getElementById("fileInputs").addEventListener("change", function(event) {
    var file = event.target.files[0];
  
});
function clearImageProduct() {
    var fileInput = document.getElementById('fileInputs');
    fileInput.value = '';
    if(fileInput.value == ''){
        displayImage(defaultImageUrl);
    }
}

function openCategoryModal(){
   $('#add_category_modal').show()
}


</script>

