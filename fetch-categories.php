<?php
include(__DIR__ . '/utils/db/connector.php');
include(__DIR__ . '/utils/models/product-facade.php');

$productFacade = new ProductFacade;

// Fetch categories
$categories = $productFacade->getCategories();

ob_start();

while ($row = $categories->fetch(PDO::FETCH_ASSOC)) {
    $rowId = htmlspecialchars($row['id']); // Get the row ID
    $categoryName = htmlspecialchars($row['category_name']); // Get the category name
    echo '<p id="paragraph_' . $rowId . '">';
    echo '<a id="anchor_' . $rowId . '" href="#" onclick="fetchIdCategories(\'' . $rowId . '\');highlightRow(this);toggleCheckbox(\'' . $rowId . '\', \'' . $categoryName . '\');" class="productCategory" style="text-decoration: none;" data-value="' . $rowId . '">';
    echo '<span id="mainSpanCategory_' . $rowId . '">+</span>&nbsp;' . $categoryName . '</a>';
    echo '<input hidden type="checkbox" name="categoryCheckbox" class="categoryCheckbox" id="catCheckbox_' . $rowId . '"/></p>';
    echo '<div id="variants_' . $rowId . '"></div>';
}
echo '<span hidden class="inputCat">+<input type="text" id="inputCat" name="category_input" placeholder="Enter Category"></span>';
$html = ob_get_clean();
echo $html;
?>
