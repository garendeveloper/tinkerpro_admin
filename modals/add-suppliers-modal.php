<style>

#add_supplier_modal {
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

.supplier-modal {
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

.sliderStatus {
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


.sliderStatus:before {
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

input:checked + .sliderStatus {
  background-color: #00CC00;
}

input:focus + .sliderStatus {
  box-shadow: 0 0 1px #262626;
}

input:checked + .sliderStatus:before {
  -webkit-transform: translateX(20px); 
  -ms-transform: translateX(20px);
  transform: translateX(20px); 
}

.sliderStatus.round {
  border-radius: 10px; 
}

.sliderStatus.round:before {
  border-radius: 50%; 
}
.sliderStatus.active {
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
.suppliedIngredientsCard{
    border: 1px solid #ffff; 
    box-sizing: border-box; 
    border-radius: 20px;
    height: 30vh;
    position: absolute;
    right: 20px;
    left: 20px;
    top: 58vh;
    border-color: #595959;
    background-color: #404040;
    width: 92%;
}

.supplied-product-table td {
        border: none;   
    }
.supplied-ingredients-table td{
  border: none;  
}
  #suppliedTable {
      border-collapse: collapse;
  }
  #suppliedTable {
        border-collapse: collapse;
        border-spacing: 0; 
    }
    
    #suppliedTable td {
        padding: 0;
    }


  #suppliedTableIng {
      border-collapse: collapse;
  }
  #suppliedTableIng {
        border-collapse: collapse;
        border-spacing: 0; 
    }
    
    #suppliedTableIng td {
        padding: 0;
    }

  .supplied-product-table{
    overflow-y: scroll;
    margin-left: 20px;
    margin-right: 20px;
    margin-top: 10px;
    height: 200px;
  }
  .supplied-ingredients-table{
    overflow-y: scroll;
    margin-left: 20px;
    margin-right: 20px;
    margin-top: 10px;
    height: 200px;
  }


.supplied-product-table::-webkit-scrollbar {
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

</style>

<div class="modal" id="add_supplier_modal" tabindex="0">
  <div class="modal-dialog ">
    <div class="modal-content supplier-modal">
      <div class="modal-title">
        <div style="margin-top: 30px; margin-left: 20px">
           <h2 class="text-custom modalHeaderTxt" id="modalHeaderTxt" style="color:#FF6900;">Add New Supplier</h2>
        </div>
        <div class="warning-container">
        <div style="margin-left: 20px;margin-right: 20px;margin-top: 20px">
        <input class="custom-input" readonly hidden name="supplierid" id="supplierid" style="width: 180px"/>
            <table id="addSuppliers" class="text-color table-border"> 
                <tbody>
                    <tr>
                        <td class="supplierLbl td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Supplier Name<sup>*</sup></td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input id="supplierName"/></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Contact</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input id="supplierContact"/></td>
                    </tr>
                     <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Email</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input type="email" id="supplierEmail"/></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Company</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input id="supplierCompany" /></td>
                    </tr>
                    <tr>
                        <td id="statusSupplier" class="td-height text-custom td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Status (Active)</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px">
                        <?php
                  $status = 'Active'; 
                  $opposite_status = ($status == 'Active') ? 'Inactive' : 'Active';
                  ?>
                  <label class="switch" style="margin-left: 5px">
                      <input readonly type="checkbox" id="statusValueSupplier"<?php if($status == 'Active') echo ' checked' ?> onclick="toggleStatusSupplier(this)">
                      <span class="sliderStatus round"></span>
                  </label></td>
                    </tr>
              </tbody>
            </table>
          </div>
          <div hidden  class="suppliedProductsCard">
                      <p class="text-custom" style="margin-left: 20px">Products</p>
                      <div class="btnDiv" style="width: 100%; display: flex; align-items: right; justify-content: right;">
                          <button class="btns-bom" id="addSuppliedProducts" onclick="openProductModal()" style="margin-right: 5px; width: 70px">+ Add</button>
                          <button class="btns-bom" id="delSuppliedProducts" style="margin-right: 20px; width: 70px">- Del</button>
                      </div>
                      <div class="supplied-product-table">
                        <table id="suppliedTable" class="text-color">
                          <tbody>
                            <tr>
                                <td class="counter-cell" style="width:5%" ></td>
                                <td id="suppliedProductCell" style="width:30%"></td>
                            </tr>
                          </tbody>
                        </table>
                </div>
                   </div>   
                   <div hidden  class="suppliedIngredientsCard">
                      <p class="text-custom" style="margin-left: 20px">Ingredients</p>
                      <div class="btnDiv" style="width: 100%; display: flex; align-items: right; justify-content: right;">
                          <button class="btns-bom" id="addSuppliedIngredients" onclick="openIngredientsModal()" style="margin-right: 5px; width: 70px">+ Add</button>
                          <button class="btns-bom" id="delSuppliedIngredients" style="margin-right: 20px; width: 70px">- Del</button>
                      </div>
                      <div class="supplied-ingredients-table">
                        <table id="suppliedTableIng" class="text-color">
                          <tbody>
                            <tr>
                                <td class="counter-cell" style="width:5%" ></td>
                                <td id="suppliedIngredientsCell" style="width:30%"></td>
                            </tr>
                          </tbody>
                        </table>
                </div>
                   </div>   
           <div class="button-container" style="display:flex;justify-content: right;">
                <button onclick="addSupplier()" class="btn-success-custom saveSuppliedBtn" style="margin-right: 10px; width: 100px; height: 40px">Save</button>
                <button hidden onclick=" updateSupplied()" class="btn-success-custom updateSuppliedBtn" style="margin-right: 10px; width: 100px; height: 40px">Update</button>
                <button onclick="closeAddSupplierModal()" class="cancelAddSupplier btn-error-custom" style="margin-right: 20px;width: 100px; height: 40px">Cancel</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

window.addEventListener('beforeunload', function() {
  localStorage.removeItem('suppliedProductData');
  localStorage.removeItem('suppliedIngredientsData');
  localStorage.removeItem('removedItemsProductsStorage');
  localStorage.removeItem('removedItemsIngStorage');
});
function openIngredientsModal() {
    const suppliedIngredientsData = JSON.parse(localStorage.getItem('suppliedIngredientsData')) || [];
    suppliedIngredientsData.forEach((ingredientsId) => {
        const checkbox = document.getElementById(ingredientsId.ingredientsId);
        if (checkbox) {
            checkbox.checked = true;
            checkbox.classList.add('checked');
        }
    });

    $('#suppliedIngredientModal').show();
}
function toggleStatusSupplier(checkbox) {
    var slider = checkbox.parentNode.querySelector('.sliderStatus'); 
    var statusLabel = document.getElementById('statusSupplier');
    if (checkbox.checked) {
        slider.style.backgroundColor = '#00CC00'; 
        statusLabel.style.color = '#00CC00';
    } else {
        slider.style.backgroundColor = '#262626'; 
        statusLabel.style.color = '#fefefe'; 
    }
}
function closeAddSupplierModal(){
  $('.highlighteds').removeClass('highlighteds');
  clearInputs()
  $('.form-check-input:checked').prop('checked', false);
  localStorage.removeItem('suppliedProductData');
  localStorage.removeItem('suppliedIngredientsData');
  localStorage.removeItem('removedItemsProductsStorage');
  localStorage.removeItem('removedItemsIngStorage');
  $('.form-check-input').removeClass('checked');
  $('#suppliedTable tbody').empty();
  $('#suppliedTableIng tbody').empty();
  $('#add_supplier_modal').css('animation', 'slideOutRight 0.5s forwards');
  $('.supplier-modal').css('animation', 'slideOutRight 0.5s forwards');


  $('#add_supplier_modal').one('animationend', function() {
    $(this).hide();
    $(this).css('animation', '');
    $('.supplier-modal').css('animation', '');

   
  });
}
function clearInputs(){
  document.getElementById('supplierName').value = "";
  document.getElementById('supplierContact').value = "";
  document.getElementById('supplierEmail').value = "";
  document.getElementById('supplierCompany').value = "";
  document.getElementById('supplierid').value = "";


  var status = document.getElementById('statusValueSupplier')
  status.checked = false;
  
  var uptBtn = document.querySelector('.updateSuppliedBtn');
    uptBtn.setAttribute('hidden',true);
    var saveBtn = document.querySelector('.saveSuppliedBtn');
    saveBtn.removeAttribute('hidden');
}

function addSupplier(){
  var s_name = document.getElementById('supplierName').value;
  var s_contact =  document.getElementById('supplierContact').value;
  var s_email =  document.getElementById('supplierEmail').value;
  var s_company = document.getElementById('supplierCompany').value;
  var status = document.getElementById('statusValueSupplier').checked ? 1 : 0;
  var suppliedProductData = JSON.parse(localStorage.getItem('suppliedProductData')) || [];
  var suppliedIngredientsData = JSON.parse(localStorage.getItem('suppliedIngredientsData')) || [];

  if (!s_name) {
      $('.supplierLbl').css('color', 'red');
        return; 
  }else{
      $('.supplierLbl').css('color', '');
  }
   
  if(s_name){
    var formData = new FormData();
    formData.append("supplierName", s_name); 
    formData.append("supplierContact", s_contact); 
    formData.append("supplierEmail", s_email); 
    formData.append("supplierCompany", s_company); 
    formData.append("supplierStatus", status); 
    formData.append("suppliedProductData", JSON.stringify(suppliedProductData));
    formData.append("suppliedIngredientsData", JSON.stringify(suppliedIngredientsData));

    axios.post('api.php?action=addSupplier', formData).then(function(response){
      var userInfo = JSON.parse(localStorage.getItem('userInfo'));
      var firstName = userInfo.firstName;
      var lastName = userInfo.lastName;
      var cid = userInfo.userId;
      var role_id = userInfo.roleId; 
    
    
      insertLogs('Supplier',firstName + ' ' + lastName + ' '+ 'Added supplier' + ' ' +  s_name)
      closeAddSupplierModal()
      refreshSupplierTable()
    }).catch(function(error){
      console.log("error")
    })
  }
}
function openProductModal(){
  const suppliedProductData = JSON.parse(localStorage.getItem('suppliedProductData')) || [];
    suppliedProductData.forEach((productId) => {
        const checkbox = document.getElementById(productId.productId);
        if (checkbox) {
            checkbox.checked = true;
            checkbox.classList.add('checked');
        }
    });
 $('#suppliedModal').show()
}

$(document).ready(function() {
    $('#supplierName').on('input', function() {
        var inputText = $(this).val(); 
        if (inputText.trim() !== '') {
            $('.supplierLbl').css('color', '');
        }
    });
});

function toUpdateSupplier(supplierId,supplierName,supplierContact,supplierEmail,supplierCompany,supplierStatus){
  $('#add_supplier_modal').show()
     if($('#add_supplier_modal').is(":visible")){
          supplierId ? document.getElementById('supplierid').value = supplierId : null;
          supplierName ? document.getElementById("supplierName").value = supplierName : null;
          supplierContact ? document.getElementById("supplierContact").value = supplierContact : null;
          supplierEmail ? document.getElementById("supplierEmail").value =  supplierEmail : null;
          supplierCompany ? document.getElementById("supplierCompany").value =   supplierCompany : null;
       

          var statusCheckbox = document.getElementById('statusValueSupplier');
          statusCheckbox.checked  = (supplierStatus == 1) ? true: false;
          toggleStatusSupplier(statusCheckbox)

              var s_id = document.getElementById('supplierid').value
              if(s_id){
                supplierName  ? (document.getElementById("modalHeaderTxt").value =   supplierName , $('.modalHeaderTxt').text(supplierName)) : null;
                    axios.get(`api.php?action=getSuppliedProductsData&supplier_id=${s_id}`).then(function(response){
                    var data = response.data.result;
                    var suppliedProductData = JSON.parse(localStorage.getItem('suppliedProductData')) || [];
                      suppliedProductData.push(...data); 
                      localStorage.setItem('suppliedProductData', JSON.stringify(suppliedProductData));
                      updateProductSupply(suppliedProductData)
                    }).catch(function(error){
                      console.log(error)
                    })

                    axios.get(`api.php?action=getSuppliedIngData&supplier_id=${s_id}`).then(function(response){
                    var data = response.data.result;
                     var suppliedIngredientsData = JSON.parse(localStorage.getItem('suppliedIngredientsData')) || [];
                      suppliedIngredientsData.push(...data); 
                      localStorage.setItem('suppliedIngredientsData', JSON.stringify(suppliedIngredientsData));
                      updateIngtSupply(suppliedIngredientsData)
                    }).catch(function(error){
                      console.log(error)
                    })
              }else{
                $('.modalHeaderTxt').text("Add New Supplier")
              }

              var uptBtn = document.querySelector('.updateSuppliedBtn');
              var saveBtn = document.querySelector('.saveSuppliedBtn');
              s_id ? (uptBtn.removeAttribute('hidden'), saveBtn.setAttribute('hidden', true)) : (uptBtn.setAttribute('hidden', true), saveBtn.removeAttribute('hidden'));
  }
}

function updateSupplied(){
  var s_id = document.getElementById('supplierid').value 
  var s_name = document.getElementById('supplierName').value;
  var s_contact =  document.getElementById('supplierContact').value;
  var s_email =  document.getElementById('supplierEmail').value;
  var s_company = document.getElementById('supplierCompany').value;
  var status = document.getElementById('statusValueSupplier').checked ? 1 : 0;
  // var removedItemsProductsStorage = JSON.parse(localStorage.getItem('removedItemsProductsStorage')) || [];
  // var removedItemsIngStorage = JSON.parse(localStorage.getItem('removedItemsIngStorage')) || [];
  // var suppliedProductData = JSON.parse(localStorage.getItem('suppliedProductData')) || [];
  // var suppliedIngredientsData = JSON.parse(localStorage.getItem('suppliedIngredientsData')) || [];

  if (!s_name) {
      $('.supplierLbl').css('color', 'red');
        return; 
  }else{
      $('.supplierLbl').css('color', '');
  }
   
  if(s_name){
    var formData = new FormData();
    formData.append("supplierName", s_name); 
    formData.append("supplierContact", s_contact); 
    formData.append("supplierEmail", s_email); 
    formData.append("supplierCompany", s_company); 
    formData.append("supplierStatus", status); 
    formData.append("id", s_id); 
    // formData.append("removedItemsProductsStorage", JSON.stringify(removedItemsProductsStorage));
    // formData.append("removedItemsIngStorage", JSON.stringify(removedItemsIngStorage));
    // formData.append("suppliedProductData", JSON.stringify(suppliedProductData));
    // formData.append("suppliedIngredientsData", JSON.stringify(suppliedIngredientsData));
    axios.post('api.php?action=updateSupplier', formData).then(function(response){
      console.log(response)
      var userInfo = JSON.parse(localStorage.getItem('userInfo'));
      var firstName = userInfo.firstName;
      var lastName = userInfo.lastName;
      var cid = userInfo.userId;
      var role_id = userInfo.roleId; 
    
    
      insertLogs('Supplier',firstName + ' ' + lastName + ' '+ 'Updated supplier' + ' ' +  s_name)
      closeAddSupplierModal()
      refreshSupplierTable()
    }).catch(function(error){
      console.log("error")
    })
  }

}
</script>

