<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include(__DIR__ . '/../utils/models/product-facade.php');
include(__DIR__ . '/../utils/models/expense-facade.php');
include( __DIR__ . '/../utils/models/loss_and_damage-facade.php');
include( __DIR__ . '/../utils/models/dashboard-facade.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


$dashboard = new DashboardFacade();
$lossanddamageFacade = new Loss_and_damage_facade();
$products = new ProductFacade();
$expenses = new ExpenseFacade();

$counter = 1;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);


$singleDateData = $singleDateData ? $singleDateData : date('Y-m-d');
$startDates = strtotime($startDate);
$formattedStartDate = date('F j, Y', $startDates);

$endDates = strtotime($endDate);
$formattedEndDate = date('F j, Y', $endDates);

$singleDateDatas = strtotime($singleDateData);
$formattedSingleDate = date('F j, Y', $singleDateDatas);
$current_date = $singleDateData ? $formattedSingleDate : $formattedStartDate." - ".$formattedEndDate;

$sales = $dashboard->get_allRevenues($startDate, $endDate, $singleDateData);
$total_sales = $sales['total_sales'] ?? 0;
$other_income = 0;
$lossanddamages = $lossanddamageFacade->get_consolidatedLossAndDamages($startDate, $endDate, $singleDateData);
$lossanddamages = $lossanddamages['totalAmountDamage'] ?? 0;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->getColumnDimension('A')->setWidth(10); 
$sheet->getColumnDimension('B')->setWidth(40);
$sheet->getColumnDimension('C')->setWidth(20);

$sheet->setCellValue('A1', 'Revenue');
$sheet->setCellValue('B1', '');
$sheet->mergeCells('A1:B1');
$sheet->setCellValue('C1', $current_date);
$sheet->getStyle('C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F5F5F5']],
];
$sheet->getStyle('A1:C1')->applyFromArray($headerStyle);

$sheet->setCellValue('A' . 2, ''); 
$sheet->setCellValue('B' . 2, 'Sales');
$sheet->setCellValue('C' . 2, number_format($total_sales, 2, '.', ','));
$cellRange = 'A2:B2'; 
$sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);

$sheet->setCellValue('A' . 3, ''); 
$sheet->setCellValue('B' . 3, 'Other income');
$sheet->setCellValue('C' . 3, number_format($other_income, 2, '.', ','));
$cellRange = 'A3:B3'; 
$sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);

$total_revenues = $total_sales + $other_income;
$sheet->getStyle('A4:C4')->applyFromArray($headerStyle);
$sheet->setCellValue('A4', 'Total Revenues');
$sheet->setCellValue('B4', '');
$sheet->mergeCells('A4:B4');
$sheet->setCellValue('C4', number_format($total_revenues, 2, '.', ','));
$sheet->getStyle('C4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

$sheet->getStyle('A5:C5')->applyFromArray($headerStyle);
$sheet->setCellValue('A5', 'Expenses');
$sheet->setCellValue('B5', '');
$sheet->mergeCells('A5:B5');
$sheet->setCellValue('C5', '');
$sheet->getStyle('C5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

$expenses = $expenses->get_allExpensesByGroup($startDate, $endDate, $singleDateData);
$rowIndex = 6;
$total_expenses = 0;
if($expenses)
{
    foreach($expenses as $row_data)
    {
        $sheet->setCellValue('A' . $rowIndex, ''); 
        $sheet->setCellValue('B' . $rowIndex, $row_data['expense_type']); 
        $sheet->setCellValue('C' . $rowIndex, number_format($row_data['expense_amount'], 2, '.', ','));
        $font = $sheet->getStyle('C'. $rowIndex)->getFont();
        $font->getColor()->setARGB('FFFF0000');
        $sheet->getStyle('C' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $total_expenses += $row_data['expense_amount'];
        $rowIndex++;
    }
}
else
{
    $sheet->setCellValue('A' . $rowIndex, ''); 
    $sheet->setCellValue('B' . $rowIndex, ''); 
    $sheet->setCellValue('C' . $rowIndex, '---');
    $sheet->getStyle('C' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
}

$lastIndex = $rowIndex;
$sheet->getStyle('A'.$lastIndex.':C'.$lastIndex)->applyFromArray($headerStyle);
$sheet->setCellValue('A'.$lastIndex, 'Total Expenses');
$sheet->setCellValue('B'.$lastIndex, '');
$sheet->mergeCells('A'.$lastIndex.':B'.$lastIndex);
$sheet->setCellValue('C'.$lastIndex, number_format($total_expenses, 2, '.', ','));
$sheet->getStyle('C'.$lastIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

$lastIndex = $lastIndex+1;
$net_incomeBefTax = $total_revenues - $total_expenses;
$sheet->setCellValue('A' . $lastIndex, ''); 
$sheet->setCellValue('B' . $lastIndex, 'Net Income Before Taxes'); 
$sheet->setCellValue('C' . $lastIndex, number_format($net_incomeBefTax, 2, '.', ','));
$sheet->getStyle('C' . $lastIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

$lastIndex = $lastIndex+1;
$net_incomeAfterTax = 0;
$sheet->setCellValue('A' . $lastIndex, ''); 
$sheet->setCellValue('B' . $lastIndex, 'Net Income After Taxes'); 
$sheet->setCellValue('C' . $lastIndex, number_format($net_incomeAfterTax, 2, '.', ','));
$sheet->getStyle('C' . $lastIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

$lastIndex = $lastIndex+1;
$income_conOperations = $net_incomeBefTax - 0;
$sheet->getStyle('A'.$lastIndex.':C'.$lastIndex)->applyFromArray($headerStyle);
$sheet->setCellValue('A'.$lastIndex, 'Income from Continuing Operations');
$sheet->setCellValue('B'.$lastIndex, '');
$sheet->mergeCells('A'.$lastIndex.':B'.$lastIndex);
$sheet->setCellValue('C'.$lastIndex, number_format($income_conOperations, 2, '.', ','));
$sheet->getStyle('C'.$lastIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

$lastIndex = $lastIndex+1;
$sheet->getStyle('A'.$lastIndex.':C'.$lastIndex)->applyFromArray($headerStyle);
$sheet->setCellValue('A'.$lastIndex, 'Below-the-line Items');
$sheet->setCellValue('B'.$lastIndex, '');
$sheet->mergeCells('A'.$lastIndex.':B'.$lastIndex);
$sheet->setCellValue('C'.$lastIndex, '');
$font = $sheet->getStyle('C'. $lastIndex)->getFont();
$font->getColor()->setARGB('FFFF0000');
$sheet->getStyle('C'.$lastIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

$lastIndex = $lastIndex+1;
$sheet->setCellValue('A' . $lastIndex, ''); 
$sheet->setCellValue('B' . $lastIndex, 'Loss and Damage Product'); 
$sheet->setCellValue('C' . $lastIndex, number_format($lossanddamages, 2, '.', ','));
$font = $sheet->getStyle('C'. $lastIndex)->getFont();
$font->getColor()->setARGB('FFFF0000');
$sheet->getStyle('C' . $lastIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

$lastIndex = $lastIndex+1;
$net_income = $income_conOperations - $lossanddamages;
$sheet->getStyle('A'.$lastIndex.':C'.$lastIndex)->applyFromArray($headerStyle);
$sheet->setCellValue('A'.$lastIndex, 'Net Income');
$sheet->setCellValue('B'.$lastIndex, '');
$sheet->mergeCells('A'.$lastIndex.':B'.$lastIndex);
$sheet->setCellValue('C'.$lastIndex, number_format($net_income, 2, '.', ','));
$sheet->getStyle('C'.$lastIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

$lastColumn = $sheet->getHighestColumn();
$lastRow = $sheet->getHighestRow();
$range = 'A1:' . $lastColumn . $lastRow;

$filename = 'income_statement.xlsx';
$writer = new Xlsx($spreadsheet);
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;
?>
