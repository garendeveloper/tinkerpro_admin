<style>

#add_expense_modal {
  display: none;
  position: fixed; 
  top: 0;
  top: 0;
  bottom: 0;
  left: calc(100% - 500px); 
  width: 500px;
   background-color: transparent;
  overflow: hidden;
  animation: slideInRight 0.5s; 
}


.expense_content {
  background-color: #fefefe;
  margin: 0 auto; 
  border: none;
  width: 100%;
  height: 100vh; 
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
    height: 100%;
    margin-top: 15px;
    margin-bottom: 15px;
    
    
}



@media (max-width: 768px) {
    .modal {
        left: 0;
        width: 100%;
        max-width: 100%; 
    }
    
    /* var(--primary-color); */
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
.imageExpense{
    border:1px solid #ffff; 
    box-sizing: border-box; 
    border-radius: 0;
    margin-right: 20px;
    margin-left:20px;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 200px;
}
.bomCard {
    border: 1px solid #ffff; 
    box-sizing: border-box; 
    height: 200px;
    margin-right: 20px;
    border-color: #595959;
}
.btnCustom{
  font-size: 11px;
  font-family: Century Gothic;
  color:var(--primary-color);
  border-radius: 5px;
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
  background-color: var(--primary-color);
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
  background-color: var(--primary-color);
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
  background-color: var(--primary-color);
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
  background-color: var(--primary-color);
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
  background-color: var(--primary-color);
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
  background-color: var(--primary-color);
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
  background-color: var(--primary-color);
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
  background-color: var(--primary-color);
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
  background-color: var(--primary-color);
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
  background-color: var(--primary-color);
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
  background-color: var(--primary-color);
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
  background-color: var(--primary-color);
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
  background-color: var(--primary-color);
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
  background-color: var(--primary-color);
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
  background-color: var(--primary-color);
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
  background-color: var(--primary-color);
}

/* new */
.dropdown {
    position: relative;
    display: inline-block;
    
  }

  /* .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    z-index: 9999;
    overflow-y: auto;
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
    overflow-y: auto;
  }
  

  .dropdown-content a:hover {
    background-color: #ddd;
  } */
  .dropdown-content {
    display: none;
    position: absolute; 
    background-color: #262626;
    min-width: 160px;
    max-height: 200px; 
    overflow-y: auto; 
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    z-index: 9999;
  }

.dropdown-content a {
  display: block;
  width: 100%;
  padding: 10px;
  min-width: 210px;
  border: none;
  background-color: #262626;
  color: #f9f9f9;
  text-decoration: none;
  padding-top: 0;
  padding-bottom: 0;
  margin-top: 0;
  margin-bottom: 0;
}

.dropdown-content a:hover {
  background-color: #ddd;
  color: #000000;
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

/* #uom_dropdown {
    display: none;
    position: absolute;
    background-color: #262626;
    min-width: 160px;
    color: #f9f9f9;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    z-index: 1;
    top: 25px; 
    left: 82px; 
    
} */
.dropdown-content{
  display: none;
    position: absolute;
    background-color: #262626;
    color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    z-index: 5;
    top: 25px; 
    left: 82px; 
    overflow-y: auto;
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
  background-color: var(--primary-color);
  color: #fefefe;
}
.btnCustom:hover {
    background-color: var(--primary-color);
    color: #fefefe;

}
.addCategory{
  color: #E46C0A;
  border-radius: 5px;
  background-color: #404040;
  border-color: #595959;
}
.addCategory:hover{
  background-color: var(--primary-color);
  color: #fefefe;
         
}.button-container {
  display:flex;
  padding-top: 5px;
  margin: 0;
  bottom: 0;
  right:0;
  margin-bottom: 0px;

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
  background-color: var(--primary-color);
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
.table-containers {
  display: flex;
  max-height: 80px; 
  overflow-y: scroll;
  background-color: transparent;
  max-width: 500px;
  padding-right: 20px;
  margin-bottom: 5px;
}


.table-containers::-webkit-scrollbar {
  width: 6px;
 
}

.table-containers::-webkit-scrollbar-track {
  background: #262626;
}

.table-containers::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 3px;
}

.table-containers::-webkit-scrollbar-thumb:hover {
  background: #555;
}

/* new */

.taxExlusive {
  position: relative;
  display: inline-block;
  width: 40px; 
  height: 20px; 
  outline: none; 
}

.taxExlusive input {
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
  background-color: var(--primary-color);
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
  background-color: var(--primary-color);
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
  background-color: var(--primary-color);
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
  background-color: var(--primary-color);
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
  background-color: var(--primary-color);
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
  background-color: var(--primary-color);
}
/* new */

.vatableTax {
  position: relative;
  display: inline-block;
  width: 40px; 
  height: 20px; 
  outline: none; 
}

.vatableTax input {
  opacity: 0;
  width: 0;
  height: 0;
}

.warningSpan {
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

.warningSpan:before {
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

input:checked + .warningSpan {
  background-color: var(--primary-color);
}

input:focus + .warningSpan {
  box-shadow: 0 0 1px #262626;
}

input:checked + .warningSpan:before {
  -webkit-transform: translateX(20px); 
  -ms-transform: translateX(20px);
  transform: translateX(20px); 
}

.warningSpan.round {
  border-radius: 10px; 
}

.warningSpan.round:before {
  border-radius: 50%; 
}

.warningSpan.active {
  background-color: var(--primary-color);
}

.imageButtonDiv{
  display: flex;
  margin-top: -50px;

}
#scrollable-div {
  overflow-y: auto; 
  overflow-x: hidden; 
  min-height: 25vh;
  max-height: 38vh;
}
.item_description{
    background-color: transparent;
    border-color: #888;
    color: #fefefe;
    width: 460px;
    height: 120px;
}

.show {
  display: block;
  overflow: auto;
}
.form-error{
  border: 1px solid red;
}
.slideOutRight {
    animation: slideOutRightss 0.5s forwards;
  }
  #uomType::placeholder {
    color: var(--primary-color);
    font-family: Century Gothic;
    font-weight: normal;
    font-style: italic;
}
.picture-button-container {
    display: flex;
    flex-direction: column;
}

.cancelAddProducts {
    width: 200px;
    height: 40px;
    margin-bottom: 10px; /* Adjust the spacing between buttons */
}
label{
  font-family: Century Gothic;
}
.text-custom{
  font-family: Century Gothic;
}
#remove_image:hover{
  background-color: red;
}

.flatpickr-innerContainer, .flatpickr-months{
  background-color: #262626 !important;
}
.flatpickr-calendar{
  background-color: #262626 !important;;
  width:  fit-content !important;;
}

</style>
