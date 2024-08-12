<?php

include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/product-facade.php');
include(__DIR__ . '/../utils/models/user-facade.php');
include(__DIR__ . '/../utils/models/inventory-facade.php');

$inventoryfacade = new InventoryFacade;

$searchInput = $_GET['searchInput'] ?? null;

$recordsPerPage = 100;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

$inventories = $inventoryfacade->get_allInventories($searchInput, $offset, $recordsPerPage);
$counter = ($page - 1) * $recordsPerPage + 1;
ob_start();

if (count($inventories) > 0) 
{
    foreach($inventories as $row)
    {
        $product_stock = "<span style='color: red'>".$row['product_stock']."</span>";
        if($row['product_stock'] > $row['stock_count'])
        {
            $product_stock = "<span style='color: #90EE90'>".$row['product_stock']."</span>";
        }
        ?> 
            <tr  data-id = '<?=$row['product_id']?>' class = "tbl_rows">
                <td style = "width: 5%"  class = "text-center"><?= $counter?></td>
                <td style = "width: 20%" ><?= $row['prod_desc']?></td>
                <td><?= $row['barcode']?></td>
                <td class = "text-center"><?= $row['uom_name']?></td>
                <td class = "text-right"><?= $product_stock?></td>
                <td class='text-center '  style="padding: 2px; width: 5%" id='btn_openStockHistory'>
                    <a id="btn_openStockHistory " data-id="'<? $row['product_id']?>'" class=' productAnch '  style='text-decoration: none;'>
                        <i class="bi bi-graph-up normalIcon" style = "color: white"></i>
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
        <td colspan="100%" style="text-align: center; padding: 20px;">
        No data found.
        </td>
    </tr>
    <?php
}

$html = ob_get_clean();
echo $html;
?>

<!-- <script>
    function highlightBorder(element) {
        $allTrs = document.querySelectorAll('tr');
        $allTrs.forEach(function(tr) {
            tr.classList.remove('highlightedss');
        });

        $('.highlighteds').removeClass('highlighteds');
        element.classList.add('highlightedss');
    }
</script> -->