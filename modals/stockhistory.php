<style>
 #stockhistory_modal  .modal-dialog {
  max-width: 1000px; 
  min-width: 500px; 
  
}

@media (max-width: 1000px) {
  #stockhistory_modal  .modal-dialog {
    max-width: 90vw; 
  }
}

#stockhistory_modal .modal-content {
  color: #ffff;
  background: #262625;
  border-radius: 0;
  position: relative;
  height: 400px;
  width: 1000px

}



#stockhistory_modal .close-button {
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

#stockhistory_modal .modal-title {
  font-family: Century Gothic;
  font-size: 1.5em;
  margin-top: 1em;
  margin-bottom: 0.5em;
  display: flex;
  align-items: center;
}

#stockhistory_modal .warning-container {
  display: flex;
  align-items: center;
}

#stockhistory_modal .warning-container svg {
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

<div class="modal" id="stockhistory_modal"  tabindex="0" style="background-color: rgba(0, 0, 0, 0.7); overflow: hidden; z-index: 2000;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" id = "stockhistory_modal_content">
      <button id="close-modal"  name="reportsClose" class="close-button" style="font-size: larger;">&times;</button>
      <div class="modal-title" style = "margin-left: 15px;">
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
        </div>
        
      </div>
      <div class="modal-body">
      <table id = "tbl_stocks_history" style = "font-family: Century Gothic;">
            <thead>
                <tr>
                    <th style = 'text-align:center;'>Document Type</th>
                    <th style = 'text-align:center'>Document </th>
                    <th style = 'text-align:center'>Customer</th>
                    <th style = 'text-align:center'>Transaction Date</th>
                    <th style = 'text-align:center'>Quantity</th>
                    <th style = 'text-align:center'>In Stock</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
    $("#stockhistory_modal #close-modal").on("click", function(){
        $("#stockhistory_modal").hide();
    })
</script>