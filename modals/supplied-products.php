<style>
 #suppliedModal .modal-dialog {
  max-width: 800px; 
  min-width: 500px; 
}

@media (max-width: 800px) {
  #suppliedModal .modal-dialog {
    max-width: 90vw; 
  }
}


  #suppliedModal .modal-content {
    color: #ffff;
    background: #262625;
    border-radius: 0;
    height: fit-content;
    position: relative;
  }

  #suppliedModal .close-button {
    position: absolute;
    right: 1.6em;
    top: 10px;
    background: #FF6900;
    color: #fff;
    border: none;
    width: 40px;
    height: 40px;
    line-height: 30px;
    text-align: center;
    cursor: pointer;
    margin-top: 1vh;
  }

  #suppliedModal .modal-title {
    font-family: Century Gothic;
    font-size: 1.5em;
    margin-top: 1em;
    margin-bottom: 0.5em;
    display: flex;
    align-items: center;
  }

  #suppliedModal .warning-container {
    display: flex;
    align-items: center;
  }

  #suppliedModal .warning-container svg {
    width: 35px;
    height: 35px;
    margin-right: 0.5em;
    margin-left: 1em;
    margin-top: -0.5em;
  }

   .warningCard {
    min-width: fit-content;
    min-height: 420px;
    max-height: 420px;
    margin-left: 2em;
    border: 1px solid #4B413E;
    border-radius: 0;
    padding: 1.5vw;
    box-sizing: border-box;
    background: #262625;
    margin-right: 2em;
    flex-shrink: 0;
    position: relative;
  }

 
  .warning-title{
    font-family: Century Gothic;
    font-size: large;
  }
  .custom_btns{
    border-color: #333333 !important;
    width: 150px;
    height: 45px;

  }
  .btnsContainer{
    width: 100%;
    display: flex;
    align-items: right;
    justify-content: right;
    margin-bottom: 20px;
    margin-top: 10px;
    padding-right: 2em;
  }
  #svgicon{
    padding-right: 10px 
  }
  #contBtn{
    padding-left: 20px;
    height: 45px !important;
    width: 160px;
    margin-left: 10px;
  }
  #receiptNum{
    border-color: #4B413E !important;
    background-color: transparent !important;
    color: #ffff !important
  }
  .productsSupplies::-webkit-scrollbar {
  width: 8px;
 
}

.productsSupplies::-webkit-scrollbar-track {
  background: #151515;
}

.productsSupplies::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 3px;
}

.productsSupplies::-webkit-scrollbar-thumb:hover {
  background: #555;
}
.form-check-input.checked {
    background-color: #FF6900 !important;
    border-color:  #FF6900 !important;
}
.form-check-input.checked:focus {
    outline: none !important;
    box-shadow: none !important;
}
.form-check-input:hover {
    background-color: #FF6900 !important; 
    border-color:  #FF6900 !important;
}


</style>

<div class="modal" id="suppliedModal"  tabindex="0" style="background-color: rgba(0, 0, 0, 0.7); overflow: hidden; z-index: 2000;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <button id="suppliedProductsClose"  name="suppliedProductsClose" class="close-button" style="font-size: larger;">&times;</button>
      <div class="modal-title">
      <div class="warning-container">
          <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 47.5 47.5" viewBox="0 0 47.5 47.5" id="Warning">
            <defs>
              <clipPath id="a">
                <path d="M0 38h38V0H0v38Z" fill="#000000" class="color000000 svgShape"></path>
              </clipPath>
            </defs>
            <g clip-path="url(#a)" transform="matrix(1.25 0 0 -1.25 0 47.5)" fill="#000000" class="color000000 svgShape">
              <path fill="#b50604" d="M0 0c-1.842 0-2.654 1.338-1.806 2.973l15.609 30.055c.848 1.635 2.238 1.635 3.087 0L32.499 2.973C33.349 1.338 32.536 0 30.693 0H0Z" transform="translate(3.653 2)" class="colorffcc4d svgShape"></path>
              <path fill="#131212" d="M0 0c0 1.302.961 2.108 2.232 2.108 1.241 0 2.233-.837 2.233-2.108v-11.938c0-1.271-.992-2.108-2.233-2.108-1.271 0-2.232.807-2.232 2.108V0Zm-.187-18.293a2.422 2.422 0 0 0 2.419 2.418 2.422 2.422 0 0 0 2.419-2.418 2.422 2.422 0 0 0-2.419-2.419 2.422 2.422 0 0 0-2.419 2.419" transform="translate(16.769 26.34)" class="color231f20 svgShape"></path>
            </g>
          </svg>
          <p class="warning-title"><b>SELECT PRODUCTS</b></p>&nbsp;
        </div>
      </div>
      <div class="warningCard">
      <div style="display: flex;">
            <svg id="svgicon" xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#ffff" class="bi bi-upc-scan" viewBox="0 0 16 16" >
                <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5M3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0z" />
            </svg>
            <div style="display: flex; flex-direction: column;">
                <span class="receiptNumberSpan"></span>
                <input placeholder="Type or Scan Product Barcode" style="width: 450px; border-radius: 0; border-color:#262625" type="number" class="form-control" id="receiptNum" name="receiptNum">
            </div>
            <button id="contBtn">Continue</button>
        </div>
        <div class="productsSupplies" style="height: 300px; overflow-y: scroll;">
    <?php
    $productFacade = new ProductFacade;
    $products =  $productFacade->getProductsData();
    $itemCount = 0; 

    while ($row = $products->fetch(PDO::FETCH_ASSOC)) {
        if ($itemCount % 2 === 0) {
            echo '<div style="display: flex;">';
        }
        echo '<div style="margin-right: 10px; flex-basis: 50%;">'; // Add margin and set width for each column
        echo '<input id="' . $row['id'] . '" name="' . $row['id'] . '" type="checkbox" class="form-check-input" value="' . $row['id'] . '" style="margin-right: 4px;margin-bottom:5px" onclick="toggleCheckboxColor(this)">';
        echo '<label for="' . $row['id'] . '" class="text-color form-check-label">' . $row['prod_desc'] . '</label>';
        echo '</div>';
        if (($itemCount + 1) % 2 === 0 || ($itemCount + 1) === $products->rowCount()) {
            echo '</div>'; 
        }
        $itemCount++; 
    }
    ?>
</div>

    </div>
    <div class="btnsContainer">
     <button id="cancelDateTime" class="custom_btns" style="margin-right:10px">Cancel</button>
     <button class="custom_btns okSuppliedProducts">Ok</button>
    </div>
    </div>
  </div>
</div>
<script>
  
        $('#suppliedProductsClose').on('click', function(){
            $('#suppliedModal').hide();
            $('.form-check-input:checked').prop('checked', false);
            
            localStorage.removeItem('suppliedProductData');
            $('.form-check-input').removeClass('checked');
            $('#suppliedTable tbody').empty();
        });
   

       
    function toggleCheckboxColor(checkbox) {
        checkbox.classList.toggle('checked');
        var productId = checkbox.value;
        var productName = checkbox.nextElementSibling.textContent;
        var isChecked = checkbox.checked;
        var id = null;
        
        if (isChecked) {
            var suppliedProductData = JSON.parse(localStorage.getItem('suppliedProductData')) || [];
            suppliedProductData.push({id:id, productId: productId, name: productName });
            localStorage.setItem('suppliedProductData', JSON.stringify(suppliedProductData));
        }else {
            var suppliedProductData = JSON.parse(localStorage.getItem('suppliedProductData')) || [];
            var indexToRemove = suppliedProductData.findIndex(function(item) {
                return item.productId === productId;
            });
            if (indexToRemove !== -1) {
                suppliedProductData.splice(indexToRemove, 1);
                localStorage.setItem('suppliedProductData', JSON.stringify(suppliedProductData));
            }
            
        }
    }

  
 
    $('.okSuppliedProducts').on('click', function(){
        var suppliedProductData = JSON.parse(localStorage.getItem('suppliedProductData'));
        console.log("Supplied Product Data:", suppliedProductData); 
        
        var tableBody = $('#suppliedTable tbody');
        tableBody.empty(); 
        
        suppliedProductData.forEach(function(product, index) {
            var row = $('<tr>');
            var counterCell = $('<td>').text((index + 1) + ".");
            row.append(counterCell);
        
            var productNameCell = $('<td>').text(product.name);
            row.append(productNameCell);
            
            tableBody.append(row);
        });
        
        closeSupplied();
    });



    function closeSupplied(){
           $('#suppliedModal').hide();
    }

</script>