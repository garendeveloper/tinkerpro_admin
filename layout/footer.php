<?php include("./layout/admin/expiration.php")?>
<script>
  $(document).ready(function(){
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
