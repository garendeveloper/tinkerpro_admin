<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');
include( __DIR__ . '/../utils/models/dashboard-facade.php');

$pdfFolder = __DIR__ . '/../assets/pdf/tax/';

$files = glob($pdfFolder . '*'); 
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file); 
    }
}

function autoAdjustFontSize($pdf, $text, $maxWidth, $initialFontSize = 8) {
    $pdf->SetFont('', '', $initialFontSize);
    while ($pdf->GetStringWidth($text) > $maxWidth) {
        $initialFontSize--;
        $pdf->SetFont('', '', $initialFontSize);
    }
    return $initialFontSize;
}

$otherfacade = new OtherReportsFacade();
$dashboardfacade = new DashboardFacade();
$products = new ProductFacade();

$counter = 1;

$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

if(!empty($singleDateData) && (empty($startDate) && empty($endDate)))
{
    $startDate = $singleDateData;
    $endDate = $singleDateData;
}
if(empty($singleDateData) && (empty($startDate) && empty($endDate)))
{
    $startDate = date('Y-m-d');
    $endDate = date('Y-m-d');
}
$sales = $dashboardfacade->get_salesByPeriod($startDate,$endDate);
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);


$pdf = new TCPDF();
$pdf->SetCreator('TinkerPro Inc.');
$pdf->SetAuthor('TinkerPro Inc.');
$pdf->SetTitle('TAX RATES Table PDF');
$pdf->SetSubject('TAX RATES PDF Document');
$pdf->SetKeywords('TCPDF, PDF, TAX RATES, table');

$pdf->AddPage();

$pdf->SetCellHeightRatio(1.5);
$imageFile = './../assets/img/tinkerpro-logo-dark.png'; 
$imageWidth = 45; 
$imageHeight = 15; 
$imageX = 10; 
$pdf->Image($imageFile, $imageX, $y = 10, $w = $imageWidth, $h = $imageHeight, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);
$pdf->SetFont('', 'I', 8);

$pdf->SetFont('', 'B', 10);
$pdf->Cell(0, 10, 'TAX RATES', 0, 1, 'R', 0); 
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
$current_date = date('F j, Y');
$pdf->Cell(0, 10, "Date: $current_date", 0, 'L');
$pdf->Ln(-3);
if ($singleDateData && !$startDate && !$endDate) {
    $formattedDate = date('M j, Y', strtotime($singleDateData));
    $pdf->SetFont('', '', 11); 
    $pdf->Cell(0, 10, "Period: $formattedDate", 0, 'L');
} else if (!$singleDateData && $startDate && $endDate) {
    $formattedStartDate = date('M j, Y', strtotime($startDate));
    $formattedEndDate = date('M j, Y', strtotime($endDate));
    $pdf->SetFont('', '', 11); 
    $pdf->Cell(0, 10, "Period: $formattedStartDate - $formattedEndDate", 0, 'L');
} else {
    $otherFacade = new OtherReportsFacade;
    $others =    $otherFacade->zReadDate();
    $dates = [];
    while ($row = $others->fetch(PDO::FETCH_ASSOC)) {
        $dates[] = $row['date'];
    }
    
    if (!empty($dates)) {
        $startDate = min($dates);
        $endDate = max($dates);

        $formattedStartDate = date('M j, Y', strtotime($startDate));
        $formattedEndDate = date('M j, Y', strtotime($endDate));
        $pdf->SetFont('', '', 11); 
        $pdf->Cell(0, 10, "Period: $formattedStartDate - $formattedEndDate", 0, 'L');
    } 
}


$pdf->SetDrawColor(192, 192, 192); 
$pdf->SetLineWidth(0.3); 
$header = array('Zero Rated','Others','Vatable Sales','VAT');
$headerWidths = array(40, 50, 50, 50);
$maxCellHeight = 5; 

$hexColor = '#F5F5F5';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

$pdf->SetFillColor($r, $g, $b);

$pdf->SetFont('', 'B', 8);
for ($i = 0; $i < count($header); $i++) {
    if ($header[$i] === 'No.') {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'L', true);
    } else {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'C', true);
    }
}
$pdf->Ln(); 

$totalZeroRated = 0;
$totalOther = 0;

$vatableSales = (float)  $sales;
$vat = (float) $tax;
$totalSales = (float) $tax + $vatableSales;

$pdf->SetFont('', '', autoAdjustFontSize($pdf, $totalZeroRated, $headerWidths[0]));
$pdf->Cell($headerWidths[0], $maxCellHeight, number_format($totalZeroRated ?? 0,2), 1, 0, 'R');
$pdf->SetFont('', '', autoAdjustFontSize($pdf, $totalOther, $headerWidths[1]));
$pdf->Cell($headerWidths[1], $maxCellHeight, number_format($totalOther ?? 0,2), 1, 0, 'R');
$pdf->SetFont('', '', autoAdjustFontSize($pdf, $vatableSales, $headerWidths[2]));
$pdf->Cell($headerWidths[2], $maxCellHeight, number_format($vatableSales ?? 0,2), 1, 0, 'R');
$pdf->SetFont('', '', autoAdjustFontSize($pdf, $vat, $headerWidths[3]));
$pdf->Cell($headerWidths[3], $maxCellHeight, number_format($vat ?? 0,2), 1, 0, 'R');
$pdf->SetFont('', 'B', 8); 
// $pdf->Ln(); 
$pdfPath = $pdfFolder . 'tax-rates.pdf';
$pdf->Output($pdfPath, 'F');

$pdf->Output('tax-rates.pdf', 'I');



?>
