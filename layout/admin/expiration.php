
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
                        thresholds.forEach(function (threshold) 
                        {
                            if (threshold.active && daysRemaining >= threshold.min && daysRemaining <= threshold.max) 
                            {
                                total++;
                            }
                        });
                        return total;
                    }, 0);

                    if(totalExpired > 0)
                    {
                        $("#expirationNotification").css('display', 'inline-block');
                        $("#expirationNotification").text(totalExpired.toString());
                    }
                }   
            });
        }

        function isReset() {
            axios.get('api.php?action=getResetVal')
                .then(function(response) {
                    if (response.data.success) {
                       $('#reloginModal').show();
                       $('#update_id').val(response.data.data.id)
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        }

       
    isReset();
    setInterval(expiration, 2000);
    expiration();
   
});
</script>