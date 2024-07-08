<script>
    $(document).ready(function () {
        var totalExpired = 0;
        function expiration() {
            $.ajax({
                url: "api.php?action=get_realtime_notifications",
                method: "GET",
                success: function (data) {
                    var products = data.products;
                    var notifications = data.notifications;

                    function isActive(value) {
                        return value === 1;
                    }
                    var firstNotif_isActive = isActive(notifications[0].is_active);//30
                    var secondNotif_isActive = isActive(notifications[1].is_active);//15
                    var thirdNotif_isActive = isActive(notifications[2].is_active);//5
                    var fourthNotif_isActive = isActive(notifications[3].is_active);//0
                    
                    totalExpired = 0;
                    products.forEach(function (product) {
                        var daysRemaining = product.days_remaining;
                        var isReceived = product.is_received === 1;
                        if(isReceived)
                        {
                            if (firstNotif_isActive) {
                                if(daysRemaining <= 30 && daysRemaining >= 16){
                                    totalExpired += 1;
                                }
                            }
                            if (secondNotif_isActive) {
                                if(daysRemaining <= 15 && daysRemaining >= 6){
                                    totalExpired += 1;
                                }
                            }
                            if (thirdNotif_isActive) {
                                if(daysRemaining <= 5 && daysRemaining >= 1){
                                    totalExpired += 1;
                                }
                            }
                            if (fourthNotif_isActive) {
                                if(daysRemaining === 0){
                                    totalExpired += 1;
                                }
                            }
                        }
                      
                        
                    });
                    if(totalExpired > 0)
                    {
                        $("#expirationNotification").css('display', 'inline-block');
                        $("#expirationNotification").text(totalExpired);
                    }
                    else
                    {
                        $("#expirationNotification").css('display', 'none');
                        $("#expirationNotification").text("0");
                    }
                   
                }   
            });
        }
    setInterval(expiration, 3000);
    expiration();
});
</script>