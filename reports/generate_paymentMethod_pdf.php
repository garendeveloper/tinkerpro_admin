<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');

use TCPDF;

$pdfFolder = __DIR__ . '/../assets/pdf/payment_method/';

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

$exclude = $_GET['exclude'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;


if ($startDate == '' || $endDate == '') {
    $startDate = date('Y-m-d');
    $endDate = date('Y-m-d');
} else {
    $s_date = strtotime($startDate);
    $e_date = strtotime($endDate);

    $startDate = date('Y-m-d', $s_date);
    $endDate = date('Y-m-d', $e_date);
}

$fetchPaymentMethod = $refundFacade->getAllPaymentMethods($startDate, $endDate);
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);


$paperSize = 'A4'; 

if ($paperSize == 'A4') {
    $pageWidth = 210;
    $pageHeight = 297;
}
$pdf = new TCPDF('L', PDF_UNIT, array($pageWidth, $pageHeight), true, 'UTF-8', false);


$pdf->SetCreator('TinkerPro Inc.');
$pdf->SetAuthor('TinkerPro Inc.');
$pdf->SetTitle('SALES BY PAYMENT TYPES Table PDF');
$pdf->SetSubject('SALES BY PAYMENT TYPES Table PDF Document');
$pdf->SetKeywords('TCPDF, PDF, SALES BY PAYMENT TYPES, table');
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
$pdf->Cell(0, 10, 'SALES BY PAYMENT TYPES', 0, 1, 'R', 0); 
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



    $html = '
    <style>
    table {
        width: 800px; 
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid black;
    }

    th {
        font-weight: bold;
    }
    th, td {
        padding: 8px;
        text-align: left;
    }
    </style>
    <table border="1" cellpadding="3">
        <thead>
            <tr>
                <th style="font-weight: bold; font-size: 10px;">Date</th>
                <th style="font-weight: bold; font-size: 10px;">Cash</th>
                <th style="font-weight: bold; font-size: 10px;">Credit</th>
                <th style="font-weight: bold; font-size: 10px;">Gcash</th>
                <th style="font-weight: bold; font-size: 10px;">Maya</th>
                <th style="font-weight: bold; font-size: 10px;">ShopeePay</th>
                <th style="font-weight: bold; font-size: 10px;">GrabPay</th>
                <th style="font-weight: bold; font-size: 10px;">Alipay</th>
                <th style="font-weight: bold; font-size: 10px;">Credit/Debit Cards</th>
                <th style="font-weight: bold; font-size: 10px;">Coupons</th>
                <th style="font-weight: bold; font-size: 10px;">Total (Php)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>'. $startDate . ' - ' . $endDate .'</td>
                <td>'. number_format($fetchPaymentMethod["totalCashPerPayment"], 2) .'</td>
                <td>'. number_format($fetchPaymentMethod["totalAmountCredit"], 2) .'</td>
                <td>'. number_format($fetchPaymentMethod["totalAmountGCash"], 2) .'</td>
                <td>'. number_format($fetchPaymentMethod["totalAmountMaya"], 2) .'</td>
                <td>'. number_format($fetchPaymentMethod["totalAmountShopeePay"], 2) .'</td>
                <td>'. number_format($fetchPaymentMethod["totalAmountGrapPay"], 2) .'</td>
                <td>'. number_format($fetchPaymentMethod["totalAmountAlipay"], 2) .'</td>
                <td>'. number_format($fetchPaymentMethod["totalAmountCreditDebit"], 2) .'</td>
                <td>'. number_format($fetchPaymentMethod["totalAmountCoupons"], 2) .'</td>
                <td>'. number_format($fetchPaymentMethod["total"], 2) .'</td>
            </tr>

            <tr style="border: none;">
                <td style="border: none; font-style: italic; font-size: 13px;" colspan="12">Note: This report does not include refund and return transactions </td>
            </tr>
        </tbody>
    </table>';



$pdf->writeHTML($html, true, 0, true, true);
$pdfPath = $pdfFolder . 'paymentMethodList.pdf';
$pdf->Output($pdfPath, 'F');

$pdf->Output('paymentMethodList.pdf', 'I');

 ?>
