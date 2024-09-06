<style>
#add_employee_modal {
  display: none;
  position: fixed; 
  z-index: 100;
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


.employee-modal {
  background-color: #fefefe;
  margin: 0 auto; 
  border: none;
  width: 100%;
  height: 100%; 
  animation: slideInRight 0.5s; 
  border-radius: 0;
  margin-top: -28px;
  background-color: #1E1C11;  
  border-color:  #1E1C11;
  
}

.no-background-btn {
    background: none; 
    border: none; 
    padding: 0; 
    margin: 0;
    margin-left: 15px;
    cursor: pointer; 
    transition: background 0.3s, transform 0.3s; 
}


.no-background-btn:hover {
    background: rgba(0, 0, 0, 0.1); 
    transform: scale(1.05); 
}


.no-background-btn:focus {
    outline: 2px solid var(--primary-color); 
    outline-offset: 2px; 
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

#addUsers tbody tr td{
    border: 1px solid #d3d3d3 !important;
}

</style>

<div class="modal" id="add_employee_modal" tabindex="0">
  <div class="modal-dialog h-100">
    <div class="modal-content employee-modal h-100">
      <div class="modal-title">
        <div class="warning-container h-100">
            <div style="display: flex; margin-top: 30px">
            <h2 style="margin-left: 20px;" class="text-custom firstName">Unknown<span>&nbsp;</span></h2><h2 class="text-custom lastName">Unknown</h2>
            </div>
            <div class="imageCard">
                 <div  style="width:30%" class="imageDiv" id="imageDiv">
                   
                </div> 
                 <div style="width:50%">
                 <input hidden type="file" id="fileInput" style="display: none;" accept="image/jpeg, image/jpg, image/png">
                 <button class="btn-control" id="browseButton" name="browseButton" style="background-color:transparent; height: 40px; width:180px"><svg width="25px" height="25px" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><defs><style>
              <!-- .cls-1 {
                fill: #699f4c;
                fill-rule: evenodd;
              } -->
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
                        <td  class="td-height text-custom"><input class="custom-input firstN" id="firstN" placeholder = "First Name"/></td>
                    </tr>
                    <tr>
                        <td id="lastNAME" class="td-height text-custom td-style td-bg">Last Name<sup>*</sup></td>
                        <td class="td-height text-custom"><input class="custom-input lastN" id="lastN" placeholder = "Last Name"/></td>
                    </tr>
                    <tr>
                        <td id="empPOSITION" class="td-height text-custom td-style td-bg">Position<sup>*</sup></td>
                        <td class="td-height text-custom-data"> <div class="dropdown custom-input">
                            <input class="custom-input" name="empPosition" id="empPosition" style="width: 180px" placeholder = "Employee Position" autocomplete = "off" />
                        </td>
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
                        <td class="td-height text-custom-data">
                            <div class="dropdown custom-input">
                                <input class="custom-input" readonly hidden name="status" id="status" style="width: 180px"/>
                                <input class="custom-input" readonly name="statusName" id="StatusName" style="width: 180px"/>
                                <button name="statusBtn" id="statusBtn" class="no-background-btn">
                                    <svg fill="var(--primary-color)" width="15px" height="15px" viewBox="-6.5 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>dropdown</title>
                                            <path d="M18.813 11.406l-7.906 9.906c-0.75 0.906-1.906 0.906-2.625 0l-7.906-9.906c-0.75-0.938-0.375-1.656 0.781-1.656h16.875c1.188 0 1.531 0.719 0.781 1.656z"></path>
                                        </g>
                                    </svg>
                                </button>
                                <div class="dropdown-content" id="dropdownContents">
                                    <?php
                                        $employeeFacade = new Employee_facade();
                                        $status = $employeeFacade->getEmployeeStatus();
                                        while ($row = $status->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<a href="#" class="dropdown-item" data-value="' . htmlspecialchars($row['id']) . '" data-name="' . htmlspecialchars($row['status']) . '">' . htmlspecialchars($row['status']) . '</a>';
                                        }
                                    ?>
                                </div>
                            </div>
                        </td>
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
          
                    
             </div>
            </div>
            <div class="button-container position-absolute d-flex justify-content-end w-100" style="bottom: 10px;">
                <button onclick="closeAddEmployeeModal()" class="cancelAddUser btn-error-custom" style="margin-right: 20px;width: 100px; height: 40px">Cancel</button>
                <button onclick="addEmployee()"  class="btn-success-custom saveBtn" style="margin-right: 10px; width: 100px; height: 40px">Save</button>
                <!-- <button hidden onclick="updateDataUser()" class="btn-success-custom updateBtn" style="margin-right: 10px; width: 100px; height: 40px">Update</button> -->
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
let userSValidate = false;

document.getElementById("statusBtn").addEventListener("click", function() {
    var dropdownContents = document.getElementById("dropdownContents");
    if (dropdownContents.style.display === "block") {
        dropdownContents.style.display = "none";
    } else {
        dropdownContents.style.display = "block";
    }
});

// Close the dropdown if clicked outside
document.addEventListener("click", function(event) {
    var dropdownContent = document.getElementById("dropdownContents");
    var statusBtn = document.getElementById("statusBtn");
    if (event.target !== dropdownContent && event.target !== statusBtn && dropdownContent.style.display === "block") {
        dropdownContent.style.display = "none";
    }
});

// Stop dropdown from closing when clicked
document.getElementById("statusBtn").addEventListener("click", function(event) {
    event.stopPropagation();
});

// Handle dropdown item selection
var dropdownItems = document.querySelectorAll("#dropdownContents .dropdown-item");

dropdownItems.forEach(function(item) {
    item.addEventListener("click", function(event) {
        event.preventDefault();
        
        // Get the selected value and name
        var selectedStatusId = this.getAttribute("data-value");
        var selectedStatusName = this.getAttribute("data-name");

        // Set the selected value in the hidden and visible inputs
        document.getElementById("status").value = selectedStatusId;
        document.getElementById("StatusName").value = selectedStatusName;

        // Close the dropdown
        document.getElementById("dropdownContents").style.display = "none";
    });
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
    document.getElementById("passWORD").style.color = (inputValue !== "" && inputValue !== null) ? "var(--primary-color)" : "";
})

confirmPassword.addEventListener('input', function(event){
    var inputValue = event.target.value;
    document.getElementById("confirmPassword").style.color = (inputValue !== "" && inputValue !== null) ? "var(--primary-color)" : "";
})

fname.addEventListener('input', function(event){
    var inputValue = event.target.value;
    document.getElementById("firstNAME").style.color = (inputValue !== "" && inputValue !== null) ? "var(--primary-color)" : "";
})
lname.addEventListener('input', function(event){
    var inputValue = event.target.value;
    document.getElementById("lastNAME").style.color = (inputValue !== "" && inputValue !== null) ? "var(--primary-color)" : "";
})
empPosition.addEventListener('input', function(event){
    var inputValue = event.target.value;
    document.getElementById("empPOSITION").style.color = (inputValue !== "" && inputValue !== null) ? "var(--primary-color)" : "";
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



function generateUsername(firstName) {
    var currentDate = new Date();
    var month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); 
    var day = currentDate.getDate().toString().padStart(2, '0');
    var year = currentDate.getFullYear().toString();
    var username = firstName + month + day + year;
    return username;
}
function showResponse(message, type) 
{
    toastr.options = {
        "onShown": function () {
        $('.custom-toast').css({
            "opacity": 1,
            "text-align": "center",
        });
        },
        "closeButton": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "progressBar": true,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "tapToDismiss": false,
        "toastClass": "custom-toast",
        "onclick": function () {  }

    };
    type === 1 ? toastr.success(message) : toastr.error(message);
 }


function addEmployee() 
{
    $(".statusDropDown a[data-value='0']").click();
    //employee
    var lastname = document.getElementById("lastN").value;
    var firstname = document.getElementById("firstN").value;
    var empPosition = document.getElementById("empPosition").value;
    var pass = document.getElementById("password").value;
    var cpass = document.getElementById("confirmPass").value;
    var file = document.getElementById("fileInput").files[0]; 
    var employeeNum = document.getElementById('employeeNum').value;
    var dateHired = document.getElementById('dateHired').value;
    var status= document.getElementById("status").value;
    var username = generateUsername(firstname);

    document.getElementById('firstNAME').style.color = (firstname == "" || firstname == null) ? "red" : "var(--primary-color)";
    document.getElementById('lastNAME').style.color = (lastname == "" || lastname == null) ? "red" : "var(--primary-color)";
    document.getElementById('empPOSITION').style.color = (empPosition == "" || empPosition == null) ? "red" : "var(--primary-color)";
    document.getElementById('passWORD').style.color = (pass == "" || pass == null) ? "red" : "var(--primary-color)";
    document.getElementById('confirmPassword').style.color = (cpass == "" || cpass == null) ? "red" : "var(--primary-color)";

    var formData = new FormData();
    formData.append("uploadedImage", file); 
    formData.append("last_name", lastname); 
    formData.append("first_name", firstname); 
    formData.append("position", empPosition); 
    formData.append("password", pass); 
    formData.append("username",username);
    formData.append("employeeNum", employeeNum);
    formData.append("dateHired", dateHired);
    formData.append("status", status);
  

    
    if(empPosition && lastname && firstname && pass && cpass){
        if(validation == true){
            console.log("hello")
            axios.post('api.php?action=addEmployeeData', formData)
             .then(function(response) { 
                console.log(response.data);
               
                showResponse("User added successfully", 1);
 
                setTimeout(function() {
                    location.reload();
                }, 1500);
                
                if(response.data.success) {
                    insertLogs('Users', 'Added' + ' ' + firstname + ' '+ lastname);
                } 
            })
            .catch(function(error) {
            console.log(error);
           });
        }else{
            showResponse("Password not match", 0);
        }
       
    }else{
        showResponse("Check the required field", 0);
    }

   
}

function closeAddEmployeeModal() {
  $('#add_employee_modal').css('animation', 'slideOutRight 0.5s forwards');
  $('.employee-modal').css('animation', 'slideOutRight 0.5s forwards');
  $('.highlightedUser').removeClass('highlightedUser');
 
  $('#add_employee_modal').one('animationend', function() {
    $(this).hide();
    $(this).css('animation', '');
    $('.employee-modal').css('animation', '');
    clearFileInput();
    clearAllInputs();
  });
}


function clearFileInput() {
    var fileInput = document.getElementById('fileInput');
    fileInput.value = '';
    if(fileInput.value == ''){
        displayImage(defaultImageUrl);
    }
}

function clearAllInputs(){
    document.getElementById("lastN").value = ""; 
    document.getElementById("firstN").value = "";
    document.getElementById("empPosition").value = "";
    document.getElementById("password").value ="";
    document.getElementById("confirmPass").value="";
    document.getElementById('employeeNum').value= "";
    document.getElementById("role").value=""; 
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
    $('#add_employee_modal').show();
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
    var promo = data[0]?.Promotion;
    var coupon = data[0]?.Coupon;
    var charges = data[0]?.Charges;
    var price_list = data[0]?.Pricelist;
    var expenses = data[0]?.Expenses;
    var supplier = data[0]?.Supplier;
    var customer = data[0]?.Customer;
    var pricetag = data[0]?.Pricetag;
    var activitylogs = data[0]?.Activitylogs;
    var management = data[0]?.Management;



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
    //new
    var promotionCheckbox = document.getElementById("promotionPermission");
    promotionCheckbox.checked = promo === "Access Granted" ? true : false;
    //coupon
    var couponCheckbox = document.getElementById("couponPermission");
    couponCheckbox.checked = coupon === "Access Granted" ? true : false;
    //charges
    var chargesCheckbox = document.getElementById("chargesPermission");
    chargesCheckbox.checked = charges === "Access Granted" ? true : false;
     //pricelist
    var pricelistCheckbox = document.getElementById("pricelistPermission");
    pricelistCheckbox.checked = price_list === "Access Granted" ? true : false;
     //expenses
    var expensesCheckbox = document.getElementById("expensesPermission");
    expensesCheckbox.checked = expenses === "Access Granted" ? true : false;
    //supplier
    var supplierCheckbox = document.getElementById("supplierPermission");
     supplierCheckbox.checked = supplier === "Access Granted" ? true : false;
    //customer
    var customerCheckbox = document.getElementById("customerPermission");
    customerCheckbox.checked = customer  === "Access Granted" ? true : false;
    //price tag
    var pricetagCheckbox = document.getElementById("pricetagPermission");
    pricetagCheckbox.checked = pricetag  === "Access Granted" ? true : false;
    //activity logs
    var activitylogsCheckbox = document.getElementById("activitylogsPermission");
    activitylogsCheckbox.checked = activitylogs  === "Access Granted" ? true : false;
    //management
    var managementCheckbox = document.getElementById("managementPermission");
    managementCheckbox.checked = management  === "Access Granted" ? true : false;
   
    
  }
    var uptBtn = document.querySelector('.updateBtn');
    var saveBtn = document.querySelector('.saveBtn');
    id ? (uptBtn.removeAttribute('hidden'), saveBtn.setAttribute('hidden', true)) : (uptBtn.setAttribute('hidden', true), saveBtn.removeAttribute('hidden'));
 
}

function updateDataUser(){
    $(".statusDropDown a[data-value='0']").click();
    var u_id = document.getElementById('id').value;
    var role_id = document.getElementById("role").value;
    var roleName = document.getElementById("roleName").value;
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
    //promotion and action
    var checkbox = document.getElementById("promotionPermission");
    var promotionPermissionValue = checkbox.checked ? checkbox.value : "0";
     //coupon
     var checkbox = document.getElementById("couponPermission");
    var couponPermissionValue = checkbox.checked ? checkbox.value : "0";
     //charges
     var checkbox = document.getElementById("chargesPermission");
    var chargesPermissionValue = checkbox.checked ? checkbox.value : "0";
     //price list
     var checkbox = document.getElementById("pricelistPermission");
    var pricelistPermissionValue = checkbox.checked ? checkbox.value : "0";
     //expenses
     var checkbox = document.getElementById("expensesPermission");
    var expensesPermissionValue = checkbox.checked ? checkbox.value : "0";
     //supplier
    var checkbox = document.getElementById("supplierPermission");
    var supplierPermissionValue = checkbox.checked ? checkbox.value : "0";
     //customer
     var checkbox = document.getElementById("customerPermission");
    var customerPermissionValue = checkbox.checked ? checkbox.value : "0";
    //Price Tag
    var checkbox = document.getElementById("pricetagPermission");
    var pricetagPermissionValue = checkbox.checked ? checkbox.value : "0";
    //Activity Logs
    var checkbox = document.getElementById("activitylogsPermission");
    var activitylogsPermissionValue = checkbox.checked ? checkbox.value : "0";
    //Activity Logs
    var checkbox = document.getElementById("managementPermission");
    var managementPermissionValue = checkbox.checked ? checkbox.value : "0";

    document.getElementById('firstNAME').style.color = (firstname == "" || firstname == null) ? "red" : "var(--primary-color)";
    document.getElementById('lastNAME').style.color = (lastname == "" || lastname == null) ? "red" : "var(--primary-color)";
    document.getElementById('roleNAME').style.color = (roleName == "" || roleName == null) ? "red" : "var(--primary-color)";
    document.getElementById('passWORD').style.color = (pass == "" || pass == null) ? "red" : "var(--primary-color)";
    document.getElementById('confirmPassword').style.color = (cpass == "" || cpass == null) ? "red" : "var(--primary-color)";

    var formData = new FormData();
    formData.append("uploadedImage", file); 
    formData.append("role_id", role_id); 
    formData.append("roleName", roleName); 
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
    formData.append("promotion", promotionPermissionValue);
    // new add
    formData.append("coupon", couponPermissionValue);
    formData.append("charges", chargesPermissionValue);
    formData.append("pricelist", pricelistPermissionValue);
    formData.append("expenses", expensesPermissionValue);
    formData.append("supplier", supplierPermissionValue);
    formData.append("customer", customerPermissionValue);
    formData.append("pricetag", pricetagPermissionValue);
    formData.append("activitylogs", activitylogsPermissionValue);
    formData.append("management", managementPermissionValue);
    formData.append("id",u_id);

   
    if(role_id && lastname && firstname && pass && cpass){
        if(pass == cpass){
            axios.post('api.php?action=updateUserData', formData)
             .then(function(response) { 
                var userInfo = JSON.parse(localStorage.getItem('userInfo'));
                var firstName = userInfo.firstName;
                var lastName = userInfo.lastName;
                var cid = userInfo.userId;
                var role_id = userInfo.roleId; 
                insertLogs('Users',firstName + ' ' + lastName + ' '+ 'Updated' + ' ' + firstname + ' '+ lastname);

                fetchEmployeeData()
                location.reload()
               showResponse("User updated successfully", 1);
              closeAddUserModal()
           
            })
            .catch(function(error) {
              console.log(error);
           });
        }else{
            showResponse("Password not match", 0);
        }  
    }
}


</script>
