function insertLogs(activity, act_details) {
    var f_name = $('#firstName').val();
    var l_name = $('#lastName').val();
    var cid = $('#user_id').val();
    $.ajax({
      method :'POST',
      url : './settings/logs.php',
      data : {
        firstName : f_name,
        lastName : l_name,
        action : activity,
        details : act_details,
        cashierId : cid,
        role_id : localStorage.roleIds
      },
      success : function(response) {
        
      },
      error : function(xhr, status, error) {
       
      }
    });
  }