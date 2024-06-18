<style>

#add_customer_modal {
  display: none;
  position: fixed; 
  z-index: 2000;
  top: 0;
  bottom: 0;
  left: calc(100% - 500px); 
  width: 500px;
  background-color: transparent;
  overflow: hidden;
  height: 100vh; 
  animation: slideInRight 0.5s; 
}

.customer-modal {
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

.button-container {
  position: absolute;
  bottom: 20px; 
  left: 270px; 
}

.switchType {
  position: relative;
  display: inline-block;
  width: 40px; 
  height: 20px; 
  outline: none;
}

.switchType input {
  opacity: 0;
  width: 0;
  height: 0;
}

.sliderType {
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


.sliderType:before {
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

input:checked + .sliderType {
  background-color: #00CC00;
}

input:focus + .sliderType {
  box-shadow: 0 0 1px #262626;
}

input:checked + .sliderType:before {
  -webkit-transform: translateX(20px); 
  -ms-transform: translateX(20px);
  transform: translateX(20px); 
}

.sliderType.round {
  border-radius: 10px; 
}

.sliderType.round:before {
  border-radius: 50%; 
}
.sliderType.active {
  background-color: #00CC00;
}

/* new */

.switchTax {
  position: relative;
  display: inline-block;
  width: 40px; 
  height: 20px; 
  outline: none;
}

.switchTax input {
  opacity: 0;
  width: 0;
  height: 0;
}

.sliderTax {
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


.sliderTax:before {
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

input:checked + .sliderTax {
  background-color: #00CC00;
}

input:focus + .sliderTax {
  box-shadow: 0 0 1px #262626;
}

input:checked + .sliderTax:before {
  -webkit-transform: translateX(20px); 
  -ms-transform: translateX(20px);
  transform: translateX(20px); 
}

.sliderTax.round {
  border-radius: 10px; 
}

.sliderTax.round:before {
  border-radius: 50%; 
}
.sliderTax.active {
  background-color: #00CC00;
}

.suppliedProductsCard {
    border: 1px solid #ffff; 
    box-sizing: border-box; 
    border-radius: 20px;
    height: 30vh;
    position: absolute;
    margin-top: 3vh;
    right: 20px;
    left: 20px;
    border-color: #595959;
    background-color: #404040;
    width: 92%;
    
}
.btns-bom{
  font-size: 12px;
  font-family: Century Gothic;
  border-radius: 5px;
  outline: 0;
  background-color: #404040;
  border-color: #595959;

}
.btns-bom:hover{
  background-color: #FF6900;
  outline: 0;
}
.btnDiv{
  margin: 0;
  padding: 0;
}




/* .supplied-product-table::-webkit-scrollbar {
  width: 8px;
 
}

.supplied-product-table::-webkit-scrollbar-track {
  background: #151515;
}

.supplied-product-table::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 3px;
}

.supplied-product-table::-webkit-scrollbar-thumb:hover {
  background: #555;
}

/* new */
.supplied-ingredients-table::-webkit-scrollbar {
  width: 8px;
 
}

.supplied-ingredients-table::-webkit-scrollbar-track {
  background: #151515;
}

.supplied-ingredients-table::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 3px;
}

.supplied-ingredients-table::-webkit-scrollbar-thumb:hover {
  background: #555;
} 

.address{
    background-color: transparent;
    border-color: #888;
    color: #fefefe;
    width: 460px;
    height: 120px;
}

</style>

<div class="modal" id="add_customer_modal" tabindex="0">
  <div class="modal-dialog ">
    <div class="modal-content customer-modal">
      <div class="modal-title">
        <div style="margin-top: 30px; margin-left: 20px">
           <h2 class="text-custom modalHeaderTxt" id="modalHeaderTxt" style="color:#FF6900;">Add New Customer</h2>
        </div>
        <div class="warning-container">
        <div style="margin-left: 20px;margin-right: 20px;margin-top: 20px">
        <input class="custom-input" readonly hidden name="customerid" id="customerid" style="width: 180px"/>
        <input class="custom-input" readonly hidden name="userid" id="userid" style="width: 180px"/>
            <table id="addCustomer" class="text-color table-border"> 
                <tbody>
                    <tr>
                        <td class="firstNameLbl td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">First Name<sup>*</sup></td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input id="firstName"/></td>
                    </tr>
                    <tr>
                        <td class="lastNameLbl td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Last Name<sup>*</sup></td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input id="lastName"/></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Contact</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input id="customerContact"/></td>
                    </tr>
                     <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Email</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input type="email" id="customerEmail"/></td>
                    </tr>
                    <tr>
                        <td id="statusSupplier" class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Type</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px">
                        <?php
                            $status = 'Active'; 
                            $opposite_status = ($status == 'Active') ? 'Inactive' : 'Active';
                            ?>
                            <label class="switchType" style="margin-left: 5px">
                                <input readonly type="checkbox" id="customerType"<?php if($status == 'Active')?> >
                                <span class="sliderType round"></span>
                            </label>&nbsp;<span style="font-style:italic">Enable for Employee Type</span></td>
                    </tr>
                    <tr>
                        <td id="customerTypeLbl" class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Customer Code</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input id="c_code"/></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">PWD/SC TIN</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input id="c_tin" /></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">PWD/SC ID</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input id="c_id"/></td>
                    </tr>
                    <tr hidden>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">PRICE LIST</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input  readonly/></td>
                    </tr>
                    <tr hidden>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Discounts</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input readonly /></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">DUE DATE(Days)</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input type="number" id="dueDate" step="1" min="0" max="99999999"  onkeydown="return event.keyCode !== 190;"  oninput="validity.valid||(value='');"/></td>
                    </tr>
                    <tr hidden>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Loyalty Cards</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input readonly /></td>
                    </tr>
                   <tr>
                        <td id="statusSupplier" class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Tax Exempt</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px">
                        <?php
                  $status = 'Active'; 
                  $opposite_status = ($status == 'Active') ? 'Inactive' : 'Active';
                  ?>
                  <label class="switchTax" style="margin-left: 5px">
                      <input readonly type="checkbox" id="taxExempt"<?php if($status == 'Active')?> >
                      <span class="sliderTax round"></span>
                  </label></td>
                    </tr>
              </tbody>
            </table>
          </div>
          <div style="margin-top: 10px; margin-left: 20px">
            <label class="text-custom">Address</label><br>
            <textarea id="address" class="address"></textarea>
          </div>
           <div class="button-container" style="display:flex;justify-content: right;">
              <button onclick="addCustomer()" class="btn-success-custom saveCustomerBtn" style="margin-right: 10px; width: 100px; height: 40px">Save</button>
              <button hidden onclick="updateCustomer()" class="btn-success-custom updateCustomerBtn" style="margin-right: 10px; width: 100px; height: 40px">Update</button>
              <button onclick="closeAddingModal()" class="cancelAddCustomer btn-error-custom" style="margin-right: 20px;width: 100px; height: 40px">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>

function closeAddingModal(){
  $('.highlighteds').removeClass('highlighteds');
    $('#add_customer_modal').css('animation', 'slideOutRight 0.5s forwards');
    $('.customer-modal').css('animation', 'slideOutRight 0.5s forwards');
    $('#add_customer_modal').one('animationend', function() {
        $(this).hide();
        $(this).css('animation', '');
        $('.customer-modal').css('animation', '');
        clearFields()
    });

}



function clearFields(){
 
    document.getElementById('firstName').value="";
    document.getElementById('firstName').value = "";
    document.getElementById('customerContact').value = "";
    document.getElementById('customerEmail').value = "";
    document.getElementById('c_code').value = "";
    document.getElementById('c_id').value = "";
    document.getElementById('c_tin').value = "";
    document.getElementById('dueDate').value = "";
    document.getElementById('address').value = "";


    var uptBtn = document.querySelector('.updateCustomerBtn');
    uptBtn.setAttribute('hidden',true);
    var saveBtn = document.querySelector('.saveCustomerBtn');
    saveBtn.removeAttribute('hidden');
}

document.getElementById("customerType").addEventListener('change', function() {
        var customerTypeLbl = document.getElementById("customerTypeLbl");
        if (this.checked) {
            customerTypeLbl.innerText = "Employee ID";
        } else {
            customerTypeLbl.innerText = "Customer Code";
        }
    });
document.getElementById('firstName').addEventListener('input', function(){
    var customerName = this.value;
        var customerNameTd = document.querySelector(".firstNameLbl");
        if (customerName == '') {
            customerNameTd.style.color = 'red';
        } else {
            customerNameTd.style.color = ''; 
        }

})
document.getElementById('lastName').addEventListener('input', function(){
    var lastName = this.value;
        var lastNameTd = document.querySelector(".lastNameLbl");
        if (lastName == '') {
            lastNameTd.style.color = 'red';
        } else {
            lastNameTd.style.color = ''; 
        }

})

function addCustomer(){
   var firstname = document.getElementById('firstName').value;
   var lastname    =   document.getElementById('lastName').value;
   var customercontact = document.getElementById('customerContact').value;
   var customeremail = document.getElementById('customerEmail').value;
   var code = document.getElementById('c_code').value;
   var pwdOrSCid = document.getElementById('c_id').value;
   var tin = document.getElementById('c_tin').value;
   var due = document.getElementById('dueDate').value;
   var firstNameTd = document.querySelector(".firstNameLbl");
   var lastNameTd = document.querySelector(".lastNameLbl");
   var type = document.getElementById('customerType').checked ? 1 : 0;
   var taxExempt = document.getElementById('taxExempt').checked ? 1 : 0;
   var address = document.getElementById('address').value;

        if (firstname == '') {
            firstNameTd.style.color = 'red';
        } else {
            firstNameTd.style.color = ''; 
        }

        if(lastname == '' ){
            lastNameTd.style.color = 'red';
        }else{
            lastNameTd.style.color = ''; 
        }

   if(firstname){
        var formData = new FormData();
        formData.append("firstName", firstname);
        formData.append("lastName", lastname);
        formData.append("customercontact", customercontact);
        formData.append("customeremail",customeremail);
        formData.append("code",code);
        formData.append("pwdOrSCid",pwdOrSCid);
        formData.append("tin",tin);
        formData.append("tin",tin);
        formData.append("due",due);
        formData.append("type", type);
        formData.append("taxExempt", taxExempt);
        formData.append("address", address);

        axios.post('api.php?action=addCustomer', formData).then(function(response){
               closeAddingModal()
               refreshCustomerTable()
            }).catch(function(error){
            console.log("error")
            })
   }
}

function  toUpdateCustomer(userId,customerId,firstName,lastName,contact,code,type, email,address,pwdID,pwdTIN,dueDate,taxExempt){
  $('#add_customer_modal').show()
  if($('#add_customer_modal').is(":visible")){
    userId ? document.getElementById('userid').value = userId  : null;
    customerId ? document.getElementById('customerid').value = customerId  : null;
    firstName ? document.getElementById('firstName').value = firstName  : null;
    lastName ? document.getElementById('lastName').value = lastName  : null;
    contact ? document.getElementById('customerContact').value = contact  : null;
    email ?  document.getElementById('customerEmail').value = email  : null;
    code ? document.getElementById('c_code').value = code  : null;
    address ? document.getElementById('address').value = address  : null;
    pwdID ? document.getElementById('c_id').value = pwdID  : null;
    pwdTIN ? document.getElementById('c_tin').value = pwdTIN  : null;
    dueDate ? document.getElementById('dueDate').value = dueDate  : null;

    var typeCheckbox = document.getElementById('customerType');
          typeCheckbox.checked  = (type == 1) ? true: false;
          var customerTypeLbl = document.getElementById("customerTypeLbl");
         if(typeCheckbox.checked ){
          customerTypeLbl.innerText = "Employee ID";
         }else{
          customerTypeLbl.innerText = "Customer Code";
         }

  var taxExempts = document.getElementById('taxExempt');
     taxExempts.checked = (taxExempt == 1) ? true: false;

    
     
     var uptBtn = document.querySelector('.updateCustomerBtn');
     var saveBtn = document.querySelector('.saveCustomerBtn');
     userId? (uptBtn.removeAttribute('hidden'), saveBtn.setAttribute('hidden', true)) : (uptBtn.setAttribute('hidden', true), saveBtn.removeAttribute('hidden'));
  }
}
function updateCustomer(){
   var userId = document.getElementById('userid').value;
   var customerId = document.getElementById('customerid').value;
   var firstname = document.getElementById('firstName').value;
   var lastname    =   document.getElementById('lastName').value;
   var customercontact = document.getElementById('customerContact').value;
   var customeremail = document.getElementById('customerEmail').value;
   var code = document.getElementById('c_code').value;
   var pwdOrSCid = document.getElementById('c_id').value;
   var tin = document.getElementById('c_tin').value;
   var due = document.getElementById('dueDate').value;
   var firstNameTd = document.querySelector(".firstNameLbl");
   var lastNameTd = document.querySelector(".lastNameLbl");
   var type = document.getElementById('customerType').checked ? 1 : 0;
   var taxExempt = document.getElementById('taxExempt').checked ? 1 : 0;
   var address = document.getElementById('address').value;

        if (firstname == '') {
            firstNameTd.style.color = 'red';
        } else {
            firstNameTd.style.color = ''; 
        }

        if(lastname == '' ){
            lastNameTd.style.color = 'red';
        }else{
            lastNameTd.style.color = ''; 
        }

   if(firstname){
        var formData = new FormData();
        formData.append("customerId", customerId);
        formData.append("userId",  userId);
        formData.append("firstName", firstname);
        formData.append("lastName", lastname);
        formData.append("customercontact", customercontact);
        formData.append("customeremail",customeremail);
        formData.append("code",code);
        formData.append("pwdOrSCid",pwdOrSCid);
        formData.append("tin",tin);
        formData.append("tin",tin);
        formData.append("due",due);
        formData.append("type", type);
        formData.append("taxExempt", taxExempt);
        formData.append("address", address);

        axios.post('api.php?action=updateCustomer', formData).then(function(response){
          console.log(response)
               closeAddingModal()
               refreshCustomerTable()
            }).catch(function(error){
            console.log("error")
            })
   }


}
</script>

 