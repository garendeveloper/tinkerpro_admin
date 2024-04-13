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
  from {margin-right: -100%;
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
.black-text {
    color: black !important;
}
.white-text {
    color: #fefefe !important;
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
              <button   class="cat_btns addCategory" >Add</button>
               <button  id="editCat" name="editBtn" class="editCat cat_btns">Edit</button>
            </div>
            <div class="productsHeader ">
               <p class="productsP" ><a href="#" class="productsBtn" id="showCategories"><span>+</span>&nbsp;Products</a></p><input hidden type="checkbox" id="addCategoryCheckbox" class="forAddCategory"/>
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
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); 
                        }
        });
  }

$(document).ready(function() {
    var categoriesVisible = false; 
    $('#categoriesDiv').hide();
    $('#showCategories').click(function() {
        $('#categoriesDiv').toggle();
        categoriesVisible = !categoriesVisible; 
        $('.productsP').toggleClass('highlighted', categoriesVisible);
        $('.productsBtn').toggleClass('black-text', categoriesVisible).toggleClass('white-text', !categoriesVisible);
        
        if (categoriesVisible) {
            getCategories();
            $(this).text('- Products');
        } else {
            $(this).text('+ Products'); 
            $('.productsP').removeClass('highlighted');
        }
    });

var previousSpan = null;
$(document).on("click", ".customAnchor", function() {
  
    $('.customAnchor').removeClass('highlighted black-text');
    $('.categoriesParagraph').removeClass('highlighted');
    $('.productsP').removeClass('highlighted');
    $('.productsBtn').addClass('white-text');
    if (previousSpan !== null) {
        previousSpan.text('+');
    }

    $(this).addClass('highlighted black-text');
    var index = $(this).index('.customAnchor');
    var categoryId = $(this).data('category-id');

 
    if (categoryId !== undefined && index !== undefined) {
        getVariants(categoryId);
    }
 
    $('.categoriesParagraph').eq(index).addClass('highlighted');
    var currentSpan = $(this).find('span');
    if ($(this).hasClass('highlighted')) {
        currentSpan.text('-');
    } else {
        currentSpan.text('+');
    }
    previousSpan = currentSpan;
});


    $('.addCategory').off('click').on('click',function() {
    if ($('.productsP').hasClass('highlighted')) {
        $('.inputCat').removeAttr('hidden')
        $('#inputCat').focus(); 
    }
});

$('.editCat').off('click').on("click",function(){
    var indexCat = $('.customAnchor.highlighted').data('index');
    var categoryId = $('.customAnchor.highlighted').data('category-id');
    
    if(indexCat !== undefined && indexCat !== null && categoryId !== undefined && categoryId !== null){
       editCategory(indexCat, categoryId)
    }
})
$('.deLbTN').off('click').on("click",function(){
    var indexCat = $('.customAnchor.highlighted').data('index');
    var categoryId = $('.customAnchor.highlighted').data('category-id');
    
    if(indexCat !== undefined && indexCat !== null && categoryId !== undefined && categoryId !== null){
       deleteCategory(categoryId)
    
    }
})




});
function getVariants(catID) {
    const variantsContainer = document.getElementById(`variants_${catID}`);
    const mainSpanCategory = document.getElementById(`mainSpanCategory_${catID}`);
    let singleInputBox;

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
                singleInputBox = `<span hidden id="spanVar" class="variant-input" style="display:flex; color: #fefefe">+&nbsp;<input hidden type="text" class="variant_input" id="cat_${catID}" placeholder="Enter Variant"></span>`;
                variantsContainer.innerHTML = singleInputBox;
                variantsContainer.style.display = 'block'; 
                if (mainSpanCategory) {
                    mainSpanCategory.textContent = '-'; 
                }
                
            } else {
                const variantsList = variants.map(variant => `<p class="variants variant-container" style="display: flex">
                    <a href="#" style="text-decoration: none;" class="variant" onclick="handleClick()">
                        <span>+</span>&nbsp;${variant.variant_name}
                    </a>
                </p>`).join('');

                singleInputBox = `<span hidden id="spanVar" class="variant-input" style="display:flex; color: #fefefe">+&nbsp;<input hidden type="text" class="variant_input" id="cat_${catID}" placeholder="Enter Variant"></span>`;
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

function handleClick(){
    
}



function  deleteCategory(id){
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
}

function addCtgory(inputElement){
    switch(inputElement.which) {
            case 13:
                var dataValue = document.getElementById('inputCat').value
                console.log(dataValue)
                if(dataValue) {
                    axios.post('api.php?action=addCategory', {
                        category: dataValue
                    }).then(function(response) {
                        getCategories()
                    }).catch(function(error) {
                        console.log(error);
                    });
                }
                break;
            default:
                return;
        }
        inputElement.preventDefault();
}

function editCategory(indexCat, categoryId) {
    $('#paragraph_' + categoryId).removeClass('highlighted');
    var $anchorElement = $('#anchor_' + categoryId);
    var $spanElement = $anchorElement.find('span');
    $anchorElement.hide();
    $spanElement.hide();
    var $inputElement = $('<input>').attr({
        type: 'text',
        value: "",
        style: 'margin: 0; padding: 0;'
    });

    var $spanPlus = $('<span>').text('+').css({
        'color': 'white',
        'margin-right': '5px'
    });

    
    $anchorElement.after($inputElement).after($spanPlus);
    $inputElement.focus();

    $inputElement.on('blur', function(event) {
        var newValue = $inputElement.val().trim();
        if (newValue !== '') {
            $spanElement.text(newValue);
        }

        $inputElement.remove();
        $spanPlus.remove();
        $anchorElement.show();
        $spanElement.show();
        
       
        $anchorElement.removeClass('highlighted');
        
     
        var index = $anchorElement.index('.customAnchor');
        $('.categoriesParagraph').eq(index).addClass('highlighted');
    });

   
    $inputElement.on('keydown', function(e) {
        if (e.which === 13) { 
            e.preventDefault();
            var newValue = $inputElement.val().trim();
            if (newValue !== '') {
                $spanElement.text(newValue);
                forCategoryUpdate(categoryId, newValue);
            }

            $inputElement.remove();
            $spanPlus.remove();
            $anchorElement.show();
            $spanElement.show();
            
          
            $anchorElement.removeClass('highlighted');
            var index = $anchorElement.index('.customAnchor');
            $('.categoriesParagraph').eq(index).addClass('highlighted');
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
    if($('#add_bom_modal').is(':visible')){
           closeModalBom()
       } 
  $('#add_category_modal').css('animation', 'slideOutRight 0.5s forwards');
  $('.categoryAdd').css('animation', 'slideOutRight 0.5s forwards');
  $('.highlighted').removeClass('highlighted');
 
  $('#add_category_modal').one('animationend', function() {
    $(this).hide();
    $(this).css('animation', '');
    $('.categoryAdd').css('animation', '');
  });
}


</script>


