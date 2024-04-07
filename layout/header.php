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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Transak POS | Admin</title>
  <link rel="icon" href="assets/img/tinkerpro-logo-dark.png" type="image/png">
  <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="assets/vendors/base/vendor.bundle.base.css">
  <link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/others/flatpicker.min.css">
  <link rel="stylesheet" href="assets/icons-main/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/icons-main/font/bootstrap-icons.css">
</head>
<body>