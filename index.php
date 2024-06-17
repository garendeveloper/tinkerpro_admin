<?php

include (__DIR__ . '/layout/header.php');
include (__DIR__ . '/utils/db/connector.php');
include (__DIR__ . '/utils/models/transaction-facade.php');
include (__DIR__ . '/utils/models/withdraw-facade.php');
include (__DIR__ . '/utils/models/dashboard-facade.php');

$transactionFacade = new TransactionFacade;
$withdrawFacade = new WithdrawFacade;
$dashboard = new DashboardFacade;

$userId = 0;

if (isset($_SESSION["user_id"])) {
  $userId = $_SESSION["user_id"];
}
if (isset($_SESSION["first_name"])) {
  $firstName = $_SESSION["first_name"];
}
if (isset($_SESSION["last_name"])) {
  $lastName = $_SESSION["last_name"];
}

// Redirect to login page if user has not been logged in
if ($userId == 0) {
  header("Location: login");
}

$dailyDate = date('d');
$yearlyDate = date('Y');

$janProductSales = $transactionFacade->janProductSales($yearlyDate);
$febProductSales = $transactionFacade->febProductSales($yearlyDate);
$marProductSales = $transactionFacade->marProductSales($yearlyDate);
$aprProductSales = $transactionFacade->aprProductSales($yearlyDate);
$mayProductSales = $transactionFacade->mayProductSales($yearlyDate);
$junProductSales = $transactionFacade->junProductSales($yearlyDate);
$julProductSales = $transactionFacade->julProductSales($yearlyDate);
$augProductSales = $transactionFacade->augProductSales($yearlyDate);
$sepProductSales = $transactionFacade->sepProductSales($yearlyDate);
$octProductSales = $transactionFacade->octProductSales($yearlyDate);
$novProductSales = $transactionFacade->novProductSales($yearlyDate);
$decProductSales = $transactionFacade->decProductSales($yearlyDate);

if ($janProductSales == NULL) {
  $janProductSales = 0;
}
if ($febProductSales == NULL) {
  $febProductSales = 0;
}
if ($marProductSales == NULL) {
  $marProductSales = 0;
}
if ($aprProductSales == NULL) {
  $aprProductSales = 0;
}
if ($mayProductSales == NULL) {
  $mayProductSales = 0;
}
if ($junProductSales == NULL) {
  $junProductSales = 0;
}
if ($julProductSales == NULL) {
  $julProductSales = 0;
}
if ($augProductSales == NULL) {
  $augProductSales = 0;
}
if ($sepProductSales == NULL) {
  $sepProductSales = 0;
}
if ($octProductSales == NULL) {
  $octProductSales = 0;
}
if ($novProductSales == NULL) {
  $novProductSales = 0;
}
if ($decProductSales == NULL) {
  $decProductSales = 0;
}

?>
<style>
 .col {
    /* background-color: #151515; */
    color: white;
    height: 300px;
    width: 100%;
}
  .col1 {
    color: white;
    height: 300px;
  }

  /* .header-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .button-container {
    display: flex;
  } */

  .datepicker {
    max-width: 400px;
    margin: 50px auto;
  }

  .datepicker-input {
    width: 100px;
    padding: 5px;
    margin-right: 10px;
  }

  .predefined-periods {
    margin-top: 10px;
  }

  button {
    padding: 5px 10px;
    margin-right: 5px;
    cursor: pointer;
  }

  h3 {
    color: #ffff;
  }

  .center-total h1 {
    font-size: 12em;

  }

  .center-total p {
    font-size: 1.5em;
    opacity: 1.5;
    color: gray;
    text-align: center;
  }

  .sub-title {
    margin-top: -10px;
    font-size: 1.0em;
    opacity: 1.5;
    color: gray;
  }

  .center-total {
    text-align: center;
    margin-top: auto;
    margin-bottom: auto;
  }

  .row {
    margin-bottom: 8px;
  }

  .col1 {
    display: flex;
    flex-direction: column;
    justify-content: left;
    align-items: left;
  }

  .sales-chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: -20px;
  }

  .sales-chart-header h4 {
    margin: 0;
  }

  .button-container {
    display: flex;
    align-items: center;
  }

  .button-container button,
  .button-container i {
    margin-left: 10px;
    color: white;
    background: none;
    border: none;
  }

  .button-container button:hover,
  .button-container i:hover {
    cursor: pointer;
  }

  .chart-container {
    margin-top: 20px;
    position: relative;
    height: 300px;
  }
  @media (min-width: 1400px) {
    .container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
        max-width: 2400px;
    }
}
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
.header-container {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  width: 100%;
}

.header-container h5 {
  margin: 0;
}

.header-container select {
  background-color: #262626;
  color: #fff;
  width: 120px;
  border: 1px solid #fff;
  font-size: 14px;
  height: 30px;
}
#top_products option{
  text-align:center;
}
#tbl_top_products {
  width: 100%;
  top: -20px;
  border-collapse: collapse; 
}
#tbl_top_products tr {
  border-bottom: 1px solid #ccc; 
}
#tbl_top_products td, table th {
  border: none;
  padding: 8px; 
  text-align: center; 
}
body, div, h1, h2, h3, h4, h5, p{
  font-family: Century Gothic;
}

  #hourlySalesChart {
    width: 100% !important;
    height: 200px !important;
  }
  #top_products_data {
    max-height: 200px;
    overflow-y: auto; 
}

#top_products_data table {
    width: 100%;
    border-collapse: collapse;
}

#top_products_data th, #top_products_data td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
}
.annual_total_sales h3, #total_sales_data h1{
  font-family: Century Gothic;
  font-size: 5rem; 
}

#total_sales_data h1{
  font-family: Century Gothic;
  font-size: 7rem; 
}

@media (max-width: 1200px) {
  .annual_total_sales h3, #total_sales_data h1{
    font-size: 3rem;
  }
}

@media (max-width: 992px) {
  .annual_total_sales h3, #total_sales_data h1{
    font-size: 2rem;
  }
}

@media (max-width: 768px) {
  .annual_total_sales h3, #total_sales_data h1{
    font-size: 1.5rem;
  }
}

@media (max-width: 576px) {
  .annual_total_sales h3, #total_sales_data h1{
    font-size: 0.5rem;
  }
}
#tbl_top_products td{
  height: 10px;
}
</style>
<?php include "layout/admin/css.php" ?>
<div class="container-scroller">
  <div class="main">
    <?php include "layout/admin/sidebar.php" ?>
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="container">
          <div class="row">
            <div class="col-12 col-md-9">
              <div class="border p-3 col">
                <div class="sales-chart-header">
                  <h4>Monthly Sales - <span id="d_year" style="color: #FF6700"></span></h4>
                  <div class="button-container">
                    <i class="bi bi-arrow-clockwise"></i>
                    <button id="toggle-theme">
                      <i class="bi bi-toggle-on"></i>
                    </button>
                    <i class="bi bi-chevron-left" id="prevYear"></i>
                    <i class="bi bi-chevron-right" id="nextYear"></i>
                  </div>
                </div>
                <p>Sales data grouped by month</p>
                <div class="d-flex justify-content-between align-items-center mb-3">
                <canvas id="salesChart"  style="display: block; height: 200px; width: 1200px;" class="chartjs-render-monitor"></canvas>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class="border p-3 col1" style = "height: 300px;">
                <h5>Total Sales</h5>
                <div class="center-total annual_total_sales" style = 'text-align: left;'>
         
                </div>
                <div class="center-total top_performing_month" style = 'text-align: left;'>
                  <p>No data to display</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-12">
              <h5 style="color: #ffff">Periodic Reports &nbsp;&nbsp; <span id="period_date" style="color: #FF6700; font-weight: bold">
              </span>
              <input type = "hidden" id = "per_start_date" ></input>
              <input type = "hidden" id = "per_end_date" ></input>
                <button id="btn_period" class="button">
                  <i class="bi bi-calendar" aria-hidden="true"></i>
                </button>
              </h5>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-4 ">
              <div class="border p-3 col1">
                <div class="header-container">
                  <h5>Top Products</h5>
                  <select name="top_products" id="top_products" class = "trigger_reports" style=" color: #ffff; width: 50px; border: 1px solid #ffff; font-size: 14px; height: 30px;">
                    <option>5</option>
                    <option>10</option>
                    <option>20</option>
                  </select>
                </div>
                <div class="center-total" id = "top_products_data">
                <p>No data to display</p>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="border p-3 col1">
                <div class="header-container">
                  <h5>Hourly Sales</h5>
                  <select name="hourly_sales" id="hourly_sales" class = "trigger_reports" style=" color: #ffff; width: 100px; border: 1px solid #ffff; font-size: 14px; height: 30px;">
                    <option>Amount</option>
                    <option>Count</option>
                  </select>
                </div>
                <div class="center-total" id = "hourly_sales_data">
                  <p>No data to display</p>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4 ">
              <div class="border p-3 col1">
                <h5>Total Sales <span id = "identifier" class = "trigger_reports"></span></h5>
                <div class="center-total" id = "total_sales_data" >
                  <p>No data to display</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-4">
              <div class="border p-3 col1">
                <h5>Top Product Groups</h5>
                <p class="sub-title">Top selling product groups in selected period</p>
                <div class="center-total">
                  <p>No data to display</p>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-8 ">
              <div class="border p-3 col1">
                <h5>Top Customers</h5>
                <p class="sub-title">Lead customers in selected period (top 5)</p>
                <div class="center-total">
                  <p>No data to display</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "modals/period-reports-modal.php" ?>
<?php include ("layout/footer.php") ?>
<script>
  function formatDate(date) 
  {
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
}
function setPredefinedPeriod(period) {
    const today = new Date();
    let startDate, endDate;

    switch (period) {
        case 'Today':
            startDate = endDate = today;
            break;
        case 'Yesterday':
            startDate = endDate = new Date(today.setDate(today.getDate() - 1));
            break;
        case 'This week':
            startDate = new Date(today.setDate(today.getDate() - today.getDay()));
            endDate = new Date(today.setDate(today.getDate() + (6 - today.getDay())));
            break;
        case 'Last week':
            startDate = new Date(today.setDate(today.getDate() - today.getDay() - 7));
            endDate = new Date(today.setDate(today.getDate() + 6));
            break;
        case 'This month':
            startDate = new Date(today.getFullYear(), today.getMonth(), 1);
            endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            break;
        case 'Last Month':
            startDate = new Date(today.getFullYear(), today.getMonth() - 1, 1);
            endDate = new Date(today.getFullYear(), today.getMonth(), 0);
            break;
        case 'This year':
            startDate = new Date(today.getFullYear(), 0, 1);
            endDate = new Date(today.getFullYear(), 11, 31);
            break;
        case 'Last Year':
            startDate = new Date(today.getFullYear() - 1, 0, 1);
            endDate = new Date(today.getFullYear() - 1, 11, 31);
            break;
        default:
            return;
    }

    const instance1 = document.getElementById("datepickerDiv")._flatpickr;
    const instance2 = document.getElementById("datepickerDiv2")._flatpickr;
    instance1.setDate(startDate);
    instance2.setDate(endDate);

    document.getElementById('date_selected').innerText = `${formatDate(startDate)} - ${formatDate(endDate)}`;
    $("#per_start_date").val(formatDate(startDate));
    $("#per_end_date").val(formatDate(endDate));
}

$('#datePickerClose').on('click', function () {
    $('#period_reports').hide();
});

$('#cancelDateTime').on('click', function () {
    $('#period_reports').hide();
});

flatpickr("#datepickerDiv", {
    inline: true,
    static: true,
    position: 'top',
    onChange: function (selectedDates, dateStr, instance) {
        const datepickerDiv2 = document.getElementById("datepickerDiv2");
        const instance2 = datepickerDiv2._flatpickr;
        instance2.set("minDate", selectedDates[0]);

        const startDate = selectedDates[0];
        const endDate = instance2.selectedDates[0] || startDate;
        document.getElementById('date_selected').innerText = `${formatDate(startDate)} - ${formatDate(endDate)}`;
    }
});

flatpickr("#datepickerDiv2", {
    inline: true,
    static: true,
    position: 'top',
    onChange: function (selectedDates, dateStr, instance) {
        const datepickerDiv = document.getElementById("datepickerDiv");
        const instance1 = datepickerDiv._flatpickr;
        instance1.set("maxDate", selectedDates[0]);

        const endDate = selectedDates[0];
        const startDate = instance1.selectedDates[0] || endDate;
        document.getElementById('date_selected').innerText = `${formatDate(startDate)} - ${formatDate(endDate)}`;
    }
});

$('.custom_btns').on('click', function () {
  var buttonText = $(this).text();
  setPredefinedPeriod(buttonText);  
});

</script>
<script>
  $(document).ready(function () {
    var totalSales = 0;
    var totalCount = 0;

    $(".trigger_reports").hide();


    $("#top_products").on("change", function(){
      var item = $(this).val();
      show_allTopProducts(item);
    })
    function formatAmount(amount) 
    {
      if (amount >= 1e9) {
          return (amount / 1e9).toFixed(2) + 'B';
      } else if (amount >= 1e6) {
          return (amount / 1e6).toFixed(2) + 'M';
      } else if (amount >= 1e3) {
          return (amount / 1e3).toFixed(2) + 'K';
      } else {
          return amount.toFixed(2);
      }
    }
   
    function show_allTopProducts(item)
    {
      var start_date = $("#per_start_date").val();
      var end_date = $("#per_end_date").val();

      totalSales = 0;
      totalCount = 0;
      $.ajax({
        type: 'get',
        url: 'api.php?action=get_allTopProducts',
        data: {
          item: item,
          start_date: start_date,
          end_date: end_date,
        },
        success: function(data)
        {
          if(data['data'].length > 0)
          {
              var tblRows = [];
            for (var i = 0, len = data['data'].length; i < len; i++) 
            {
              var currentItem = data['data'][i];
              tblRows.push(
                  `<tr>
                        <td style = 'text-align: left'>${currentItem.product}</td>
                        <td style = 'text-align: right'>${formatNumberWithCommasAndDecimals(currentItem.total_paid_amount)}</td>
                      </td>
                    </tr>`
                );
                totalSales += currentItem.total_paid_amount;
                totalCount = i+1;
            }

            var tblData = `
            <table  id = "tbl_top_products" class='' style='font-size: 10px;'>
                <thead>
                    <tr>
                        <th style = 'text-align: left; background-color: #8f3900'>Product.</th>
                        <th style = 'text-align: center; background-color: #7f160b'>Total</th>
                    </tr>
                </thead>
                <tbody>
                    ${tblRows.join('')}
                </tbody>
            </table>`;
            $("#top_products_data").html(tblData);
          }
          else
          {
            $("#top_products_data").html('<p>No data to display</p>');
          }
        }
      })
  }
  function show_allTotalSales(identifier)
  {
    if(identifier == "Count")
    {
      $("#total_sales_data").html("<h1>"+totalCount+"</h1>");
    }
    if(identifier == "Amount")
    {
      $("#total_sales_data").html("<h1>"+formatAmount(totalSales)+"</h1>");
    }
    $("#identifier").html("("+identifier+")");
  }
    function show_hourlySalesChart()
    {
      var start_date = $("#per_start_date").val();
      var end_date = $("#per_end_date").val();

     
      axios.get('api.php?action=get_salesDataByHour&start_date=' + start_date + '&end_date='+end_date)
          .then(function (response) {
              const salesData = response.data.salesData;
              if(salesData !== 0)
              {
                show_allTotalSales($("#hourly_sales").val());
                $("#hourly_sales_data").html('<canvas id="hourlySalesChart"  style="height: 50px; width: 50px;" class="chartjs-render-monitor"></canvas>');
                const labels = response.data.labels;
                const ctx = document.getElementById('hourlySalesChart').getContext('2d');

                const colors = [
                    'rgba(255, 99, 132, 0.6)',  
                    'rgba(54, 162, 235, 0.6)',  
                    'rgba(255, 206, 86, 0.6)',  
                    'rgba(75, 192, 192, 0.6)',  
                    'rgba(153, 102, 255, 0.6)', 
                    'rgba(255, 159, 64, 0.6)',  
                    'rgba(199, 199, 199, 0.6)', 
                    'rgba(83, 102, 255, 0.6)',  
                    'rgba(99, 255, 132, 0.6)',  
                    'rgba(235, 54, 162, 0.6)',  
                    'rgba(206, 255, 86, 0.6)',  
                    'rgba(192, 192, 75, 0.6)'   
                ];

                const chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Sales (₱)',
                            data: salesData,
                            backgroundColor: colors, 
                            borderColor: colors.map(color => color.replace('0.6', '1')), 
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                grid: {
                                    color: 'blue',
                                }
                            }
                        }
                    }
                });
              }
              else
              {
                $("#hourly_sales_data").html('<p>No data to display</p>');
                $("#total_sales_data").html('<p>No data to display</p>');
              }
              
          })
          .catch(function (error) {
              console.error('Error fetching sales data:', error);
          });
    }
    $("#hourly_sales").on("change", function(){
      var identifier = $(this).val();
      show_hourlySalesChart();
      show_allTotalSales(identifier);
    })
    $("#btn_datePeriodSelected").on('click',function(){
      var date_period_selected = $("#date_selected").text();
      $("#period_date").html(date_period_selected);
      $("#period_reports").hide();
      $(".trigger_reports").show();
      var period_date = $("#period_date").html().trim();
      if(period_date !== "")
      {
        show_allTopProducts(5);
        show_hourlySalesChart();
      }
      
    })
    $("#cancelDateTime").on('click',function(){
      $("#period_date").html("");
      $("#period_reports").hide();
      $(".trigger_reports").hide();
    })


    $("#index").addClass('active');
    $("#pointer").html("Dashboard");
    let year = new Date().getFullYear();
    $("#d_year").html(year);
    updateChart(year);
    $('#nextYear').click(function () {
      year++;
      updateChart(year);
    });
    $('#prevYear').click(function () {
      year--;
      updateChart(year);
    });
    function formatNumberWithCommasAndDecimals(number) {
        return number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
    function updateChart(year) 
    {
      $("#d_year").html(year);
      axios.get('api.php?action=get_salesData&year=' + year)
          .then(function (response) {
              const salesData = response.data.salesData;
              const months = response.data.months;
              const annual_sales = response.data.annual_sales;
              const top_month = annual_sales === 0 ? "---" : response.data.top_month;
              const top_month_value = response.data.top_month_value;

              $(".annual_total_sales").html("<h3 style='font-family: Century Gothic;'>" + formatAmount(annual_sales) + "</h3>");
              $(".top_performing_month").html("<h4 style='color: #d9f500; font-size: 1rem'>Top Performing Month</h4>" +
                  "<h4>" + top_month + "</h4>" +
                  "<h4>" + formatNumberWithCommasAndDecimals(top_month_value) + "</h4>");

              const ctx = document.getElementById('salesChart').getContext('2d');

              const colors = [
                  'rgba(255, 99, 132, 0.6)',  
                  'rgba(54, 162, 235, 0.6)',  
                  'rgba(255, 206, 86, 0.6)',  
                  'rgba(75, 192, 192, 0.6)',  
                  'rgba(153, 102, 255, 0.6)', 
                  'rgba(255, 159, 64, 0.6)',  
                  'rgba(199, 199, 199, 0.6)', 
                  'rgba(83, 102, 255, 0.6)',  
                  'rgba(99, 255, 132, 0.6)',  
                  'rgba(235, 54, 162, 0.6)',  
                  'rgba(206, 255, 86, 0.6)',  
                  'rgba(192, 192, 75, 0.6)'   
              ];

              const chart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels: months,
                      datasets: [{
                          label: 'Sales (₱)',
                          data: salesData,
                          backgroundColor: colors, 
                          borderColor: colors.map(color => color.replace('0.6', '1')), 
                          borderWidth: 1
                      }]
                  },
                  options: {
                      scales: {
                          x: {
                              grid: {
                                  display: false
                              }
                          },
                          y: {
                              grid: {
                                  color: 'blue',
                              }
                          }
                      }
                  }
              });
          })
          .catch(function (error) {
              console.error('Error fetching sales data:', error);
          });
    }
    $("#btn_period").click(function (e) {
      e.preventDefault();
      $("#period_reports").slideDown({
        backdrop: 'static',
        keyboard: false,
      });
    })
  });
</script>