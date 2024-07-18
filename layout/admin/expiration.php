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

                    var thresholds = [
                        { active: isActive(notifications[0].is_active), min: 16, max: 30 },
                        { active: isActive(notifications[1].is_active), min: 6, max: 15 },
                        { active: isActive(notifications[2].is_active), min: 1, max: 5 },
                        { active: isActive(notifications[3].is_active), min: -365, max: 0 }
                    ];

                    totalExpired = products.reduce(function (total, product) {
                        var daysRemaining = product.days_remaining;
                        var isReceived = product.is_received === 1;

                        if (isReceived) {
                            thresholds.forEach(function (threshold) {
                                if (threshold.active && daysRemaining >= threshold.min && daysRemaining <= threshold.max) {
                                    total++;
                                }
                            });
                        }

                        return total;
                    }, 0);

                    $("#expirationNotification").css('display', totalExpired > 0 ? 'inline-block' : 'none');
                    $("#expirationNotification").text(totalExpired.toString());
                   
                }   
            });
        }
    setInterval(expiration, 3000);
    expiration();
});
</script>