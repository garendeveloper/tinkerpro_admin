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
                    <a id="btn_openStockHistory" data-id="'<? $row['product_id']?>'" class='text-success productAnch '  style='text-decoration: none;'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-clipboard-data" viewBox="0 0 16 16">
                            <path d="M4 11a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0zm6-4a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0zM7 9a1 1 0 0 1 2 0v3a1 1 0 1 1-2 0z"/>
                            <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
                            <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
                        </svg>
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
            <img src="./assets/img/no-data.png" alt="No data Found" style="display: block; margin: 0 auto 10px auto;"><br>
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