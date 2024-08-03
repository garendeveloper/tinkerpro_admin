<?php
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/customer-facade.php');
include(__DIR__ . '/../utils/models/user-facade.php');

$customerFacade = new CustomerFacade;


$searchQuery = $_GET['searchQuery'] ?? null;

$customer = $customerFacade->getCustomersData($searchQuery);
$counter = 1;

ob_start();
if ($customer->rowCount() > 0) {
while ($row = $customer->fetch(PDO::FETCH_ASSOC)) 
{
//   var_dump( $row)
    ?>
    <tr class="table-row customer-row">
    <td class='text-center td-h col-1' style="border-left: 1px solid transparent !important"><?= $counter?></td>
    <td hidden class='text-center action-td td-h'><span class="userId"><?= $row['id'] ?? null ?></span><span class="customerId"><?= $row['customerId'] ?? null ?></span></td>
    <td class='text-light'><span class="firstName text-light"><?= $row['firstname'] ?? null ?></span>&nbsp;<span class="lastName text-light"><?= $row['lastname'] ?? null ?></span></td>
    <td class='action-td td-h text-center customerContact'><?= $row['contact'] ?? null ?></td>
    <td class='action-td td-h text-center customerCode'><?= $row['code'] ?? null ?></td>
    <td class='text-center action-td td-h '>
    <?= ($row['type'] ?? null) == 0 ? 'customer' : 'employee' ?>
    </td>
    <td hidden class='text-center action-td td-h pwdID'><?= $row['pwdOrScId'] ?? null ?></td>
    <td hidden class='text-center action-td td-h pwdTIN'><?= $row['scOrPwdTIN'] ?? null ?></td>
    <td hidden class='text-center action-td td-h dueDate'><?= $row['dueDateInterval'] ?? null ?></td>
    <td hidden class='text-center action-td td-h taxExempt'><?= $row['is_tax_exempt'] ?? null ?></td>
    <td hidden class='text-center action-td td-h customerType'><?= $row['type'] ?? null ?></td>
    <td class='action-td td-h customerEmail'><?= $row['email'] ?? null ?></td>
    <td class='action-td td-h customerAddress'><?= $row['address'] ?? null ?></td>
    <td class='text-center action-td td-h' style="border-right: 1px solid transparent !important">
        <a class='text-success editCustomer' style='text-decoration: none; cursor: pointer;'>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-pencil-square" viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
            </svg>
        </a>

        <a class='text-success deleteCustomer' style='text-decoration: none; cursor: pointer;'>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
            </svg>
        </a>
        <?php ?>
    </td>
    <?php
    $counter++;
}
} else {
    ?>
    <tr style="border: none">
        <td colspan="100%" rowspan="100%" style="text-align: center; padding: 20px; border: 1px solid transparent !important">
            <img src="./assets/img/notFound2.png" alt="No Products Found" style="display: block; margin: 0 auto 10px auto;"><br>
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

