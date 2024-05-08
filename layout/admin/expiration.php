<script>
    $(document).ready(function () {
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
                    var totalExpired = 0;
                    products.forEach(function (product) {
                        var daysRemaining = product.days_remaining;
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
                        // } else if(daysRemaining >= 15) {
                        //     if (daysRemaining === 15) {
                        //         showNotification("Product " + product.name + " expires in 15 days.", "warning");
                        //     }
                        // } else if(daysRemaining >= 5) {
                        //     if (daysRemaining === 5) {
                        //         showNotification("Product " + product.name + " expires in 5 days.", "warning");
                        //     }
                        // } else {
                        //     showNotification("Product " + product.name + " has expired.", "danger");
                        // }
                        
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
    function showNotification(message, type) {
        // var notification = $("<div>").addClass("alert alert-" + type).text(message);
        $("#expirationNotification").text(notification);
        setTimeout(function () {
            notification.fadeOut(500, function () {
                notification.remove();
            });
        }, 3000);
    }
    setInterval(expiration, 3000);
    expiration();
});
</script>