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

$fetchRefund= $refundFacade->getCustomersData($customerId);
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);


$pdf = new TCPDF();
$pdf->SetCreator('TinkerPro Inc.');
$pdf->SetAuthor('TinkerPro Inc.');
$pdf->SetTitle('Customer Table PDF');
$pdf->SetSubject('Customer Table PDF Document');
$pdf->SetKeywords('TCPDF, PDF, Customer, table');

$pdf->AddPage();


$pdf->SetCellHeightRatio(1.5);
$imageFile = './../assets/img/tinkerpro-logo-dark.png'; 
$imageWidth = 45; 
$imageHeight = 15; 
$imageX = 10; 
$pdf->Image($imageFile, $imageX, $y = 10, $w = $imageWidth, $h = $imageHeight, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);
$pdf->SetFont('', 'I', 8);


$pdf->SetFont('', 'B', 10);
$pdf->Cell(0, 10, 'CUSTOMER', 0, 1, 'R', 0); 
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

if($customerId){
    $header = array('No.', 'Name', 'Contact', 'Email', 'Discount Type', 'Rate(%)');
    $headerWidths = array(10, 50, 40, 25, 40, 25);
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
        $pdf->Cell($headerWidths[0], $maxCellHeight, $counter, 1, 0, 'C');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['last_name'] . ' ' . $row['first_name'], $headerWidths[1]));
        $pdf->Cell($headerWidths[1], $maxCellHeight, $row['last_name'] . ' ' . $row['first_name'], 1, 0, 'L');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['contact'], $headerWidths[2]));
        $pdf->Cell($headerWidths[2], $maxCellHeight, $row['contact'], 1, 0, 'L');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['email'], $headerWidths[3]));
        $pdf->Cell($headerWidths[3], $maxCellHeight, $row['email'], 1, 0, 'L');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['name'], $headerWidths[4]));
        $pdf->Cell($headerWidths[4], $maxCellHeight, $row['name'], 1, 0, 'L');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['rate'], $headerWidths[4]));
        $pdf->Cell($headerWidths[5], $maxCellHeight, $row['rate'], 1, 0, 'L');;    
       
        $pdf->Ln(); // Move to next line
        $counter++;
    }
    
}else{
    $totalAmount = 0;
    $pdf->SetFont('', '', 10);
    while ($row = $fetchRefund->fetch(PDO::FETCH_ASSOC)) {
        $pdf->SetFont('', 'B', 10);
        $pdf->Cell(0, 10, "Customer Name: " . $row['last_name'] . ' ' . $row['first_name'], 0, 1, 'L');
        $pdf->Ln(-2) ;
        $header = array('No.', 'Contact', 'Email', 'Discount Type', 'Rate(%)');
        $headerWidths = array(10, 50, 50, 40, 40);
        $maxCellHeight = 5;
    
        $hexColor = '#FF6900';
        list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");
    
        $pdf->SetFillColor($r, $g, $b);
    
        $pdf->SetFont('', 'B', 10);
        for ($i = 0; $i < count($header); $i++) {
            $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'C', true);
        }
        $pdf->Ln() ;
        $pdf->Cell($headerWidths[0], $maxCellHeight, $counter, 1, 0, 'C');
        $pdf->Cell($headerWidths[1], $maxCellHeight, $row['contact'], 1, 0, 'L');
        $pdf->Cell($headerWidths[2], $maxCellHeight, $row['email'], 1, 0, 'L');
        $pdf->Cell($headerWidths[3], $maxCellHeight, $row['name'], 1, 0, 'L');
        $pdf->Cell($headerWidths[4], $maxCellHeight, $row['rate'], 1, 0, 'L');
        $pdf->Ln(); 
        $counter++;
    }
}



$pdf->Output('customerList.pdf', 'I');
$pdfPath = __DIR__ . '/../assets/pdf/customer/customerList.pdf';

if (file_exists($pdfPath)) {
 
    unlink($pdfPath);
}
$pdf->Output($pdfPath, 'F');
?>
