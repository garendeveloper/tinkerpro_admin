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
  align-items: center;  
  text-align: center;  
  vertical-align: center;
  font-size: 12px;
  margin-top: -100px;
}
.has-error{
    border: 1px solid red !important;
}
</style>
<div class="modal" id="unlockscreen" tabindex="-1" aria-labelledby="unlockscreenLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 1);    z-index: 99999;";>
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content modal-logout" style = "background: #262626; height: 100px;">
      <div class = "modal-body">
        <h4 style = "color: #fffff; font-weight: bold">For security reason, please log back in</h4>
        <h4 style = "color: var(--primary-color); margin-top: -20px;">[<?= $_SESSION['first_name']." ".$_SESSION['last_name']?>]</h4>
        <h6 style = "color: #d3d3d3; margin-top: -20px;">Scan your ID or enter your password</h6>
        <input type="password" id = "unlockPasswordTxt" style = "width: 380px; border: 1px solid #d3d3d3; background-color: grey;text-align: center" oninput = "$(this).removeClass('has-error'); $('.errorResponse').html('')" autocomplete = "off"/>
        <p class = "errorResponse" style = "color: red !important"></p>
      </div>
      <div class="modal-footer" style = "border: none; ">
        <button id="btnCancelUnlock" style = "background-color: #d3d3d3">CANCEL</button>
        <button id = "btnContinueUnlock" style = "background-color: var(--primary-color)">CONTINUE</button>
      </div>
    </div>
  </div>
</div>
