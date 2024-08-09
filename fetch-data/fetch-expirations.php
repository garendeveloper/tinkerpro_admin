<?php

    include(__DIR__ . '/../utils/db/connector.php');
    include( __DIR__ . '/../utils/models/inventory-facade.php');

    $inventoryfacade = new InventoryFacade();

    $searchInput = $_GET['searchInput'] ?? null;

    $recordsPerPage = 100;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * $recordsPerPage;

    $inventory = $inventoryfacade->get_productsForExpiring($searchInput, $offset, $recordsPerPage);
    $counter = ($page - 1) * $recordsPerPage + 1;
    ob_start();

    $data = $inventory['products'];
    $notifications = $inventory['notifications'];

    function isActive($value) 
    {
        return $value === 1;
    }

    if (count($data) > 0) 
    {
        $firstNotif_isActive = isActive($notifications[0]['is_active']); // 30
        $secondNotif_isActive = isActive($notifications[1]['is_active']); // 15
        $thirdNotif_isActive = isActive($notifications[2]['is_active']); // 5
        $fourthNotif_isActive = isActive($notifications[3]['is_active']); 
    
        $totalExpired = 0;
        $temp = false;
        $verifier = false;

        foreach($data as $row)
        {
            $days_remaining = $row['days_remaining'];

            $expiration = "";
            if (($firstNotif_isActive && $days_remaining <= 30 && $days_remaining >= 16) || ($secondNotif_isActive && $days_remaining <= 15 && $days_remaining >= 6) || ($thirdNotif_isActive && $days_remaining <= 5 && $days_remaining >= 1) || ($fourthNotif_isActive && $days_remaining <= 0)) 
            {
        
                $expiration = $days_remaining > 0 ?
                    'This product has a remaining shelf life of <span style="color: #FF6900; font-size: 14px;">' . $days_remaining . '</span> days' :
                    '<span style="font-size: 14px;"> This product has already expired. <span style = "color: red; ">' . $days_remaining . '</span> </span> days';
                ?>
                    <tr  data-id = '<?= $row['inventory_id'] ?>' class = "tbl_rows">
                        <td><?= $row['prod_desc']?></td>
                        <td class = "text-center"><?= $row['barcode'] ?></td>
                        <td class = "text-center"><?= $row['date_expired'] ?></td>
                        <td class = "text-center"><?= $row['transaction_qty'] ?></td>
                        <td class = "text-center"><?= $expiration ?></td>
                    </tr>
                <?php
            }
            $counter++;
        }
    
    } 
    else 
    {
        ?>
        <tr>
            <td colspan="100%" style="text-align: center; padding: 20px;" >
                <img src="./assets/img/no-data.png" alt="No data Found" style="display: block; margin: 0 auto 10px auto;"><br>
            </td>
        </tr>
        <?php
    }

    $html = ob_get_clean();
    echo $html;
?>
