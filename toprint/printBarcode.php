<?php
require_once '../reports/vendor/autoload.php';

$pdf = new TCPDF("L", "mm", array(40, 60), true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Barcode');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
$pdf->SetMargins(2, 2, 2); 

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(TRUE, 1); 
$pdf->SetFont('helvetica', '', 8); 

$barcodeArray = json_decode($_GET['data'], true);

$style = array(
    'border' => false,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, 
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 6,
    'stretchtext' => 4
);

foreach($barcodeArray as $product)
{
    $pdf->AddPage();

    $pdf->SetFont('helvetica', '', 8); 
    $pdf->SetXY(2, 2); 
    $pdf->MultiCell(100, 15, $product['productName'], 0, 'L', 0, 1, '', '', true); 

    $pdf->SetXY(2, 5);
    $pdf->write1DBarcode($product['barcode'], 'C39', '', '', '150', 30, 0.4, $style, 'N'); 
}



$pdf->Output('stocks.pdf', 'I');
$pdfPath = __DIR__ . '/assets/pdf/barcode/barcode.pdf';

if (file_exists($pdfPath)) {

    unlink($pdfPath);
}
$pdf->Output($pdfPath, 'F');

 ?>
