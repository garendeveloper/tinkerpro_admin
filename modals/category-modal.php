                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <style>

#add_category_modal {
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

.categoryAdd {
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
.productsBtn{
    border: none;
    background-color: transparent;
    outline: 0;
    color:#fefefe;
    text-decoration: none;
    font-size: small;
    padding-left: 25px;
}
.productsBtn:hover{
    color: #FF6900 !important;
}
.productsHeader{
    margin-top: 50px;
    position: absolute;
    width: 100%
}
.productCategory{
    border: none;
    background-color: transparent;
    outline: 0;
    color :#fefefe;
    text-decoration: none;
    font-size: small;
   
}
#categoriesDiv p {
    padding-left: 50px
}
.productCategory:hover{
    color: #FF6900 !important;
}
#categoriesDiv p a {
    margin: 0; 
}
#categoriesDiv {
    padding-top: 0; 
}

#categoriesDiv p {
    margin: 0;
    padding-top: 0; 
    padding-left: 50px;
}
.variants-container {
    margin-top: 5px; 
    padding-left: 50px;
}

.variant {
    display: block;
    color: #fefefe;
    text-decoration: none;
    font-size: small;
    transition: background-color 0.3s; 
    box-sizing: border-box; 
    padding-left: 25px;
}

.variant.highlighted {
    background-color: #f0f0f0; 
}


.variant:hover {
    color: #FF6900;
}

.highlighted {
    background-color: #fefefe;
    color: black !important;
}

.catBtns{
    padding-left: 10px;
    margin: 0;
}
.cat_btns{
    font-size: 10px;
    font-family: Century Gothic;
    border-radius: 5px;
    width: 70px;
    margin: 0;
    background-color: #404040;
}
.inputCat{
    padding-left: 50px;
    font-family: Century Gothic;
    font-size: 12px;
    color:#fefefe
}
.variants{
    padding-left: 100px;
    display: block;
}
.productsP{
  margin: 0;
  padding: 0
}
.variant-input{
    margin: 0;
    padding-left: 75px
}
.variant_input{
    font-family: Century Gothic;
    font-size: 13px;
    margin: 0;
    padding:0
}

.scrollable-content {
    max-height: 800px; 
    overflow-y: auto;
}
.done-div{
    position: absolute;
    padding: 0;
    margin: 0;
    top: 880px;
    bottom: 20px;
    left: 137px
   
}
.swal2-container {
    z-index: 10000; 
}
</style>
<div class="modal" id="add_category_modal" tabindex="0">
  <div class="modal-dialog ">
    <div class="modal-content categoryAdd">
      <div class="modal-title">
        <div class="warning-container">
            <div id="categoryData"  style="margin-top: 60px; margin-left: 10px">
              <h6 class="text-custom" style="color:#FF6900;">Category</h6>
            </div>
            <div class="catBtns">
              <button  class="cat_btns deLbTN">Del</button>
              <button onclick="addBtnCategory();addVariants()" class="cat_btns" id="addVariant">Add</button>
               <button  id="editCat" name="editBtn" class="editCat cat_btns">Edit</button>
            </div>
            <div class="productsHeader ">
               <p class="productsP" ><a href="#" onclick="changeValueInput(this)" class="productsBtn" id="showCategories"><span>+</span>&nbsp;Products</a></p><input hidden type="checkbox" id="addCategoryCheckbox" class="forAddCategory"/>
               <div id="categoriesDiv" class="scrollable-content" style="display: none;">
    
              </div>
           </div>
         </div>
         
        </div>
        <div class="done-div">
        <button   class="btn-success-custom doneBtn"  style="margin-right: 10px; width: 100px; height: 40px">Done</button>
    </div>
      </div>
      
    </div>
  </div>                      
</div>


<script>
function getCategories() {
    $.ajax({
            url: 'fetch-categories.php', 
            type: 'GET',
            success: function(response) {
                $('#categoriesDiv').html(response); 
                addEventListenerToInput()
                toRefreshCat()
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); 
                        }
                    });
  }



document.addEventListener("DOMContentLoaded", function() {
    getCategories()
   
 
});

function toRefreshCat(){
                var showCategoriesBtn = document.getElementById('showCategories');
                var categoriesDiv = document.getElementById('categoriesDiv');
                var spanIcon = showCategoriesBtn.querySelector('span');
                var addCategoryCheckbox = document.getElementById('addCategoryCheckbox');
                var inputCatSpan = document.querySelector('.inputCat');
                var singleInputBoxElement = document.querySelector('.variant-input');

                showCategoriesBtn.addEventListener('click', function() {
                    var variantContainers = document.querySelectorAll('[id^="variants_"]');
                    variantContainers.forEach(function(container) {
                        container.style.display = 'none';
                    });

                    var mainSpanCategories = document.querySelectorAll('[id^="mainSpanCategory"]');
                    mainSpanCategories.forEach(function(span) {
                        span.textContent = '+';
                    });

                    if (categoriesDiv.style.display === 'none') {
                        categoriesDiv.style.display = 'block';
                        spanIcon.textContent = '-';
                        addCategoryCheckbox.checked = true; 
                        inputCatSpan.setAttribute('hidden','hidden'); 
                        if(singleInputBoxElement){
                            singleInputBoxElement.setAttribute('hidden','hidden');
                        }
                    
                    } else {
                        categoriesDiv.style.display = 'none';
                        spanIcon.textContent = '+';
                        addCategoryCheckbox.checked = false; 
                        inputCatSpan.setAttribute('hidden','hidden'); 
                        
                        var categoryCheckboxes = document.querySelectorAll('.categoryCheckbox');
                        categoryCheckboxes.forEach(function(checkbox) {
                            checkbox.checked = false;
                        });
                    }
                });
}
var singleInputBox;
let  idCategories;
function fetchIdCategories(clickedId) {
        idCategories = clickedId  
        singleInputBox = `<span hidden id="spanVar" class="variant-input" style="display:flex; color: #fefefe">+&nbsp;<input hidden type="text" class="variant_input" id="cat_${idCategories}" placeholder="Enter Variant"></span>`;
        getVariants(clickedId)

}

let previouslyClicked = null;

function highlightRow(element) {
    if (previouslyClicked && previouslyClicked !== element) {
        previouslyClicked.classList.remove('highlighted');
        previouslyClicked.parentElement.classList.remove('highlighted');
        const previousSpan = previouslyClicked.querySelector('span');
        if (previousSpan) {
            previousSpan.textContent = "+";
        }
        previouslyClicked.style.color = "white";
    }

    element.parentElement.classList.toggle('highlighted');

    
    element.classList.toggle('highlighted');

    const spanElement = element.querySelector('span');
    if (spanElement) {
        if (element.classList.contains('highlighted')) {
            spanElement.textContent = "-";
            element.style.color = "black";
        } else {
            spanElement.textContent = "+";
            element.style.color = "white";
        }
    }

    previouslyClicked = element;
}

function toggleSpanVisibility() {
        var span = document.querySelector('.inputCat');
        var input = document.getElementById('inputCat');
        
        if (input === document.activeElement) {
            span.removeAttribute('hidden');
        } else {
            span.setAttribute('hidden', 'true');
            input.value=""
        } 
    }
    
 
    document.getElementById('inputCat').addEventListener('focus', toggleSpanVisibility);
    document.getElementById('inputCat').addEventListener('blur', toggleSpanVisibility);



function toggleCheckbox(id, name) {
    let checkValiDation = false;
    var checkbox = document.getElementById('catCheckbox_' + id);
    var previousInput = document.querySelector('.categoryInput');
    if (previousInput) {
        var previousAnchor = previousInput.nextElementSibling;
        previousAnchor.style.display = '';
        previousInput.parentNode.removeChild(previousInput);
    }
    // Uncheck checkboxes except for the clicked one
    var checkboxes = document.querySelectorAll('.categoryCheckbox');
    checkboxes.forEach(function(checkbox) {
        if (checkbox.id !== 'catCheckbox_' + id) {
            checkbox.checked = false;
        }
    });
    var catValue = document.getElementById('cat_Lbl');
    var categoriesInput = document.getElementById('categoriesInput');
    var id_cat = document.getElementById('catID');
    var idVar = document.getElementById('varID');
    
    if (checkbox) {
        checkValiDation = true
        editBtnCategory(id, name, checkbox); 
        checkbox.checked = !checkbox.checked;
        if (checkbox.checked) {
            catValue.value =  "/" + name ;
            var newValue = document.getElementById('cat_Lbl').value;
            var p_value =  document.getElementById('productLbl').value
            var catValue =  p_value + newValue
            $('.doneBtn').on('click', function(){
                categoriesInput.value = catValue 
                id_cat.value = id
                closeModal()
            })
          
            $('.deLbTN').on('click', function(){
                axios.delete(`api.php?action=deleteCategory&id=${id}`)
                .then(function(response){
                    if (response.data.success) {
                        getCategories();
                    } else {
                        Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Unable to delete categories!',
                        timer: 1000, 
                        timerProgressBar: true, 
                        showConfirmButton: false 
            });
                    }
                })
                .catch(function(error){
                    Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Error!',
                    timer: 1000, 
                    timerProgressBar: true, 
                    showConfirmButton: false 
            });
                });
            });
        
        } else {
            catValue.value = "";
            categoriesInput.value =  document.getElementById('productLbl').value;
            id_cat.value=""
            idVar.value = ""
        }
    }
}



function getVariants(catID) {
    const variantsContainer = document.getElementById(`variants_${catID}`);
    const mainSpanCategory = document.getElementById(`mainSpanCategory_${catID}`);
  

    const allVariantsContainers = document.querySelectorAll('[id^="variants_"]');
    allVariantsContainers.forEach(container => {
        if (container.id !== `variants_${catID}`) {
            container.style.display = 'none';
            const categoryId = container.id.split('_')[1];
            const mainSpan = document.getElementById(`mainSpanCategory_${categoryId}`);
            if (mainSpan) {
                mainSpan.textContent = '+';
            }
        }
    });
    axios.get(`api.php?action=getVariantsData&cat_id=${catID}`)
    .then(response => {
        const variants = response.data.variants;
        if (variantsContainer.style.display === 'none') {
            if (!variants || variants.length === 0) {
                variantsContainer.innerHTML = singleInputBox;
                variantsContainer.style.display = 'block'; 
                if (mainSpanCategory) {
                    mainSpanCategory.textContent = '-'; 
                }
                
            } else {
                // const variantsList = variants.map(variant => `<p class="variants variant-container"  style="display: flex">
                //     <a id="variants_${variant.variant_id}" href="#" style="text-decoration: none;" class="variant" onclick="handleClick(event, this)">
                //         <span>+</span>&nbsp;${variant.variant_name}
                //     </a>
                //     <input type="checkbox"  id="${variant.variant_id}">
                // </p>`).join('');
                // const variantsList = variants.map(variant => `<p class="variants variant-container"  style="display: flex">
                //     <a id="variants_${variant.variant_id}" href="#" style="text-decoration: none;" class="variant" onclick="handleClick(event, this);highlightRow(this);">
                //         <span>+</span>&nbsp;${variant.variant_name}
                //     </a>
                //     <input type="checkbox" class="variant-checkbox" id="${variant.variant_id}">
                // </p>`).join('');
                const variantsList = variants.map(variant => `<p class="variants variant-container" style="display: flex">
                    <a href="#" style="text-decoration: none;" class="variant" onclick="handleClick(event, this, ${variant.id});highlightRow(this)">
                        <span>+</span>&nbsp;${variant.variant_name}
                    </a>
                    <input hidden type="checkbox" class="variant-checkbox" id="variant_${variant.id}">
                </p>`).join('');

                const finalVariantList = variantsList + singleInputBox;

                if (variantsContainer) {
                    variantsContainer.innerHTML = finalVariantList;
                    variantsContainer.style.display = 'block';
                }
                if (mainSpanCategory) {
                    mainSpanCategory.textContent = '-';
                }
            }
        } else {
            variantsContainer.style.display = 'none';
            if (mainSpanCategory) {
                mainSpanCategory.textContent = '+';
            }
        }
    })
    .catch(error => {
        console.error('Error fetching variants:', error);
    });

}




function handleClick(event, anchor,id) {
    event.preventDefault();
    const checkbox = anchor.nextElementSibling;
    const isChecked = checkbox.checked;
    
    
    const previousCheckedCheckbox = document.querySelector('.variant-checkbox:checked');
    if (previousCheckedCheckbox && previousCheckedCheckbox !== checkbox) {
        previousCheckedCheckbox.checked = false;
    }

    checkbox.checked = !isChecked;

    var varLbl = document.getElementById('var_Lbl');
    var categoriesInput = document.getElementById('categoriesInput');
    var productInputLbl = document.getElementById('productLbl')
    var newValue = document.getElementById('cat_Lbl').value;
    var idVar = document.getElementById('varID');
    if (checkbox.checked) {
        // const variantId = checkbox.id;
        const variantName = anchor.textContent.trim().replace('+', '').trim();
        varLbl.value = "/" + variantName;
        var c_value =  productInputLbl.value + newValue +  varLbl.value
        $('.doneBtn').on('click', function(){
            categoriesInput.value = c_value;
            idVar.value = id
            closeModal()
        })
        if(variantName){
        // $('.deLbTN').on('click', function(){
        //         axios.delete(`api.php?action=deleteVariants&id=${id}`)
        //         .then(function(response){
        //                 getCategories();
                  
        //         })
        //         .catch(function(error){
        //           console.log(error)
        //         });
        //     });
         }
    }else{
        varLbl.value = ""
        idVar.value =  ""
    }
}






function highlight(element) {
    const categoriesDiv = document.getElementById('categoriesDiv');
    if (element.id === 'showCategories') {
        const highlightedElement = document.querySelector('.highlighted');
        if (highlightedElement) {
            highlightedElement.classList.remove('highlighted');
            const spanElement = highlightedElement.querySelector('span');
            if (spanElement) {
                spanElement.textContent = "+";
                highlightedElement.style.color = "white";
            }
        }
        return;
    }
    const previouslyClicked = document.querySelector('.highlighted');
    if (previouslyClicked && previouslyClicked !== element) {
        previouslyClicked.classList.remove('highlighted');
        const previousSpan = previouslyClicked.querySelector('span');
        if (previousSpan) {
            previousSpan.textContent = "+";
            previouslyClicked.style.color = "white";
        }
    }

  
    element.parentElement.classList.toggle('highlighted');
    element.classList.toggle('highlighted');

    const spanElement = element.querySelector('span');
    if (spanElement) {
        if (element.classList.contains('highlighted')) {
            spanElement.textContent = "-";
            element.style.color = "black";
        } else {
            spanElement.textContent = "+";
            element.style.color = "white";
        }
    }
}



function addBtnCategory() {
    var addCategoryCheckbox = document.getElementById('addCategoryCheckbox');
    var inputCategory = document.getElementById('inputCat');
    var inputCatSpan = document.querySelector('.inputCat');
    var categoryCheckboxes = document.querySelectorAll('.categoryCheckbox');
    var anyChecked = false;

   
    categoryCheckboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            anyChecked = true;
        }
    });

    if (addCategoryCheckbox.checked && !anyChecked) {
        inputCatSpan.removeAttribute('hidden');
        inputCategory.focus();
    } else {
        inputCatSpan.setAttribute('hidden', 'hidden'); 
        inputCategory.value = ""; 
    }
}


function validateCategories() {
    const checkboxes = document.querySelectorAll('.categoryCheckbox');
    for (let i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            return true; 
        }
    }
    return false; 
}



let variantsContainer;


function addVariants() {
    if ($('.categoryCheckbox:checked').length > 0) {
    const singleInputBoxElement = document.getElementById('cat_' + idCategories);
    const singleSpanElement = singleInputBoxElement.parentElement;
    if (idCategories) {
            singleInputBoxElement.removeAttribute('hidden');
            singleSpanElement.removeAttribute('hidden');
      
        document.getElementById('cat_' + idCategories).addEventListener('keydown', function(e) {
        switch(e.which) {
            case 13:
                e.preventDefault();
                var inputedVariant = document.getElementById('cat_' + idCategories).value
                console.log(inputedVariant)
                axios.post('api.php?action=addVariant', {
                        id:idCategories,
                        variantName: inputedVariant
                    }).then(function(response) {
                        const variantsContainer = document.getElementById(`variants_${idCategories}`);
    const mainSpanCategory = document.getElementById(`mainSpanCategory_${idCategories}`);
 
    // Hide all variant containers except the one being clicked
    const allVariantsContainers = document.querySelectorAll('[id^="variants_"]');
    allVariantsContainers.forEach(container => {
        if (container.id !== `variants_${idCategories}`) {
            container.style.display = 'none';
            const categoryId = container.id.split('_')[1];
            const mainSpan = document.getElementById(`mainSpanCategory_${categoryId}`);
            if (mainSpan) {
                mainSpan.textContent = '+';
            }
        }
    });
    axios.get(`api.php?action=getVariantsData&cat_id=${idCategories}`)
    .then(response => {
        const variants = response.data.variants;
        const variantsList = variants.map(variant => `<p class="variants variant-container" style="display: flex">
                    <a href="#" style="text-decoration: none;" class="variant" onclick="handleClick(event, this, ${variant.id});highlightRow(this)">
                        <span>+</span>&nbsp;${variant.variant_name}
                    </a>
                    <input hidden type="checkbox" class="variant-checkbox" id="variant_${variant.id}">
                </p>`).join('');


                const finalVariantList = variantsList + singleInputBox;
                if (variantsContainer) {
                    variantsContainer.innerHTML = finalVariantList;
                    variantsContainer.style.display = 'block';
                }
                if (mainSpanCategory) {
                    mainSpanCategory.textContent = '-';
                }
            
        
    })
    .catch(error => {
        console.error('Error fetching variants:', error);
    });
                    }).catch(function(error) {
                        console.log(error);
                    });
                break;
            default:
                return;
        }
        e.preventDefault();
    });

    }else {
        singleSpanElement.setAttribute('hidden', 'true');
        singleInputBoxElement.setAttribute('hidden', 'true');
        singleInputBoxElement.value = "";
    }
}
}


function addEventListenerToInput() {
    document.getElementById('inputCat').addEventListener('keydown', function(e) {
        switch(e.which) {
            case 13:
                var addCategoryCheckbox = document.getElementById('addCategoryCheckbox');
                var dataValue = document.getElementById('inputCat').value
                if(addCategoryCheckbox.checked === true && dataValue) {
                    axios.post('api.php?action=addCategory', {
                        category: dataValue
                    }).then(function(response) {
                        getCategories();
                        toRefreshCat()
                    }).catch(function(error) {
                        console.log(error);
                    });
                }
                break;
            default:
                return;
        }
        e.preventDefault();
    });
}





function editBtnCategory(id, name ,checkbox) {
    $(document).off('click', '.editCat').on('click', '.editCat', function() {
        if (id && name && checkbox.checked === true) {
            $('#paragraph_' + id).removeClass('highlighted'); 
            var categoryName = $('#mainSpanCategory_' + id).text().trim();
            if (categoryName.startsWith('+')) {
                categoryName = categoryName.substring(1);
            }
            var anchorElement = $('#mainSpanCategory_' + id).parent();
            var spanElement = anchorElement.find('span');

            var inputElement = $('<input>').attr({
                type: 'text',
                value: name,
                style: 'margin: 0; padding: 0;'
            });

            var spanPlus = $('<span>').text('+').css({
                'color': 'white',
                'margin-right': '5px'
            });
            anchorElement.hide();
            spanElement.hide();
            anchorElement.after(inputElement).after(spanPlus);
            inputElement.focus();

            inputElement.val(inputElement.val());
            inputElement[0].selectionStart = inputElement[0].selectionEnd = inputElement.val().length;

            inputElement.on('blur', function(event) {
                var newValue = inputElement.val().trim();
                if (newValue !== '' && newValue !== name) {
                    name = newValue;
                    spanElement.text(newValue);
                    forCategoryUpdate(id, newValue);
                }
                inputElement.remove();
                spanPlus.remove();
                anchorElement.show();
                spanElement.show();
                if ($('#catCheckbox_' + id).is(':checked')) {
                    $('#paragraph_' + id).addClass('highlighted');
                }
            });

            inputElement.on('keydown', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    var newValue = inputElement.val().trim();
                    if (newValue !== '' && newValue !== name) {
                        name = newValue;
                        spanElement.text(newValue);
                        forCategoryUpdate(id, newValue);

                    }
                    inputElement.remove();
                    spanPlus.remove();
                    anchorElement.show();
                    spanElement.show();

                    if ($('#catCheckbox_' + id).is(':checked')) {
                        $('#paragraph_' + id).addClass('highlighted');
                    }
                }
            });
        }
    });
}



function forCategoryUpdate(id, newValue) {
    axios.post('api.php?action=updateDataCategory', {
        id: id,
        name: newValue
    }).then(function(response) {
        getCategories();
        uncheckCategoryCheckbox(id);
    }).catch(function(error) {
        console.log(error);
    });
}


function uncheckCategoryCheckbox(id) {
    var checkbox = document.getElementById('catCheckbox_' + id);
    if (checkbox) {
        checkbox.checked = false;
    }
}


function closeModal(){
  $('#add_category_modal').css('animation', 'slideOutRight 0.5s forwards');
  $('.categoryAdd').css('animation', 'slideOutRight 0.5s forwards');
  $('.highlighted').removeClass('highlighted');
 
  $('#add_category_modal').one('animationend', function() {
    $(this).hide();
    $(this).css('animation', '');
    $('.categoryAdd').css('animation', '');
   
  });
}

function changeValueInput(element) {
    var categoriesInput = document.getElementById('categoriesInput');
    var productInputLbl = document.getElementById('productLbl')
    var spanIcon = document.getElementById('showCategories').querySelector('span');
    var newValue = document.getElementById('cat_Lbl')
    var varLbl = document.getElementById('var_Lbl');
    var id_cat = document.getElementById('catID');
    var idVar = document.getElementById('varID');
    if (spanIcon.textContent === "+") {
        productInputLbl.value = "Product"; 
        var prd_value = document.getElementById('productLbl').value;
        $('.doneBtn').on('click', function(){
        categoriesInput.value = prd_value;
        closeModal()
        })
    } else {
        productInputLbl.value = ""; 
        var prd_value = document.getElementById('productLbl').value;
        categoriesInput.value = prd_value;
        newValue.value = ""
        varLbl.value = ""
        id_cat.value = ""
        idVar.value = ""
    }
}




</script>


