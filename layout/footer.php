
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
