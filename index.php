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

  <div class="container-scroller">
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
            <a class="nav-link" href="ability">
              <i class="mdi mdi-view-headline menu-icon"></i>
              <span class="menu-title">Ability</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                  <div class="me-md-3 me-xl-5">
                    <h2>Welcome back, <?= $firstName ?></h2>
                    <div class="d-flex">
                      <i class="mdi mdi-home text-muted hover-cursor"></i>
                      <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;</p>
                      <p class="text-primary mb-0 hover-cursor">Analytics</p>
                    </div>
                  </div>
                </div>
                <!-- <div class="d-flex justify-content-between align-items-end flex-wrap">
                  <button class="btn btn-primary mt-2 mt-xl-0">Generate report</button>
                </div> -->
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body dashboard-tabs p-0">
                  <ul class="nav nav-tabs px-4" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="overview-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Analytics</a>
                    </li>
                  </ul>
                  <div class="tab-content py-0 px-0">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                      <div class="d-flex flex-wrap justify-content-xl-between">
                        <div class="d-none d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-calendar-heart icon-lg me-3 text-primary"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Business Date</small>
                            <h5 class="mb-0 d-inline-block"><?= date('Y-m-d') ?></h5>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <h1 class="text-danger me-3">&#8369;</h1>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Product Sales</small>
                            <h5 class="me-2 mb-0">
                              <?php
                                // Display Sales 
                                $fetchSales = $transactionFacade->fetchProductSales();
                                if ($fetchSales != 0) {
                                  echo $transactionFacade->fetchProductSales();
                                } else {
                                  echo '0';
                                }
                                ?>
                            </h5>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <h1 class="text-danger me-3">&#8369;</h1>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Markup Sales</small>
                            <h5 class="me-2 mb-0">
                              <?php
                                // Display Sales 
                                $fetchSales = $transactionFacade->fetchMarkupSales();
                                if ($fetchSales != 0) {
                                  echo $transactionFacade->fetchMarkupSales();
                                } else {
                                  echo '0';
                                }
                                // Display withdraws
                                $fetchWithdraws = $withdrawFacade->fetchWithdraws()->rowCount();
                                if ($fetchWithdraws != 0) {
                                  echo '<span class="text-danger"> - ' . $withdrawFacade->fetchWithdrawsTotal() .'</span>';
                                } else {
                                  echo '<span class="text-danger"> - 0</span>';
                                }
                                ?>
                            </h5>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-eye me-3 icon-lg text-success"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Product Sold</small>
                            <h5 class="me-2 mb-0">
                              <?php
                                // Display Products Sold
                                $fetchProductSold = $transactionFacade->fetchProductsSold();
                                if ($fetchProductSold != 0) {
                                  echo $transactionFacade->fetchProductsSold();
                                } else {
                                  echo '0';
                                }
                              ?>
                            </h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Monthly Sales <span class="small text-info"> (Products)</span></p>
                  <p class="mb-4">This graph will show your monthly sales based from product sales throughout the year.</p>
                  <div id="monthly-sales-chart-legend" class="d-flex justify-content-center pt-3"></div>
                  <canvas id="monthly-sales-chart"></canvas>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Withdraw</p>
                  <div class="table-responsive">
                    <table id="withdraws-listing" class="table">
                      <thead>
                        <tr>
                          <th>Amount</th>
                          <th>Withdraw By</th>
                          <th>Date</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php   
                        $fetchWithdraws = $withdrawFacade->fetchWithdraws();
                        while ($row = $fetchWithdraws->fetch(PDO::FETCH_ASSOC)) { ?>
                          <tr>
                            <td><?= $row["amount"] ?></td>
                            <td><?= $row["withdraw_by"] ?></td>
                            <td><?= $row["date"] ?></td>
                            <td>
                              <?php
                                if ($row["is_settled"] == 0) { ?>
                                  <a href="settle-withdraw.php?withdraw_id=<?= $row["id"] ?>" class="btn btn-primary text-white pt-1">Settle</a>
                                <?php } else {
                                  echo '<span class="text-success">Settled</span>';
                                }
                              ?>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>       
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Recent Transactions</p>
                  <div class="table-responsive">
                    <table id="recent-purchases-listing" class="table">
                      <thead>
                        <tr>
                          <th>Transaction #</th>
                          <th>Qty</th>
                          <th>Description</th>
                          <th>Price</th>
                          <th>Subtotal</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php   
                            $fetchTransactions = $transactionFacade->fetchTransactions();
                            while ($row = $fetchTransactions->fetch(PDO::FETCH_ASSOC)) { ?>
                          <tr>
                            <td><?= $row["transaction_num"] ?></td>
                            <td><?= $row["prod_qty"] ?></td>
                            <td><?= $row["prod_desc"] ?></td>
                            <td><?= $row["prod_price"] ?></td>
                            <td><?= $row["subtotal"] ?></td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023 TinkerPro Pos. All Rights Reserved.</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

<?php include("layout/footer.php") ?>
<script>
  var ctx = document.getElementById('monthly-sales-chart');
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        label: 'Monthly Sales',
        data: [<?php echo json_encode($janProductSales) ?>, <?php echo json_encode($febProductSales) ?>, <?php echo json_encode($marProductSales) ?>, <?php echo json_encode($aprProductSales) ?>, <?php echo json_encode($mayProductSales) ?>, <?php echo json_encode($junProductSales) ?>, <?php echo json_encode($julProductSales) ?>, <?php echo json_encode($augProductSales) ?>, <?php echo json_encode($sepProductSales) ?>, <?php echo json_encode($octProductSales) ?>, <?php echo json_encode($novProductSales) ?>, <?php echo json_encode($decProductSales) ?>],
        backgroundColor: [
          'rgba(0, 0, 0, 0)',
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });
</script>