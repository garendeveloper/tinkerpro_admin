<style>
#add_users_modal {
  display: none;
  position: fixed; 
  z-index: 9999;
  top: 0;
  top: 0;
  bottom: 0;
  left: calc(100% - 500px); 
  width: 500px;
   background-color: transparent;
  overflow: hidden;
  height: 100%; 
  animation: slideInRight 0.5s; 
}


.user-modal {
  background-color: #fefefe;
  margin: 0 auto; 
  border: none;
  width: 100%;
  height: 1000px; 
  animation: slideInRight 0.5s; 
  border-radius: 0;
  margin-top: -28px;
  background-color: #1E1C11;  
  border-color:  #1E1C11;
  
}

@keyframes slideInRight {
  from {
    margin-right: -100%;
    opacity: 0;
  }
  to {
    margin-right: 0;
    opacity: 1;
  }
}
@keyframes slideOutRight {
  from {
    margin-right: 0;
    opacity: 1;
  }
  to {
    margin-right: -100%;
    opacity: 0;
  }
}


.imageCard{
    /* border: 2px solid #4B413E; 
    box-sizing: border-box;  */
    border-radius: 0;
    min-width: 500px;
    width: 100%;
    max-width: 500px; 
    height: 150px;
    min-height: 20%;
    max-height: 180px; 
    display:flex;
    margin-top:10px;
}
.tableCard{
    /* border: 2px solid #4B413E; 
    box-sizing: border-box;  */
    border-radius: 0;
    width: 100%;
    max-width: 500px;  
    height: fit-content;
    margin-top: 15px;
    margin-bottom: 15px;
    
}
.accessLevel {
    border-radius: 0;
    width: 100%;
    max-width: 500px;  
    height: fit-content;
    margin-left: 20px;
    display: flex;
    
}
.imageDiv{
    border: 2px solid #ffff; 
    box-sizing: border-box; 
    border-radius: 0;
    width: 70%;
    margin-right: 20px;
    margin-left:20px;
    display: flex;
    justify-content: center;
    align-items: center;
}




@media (max-width: 768px) {
    .modal {
        left: 0;
        width: 100%;
        max-width: 100%; 
    }
    
    .imageCard,
    .tableCard,
    .accessLevel {
        height: auto; 
        max-height: none; 
    }
}
.td-height{
    width:50%
}
.td-style{
    font-style: italic;
}
.td-bg{
    background-color: #404040;
}
.custom-input{
    padding-top: 0;
    padding-bottom: 0;
    margin-top: 0;
    margin-bottom: 0;   
}
.custom-btn {
  border-radius: 25%; 
  background-color: #A6A6A6; 
  transition: background-color 0.3s; 
}

.custom-btn:hover {
  background-color: #808080; 
}

.dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    z-index: 1;
  }

 
  .dropdown-content a {
    display: block;
    width: 100%;
    padding: 10px;
    min-width: 210px;
    border: none; 
    background-color: transparent;
    color: #000000; 
    text-decoration: none; 
    padding-top: 0;
    padding-bottom: 0;
    margin-top: 0;
    margin-bottom: 0;  
  }
  

  .dropdown-content a:hover {
    background-color: #ddd;
  }
  .font-custom{
    font-family: Century Gothic;
  }
  .custom {
    width: calc(100%);
    padding: 5px; 
    box-sizing: border-box;
    border: none; 
    background-color: transparent !important;
    color:#FFFFFF !important;
    font-family: Century Gothic !important;
    font-size: medium !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    margin-top: 0 !important;
    margin-bottom: 0 !important; 

}
.flatpickr-calendar {
    outline: none !important;
    border-radius: none !important;
}
.toggle-password {
    cursor: pointer;
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
}

.password-container {
    position: relative;
}



</style>

<div class="modal" id="add_users_modal" tabindex="0">
  <div class="modal-dialog ">
    <div class="modal-content user-modal">
      <div class="modal-title">
        <div class="warning-container">
            <div style="display: flex">
                <h2 style="margin-left: 20px" class="text-custom firstName">Unknown<span>&nbsp;</span><h2 class="text-custom lastName">Unknown</h2></h2></h2>
            </div>
            <div class="imageCard">
                 <div  style="width:30%" class="imageDiv" id="imageDiv">
                   
                </div> 
                 <div style="width:50%">
                 <input hidden type="file" id="fileInput" style="display: none;" accept="image/jpeg, image/jpg, image/png">
                 <button class="btn-control" id="browseButton" name="browseButton" style="background-color:transparent; height: 40px; width:180px"><svg width="25px" height="25px" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><defs><style>
              .cls-1 {
                fill: #699f4c;
                fill-rule: evenodd;
              }
            </style></defs><path class="cls-1" d="M1080,270a30,30,0,1,1,30-30A30,30,0,0,1,1080,270Zm14-34h-10V226a4,4,0,0,0-8,0v10h-10a4,4,0,0,0,0,8h10v10a4,4,0,0,0,8,0V244h10A4,4,0,0,0,1094,236Z" id="add" transform="translate(-1050 -210)"/></svg>&nbsp;Browse Picture</button>
                 <button onclick="clearFileInput()" id="removeImage" class="btn-control"  style="background-color:transparent; height: 40px;width:180px; margin-top:10px"><svg height="25px" width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.001 512.001" xml:space="preserve" fill="#f20707" stroke="#f20707"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#f20707;" d="M256.001,512c141.384,0,255.999-114.615,255.999-256.001C512.001,114.615,397.386,0,256.001,0 S0.001,114.615,0.001,256.001S114.616,512,256.001,512z"></path> <path style="opacity:0.1;enable-background:new ;" d="M68.873,256.001c0-129.706,96.466-236.866,221.564-253.688 C279.172,0.798,267.681,0,256.001,0C114.616,0,0.001,114.615,0.001,256.001S114.616,512.001,256,512.001 c11.68,0,23.171-0.798,34.436-2.313C165.339,492.865,68.873,385.705,68.873,256.001z"></path> <path style="fill:#FFFFFF;" d="M313.391,256.001l67.398-67.398c4.899-4.899,4.899-12.842,0-17.74l-39.65-39.65 c-4.899-4.899-12.842-4.899-17.74,0l-67.398,67.398l-67.398-67.398c-4.899-4.899-12.842-4.899-17.74,0l-39.65,39.65 c-4.899,4.899-4.899,12.842,0,17.74l67.398,67.398l-67.398,67.398c-4.899,4.899-4.899,12.842,0,17.741l39.65,39.65 c4.899,4.899,12.842,4.899,17.74,0l67.398-67.398L323.4,380.79c4.899,4.899,12.842,4.899,17.74,0l39.65-39.65 c4.899-4.899,4.899-12.842,0-17.741L313.391,256.001z"></path> </g></svg>&nbsp;Remove Picture</button>
                 <input class="custom-input" readonly hidden name="id" id="id" style="width: 180px"/>
                </div>        
            </div>
            <div class="tableCard">
                <div style="margin-left: 20px;margin-right: 20px">
                <table id="addUsers" class="text-color table-border"> 
                <tbody>
                    <tr>
                        <td id="firstNAME" class="td-height text-custom td-style td-bg">First Name<sup>*</sup></td>
                        <td  class="td-height text-custom"><input class="custom-input firstN" id="firstN"/></td>
                    </tr>
                    <tr>
                        <td id="lastNAME" class="td-height text-custom td-style td-bg">Last Name<sup>*</sup></td>
                        <td class="td-height text-custom"><input class="custom-input lastN" id="lastN"/></td>
                    </tr>
                    <tr>
                        <td id="roleNAME" class="td-height text-custom td-style td-bg">Role<sup>*</sup></td>
                        <td class="td-height text-custom-data"> <div class="dropdown custom-input">
                            <input class="custom-input" readonly hidden name="role" id="role" style="width: 180px"/>
                            <input class="custom-input" readonly name="roleName" id="roleName" style="width: 180px"/>
                            <button name="roleBtn" id="roleBtn" class="custom-btn">
                            <svg width="13px" height="13px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                <path d="M19 5L12.7071 11.2929C12.3166 11.6834 11.6834 11.6834 11.2929 11.2929L5 5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M19 13L12.7071 19.2929C12.3166 19.6834 11.6834 19.6834 11.2929 19.2929L5 13" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                            </button>
                            <div class="dropdown-content" id="dropdownContent">
                                <?php
                                 $userFacade = new UserFacade();
                                 $roleTypes = $userFacade->getRoleType();
                                while ($row = $roleTypes->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<a href="#" style="color:#000000; text-decoration: none;" data-value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['role_name']) . '</a>';
                                }
                                ?>
                            </div>
                        </div></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg">ID</td>
                        <td class="td-height text-custom"><input readonly class="custom-input user_ID" id="user_ID"/></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg">Employee No.</td>
                        <td class="td-height text-custom"><input class="custom-input" id="employeeNum"/></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg">Date Hired</td>
                        <td class="td-height text-custom"><input readonly class="custom-input dateHired custom" id="dateHired"/></td>
                    </tr>
                    <tr>
                        <td class="td-height text-custom td-style td-bg">Status</td>
                        <td class="td-height text-custom-data"> <div class="dropdown custom-input">
                            <input class="custom-input" readonly hidden name="status" id="status" style="width: 180px"/>
                            <input class="custom-input" readonly name="statusName" id="StatusName" style="width: 180px"/>
                            <button name="statusBtn" id="statusBtn" class="custom-btn">
                            <svg width="13px" height="13px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                <path d="M19 5L12.7071 11.2929C12.3166 11.6834 11.6834 11.6834 11.2929 11.2929L5 5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M19 13L12.7071 19.2929C12.3166 19.6834 11.6834 19.6834 11.2929 19.2929L5 13" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                            </button>
                            <div class="dropdown-content" id="dropdownContents">
                            <?php
                                 $userFacade = new UserFacade();
                                 $status = $userFacade->getUsersStatus();
                                while ($row = $status->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<a href="#" style="color:#000000; text-decoration: none;" data-value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['status']) . '</a>';
                                }
                                ?>
                            </div>
                        </div></td>
                    </tr>
                    <tr>
    <td id="passWORD" class="td-height text-custom td-style td-bg">Password&nbsp;<sup>*</sup></td>
    <td class="td-height text-custom">
        <div class="password-container">
            <input type="password" name="password" id="password" class="custom-input password" />
            <span class="toggle-password pswrd" onclick="togglePasswordVisibility('password', this)">&#128065;</span>
        </div>
    </td>
</tr>
<tr>
    <td id="confirmPassword" class="td-height text-custom td-style td-bg">Confirm Password&nbsp;<sup>*</sup></td>
    <td class="td-height text-custom">
        <div class="password-container">
            <input id="confirmPass" name="confirmPass" type="password" class="custom-input confirmPass"/>
            <span class="toggle-password cpswrd" onclick="togglePasswordVisibility('confirmPass', this)">&#128065;</span>
        </div>
    </td> 
</tr>

                                </tbody>
            </table>

                </div>
          
            </div>
            <div class="editAccess" style="display: flex">
                <div style="width: 50%; margin-left: 20px">
                    <h5 class="text-custom">Special Access</h5>
                </div>
                <div style="width:50%; display:flex; justify-content:right">
                    <button style="margin-right:20px; width:100px;" class="btn-success-custom">Edit</button>
                </div>
            </div>
            <div class="accessLevel">
                <div style="width: 50%">
                <div style="display: flex;">
                        <input id="refund_permission"  readonly name="refund_permission" type="checkbox" class="refund_permission form-check-input" value="1" style="margin-right: 4px;">
                        <label for="refund_permission" class="text-color form-check-label">Refund</label>
                          </div>
                          <div style="display: flex;">
                              <input id="retAndExPermission" name="retAndExPermission" type="checkbox" class="retAndExPermission form-check-input" value="1" style="margin-right: 4px;">
                              <label for="retAndExPermission" class="retAndExLbl text-color form-check-label">Return & Exchange</label>
                          </div>
                          <div style="display: flex;">
                              <input id="xReadingPermission" name="xReadingPermission" type="checkbox" class="xReadingPermission form-check-input" value="1" style="margin-right: 4px;">
                              <label for="xReadingPermission" class="xReadingLbl text-color form-check-label">X-Reading</label>
                          </div>
                          <div style="display: flex;">
                              <input id="zReadingPermission" name="zReadingPermission" type="checkbox" class="zReadingPermission form-check-input" value="1" style="margin-right: 4px;">
                              <label for="zReadingPermission" class="zReadingLbl text-color form-check-label">Z-Reading</label>
                          </div>
                          <div style="display: flex;">
                              <input id="cashCountPermission" name="cashCountPermission" type="checkbox" class="cashCountPermission form-check-input" value="1" style="margin-right: 4px;">
                              <label for="cashCountPermission" class="cashCountLbl text-color form-check-label">Cash Count</label>
                          </div>
                          <div style="display: flex;">
                              <input id="salesHistoryPermission" name="salesHistoryPermission" type="checkbox" class="salesHistoryPermission form-check-input" value="1" style="margin-right: 4px;">
                              <label for="salesHistoryPermission" class="salesHistoryLbl text-color form-check-label">View Sales History</label>
                          </div>
                          <div style="display: flex;">
                              <input id="inventoryPermission" name="inventoryPermission" type="checkbox" class="inventoryPermission form-check-input" value="1" style="margin-right: 4px;">
                              <label for="inventoryPermission" class="inventoryLbl text-color form-check-label">Inventory</label>
                          </div>
                          <div style="display: flex;">
                              <input id="reportingPermission" name="reportingPermission" type="checkbox" class="reportingPermission form-check-input" value="1" style="margin-right: 4px;">
                              <label for="reportingPermission" class="reportingLbl text-color form-check-label">Reporting</label>
                          </div>
                </div>
                <div style="width: 50%">
                    <div style="display: flex;">
                        <input id="startingCashPermission" name="startingCashPermission" type="checkbox" class="startingCashPermission form-check-input" value="1" style="margin-right: 4px;">
                        <label for="startingCashPermission" class="startingCashLbl text-color form-check-label">Starting Cash Entries</label>
                    </div>
                    <div style="display: flex;">
                        <input id="productsPermission" name="productsPermission" type="checkbox" class="productsPermission form-check-input" value="1" style="margin-right: 4px;">
                        <label for="productsPermission" class="productsLbl text-color form-check-label">Products</label>
                    </div>
                    <div style="display: flex;">
                        <input id="documentsPermission" name="documentsPermission" type="checkbox" class="documentsPermission form-check-input" value="1" style="margin-right: 4px;">
                        <label for="documentsPermission" class="documentsLbl text-color form-check-label">Documents</label>
                    </div>
                    <div style="display: flex;">
                        <input id="purchaseOrderPermission" name="purchaseOrderPermission" type="checkbox" class="purchaseOrderPermission form-check-input" value="1" style="margin-right: 4px;">
                        <label for="purchaseOrderPermission" class="purchaseOrderLbl text-color form-check-label">Purchase Order</label>
                    </div>
                    <div style="display: flex;">
                        <input id="voidItemPermission" name="voidItemPermission" type="checkbox" class="voidItemPermission form-check-input" value="1" style="margin-right: 4px;">
                        <label for="voidItemPermission" class="voidItemLbl text-color form-check-label">Void Item</label>
                    </div>
                    <div style="display: flex;">
                        <input id="voidCartPermission" name="voidCartPermission" type="checkbox" class="voidCartPermission form-check-input" value="1" style="margin-right: 4px;">
                        <label for="voidCartPermission" class="voidCartLbl text-color form-check-label">Void Cart</label>
                    </div>
                    <div style="display: flex;">
                        <input id="cancelOfficialReceiptPermission" name="cancelOfficialReceiptPermission" type="checkbox" class="cancelOfficialReceiptPermission form-check-input" value="1" style="margin-right: 4px;">
                        <label for="cancelOfficialReceiptPermission" class="cancelOfficialReceiptLbl text-color form-check-label">Cancel Official Receipt</label>
                    </div>
                    <div style="display: flex;">
                        <input id="usersPermission" name="usersPermission" type="checkbox" class="usersPermission form-check-input" value="1" style="margin-right: 4px;">
                        <label for="usersPermission" class="usersLbl text-color form-check-label">Users</label>
                    </div>
             </div>
            </div>
            <div class="button-container" style="display:flex;justify-content: right">
                <button onclick="addUsers()"  class="btn-success-custom saveBtn" style="margin-right: 10px; width: 100px; height: 40px">Save</button>
                <button hidden onclick="updateDataUser()" class="btn-success-custom updateBtn" style="margin-right: 10px; width: 100px; height: 40px">Update</button>
                <button onclick="closeAddUserModal()" class="cancelAddUser btn-error-custom" style="margin-right: 20px;width: 100px; height: 40px">Cancel</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

var checkboxes = document.querySelectorAll('.accessLevel input[type="checkbox"]');
checkboxes.forEach(function(checkbox) {
    checkbox.disabled = true;
});
// Role dropdown
document.getElementById("roleBtn").addEventListener("click", function() {
  var dropdownContent = document.getElementById("dropdownContent");
  if (dropdownContent.style.display === "block") {
    dropdownContent.style.display = "none";
  } else {
    dropdownContent.style.display = "block";
  }
});

document.addEventListener("click", function(event) {
  var dropdownContent = document.getElementById("dropdownContent");
  var roleBtn = document.getElementById("roleBtn");
  if (event.target !== dropdownContent && event.target !== roleBtn && dropdownContent.style.display === "block") {
    dropdownContent.style.display = "none";
  }
});

document.querySelectorAll("#dropdownContent a").forEach(item => {
  item.addEventListener("click", function(event) {
    event.preventDefault(); 
    var value = this.getAttribute("data-value");
    var roleName = this.textContent;
    document.getElementById("role").value = value;
    document.getElementById("roleName").value = roleName;
    document.getElementById("dropdownContent").style.display = "none";
  });
});

document.getElementById("roleBtn").addEventListener("click", function(event) {
  event.stopPropagation(); 
});

// Status dropdown
document.getElementById("statusBtn").addEventListener("click", function() {
  var dropdownContents = document.getElementById("dropdownContents");
  if (dropdownContents.style.display === "block") {
    dropdownContents.style.display = "none";
  } else {
    dropdownContents.style.display = "block";
  }
});

document.addEventListener("click", function(event) {
  var dropdownContent = document.getElementById("dropdownContents");
  var statusBtn = document.getElementById("statusBtn");
  if (event.target !== dropdownContent && event.target !== statusBtn && dropdownContent.style.display === "block") {
    dropdownContent.style.display = "none";
  }
});


document.querySelectorAll("#dropdownContents a").forEach(item => {
    item.addEventListener("click", function(event) {
        event.preventDefault(); 
        var value = this.getAttribute("data-value");
        var statusName = this.textContent;
        document.getElementById("status").value = value;
        document.getElementById("StatusName").value = statusName;
        document.getElementById("dropdownContents").style.display = "none";
    });
});


document.getElementById("statusBtn").addEventListener("click", function(event) {
  event.stopPropagation(); 
});

document.getElementById("firstN").addEventListener("input", function(event) {
    var f_name = $(this).val();
    if (f_name.trim() === '') {
        f_name = 'Unknown';
    } else {
        var words = f_name.toLowerCase().split(' ');
        for (var i = 0; i < words.length; i++) {
            words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
        }
        f_name = words.join(' ');
    }
    $('.firstName').html(f_name + '&nbsp;');
});


document.getElementById("lastN").addEventListener("input", function(event) {
    var l_name = $(this).val()
    if (l_name.trim() === '') {
        l_name = 'Unknown';
    } else {

    var words = l_name.toLowerCase().split(' ');
    for (var i = 0; i < words.length; i++) {
        words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
    }
    l_name = words.join(' ');
}
    $('.lastName').text(l_name);
});

document.addEventListener("DOMContentLoaded", function() {
    var inputs = document.querySelectorAll('.custom-input.dateHired');
    inputs.forEach(function(input) {
        flatpickr(input, {
            dateFormat: "m-d-Y",
            altInput: true,
            altFormat: "M j, Y",
         
        });
    });
});


var passwordInput = document.getElementById('password');
var confirmPassInput = document.getElementById('confirmPass');

var validation;
function updateConfirmPassColor() {
    if (confirmPassInput.value !== passwordInput.value) {
        confirmPassInput.style.color = 'red';
        validation = false
    } else {
        confirmPassInput.style.color = ''; 
        validation = true
    }
}
confirmPassInput.addEventListener('input', updateConfirmPassColor);
passwordInput.addEventListener('input', updateConfirmPassColor);



var passwordField = document.getElementById('password');
var confirmPassword = document.getElementById('confirmPass');
var fname = document.getElementById('firstN');
var lname = document.getElementById('lastN');



passwordField.addEventListener('input', function(event) {
    var inputValue = event.target.value;
    document.getElementById("passWORD").style.color = (inputValue !== "" && inputValue !== null) ? "#FF6900" : "";
})

confirmPassword.addEventListener('input', function(event){
    var inputValue = event.target.value;
    document.getElementById("confirmPassword").style.color = (inputValue !== "" && inputValue !== null) ? "#FF6900" : "";
})

fname.addEventListener('input', function(event){
    var inputValue = event.target.value;
    document.getElementById("firstNAME").style.color = (inputValue !== "" && inputValue !== null) ? "#FF6900" : "";
})
lname.addEventListener('input', function(event){
    var inputValue = event.target.value;
    document.getElementById("lastNAME").style.color = (inputValue !== "" && inputValue !== null) ? "#FF6900" : "";
})


var passwordVisible = false;
var timeoutId; 

function togglePasswordVisibility(inputId, icon) {
    var input = document.getElementById(inputId);
    if (!passwordVisible) {
        input.type = "text";
        icon.innerHTML = "&#128064;"; 
        passwordVisible = true;
      
        timeoutId = setTimeout(function() {
            input.type = "password";
            icon.innerHTML = "&#128065;"; 
            passwordVisible = false;
        }, 1000); 
    } else {
        input.type = "password";
        icon.innerHTML = "&#128065;"; 
        passwordVisible = false;
        clearTimeout(timeoutId);
    }
}

document.getElementById("browseButton").addEventListener("click", function() {
    document.getElementById("fileInput").click();
});



document.getElementById('fileInput').addEventListener('change', function(event) {
    var file = event.target.files[0];
    var reader = new FileReader();

    reader.onload = function(event) {
        var imageUrl = event.target.result;
        displayImage(imageUrl);
    };

    if (file) {
        reader.readAsDataURL(file);
    } 
});

function displayImage(imageUrl) {
    document.getElementById('imageDiv').innerHTML = '<img src="' + imageUrl + '" style="max-width: 100%; max-height: 100%;">';
}

var defaultImageUrl = './assets/profile/blank.png';
var file;
displayImage(defaultImageUrl);


document.getElementById("fileInput").addEventListener("change", function(event) {
    var file = event.target.files[0];
  
});

var selectedROLES = document.getElementById("role").value;

function generateUsername(firstName) {
    var currentDate = new Date();
    var month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); 
    var day = currentDate.getDate().toString().padStart(2, '0');
    var year = currentDate.getFullYear().toString();
    var username = firstName + month + day + year;
    return username;
}

function addUsers() {
    $(".statusDropDown a[data-value='0']").click();
    //users
    var role_id = document.getElementById("role").value;
    var lastname = document.getElementById("lastN").value;
    var firstname = document.getElementById("firstN").value;
    var pass = document.getElementById("password").value;
    var cpass = document.getElementById("confirmPass").value;
    var file = document.getElementById("fileInput").files[0]; 
    var identification = document.getElementById('user_ID').value;
    var employeeNum = document.getElementById('employeeNum').value;
    var dateHired = document.getElementById('dateHired').value;
    var status= document.getElementById("status").value;
    var username = generateUsername(firstname);
    //abilities

    //refund
    var checkbox = document.getElementById("refund_permission");
    var refundPermissionValue = checkbox.checked ? checkbox.value : "0";
    //ret&ex
    var checkbox = document.getElementById("retAndExPermission");
    var retexPermissionValue = checkbox.checked ? checkbox.value : "0";
    //x-reading 
    var checkbox = document.getElementById("xReadingPermission");
    var xReadingPermissionValue = checkbox.checked ? checkbox.value : "0";
    //zreading
    var checkbox = document.getElementById("zReadingPermission");
    var zReadingPermissionValue = checkbox.checked ? checkbox.value : "0";
    //cash count
    var checkbox = document.getElementById("cashCountPermission");
    var cashCountPermissionValue = checkbox.checked ? checkbox.value : "0";
    //sales history
    var checkbox = document.getElementById("salesHistoryPermission");
    var salesHistoryPermissionValue = checkbox.checked ? checkbox.value : "0";
    //inventory
    var checkbox = document.getElementById("inventoryPermission");
    var inventoryPermissionValue = checkbox.checked ? checkbox.value : "0";
    //reporting
    var checkbox = document.getElementById("reportingPermission");
    var reportingPermissionValue = checkbox.checked ? checkbox.value : "0";
    //starting cash
    var checkbox = document.getElementById("startingCashPermission");
    var startingPermissionValue = checkbox.checked ? checkbox.value : "0";
    //products
    var checkbox = document.getElementById("productsPermission");
    var productsPermissionValue = checkbox.checked ? checkbox.value : "0";
    //documents
    var checkbox = document.getElementById("documentsPermission");
    var documentsPermissionValue = checkbox.checked ? checkbox.value : "0";
    //purchase
    var checkbox = document.getElementById("purchaseOrderPermission");
    var purchasePermissionValue = checkbox.checked ? checkbox.value : "0";
    //void item
    var checkbox = document.getElementById("voidItemPermission");
    var voidItemPermissionValue = checkbox.checked ? checkbox.value : "0";
    //void card
    var checkbox = document.getElementById("voidCartPermission");
    var voidCartPermissionValue = checkbox.checked ? checkbox.value : "0";
    //cancel O.R
    var checkbox = document.getElementById("cancelOfficialReceiptPermission");
    var cancelReceiptPermissionValue = checkbox.checked ? checkbox.value : "0";
    //users
    var checkbox = document.getElementById("usersPermission");
    var userPermissionValue = checkbox.checked ? checkbox.value : "0";

    document.getElementById('firstNAME').style.color = (firstname == "" || firstname == null) ? "red" : "#FF6900";
    document.getElementById('lastNAME').style.color = (lastname == "" || lastname == null) ? "red" : "#FF6900";
    document.getElementById('roleNAME').style.color = (role_id == "" || role_id == null) ? "red" : "#FF6900";
    document.getElementById('passWORD').style.color = (pass == "" || pass == null) ? "red" : "#FF6900";
    document.getElementById('confirmPassword').style.color = (cpass == "" || cpass == null) ? "red" : "#FF6900";

    var formData = new FormData();
    formData.append("uploadedImage", file); 
    formData.append("role_id", role_id); 
    formData.append("last_name", lastname); 
    formData.append("first_name", firstname); 
    formData.append("password", pass); 
    formData.append("username",username);
    formData.append("userID", identification);
    formData.append("employeeNum", employeeNum);
    formData.append("dateHired", dateHired);
    formData.append("status", status);
    formData.append("refund", refundPermissionValue);
    formData.append("return", retexPermissionValue);
    formData.append("xreading",xReadingPermissionValue);
    formData.append("zreading",zReadingPermissionValue);
    formData.append("cashcount",cashCountPermissionValue);
    formData.append("saleshistory",salesHistoryPermissionValue);
    formData.append("inventory",inventoryPermissionValue);
    formData.append("reporting",reportingPermissionValue);
    formData.append("starting",startingPermissionValue);
    formData.append("products",productsPermissionValue);
    formData.append("documents", documentsPermissionValue);
    formData.append("purchase", purchasePermissionValue);
    formData.append("voiditem", voidItemPermissionValue);
    formData.append("voidcart", voidCartPermissionValue);
    formData.append("cancelreceipt", cancelReceiptPermissionValue);
    formData.append("users", userPermissionValue);

    
    if(role_id && lastname && firstname && pass && cpass){
        if(validation == true){
            axios.post('api.php?action=addUsersData', formData)
             .then(function(response) { 
                refreshTable()
                Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'User added successfully!',
                timer: 1000, 
                timerProgressBar: true, 
                showConfirmButton: false 
            });
              closeAddUserModal()
            })
            .catch(function(error) {
            console.log(error);
           });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Password not match!',
                timer: 1000, 
                timerProgressBar: true, 
                showConfirmButton: false 
            });
        }
       
    }else{
        Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Check the required field!',
                timer: 1000, 
                timerProgressBar: true, 
                showConfirmButton: false 
            });
    }

   
}

function clearFileInput() {
    var fileInput = document.getElementById('fileInput');
    fileInput.value = '';
    if(fileInput.value == ''){
        displayImage(defaultImageUrl);
    }
}
function closeAddUserModal() {
  $('#add_users_modal').css('animation', 'slideOutRight 0.5s forwards');
  $('.user-modal').css('animation', 'slideOutRight 0.5s forwards');
  $('.highlighted').removeClass('highlighted');
 
  $('#add_users_modal').one('animationend', function() {
    $(this).hide();
    $(this).css('animation', '');
    $('.user-modal').css('animation', '');
    clearFileInput();
    uncheckAllCheckboxes();
    clearAllInputs();
  });
}




function uncheckAllCheckboxes() {
    var checkboxes = document.querySelectorAll('.form-check-input');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = false;
    });
}
function clearAllInputs(){
    document.getElementById("lastN").value = ""; 
    document.getElementById("firstN").value = "";
    document.getElementById("password").value ="";
    document.getElementById("confirmPass").value="";
    document.getElementById('employeeNum').value= "";
    document.getElementById("role").value=""; 
    document.getElementById("roleName").value=""; 
    document.getElementById("user_ID").value="";
    document.getElementById("status").value = "";
    document.getElementById("StatusName").value = "";
    var dateHiredInput = document.getElementById('dateHired');
    dateHiredInput._flatpickr.clear();
    dateHiredInput.value = "";
    var uptBtn = document.querySelector('.updateBtn');
    uptBtn.setAttribute('hidden',true);
    var saveBtn = document.querySelector('.saveBtn');
    saveBtn.removeAttribute('hidden');

}

function updateUserForm(id, dataFirstName, dataLastName, employeeNum, pw, imageName, datastats, datastatsID, roleN, roleID, identification, datehired,perm) {
    $('#add_users_modal').show();
    id? document.getElementById('id').value = id : null;
    dataFirstName ? (document.getElementById("firstN").value = dataFirstName, $('.firstName').html(dataFirstName + '&nbsp;')) : null;
    dataLastName ? (document.getElementById("lastN").value = dataLastName, $('.lastName').text(dataLastName)) : null;
    employeeNum ? document.getElementById('employeeNum').value = employeeNum : null;
    pw ? (document.getElementById("password").value = pw, document.getElementById("confirmPass").value = pw) : null;
    imageName ? displayImage('./assets/profile/' + imageName) : null;
    datastats ? document.getElementById("StatusName").value = datastats : null;
    datastatsID ? document.getElementById("status").value = datastatsID : null;
    roleN ? document.getElementById("roleName").value = roleN : null;
    roleID ? document.getElementById("role").value = roleID : null;
    identification ? document.getElementById("user_ID").value = identification : null;
    datehired ? (() => {
        var dateObj = new Date(datehired);
        !isNaN(dateObj.getTime()) ? (() => {
            var month = (dateObj.getMonth() + 1).toString().padStart(2, '0');
            var day = dateObj.getDate().toString().padStart(2, '0');
            var year = dateObj.getFullYear();
            var formattedDate = month + '-' + day + '-' + year;
            var input = document.getElementById('dateHired');
            input._flatpickr.setDate(formattedDate, true);
        })() : console.error("Invalid date format: ", datehired);
    })() : null;
  if(perm){
    var jsonPermissionData = perm;
    var data = JSON.parse(jsonPermissionData);
    var refundAccess = data[0]?.Refund;
    var returnAccess = data[0]?.ReturnExchange;
    var xreading = data[0]?.XReading;
    var zreading = data[0]?.ZReading;
    var cashcount = data[0]?.CashCount;
    var saleshistory = data[0]?.SalesHistory;
    var inventory = data[0]?.Inventory;
    var reports = data[0]?.Reports;
    var startingCash = data[0]?.StartingCash;
    var products = data[0]?.Products;
    var documentFile = data[0]?.Documents;
    var purchaseOrder = data[0]?.PurchaseOrder;
    var voidItem = data[0]?.VoidItem;
    var voidCart = data[0]?.VoidCart;
    var cancelReceipt = data[0]?.CancelReceipt;
    var us_er = data[0]?.Users;
   

    var refundCheckbox = document.getElementById("refund_permission");
    refundCheckbox.checked = refundAccess === "Access Granted" ? true : false;
    var returnCheckbox = document.getElementById("retAndExPermission");
    returnCheckbox.checked = returnAccess === "Access Granted" ? true : false;
    var xreadingCheckbox = document.getElementById("xReadingPermission");
    xreadingCheckbox.checked = xreading === "Access Granted" ? true : false;
    var zreadingCheckbox = document.getElementById("zReadingPermission");
    zreadingCheckbox.checked = zreading === "Access Granted" ? true : false;
    var cashCountCheckbox = document.getElementById("cashCountPermission");
    cashCountCheckbox.checked = cashcount === "Access Granted" ? true : false;
    var salesHistoryCheckbox = document.getElementById("salesHistoryPermission");
    salesHistoryCheckbox.checked = saleshistory === "Access Granted" ? true : false;
    var inventoryCheckbox = document.getElementById("inventoryPermission");
    inventoryCheckbox.checked = inventory === "Access Granted" ? true : false;
    var reportsCheckbox = document.getElementById("reportingPermission");
    reportsCheckbox.checked = reports === "Access Granted" ? true : false;
    var startingCheckbox = document.getElementById("startingCashPermission");
    startingCheckbox.checked = startingCash === "Access Granted" ? true : false;
    var productsCheckbox = document.getElementById("productsPermission");
    productsCheckbox.checked = products === "Access Granted" ? true : false;
    var documentCheckbox = document.getElementById("documentsPermission");
    documentCheckbox.checked = documentFile === "Access Granted" ? true : false;
    var purchaseCheckbox = document.getElementById("purchaseOrderPermission");
    purchaseCheckbox.checked = purchaseOrder === "Access Granted" ? true : false;
    var voidItemCheckbox = document.getElementById("voidItemPermission");
    voidItemCheckbox.checked = voidItem === "Access Granted" ? true : false;
    var voidCartCheckbox = document.getElementById("voidCartPermission");
    voidCartCheckbox.checked = voidCart === "Access Granted" ? true : false;
    var cancelOfficialCheckbox = document.getElementById("cancelOfficialReceiptPermission");
    cancelOfficialCheckbox.checked = cancelReceipt === "Access Granted" ? true : false;
    var usersCheckbox = document.getElementById("usersPermission");
    usersCheckbox.checked = us_er === "Access Granted" ? true : false;
    
  }
    var uptBtn = document.querySelector('.updateBtn');
    var saveBtn = document.querySelector('.saveBtn');
    id ? (uptBtn.removeAttribute('hidden'), saveBtn.setAttribute('hidden', true)) : (uptBtn.setAttribute('hidden', true), saveBtn.removeAttribute('hidden'));
 
}

function updateDataUser(){
    $(".statusDropDown a[data-value='0']").click();
    var u_id = document.getElementById('id').value;
    var role_id = document.getElementById("role").value;
    var lastname = document.getElementById("lastN").value;
    var firstname = document.getElementById("firstN").value;
    var pass = document.getElementById("password").value;
    var cpass = document.getElementById("confirmPass").value;
    var file = document.getElementById("fileInput").files[0]; 
    var identification = document.getElementById('user_ID').value;
    var employeeNum = document.getElementById('employeeNum').value;
    var dateHired = document.getElementById('dateHired').value;
    var status= document.getElementById("status").value;
    var username = generateUsername(firstname);
    //abilities
 
    //refund
    var checkbox = document.getElementById("refund_permission");
    var refundPermissionValue = checkbox.checked ? checkbox.value : "0";
    //ret&ex
    var checkbox = document.getElementById("retAndExPermission");
    var retexPermissionValue = checkbox.checked ? checkbox.value : "0";
    //x-reading 
    var checkbox = document.getElementById("xReadingPermission");
    var xReadingPermissionValue = checkbox.checked ? checkbox.value : "0";
    //zreading
    var checkbox = document.getElementById("zReadingPermission");
    var zReadingPermissionValue = checkbox.checked ? checkbox.value : "0";
    //cash count
    var checkbox = document.getElementById("cashCountPermission");
    var cashCountPermissionValue = checkbox.checked ? checkbox.value : "0";
    //sales history
    var checkbox = document.getElementById("salesHistoryPermission");
    var salesHistoryPermissionValue = checkbox.checked ? checkbox.value : "0";
    //inventory
    var checkbox = document.getElementById("inventoryPermission");
    var inventoryPermissionValue = checkbox.checked ? checkbox.value : "0";
    //reporting
    var checkbox = document.getElementById("reportingPermission");
    var reportingPermissionValue = checkbox.checked ? checkbox.value : "0";
    //starting cash
    var checkbox = document.getElementById("startingCashPermission");
    var startingPermissionValue = checkbox.checked ? checkbox.value : "0";
    //products
    var checkbox = document.getElementById("productsPermission");
    var productsPermissionValue = checkbox.checked ? checkbox.value : "0";
    //documents
    var checkbox = document.getElementById("documentsPermission");
    var documentsPermissionValue = checkbox.checked ? checkbox.value : "0";
    //purchase
    var checkbox = document.getElementById("purchaseOrderPermission");
    var purchasePermissionValue = checkbox.checked ? checkbox.value : "0";
    //void item
    var checkbox = document.getElementById("voidItemPermission");
    var voidItemPermissionValue = checkbox.checked ? checkbox.value : "0";
    //void card
    var checkbox = document.getElementById("voidCartPermission");
    var voidCartPermissionValue = checkbox.checked ? checkbox.value : "0";
    //cancel O.R
    var checkbox = document.getElementById("cancelOfficialReceiptPermission");
    var cancelReceiptPermissionValue = checkbox.checked ? checkbox.value : "0";
    //users
    var checkbox = document.getElementById("usersPermission");
    var userPermissionValue = checkbox.checked ? checkbox.value : "0";
    
    document.getElementById('firstNAME').style.color = (firstname == "" || firstname == null) ? "red" : "#FF6900";
    document.getElementById('lastNAME').style.color = (lastname == "" || lastname == null) ? "red" : "#FF6900";
    document.getElementById('roleNAME').style.color = (role_id == "" || role_id == null) ? "red" : "#FF6900";
    document.getElementById('passWORD').style.color = (pass == "" || pass == null) ? "red" : "#FF6900";
    document.getElementById('confirmPassword').style.color = (cpass == "" || cpass == null) ? "red" : "#FF6900";

    var formData = new FormData();
    formData.append("uploadedImage", file); 
    formData.append("role_id", role_id); 
    formData.append("last_name", lastname); 
    formData.append("first_name", firstname); 
    formData.append("password", pass); 
    formData.append("username",username);
    formData.append("userID", identification);
    formData.append("employeeNum", employeeNum);
    formData.append("dateHired", dateHired);
    formData.append("status", status);
    formData.append("refund", refundPermissionValue);
    formData.append("return", retexPermissionValue);
    formData.append("xreading",xReadingPermissionValue);
    formData.append("zreading",zReadingPermissionValue);
    formData.append("cashcount",cashCountPermissionValue);
    formData.append("saleshistory",salesHistoryPermissionValue);
    formData.append("inventory",inventoryPermissionValue);
    formData.append("reporting",reportingPermissionValue);
    formData.append("starting",startingPermissionValue);
    formData.append("products",productsPermissionValue);
    formData.append("documents", documentsPermissionValue);
    formData.append("purchase", purchasePermissionValue);
    formData.append("voiditem", voidItemPermissionValue);
    formData.append("voidcart", voidCartPermissionValue);
    formData.append("cancelreceipt", cancelReceiptPermissionValue);
    formData.append("users", userPermissionValue);
    formData.append("id",u_id);

   
    if(role_id && lastname && firstname && pass && cpass){
        if(pass == cpass){
            axios.post('api.php?action=updateUserData', formData)
             .then(function(response) { 
                console.log(response)
                refreshTable()
                Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'User updated successfully!',
                timer: 1000, 
                timerProgressBar: true, 
                showConfirmButton: false 
            });
              closeAddUserModal()
            })
            .catch(function(error) {
              console.log(error);
           });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Password not match!',
                timer: 1000, 
                timerProgressBar: true, 
                showConfirmButton: false 
            });
        }
       
    }else{
        Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Check the required field!',
                timer: 1000, 
                timerProgressBar: true, 
                showConfirmButton: false 
            });
    }

   

}
</script>
