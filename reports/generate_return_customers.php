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
$selectedCustomers = $_GET['selectedCustomers'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

$fetchRefund= $refundFacade->getReturnExchangeCustomers($selectedCustomers,$singleDateData,$startDate,$endDate);
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);


$pdf = new TCPDF();
$pdf->SetCreator('TinkerPro Inc.');
$pdf->SetAuthor('TinkerPro Inc.');
$pdf->SetTitle('Return & Exchange Table PDF');
$pdf->SetSubject('Return & Exchange Table PDF Document');
$pdf->SetKeywords('TCPDF, PDF, return, table');

$pdf->AddPage();


$pdf->SetCellHeightRatio(1.5);
$imageFile = './../assets/img/tinkerpro-logo-dark.png'; 
$imageWidth = 45; 
$imageHeight = 15; 
$imageX = 10; 
$pdf->Image($imageFile, $imageX, $y = 10, $w = $imageWidth, $h = $imageHeight, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);
$pdf->SetFont('', 'I', 8);


$pdf->SetFont('', 'B', 10);
$pdf->Cell(0, 10, 'RETURN & EXCHANGE', 0, 1, 'R', 0); 
$pdf->Ln(-5);
$pdf->SetFont('',  10);
$pdf->Cell(0, 10, "{$shop['shop_name']}", 0, 1, 'R', 0); 

$pdf->Ln(-3);
$pdf->SetFont('', 'I', 10); 
$pdf->MultiCell(0, 10, "{$shop['shop_address']}", 0, 'R');
$pdf->Ln(-9);
$pdf->SetFont('', 'I', 8); 
$pdf->MultiCell(0, 10, "Contact: {$shop['contact_number']}", 0, 'L');
$pdf->SetFont('' , 8); 
$pdf->Ln(-9);
$current_date = date('F j, Y');
$pdf->Cell(0, 10, "Date: $current_date", 0, 'L');
$pdf->Ln(-2);


$header = array('No.', 'Customer Name', 'Product Price', 'Quantity', 'Ref. No.', 'Total Amount', 'Date');
$headerWidths = array(10, 50, 25, 18, 25, 25, 35);
$maxCellHeight = 5; 

$hexColor = '#FF6900';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

$pdf->SetFillColor($r, $g, $b);


$pdf->SetFont('', 'B', 10);
for ($i = 0; $i < count($header); $i++) {
    $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'L', true); 
}
$pdf->Ln(); 

$totalAmount = 0; 
$pdf->SetFont('', '', 10); 
while ($row = $fetchRefund->fetch(PDO::FETCH_ASSOC)) {
    $totalAmount += $row['return_amount'];
    $pdf->Cell($headerWidths[0], $maxCellHeight, $counter, 1, 0, 'C');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['user_last_name'] . ' ' . $row['user_first_name'] , $headerWidths[1]));
    $pdf->Cell($headerWidths[1], $maxCellHeight, $row['user_last_name'] . ' ' . $row['user_first_name'] , 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['prod_price'], $headerWidths[2]));
    $pdf->Cell($headerWidths[2], $maxCellHeight, $row['prod_price'], 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['qty'], $headerWidths[3]));
    $pdf->Cell($headerWidths[3], $maxCellHeight, $row['qty'], 1, 0, 'L');
    $formatted_receipt_id = str_pad($row['receipt_id'], 9, '0', STR_PAD_LEFT);
    $pdf->Cell($headerWidths[4], $maxCellHeight, $formatted_receipt_id, 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['return_amount'], $headerWidths[5]));
    $pdf->Cell($headerWidths[5], $maxCellHeight, $row['return_amount'], 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['date'] !== null ? date('M j, Y', strtotime($row['date'])) : '', $headerWidths[6]));
    $pdf->Cell($headerWidths[6], $maxCellHeight, $row['date'] !== null ? date('M j, Y', strtotime($row['date'])) : '', 1, 0, 'L');    
   
    $pdf->Ln(); // Move to next line
    $counter++;
}

$pdf->SetFont('', 'B', 10);
// $pdf->Cell($headerWidths[0] + $headerWidths[1] + $headerWidths[2] + $headerWidths[3] + $headerWidths[4] + $headerWidths[5]+ $headerWidths[6], $maxCellHeight, "Total: Php " . number_format($totalAmount, 2), 1, 0, 'R');
$pdf->Cell($headerWidths[0] + $headerWidths[1] + $headerWidths[2] + $headerWidths[3] + $headerWidths[4] + $headerWidths[5] + $headerWidths[6], $maxCellHeight, "Total: Php " . number_format($totalAmount, 2), 0, 0, 'R');

$pdf->Output('returnAndExchangeList.pdf', 'I');
$pdfPath = __DIR__ . '/../assets/pdf/return/returnAndExchangeList.pdf';
if (file_exists($pdfPath)) {

    unlink($pdfPath);
}
$pdf->Output($pdfPath, 'F');
?>
