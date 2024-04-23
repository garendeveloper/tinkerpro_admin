<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();



$sheet->setCellValue('A1', 'No.');
$sheet->setCellValue('B1', 'Product Name');
$sheet->setCellValue('C1', 'Product Price');
$sheet->setCellValue('D1', 'Quantity');
$sheet->setCellValue('E1', 'Reference No.');
$sheet->setCellValue('F1', 'Total Amount');
$sheet->setCellValue('G1', 'Date');


$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF6900']],
];
$sheet->getStyle('A1:G1')->applyFromArray($headerStyle);



$refundFacade = new OtherReportsFacade();
$products = new ProductFacade();

$selectedProduct = $_GET['selectedProduct'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

$fetchRefund= $refundFacade->getReturnAndEx($selectedProduct,$singleDateData,$startDate,$endDate);
$counter = 1;

while ($row = $fetchRefund->fetch(PDO::FETCH_ASSOC)) {
   
    $sheet->setCellValue('A' . ($counter + 1), $counter); 
    $sheet->setCellValue('B' . ($counter + 1), $row['prod_desc']);
    $sheet->setCellValue('C' . ($counter + 1), $row['prod_price']); 
    $sheet->setCellValue('D' . ($counter + 1), $row['qty']); 
    $receipt_id = str_pad($row['receipt_id'], 9, '0', STR_PAD_LEFT);
    $sheet->setCellValue('E' . ($counter + 1), $receipt_id); 
    $sheet->setCellValue('F' . ($counter + 1), $row['return_amount']); 
    $sheet->setCellValue('G' . ($counter + 1), $row['date']); 
   
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
$writer->save('returnAndExchangeList.xlsx'); // Save the file with a given filename

// Force the download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="returnAndExchangeList.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
?>
