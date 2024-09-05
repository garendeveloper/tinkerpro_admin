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
    <tr class="table-row">
        <td  class='text-center td-h child-a' ><?= $counter?><span hidden class="couponId"><?= $row['id'] ?></span></td>
        <td  class='text-center text-color td-h child-b'><?= $row['qrNumber'] ?></span></td>
        <td  class='text-center text-color td-h child-c'><?= number_format($row['c_amount'],2) ?></td>
        <td  class='text-center text-color td-h child-d'><?= $row['transaction_dateTime'] !== null ? date('F d, Y', strtotime($row['transaction_dateTime'])) : '' ?></td>
        <td  class='text-center text-color employeeNum td-h child-e'><?= $row['used_date'] !== null ? date('F d, Y', strtotime($row['used_date'])) : '' ?></td>
        <td  class='text-center text-color td-h child-f'><?= $row['expiry_dateTime'] !== null ? date('F d, Y', strtotime($row['expiry_dateTime'])) : '' ?><span hidden class="statsData"><?= $row['status']?></span><span hidden class="statsDataID"><?= $row['status_id']?></span></td>
        <td class="text-center td-h child-g <?= ($row["isUse"] == 0) ? 'text-success' : ($row["isUse"] == 1 ? 'text-danger' : '') ?>">
        <?= ($row["isUse"] == 0) ? 'Not Used' : ($row["isUse"] == 1 ? 'Used' : ($row['status'] ?? null)) ?>
        </td>
        <td class='text-center action-td td-h text-center child-h'>
    <a href="#" class='text-success editBtn' style='text-decoration: none;' onclick="printCoupon(<?= $row['id'] ?>)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-receipt-cutoff" viewBox="0 0 16 16">
                    <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5M11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z"/>
                    <path d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118z"/>
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
        <td colspan="100%" rowspan="100%" style="text-align: center; padding: 20px; border: 1px solid transparent !important">
            No data found.
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

<script>
    $(document).ready(function() {
       
        $('.table-row').click(function() {
         
            $('#add_coupon_modal').hide();
        });


        $('.table-row').click(function() {
         
            $('.table-row').removeClass('highlighteds');

            $(this).addClass('highlighteds');

           
            $('#add_coupon_modal').hide();
        });

    });

</script>