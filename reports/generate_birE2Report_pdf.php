<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');
include( __DIR__ . '/../utils/models/bir-facade.php');

session_start();
date_default_timezone_set('Asia/Manila');
$pdfFolder = __DIR__ . '/../assets/pdf/bir/';

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


class MYPDF extends TCPDF 
{

    public function Header() {
        $products = new ProductFacade();
        $fetchShop = $products->getShopDetails();
        $shop = $fetchShop->fetch(PDO::FETCH_ASSOC);
        
        $this->Ln(8);
        $this->Cell(0, 1, "{$shop['shop_name']}", 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 1, 'ANNEX "E-2"', 0, false, 'R', 0, '', 0, false, 'M', 'M');
        $this->Ln();
        $this->SetFont('helvetica', '', 11);
        $this->Cell(0, 1, "{$shop['shop_address']}", 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
        $this->SetFont('helvetica', '', 11);
        $this->Cell(0, 1, "{$shop['tin']}", 0, false, 'C', 0, '', 0, false, 'M', 'M');
       
    }
 
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}


$productSales = new OtherReportsFacade();
$birFacade = new BirFacade();
$products = new ProductFacade();
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);

$counter = 1;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

if($startDate !== null && $endDate !== null)
{
    $startDates = strtotime($startDate);
    $formattedStartDate = date('F j, Y', $startDates);
    
    $endDates = strtotime($endDate);
    $formattedEndDate = date('F j, Y', $endDates);
}

$current_date = "---";
if((empty($singleDateData) && empty($startDate) && empty($endDate)) || (!empty($singleDateData) && empty($startDate) && empty($endDate)))
{
    $singleDateData = date('Y-m-d');
    $singleDateDatas = strtotime($singleDateData);
    $formattedSingleDate = date('F j, Y', $singleDateDatas);
    $current_date = $formattedSingleDate;
}
else
{
    $current_date =  $formattedStartDate." - ".$formattedEndDate;
}


$currentDateTime = date('F j, Y h:i:s A');
$paperSize = 'A4'; 

if ($paperSize == 'A4') {
    $pageWidth = 210;
    $pageHeight = 297;
}
$pdf = new MYPDF('L', PDF_UNIT, array(297, 210), true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("{$shop['shop_name']}");
$pdf->SetTitle('BIR REPORT');   
$pdf->SetSubject('E-2 SALES SUMMARY REPORT');
$pdf->SetKeywords('TCPDF, PDF, Sales, Summary, guide');
$pdf->SetDrawColor(255, 199, 60); 
$pdf->Rect(0, 0, $pdf->getPageWidth(), $pdf->getPageHeight(), 'D');
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->AddPage();
$pdf->Ln(10);
$hostname = gethostname();
$user_id = $_SESSION['users_identification'] ?? null;

$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 10, "Software: {$shop['pos_provided']}", 0, false, 'L');
$pdf->Ln();
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 10, "Machine Name: {$hostname}", 0, false, 'L');
$pdf->Ln(-5);
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 10, 'Serial No: '.$shop['series_num'].'', 0, false, 'L');
$pdf->Ln();
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 10, 'POS Terminal No: 123456789', 0, false, 'L');
$pdf->Ln(5);
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 10, 'Date and Time Generated: '.$currentDateTime.'', 0, false, 'L');
$pdf->Ln(5);
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 10, 'User ID: '.$user_id.'', 0, false, 'L');
$pdf->Ln();

$hexColor = '#F5F5F5';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");
$pdf->SetDrawColor(0, 0, 0); 
$pdf->SetLineWidth(0.1); 


$pdf->SetFillColor($r, $g, $b);
$pdf->SetFont('', 'B', 10);
$maxCellHeight = 5; 
$pdf->Cell(277, 8, "Senior Citizen Sales Book/Report", 1, 0, 'C', true);
$pdf->Ln();
$header = array('Date','Name of Senior Citizen (SC)','OSCA ID No./SC ID No.', 'SC TIN', 'SI / OR Number', 'Sales (Inclusive of VAT)', 'VAT Amount', 'VAT Exempt Sales',  'Discount', 'Net Sales');
$headerWidths = array(20, 40, 25, 30, 20, 30, 27, 25, 30, 30);
$maxCellHeight = 12; 

$hexColor = '#F5F5F5';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

$pdf->SetFillColor($r, $g, $b);
$pdf->SetFont('', '', 9);
$x = 10; 
$y = 63; 
foreach ($header as $key => $heading) 
{
    $pdf->SetFont('', 'B', 9);
    $hexColor = '#F5F5F5';

    if($key === 0) $hexColor = '#A6A6A6';
    if($key === 1) $hexColor = '#00B0F0';
    if($key === 2) $hexColor = '#FFFF00';
    if($key === 3) $hexColor = '#9999FF';
    if($key === 4) $hexColor = '#FFC000';
    if($key === 5) $hexColor = '#92D050';
    if($key === 6) $hexColor = '#ED7D31';
    if($key === 7) $hexColor = '#E7E6E6';
    if($key === 8) $hexColor = '#FFD966';
    if($key === 9) $hexColor = '#A6A6A6';
    list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");
    if ($key === 8) 
    {
        $pdf->SetFillColor($r, $g, $b);
        $pdf->MultiCell($headerWidths[$key], $maxCellHeight, $heading, 1, 'C', true, 0, $x, $y, true, 0, false, true, 0, 'M');
        
        $childRowX = $x;  
        $childRowY = $pdf->GetY();  
        $childColumn1 = "5%";  
        $childColumn2 = "20%";  

        $childColumnWidth1 = 15;  
        $childColumnWidth2 = 15;  

        $pdf->MultiCell($childColumnWidth1, $maxCellHeight, $childColumn1, '', 'C', true, 0, $childRowX, $childRowY, true, 0, false, true, 0, 'M', true);
        $pdf->MultiCell($childColumnWidth2, $maxCellHeight, $childColumn2, '', 'C', true, 0, $childRowX + $childColumnWidth1, $childRowY, true, 0, false, true, 0, 'M', true);

        $pdf->SetXY($x, $childRowY + $maxCellHeight);
    }
    else
    {
        $pdf->SetFillColor($r, $g, $b);
        $pdf->MultiCell($headerWidths[$key], $maxCellHeight, $heading, 1, 'C', true, 0, $x, $y, true, 0, false, true, 0, 'M', true);
    }
    $x += $headerWidths[$key]; 
}

if($singleDateData !== null && ($startDate === null && $endDate === null))
{
    $startDate = $singleDateData;
    $endDate = $singleDateData;
}

$items = $birFacade->E_reports(1, $startDate, $endDate);
$pdf->Ln();
$pdf->SetFont('', '', 7);
$maxCellHeight = 5; 

if(count($items) > 0)
{
    foreach ($items as $key =>$item) 
    {
        $vat_amount = number_format(0.00, 2);
        $sales_vat = number_format(0.00, 2);
        $discount20percent = number_format(0.00, 2);
    
        $customerID = $item['customerID'] ?? '---';
        $customerTIN = $item['customerTIN'] ?? '---';
        $name = $item['first_name']." ".$item['last_name'];
        $date_time_of_payment = $item['date_time_of_payment'];
        $date_time = new DateTime($date_time_of_payment);
        $current_date = $date_time->format('F j, Y');
    
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $current_date, $headerWidths[0]));
        $pdf->Cell($headerWidths[0], $maxCellHeight, $current_date, 1, 0, 'C');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $name, $headerWidths[1]));
        $pdf->Cell($headerWidths[1], $maxCellHeight, $name, 1, 0, 'L');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $customerID, $headerWidths[2]));
        $pdf->Cell($headerWidths[2], $maxCellHeight, $customerID, 1, 0, 'C');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $customerTIN, $headerWidths[3]));
        $pdf->Cell($headerWidths[3], $maxCellHeight, $customerTIN, 1, 0, 'C');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['barcode'], $headerWidths[4]));
        $pdf->Cell($headerWidths[4], $maxCellHeight, $item['barcode'], 1, 0, 'C');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $sales_vat, $headerWidths[5]));
        $pdf->Cell($headerWidths[5], $maxCellHeight, $sales_vat, 1, 0, 'R');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $vat_amount, $headerWidths[6]));
        $pdf->Cell($headerWidths[6], $maxCellHeight, $vat_amount, 1, 0, 'R');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, number_format($item['vatable_sales'], 2), $headerWidths[7]));
        $pdf->Cell($headerWidths[7], $maxCellHeight, number_format($item['vatable_sales'], 2), 1, 0, 'R');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, number_format($item['customerDiscount'], 2), 15));
        $pdf->Cell(15, $maxCellHeight, number_format($item['customerDiscount'], 2), 1, 0, 'R');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $discount20percent, 15));
        $pdf->Cell(15, $maxCellHeight, number_format($discount20percent, 2), 1, 0, 'R');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, number_format($item['netSales'], 2), $headerWidths[9]));
        $pdf->Cell($headerWidths[9], $maxCellHeight, number_format($item['netSales'], 2), 1, 0, 'R');
        $pdf->Ln(); 
        $counter++;
    }
}
else
{
    $pdf->SetFont('', 'I', 8); 
    $pdf->Cell(array_sum($headerWidths), $maxCellHeight, 'No available data.***', 1, 0, 'C'); 
    $pdf->Ln(); 
}
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->SetFont('times', 'BI', 7);


$pdfPath = $pdfFolder . 'e2.pdf';
$pdf->Output($pdfPath, 'F');

$pdf->Output('e2.pdf', 'I');
