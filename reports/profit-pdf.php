<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');

use TCPDF;
$pdfFolder = __DIR__ . '/../assets/pdf/profit/';

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

$refundFacade = new OtherReportsFacade();
$products = new ProductFacade();

$counter = 1;

$selectedProduct = $_GET['selectedProduct'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;


$fetchRefund= $refundFacade->getProfit($selectedProduct,$singleDateData,$startDate,$endDate);
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);


$paperSize = 'A4'; 

if ($paperSize == 'A4') {
    $pageWidth = 210;
    $pageHeight = 297;
}
$pdf = new TCPDF('L', PDF_UNIT, array($pageWidth, $pageHeight), true, 'UTF-8', false);
$pdf->SetCreator('TinkerPro Inc.');
$pdf->SetAuthor('TinkerPro Inc.');
$pdf->SetTitle('PROFIT Table PDF');
$pdf->SetSubject('PROFIT PDF Document');
$pdf->SetKeywords('TCPDF, PDF, PROFIT, table');

$pdf->AddPage();


$pdf->SetCellHeightRatio(1.5);
$imageFile = './../assets/img/tinkerpro-logo-dark.png'; 
$imageWidth = 45; 
$imageHeight = 15; 
$imageX = 10; 
$pdf->Image($imageFile, $imageX, $y = 10, $w = $imageWidth, $h = $imageHeight, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);
$pdf->SetFont('', 'I', 8);


$pdf->SetFont('', 'B', 10);
$pdf->Cell(0, 10, 'PROFIT', 0, 1, 'R', 0); 
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
} elseif (!$singleDateData && $startDate && $endDate) {
    $formattedStartDate = date('M j, Y', strtotime($startDate));
    $formattedEndDate = date('M j, Y', strtotime($endDate));
    $pdf->SetFont('', '', 11); 
    $pdf->Cell(0, 10, "Period: $formattedStartDate - $formattedEndDate", 0, 'L');
} else {
    $otherFacade = new OtherReportsFacade;
    $others =    $otherFacade->getDatePayments();
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
$header = array('Product','SKU','Sold','Cost','Margin(%)','Selling Price','Total','Profit');


$headerWidths = array(50,18,25,40,22, 40, 40,40);
$maxCellHeight = 5; 

$hexColor = '#F5F5F5';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

$pdf->SetFillColor($r, $g, $b);


$pdf->SetFont('', 'B', 8);
for ($i = 0; $i < count($header); $i++) {
    if ($header[$i] === 'Product') {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'L', true);
    } else {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'C', true);
    }
}
$pdf->Ln(); 

$totalCost = 0;
$totalT = 0 ;
$totalProfit = 0;
$grossAmount = 0;
$pdf->SetFont('', '', 8); 

while ($row = $fetchRefund->fetch(PDO::FETCH_ASSOC)) {
   
    $totalT += $row['amount']?? 0;
    $totalCost = $row['newQty'] * $row['cost'];
    $grossAmount = $row['grossAmount'] - $row['itemDiscount'] - $row['overallDiscounts'];
    $totalT += $grossAmount;
    $profit =$grossAmount - $totalCost;
    $totalProfit  +=  $profit;

    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['prod_desc'], $headerWidths[0]));   
    $pdf->Cell($headerWidths[0], $maxCellHeight, $row['prod_desc'], 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['sku'], $headerWidths[1]));   
    $pdf->Cell($headerWidths[1], $maxCellHeight, $row['sku'], 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['newQty'], $headerWidths[2]));   
    $pdf->Cell($headerWidths[2], $maxCellHeight, number_format($row['newQty'],2), 1, 0, 'R');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['cost'], $headerWidths[3]));   
    $pdf->Cell($headerWidths[3], $maxCellHeight, number_format($row['cost'],2), 1, 0, 'R');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['markup']."%", $headerWidths[4]));   
    $pdf->Cell($headerWidths[4], $maxCellHeight, number_format($row['markup'],2)."%", 1, 0, 'R');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['prod_price'], $headerWidths[5]));   
    $pdf->Cell($headerWidths[5], $maxCellHeight, number_format($row['prod_price'],2), 1, 0, 'R');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $grossAmount, $headerWidths[6]));   
    $pdf->Cell($headerWidths[6], $maxCellHeight, number_format($grossAmount,2), 1, 0, 'R');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf,   $profit, $headerWidths[7]));   
    $pdf->Cell($headerWidths[7], $maxCellHeight, number_format(  $profit,2), 1, 0, 'R');
    $pdf->Ln(); 
}

$pdf->SetFont('', 'B', 8); 
$pdf->Cell($headerWidths[0] + $headerWidths[1]  + $headerWidths[2] , $maxCellHeight, 'Total', 1, 0, 'L'); 
$pdf->Cell($headerWidths[3] , $maxCellHeight,  '', 1, 0, 'R'); 
$pdf->Cell($headerWidths[4] , $maxCellHeight,  '', 1, 0, 'R'); 
$pdf->Cell($headerWidths[5] , $maxCellHeight,  '', 1, 0, 'R'); 
$pdf->Cell($headerWidths[6] , $maxCellHeight,  number_format($totalT,2), 1, 0, 'R'); 
$pdf->Cell($headerWidths[7] , $maxCellHeight,  number_format($totalProfit,2), 1, 0, 'R'); 
$pdf->SetFont('', 'I', 12); 
$pdf->Ln(); 
$pdf->Cell(0, 12, "NOTE: The total amount in this report has deductions applied for all discounts, including cart, item, and other discounts.***", 0, 'L');


$pdfPath = $pdfFolder . 'profit.pdf';
$pdf->Output($pdfPath, 'F');
$pdf->Output('profit.pdf', 'I');

?>
