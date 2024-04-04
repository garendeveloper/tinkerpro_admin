<?php
include(__DIR__ . '/utils/db/connector.php');
include(__DIR__ . '/utils/models/product-facade.php');
include(__DIR__ . '/utils/models/user-facade.php');

$productFacade = new ProductFacade;




// Fetch users with pagination
$fetchProduct = $productFacade->fetchProducts();
$counter = 1;

ob_start();

while ($row = $fetchProduct->fetch(PDO::FETCH_ASSOC)) {
    // var_dump($row)
    ?>
    <tr>
    <td class='text-center td-h'><?= $counter?><span hidden class="userId"><?= $row['id'] ?></span></td>
    <td class='text-center td-h'><?= $row['prod_desc']?></td>
    <td class='text-center td-h'><?= $row['barcode']?></td>
    <td class='text-center td-h'><?= $row['sku']?></td>
    <td class='text-center td-h'><?= $row['code']?></td>
    <td class='text-center td-h'><?= $row['uom_name']?></td>
    <td class='text-center td-h'><?= $row['brand']?></td>
    <td class='text-center td-h'><?= $row['prod_price']?></td>
    <td class='text-center td-h'><?= $row['markup']?></td>
    <td class='text-center td-h'><?= $row['cost']?></td>
    <td class='text-center td-h'>walapa</td>
    <td class='text-center td-h' style='color: <?= ($row['status'] == 1) ? "green" : "red" ?>;'><?= ($row['status'] == 1) ? "Active" : "Inactive" ?></td>
    <td class='text-center action-td td-h'>
               <a class='text-success editBtn' style='text-decoration: none;'><svg width="25px" height="25px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title></title> <g id="Complete"> <g id="edit"> <g> <path d="M20,16v4a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V6A2,2,0,0,1,4,4H8" fill="none" stroke=" #FF6900" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path> <polygon fill="none" points="12.5 15.8 22 6.2 17.8 2 8.3 11.5 8 16 12.5 15.8" stroke=" #FF6900" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></polygon> </g> </g> </g> </g></svg></a>
            <?php 
            ?>
        </td>
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