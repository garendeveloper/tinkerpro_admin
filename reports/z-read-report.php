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


$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

$fetchRefund= $refundFacade->zReadingReport($singleDateData,$startDate,$endDate);
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);

$paperSize = 'Letter'; 

if ($paperSize == 'Letter') {
    $pageWidth = 215.9; 
    $pageHeight = 279.4;
}

$pdf = new TCPDF('P', PDF_UNIT, array($pageWidth, $pageHeight), true, 'UTF-8', false);



$pdf->SetCreator('TinkerPro Inc.');
$pdf->SetAuthor('TinkerPro Inc.');
$pdf->SetTitle('Z-READING REPORT Table PDF');
$pdf->SetSubject('Z-READING REPORT Table PDF Document');
$pdf->SetKeywords('TCPDF, PDF, Z-READING REPORT, table');
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
$pdf->Cell(0, 10, 'Z-READING REPORT', 0, 1, 'R', 0); 
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
} elseif (!$singleDateData && $startDate && $endDate) {
    $formattedStartDate = date('M j, Y', strtotime($startDate));
    $formattedEndDate = date('M j, Y', strtotime($endDate));
    $pdf->SetFont('', '', 11); 
    $pdf->Cell(0, 10, "Period: $formattedStartDate - $formattedEndDate", 0, 'L');
} else {
    $otherFacade = new OtherReportsFacade;
    $others =    $otherFacade->getDatePayments();
    $dates = [];
    while ($data = $others->fetch(PDO::FETCH_ASSOC)) {
        $dates[] = $data['date'];
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
$pdf->Ln(-11);
$pdf->SetDrawColor(192, 192, 192); 
$pdf->SetLineWidth(0.3); 
$pdf->SetFont('', '', 10); 

while ($data = $fetchRefund->fetch(PDO::FETCH_ASSOC)) {


$presentAccumulatedSale = $data['total_present_accumulated_sale'] ?? 0;
$previousAccumulatedSale = $data['total_previous_accumulated_sale'] ?? 0;
$totalSales = $data['total_sales'] ?? 0;

$presentAccumulatedSaleFormatted = number_format($presentAccumulatedSale, 2);
$previousAccumulatedSaleFormatted = number_format($previousAccumulatedSale, 2);
$totalSalesFormatted = number_format($totalSales, 2);
$pdf->Ln();
$pdf->SetFont('', 'B', 11); 
$pdf->Cell(0, 10, "REPORT DETAILS", 0, 'L');

$pdf->Ln(-3);

$pdf->SetFont('', '', 10); 


if ($data['beg_si'] !== null && $data['end_si'] !== null && $data['void_beg'] !== null && $data['void_end'] !== null) {
    $pdf->SetFont('', '', 10);
    $pdf->Cell(0, 10, "Beg. SI: {$data['beg_si']}", 0, 'L');
    $pdf->Ln(-5);
    $pdf->SetFont('', '', 10);
    $pdf->Cell(0, 10, "End. SI: {$data['end_si']}", 0, 'L');
    $pdf->Ln(-5);
    $pdf->Cell(0, 10, "Beg. Void: {$data['void_beg']}", 0, 'L');
    $pdf->Ln(-5);
    $pdf->Cell(0, 10, "End. Void: {$data['void_end']}", 0, 'L');
    $pdf->Ln(-22);
    $pdf->SetFont('', '', 10);
    $pdf->MultiCell(0, 10, "Beg. Return: {$data['return_beg']}", 0, 'R');
    $pdf->Ln(-5);
    $pdf->SetFont('', '', 10);
    $pdf->MultiCell(0, 10, "End. Return: {$data['return_end']}", 0, 'R');
    $pdf->Ln(-5);
    $pdf->SetFont('', '', 10);
    $pdf->MultiCell(0, 10, "Beg. Refund: {$data['refund_beg']}", 0, 'R');
    $pdf->Ln(-5);
    $pdf->SetFont('', '', 10);
    $pdf->MultiCell(0, 10, "End. Refund: {$data['refund_end']}", 0, 'R');
    $pdf->Ln(-3);
}



$header = array('Description', 'Amount');
$maxCellHeight = 5;

$hexColor = '#F5F5F5';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

$pdf->SetFillColor($r, $g, $b);
$pdf->SetFont('', 'B', 10);

$pdf->Cell(150, $maxCellHeight, $header[0], 1, 0, 'C', true);
$pdf->Cell(48, $maxCellHeight, $header[1], 1, 0, 'C', true);
$pdf->Ln();
$pdf->SetFont('', 'B', 10);
$pdf->SetFillColor(137, 148, 153);
$pdf->Cell(198, $maxCellHeight, "ITEMS", 1, 0, 'L', true);
$pdf->Ln();
$pdf->SetFont('', '', 10);

$dataRows = array(
    array('Present Accumulated Sales', $presentAccumulatedSaleFormatted),
    array('Previous Accumulated Sales', $previousAccumulatedSaleFormatted),
    array('Sales for Today', $totalSalesFormatted)
);

foreach ($dataRows as $row) {
    $pdf->Cell(150, $maxCellHeight, $row[0], 1, 0, 'L');
    $pdf->Cell(48, $maxCellHeight, $row[1], 1, 0, 'R');
    $pdf->Ln();
}

$pdf->SetFont('', 'B', 10);
$pdf->SetFillColor(137, 148, 153);
$pdf->Cell(198, $maxCellHeight, "BREAKDOWN OF SALES", 1, 0, 'L', true);
$pdf->Ln();

$pdf->SetFont('', '', 10);

$dataRows = array(
    array('Vatable Sales',  number_format($data['total_vatable_sales'] ?? 0, 2)),
    array('VAT Amount',  number_format($data['total_vat_amount'] ?? 0, 2)),
    array('VAT Exempt Sales', number_format($data['total_vat_exempt'] ?? 0,2)),
    array('Zero Rated Sales', number_format(0,2))
);

foreach ($dataRows as $row) {
    $pdf->Cell(150, $maxCellHeight, $row[0], 1, 0, 'L');
    $pdf->Cell(48, $maxCellHeight, $row[1], 1, 0, 'R');
    $pdf->Ln();
}

$pdf->SetFont('', '', 10);

$dataRows = array(
    array('Gross Amount', number_format(isset($data['total_gross_amount']) ? $data['total_gross_amount'] : 0, 2)),
    array('Less Discount',  number_format($data['total_less_discount'] ? $data['total_less_discount'] : 0, 2)),
    array('Less Return', number_format($data['total_less_return_amount'] ? $data['total_less_return_amount']: 0,2)),
    array('Less Refund', number_format($data['total_less_refund_amount'] ? $data['total_less_refund_amount'] : 0,2)),
    array('Less Void',  number_format($data['total_less_void'] ? $data['total_less_void'] : 0, 2)),
    array('Less VAT Adjsutment',  number_format($data['total_less_vat_adjustment'] ? $data['total_less_vat_adjustment'] : 0, 2)),
    array('Net Amount', number_format($data['total_net_amount'] ?? 0,2))
   
);

foreach ($dataRows as $row) {
    $pdf->Cell(150, $maxCellHeight, $row[0], 1, 0, 'L');
    $pdf->Cell(48, $maxCellHeight, $row[1], 1, 0, 'R');
    $pdf->Ln();
}
$pdf->SetFont('', 'B', 10);
$pdf->SetFillColor(137, 148, 153);
$pdf->Cell(198, $maxCellHeight, "DISCOUNT SUMMARY", 1, 0, 'L',true);
$pdf->Ln();
$pdf->SetFont('', '', 10);
$dataRows = array(
    array('SC Discount',  number_format($data['total_senior_discount'] ?? 0, 2)),
    array('UP Discount',  number_format($data['total_officer_discount'] ?? 0, 2)),
    array('PWD Discount', number_format($data['total_pwd_discount'] ?? 0,2)),
    array('NAAC Discount', number_format($data['total_naac_discount'] ?? 0,2)),
    array('SOLO Parent Discount',  number_format($data['total_solo_parent_discount'] ?? 0, 2)),
    array('Other Discount',  number_format($data['total_other_discount'] ?? 0, 2)),
    
   
);

foreach ($dataRows as $row) {
    $pdf->Cell(150, $maxCellHeight, $row[0], 1, 0, 'L');
    $pdf->Cell(48, $maxCellHeight, $row[1], 1, 0, 'R');
    $pdf->Ln();
}  
$pdf->SetFont('', 'B', 10);
$pdf->SetFillColor(137, 148, 153);
$pdf->Cell(198, $maxCellHeight, "SALES ADJUSTMENT", 1, 0, 'L',true);
$pdf->Ln();
$pdf->SetFont('', '', 10);
$dataRows = array(
    array('Void',  number_format($data['total_void'] ?? 0, 2)),
    array('Return',  number_format($data['total_return'] ?? 0, 2)),
    array('Refund', number_format($data['total_refund'] ?? 0,2))
    
);

foreach ($dataRows as $row) {
    $pdf->Cell(150, $maxCellHeight, $row[0], 1, 0, 'L');
    $pdf->Cell(48, $maxCellHeight, $row[1], 1, 0, 'R');
    $pdf->Ln();
}  
$pdf->SetFont('', 'B', 10);
$pdf->SetFillColor(137, 148, 153);
$pdf->Cell(198, $maxCellHeight, "VAT ADJUSTMENT", 1, 0, 'L', true);
$pdf->Ln();
$pdf->SetFont('', '', 10);

$dataRows = array(
    array('SC VAT',  number_format($data['total_senior_citizen_vat'] ?? 0, 2)),
    array('SC VAT',  number_format($data['total_senior_citizen_vat'] ?? 0, 2)),
    array('UP VAT',  number_format($data['total_officers_vat'] ?? 0 , 2)),
    array('PWD VAT',  number_format($data['total_pwd_vat'] ?? 0, 2)),
    array('Zero Rated VAT', number_format($data['total_zero_rated'] ?? 0,2)),
    array('Void VAT', number_format($data['total_void_vat'] ?? 0, 2)),
    array('VAT on Return', number_format($data['total_vat_return'] ?? 0,2)),
    array('VAT on Refund', number_format($data['total_vat_refunded'] ?? 0,2)),

    
);

foreach ($dataRows as $row) {
    $pdf->Cell(150, $maxCellHeight, $row[0], 1, 0, 'L');
    $pdf->Cell(48, $maxCellHeight, $row[1], 1, 0, 'R');
    $pdf->Ln();
}  

$pdf->SetFont('', 'B', 10);
$pdf->SetFillColor(137, 148, 153);
$pdf->Cell(198, $maxCellHeight, "TRANSACTION SUMMARY", 1, 0, 'L',true);
$pdf->Ln();
$pdf->SetFont('', '', 10);

$dataRows = array(
    array('Cash in Drawer',  number_format($data['total_cash_in_receive'] ?? 0, 2)),
    array('Credit/Debit Card',  number_format($data['total_totalCcDb']?? 0, 2)),
    array('E-wallet',  number_format($data['total_totalEwallet'] ?? 0, 2)),
    array('Coupon/Voucher', number_format($data['total_totalCoupon']  ?? 0 ,2)),
    array('Credit', number_format($data['total_credit']  ?? 0,2)),
    array('Cash In', number_format($data['total_totalCashIn']  ?? 0,2)),
    array('Cash Out', number_format($data['total_totalCashOut']  ?? 0,2)),  
    array('Payment Receieve', number_format($data['total_payment_receive']  ?? 0,2))
);

foreach ($dataRows as $row) {
    $pdf->Cell(150, $maxCellHeight, $row[0], 1, 0, 'L');
    $pdf->Cell(48, $maxCellHeight, $row[1], 1, 0, 'R');
    $pdf->Ln();
} 
   
}



$pdf->Output('zReadReportList.pdf', 'I');
$pdfPath = __DIR__ . '/../assets/pdf/zread/zReadReportList.pdf';
if (file_exists($pdfPath)) {
    unlink($pdfPath);
}

$pdf->Output($pdfPath, 'F');
 ?>
