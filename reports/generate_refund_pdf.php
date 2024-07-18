<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');

use TCPDF;

$pdfFolder = __DIR__ . '/../assets/pdf/refund/';

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
} else if (!$singleDateData && $startDate && $endDate) {
    $formattedStartDate = date('M j, Y', strtotime($startDate));
    $formattedEndDate = date('M j, Y', strtotime($endDate));
    $pdf->SetFont('', '', 11); 
    $pdf->Cell(0, 10, "Period: $formattedStartDate - $formattedEndDate", 0, 'L');
} else {
    $otherFacade = new OtherReportsFacade;
    $others =    $otherFacade->getDateRefunded();
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
$amountPerRefs = array();
$previousRefNum = null;
$discountsData = array();
$itemDiscounts = array();
$cartDiscounts = array();
$overAllRefunded = 0;
$overAlldisCounts = 0;
$overAllItem = 0;
$overAllCart  = 0;
$discount = 0;
$data = 0;

$firstDiscountSum = 0; 
$processedRefs = array();
$totalAmountPerRef = 0;
while ($row = $fetchRefund->fetch(PDO::FETCH_ASSOC)) {
    $otherDetails = $row['otherDetails'];
    $otherDetailsArray = json_decode($otherDetails, true);

    
 
    $itemDiscount = 0;
    $cartDiscount = 0;
       if (json_last_error() === JSON_ERROR_NONE && isset($otherDetailsArray[0]['discount'])) {
        $discount = $otherDetailsArray[0]['discount'];
    }

    if (json_last_error() === JSON_ERROR_NONE && isset($otherDetailsArray[0]['itemDiscountsData'])) {
        $itemDiscount = $otherDetailsArray[0]['itemDiscountsData'];
    }
    if (json_last_error() === JSON_ERROR_NONE && isset($otherDetailsArray[0]['cartRate'])) {
        $cartDiscount = $otherDetailsArray[0]['cartRate'];
    }

  
    $referenceNum = $row['reference_num'] ?? null;
    $method = $row['method'] ?? null;
    $receipt = str_pad($receipt = $row['receipt_id'], 9, '0', STR_PAD_LEFT);
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
   
    if (!isset($processedRefs[$referenceNum])) {
        $firstDiscountSum += $discount;
        $processedRefs[$referenceNum] = true;
    }

    $amountPerRefs[$referenceNum] += $row['amount'];
    $totalAmountPerRef += $row['amount'];
  

    if ($referenceNum !== $previousRefNum) {
        if (!is_null($previousRefNum)) {
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
        $pdf->Cell(0, 10, "Refund Slip No.: {$referenceNum}", 0, 'L');
        $pdf->Ln(-6);
        $pdf->Cell(0, 10, "Document No.: 60-{$receipt}", 0, 'L');
        $pdf->Ln(-1);

        if( $method   == 7){
           $pdf->Ln(-5);
           $pdf->Cell(0, 10, "Refund Type.: Coupon/Voucher", 0, 'L');
           $pdf->Ln(-6);
           $pdf->SetFont('', 'I', 10);
           $pdf->Cell(0, 10, "QR No.: {$row['qrNumber']}", 0, 'L');
           $pdf->Ln(-1);
        }else if( $method  == 1){
            $pdf->Ln(-5);
            $pdf->Cell(0, 10, "Refund Type.: Cash", 0, 'L');
            $pdf->Ln(-1);
          
        }else if( $method  == 9){
            $pdf->Ln(-5);
            $pdf->Cell(0, 10, "Refund Type.: Shopee Pay", 0, 'L');
            $pdf->Ln(-1);
        }else if( $method  == 2){
            $pdf->Ln(-5);
            $pdf->Cell(0, 10, "Refund Type.: GCash", 0, 'L');
            $pdf->Ln(-1);
        }else if( $method  == 3){
            $pdf->Ln(-5);
            $pdf->Cell(0, 10, "Refund Type.: Pay Maya", 0, 'L');
            $pdf->Ln(-1);

        }else if( $method  == 4){
            $pdf->Ln(-5);
            $pdf->Cell(0, 10, "Refund Type.: Grab Pay", 0, 'L');
            $pdf->Ln(-1);
        }else if( $method  == 8){
            $pdf->Ln(-5);
            $pdf->Cell(0, 10, "Refund Type.: Ali Pay", 0, 'L');
            $pdf->Ln(-1);

        }else if( $method  == 5){
            $pdf->Ln(-5);
            $pdf->Cell(0, 10, "Refund Type.: Visa", 0, 'L');
            $pdf->Ln(-1);

        }else if( $method  == 6){
            $pdf->Ln(-5);
            $pdf->Cell(0, 10, "Refund Type.: Master Card", 0, 'L');
            $pdf->Ln(-1);

        }else if( $method  == 10){
            $pdf->Ln(-5);
            $pdf->Cell(0, 10, "Refund Type.: Discover", 0, 'L');
            $pdf->Ln(-1);

        }else if( $method  == 11){
            $pdf->Ln(-5);
            $pdf->Cell(0, 10, "Refund Type.: American Express", 0, 'L');
            $pdf->Ln(-1);


        }else if( $method  == 12){
            $pdf->Ln(-5);
            $pdf->Cell(0, 10, "Refund Type.: JCB", 0, 'L');
            $pdf->Ln(-1);

        }

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
    $pdf->Cell($headerWidths[4], $maxCellHeight, number_format($row['amount'] ?? 0, 2), 1, 0, 'R');
    $pdf->Ln();

    $amountPerRef[$referenceNum] += $row['amount'] ?? 0;
    $discountsData[$referenceNum] =   $discount;
    $itemDiscounts[$referenceNum] += $itemDiscount;
    $cartDiscounts[$referenceNum] =   $cartDiscount;
    $cartRemove = $amountPerRef[$referenceNum] * $cartDiscounts[$referenceNum];
    $overAllCart += $row['amount']-$itemDiscount;
 
   

}
$totalCartRemove = 0;
foreach ($amountPerRefs as $referenceNum => $amount) {
    $cartRemove = $amount * $cartDiscounts[$referenceNum];
    $totalCartRemove += $cartRemove;
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
$pdf->Ln(20);

$pdf->SetFont('', 'B', 12);
$pdf->Cell($headerWidths[0], $maxCellHeight, 'Total Refunded Amount', 1, 0, 'L');
$pdf->Cell($headerWidths[1], $maxCellHeight, '', 1, 0, 'R');
$pdf->Cell($headerWidths[2]+$headerWidths[3] + $headerWidths[4], $maxCellHeight, number_format( $overAllCart-$firstDiscountSum-$totalCartRemove ,2), 1, 0, 'R');



$pdfPath = $pdfFolder . 'refundList.pdf';
$pdf->Output($pdfPath, 'F');

$pdf->Output('refundList.pdf', 'I');



?>
