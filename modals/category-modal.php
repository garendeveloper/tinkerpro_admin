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
        <button  class="cat_btns">Edit</button>
        </div>
        <div class="productsHeader">
    <a href="#" class="productsBtn" id="showCategories"><span>+</span>&nbsp;Products</a><input hidden type="checkbox" id="addCategoryCheckbox" class="forAddCategory"/>
    <div id="categories" style="display: none;">
        <?php
        $productFacade = new ProductFacade;
        $categories = $productFacade->getCategories();
        while ($row = $categories->fetch(PDO::FETCH_ASSOC)) {
            echo '<p><a href="#" onclick="toggleCheckbox(' . htmlspecialchars($row['id']) . ', \'' . htmlspecialchars($row['category_name']). '\')" 
            class="productCategory" style="text-decoration: none;" data-value="' . htmlspecialchars($row['id']) . '"><span id="mainSpanCategory_' . htmlspecialchars($row['id']) . '">+</span>&nbsp' . htmlspecialchars($row['category_name']) . '</a>
            <input hidden type="checkbox" class="categoryCheckbox" id="catCheckbox_' . htmlspecialchars($row['id']) . '"/></p>';
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
        }
    });
});

// function toggleCheckbox(id, name){
//     console.log(name)
//     getVariants(id);
//     editBtnCategory(id,name)
//     var checkboxes = document.querySelectorAll('.categoryCheckbox');
//     checkboxes.forEach(function(checkbox) {
//         if (checkbox.id !== 'catCheckbox_' + id) {
//             checkbox.checked = false;
//         }
//     });

   
//     var checkbox = document.getElementById('catCheckbox_' + id);
//     if (checkbox) {
//         checkbox.checked = !checkbox.checked; 
//     } else {
//         console.error('Checkbox element not found for id: ' + id);
//     }
// }

function toggleCheckbox(id, name) {
    console.log(name);
    getVariants(id);

    // Find and remove the previous input element
    var previousInput = document.querySelector('.categoryInput');
    if (previousInput) {
        var previousAnchor = previousInput.nextElementSibling;
        previousAnchor.style.display = ''; // Show the anchor element
        previousInput.parentNode.removeChild(previousInput); // Remove the previous input element
    }

    // Create and display the input element for the clicked category
    editBtnCategory(id, name);

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

function highlightRow(element) {
    if (previouslyClicked && previouslyClicked !== element) {
        previouslyClicked.classList.remove('highlighted');
        const previousSpan = previouslyClicked.querySelector('span');
        if (previousSpan) {
            previousSpan.textContent = "+";
        }
        previouslyClicked.style.color = "white";
    }
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

function addBtnCategory(){
    var addCategoryCheckbox = document.getElementById('addCategoryCheckbox');
    var inputCatSpan = document.querySelector('.inputCat');
    if(addCategoryCheckbox.checked === true){
        inputCatSpan.removeAttribute('hidden'); 
    }
}


document.getElementById('inputCat').addEventListener('keydown', function(e) {
    switch(e.which) {
        case 13:
            var addCategoryCheckbox = document.getElementById('addCategoryCheckbox');
            var dataValue = document.getElementById('inputCat').value
            if(addCategoryCheckbox.checked === true && dataValue) {
               axios.post('api.php?action=addCategory',{
                category: dataValue
               }).then(function(response){
                  getCategories()
               }).catch(function(error){
                console.log(error)
               })
            } 
            break;
        default: 
            return; 
    }
    e.preventDefault(); 
});

function getCategories(){
    $.ajax({
            url: 'api.php?action=getDataCategory', 
            type: 'GET',
            success: function(response) {
            $('#categories').empty();
            $.each(response.categories, function(index, category) {
                var categoryHTML = '<p><a href="#" onclick="getVariants(' + category.id + ')" class="productCategory" style="text-decoration: none;" data-value="' + category.id + '">';
                categoryHTML += '<span id="mainSpanCategory_' + category.id + '">+</span>&nbsp' + category.category_name + '</a>&nbsp';
                categoryHTML += '<input type="checkbox"  class="categoryCheckbox" id="catCheckbox_' + category.id + '"></p>';
                categoryHTML += '<div id="variants_' + category.id + '"></div>';
                $('#categories').append(categoryHTML);
            });
            $('input[type="checkbox"]').change(function() {
                if ($(this).is(':checked')) {
                    $('input[type="checkbox"]').not(this).prop('checked', false);
                }
            });
         
            var inputHTML = '<span hidden class="inputCat">+<input type="text" id="inputCat" name="category_input" placeholder="Enter Category"></span>';
            $('#categories').append(inputHTML);
            var addCategoryCheckbox = document.getElementById('addCategoryCheckbox');
            addBtnCategory.checked = false
            $('#categories').show();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); 
            }
        });
}
getCategories()

// function editBtnCategory(id, name) {
//     if (id) {
//         var categoryName = document.getElementById('mainSpanCategory_' + id).textContent.trim();
//         var inputElement = document.createElement('input');
//         inputElement.type = 'text';
//         inputElement.value = categoryName;
//         var anchorElement = document.getElementById('mainSpanCategory_' + id).parentNode;
//         anchorElement.style.display = 'none';
//         anchorElement.parentNode.insertBefore(inputElement, anchorElement);
        

//         inputElement.focus();
//         inputElement.addEventListener('input', function(event) {
//             if (!inputElement.value.startsWith(categoryName)) {
//                 inputElement.value = categoryName + inputElement.value.substring(categoryName.length);
//             }
//         });
//     }
// }
// function editBtnCategory(id, name) {
//     if (id) {
//         var categoryName = document.getElementById('mainSpanCategory_' + id).textContent.trim();
//         var inputElement = document.createElement('input');
//         inputElement.type = 'text';
//         inputElement.value = name; // Set the value of the input box to the provided name
//         var anchorElement = document.getElementById('mainSpanCategory_' + id).parentNode;
//         anchorElement.style.display = 'none';
//         anchorElement.parentNode.insertBefore(inputElement, anchorElement);

//         inputElement.focus();
//         inputElement.addEventListener('input', function(event) {
//             if (!inputElement.value.startsWith(categoryName)) {
//                 inputElement.value = categoryName + inputElement.value.substring(categoryName.length);
//             }
//         });
//     }
// }



</script>


