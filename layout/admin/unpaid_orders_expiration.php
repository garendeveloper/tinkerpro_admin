<script>
    $(document).ready(function () {
        var totalExpired = 0;
        function expiration() {
            $.ajax({
                url: "api.php?action=get_realtime_orderExpirations",
                method: "GET",
                success: function (data) {
                    var totalExpired = data.length;
                    var tbl_orders = $('#tbl_orders tbody tr');
                    for (var i = 0; i < data.length; i++) 
                    {
                        var matchingId = data[i].id; 
                        tbl_orders.each(function() {
                            var rowId = $(this).data('id'); 
                            if (rowId === matchingId) {
                                $(this).addClass('expiring'); 
                            }
                        });
                    }
                    if(totalExpired > 0)
                    {
                        $("#unpaidExpirations").css('display', 'inline-block');
                        $("#unpaidExpirations").text(totalExpired.toString());
                    }
                }   
            });
        }
    setInterval(expiration, 3000);
    expiration();
});
</script>