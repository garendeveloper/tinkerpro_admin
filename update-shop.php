<?php

  include( __DIR__ . '/layout/header.php');
  include( __DIR__ . '/utils/db/connector.php');
  include( __DIR__ . '/utils/models/shop-facade.php');

  $shopFacade = new ShopFacade;

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
  if (isset($_GET["shop_name"])){
    $shopName = $_GET["shop_name"];
  }
  if (isset($_GET["shop_address"])){
    $shopAddress = $_GET["shop_address"];
  }
  if (isset($_GET["contact_number"])){
    $contactNumber = $_GET["contact_number"];
  }

  // Redirect to login page if user has not been logged in
  if ($userId == 0) {
    header("Location: login");
  }

  if (isset($_POST["update_shop"])) {
    $shopName = $_POST["shop_name"];
    $shopAddress = $_POST["shop_address"];
    $contactNumber = $_POST["contact_number"];

    if (empty($shopName)) {
      array_push($invalid, 'Shop Name should not be empty!');
    } if (empty($shopAddress)) {
      array_push($invalid, 'Shop Address should not be empty!');
    } if (empty($contactNumber)) {
      array_push($invalid, 'Contact Number should not be empty!');
    } else {
      $updateShop = $shopFacade->updateShop($shopName, $shopAddress, $contactNumber);
      if ($updateShop) {
        header("Location: my-shop?update_shop=Shop has been updated successfully!");
      }
    }
  }

?>

	<!-- partial:partials/_navbar.html -->
  <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex justify-content-center">
      <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">  
        <a class="navbar-brand brand-logo" href="index"><img src="assets/img/transak-pos-logo.png" alt="logo"/></a>
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
        <li class="nav-item">
          <a class="nav-link" href="index">
            <i class="mdi mdi-home menu-icon"></i>
            <span class="menu-title">Dashboard</span>
          </a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="my-shop">
            <i class="mdi mdi-home menu-icon"></i>
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
                  <h2>Update Shop</h2>
                  <div class="d-flex">
                    <i class="mdi mdi-home text-muted hover-cursor"></i>
                    <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;My Shop&nbsp;/&nbsp;</p>
                    <p class="text-primary mb-0 hover-cursor">Update Shop</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 stretch-card">
            <div class="card">
              <div class="card-body">
                <form class="forms-sample" action="update-shop.php" method="post">
                  <?php include('errors.php'); ?>
                  <div class="form-group">
                    <label for="shopName">Shop Name</label>
                    <input type="text" class="form-control" id="shopName" placeholder="Enter Shop Name" name="shop_name" value="<?= $shopName ?>">
                  </div>
                  <div class="form-group">
                    <label for="shopAddress">Shop Address</label>
                    <input type="text" class="form-control" id="shopAddress" placeholder="Enter Shop Address" name="shop_address" value="<?= $shopAddress ?>">
                  </div>
                  <div class="form-group">
                    <label for="contactNumber">Contact Number</label>
                    <input type="text" class="form-control" id="contactNumber" placeholder="Enter Contact Number" name="contact_number" value="<?= $contactNumber ?>">
                  </div>
                  <button type="submit" class="btn btn-primary me-2 text-white" name="update_shop">Update Shop</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php include('layout/footer.php') ?>