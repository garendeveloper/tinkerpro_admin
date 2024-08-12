<style>
 #unlockscreen .modal-content {
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
h4{
  font-family: Century Gothic;
}
.modal-logout {
    color: #ffff;
    background: #262625;
    border-radius: 0;
    min-height: 240px;
    position: relative;
}
.cancel_logout{
  background-color: red;
}
.cancel_logout:hover{
  background-color: darkred;
}
.continue_logout{
  background-color: green;
}
.continue_logout:hover{
  background-color: darkgreen;
}
#unlockscreen .modal-header{
  border: none;
}
#unlockscreen .modal-footer button {
  width: 150px;
  height: 30px;
  display: flex;
  align-items: center;  /* Vertically centers the text */
  justify-content: center;  /* Horizontally centers the text */
  text-align: center;  /* Ensures text is centered if wrapping occurs */
  font-size: 12px;
}
.has-error{
    border: 1px solid red !important;
}
.modal-header {
    display: flex;
    flex-direction: column; 
    align-items: center;    
    justify-content: center; 
    height: 100%; 
    text-align: center; 
  }

  .modal-header h3 {
    margin: 0; 
    padding: 10px 0; 
  }
</style>
<div class="modal" id="unlockscreen" tabindex="-1" aria-labelledby="unlockscreenLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 1)";>
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content modal-logout" style = "background: transparent">
      <div class="modal-header">
        <h4 style = "color: var(--primary-color)">Please enter your password: </h4>
        <h4 style = "color: red">[<?= $_SESSION['first_name']." ".$_SESSION['last_name']?>]</h4>
      </div>
      <div class = "modal-body">
        <input type="password" id = "unlockPasswordTxt" style = "width: 400px; border: 1px solid #d3d3d3; background-color: grey;text-align: center" oninput = "$(this).removeClass('has-error'); $('.errorResponse').html('')" autocomplete = "off"/>
        <p class = "errorResponse" style = "color: red !important"></p>
      </div>
      <div class="modal-footer" style = "border: none; ">
        <button id="btnCancelUnlock" style = "background-color: #d3d3d3">CANCEL</button>
        <button id = "btnContinueUnlock" style = "background-color: var(--primary-color)">CONTINUE</button>
      </div>
    </div>
  </div>
</div>
