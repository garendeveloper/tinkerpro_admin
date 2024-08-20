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
  animation: none;
 
}

.categoryAdd {

  margin: 0 auto;
  border: none;
  width: 100%;
  height: 100vh; 
  border: 1px solid #595959;
  animation: none;
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
    color:var(--primary-color);
    text-decoration: none;
    font-size: 14px;
    padding-left: 25px;
}
.productsBtn:hover{
   color:#fefefe
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
    color: var(--primary-color) !important;
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
    color: var(--primary-color) !important;
}

.highlighted {
    color: var(--primary-color) !important;
    /* background-color: grey !important;
    color: black !important; */
}

.catBtns{
    padding-left: 10px;
    margin: 0;
}
.cat_btns {
    font-size: 13px;
    border-radius: 5px;
    width: 70px;
    margin: 0;
    height: 40px;
    background-color: #404040; 
    color: #fefefe;
}

.cat_btns:hover {
    background-color: #333333; /* Example hover color, adjust as needed */
    color: #ffffff; /* Example hover text color */
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
.productsItem{
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

.categoryInput::placeholder{
    font-size: 10px;
    font-style: italic;
    color: #ffff;
}

</style>