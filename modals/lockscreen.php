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
</style>
<div class="modal" id="lockscreen" tabindex="-1" aria-labelledby="lockscreenLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.9)";>
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-logout">
      <div class="modal-header">
      <img src="assets/img/tinkerpro-logo-light.png" style = "width: 200px; height: 80px;" alt="logo"/>
      </div>
      <h4>You've been away for 1 minute. Stay or logout?</h4>
      <div class="confirmation-container" style="display: flex; align-items: center; width: 100%; ">
        <button class="requestPermissionBtn continueT">LOGOUT</button>
        <button class="requestPermissionBtn cancelT">STAY</button>
      </div>
    </div>
  </div>
</div>
