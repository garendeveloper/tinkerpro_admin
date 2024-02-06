<?php

  include( __DIR__ . '/layout/header.php');
  include( __DIR__ . '/utils/db/connector.php');
  include( __DIR__ . '/utils/models/user-facade.php');

  $userFacade = new UserFacade;

  if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username)) {
      array_push($invalid, 'Username should not be empty!');
    } if (empty($password)) {
      array_push($invalid, 'Password should not be empty!');
    } else {
      $verifyUsernameAndPassword = $userFacade->verifyUsernameAndPassword($username, $password);
      $signIn = $userFacade->signIn($username, $password);
      if ($verifyUsernameAndPassword > 0) {
        while ($row = $signIn->fetch(PDO::FETCH_ASSOC)) {
          $_SESSION['user_id'] = $row['id'];
          $_SESSION['first_name'] = $row['first_name'];
          $_SESSION['last_name'] = $row['last_name'];
          header('Location: index'); 
        }
      } else {
        array_push($invalid, "Incorrect username or password!");
      }
    }
  }

?>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo text-center">
                <img src="assets/img/tinkerpro-logo-dark.png" alt="logo">
              </div>
              <h4>Hello! let's get started</h4>
              <h6 class="font-weight-light">Login to continue.</h6>
              <?php include('errors.php'); ?>
              <form action="login.php" class="pt-3" method="post">
                <div class="form-group mb-0">
                  <input type="text" class="form-control form-control-lg" placeholder="Username" name="username">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" placeholder="Password" name="password">
                </div>
                <div class="mt-3">
                  <button class="btn btn-block bg-dark btn-lg text-white font-weight-medium auth-form-btn w-100" name="login">Login</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../../vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <!-- endinject -->
</body>

</html>
