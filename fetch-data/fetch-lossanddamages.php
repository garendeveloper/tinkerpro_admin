<?php

    include(__DIR__ . '/../utils/db/connector.php');
    include( __DIR__ . '/../utils/models/loss_and_damage-facade.php');

    $loss_and_damage = new Loss_and_damage_facade();

    $searchInput = $_GET['searchInput'] ?? null;

    $recordsPerPage = 100;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * $recordsPerPage;

    $data = $loss_and_damage->get_all_lostanddamageinfo($searchInput, $offset, $recordsPerPage);
    $counter = ($page - 1) * $recordsPerPage + 1;
    ob_start();

    if (count($data) > 0) 
    {
        foreach($data as $row)
        {
            $date_transact = date('F j, Y', strtotime($row['date_transact']));
            ?> 
                <tr  data-id = '<?= $row['id'] ?>' class = "tbl_rows">
                    <td class = "text-center"><?= $row['reference_no']?></td>
                    <td class = "text-center"><?= $date_transact ?></td>
                    <td class = "text-center"><?= $row['reason']?></td>
                    <td class = "text-right"><?= number_format($row['total_qty'], 2)?></td>
                    <td class = "text-right"><?= number_format($row['total_cost'], 2)?></td>
                    <td class = "text-right"><?= number_format($row['over_all_total_cost'], 2)?></td>
                    <td class = "text-right"><?= $row['note']?></td>
                    <td class='text-center'  style="padding: 2px" >
                        <a id="btn_view_lossanddamage" data-id='<?= $row['id']?>'  class="text-success productAnch " style="text-decoration: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-binoculars" viewBox="0 0 16 16">
                                <path d="M3 2.5A1.5 1.5 0 0 1 4.5 1h1A1.5 1.5 0 0 1 7 2.5V5h2V2.5A1.5 1.5 0 0 1 10.5 1h1A1.5 1.5 0 0 1 13 2.5v2.382a.5.5 0 0 0 .276.447l.895.447A1.5 1.5 0 0 1 15 7.118V14.5a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 14.5v-3a.5.5 0 0 1 .146-.354l.854-.853V9.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v.793l.854.853A.5.5 0 0 1 7 11.5v3A1.5 1.5 0 0 1 5.5 16h-3A1.5 1.5 0 0 1 1 14.5V7.118a1.5 1.5 0 0 1 .83-1.342l.894-.447A.5.5 0 0 0 3 4.882zM4.5 2a.5.5 0 0 0-.5.5V3h2v-.5a.5.5 0 0 0-.5-.5zM6 4H4v.882a1.5 1.5 0 0 1-.83 1.342l-.894.447A.5.5 0 0 0 2 7.118V13h4v-1.293l-.854-.853A.5.5 0 0 1 5 10.5v-1A1.5 1.5 0 0 1 6.5 8h3A1.5 1.5 0 0 1 11 9.5v1a.5.5 0 0 1-.146.354l-.854.853V13h4V7.118a.5.5 0 0 0-.276-.447l-.895-.447A1.5 1.5 0 0 1 12 4.882V4h-2v1.5a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5zm4-1h2v-.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm4 11h-4v.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5zm-8 0H2v.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5z"/>
                            </svg>
                        </a>
                        <a id="btn_delete_lossanddamage" data-id='<?= $row['id']?>' data-reference_no = '<?= $row['reference_no']?>'  class="text-success productAnch " style="text-decoration: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-trash3" viewBox="0 0 16 16">
                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                            </svg>
                        </a>
                    </td>
                    <?php 
                    ?>
                </tr>
            <?php
            $counter++;
        }
    
    } 
    else 
    {
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
