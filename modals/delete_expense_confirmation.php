<style>
 #delete_expenseConfirmation .modal-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.modal-content h4 {
  margin-bottom: 20px;
}

.confirmation-container {
  display: flex;
  justify-content: center;
  width: 100%;
}

.requestPermissionBtn {
  background-color: #1E1C11;
  color: #fff;
  border: none;
  padding: 10px 20px;
  font-size: 14px;
  cursor: pointer;
}
h1, h2, h3, h4, h5, h6, p{
  font-family: Century Gothic;
}
.modal-deleteExpense {
    color: #ffff;
    background: #262625;
    border-radius: 0;
    min-height: 240px;
    position: relative;
}
.cancel_deleteExpense{
  background-color: red;
}
.cancel_deleteExpense:hover{
  background-color: darkred;
}
.continue_deleteExpense{
  background-color: green;
}
.continue_deleteExpense:hover{
  background-color: darkgreen;
}
#delete_expenseConfirmation .modal-header{
  border: none;
}
.image-size {
    width: 150px;
    height: 200px;
}
.responsive-img {
    max-width: 80%;
    max-height: 50%;
    height: auto;
    display: block;
    margin: auto;
}
</style>
<div class="modal" id="delete_expenseConfirmation" tabindex="-1" aria-labelledby="delete_expenseConfirmationLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.9)";>
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-deleteExpense">
      <input type="hidden" id = "remove_expense_id" value = "">
      <h4 style = "margin-top: 20px;">Do you wish to remove the expense?</h4>
      <div class="modal-header">
        
      <img src="assets/img/tinkerpro-logo-light.png" class = "responsive-img" id= "item_image" alt="logo"/>
      </div>
      <h5 id = "expense_name"></h5>
      <h5 id = "expense_msg"></h5>
      <div class="confirmation-container" style="display: flex; align-items: center; width: 100%; ">
        <button class="requestPermissionBtn cancel_deleteExpense">CANCEL</button>
        <button class="requestPermissionBtn continue_deleteExpense">CONTINUE</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('.cancel_deleteExpense').on('click', function(){
    $('#delete_expenseConfirmation').hide();
  })
</script>

