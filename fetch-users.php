<?php
include(__DIR__ . '/utils/db/connector.php');
include(__DIR__ . '/utils/models/user-facade.php');

// Retrieve parameters from GET request
$value = $_GET['selectedValue'] ?? null; 
$searchQuery = $_GET['searchQuery'] ?? null;

$userFacade = new UserFacade();




// Fetch users with pagination
$fetchUser = $userFacade->fetchUsers($value, $searchQuery);
$counter = 1;

ob_start();

while ($row = $fetchUser->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <tr>
    <td hidden><span hidden class="roleN td-h"><?= $row['role_name'] ?></span><span hidden class="roleidNum"><?= $row['role_id'] ?></span><span hidden class="identification"><?= $row['identification'] ?></span>
        </span><span hidden class="datehired"><?= $row['dateHired'] ?></span><span hidden class="permission"><?= $row['permission'] ?></span></td>
        <td  class='text-center td-h' ><?= $counter?><span hidden class="userId"><?= $row['id'] ?></span></td>
        <td  class='text-center text-color td-h'><?= $row['first_name'] . ' ' . $row['last_name'] ?><span hidden class="f_name"><?= $row['first_name']?></span><span hidden class="l_name"><?= $row['last_name']?></span></td>
        <td  class='text-center text-color td-h'><?= $row['role_name'] ?></td>
        <td  class='text-center text-color td-h'><?= $row['identification'] ?? null ?><span hidden class="pw"><?= $row['password']?></span><span hidden class="imageName"><?= $row['imageName']?></span></td>
        <td  class='text-center text-color employeeNum td-h'><?= $row['employeeNum'] ?? null ?></td>
        <td  class='text-center text-color td-h'><?= $row['dateHired'] !== null ? date('F d, Y', strtotime($row['dateHired'])) : '' ?><span hidden class="statsData"><?= $row['status']?></span><span hidden class="statsDataID"><?= $row['status_id']?></span></td>
        <td  class="text-center td-h  <?= ($row["status"] == 'Active') ? 'text-success' : (($row["status"] == 'Inactive') ? 'text-danger' : (($row["status"] == 'Suspended') ? 'text-warning' : '')) ?>">
            <?= $row['status'] ?? null ?>
        </td>
        <td class='text-center action-td td-h'>
            <?php
            if ($row['username'] == 'admin' && $row['password'] == 'admin') {
               
            } else {
                ?>
               <a class='text-success editBtn' style='text-decoration: none;'><svg width="25px" height="25px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title></title> <g id="Complete"> <g id="edit"> <g> <path d="M20,16v4a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V6A2,2,0,0,1,4,4H8" fill="none" stroke=" #FF6900" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path> <polygon fill="none" points="12.5 15.8 22 6.2 17.8 2 8.3 11.5 8 16 12.5 15.8" stroke=" #FF6900" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></polygon> </g> </g> </g> </g></svg></a>

            <?php }
            ?>
        </td>
    </tr>
    <?php
    $counter++;
}




$html = ob_get_clean();
echo $html;

?>
<style>
.td-h {
    font-size: 14px;
    margin: 0; 
    padding: 0;
    height: auto; 
}
</style>