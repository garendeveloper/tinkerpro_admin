<?php
require_once  './vendor/autoload.php';
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include(__DIR__ . '/../utils/models/product-facade.php');
include(__DIR__ . '/../utils/models/expense-facade.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'No.');
$sheet->setCellValue('B1', 'Item Name');
$sheet->setCellValue('C1', 'Date of Transaction');
$sheet->setCellValue('D1', 'Billable');
$sheet->setCellValue('E1', 'Type');
$sheet->setCellValue('F1', 'Quantity');
$sheet->setCellValue('G1', 'UOM');
$sheet->setCellValue('H1', 'Supplier');
$sheet->setCellValue('I1', 'Invoice Number');
$sheet->setCellValue('J1', 'Price (Php)');
$sheet->setCellValue('K1', 'Discount');
$sheet->setCellValue('L1', 'Total Amount (Php)');

$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF6900']],
];
$sheet->getStyle('A1:L1')->applyFromArray($headerStyle);

$refundFacade = new OtherReportsFacade();
$products = new ProductFacade();
$expenses = new ExpenseFacade();

$counter = 1;
$expenses_data = $expenses->get_data();
$total_expenses = 0;

foreach ($expenses_data as $row_data) {
    $rowIndex = $counter + 1; 
    $item_name = $row_data['item_name'] === "" ? $row_data['product'] : $row_data['item_name'];
    $sheet->setCellValue('A' . $rowIndex, $counter); 
    $sheet->setCellValue('B' . $rowIndex, $item_name);
    $sheet->setCellValue('C' . $rowIndex, $row_data['dot']); 
    $sheet->setCellValue('D' . $rowIndex, $row_data['billable_receipt_no']); 
    $sheet->setCellValue('E' . $rowIndex, $row_data['expense_type']);
    $sheet->setCellValue('F' . $rowIndex, $row_data['quantity']); 
    $sheet->setCellValue('G' . $rowIndex, $row_data['uom_name']);
    $sheet->setCellValue('H' . $rowIndex, $row_data['supplier']); 
    $sheet->setCellValue('I' . $rowIndex, $row_data['invoice_number']); 
    $sheet->setCellValue('J' . $rowIndex, number_format($row_data['price'], 2)); 
    $sheet->setCellValue('K' . $rowIndex, number_format($row_data['discount'], 2)); 
    $sheet->setCellValue('L' . $rowIndex, number_format($row_data['total_amount'], 2)); 

    $sheet->getStyle('A' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('B' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $sheet->getStyle('C' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('D' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('E' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $sheet->getStyle('F' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('G' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('H' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $sheet->getStyle('I' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('J' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    $sheet->getStyle('K' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    $sheet->getStyle('L' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

    $total_expenses += $row_data['total_amount'];
   
    $counter++;
}

$lastRowIndex = $counter + 1; 
$sheet->mergeCells('A' . $lastRowIndex . ':K' . $lastRowIndex);
$sheet->setCellValue('A' . $lastRowIndex, 'Total Expenses');
$sheet->getStyle('A' . $lastRowIndex)->getFont()->setBold(true);
$sheet->getStyle('A' . $lastRowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->setCellValue('L' . $lastRowIndex, number_format($total_expenses, 2));

foreach (range('A', 'L') as $column) {
    $sheet->getColumnDimension($column)->setAutoSize(true);
}

$lastColumn = $sheet->getHighestColumn();
$lastRow = $sheet->getHighestRow();
$range = 'A1:' . $lastColumn . $lastRow;

$styleArray = [
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];

$sheet->getStyle($range)->applyFromArray($styleArray);

$filename = 'overall_expenses.xlsx';
$writer = new Xlsx($spreadsheet);
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;
?>
