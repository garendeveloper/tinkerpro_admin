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

function autoAdjustFontSize($pdf, $text, $maxWidth, $initialFontSize = 7) {
    $pdf->SetFont('', '', $initialFontSize);
    while ($pdf->GetStringWidth($text) > $maxWidth) {
        $initialFontSize--;
        $pdf->SetFont('', '', $initialFontSize);
    }
    return $initialFontSize;
}

$productSales = new OtherReportsFacade();


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

$now = new DateTime();
$currentDateTime = date('F j, Y h:i:s A');

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        $products = new ProductFacade();
        $fetchShop = $products->getShopDetails();
        $shop = $fetchShop->fetch(PDO::FETCH_ASSOC);
        
        $this->Ln(8);
        $this->Cell(0, 1, "{$shop['shop_name']}", 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 1, 'ANNEX "E-1"', 0, false, 'R', 0, '', 0, false, 'M', 'M');
        $this->Ln();
        $this->SetFont('helvetica', '', 11);
        $this->Cell(0, 1, "{$shop['shop_address']}", 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
        $this->SetFont('helvetica', '', 11);
        $this->Cell(0, 1, "{$shop['tin']}", 0, false, 'C', 0, '', 0, false, 'M', 'M');
       
    }
    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$products = new ProductFacade();
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);

$pdf = new MYPDF('L', 'mm', array(215.9, 355.6));
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("{$shop['shop_name']}");
$pdf->SetTitle('BIR REPORT');   
$pdf->SetSubject('E-1 SALES SUMMARY REPORT');
$pdf->SetKeywords('TCPDF, PDF, Sales, Summary, guide');
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->AddPage();
$pdf->Ln(10);
$hostname = gethostname();  
$user_id = $_SESSION['users_identification'] ?? null;

$products = new ProductFacade();
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);

$x = 2; 
$y = 63; 
$pdf->SetX($x);
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 10, "Software: {$shop['pos_provided']}", 0, false, 'L');
$pdf->Ln();
$pdf->SetX($x);
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 10, "Machine Name: {$hostname}", 0, false, 'L');
$pdf->Ln(-5);
$pdf->SetX($x);
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 10, 'Serial No: '.$shop['series_num'].'', 0, false, 'L');
$pdf->Ln();
$pdf->SetX($x);
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 10, 'POS Terminal No: 123456789', 0, false, 'L');
$pdf->Ln(5);
$pdf->SetX($x);
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 10, 'Date and Time Generated: '.$currentDateTime.'', 0, false, 'L');
$pdf->Ln(5);
$pdf->SetX($x);
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 10, 'User ID: '.$user_id.'', 0, false, 'L');
$pdf->Ln();
$pdf->SetX($x);
$hexColor = '#F5F5F5';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");
$pdf->SetDrawColor(0,0,0); 
$pdf->SetLineWidth(0.1); 

$pageWidth = $pdf->getPageWidth();
$pageHeight = $pdf->getPageHeight();
$pdf->SetFillColor($r, $g, $b);
$pdf->SetFont('', 'B', 7);
$maxCellHeight = 5; 
$pdf->Cell(352, 8, "BIR SALES SUMMARY REPORT", 1, 0, 'C', true);
$pdf->Ln();
$header = array('Date','Beginning SI/OR No.','Ending SI/OR No.', 'Grand Accum. Sales Ending Balance', 'Grand Beg. Balance', 'Sales Issued w/Manual SI/OR (per RR 16-2018)', 'Gross Sales for the Day', 'VATable Sales', 'VAT Amount', 'VAT-Exempt Sales', 'Zero-Rated Sales', 'Deductions', 'Adjustment on Vat', 'VAT Payable', 'Net Sales', 'Sales Overrun/Overflow', 'Total Income', 'Reset Counter', 'Z-counter', 'Remarks');
$headerWidths = array(10, 15, 15, 15, 15, 15, 13, 13, 13, 13, 13, 60, 49, 13, 13, 13, 13, 13, 13, 15);
$maxCellHeight = 30; 

$hexColor = '#F5F5F5';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

$pdf->SetFillColor($r, $g, $b);
$pdf->SetFont('', '', 7);

foreach ($header as $key => $heading) 
{
    $pdf->SetFont('', 'B', 6);
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

    // $pdf->MultiCell($headerWidths[$key], $maxCellHeight, $heading, 1, 'C', true, 0, $x, $y, true, 0, false, true, 0, 'M', true);
    // $x += $headerWidths[$key]; 
    // $childRowX = $x;  
    //     $childRowY = $pdf->GetY();  
    //     $childColumn1 = "5%";  
    //     $childColumn2 = "20%";  

    //     $childColumnWidth1 = 15;  
    //     $childColumnWidth2 = 15;  

    //     $pdf->MultiCell($childColumnWidth1, $maxCellHeight, $childColumn1, '', 'C', true, 0, $childRowX, $childRowY, true, 0, false, true, 0, 'M', true);
    //     $pdf->MultiCell($childColumnWidth2, $maxCellHeight, $childColumn2, '', 'C', true, 0, $childRowX + $childColumnWidth1, $childRowY, true, 0, false, true, 0, 'M', true);

    //     $pdf->SetXY($x, $childRowY + $maxCellHeight);
    if ($key === 11) 
    {
        $pdf->SetFillColor($r, $g, $b);
        $pdf->MultiCell($headerWidths[$key], $maxCellHeight, $heading, 1, 'C', true, 0, $x, $y, true, 0, false, true, 0, 'M');
      
        $childRowX = $x;  
        $childRowY = $pdf->GetY();  
        $childColumn1 = "Discount";  
        $childColumn2 = "Returns";  
        $childColumn3 = "Voids";
        $childColumn4 = "Total Deductions";

        $childColumnWidth1 = 30;  
        $childColumnWidth2 = 10;  
        $childColumnWidth3 = 10;  
        $childColumnWidth4 = 10;  

        $pdf->MultiCell($childColumnWidth1, 15, $childColumn1, 0, 'C', true, 0, $childRowX, $childRowY, true, 0, false, true, 0, 'M', true);
        $grandChildRowX = $x;
        $grandChildRowY = $pdf->GetY();
        $grandChildColumn1 = "SC";
        $grandChildColumn2 = "PWD";
        $grandChildColumn3 = "NAAC";
        $grandChildColumn4 = "Solo Parent";
        $grandChildColumn5 = "Others";

        $grandChildColumnWidth1 = 6;
        $grandChildColumnWidth2 = 6;
        $grandChildColumnWidth3 = 6;
        $grandChildColumnWidth4 = 6;
        $grandChildColumnWidth5 = 6;

        $pdf->MultiCell($grandChildColumnWidth1, 30, $grandChildColumn1, 0, 'C', true, 0, $grandChildRowX, $grandChildRowY, true, 0, false, true, 0, 'M', true);
        $pdf->MultiCell($grandChildColumnWidth2, 30, $grandChildColumn2, 0, 'C', true, 0, $grandChildRowX + $grandChildColumnWidth1, $grandChildRowY, true, 0, false, true, 0, 'M', true);
        $pdf->MultiCell($grandChildColumnWidth3, 30, $grandChildColumn3, 0, 'C', true, 0, $grandChildRowX + $grandChildColumnWidth1 + $grandChildColumnWidth2, $grandChildRowY, true, 0, false, true, 0, 'M', true);
        $pdf->MultiCell($grandChildColumnWidth4, 30, $grandChildColumn4, 0, 'C', true, 0, $grandChildRowX + $grandChildColumnWidth1 + $grandChildColumnWidth2 + $grandChildColumnWidth3, $grandChildRowY, true, 0, false, true, 0, 'M', true);
        $pdf->MultiCell($grandChildColumnWidth5, 30, $grandChildColumn5, 0, 'C', true, 0, $grandChildRowX + $grandChildColumnWidth1 + $grandChildColumnWidth2 + $grandChildColumnWidth3 + $grandChildColumnWidth4, $grandChildRowY, true, 0, false, true, 0, 'M', true);
        $pdf->SetXY($x, $grandChildRowY);
        
        $pdf->MultiCell($childColumnWidth2, 15, $childColumn2, 0, 'C', true, 0, $childRowX + $childColumnWidth1, $childRowY, true, 0, false, true, 0, 'M', true);
        $pdf->MultiCell($childColumnWidth3, 15, $childColumn3, 0, 'C', true, 0, $childRowX + $childColumnWidth1 + $childColumnWidth2, $childRowY, true, 0, false, true, 0, 'M', true);
        $pdf->MultiCell($childColumnWidth4, 15, $childColumn4, 0, 'C', true, 0, $childRowX + $childColumnWidth1 + $childColumnWidth2 + $childColumnWidth3, $childRowY, true, 0, false, true, 0, 'M', true);
        $pdf->SetXY($x, $childRowY + $maxCellHeight);

        // $grandChildRowX = $x;  
        // $grandChildRowY = $pdf->GetY();  
        // $grandChildColumn1 = "SC";  
        // $grandChildColumn2 = "PWD";
        // $grandChildColumn3 = "NAAC";
        // $grandChildColumn4 = "Solo Parent";      
        // $grandChildColumn5 = "Others";  

        // $grandChildColumnWidth1 = 6;  
        // $grandChildColumnWidth2 = 6;  
        // $grandChildColumnWidth3 = 6;  
        // $grandChildColumnWidth4 = 6;  
        // $grandChildColumnWidth5 = 6;  

        // $pdf->MultiCell($grandChildColumn1, 15, $grandChildColumnWidth1, 0, 'C', true, 0, $grandChildRowX, $childRowY, true, 0, false, true, 0, 'M', true);
        // $pdf->MultiCell($grandChildColumn2, 15, $grandChildColumnWidth2, 0, 'C', true, 0, $grandChildRowX + $grandChildColumnWidth1, $grandChildRowY, true, 0, false, true, 0, 'M', true);
        // $pdf->MultiCell($grandChildColumn3, 15, $grandChildColumnWidth3, 0, 'C', true, 0, $grandChildRowX + $grandChildColumnWidth1 + $grandChildColumnWidth2, $grandChildRowY, true, 0, false, true, 0, 'M', true);
        // $pdf->MultiCell($grandChildColumn4, 15, $grandChildColumnWidth4, 0, 'C', true, 0, $grandChildRowX + $grandChildColumnWidth1 + $grandChildColumnWidth2 + $grandChildColumnWidth3, $grandChildRowY, true, 0, false, true, 0, 'M', true);
        // $pdf->MultiCell($grandChildColumn5, 15, $grandChildColumnWidth5, 0, 'C', true, 0, $grandChildRowX + $grandChildColumnWidth1 + $grandChildColumnWidth2 + $grandChildColumnWidth4, $grandChildRowY, true, 0, false, true, 0, 'M', true);
        // $pdf->SetXY($x, $grandChildRowY + $maxCellHeight);
   
    }
    else if ($key === 12) 
    {
        $pdf->SetFillColor($r, $g, $b);
        $pdf->MultiCell($headerWidths[$key], $maxCellHeight, $heading, 1, 'C', true, 0, $x, $y, true, 0, false, true, 0, 'M');
      
        $childRowX = $x;  
        $childRowY = $pdf->GetY();  
        $childColumn1 = "Discount";  
        $childColumn2 = "Vat on Returns";  
        $childColumn3 = "Others";
        $childColumn4 = "Total Vat Adjustment";

        $childColumnWidth1 = 22;  
        $childColumnWidth2 = 6;  
        $childColumnWidth3 = 6;  
        $childColumnWidth4 = 6;  

        $pdf->MultiCell($childColumnWidth1, 20, $childColumn1, 0, 'C', true, 0, $childRowX, $childRowY, true, 0, false, true, 0, 'M', true);
        $grandChildRowX = $x;
        $grandChildRowY = $pdf->GetY();
        $grandChildColumn1 = "SC";
        $grandChildColumn2 = "PWD";
        $grandChildColumn3 = "Others";

        $grandChildColumnWidth1 = 7.3;
        $grandChildColumnWidth2 = 7.3;
        $grandChildColumnWidth3 = 7.3;

        $pdf->MultiCell($grandChildColumnWidth1, 30, $grandChildColumn1, 0, 'C', true, 0, $grandChildRowX, $grandChildRowY, true, 0, false, true, 0, 'M', true);
        $pdf->MultiCell($grandChildColumnWidth2, 30, $grandChildColumn2, 0, 'C', true, 0, $grandChildRowX + $grandChildColumnWidth1, $grandChildRowY, true, 0, false, true, 0, 'M', true);
        $pdf->MultiCell($grandChildColumnWidth3, 30, $grandChildColumn3, 0, 'C', true, 0, $grandChildRowX + $grandChildColumnWidth1 + $grandChildColumnWidth2, $grandChildRowY, true, 0, false, true, 0, 'M', true);
        $pdf->MultiCell($grandChildColumnWidth4, 30, $grandChildColumn4, 0, 'C', true, 0, $grandChildRowX + $grandChildColumnWidth1 + $grandChildColumnWidth2 + $grandChildColumnWidth3, $grandChildRowY, true, 0, false, true, 0, 'M', true);
        $pdf->MultiCell($grandChildColumnWidth5, 30, $grandChildColumn5, 0, 'C', true, 0, $grandChildRowX + $grandChildColumnWidth1 + $grandChildColumnWidth2 + $grandChildColumnWidth3 + $grandChildColumnWidth4, $grandChildRowY, true, 0, false, true, 0, 'M', true);
        $pdf->SetXY($x, $grandChildRowY);
        
        $pdf->MultiCell($childColumnWidth2, 15, $childColumn2, 0, 'C', true, 0, $childRowX + $childColumnWidth1, $childRowY, true, 0, false, true, 0, 'M', true);
        $pdf->MultiCell($childColumnWidth3, 15, $childColumn3, 0, 'C', true, 0, $childRowX + $childColumnWidth1 + $childColumnWidth2, $childRowY, true, 0, false, true, 0, 'M', true);
        $pdf->MultiCell($childColumnWidth4, 15, $childColumn4, 0, 'C', true, 0, $childRowX + $childColumnWidth1 + $childColumnWidth2 + $childColumnWidth3, $childRowY, true, 0, false, true, 0, 'M', true);
        $pdf->SetXY($x, $childRowY + $maxCellHeight);
   
    }
    else
    {
        $pdf->SetFillColor($r, $g, $b);
        $pdf->MultiCell($headerWidths[$key], $maxCellHeight, $heading, 1, 'C', true, 0, $x, $y, true, 0, false, true, 0, 'M', true);
    }
    $x += $headerWidths[$key]; 
}


// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);



$pdf->SetFont('times', 'BI', 5);

$pdfPath = $pdfFolder . 'e1.pdf';
$pdf->Output($pdfPath, 'F');

$pdf->Output('e1.pdf', 'I');
