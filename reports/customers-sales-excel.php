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
$sheet->setCellValue('B1', 'Customer');
$sheet->setCellValue('C1', 'Total');




$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF6900']],
];
$sheet->getStyle('A1:C1')->applyFromArray($headerStyle);



$refundFacade = new OtherReportsFacade();
$products = new ProductFacade();


$customerId = $_GET['customerId'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

$fetchRefund= $refundFacade->customerSales($customerId,$singleDateData,$startDate,$endDate);
$counter = 1;
$totalSales = 0;
while ($row = $fetchRefund->fetch(PDO::FETCH_ASSOC)) {

    $paid_amount = $row['paid_amount'];
    $totalChange = $row['totalChange'];

    $sales = $paid_amount - $totalChange;

    //refund data
    $refunded_amt = $row['refunded_amt'];
    $refudned_item_discount = $row['total_item_discounts'];
    $refund_credits = $row['totalCredits'];
    $totalRefundDiscountsTendered = $row['totalDiscountsTender'];

    //calcualtion for other payments
    $otherRefundPayments = $row['totalOtherPayments'];
    $cartDiscountAmount = $row['cartRefundTotal'];

    $totalRefundedAmt =  $refunded_amt-$refudned_item_discount- $totalRefundDiscountsTendered-$cartDiscountAmount;
   
    

    //return
    $return_amount = $row['return_amt'];
    $return_item_discounts = $row['total_return_item_discounts'];
    $return_credits = $row['totalReturnCredits'];
    $totalReturnDiscountsTender = $row['totalDiscountsReturnTender'];

        //calcualtion for other payments
        $otherReturnPayments = $row['totalOtherReturnPayments'];
        $cartDiscountReturnAmount = $row['cartReturnTotal'];

    $totalReturnAmt = $return_amount-$return_item_discounts-$totalReturnDiscountsTender-$cartDiscountReturnAmount;

    $totalGrossSales = $sales-$totalRefundedAmt-$totalReturnAmt;
    $totalSales += $totalGrossSales;
   
    $sheet->setCellValue('A' . ($counter + 1), $counter); 
    $sheet->setCellValue('B' . ($counter + 1), $row['last_name'] . ' ' . $row['first_name']);
    $sheet->setCellValue('C' . ($counter + 1),  $totalGrossSales); 
 
   
    $counter++;
}

foreach (range('A', 'C') as $column) {
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
$writer->save('customerSales.xlsx');


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="customerSales.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
?>
