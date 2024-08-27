<?php

  include( __DIR__ . '/layout/header.php');
  include( __DIR__ . '/utils/db/connector.php');
  include( __DIR__ . '/utils/models/product-facade.php');
  include( __DIR__ . '/utils/models/ingredients-facade.php');
  include(__DIR__ . '/utils/models/ability-facade.php');
  include(__DIR__ . '/utils/models/supplier-facade.php');
  include(__DIR__ . '/utils/models/user-facade.php');
  
  $productFacade = new ProductFacade;

  $userId = 0;
  
  $abilityFacade = new AbilityFacade;

  if (isset($_SESSION['totalPages'])) 
  {
      $totalPages = $_SESSION['totalPages'];
      unset($_SESSION['totalPages']); 
  }

if (isset($_SESSION['user_id'])) {
 
    $userID = $_SESSION['user_id'];

    
    $permissions = $abilityFacade->perm($userID);

    
    $accessGranted = false;
    foreach ($permissions as $permission) {
        if (isset($permission['Activitylogs']) && $permission['Activitylogs'] == "Access Granted") {
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

  if ($userId == 0) {
    header("Location: login");
  }
  if (isset($_GET["add_product"])) {
		$error = $_GET["add_product"];
    array_push($success, $error);
	}
  if (isset($_GET["update_product"])) {
		$error = $_GET["update_product"];
    array_push($info, $error);
	}
  if (isset($_GET["delete_product"])) {
		$error = $_GET["delete_product"];
    array_push($info, $error);
	}

  include('./modals/loading-modal.php');
  include('./modals/period-reports-modal.php');
?>


	<style>


  .custom-select select {
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      text-indent: 0.5em;
  }

 
    .fcontainer{
      overflow: auto;
      height: 750px;
    }
tbody {
    display: block;
    overflow: auto;
}
thead, tbody tr {
    display: table;
    width: 100%;
    table-layout: fixed;
    height: 1px;
}
tbody td {
    /* border: 1px solid #dddddd;  */
    border: none;
    padding: 2px 2px; 
    height: 5px; 
    line-height:1;
}
#logHead th{
    border: 2px solid white; 
    background: none;
    padding: 2px 2px; 
    height: 5px; 
    line-height:2;
}
#searchHead th{
    border: none;
    padding: 2px 2px; 
    height: 3px; 
    line-height:1;
}
.fcontainer::-webkit-scrollbar {
    width: 10px; 
    margin-right: 100px;
}

.f-container::-webkit-scrollbar-thumb {
  background: #888; 
  border-radius: 10px; 
}

.f-container::-webkit-scrollbar-track {
    background: #1e1e1e;
}

</style>

<?php include "layout/admin/css.php"?> 
<style>
  body{
    font-family: "Century Gothic"
  }
  .date-input-container {
    display: flex;
    align-items: center;
}

#dateRange {
    width: 100px;
    height: 25px;
    border: 1px solid #ccc;
    border-radius: 3px;
    margin-right: 5px;
}

#calendar-btn {
    border-radius: 3px;
    cursor: pointer;
    border-color: var(--primary-color);
    font-size: 10px;
}
.highlighted {
  background-color: var(--active-bg-color);
  border: none;
}
/* table tr:hover {
    cursor: pointer; 
    border: 1px solid #DB7093 !important;
  } */

  .custom-input input{
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  padding: 8px 30px 8px 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 0;
  background-color: #575757;
  color: white;
  cursor: pointer;
  width: 100%;
}

  .custom-input {
  position: relative;
  display: inline-block;
  width: 100%;
}


.custom-input input {
  padding-left: 30px; 
  width: 100%
}

.custom-input .calendar-icon {
  position: absolute;
  top: 50%;
  left: 10px; 
  transform: translateY(-50%);
  cursor: pointer;
}

.search-logs {
  width: 100%; 
  height: auto; 
  border-radius: 20px 0 0 20px; 
  border-top: 1px solid var(--border-color) !important;
  border-bottom: 1px solid var(--border-color) !important;
  border-right: 1px solid var(--border-color) !important;
  border-right: 1px solid transparent !important;
  padding-left: 15px;
  font-style: italic;
  border-right: none;
}

.searcBtn-log {
  margin-right:10px; 
  width:55px; 
  border-radius: 0 20px 20px 0; 
  border-left: none;
  padding-left: 10px;
}

.select-app {
  background-color: transparent; 
  color: #ffff; 
  width: 100%; 
  border: 1px solid var(--border-color); 
  font-size: 14px;
  height: 35px;
  border-radius: 10px;
  padding: 5px 5px;
}

select::-webkit-scrollbar {
    width: 6px; 
}
select::-webkit-scrollbar-track {
    background: #1e1e1e;
}
select::-webkit-scrollbar-thumb {
    background: #888; 
    border-radius: 20px; 
}
#logTable tbody tr:hover{
  background-color: #333333;
}

</style>

  <div class="container-scroller">
    <?php include 'layout/admin/sidebar.php' ?>
      <div class="main-panel h-100" style = "overflow: hidden">
        <div class="content-wrapper">
          <div class="row not_scrollable" style = "margin-bottom: 10px; ">
            <div class="col-md-12" >
              <div id="title" class = "text-custom ms-2">
                <label for="" style="font-size: 35px;">ACTIVITY LOGS</label>
              </div>
            </div>
            <div class = "row">
                <div style = "background-color: #1e1e1e; border-color: white; width: 15%; border-radius: 10px;">
                  <div class="mainDiv" style = "margin-left: 15px; height: 90vh">
                  <br>
                    <div class="row">
                      <h6 class = "text-custom">Select Date</h6>
                      <div class="custom-select">
                        <a  href="#"  class="custom-input mt-1" id="btn_datePicker" >
                            <input readonly type="text" placeholder="Select Date" id="datepicker" style="padding-left: 35px; background: transparent !important; border-radius: 10px; text-align: center; height: 35px; border: 1px solid var(--border-color) !important;">
                            <svg class="calendar-icon" width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier"> 
                                    <path d="M7 10H17M7 14H12M7 3V5M17 3V5M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                        </a>
                      </div>
                    </div>
                    <br>
                    <div class = "row">
                        <h6 class = "text-custom">Choose Application</h6>
                        <div class="custom-select" style="margin-right: 0px; ">
                            <select name="application" id = "application" class="select-app">
                                <option value="1">Cashiering App</option>
                                <option value="2">BackOffice App</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class = "row">
                        <h6 class = "text-custom">Select User</h6>
                        <div class="custom-select" style="margin-right: 0px; ">
                            <select name="user" id = "user" class="select-app">
                                <option value="">-- Select Here --</option>
                                <?php
                                  $userFacade = new UserFacade;
                                  $users = $userFacade->fetchUserForLogs();
                                  while ($row = $users->fetch(PDO::FETCH_ASSOC)) {
                                      echo '<option value="' . $row['first_name'] .' ' . $row['last_name'] . '">' . $row['first_name'] .' ' . $row['last_name'] . '</option>';
                                  }
                              ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class = "row">
                        <div class="custom-select" style="margin-right: 0px; ">
                             <button style = "height: 35px; border-radius: 10px; font-size: 0.9rem; width: 100%" id = "btn_reload"><i class = "bi bi-arrow-clockwise"></i> Reload</button>
                        </div>
                     </div>
                  </div>
                </div>
                
                <div class = "col-md-11" style = "background-color: #262626; width: 85%" >

                    <div class="d-flex justify-content-between mb-2">
                      <input  class="text-color search-logs" id = "search_log" placeholder="Search Logs [Date&Time,User,Module,Activity]" autocomplete = "off" autofocus="autofocus"/>
                      <button  id="searchBtn" name="productSearch"  class="searcBtn-log">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>
                      </button>
                    </div>

                    <div class="tableCard" style = " width: 100%; background-color: #262626;  ">
                      <table  class="text-color mb-2">
                        <thead id = "logHead">
                            <tr style = "border: 1px solid var(--primary-color); " >
                                <th class = "th-noborder" style="background-color: none;  border: none; width: 15%; font-size: 12px; text-align: left">DATE & TIME</th>
                                <th class = "th-noborder" style="background-color: none; text-align:center; width: 15%; font-size: 12px; text-align: left">USER</th>
                                <th class = "th-noborder" style="background-color: none; text-align:center; width: 10%; font-size: 12px; text-align: left">ROLE</th>
                                <th class = "th-noborder" style="background-color: none; width: 15%; font-size: 12px; text-align: left">MODULE</th>
                                <th  class = "th-noborder"  style="background-color: none; text-align:center; width: 50%; font-size: 12px; text-align: left">ACTIVITY</th>
                            </tr>
                        </thead>
                      </table>
                      <div class="fcontainer">
                          <table id="logTable" class="text-color " style="margin-top: -3px; height: 300px; padding:10px; font-size: 15px;">
                              <tbody style="border-collapse: collapse; border: none">
                                <img id="noRecords" src ="./assets/img/tinkerpro-t.png" style="display: none;">
                              </tbody>
                          </table>
                      </div>
                    </div> 
                    <div style = "position: absolute; bottom: 5vh; right: 0; margin-right: 3.5vh;">
                      <button class="button" style="width: 200px; background-color: #262626; color: white; height: 40px; " id="downloadFile">Download Txt File</button>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php 
  include("layout/footer.php");
?>
<script src="assets/adminjs/activitylogs.js"></script>