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
<script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
<script src="assets/js/otherjs/flatpicker.js"></script>
<script src="assets/js/otherjs/axios.min.js"></script>
<script src="assets/js/otherjs/sweetalert.js"></script>

<script>
  $(document).ready(function(){
    var url = window.location.href;
    var urlEnding = url.substring(url.lastIndexOf('/') + 1);
    $("#"+urlEnding).css('background-color', '#FF6700');
    urlEnding = urlEnding.charAt(0).toUpperCase() + urlEnding.slice(1);
    $("#pointer").html(urlEnding);

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
    $("#r_close").click(function(){
      $("#response_modal").hide();
    })
  })
</script>
