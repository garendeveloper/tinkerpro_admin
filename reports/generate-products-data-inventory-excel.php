<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include( __DIR__ . '/../utils/models/other-reports-facade.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$selectedProduct = $_GET['selectedProduct'] ?? null;
$selectedCategories = $_GET['selectedCategories'] ?? null;
$selectedSubCategories = $_GET['selectedSubCategories'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;





    $sheet->setCellValue('A1', 'No.');
    $sheet->setCellValue('B1', 'Product Name');
    $sheet->setCellValue('C1', 'SKU');
    $sheet->setCellValue('D1', 'Sold');
    $sheet->setCellValue('E1', 'Cost');
    $sheet->setCellValue('F1', 'Tax');
    $sheet->setCellValue('G1', 'Selling Price');
    $sheet->setCellValue('H1', 'Total(Php)');





$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF6900']],
];
$sheet->getStyle('A1:H1')->applyFromArray($headerStyle);



$products = new OtherReportsFacade();



$fetchSales= $products->geProductSalesData($selectedProduct,$selectedCategories,$selectedSubCategories,$singleDateData,$startDate,$endDate);
$counter = 1; 
$totalAmount = 0;

    while ($row = $fetchSales->fetch(PDO::FETCH_ASSOC)) {
        $grossAmount = $row['grossAmount'] - $row['itemDiscount'] - $row['overallDiscounts'];
        $totalAmount += $grossAmount ;
        $sheet->setCellValue('A' . ($counter + 1), $counter); 
        $sheet->setCellValue('B' . ($counter + 1), $row['prod_desc']);
        $sheet->setCellValue('C' . ($counter + 1), $row['sku']); 
        $sheet->setCellValue('D' . ($counter + 1),  $row['newQty']); 
        $sheet->setCellValue('E' . ($counter + 1), $row['cost']); 
        $sheet->setCellValue('F' . ($counter + 1), $row['totalVat']); 
        $sheet->setCellValue('G' . ($counter + 1), $row['prod_price'] );
        $sheet->setCellValue('H' . ($counter + 1), $grossAmount);
        $counter++;
    }
    

foreach (range('A', 'H') as $column) {
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


$writer = new Xlsx($spreadsheet);
$writer->save('product_report.xlsx'); 


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="product_report.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
?>
