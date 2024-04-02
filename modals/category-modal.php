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
#categories p {
    padding-left: 50px
}
.productCategory:hover{
    color: #FF6900 !important;
}
#categories p a {
    margin: 0; 
}
#categories {
    padding-top: 0; 
}

#categories p {
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
    padding-left: 75px;
    transition: background-color 0.3s; 
    box-sizing: border-box; 
}

.variant.highlighted {
    background-color: #f0f0f0; 
}


.variant:hover {
    color: #FF6900;
}

.highlighted {
    background-color: #fefefe;
    color: black;
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
        <button onclick="addBtnCategory()" class="cat_btns">Add</button>
        <button onclick="" id="editCat" name="editBtn" class="editCat cat_btns">Edit</button>
        </div>
        <div class="productsHeader">
    <a href="#" class="productsBtn" id="showCategories"><span>+</span>&nbsp;Products</a><input hidden type="checkbox" id="addCategoryCheckbox" class="forAddCategory"/>
    <div id="categories" style="display: none;">
        <?php
        $productFacade = new ProductFacade;
        $categories = $productFacade->getCategories();
        while ($row = $categories->fetch(PDO::FETCH_ASSOC)) {
            echo '<p onclick="highlightRow(this)"><a href="#" onclick="toggleCheckbox(' . htmlspecialchars($row['id']) . ', \'' . htmlspecialchars($row['category_name']). '\');" 
            class="productCategory" style="text-decoration: none;" data-value="' . htmlspecialchars($row['id']) . '"><span id="mainSpanCategory_' . htmlspecialchars($row['id']) . '">+</span>&nbsp' . htmlspecialchars($row['category_name']) . '</a>
            <input hidden  type="checkbox" class="categoryCheckbox" id="catCheckbox_' . htmlspecialchars($row['id']) . '"/></p>';
            echo '<div id="variants_' . htmlspecialchars($row['id']) . '"></div>';
           
        }
         echo '<span hidden class="inputCat">+<input  type="text" id="inputCat" name="category_input " placeholder="Enter Category"></span>';
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
    var categoriesDiv = document.getElementById('categories');
    var spanIcon = showCategoriesBtn.querySelector('span');
    var addCategoryCheckbox = document.getElementById('addCategoryCheckbox');
    var inputCatSpan = document.querySelector('.inputCat');
    showCategoriesBtn.addEventListener('click', function() {
        // Hide all category variants
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
        } else {
            categoriesDiv.style.display = 'none';
            spanIcon.textContent = '+';
            addCategoryCheckbox.checked = false; 
            inputCatSpan.setAttribute('hidden','hidden'); 
            
            // Uncheck all category checkboxes
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
    console.log(name);
    getVariants(id);
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

    // Toggle the clicked checkbox
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

    if (variantsContainer.style.display === 'none') {
        axios.get(`api.php?action=getVariantsData&cat_id=${catID}`)
            .then(response => {
                const variants = response.data.variants;
                const variantsList = variants.map(variant => `<a href="#" style="text-decoration: none;" class="variant" onclick="highlightRow(this)"><span>+</span>&nbsp;${variant.variant_name}</a>`).join('');

                if (variants.length > 0) {
                    if (variantsContainer) {
                        variantsContainer.innerHTML = variantsList; 
                        variantsContainer.style.display = 'block';
                    }
                    if (mainSpanCategory) {
                        mainSpanCategory.textContent = '-';
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching variants:', error);
            });
    } else {
        variantsContainer.style.display = 'none';
        if (mainSpanCategory) {
            mainSpanCategory.textContent = '+';
        }
    }
}


let previouslyClicked = null;

// function highlightRow(element) {
//     if (previouslyClicked && previouslyClicked !== element) {
//         previouslyClicked.classList.remove('highlighted');
//         const previousSpan = previouslyClicked.querySelector('span');
//         if (previousSpan) {
//             previousSpan.textContent = "+";
//         }
//         previouslyClicked.style.color = "white";
//     }
//     element.classList.toggle('highlighted');

//     const spanElement = element.querySelector('span');
//     if (spanElement) {
//         if (element.classList.contains('highlighted')) {
//             spanElement.textContent = "-";
//             element.style.color = "black";
//         } else {
//             spanElement.textContent = "+";
//             element.style.color = "white";
//         }
//     }

//     previouslyClicked = element;
// }

function highlightRow(element) {
    if (previouslyClicked && previouslyClicked !== element) {
        previouslyClicked.classList.remove('highlighted');
        const previousSpan = previouslyClicked.querySelector('span');
        if (previousSpan) {
            previousSpan.textContent = "+";
            previousSpan.style.color = "black"; 
        }
        previouslyClicked.style.color = "white";
    }
    element.classList.toggle('highlighted');

    const spanElement = element.querySelector('span');
    if (spanElement) {
        if (element.classList.contains('highlighted')) {
            spanElement.textContent = "-";
            spanElement.style.color = "black";
            element.style.color = "black"; 
        } else {
            spanElement.textContent = "+";
            spanElement.style.color = "black";
            element.style.color = "white"; 
        }
    }

    previouslyClicked = element;
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

// Call this function whenever new input field is added
addEventListenerToInput();


function getCategories() {
    $.ajax({
        url: 'api.php?action=getDataCategory',
        type: 'GET',
        success: function (response) {
            $('#categories').empty();
            $.each(response.categories, function (index, category) {
                var categoryId = category.id;
                var categoryName = category.category_name
                var categoryHTML = '<p><a href="#" onclick="getVariants(' + categoryId + ')" class="productCategory" style="text-decoration: none;" data-value="' + categoryId + '" data-checkbox-id="catCheckbox_' + categoryId + '" data-category-name="' + categoryName + '">';
                categoryHTML += '<span id="mainSpanCategory_' + categoryId + '">+</span>&nbsp' + category.category_name + '</a>&nbsp';
                categoryHTML += '<input hidden type="checkbox" class="categoryCheckbox" id="catCheckbox_' + categoryId + '"></p>';
                categoryHTML += '<div id="variants_' + categoryId + '"></div>';
                $('#categories').append(categoryHTML);
                
            });
       
            $('input[type="checkbox"]').change(function () {
                if ($(this).is(':checked')) {
                    $('input[type="checkbox"]').not(this).prop('checked', false);
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
            $('#categories').append(inputHTML);
            var addCategoryCheckbox = document.getElementById('addCategoryCheckbox');
            addBtnCategory.checked = false
            $('#categories').show();
            addEventListenerToInput();
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}
getCategories();




function editBtnCategory(id, name, checkbox) {
    $(document).off('click', '.editCat').on('click', '.editCat', function() {
        if (id && name && checkbox.checked === true) {
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


</script>


