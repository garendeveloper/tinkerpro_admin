<?php 

  session_start();
  ob_start();

  $invalid = array();
  $success = array();
  $info = array();

  $session_timeout = 120; 

  if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
      session_unset();     
      session_destroy();   
      header("Location: login.php"); 
      exit();
  }

  $_SESSION['last_activity'] = time();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="refresh" content="900;url=logout.php" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>POS Management | Admin</title>
  <link rel="icon" href="assets/img/tinkerpro-logo-dark.png" type="image/png">
  <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="assets/vendors/base/vendor.bundle.base.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/others/flatpicker.min.css">
  <link rel="stylesheet" href="assets/icons-main/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/icons-main/font/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/jquery-ui.css">
  <link rel="stylesheet" href="assets/css/flatpickr.min.css">
  <link rel="stylesheet" href="assets/css/jquery-ui.css">
  <link rel="stylesheet" href="assets/js/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="assets/css/toastr.min.css">
  <link rel="stylesheet" href="assets/table-sortable/dataTables.dataTables.min.css">

  <script src="assets/vendors/base/vendor.bundle.base.js"></script>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/vendors/chart.js/Chart.min.js"></script>
  <script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="assets/vendors/letteravatar/letteravatar.js"></script>
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/hoverable-collapse.js"></script>
  <script src="assets/js/dashboard.js"></script>
  <script src="assets/js/data-table.js"></script>
  <script src="assets/js/jquery.dataTables.js"></script>
  <script src="assets/js/dataTables.bootstrap4.js"></script>
  <script src="assets/js/jquery.cookie.js"></script>
  <script src="assets/js/otherjs/flatpicker.js"></script>
  <script src="assets/js/otherjs/axios.min.js"></script>
  <script src="assets/js/otherjs/sweetalert.js"></script>
  <script src="assets/js/jquery-ui.min.js"></script>
  <script src="assets/js/flatpickr.js"></script>
  <script src="assets/js/daterangepicker/moment.min.js"></script>
  <script src="assets/js/daterangepicker/daterangepicker.min.js"></script>
  <script src="assets/js/sweetalert.js"></script>
  <script src="assets/js/toastr.min.js"></script>
  <script src="assets/table-sortable/dataTables.min.js"></script>
</head>
<body>