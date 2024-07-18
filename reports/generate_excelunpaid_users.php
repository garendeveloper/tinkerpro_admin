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
$sheet->setCellValue('B1', 'Cashier Name');
$sheet->setCellValue('C1', 'Receipt No.');
$sheet->setCellValue('D1', 'Date');
$sheet->setCellValue('E1', 'Partial Payement');
$sheet->setCellValue('F1', 'Credit Amount');
$sheet->setCellValue('G1', 'Balance');


$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF6900']],
];
$sheet->getStyle('A1:G1')->applyFromArray($headerStyle);



$refundFacade = new OtherReportsFacade();
$products = new ProductFacade();

$selectedCustomers= $_GET['selectedCustomers'] ?? null;
$userId = $_GET['userId'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

$fetchRefund= $refundFacade-> getUnpaidSales($selectedCustomers,$userId,$singleDateData,$startDate,$endDate);
$counter = 1;

while ($row = $fetchRefund->fetch(PDO::FETCH_ASSOC)) {
   
    $sheet->setCellValue('A' . ($counter + 1), $counter); 
    $sheet->setCellValue('B' . ($counter + 1), $row['c_lastname'] . ' ' . $row['c_firstname']);
    $receipt_id = str_pad($row['receipt_id'], 9, '0', STR_PAD_LEFT);
    $sheet->setCellValue('C' . ($counter + 1), $receipt_id);  
    $sheet->setCellValue('D' . ($counter + 1), $row['date']); 
    $sheet->setCellValue('E' . ($counter + 1), $row['total_paid_amount']); 
    $sheet->setCellValue('F' . ($counter + 1), $row['credit_amount']); 
    $sheet->setCellValue('G' . ($counter + 1), $row['balance']); 
   
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
$writer->save('unpaidSalesList.xlsx'); // Save the file with a given filename

// Force the download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="unpaidSalesList.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
?>
