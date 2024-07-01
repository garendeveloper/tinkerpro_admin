function insertLogs(activity, act_details) {
    var userInfo = JSON.parse(localStorage.getItem('userInfo'));
    var f_name = userInfo.firstName;
    var l_name = userInfo.lastName;
    var cid = userInfo.userId;
    var role_id = userInfo.roleId; 
    

    $.ajax({
        method: 'POST',
        url: './settings/logs.php',
        data: {
            firstName: f_name,
            lastName: l_name,
            action: activity,
            details: act_details,
            cashierId: cid,
            role_id: role_id
        },
        success: function(response) {
            console.log(response)
        },
        error: function(xhr, status, error) {
            console.log(error)
        }
    });
}