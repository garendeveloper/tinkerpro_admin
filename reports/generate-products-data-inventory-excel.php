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
$selectedOption = $_GET['selectedOption'] ?? null;


if($selectedOption == "sold"){ $sheet->setCellValue('A1', 'No.');
    $sheet->setCellValue('B1', 'Product Name');
    $sheet->setCellValue('C1', 'SKU');
    $sheet->setCellValue('D1', 'Sold');
    $sheet->setCellValue('E1', 'UOM');
    $sheet->setCellValue('F1', 'Cost');
    $sheet->setCellValue('G1', 'Tax');
    $sheet->setCellValue('H1', 'Selling Price');
    $sheet->setCellValue('I1', 'Total(Php)');

}else{
    $sheet->setCellValue('A1', 'No.');
    $sheet->setCellValue('B1', 'Product Name');
    $sheet->setCellValue('C1', 'SKU');
    $sheet->setCellValue('D1', 'Stock');
    $sheet->setCellValue('E1', 'UOM');
    $sheet->setCellValue('F1', 'Cost');
    $sheet->setCellValue('G1', 'Tax');
    $sheet->setCellValue('H1', 'Selling Price');
    $sheet->setCellValue('I1', 'Total(Php)');
}



$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF6900']],
];
$sheet->getStyle('A1:I1')->applyFromArray($headerStyle);



$products = new OtherReportsFacade();



$fetchSales= $products->geProductSalesData($selectedProduct,$selectedCategories,$selectedSubCategories,$singleDateData,$startDate,$endDate,$selectedOption);
$counter = 1; 
if($selectedOption == "sold"){
    while ($row = $fetchSales->fetch(PDO::FETCH_ASSOC)) {

        $sheet->setCellValue('A' . ($counter + 1), $counter); 
        $sheet->setCellValue('B' . ($counter + 1), $row['prod_desc']);
        $sheet->setCellValue('C' . ($counter + 1), $row['sku']); 
        $sheet->setCellValue('D' . ($counter + 1), $row['sold']); 
        $sheet->setCellValue('E' . ($counter + 1), $row['measurement']); 
        $sheet->setCellValue('F' . ($counter + 1), $row['cost']); 
        $sheet->setCellValue('G' . ($counter + 1), $row['totalVat']); 
        $sheet->setCellValue('H' . ($counter + 1), $row['prod_price'] );
        $sheet->setCellValue('I' . ($counter + 1), $row['totalAmount']);
        $counter++;
    }
    

}else{
    while ($row = $fetchSales->fetch(PDO::FETCH_ASSOC)) {

        $sheet->setCellValue('A' . ($counter + 1), $counter); 
        $sheet->setCellValue('B' . ($counter + 1), $row['prod_desc']);
        $sheet->setCellValue('C' . ($counter + 1), $row['sku']); 
        $sheet->setCellValue('D' . ($counter + 1), $row['stock']); 
        $sheet->setCellValue('E' . ($counter + 1), $row['measurement']); 
        $sheet->setCellValue('F' . ($counter + 1), $row['cost']); 
        $sheet->setCellValue('G' . ($counter + 1), $row['totalVat']); 
        $sheet->setCellValue('H' . ($counter + 1), $row['prod_price']);
        $sheet->setCellValue('I' . ($counter + 1), $row['totalAmount']);
        $counter++;
    }

    

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


$writer = new Xlsx($spreadsheet);
$writer->save('product_report.xlsx'); 


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="product_report.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
?>
