<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');
include( __DIR__ . '/../utils/models/expense-facade.php');
include( __DIR__ . '/../utils/models/loss_and_damage-facade.php');
include( __DIR__ . '/../utils/models/dashboard-facade.php');

session_start();
date_default_timezone_set('Asia/Manila');
$pdfFolder = __DIR__ . '/../assets/pdf/income_statement/';

$files = glob($pdfFolder . '*'); 
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file); 
    }
}

function autoAdjustFontSize($pdf, $text, $maxWidth, $initialFontSize = 8) 
{
    $pdf->SetFont('', '', $initialFontSize);
    while ($pdf->GetStringWidth($text) > $maxWidth) {
        $initialFontSize--;
        $pdf->SetFont('', '', $initialFontSize);
    }
    return $initialFontSize;
}

$otherFacade = new OtherReportsFacade();
$products = new ProductFacade();
$expenses = new ExpenseFacade();
$dashboard = new DashboardFacade();
$lossanddamageFacade = new Loss_and_damage_facade();

$counter = 1;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);

if((empty($startDate) && empty($endDate)) && !empty($singleDateData))
{
    $startDate = $singleDateData;
    $endDate = $singleDateData;
}
if((empty($startDate) && empty($endDate)) && empty($singleDateData))
{
    $startDate = date('Y-m-d');
    $endDate = date('Y-m-d');
}

$pdf = new TCPDF();
$pdf->SetCreator('TinkerPro Inc.');
$pdf->SetAuthor('TinkerPro Inc.');
$pdf->SetTitle('Income Statement Table PDF');
$pdf->SetSubject('Income Statement PDF Document');
$pdf->SetKeywords('TCPDF, PDF, Expenses, table');
$pdf->AddPage();


// $pdf->SetCellHeightRatio(1.5);
// $imageFile = './../assets/img/tinkerpro-logo-dark.png'; 
// $imageWidth = 45; 
// $imageHeight = 15; 
// $imageX = 10; 
// $pdf->Image($imageFile, $imageX, $y = 10, $w = $imageWidth, $h = $imageHeight, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);
$pdf->SetCellHeightRatio(1.5);
$ipAddress = gethostbyname(gethostname());
$imageFile = "http://".$ipAddress."/tinkerpros/www/assets/company_logo/".$shop['company_logo'];

$imageWidth = 20; 
$imageHeight = 12; 
$imageX = 10; 
$serverFilePath = $_SERVER['DOCUMENT_ROOT'] . "/tinkerpros/www/assets/company_logo/{$shop['company_logo']}";
$pdf->Image($serverFilePath, $imageX, $y = 10, $w = $imageWidth, $h = $imageHeight, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);
$pdf->SetFont('', 'I', 8);
$pdf->SetFont('', 'I', 8);


$pdf->SetFont('', 'B', 10);
$pdf->Cell(0, 10, 'Income Statement', 0, 1, 'R', 0); 
$pdf->Ln(-5);
$pdf->SetFont('',  10);
$pdf->Cell(0, 10, "{$shop['shop_name']}", 0, 1, 'R', 0); 

$pdf->Ln(-3);
$pdf->SetFont('', '', 10); 
$pdf->MultiCell(0, 10, "{$shop['shop_address']}", 0, 'R');
$pdf->Ln(-6);
$pdf->SetFont('', '', 10); 
$pdf->MultiCell(0, 10, "{$shop['shop_email']}", 0, 'R');
$pdf->Ln(-12);
$pdf->SetFont('', '', 8); 
$pdf->MultiCell(0, 10, "Contact: {$shop['contact_number']}", 0, 'L');

$pdf->Ln(-3);
$pdf->SetFont('' , 10); 
$pdf->MultiCell(0, 10, "VAT REG TIN: {$shop['tin']}", 0, 'R');
$pdf->Ln(-6);
$pdf->SetFont('' , 8); 
$pdf->MultiCell(0, 10, "MIN: {$shop['min']}", 0, 'L');
$pdf->Ln(-6);
$pdf->SetFont('' , 8); 
$pdf->MultiCell(0, 10, "S/N: {$shop['series_num']}", 0, 'L');
$pdf->SetFont('' , 8); 
$pdf->Ln(-9);

if($startDate !== null && $endDate !== null)
{
    $startDates = strtotime($startDate);
    $formattedStartDate = date('F j, Y', $startDates);
    
    $endDates = strtotime($endDate);
    $formattedEndDate = date('F j, Y', $endDates);
}

$current_date = "---";
if((empty($singleDateData) && empty($startDate) && empty($endDate)) || (!empty($singleDateData) && empty($startDate) && empty($endDate)))
{
    $singleDateData = date('Y-m-d');
    $singleDateDatas = strtotime($singleDateData);
    $formattedSingleDate = date('F j, Y', $singleDateDatas);
    $current_date = $formattedSingleDate;
}
else
{
    $current_date =  $formattedStartDate." - ".$formattedEndDate;
}

$pdf->Cell(0, 10, "Date: $current_date", 0, 'L');
$pdf->Ln(-3);     

//188
$pdf->SetDrawColor(192, 192, 192); 
$pdf->SetLineWidth(0.3); 
$header = array('Revenue', $current_date);
$headerWidths = array(108, 80);
$maxCellHeight = 5; 

$pdf->SetFillColor(211, 211, 211);
$pdf->SetFont('', 'B', 9);
$pdf->Cell($headerWidths[0], $maxCellHeight, $header[0], 1, 0, 'L', true);
$pdf->Cell($headerWidths[1], $maxCellHeight, $header[1], 1, 0, 'R', true);
$pdf->Ln(); 

$totalAmount = 0; 
$pdf->SetFont('', '', 8); 
$total_expenses = 0;

$sales = $dashboard->get_allRevenues($startDate, $endDate, $singleDateData);
$total_sales = $sales['total_sales'] ?? 0;
$other_income = 0;

$pdf->Cell(15, $maxCellHeight, "", 0, 0, 'C');
$pdf->SetFont('', '', autoAdjustFontSize($pdf, "", 15));
$pdf->Cell(93, $maxCellHeight, "Sales", 0, 0, 'L');
$pdf->SetFont('', '', autoAdjustFontSize($pdf, "Sales", 93));
$pdf->Cell(80, $maxCellHeight, number_format($total_sales, 2, '.', ','), 1, 0, 'R');
$pdf->SetFont('', '', autoAdjustFontSize($pdf, number_format($total_sales, 2, '.', ','), 80));
$pdf->Ln(); 

$cash_inQuery = $otherFacade->cashInAmountsData('',$startDate,$endDate,0);
$cash_inData = $cash_inQuery->fetchAll(PDO::FETCH_ASSOC);
$cash_in = 0;
if(count($cash_inData) > 0)
{
    foreach($cash_inData as $row)
    {
        $cash_in += $row['cash_in_amount'];
    }
}
$total_revenue = $total_sales + $cash_in;
$pdf->Cell(15, $maxCellHeight, "", 0, 0, 'C');
$pdf->SetFont('', '', autoAdjustFontSize($pdf, "", 15));
$pdf->Cell(93, $maxCellHeight, "Other Income (Cash In)", 0, 0, 'L');
$pdf->SetFont('', '', autoAdjustFontSize($pdf, "Other Income", 93));
$pdf->Cell(80, $maxCellHeight, number_format($cash_in, 2), 1, 0, 'R');
$pdf->SetFont('', '', autoAdjustFontSize($pdf, number_format($cash_in, 2), 80));
$pdf->Ln(); 

$pdf->SetFont('', 'B', 9);
$pdf->SetFillColor(211, 211, 211);
$pdf->Cell(108, $maxCellHeight, "Total Revenues", 1, 0, 'L', true);
$pdf->SetFont('', '', autoAdjustFontSize($pdf, "", 108));
$pdf->SetFont('', 'B', 8);
$pdf->Cell(80, $maxCellHeight, number_format($total_revenue, 2, '.', ','), 1, 0, 'R', true);
$pdf->SetFont('', '', autoAdjustFontSize($pdf, number_format($total_revenue, 2, '.', ','), 80));
$pdf->Ln(); 
$pdf->Ln(); 

$pdf->SetFont('', 'B', 9);
$pdf->SetFillColor(255, 218, 185);
$pdf->Cell(108, $maxCellHeight, "Expenses", 1, 0, 'L', true);
$pdf->SetFont('', '', autoAdjustFontSize($pdf, "", 108));
$pdf->SetFont('', 'B', 9);
$pdf->Cell(80, $maxCellHeight, "Amount(Php)", 1, 0, 'R', true);
$pdf->SetFont('', '', autoAdjustFontSize($pdf, "", 80));
$pdf->Ln(); 

$expenses = $expenses->get_allExpensesByGroup($startDate, $endDate, $singleDateData);
$total_expenses = 0;
$income_tax_expense = 0;
if($expenses)
{
    foreach($expenses as $row) 
    {   
        $total_expenses += $row['expense_amount'];
        $pdf->Cell(15, $maxCellHeight, "", 0, 0, 'C');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, "", 15));
        $pdf->Cell(93, $maxCellHeight, $row['expense_type'], 0, 0, 'L');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['expense_type'], 93));
        $pdf->Cell(80, $maxCellHeight, number_format($row['expense_amount'], 2, '.', ','), 1, 0, 'R');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, number_format($row['expense_amount'], 2, '.', ','), 80));
        $income_tax_expense += $row['total_income_tax_expense'];
        $pdf->Ln(); 

        if($row['Landing_Cost'] != 0)
        {
            $landingCost = $row['Landing_Cost'];
            $pdf->Cell(15, $maxCellHeight, "", 0, 0, 'C');
            $pdf->SetFont('', 'I', autoAdjustFontSize($pdf, "", 15));
            $pdf->Cell(93, $maxCellHeight, "             Landed Cost", 0, 0, 'L');
            $pdf->SetFont('', 'I', autoAdjustFontSize($pdf, "             Landed Cost", 93));
            $pdf->Cell(80, $maxCellHeight, number_format($landingCost, 2, '.', ','), 1, 0, 'R');
            $pdf->SetFont('', 'I', autoAdjustFontSize($pdf, number_format($landingCost, 2, '.', ','), 80));
            $total_expenses += $landingCost;
            $pdf->Ln(); 
        }
        
        $counter++;
    }
}
else
{
    $pdf->Cell(108, $maxCellHeight, "", 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, "", 108));
    $pdf->SetFont('', 'B', 9);
    $pdf->Cell(80, $maxCellHeight, "---", 1, 0, 'R');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, "", 80));
    $pdf->Ln(); 
}


$pdf->SetFont('', 'B', 9);
$pdf->SetFillColor(255, 218, 185);
$pdf->Cell(108, $maxCellHeight, "Total Expenses", 1, 0, 'L', true);
$pdf->SetFont('', '', autoAdjustFontSize($pdf, "", 108));
$pdf->SetFont('', 'B', 8);
$pdf->Cell(80, $maxCellHeight, number_format($total_expenses, 2, '.', ','), 1, 0, 'R', true);
$pdf->SetFont('', '', autoAdjustFontSize($pdf, number_format($total_expenses, 2, '.', ','), 80));
$pdf->Ln(); 
$pdf->Ln(); 

$hexColor = '#F5F5F5';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");
$pdf->SetFillColor($r, $g, $b);

$net_incomebeforeTax = $total_revenue - $total_expenses;



$pdf->Cell(15, $maxCellHeight, "", 0, 0, 'C', true);
$pdf->SetFont('', '', autoAdjustFontSize($pdf, "", 15));
$pdf->Cell(93, $maxCellHeight, "Net Income Before Taxes", 0, 0, 'L', true);
$pdf->SetFont('', '', autoAdjustFontSize($pdf, "Net Income Before Taxes", 93));
$pdf->Cell(80, $maxCellHeight, number_format($net_incomebeforeTax, 2), 1, 0, 'R', true);
$pdf->SetFont('', '', autoAdjustFontSize($pdf, number_format($net_incomebeforeTax,2), 80));
$pdf->Ln(); 

$cash_outQuery = $otherFacade->cashInAmountsData('',$startDate,$endDate,1);
$cash_outData = $cash_outQuery->fetchAll(PDO::FETCH_ASSOC);
$cash_out = 0;
if(count($cash_outData) > 0)
{
    foreach($cash_outData as $row)
    {
        $cash_out += $row['cash_out_amount'];
    }
}
$net_incomeAfterTax = $net_incomebeforeTax - $income_tax_expense - $cash_out;

$pdf->Cell(15, $maxCellHeight, "", 0, 0, 'C', true);
$pdf->SetFont('', '', autoAdjustFontSize($pdf, "", 15));
$pdf->Cell(93, $maxCellHeight, "Other Expense (Cash Out)", 0, 0, 'L', true);
$pdf->SetFont('', '', autoAdjustFontSize($pdf, "Other Expense (Cash Out)", 93));
$pdf->Cell(80, $maxCellHeight, number_format($cash_out, 2), 1, 0, 'R', true);
$pdf->SetFont('', '', autoAdjustFontSize($pdf, number_format($cash_out, 2), 80));
$pdf->Ln(); 

$pdf->Cell(15, $maxCellHeight, "", 0, 0, 'C', true);
$pdf->SetFont('', '', autoAdjustFontSize($pdf, "", 15));
$pdf->Cell(93, $maxCellHeight, "Income tax expense", 0, 0, 'L', true);
$pdf->SetFont('', '', autoAdjustFontSize($pdf, "income tax expense", 93));
$pdf->Cell(80, $maxCellHeight, number_format($income_tax_expense, 2), 1, 0, 'R', true);
$pdf->SetFont('', '', autoAdjustFontSize($pdf, number_format($income_tax_expense, 2), 80));
$pdf->Ln(); 

$pdf->Ln(); 

$net_income = $net_incomeAfterTax;

$pdf->SetFont('', 'B', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(211, 211, 211);
$pdf->Cell(108, $maxCellHeight, "Net Income", 0, 0, 'L', true);
$pdf->SetFont('', '', autoAdjustFontSize($pdf, "", 108));

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(211, 211, 211);
$pdf->SetFont('', 'B', 8);
$pdf->Cell(80, $maxCellHeight, number_format($net_income, 2, '.', ','), 1,0, 'R', true);
$pdf->SetFont('', '', autoAdjustFontSize($pdf, number_format($net_income, 2, '.', ','), 80));

$pdf->Ln(); 

$pdfPath = $pdfFolder . 'income_statement.pdf';
$pdf->Output($pdfPath, 'F');

$pdf->Output('income_statement.pdf', 'I');
