<?php
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/customer-facade.php');
include(__DIR__ . '/../utils/models/user-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');
require_once('./vendor/autoload.php');
use TCPDF;

function autoAdjustFontSize($pdf, $text, $maxWidth, $initialFontSize = 8) {
    $pdf->SetFont('', '', $initialFontSize);
    while ($pdf->GetStringWidth($text) > $maxWidth) {
        $initialFontSize--;
        $pdf->SetFont('', '', $initialFontSize);
    }
    return $initialFontSize;
}



$counter = 1;
$customerFacade = new CustomerFacade;
$products = new ProductFacade;
$searchQuery = $_GET['searchQuery'] ?? null;

$customer = $customerFacade->getCustomersData($searchQuery);
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);


$pdf = new TCPDF();
$pdf->SetCreator('TinkerPro Inc.');
$pdf->SetAuthor('TinkerPro Inc.');
$pdf->SetTitle('CUSTOMERS');
$pdf->SetSubject('CUSTOMERS Table PDF Document');
$pdf->SetKeywords('TCPDF, PDF, CUSTOMERS, table');
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
$pdf->Cell(0, 10, 'CUSTOMERS', 0, 1, 'R', 0); 
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

$header = array('Name','Contact','Code/ID','Type', 'Email', 'Address');

$pageWidth = $pdf->getPageWidth();
$pageHeight = $pdf->getPageHeight();

$headerWidths = array();
    $headerWidths = array(40, 30, 30, 20, 30, 40);
$maxCellHeight = 5; 

$hexColor = '#F5F5F5';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

$pdf->SetFillColor($r, $g, $b);
$pdf->SetFont('', 'B', 10);
for ($i = 0; $i < count($header); $i++) {
    if ($header[$i] === 'Name') {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'L', true);
    } else {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'C', true);
    }
}
$pdf->Ln(); 


$pdf->SetFont('', '', 10); 

while ($row = $customer->fetch(PDO::FETCH_ASSOC)) {

     $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['firstname'] .' '.$row['lastname'] , $headerWidths[0]));   
     $pdf->Cell($headerWidths[0], $maxCellHeight, $row['firstname'] .' '.$row['lastname'], 1, 0, 'L');
     $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['contact'], $headerWidths[1]));   
     $pdf->Cell($headerWidths[1], $maxCellHeight, $row['contact'], 1, 0, 'C');
     $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['code'], $headerWidths[2]));   
     $pdf->Cell($headerWidths[2], $maxCellHeight, $row['code'], 1, 0, 'C');
     $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['type'], $headerWidths[3]));   
     if($row['type'] == 1){
        $pdf->Cell($headerWidths[3], $maxCellHeight, "Employee", 1, 0, 'C');
     }else{
        $pdf->Cell($headerWidths[3], $maxCellHeight, "Customers", 1, 0, 'C');
     }
     $pdf->SetFont('', '', autoAdjustFontSize($pdf,  $row['email'], $headerWidths[4]));   
     $pdf->Cell($headerWidths[4], $maxCellHeight, $row['email'], 1, 0, 'L');
     $pdf->SetFont('', '', autoAdjustFontSize($pdf,  $row['address'], $headerWidths[5]));   
     $pdf->Cell($headerWidths[5], $maxCellHeight,$row['address'], 1, 0, 'L');


     $pdf->Ln(); 
     
}


    
    $pdf->Output('customer_list.pdf', 'I');

 




 ?>
