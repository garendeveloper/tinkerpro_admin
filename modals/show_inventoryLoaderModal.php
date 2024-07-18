<style>
 #show_inventoryLoaderModal  .modal-dialog {
  max-width: 1000px; 
  min-width: 500px; 
  
}

@media (max-width: 1000px) {
  #show_inventoryLoaderModal  .modal-dialog {
    max-width: 90vw; 
  }
}

#show_inventoryLoaderModal .modal-content {
  color: #ffff;
  background: #262625;
  border-radius: 0;
  position: relative;
  height: 800px;
  width: 1000px

}



#show_inventoryLoaderModal .close-button {
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

#show_inventoryLoaderModal .modal-title {
  font-family: Century Gothic;
  font-size: 1.5em;
  margin-top: 1em;
  margin-bottom: 0.5em;
  display: flex;
  align-items: center;
}

#show_inventoryLoaderModal .warning-container {
  display: flex;
  align-items: center;
}

#show_inventoryLoaderModal .warning-container svg {
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

<div class="modal" id="show_inventoryLoaderModal"  tabindex="0" style="background-color: rgba(0, 0, 0, 0.7); overflow: hidden; z-index: 2000;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <button id="reportsClose"  name="reportsClose" class="close-button" style="font-size: larger;">&times;</button>
      <div class="modal-title">
      <div class="warning-container">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
            <polyline points="10 9 9 9 8 9"></polyline>
          </svg>
          <p class="warning-title"><b>SHOW INVENTORY COUNT REPORT</b></p>&nbsp;
        </div>
      </div>
      <div hidden id="loadingImage" style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 800px; position: absolute; top: 0; left: 0; width: 100%; background: rgba(255,255,255,0.8); z-index: 9999;">
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
        $('#show_inventoryLoaderModal').hide();
        $('#pdfViewer').attr('src', '');
        var loadingImage = document.getElementById("loadingImage");
         loadingImage.setAttribute("hidden",true);
        var pdfFile= document.getElementById("pdfFile");
         pdfFile.setAttribute('hidden',true)
    });
});
 
</script>
