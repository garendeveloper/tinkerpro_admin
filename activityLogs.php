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

  if (isset($_SESSION['totalPages'])) {
    $totalPages = $_SESSION['totalPages'];
    unset($_SESSION['totalPages']); 
}

if (isset($_SESSION['user_id'])) {
 
    $userID = $_SESSION['user_id'];

    
    $permissions = $abilityFacade->perm($userID);

    
    $accessGranted = false;
    foreach ($permissions as $permission) {
        if (isset($permission['Products']) && $permission['Products'] == "Access Granted") {
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
  // include ('./modals/pricetagsModal.php'); 
?>


	<style>

.custom-select {
        position: relative;
        display: inline-block;
    }

    .custom-select select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        padding-right: 25px;
        text-indent: 0.5em;
    }

    .custom-select i {
        position: absolute;
        top: 50%;
        right: 5px;
        transform: translateY(-50%);
    }
</style>

<?php include "layout/admin/css.php"?> 
<?php include "layout/admin/barcodeassets.php"?> 
<style>
  body{
    font-family: "Century Gothic"
  }
</style>
  <div class="container-scroller">
    <?php include 'layout/admin/sidebar.php' ?>
      <div class="main-panel" style = "overflow: hidden">
        <div class="content-wrapper">
          <div class="row not_scrollable" style = "margin-bottom: 10px; margin-top: -20px;">
            <div class="col-md-12" >
              <div id="title" class = "text-custom">
                <h1 style = "font-weight: bold">ACTIVITY LOGS</h1>

              </div>
            </div>
            <div class = "row">
                <div class = "col-md-3" style = "background-color: #151515; border-color: white;">
                  <div class="mainDiv" style = "margin-left: 25px; height: 90vh">
                  <br>
                  <div class="row">
                      <div class="custom-select">
                        <input  class="text-color" style="width: 100%; height: 30px; margin-right: 10px; text-align: center; border: 1px solid white;" id = "search_log" placeholder="Search Logs [Date&Time,User,Module,Activity]" autocomplete = "off" />
                      </div>
                    </div>
                  <br>
                    <div class="row">
                      <div class="custom-select">
                        <input  class="text-color searchProducts" style="width: 100%; height: 30px; margin-right: 10px; text-align: center;" id = "date_range" placeholder="Select Date Period" autocomplete = "off" />
                      </div>
                    </div>
                    <br>
                    <div class = "row">
                        <h5 class = "text-custom">Choose Application</h5>
                        <div class="custom-select" style="margin-right: 0px; ">
                            <select name="application" id = "application"
                                style=" background-color: #1E1C11; color: #ffff; width: 100%; border: 1px solid #ffff; font-size: 14px; height: 30px;">
                                <option value="1">Cashiering App</option>
                                <option value="2">Backend App</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class = "row">
                        <h5 class = "text-custom">Select User</h5>
                        <div class="custom-select" style="margin-right: 0px; ">
                            <select name="supplier" id = "supplier"
                                style=" background-color: #1E1C11; color: #ffff; width: 100%; border: 1px solid #ffff; font-size: 14px; height: 30px;">
                                <?php
                                  $userFacade = new UserFacade;
                                  $users = $userFacade->getCustomersData();
                                  while ($row = $users->fetch(PDO::FETCH_ASSOC)) {
                                      echo '<option value="' . $row['id'] . '">' . $row['first_name'] .' ' . $row['last_name'] . '</option>';
                                  }
                              ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class = "row">
                        <h5 class = "text-custom">Select Module</h5>
                        <div class="custom-select" style="margin-right: 0px; ">
                            <select name="supplier" id = "supplier"
                                style=" background-color: #1E1C11; color: #ffff; width: 100%; border: 1px solid #ffff; font-size: 14px; height: 30px;">
                                <option value="All">All</option>
                                <option value="Products">Products</option>
                            </select>
                        </div>
                    </div>
                  </div>
                </div>
                <div class = "col-md-9" style = "background-color: #262626;"  >
                  <div class="tableCard" style = " width: 100%; background-color: #262626; border: 1px solid white;">
                      <div class="fcontainer"  >
                          <table id="logTable" class="text-color table-border " style="margin-top: -3px; height: 300px; ">
                              <thead>
                                  <tr>
                                      <th style="background-color: none; width: 25%; font-size: 12px;">DATE & TIME</th>
                                      <th style="background-color: none; text-align:center; width: 25%; font-size: 12px;">USER</th>
                                      <th style="background-color: none; width: 25%; font-size: 12px;">MODULE</th>
                                      <th style="background-color: none; text-align:center; width: 25%; font-size: 12px;">ACTIVITY</th>
                                  </tr>
                              </thead>
                              <tbody style="border-collapse: collapse; border: none">

                              </tbody>
                          </table>
                      </div>
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
<script>
  $(document).ready(function(){
    $("#activity_logs").addClass('active');
    $("#pointer").html("Activity Logs");
 
    var ipAddress = '192.168.0.111';
    $('#search_log').on('keyup', function() {
        var value = $(this).val().toLowerCase(); 
        $('#logTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1); 
        });
    });

    function displayLogData(logText) 
    {
      var lines = logText.split('\n');
      var tableBody = $('#logTable tbody');
      tableBody.empty();

      lines.forEach(function(line) {
          var columns = line.split('|'); 
          var row = $('<tr>');

          row.append($('<td>').text(columns[0].trim())); 
          row.append($('<td>').text(columns[1].trim())); 
          row.append($('<td>').text(columns[4].trim())); 
          row.append($('<td>').text(columns[5].trim())); 
          row.append($('</tr>'));
          tableBody.append(row);
      });
    }
    function fetchData(applicationValue) {
        if (applicationValue === "1") {
            $.ajax({
                type: 'GET',
                url: 'fetch-data/log_reader.php',
                dataType: 'text',
                success: function(data) {
                    displayLogData(data); 
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });
        }
        else
        {
          $("#logTable tbody").empty();
        }
    }

    var initialApplicationValue = $("#application").val();
    fetchData(initialApplicationValue);

    $("#application").on("change", function() {
        var applicationValue = $(this).val();
        fetchData(applicationValue);
    });
  })
</script>