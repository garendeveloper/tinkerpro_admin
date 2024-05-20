<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');

use TCPDF;

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
$customerId= $_GET['customerId'] ?? null;
$discountType= $_GET['discountType'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

$fetchRefund= $refundFacade->getDiscountDataReceipt($customerId,$discountType,$singleDateData,$startDate,$endDate);
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);


$pdf = new TCPDF();
$pdf->SetCreator('TinkerPro Inc.');
$pdf->SetAuthor('TinkerPro Inc.');
$pdf->SetTitle('Discounts Granted PDF');
$pdf->SetSubject('Discounts Granted PDF Document');
$pdf->SetKeywords('TCPDF, PDF, Discounts Granted, table');

$pdf->AddPage();


$pdf->SetCellHeightRatio(1.5);
$imageFile = './../assets/img/tinkerpro-logo-dark.png'; 
$imageWidth = 45; 
$imageHeight = 15; 
$imageX = 10; 
$pdf->Image($imageFile, $imageX, $y = 10, $w = $imageWidth, $h = $imageHeight, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);
$pdf->SetFont('', 'I', 8);



$pdf->SetFont('', 'B', 10);
$pdf->Cell(0, 10, 'DISCOUNTS GRANTED', 0, 1, 'R', 0); 
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


$groupedData = [];
$totalDiscount = 0;

while ($row = $fetchRefund->fetch(PDO::FETCH_ASSOC)) {
    $lastName = $row['last_name'];
    $firstName = $row['first_name'];
   
    if (!isset($groupedData[$lastName])) {
        $groupedData[$lastName] = [];
    }
    $groupedData[$lastName][] = $row;
}

foreach ($groupedData as $lastName => $customerData) {
    $totalDiscount = 0; // Initialize total discount for the current customer

    $pdf->SetFont('', 'B', 10);
    $pdf->Cell(0, 10, 'Customer Name: ' . $firstName . ' ' . $lastName, 0, 1, 'L', 0);
    $pdf->Ln(-2); 
    $pdf->SetDrawColor(192, 192, 192); 
    $pdf->SetLineWidth(0.3); 
    $header = array('No.', 'User', 'Receipt No', 'Date', 'Discount(Php)');
    $headerWidths = array(10, 60, 40, 40, 40);
    $maxCellHeight = 5; 

    $hexColor = '#F5F5F5';
    list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");
    
    $pdf->SetFillColor($r, $g, $b);
    
    $pdf->SetFont('', 'B', 10);
    foreach ($header as $i => $headerItem) {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $headerItem, 1, 0, 'C', true);
    }  
    $pdf->Ln();

    $counter = 1;
    foreach ($customerData as $row) {
        $pdf->Cell($headerWidths[0], $maxCellHeight, $counter, 1, 0, 'C');
        $pdf->Cell($headerWidths[1], $maxCellHeight, $row['c_first_name'] .' '. $row['c_last_name'], 1, 0, 'C');
        $pdf->Cell($headerWidths[2], $maxCellHeight, str_pad($row['receipt_id'], 9, '0', STR_PAD_LEFT), 1, 0, 'C');
        $formattedDate = date('M d, Y', strtotime($row['date']));
        $pdf->Cell($headerWidths[3], $maxCellHeight, $formattedDate, 1, 0, 'C');
        $pdf->Cell($headerWidths[4], $maxCellHeight, number_format($row['discountAmount'], 2), 1, 0, 'R');

        $totalDiscount += $row['discountAmount']; 
        $pdf->Ln(); 
        $counter++;
    }


    $pdf->SetFont('', 'B', 10); 
    $pdf->Cell($headerWidths[0] + $headerWidths[1], $maxCellHeight, 'Total', 1, 0, 'C'); 
    $pdf->Cell( $headerWidths[2] + $headerWidths[3] + $headerWidths[4], $maxCellHeight, number_format( $totalDiscount, 2), 1, 0, 'R'); 
    $pdf->Ln(); 
}

$pdf->Output('discountsGranted.pdf', 'I');
$pdfPath = __DIR__ . '/../assets/pdf/discounts_granted/discountsGranted.pdf';

if (file_exists($pdfPath)) {
    unlink($pdfPath);
}
$pdf->Output($pdfPath, 'F');
?>
