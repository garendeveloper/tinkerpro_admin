<?php
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/product-facade.php');

$productFacade = new ProductFacade;

// Fetch categories
$categories = $productFacade->getCategories();

ob_start();

$index = 0; // Initialize index counter
while ($row = $categories->fetch(PDO::FETCH_ASSOC)) {
    $rowId = htmlspecialchars($row['id']); 
    $categoryName = htmlspecialchars($row['category_name']); 
    echo '<p id="paragraph_' . $rowId . '" class="categoriesParagraph">';
    echo '<a id="anchor_' . $rowId . '" href="#" class="customAnchor" data-category-name="' .  $categoryName . '" data-index="' . $index . '" data-category-id="' . $rowId . '">';
    echo '<span id="mainSpanCategory_' . $rowId . '">+</span>&nbsp;' . $categoryName . '</a>';
    echo '<div id="variants_' . $rowId . '"></div>';
    echo '</p>';
    $index++;
}
echo '<span hidden class="inputCat">+<input type="text" id="inputCat" name="category_input" placeholder="Enter Category" onkeydown="addCtgory(event)"></span>';
$html = ob_get_clean();
echo $html;
?>
<style>
    .customAnchor {
    text-decoration: none; 
    color: white;
    margin: 0;
    padding: 0 
}
.customAnchor:hover{
    color: #FF6900;
}
</style>
