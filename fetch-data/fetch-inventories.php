<?php

include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/product-facade.php');
include(__DIR__ . '/../utils/models/user-facade.php');
include(__DIR__ . '/../utils/models/inventory-facade.php');

$inventoryfacade = new InventoryFacade;

$searchInput = $_GET['searchInput'] ?? null;

$recordsPerPage = 50;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

$inventories = $inventoryfacade->get_allInventories($searchInput, $offset, $recordsPerPage);
$counter = ($page - 1) * $recordsPerPage + 1;
ob_start();

if (count($inventories) > 0) 
{
    foreach($inventories as $row)
    {
        $stock = (float) $row['product_stock'];
        $stock_count = (float) $row['stock_count'];
        $stock_status = $row['stock_status'];
        $isReceived = $row['latest_isReceived'];
        $qty_purchased = $row['all_qty_purchased'];
        $qty_received = $row['all_qty_received'];

        $qty_received = $qty_purchased == '0' ? 0 : $qty_received;

        $partially_received = $qty_purchased !== 0 && $qty_purchased > $qty_received;
        $fully_received = ($qty_purchased == 0 && $qty_received == 0 );
        $is_lowstock = ($stock_status == 1 && $row['product_stock'] < $row['stock_count']) ? 1 : 0;
       

        $total_amount = $row['prod_price'] * $row['product_stock'];
        $product_stock = "<span style='color: red'>".$row['product_stock']."</span>";
        if($row['product_stock'] > $row['stock_count'])
        {
            $product_stock = "<span style='color: #90EE90'>".$row['product_stock']."</span>";
        }
        $span = "";
        if($is_lowstock == 1)
        {
            if ($stock <= 0 || $stock > 0) $span = "<span class='to-purchase' style='color: #f94449; font-size: 10px; font-weight: bold'>TO PURCHASE</span>";
            if ($isReceived && $fully_received ) $span = "<span class='fully-received' style='color: #72bf6a; font-size: 7px; font-weight: bold'> FULLY RECEIVED </span> | <span style='color: #f94449; font-size: 7px; font-weight: bold'>TO PURCHASE</span>";
            if ($isReceived && $partially_received) $span = "<span class='partially-received' style='color: yellow; font-size: 6px; font-weight: bold'>PARTIALLY RECEIVED</span> | <span style='color: #f94449; font-size: 6px; font-weight: bold'>TO PURCHASE</span></span>";
        }
        if($is_lowstock == 0)
        {
            if ($stock <= 0 || $stock > 0) $span = "<span class='to-purchase' style='color: #f94449; font-size: 10px; font-weight: bold'>TO PURCHASE</span>";
            if ($isReceived && $fully_received ) $span = "<span class='fully-received' style='color: #72bf6a; font-size: 10px; font-weight: bold'> FULLY RECEIVED </span>";
            if ($isReceived && $partially_received) $span = "<span class='partially-received' style='color: yellow; font-size: 10px; font-weight: bold'>PARTIALLY RECEIVED </span>";
        }
        ?> 
            <tr  data-id = '<?=$row['inventory_id']?>' class = "tbl_rows">
                <td style = "width: 5%" class = "text-center"><?= $counter?></td>
                <td style = "width: 15%" ><?= $row['prod_desc']?></td>
                <td><?= $row['barcode']?> </td>
                <td class = "text-center"><?= $row['uom_name']?></td>
                <td class = "text-right"><?= $row['all_qty_purchased']?></td>
                <td class = "text-right"><?= $qty_received ?></td>
                <td class = "text-right"><?= $product_stock ?></td>
                <td class = "text-right"><?= number_format($row['cost'],2)?></td>
                <td class = "text-right"><?= number_format($row['prod_price'], 2)?></td>
                <td class = "text-right"><?= number_format($total_amount, 2)?></td>
                <td class = "doctype text-center" style ="width: 20%"><?= $span?></td>
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
