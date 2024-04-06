  <!-- plugins:js -->
  <script src="assets/vendors/base/vendor.bundle.base.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="assets/vendors/chart.js/Chart.min.js"></script>
  <script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="assets/vendors/letteravatar/letteravatar.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/hoverable-collapse.js"></script>
  <!-- <script src="assets/js/template.js"></script> -->
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="assets/js/dashboard.js"></script>
  <script src="assets/js/data-table.js"></script>
  <script src="assets/js/jquery.dataTables.js"></script>
  <script src="assets/js/dataTables.bootstrap4.js"></script>
  <!-- End custom js for this page-->

  <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
  <script src="assets/js/otherjs/flatpicker.js"></script>
  <script src="assets/js/otherjs/axios.min.js"></script>
  <script src="assets/js/otherjs/sweetalert.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.js"></script>
  <script>
    $(document).ready(function(){
      var url = window.location.href;
      var urlEnding = url.substring(url.lastIndexOf('/') + 1);
      $("#"+urlEnding).css('background-color', '#FF6700');

      $("#btn_logout").click(function(){
        if(confirm("Do you wish to proceed to logout?"))
        {
          window.location.href = "logout.php";
        }
      })
      $('#searchInput').on('keyup', function() {
          var value = $(this).val().toLowerCase();
          $('table tbody tr').filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
      });
    })
  </script>
</body>
</html>