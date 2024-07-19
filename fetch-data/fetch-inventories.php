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
        $stock = $row['product_stock'] || 0;
        $stock_count = $row['stock_count'];
        $stock_status = $row['stock_status'] === 1;
        $isReceived = $row['latest_isReceived'];
        $qty_purchased = $row['all_qty_purchased'];
        $qty_received = $row['all_qty_received'];

        $partially_received = $qty_purchased !== 0 && $qty_purchased < $qty_received;
        $fully_received = $qty_purchased === 0 && $qty_received !== 0;
        $is_lowstock = $stock_status && $stock < $stock_count;
        $span = "<span style='color: #f94449; font-weight: bold'><i>TO PURCHASE</i></span>";
        if ($isReceived === 1 && $is_lowstock && $fully_received) $span = "<span><i style='color: #72bf6a; font-weight: bold'>RECEIVED</i> / <i style='color: #f94449; font-weight: bold'>TO PURCHASE</i></span>";
        if ($isReceived === 1 && !$is_lowstock && $fully_received) $span = "<span style='color: #72bf6a; font-weight: bold'><i>RECEIVED</i></span>";
        if ($isReceived === 1 && $is_lowstock && $partially_received) $span = "<span><i style='color: #FF6900; font-weight: bold'>PARTIALLY RECEIVED</i> / <i style='color: #f94449; font-weight: bold'>TO PURCHASE</i></span>";
        if ($isReceived === 1 && !$is_lowstock && $partially_received) $span = "<span style='color: #72bf6a; font-weight: bold'><i>PARIALLY RECEIVED</i></span>";
        ?> 
            <tr  onclick="highlightBorder(this)">
                <td><?= $counter?></td>
                <td><?= $row['prod_desc']?></td>
                <td><?= $row['barcode']?></td>
                <td class = "text-center"><?= $row['uom_name']?></td>
                <td class = "text-right"><?= $row['all_qty_purchased']?></td>
                <td class = "text-right"><?= $row['all_qty_received']?></td>
                <td class = "text-right"><?= $row['total_stock']?></td>
                <td class = "text-right"><?= number_format($row['cost'],2)?></td>
                <td class = "text-right"><?= number_format($row['prod_price'], 2)?></td>
                <td class = "text-center"><?= $span?></td>
            </tr>
        <?php
        $counter++;
    }
 
} else {
    ?>
    <tr>
        <td colspan="100%" style="text-align: center; padding: 20px;">
            <img src="./assets/img/tinkerpro-t.png" alt="No data Found" style="display: block; margin: 0 auto 10px auto;"><br>
            No Data Found!
        </td>
    </tr>
    <?php
}

$html = ob_get_clean();
echo $html;
?>
<style>

.productAnch {
    cursor: pointer;
}

.td-h {
    font-size: 12px;
    margin: 0; 
    padding: 0;
    height: auto; 
}

.highlightedss {
    background: var(--primary-color);
    color: #fff;
    font-weight: bold;
}

table tbody td {
    border: 1px solid #292928;
}

</style>
<script>
    function highlightBorder(element) {
        $allTrs = document.querySelectorAll('tr');
        allTrs.forEach(function(tr) {
            tr.classList.remove('highlightedss');
        });

        $('.highlighteds').removeClass('highlighteds');
        element.classList.add('highlightedss');
    }
</script>
