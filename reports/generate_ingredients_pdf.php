<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include( __DIR__ . '/../utils/models/ingredients-facade.php');
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

$ingredients= new IngredientsFacade();
$products = new ProductFacade();
$counter = 1;

$searchQuery = $_GET['searchQuery'] ?? null;
$selectedIngredients = $_GET['selectedIngredients'] ?? null;
// Fetch users with pagination
$fetchIngrdients = $ingredients->getAllIngredients($searchQuery,$selectedIngredients);
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);


$pdf = new TCPDF();
$pdf->SetCreator('TinkerPro Inc.');
$pdf->SetAuthor('TinkerPro Inc.');
$pdf->SetTitle('Ingredients Table PDF');
$pdf->SetSubject('Ingredients Table PDF Document');
$pdf->SetKeywords('TCPDF, PDF, ingredients, table');

$pdf->AddPage();


$pdf->SetCellHeightRatio(1.5);
$imageFile = './assets/img/tinkerpro-logo-dark.png'; 
$imageWidth = 45; 
$imageHeight = 15; 
$imageX = 10; // Adjust this value to your desired left margin
$pdf->Image($imageFile, $imageX, $y = 10, $w = $imageWidth, $h = $imageHeight, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);
$pdf->SetFont('', 'I', 8);


$pdf->SetFont('', 'B', 10);
$pdf->Cell(0, 10, 'INGREDIENTS', 0, 1, 'R', 0); 
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


$header = array('No.','Ingredients','Barcode', 'UOM', 'Cost(Php)', 'Status');
$headerWidths = array(10, 60, 30, 30,30,30);
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
$totalInactiveCost = 0;
$totalGrand = 0;
while ($row = $fetchIngrdients->fetch(PDO::FETCH_ASSOC)) {
    if ($row['cost'] && $row['status'] == 'Active') {
        $formatted_cost = number_format($row['cost'], 2);
        $totalCost += $row['cost'];
    } elseif ($row['cost'] && $row['status'] == "Inactive") {
        $formatted_cost = number_format($row['cost'], 2);
        $totalInactiveCost += $row['cost'];
    }
    $totalGrand = $totalCost + $totalInactiveCost;

    $pdf->Cell($headerWidths[0], $maxCellHeight, $counter, 1, 0, 'C');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['name'] , $headerWidths[1]));
    $pdf->Cell($headerWidths[1], $maxCellHeight, $row['name'], 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['barcode'], $headerWidths[2]));
    $pdf->Cell($headerWidths[2], $maxCellHeight, $row['barcode'], 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['uom_name'], $headerWidths[3]));
    $pdf->Cell($headerWidths[3], $maxCellHeight, $row['uom_name'], 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf,  $formatted_cost, $headerWidths[4]));
    $pdf->Cell($headerWidths[4], $maxCellHeight,  $formatted_cost, 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['status'], $headerWidths[5]));
    $pdf->Cell($headerWidths[5], $maxCellHeight, $row['status'], 1, 0, 'L');
   
    $pdf->Ln(); // Move to next line
    $counter++;
}

$pdf->SetFont('', 'B', 10);
$activeFormatted= number_format($totalCost, 2); 
$inactiveFormatted =  number_format($totalInactiveCost, 2); 
$totalGrandFormatted =  number_format($totalGrand, 2); 


$totalSellingWidth = $pdf->GetStringWidth("Total Cost(Inactive): Php $inactiveFormatted");
$totalCostWidth = $pdf->GetStringWidth("Total Cost(Active): Php $activeFormatted");
$totalTaxWidth = $pdf->GetStringWidth("Grand Total Cost: Php $totalGrandFormatted");


$maxTotalWidth = max($totalSellingWidth, $totalCostWidth, $totalTaxWidth);


$sellingPosition = 210 - $maxTotalWidth; 
$costPosition = 210 - $maxTotalWidth;
$taxPosition = 210 - $maxTotalWidth; 


$pdf->Cell($sellingPosition);
$pdf->Cell(0, 10, "Total Cost(Inactive): Php $inactiveFormatted", 0, 1, 'R', 0);
$pdf->Ln(-5);
$pdf->Cell($costPosition);
$pdf->Cell(0, 10, "Total Cost(Active): Php $activeFormatted", 0, 1, 'R', 0);
$pdf->Ln(-5);
$pdf->Cell($taxPosition);
$pdf->Cell(0, 10, "Grand Total Cost: Php $totalGrandFormatted", 0, 1, 'R', 0);
$pdf->Ln();

$pdf->Output('ingredient_list.pdf', 'I');
$pdfPath = __DIR__ . '/assets/pdf/ingredients/ingredients_list.pdf';

if (file_exists($pdfPath)) {
 
    unlink($pdfPath);
}
$pdf->Output($pdfPath, 'F');
?>
