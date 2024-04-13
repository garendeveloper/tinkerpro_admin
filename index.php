<?php

  include( __DIR__ . '/layout/header.php');
  include( __DIR__ . '/utils/db/connector.php');
  include( __DIR__ . '/utils/models/transaction-facade.php');
  include( __DIR__ . '/utils/models/withdraw-facade.php');

  $transactionFacade = new TransactionFacade;
  $withdrawFacade = new WithdrawFacade;

  $userId = 0;

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
  .col{
    background-color: #151515;
    color: white;
    height: 200px;
  }
  .header-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .button-container {
    display: flex;
  }
</style>
<?php include "layout/admin/css.php"?>

  <div class="container-scroller">

    <div class="">
      <?php include "layout/admin/sidebar.php"?>
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">  
          <a class="navbar-brand brand-logo" href="index"><img src="assets/img/tinkerpro-logo-dark.png" alt="logo"/></a>
          <a class="navbar-brand brand-logo-mini" href="index"><img src="assets/img/logo-mini.png" alt="logo"/></a>
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-sort-variant"></span>
          </button>
        </div>  
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
              <img width="60" height="60" avatar="<?= $firstName . ' ' . $lastName ?>">
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a href="logout.php" class="dropdown-item">
                <i class="mdi mdi-logout text-primary"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item active">
            <a class="nav-link" href="index">
              <i class="mdi mdi-home menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="my-shop">
              <i class="mdi mdi-store menu-icon"></i>
              <span class="menu-title">My Shop</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="users">
              <i class="mdi mdi-account menu-icon"></i>
              <span class="menu-title">Users</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="products">
              <i class="mdi mdi-view-headline menu-icon"></i>
              <span class="menu-title">Products</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ingredients">
              <i class="mdi mdi-view-headline menu-icon"></i>
              <span class="menu-title">Ingredients</span>
            </a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="logout.php">
            <i class="mdi mdi-logout text-primary menu-icon"></i>
            <span class="menu-title">Logout</span>
          </a>
        </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="container">
            <div class="row">
              <div class="col-md-8 ">
                <div class="border p-3 col">
                  <div class="header-container">
                    <h4 class="sales-chart-header">Monthly Sales Chart <span id="d_year" style = "color: #FF6700"></span></h4>
                    <div class="button-container">
                      <button id="prevYear" class="btn btn-default btn-sm" style="color: #fff">&lt;</button>
                      <button id="nextYear" class="btn btn-default btn-sm" style="color: #fff">&gt;</button>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <canvas id="salesChart" width="400" height="60"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="border p-3 col">
                  <h5>Total Sales</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php include("layout/footer.php") ?>
<script>
  $(document).ready(function() {
    let year = new Date().getFullYear();
    $("#d_year").html(year);
    updateChart(year);

    // Function to update chart data for the next year
    $('#nextYear').click(function() {
      year++;
      updateChart(year);
    });

    // Function to update chart data for the previous year
    $('#prevYear').click(function() {
      year--;
      updateChart(year);
    });

    // Function to update chart data based on the selected year
    function updateChart(year) {
      // Here you should fetch the sales data for the selected year from your server
      // Replace the salesData array with the fetched data
      $("#d_year").html(year);
      // chart.data.datasets[0].data = updatedSalesData;
      // chart.update();
      const salesData = [100, 200, 150, 300, 250, 400, 350, 500, 450, 600, 550, 700];
      const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
      const ctx = document.getElementById('salesChart').getContext('2d');
      const chart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: months,
          datasets: [{
            label: 'Sales ($)',
            data: salesData,
            fill: false,
            borderColor: '#fff',
            tension: 0.2
          }]
        },
        options: {
          scales: {
            x: {
              grid: {
                color: 'red',
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
  });
</script>