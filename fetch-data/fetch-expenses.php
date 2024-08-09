<?php

    include(__DIR__ . '/../utils/db/connector.php');
    include( __DIR__ . '/../utils/models/expense-facade.php');

    $expenseFacade = new ExpenseFacade();

    $searchInput = $_GET['searchInput'] ?? null;

    $recordsPerPage = 100;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * $recordsPerPage;
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $data = $expenseFacade->get_allExpenses($start_date, $end_date, $searchInput, $offset, $recordsPerPage);
    $counter = ($page - 1) * $recordsPerPage + 1;
    ob_start();

    if (count($data) > 0) 
    {
        foreach($data as $row)
        {   
            $total_landing_cost = 0;

            if($row['isLandingCostEnabled'] === 1)
            {
                $landing_cost = json_decode($row['landingCost'], true);
                $totalLandingCost = $landing_cost['totalLandingCost'];
                $total_landing_cost = $totalLandingCost-$row['total_amount'];
            }
            ?> 
                <tr  data-id = '<?= $row['id'] ?>' data-product_id = '<?= $row['product_id']?>' class = "tbl_rows">
                    <td style = "width: 3%" class = "text-center"><?= $counter?></td>
                    <td style = "width: 12%"><?= $row['item_name'] === "" ? $row['product'] : $row['item_name']?></td>
                    <td style = "width: 6%" class = "text-center"><?= $row['date_of_transaction']?></td>
                    <td style = "width: 6%"  class = "text-center"><?= $row['billable_receipt_no'] ?></td>
                    <td style = "width: 10%"  class = "center"><?= $row['expense_type'] ?></td>
                    <td style = "width: 6%"  class = "text-center"><?= $row['uom_name']?></td>
                    <td style = "width: 6%" ><?= $row['supplier']?></td>
                    <td style = "width: 7%" class = "text-center"><?= $row['invoice_number']?></td>
                    <td style = "width: 8%" class = "text-right"><?= number_format($row['quantity'], 2)?></td>
                    <td style = "width: 8%" class = "text-right"><?= number_format($row['price'], 2)?></td>
                    <td style = "width: 8%" class = "text-right"><?= number_format($row['discount'], 2)?></td>
                    <td style = "width: 8%" class = "text-right"><?= number_format($row['total_amount'], 2)?></td>
                    <td style = "width: 8%" class = "text-right"><?= number_format($total_landing_cost,2)?></td>
                    <td class='text-center'  style="padding: 2px" >
                        <?php if($row['product_id'] !== 0) {?>
                            <a class="text-success productAnch " style="text-decoration: none;" >
                                <i class="bi bi-receipt" style = "font-size: 16px;"></i>
                            </a>
                        <?php }?>
                        <?php if($row['product_id'] == 0) {?>
                            <a id="btn_removeExpense" data-id='<?= $row['id']?>'  class="text-success productAnch " style="text-decoration: none;" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                </svg>
                            </a>
                        <?php }?>
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
            <td colspan="100%" rowspan="100%"  style="text-align: center; padding: 20px; border: 1px solid transparent !important">
                <img src="./assets/img/no-data.png" alt="No data Found" style="display: block; margin: 0 auto 10px auto;"><br>
            </td>
        </tr>
        <?php
    }

    $html = ob_get_clean();
    echo $html;
?>
