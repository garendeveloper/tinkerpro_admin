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
if (isset($_SESSION["role_id"])) {
  $role_id = $_SESSION["role_id"];
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
    max-height: 300px;
    overflow-y: auto; 
}

#top_products_data::-webkit-scrollbar {
    width: 6px; 
}
#top_products_data::-webkit-scrollbar-track {
    background: #151515;
}
#top_products_data::-webkit-scrollbar-thumb {
    background: #888; 
    border-radius: 20px; 
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
.annual_total_sales h3, .annual_total_expenses h3, #total_sales_data h1{
  font-family: Century Gothic;
  font-size: 3rem; 
}

#total_sales_data h1{
  font-family: Century Gothic;
  font-size: 6rem; 
}
#net_income h1{
  font-family: Century Gothic;
  font-size: 4.5rem; 
}
.topValue{
  font-size: 1rem;
}
@media (max-width: 1200px) {
  .annual_total_sales h3, .annual_total_expenses h3, #total_sales_data h1{
    font-size: 2.5rem;
  }
  .topValue{
    font-size: 0.7rem;
  }
  #net_income h1{
    font-family: Century Gothic;
    font-size: 3.5rem; 
  }
}

@media (max-width: 992px) {
  .annual_total_sales h3, .annual_total_expenses h3, #total_sales_data h1{
    font-size: 2rem;
  }
  .topValue{
    font-size: 0.5rem;
  }
  #net_income h1{
    font-family: Century Gothic;
    font-size: 2.5rem; 
  }
}

@media (max-width: 768px) {
  .annual_total_sales h3, .annual_total_expenses h3, #total_sales_data h1{
    font-size: 1.5rem;
  }
  .topValue{
    font-size: 0.3rem;
  }
  #net_income h1{
    font-family: Century Gothic;
    font-size: 1.5rem; 
  }
}

@media (max-width: 576px) {
  .annual_total_sales h3, .annual_total_expenses h3, #total_sales_data h1{
    font-size: 0.5rem;
  }
  .topValue{
    font-size: 0.1rem;
  }
  #net_income h1{
    font-family: Century Gothic;
    font-size: 0.5rem; 
  }
}
#tbl_top_products td{
  height: 10px;
}
.dashboard-button:hover{
  color: var(--primary-color);
}
.table-responsive{
  overflow: auto;
}
.p-icon:hover{
  color: var(--primary-color);
}
.main-panel::-webkit-scrollbar {
    width: 6px; 
}
.main-panel::-webkit-scrollbar-track {
    background: #151515;
}
.main-panel::-webkit-scrollbar-thumb {
    background: #888; 
    border-radius: 20px; 
}

.table-responsive::-webkit-scrollbar {
    width: 6px; 
}
.table-responsive::-webkit-scrollbar-track {
    background: #151515;
}
.table-responsive::-webkit-scrollbar-thumb {
    background: #888; 
    border-radius: 20px; 
}
</style>
<?php include "layout/admin/css.php" ?>
<div class="container-scroller" style = "background-color: #262626">
  <div class="main" >
    <?php include "layout/admin/sidebar.php" ?>
    <div class="main-panel" >
      <div class="content-wrapper" id = "dashboard_content">
      <input hidden type="text" id="userId" value="<?php echo isset($userId) ? htmlspecialchars($userId) : ''; ?>">
      <input hidden type="text" id="firstName" value="<?php echo isset($firstName) ? htmlspecialchars($firstName) : ''; ?>">
      <input hidden type="text" id="lastName" value="<?php echo isset($lastName) ? htmlspecialchars($lastName) : ''; ?>">
      <input hidden type="text" id="roleId" value="<?php echo isset($role_id) ? htmlspecialchars($role_id) : ''; ?>">

        <div class="container">
          <div class="row">
            <div class="col-12 col-md-8">
              <div class="border p-3 col">
                <div class="sales-chart-header">
                  <h4>Monthly Sales | Expenses - <span id="d_year" style="color: var(--primary-color)"></span></h4>
                  <div class="button-container">
                    <i class="bi bi-arrow-clockwise dashboard-button" id = "btn_refresh_dashboard"></i>
                    <i class="bi bi-chevron-left dashboard-button" id="prevYear"></i>
                    <i class="bi bi-chevron-right dashboard-button" id="nextYear"></i>
                  </div>
                </div>
                <p>Sales & Expenses data grouped by month</p>
                <div class="d-flex justify-content-between align-items-center mb-3">
                <canvas id="salesChart"  style="display: block; height: 200px; width: 1200px;" class="chartjs-render-monitor"></canvas>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="border p-3 col1" style = "height: 300px;">
                <h5>Total Annual (Sales & Expenses )</h5>
                <div class = "d-flex mb-4 align-items-center" style = "justify-content: space-between;">
                  <div class="center-total annual_total_sales" style = 'text-align: left;'>
          
                  </div>
                  <div class="center-total annual_total_expenses" style = 'text-align: right;'>
            
                  </div>
                </div>
                <div class = "d-flex justify-content-between" style = "margin-top: 70px">
                  <div class="center-total top_performing_month" style = "text-align: left">
                    <p>No data to display</p>
                  </div>
                  <div class="center-total top_expensive_month" style = "text-align: right" >
                    <p>No data to display</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row exclude">

            <div class="col-12 col-md-8 ">
              <h5 style="color: #ffff">Periodic Reports &nbsp;&nbsp; <span id="period_date" style="color: var(--primary-color); font-weight: bold">
              </span>
              <input type = "hidden" id = "per_start_date" ></input>
              <input type = "hidden" id = "per_end_date" ></input>
                
                  <i class="bi bi-calendar3 p-icon" id="btn_period" aria-hidden="true"></i>
             
              </h5>
            </div>
            <div class="col-12 col-md-4 ">
            <!-- <button id="print_screenshot" style="display:none;">Print Screenshot</button> -->
              <button id="btn_period" class="button " onclick = "printDiv()">
                  <i class="bi bi-camera" aria-hidden="true"></i> Print Screenshot
              </button>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-4 ">
              <div class="border p-3 col1">
                <div class="header-container" style = "background-color: #262626; border: 1px solid #262626">
                  <h5>Top Products</h5>
                  <select name="top_products" id="top_products" class = "trigger_reports" style="color: #ffff; width: 50px; border: 1px solid #ffff; font-size: 14px; height: 30px;">
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
                <div class="header-container" id = "hs_data" style = "background-color: #262626; border: 1px solid #262626">
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
                <h5>Net Income</h5>
                <p class="sub-title">Income from sales and expenses in selected period</p>
                <div class="center-total" id = "net_income">
                  <p>No data to display</p>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-8 ">
              <div class="border p-3 col1">
                <h5>Top Products </h5>
                <p class="sub-title">Lead products in selected period (top <span id = 'topitem_identifier'>5</span>)</p>
                  <table   class = "text-color table-border tbl_dashboard" >
                    <thead>
                      <tr>
                        <th style = "background-color: #343a40; text-align: left">Product</th>
                        <th style = "background-color: #343a40">Amount</th>
                      </tr>
                    </thead>
                  </table>
                  <div class = "table-responsive" id = "tbl_dashboard" style = "width: 100%">
                
                  <table id = "tbl_top_products"  class = "text-color table-border tbl_dashboard" >
                    <tbody>

                    </tbody>
                  </table>
                </div>
                <div class="center-total" id = "top_products_in_table">
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
<?php include "modals/dashboard_modal.php" ?>
<?php include ("layout/footer.php") ?>
<script>
  var originalColors = [];

  function printDiv() 
  {  
    $("#dashboard_content").css('background-color', 'transparent');
    $(".header-container").css({
      'background-color': 'transparent',
      'border': 'transparent'
    });
    $('#dashboard_content *').each(function() {
        var $this = $(this);
       
        if ($this.css('color') === 'rgb(255, 255, 255)' || $this.css('color') === '#ffffff'  ) {
            $this.css('color', 'black');
            $this.css('background-color', 'transparent');
        }
        if ($this.css('color') === 'rgb(38, 38, 38)' || $this.css('color') === '#262626' ) {
          $this.css('background-color', 'transparent');
        }
    });
    html2canvas(document.querySelector("#dashboard_content"), {
      ignoreElements: function(element) {
        return element.classList.contains('exclude');
      },
    }).then(canvas => {
      const dataURL = canvas.toDataURL();
      $("#dashboard_modal").fadeIn('show')
      const iframe = document.createElement('iframe');
      iframe.style.width = '100%';
      iframe.style.height = '700px';
      iframe.style.border = 'none';

      const blob = dataURLToBlob(dataURL);
      const blobURL = URL.createObjectURL(blob);

      iframe.src = blobURL;
      $('#dashboard_preview').html(iframe);

      $("#dashboard_content").css('background-color', '#262626');
      $('#dashboard_content *').each(function() {
        var $this = $(this);
        if ($this.css('background-color') === 'rgb(255, 255, 255)' || $this.css('color') === '#ffffff') {
            $this.css('color', 'white');
            $this.css('background-color', '#262626');
        }
      });

      const printButton = $('<button/>', {
          type: 'button',
          class: 'footerButton',
          id: 'print_screenshot',
          text: 'Print Dashboard Report'
      });
      $('#dashboard_preview').append(printButton);
      $('#print_screenshot').off('click').on('click', function() {
          iframe.contentWindow.print();
      });
    });
  } 
  function dataURLToBlob(dataURL) 
    {
        const byteString = atob(dataURL.split(',')[1]);
        const mimeString = dataURL.split(',')[0].split(':')[1].split(';')[0];
        const ab = new ArrayBuffer(byteString.length);
        const ia = new Uint8Array(ab);
        for (let i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }
        return new Blob([ab], { type: mimeString });
    }

  $(document).ready(function () {
    var totalSales = 0;
    var totalCount = 0;
    setPredefinedPeriod("Today");  
    show_allTopProducts(5);
    show_hourlySalesChart();
    var date_period_selected = $("#date_selected").text();
    $("#period_date").html(date_period_selected);
  
    $(".trigger_reports").show();
    
    $("#top_products").on("change", function(){
      var item = $(this).val();
      show_allTopProducts(item);
      $("#topitem_identifier").html(item);
    })
    function formatAmount(amount) {
    if (typeof amount !== 'number' || isNaN(amount)) {
        return amount; 
    }

    if (amount < 0) {
        amount = Math.abs(amount);
        if (amount >= 1e9) {
            return '-' + (amount / 1e9).toFixed(2) + 'B';
        } else if (amount >= 1e6) {
            return '-' + (amount / 1e6).toFixed(2) + 'M';
        } else if (amount >= 1e3) {
            return '-' + (amount / 1e3).toFixed(2) + 'K';
        } else {
            return '-' + amount.toFixed(2);
        }
    } else {
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
        success: function(responseData)
        {
          if(responseData['data'].length > 0)
          {
            var tblRows = [];
            const productsName = [];
            const productsAmount = [];
            var total_expenses = 0;
            var html = "";
            for (var i = 0, len = responseData['data'].length; i < len; i++) 
            {
              var currentItem = responseData['data'][i];

              html += "<tr>";
              html += "<td style = 'text-align: left'>"+currentItem.product+"</td>";
              html += "<td style = 'text-align: right'>"+currentItem.total_paid_amount+"</td>"


              productsName.push(currentItem.product);
              productsAmount.push(currentItem.total_paid_amount);
              // totalSales += currentItem.total_sales_amount;
              totalCount = i+1;
              
            }
  
            $("#top_products_in_table").hide();
            $(".tbl_dashboard").show();
          
            $("#tbl_top_products tbody").html(html);
          
            $("#top_products_data").html('<canvas id="myDoughnutChart"></canvas>');
            const backgroundColors = productsAmount.map(() => getRandomColor());

            const data = {
                labels: productsName,
                datasets: [{
                    label: 'My First Dataset',
                    data: productsAmount,
                    backgroundColor: backgroundColors,
                    hoverOffset: 4
                }]
            };

            const config = {
                type: 'doughnut',
                data: data,
            };

            const ctx = document.getElementById('myDoughnutChart').getContext('2d');
            new Chart(ctx, config);

            if(responseData['top_expensive_by_period'] !== 0)
            {
              var total_net_income = totalSales - responseData['total_expense_by_period'];
              total_net_income = total_net_income < 0 ? formatAmount(total_net_income) : formatAmount(total_net_income);
              $("#net_income").html("<h1>"+total_net_income+"</h1>");
            }
          }
          else
          {
            $("#top_products_in_table").show();
            $(".tbl_dashboard").hide();    
            $("#top_products_data").html('<p>No data to display</p>');
            $("#net_income").html("<h1>0.00</h1>");
            if(responseData['top_expensive_by_period'] === 0)
            {
              $("#net_income").html('<p>No data to display</p>');
            }
          }
        }
      })
  }
  function formatNegativeWithCommas(number) 
  {
    let strNumber = number.toString();

    if (strNumber.startsWith('-')) {
        let numWithoutSign = strNumber.substring(1);
        let formattedNum = '-' + parseFloat(numWithoutSign).toLocaleString();
        return formattedNum;
    } else {
        return parseFloat(strNumber).toLocaleString();
    }
}
  function getRandomColor() {
    const r = Math.floor(Math.random() * 256);
    const g = Math.floor(Math.random() * 256);
    const b = Math.floor(Math.random() * 256);
    return `rgb(${r}, ${g}, ${b})`;
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
              const db_totalSales = response.data.totalSales;
              const labels = response.data.labels;
              var allZeros = salesData.every(function(element) {
                  return element === "0.00";
              });
         
              if(!allZeros)
              {
                totalSales = db_totalSales;
                show_allTotalSales($("#hourly_sales").val());
                $("#hourly_sales_data").html('<canvas id="hourlySalesChart"  style="height: 50px; width: 50px;" class="chartjs-render-monitor"></canvas>');
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
                            label: '',
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
    function formatNumberWithCommas(number) {
        return number !==0 ? number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0;
    }
    function formatNumberWithCommasAndDecimals(number) {
      return number !== 0 ? number.toFixed(2).replace(/\d(?=(\d{3})+.)/g, '$&,') : 0;
    }
    $("#btn_refresh_dashboard").off("click").on("click", function(){
      updateChart(year);
    })

 
    function updateChart(year) {
    $("#d_year").html(year);
    axios.get('api.php?action=get_salesData&year=' + year)
        .then(function (response) {
            const salesData = response.data.salesData;
            const months = response.data.months;
            const annual_sales = response.data.annual_sales;
            const top_month = annual_sales === 0 ? "---" : response.data.top_month;
            const top_month_value = response.data.top_month_value;

            const expensesData = response.data.expensesData; 
            const annual_expenses= response.data.annual_expenses;
            const top_expensiveMonth =  annual_expenses === 0 ? "---" : response.data.top_expensiveMonth;
            const top_expensiveMonth_value = response.data.top_expensiveMonth_value;

            $(".annual_total_sales").html("<h3 style='font-family: Century Gothic;'>" + formatAmount(annual_sales) + "</h3>");
            $(".top_performing_month").html("<h4 style='color: #d9f500; font-size: 1rem'>Top Performing Month</h4>" +
                "<h4>" + top_month + "</h4>" +
                "<h4 class = 'topValue'>" +  formatNumberWithCommas(top_month_value) + "</h4>");

            $(".annual_total_expenses").html("<h3 style='font-family: Century Gothic;'>" + formatAmount(annual_expenses) + "</h3>");
            $(".top_expensive_month").html("<h4 style='color: #ff8792; font-size: 1rem'>Top Expensive Month</h4>" +
            "<h4>" + top_expensiveMonth + "</h4>" +
            "<h4 class = 'topValue'>" + formatNumberWithCommas(top_expensiveMonth_value) + "</h4>");

            const ctx = document.getElementById('salesChart').getContext('2d');

            const colorsSales = 'rgba(54, 162, 235, 0.6)'; 
            const colorsExpenses = 'rgba(255, 99, 132, 0.6)'; 

            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'Sales (₱)',
                            data: salesData,
                            backgroundColor: colorsSales,
                            borderColor: colorsSales.replace('0.6', '1'),
                            borderWidth: 1
                        }, 
                        {
                            label: 'Expenses (₱)',
                            data: expensesData,
                            backgroundColor: colorsExpenses, 
                            borderColor: colorsExpenses.replace('0.6', '1'),
                            borderWidth: 1
                        },
                    ]
                },
                options: {
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            stacked: true
                        },
                        y: {
                            grid: {
                                color: 'blue'
                            },
                            stacked: true
                        }
                    },
                    plugins: {
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        })
        .catch(function (error) {
            console.error('Error fetching sales data:', error);
        });
    }
    $("#btn_period").click(function (e) {
      e.preventDefault();
      $("#period_reports").fadeIn(200)
    })
  });


    document.addEventListener('DOMContentLoaded', function() {  
        var userId = document.getElementById('userId').value;
        var firstName = document.getElementById('firstName').value;
        var lastName = document.getElementById('lastName').value;
        var roleId = document.getElementById('roleId').value;

        
        var userInfo = {
            userId: userId,
            firstName: firstName,
            lastName: lastName,
            roleId: roleId
        };
        // localStorage.setItem('userInfo', JSON.stringify(userInfo));

        // insertLogs('Login', 'User' + ' '+ firstName + ' ' + lastName + ' ' + roleId )
      
    });


</script>