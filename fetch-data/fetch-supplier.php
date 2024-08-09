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
    <td class='text-center child-a' ><?= $counter?></td>
    <td hidden class='text-center action-td supplierStatus'><?= $row['status'] ?? null ?></td>
    <td hidden class='text-center action-td supplierId'><?= $row['id'] ?? null ?></td>
    <td class='text-left action-td supplierName child-b'><?= $row['name'] ?? null ?></td>//
    <td class='text-center action-td supplierContact child-c'><?= $row['contact'] ?? null ?></td>
    <td class='text-left action-td supplierEmail child-d'><?= $row['email'] ?? null ?></td>
    <td class='text-left action-td supplierCompany child-e'><?= $row['company'] ?? null ?></td>
    <td class='text-center action-td child-f' style='color: <?= $row['status'] === 1 ? 'green' : 'red' ?>;'>
    <?= $row['status']=== 1 ? 'Active' : 'Inactive' ?></td>
    <td  class='text-center action-td child-g'>
               <a class='text-success editSupplier' style='text-decoration: none;'>
               <i class = "bi bi-pencil-square normalIcon" style = "font-size: 16px; color: white"></i>
               </a>
               <a class='text-success deleteSupplier' style='text-decoration: none;'>
                    <i class = "bi bi-trash3 deleteIcon" style = "font-size: 16px; color: white"></i>
               </a>
            <?php 
            ?>
        </td>
</tr>
    <?php
    $counter++;
}
} else {
    ?>
    <tr>
        <td colspan="100%" rowspan="100%" style="text-align: center; padding: 20px; border: 1px solid transparent !important">
            <img src="./assets/img/no-data.png" alt="No Products Found" style="display: block; margin: 0 auto 10px auto;"><br>
        </td>
    </tr>
    <?php
}


$html = ob_get_clean();
echo $html;

?>

