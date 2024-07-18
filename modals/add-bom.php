<style>

#add_bom_modal {
  display: none;
  position: fixed;
  z-index: 9999;
  top: 0;
  bottom: 0;
  left: calc(100% - 750px);
  width: 250px;
  background-color: transparent;
  overflow: hidden;
  height: 100%;
  animation: slideInRight 0.5s;
}

.bomAdd {
  background-color: #fefefe;
  margin: 0 auto;
  border: none;
  width: 100%;
  height: 100vh; 
  border: 1px solid #595959;
  animation: slideInRight 0.5s;
  border-radius: 0;
  margin-top: -28px;
  background-color: #1E1C11;
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
.qtyIngredients{
    background-color: #7C7C7C;
    font-size: 13px;
    width: 230px;
}
.qtyIngredients::placeholder { 
    color: white;
    font-style: italic;
    opacity: 1; 
    
}
#uomTypes::placeholder { 
    color: white;
    font-style: italic;
    opacity: 1; 
    
}
#ingredientsName::placeholder { 
    color: white;
    font-style: italic;
    opacity: 1; 
    
}
#uomTypes{
    background-color: #7C7C7C;
    font-size: 13px;
}
#ingredientsName{
    background-color: #7C7C7C;
    font-size: 13px; 
}
.dropdowns {
    position: relative; 
    display: inline-block;
}

.dropdown-contents {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    z-index:1; 
}

#uomDropDowns {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    z-index: 1; 
    top: 28px; 
    left: 60px; 
    right: 2px;
}
.ingredients{
    position: relative; 
    display: inline-block;
}

 
  .dropdown-contents a {
    display: block;
    width: 168px;
    padding: 10px;
    border: none; 
    background-color: transparent;
    color: #000000; 
    text-decoration: none; 
    padding-top: 0;
    padding-bottom: 0;
    margin-top: 0;
    margin-bottom: 0;  
  }
  

  .dropdown-contents a:hover {
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
.text-header{
color: #fefefe;
font-family: Century Gothic;
}

/* ingredient */

#ingredientDropDowns {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    z-index: 1; 
    top: 28px; 
    left: 60px; 
    right: 2px;
    overflow-y: auto;
    height: 250px;
}

 
#ingredientDropDowns a {
    display: block;
    width: 168px;
    padding: 10px;
    border: none; 
    background-color: transparent;
    color: #000000; 
    text-decoration: none; 
    padding-top: 0;
    padding-bottom: 0;
    margin-top: 0;
    margin-bottom: 0;  
    
  }
  
#ingredientDropDowns a:hover {
    background-color: #ddd;
  }
  .closeBom{
    position:absolute;
    width: 30px;
    height: 30px;
    left: 210px;
    top: 25px;
    right:5px;
  }
  .closeBom:hover {
    background-color: #ccc; 
    color: #fff;
}
.bomActionBtns{
    position: absolute;
    top: 870px;
    left: 150px;
    right: 8px
}
</style>
<div class="modal" id="add_bom_modal" tabindex="0">
  <div class="modal-dialog ">
    <div class="modal-content bomAdd">
      <div class="modal-title">
        <div class="warning-container">
            <div>
                <button onclick="closeModalBom()"class="closeBom">x</button>
            </div>
            <div  style="margin-top: 60px; margin-left: 10px">
              <h3 class="text-custom" style="color:#FF6900;">Add BOM</h3>
            </div>
            <div style="margin-left: 10px; margin-top: 40px; width: 100%">
              <label for="qtyIngredients" class="text-header"style="margin-top: 15px">Ingredient<supp>*</supp>:</label>
              <div class="ingredients custom-input">
                            <input class="custom-input" readonly hidden name="qtyIngredients" id="ingredientsId" style="width: 200px"/>
                            <input class="custom-input" readonly name="ingredientsName" id="ingredientsName" style="width: 200px" placeholder="Select Ingredients"/>
                            <button name="ingBtns" id="ingBtns" class="custom-btn">
                            <svg width="13px" height="13px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                <path d="M19 5L12.7071 11.2929C12.3166 11.6834 11.6834 11.6834 11.2929 11.2929L5 5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M19 13L12.7071 19.2929C12.3166 19.6834 11.6834 19.6834 11.2929 19.2929L5 13" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                            </button>
                            <div class="ingredients-contents" id="ingredientDropDowns">
                            <?php
                                 $ingredientFacade = new IngredientsFacade;
                                 $ing =   $ingredientFacade->ingredients();
                                while ($row =  $ing->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<a href="#" style="color:#000000; text-decoration: none;" data-value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</a>';
                                }
                                ?>
                            </div>
                        </div>
              <label for="uomIDs" class="text-header"style="margin-top: 15px">Unit of Measure<supp>*</supp>:</label>
              <div class="dropdowns custom-input">
                            <input class="custom-input" readonly hidden name="uomIDs" id="uomIDs" style="width: 200px"/>
                            <input class="custom-input" readonly name="uomTypes" id="uomTypes" style="width: 200px" placeholder="Select UOM"/>
                            <button name="uomBtns" id="uomBtns" class="custom-btn">
                            <svg width="13px" height="13px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                <path d="M19 5L12.7071 11.2929C12.3166 11.6834 11.6834 11.6834 11.2929 11.2929L5 5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M19 13L12.7071 19.2929C12.3166 19.6834 11.6834 19.6834 11.2929 19.2929L5 13" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                            </button>
                            <div class="dropdown-contents" id="uomDropDowns">
                            <?php
                                 $productFacade = new ProductFacade;
                                 $uom = $productFacade->getUOM();
                                while ($row =  $uom->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<a href="#" style="color:#000000; text-decoration: none;" data-value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['uom_name']) . '</a>';
                                }
                                ?>
                            </div>
                        </div>
                        <label for="ingredientsId" class="text-header" style="margin-top: 15px">Quantity<supp>*</supp>:</label>
                <input name="ingredientsId" class="qtyIngredients" id="qtyIngredients" oninput=" validateNumber(this)" placeholder="Quantity"/>
            </div>
            <div class="button-container bomActionBtns" style="display:flex;justify-content: right;">
                <button  class="btn-success-custom saveBom" id="saveBom" style=" width: 100px; height: 40px">Done</button>
            </div>
         </div>
        </div>  
    </div>
  </div>                      
</div>


<script>

function closeModalBom(){
   
 $('#add_bom_modal').css('animation', 'slideOutRight 0.5s forwards');
  $('.bomAdd').css('animation', 'slideOutRight 0.5s forwards');
//   $('.highlighted').removeClass('highlighted');
 
  $('#add_bom_modal').one('animationend', function() {
    $(this).hide();
    $(this).css('animation', '');
    $('.bomAdd').css('animation', '');
    clearBomInputs()
   
  });
}

function clearBomInputs(){
    document.getElementById('qtyIngredients').value= "";
    document.getElementById('uomIDs').value= "";
    document.getElementById('uomTypes').value= "";
    document.getElementById('ingredientsId').value= "";
    document.getElementById('ingredientsName').value= "";
}

document.addEventListener('DOMContentLoaded', function() {
document.getElementById("ingBtns").addEventListener("click", function() {
  var dropdownContents = document.getElementById("ingredientDropDowns");
  if (dropdownContents.style.display === "block") {
    dropdownContents.style.display = "none";
  } else {
    dropdownContents.style.display = "block";
  }
  event.stopImmediatePropagation();
});

document.addEventListener("click", function(event) {
  var dropdownContent = document.getElementById("ingredientDropDowns");
  var statusBtn = document.getElementById("ingBtns");
  if (event.target !== dropdownContent && event.target !== statusBtn && dropdownContent.style.display === "block") {
    dropdownContent.style.display = "none";
  }
});

document.querySelectorAll("#ingredientDropDowns a").forEach(item => {
  item.addEventListener("click", function(event) {
    event.preventDefault(); 
    var value = this.getAttribute("data-value");
    var roleName = this.textContent;
    document.getElementById("ingredientsId").value = value;
    if(value){
      var ingredientLabel = document.querySelector('label[for="qtyIngredients"]');
      ingredientLabel.style.color = '';
    }
     document.getElementById("ingredientsName").value = roleName;
    document.getElementById("ingredientDropDowns").style.display = "none";
  });
});




document.getElementById("uomBtns").addEventListener("click", function() {
  var dropdownContents = document.getElementById("uomDropDowns");
  if (dropdownContents.style.display === "block") {
    dropdownContents.style.display = "none";
  } else {
    dropdownContents.style.display = "block";
  }
  event.stopImmediatePropagation();
});

document.addEventListener("click", function(event) {
  var dropdownContent = document.getElementById("uomDropDowns");
  var statusBtn = document.getElementById("uomBtns");
  if (event.target !== dropdownContent && event.target !== statusBtn && dropdownContent.style.display === "block") {
    dropdownContent.style.display = "none";
  }
});

document.querySelectorAll("#uomDropDowns a").forEach(item => {
  item.addEventListener("click", function(event) {
    event.preventDefault(); 
    var value = this.getAttribute("data-value");
    var roleName = this.textContent;
    document.getElementById("uomIDs").value = value;
    if(value){
      var uomLabel = document.querySelector('label[for="uomIDs"]');
      uomLabel.style.color = "";
    }
    document.getElementById("uomTypes").value = roleName;
    document.getElementById("uomDropDowns").style.display = "none";
  });
});

 document.getElementById('qtyIngredients').addEventListener('input',function(){
  var qtyLabel = document.querySelector('label[for="ingredientsId"');
  qtyLabel.style.color = '';
 });
   

document.getElementById('saveBom').addEventListener('click', function() {
    var ingredientsQty = document.getElementById('qtyIngredients').value;
    var uom_id = document.getElementById('uomIDs').value;
    var ingredientId = document.getElementById('ingredientsId').value;
    var oumTypes = document.getElementById('uomTypes').value;
    var ingredientsname = document.getElementById('ingredientsName').value;

    var qtyLabel = document.querySelector('label[for="qtyIngredients"]');
    var uomLabel = document.querySelector('label[for="uomIDs"]');
    var ingredientLabel = document.querySelector('label[for="ingredientsId"]');

  
    var isEmpty = !ingredientsQty || !uom_id || !ingredientId;

    
    qtyLabel.style.color = !ingredientsQty ? 'red' : '';
    uomLabel.style.color = !uom_id ? 'red' : '';
    ingredientLabel.style.color = !ingredientId ? 'red' : '';

   
    if (isEmpty) return;

   
    qtyLabel.style.color = '';
    uomLabel.style.color = '';
    ingredientLabel.style.color = '';

    var existingData = JSON.parse(localStorage.getItem('bomData')) || [];
    existingData.push({
        ingredientsQty: ingredientsQty,
        uom_id: uom_id,
        ingredientId: ingredientId,
        oumTypes: oumTypes,
        ingredientsname: ingredientsname
    });

    localStorage.setItem('bomData', JSON.stringify(existingData));
     updateTable(existingData);
    closeModalBom()
});






var existingData = JSON.parse(localStorage.getItem('bomData')) || [];
updateTable(existingData);


 });
 function updateTable(data) {
  var tableBody = document.getElementById('myTable').getElementsByTagName('tbody')[0];
  tableBody.innerHTML = '';
  
 
  data.forEach(function(entry, index) {
    var row = document.createElement('tr');
    
    var counterCell = document.createElement('td');
    counterCell.textContent = (index + 1) + '.';
    row.appendChild(counterCell);

    var ingredientCell = document.createElement('td');
    ingredientCell.textContent = entry.ingredientsname;
    row.appendChild(ingredientCell);
    
    var qtyCell = document.createElement('td');
    qtyCell.textContent = entry.ingredientsQty;
    row.appendChild(qtyCell);
    
    var uomCell = document.createElement('td');
    uomCell.textContent = entry.oumTypes;
    row.appendChild(uomCell);
    
   
    
    // var actionCell = document.createElement('td');
    // var editLink = document.createElement('a');
    // editLink.textContent = 'Edit';
    // editLink.href = '#';
    // actionCell.appendChild(editLink);
    // row.appendChild(actionCell);
    tableBody.appendChild(row);

   
  });

  var previouslyClickedRow = null; 
var rows = tableBody.querySelectorAll('tr');
rows.forEach(function(row, index) {
    row.addEventListener('click', function() {
        var rowData = data[index]; 
        forDeletion(rowData,index);
        if (previouslyClickedRow !== null) {
            previouslyClickedRow.querySelectorAll('td').forEach(function(td) {
                td.style.color = '';
            });
        }
        row.querySelectorAll('td').forEach(function(td) {
            td.style.color = 'green';
        });
        previouslyClickedRow = row;
    });
});

}

function forDeletion(rowData,index){
    $('#delIngredients').off('click').on('click',function(){
        if(rowData.id){
          var existingData = JSON.parse(localStorage.getItem('bomData')) || [];
          existingData.splice(index, 1);
          localStorage.setItem('bomData', JSON.stringify(existingData));
            axios.delete(`api.php?action=deleteBOM&id=${rowData.id}`).then(function(response){
                var existingData = JSON.parse(localStorage.getItem('bomData')) || [];
                localStorage.setItem('bomData', JSON.stringify(existingData));
                updateTable(existingData);
            }).catch(function(error){
              console.log(error)
            })

        }else{
          var existingData = JSON.parse(localStorage.getItem('bomData')) || [];
          existingData.splice(index, 1);
          localStorage.setItem('bomData', JSON.stringify(existingData));
          updateTable(existingData);
        }
    });
}

</script>


