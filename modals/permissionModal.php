<style>
  #permModal .modal-dialog {
    max-width: fit-content;
    min-width: 600px;
  }

  @media (max-width: 768px) {
    #permModal .modal-dialog {
      max-width: 90vw;
    }
  }

   .modal-perm {
    color: #ffff;
    background: #262625;
    border-radius: 0;
    min-height: 300px;
    position: relative;
  }

  #permModal .close-button {
    position: absolute;
    right: 1.6em;
    top: 10px;
    background: #FF6900;
    color: #fff;
    border: none;
    width: 40px;
    height: 40px;
    line-height: 30px;
    text-align: center;
    cursor: pointer;
    margin-top: 1vh;
  }

  #permModal .modal-title {
    font-family: Century Gothic;
    font-size: 1.5em;
    margin-top: 1em;
    margin-bottom: 0.5em;
    display: flex;
    align-items: center;
  }

  #permModal .warning-container {
    display: flex;
    align-items: center;
  }

  #permModal .warning-container img {
    width: 35px;
    height: 35px;
    margin-right: 0.5em;
    margin-left: 1vh;
    margin-top: -0.5em;
  }

  #permModal .warningCard {
    min-width: fit-content;
    /* Adjusted width */
    height: 180px;
    margin-left: 2em;
    border: 2px solid #4B413E;
    border-radius: 0;
    padding: 1.5vw;
    box-sizing: border-box;
    justify-content: flex-start;
    align-items: center;
    background: #262625;
    margin-right: 2em;
    flex-shrink: 0;
    margin-top: -2vh;
  }

  #permModal .warningText {
    color: #fff;
    margin-right: 2vw;
    font-size: 1.5em;
    font-family: "Century Gothic", sans-serif;
    white-space: nowrap;
    text-align: center;
  }


  #permModal .warning-container svg {
    width: 35px;
    height: 35px;
    margin-right: 0.5em;
    margin-left: 1em;
    margin-top: -0.5em;
  }
 .confirmation-container{
    margin-top: 1em;
    margin-bottom: 1em;
    display: flex;
  }
 .requestPermissionBtn{
    font-family: Century Gothic;
    width: 180px;
    height: 40px;
    margin-right: 2em;
 }
 #adminCredentials{
  margin-top: 1vh;
 }
 .permissions:focus{
   outline: none;
 }

</style>


<div class="modal" id="permModal" tabindex="1" style="background-color: rgba(0, 0, 0, 0.9); overflow: hidden; z-index: 999999;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-perm">
      <button id="permButton" class="close-button" style="font-size:larger">&times;</button>
         <div class="modal-title">
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
                   <p class="warning-title"><b>ATTENTION</b></p>&nbsp;
                   <p style="font-family: Century Gothic; color: #FF6900;"><b>[PERMISSION REQUIRED]</b></p>
            </div>
           </div>
          <div class="warningCard">
            <div style="width: 100%" >
                <h6 style="display:flex; align-items:center;justify-content: center;margin-bottom: 0;">To grant access to&nbsp;<span style="color:#FF6900" id="toChangeText">Refund</span>&nbsp;,enter</L></h6>
                <h6 style="display:flex; align-items:center;justify-content: center;margin-top: 0;">access code or scan ID</h6>
            </div>
            <div style="display:flex; align-items:center;justify-content: center;">
               <div style="margin-right: 10px" class="svg_icon">
                      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-upc-scan" viewBox="0 0 16 16">
                      <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5M3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0z"/>
                      </svg>
                </div>
                <input type="password" id="adminCredentials" name="username" autofocus placeholder="Scan ID or Type Password" class="form-control shadow-none me-2 custom-width" style="border-radius: 0; width: 360px;">
                <button type="submit" id="forRefund" name="login" class="permissions form-control primary-color-btn" style="width: auto; border: none; border-radius: 0; margin-top: 1vh" >Continue</button>
                <button hidden id="continueLogin" class="continue" style="width: auto; border: none; border-radius: 0; margin-top: 1vh" >Continue</button>
               </div>
          </div>
          <div class="confirmation-container"  style="display:flex; align-items:right;width: 100%;justify-content: right;">
              <button class="requestPermissionBtn">REQUEST ACCESS</button>           
         </div>  
    </div>
  </div>
</div>
<script>
var crdntials;
function permModals() {
    $('#permModal').show(); 
    $('#adminCredentials').focus()  
}
 $('#permButton').on('click', function(){
  $('#permModal').hide();   
 })

// $(document).on('input','#adminCredentials',function() {
//     crdntials =$('#adminCredentials').val();
//   })

</script>

