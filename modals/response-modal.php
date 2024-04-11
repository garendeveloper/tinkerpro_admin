<style>
.response_modal {
    display: flex; 
    justify-content: center; 
    align-items: center; 
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    background-color: rgba(0, 0, 0, 0.4);
}

.response_modal-content {
    background-color: #1E1C11;
    color: #fff;
    margin: auto;
    padding: 20px;
    border: 1px solid #fff;
    width: 100%;
}
#r_message{
    color: #FF6900;
}
.close {
    color: #fff;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #FF6900;
    text-decoration: none;
    cursor: pointer;
}
</style>

<div id="response_modal" class="response_modal" style = "display: none">
  <div class="response_modal-content">
    <span class="close" id = "r_close">&times;</span>
    <h3 id = "r_message" style = "text-align:center"></h3>
  </div>
</div>
