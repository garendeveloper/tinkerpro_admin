<style>
 
</style>
<div class="modal" id="permModal" tabindex="-1" aria-labelledby="permModalLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.9)";>
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-perm">
      
        <button type="button" class="close close-button " name="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="permModalLabel">
          <div class="warning-container">
          <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 47.5 47.5" viewBox="0 0 47.5 47.5" id="Warning">
            <defs>
              <clipPath id="a">
                <path d="M0 38h38V0H0v38Z" fill="#000000" class="color000000 svgShape"></path>
              </clipPath>
            </defs>
            <g clip-path="url(#a)" transform="matrix(1.25 0 0 -1.25 0 47.5)" fill="#000000" class="color000000 svgShape">
              <path fill="#b50604" d="M0 0c-1.842 0-2.654 1.338-1.806 2.973l15.609 30.055c.848 1.635 2.238 1.635 3.087 0L32.499 2.973C33.349 1.338 32.536 0 30.693 0H0Z" transform="translate(3.653 2)" class="colorffcc4d svgShape"></path>
              <path fill="#131212" d="M0 0c0 1.302.961 2.108 2.232 2.108 1.241 0 2.233-.837 2.233-2.108v-11.938c0-1.271-.992-2.108-2.233-2.108-1.271 0-2.232.807-2.232 2.108V0Zm-.187-18.293a2.422 2.422 0 0 0 2.419 2.418 2.422 2.422 0 0 0 2.419-2.418 2.422 2.422 0 0 0-2.419-2.419 2.422 2.422 0 0 0-2.419 2.419" transform="translate(16.769 26.34)" class="color231f20 svgShape"></path>
            </g>
          </svg>
            <p class="warning-title"><b>ATTENTION</b></p>
            <p style="font-family: Century Gothic; color: var(--primary-color);"><b>[PERMISSION REQUIRED]</b></p>
          </div>
        </h5>
        <div class="warningCards">
        <div style="width: 100%">
          <h6 style="display: flex; align-items: center; justify-content: center; margin-bottom: 0;">To grant access to&nbsp;<span style="color: var(--primary-color)" id="toChangeText">Refund</span>&nbsp;,enter</h6>
          <h6 style="display: flex; align-items: center; justify-content: center; margin-top: 0;">access code or scan ID</h6>
        </div>
        <div style="display: flex; align-items: center; justify-content: center;">
          <div style="margin-right: 10px" class="svg_icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-upc-scan" viewBox="0 0 16 16">
              <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5M3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0z"/>
            </svg>
          </div>
          <input type="password" id="adminCredentials" name="username" autofocus placeholder="Scan ID or Type Password" class="form-control shadow-none me-2 custom-width" style="border-radius: 0; width: 360px;">
          <button hidden type="submit" id="forUsers" name="loginUsers" class="permissions form-control primary-color-btn" style="width: auto; border: none; border-radius: 0; margin-top: 1vh">Continue</button>
          <button hidden type="submit" id="forProducts" name="loginProducts" class="permissions form-control primary-color-btn" style="width: auto; border: none; border-radius: 0; margin-top: 1vh">Continue</button>
          <button hidden type="submit" id="forReportings" name="loginReportings" class="permissions form-control primary-color-btn" style="width: auto; border: none; border-radius: 0; margin-top: 1vh">Continue</button>
          <button hidden type="submit" id="forInventory" name="loginInventory" class="permissions form-control primary-color-btn" style="width: auto; border: none; border-radius: 0; margin-top: 1vh">Continue</button>
          <button hidden type="submit" id="forUser" name="loginUser" class="permissions form-control primary-color-btn" style="width: auto; border: none; border-radius: 0; margin-top: 1vh">Continue</button>
        </div>
        </div>
        <div class="confirmation-container" style="display: flex; align-items: right; width: 100%; justify-content: right;">
        <button class="requestPermissionBtn">REQUEST ACCESS</button>
      </div>
    </div>
  </div>
</div>

<script>
  function permModals() {
    $('#permModal').show();
    $('#adminCredentials').focus();

  }
$('.close-button').on('click', function(){
  $('#permModal').hide();
  $('#toChangeText').text("Users Abilities")
  document.getElementById('adminCredentials').value = "";
  var forUsers = document.getElementById('forUsers')
  forUsers.setAttribute('hidden',true)
  var forProducts = document.getElementById('forProducts')
  forProducts.setAttribute('hidden',true);
  var forReportings = document.getElementById('forReportings')
  forReportings.setAttribute('hidden',true);
})

  $('#forUsers').on('click',function() {
           var crdntials = document.getElementById('adminCredentials').value
           axios.get(`api.php?action=credentialsAdmin&credentials=${crdntials}`)
           .then(function(response){
           var crdtls = response.data.credentials
           var userID = document.getElementById('userId').value;
           if(crdtls){
               axios.get(`api.php?action=getPermissionLevel&userID=${userID}`).then(function(response){
                   var accessLevel = response.data.permission[0].permission
                   var accLvl = JSON.parse(accessLevel)
                   if(accLvl[0].Users== "Access Granted") {
                    $('#granted_modal').show()
                        $('.grantedBtn').focus()
                        if($('#granted_modal').is(":visible")){
                                $('#permModal').hide(); 
                                $('#adminCredentials').val(""); 
                            }

                        $('#grantedClose, .grantedBtn').on('click', function(){
                            $('#granted_modal').hide()
                            if(!$('#granted_modal').is(':visible')){
                              var checkboxes = document.querySelectorAll('.accessLevel input[type="checkbox"]');
                              checkboxes.forEach(function(checkbox) {
                                  checkbox.disabled = false;
                       });
                       
                            }
                        })
                   } 
                   
                   else {
                    $('#denied_modal').show()
                       $('.deniedBtn').focus()
                       if(  $('#denied_modal').is(":visible")){
                            $('#permModal').hide(); 
                            $('#adminCredentials').val(""); 
                       }
                       $('#deniedClose').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })
                       $('.deniedBtn').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })

                   }

               }).catch(function(error){
                $('#denied_modal').show()
                       $('.deniedBtn').focus()
                       if(  $('#denied_modal').is(":visible")){
                            $('#permModal').hide(); 
                            $('#adminCredentials').val(""); 
                       }
                       $('#deniedClose').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })
                       $('.deniedBtn').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })

                })
           }else{
        
              modifiedMessageAlert('error', 'Admin password or ID is incorrect!', false, false);
         
           }
           }).catch(function(error){
            
           })
          })
  
 
    $('#permModal').keydown(function(e) {
        switch(e.which){
          case 27:
          $('button[name="close"]').click();
        break;
        default: return; 
        }
      e.preventDefault(); 
    }); 


   //products
   $('#forProducts').on('click',function() {
          $('#add_users_modal').hide()
           var crdntials = document.getElementById('adminCredentials').value
           axios.get(`api.php?action=credentialsAdmin&credentials=${crdntials}`)
           .then(function(response){
           var crdtls = response.data.credentials
           var userID = document.getElementById('userId').value;
           if(crdtls){
               axios.get(`api.php?action=getPermissionLevel&userID=${userID}`).then(function(response){
                   var accessLevel = response.data.permission[0].permission
                   var accLvl = JSON.parse(accessLevel)
                   if(accLvl[0].Products == "Access Granted") {
                    $('#granted_modal').show()
                        $('.grantedBtn').focus()
                        if($('#granted_modal').is(":visible")){
                                $('#permModal').hide(); 
                                $('#adminCredentials').val(""); 
                            }

                        $('#grantedClose, .grantedBtn').on('click', function(){
                            $('#granted_modal').hide()
                            if(!$('#granted_modal').is(':visible')){
                              window.location.href = "products";

                               
    

                            }
                        })
                   } 
                   
                   else {
                    $('#denied_modal').show()
                       $('.deniedBtn').focus()
                       if(  $('#denied_modal').is(":visible")){
                            $('#permModal').hide(); 
                            $('#adminCredentials').val(""); 
                       }
                       $('#deniedClose').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })
                       $('.deniedBtn').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })

                   }

               }).catch(function(error){
                $('#denied_modal').show()
                       $('.deniedBtn').focus()
                       if(  $('#denied_modal').is(":visible")){
                            $('#permModal').hide(); 
                            $('#adminCredentials').val(""); 
                       }
                       $('#deniedClose').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })
                       $('.deniedBtn').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })

                })
           }else{
               modifiedMessageAlert('error', 'Admin password or ID is incorrect!' , false, false);
               console.log('hello')
           }
           }).catch(function(error){
            $('#denied_modal').show()
                       $('.deniedBtn').focus()
                       if(  $('#denied_modal').is(":visible")){
                            $('#permModal').hide(); 
                            $('#adminCredentials').val(""); 
                       }
                       $('#deniedClose').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })
                       $('.deniedBtn').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })

           })
           })
//Reporting
$('#forReportings').on('click',function() {
  $('#add_users_modal').hide()
           var crdntials = document.getElementById('adminCredentials').value
           axios.get(`api.php?action=credentialsAdmin&credentials=${crdntials}`)
           .then(function(response){
           var crdtls = response.data.credentials
           var userID = document.getElementById('userId').value;
           if(crdtls){
               axios.get(`api.php?action=getPermissionLevel&userID=${userID}`).then(function(response){
                   var accessLevel = response.data.permission[0].permission
                   var accLvl = JSON.parse(accessLevel)
                   if(accLvl[0].Reports== "Access Granted") {
                    $('#granted_modal').show()
                        $('.grantedBtn').focus()
                        if($('#granted_modal').is(":visible")){
                                $('#permModal').hide(); 
                                $('#adminCredentials').val(""); 
                            }

                        $('#grantedClose, .grantedBtn').on('click', function(){
                            $('#granted_modal').hide()
                            if(!$('#granted_modal').is(':visible')){
                              window.location.href = "reporting";
                            }
                        })
                   } 
                   
                   else {
                    $('#denied_modal').show()
                       $('.deniedBtn').focus()
                       if(  $('#denied_modal').is(":visible")){
                            $('#permModal').hide(); 
                            $('#adminCredentials').val(""); 
                       }
                       $('#deniedClose').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })
                       $('.deniedBtn').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })

                   }

               }).catch(function(error){
                $('#denied_modal').show()
                       $('.deniedBtn').focus()
                       if(  $('#denied_modal').is(":visible")){
                            $('#permModal').hide(); 
                            $('#adminCredentials').val(""); 
                       }
                       $('#deniedClose').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })
                       $('.deniedBtn').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })

                })
           }else{
        
              modifiedMessageAlert('error', 'Admin password or ID is incorrect!', false, false);
         
           }
           }).catch(function(error){
            
           })
          })
  //inventory
  $('#forInventory').on('click',function() {
  $('#add_users_modal').hide()
           var crdntials = document.getElementById('adminCredentials').value
           axios.get(`api.php?action=credentialsAdmin&credentials=${crdntials}`)
           .then(function(response){
           var crdtls = response.data.credentials
           var userID = document.getElementById('userId').value;
           if(crdtls){
               axios.get(`api.php?action=getPermissionLevel&userID=${userID}`).then(function(response){
                   var accessLevel = response.data.permission[0].permission
                   var accLvl = JSON.parse(accessLevel)
                   if(accLvl[0].Inventory== "Access Granted") {
                    $('#granted_modal').show()
                        $('.grantedBtn').focus()
                        if($('#granted_modal').is(":visible")){
                                $('#permModal').hide(); 
                                $('#adminCredentials').val(""); 
                            }

                        $('#grantedClose, .grantedBtn').on('click', function(){
                            $('#granted_modal').hide()
                            if(!$('#granted_modal').is(':visible')){
                              window.location.href = "inventory";
                            }
                        })
                   } 
                   
                   else {
                    $('#denied_modal').show()
                       $('.deniedBtn').focus()
                       if(  $('#denied_modal').is(":visible")){
                            $('#permModal').hide(); 
                            $('#adminCredentials').val(""); 
                       }
                       $('#deniedClose').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })
                       $('.deniedBtn').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })

                   }

               }).catch(function(error){
                $('#denied_modal').show()
                       $('.deniedBtn').focus()
                       if(  $('#denied_modal').is(":visible")){
                            $('#permModal').hide(); 
                            $('#adminCredentials').val(""); 
                       }
                       $('#deniedClose').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })
                       $('.deniedBtn').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })

                })
           }else{
        
              modifiedMessageAlert('error', 'Admin password or ID is incorrect!', false, false);
         
           }
           }).catch(function(error){
            
           })
          })
 //User
   $('#forUser').on('click',function() {
  $('#add_users_modal').hide()
           var crdntials = document.getElementById('adminCredentials').value
           axios.get(`api.php?action=credentialsAdmin&credentials=${crdntials}`)
           .then(function(response){
           var crdtls = response.data.credentials
           var userID = document.getElementById('userId').value;
           if(crdtls){
               axios.get(`api.php?action=getPermissionLevel&userID=${userID}`).then(function(response){
                   var accessLevel = response.data.permission[0].permission
                   var accLvl = JSON.parse(accessLevel)
                   if(accLvl[0].Users== "Access Granted") {
                    $('#granted_modal').show()
                        $('.grantedBtn').focus()
                        if($('#granted_modal').is(":visible")){
                                $('#permModal').hide(); 
                                $('#adminCredentials').val(""); 
                            }

                        $('#grantedClose, .grantedBtn').on('click', function(){
                            $('#granted_modal').hide()
                            if(!$('#granted_modal').is(':visible')){
                              window.location.href = "users";
                            }
                        })
                   } 
                   
                   else {
                    $('#denied_modal').show()
                       $('.deniedBtn').focus()
                       if(  $('#denied_modal').is(":visible")){
                            $('#permModal').hide(); 
                            $('#adminCredentials').val(""); 
                       }
                       $('#deniedClose').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })
                       $('.deniedBtn').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })

                   }

               }).catch(function(error){
                $('#denied_modal').show()
                       $('.deniedBtn').focus()
                       if(  $('#denied_modal').is(":visible")){
                            $('#permModal').hide(); 
                            $('#adminCredentials').val(""); 
                       }
                       $('#deniedClose').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })
                       $('.deniedBtn').on('click', function(){
                           $('#denied_modal').hide()
                           $('#permModal').show()
                           $('#adminCredentials').focus()
                       })

                })
           }else{
        
              modifiedMessageAlert('error', 'Admin password or ID is incorrect!', false, false);
         
           }
           }).catch(function(error){
            
           })
          })
 //User

    $('#permModal').keydown(function(e) {
        switch(e.which){
          case 27:
          $('button[name="close"]').click();
        break;
        default: return; 
        }
      e.preventDefault(); 
    }); 
                
  $('#adminCredentials').keydown(function(e) {
        switch(e.which){
         case 13: 
          var c =  $('#adminCredentials').val()
          if(userSValidate == true && c != ""){
            $('button[name="loginUsers"]').click();
          }
          else if(productSValidate == true  && c != ""){
            $('button[name="loginProducts"]').click();
          }
          else if(reportingsValidate == true  && c != ""){
            $('button[name="loginReportings"]').click();
          }
          else if(inventoryValidate == true  && c != ""){
            $('button[name="loginInventory"]').click();
          }
          else if(userValidate == true  && c != ""){
            $('button[name="loginUser"]').click();
          }
        break;
        default: return; 
        }
      e.preventDefault(); 
    });
</script>

