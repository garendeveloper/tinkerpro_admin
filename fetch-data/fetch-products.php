<?php

include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/product-facade.php');
include(__DIR__ . '/../utils/models/user-facade.php');

$productFacade = new ProductFacade;

$searchQuery = $_GET['searchQuery'] ?? null;
$selectedProduct = $_GET['selectedProduct'] ?? null;
$selectedCategories = $_GET['selectedCategories'] ?? null;
$selectedSubCategories = $_GET['selectedSubCategories'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

$recordsPerPage = 100;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

// Fetch products with pagination
$fetchProduct = $productFacade->fetchProducts($searchQuery, $selectedProduct, $singleDateData, $startDate, $endDate, $selectedCategories, $selectedSubCategories, $offset, $recordsPerPage);
$counter = ($page - 1) * $recordsPerPage + 1;
ob_start();

if ($fetchProduct->rowCount() > 0) {
    while ($row = $fetchProduct->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr class="hoverRow" href="#" onclick="highlightBorder(this)" ondblclick="openModal(this)">
        <td hidden class='text-center td-h'><span class="stock_status"><?= $row['stock_status'] ?></span><span class="stock_count"><?= $row['stock_count'] ?></span></td>
        <td hidden class='text-center td-h'><span class="isBOM"><?= $row['is_BOM'] ?></span><span class="isWarranty"><?= $row['is_warranty'] ?></span><span class="is_stockable"><?= $row['is_stockable'] ?></span></td>
        <td hidden class='text-center td-h'><span class="categoryDetails"><?= $row['category_details'] ?? null ?></span><span class="categoryid"><?= $row['category_id'] ?? null ?></span></span><span class="variantid"><?= $row['variant_id'] ?? null ?></span></td> 
        <td hidden class='text-center td-h'><span class="isTaxIncluded"><?= $row['taxIncluded'] ?></td> 
        <td hidden class='text-center td-h'><span class="description"><?= $row['description'] ?></span><span class="statusData"><?= $row['status'] ?></span><span class="productImgs"><?= $row['image'] ?></span></td> 
        <td hidden class='text-center td-h'><span class="other"><?= $row['otherCharges'] ?></span><span class="displayOthers"><?= $row['displayOthers'] ?></span></td> 
        <td hidden class='text-center td-h'><span class="service"><?= $row['serviceCharge'] ?></span><span class="displayService"><?= $row['displayService'] ?></span></td>
        <td hidden class='text-center td-h'><span hidden class="isDiscounted"><?= $row['discounted'] ?></span><span hidden class="isTax"><?= $row['isVAT'] ?></span></td>
        <td class='text-center td-h' style="width: 46px"><?= $counter?><span hidden class="productsId"><?= $row['id'] ?></span><span hidden class="oumId"><?= $row['uom_id'] ?></span></td>
        <td class='productsName text-left td-h' style='padding-left: 10px;width: 350px'><?= $row['prod_desc']?></td>
        <td class='barcode text-center td-h' style="width: 100px"><?= $row['barcode']?></td>
        <td class='sku text-center td-h'   style="width: 100px" ><?= $row['sku']?></td>
        <td class='code text-center td-h'   style="width: 100px" ><?= $row['code']?></td>
        <td class='uom_name text-center td-h'   style="width: 100px" ><?= $row['uom_name'] ?? null ?></td>
        <td class='brand text-center td-h'   style="width: 100px" ><?= $row['brand']?></td>
        <td class='prod_price text-end td-h pe-1'   style="width: 100px" ><?= number_format((float)$row['prod_price'], 2, '.', '')?></td>
        <td class='markup text-end td-h pe-1'   style="width: 100px" ><?= number_format((float)$row['markup'], 2, '.', '')?></td>
        <td class='cost text-end td-h pe-1' style="width: 100px" ><?= number_format((float)$row['cost'], 2, '.', '') ?></td>
        <td class='text-center td-h' style="width: 319px;">
        <?php
        if ($row['category_details'] !== null) {
            $category_details = json_decode($row['category_details'], true);
            $string_values = array_map(function($item) {
                return is_array($item) ? implode($item) : $item;
            }, $category_details);
            
            $concatenated_values = implode($string_values);
            echo $concatenated_values;
        }
        ?>
    </td>
        <td class='status text-center td-h' style='padding: 2px; width: 106px;color: <?= ($row['status'] == 1) ? "green" : "red" ?>;'><?= ($row['status'] == 1) ? "Active" : "Inactive" ?></td>
        <td class='text-center action-td td-h' style="width: 210px; padding: 2px">
                    <a id="editProductLink" class='text-success productAnch editProductBtn' onclick="openModal(this.closest('tr'))" style='text-decoration: none;'>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                    </svg>
                    </a>
                    <a class='text-success deleteProducts productAnch' style='text-decoration: none;'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-trash3" viewBox="0 0 16 16">
                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
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
        <td colspan="100%" rowspan="100%" style="text-align: center; padding: 20px; border: 1px solid transparent !important">
            <img src="./assets/img/notFound2.png" alt="No Products Found" style="display: block; margin: 0 auto 10px auto;"><br>
            No Data Found!
        </td>
    </tr>
    <?php
}

$html = ob_get_clean();
echo $html;
?>
<style>

.hoverRow:hover {
    background: #292928;
    cursor: pointer;
}

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
        var allTrs = document.querySelectorAll('tr');
        allTrs.forEach(function(tr) {
            tr.classList.remove('highlightedss');
        });

        $('.highlighteds').removeClass('highlighteds');
        element.classList.add('highlightedss');
    }
</script>
