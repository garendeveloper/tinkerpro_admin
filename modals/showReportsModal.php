<style>
 #showReportsModal  .modal-dialog {
  max-width: 1000px; 
  min-width: 500px; 
  
}

@media (max-width: 1000px) {
  #showReportsModal  .modal-dialog {
    max-width: 90vw; 
  }
}

#showReportsModal .modal-content {
  color: #ffff;
  background: #262625;
  border-radius: 0;
  position: relative;
  height: 800px;
  width: 1000px

}



#showReportsModal .close-button {
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

#showReportsModal .modal-title {
  font-family: Century Gothic;
  font-size: 1.5em;
  margin-top: 1em;
  margin-bottom: 0.5em;
  display: flex;
  align-items: center;
}

#showReportsModal .warning-container {
  display: flex;
  align-items: center;
}

#showReportsModal .warning-container svg {
  width: 35px;
  height: 35px;
  margin-right: 0.5em;
  margin-left: 1em;
  margin-top: -0.5em;
}

.warning-title {
  font-family: Century Gothic;
  font-size: large;
}


.pdf-viewer-container {
  padding-left: 2em;
  padding-right: 2em;
  width: 100%;
  height: 100%;
  padding-bottom: 4em;
 
}
@keyframes rotate {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

</style>

<div class="modal" id="showReportsModal"  tabindex="0" style="background-color: rgba(0, 0, 0, 0.7); overflow: hidden; z-index: 2000;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <button id="reportsClose"  name="reportsClose" class="close-button" style="font-size: larger;">&times;</button>
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
          <p class="warning-title"><b>SHOW REPORTS</b></p>&nbsp;
        </div>
      </div>
      <div hidden id="loadingImage" style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 85vh; position: absolute; top: 0; left: 0; width: 100%; background: rgba(255,255,255,0.8); z-index: 9999;">
            <h3 style="color: #FF6900"><b></b>LOADING PLEASE WAIT</b></h3><br>
            <img src="assets/img/globe.png" alt="Globe Image" style="width:75px; height: 75px; animation: rotate 2s linear infinite;" />
        </div>
    <div hidden id="pdfFile"class="pdf-viewer-container">
        <iframe id="pdfViewer" src="" frameborder="0" width="935px" height="700px"></iframe>
    </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
    $('#reportsClose').on('click', function() {
        $('#showReportsModal').hide();
        $('#pdfViewer').attr('src', '');
        var loadingImage = document.getElementById("loadingImage");
         loadingImage.setAttribute("hidden",true);
        var pdfFile= document.getElementById("pdfFile");
         pdfFile.setAttribute('hidden',true)
    });
});
 
</script>
