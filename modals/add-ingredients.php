<style>
#add_ingredients_modal {
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


.ingredients-modal {
  background-color: #fefefe;
  margin: 0 auto; 
  border: none;
  width: 100%;
  height: 1200px; 
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
   color: #FF6900;
   font-family: Century Gothic;
   font-weight: bold;
}
.text-white{
    color: #FFFF;
    font-family: Century Gothic;
}
.tips-header{
  margin-top: 25px;
}
.pl{
 padding-left: 20px;
}
.m{
    margin: 0 ;
    margin-bottom: 20px;
    padding-right: 20px;
}
.activateHeader{
    font-family: Century Gothic;
    font-weight: bold;
    color: #7F7F7F;
}
.switchActivate {
  position: relative;
  display: inline-block;
  width: 40px; 
  height: 20px; 
  outline: none; 
}

.switchActivate input {
  opacity: 0;
  width: 0;
  height: 0;
}

.sliderActivate {
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

.sliderActivate:before {
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

input:checked + .sliderActivate {
  background-color: #FF6900;
}

input:focus + .sliderActivate {
  box-shadow: 0 0 1px #BFBFBF;
}

input:checked + .sliderActivate:before {
  -webkit-transform: translateX(20px); 
  -ms-transform: translateX(20px);
  transform: translateX(20px); 
}

.sliderActivate.round {
  border-radius: 10px; 
}

.sliderActivate.round:before {
  border-radius: 50%; 
}

.sliderActivate.active {
  background-color: #FF6900;
}
/* new */
.ifActivate {
  position: relative;
  display: inline-block;
  width: 40px; 
  height: 20px; 
  outline: none; 
}

.ifActivate input {
  opacity: 0;
  width: 0;
  height: 0;
}

.sliderIfActivate {
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

.sliderIfActivate:before {
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

input:checked + .sliderIfActivate {
  background-color: #FF6900;
}

input:focus + .sliderIfActivate {
  box-shadow: 0 0 1px #BFBFBF;
}

input:checked + .sliderIfActivate:before {
  -webkit-transform: translateX(20px); 
  -ms-transform: translateX(20px);
  transform: translateX(20px); 
}

.sliderIfActivate.round {
  border-radius: 10px; 
}

.sliderIfActivate.round:before {
  border-radius: 50%; 
}

.sliderIfActivate.active {
  background-color: #FF6900;
}
.pd {
    margin: 0;
    padding: 0;
    padding-left: 20px;
}
.text-c{
    font-family: Century Gothic;
    color: #7F7F7F;
    font-size: 12px;
    
}
.table-borders{
    margin-left: 20px;
    margin-right: 20px;
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
/* new */

.statusLbl {
  position: relative;
  display: inline-block;
  width: 40px; 
  height: 20px; 
  outline: none; 
}

.statusLbl input {
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
  background-color: #BFBFBF;
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
  box-shadow: 0 0 1px #BFBFBF;
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
.desc{
    position:absolute;
    top: 650px;
}
.descArea{
    background-color: transparent;
    border-color: #BFBFBF;
    color: #ffff
}
.button-container{
    position: absolute;
    top: 810px;
    left: 275px

}
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
    z-index: 8000 !important; 
}

#uomDropDown {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    z-index: 8000 !important; 
    top: 25px; 
    left: 75px; 
    overflow-y: scroll;
    height: 100px;
  
    
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


</style>

<div class="modal" id="add_ingredients_modal" tabindex="0">
  <div class="modal-dialog ">
    <div class="modal-content ingredients-modal">
      <div class="modal-title">
        <div class="warning-container">
        <div style="display: flex; margin-top: 30px">
                <h2 style="margin-left: 20px;" class="text-custom modalIngredientsTxt">Add Ingredients</h2>
                 <input hidden readonly id="ingredientsID"/>
            </div>
            <div hidden>
                <h5 class="tips-header pl "><span class="text-custom">Tips:</span>&nbsp;<span class="text-white">Managing Inventory With Ingredients</span></h5>
                <h6 class="text-white pl m" style="margin-top: 40px;margin-bottom:20px">Did you know you can streamline inventory management by utilizing the ingredients module? Here's how:</h6>
                <h6 class="pl m" style="margin-bottom:20px"><span class="text-custom">Identify Components:</span>&nbsp;<span class="text-white">List all ingredients used in your products, such as flour, sugar, eggs, etc.</span></h6>
                <h6 class="pl m"><span class="text-custom">Assign Quantities:</span>&nbsp;<span class="text-white">Specify the quantity of each ingredient required for a single unit of your product (e.g., 2 cups of flour, 1 egg).</span></h6>
                <h6 class="pl m"><span class="text-custom">Track Stock Levels:</span>&nbsp;<span class="text-white">Input initital stock quantitites for each ingredient and update them as you receive new shipments or use them in recipes.</span></h6>
                <h6 class="pl m"><span class="text-custom">Automate Reordering:</span>&nbsp;<span class="text-white">Set up automatic reorder points for ingredients to ensure you never run out of essential supplies.</span></h6>
                <h6 class="pl m"><span class="text-custom">Monitor Usage:</span>&nbsp;<span class="text-white">Keep track of ingredient usage with real-time reports to indetify trends and adjust purchasing decisions accordingly.</span></h6>
                <h6 class="pl m text-white">By effectively managing your ingredients, you can optimize stock levels, reduce waste, and ensure smooth operations for your POS system.</h6>
           <div class=" pl " style="display: flex; margin-top: 40px">
              <h6 class="activateHeader">ACTIVATE INGREDIENTS</h6>
              <?php
                    $otherChanges = "no"; 
                    $other_changes = ($otherChanges == "no") ? "yes" : "no";
                    ?>
                    <label class="switchActivate" style="margin-left: 5px; margin-top: -2px">
                        <input type="checkbox" id="activateToggle"<?php if($otherChanges == "no") ?> >
                        <span class="sliderActivate round"></span>
                    </label>    
           </div>
           <h6 class="pl m text-white">499 Php./ Month Billed Annually<br>For more details, please visit our page.<br>Contact us: 032-385-8586</h6>
            </div>
            <div>
             <div class="pl" style="display: flex; margin-top: 40px">
              <p class="text-custom">ACTIVATE INGREDIENTS</p>
              <?php
                    $otherChanges = "no"; 
                    $other_changes = ($otherChanges == "no") ? "yes" : "no";
                    ?>
                    <label class="ifActivate" style="margin-left: 5px; margin-top: -2px">
                        <input type="checkbox" id="activateIngredientsToggle"<?php if($otherChanges == "no") ?> >
                        <span class="sliderIfActivate round"></span>
                    </label>    
                </div>
                    <h6 class="pd  text-c" style="margin-bottom: 30px"><span>Activation code:</span>&nbsp;<span>1A2B-3C4D-5E6F-7G8H-XXXX-XXXX-XXXX</span><br>
                    <span>REF ID:</span>&nbsp;<span>XXXX-XXXX-XXXX-XXXX-XXXX-XXXX-XXXX</span><br><span >Valid Until:</span>&nbsp;<span>Dec 30, 2025</span></h6>
                    <div style="width: 93%">
                    <table id="addIngredients" class="text-color table-borders"> 
                   <tbody>
                    <tr>
                        <td class="nameLbl td-height  td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Name<supp>*</supp></td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><input class="ingredientsName" name="ingredientsName" id="ingredientsName"/></td>
                    </tr>
                    <tr>
                        <td  class="barcodeTd td-height  td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Barcode</td>
                        <td  class="td-height text-custom" style="font-size: 12px; height: 10px"><input  oninput="validateNumber(this)" class="barcode" id="barcode" name="barcode" style="width: 225px"/><button class="generate" id="generate">Generate</button></td>
                    </tr>
                    <tr>
                        <td  class="unitM td-height  td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Unit of Measure</td>
                        <td class="td-height text-custom" style="font-size: 12px; height: 10px"><div class="dropdown custom-input">
                            <input class="custom-input" readonly hidden name="uomID" id="uomID" style="width: 265px"/>
                            <input class="custom-input" readonly name="uomType" id="uomType" style="width: 265px"/>
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
                        </div></td>
                    </tr>
                    <tr>
                        <td  class="costLbl td-height  td-style td-bg" style="font-size: 12px; height: 10px; width:35%">Cost Price (Php)/Unit</td>
                        <td  class="td-height text-custom" style="font-size: 12px; height: 10px"><input oninput="validateNumber(this)" class="cost" name="cost" id="cost"/></td>
                    </tr>
                    <tr>
                        <td  class="td-height  td-style td-bg" style="font-size: 12px; height: 10px; width:35%"><span id="spanStatus">Status</span>&nbsp;<span class="statusData">Active</span></td>
                        <td  class="td-height text-custom" style="font-size: 12px; height: 10px">

                        <?php
                    $otherChanges = "no"; 
                    $other_changes = ($otherChanges == "no") ? "yes" : "no";
                    ?>
                    <label class="statusLbl" style="margin-left: 5px; margin-top: -2px">
                        <input type="checkbox" id="activateIfToggle"<?php if($otherChanges == "no") echo "checked" ?> >
                        <span class="sliderStatus round"></span>
                    </label>  
                    </td>

                    </tr>
                   </tbody>
                  </table>
            </div>

            <div class="pl desc" style="width: 100%">
                <h6 class="text-custom">Description</h6>
                <textarea class="descArea" id="descArea" style="width: 97%; height: 150px"></textarea>
            </div>
            <div class="button-container" style="display:flex;justify-content: right;">
                <button onclick=" addIngrediets()" class="btn-success-custom saveIngredientsBtn" style="margin-right: 10px; width: 100px; height: 40px">Save</button>
                <button hidden onclick="updateIng()" class="btn-success-custom updateIngredientsBtn" style="margin-right: 10px; width: 100px; height: 40px">Update</button>
                <button onclick="closeAddIngredientsModal()" class="cancelAddIngredients btn-error-custom" style="margin-right: 20px;width: 100px; height: 40px">Cancel</button>
            </div>
            </div>
           
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function addIngrediets(){
 var ingredientName = document.getElementById('ingredientsName').value 
 var barcode =   document.getElementById('barcode').value 
 var uom_id = document.getElementById('uomID').value 
 var cost = document.getElementById('cost').value 
 var description = document.getElementById('descArea').value
 var checkbox = document.getElementById('activateIfToggle');
 var status = checkbox.checked ? 'Active' : 'Inactive'; 

 var nameLabel = document.querySelector('.nameLbl');
 var barcodeLabel = document.querySelector('.barcodeTd');
 var unitLabel = document.querySelector('.unitM'); 
 var costLabel = document.querySelector('.costLbl'); 

 ingredientName ? nameLabel.style.color = '' : nameLabel.style.color = 'red';
 barcode ? barcodeLabel.style.color = '' : barcodeLabel.style.color = 'red';
 uom_id ? unitLabel.style.color = '' : unitLabel.style.color = 'red';
 cost ? costLabel.style.color = '' : costLabel.style.color = 'red';

if(ingredientName && barcode && uom_id && cost){
    axios.post('api.php?action=addIngredients',{
    ingredientName: ingredientName,
    barcode: barcode,
    uom_id:  uom_id,
    cost: cost,
    status: status,
    description : description 
 }).then(function(response){
    closeAddIngredientsModal()
    refreshIngredientsTable()
 }).catch(function(error){
    console.log(error)
 })
}

}

function closeAddIngredientsModal(){
  $('#add_ingredients_modal').css('animation', 'slideOutRight 0.5s forwards');
  $('.ingredients-modal').css('animation', 'slideOutRight 0.5s forwards');
  $('.highlightedIng').removeClass('highlightedIng');

  $('#add_ingredients_modal').one('animationend', function() {
    $(this).hide();
    $(this).css('animation', '');
    $('.ingredients-modal').css('animation', '');
     clearIngredientsInputs()
    
  });
  
}

function clearIngredientsInputs(){
  document.getElementById('ingredientsName').value = "";
  document.getElementById('barcode').value = "";
  document.getElementById('uomID').value = "";
  document.getElementById('cost').value = "";
  document.getElementById('uomType').value = ""
  document.getElementById('descArea').value = ""
  document.getElementById('ingredientsID').value="";

  var checkbox = document.getElementById('activateIfToggle');
  checkbox.checked = true;
  updateTextColor() 

  var uptBtn = document.querySelector('.updateIngredientsBtn');
    uptBtn.setAttribute('hidden',true);
    var saveBtn = document.querySelector('.saveIngredientsBtn');
    saveBtn.removeAttribute('hidden');
}

function validateNumber(input) {
   input.value = input.value.replace(/[^0-9.]/g, '');
   if (input.value.startsWith('-')) {
       input.value = input.value.slice(1);
   }
}  
document.getElementById("generate").addEventListener("click", function() {
    const minDigits = 9;
    const randomNumber = generateRandomNumber(minDigits);
    document.getElementById('barcode').value = randomNumber
    var barcodeLabel = document.querySelector('.barcodeTd');
    barcodeLabel.style.color = '';
    
})
function generateRandomNumber(minDigits) {
    const numberOfDigits = Math.floor(Math.random() * (9 - minDigits + 1)) + minDigits; 
    let randomNumber = '';

    for (let i = 0; i < numberOfDigits; i++) {
        randomNumber += Math.floor(Math.random() * 10); 
    }

    return randomNumber;
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
    if(value){
      var unitLabel = document.querySelector('.unitM'); 
      unitLabel.style.color = '';
    }
    document.getElementById("uomType").value = roleName;
    document.getElementById("uomDropDown").style.display = "none";
  });
});

document.addEventListener('DOMContentLoaded', function() {
   
    var barcodeInput =  document.getElementById('barcode');
    var barcodeLabel = document.querySelector('.barcodeTd');
    barcodeInput.addEventListener('input', function() {
        var barcode = barcodeInput.value.trim(); 
        if (barcode) {
            axios.get(`api.php?action=checkBarcode&barcode=${barcode}`)
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


 var nameLabel = document.querySelector('.nameLbl');
 var barcodeLabel = document.querySelector('.barcodeTd');
 var costLabel = document.querySelector('.costLbl'); 

document.getElementById('ingredientsName').addEventListener('input', function(){
  nameLabel.style.color = "";
})
document.getElementById('barcode').addEventListener('input', function(){
  barcodeLabel.style.color = "";
})
document.getElementById('cost').addEventListener('input', function(){
  costLabel .style.color = "";
})
 

});

function  toupdateIngredients(ingredientsId,uom_id,uom_name,name,barcode,cost,status,desc){
  $('#add_ingredients_modal').show()
  var activatedToggle = document.getElementById('activateIngredientsToggle')
  var statusToggle =  document.getElementById('activateIfToggle')
  activatedToggle.disabled = true
  activatedToggle.checked = true
  if(ingredientsId && activatedToggle.checked){
    ingredientsId ? document.getElementById('ingredientsID').value = ingredientsId : null; 
    name ? document.getElementById('ingredientsName').value = name : null; 
    barcode ?  document.getElementById('barcode').value = barcode : null;
    cost ?  document.getElementById('cost').value = cost : null;
    uom_name ?  document.getElementById('uomType').value = uom_name : null;
    uom_id ? document.getElementById('uomID').value = uom_id : null;
    desc ?  document.getElementById('descArea').value = desc : null;
    statusToggle.checked = status == 'Active' ? true : false;
    updateTextColor() 
    var uptBtn = document.querySelector('.updateIngredientsBtn');
    var saveBtn = document.querySelector('.saveIngredientsBtn');
    ingredientsId? (uptBtn.removeAttribute('hidden'), saveBtn.setAttribute('hidden', true)) : (uptBtn.setAttribute('hidden', true), saveBtn.removeAttribute('hidden'));
    var i_id = document.getElementById('ingredientsID').value;
    if(i_id){
    name ? (document.getElementById("ingredientsName").value =  name, $('.modalIngredientsTxt').text(name)) : null;
  }else{
    $('.modalIngredientsTxt').text("Add Ingredients")
  }
  }
}

function updateIng(){
 var ing_id = document.getElementById('ingredientsID').value;
 var ingredientName = document.getElementById('ingredientsName').value 
 var barcode =   document.getElementById('barcode').value 
 var uom_id = document.getElementById('uomID').value 
 var cost = document.getElementById('cost').value 
 var description = document.getElementById('descArea').value
 var checkbox = document.getElementById('activateIfToggle');
 var status = checkbox.checked ? 'Active' : 'Inactive';


 var nameLabel = document.querySelector('.nameLbl');
 var barcodeLabel = document.querySelector('.barcodeTd');
 var unitLabel = document.querySelector('.unitM'); 
 var costLabel = document.querySelector('.costLbl'); 

 ingredientName ? nameLabel.style.color = '' : nameLabel.style.color = 'red';
 barcode ? barcodeLabel.style.color = '' : barcodeLabel.style.color = 'red';
 uom_id ? unitLabel.style.color = '' : unitLabel.style.color = 'red';
 cost ? costLabel.style.color = '' : costLabel.style.color = 'red';

 if(ingredientName && barcode && uom_id && cost){
      axios.post('api.php?action=updateIngredients',{
          ingredientName: ingredientName,
          barcode: barcode,
          uom_id:  uom_id,
          cost: cost,
          status: status,
          description : description,
          ing_id: ing_id
      }).then(function(response){
          closeAddIngredientsModal()
          refreshIngredientsTable()
      }).catch(function(error){
          console.log(error)
      })
 }
}



</script>
