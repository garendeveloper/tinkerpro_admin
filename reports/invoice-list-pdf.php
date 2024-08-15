<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include(__DIR__ . '/../utils/models/product-facade.php');

$pdfFolder = __DIR__ . '/../assets/pdf/invoice/';

$files = glob($pdfFolder . '*');
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file);
    }
}

function autoAdjustFontSize($pdf, $text, $maxWidth, $initialFontSize = 8) {
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

$salesHistory = json_decode($_POST['salesHistory'], true);

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
$pdf->SetTitle('INVOICE LIST Table PDF');
$pdf->SetSubject('INVOICE LIST PDF Document');
$pdf->SetKeywords('TCPDF, PDF, INVOICE LIST, table');

$pdf->AddPage();

$pdf->SetCellHeightRatio(1.5);
$imageFile = './../assets/img/tinkerpro-logo-dark.png';
$imageWidth = 45;
$imageHeight = 15;
$imageX = 10;
$pdf->Image($imageFile, $imageX, 10, $imageWidth, $imageHeight, '', '', '', false, 300);
$pdf->SetFont('', 'I', 8);

$pdf->SetFont('', 'B', 10);
$pdf->Cell(0, 10, 'JOURNAL', 0, 1, 'R', 0);
$pdf->Ln(-5);
$pdf->SetFont('', '', 10);
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
$pdf->SetFont('', '', 10);
$pdf->MultiCell(0, 10, "VAT REG TIN: {$shop['tin']}", 0, 'R');
$pdf->Ln(-6);
$pdf->SetFont('', '', 8);
$pdf->MultiCell(0, 10, "MIN: {$shop['min']}", 0, 'L');
$pdf->Ln(-6);
$pdf->SetFont('', '', 8);
$pdf->MultiCell(0, 10, "S/N: {$shop['series_num']}", 0, 'L');
$pdf->SetFont('', '', 8);
$pdf->Ln(-9);
$current_date = date('F j, Y');
$pdf->Cell(0, 10, "Date: $current_date", 0, 'L');
$pdf->Ln(-3);

if ($singleDateData && !$startDate && !$endDate) {
    $formattedDate = date('M j, Y', strtotime($singleDateData));
    $pdf->SetFont('', '', 11);
    $pdf->Cell(0, 10, "Period: $formattedDate", 0, 'L');
} elseif
(!$singleDateData && $startDate && $endDate) {
    $formattedStartDate = date('M j, Y', strtotime($startDate));
    $formattedEndDate = date('M j, Y', strtotime($endDate));
    $pdf->SetFont('', '', 11);
    $pdf->Cell(0, 10, "Period: $formattedStartDate - $formattedEndDate", 0, 'L');
} else {
    $otherFacade = new OtherReportsFacade;
    $others = $otherFacade->getDatePayments();
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
$header = array('Invoice #', 'Docs. Type', 'Date & Time', 'User', 'Type', 'Status', 'Amount');

$headerWidths = array(20, 40, 40, 40, 40, 50, 50);
$maxCellHeight = 5;

$hexColor = '#F5F5F5';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

$pdf->SetFillColor($r, $g, $b);

$pdf->SetFont('', 'B', 8);
for ($i = 0; $i < count($header); $i++) {
    if ($header[$i] === 'Invoice #') {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'L', true);
    } else {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'C', true);
    }
}
$pdf->Ln();

$pdf->SetFont('', '', 8);

    foreach ($salesHistory as $index => $sale) {
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $sale['barcode'], $headerWidths[0]));
        $pdf->Cell($headerWidths[0], $maxCellHeight, $sale['barcode'], 1, 0, 'L');
        $pdf->Cell($headerWidths[1], $maxCellHeight, getStatusText($sale['is_refunded']), 1, 0, 'C');
        $pdf->Cell($headerWidths[2], $maxCellHeight, $sale['date_time_of_payment'], 1, 0, 'C');
        $pdf->Cell($headerWidths[3], $maxCellHeight, $sale['cashier'], 1, 0, 'C');
        $pdf->Cell($headerWidths[4], $maxCellHeight, $sale['customer_type'], 1, 0, 'C');
        $pdf->Cell($headerWidths[5], $maxCellHeight, getStatusTexts($sale['is_refunded']), 1, 0, 'C');
        $pdf->Cell($headerWidths[6], $maxCellHeight, $sale['payment_amount'], 1, 0, 'R');
       
        $pdf->Ln();
    }
    function getStatusText($status)
    {
        switch ($status) {
            case 0:
                return 'Sales';
            case 1:
                return 'Refunded';
            case 2:
                return 'Ret & Ex';
            case 4:
                return 'Return';
            default:
                return '';
        }
    }
    function getStatusTexts($status)
    {
        switch ($status) {
            case 0:
                return 'Success';
            case 1:
                return 'Refunded';
            case 2:
                return 'Ret & Ex';
            case 4:
                return 'Return';
            default:
                return '';
        }
    }


$pdfPath = $pdfFolder . 'invoiceList.pdf';
$pdf->Output($pdfPath, 'F');
$pdf->Output('invoiceList.pdf', 'I');

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="invoiceList.pdf"');
?>
