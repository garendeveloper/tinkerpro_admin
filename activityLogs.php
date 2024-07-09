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
  include('./modals/logDatePickerModal.php');
  // include ('./modals/pricetagsModal.php'); 
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
    /* border: 1px solid #dddddd;  */
    border: none;
    padding: 2px 2px; 
    height: 5px; 
    line-height:2;
}
#searchHead th{
    /* border: 1px solid #dddddd;  */
    border: none;
    padding: 2px 2px; 
    height: 3px; 
    line-height:1;
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
.highlighted {
  background-color: #DB7093;
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
</style>
  <div class="container-scroller">
    <?php include 'layout/admin/sidebar.php' ?>
      <div class="main-panel" style = "overflow: hidden">
        <div class="content-wrapper">
          <div class="row not_scrollable" style = "margin-bottom: 10px; ">
            <div class="col-md-12" >
              <div id="title" class = "text-custom">
                <h1 style = "font-weight: bold">ACTIVITY LOGS</h1>

              </div>
            </div>
            <div class = "row">
                <div class = "" style = "background-color: #151515; border-color: white; width: 15%">
                  <div class="mainDiv" style = "margin-left: 15px; height: 90vh">
                  <br>
                    <div class="row">
                      <h6 class = "text-custom">Select Date</h6>
                      <div class="custom-select">
                        <a  href="#"  class="custom-input" id="btn_datePicker" style="margin-top: 5px">
                            <input readonly type="text" id="datepicker" style="padding-left: 35px; flex: 1; text-align: center; height: 30px; font-size: 11px;">
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
                            <select name="application" id = "application"
                                style=" background-color: #1E1C11; color: #ffff; width: 100%; border: 1px solid #ffff; font-size: 14px; height: 30px;">
                                <option value="1">Cashiering App</option>
                                <option value="2">BackOffice App</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class = "row">
                        <h6 class = "text-custom">Select User</h6>
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
                    <br>
                    <div class = "row">
                        <div class="custom-select" style="margin-right: 0px; ">
                             <button style = "height: 30px; border-radius: 10px; font-size: 0.9rem; width: 100%" id = "btn_reload"><i class = "bi bi-arrow-clockwise"></i> Reload</button>
                        </div>
                     </div>
                  </div>
                </div>
                <div class = "col-md-11" style = "background-color: #262626; width: 85%"  >
                    <div class="tableCard" style = " width: 100%; background-color: #262626;  ">
                      <table  class="text-color " style="margin-top: -3px; ">
                        <thead id = "searchHead" class = "th-noborder">
                          <tr >
                            <th colspan = "4" class = "inputGray th-noborder">
                              <input  class="text-color " style="width: 100%; height: 20px;" id = "search_log" placeholder="Search Logs [Date&Time,User,Module,Activity]" autocomplete = "off" autofocus="autofocus"/>
                            </th>
                            <th class = "otherinput th-noborder">
                            
                            <button  id="searchBtn" name="productSearch"  class="btn-control" style="margin-right:10px; width:100%; border-radius: none "><svg width="30px"version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                viewBox="0 0 491.52 491.52" xml:space="preserve">
                              <ellipse style="opacity:0.5;fill:#27A2DB;enable-background:new    ;" cx="158.537" cy="158.536" rx="129.777" ry="129.777"/>
                              <path style="opacity:0.5;fill:#FFFFFF;enable-background:new    ;" d="M98.081,234.62c-43.316-43.315-43.882-112.979-1.264-155.595
                                c9.509-9.511,20.41-16.745,32.021-21.96c-16.497,4.812-32.056,13.702-45.064,26.71c-41.288,41.289-41.289,108.231,0,149.521
                                c18.282,18.281,41.596,28.431,65.483,30.523C130.561,258.986,112.79,249.33,98.081,234.62z"/>
                              <path style="fill:#3A556A;" d="M270.636,46.433c-61.912-61.912-162.291-61.911-224.202,0.001s-61.912,162.291-0.001,224.202
                                c57.054,57.054,146.703,61.394,208.884,13.294l14.18,14.182l28.615-28.613l-14.182-14.182
                                C332.029,193.137,327.69,103.487,270.636,46.433z M250.301,250.302c-50.681,50.681-132.852,50.681-183.534,0
                                c-50.68-50.681-50.68-132.852,0.002-183.533s132.85-50.681,183.531,0C300.982,117.45,300.982,199.621,250.301,250.302z"/>
                              <path style="fill:#E56353;" d="M305.823,258.865l-46.959,46.958c-2.669,2.67-2.669,6.996,0,9.665l174.339,174.338
                                c12.132,12.133,68.755-44.49,56.623-56.623L315.488,258.865C312.819,256.196,308.493,256.196,305.823,258.865z"/>
                              <g>
                              <rect x="409.379" y="442.628" transform="matrix(-0.7071 0.7071 -0.7071 -0.7071 1084.9951 449.4294)" style="fill:#EBF0F3;" width="80.077" height="13.594"/>
                              <rect x="260.671" y="293.889" transform="matrix(-0.7071 0.7071 -0.7071 -0.7071 725.9606 300.6683)" style="fill:#EBF0F3;" width="80.077" height="13.594"/>
                                  </g>
                                  </svg>&nbsp;Search</button>
                            </th>
                          </tr>
                        </thead>
                        <thead id = "logHead">
                            <tr >
                                <th class = "th-noborder" style="background-color: none;  border: none; width: 15%; font-size: 12px; text-align: left">DATE & TIME</th>
                                <th class = "th-noborder" style="background-color: none; text-align:center; width: 15%; font-size: 12px; text-align: left">USER</th>
                                <th class = "th-noborder" style="background-color: none; text-align:center; width: 10%; font-size: 12px; text-align: left">ROLE</th>
                                <th class = "th-noborder" style="background-color: none; width: 15%; font-size: 12px; text-align: left">MODULE</th>
                                <th  class = "th-noborder"  style="background-color: none; text-align:center; width: 50%; font-size: 12px; text-align: left">ACTIVITY</th>
                            </tr>
                        </thead>
                      </table>
                      <div class="fcontainer"  >
                          <table id="logTable" class="text-color " style="margin-top: -3px; height: 300px; padding:10px;">
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
<script>
  

  $(document).ready(function(){
    $("#activity_logs").addClass('active');
    $("#pointer").html("Activity Logs");

    var initialApplicationValue = $("#application").val();
   

    $("#logTable tbody").on("click", "tr", function() {
        $("#logTable tbody tr").removeClass('highlighted');
      
      $(this).addClass('highlighted');
    });
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

    $("#btn_datePicker").off("click").on("click", function(){
      $('#dateTimeModal').show()
      $('.predefinedDates').val("");
   })

   $('.okBtnDates').off('click').on('click', function() {
      var selectedDatePre = document.getElementById("predefinedDates").value;
      var predefinedDouble = document.getElementById("predefinedDouble").value;

      var dateFrom = document.getElementById("datepickerDiv").value;
      var dateTo = document.getElementById("datepickerDiv2").value;

      if (selectedDatePre !== "" || predefinedDouble !== "" || dateFrom !== "" || dateTo !== "") {
          if (selectedDatePre !== "" && predefinedDouble === "") {
              var date = new Date(selectedDatePre);
              const formattedDateSelected = date.toLocaleDateString("en-PH", {
                  year: "numeric",
                  month: "short",
                  day: "2-digit"
              });
              document.getElementById('datepicker').value = formattedDateSelected;
          } else if (selectedDatePre === "" && predefinedDouble !== "") {
              var dates = predefinedDouble.split(" - ");
              var startDateString = dates[0];
              var endDateString = dates[1];

              var startDate = new Date(startDateString);
              var formattedStartDate = startDate.toLocaleDateString("en-PH", {
                  year: "numeric",
                  month: "short",
                  day: "2-digit"
              });

              var endDate = new Date(endDateString);
              var formattedEndDate = endDate.toLocaleDateString("en-PH", {
                  year: "numeric",
                  month: "short",
                  day: "2-digit"
              });

              var formattedDates = formattedStartDate + " - " + formattedEndDate;
              document.getElementById('datepicker').value = formattedDates;
          } else {
            var dateFrom = new Date(document.getElementById("datepickerDiv").value);
            var dateTo = new Date(document.getElementById("datepickerDiv2").value);
              const formattedDateFrom = dateFrom.toLocaleDateString("en-PH", {
                  year: "numeric",
                  month: "short",
                  day: "2-digit"
              });
              const formattedDateTo = dateTo.toLocaleDateString("en-PH", {
                  year: "numeric",
                  month: "short",
                  day: "2-digit"
              });

              var selectedDates = formattedDateFrom + " - " + formattedDateTo;
              document.getElementById('datepicker').value = selectedDates;
          }
      } else {
          document.getElementById('datepicker').value = "";
      }

      $('#dateTimeModal').hide();
      $('.predefinedDates').val("");
      $('.predefinedDouble').val("");
      clearFields();

      var selectedDate = $("#datepicker").val();
      var selectedUser = $('#user').val();
      filterTable(selectedDate, selectedUser);

  });



    $("#user").on("change", function(){
        var selectedDates = $('#datepicker').val();
        var selectedUser = $(this).val();
        filterTable(selectedDates, selectedUser);
    });
    $("#searchBtn").off("click").on("click", function(){
      var selectedDates = $('#datepicker').val();
      var selectedUser = $("#user").val();
      filterTable(selectedDates, selectedUser);
    })
    function filterTable(selectedDates, selectedUser) {
      if (!selectedDates || selectedDates.trim() === '') {
          $('#logTable tbody tr').show();
          return;
      }

      if (selectedDates.indexOf(" - ") === -1) {
          filterSingleDate(selectedDates, selectedUser);
      } else {
          filterDateRange(selectedDates, selectedUser);
      }
    }

    function filterSingleDate(selectedDate, selectedUser) {
        var date = new Date(selectedDate);
        var endDate = new Date(date);
        endDate.setDate(date.getDate() + 1);

        const lowerCaseSelectedUser = selectedUser ? selectedUser.toLowerCase() : '';

        $('#logTable tbody tr').each(function() {
            const rowDate = $(this).find('td:first').text().trim();
            const rowUser = $(this).find('td:eq(1)').text().trim();
            const rowDateObj = new Date(rowDate);

            const lowerCaseRowUser = rowUser.toLowerCase();

            if (!rowUser || rowUser.trim() === '') {
                $(this).hide();
                return;
            }

            const isWithinRange = rowDateObj >= date && rowDateObj < endDate;

            if ((!lowerCaseSelectedUser || lowerCaseRowUser === lowerCaseSelectedUser) && isWithinRange) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    function filterDateRange(selectedDates, selectedUser) {
        var dateRange = selectedDates.split(" - ");
        var startDate = new Date(dateRange[0]);
        var endDate = new Date(dateRange[1]);
        endDate.setDate(endDate.getDate() + 1);

        const lowerCaseSelectedUser = selectedUser ? selectedUser.toLowerCase() : '';

        $('#logTable tbody tr').each(function() {
            const rowDate = $(this).find('td:first').text().trim();
            const rowUser = $(this).find('td:eq(1)').text().trim();
            const rowDateObj = new Date(rowDate);

            const lowerCaseRowUser = rowUser.toLowerCase();

            if (!rowUser || rowUser.trim() === '') {
                $(this).hide();
                return;
            }

            const isWithinRange = rowDateObj >= startDate && rowDateObj < endDate;

            if ((!lowerCaseSelectedUser || lowerCaseRowUser === lowerCaseSelectedUser) && isWithinRange) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
    $("#btn_reload").on("click", function(){
      $("#datepicker").val("");
      $("#user").val("");
      var initialApplicationValue = $("#application").val();
      fetchData(initialApplicationValue);
    })

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
                row.append($('<td style = "width: 15%; ">').text(datetime));
                row.append($('<td style = "width: 15%">').text(columns[1].trim() || ''));
                row.append($('<td style = "width: 10%">').text(role));
                row.append($('<td style = "width: 15%">').text(columns[4].trim() || ''));
                row.append($('<td style = "width: 50%">').text(columns[5].trim() || '')); 

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
      
      hours = hours < 10 ? '0' + hours : hours;
      minutes = minutes < 10 ? '0' + minutes : minutes;
      seconds = seconds < 10 ? '0' + seconds : seconds;

      var formattedTime = hours + ':' + minutes + ':' + seconds + ' ' + period;

      const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
      var formattedDay = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
      var formattedDate = monthNames[date.getMonth()] + ' ' + formattedDay + ', ' + date.getFullYear();

      return formattedDate + ' ' + formattedTime;
  }
    function fetchData(applicationValue) 
    {
      $('#modalCashPrint').show();
      $("#logTable tbody").empty();
        if (applicationValue === "1") {
            $.ajax({
                type: 'GET',
                url: 'fetch-data/log_reader.php',
                dataType: 'text',
                success: function(data) {
                    displayLogData(data); 
                    $('#modalCashPrint').hide();
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
                    $('#modalCashPrint').hide();
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });
        }
    }

    fetchData(initialApplicationValue);

    $("#application").on("change", function() {
        var applicationValue = $(this).val();
        $("#datepicker").val("");
        $("#user").val();
        fetchData(applicationValue);
    });
  })
</script>