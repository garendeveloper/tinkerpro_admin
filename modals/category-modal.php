                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <style>

#add_category_modal {
  display: none;
  position: fixed; 
  z-index: 9999;
  top: 0;
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
  height: 1000px; 
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




</style>

<div class="modal" id="add_category_modal" tabindex="0">
  <div class="modal-dialog ">
    <div class="modal-content categoryAdd">
      <div class="modal-title">
        <div class="warning-container">
        <div style="margin-top: 40px; margin-left: 10px">
           <h6 class="text-custom" style="color:#FF6900;">Category</h6>
        </div>
        <div class="catBtns">
        <button  class="cat_btns">Del</button>
        <button onclick="addBtnCategory();addVariants()" class="cat_btns" id="addVariant">Add</button>
        <button onclick="" id="editCat" name="editBtn" class="editCat cat_btns">Edit</button>
        </div>
        <div class="productsHeader">
             <p class="productsP" ><a href="#" onclick="highlight(this)" class="productsBtn" id="showCategories"><span>+</span>&nbsp;Products</a></p><input hidden type="checkbox" id="addCategoryCheckbox" class="forAddCategory"/>
    <div id="categoriesDiv" style="display: none;">
    <?php
    $productFacade = new ProductFacade;
    $categories = $productFacade->getCategories();
    while ($row = $categories->fetch(PDO::FETCH_ASSOC)) {
        $rowId = htmlspecialchars($row['id']); // Get the row ID
        $categoryName = htmlspecialchars($row['category_name']); // Get the category name
        echo '<p id="paragraph_' . $rowId . '">';
        echo '<a href="#" onclick="fetchIdCategories(\'' . $rowId . '\');highlightRow(this, \'' . $rowId . '\', \'' . $categoryName . '\');toggleCheckbox(\'' . $rowId . '\', \'' . $categoryName . '\');getVariants(\'' . $rowId . '\');" class="productCategory" style="text-decoration: none;" data-value="' . $rowId . '">';
        echo '<span id="mainSpanCategory_' . $rowId . '">+</span>&nbsp;' . $categoryName . '</a>';
        echo '<input hidden  type="checkbox" name="categoryCheckbox" class="categoryCheckbox" id="catCheckbox_' . $rowId . '"/></p>';
        echo '<div id="variants_' . $rowId . '"></div>';
    }
    echo '<span hidden class="inputCat">+<input type="text" id="inputCat" name="category_input " placeholder="Enter Category"></span>';
    ?>
</div>
</div>
   </div>
        </div>
      </div>
    </div>
  </div>                      
</div>


<script>
   


document.addEventListener("DOMContentLoaded", function() {
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

        // Reset mainSpanCategory texts to '+'
        var mainSpanCategories = document.querySelectorAll('[id^="mainSpanCategory"]');
        mainSpanCategories.forEach(function(span) {
            span.textContent = '+';
        });

        // Toggle display of categoriesDiv
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
});

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
    var checkbox = document.getElementById('catCheckbox_' + id);
    editBtnCategory(id, name, checkbox);
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


    var checkbox = document.getElementById('catCheckbox_' + id);
    if (checkbox) {
        checkbox.checked = !checkbox.checked;
    } else {
        console.error('Checkbox element not found for id: ' + id);
    }
  
}




function getVariants(catID) {
    const variantsContainer = document.getElementById(`variants_${catID}`);
    const mainSpanCategory = document.getElementById(`mainSpanCategory_${catID}`);
    const singleInputBox = `<span hidden id="spanVar" class="variant-input" style="display:flex; color: #fefefe">+&nbsp;<input hidden type="text" class="variant_input" id="cat_${catID}" placeholder="Enter Variant"></span>`;

    // Hide all variant containers except the one being clicked
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
                const variantsList = variants.map(variant => `<p class="variants variant-container"  style="display: flex">
                    <a id="variants_${variant.variant_id}" href="#" style="text-decoration: none;" class="variant" onclick="highlightRow(this);handleClick(event, this)">
                        <span>+</span>&nbsp;${variant.variant_name}
                    </a>
                    <input type="checkbox" hidden  id="${variant.variant_id}">
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




function handleClick(event, anchor) {
    event.preventDefault();

 
    const previousCheckedCheckbox = document.querySelector('.variant-checkbox:checked');
    if (previousCheckedCheckbox) {
        previousCheckedCheckbox.checked = false;
    }

   
    const checkbox = anchor.nextElementSibling;
    checkbox.checked = !checkbox.checked;
}






let previouslyClicked = null;

function highlightRow(element) {
    console.log(element)
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


let  idCategories;
function fetchIdCategories(clickedId) {
        idCategories = clickedId  

}


let variantsContainer;


function addVariants() {
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
                axios.post('api.php?action=addVariant', {
                        id:idCategories,
                        variantName: inputedVariant
                    }).then(function(response) {
                        const variantsContainer = document.getElementById(`variants_${idCategories}`);
    const mainSpanCategory = document.getElementById(`mainSpanCategory_${idCategories}`);
    const singleInputBox = `<span hidden id="spanVar" class="variant-input" style="display:flex; color: #fefefe">+&nbsp;<input hidden type="text" class="variant_input" id="cat_${idCategories}" placeholder="Enter Variant"></span>`;

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
      
                const variantsList = variants.map(variant => `<p class="variants variant-container"  style="display: flex">
                    <a id="variants_${variant.variant_id}" href="#" style="text-decoration: none;" class="variant" onclick="highlightRow(this);handleClick(event, this)">
                        <span>+</span>&nbsp;${variant.variant_name}
                    </a>
                    <input type="checkbox" hidden  id="${variant.variant_id}">
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


addEventListenerToInput();


function getCategories() {
    $.ajax({
        url: 'api.php?action=getDataCategory',
        type: 'GET',
        success: function (response) {
            $('#categoriesDiv').empty();
            $.each(response.categories, function (index, category) {
                var categoryId = category.id;
                var categoryName = category.category_name
                // var categoryHTML = '<p><a href="#" onclick="getVariants(' + categoryId + ')" class="productCategory" style="text-decoration: none;" data-value="' + categoryId + '" data-checkbox-id="catCheckbox_' + categoryId + '" data-category-name="' + categoryName + '">';
                // categoryHTML += '<span id="mainSpanCategory_' + categoryId + '">+</span>&nbsp' + category.category_name + '</a>&nbsp';
                // categoryHTML += '<input  type="checkbox" class="categoryCheckbox" id="catCheckbox_' + categoryId + '"></p>';
                // categoryHTML += '<div id="variants_' + categoryId + '"></div>';
                // $('#categoriesDiv').append(categoryHTML);
                var categoryHTML = '<p><a href="#" onclick="fetchIdCategories(\'' + categoryId + '\'); highlightRow(this, \'' + categoryId + '\', \'' + categoryName + '\'); toggleCheckbox(\'' + categoryId + '\', \'' + categoryName + '\'); getVariants(\'' + categoryId + '\');" class="productCategory" style="text-decoration: none;" data-value="' + categoryId + '" data-checkbox-id="catCheckbox_' + categoryId + '" data-category-name="' + categoryName + '">';
                    categoryHTML += '<span id="mainSpanCategory_' + categoryId + '">+</span>&nbsp;' + category.category_name + '</a>&nbsp;';
                    categoryHTML += '<input hidden type="checkbox" class="categoryCheckbox" id="catCheckbox_' + categoryId + '"></p>';
                    categoryHTML += '<div id="variants_' + categoryId + '"></div>';
                    $('#categoriesDiv').append(categoryHTML);                  
            });
       
            $('input.categoryCheckbox').change(function () {
            if ($(this).is(':checked')) {
                $('input.categoryCheckbox').not(this).prop('checked', false);
            }
        });
         
            $('a.productCategory').click(function (e) {
                e.preventDefault();
                var checkboxId = $(this).data('checkbox-id');
                var categoryId = checkboxId.split('_')[1];
                var categoryName = $(this).data('category-name');
                var checkbox = $('#' + checkboxId);
                var checkbox2 = document.getElementById('catCheckbox_' + categoryId);
                editBtnCategory(categoryId,categoryName, checkbox2)
                if (!checkbox.prop('checked')) {
                    $('input[type="checkbox"]').prop('checked', false);
                    checkbox.prop('checked', true);
                }
            });
    
            var inputHTML = '<span hidden class="inputCat">+<input type="text" id="inputCat" name="category_input" placeholder="Enter Category"></span>';
            $('#categoriesDiv').append(inputHTML);
            var addCategoryCheckbox = document.getElementById('addCategoryCheckbox');
            addBtnCategory.checked = false
            $('#categoriesDiv').show();
            addEventListenerToInput();
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}





function editBtnCategory(id, name, checkbox) {
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
       
    }).catch(function(error) {
        console.log(error);
    });
}

function closeModal(){
  $('#add_category_modal').css('animation', 'slideOutRight 0.5s forwards');
  $('.categoryAdd').css('animation', 'slideOutRight 0.5s forwards');
  // $('.highlighted').removeClass('highlighted');
 
  $('#add_category_modal').one('animationend', function() {
    $(this).hide();
    $(this).css('animation', '');
    $('.categoryAdd').css('animation', '');
   
  });
}


</script>


