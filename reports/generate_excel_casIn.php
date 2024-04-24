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
$sheet->setCellValue('C1', 'Date');
$sheet->setCellValue('D1', 'Note');
$sheet->setCellValue('E1', 'Amounnt');



$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF6900']],
];
$sheet->getStyle('A1:E1')->applyFromArray($headerStyle);



$refundFacade = new OtherReportsFacade();
$products = new ProductFacade();

$userId = $_GET['userId'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;


$fetchRefund= $refundFacade->cashInAmountsData($userId,$singleDateData ,$startDate,$endDate);
$counter = 1;

while ($row = $fetchRefund->fetch(PDO::FETCH_ASSOC)) {
   
    $sheet->setCellValue('A' . ($counter + 1), $counter); 
    $sheet->setCellValue('B' . ($counter + 1),  $row['first_name'] .' '. $row['last_name']);
    $sheet->setCellValue('C' . ($counter + 1), $row['date']);  
    $sheet->setCellValue('D' . ($counter + 1), $row['note']); 
    $sheet->setCellValue('E' . ($counter + 1), $row['amount']); 
  
    $counter++;
}

foreach (range('A', 'E') as $column) {
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
$writer->save('cashEntriesList.xlsx'); 


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="cashEntriesList.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
?>
