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


.coupon-input-group input, select {
    text-align: left;
    max-width: 190px;
    min-width: 50px;
    height:30px;
   
}

.coupon-input-group input::placeholder{
    font-style: italic;
}

.coupon-input-group input[type="text"], input[type="date"] {
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

.coupon-input-group select {
    flex: 2;
    padding: 4px;
    box-sizing: border-box;
    border: none;
    border-radius: 5px;
    color: #fff;
    border-color: var(--primary-color) !important;
    border: 1px solid white;
    background-color: #1E1C11; 
 
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
    margin-top: 20px;
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

#print {
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
margin-top: 50px;
}

.qr-section svg{
    margin-top: 10px;
}

#generateQr{
    cursor: pointer ;
    margin-top: -2px;
    margin-left: -45px;
    position: absolute;
    height: 45px;
}

.coupon-alert{
    text-align: center;
}


@media screen and (max-width: 1400px) {


.modal{
    zoom:90%;
}

.modal-content{
        height: 800px;
        width:400px;
        margin-right:-10px ;
      
      }

      #add_coupon_modal{
        height: 900px;
      }

      .coupon-button{
        margin-top: -30px;
      }

      .add-customer{
        margin-top: 10px;
      }

      #modalHeaderTxt{
        font-size: 25px;
      }
      
      .qr-section svg{
    margin-top: 0px;
    margin-bottom: 20px;
}

.coupon-alert{
    text-align: center;
    margin-top: -30px;
    padding-bottom: 20px;
}

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
      <input type="text" id="amount" name="amount" placeholder="amount" required>
    </div>

    <div class="input-group coupon-input-group">
      <label for="validity">Validity (Days):</label>
      <input type="date" id="validity" name="validity"  placeholder="validity days" required>
    </div>

    <!-- <div class="input-group coupon-input-group">
      <label for="multipleUse">Multiple Use:</label>
      <input type="text" id="multipleUse" name="multipleUse" placeholder="multiple use" >
    </div> -->

    <div class="input-group coupon-input-group">
        <label for="multipleUse">Multiple Use:</label>
        <select id="multipleUse" name="multipleUse">
            <!-- <option >Select</option> -->
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>
    </div>


    <button class="add-customer">ADD CUSTOMER</button>

    <div class="customer-info">
    <input type="text" id="coupon-customer" name="coupon-customer" placeholder="customer name" >
    </div>

    <div class="qr-section">
        <label for="qrCode">Generate QR Code</label>
        <input type="text" id="qrCode" name="qrCode" placeholder="Generate QR" required>
         <svg  id="generateQr" width="50px" height="50px" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g>
          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier">
          <path d="M9 5.30423C6.33576 6.60253 4.5 9.33688 4.5 12.5C4.5 16.9183 8.08172 20.5 12.5 20.5C16.9183 20.5 20.5 16.9183 20.5 12.5C20.5 8.08172 16.9183 4.5 12.5 4.5V14.5" stroke="var(--primary-color)" stroke-width="1.2"></path>
          <path d="M16 11L12.5 14.5L9 11" stroke="var(--primary-color)" stroke-width="1.2"></path> </g>
        </svg>
         
        <br>
        <svg  width="250px" height="250px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="var(--primary-color)">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier"><path d="M3 9h6V3H3zm1-5h4v4H4zm1 1h2v2H5zm10 4h6V3h-6zm1-5h4v4h-4zm1 1h2v2h-2zM3 21h6v-6H3zm1-5h4v4H4zm1 1h2v2H5zm15 2h1v2h-2v-3h1zm0-3h1v1h-1zm0-1v1h-1v-1zm-10 2h1v4h-1v-4zm-4-7v2H4v-1H3v-1h3zm4-3h1v1h-1zm3-3v2h-1V3h2v1zm-3 0h1v1h-1zm10 8h1v2h-2v-1h1zm-1-2v1h-2v2h-2v-1h1v-2h3zm-7 4h-1v-1h-1v-1h2v2zm6 2h1v1h-1zm2-5v1h-1v-1zm-9 3v1h-1v-1zm6 5h1v2h-2v-2zm-3 0h1v1h-1v1h-2v-1h1v-1zm0-1v-1h2v1zm0-5h1v3h-1v1h-1v1h-1v-2h-1v-1h3v-1h-1v-1zm-9 0v1H4v-1zm12 4h-1v-1h1zm1-2h-2v-1h2zM8 10h1v1H8v1h1v2H8v-1H7v1H6v-2h1v-2zm3 0V8h3v3h-2v-1h1V9h-1v1zm0-4h1v1h-1zm-1 4h1v1h-1zm3-3V6h1v1z"></path><path fill="none" d="M0 0h24v24H0z"></path></g>    
        </svg>
    </div>

    <div class="coupon-alert">
    </div>

    <div class="coupon-button">   
        <button class="disabled">EDIT</button>
        <button id="delete-customer" class="disabled">DELETE</button>
        <button class="save-print">SAVE & PRINT</button> 

    </div>
  


          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

document.querySelector('#generateQr').addEventListener('click', function() {
    const amount = document.getElementById('amount').value;
    const validity = document.getElementById('validity').value;

    const qrNumber = 'QR-' + Math.random().toString(36).substr(2, 9).toUpperCase();

    document.getElementById('qrCode').value = qrNumber;
});

document.querySelector('.save-print').addEventListener('click', function() {
    const amount = document.getElementById('amount').value.trim();
    const validity = document.getElementById('validity').value.trim();
    const qrNumber = document.getElementById('qrCode').value.trim();
    const multipleUse = document.getElementById('multipleUse').value;
    const alertDiv = document.querySelector('.coupon-alert');

    // Clear any previous alerts
    alertDiv.innerHTML = "";

    // Validate if amount, validity, and QR code fields are filled
    if (amount === "" || validity === "" || qrNumber === "" || multipleUse === "") {
        alertDiv.innerHTML = "<p style='color:red;'>Please fill out all required fields before saving.</p>";
        return; 
    }

    // If validation passes, proceed with the fetch request
    fetch('add_coupon.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            amount: amount,
            validity: validity,
            qrNumber: qrNumber,
            multipleUse: multipleUse
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alertDiv.innerHTML = `<p style='color:green;'>Coupon saved successfully!</p>`;
            $('#add_coupon_modal').hide();
            couponIdToPrint = data.id;
            refreshTable()
            // location.reload()
        } else {
            alertDiv.innerHTML = "<p style='color:red;'>Server Error: " + data.error + "</p>";
        }
    })
    .catch(error => {
        alertDiv.innerHTML = "<p style='color:red;'>Fetch Error: " + error.message + "</p>";
    });
});


document.getElementById('delete-customer').addEventListener('click', function() {
    // Clear all input fields
    document.getElementById('amount').value = '';
    document.getElementById('validity').value = '';
    document.getElementById('qrCode').value = '';
    document.getElementById('coupon-customer').value = '';
    document.getElementById('multipleUse').selectedIndex = 0; // Reset to the first option
});


// Print coupon when the print button is clicked
$(document.body).on('click', '.save-print', function() {
    if (couponIdToPrint !== null) {
        console.log("Coupon ID to print:", couponIdToPrint);
        
    } else {
        console.log("No coupon ID available to print.");
    }
 
    var id = couponIdToPrint;

    $('#confirmModal').modal('show');
  

});

</script>