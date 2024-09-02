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
  width: 100px;
  height: 25px;
  display: flex;
  align-items: center; 
  justify-content: center; 
  text-align: center; 
  margin-left: 30px;

}
.has-error{
    border: 1px solid red !important;
}
input::placeholder{
  color: white;
  font-style: italic;
}
</style>
<div class="modal" id="unlockscreen" tabindex="-1" aria-labelledby="unlockscreenLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.9);    z-index: 99999;";>
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content modal-logout" style = "background: #262626; height: 80px;">
      <div class = "modal-body" >
        <h4 style = "color: #ffff">For security reason, please log back in</h4>
        <h4 style = "color: var(--primary-color); margin-top: -20px;">[<?= $_SESSION['first_name']." ".$_SESSION['last_name']?>]</h4>
        <h6 style = "color: #d3d3d3; margin-top: 30px;"></h6>
        <input type="password" id = "unlockPasswordTxt" placeholder = "Scan your ID or enter your password" style = "width: 380px; border: 1px solid #d3d3d3; background-color: grey;text-align: center" oninput = "$(this).removeClass('has-error'); $('.errorResponse').html('')" autocomplete = "off"/> 
        <p class = "errorResponse" style = "color: red !important"></p>
      </div>
      <div class="modal-footer" style = "border: none; margin-top: -30px; padding: 20px; align-items: center; justify-content: center; ">
        <!-- <button id="btnCancelUnlock" style = "background-color: #d3d3d3">CANCEL</button>
        <button  style = "background-color: var(--primary-color)">CONTINUE</button> -->

        <button id="btnCancelUnlock" style = "background-color: grey; margin-right: 10px; font-weight: normal; border-radius: 5px;">CANCEL</button>
        <button id = "btnContinueUnlock" style = "background-color: var(--primary-color); font-weight: normal; border-radius: 5px;">CONTINUE</button>
      </div>
    </div>
  </div>
</div>
