<?php 

  session_start();
  ob_start();

  $invalid = array();
  $success = array();
  $info = array();

  // $session_timeout = 120; 

  // if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
  //     session_unset();     
  //     session_destroy();   
  //     header("Location: login.php"); 
  //     exit();
  // }

  // $_SESSION['last_activity'] = time();

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
    <link rel="stylesheet" href="assets/css/flatpickr.min.css">


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
  <script src="layout/admin/moment.min.js"></script>
  <script src="assets/jquery-barcode/jquery-barcode.js"></script>
  <script src="assets/jquery-barcode/jquery-barcode.min.js"></script>
  <script src="assets/js/html2canvas.min.js"></script>
  <script src="assets/js/main.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <!-- <script src="assets/js/JsBarcode.all.min.js"></script> -->

</head>
<body>
<script>
 function display_ct7() 
 {
    var x = new Date();
    var ampm = x.getHours() >= 12 ? ' PM' : ' AM';
    var hours = x.getHours() % 12;
    hours = hours ? hours : 12; 
    hours = hours.toString().length == 1 ? '0' + hours : hours;

    var minutes = x.getMinutes().toString();
    minutes = minutes.length == 1 ? '0' + minutes : minutes;

    var seconds = x.getSeconds().toString();
    seconds = seconds.length == 1 ? '0' + seconds : seconds;

    var monthNames = ["January", "February", "March", "April", "May", "June", 
                      "July", "August", "September", "October", "November", "December"];
    var month = monthNames[x.getMonth()];

    var dt = x.getDate().toString();
    dt = dt.length == 1 ? '0' + dt : dt;

    var year = x.getFullYear();

    var x1 = month + " " + dt + ", " + year;
    x1 = x1 + " - " + hours + ":" + minutes + ":" + seconds + ampm;
    document.getElementById('ct7').innerHTML = x1;
    display_c7();
  }

  function display_c7(){
    var refresh=1000; 
    mytime=setTimeout('display_ct7()',refresh)
  }
  display_c7()
</script>