<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');

use TCPDF;

$pdfFolder = __DIR__ . '/../assets/pdf/return/';

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

$refundFacade = new OtherReportsFacade();
$products = new ProductFacade();

$counter = 1;
$selectedProduct = $_GET['selectedProduct'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

$fetchRefund= $refundFacade->getReturnAndEx($selectedProduct,$singleDateData,$startDate,$endDate);
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
$pdf->Cell(0, 10, 'RETURN AND EXCHANGE', 0, 1, 'R', 0); 
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
} else if (!$singleDateData && $startDate && $endDate) {
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




$pdf->SetFont('', '', 10); 

$header = array('Product', 'Barcode', 'SKU', 'Total Qty.', 'Amount');
$headerWidths = array(70, 40, 20, 20, 40);
$maxCellHeight = 5;

$hexColor = '#F5F5F5';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

$pdf->SetFillColor($r, $g, $b);
$pdf->SetFont('', 'B', 10);



$amountPerRef = array();
$previousRefNum = null;
$discountsData = array();
$itemDiscounts = array();
$cartDiscounts = array();

while ($row = $fetchRefund->fetch(PDO::FETCH_ASSOC)) {
    if($row){
    $referenceNum = $row['receipt_id'];
    $otherDetails = $row['otherDetails'];
    $otherDetailsArray = json_decode($otherDetails, true);

    
 
    $itemDiscount = 0;
    $cartDiscount = 0;
    $discount = 0;
       if (json_last_error() === JSON_ERROR_NONE && isset($otherDetailsArray[0]['discount'])) {
        $discount = $otherDetailsArray[0]['discount'];
    }

    if (json_last_error() === JSON_ERROR_NONE && isset($otherDetailsArray[0]['itemDiscountsData'])) {
        $itemDiscount = $otherDetailsArray[0]['itemDiscountsData'];
    }
    if (json_last_error() === JSON_ERROR_NONE && isset($otherDetailsArray[0]['cartRate'])) {
        $cartDiscount = $otherDetailsArray[0]['cartRate'];
    }

    if (!isset($amountPerRef[$referenceNum])) {
        $amountPerRef[$referenceNum] = 0;
    }
    if (!isset($discountsData[$referenceNum])) {
        $discountsData[$referenceNum] = 0;
    }
    if (!isset($itemDiscounts[$referenceNum])) {
        $itemDiscounts[$referenceNum] = 0;
    }
    if (!isset($cartDiscounts[$referenceNum])) {
        $cartDiscounts[$referenceNum] = 0;
    }
   
  
    if ($referenceNum !== $previousRefNum) {
        if (!is_null($previousRefNum)) {
            $pdf->SetFont('', 'B', 10);
            $pdf->SetFont('', 'B', 10);
            $pdf->Cell($headerWidths[0], $maxCellHeight, 'Discounts', 1, 0, 'L');
            $pdf->Cell($headerWidths[1], $maxCellHeight, '', 1, 0, 'R');
            $pdf->Cell($headerWidths[2], $maxCellHeight, '', 1, 0, 'R');
            $pdf->Cell($headerWidths[3], $maxCellHeight, '', 1, 0, 'R');
            $pdf->SetTextColor(255, 0, 0);
            $pdf->Cell($headerWidths[4], $maxCellHeight, number_format($discountsData[$previousRefNum], 2), 1, 0, 'R');
            $pdf->SetTextColor(0);
            $pdf->Ln();
            $pdf->Cell($headerWidths[0], $maxCellHeight, 'Item Discounts', 1, 0, 'L');
            $pdf->Cell($headerWidths[1], $maxCellHeight, '', 1, 0, 'R');
            $pdf->Cell($headerWidths[2], $maxCellHeight, '', 1, 0, 'R');
            $pdf->Cell($headerWidths[3], $maxCellHeight, '', 1, 0, 'R');
            $pdf->SetTextColor(255, 0, 0);
            $pdf->Cell($headerWidths[4], $maxCellHeight, number_format( $itemDiscounts[$previousRefNum]?? 0, 2), 1, 0, 'R');
            $pdf->SetTextColor(0);
            $pdf->Ln();
            $pdf->Cell($headerWidths[0], $maxCellHeight, 'Cart Discounts', 1, 0, 'L');
            $pdf->Cell($headerWidths[1], $maxCellHeight, '', 1, 0, 'R');
            $pdf->Cell($headerWidths[2], $maxCellHeight, '', 1, 0, 'R');
            $pdf->Cell($headerWidths[3], $maxCellHeight, '', 1, 0, 'R');
            $pdf->SetTextColor(255, 0, 0);
            $pdf->Cell($headerWidths[4], $maxCellHeight, number_format($cartRemove ?? 0, 2), 1, 0, 'R');
            $pdf->SetTextColor(0);
            $pdf->Ln();
            $pdf->Cell($headerWidths[0], $maxCellHeight, 'Total', 1, 0, 'L');
            $pdf->Cell($headerWidths[1], $maxCellHeight, '', 1, 0, 'R');
            $pdf->Cell($headerWidths[2], $maxCellHeight, '', 1, 0, 'R');
            $pdf->Cell($headerWidths[3], $maxCellHeight, '', 1, 0, 'R');
            $pdf->Cell($headerWidths[4], $maxCellHeight, number_format($amountPerRef[$previousRefNum]-$discountsData[$previousRefNum]-$itemDiscounts[$previousRefNum]-$cartRemove, 2), 1, 0, 'R');
            $pdf->Ln();
        }
        $pdf->SetFont('', 'B', 10);
        $pdf->Cell(0, 10, "Reference No.: " . str_pad($referenceNum, 9, '0', STR_PAD_LEFT), 0, 'L');
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

        $previousRefNum = $referenceNum;
        $amountPerRef[$referenceNum] = 0;
    }


    $pdf->SetFont('', '', 10);
    $pdf->Cell($headerWidths[0], $maxCellHeight, $row['prod_desc'], 1, 0, 'L');
    $pdf->Cell($headerWidths[1], $maxCellHeight, $row['barcode'], 1, 0, 'L');
    $pdf->Cell($headerWidths[2], $maxCellHeight, $row['sku'], 1, 0, 'C');
    $pdf->Cell($headerWidths[3], $maxCellHeight, $row['qty'], 1, 0, 'C');
    $pdf->Cell($headerWidths[4], $maxCellHeight, number_format($row['amount'], 2), 1, 0, 'R');
    $pdf->Ln();

    $amountPerRef[$referenceNum] += $row['amount'] ?? null;
    $discountsData[$referenceNum] =   $discount;
    $itemDiscounts[$referenceNum] += $itemDiscount;
    $cartDiscounts[$referenceNum] =   $cartDiscount;
    $cartRemove = $amountPerRef[$referenceNum] * $cartDiscounts[$referenceNum];
}
}


$pdf->SetFont('', 'B', 10);
$pdf->Cell($headerWidths[0], $maxCellHeight, 'Discounts', 1, 0, 'L');
$pdf->Cell($headerWidths[1], $maxCellHeight, '', 1, 0, 'R');
$pdf->Cell($headerWidths[2], $maxCellHeight, '', 1, 0, 'R');
$pdf->Cell($headerWidths[3], $maxCellHeight, '', 1, 0, 'R');
$pdf->SetTextColor(255, 0, 0);
$pdf->Cell($headerWidths[4], $maxCellHeight, number_format( $discountsData[$previousRefNum] ?? 0, 2), 1, 0, 'R');
$pdf->SetTextColor(0); 
$pdf->Ln();
$pdf->Cell($headerWidths[0], $maxCellHeight, 'Item Discounts', 1, 0, 'L');
$pdf->Cell($headerWidths[1], $maxCellHeight, '', 1, 0, 'R');
$pdf->Cell($headerWidths[2], $maxCellHeight, '', 1, 0, 'R');
$pdf->Cell($headerWidths[3], $maxCellHeight, '', 1, 0, 'R');
$pdf->SetTextColor(255, 0, 0);
$pdf->Cell($headerWidths[4], $maxCellHeight, number_format( $itemDiscounts[$previousRefNum]?? 0, 2), 1, 0, 'R');
$pdf->SetTextColor(0); 
$pdf->Ln();
$pdf->Cell($headerWidths[0], $maxCellHeight, 'Cart Discounts', 1, 0, 'L');
$pdf->Cell($headerWidths[1], $maxCellHeight, '', 1, 0, 'R');
$pdf->Cell($headerWidths[2], $maxCellHeight, '', 1, 0, 'R');
$pdf->Cell($headerWidths[3], $maxCellHeight, '', 1, 0, 'R');
$pdf->SetTextColor(255, 0, 0);
$pdf->Cell($headerWidths[4], $maxCellHeight, number_format($cartRemove ?? 0, 2), 1, 0, 'R'); 
$pdf->SetTextColor(0); 
$pdf->Ln();
$pdf->Cell($headerWidths[0], $maxCellHeight, 'Total', 1, 0, 'L');
$pdf->Cell($headerWidths[1], $maxCellHeight, '', 1, 0, 'R');
$pdf->Cell($headerWidths[2], $maxCellHeight, '', 1, 0, 'R');
$pdf->Cell($headerWidths[3], $maxCellHeight, '', 1, 0, 'R');
$pdf->Cell($headerWidths[4], $maxCellHeight, number_format($amountPerRef[$previousRefNum]-$discountsData[$previousRefNum]-$itemDiscounts[$previousRefNum]-$cartRemove, 2), 1, 0, 'R');
$pdf->Ln();

$pdfPath = $pdfFolder . 'returnAndExchangeList.pdf';
$pdf->Output($pdfPath, 'F');

$pdf->Output('returnAndExchangeList.pdf', 'I');



?>
