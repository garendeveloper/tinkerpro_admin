<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');

use TCPDF;


$pdfFolder = __DIR__ . '/../assets/pdf/product/';

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

$productSales = new OtherReportsFacade();
$products = new ProductFacade();

$counter = 1;
$selectedProduct = $_GET['selectedProduct'] ?? null;
$selectedCategories = $_GET['selectedCategories'] ?? null;
$selectedSubCategories = $_GET['selectedSubCategories'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;


$fetchSales= $productSales->geProductSalesData($selectedProduct,$selectedCategories,$selectedSubCategories,$singleDateData,$startDate,$endDate);
$fetchShop = $products->getShopDetails();
$fetchCart= $productSales->getTotalCart();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);


$paperSize = 'A4'; 

if ($paperSize == 'A4') {
    $pageWidth = 210;
    $pageHeight = 297;
}
$pdf = new TCPDF('L', PDF_UNIT, array($pageWidth, $pageHeight), true, 'UTF-8', false);
$pdf->SetCreator('TinkerPro Inc.');
$pdf->SetAuthor('TinkerPro Inc.');
$pdf->SetTitle('PRODUCTS');
$pdf->SetSubject('PRODUCTS Table PDF Document');
$pdf->SetKeywords('TCPDF, PDF, PRODUCTS, table');
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
$pdf->Cell(0, 10, 'PRODUCTS', 0, 1, 'R', 0); 
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
$header = array('Product','SKU','Sold', 'Cost', 'Tax','Selling Price','Total');
$pageWidth = $pdf->getPageWidth();
$pageHeight = $pdf->getPageHeight();

$headerWidths = array();
    $headerWidths = array(50, 30, 30, 35, 50, 30, 50);
$maxCellHeight = 5; 

$hexColor = '#F5F5F5';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

$pdf->SetFillColor($r, $g, $b);
$pdf->SetFont('', 'B', 10);
for ($i = 0; $i < count($header); $i++) {
    if ($header[$i] === 'Product') {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'L', true);
    } else {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'C', true);
    }
}
$pdf->Ln(); 

$totalCost = 0;
$totalTax = 0;
$totalPrice = 0;
$totalAmount = 0;
$totalCart = 0;
$pdf->SetFont('', '', 10); 

while ($row = $fetchSales->fetch(PDO::FETCH_ASSOC)) {
    $totalCost += $row['cost'];
    $totalTax += $row['totalVat'];
    $totalPrice += $row['prod_price'];
    $grossAmount = $row['grossAmount'] - $row['itemDiscount'] - $row['overallDiscounts'];

    $totalAmount += $grossAmount ;
  
     $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['prod_desc'], $headerWidths[0]));   
     $pdf->Cell($headerWidths[0], $maxCellHeight, $row['prod_desc'], 1, 0, 'L');
     $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['sku'], $headerWidths[1]));   
     $pdf->Cell($headerWidths[1], $maxCellHeight, $row['sku'], 1, 0, 'C');
     $pdf->SetFont('', '', autoAdjustFontSize($pdf,  $row['newQty'], $headerWidths[2]));   
     $pdf->Cell($headerWidths[2], $maxCellHeight,  $row['newQty'], 1, 0, 'C');
     $pdf->SetFont('', '', autoAdjustFontSize($pdf, number_format( $row['cost'],2), $headerWidths[3]));   
     $pdf->Cell($headerWidths[3], $maxCellHeight, $row['cost'], 1, 0, 'R');
     $pdf->SetFont('', '', autoAdjustFontSize($pdf, number_format( $row['totalVat'],2), $headerWidths[4]));   
     $pdf->Cell($headerWidths[4], $maxCellHeight, number_format($row['totalVat'],2), 1, 0, 'R');
     $pdf->SetFont('', '', autoAdjustFontSize($pdf, number_format( $row['prod_price'],2), $headerWidths[5]));   
     $pdf->Cell($headerWidths[5], $maxCellHeight, number_format($row['prod_price'],2), 1, 0, 'R');
     $pdf->SetFont('', '', autoAdjustFontSize($pdf, number_format( $grossAmount,2), $headerWidths[6]));   
     $pdf->Cell($headerWidths[6], $maxCellHeight, number_format( $grossAmount,2), 1, 0, 'R');
     $pdf->Ln(); 
     
}


$pdf->SetFont('', 'B', 10); 
$pdf->Cell($headerWidths[0]+$headerWidths[1] + $headerWidths[2], $maxCellHeight, 'Total', 1, 0, 'L'); 
$pdf->Cell( $headerWidths[3], $maxCellHeight, number_format($totalCost, 2), 1, 0, 'R'); 
$pdf->Cell( $headerWidths[4], $maxCellHeight, number_format($totalTax, 2), 1, 0, 'R'); 
$pdf->Cell( $headerWidths[5], $maxCellHeight, number_format($totalPrice, 2), 1, 0, 'R'); 
$pdf->Cell( $headerWidths[6], $maxCellHeight, number_format($totalAmount, 2), 1, 0, 'R'); 

$pdfPath = $pdfFolder . 'product_report.pdf';
$pdf->Output($pdfPath, 'F');



$pdf->Output('product_report.pdf', 'I');




 



 ?>
