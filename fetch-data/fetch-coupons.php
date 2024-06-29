<?php
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/user-facade.php');

// Retrieve parameters from GET request
$value = $_GET['selectedValue'] ?? null; 
$searchQuery = $_GET['searchQuery'] ?? null;
$selectedUser = $_GET['selectedUser'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;
$userFacade = new UserFacade();
$selectedUser = $_GET['selectedUser'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;
$fetchUser = $userFacade->getAllCouponsStatus($value,$searchQuery);



// Fetch users with pagination

$counter = 1;

ob_start();
if ($fetchUser->rowCount() > 0) {
while ($row = $fetchUser->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <tr>
        <td  class='text-center td-h' ><?= $counter?><span hidden class="couponId"><?= $row['id'] ?></span></td>
        <td  class='text-center text-color td-h'><?= $row['qrNumber'] ?></span></td>
        <td  class='text-center text-color td-h'><?= number_format($row['c_amount'],2) ?></td>
        <td  class='text-center text-color td-h'><?= $row['transaction_dateTime'] !== null ? date('F d, Y', strtotime($row['transaction_dateTime'])) : '' ?></td>
        <td  class='text-center text-color employeeNum td-h'><?= $row['used_date'] !== null ? date('F d, Y', strtotime($row['used_date'])) : '' ?></td>
        <td  class='text-center text-color td-h'><?= $row['expiry_dateTime'] !== null ? date('F d, Y', strtotime($row['expiry_dateTime'])) : '' ?><span hidden class="statsData"><?= $row['status']?></span><span hidden class="statsDataID"><?= $row['status_id']?></span></td>
        <td class="text-center td-h <?= ($row["isUse"] == 0) ? 'text-success' : ($row["isUse"] == 1 ? 'text-danger' : '') ?>">
        <?= ($row["isUse"] == 0) ? 'Not Used' : ($row["isUse"] == 1 ? 'Used' : ($row['status'] ?? null)) ?>
        </td>
        <td class='text-center action-td td-h' style="display: flex; align-items:center; justify-content:center">
        <a href="#" class='text-success editBtn' style='text-decoration: none;'>
        <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V11C20.6569 11 22 12.3431 22 14V18C22 19.6569 20.6569 21 19 21H5C3.34314 21 2 19.6569 2 18V14C2 12.3431 3.34315 11 5 11V5ZM5 13C4.44772 13 4 13.4477 4 14V18C4 18.5523 4.44772 19 5 19H19C19.5523 19 20 18.5523 20 18V14C20 13.4477 19.5523 13 19 13V15C19 15.5523 18.5523 16 18 16H6C5.44772 16 5 15.5523 5 15V13ZM7 6V12V14H17V12V6H7ZM9 9C9 8.44772 9.44772 8 10 8H14C14.5523 8 15 8.44772 15 9C15 9.55228 14.5523 10 14 10H10C9.44772 10 9 9.55228 9 9ZM9 12C9 11.4477 9.44772 11 10 11H14C14.5523 11 15 11.4477 15 12C15 12.5523 14.5523 13 14 13H10C9.44772 13 9 12.5523 9 12Z" fill="#FF6700"></path> </g></svg>
     </a>
</td>

    </tr>
    <?php
    $counter++;
}
} else {
    ?>
    <tr>
        <td colspan="100%" style="text-align: center; padding: 20px;">
            <img src="./assets/img/tinkerpro-t.png" alt="No Products Found" style="display: block; margin: 0 auto 10px auto;"><br>
            No Data Found!
        </td>
    </tr>
    <?php
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