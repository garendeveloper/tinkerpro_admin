<?php

  include( __DIR__ . '/layout/header.php');
  include( __DIR__ . '/utils/db/connector.php');
  include( __DIR__ . '/utils/models/user-facade.php');
  include(__DIR__ . '/utils/models/ability-facade.php');
  include( __DIR__ . '/utils/models/employee-facade.php');


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

  include('./modals/add-employee-modal.php');
  include('./modals/permissionModal.php');
  include('./modals/access_denied.php');
  include('./modals/access_granted.php');
  include('./modals/user-logs-modal.php');

?>
<style>
  #topBar{
  background-color:#262626
}
.content-wrapper{
    background-color: #262626;
  
  }
 
  .text-color::placeholder {
  color: #ffff;
}
.btn-control{
  font-family: Century Gothic;
  border-radius: 10px;
  border-color: #33557F;
}
/* 
.btn-success-custom{
  background-color: #00B050
} */
.btn-error-custom{
  background-color: red;
}
.btn-control:hover {
    border-color: var(--primary-color); 
    color: #fefefe !important; 
}
.productTable{
    position: absolute; 
    left: 2px;
    right:2px;
    top:2px;
    
}
.table-border{
    border-collapse: collapse;
    width: 100%;
    border: 1px solid #292928 !important;
}

.table-border td {
  padding: 2px !important;
}

.table-border th, td {
  border: 1px solid #292928 !important;
  padding: 8px;
  font-size: 12px !important;
}


 th.text-center{
  background: transparent !important;
  color: var(--primary-color);
  font-size: 12px;
}

.text-color{
    color: #ffff;
    font-family: Century Gothic;
  }
  .table-responsive {
    max-height: 600px;
    width: 100%; 
   
}


.card{
    background-color:#151515;
    border-color: #242424;
    height: 200px; 
    border-radius: 8px;
    padding: 16px; 
  }



  .searchDis, .addProducts {
    background: #7C7C7C;
    border: 1px solid transparent;
  }

  .addProducts {
    border-radius: 0 20px 20px 0;
  }

  .searcEmployee {
    padding-left: 15px;
    border-radius: 20px 0 0 20px;
    background-color: #7C7C7C;
  }

  .main-panel {
    -webkit-user-select: none; 
    -moz-user-select: none;   
    -ms-user-select: none;  
    user-select: none;   
  }



  .setExpiration, .filterBtn {
    border-radius: 50%;
    height: 35px;
    width: 35px;
    border: none;
    box-shadow: none;
  }  
  
  .setExpiration:hover, .filterBtn:hover {
    background: none;
  }
  
  #expirationSelect, #filterStatusName {
    background: none;
    height: 35px;
    color: var(--text-color);
    border-radius: 5px;
    border: 1px solid var(--border-color);
    font-size: 13px;
    width: auto;
  }


  .deleteIcon:hover{
    color: red;
}


#responsive-data thead th,
    #responsive-data tbody td {
      padding: 6px 6px; 
      height: auto; 
      line-height: 0.5; 
      border: 1px solid #292928;
      color: #ffff;
  }
  #responsive-data{
    width: 100%;
  }
  #responsive-data thead {
      display: table; 
      width: calc(100% - 4px);
  }

  #responsive-data tbody {
      display: block; 
      max-height: 76vh; 
      overflow-y: scroll;
  }

  #responsive-data th, td {
      width: 9%;
      overflow-wrap: break-word; 
      box-sizing: border-box;
      font-size: 13px;
  }
  #responsive-data tr {
      display: table;
      width: 100%;
  }
  #responsive-data, table,  tbody{
    border: 1px solid #292928;
  }
  #responsive-data table{
      background-color: #1e1e1e;
   
      height: 5px;
      padding: 10px 10px;
  }
  #responsive-data tbody::-webkit-scrollbar {
    width: 4px; 
}
#responsive-data tbody::-webkit-scrollbar-track {
    background: #151515;
}
#responsive-data tbody::-webkit-scrollbar-thumb {
    background: #888; 
    border-radius: 50px; 
}
 .main-panel, .container-scroller, .card, .card-body, .content-wrapper{
  overflow: hidden !important;
 }
 .child-a{
  width: 3% !important;
 }
 .child-b{
  width: 12% !important;
 }
 .child-c{
  width: 5% !important;
 }
 .child-d{
  width: 5% !important;
 }
 .child-e{
  width: 5% !important;
 }
 .child-f{
  width: 5% !important;
 }
 .child-g{
  width: 5% !important;
 }
 .child-h{
  width: 3% !important;
 }
 .adminTableHead th{
  font-weight: bold !important;
  font-size: 12px !important;
  line-height: 18px !important;
 }
 .adminTableHead tbody td{
  padding-left: 10px !important;
 }

   /* start for search bar css*/

   ::selection {
  color: black;
  background: white;
}

.text-color.searchEmployee{
    caret-color: white; 
    color: white; 
    background-color: #555; 
    font-size: 15px; 
}

.text-color.searchEmployee::placeholder {
    color: rgba(255, 255, 255, 0.8);
}

.clearBtn{
  background-color: #555;  
  margin-left: -5px;
  height: 35px;
  cursor: pointer;
}

.clearBtn svg {
  transition: fill 0.3s ease, transform 0.3s ease; 
}

.clearBtn:hover svg {
  fill: var(--primary-color); 
  transform: scale(1.1);
}

.searchbtn {
   background-color: #555;  
  border:none;
  }

.addProducts.searchAdd {
    background-color: #555;
}
.addProducts.searchAdd:hover {
    background-color: var(--primary-color);
}

/*   end for search bar css */





@media screen and (max-width: 1400px) {
     
  #responsive-data th.child-a, #responsive-data td.child-a { width: 50px !important; }
    #responsive-data th.child-b, #responsive-data td.child-b { width: 150px !important; }
    #responsive-data th.child-c, #responsive-data td.child-c { width: 100px !important; }
    #responsive-data th.child-d, #responsive-data td.child-d { width: 80px !important; }
    #responsive-data th.child-e, #responsive-data td.child-e { width: 120px !important; }
    #responsive-data th.child-f, #responsive-data td.child-f { width: 100px !important; }
    #responsive-data th.child-g, #responsive-data td.child-g { width: 90px !important; }
    #responsive-data th.child-h, #responsive-data td.child-h { width: 70px !important; }
     

    #responsive-data td{

      font-size: 12px !important;
    }
    .card{
      height: 68vh !important;
    }

    .btn-control{
      zoom:90%;
    }
  .modal{
   zoom: 80% !important;

  }

  #addUsers td{
    font-size: 14px !important;
  }

  .accessLevel{
   
    font-size: 15px;
  }
  .imageCard{
    height:50px;
  }
    }




</style>
<?php include "layout/admin/css.php"?>
  <div class="container-scroller">
      <?php include 'layout/admin/sidebar.php' ?>
      <div class="main-panel h-100">
        <div class="content-wrapper">

     
       
                <button id="attendance" class="grid-item pos-setting text-color button"><i class="bi bi-calendar-check-fill"></i>&nbsp;
                  Attendance</button>
                <button id="stocks" class="grid-item pos-setting text-color button"><i class="bi bi-credit-card"></i>&nbsp;
                  Payroll</button>
                <button id="payroll" class="grid-item pos-setting text-color button"><i class="bi bi-card-list"></i>&nbsp;
                  Leave <span id="leavemanagement" class="badge badge-danger"
                  style="font-size: 11px; background-color: red; color: fff; "></span></button>
              

           
          
          <div class="d-flex mb-2 w-10">

            <input  class="text-color searchEmployee w-100 ms-2 searchInputs" id="searchInput" placeholder="Search Employee"/>
            <span class="clearBtn" id="clearbtn" >
              <svg xmlns="http://www.w3.org/2000/svg" width="25" height="35" fill="#fff" class="bi bi-x" viewBox="0 0 16 16">
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
              </svg>
            </span>

            <button class="searchbtn">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
              </svg>
            </button>

            <button class="addProducts searchAdd">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
              </svg> 
            </button>


            <?php include('errors.php'); ?>
                    
            <input class="custom-input texct-color filterStatus" readonly hidden name="filterStatus" id="filterStatus" style="width: 180px"/>
            <!-- <input class="text-color filterStatusName" readonly name="filterStatusName" id="filterStatusName" >    -->
            <select class="text-color ms-2 filterStatusName" name="filterStatusName" id="filterStatusName">
              <?php
                  $userFacade = new UserFacade();
                  $status = $userFacade->getUsersStatus();
                  echo '<option value="0" data-value="0">All</option>';
                  while ($row = $status->fetch(PDO::FETCH_ASSOC)) {
                      // Check if the status is 'Active' and set it as selected
                      $selected = ($row['status'] == 'Active') ? 'selected' : '';
                      echo '<option value="'. $row['id'] .'" data-value="'. $row['id'] .'" '. $selected .'>'. $row['status'] .'</option>';
                  }
              ?>       
          </select>


            <button name="filterStatusBtn" id="filterStatusBtn" class="filterBtn">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter-right" viewBox="0 0 16 16">
                <path d="M14 10.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 .5-.5m0-3a.5.5 0 0 0-.5-.5h-7a.5.5 0 0 0 0 1h7a.5.5 0 0 0 .5-.5m0-3a.5.5 0 0 0-.5-.5h-11a.5.5 0 0 0 0 1h11a.5.5 0 0 0 .5-.5"/>
              </svg>
            </button>
          </div>

          <div>
          <div class="row">
            <div>
              <div class="card ms-1 ps-0 pe-0 pb-0 pt-0 d-flex" style="height:76vh; width: 100%">
                  <?php include('errors.php'); ?>
                  <div id="responsive-data" >
                    <table id="recent_employee" class="text-color table-border">
                      <thead class = 'adminTableHead'>
                        <tr>
                          <th class="text-center child-a" style=" border-left: 1px solid transparent !important">No.</th>
                          <th class="text-center child-b">NAME</th>
                          <th class="text-center child-c">POSITION</th>
                          <th class="text-center child-e">EMPLOYEE NO.</th>
                          <th class="text-center child-f">DATE HIRED</th>
                          <th class="text-center child-g">STATUS</th>
                          <th class="text-center child-h" style="border-right: 1px solid transparent !important">ACTION</th>
                        </tr>
                      </thead>
                      <tbody  id="employeeTable">
                        
                      </tbody>
                    </table>
                  </div>
                <!-- </div> -->
              </div>

              <div id="paginationDiv" class="paginactionClass">

              </div>
              
            </div>
          </div>
        </div>
      </div>
      <!-- main-panel ends -->
    
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

<?php include("layout/footer.php") ?>
<script>

$("#employee").addClass('active');
  $("#pointer").html("Employee");

  $(document).ready(function () {



    function refreshTable() {
    $.ajax({
      url: './fetch-data/fetch-employee.php',
        type: 'GET',
        success: function(response) {
            $('#employeeTable').html(response); 
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText); 
        }
    });
}



  function fetchEmployeeData() {
    $.ajax({
        url: './fetch-data/fetch-employee.php', 
        type: 'GET',
        success: function (data) {
          $('#employeeTable').html(data); 
        },
        error: function (xhr, status, error) {
          console.error('Error fetching employee data:', error);
        }
      });
    }

    

  function selectDataDisplay() {
    $('#filterStatusName').off('change').on('change', function() {
      var value = $(this).val();
      $.ajax({
          url: './fetch-data/fetch-employee.php', 
          type: 'GET',
          data:{selectedValue:value},
          success: function(response) {
              $('#employeeTable').html(response); 
              
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText); 
          }
      });
    })
  }


    fetchEmployeeData();

  
   $(".addProducts").on("click", function(){
    $('#add_employee_modal').show();
  })


  
  function EmployeeForm(tableRow)
  {
    var empId = tableRow.closest('tr').find('.empId').text();
    var dataFirstName =  tableRow.closest('tr').find('.f_name').text();
    var dataLastName =  tableRow.closest('tr').find('.l_name').text();
    var empPosition =  tableRow.closest('tr').find('.empPosition').text();
    var empNumber =  tableRow.closest('tr').find('.empNumber').text();
    var pw =  tableRow.closest('tr').find('.pw').text();
    var imageName =  tableRow.closest('tr').find('.imageName').text();
    var status_name =  tableRow.closest('tr').find('.status_name').text();
    var status_id =  tableRow.closest('tr').find('.status_id').text();
    var datehired =  tableRow.closest('tr').find('.dateHired').text();
  



    console.log({
      empId, dataFirstName, dataLastName, empPosition, empNumber, pw, imageName, status_name, status_id, datehired
  });

    $('.highlightedUser').removeClass('highlightedUser');


    var $row = tableRow.closest('tr').addClass('highlightedUser');
    updateEmployeeForm(empId,dataFirstName,dataLastName,empPosition,empNumber,pw,imageName,status_name,status_id,datehired)
  }
  $(document.body).on('click', '.editBtn', function() {
    EmployeeForm($(this));  
  });
  
  $(document).on("dblclick", "#recent_employee tbody tr", function(e){
    e.preventDefault();
    EmployeeForm($(this));
  })

  });

</script>