<?php
    include(__DIR__ . '/../utils/db/connector.php');
    include(__DIR__ . '/../utils/models/inventory-facade.php');

    $inventory = new InventoryFacade;
   
    $search = $_REQUEST["search"];
    $suggestions = $inventory->fetchProducts($search);
   
    echo json_encode($suggestions);

?>