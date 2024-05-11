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

$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

$fetchRefund= $refundFacade->birSalesReport($singleDateData,$startDate,$endDate);
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
$pdf->SetTitle('SALES REPORT Table PDF');
$pdf->SetSubject('SALES REPORT Table PDF Document');
$pdf->SetKeywords('TCPDF, PDF, SALES REPORT, table');
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
$pdf->Cell(0, 10, 'SALES REPORT', 0, 1, 'R', 0); 
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
$header = array('TIN','Branch','Month','Year', 'MIN', 'Vatable Sales', 'Vat Zero Rated Sales', 'Vat Exempt Sales', 'Sales Subject to other percentage taxes');
$pageWidth = $pdf->getPageWidth();
$pageHeight = $pdf->getPageHeight();

$headerWidths = array();
$headerWidths = array(23, 20, 20, 20, 20, 30, 37, 37, 70);
    
$maxCellHeight = 5; 
$hexColor = '#F5F5F5';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

$pdf->SetFillColor($r, $g, $b);
$pdf->SetFont('', 'B', 10);
for ($i = 0; $i < count($header); $i++) {
    if ($header[$i] === 'TIN') {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'L', true);
    } else {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'C', true);
    }
}
$pdf->Ln(); 

$monthNames = array(
    1 => 'Jan',
    2 => 'Feb',
    3 => 'Mar',
    4 => 'Apr',
    5 => 'May',
    6 => 'Jun',
    7 => 'Jul',
    8 => 'Aug',
    9 => 'Sep',
    10 => 'Oct',
    11 => 'Nov',
    12 => 'Dec'
);
$totalAmountVatSales = 0;
$totalAmountExemptSales = 0;
$pdf->SetFont('', '', 10); 
while ($row = $fetchRefund->fetch(PDO::FETCH_ASSOC)) {
    $month = $row['month'];
    $monthName = $monthNames[$month];
    $totalAmountVatSales +=  $row['total_vatable_sales'];
    $totalAmountExemptSales += $row['total_vat_exempt'];
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['tin'], $headerWidths[0]));   
    $pdf->Cell($headerWidths[0], $maxCellHeight, $row['tin'], 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['branch'], $headerWidths[1]));   
    $pdf->Cell($headerWidths[1], $maxCellHeight, $row['branch'], 1, 0, 'C');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $monthName, $headerWidths[2]));   
    $pdf->Cell($headerWidths[2], $maxCellHeight, $monthName, 1, 0, 'C');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['year'], $headerWidths[3]));   
    $pdf->Cell($headerWidths[3], $maxCellHeight, $row['year'], 1, 0, 'C');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['min'], $headerWidths[4]));   
    $pdf->Cell($headerWidths[4], $maxCellHeight, $row['min'], 1, 0, 'C');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['total_vatable_sales'] ?? 0, $headerWidths[5]));   
    $pdf->Cell($headerWidths[5], $maxCellHeight, number_format($row['total_vatable_sales'] ?? 0, 2), 1, 0, 'R');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, 0, $headerWidths[6]));   
    $pdf->Cell($headerWidths[6], $maxCellHeight, number_format( 0 ,2), 1, 0, 'R');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['total_vat_exempt'] ?? 0, $headerWidths[7]));   
    $pdf->Cell($headerWidths[7], $maxCellHeight, number_format($row['total_vat_exempt'] ?? 0, 2), 1, 0, 'R');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, 0, $headerWidths[8]));   
    $pdf->Cell($headerWidths[8], $maxCellHeight, number_format( 0 ,2), 1, 0, 'R');
    $pdf->Ln();
}

$pdf->SetFont('', 'B', 10); 
$pdf->Cell($headerWidths[0], $maxCellHeight, 'Total(Php)', 1, 0, 'L'); 
$pdf->Cell($headerWidths[1], $maxCellHeight, '', 1, 0, 'L'); 
$pdf->Cell($headerWidths[2], $maxCellHeight, '', 1, 0, 'L'); 
$pdf->Cell($headerWidths[3], $maxCellHeight, '', 1, 0, 'L'); 
$pdf->Cell($headerWidths[4], $maxCellHeight, '', 1, 0, 'L'); 
$pdf->Cell($headerWidths[5], $maxCellHeight, number_format($totalAmountVatSales, 2), 1, 0, 'R'); 
$pdf->Cell($headerWidths[6], $maxCellHeight, number_format(0, 2), 1, 0, 'R'); 
$pdf->Cell($headerWidths[7], $maxCellHeight, number_format($totalAmountExemptSales, 2), 1, 0, 'R'); 
$pdf->Cell($headerWidths[8], $maxCellHeight, number_format(0, 2), 1, 0, 'R'); 
$pdf->Ln(); 
 

$pdf->Output('salesReport.pdf', 'I');
$pdfPath = __DIR__ . '/../assets/pdf/salesReport/salesReport.pdf';
if (file_exists($pdfPath)) {
    unlink($pdfPath);
}

$pdf->Output($pdfPath, 'F');
 ?>
