<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');

use TCPDF;

$pdfFolder = __DIR__ . '/../assets/pdf/payment_method/';

$files = glob($pdfFolder . '*'); 
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file); 
    }
}

function autoAdjustFontSize($pdf, $text, $maxWidth, $initialFontSize = 10) {
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

$exclude = $_GET['exclude'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

$fetchRefund= $refundFacade->getPaymentMethod($singleDateData,$startDate,$endDate);
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
$pdf->SetTitle('SALES BY PAYMENT TYPES Table PDF');
$pdf->SetSubject('SALES BY PAYMENT TYPES Table PDF Document');
$pdf->SetKeywords('TCPDF, PDF, SALES BY PAYMENT TYPES, table');
$pdf->SetDrawColor(255, 199, 60); 
$pdf->Rect(0, 0, $pdf->getPageWidth(), $pdf->getPageHeight(), 'D');

$pdf->AddPage();



$pdf->SetCellHeightRatio(1.5);
$imageFile = './../assets/img/tinkerpro-logo-dark.png'; 
$imageWidth = 45; 
$imageHeight = 15; 
$imageX = 10; 
$pdf->Image($imageFile, $imageX, $y = 10, $w = $imageWidth, $h = $imageHeight, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);
$pdf->SetFont('', 'I', 8);


$pdf->SetFont('', 'B', 10);
$pdf->Cell(0, 10, 'SALES BY PAYMENT TYPES', 0, 1, 'R', 0); 
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

$header = array( 'Date', 'Cash', 'E-Wallet', 'Credit/Debit Cards', 'Credit','Coupons', 'Total(Php)');
$headerWidths = array( 40, 40, 40, 40, 40, 40, 40);
$maxCellHeight = 5; 

$hexColor = '#F5F5F5';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

$pdf->SetFillColor($r, $g, $b);
$pdf->SetFont('', 'B', 10);
for ($i = 0; $i < count($header); $i++) {
    if ($header[$i] === 'Date') {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'L', true);
    } else {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'C', true);
    }
}
$pdf->Ln(); 

$totalAmount = 0; 
$totalCash = 0;
$totalEwallet = 0;
$totalCC  = 0;
$totalCredit = 0;
$totalCoupons = 0;
$pdf->SetFont('', '', 10); 
while ($row = $fetchRefund->fetch(PDO::FETCH_ASSOC)) {
    $totalAmount += $row['total_amount'];
    $totalCash += $row['cash'];
    $totalEwallet += $row['ewallet'];
    $totalCC += $row['cc'];
    $totalCoupons += $row['coupon'];
    $totalCredit += $row['credit'];
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['date'] !== null ? date('M j, Y', strtotime($row['date'])) : '', $headerWidths[0]));
    $pdf->Cell($headerWidths[0], $maxCellHeight, $row['date'] !== null ? date('M j, Y', strtotime($row['date'])) : '', 1, 0, 'L');    
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['cash'], $headerWidths[1]));
    $pdf->Cell($headerWidths[1], $maxCellHeight, number_format($row['cash'], 2), 1, 0, 'R');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['ewallet'], $headerWidths[2]));
    $pdf->Cell($headerWidths[2], $maxCellHeight, number_format($row['ewallet'], 2), 1, 0, 'R');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['cc'], $headerWidths[3]));
    $pdf->Cell($headerWidths[3], $maxCellHeight, number_format($row['cc'], 2), 1, 0, 'R');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['credit'], $headerWidths[4]));
    $pdf->Cell($headerWidths[4], $maxCellHeight, number_format($row['credit'], 2), 1, 0, 'R');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['coupon'], $headerWidths[5]));
    $pdf->Cell($headerWidths[5], $maxCellHeight, number_format($row['coupon'], 2), 1, 0, 'R');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['total_amount'], $headerWidths[6]));
    $pdf->Cell($headerWidths[6], $maxCellHeight, number_format($row['total_amount'], 2), 1, 0, 'R');
    $pdf->Ln();
   
}

$pdf->SetFont('', 'B', 10); 
$pdf->Cell($headerWidths[0], $maxCellHeight, 'Total(Php)', 1, 0, 'L'); 
$pdf->Cell($headerWidths[1], $maxCellHeight, number_format($totalCash, 2), 1, 0, 'R'); 
$pdf->Cell($headerWidths[2], $maxCellHeight, number_format($totalEwallet, 2), 1, 0, 'R'); 
$pdf->Cell($headerWidths[3], $maxCellHeight, number_format($totalCC, 2), 1, 0, 'R'); 
$pdf->Cell($headerWidths[4], $maxCellHeight, number_format($totalCredit, 2), 1, 0, 'R'); 
$pdf->Cell($headerWidths[5], $maxCellHeight, number_format($totalCoupons, 2), 1, 0, 'R'); 
$pdf->Cell($headerWidths[6], $maxCellHeight, number_format($totalAmount, 2), 1, 0, 'R'); 
$pdf->Ln(); 
$pdf->SetFont('', 'I', 12); 


    $pdf->Cell(0, 10, "NOTE: This report does not include transactions for refunds and returns.***", 0, 'L');



$pdfPath = $pdfFolder . 'paymentMethodList.pdf';
$pdf->Output($pdfPath, 'F');

$pdf->Output('paymentMethodList.pdf', 'I');

 ?>
