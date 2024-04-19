<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/utils/db/connector.php');
include( __DIR__ . '/utils/models/product-facade.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();



$sheet->setCellValue('A1', 'No.');
$sheet->setCellValue('B1', 'SKU');
$sheet->setCellValue('C1', 'Product Name');
$sheet->setCellValue('D1', 'UOM');
$sheet->setCellValue('E1', 'Cost');
$sheet->setCellValue('F1', 'Unit Price');
$sheet->setCellValue('G1', 'Markup(%)');
$sheet->setCellValue('H1', 'Tax');


$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF6900']],
];
$sheet->getStyle('A1:H1')->applyFromArray($headerStyle);



$products = new ProductFacade();

$searchQuery = $_GET['searchQuery'] ?? null;
$selectedProduct = $_GET['selectedProduct'] ?? null;
$selectedCategories = $_GET['selectedCategories'] ?? null;
$selectedSubCategories = $_GET['selectedSubCategories'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

// Fetch users with pagination
$fetchProducts = $products->fetchProducts($searchQuery,$selectedProduct,$singleDateData,$startDate,$endDate,$selectedCategories,$selectedSubCategories);
$counter = 1; // Start numbering from 1

while ($row = $fetchProducts->fetch(PDO::FETCH_ASSOC)) {
    if($row['prod_price'] && $row['isVAT'] == 1){
        $product_price = $row['prod_price'];
        $vatable = round($product_price / 1.12, 2);
        $tax = $product_price - $vatable;

    }
    $sheet->setCellValue('A' . ($counter + 1), $counter); 
    $sheet->setCellValue('B' . ($counter + 1), $row['sku']);
    $sheet->setCellValue('C' . ($counter + 1), $row['prod_desc']); 
    $sheet->setCellValue('D' . ($counter + 1), $row['uom_name']); 
    $sheet->setCellValue('E' . ($counter + 1), $row['cost']); 
    $sheet->setCellValue('F' . ($counter + 1), $row['prod_price']); 
    $sheet->setCellValue('G' . ($counter + 1), $row['markup']); 
    $sheet->setCellValue('H' . ($counter + 1), $row['isVAT'] == 1 ? $tax : "");
    $counter++;
}

foreach (range('A', 'G') as $column) {
    $sheet->getColumnDimension($column)->setAutoSize(true);
}

$lastRow = $sheet->getHighestRow();
$lastColumn = $sheet->getHighestColumn();
$range = 'A1:' . $lastColumn . $lastRow;
$style = [
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];
$sheet->getStyle($range)->applyFromArray($style);

// Save the Excel file
$writer = new Xlsx($spreadsheet);
$writer->save('productList.xlsx'); // Save the file with a given filename

// Force the download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="productList.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
?>
