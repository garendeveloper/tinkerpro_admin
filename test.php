<?php

  include( __DIR__ . '/layout/header.php');
  include( __DIR__ . '/utils/db/connector.php');
  include( __DIR__ . '/utils/models/user-facade.php');
  include(__DIR__ . '/utils/models/ability-facade.php');


  $userId = 0;
  
  $abilityFacade = new AbilityFacade;

if (isset($_SESSION['user_id'])) {
 
    $userID = $_SESSION['user_id'];

    
    $permissions = $abilityFacade->perm($userID);

    
    $accessGranted = false;
    foreach ($permissions as $permission) {
        if (isset($permission['Users']) && $permission['Users'] == "Access Granted") {
            $accessGranted = true;
            break;
        }
    }
    if (!$accessGranted) {
      header("Location: 403.php");
      exit;
  }
} else {
    header("Location: login.php");
    exit;

}

  if (isset($_SESSION["user_id"])){
    $userId = $_SESSION["user_id"];
  }
  if (isset($_SESSION["first_name"])){
    $firstName = $_SESSION["first_name"];
  }
  if (isset($_SESSION["last_name"])){
    $lastName = $_SESSION["last_name"];
  }

  // Redirect to login page if user has not been logged in
  if ($userId == 0) {
    header("Location: login");
  }
  if (isset($_GET["add_user"])) {
		$error = $_GET["add_user"];
    array_push($success, $error);
	}
  if (isset($_GET["update_user"])) {
		$error = $_GET["update_user"];
    array_push($info, $error);
	}
  if (isset($_GET["delete_user"])) {
		$error = $_GET["delete_user"];
    array_push($info, $error);
	}

  include('./modals/add-users-modal.php');
  include('./modals/permissionModal.php');
  include('./modals/access_denied.php');
  include('./modals/access_granted.php');
  include('./modals/user-logs-modal.php');
?>
<?php include "layout/admin/css.php"?>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include 'layout/admin/sidebar.php' ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div style="display: flex; margin-bottom: 20px;">
           <input  class="text-color searchUsers" style="width: 80%; height: 45px; margin-right: 10px" placeholder="Search Users,Employee Number,Role"/>
           <button class="btn-control" style="margin-right:10px; width:120px">&nbsp;Search</button>
           <button onclick="addUser()"  class="btn-control" style="margin-right:10px;width:120px ">&nbsp;Add User</button>
            <button class="btn-control clearBtn" style="width:120px;order: 1" >>&nbsp;Clear</button>
            </div>
          <div>
          <div class="row">
            <div>
              <div class="card" style="height:700px; width: 100%">
                <div class="card-body">
                <h2 class="text-color user-header" style="margin-left: 5px">USERS INFORMATION</h2>
                  <?php include('errors.php'); ?>
                  <div class="select-area dropdown custom-input">
                    <input class="custom-input texct-color filterStatus" readonly hidden name="filterStatus" id="filterStatus" style="width: 180px"/>
                    <input class="text-color filterStatusName" readonly name="filterStatusName" id="filterStatusName" style="width: 130px; border: 1px solid #808080; margin-right: 5px;">   
                    <button name="filterStatusBtn" id="filterStatusBtn" class="custom-btn">
                    <svg width="25px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                      <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                      <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <path d="M19 5L12.7071 11.2929C12.3166 11.6834 11.6834 11.6834 11.2929 11.2929L5 5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M19 13L12.7071 19.2929C12.3166 19.6834 11.6834 19.6834 11.2929 19.2929L5 13" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </g>
        </svg>
    </button>
    <div class="statusDropDown" id="statusDropDown">
        <?php
            $userFacade = new UserFacade();
            $status = $userFacade->getUsersStatus();
            echo '<a href="#" style="color:#000000; text-decoration: none;" data-value="0">All</a>';
            while ($row = $status->fetch(PDO::FETCH_ASSOC)) {
                echo '<a href="#" style="color:#000000; text-decoration: none;" data-value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['status']) . '</a>';
            }
                ?>       
             </div>
        </div>

                  <div class="table-responsive usersTable">
                    <table id="recentusers" class="text-color table-border">
                      <thead>
                        <tr>
                          <th class="text-center" style="width: 3%;">No.</th>
                          <th class="text-center" style="width: 20%;">USERS</th>
                          <th class="text-center" style="width: 10%;">ROLE</th>
                          <th class="text-center" style="width: 8%;">ID</th>
                          <th class="text-center" style="width: 10%;">EMPLOYEE NO.</th>
                          <th class="text-center" style="width: 10%;">DATE HIRED</th>
                          <th class="text-center" style="width: 10%;">STATUS</th>
                          <th class="text-center" style="width: 10%;">ACTION</th>
                        </tr>
                      </thead>
                      <tbody  id="userTable">
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div style="display: flex; margin-top: 10px">
                <button class="btn-control" id="printThis" style="width:160px; height:45px; margin-right: 10px"><svg version="1.1" id="_x32_" width="25px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="" stroke=""><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#ffff;} </style> <g> <path class="st0" d="M488.626,164.239c-7.794-7.813-18.666-12.684-30.578-12.676H409.01V77.861L331.145,0h-4.225H102.99v151.564 H53.955c-11.923-0.008-22.802,4.862-30.597,12.676c-7.806,7.798-12.665,18.671-12.657,30.574v170.937 c-0.008,11.919,4.847,22.806,12.661,30.589c7.794,7.813,18.678,12.669,30.593,12.661h49.034V512h306.02V409.001h49.037 c11.901,0.008,22.78-4.848,30.574-12.661c7.818-7.784,12.684-18.67,12.677-30.589V194.814 C501.306,182.91,496.436,172.038,488.626,164.239z M323.519,21.224l62.326,62.326h-62.326V21.224z M123.392,20.398l179.725,0.015 v83.542h85.491v47.609H123.392V20.398z M388.608,491.602H123.392v-92.801h-0.016v-96.638h265.217v106.838h0.015V491.602z M480.896,365.751c-0.004,6.353-2.546,11.996-6.694,16.17c-4.166,4.136-9.813,6.667-16.155,6.682h-49.049V281.75H102.974v106.853 H53.955c-6.365-0.015-12.007-2.546-16.166-6.682c-4.144-4.174-6.682-9.817-6.686-16.17V194.814 c0.004-6.338,2.538-11.988,6.686-16.155c4.167-4.144,9.809-6.682,16.166-6.698h49.034h306.02h49.037 c6.331,0.016,11.985,2.546,16.151,6.698c4.156,4.174,6.694,9.817,6.698,16.155V365.751z"></path> <rect x="167.59" y="336.155" class="st0" width="176.82" height="20.405"></rect> <rect x="167.59" y="388.618" class="st0" width="176.82" height="20.398"></rect> <rect x="167.59" y="435.255" class="st0" width="83.556" height="20.398"></rect> <path class="st0" d="M353.041,213.369c-9.263,0-16.767,7.508-16.767,16.774c0,9.251,7.504,16.759,16.767,16.759 c9.263,0,16.77-7.508,16.77-16.759C369.811,220.877,362.305,213.369,353.041,213.369z"></path> <path class="st0" d="M424.427,213.369c-9.262,0-16.77,7.508-16.77,16.774c0,9.251,7.508,16.759,16.77,16.759 c9.258,0,16.766-7.508,16.766-16.759C441.193,220.877,433.685,213.369,424.427,213.369z"></path> </g> </g></svg>&nbsp;Print</button>
                <button class="btn-control" id="generatePDFBtn"style="width:160px; height:45px; margin-right: 10px"><svg width="25px" height="25px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M2.5 6.5V6H2V6.5H2.5ZM6.5 6.5V6H6V6.5H6.5ZM6.5 10.5H6V11H6.5V10.5ZM13.5 3.5H14V3.29289L13.8536 3.14645L13.5 3.5ZM10.5 0.5L10.8536 0.146447L10.7071 0H10.5V0.5ZM2.5 7H3.5V6H2.5V7ZM3 11V8.5H2V11H3ZM3 8.5V6.5H2V8.5H3ZM3.5 8H2.5V9H3.5V8ZM4 7.5C4 7.77614 3.77614 8 3.5 8V9C4.32843 9 5 8.32843 5 7.5H4ZM3.5 7C3.77614 7 4 7.22386 4 7.5H5C5 6.67157 4.32843 6 3.5 6V7ZM6 6.5V10.5H7V6.5H6ZM6.5 11H7.5V10H6.5V11ZM9 9.5V7.5H8V9.5H9ZM7.5 6H6.5V7H7.5V6ZM9 7.5C9 6.67157 8.32843 6 7.5 6V7C7.77614 7 8 7.22386 8 7.5H9ZM7.5 11C8.32843 11 9 10.3284 9 9.5H8C8 9.77614 7.77614 10 7.5 10V11ZM10 6V11H11V6H10ZM10.5 7H13V6H10.5V7ZM10.5 9H12V8H10.5V9ZM2 5V1.5H1V5H2ZM13 3.5V5H14V3.5H13ZM2.5 1H10.5V0H2.5V1ZM10.1464 0.853553L13.1464 3.85355L13.8536 3.14645L10.8536 0.146447L10.1464 0.853553ZM2 1.5C2 1.22386 2.22386 1 2.5 1V0C1.67157 0 1 0.671573 1 1.5H2ZM1 12V13.5H2V12H1ZM2.5 15H12.5V14H2.5V15ZM14 13.5V12H13V13.5H14ZM12.5 15C13.3284 15 14 14.3284 14 13.5H13C13 13.7761 12.7761 14 12.5 14V15ZM1 13.5C1 14.3284 1.67157 15 2.5 15V14C2.22386 14 2 13.7761 2 13.5H1Z" fill="#ffff"></path> </g></svg>&nbsp;Save as PDF</button>
                <button class="btn-control" id="generateEXCELBtn" style="width:160px; height:45px;"><svg height="25px" width="25px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26 26" xml:space="preserve" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path style="fill:#ffff;" d="M25.162,3H16v2.984h3.031v2.031H16V10h3v2h-3v2h3v2h-3v2h3v2h-3v3h9.162 C25.623,23,26,22.609,26,22.13V3.87C26,3.391,25.623,3,25.162,3z M24,20h-4v-2h4V20z M24,16h-4v-2h4V16z M24,12h-4v-2h4V12z M24,8 h-4V6h4V8z"></path> <path style="fill:#ffff;" d="M0,2.889v20.223L15,26V0L0,2.889z M9.488,18.08l-1.745-3.299c-0.066-0.123-0.134-0.349-0.205-0.678 H7.511C7.478,14.258,7.4,14.494,7.277,14.81l-1.751,3.27H2.807l3.228-5.064L3.082,7.951h2.776l1.448,3.037 c0.113,0.24,0.214,0.525,0.304,0.854h0.028c0.057-0.198,0.163-0.492,0.318-0.883l1.61-3.009h2.542l-3.037,5.022l3.122,5.107 L9.488,18.08L9.488,18.08z"></path> </g> </g></svg>&nbsp;Save as Excel</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

<?php include("layout/footer.php") ?>
<style>
 .statusDropDown {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    z-index: 1;
    top: calc(100% + 10px); 
    right: 0; 
    top: 38px;
}


#topBar{
  background-color:#262626
}
 
  .statusDropDown a {
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
  

  .statusDropDown a:hover {
    background-color: #ddd;
  }
   .editBtn:hover {
     transform: scale(0.9);
  }
  .editBtn {
    text-decoration: none; 
    border-radius: 3px; 
    overflow: hidden;
    display: inline-block; 
    transition: transform 0.3s;
  }
  .content-wrapper{
    background-color: #262626;
  
  }
  .btn-control:hover {
    border-color: #FF6900 !important; 
    color: #ffff !important; 
}
  .text-color{
    color: #ffff;
    font-family: Century Gothic;
  }
  .card{
    background-color:#151515;
    border-color: #242424;
  }
  .table-border{
    border-collapse: collapse;
    border: 1px solid white;
  }
  .usersTable{
    position: absolute; 
    left: 2px;
    right:2px;
    margin-top: 80px;
  }
  .select-area {
  margin-top: 40px;
  position: absolute;
  right:5px;
  display: flex;
  align-items: flex-end;
  justify-content: flex-end;

}

  .searchUsers{
  background-color: #7C7C7C;
  }
  .text-color::placeholder {
  color: #ffff;
}

.table-border th, td {
  border: 1px solid white;
  padding: 8px;
}
.table-border th{
  background-color: #FF6900;
}
.text-center{
  text-align: center;
}
.user-header{
  position: absolute;
  left: 0;
  top: 5px;
}
.btn-control{
  font-family: Century Gothic;
  border-radius: 10px;
  border-color: #33557F;
}
.table-responsive {
    max-height: 600px; 
    overflow: auto; 
    width: 100%;
}

.table-responsive table {
    border-collapse: collapse;
    width: 100%;
}
.text-custom{
   color: #FF6900;
   font-family: Century Gothic;
   font-weight: bold;
}
.text-custom-data{
   color: #FF6900;
   font-family: Century Gothic;
}
.btn-success-custom{
  background-color: #00B050
}
.btn-error-custom{
  background-color: red;
}
.action-td{
  font-style: italic;
}
.highlightedUser {
    border: 2px solid #00B050 !important; 
}


</style>
<script>


$(document).ready(function() {
  $("#users").addClass('active');
  $("#pointer").html("Users");

    $('#dropdownContent a').click(function() {
        var roleId = $(this).data('value');
        selectedRole(roleId)
        $('#roleNAME').css('color', (roleId !== "" && roleId !== null) ? "#FF6900" : "");
        $.ajax({
        url: './api.php',
        method: 'GET',
        data: {
            action: 'user_role',
            roleId: roleId
        },
        success: function(response) {
          $('.user_ID').val(response.role_id);
        },
        error: function(xhr, status, error) {
            console.error(error);
          
        }
    });
    });

    
});

function selectedRole(id) {
    switch(id) {
        case 2:
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = true;
            });
            break;
            case 3:
                const idsToCheck = ["xReadingPermission", "zReadingPermission", "cashCountPermission", "startingCashPermission"];
                checkboxes.forEach(checkbox => {
                    checkbox.checked = idsToCheck.includes(checkbox.id);
                });
            break;
            case 5:
              const idsToChecks = ["refund_permission", "retAndExPermission", "salesHistoryPermission", "voidItemPermission","voidCartPermission","cancelOfficialReceiptPermission"];
                checkboxes.forEach(checkbox => {
                    checkbox.checked = idsToChecks.includes(checkbox.id);
                });
            break;
            case 6:
              const idsToCheckss = ["usersPermission", "purchaseOrderPermission", "documentsPermission", "productsPermission","reportingPermission","inventoryPermission"];
                checkboxes.forEach(checkbox => {
                    checkbox.checked = idsToCheckss.includes(checkbox.id);
                });
            break;
            default: return;
    }
}


function addUser() {
    $('#add_users_modal').show();
}

function refreshTable() {
        $.ajax({
            url: './fetch-data/fetch-users.php', 
            type: 'GET',
            success: function(response) {
                $('#userTable').html(response); 
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); 
            }
        });
    }

function selectDataDisplay() {
  var value;

  $(".statusDropDown a").click(function(event) {
          $('.searchUsers').val("")
         event.preventDefault();
         value = $(this).attr("data-value");
        var statusName = $(this).text();
        $("#filterStatus").val(value);
        $("#filterStatusName").val(statusName);
        $("#statusDropDown").hide();
        $.ajax({
            url: './fetch-data/fetch-users.php', 
            type: 'GET',
            data:{selectedValue:value},
            success: function(response) {
                $('#userTable').html(response); 
               
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); 
            }
        });
    });   
}
  refreshTable() 
  selectDataDisplay()

    $(document.body).on('click', '.editBtn', function() {
        var userId = $(this).closest('tr').find('.userId').text();
        var dataFirstName =  $(this).closest('tr').find('.f_name').text();
        var dataLastName =  $(this).closest('tr').find('.l_name').text();
        var employeeNum =  $(this).closest('tr').find('.employeeNum').text();
        var pw =  $(this).closest('tr').find('.pw').text();
        var imageName =  $(this).closest('tr').find('.imageName').text();
        var datastats =  $(this).closest('tr').find('.statsData').text();
        var datastatsID =  $(this).closest('tr').find('.statsDataID').text();
        var roleN =  $(this).closest('tr').find('.roleN').text();
        var roleID =  $(this).closest('tr').find('.roleidNum').text();
        var identification =  $(this).closest('tr').find('.identification').text();
        var datehired =  $(this).closest('tr').find('.datehired').text();
        var perm =  $(this).closest('tr').find('.permission').text();
        $('.highlightedUser').removeClass('highlightedUser');


      var $row = $(this).closest('tr').addClass('highlightedUser');
        updateUserForm(userId,dataFirstName,dataLastName,employeeNum,pw,imageName,datastats,datastatsID,roleN,roleID,identification,datehired,perm)
    });

 
    $(document).ready(function() {
      $(".statusDropDown a[data-value='0']").click();
      $('#generatePDFBtn').click(function() {
      var searchData = $('.searchUsers').val();
      var statusValue = $("#filterStatus").val(); 

    $.ajax({
        url: './reports/generate_pdf.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
        data: {
            selectedValue: statusValue,
            searchQuery: searchData
        },
        success: function(response) {
            var blob = new Blob([response], { type: 'application/pdf' });
            var url = window.URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'usersList.pdf';
            document.body.appendChild(a);
            a.click();

            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
            var userInfo = JSON.parse(localStorage.getItem('userInfo'));
            var firstName = userInfo.firstName;
            var lastName = userInfo.lastName;
            var cid = userInfo.userId;
            var role_id = userInfo.roleId; 

            insertLogs('Users',firstName + ' ' + lastName + ' '+ 'Generate pdf');
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            console.log(searchData)
        }
    });
});


  $('#generateEXCELBtn').click(function() {
    var searchData = $('.searchUsers').val();
    $.ajax({
        url: './reports/generate_excel.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
        data: {
            selectedValue: $('#filterStatus').val(),
            searchQuery: searchData 
        },
        success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'usersList.xlsx'; 

            
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
            var userInfo = JSON.parse(localStorage.getItem('userInfo'));
            var firstName = userInfo.firstName;
            var lastName = userInfo.lastName;
            var cid = userInfo.userId;
            var role_id = userInfo.roleId; 

            insertLogs('Users',firstName + ' ' + lastName + ' '+ 'Exported'+ 'usersList.xlsx');
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
 
$('#printThis').click(function() {
    var searchData = $('.searchUsers').val();
    var statusValue = $("#filterStatus").val(); 

    $.ajax({
        url: './reports/generate_pdf.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
        data: {
            selectedValue: statusValue,
            searchQuery: searchData
        },
        success: function(response) {
          var blob = new Blob([response], { type: 'application/pdf' });
            var url = window.URL.createObjectURL(blob);
            var win = window.open(url);
            win.onload = function() {
                win.print();
                win.onafterprint = function() {
                    window.focus(); 
                    win.close();
                }
            }

            window.URL.revokeObjectURL(url);
            var userInfo = JSON.parse(localStorage.getItem('userInfo'));
            var firstName = userInfo.firstName;
            var lastName = userInfo.lastName;
            var cid = userInfo.userId;
            var role_id = userInfo.roleId; 

            insertLogs('Users',firstName + ' ' + lastName + ' '+ 'Printing a pdf');
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            console.log(searchData)
        }
    });
});
$('.searchUsers').on('input', function(){
    var searchData = $(this).val();
    var statusValue = $("#filterStatus").val(); 
    
    $.ajax({
        url: './fetch-data/fetch-users.php', 
        type: 'GET',
        data: {
            selectedValue: statusValue,
            searchQuery: searchData 
        },
        success: function(response) {
            $('#userTable').html(response); 
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText); 
        }
    });
});
 $('.clearBtn').on('click', function(){
    $('.searchUsers').val("")
    $(".statusDropDown a[data-value='0']").click();
    refreshTable() 
 })

 });


document.getElementById("filterStatusBtn").addEventListener("click", function() {
  var dropdownContents = document.getElementById("statusDropDown");
  if (dropdownContents.style.display === "block") {
    dropdownContents.style.display = "none";
  } else {
    dropdownContents.style.display = "block";
  }
  event.stopImmediatePropagation();
});

document.addEventListener("click", function(event) {
  var dropdownContent = document.getElementById("statusDropDown");
  var statusBtn = document.getElementById("filterStatusBtn");
  if (event.target !== dropdownContent && event.target !== statusBtn && dropdownContent.style.display === "block") {
    dropdownContent.style.display = "none";
  }
});
$(document.body).on('click', '.viewLogs', function() {
        var userId = $(this).closest('tr').find('.userId').text();
        var dataFirstName =  $(this).closest('tr').find('.f_name').text();
        var dataLastName =  $(this).closest('tr').find('.l_name').text();
        var employeeNum =  $(this).closest('tr').find('.employeeNum').text();
        var pw =  $(this).closest('tr').find('.pw').text();
        var imageName =  $(this).closest('tr').find('.imageName').text();
        var datastats =  $(this).closest('tr').find('.statsData').text();
        var datastatsID =  $(this).closest('tr').find('.statsDataID').text();
        var roleN =  $(this).closest('tr').find('.roleN').text();
        var roleID =  $(this).closest('tr').find('.roleidNum').text();
        var identification =  $(this).closest('tr').find('.identification').text();
        var datehired =  $(this).closest('tr').find('.datehired').text();
        var perm =  $(this).closest('tr').find('.permission').text();
        $('.highlightedUser').removeClass('highlightedUser');
        var $row = $(this).closest('tr').addClass('highlightedUser');
        console.log(userId)

        openUsersLogs()
       
    });

</script>
