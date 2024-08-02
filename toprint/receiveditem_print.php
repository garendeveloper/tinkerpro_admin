<?php
require_once '../reports/vendor/autoload.php';
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');
include('../utils/models/order-facade.php');

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


$now = new DateTime();
$currentDateTime = date('F j, Y h:i:s A');

class MYPDF extends TCPDF {
    public function Header() 
    {
        $currentDateTime = date('F j, Y h:i:s A');
        $products = new ProductFacade();
        $fetchShop = $products->getShopDetails();
        $shop = $fetchShop->fetch(PDO::FETCH_ASSOC);
        $hostname = gethostname();  
        $user_id = $_SESSION['users_identification'] ?? null;

        $products = new ProductFacade();
        $fetchShop = $products->getShopDetails();
        $shop = $fetchShop->fetch(PDO::FETCH_ASSOC);
        
        $this->Ln(8);
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 1, "RECEIVE ITEMS RECEIPT", 0, false, 'L', 0, '', 0, false, 'L', 'M');
        $this->Ln();
        $this->Cell(0, 1, "{$shop['shop_name']}", 0, false, 'L', 0, '', 0, false, 'L', 'M');
        $this->Ln();
        $this->Ln();
        $this->Ln();

        $barcodeValue = $_GET['po_number']; 
        $barcodeFormat = 'C128';
        $barcodeWidth = 10;
        $barcodeHeight= 10; 
        $barcodePosX = $this->getPageWidth() - 70; 
        $barcodePosY = 3; 
        $this->write1DBarcode($barcodeValue, $barcodeFormat, $barcodePosX, $barcodePosY, '', $barcodeWidth, $barcodeHeight, null, 'R');

        $this->SetFont('helvetica', '', 11);
        $this->Cell(0, 10, "{$shop['shop_address']}", 0, false, 'L');
        $this->Ln(-5);
        $this->SetFont('helvetica', '', 11);
        $this->Cell(0, 10, 'Tax: '.$shop['shop_tin'].'', 0, false, 'L');
        $this->Ln();
        $this->SetFont('helvetica', '', 11);
        $this->Cell(0, 10, 'Employee: '.$shop['contact_number'].'', 0, false, 'L');
        $this->Ln(5);
        $this->SetFont('helvetica', '', 11);
        $this->Cell(0, 10, 'No.: '.$shop['acc_no'].'', 0, false, 'L');
        $this->Ln(5);
        $this->SetFont('helvetica', '', 11);
        $this->Cell(0, 10, 'Email: '.$shop['shop_email'].'', 0, false, 'L');
        
        $this->Line(10, 55, 200, 55);
        $imageWidth = 45; 
        $imageHeight = 15; 
        $imageX = 150; 

        $serverFilePath = $_SERVER['DOCUMENT_ROOT'] . "/tinkerpros/www/assets/company_logo/{$shop['company_logo']}";

        if (file_exists($serverFilePath)) {
            $this->Image($serverFilePath, $imageX, $y = 20, $w = $imageWidth, $h = $imageHeight);
        } else {
            echo "File does not exist.";
        }

    }
    public function fileExistsViaHttp($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $statusCode == 200;
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

$pdf = new MYPDF('P', 'mm', 'A4');
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("{$shop['shop_name']}");
$pdf->SetTitle('RECEIVE ITEMS');   
$pdf->SetSubject('RECEIVE ITEMS');
$pdf->SetKeywords('TCPDF, PDF, RECEIVE ITEMS, Summary, guide');
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->AddPage();
$pdf->Ln(45);
$hostname = gethostname();  
$user_id = $_SESSION['users_identification'] ?? null;


$x = 10; 
$y = 70; 
$pdf->SetX($x);
$hexColor = '#F5F5F5';
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");
$pdf->SetDrawColor(0,0,0); 
$pdf->SetLineWidth(0.1); 

$pdf->SetMargins(10, 10, 20); 

$orders = new OrderFacade();
$counter = 1;
$order_id = $_GET['order_id'] ?? 0;
$items = $orders->get_orderData($order_id);
$orderDetails = $orders->get_paymentHistory($order_id);

$html = '<style>
            #tblHeader{
                text-align: left;
            }
            #mainTable thead th{
                border: 0.5px solid rgba(0, 0, 0, 0.1);
                word-wrap: break-word;
                text-align: center;       
                vertical-align: middle;
            
            }
            #mainTable {
                border-collapse: collapse;
                table-layout: fixed;
                width: 100%; 
            }
            #mainTable tbody td {
                padding: 10px 10px; 
                height: 10px; 
                line-height: 0.5; 
                font-size: 9px;
            }
        </style>';

$html .= '<table border = "0" cellpadding="2" id = "tblHeader">
            <thead>
                <tr>
                    <th style = "width: 65%">Bill to</th>
                    <th style = "width: 20%">PO No.: </th>
                    <th style = "width: 15%">'.$items[0]['po_number'].'</th>
                </tr>
                <tr>
                    <th style = "width: 65%">'.$items[0]['supplier'].'</th>
                    <th style = "width: 20%">Date: </th>
                    <th style = "width: 15%">'.$items[0]['date_purchased'].'</th>
                </tr>
                <tr>
                    <th style = "width: 65%">Tax: XXXXX</th>
                    <th style = "width: 20%">Due date: </th>
                    <th style = "width: 15%">'.$items[0]['due_date'].'</th>
            
                </tr>
                <tr>
                    <th style = "width: 65%"></th>
                    <th style = "width: 20%">Payment status: </th>
                    <th style = "width: 15%;">Paid</th>
                </tr>
                <tr>
                    <th style = "width: 65%"></th>
                    <th style = "width: 20%">Bank acc. number: </th>
                    <th style = "width: 15%"></th>
                </tr>
            </thead>
        </table>';

$html .= '<table border = "1" cellpadding = "2" id = "mainTable" style = "font-size: 9px;">
            <thead>
                <tr style = "border-bottom: 10px solid #gray;">
                    <th style = "text-align: center; width: 10%">#</th>
                    <th style = "text-align: center; width: 20%">Date Received</th>
                    <th style = " text-align: center; width: 57%">Item</th>
                    <th style = "text-align: center; width: 20%">Total Quantity Received</th>
                </tr>
            </thead>
            <tbody>';
           

$counter = 1;
$total_received = 0;
foreach($items as $item)
{
    $html .= '<tr >
                <td style = "text-align: center;width: 10% ">'.$counter.'</td>
                <td class = "text-center" style = "width: 20%; text-align: center">'.$item['dateReceived'].'</td>
                <td style = "width: 57%">'.$item['prod_desc'].'</td>
                <td style = "text-align: right; width: 20%">'.$item['qty_received'].'</td>
            </tr>';

    $total_received += (float) $item['qty_received'];
    $counter++;
}

$html .= '</tbody>
        </table> <br><br>';

$html .= '<table border = "0" cellpadding="2" style = "font-size: 9px;">
        <thead>
            <tr>
                <th style = "width: 70.6%"></th>
                <th style = "width: 16%;font-weight: bold ">Total Received</th>
                <th style = "width: 20%;  text-align: right; ">'.$total_received.'</th>
            </tr>';

        $html.='</thead>
    </table> <br><br>';

    $pdf->ln();
$pdf->SetFont('helvetica', '', 9);
$pdf->writeHTML($html, true, 0, true, true);
$pdf->lastPage();

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->SetFont('times', 'BI', 5);

$pdfPath = $pdfFolder . 'receiveITem.pdf';
$pdf->Output($pdfPath, 'F');

$pdf->Output('receiveITem.pdf', 'I');
