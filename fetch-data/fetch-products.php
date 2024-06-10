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

$recordsPerPage = 300;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

// Fetch products with pagination
$fetchProduct = $productFacade->fetchProducts($searchQuery, $selectedProduct, $singleDateData, $startDate, $endDate, $selectedCategories, $selectedSubCategories, $offset, $recordsPerPage);

$counter = ($page - 1) * $recordsPerPage + 1;
ob_start();

if ($fetchProduct->rowCount() > 0) {
    while ($row = $fetchProduct->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr href="#" onclick="highlightBorder(this)" ondblclick="openModal(this)">
        <td hidden class='text-center td-h'><span class="stock_status"><?= $row['stock_status'] ?></span><span class="stock_count"><?= $row['stock_count'] ?></span></td>
        <td hidden class='text-center td-h'><span class="isBOM"><?= $row['is_BOM'] ?></span><span class="isWarranty"><?= $row['is_warranty'] ?></span><span class="is_stockable"><?= $row['is_stockable'] ?></span></td>
        <td hidden class='text-center td-h'><span class="categoryDetails"><?= $row['category_details'] ?? null ?></span><span class="categoryid"><?= $row['category_id'] ?? null ?></span></span><span class="variantid"><?= $row['variant_id'] ?? null ?></span></td> 
        <td hidden class='text-center td-h'><span class="isTaxIncluded"><?= $row['taxIncluded'] ?></td> 
        <td hidden class='text-center td-h'><span class="description"><?= $row['description'] ?></span><span class="statusData"><?= $row['status'] ?></span><span class="productImgs"><?= $row['image'] ?></span></td> 
        <td hidden class='text-center td-h'><span class="other"><?= $row['otherCharges'] ?></span><span class="displayOthers"><?= $row['displayOthers'] ?></span></td> 
        <td hidden class='text-center td-h'><span class="service"><?= $row['serviceCharge'] ?></span><span class="displayService"><?= $row['displayService'] ?></span></td>
        <td hidden class='text-center td-h'><span hidden class="isDiscounted"><?= $row['discounted'] ?></span><span hidden class="isTax"><?= $row['isVAT'] ?></span></td>
        <td class='text-center td-h'><?= $counter?><span hidden class="productsId"><?= $row['id'] ?></span><span hidden class="oumId"><?= $row['uom_id'] ?></span></td>
        <td class='productsName text-left td-h' style='padding-left: 10px;'><?= $row['prod_desc']?></td>
        <td class='barcode text-center td-h'><?= $row['barcode']?></td>
        <td class='sku text-center td-h'><?= $row['sku']?></td>
        <td class='code text-center td-h'><?= $row['code']?></td>
        <td class='uom_name text-center td-h'><?= $row['uom_name'] ?? null ?></td>
        <td class='brand text-center td-h'><?= $row['brand']?></td>
        <td class='prod_price text-center td-h'><?= $row['prod_price']?></td>
        <td class='markup text-center td-h'><?= $row['markup']?></td>
        <td class='cost text-center td-h'><?= $row['cost']?></td>
        <td class='text-center td-h'>
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
        <td class='status text-center td-h' style='color: <?= ($row['status'] == 1) ? "green" : "red" ?>;'><?= ($row['status'] == 1) ? "Active" : "Inactive" ?></td>
        <td class='text-center action-td td-h'>
                   <a id="editProductLink" class='text-success editProductBtn' style='text-decoration: none;'><svg width="25px" height="25px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title></title> <g id="Complete"> <g id="edit"> <g> <path d="M20,16v4a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V6A2,2,0,0,1,4,4H8" fill="none" stroke=" #FF6900" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path> <polygon fill="none" points="12.5 15.8 22 6.2 17.8 2 8.3 11.5 8 16 12.5 15.8" stroke=" #FF6900" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></polygon> </g> </g> </g> </g></svg></a>
                   <a class='text-success deleteProducts' style='text-decoration: none;'><svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M10 12V17" stroke="#FF6900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M14 12V17" stroke="#FF6900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M4 7H20" stroke="#FF6900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10" stroke="#FF6900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#FF6900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg></a>
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
            <img src="./assets/img/tinkerpro-logo-light.png" alt="No Products Found" style="display: block; margin: 0 auto 10px auto;"><br>
            No Data Found!
        </td>
    </tr>
    <?php
}

$html = ob_get_clean();
echo $html;
?>
<style>
.td-h {
    font-size: 12px;
    margin: 0; 
    padding: 0;
    height: auto; 
}
.highlightedss {
    border: 2px solid #00B050 !important; 
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
