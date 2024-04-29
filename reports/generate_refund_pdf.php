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
$selectedProduct = $_GET['selectedProduct'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

$fetchRefund= $refundFacade->getRefundData($selectedProduct,$singleDateData,$startDate,$endDate);
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);


$pdf = new TCPDF();
$pdf->SetCreator('TinkerPro Inc.');
$pdf->SetAuthor('TinkerPro Inc.');
$pdf->SetTitle('Refund Table PDF');
$pdf->SetSubject('Refund Table PDF Document');
$pdf->SetKeywords('TCPDF, PDF, refund, table');

$pdf->AddPage();


$pdf->SetCellHeightRatio(1.5);
$imageFile = './../assets/img/tinkerpro-logo-dark.png'; 
$imageWidth = 45; 
$imageHeight = 15; 
$imageX = 10; 
$pdf->Image($imageFile, $imageX, $y = 10, $w = $imageWidth, $h = $imageHeight, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);
$pdf->SetFont('', 'I', 8);



$pdf->SetFont('', 'B', 10);
$pdf->Cell(0, 10, 'REFUND', 0, 1, 'R', 0); 
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



$totalAmount = 0; 
$pdf->SetFont('', '', 10); 
// while ($row = $fetchRefund->fetch(PDO::FETCH_ASSOC)) {

//     $pdf->SetFont('', 'B', 10);
//     $pdf->Cell(0, 10, "Refund No.: {$row['reference_num']}", 0, 'L');
//     $pdf->Ln(-1); 
//     $header = array( 'Product', 'Barcode', 'SKU', 'Total Qty.', 'Amount(Php)');
//     $headerWidths = array( 80, 25, 25, 20, 40);
//     $maxCellHeight = 5; 

//     $hexColor = '#F5F5F5';
//     list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

//     $pdf->SetFillColor($r, $g, $b);
//     $pdf->SetFont('', 'B', 10);
//     for ($i = 0; $i < count($header); $i++) {
//         if ($header[$i] === 'Product') {
//             $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'L', true);
//         } else {
//             $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'C', true);
//         }
//     }
//     $pdf->Ln(); 
//     $pdf->Cell($headerWidths[0], $maxCellHeight, $row['prod_desc'], 1, 0, 'L');
//     $pdf->Cell($headerWidths[1], $maxCellHeight, '', 1, 0, 'L');
//     $pdf->Cell($headerWidths[2], $maxCellHeight, '', 1, 0, 'L');
//     $pdf->Cell($headerWidths[3], $maxCellHeight, $row['qty'], 1, 0, 'L');
//     $pdf->Cell($headerWidths[4], $maxCellHeight, $row['amount'], 1, 0, 'R');
//     $pdf->Ln(); 
    
// }

$header = array('Product', 'Barcode', 'SKU', 'Total Qty.', 'Amount(Php)');
$headerWidths = array(80, 25, 25, 20, 40);
$maxCellHeight = 5;

$hexColor = '#F5F5F5';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

$pdf->SetFillColor($r, $g, $b);
$pdf->SetFont('', 'B', 10);

while ($row = $fetchRefund->fetch(PDO::FETCH_ASSOC)) {
    $pdf->SetFont('', 'B', 10);
    $pdf->Cell(0, 10, "Refund No.: {$row['reference_num']}", 0, 'L');
    $pdf->Ln(-1);

    $pdf->SetFont('', 'B', 10);
    for ($i = 0; $i < count($header); $i++) {
        if ($header[$i] === 'Product') {
            $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'L', true);
        } else {
            $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'C', true);
        }
    }
    $pdf->Ln();

    $pdf->Cell($headerWidths[0], $maxCellHeight, $row['prod_desc'], 1, 0, 'L');
    $pdf->Cell($headerWidths[1], $maxCellHeight, '', 1, 0, 'L');
    $pdf->Cell($headerWidths[2], $maxCellHeight, '', 1, 0, 'L');
    $pdf->Cell($headerWidths[3], $maxCellHeight, $row['qty'], 1, 0, 'L');
    $pdf->Cell($headerWidths[4], $maxCellHeight, $row['amount'], 1, 0, 'R');
    $pdf->Ln();
}


$pdf->Output('refundList.pdf', 'I');
$pdfPath = __DIR__ . '/../assets/pdf/refund/refundList.pdf';

if (file_exists($pdfPath)) {

    unlink($pdfPath);
}
$pdf->Output($pdfPath, 'F');
?>
