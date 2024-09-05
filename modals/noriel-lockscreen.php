<style>
 #lockscreen .modal-content {
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
#lockscreen .modal-header{
  border: none;
}
#lockscreen .modal-footer button {
  width: 100px;
  height: 25px;
  display: flex;
  align-items: center; 
  justify-content: center; 
  text-align: center; 
  margin-left: 30px;
}

#unlockPasswordTxt::placeholder {
            color: whitesmoke; 
            font-size: 15px;
            font-style: italic;
            opacity: 1;
        }

#unlockPasswordTxt{
  height: 30px;
}

#btnContinueUnlock{
  font-size: 12px;
}

.unlockscreen svg{
  margin-left:50px ;
}

.modal-body{
    background-color: transparent ;

  }



@media screen and (max-width: 1400px) {


  .modal-body{
    background-color: transparent !important;

  }

  #lockscreen .modal-content {
    margin-top: 15vh;

}

}
</style>


<div class="modal" id="lockscreen" tabindex="-1" aria-labelledby="lockscreenLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.8); z-index: 9999;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-logout" style="background: transparent">
      <div class="modal-header">
        <img src="assets/img/lock-icon.png" style="width: auto; height: auto;" alt="logo"/>
      </div>

      <div class="modal-body" id="unlockscreen" style="display: none;">
        <!-- Initially, this input is hidden -->
        <div class="input-group unlockscreen">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#fff" class="bi bi-upc-scan" viewBox="0 0 16 16">
              <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5M3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0z"></path>
            </svg>
            <input type="password" id="unlockPasswordTxt" placeholder="Scan your ID or enter your password" style="width: 275px; border: 1px solid #d3d3d3; background-color: grey; text-align: center; display: block; margin-left:5px;" autocomplete="off"/>
            <button id = "btnContinueUnlock" style = "background-color: var(--primary-color); height: 30px; font-weight: normal; border-radius: 5px; margin-left: 5px;">CONTINUE</button>
            </div>
            <p class="errorResponse" style="color: red !important"></p>

      </div>

      <div class="modal-footer" id="modalFooter" style="border: none; margin-top: -10px; padding: 20px; align-items: center; justify-content: center;">
        <button class="requestPermissionBtn continueT" style="background-color: grey; margin-right: -20px; font-weight: normal; border-radius: 5px;">LOGOUT</button>
        <button class="requestPermissionBtn cancelT" style="background-color: var(--primary-color); font-weight: normal; border-radius: 5px;">STAY</button>
      </div>
    </div>
  </div>
</div>
