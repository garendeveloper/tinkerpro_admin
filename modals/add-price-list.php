<style>

#add_multiple_modal {
  display: none;
  position: fixed;
  z-index: 9999;
  top: 0;
  bottom: 0;
  left: calc(100% - 850px);
  width: 350px;
  background-color: transparent;
  overflow: hidden;
  height: 100%;
  animation: slideInRight 0.5s;
}

.multiple {
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
.closeMultiple{
    position:absolute;
    width: 30px;
    height: 30px;
    left: 300px;
    top: 25px;
    right:5px;
  }
  #productsModal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 80%; 
        height: 80%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    #specificModalContent {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 90%; 
        height: 90%; 
    }

  
</style>
<div class="modal" id="add_multiple_modal" tabindex="0">
  <div class="modal-dialog ">
    <div class="modal-content multiple">
      <div class="modal-title">
        <div class="warning-container">
            <div>
                <button onclick="closeMultiple()" class="closeMultiple">x</button>
            </div>
            <div  style="margin-top: 60px; margin-left: 10px">
              <h6 class="text-custom" style="color:#FF6900;">Add Multiple Prices</h6>
            </div>
            <div class="catBtns">
              <button  class="cat_btns deLbTN">Del</button>
              <button id="toggleProducts" class="cat_btns">Add</button>
              <button  id="editCat" name="editBtn" class="editCat cat_btns">Edit</button>
              <div id="productsModal" class="modal">
    <div id="specificModalContent" class="modal-content">
        <div class="select-container">
            <div id="selectProducts">
                <div class="dropdown-item" data-value="">All Products</div>
                <?php
                $productFacade = new ProductFacade;
                $products =  $productFacade->getProductsData();
                while ($row = $products->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="dropdown-item" data-value="' . $row['id'] . '">' . $row['prod_desc'] . '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
                </div>
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
 function closeMultiple(){
$('#add_multiple_modal').css('animation', 'slideOutRight 0.5s forwards');
  $('.multiple').css('animation', 'slideOutRight 0.5s forwards');

 
  $('#add_multiple_modal').one('animationend', function() {
    $(this).hide();
    $(this).css('animation', '');
    $('.multiple').css('animation', '');
    
   
  });
 }
 var toggleProducts = document.getElementById('toggleProducts');
    var productsModal = document.getElementById('productsModal');

    toggleProducts.addEventListener('click', function() {
        productsModal.style.display = 'block';
    });

    window.addEventListener('click', function(event) {
        if (event.target === productsModal) {
            productsModal.style.display = 'none';
        }
    });
</script>


