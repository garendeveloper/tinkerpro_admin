<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include( __DIR__ . '/../utils/models/user-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');
use TCPDF;
$products = new ProductFacade();

function autoAdjustFontSize($pdf, $text, $maxWidth, $initialFontSize = 10) {
    $pdf->SetFont('', '', $initialFontSize);
    while ($pdf->GetStringWidth($text) > $maxWidth) {
        $initialFontSize--;
        $pdf->SetFont('', '', $initialFontSize);
    }
    return $initialFontSize;
}

$refundFacade = new OtherReportsFacade();
// $products = new ProductFacade();

$counter = 1;

$value = $_GET['selectedValue'] ?? null; 
$searchQuery = $_GET['searchQuery'] ?? null;
$userFacade = new UserFacade();

$fetchCoupon = $userFacade->getAllCouponsStatus($value,$searchQuery);

$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);



$pdf = new TCPDF();


$pdf->SetCreator('TinkerPro Inc.');
$pdf->SetAuthor('TinkerPro Inc.');
$pdf->SetTitle('COUPONS Table PDF');
$pdf->SetSubject('Coupons Table PDF Document');
$pdf->SetKeywords('TCPDF, PDF, COUPONS, table');
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
$pdf->Cell(0, 10, 'COUPONS', 0, 1, 'R', 0); 
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


$pdf->SetDrawColor(192, 192, 192); 
$pdf->SetLineWidth(0.3); 

$header = array( 'Transaction Date', 'Amount', 'Used Date', 'Expiration Date','Total');
$headerWidths = array(40, 34, 40, 40 ,34);
$maxCellHeight = 5; 

$hexColor = '#F5F5F5';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

$pdf->SetFillColor($r, $g, $b);
$pdf->SetFont('', 'B', 10);
for ($i = 0; $i < count($header); $i++) {
    if ($header[$i] === 'Transaction Date') {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'L', true);
    } else {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'C', true);
    }
}
$pdf->Ln(); 

$totalAmount = 0; 
$pdf->SetFont('', '', 10); 
while ($row = $fetchCoupon ->fetch(PDO::FETCH_ASSOC)) {
    $totalAmount += $row['c_amount'];
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['transaction_dateTime'] !== null ? date('M j, Y', strtotime($row['transaction_dateTime'])) : '', $headerWidths[0]));
    $pdf->Cell($headerWidths[0], $maxCellHeight, $row['transaction_dateTime'] !== null ? date('M j, Y', strtotime($row['transaction_dateTime'])) : '', 1, 0, 'L');    
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['qrNumber'], $headerWidths[1]));
    $pdf->Cell($headerWidths[1], $maxCellHeight, $row['qrNumber'], 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['used_date'] !== null ? date('M j, Y', strtotime($row['used_date'])) : '', $headerWidths[2]));
    $pdf->Cell($headerWidths[2], $maxCellHeight, $row['used_date'] !== null ? date('M j, Y', strtotime($row['used_date'])) : '', 1, 0, 'C');    
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['expiry_dateTime'] !== null ? date('M j, Y', strtotime($row['expiry_dateTime'])) : '', $headerWidths[3]));
    $pdf->Cell($headerWidths[3], $maxCellHeight, $row['expiry_dateTime'] !== null ? date('M j, Y', strtotime($row['expiry_dateTime'])) : '', 1, 0, 'C');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['c_amount'], $headerWidths[4]));
    $pdf->Cell($headerWidths[4], $maxCellHeight, number_format($row['c_amount'], 2), 1, 0, 'R');
    $pdf->Ln();
   
}

$pdf->SetFont('', 'B', 10); 
$pdf->Cell($headerWidths[0], $maxCellHeight, 'Total', 1, 0, 'L'); 
$pdf->Cell($headerWidths[1], $maxCellHeight, '', 1, 0, 'R'); 
$pdf->Cell($headerWidths[2], $maxCellHeight,'', 1, 0, 'R'); 
$pdf->Cell($headerWidths[3], $maxCellHeight,'', 1, 0, 'R'); 
$pdf->Cell($headerWidths[4], $maxCellHeight, number_format($totalAmount, 2), 1, 0, 'R'); 
$pdf->Ln(); 
// $pdf->SetFont('', 'I', 12); 

$pdf->Output('coupon_list.pdf', 'I');

 ?>
