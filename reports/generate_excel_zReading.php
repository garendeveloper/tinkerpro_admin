<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$refundFacade = new OtherReportsFacade();
$products = new ProductFacade();

$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

$fetchRefund = $refundFacade->zReadingReport($singleDateData, $startDate, $endDate);
$counter = 1;

while ($row = $fetchRefund->fetch(PDO::FETCH_ASSOC)) {
    $sheet->setCellValue('B2', $row['beg_si']);
    $sheet->setCellValue('B3', $row['end_si']);
    $sheet->setCellValue('B4', $row['void_beg']);
    $sheet->setCellValue('B5', $row['void_end']);
    $sheet->setCellValue('B6', $row['return_beg']);
    $sheet->setCellValue('B7', $row['return_end']);
    $sheet->setCellValue('B8', $row['refund_beg']);
    $sheet->setCellValue('B9', $row['refund_end']);
    $sheet->setCellValue('B10',  '');
    $sheet->setCellValue('B11', '');
    $sheet->setCellValue('B12', number_format($row['total_present_accumulated_sale'] ?? 0, 2));
    $sheet->setCellValue('B13', number_format($row['total_previous_accumulated_sale'] ?? 0, 2));
    $sheet->setCellValue('B14', number_format($row['total_sales'] ?? 0, 2));
    $sheet->setCellValue('B15', '');
    $sheet->setCellValue('B16',  number_format($row['total_vatable_sales'] ? $row['total_vatable_sales'] : 0, 2));
    $sheet->setCellValue('B17',  number_format($row['total_vat_amount'] ? $row['total_vat_amount'] : 0, 2));
    $sheet->setCellValue('B18',  number_format($row['total_vat_exempt'] ? $row['total_vat_exempt'] : 0, 2));
    $sheet->setCellValue('B19',  number_format(0,2));
  
    $sheet->setCellValue('B20',  number_format($row['total_gross_amount'] ? $row['total_gross_amount'] : 0, 2));
    $sheet->setCellValue('B21',  number_format($row['total_less_discount'] ? $row['total_less_discount'] : 0, 2));
    $sheet->setCellValue('B22',   number_format($row['total_less_return_amount'] ? $row['total_less_return_amount']: 0,2));
    $sheet->setCellValue('B23',    number_format($row['total_less_refund_amount'] ? $row['total_less_refund_amount'] : 0,2));
    $sheet->setCellValue('B24',   number_format($row['total_less_void'] ? $row['total_less_void'] : 0, 2));
    $sheet->setCellValue('B25',    number_format($row['total_less_vat_adjustment'] ? $row['total_less_vat_adjustment'] : 0, 2));
    $sheet->setCellValue('B26',    number_format($row['total_net_amount'] ??0,2));
    $sheet->setCellValue('B27', '');
    $sheet->setCellValue('B28',   number_format($row['total_senior_discount'] ?? 0,2));
    $sheet->setCellValue('B29',   number_format($row['total_officer_discount'] ?? 0,2));
    $sheet->setCellValue('B30',   number_format($row['total_pwd_discount'] ?? 0,2));
    $sheet->setCellValue('B31',   number_format($row['total_naac_discount'] ?? 0,2));
    $sheet->setCellValue('B32',   number_format($row['total_solo_parent_discount'] ?? 0,2));
    $sheet->setCellValue('B33',   number_format($row['total_other_discount'] ?? 0,2));
    $sheet->setCellValue('B34', '');
    $sheet->setCellValue('B35', number_format($row['total_void'] ?? 0,2));
    $sheet->setCellValue('B36', number_format($row['total_return'] ?? 0,2));
    $sheet->setCellValue('B37', number_format($row['total_refund'] ?? 0,2));
    $sheet->setCellValue('B38', '');
    $sheet->setCellValue('B39', number_format($row['total_senior_citizen_vat'] ?? 0,2));
    $sheet->setCellValue('B40', number_format($row['total_officers_vat'] ?? 0,2));
    $sheet->setCellValue('B41', number_format($row['total_pwd_vat'] ?? 0,2));
    $sheet->setCellValue('B42', number_format($row['total_zero_rated'] ?? 0,2));
    $sheet->setCellValue('B43', number_format($row['total_void_vat'] ?? 0,2));
    $sheet->setCellValue('B44', number_format($row['total_vat_return'] ?? 0,2));
    $sheet->setCellValue('B45', number_format($row['total_vat_refunded'] ?? 0,2));
    $sheet->setCellValue('B46','');
    $sheet->setCellValue('B47', number_format($row['total_cash_in_receive'] ?? 0,2));
    $sheet->setCellValue('B48', number_format($row['total_totalCcDb'] ?? 0,2));
    $sheet->setCellValue('B49', number_format($row['total_totalEwallet'] ?? 0,2));
    $sheet->setCellValue('B50', number_format($row['total_totalCoupon'] ?? 0,2));
    $sheet->setCellValue('B51', number_format($row['total_credit'] ?? 0,2));
    $sheet->setCellValue('B52', number_format($row['total_totalCashIn'] ?? 0,2));
    $sheet->setCellValue('B53', number_format($row['total_totalCashOut'] ?? 0,2));
    $sheet->setCellValue('B54', number_format($row['total_payment_receive'] ?? 0,2));
}

$lastRow = $sheet->getHighestRow();
$lastColumn = $sheet->getHighestColumn();
$range = 'A1:' . $lastColumn . $lastRow;

$sheet->mergeCells('A1:B1');

$sheet->setCellValue('A1', 'Report Details');
$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '85929E']],
];
$sheet->getStyle('A1')->applyFromArray($headerStyle);




$sheet->setCellValue('A2', 'Beg. SI');
$sheet->setCellValue('A3', 'End. SI');
$sheet->setCellValue('A4', 'Beg. Void');
$sheet->setCellValue('A5', 'End. Void');
$sheet->setCellValue('A6', 'Beg. Return');
$sheet->setCellValue('A7', 'End. Return');
$sheet->setCellValue('A8', 'Beg. Refund');
$sheet->setCellValue('A9', 'End. Refund');

$sheet->setCellValue('A10', 'Description');
$sheet->setCellValue('B10', 'Amount');
$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '7DCEA0']],
];
$sheet->getStyle('A10:B10')->applyFromArray($headerStyle);

$sheet->mergeCells('A11:B11');
$sheet->setCellValue('A11', 'ITEMS');
$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '85929E']],
];
$sheet->getStyle('A11')->applyFromArray($headerStyle);


$sheet->setCellValue('A12', 'Present Accumulated Sales');
$sheet->setCellValue('A13', 'Previous Accumulated Sales');
$sheet->setCellValue('A14', 'Sales for Today');
$sheet->mergeCells('A15:B15');
$sheet->setCellValue('A15', 'BREAKDOWN OF SALES');
$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '85929E']],
];
$sheet->getStyle('A15')->applyFromArray($headerStyle);

$sheet->setCellValue('A16', 'Vatable Sales');
$sheet->setCellValue('A17', 'VAT Amount');
$sheet->setCellValue('A18', 'VAT Exempt Sales');
$sheet->setCellValue('A19', 'Zero Rated Sales');
$sheet->setCellValue('A20', 'Gross Amount');
$sheet->setCellValue('A21', 'Less Discount');
$sheet->setCellValue('A22', 'Less Return');
$sheet->setCellValue('A23', 'Less Refund');
$sheet->setCellValue('A24', 'Less Void');
$sheet->setCellValue('A25', 'Less VAT Adjsutment');
$sheet->setCellValue('A26', 'Net Amount');
$sheet->mergeCells('A27:B27');
$sheet->setCellValue('A27', 'DISCOUNT SUMMARY');
$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '85929E']],
];
$sheet->getStyle('A27')->applyFromArray($headerStyle);


$sheet->setCellValue('A28', 'SC Discount');
$sheet->setCellValue('A29', 'UP Discount');
$sheet->setCellValue('A30', 'PWD Discount');
$sheet->setCellValue('A31', 'NAAC Discount');
$sheet->setCellValue('A32', 'SOLO Parent Discount');
$sheet->setCellValue('A33', 'Other Discount');
$sheet->mergeCells('A34:B34');
$sheet->setCellValue('A34', 'SALES ADJUSTMENT');
$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '85929E']],
];
$sheet->getStyle('A34')->applyFromArray($headerStyle);


$sheet->setCellValue('A35', 'Void');
$sheet->setCellValue('A36', 'Return');
$sheet->setCellValue('A37', 'Refund');
$sheet->mergeCells('A38:B38');
$sheet->setCellValue('A38', 'VAT ADJUSTMENT');
$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '85929E']],
];
$sheet->getStyle('A38')->applyFromArray($headerStyle);


$sheet->setCellValue('A39', 'SC VAT');
$sheet->setCellValue('A40', 'UP VAT');
$sheet->setCellValue('A41', 'PWD VAT');
$sheet->setCellValue('A42', 'Zero Rated VAT');
$sheet->setCellValue('A43', 'Void VAT');
$sheet->setCellValue('A44', 'VAT on Return');
$sheet->setCellValue('A45', 'VAT on Refund');
$sheet->mergeCells('A46:B46');
$sheet->setCellValue('A46', 'TRANSACTION SUMMARY');
$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '85929E']],
];
$sheet->getStyle('A46')->applyFromArray($headerStyle);


$sheet->setCellValue('A47', 'Cash in Drawer');
$sheet->setCellValue('A48', 'Credit/Debit Card');
$sheet->setCellValue('A49', 'E-wallet');
$sheet->setCellValue('A50', 'Coupon/Voucher');
$sheet->setCellValue('A51', 'Credit');
$sheet->setCellValue('A52', 'Cash In');
$sheet->setCellValue('A53', 'Cash Out');
$sheet->setCellValue('A54', 'Payment Receieve');
$headerStyle = [
    'font' => ['bold' => true],
];
$sheet->getStyle('A10:B10')->applyFromArray($headerStyle);

$sheet->getStyle('A2:B9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('A12:B14')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('A10:B' . $lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('A1:B' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


// Adjust column widths
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setWidth(15);


$writer = new Xlsx($spreadsheet);
$writer->save('zReadingList.xlsx'); 


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="zReadingList.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
?>
