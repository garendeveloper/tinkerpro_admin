<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/product-facade.php');

$products = new ProductFacade();

$searchQuery = $_GET['searchQuery'] ?? null;
$selectedProduct = $_GET['selectedProduct'] ?? null;
$selectedCategories = $_GET['selectedCategories'] ?? null;
$selectedSubCategories = $_GET['selectedSubCategories'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

$count = $products->getTotalProductsCount();
$recordsPerPage = $count;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

try {
    $fetchProducts = $products->fetchProducts($searchQuery, $selectedProduct, $singleDateData, $startDate, $endDate, $selectedCategories, $selectedSubCategories, $offset, $recordsPerPage);
    
    if (!$fetchProducts) {
        throw new Exception("No data returned from the database.");
    }

    $headers = [
        'Name', 'SKU', 'Barcode', 'Cost', 'Markup', 'Price', 'Tax',
        'IsTaxInclusivePrice', 'IsPriceChangeAllowed', 'IsUsingDefaultQuantity',
        'IsService', 'IsEnabled', 'isDiscounted', 'Stockable','UOM'
    ];

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="productList.csv"');
    header('Cache-Control: max-age=0');
    header('Pragma: public');

    $output = fopen('php://output', 'w');
    if (fputcsv($output, $headers) === false) {
        throw new Exception("Unable to write the header row to the CSV file.");
    }

    foreach ($fetchProducts as $row) {
        $row = (array) $row;
        $data = [
            $row['prod_desc'] ?? '',
            $row['sku'] ?? '',
            $row['barcode'] ?? '',
            $row['cost'] ?? 0,
            $row['markup'] ?? 0,
            $row['prod_price'] ?? 0,
            $row['isVAT'] ?? 0,
            $row['is_taxIncluded'] ?? 0,
            $row['IsPriceChangeAllowed'] ?? 0,
            $row['IsUsingDefaultQuantity'] ?? 0,
            $row['IsService'] ?? 0,
            $row['status'] ?? 0,
            $row['is_discounted'] ?? 0,
            $row['is_stockable'] ?? 0,
            $row['uom_id'] ?? 0,
        ];

        if (fputcsv($output, $data) === false) {
            throw new Exception("Unable to write a data row to the CSV file.");
        }
    }
    fclose($output);
    exit;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
