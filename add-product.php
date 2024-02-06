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

  // Redirect to login page if user has not been logged in
  if ($userId == 0) {
    header("Location: login.php");
  }

  if (isset($_POST["add_product"])) {
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
      $addProduct = $productFacade->addProduct($barcode, $prodDesc, $stocks, $cost, $markup, $prodPrice);
      if ($addProduct) {
        header("Location: products.php?add_product=Product has been added successfully!");
      }
    }
  }

?>

	<!-- partial:partials/_navbar.html -->
  <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex justify-content-center">
      <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">  
        <a class="navbar-brand brand-logo" href="index.html"><img src="assets/img/transak-pos-logo.png" alt="logo"/></a>
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
          <a class="nav-link" href="index.php">
            <i class="mdi mdi-home menu-icon"></i>
            <span class="menu-title">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="my-shop.php">
            <i class="mdi mdi-store menu-icon"></i>
            <span class="menu-title">My Shop</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="users.php">
            <i class="mdi mdi-account menu-icon"></i>
            <span class="menu-title">Users</span>
          </a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="products.php">
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
                  <h2>Add Product</h2>
                  <div class="d-flex">
                    <i class="mdi mdi-home text-muted hover-cursor"></i>
                    <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Products&nbsp;/&nbsp;</p>
                    <p class="text-primary mb-0 hover-cursor">Add Product</p>
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
                <form class="forms-sample" action="add-product.php" method="post">
                  <?php include('errors.php'); ?>
                  <div class="form-group">
                    <label for="firstName">Barcode</label>
                    <input type="text" class="form-control" id="firstName" placeholder="Enter Barcode" name="barcode">
                  </div>
                  <div class="form-group">
                    <label for="productDescription">Product Description</label>
                    <input type="text" class="form-control" id="productDescription" placeholder="Enter Product Description" name="prod_desc">
                  </div>
                  <div class="form-group">
                    <label for="stocks">Stocks</label>
                    <input type="number" class="form-control" id="stocks" placeholder="Enter Stocks" name="stocks">
                  </div>
                  <div class="form-group">
                    <label for="cost">Cost</label>
                    <input type="number" class="form-control" id="cost" placeholder="Enter Cost" name="cost">
                  </div>
                  <div class="form-group">
                    <label for="markup">Markup</label>
                    <input type="number" class="form-control" id="markup" placeholder="Enter Markup" name="markup">
                  </div>
                  <button type="submit" class="btn btn-primary me-2 text-white" name="add_product">Add Product</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php include('layout/footer.php') ?>