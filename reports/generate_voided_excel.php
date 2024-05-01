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
$sheet->setCellValue('B1', 'Product');
$sheet->setCellValue('C1', 'Cashier/User');
$sheet->setCellValue('D1', 'Discount');
$sheet->setCellValue('E1', 'Price');
$sheet->setCellValue('F1', 'Qty.');
$sheet->setCellValue('G1', 'Created');
$sheet->setCellValue('H1', 'Voided');
$sheet->setCellValue('I1', 'Reasons');
$sheet->setCellValue('J1', 'Total(Php)');
$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF6900']],
];
$sheet->getStyle('A1:J1')->applyFromArray($headerStyle);



$refundFacade = new OtherReportsFacade();
$products = new ProductFacade();

$selectedProduct = $_GET['selectedProduct'] ?? null;
$userId = $_GET['userId'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

$fetchRefund= $refundFacade-> getVoidedSales($selectedProduct,$userId,$singleDateData,$startDate,$endDate);
$counter = 1;

while ($row = $fetchRefund->fetch(PDO::FETCH_ASSOC)) {
    $sheet->setCellValue('A' . ($counter + 1), $counter); 
    $sheet->setCellValue('B' . ($counter + 1), $row['prod_desc']);
    $sheet->setCellValue('C' . ($counter + 1), $row['first_name'] . ' ' .$row['last_name']); 
    $sheet->setCellValue('D' . ($counter + 1), $row['discount']); 
    $sheet->setCellValue('E' . ($counter + 1), $row['price']); 
    $sheet->setCellValue('F' . ($counter + 1), $row['qty']); 
    $sheet->setCellValue('G' . ($counter + 1), $row['dateCreated']); 
    $sheet->setCellValue('H' . ($counter + 1), $row['voided']); 
    $sheet->setCellValue('I' . ($counter + 1), $row['note']); 
    $sheet->setCellValue('J' . ($counter + 1), $row['subtotal']); 
    $counter++;
}

foreach (range('A', 'J') as $column) {
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
$writer->save('voidList.xlsx'); 

// Force the download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="voidList.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
?>
