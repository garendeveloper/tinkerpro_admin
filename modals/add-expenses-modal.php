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
</style>

<div class="modal" id="add_expense_modal" tabindex="0">
  <div class="modal-dialog ">
    <div class="modal-content expense_content">
      <!-- <div id="scrollable-data"> -->
      <div class="modal-title">
        <div style="margin-top: 30px; margin-left: 20px">
           <h5 class="text-custom modalHeaderTxt" id="modalHeaderTxt" style="color: var(--primary-color)">EXPENSES</h5>
        </div>
        <form id = "expense_form" enctype="multipart/form-data">
        <div class="warning-container">
          <div class="tableCard">
          <div style="margin-left: 20px;margin-right: 20px">
            <table id="tbl_createExpense" class="text-color table-border" > 
              <input type="hidden" name = "expense_id" id = "expense_id" value = "">
                <tbody>
                    <tr>
                        <td class="nameTd td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Item Name<sup>*</sup></td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input class="productname" id="item_name" oninput = "$(this).closest('td').removeClass('form-error')" name="item_name" autocomplete="off" autofocus/></td>
                    </tr>
                    <tr>
                        <td  class="skuTd td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Date(MM-DD-YYYY)</td>
                        <td class="td-height text-custom"style="font-size: 12px; height: 10px:"><input id="date_of_transaction" type = "date" name="date_of_transaction" oninput = "$(this).closest('td').removeClass('form-error')" autocomplete="off"/></td>
                    </tr>
                    <tr>
                        <td class="codeTd td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Billable (Receipt No.)</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input id="billable_receipt_no" name="billable_receipt_no" oninput = "$(this).closest('td').removeClass('form-error')" autocomplete="off"/></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Type</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><div class="dropdown custom-input" >
                            <input class="custom-input" placeholder = "Search Expense Type" name="expense_type" id="expense_type"  style="width: 259px" autocomplete="off"/>
                            <button type = "button"  id="btn_expense_type" class="custom-btn dropdown_btn">
                            <svg width="13px" height="13px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                <path d="M19 5L12.7071 11.2929C12.3166 11.6834 11.6834 11.6834 11.2929 11.2929L5 5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M19 13L12.7071 19.2929C12.3166 19.6834 11.6834 19.6834 11.2929 19.2929L5 13" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                            </button>
                            <div class="dropdown-content" id="expense_type_dropdown" >
                                <a href="#" data-value="rent">Rent</a>
                                <a href="#" data-value="utilities">Utilities</a>
                                <a href="#" data-value="salaries wages">Salaries and Wages</a>
                                <a href="#" data-value="maintenance repairs">Maintenance and Repairs</a>
                                <a href="#" data-value="promotions">Promotions</a>
                                <a href="#" data-value="advertising">Advertising</a>
                                <a href="#" data-value="public relations">Public Relations</a>
                                <a href="#" data-value="office supplies">Office Supplies</a>
                                <a href="#" data-value="professional services">Professional Services</a>
                                <a href="#" data-value="software subsciptions">Software Subscriptions</a>
                                <a href="#" data-value="interest">Interest</a>
                                <a href="#" data-value="bank fees">Bank Fees</a>
                                <a href="#" data-value="insurance">Insurance</a>
                                <a href="#" data-value="travel expenses">Travel Expenses</a>
                                <a href="#" data-value="client entertainment">Client Entertainment</a>
                                <a href="#" data-value="taxes">Taxes</a>
                                <a href="#" data-value="income tax">Income Tax</a>
                                <a href="#" data-value="Property Tax">Property Tax</a>
                                <a href="#" data-value="depreciation">Depreciation</a>
                                <a href="#" data-value="amortization">Amortization</a>
                                <a href="#" data-value="miscellaneous">Miscellaneous</a>
                                <a href="#" data-value="charitable donations">Charitable Donations</a>
                                <a href="#" data-value="employee training">Employee Training</a>
                                <a href="#" data-value="unplanned expenses">Unplanned Expenses / Others</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Quantity</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><div class="dropdown custom-input">
                            <input class="custom-input" name="qty" id="qty" style="width: 125px" oninput = "$(this).removeClass('form-error')" autocomplete="off"/>
                            <input class="custom-input" readonly hidden name="uomID" id="uomID" style="width: 125px"/>
                            <input class="custom-input"  name="uomType" id="uomType" placeholder = "Unit of Measure" style="width: 126px" autocomplete="off"/>
                            <button type  ="button" name="uomBtn" id="uomBtn" class="custom-btn">
                            <svg width="13px" height="13px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                <path d="M19 5L12.7071 11.2929C12.3166 11.6834 11.6834 11.6834 11.2929 11.2929L5 5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M19 13L12.7071 19.2929C12.3166 19.6834 11.6834 19.6834 11.2929 19.2929L5 13" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                            </button>
                            <div class="dropdown-content uom_dropdown" >
                            <?php
                                 $productFacade = new ProductFacade;
                                 $uom = $productFacade->getUOM();
                                while ($row =  $uom->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<a href="#" style=" text-decoration: none;" data-value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['uom_name']) . '</a>';
                                }
                                ?>
                            </div>
                          </td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Supplier</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><div class="dropdown custom-input">
                            <input class="custom-input" hidden readonly name="supplier_id" id="supplier_id" style="width: 259px" />
                            <input class="custom-input" placeholder = "Search Supplier" name="supplier" id="supplier" style="width: 259px " autocomplete="off"/>
                            <button type = "button" name="btn_supplier" id="btn_supplier" class="custom-btn">
                            <svg width="13px" height="13px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                <path d="M19 5L12.7071 11.2929C12.3166 11.6834 11.6834 11.6834 11.2929 11.2929L5 5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M19 13L12.7071 19.2929C12.3166 19.6834 11.6834 19.6834 11.2929 19.2929L5 13" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                            </button>
                            <div class="dropdown-content" id="supplier_dropdown">
                            <?php
                                 $supplierFacade = new SupplierFacade;
                                 $suppliers = $supplierFacade->get_allSuppliers();
                                while ($row =  $suppliers->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<a href="#" style=" text-decoration: none;" data-value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['supplier']) . '</a>';
                                }
                                ?>
                            </div></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Invoice Number</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input class="brand" name="invoice_number" id="invoice_number" oninput = "$(this).closest('td').removeClass('form-error')"  autocomplete="off"/></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Price (Php)</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input class="brand" name="price" id="price" oninput = "$(this).closest('td').removeClass('form-error')" autocomplete="off"/></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Discount</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px;"><input class="brand" name="discount" id="discount" autocomplete="off"/></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Total Amount (Php)</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px;"><input class="brand" name="total_amount" id="total_amount" readonly autocomplete="off"/></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px">Is Tax Exlusive?&nbsp;&nbsp;&nbsp;
                          <label class="taxExlusive" style="margin-left: 5px">
                              <input type="checkbox" id="toggleTaxIn">
                              <span class="warrantySpan round"></span>
                          </label>
                      </td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px; font-style:italic; color: #B2B2B2">
                          <input type="hidden" id = "isVatable" name = "isVatable" value = "0">
                          <input type="text"value = "0" class="vatable_amount" id="vatable_amount" name = "vatable_amount" style="width: 80px" placeholder="Gross Amount (Inclusive of VAT):" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); if(this.value.includes('-')) this.value = this.value.replace('-', ''); if(this.value.includes('.')) { let parts = this.value.split('.'); this.value = parts[0] + '.' + parts.slice(1).join('').slice(0, 2); }" maxlength="10" readonly/>
                        </td>
                    </tr>
            </table>
          </div>
          <div style="margin-top: 10px; margin-left: 20px">
            <label class="text-custom"  style="color:var(--primary-color);">Description</label><br>
            <textarea id="description" name = "description" class="item_description"></textarea>
          </div>
          <div id="scrollable-div">
              <div class="imageCard">
                  <div  style="width:180px; display: flex; flex-direction: column; justify-content: center; align-items: center; border: 2px solid gray; background-color: #151515" class="imageExpense" id="imageExpense">
                      <img src="./assets/img/invoice.png" id= "imagePreview" alt="Image Preview" style = "width: 175px; height: 195px"></img>
                      <p style = "color: red; font-size: 0.80rem" id = "dd_r">Drag or Drop your Receipt</p>
                   </div>   
                   <input type="file" hidden id = "image-input" accept="image/*" name = "image_url">
                   <div class="picture-button-container">
                      <button class="cancelAddProducts " type = "button" id = "open_image" style="margin-right: 10px; width: 200px; height: 40px"><i class = 'bi bi-images'></i>&nbsp; Browse Picture</button>
                      <button class="cancelAddProducts " type = "button" id = "remove_image" style="margin-right: 20px;width: 200px; height: 40px"><i class = 'bi bi-trash'></i>&nbsp; Remove Picture</button>
                    </div>
               </div>
              </div>
              <div style = "margin-left: 20px">
                <p id = "expense_errorMessages" style = "color: red">  
              </div>
            <div class="button-container" style="display:flex;justify-content: space-between; position:absolute; ">
              <button  type = "button" class="btn-success-custom btn-error-custom" id = "btn_cancelExpense" style="margin-right: 10px; width: 100px; height: 40px">CANCEL</button>
              <button  class="btn-success-custom saveProductsBtn" type = "submit" style="margin-right: 10px; width: 100px; height: 40px">SAVE</button>
            </div>
          </div>
          </div>
          </form>
        </div>
      </div>
    </div>
 
    </div>
  </div>
<!-- </div> -->
<script>

$(document).ready(function(){
  const TAX_RATE = 0.12; // define a constant for the tax rate
  $(window).on("click", function(event) {
    if (!$(event.target).hasClass("custom-btn") && !$(event.target).closest('.dropdown-content').length) {
      $(".dropdown-content").each(function() {
        if ($(this).hasClass("show")) {
          $(this).removeClass("show");
        }
      });
    }
  });
  // var current_totalAmount = $("#total_amount").val();
  // computeInclusive(current_totalAmount);

  function hide_dropdown()
  {
    $(".dropdown-content").each(function() {
      if ($(this).hasClass("show")) {
        $(this).removeClass("show");
      }
    });
  }
  
  

  $("#btn_expense_type").on("click", function(event) {
    event.stopPropagation();
    hide_dropdown();
    $("#expense_type_dropdown").toggleClass("show");
  });

  $("#expense_type_dropdown a").on("click", function(event) {
    event.preventDefault();
    $(this).closest('td').removeClass('form-error');
    var value = $(this).data("value");
    var roleName = $(this).text();
    $("#expense_type").val(roleName);
    $("#expense_type_dropdown").removeClass("show")
  });
  $('#expense_type').on('keyup', function() {
      var searchText = $(this).val().toLowerCase();
      $('#expense_type_dropdown a').each(function() {
          var linkText = $(this).text().toLowerCase();
          if (linkText.includes(searchText)) {
            $("#expense_type_dropdown").toggleClass("show");
            $(this).show();
            $(this).closest("td").removeClass('form-error');
          } else {
              $(this).hide();
              $(this).closest("td").addClass('form-error');
          }
      });
  });
  $('#expense_type').on('input', function() {
      if ($(this).val().trim() === '') {
          $('#expense_type_dropdown a').show();
      }
  });

  $("#uomBtn").on("click", function(event) {
    event.stopPropagation();
    hide_dropdown();
    $(".uom_dropdown").toggleClass("show");
  });

  $(".uom_dropdown a").on("click", function(event) {
    event.preventDefault();
    var value = $(this).data("value");
    var roleName = $(this).text();
    $("#uomID").val(value); 
    $("#uomType").val(roleName);
    $(".uom_dropdown").removeClass("show")
  });
  $('#uomType').on('keyup', function() {
    var inputField = $("#uomType");
    var searchText = inputField.val().toLowerCase();
    var foundMatch = false; 

    $('.uom_dropdown a').each(function() {
        var linkText = $(this).text().toLowerCase();
        
        if (linkText.includes(searchText)) {
            $(".uom_dropdown").addClass("show");
            $(this).show();
            foundMatch = true;
        } else {
            $(this).hide();
        }
    });
    if (foundMatch) {
      $(this).closest("td").removeClass('form-error');
    } else {
      $(this).closest("td").addClass('form-error');
    }
  });
  $('#uomType').on('input', function() {
      if ($(this).val().trim() === '') {
          $('.uom_dropdown a').show();
      }
  });

  $("#btn_supplier").on("click", function(event) {
    event.stopPropagation();
    hide_dropdown();
    $("#supplier_dropdown").toggleClass("show");
  });

  $("#supplier_dropdown a").on("click", function(event) {
    event.preventDefault();
    var value = $(this).data("value");
    var roleName = $(this).text();
    $("#supplier_id").val(value); 
    $("#supplier").val(roleName);
    $("#supplier_dropdown").removeClass("show")
  });
  $('#supplier').on('keyup', function() {
      var searchText = $(this).val().toLowerCase();
      var foundMatch = false;
      $('#supplier_dropdown a').each(function() {
          var linkText = $(this).text().toLowerCase();
          if (linkText.includes(searchText)) {
            $("#supplier_dropdown").toggleClass("show");
            $(this).show();
            foundMatch = true;
          } else {
              $(this).hide();
          }
      });
      if (foundMatch) {
        $(this).closest("td").removeClass('form-error');
      } else {
        $(this).closest("td").addClass('form-error');
      }
  });
  $('#supplier').on('input', function() {
      if ($(this).val().trim() === '') {
          $('#supplier_dropdown a').show();
      }
  });


  $("#date_of_transaction").prop("readonly", true).flatpickr({
    dateFormat: "m-d-Y",
    onClose: function(selectedDates) {
    }
  });

  $("#qty, #price, #discount").on("input", function() {
    var price = parseFloat($("#price").val()) || 0;
    var qty = parseFloat($("#qty").val()) || 0;
    var discount = parseFloat($("#discount").val()) || 0;
    
    var total_amount = (qty * price) - discount;
    $("#total_amount").val(total_amount.toFixed(2));

    if ($("#toggleTaxIn").is(":checked")) {
      computeTax(total_amount);
    }
    else
    {
      computeInclusive(total_amount);
    }
  });
  $("#toggleTaxIn").on("change", function(){
    var total_amount = $("#total_amount").val();
    if($(this).is(":checked"))
    {
      computeTax(total_amount);
      $("#isVatable").val("1");
    }
    else
    {
      $("#isVatable").val("0");
      computeInclusive(total_amount);
    }
  })
  function computeTax(amount)
  {
    var currentAmount = parseFloat(amount);
    var tax_amount = parseFloat(amount / 1.12);
    var tax = parseFloat(tax_amount * 0.12);
    var vatable_amount = parseFloat(currentAmount + tax);
    $("#vatable_amount").val(vatable_amount.toFixed(2));
  }


// function computeTax(amount) {
//   const taxAmount = amount / (1 + TAX_RATE);
//   const tax = taxAmount * TAX_RATE;
//   const vatableAmount = amount + tax;
//   const total = parseFloat()
//   $("#vatable_amount").val(vatableAmount.toFixed(2));
// }
  function computeInclusive(amount)
  {
    var currentAmount = parseFloat(amount);
    var tax_amount = parseFloat(amount / 1.12)
    var tax = parseFloat(tax_amount * 0.12);
    var vatable_amount = parseFloat(currentAmount - tax);
    $("#vatable_amount").val(vatable_amount.toFixed(2));
  }
  $("#price, #discount, #qty").on("input", function() {
    var value = $(this).val();
    var formatted = value.replace(/[^0-9.]/g, '');
    var decimalIndex = formatted.indexOf('.');
    if (decimalIndex !== -1) {
      var decimalPart = formatted.substring(decimalIndex + 1);
      if (decimalPart.length > 2) {
        formatted = formatted.substring(0, decimalIndex + 3);
      }
    }
    $(this).val(formatted);
  });


  $("#total_amount").on("input", function() {
    var input = $(this).val();
    var formatted = input.replace(/[^0-9.]/g, '');
                
    var decimalIndex = formatted.indexOf('.');
    if (decimalIndex !== -1) {
        var decimalPart = formatted.substring(decimalIndex + 1);
        if (decimalPart.length > 2) {
            formatted = formatted.substring(0, decimalIndex + 3);
        }
    }
    $(this).val(formatted);
  });

  $("#open_image").on("click", function() {
    $("#image-input").click();
  });

  $("#image-input").on("change", function() {
    var file = this.files[0];
    $("#dd_r").hide();
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $("#imagePreview").attr("src", e.target.result).show();
        };
        reader.readAsDataURL(file);
    } else {
        $("#imagePreview").hide();
    }
  });
  $("#remove_image").on("click", function() {
    $("#imagePreview").attr("src", "./assets/img/invoice.png").show(); 
    $("#image-input").val(''); 
    $("#dd_r").show();
  });
  $("#btn_cancelExpense").on("click", function(){
    $("#expense_form")[0].reset();
    $("#expense_id").val("");
    hide_modal();
  })
  function hide_modal()
  {
    $("#add_expense_modal").addClass('slideOutRight');
    $(".expense_content").addClass('slideOutRight');
    setTimeout(function () {
      $("#add_expense_modal").removeClass('slideOutRight');
      $("#add_expense_modal").hide();
      $(".expense_content").removeClass('slideOutRight');
      $(".expense_content").hide();
    }, 100);
    $("#searchInput").focus();
  }
 
})

$(document).ready(function() {
  $('#imageExpense').on('dragover', function(e) {
    e.preventDefault();
    $(this).addClass('dragover');
  });

  $('#imageExpense').on('dragleave', function(e) {
    e.preventDefault();
    $(this).removeClass('dragover');
  });

  $('#imageExpense').on('drop', function(e) {
    e.preventDefault();
    $(this).removeClass('dragover');
    var file = e.originalEvent.dataTransfer.files[0];

    if (file.type.match('image.*')) {
      $("#dd_r").hide();
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#imagePreview').attr('src', e.target.result);
      };
      reader.readAsDataURL(file);
      $('#image-input').val(file);
    } else {
      show_errorResponse("Only images are allowed.")
    }
  });
  function show_errorResponse(message) 
  {
    toastr.options = {
      "onShown": function () {
        $('.custom-toast').css({
          "opacity": 1,
          "width": "600px",
          "text-align": "center",
          "border": "2px solid #1E1C11",
        });
      },
      "closeButton": true,
      "positionClass": "toast-top-right",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "progressBar": true,
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut",
      "tapToDismiss": false,
      "toastClass": "custom-toast",
      "onclick": function () { alert('Clicked'); }

    };
    toastr.error(message);
  }
});
</script>

