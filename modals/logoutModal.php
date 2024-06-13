<style>
 #logoutModal .modal-content {
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
#logoutModal .modal-header{
  border: none;
}
</style>
<div class="modal" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.9)";>
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-logout">
      <div class="modal-header">
      <img src="assets/img/tinkerpro-logo-light.png" style = "width: 200px; height: 80px;" alt="logo"/>
      </div>
      <h4>Are you sure you want to logout?</h4>
      <div class="confirmation-container" style="display: flex; align-items: center; width: 100%; ">
        <button class="requestPermissionBtn cancel_logout">CANCEL</button>
        <button class="requestPermissionBtn continue_logout">CONTINUE</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('.cancel_logout').on('click', function(){
    $('#logoutModal').hide();
  })
  $(".continue_logout").off("click").on("click", function(){
    $('#logoutModal').hide();
    window.location.href = "logout.php";
  })
</script>

