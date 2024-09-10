<?php

include(__DIR__ . '/..//utils/db/connector.php');
include(__DIR__ . '/..//utils/models/employee-facade.php');
// include(__DIR__ . '/..//utils/models/user-facade.php');

$employeeFacade = new Employee_facade();
// $userFacade = new UserFacade();

$fetchEmployee = $employeeFacade->fetchEmployee();

$counter = 1;

ob_start(); 

if ($fetchEmployee->rowCount() > 0) {

    while ($row = $fetchEmployee->fetch(PDO::FETCH_ASSOC)) {
        ?>
       <tr class="table-row employee-row">
         
            <td style="border-left: 1px solid transparent !important" class="text-center td-h child-a">
                <?= $counter ?>
                <span hidden class="empId"><?= $row['id'] ?></span>
            </td>
            
            <td class="text-left text-color td-h child-b" style="padding-left: 10px !important">
                <?= $row['fname'] . ' ' . $row['lname'] ?>
                <span hidden class="f_name"><?= $row['fname'] ?></span>
                <span hidden class="l_name"><?= $row['lname'] ?></span>
            </td>

            <td class="text-center text-color td-h child-c"><?= $row['position'] ?>
            <span hidden class="empPosition"><?= $row['position'] ?></span></td>

            <td class="text-center text-color td-h child-d">
                <?= $row['employee_number'] ?? 'N/A' ?>
                <span hidden class="empNumber"><?= $row['employee_number'] ?></span>
                <span hidden class="pw"><?= $row['password'] ?></span>
                <span hidden class="imageName"><?= $row['profileimage'] ?? '' ?></span>
            </td>

            <td class="text-center text-color td-h child-f">
                <?= date('F d, Y', strtotime($row['date_hired'])) ?>
                 
            <span hidden class="dateHired"><?= $row['date_hired'] ?></span>
          
            </td>

            <td class="text-center td-h child-g <?= ($row["status"] == 'Active') ? 'text-success' : (($row["status"] == 'Inactive') ? 'text-danger' : (($row["status"] == 'Suspended') ? 'text-warning' : '')) ?>">
                <?= $row['status'] ?? null ?>
                <span hidden class="status_name"><?= $row['status']?></span>
                <span hidden class="status_id"><?= $row['status_id']?></span>
            </td>

            <td class="text-center action-td td-h child-h" style="border-right: 1px solid transparent !important">
                <a href="#" class="text-success editBtn" style="text-decoration: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                    </svg>
                </a>
   
                <a href="#" class="delete-btn" data-id="<?= $row['id'] ?>" style="text-decoration: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-trash3" viewBox="0 0 16 16">
                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                    </svg>
                </a>
            </td>

        </tr>
        <?php
        $counter++; 
    }
} else {

    ?>
    <tr>
        <td colspan="7" style="text-align: center; padding: 20px; border: 1px solid transparent !important">
            No data found.
        </td>
    </tr>
    <?php
}

$html = ob_get_clean(); 
echo $html; 

?>


<script>


    $(document).ready(function() {
       
        $('.table-row').click(function() {
         
            $('#add_employee_modal').hide();
        });


        $('.table-row').click(function() {
         
            $('.table-row').removeClass('highlighteds');

            $(this).addClass('highlighteds');

           
            $('#add_employee_modal').hide();
        });


        function refreshTable() {
    $.ajax({
      url: './fetch-data/fetch-employee.php',
        type: 'GET',
        success: function(response) {
            $('#employeeTable').html(response); 
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText); 
        }
    });
}


//delete function for employee
        $('.delete-btn').click(function(e) {
            e.preventDefault();
            
            var employeeId = $(this).data('id');
            if (confirm('Are you sure you want to delete this employee?')) {
                $.ajax({
                    url: 'api.php?action=DeleteEmployee', 
                    type: 'POST',
                 
                    data: {
                        action: 'deleteEmployee',
                        id: employeeId
                    },
                    
                    success: function(response) {
                        refreshTable();
                        var result = JSON.parse(response);
                        if (result.success) {
                            alert('Employee deleted successfully.');
                            location.reload(); 
                            insertLogs('Employee', 'Deleted' + ' ' + firstname + ' '+ lastname);

                        } else {
                            alert('Failed to delete employee.');
                        }
                    }
                });
            }
        });
        

        

    });


</script>

