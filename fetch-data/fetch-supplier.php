<?php
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/supplier-facade.php');
include(__DIR__ . '/../utils/models/user-facade.php');

$supplierFacade = new SupplierFacade;


$searchQuery = $_GET['searchQuery'] ?? null;

// $selectedIngredients = $_GET['selectedIngredients'] ?? null;
// Fetch users with pagination
$fetchSupplier = $supplierFacade->getSupplierAndSuppliedData($searchQuery);
$counter = 1;

ob_start();
if ($fetchSupplier->rowCount() > 0) {
while ($row = $fetchSupplier->fetch(PDO::FETCH_ASSOC)) {
//   var_dump( $row)
    ?>
    <tr class="table-row supplier-rows">
    <td class='text-center td-h' style="border-left: 1px solid transparent !important"><?= $counter?></td>
    <td hidden class='text-center action-td td-h supplierStatus'><?= $row['status'] ?? null ?></td>
    <td hidden class='text-center action-td td-h supplierId'><?= $row['id'] ?? null ?></td>
    <td class='text-left action-td td-h supplierName'><?= $row['name'] ?? null ?></td>//
    <td class='text-center action-td td-h supplierContact'><?= $row['contact'] ?? null ?></td>
    <td class='text-left action-td td-h supplierEmail'><?= $row['email'] ?? null ?></td>
    <td class='text-left action-td td-h supplierCompany'><?= $row['company'] ?? null ?></td>
    <td class='text-center action-td td-h' style='color: <?= $row['status'] === 1 ? 'green' : 'red' ?>;'>
    <?= $row['status']=== 1 ? 'Active' : 'Inactive' ?></td>
    <td style="border-right: 1px solid transparent !important" class='text-center action-td td-h'>
               <a class='text-success editSupplier' style='text-decoration: none;'>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-pencil-square" viewBox="0 0 16 16">
                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                </svg>
               </a>
               <a class='text-success deleteSupplier' style='text-decoration: none;'>
                <i class = "bi bi-trash3 deleteIcon" style = "font-size: 14px; color: white"></i>
               </a>
            <?php 
            ?>
        </td>
    <?php
    $counter++;
}
} else {
    ?>
    <tr>
        <td colspan="100%" rowspan="100%" style="text-align: center; padding: 20px; border: 1px solid transparent !important">
            <!-- <img src="./assets/img/notFound2.png" alt="No Products Found" style="display: block; margin: 0 auto 10px auto;"><br> -->
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

