
<style>
  #topBar{
  background-color:#262626
}

  .searchProducts{
  background-color: #7C7C7C;
  }
  .text-color::placeholder {
  color: #ffff;
}
.btn-control{
  font-family: Century Gothic;
  border-radius: none;
  border-color: #33557F;
}
.btn-success-custom{
  background-color: #00B050
}
.btn-error-custom{
  background-color: red;
}
.btn-control:hover {
    border-color: var(--primary-color); 
    color: #fefefe !important; 
}


.text-color{
    color: #ffff;
    font-family: Century Gothic;
  }
  .table-responsive {
    max-height: 600px;

   
}

.table-responsive table {
    width: 100px;
    border-collapse: collapse;
}
.card {
  background-color: #151515;
  border-color: #242424;
  height: 200px;
  overflow-x: auto; 
  overflow-y: hidden;
  border-radius: 8px;
  padding: 16px;
}


.deleteBtn {
  background: transparent;
  border-radius: 0;
}

button.btn.btn-secondary.deleteBtn.deleteProductItem {
  border: 1px solid var(--border-color);

}

#responsive-data {
  overflow-y: auto;
  overflow-x: hidden;
  max-height: 80vh;
  position: absolute;
  left: 2px;
  right: 2px;
  top: 2px;
}



.productHeader tr th {
  background: none;
 }



 .productBTNs  {
  border: 1px solid transparent; 
  width: 3vw; 
  border-radius: 0;
  height: 35px;
 }


/* #responsive-data {
  max-height: 700px;
  position: absolute;
  left: 2px;
  right: 2px;
  top: 2px;
 
}

#responsive-data thead {
  display: block;
}

#responsive-data tbody {
  display: block;
  max-height: 600px;
  overflow-y: auto; 
  max-width: fit-content;
}
 */
.font-size{
  font-size: 12px !important;
}




.search_design {
 width: 100%; 
 height: 35px; 
 font-style: italic; 
 border-top-left-radius: 100px;
 border-bottom-left-radius: 100px;
 margin-right: 0;
}

.searchIconD {
  background: #7C7C7C;

}


.addProducts {

  background: #7C7C7C;
  border-top-right-radius : 100px;
  border-bottom-right-radius : 100px;
}
 .addProducts.productBTNs {
  width: 1550px;
}





</style>
<div class="modal" id="deleteProdModal" tabindex="0" style="background-color: rgba(0, 0, 0, 0.5)">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 35vw">
    <div class="modal-content">
      <div class="modal-body" style="background: #262626; color: #ffff; border-radius: 0;">

        <div style="position: relative; width: 100%;" class="d-flex">
            <div  style="margin-right: 10px; color:#ffff;">
              <h4><span>
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                    <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
                    <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                  </svg>
              </span>Delete <span class="ProdName"></span></h4>
            </div>
        </div>

        <input type="hidden" class = "promotion_id" value = "">

        <div class="show_product_info">
           
        </div>

        <div class="d-flex justify-content-between" style="margin-top: 10px">
          <button class="btn btn-secondary deleteBtn deleteCancel cancelModal" style="border: 1px solid #4B413E; box-shadow: none;"><span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-x-lg" viewBox="0 0 16 16">
              <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
            </svg>
            </span>CANCEL</button>
            <button class="btn btn-secondary deleteBtn deleteProductItem" tabindex="0" style="border: 1px solid #4B413E; box-shadow: none;"><span>
            <i class = "bi bi-trash3 delete" style = "color: white"></i>
            </span>DELETE</button>

            <button class="btn btn-secondary deleteBtn inactiveBtn d-none" tabindex="0" style="border: 1px solid #4B413E; box-shadow: none;"><span>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#fff" class="bi bi-check2" viewBox="0 0 16 16">
                <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0"/>
            </svg>
            </span>YES</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    $(".cancelModal").on("click", function(){
        $("#deleteProdModal").hide();
    })
</script>