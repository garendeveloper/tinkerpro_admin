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
$selectedMethod = $_GET['selectedMethod'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

$fetchRefund= $refundFacade->getPaymentMethod($selectedMethod,$singleDateData,$startDate,$endDate);
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);


$pdf = new TCPDF();
$pdf->SetCreator('TinkerPro Inc.');
$pdf->SetAuthor('TinkerPro Inc.');
$pdf->SetTitle('Payment Method Table PDF');
$pdf->SetSubject('Payment Method Table PDF Document');
$pdf->SetKeywords('TCPDF, PDF, payment method, table');

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
$pdf->SetDrawColor(192, 192, 192); 






$header = array('No.', 'Date', 'Cash', 'Credit', 'E-wallet', 'Debit/Credit', 'Total(Php)');
$headerWidths = array(10, 30, 30, 30, 30, 30, 30);
$maxCellHeight = 5;

$hexColor = '#F5F5F5';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

$pdf->SetFillColor($r, $g, $b);
$pdf->SetFont('', 'B', 10);

for ($i = 0; $i < count($header); $i++) {
    $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'C', true);
}
$pdf->Ln();

$pdf->SetFont('', '', 10);
// Define an array to store the sum of amounts for each payment type
$sumByPaymentType = array(
    'cash' => 0,
    'credit' => 0,
    'maya' => 0,
    'alipay' => 0,
    'master card' => 0,
    'american express' => 0,
    'coupon' => 0
);

// Loop through the fetched data to calculate the sum for each payment type
while ($row = $fetchRefund->fetch(PDO::FETCH_ASSOC)) {
    $paymentType = strtolower($row['paymentType']);
    $amount = floatval($row['amount']);
    $sumByPaymentType[$paymentType] += $amount;
}


// Print the sum for each payment type
// Print the sum for each payment type
foreach ($sumByPaymentType as $paymentType => $sum) {
    $pdf->Cell($headerWidths[0], $maxCellHeight, $counter, 1, 0, 'LR'); // No content, just to maintain cell structure
    $pdf->Cell($headerWidths[1], $maxCellHeight, $singleDateData, 'LR');
    $pdf->Cell($headerWidths[2], $maxCellHeight, $paymentType == 'cash' ? number_format($sum, 2) : '', 'LR', 0, 'C');
    $pdf->Cell($headerWidths[3], $maxCellHeight, '', 'LR'); // No content, just to maintain cell structure
    $pdf->Cell($headerWidths[4], $maxCellHeight, '', 'LR'); // No content, just to maintain cell structure
    $pdf->Cell($headerWidths[5], $maxCellHeight, '', 'LR'); // No content, just to maintain cell structure
    $pdf->Cell($headerWidths[6], $maxCellHeight, '', 'LR'); // No content, just to maintain cell structure
   // Move to the next line after each row
   $pdf->Ln(); // Move to next line
   $counter++;
}

$pdf->Ln(); 

$pdf->Output('paymentMethodList.pdf', 'I');
$pdfPath = __DIR__ . '/../assets/pdf/payment_method/paymentMethodList.pdf';

if (file_exists($pdfPath)) {
    unlink($pdfPath);
}

$pdf->Output($pdfPath, 'F');
?>
