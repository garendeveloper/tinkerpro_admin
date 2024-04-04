<?php 

  session_start();
  ob_start();

  $invalid = array();
  $success = array();
  $info = array();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Transak POS | Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="assets/vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- endinject -->
  <link rel="icon" href="assets/img/tinkerpro-logo-dark.png" type="image/png">
  <link rel="stylesheet" href="assets/css/others/flatpicker.min.css">
   <!-- Option 1: Include in HTML -->
  <link rel="stylesheet" href="assets/icons-main/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/icons-main/font/bootstrap-icons.css">
</head>
<body>