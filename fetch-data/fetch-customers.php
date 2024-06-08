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
while ($row = $customer->fetch(PDO::FETCH_ASSOC)) {
//   var_dump( $row)
    ?>
    <tr>
    <td class='text-center td-h'><?= $counter?></td>
    <td hidden class='text-center action-td td-h'><span class="userId"><?= $row['id'] ?? null ?></span><span class="customerId"><?= $row['customerId'] ?? null ?></span></td>
    <td class='text-center action-td td-h '><span class="firstName"><?= $row['firstname'] ?? null ?></span>&nbsp;<span class="lastName"><?= $row['lastname'] ?? null ?></span></td>
    <td class='text-center action-td td-h customerContact'><?= $row['contact'] ?? null ?></td>
    <td class='text-center action-td td-h customerCode'><?= $row['code'] ?? null ?></td>
    <td class='text-center action-td td-h '>
    <?= ($row['type'] ?? null) == 0 ? 'customer' : 'employee' ?>
    </td>
    <td hidden class='text-center action-td td-h pwdID'><?= $row['pwdOrScId'] ?? null ?></td>
    <td hidden class='text-center action-td td-h pwdTIN'><?= $row['scOrPwdTIN'] ?? null ?></td>
    <td hidden class='text-center action-td td-h dueDate'><?= $row['dueDateInterval'] ?? null ?></td>
    <td hidden class='text-center action-td td-h taxExempt'><?= $row['is_tax_exempt'] ?? null ?></td>
    <td hidden class='text-center action-td td-h customerType'><?= $row['type'] ?? null ?></td>
    <td class='text-center action-td td-h customerEmail'><?= $row['email'] ?? null ?></td>
    <td class='text-center action-td td-h customerAddress'><?= $row['address'] ?? null ?></td>
    <td class='text-center action-td td-h'>
               <a class='text-success editCustomer' style='text-decoration: none;'><svg width="25px" height="25px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title></title> <g id="Complete"> <g id="edit"> <g> <path d="M20,16v4a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V6A2,2,0,0,1,4,4H8" fill="none" stroke=" #FF6900" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path> <polygon fill="none" points="12.5 15.8 22 6.2 17.8 2 8.3 11.5 8 16 12.5 15.8" stroke=" #FF6900" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></polygon> </g> </g> </g> </g></svg></a>
            <?php 
            ?>
        </td>
    <?php
    $counter++;
}
} else {
    ?>
    <tr>
        <td colspan="100%" style="text-align: center; padding: 20px;">
            <img src="./assets/img/tinkerpro-logo-light.png" alt="No Products Found" style="display: block; margin: 0 auto 10px auto;"><br>
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

