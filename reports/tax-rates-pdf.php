<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');

use TCPDF;

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

$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

$fetchRefund= $refundFacade->taxRates($singleDateData,$startDate,$endDate);
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
$header = array('No.','Zero Rated','Others','Vatable Sales','VAT');
$headerWidths = array(30, 40,40, 40, 40);
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

$totalVatableSales = 0;
$totalTax = 0;
$totalOther = 0;
$totalZeroRated = 0;
$pdf->SetFont('', '', 8); 
while ($row = $fetchRefund->fetch(PDO::FETCH_ASSOC)) {
    $totalVatableSales += $row['total_vatable_sales'] ??  0;
    $totalTax += $row['total_vat_amount'] ?? 0;
    $totalOther +=  $row['total_other'] ?? 0;
    $totalZeroRated  += $row['total_zero_rated'] ?? 0;
    $pdf->Cell($headerWidths[0], $maxCellHeight, $counter, 1, 0, 'L');
    // $formatted_date = date("M j, Y", strtotime($row['date_time']));
    // $pdf->SetFont('', '', autoAdjustFontSize($pdf, $formatted_date, $headerWidths[1]));
    // $pdf->Cell($headerWidths[1], $maxCellHeight, $formatted_date, 1, 0, 'C');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['total_zero_rated'], $headerWidths[2]));
    $pdf->Cell($headerWidths[2], $maxCellHeight, number_format($row['total_zero_rated'] ?? 0,2), 1, 0, 'R');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['total_other'], $headerWidths[2]));
    $pdf->Cell($headerWidths[2], $maxCellHeight, number_format($row['total_other'] ?? 0,2), 1, 0, 'R');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['total_vatable_sales'], $headerWidths[3]));
    $pdf->Cell($headerWidths[3], $maxCellHeight, number_format($row['total_vatable_sales'] ?? 0,2), 1, 0, 'R');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['total_vat_amount'], $headerWidths[4]));
    $pdf->Cell($headerWidths[4], $maxCellHeight, number_format($row['total_vat_amount'] ?? 0,2), 1, 0, 'R');
  
 

    $pdf->Ln(); 
    $counter++;
}

$pdf->SetFont('', 'B', 8); 
$pdf->Cell($headerWidths[0] , $maxCellHeight, 'Total', 1, 0, 'L'); 
$pdf->Cell($headerWidths[2] , $maxCellHeight,  $totalZeroRated, 1, 0, 'R');
$pdf->Cell($headerWidths[2] , $maxCellHeight,  $totalOther, 1, 0, 'R');
$pdf->Cell($headerWidths[3] , $maxCellHeight,  $totalVatableSales, 1, 0, 'R'); 
$pdf->Cell($headerWidths[4] , $maxCellHeight,   $totalTax, 1, 0, 'R'); 
// $pdf->Cell( $headerWidths[2] + $headerWidths[3] + $headerWidths[4], $maxCellHeight, number_format( $totalDiscount, 2), 1, 0, 'R'); 
// $pdf->Ln(); 

$pdf->Output('tax-rates.pdf', 'I');
$pdfPath = __DIR__ . '/../assets/pdf/tax/tax-rates.pdf';

if (file_exists($pdfPath)) {
 
    unlink($pdfPath);
}
$pdf->Output($pdfPath, 'F');
?>
