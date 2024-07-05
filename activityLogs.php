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


    .custom-select select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        text-indent: 0.5em;
    }

    .custom-select i {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
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
    border: 1px solid #262626;
    padding: 8px; 
}
.fcontainer::-webkit-scrollbar {
    width: 1px; 
    margin-right: 200px;
}

.f-container::-webkit-scrollbar-thumb {
    background-color: #151515; 
    border-radius: 4px; 
}
</style>

<?php include "layout/admin/css.php"?> 
<?php include "layout/admin/barcodeassets.php"?> 
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
    border-color: #FF6900;
    font-size: 10px;
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
                <div class = "" style = "background-color: #151515; border-color: white; width: 12%">
                  <div class="mainDiv" style = "margin-left: 25px; height: 90vh">
                  <br>
                    <div class="row">
                      <div class="custom-select">
                          <div class="date-input-container">
                            <input type="text" name="dateRange"  style="width: 100%; height: 30px; text-align: center;" id="dateRange" placeholder="Select date" autocomplete = "off">
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class = "row">
                        <h5 class = "text-custom">Choose Application</h5>
                        <div class="custom-select" style="margin-right: 0px; ">
                            <select name="application" id = "application"
                                style=" background-color: #1E1C11; color: #ffff; width: 100%; border: 1px solid #ffff; font-size: 14px; height: 30px;">
                                <option value="1">Cashiering App</option>
                                <option value="2">BackOffice App</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class = "row">
                        <h5 class = "text-custom">Select User</h5>
                        <div class="custom-select" style="margin-right: 0px; ">
                            <select name="user" id = "user"
                                style=" background-color: #1E1C11; color: #ffff; width: 100%; border: 1px solid #ffff; font-size: 14px; height: 30px;">
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
                    <!-- <br>
                     <div class = "row">
                        <div class="custom-select" style="margin-right: 0px; ">
                          <button class = "button" style = "width: 100%; background-color: #ccc; height: 30px;" id = "downloadFile"> Download File</button>
                        </div>
                    </div> -->
                  </div>
                </div>
                <div class = "col-md-11" style = "background-color: #262626; width: 88%"  >
                    <div class="tableCard" style = " width: 100%; background-color: #262626;  ">
                      <table  class="text-color table-border" style="margin-top: -3px; ">
                        <thead>
                          <tr >
                            <th colspan = "5" class = "otherinput">
                              <input  class="text-color" style="width: 100%; height: 30px;" id = "search_log" placeholder="Search Logs [Date&Time,User,Module,Activity]" autocomplete = "off" autofocus="autofocus"/>
                            </th>
                          </tr>
                        </thead>
                        <thead>
                            <tr>
                                <th style="background-color: none; width: 15%; font-size: 12px;">DATE & TIME</th>
                                <th style="background-color: none; text-align:center; width: 15%; font-size: 12px;">USER</th>
                                <th style="background-color: none; text-align:center; width: 15%; font-size: 12px;">ROLE</th>
                                <th style="background-color: none; width: 15%; font-size: 12px;">MODULE</th>
                                <th style="background-color: none; text-align:center; width: 40%; font-size: 12px;">ACTIVITY</th>
                            </tr>
                        </thead>
                      </table>
                      <div class="fcontainer"  >
                          <table id="logTable" class="text-color table-border" style="margin-top: -3px; height: 300px; padding:10px;">
                              <tbody style="border-collapse: collapse; border: none">

                              </tbody>
                          </table>
                      </div>
                    </div> 
                    <button class = "button" style = "width: 100%; background-color: #ccc; height: 30px;" id = "downloadFile"> Download File</button>
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
 

    $('#downloadFile').on('click', function() {
      var applicationType = $("#application").val() === "1" ? "Cashiering_Logs" : "Back_Office_Logs";
      var tableData = '';
      $('#logTable tbody tr:visible').each(function(index, row) {
          $(row).find('td').each(function(index, col) {
              tableData += $(col).text().trim() + '\t';
          });
          tableData = tableData.slice(0, -1) + '\n';
      });

      var blob = new Blob([tableData], { type: 'text/plain' });
      var url = window.URL.createObjectURL(blob);

      var link = $('<a></a>');
      link.attr('href', url);
      link.attr('download', applicationType + ".txt");

      $('body').append(link);
      link[0].click();

      $(link).remove();
      window.URL.revokeObjectURL(url);
    });

    $('#dateRange').datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: 'M d, yy', 
      onSelect: function(selectedDateText, inst) {
        var date = new Date(selectedDateText);
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        var year = date.getFullYear(); 
        var month = months[date.getMonth()]; 
        var day = date.getDate();

        var selectedDate = month + ' ' + day + ', ' + year;
        
        var selectedUser = $('#user').val();
        filterTable(selectedDate, selectedUser);
      }
    });

    $("#user").on("change", function(){
      var selectedDate = $('#dateRange').val();
        var selectedUser = $(this).val();
        filterTable(selectedDate, selectedUser);
    })
    function filterTable(selectedDate, selectedUser) 
    {
      $('#logTable tbody tr').each(function() {
          const rowDate = $(this).find('td:first').text().trim();
          const rowUser = $(this).find('td:eq(1)').text().trim(); 
          const rowDateObj = new Date(rowDate);
          const formattedRowDate = rowDateObj.toLocaleDateString('en-US', {
              month: 'short',
              day: 'numeric',
              year: 'numeric'
          });

          if ((formattedRowDate !== selectedDate) || (rowUser !== selectedUser)) {
              $(this).hide();
          } else {
              $(this).show();
          }
      });
    }

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
          line = line.trim();
          if (line) 
          {
              var columns = line.split('|');
              if (columns.length >= 6) 
              {
                var role = columns[3].trim() || '';
                var datetime = columns[0].trim() || '';
                if(datetime !== '') datetime = formatDateToAMPM(datetime);
                
                if(role === "1") role = "Super Admin";
                if(role === "2") role = "Admin";
                if(role === "3") role = "Cashier";

                var row = $('<tr>');
                row.append($('<td style = "width: 15%">').text(datetime));
                row.append($('<td style = "width: 15%">').text(columns[1].trim() || ''));
                row.append($('<td style = "width: 15%">').text(role));
                row.append($('<td style = "width: 15%">').text(columns[4].trim() || ''));
                row.append($('<td style = "width: 40%">').text(columns[5].trim() || '')); 

                tableBody.append(row);
              } else {
                  console.error('Line does not have enough columns:', line);
              }
          }
      });
    }
    function formatDateToAMPM(datetimeString) 
    {
        var date = new Date(datetimeString);
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var seconds = date.getSeconds();

        var period = hours >= 12 ? 'PM' : 'AM';

        hours = hours % 12;
        hours = hours ? hours : 12;

        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        var formattedTime = hours + ':' + minutes + ':' + seconds + ' ' + period;
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        var formattedDate = monthNames[(date.getMonth())] + ' ' + date.getDate() + ', ' + date.getFullYear();
        return formattedDate + ' ' + formattedTime;
    }
    function fetchData(applicationValue) {
      $("#logTable tbody").empty();
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
          $.ajax({
                type: 'GET',
                url: './assets/logs/logs.txt',
                dataType: 'text',
                success: function(data) {
                    displayLogData(data); 
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });
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