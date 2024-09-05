<?php
// Include necessary files
include(__DIR__ . '/..//utils/db/connector.php');
include(__DIR__ . '/..//utils/models/employee-facade.php');

// Instantiate the Employee facade class
$employeeFacade = new Employee_facade();

// Fetch employee data using the method defined in the Employee_facade class
$fetchEmployee = $employeeFacade->fetchEmployee();

$counter = 1; 

ob_start(); // Start output buffering

// Check if any employee data exists
if ($fetchEmployee->rowCount() > 0) {
    // Loop through each employee and populate the table rows
    while ($row = $fetchEmployee->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr class="table-row employee-row">
            <td hidden>
                <span hidden class="roleN td-h"><?= $row['position'] ?></span>
                <span hidden class="userId"><?= $row['user_id'] ?></span>
                <span hidden class="dateHired"><?= $row['date_hired'] ?></span>
                <span hidden class="status_id"><?= $row['status_id'] ?></span>
            </td>
            <td style="border-left: 1px solid transparent !important" class="text-center td-h child-a"><?= $counter ?></td>
            <td class="text-left text-color td-h child-b" style="padding-left: 10px !important"><?= $row['fname'] . ' ' . $row['lname'] ?></td>
            <td class="text-center text-color td-h child-c"><?= $row['position'] ?></td>
            <td class="text-center text-color td-h child-d"><?= $row['employee_number'] ?? 'N/A' ?></td>
            <td class="text-center text-color td-h child-e"><?= date('F d, Y', strtotime($row['date_hired'])) ?></td>
            <td class="text-center td-h child-f <?= ($row['status_id'] == 1) ? 'text-success' : (($row['status_id'] == 2) ? 'text-danger' : 'text-warning') ?>">
                <?= $row['status_id'] == 1 ? 'Active' : ($row['status_id'] == 2 ? 'Inactive' : 'Suspended') ?>
            </td>
            <td class="text-center action-td td-h child-h" style="border-right: 1px solid transparent !important">
                <a href="#" class="text-success editBtn" style="text-decoration: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                    </svg>
                </a>
            </td>
        </tr>
        <?php
        $counter++; // Increment the counter for each row
    }
} else {
    // Display a message if no data is found
    ?>
    <tr>
        <td colspan="7" style="text-align: center; padding: 20px; border: 1px solid transparent !important">
            No data found.
        </td>
    </tr>
    <?php
}

$html = ob_get_clean(); // Get the content of the output buffer
echo $html; // Display the table rows

?>
