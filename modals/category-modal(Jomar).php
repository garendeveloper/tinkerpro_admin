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
    font-size: 14px;
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
    background-color: transparent; 
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
    font-size: 13px;
    border-radius: 5px;
    width: 70px;
    margin: 0;
    height: 40px;
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
    max-height: 650px; 
    overflow-y: auto;
}

::-webkit-scrollbar {
      width: 6px; 
    }

::-webkit-scrollbar-track {
    background: #262626; 
}
::-webkit-scrollbar-thumb {
    background: #888; 
    border-radius: 3px; 
}

::-webkit-scrollbar-thumb:hover {
    background: #555; 
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
    color: white !important;
}
.white-text {
    color: #fefefe !important;
}

.closeBom {
    border-radius: 50%;
    background: none;
    border: none;
    box-shadow: none;
}

.closeBom:hover {
    background: transparent !important;
}

.categoriesParagraph {
    height: 16px;
}



</style>
<div class="modal" id="add_category_modal" tabindex="0">
    <div class="modal-dialog ">
        <div class="modal-content categoryAdd">
            <div >
                <div class="warning-container">
                    <div class="d-flex">
                        <button onclick="closeModalCategory()"class="closeBom"><i class="bi bi-x"></i></button>
                    </div>

                    <div id="categoryData"  style="margin-top: 60px; margin-left: 10px">
                        <h6 class="text-custom" style="color:#FF6900;">Category</h6>
                    </div>

                    <div class="catBtns">
                        <button  class="cat_btns deLbTN"><span><i class="bi bi-trash"></i> </span>Del</button>
                        <button   class="cat_btns addCategory"><span><i class="bi bi-plus-lg"></i> </span>Add</button>
                        <button  id="editCat" name="editBtn" class="editCat cat_btns"><span><i class="bi bi-pencil-square"></i> </span>Edit</button>
                    </div>

                    <div class="productsHeader ">
                        <p class="productsP" ><a href="#" onclick="changeValueInput(this)" class="productsBtn" id="showCategories"><span>+</span>&nbsp;Products</a></p><input hidden type="checkbox" id="addCategoryCheckbox" class="forAddCategory"/>
                        <div id="categoriesDiv" class="scrollable-content" style="display: none;"></div>
                    </div>
                </div>
            </div>

            <div class="done-div">
                <button   class="btn-success-custom doneBtn"  style="margin-right: 10px; width: 100px; height: 100%">Done</button>
            </div>
        </div>
    </div>               
</div>


<script>

function closeModalCategory() {
    closeModal()
}

function getCategories() {
    $.ajax({
        url: './fetch-data/fetch-categories.php', 
        type: 'GET',
        success: function(response) {
            $('#categoriesDiv').html(response);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText); 
        }
    });
}

var previousSpan = null;

$(document).ready(function() {
    var categoriesVisible = false; 
    $('#categoriesDiv').hide();
    $('#showCategories').click(function() {
        $('#categoriesDiv').toggle();
        categoriesVisible = !categoriesVisible; 
        $('.productsP').toggleClass('highlighted', categoriesVisible);
        $('.productsBtn').toggleClass('black-text', categoriesVisible).toggleClass('black-text', !categoriesVisible);
        
        if (categoriesVisible) {
            getCategories();
            $(this).text('- Products').css('color', 'black');
        } else {
            $(this).text('+ Products').css('color', 'var(--primary-color)');; 
            $('.productsP').removeClass('highlighted');
        }
    });


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
    var name = $(this).data('category-name');

    var catValue = document.getElementById('cat_Lbl');
    var categoriesInput = document.getElementById('categoriesInput');
    var id_cat = document.getElementById('catID');
    var idVar = document.getElementById('varID');
 
    id_cat.value = categoryId;
    if (categoryId !== undefined && index !== undefined) {
        getVariants(categoryId);
        catValue.value =  "/" + name ;
            var newValue = document.getElementById('cat_Lbl').value;
            var p_value =  document.getElementById('productLbl').value
            var catValue =  p_value + newValue
            $('.doneBtn').off('click').on('click', function(){
                categoriesInput.value = catValue 
                id_cat.value = categoryId 
                closeModal()
                $('.categoriesParagraph').eq(index).addClass('highlighted');
            })
    }else{
        catValue.value = "";
        categoriesInput.value =  document.getElementById('productLbl').value;
        id_cat.value=""
        dVar.value = ""
    }
 
    $('.categoriesParagraph').eq(index).addClass('highlighted');
    var currentSpan = $(this).find('span');
    if ($(this).hasClass('highlighted')) {
        currentSpan.text('-')
        currentSpan.css({
            'font-size' : '20px',
            'color' : 'white'
        });
       
    } else {
        currentSpan.text('+')
        currentSpan.css({
            'font-size' : '20px',
            'color' : 'white'
        });
       
    }
    previousSpan = currentSpan;
});



$('.addCategory').off('click').on('click', function() {
    var index = $('.customAnchor.highlighted').index();
    var categoryId = $('.customAnchor.highlighted').data('category-id');

    $('#mainSpanCategory_' + categoryId).css('font-size', '20px');
    
    if ($('.productsP').hasClass('highlighted')) {
        $('.inputCat').removeAttr('hidden');
        $('#inputCat').focus();
    } else if ($('.categoriesParagraph').hasClass('highlighted') && $('#mainSpanCategory_' + categoryId).text() === '-') {
            
            $('#spanVar').removeAttr('hidden');
            $('#cat_' + categoryId).removeAttr('hidden');
            addVariant(categoryId)
        
    } else {
        $('#spanVar').attr('hidden', 'hidden');
        $('.variant_input').attr('hidden', 'hidden');
    }
});




// $(document).off('click','.editCat').on("click",'.editCat',function(e){
//                     e.preventDefault()
//     var indexCat = $('.customAnchor.highlighted').data('index');
//     var categoryId = $('.customAnchor.highlighted').data('category-id');
//     console.log(categoryId)
//     if(indexCat !== undefined && indexCat !== null && categoryId !== undefined && categoryId !== null ){
//        editCategory(indexCat, categoryId)
//     }
//                 })
$('.deLbTN').off('click').on("click",function(){
    var indexCat = $('.customAnchor.highlighted').data('index');
    var categoryId = $('.customAnchor.highlighted').data('category-id');
  
    
    if(indexCat !== undefined && indexCat !== null && categoryId !== undefined && categoryId !== null){
       deleteCategory(categoryId)
    
    }
})
$(document.body).on('click', function(event) {
        if (!$(event.target).closest('.inputCat').length && !$(event.target).closest('.addCategory').length &&
            !$(event.target).closest('#spanVar').length && !$(event.target).closest('.customAnchor').length) {
            $('.inputCat').hide(); 
            $('#spanVar').hide(); 
        }
    });
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
                singleInputBox = `<span hidden id="spanVar" class="variant-input" style="display:flex; color: #fefefe"><input hidden type="text" class="variant_input" id="cat_${catID}" placeholder="Enter Variant"></span>`;
                variantsContainer.innerHTML = singleInputBox;
                variantsContainer.style.display = 'block'; 
                if (mainSpanCategory) {
                    mainSpanCategory.textContent = '-'; 
                }
                
            } else {
                const variantsList = variants.map((variant, index) => `
                    <p id="variant_${variant.id}" class="variants variant-container" style="display: flex ">
                        <a href="#" style="text-decoration: none;" class="variant" 
                        onclick="handleClick(this, event);" 
                        data-index="${index}" 
                        data-id="${variant.id}" 
                        data-variant-name="${variant.variant_name}"
                        data-category-id="${catID}">
                            <span class="spanVariant">+</span>&nbsp;${variant.variant_name}
                        </a>
                    </p>`
                ).join('');
                singleInputBox = `<span hidden id="spanVar" class="variant-input" style="display:flex; color: #fefefe"><input hidden type="text" class="variant_input" id="cat_${catID}" placeholder="Enter Variant"></span>`;
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

function addVariant(categoryId){
    document.getElementById('cat_' + categoryId).addEventListener('keydown', function(e) {
        switch(e.which) {
            case 13: 
                e.preventDefault();
                var inputedVariant = document.getElementById('cat_' + categoryId).value
                axios.post('api.php?action=addVariant', {
                    id:categoryId,
                    variantName: inputedVariant
                }).then(function(response) {
                     getVariants(categoryId)
                }).catch(function(error){

                })
            break;
        } 
    })
}
let previousParagraph = null;
let data;
let hghLighted;
function handleClick(link, event) {
    event.preventDefault();
    data = link;
    var id = link.dataset.id;
    var index = link.dataset.index;
    var variantName = link.dataset.variantName;
    var category_id = link.dataset.categoryId;

    var varLbl = document.getElementById('var_Lbl');
    var categoriesInput = document.getElementById('categoriesInput');
    var productInputLbl = document.getElementById('productLbl');
    var newValue = document.getElementById('cat_Lbl').value;
    var idVar = document.getElementById('varID');

    $('.categoriesParagraph').removeClass('highlighted');
    $('.customAnchor').removeClass('highlighted black-text');
    const paragraph = link.closest('p.variants');

    console.log('hello world')

    if (paragraph.classList.contains('highlighted')) {
        paragraph.classList.remove('highlighted');
        const linkText = link.querySelector('span');
        linkText.innerText = '+';
        link.style.color = '';
        hghLighted = false
    } else {
        if (previousParagraph) {
            previousParagraph.classList.remove('highlighted');
            const previousLink = previousParagraph.querySelector('.variant');
            previousLink.querySelector('span').innerText = '+';
            previousLink.style.color = '';
        }
        hghLighted = true
        paragraph.classList.add('highlighted');
        const linkText = link.querySelector('span');
        linkText.innerText = '-';
        link.style.color = 'black';
        previousParagraph = paragraph;
        if (id && index) {
        
            $('.deLbTN').off('click').on("click", function () {
                deleteVariants(id, category_id);
            });
            varLbl.value = "/" + variantName;
            var c_value = productInputLbl.value + newValue + varLbl.value;
            $('.doneBtn').off('click').on('click', function () {
                categoriesInput.value = c_value;
                idVar.value = id;
                closeModal();
                $('.variants').removeClass('highlighted');
                $('.variants').eq(index).addClass('highlighted');
            });
        } else {
            varLbl.value = "";
            idVar.value = "";
        }
    }
}


$(document).off('click', '.editCat').on("click", '.editCat', function (e) {
    e.preventDefault();
    var indexCat = $('.customAnchor.highlighted').data('index');
    var categoryId = $('.customAnchor.highlighted').data('category-id');

 if (indexCat !== undefined && indexCat !== null && categoryId !== undefined && categoryId !== null) {
        handleClickCategory(indexCat, categoryId);
    }else{
        var id = data.dataset.id;
    var category_id = data.dataset.categoryId;
    var index = data.dataset.index;
        editVariants(id, category_id, index);
    }
});


function handleClickCategory(indexCat, categoryId) {
    hghLighted == false
    editCategory(indexCat, categoryId);
}




function editVariants(id, category_id, index) {
    $('#variant_' + id).removeClass('highlighted');
    var $anchorElement = $('#variant_' + id);
    var $spanElement = $anchorElement.find('span');
    $anchorElement.hide();
    $spanElement.hide();
    var $inputElement = $('<input>').attr({
        type: 'text',
        value: "",
        style: 'margin: 0; padding: 0;  width: 150px;'
        
    });

    var $spanPlus = $('<span>').text('+').css({
        'color': 'white',
        'margin-right': '5px',
        'padding-left': '75px'
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
        
     
        var index = $anchorElement.index('.variant');
        $('.variants').eq(index).addClass('highlighted');
    });

   
    $inputElement.on('keydown', function(e) {
        if (e.which === 13) { 
            e.preventDefault();
            var newValue = $inputElement.val().trim();
            if (newValue !== '') {
                $spanElement.text(newValue);
                // Call function to update variant in the database
                updateVariant(id, newValue,category_id);
            }

            $inputElement.remove();
            $spanPlus.remove();
            $anchorElement.show();
            $spanElement.show();
            
          
            $anchorElement.removeClass('highlighted');
            var index = $anchorElement.index('.variant');
            $('.variants').eq(index).addClass('highlighted');
        }
    });
}

function  updateVariant(id, newValue,category_id){
    axios.post('api.php?action=updateVariants',{
        id:id,
        variantName:newValue,
        category_id:category_id
    }).then(function(response){
        getCategories();
        getVariants(category_id)
        
    }).catch(function(error){
        console.log(error)
    })
}


function deleteVariants(id,category_id){
        axios.delete(`api.php?action=deleteVariants&id=${id}`)
        .then(function(response){
               getCategories();
               getVariants(category_id)
            console.log(response)
            
        })
        .catch(function(error){
            console.log(error)
        });
    
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
    var $anchorElement = $('#anchor_' + categoryId).css('color', 'green');
    var $spanElement = $anchorElement.find('span')
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

function changeValueInput(element) {
    var categoriesInput = document.getElementById('categoriesInput');
    var productInputLbl = document.getElementById('productLbl');
    var newValue = document.getElementById('cat_Lbl');
    var varLbl = document.getElementById('var_Lbl');
    var id_cat = document.getElementById('catID');
    var idVar = document.getElementById('varID');

   
    productInputLbl.value = "";
    categoriesInput.value = "";
    newValue.value = "";
    varLbl.value = "";
    id_cat.value = "";
    idVar.value = "";

    
    if ( categoriesInput.value == "" ||  categoriesInput.value == null ) {
        productInputLbl.value = "Product"; 
        var prd_value = document.getElementById('productLbl').value;
        $('.doneBtn').off('click').on('click', function(){
            categoriesInput.value = prd_value;
            closeModal();
            $('.productsP').addClass('highlighted');
        });
    }
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
     getCategories()  
  });
}


</script>


