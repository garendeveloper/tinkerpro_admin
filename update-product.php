<?php

  include( __DIR__ . '/layout/header.php');
  include( __DIR__ . '/utils/db/connector.php');
  include( __DIR__ . '/utils/models/product-facade.php');

  $productFacade = new ProductFacade;

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
  if (isset($_GET["barcode"])){
    $barcode = $_GET["barcode"];
  }
  if (isset($_GET["prod_desc"])){
    $prodDesc = $_GET["prod_desc"];
  }
  if (isset($_GET["stocks"])){
    $stocks = $_GET["stocks"];
  }
  if (isset($_GET["cost"])){
    $cost = $_GET["cost"];
  }
  if (isset($_GET["markup"])){
    $markup = $_GET["markup"];
  }

  // Redirect to login page if user has not been logged in
  if ($userId == 0) {
    header("Location: login");
  }

  if (isset($_POST["update_product"])) {
    $barcode = $_POST["barcode"];
    $prodDesc = $_POST["prod_desc"];
    $stocks = $_POST["stocks"];
    $cost = $_POST["cost"];
    $markup = $_POST["markup"];
    $prodPrice = $cost + $markup;

    if (empty($barcode)) {
      array_push($invalid, 'Barcode should not be empty!');
    } if (empty($prodDesc)) {
      array_push($invalid, 'Product Description should not be empty!');
    } if (empty($stocks)) {
      array_push($invalid, 'Stocks should not be empty!');
    } if (empty($cost)) {
      array_push($invalid, 'Cost should not be empty!');
    } if (empty($markup)) {
      array_push($invalid, 'Markup should not be empty!');
    } else {
      $updateProduct = $productFacade->updateProduct($barcode, $prodDesc, $stocks, $cost, $markup, $prodPrice);
      if ($updateProduct) {
        header("Location: products?update_product=Product has been updated successfully!");
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
        <li class="nav-item">
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
        <li class="nav-item active">
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
                  <h2>Update Product</h2>
                  <div class="d-flex">
                    <i class="mdi mdi-home text-muted hover-cursor"></i>
                    <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Products&nbsp;/&nbsp;</p>
                    <p class="text-primary mb-0 hover-cursor">Update Product</p>
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
                <form class="forms-sample" action="update-product.php" method="post">
                  <?php include('errors.php'); ?>
                  <div class="form-group">
                    <label for="firstName">Barcode</label>
                    <input type="text" class="form-control" id="firstName" placeholder="Enter Barcode" name="barcode" value="<?= $barcode ?>">
                  </div>
                  <div class="form-group">
                    <label for="productDescription">Product Description</label>
                    <input type="text" class="form-control" id="productDescription" placeholder="Enter Product Description" name="prod_desc" value="<?= $prodDesc ?>">
                  </div>
                  <div class="form-group">
                    <label for="stocks">Stocks</label>
                    <input type="number" class="form-control" id="stocks" placeholder="Enter Stocks" name="stocks" value="<?= $stocks ?>">
                  </div>
                  <div class="form-group">
                    <label for="cost">Cost</label>
                    <input type="number" class="form-control" id="cost" placeholder="Enter Cost" name="cost" value="<?= $cost ?>">
                  </div>
                  <div class="form-group">
                    <label for="markup">Markup</label>
                    <input type="number" class="form-control" id="markup" placeholder="Enter Markup" name="markup" value="<?= $markup ?>">
                  </div>
                  <button type="submit" class="btn btn-primary me-2 text-white" name="update_product">Update Product</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php include('layout/footer.php') ?>