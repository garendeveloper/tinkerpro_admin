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
                            <input readonly type="text" id="datepicker" style="padding-left: 35px; background: transparent !important; border-radius: 10px; text-align: center; height: 35px; border: 1px solid var(--border-color) !important;">
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

    var toastDisplayed = false;
    $("#activity_logs").addClass('active');
    $("#pointer").html("Activity Logs");

    var initialApplicationValue = $("#application").val();
    function getPHTDateTime() 
    {
      const now = new Date();
      const options = {
        timeZone: 'Asia/Manila',
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false 
      };
      const formatter = new Intl.DateTimeFormat('en-PH', options);
      return formatter.format(now).replace(/[/\s:]/g, '_');
    }

   

    $("#logTable tbody").on("click", "tr", function() {
        $("#logTable tbody tr").removeClass('highlighted-row');

      $(this).addClass('highlighted-row');
    });
    $('#downloadFile').on('click', function() {
      var applicationType = $("#application").val() === "1" ? "Cashiering_Logs_"+getPHTDateTime() : "Back_Office_Logs_"+getPHTDateTime();
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

      show_response(`File "${applicationType}.txt" has been downloaded. Check your Downloads folder.`, 1)
    });

    $("#btn_datePicker").off("click").on("click", function(){
      $('#period_reports').fadeIn(200)
   })
  function formatDates(dateStr) 
  {
    const parts = dateStr.split('/');
    const date = new Date(parts[2], parts[1] - 1, parts[0]);
    const options = {
      timeZone: 'Asia/Manila',
      year: 'numeric',
      month: 'short',
      day: '2-digit'
    };
    return new Intl.DateTimeFormat('en-PH', options).format(date);
  }
  function convertDateRange(dateRange) 
  {
    const [startDateStr, endDateStr] = dateRange.split(' - ');
    const startFormatted = formatDates(startDateStr);
    const endFormatted = formatDates(endDateStr);
    return `${startFormatted} - ${endFormatted}`;
  }
  $("#btn_datePeriodSelected").on("click", function(){
    var date_selected = $("#date_selected").text();
    $("#date_range").val(date_selected);
    $("#period_reports").hide();
    $("#datepicker").val(convertDateRange(date_selected))
    var selectedDate = $("#datepicker").val();
    var selectedUser = $('#user').val();
    filterTable(selectedDate, selectedUser);
  })

  function show_response(message, type) 
  {
      if (toastDisplayed) {
          return; 
      }

      toastDisplayed = true; 

      toastr.options = {
          "onShown": function () {
              $('.custom-toast').css({
                  "opacity": 1,
                  "width": "600px",
                  "text-align": "center",
                  "border": "1px solid #1E1C11",
              });
          },
          "onHidden": function () {
              toastDisplayed = false; 
          },
          "closeButton": true,
          "positionClass": "toast-top-right",
          "timeOut": "3500",
          "extendedTimeOut": "1000",
          "progressBar": true,
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut",
          "tapToDismiss": false,
          "toastClass": "custom-toast",
          "onclick": function () { 
              toastr.clear();
              toastDisplayed = false;
              }
      };

      type === 1 ? toastr.success(message) : toastr.error(message);
  }


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
          // $('#logTable tbody tr').show();
          // return;
          const lowerCaseSelectedUser = selectedUser ? selectedUser.toLowerCase() : '';

        $('#logTable tbody tr').each(function() {
            const rowUser = $(this).find('td:eq(1)').text().trim();
            const lowerCaseRowUser = rowUser.toLowerCase();

            if ((!lowerCaseSelectedUser || lowerCaseRowUser === lowerCaseSelectedUser)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

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

                tableBody.prepend(row);
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
                  console.log(data)
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
  
</script>