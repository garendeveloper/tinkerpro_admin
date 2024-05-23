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


.product-modal {
  background-color: #fefefe;
  margin: 0 auto; 
  border: none;
  width: 100%;
  height: fit-content; 
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
@keyframes slideOutRight {
  from {
    margin-right: 0;
    opacity: 1;
  }
  to {
    margin-right: -100%;
    opacity: 0;
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
  top: 730px;
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
  top: 760px
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
         
}.button-container {
  padding-top: 5px;
  margin: 0;
  bottom: 20px;
  right:0;
  margin-bottom: 20px;

}
.bomHeader{
color: #ffff;
font-family: Century Gothic;
padding-top: 7px;
margin-left: 10px;
font-size: 13px;
}

/* new */

.bomLbl {
  position: relative;
  display: inline-block;
  width: 40px; 
  height: 20px; 
  outline: none; 
}

.bomLbl input {
  opacity: 0;
  width: 0;
  height: 0;
}

.sliderbom {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #BFBFBF;
  -webkit-transition: .4s;
  transition: .4s;
  outline: none;
  border-radius: 10px; 
}

.sliderbom:before {
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

input:checked + .sliderbom {
  background-color: #00CC00;
}

input:focus + .sliderbom {
  box-shadow: 0 0 1px #BFBFBF;
}

input:checked + .sliderbom:before {
  -webkit-transform: translateX(20px); 
  -ms-transform: translateX(20px);
  transform: translateX(20px); 
}

.sliderbom.round {
  border-radius: 10px; 
}

.sliderbom.round:before {
  border-radius: 50%; 
}

.sliderbom.active {
  background-color: #00CC00;
}
.enablingTxt{
  color: #ffff;
  font-family: Century Gothic;
  font-size: 13px;
  text-align: center;
  font-style: italic;
}
.btns-bom{
  font-size: 12px;
  font-family: Century Gothic;
  border-radius: 5px;
  outline: 0;
  background-color: #404040;
  border-color: #595959;
  margin-top: 20px
}
.btns-bom:hover{
  background-color: #FF6900;
  outline: 0;
}
#myTable {
  border-collapse: collapse;
  width: 100%;
  margin-top:15px;
}

#myTable td {
  border: none !important;
  font-family: Century Gothic;
  font-size: 11px;
}

#myTable td {
  padding: 0; 
  padding-left: 10px
}

#myTable tr {
  margin: 0;
}
.table-container {
  max-height: 80px; 
  overflow-y: scroll;
  background-color: transparent;
  top: 85px;
  max-width: 500px;
  padding-right: 20px;
  margin-top: 13px;
  margin-bottom: 5px;
}


.table-container::-webkit-scrollbar {
  width: 6px;
 
}

.table-container::-webkit-scrollbar-track {
  background: #262626;
}

.table-container::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 3px;
}

.table-container::-webkit-scrollbar-thumb:hover {
  background: #555;
}

/* new */

.warrantLbl {
  position: relative;
  display: inline-block;
  width: 40px; 
  height: 20px; 
  outline: none; 
}

.warrantLbl input {
  opacity: 0;
  width: 0;
  height: 0;
}

.warrantySpan {
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

.warrantySpan:before {
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

input:checked + .warrantySpan {
  background-color: #FF6900;
}

input:focus + .warrantySpan {
  box-shadow: 0 0 1px #262626;
}

input:checked + .warrantySpan:before {
  -webkit-transform: translateX(20px); 
  -ms-transform: translateX(20px);
  transform: translateX(20px); 
}

.warrantySpan.round {
  border-radius: 10px; 
}

.warrantySpan.round:before {
  border-radius: 50%; 
}

.warrantySpan.active {
  background-color: #FF6900;
}

/* new */
.multiplePrice {
  position: relative;
  display: inline-block;
  width: 40px; 
  height: 20px; 
  outline: none; 
}

.multiplePrice input {
  opacity: 0;
  width: 0;
  height: 0;
}

.multipleSpan {
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

.multipleSpan:before {
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

input:checked + .multipleSpan {
  background-color: #FF6900;
}

input:focus + .multipleSpan {
  box-shadow: 0 0 1px #262626;
}

input:checked + .multipleSpan:before {
  -webkit-transform: translateX(20px); 
  -ms-transform: translateX(20px);
  transform: translateX(20px); 
}

.multipleSpan.round {
  border-radius: 10px; 
}

.multipleSpan.round:before {
  border-radius: 50%; 
}

.multipleSpan.active {
  background-color: #FF6900;
}
/* new */
.stockeable {
  position: relative;
  display: inline-block;
  width: 40px; 
  height: 20px; 
  outline: none; 
}

.stockeable input {
  opacity: 0;
  width: 0;
  height: 0;
}

.stockeableSpan {
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

.stockeableSpan:before {
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

input:checked + .stockeableSpan {
  background-color: #FF6900;
}

input:focus + .stockeableSpan {
  box-shadow: 0 0 1px #262626;
}

input:checked + .stockeableSpan:before {
  -webkit-transform: translateX(20px); 
  -ms-transform: translateX(20px);
  transform: translateX(20px); 
}

.stockeableSpan.round {
  border-radius: 10px; 
}

.stockeableSpan.round:before {
  border-radius: 50%; 
}

.stockeableSpan.active {
  background-color: #FF6900;
}


</style>

<div class="modal" id="add_products_modal" tabindex="0">
  <div class="modal-dialog ">
    <div class="modal-content product-modal">
      <!-- <div id="scrollable-data"> -->
      <div class="modal-title">
        <div style="margin-top: 30px; margin-left: 20px">
           <h5 class="text-custom modalHeaderTxt" id="modalHeaderTxt" style="color:#FF6900;">Add New Product</h5>
        </div>
        <div class="warning-container">
          <div class="tableCard">
          <div style="margin-left: 20px;margin-right: 20px">
            <table id="addProducts" class="text-color table-border"> 
                <tbody>
                    <tr>
                        <td class="nameTd td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Name<sup>*</sup></td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input class="productname" id="productname" name="productname"/></td>
                    </tr>
                    <tr>
                        <td  class="skuTd td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">SKU</td>
                        <td class="td-height text-custom"style="font-size: 12px; height: 10px:"><input oninput="validateInputs(this)"  class="skunNumber" id="skunNumber" name="skunNumber" /></td>
                    </tr>
                    <tr>
                        <td class="codeTd td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Code</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input oninput="validateInputs(this)"  class="code" id="code" name="code"/></td>
                    </tr>
                    <tr>
                        <td class="barcodeTd td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Barcode<sup>*</sup></td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px;"><input  oninput="validateNumber(this)" class="barcode" id="barcode" name="barcode" style="width: 220px"/><button class="generate" id="generate">Generate</button></td>
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
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input class="brand" name="brand" id="brand"/></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Warranty &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        
                        <?php
                          $taxVat = "yes"; 
                          $other_Charge = ($taxVat== "yes") ? "no" : "yes";
                          ?>
                          <label class="warrantLbl" style="margin-left: 5px">
                              <input type="checkbox" id="warrantyToggle"<?php if($taxVat == "yes") ?> onclick="toggleShowText(this)">
                              <span class="warrantySpan round"></span>
                          </label>
                      </td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px; font-style:italic; color: #B2B2B2"><span hidden id="triggers"> &nbsp;Triggers only when the product is sold</span></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Category<input hidden id="catID"/><input hidden  id="varID"/><input hidden id="productLbl"/><input hidden id="cat_Lbl"/><input hidden id="var_Lbl"/></td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input readonly class="categoriesInput" name="categoriesInput" id="categoriesInput" style="width: 242px"/><button onclick="openCategoryModal()" class="addCategory">+Add</button></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Discount (SR/PWD/UP)</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px;">
                        <?php
                          $discount = "no"; 
                          $other_Charge = ($discount== "no") ? "yes" : "no";
                          ?>
                          <label class="discount" style="margin-left: 5px">
                              <input type="checkbox" id="discountToggle"<?php if($discount == "no") ?>  >
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
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Stockable</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px;">
                        <?php
                          $stockable = "no"; 
                          $other_Charge = ($stockable == "no") ? "yes" : "no";
                          ?>
                          <label class="stockeable" style="margin-left: 5px">
                              <input type="checkbox" id="stockeableToggle"<?php if($stockable  == "no") ?>  >
                              <span class="stockeableSpan round"></span>
                          </label>
                            </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                        <td class="costTd td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Cost Price (Php)<sup>*</sup></td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input class="cost" name="cost" id="cost"  oninput="validateNumber(this)"/></td>
                    </tr>
                    <tr>
                        <td class="markupTd td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Mark-up (%)<sup>*</sup></td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input class="markup" name="markup" id="markup"  oninput="validateNumber(this)" /></td>
                    </tr>
                    <tr> 
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Selling Price (Php)</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input style="width: 105px"  class="selling_price" name="selling_price" id="selling_price"/>
                        <span hidden class="text-custom" id="multiLbl">Multiple Prices</span>
                        <?php
                          $multi = "yes"; 
                          $other_Charge = ($taxVat== "yes") ? "no" : "yes";
                          ?>
                          <label hidden class="multiplePrice" style="margin-left: 5px">
                              <input hidden type="checkbox" id="multipleToggle"<?php if($multi == "yes")?>  onclick="toggleMultiple(this)">
                              <span hidden  class="multipleSpan round"></span>
                          </label>
                        <button hidden disabled id="addMultiple" class="addMultiple addCategory">+Add</button>
                        <button hidden disabled class="editMultiple addCategory" hidden>+Edit</button> </td>
                    </tr>
                    <tr>
                        <td id="taxtVatLbl" class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Tax (VAT) 12%</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px">  <?php
                          $taxVat = "yes"; 
                          $other_Charge = ($taxVat== "yes") ? "no" : "yes";
                          ?>
                          <label class="taxVat" style="margin-left: 5px">
                              <input type="checkbox" id="taxVatToggle"<?php if($taxVat == "yes") echo ' checked'?> onclick="toggleTaxVat(this)">
                              <span class="taxVatSpan round"></span>
                          </label>
                          <small id="showTaxVatLbl" style="margin-left: 100px">Price Includes Tax</small>
                          <?php
                          $showTheTaxVat = 'yes'; 
                          $showOn = ($showTheTaxVat == 'yes') ? 'no' : 'yes';
                          ?>
                          <label class="showIncludesTaxVat" style="display:flex;float: right; margin-right: 5px">
                              <input type="checkbox" id="showIncludesTaxVatToggle"<?php if($showTheTaxVat == 'yes') echo ' checked'; ?> onclick="toggleChangeColor(this)">
                              <span class="spanShowTaxVat round"></span>
                          </label>
                        </td>
                    </tr>
                    <tr>
                        <td id="serviceChargeLbl" class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Service Charge (1%)</td>
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
                      <input readonly type="checkbox" id="statusValue"<?php if($status == 'Active') echo ' checked' ?> onclick="toggleStatus(this)">
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
                      <div style="width: 100%; display: flex;">
                         <h6 class="bomHeader" style="margin-left: 20px"><span class="disAbled">Disabled</span>&nbsp;<span id="bomText">Bill-0f-Material (BOM)</span></h6>
                         <div>
                         <?php
                            $otherChanges = "no"; 
                            $other_changes = ($otherChanges == "no") ? "yes" : "no";
                            ?>
                            <label class="bomLbl" style="margin-left: 15px; margin-top: 5px">
                                <input type="checkbox" id="bomToggle"<?php if($otherChanges == "no")  ?> >
                                <span class="sliderbom round"></span>
                            </label>  
                         </div>
                      </div>
                      <h6 class="enablingTxt">By enabling BOM, you are <br>activating the ingredients module.</h6>
                      <div  style="width: 100%; display: flex; align-items: right; justify-content: right; margin-top: -10px">
                          <button class="btns-bom" id="addIngredients" onclick="openBomModal()" style="margin-right: 5px; width: 70px">+ Add</button>
                          <button class="btns-bom" id="delIngredients" style="margin-right: 20px; width: 70px">- Del</button>
                      </div>
                      <div class="table-container">
                  <table id="myTable" class="text-color">
                    <tbody>
                      <tr>
                          <td class="counter-cell" style="width:5%" ></td>
                          <td id="ingredientCell" style="width:30%"></td>
                          <td id="qtyCell"style="width:5%"></td>
                          <td id="uomCell" style="width:30%"></td>
                          <td hidden class="action-cell"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                   </div>        
               </div>     
          </div>
          <div class="imageButtonDiv">
            <input hidden type="file" id="fileInputs" style="display: none;" accept="image/jpeg, image/jpg, image/png">
            <button onclick="clearImageProduct()" class="btnCustom removeImage">-Del</button>
            <button class="btnCustom addImage" id="addImage">+ Add Image</button>
          </div>
          <div style="margin-bottom: 20px">
            <h4 class="descripTion"  style="color:#FF6900;">Description</h4>
          </div>
          <div style="margin-left: 20px;width: 100%; margin-right: 20px">
            <textarea  id="description" style="width: 92%; height: 120px; background-color: transparent; color:#fefefe" name="description"  class="description"></textarea>
          </div>
            <div class="button-container" style="display:flex;justify-content: right;">
                <button onclick="addProduct()" class="btn-success-custom saveProductsBtn" style="margin-right: 10px; width: 100px; height: 40px">Save</button>
                <button hidden onclick="updateProducts()" class="btn-success-custom updateProductsBtn" style="margin-right: 10px; width: 100px; height: 40px">Update</button>
                <button onclick="closeAddProductsModal()" class="cancelAddProducts btn-error-custom" style="margin-right: 20px;width: 100px; height: 40px">Cancel</button>
            </div>
        </div>
      </div>
    </div>
    </div>
  </div>
<!-- </div> -->
<script>




document.getElementById('addMultiple').addEventListener('click', function(){
   $('#add_multiple_modal').show()
})
window.addEventListener('beforeunload', function() {
    localStorage.removeItem('bomData');
});


document.addEventListener('DOMContentLoaded', function() {
    var checkbox = document.getElementById('bomToggle');
    var bomText = document.getElementById('bomText');
    var disAbled = document.querySelector('.disAbled');
    var addButtons = document.getElementById('addIngredients');
    var delButtons = document.getElementById('delIngredients');
    if (checkbox.checked) {
            bomText.style.color = '#00CC00';
            disAbled.textContent = 'Enabled';
            disAbled.style.color = '#00CC00';
            addButtons.disabled = false;
            delButtons.disabled = false;
    }else{
         addButtons.disabled = true;
         delButtons.disabled = true;
        
    }

 
   
});
function openBomModal(){
  if( $('#add_category_modal').is(":visible")){
    closeModal()
  }
  var checkbox = document.getElementById('bomToggle');
  if (checkbox.checked) {
    $('#add_bom_modal').css('display', 'block');
  }
}

document.addEventListener('DOMContentLoaded', function() {
    var checkbox = document.getElementById('bomToggle');
    checkbox.addEventListener('change', updateTextColor);
    checkbox.addEventListener('change', function(){
      if(!checkbox.checked){
      if($('#add_bom_modal').is(':visible')){
           closeModalBom()
       }
    }
    });
   
  
});
  

function updateTextColor() {
    var checkbox = document.getElementById('bomToggle');
    var bomText = document.getElementById('bomText');
    var disAbled = document.querySelector('.disAbled');
    var addButtons = document.getElementById('addIngredients');
    var delButtons = document.getElementById('delIngredients');

    if (checkbox.checked) {
        bomText.style.color = '#00CC00';
        disAbled.textContent = 'Enabled';
        disAbled.style.color = '#00CC00';
         addButtons.disabled = false;
         delButtons.disabled = false;
    } else {
        bomText.style.color = '';
        disAbled.textContent = 'Disabled';
        disAbled.style.color = '';
        addButtons.disabled = true;
         delButtons.disabled = true;
    }
}
function toggleShowText(checkbox) {
    var triggers = document.getElementById('triggers');
    if (checkbox.checked) {
      triggers.removeAttribute('hidden');
    } else {
      triggers.setAttribute('hidden', 'hidden');
    }
  }

  function toggleMultiple(checkbox){
    var multiLbl = document.getElementById('multiLbl');
    var addMultiple = document.getElementById('addMultiple')
    if(checkbox.checked){
      multiLbl.style.color = "#FF6900";
      addMultiple.disabled = false;
    }else{
      multiLbl.style.color = "";
      addMultiple.disabled = true;
    }
  }

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
           taxVat.checked= true
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
    const numberOfDigits = Math.floor(Math.random() * (9 - minDigits + 1)) + minDigits; 
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
   if($('#add_bom_modal').is(':visible')){
      closeModalBom()
    }
    
}

function clearStorage() {
  var existingData = JSON.parse(localStorage.getItem('bomData')) || [];
  
  if (existingData.length > 0) {
    localStorage.removeItem('bomData');
    var tableBody = document.getElementById('myTable').getElementsByTagName('tbody')[0];
    tableBody.innerHTML = '';
  }
}

function closeAddProductsModal(){
     closeModal()
     clearStorage()
    if($('#add_bom_modal').is(':visible')){
      closeModalBom()
    }
    
  $('#add_products_modal').css('animation', 'slideOutRight 0.5s forwards');
  $('.product-modal').css('animation', 'slideOutRight 0.5s forwards');
  $('.highlighteds').removeClass('highlighteds');
  $('.highlightedss').removeClass('highlightedss');

  $('#add_products_modal').one('animationend', function() {
    $(this).hide();
    $(this).css('animation', '');
    $('.product-modal').css('animation', '');
     clearProductsInputs()
     clearFileInput() 
   
  });
  
}

  
function validateNumber(input) {
   
    input.value = input.value.replace(/[^0-9.]/g, '');
    if (input.value.startsWith('-')) {
        input.value = input.value.slice(1);
    }
}function validateInputs(input) {
    // Remove any non-alphanumeric characters
    input.value = input.value.replace(/[^a-zA-Z0-9]/g, '');
}

document.addEventListener('DOMContentLoaded', function() {
    var skunNumberInput = document.getElementById('skunNumber');
    var skuLabel = document.querySelector('.skuTd');

    skunNumberInput.addEventListener('input', function() {
        var sku = skunNumberInput.value.trim(); 
        if (sku) {
          axios.get(`api.php?action=checkSKU&sku=${sku}`)
                .then(function(response) {
                    var data = response.data;
                    if (data.success && data.sku) {
                        skunNumberInput.style.color = 'red';
                        skuLabel.style.color = 'red';
                    } else {
                        skunNumberInput.style.color = ''; 
                        skuLabel.style.color = '';
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        } else {
            skunNumberInput.style.color = ''; 
            skuLabel.style.color = '';
        }
    });
    var barcodeInput =  document.getElementById('barcode');
    var barcodeLabel = document.querySelector('.barcodeTd');
    barcodeInput.addEventListener('input', function() {
        var barcode = barcodeInput.value.trim(); 
        if (barcode) {
            axios.get(`api.php?action=checkSKU&barcode=${barcode}`)
                .then(function(response) {
                    var data = response.data;
                    if (data.success && data.sku) {
                        barcodeInput.style.color = 'red';
                        barcodeLabel.style.color = 'red';
                    } else {
                        barcodeInput.style.color = ''; 
                        barcodeLabel.style.color = '';
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        } else {
            barcodeInput.style.color = ''; 
            barcodeLabel.style.color = '';
        }
    });
    var codeInput =  document.getElementById('code');
    var codeLabel = document.querySelector('.codeTd');
    codeInput.addEventListener('input', function() {
        var code = codeInput.value.trim(); 
        if (code) {
            axios.get(`api.php?action=checkSKU&code=${code}`)
                .then(function(response) {
                    var data = response.data;
                    if (data.success && data.sku) {
                       codeInput.style.color = 'red';
                        codeLabel.style.color = 'red';
                    } else {
                       codeInput.style.color = ''; 
                        codeLabel.style.color = '';
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        } else {
           codeInput.style.color = ''; 
            codeLabel.style.color = '';
        }
    });
    var productInput =  document.getElementById('productname');
    var nameLabel = document.querySelector('.nameTd');
    productInput.addEventListener('input', function() {
       var productname =  productInput.value.trim();
       if(productInput){
         nameLabel.style.color = '';
       }
    })
  var costLabel  = document.querySelector('.costTd');
  var costInput = document.getElementById('cost');
  costInput.addEventListener('input', function(){
    var cost =  costInput.value.trim();
    if(cost){
      costLabel.style.color = '';
    }
  })
  var markupLabel = document.querySelector('.markupTd');
  var markupInput = document.getElementById('markup')
  markupInput.addEventListener('input', function(){
     var markup = markupInput.value.trim();
     if(markup){
      markupLabel.style.color = '';
     }
  })
});
function clearFileInput() {
    var fileInput = document.getElementById('fileInputs');
    fileInput.value = '';
    if(fileInput.value == ''){
        displayImage(defaultImageUrl);
    }
}

function clearProductsInputs(){

  document.getElementById('productname').value = "";
  document.getElementById('skunNumber').value = "";
  document.getElementById('code').value = "";
  document.getElementById('barcode').value = "";
  document.getElementById('uomID').value = "";
  document.getElementById('brand').value = "";
  document.getElementById('cost').value = "";
  document.getElementById('markup').value = "";
  document.getElementById('selling_price').value = "";
  document.getElementById('uomType').value = ""
  document.getElementById('categoriesInput').value = "";
  document.getElementById('description').value = "";
  document.getElementById('productid').value = ""
  document.getElementById('catID').value = "";
  document.getElementById('varID').value = "";
  document.getElementById('productLbl').value = "";
  document.getElementById('cat_Lbl').value = "";
  document.getElementById('var_Lbl').value = "";

  var nameLabel = document.querySelector('.nameTd');
  nameLabel.style.color = ""
  var barcodeLabel = document.querySelector('.barcodeTd');
  barcodeLabel.style.color = ""
  var costLabel  = document.querySelector('.costTd');
  costLabel.style.color = ""
  var markupLabel = document.querySelector('.markupTd');
  markupLabel.style.color = ""

  var categoriesVisible = false;
    $('#categoriesDiv').hide();
    $('#showCategories').text('+ Products').removeClass('highlighted');
    $('#showCategories').off('click').click(function() {
        $('#categoriesDiv').toggle();
        categoriesVisible = !categoriesVisible; 
        $('.productsP').toggleClass('highlighted', categoriesVisible);
        $('.productsBtn').toggleClass('black-text', categoriesVisible).toggleClass('white-text', !categoriesVisible);

        if (categoriesVisible) {
            getCategories();
            $(this).text('- Products');
        } else {
            $(this).text('+ Products'); 
            $('.productsP').removeClass('highlighted');
        }
    });
  var uptBtn = document.querySelector('.updateProductsBtn');
    uptBtn.setAttribute('hidden',true);
    var saveBtn = document.querySelector('.saveProductsBtn');
    saveBtn.removeAttribute('hidden');
}



document.getElementById('selling_price').addEventListener('input', function(){
  var multipleToggle = document.getElementById('multipleToggle'); 
  var sell =  document.getElementById('selling_price').value
  if(sell){
    multipleToggle.disabled = false; 
  }else{
    multipleToggle.disabled = true; 
  }

})

document.addEventListener('DOMContentLoaded', function() {
  var multipleToggle = document.getElementById('multipleToggle'); 
  var sell =  document.getElementById('selling_price').value
  if(sell){
    multipleToggle.disabled = false; 
  }else{
    multipleToggle.disabled = true; 
  }

  var isFirstInputZeroIndex = false; 
  var isFirstInputOneIndex = false;
  var isFirstInputTwoIndex = false;

  
  var $inputs = $('#cost, #markup, #selling_price');

  var taxCheckbox = document.getElementById('taxVatToggle');
  var showTaxCheckbox = document.getElementById('showIncludesTaxVatToggle');
  var service = document.getElementById('serviceChargesToggle');
  var otherCharges = document.getElementById('otherChargesToggle');
  var taxLabel = document.getElementById('taxtVatLbl');
  var serviceLabel = document.getElementById('serviceChargeLbl');
  var showTaxLbl = document.getElementById('showTaxVatLbl');

  $inputs.on('input', function() {
    handleInputChange();
    var index = $inputs.index(this);
    if ($(this).val() === '') {
      isFirstInputZeroIndex = false;
      isFirstInputOneIndex = false;
      isFirstInputTwoIndex = false;
      $('#selling_price, #markup, #cost').val('');
    return; 
  }

    
    if (!isFirstInputZeroIndex && index === 0) {
      isFirstInputZeroIndex = true;
    }
    if (!isFirstInputOneIndex && index === 1) {
      isFirstInputOneIndex = true;
    }

    if (!isFirstInputTwoIndex && index === 2) {
      isFirstInputTwoIndex = true;
    }
   
    if ((isFirstInputZeroIndex && index === 1) || (isFirstInputOneIndex && index === 0)) {
      calculateSellingPrice();
    } else if ((isFirstInputZeroIndex && index === 2) || (isFirstInputTwoIndex && index === 0 )) {
      calculateMarkup();
    } 
    
    if ((isFirstInputOneIndex && index === 2) ||  (isFirstInputTwoIndex && index === 1 ) ) {
      calculateCost();
    }

  });
  var tax = 0; // Declare tax outside the event listener function

showTaxCheckbox.addEventListener('change', function() {
    var sellingPrice = parseFloat(document.getElementById('selling_price').value);
    var vatable = sellingPrice / 1.12;
    if (!this.checked) {
        tax = sellingPrice - vatable;
        var newPrice = sellingPrice + tax;
        document.getElementById('selling_price').value = newPrice.toFixed(2);
    } else {
        var newPrice = sellingPrice - tax;
        showTaxLbl.style.color = ""
        document.getElementById('selling_price').value = newPrice.toFixed(2);
    }
});
var serviceCharge = 0.01; 

service.addEventListener('change', function() {
    var sellingPrice = parseFloat(document.getElementById('selling_price').value);
    
    if (this.checked) {
        var serviceFee = sellingPrice * serviceCharge;
        var newPrice = sellingPrice + serviceFee;
        document.getElementById('selling_price').value = newPrice.toFixed(2);
        // Disable tax checkboxes
        taxCheckbox.disabled = true;
        showTaxCheckbox.disabled = true;
        taxLabel.style.color = '#FF6900';
    } else {
        var originalPrice = sellingPrice / (1 + serviceCharge);
        document.getElementById('selling_price').value = originalPrice.toFixed(2);
        // Enable tax checkboxes
        taxCheckbox.disabled = false;
        showTaxCheckbox.disabled = false;
        taxLabel.style.color = '';
    }
});
var otherCharge = 0.02;
otherCharges.addEventListener('change', function() {
    var sellingPrice = parseFloat(document.getElementById('selling_price').value);
    
    if (this.checked) {
        var otherChargeFee = sellingPrice * otherCharge
        var newPrice = sellingPrice + otherChargeFee;
        document.getElementById('selling_price').value = newPrice.toFixed(2);
        taxCheckbox.disabled = true;
        showTaxCheckbox.disabled = true;
        service.disabled = true
        taxLabel.style.color = '#FF6900';
        serviceLabel.style.color = '#FF6900';
    } else {
        var originalPrice = sellingPrice / (1 + otherCharge);
        document.getElementById('selling_price').value = originalPrice.toFixed(2);
        service.disabled = false
        serviceLabel.style.color = '';
        if(!service.checked){
          taxCheckbox.disabled = false;
          showTaxCheckbox.disabled = false;
        }
        
        
       
    }
});

  function calculateSellingPrice() {
    var multipleToggle = document.getElementById('multipleToggle'); 
    var cost = parseFloat($('#cost').val());
    var markup = parseFloat($('#markup').val());
    if (!isNaN(cost) && !isNaN(markup)) {
      var sellingPrice = (cost + (cost * markup / 100)).toFixed(2);
      $('#selling_price').val(sellingPrice);
      multipleToggle.disabled = false; 
    } else {
      $('#selling_price').val('');
      multipleToggle.disabled = true; 
    }
  }

  function calculateMarkup() {
    var cost = parseFloat($('#cost').val());
    var sellingPrice = parseFloat($('#selling_price').val());
    if (!isNaN(cost) && !isNaN(sellingPrice) && cost !== 0) {
      var markup = (((sellingPrice - cost) / cost) * 100).toFixed(2);
      $('#markup').val(markup);
    }else{
      $('#markup').val('');
    }
  }

  function calculateCost() {
    var sellingPrice = parseFloat($('#selling_price').val());
    var markup = parseFloat($('#markup').val());
    if (!isNaN(sellingPrice) && !isNaN(markup) && markup !== 0) {
      var cost = (sellingPrice / (1 + (markup / 100))).toFixed(2);
      $('#cost').val(cost);
    } else {
      $('#cost').val('');
    }
  }
  function handleInputChange() {
    if(taxCheckbox.checked === true){
      showTaxCheckbox.checked = true; 
    
    }
    service.checked = false;
    otherCharges.checked = false;
    taxCheckbox.disabled = false;
    showTaxCheckbox.disabled = false;
    service.disabled = false
    serviceLabel.style.color = '';
   
  }

});


</script>

