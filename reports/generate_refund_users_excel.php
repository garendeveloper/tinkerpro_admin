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
$sheet->setCellValue('B1', 'Customer Name');
$sheet->setCellValue('C1', 'Refund Type.');
$sheet->setCellValue('D1', 'Quantity');
$sheet->setCellValue('E1', 'Refund No.');
$sheet->setCellValue('F1', 'Amount');
$sheet->setCellValue('G1', 'Date');


$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF6900']],
];
$sheet->getStyle('A1:G1')->applyFromArray($headerStyle);



$refundFacade = new OtherReportsFacade();
$products = new ProductFacade();

$selectedCustomers = $_GET['selectedCustomers'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;
$selectedRefundTypes = $_GET['selectedRefundTypes'] ?? null;

$fetchRefund= $refundFacade->getRefundByCustomers($selectedCustomers,$singleDateData,$startDate,$endDate,$selectedRefundTypes);
$counter = 1;

$methodTypes = [
    1 => 'Cash',
    7 => 'Voucher',
    2 => 'GCash',
    3 => 'Pay Maya',
    4 => 'Grab Pay',
    8 => 'Ali Pay',
    9 => 'Shopee Pay',
    5 => 'Visa',
    6 => 'Master Card',
    10 => 'Discover',
    11 => 'American Express',
    12 => 'JCB'
];


while ($row = $fetchRefund->fetch(PDO::FETCH_ASSOC)) {
   
    $sheet->setCellValue('A' . ($counter + 1), $counter); 
    $sheet->setCellValue('B' . ($counter + 1), $row['user_first_name'] .' '. $row['user_last_name']);
    $refundType = $methodTypes[$row['refundType']] ?? '';
    $sheet->setCellValue('C' . ($counter + 1), $refundType);
    $sheet->setCellValue('D' . ($counter + 1), $row['qty']); 
    $sheet->setCellValue('E' . ($counter + 1), $row['reference_num']); 
    $sheet->setCellValue('F' . ($counter + 1), $row['amount']); 
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
$writer->save('refundList.xlsx'); // Save the file with a given filename

// Force the download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="refundList.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
?>
