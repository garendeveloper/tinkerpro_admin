<style>

#add_coupon_modal {
  display: none;
  position: fixed; 
  z-index: 2000;
  top: 0;
  bottom: 0;
  left: calc(100% - 500px); 
  width: 500px;
  background-color: transparent;
  overflow: hidden;
  height: 100vh; 
  animation: slideInRight 0.5s; 
}

.coupon-modal {
  background-color: #fefefe;
  margin: 0 auto; 
  border: none;
  width: 100%;
  height: 100vh;
  animation: slideInRight 0.5s; 
  border-radius: 0;
  margin-top: -28px;
  background-color: #1E1C11;  
  border-color:  #1E1C11;
  color:#fefefe;
}




/* Modal Background */
/* #add_coupon_modal {
display: none;
position: fixed; 
z-index: 2000;
left: 0;
top: 0;
width: 100%;
height: 100%;
background-color: rgba(0, 0, 0, 0.7);
overflow: auto; 
} */

/* Modal Content */
/* .coupon-modal {
    background-color: #1c1c1c; 
   margin: 10% auto;   
    padding: 20px;
    
    width: 450px; 
    color: #fff; 
    border-radius: 10px;
    font-family: Arial, sans-serif;
} */



/* Flex Container for Inputs */
.coupon-input-group{
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}


.coupon-input-group input {
    text-align: right;
    max-width: 190px;
    min-width: 50px;
    height:30px;
   
}

.coupon-input-group input::placeholder{
    font-style: italic;
}
.coupon-input-group input[type="text"], input[type="number"] {
            flex: 2;
            padding: 8px;
            box-sizing: border-box;
            border: none;
            border-radius: 5px;
            color: #fff;
            border-color:var(--primary-color)!important;
            border: 1px solid white;
        }


.qr-section input[type="text"], input[type="number"] {
            flex: 2;
            padding: 8px;
            box-sizing: border-box;
            border: none;
            border-radius: 5px;
            color: #fff;
            border-color:var(--primary-color)!important;
            border: 1px solid white;
        }

.customer-info input[type="text"] {
    flex: 2;
    padding: 8px;
    box-sizing: border-box;
    border: none;
    border-radius: 5px;
    color: #fff;
    border-color:var(--primary-color)!important;
    border: 1px solid white;
}



/* Labels and Input Fields */
label {
    flex: 1;
    margin-right: 10px;
}

        
.coupon-input-group label {
  flex-grow: 1;
  /* color: var(--primary-color); */
}



/* Add Customer Button */
.add-customer {
    background-color: #2ba853;
    color: white;
   
    border: none;
    border-radius: 5px;
    text-align: center;
    cursor: pointer;
    width: 100%;
    margin-bottom: 10px;
    margin-top: 40px;
    height: 35px;
    background-color: var(--primary-color);
}

/* QR Code Section */
.qr-section {
    text-align: center;
    margin-top: 50px;
}

.qr-section img {
    margin-top: 40px;
}

/* Save & Print Button */
.save-print {
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: 5px;
    text-align: center;
    cursor: pointer;
    width: 100%;
    margin-top: 10px;
    height: 35px;
}

/* Disabled Buttons (Edit/Delete) */
.disabled {
    background-color: #555;
    color: white;
    border: none;
    border-radius: 5px;
    text-align: center;
    cursor: not-allowed;
    width: 100%;
    margin-top: 10px;
    height: 35px;
}

/* Close Button */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #fff;
    text-decoration: none;
    cursor: pointer;
}

.customer-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 5px;
    margin-top: 10px;
   
}

.customer-info span {
    color: #fff;
}

.delete-customer {
    color: #d9534f;
    cursor: pointer;
    font-weight: bold;
}


.title{
    top: 0;
    margin-bottom: 30px;
    font-size: 20pt;
}

.coupon-button{
margin-top: 70px;
}


</style>

<div class="modal settingModal" id="add_coupon_modal" tabindex="0">
  <div class="modal-dialog ">
    <div class="modal-content coupon-modal">
      <div class="modal-title">
        <div style="margin-top: 30px; margin-bottom:50px; margin-left: 20px">
         <!-- <span class="close">&times;</span>
        <h2 class="title">Generate New Coupon</h2> -->
        <h2 class="text-custom modalHeaderTxt" id="modalHeaderTxt" style="color:#FF6900;">Generate New Coupon</h2>

        </div>
        <div class="warning-container">
        <div style="margin-left: 20px;margin-right: 20px;margin-top: 20px">
       
        <div class="input-group coupon-input-group">
      <label for="amount">Amount (Php):</label> 
      <input type="text" id="amount" name="amount" placeholder="amount" >
    </div>

    <div class="input-group coupon-input-group">
      <label for="validity">Validity (Days):</label>
      <input type="text" id="validity" name="validity"  placeholder="validity days">
    </div>
    <div class="input-group coupon-input-group">
      <label for="multipleUse">Multiple Use:</label>
      <input type="text" id="multipleUse" name="multipleUse" placeholder="multiple use" >
    </div>

    <button class="add-customer">ADD CUSTOMER</button>

    <div class="customer-info">
    <input type="text" id="coupon-customer" name="coupon-customer" placeholder="customer name" >
    </div>

    <div class="qr-section">
        <label for="qrCode">Generate QR Code</label>
        <input type="text" id="qrCode" name="qrCode" placeholder="Generate QR">
        <img src="https://via.placeholder.com/100" alt="QR Code">
    </div>


    <div class="coupon-button">   
        <button class="disabled">EDIT</button>
        <button class="disabled">DELETE</button>
        <button class="save-print">SAVE & PRINT</button> 
    </div>
  


          </div>
        </div>
      </div>
    </div>
  </div>
</div>
