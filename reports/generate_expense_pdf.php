<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');
include( __DIR__ . '/../utils/models/expense-facade.php');


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
$expenses = new ExpenseFacade();

$counter = 1;
$customerId= $_GET['customerId'] ?? null;

$fetchRefund= $refundFacade->getCustomersData($customerId);
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);


$pdf = new TCPDF();
$pdf->SetCreator('TinkerPro Inc.');
$pdf->SetAuthor('TinkerPro Inc.');
$pdf->SetTitle('Expenses Table PDF');
$pdf->SetSubject('Expenses PDF Document');
$pdf->SetKeywords('TCPDF, PDF, Expenses, table');
$pdf->setPageOrientation('L');
$pdf->AddPage();


$pdf->SetCellHeightRatio(1.5);
$imageFile = './../assets/img/tinkerpro-logo-dark.png'; 
$imageWidth = 45; 
$imageHeight = 15; 
$imageX = 10; 
$pdf->Image($imageFile, $imageX, $y = 10, $w = $imageWidth, $h = $imageHeight, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);
$pdf->SetFont('', 'I', 8);


$pdf->SetFont('', 'B', 10);
$pdf->Cell(0, 10, 'Expenses', 0, 1, 'R', 0); 
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
// if($customerId){
    $header = array('No.', 'Item Name', 'Date', 'Billable', 'Type', 'Quantity', 'UOM', 'Supplier', 'Inv. Num', 'Price (Php)', 'Disc.', 'To. Amt(Php)');
    $headerWidths = array(10, 40, 25, 25, 40, 15, 15, 20, 30, 20, 20, 20, 20);
    $maxCellHeight = 5; 
    
    $hexColor = '#F5F5F5';
    list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");
    
    $pdf->SetFillColor($r, $g, $b);
    
    
    $pdf->SetFont('', 'B', 8);
    for ($i = 0; $i < count($header); $i++) {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'C', true);
    }
    $pdf->Ln(); 

    $expenses_data = $expenses->get_data();
    $totalAmount = 0; 
    $pdf->SetFont('', '', 10); 
    $total_expenses = 0;
    foreach($expenses_data as $row) {
        $pdf->Cell($headerWidths[0], $maxCellHeight, $counter, 1, 0, 'C');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['item_name'] . ' ' . $row['item_name'], $headerWidths[1]));
        $pdf->Cell($headerWidths[1], $maxCellHeight, $row['item_name'] . ' ' . $row['item_name'], 1, 0, 'L');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['dot'], $headerWidths[2]));
        $pdf->Cell($headerWidths[2], $maxCellHeight, $row['dot'], 1, 0, 'C');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['billable_receipt_no'], $headerWidths[3]));
        $pdf->Cell($headerWidths[3], $maxCellHeight, $row['billable_receipt_no'], 1, 0, 'L');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['expense_type'], $headerWidths[4]));
        $pdf->Cell($headerWidths[4], $maxCellHeight, $row['expense_type'], 1, 0, 'L');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['quantity'], $headerWidths[5]));
        $pdf->Cell($headerWidths[5], $maxCellHeight, $row['quantity'], 1, 0, 'C'); 
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['uom_name'], $headerWidths[6]));
        $pdf->Cell($headerWidths[6], $maxCellHeight, $row['uom_name'], 1, 0, 'C'); 
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['supplier'], $headerWidths[7]));
        $pdf->Cell($headerWidths[7], $maxCellHeight, $row['supplier'], 1, 0, 'L'); 
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['invoice_number'], $headerWidths[8]));
        $pdf->Cell($headerWidths[8], $maxCellHeight, $row['invoice_number'], 1, 0, 'C'); 
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, number_format($row['price'],2), $headerWidths[9]));
        $pdf->Cell($headerWidths[9], $maxCellHeight, number_format($row['price'],2), 1, 0, 'R'); 
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, number_format($row['discount'],2), $headerWidths[10]));
        $pdf->Cell($headerWidths[10], $maxCellHeight, number_format($row['discount'], 2), 1, 0, 'R'); 
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, number_format($row['total_amount'], 2), $headerWidths[11]));
        $pdf->Cell($headerWidths[11], $maxCellHeight, number_format($row['total_amount'], 2), 1, 0, 'R'); 
        $total_expenses += $row['total_amount'];
        $pdf->Ln(); 
        $counter++;
    }


    $pdf->SetFont('', 'B', 8); 
    $pdf->Cell(array_sum($headerWidths) - $headerWidths[10] - $headerWidths[11], $maxCellHeight, 'Total', 1, 0, 'R'); 
    $pdf->Cell(($headerWidths[11]), $maxCellHeight, number_format( $total_expenses, 2), 1, 0, 'R'); 
    $pdf->Ln(); 

$pdf->Output('expensesList.pdf', 'I');
$pdfPath = __DIR__ . '/../assets/pdf/expenses/expensesList.pdf';

if (file_exists($pdfPath)) {
 
    unlink($pdfPath);
}
$pdf->Output($pdfPath, 'F');
?>
