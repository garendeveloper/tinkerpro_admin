<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();



$sheet->setCellValue('A1', 'Customer');
$sheet->setCellValue('B1', 'Cash');
$sheet->setCellValue('C1', 'E-Wallet');
$sheet->setCellValue('D1', 'Credit/Debit Cards');
$sheet->setCellValue('E1', 'Credit');
$sheet->setCellValue('F1', 'Coupons');
$sheet->setCellValue('G1', 'Total(Php)');


$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF6900']],
];
$sheet->getStyle('A1:G1')->applyFromArray($headerStyle);



$refundFacade = new OtherReportsFacade();
$products = new ProductFacade();

$exclude = $_GET['exclude'] ?? null;
$customerId = $_GET['customerId'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

$fetchRefund= $refundFacade->getPaymentMethodByCustomer($customerId,$singleDateData,$startDate,$endDate,$exclude);

$rowIndex = 2;
while ($row = $fetchRefund->fetch(PDO::FETCH_ASSOC)) {
    $sheet->setCellValue('A' . $rowIndex, $row['firstname'] .' '. $row['lastname']);
    $sheet->setCellValue('B' . $rowIndex, $row['cash_total']);
    $sheet->setCellValue('C' . $rowIndex, $row['e_wallet_total']);
    $sheet->setCellValue('D' . $rowIndex, $row['cdcards_total']);
    $sheet->setCellValue('E' . $rowIndex, $row['credit_total']);
    $sheet->setCellValue('F' . $rowIndex, $row['coupons_total']);
    $sheet->setCellValue('G' . $rowIndex, $row['total_amount']);
    $rowIndex++;
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
$writer->save('paymentMethodList.xlsx'); // Save the file with a given filename

// Force the download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="paymentMethodList.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
?>
