<script>
    $(document).ready(function () {
        function expiration() {
            $.ajax({
                url: "api.php?action=get_realtime_notifications",
                method: "GET",
                success: function (data) {
                    var products = data.products;
                    var notifications = data.notifications;
                    products.forEach(function (product) {
                        var daysRemaining = product.days_remaining;
                        if (daysRemaining > 30) {
                        } else if(daysRemaining >= 15) {
                            if (daysRemaining === 15) {
                                showNotification("Product " + product.name + " expires in 15 days.", "warning");
                            }
                        } else if(daysRemaining >= 5) {
                            if (daysRemaining === 5) {
                                showNotification("Product " + product.name + " expires in 5 days.", "warning");
                            }
                        } else {
                            showNotification("Product " + product.name + " has expired.", "danger");
                        }
                    });
                }   
            });
        }
    function showNotification(message, type) {
        var notification = $("<div>").addClass("alert alert-" + type).text(message);
        $("#notifications").append(notification);
        setTimeout(function () {
            notification.fadeOut(500, function () {
                notification.remove();
            });
        }, 3000);
    }
    setInterval(expiration, 5 * 60 * 1000);
    expiration();
});
</script>