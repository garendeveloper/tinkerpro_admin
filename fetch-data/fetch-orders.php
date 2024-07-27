<?php

    include(__DIR__ . '/../utils/db/connector.php');
    include(__DIR__ . '/../utils/models/product-facade.php');
    include(__DIR__ . '/../utils/models/user-facade.php');
    include(__DIR__ . '/../utils/models/order-facade.php');

    $orderfacade = new OrderFacade;

    $searchInput = $_GET['searchInput'] ?? null;

    $recordsPerPage = 100;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * $recordsPerPage;

    $orders = $orderfacade->get_allOrders($searchInput, $offset, $recordsPerPage);
    $counter = ($page - 1) * $recordsPerPage + 1;
    ob_start();

    if (count($orders) > 0) 
    {
        foreach($orders as $row)
        {
            $order_id = $row['order_id'];
            $date_purchased = date('F j, Y', strtotime($row['date_purchased']));
            $due_date = date('F j, Y', strtotime($row['due_date']));
            $isPaid = $row['isPaid'] === 1 ? "<span class='text-center badge-success'>Paid</span>" : "<span class='text-center badge-danger'>Unpaid</span>";
            $is_received = $row['is_received'] === 1 ? "<span class='text-center badge-success' >Received</span>" : "<span class='text-center badge-warning' style = 'color: yellow;'>To Receive</span>";
            $buttons = '<div >
                            <a id="btn_openUnpaidPayment" data-id='.$row['order_id'].' class="text-success productAnch " style="text-decoration: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-cash-stack" viewBox="0 0 16 16">
                                    <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                                    <path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2z"/>
                                </svg>
                            </a>
                            <a id="btn_editOrder" data-id='.$row['order_id'].' class="text-success productAnch " style="text-decoration: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </a>
                            <a id="btn_removeOrder" data-id='.$row['order_id'].' data-po_number='.$row['po_number'].' data-isReceived='.$row['is_received'].' data-isPaid='.$row['isPaid'].' class="text-success productAnch " style="text-decoration: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                </svg>
                            </a>
                        </div>';
            if($row['isPaid'] === 1 && $row['is_received'] === 0)
            {
                $buttons = '<div >
                                <a id="btn_editOrder" data-id='.$row['order_id'].' class="text-success productAnch " style="text-decoration: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </a>
                                <a id="btn_removeOrder" data-id='.$row['order_id'].' data-po_number='.$row['po_number'].' data-isReceived='.$row['is_received'].' data-isPaid='.$row['isPaid'].' class="text-success productAnch " style="text-decoration: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-trash3" viewBox="0 0 16 16">
                                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                    </svg>
                                </a>
                            </div>';
            }

            if($row['is_received'] === 1  && $row['is_received'] === 1)
            {
                $buttons = '<div >
                                <a   class="text-success productAnch " style="text-decoration: none;" >
                                    <i class="bi bi-node-minus" style = "font-size: 16px;"></i>
                                </a>
                            </div>';
            }
            ?> 
                <tr  data-id = '<?= $row['order_id'] ?>' data-is_received = '<?= $row['is_received']?>' data-po_number = '<?= $row['po_number']?>'>
                    <td class = "text-center"><?= $row['po_number']?></td>
                    <td><?= $row['supplier']?></td>
                    <td class = "text-center"><?= $date_purchased ?></td>
                    <td class = "text-center"><?= $due_date ?></td>
                    <td class = "text-right"><?= number_format($row['totalQty'], 2)?></td>
                    <td class = "text-right"><?= number_format($row['totalPrice'], 2)?></td>
                    <td class = "text-right"><?= number_format($row['price'], 2)?></td>
                    <td class = "text-center"><?= $isPaid?></td>
                    <td class = "text-center"><?= $is_received?></td>
                    <td class='text-center'  style="padding: 2px" ><?= $buttons?></td>
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
                <img src="./assets/img/tinkerpro-t.png" alt="No data Found" style="display: block; margin: 0 auto 10px auto;"><br>
                No Data Found!
            </td>
        </tr>
        <?php
    }

    $html = ob_get_clean();
    echo $html;
?>
