<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
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

$products = new ProductFacade();

$counter = 1;

$searchQuery = $_GET['searchQuery'] ?? null;
$selectedProduct = $_GET['selectedProduct'] ?? null;
$selectedCategories = $_GET['selectedCategories'] ?? null;
$selectedSubCategories = $_GET['selectedSubCategories'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

$count = $products->getTotalProductsCount();

$recordsPerPage = $count;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

// Fetch users with pagination
$fetchProducts = $products->fetchProducts($searchQuery,$selectedProduct,$singleDateData,$startDate,$endDate,$selectedCategories,$selectedSubCategories, $offset, $recordsPerPage);
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);


$pdf = new TCPDF();
$pdf->SetCreator('TinkerPro Inc.');
$pdf->SetAuthor('TinkerPro Inc.');
$pdf->SetTitle('Product Table PDF');
$pdf->SetSubject('Product Table PDF Document');
$pdf->SetKeywords('TCPDF, PDF, product, table');

$pdf->AddPage();


$pdf->SetCellHeightRatio(1.5);
$imageFile = './assets/img/tinkerpro-logo-dark.png'; 
$imageWidth = 45; 
$imageHeight = 15; 
$imageX = 10; // Adjust this value to your desired left margin
$pdf->Image($imageFile, $imageX, $y = 10, $w = $imageWidth, $h = $imageHeight, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);
$pdf->SetFont('', 'I', 8);


$pdf->SetFont('', 'B', 10);
$pdf->Cell(0, 10, 'PRODUCTS', 0, 1, 'R', 0); 
$pdf->Ln(-5);
$pdf->SetFont('',  10);
$pdf->Cell(0, 10, "{$shop['shop_name']}", 0, 1, 'R', 0); 

$pdf->Ln(-3);
$pdf->SetFont('', 'I', 10); // Bold, size 10
$pdf->MultiCell(0, 10, "{$shop['shop_address']}", 0, 'R');
$pdf->Ln(-9);
$pdf->SetFont('', 'I', 8); // Italic, size 8
$pdf->MultiCell(0, 10, "Contact: {$shop['contact_number']}", 0, 'L');
$pdf->SetFont('' , 8); 
$pdf->Ln(-9);
$current_date = date('F j, Y');
$pdf->Cell(0, 10, "Date: $current_date", 0, 'L');
$pdf->Ln(-2);


$header = array('No.','SKU','Product Name', 'UOM', 'Markup(%)', 'Cost(Php)', 'Unit Price(Php)','Tax(Php)');
$headerWidths = array(10, 15, 50, 25, 22, 22, 27, 20);
$maxCellHeight = 5; 

$hexColor = '#FF6900';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

$pdf->SetFillColor($r, $g, $b);

$pdf->SetFont('', 'B', 10);
for ($i = 0; $i < count($header); $i++) {
    $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'L', true); 
}
$pdf->Ln(); 

$pdf->SetFont('', '', 10); 
$totalCost = 0;
$totalSellingPrice = 0;
$totalTax = 0;
$formatted_tax = 0;
while ($row = $fetchProducts->fetch(PDO::FETCH_ASSOC)) {
    if ($row['prod_price'] && $row['isVAT'] == 1) {
        $product_price = $row['prod_price'];
        $vatable = round($product_price / 1.12, 2);
        $tax = $product_price - $vatable;
        $totalTax += $tax; 
        $formatted_tax = number_format($tax, 2);
    }
    
    if($row['prod_price']){
        $formatted_price = number_format($row['prod_price'],2);
        $totalSellingPrice += $row['prod_price'];
    }
    if($row['cost']){
        $formatted_cost = number_format($row['cost'],2);
        $totalCost += $row['cost'];
    }
  
    
    $pdf->Cell($headerWidths[0], $maxCellHeight, $counter, 1, 0, 'C');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['sku'] , $headerWidths[1]));
    $pdf->Cell($headerWidths[1], $maxCellHeight, $row['sku'], 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['prod_desc'], $headerWidths[2]));
    $pdf->Cell($headerWidths[2], $maxCellHeight, $row['prod_desc'], 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['uom_name'], $headerWidths[3]));
    $pdf->Cell($headerWidths[3], $maxCellHeight, $row['uom_name'], 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['markup'], $headerWidths[4]));
    $pdf->Cell($headerWidths[4], $maxCellHeight, $row['markup'], 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf,  $formatted_cost, $headerWidths[5]));
    $pdf->Cell($headerWidths[5], $maxCellHeight,  $formatted_cost, 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf,  $formatted_price , $headerWidths[6]));
    $pdf->Cell($headerWidths[6], $maxCellHeight, $formatted_price , 1, 0, 'L');    
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $formatted_tax, $headerWidths[7]));
    $pdf->Cell($headerWidths[7], $maxCellHeight, $row['isVAT'] == 1 ? $formatted_tax : "", 1, 0, 'L');
    $pdf->Ln(); // Move to next line
    $counter++;
}



$pdf->SetFont('', 'B', 10); 
$pdf->Cell($headerWidths[0] + $headerWidths[1] + $headerWidths[2] + $headerWidths[3] + $headerWidths[4], $maxCellHeight, 'Total', 1, 0, 'C'); 
$pdf->Cell($headerWidths[5], $maxCellHeight, number_format($totalCost, 2), 1, 0, 'L'); 
$pdf->Cell($headerWidths[6], $maxCellHeight, number_format($totalSellingPrice, 2), 1, 0, 'L'); 
$pdf->Cell($headerWidths[7], $maxCellHeight, number_format($totalTax, 2), 1, 0, 'L'); 
$pdf->Ln(); 


$pdf->Output('product_list.pdf', 'I');
$pdfPath = __DIR__ . '/assets/pdf/product/product_list.pdf';

if (file_exists($pdfPath)) {
 
    unlink($pdfPath);
}
$pdf->Output($pdfPath, 'F');
?>
