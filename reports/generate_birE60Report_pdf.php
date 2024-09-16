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

$products = new ProductFacade();
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);
$birFacade = new BirFacade();


$now = new DateTime();
$currentDateTime = date('F j, Y h:i:s A');

class MYPDF extends TCPDF {

    //Page header
    public function Header() 
    {
        $products = new ProductFacade();
        $fetchShop = $products->getShopDetails();
        $shop = $fetchShop->fetch(PDO::FETCH_ASSOC);
        
        $this->Ln(8);
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 1, "{$shop['shop_name']}", 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 1, '', 0, false, 'R', 0, '', 0, false, 'M', 'M');
        $this->Ln();
        $this->SetFont('helvetica', '', 11);
        $this->Cell(0, 1, "{$shop['shop_address']}", 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
        $this->SetFont('helvetica', '', 11);
        $this->Cell(0, 1, " Vat Reg. {$shop['tin']}", 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
        $this->SetFont('helvetica', '', 11);
        $this->Cell(0, 1, " MIN: XXXXXXXXXX ", 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }
    public function Footer() 
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
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
$pdf->SetSubject('DAILY TRANSACTION REPORT');
$pdf->SetKeywords('TCPDF, PDF, Sales, Daily, guide');
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->AddPage();
$pdf->Ln(10);
$hostname = gethostname();  
$user_id = $_SESSION['users_identification'] ?? null;
$userName = $_SESSION['first_name'];

$products = new ProductFacade();
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);


$birFacade = new BirFacade();

$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

if((empty($singleDateData) && empty($startDate) && empty($endDate)) || (!empty($singleDateData) && empty($startDate) && empty($endDate)))
{
    $singleDateData = date('Y-m-d');
    $startDate = $singleDateData;
    $endDate = $singleDateData;
}
if($singleDateData !== null && ($startDate === null && $endDate === null))
{
    $startDate = $singleDateData;
    $endDate = $singleDateData;
}

// $items = $birFacade->getDailyTransaction($startDate, $endDate);

$items = $birFacade->getCancelledTransactions()->fetchAll();
var_dump($items[0]['date_of_payment']);

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
$pdf->Cell(0, 10, 'POS Terminal No: POS 1', 0, false, 'L');
$pdf->Ln(5);
$pdf->SetX($x);
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 10, 'Date and Time Generated: '.$currentDateTime.'', 0, false, 'L');
$pdf->Ln(5);
$pdf->SetX($x);
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 10, 'User ID: '.$userName.'', 0, false, 'L');
$pdf->Ln();
$pdf->SetX($x);
$hexColor = '#F5F5F5';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");
$pdf->SetDrawColor(0,0,0); 
$pdf->SetLineWidth(0.1); 

$pdf->SetMargins(10, 10, 20);

$html = '<style>
  
    table td, table th {
        border: solid 1px black;
        padding: 5px;
        word-wrap: break-word;
        text-align: center;       
        vertical-align: middle;
        font-size: 10px;
    }
    table thead th {
        font-weight: bold;
        border: solid 1px #666;
        text-align: center;       
        vertical-align: middle;
        font-size: 1px;
       padding: 20px !important;
    }
    th {
        font-weight: bold;
        border: solid 1px #666;
        text-align: center;
        vertical-align: middle;
        font-size: 10px;
    }
    .daily-reports{
        width: 990vw;
    }
</style>';

$html .= '
<table class="daily-reports">
    <thead>
        <tr>
            <th colspan="11" style="font-size: large ">VOIDED TRANSACTIONS REPORT</th>
        </tr>
        <tr>
            <th >Date of Payment</th>
            <th >Date of Cancelation</th>
            <th >SI No.</th>
            <th >Customer Type</th>
            <th >Amount</th>
            <th >Discount</th>
            <th >VATable Sales</th>
            <th >VAT Amount</th>
            <th >VAT-Exempt Sales</th>
            <th >Zero-Rated Sales</th>
            <th >Total Amount</th>
        </tr>
    </thead>
    <tbody>';

    $totals = [
        'total_amount' => 0,
        'total_VAT_SALES' => 0,
        'total_VAT_AMOUNT' => 0,
        'total_VAT_EXEMPT' => 0,
        'total_discount' => 0,
        'total_to_paid' => 0,
        'total_zero_rated' => 0,
        'total_to_be_paid' => 0,
    ];


for ($i = 0; $i < count($items); $i++) {

    $totals['total_amount'] += (float)$items[$i]['totalAmount'];
    $totals['total_discount'] += (float)$items[$i]['finalDiscountCustomer'];
    $totals['total_VAT_SALES'] += (float)$items[$i]['VAT_SALES'];
    $totals['total_VAT_AMOUNT'] += (float)$items[$i]['VAT_AMOUNT'];
    $totals['total_VAT_EXEMPT'] += (float)$items[$i]['VAT_EXEMPT'];
    $totals['total_to_be_paid'] += (float)$items[$i]['toBePaid'];

    $html .= '<tr>
        <td style="text-align: center">' . $items[$i]['date_of_payment'] . ' ' . $items[$i]['time_of_payment'] . '</td>
        <td style="text-align: center">' . $items[$i]['date_cancelled'] . '</td>
        <td style="text-align: center">' . $items[$i]['barcode'] . '</td>
        <td style="text-align: center">' . $items[$i]['customer_type'] . '</td>
        <td style="text-align: right">' . number_format($items[$i]['totalAmount'], 2) . '</td>
        <td style="text-align: right">' . number_format($items[$i]['finalDiscountCustomer'], 2) . '</td>
        <td style="text-align: right">' . number_format($items[$i]['VAT_SALES'], 2) . '</td>
        <td style="text-align: right">' . number_format($items[$i]['VAT_AMOUNT'], 2) . '</td>
        <td style="text-align: right">' . number_format($items[$i]['VAT_EXEMPT'], 2) . '</td>
        <td style="text-align: right">0.00</td>
        <td style="text-align: right">' . number_format($items[$i]['toBePaid'], 2) . '</td>
    </tr>';
}

$html .= '<tr style="font-weight: bold; font-size: large">
        <td style="text-align: center" colspan="4">' . 'Total: ' . '</td>
        <td style="text-align: right">' . number_format($totals['total_amount'], 2) . '</td>
        <td style="text-align: right">' . number_format($totals['total_discount'], 2) . '</td>
        <td style="text-align: right">' . number_format($totals['total_VAT_SALES'], 2) . '</td>
        <td style="text-align: right">' . number_format($totals['total_VAT_AMOUNT'], 2) . '</td>
        <td style="text-align: right">' . number_format($totals['total_VAT_EXEMPT'], 2) . '</td>
        <td style="text-align: right">0.00</td>
        <td style="text-align: right">' . number_format($totals['total_to_be_paid'], 2) . '</td>
    </tr>';

$html .= '</tbody>
</table>';

// Generate PDF
$pdf->SetFont('helvetica', '', 10);
$pdf->writeHTML($html, true, 0, true, true);
$pdf->Ln();
$pdf->lastPage();

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->SetFont('times', 'BI', 5);

$pdfPath = $pdfFolder . 'e60.pdf';
$pdf->Output($pdfPath, 'F');
$pdf->Output('e60.pdf', 'I');
