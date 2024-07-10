<?php
    require_once '../reports/vendor/autoload.php';
    include('../utils/db/connector.php');
    include('../utils/models/user-facade.php');
    include('../utils/models/product-facade.php');
    include('../utils/models/inventory-facade.php');
    include('../utils/models/order-facade.php');
    include('../utils/models/loss_and_damage-facade.php');
    include('../utils/models/supplier-facade.php');
    include('../utils/models/inventorycount-facade.php');



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

$products = new ProductFacade();

$counter = 1;
$inventoryfacade = new InventoryFacade();
$start_date = $_GET['start_date'] ?? 0;
$end_date = $_GET['end_date'] ?? 0;
$product_id = $_GET['product_id'] ?? 0;


$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);


$paperSize = 'A4'; 

if ($paperSize == 'A4') {
    $pageWidth = 210;
    $pageHeight = 297;
}
$info = $inventoryfacade->get_allStocksData($product_id)['inventoryInfo'];

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
$pdf->Cell(0, 10, "STOCK MOVEMENT OF {$info['prod_desc']}", 0, 1, 'R', 0); 
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


$items = $inventoryfacade->get_allStocksData($product_id)['stocks'];
if($start_date != 0 && $end_date != 0)
{
    $items = $inventoryfacade->get_allStocksDataByDate($product_id, $start_date, $end_date)['stocks'];
}

$pdf->SetDrawColor(192, 192, 192); 
$pdf->SetLineWidth(0.3); 
$header = array('No.', 'Document Type', 'Document', 'User', 'Date', 'Stock Date', 'Quantity', 'In Stock');
$pageWidth = $pdf->getPageWidth();
$pageHeight = $pdf->getPageHeight();

$headerWidths = array();
$headerWidths = array(20, 60, 30, 35, 25, 50, 28, 28);
$maxCellHeight = 5; 

$hexColor = '#F5F5F5';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

$pdf->SetFillColor($r, $g, $b);
$pdf->SetFont('', 'B', 10);
for ($i = 0; $i < count($header); $i++) {
    if ($header[$i] === 'Document Type') {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'L', true);
    } else {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'C', true);
    }
}
$pdf->Ln(); 


$pdf->SetFont('', 'B', 10); 
$pdf->Cell($headerWidths[0]+$headerWidths[1] + $headerWidths[2], $maxCellHeight, 'Beggining Stock', 1, 0, 'L', true); 
$pdf->Cell( $headerWidths[3] + $headerWidths[4] + $headerWidths[5] + $headerWidths[6] + $headerWidths[7], $maxCellHeight, number_format(0, 2), 1, 0, 'R', true); 
$pdf->Ln(); 

$pdf->SetFont('', '', 10); 
$remaining_stock = 0;
foreach ($items as $item) 
{
    $stockDateTime = strtotime($item['stock_date']);
    $stockDate = date("M d y", $stockDateTime);
    $stockTimestamp = date("M d y h:i:s A", $stockDateTime); 

    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $counter, $headerWidths[0]));
    $pdf->Cell($headerWidths[0], $maxCellHeight, $counter, 1, 0, 'C');

    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['transaction_type'], $headerWidths[1]));
    $pdf->Cell($headerWidths[1], $maxCellHeight, $item['transaction_type'], 1, 0, 'L');

    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['document_number'], $headerWidths[2]));
    $pdf->Cell($headerWidths[2], $maxCellHeight, $item['document_number'], 1, 0, 'C');

    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['stock_customer'], $headerWidths[3]));
    $pdf->Cell($headerWidths[3], $maxCellHeight, $item['stock_customer'], 1, 0, 'C');

    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $stockDate, $headerWidths[4]));
    $pdf->Cell($headerWidths[4], $maxCellHeight, $stockDate, 1, 0, 'C');

    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $stockTimestamp, $headerWidths[5]));
    $pdf->Cell($headerWidths[5], $maxCellHeight, $stockTimestamp, 1, 0, 'C');

    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['stock_qty'], $headerWidths[6]));
    $pdf->Cell($headerWidths[6], $maxCellHeight, $item['stock_qty'], 1, 0, 'R');

    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['stock'], $headerWidths[7]));
    $pdf->Cell($headerWidths[7], $maxCellHeight, $item['stock'], 1, 0, 'R');
    $remaining_stock = $item['stock'];
    $pdf->Ln(); 
    $counter++;
}

$pdf->SetFont('', 'B', 10); 
$pdf->Cell($headerWidths[0]+$headerWidths[1] + $headerWidths[2] + $headerWidths[3] + $headerWidths[4], $maxCellHeight, 'Remaining stock of '.$info['prod_desc'] . ' as of '.$current_date, 1, 0, 'L', true); 
$pdf->Cell($headerWidths[5] + $headerWidths[6] + $headerWidths[7], $maxCellHeight, number_format($remaining_stock, 2), 1, 0, 'R', true); 
$pdf->Ln(); 
$pdf->Output('stocks.pdf', 'I');
$pdfPath = __DIR__ . '/assets/pdf/inventory/stocks.pdf';

if (file_exists($pdfPath)) {

    unlink($pdfPath);
}
$pdf->Output($pdfPath, 'F');

 ?>
