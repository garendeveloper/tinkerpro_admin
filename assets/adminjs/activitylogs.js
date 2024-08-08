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
