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
</style>

<div class="modal" id="lockscreen" tabindex="-1" aria-labelledby="lockscreenLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.8);    z-index: 9999;";>
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content modal-logout" style = "background: transparent">
      <div class="modal-header">
        <img src="assets/img/lock-icon.png" style = "width: auto; height: auto;" alt="logo"/>
      </div>
      <div class="modal-footer" style = "border: none; margin-top: -10px; padding: 20px; align-items: center; justify-content: center; ">
        <button class="requestPermissionBtn continueT" style = "background-color: grey; margin-right: -20px; font-weight: normal; border-radius: 5px;">LOGOUT</button>
        <button class="requestPermissionBtn cancelT" style = "background-color: var(--primary-color); font-weight: normal; border-radius: 5px;">STAY</button>
      </div>
    </div>
  </div>
</div>
