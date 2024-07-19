<?php
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/product-facade.php');
include(__DIR__ . '/../utils/models/user-facade.php');

$productFacade = new ProductFacade;

$totalRecords = $productFacade->getTotalProductsCount();
$totalPages = ceil($totalRecords / 100);
echo "<div id='paginationBtns'>";
for ($i = 1; $i <= $totalPages; $i++) {
    $activeClass = ($i == 1) ? 'active' : ''; 
    echo "<a class='paginationTag $activeClass' href='javascript:void(0)' onclick='refreshProductsTable($i)'>$i</a> ";
}
echo "</div>";