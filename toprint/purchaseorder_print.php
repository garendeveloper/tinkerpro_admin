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

    //Page header
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
        $this->Cell(0, 1, "PURCHASE ORDER RECEIPT", 0, false, 'L', 0, '', 0, false, 'L', 'M');
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
        
        $this->Line(10, 52, 200, 52);
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
$pdf->SetTitle('PURCHASE ORDER');   
$pdf->SetSubject('PURCHASE ORDER');
$pdf->SetKeywords('TCPDF, PDF, PURCHASES, Summary, guide');
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
$isFullyReceived = (float)$items[0]['totalQty'] === (float)$items[0]['totalReceived'];

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
                width: 200%;
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
                    <th style = "width: 25%">PO No.: </th>
                    <th style = "width: 25%">'.$items[0]['po_number'].'</th>
                </tr>
                <tr>
                    <th style = "width: 65%">'.$items[0]['supplier'].'</th>
                    <th style = "width: 25%">Date: </th>
                    <th style = "width: 25%">'.$items[0]['date_purchased'].'</th>
                </tr>
                <tr>
                    <th style = "width: 65%">Tax: XXXXX</th>
                    <th style = "width: 25%">Due date: </th>
                    <th style = "width: 25%">'.$items[0]['due_date'].'</th>
               
                </tr>
                <tr>
                    <th style = "width: 65%"></th>
                    <th style = "width: 25%">Payment status: </th>
                    <th style = "width: 25%;">Paid</th>
                </tr>
                <tr>
                    <th style = "width: 65%"></th>
                    <th style = "width: 25%">Bank acc. number: </th>
                    <th style = "width: 25%"></th>
                </tr>
            </thead>
        </table>';

$html .= '<table border = "1" cellpadding = "2" id = "mainTable" style = "font-size: 9px;">
            <thead>
                <tr style = "border-bottom: 10px solid #gray;">
                    <th style = "width: 4%; text-align: center">#</th>
                    <th style = "width: 36%; text-align: center">Item</th>
                    <th style = "text-align: center">Quantity</th>
                    <th style = "text-align: center">Unit Price</th>
                    <th style = "text-align: center">Tax</th>
                    <th style = "text-align: center">Total</th>
                </tr>
            </thead>
            <tbody>';
           
$totalCost = 0;
$totalSellingPrice = 0;
$totalTax = 0;
$formatted_tax = 0;

$overall_qty = 0;
$overall_price = 0;
$overall_vat = 0;
$overall_total = 0;

$counter = 1;
foreach($items as $item)
{
    $amountBeforeTaxFormatted = number_format($item['cost'], 2);
    $tax = number_format($item['tax'], 2);
    $total = number_format($item['total'], 2);

    $overall_qty += $item['qty_purchased'];
    $overall_price += $item['cost'];
    $overall_vat += $item['tax'];
    $overall_total += $item['total'];
    $qty  = $isFullyReceived ? number_format($item['qty_received'],2) : number_format($item['qty_purchased'],2);
    $html .= '<tr >
                <td style = "width: 4%; text-align: center; ">'.$counter.'</td>
                <td style = "width: 36%">'.$item['prod_desc'].'</td>
                <td style = "text-align: right">'.$qty.'</td>
                <td style = "text-align: right">'.$amountBeforeTaxFormatted.'</td>
                <td style = "text-align: right">'.$tax.'</td>
                <td style = "text-align: right">'.$total.'</td>
            </tr>';
    $counter++;
}
$pdf->ln();
$html .= '</tbody>
        </table> <br><br>';

$html .= '<table border = "0" cellpadding="2" style = "font-size: 9px;">
            <thead>
                <tr>
                    <th style = "width: 70.6%"></th>
                    <th style = "width: 16%; border: 1px solid rgba(0, 0, 0, 0.2);">Subtotal</th>
                    <th style = "width: 20%; border: 1px solid rgba(0, 0, 0, 0.2); text-align: right">P'.number_format($overall_price,2).'</th>
                </tr>
                <tr>
                    <th style = "width: 70.6%"></th>
                    <th style = "width: 16%; border: 1px solid black;">Tax</th>
                    <th style = "width: 20%; border: 1px solid black; text-align: right">P'.number_format($overall_vat,2).'</th>
                </tr>
                <tr>
                    <th style = "width: 70.6%;"></th>
                    <th style = "width: 16%; border: 1px solid black; background-color: #d3d3d3;">Total</th>
                    <th style = "width: 20%; border: 1px solid black; background-color: #d3d3d3; text-align: right">P'.number_format($overall_total,2).'</th>
                </tr>
            </thead>
        </table> <br><br>';

$html .= '<table border = "0" cellpadding="2" style = "font-size: 9px;">
        <thead>
            <tr>
                <th style = "width: 70.6%"></th>
                <th style = "width: 36%; font-weight: bold">Payment method:</th>
            </tr>
            <tr>
                <th style = "width: 70.6%"></th>
                <th style = "width: 16%; ">Cash</th>
                <th style = "width: 20%;  text-align: right; ">P'.number_format($overall_total,2).'</th>
            </tr>
            <tr>
                <th style = "width: 70.6%;"></th>
                <th style = "width: 16%; font-weight: bold">Paid amount</th>
                <th style = "width:20%; text-align: right; font-weight: bold">P'.number_format($overall_total,2).'</th>
            </tr>
            <tr>
                <th style = "width: 70.6%;"></th>
                <th style = "width: 16%; font-weight: bold">Amount Due</th>
                <th style = "width:20%; text-align: right; font-weight: bold">P'.number_format(0,2).'</th>
            </tr>';

            // $paid_amount = 0;
            // $i = 1;
            // foreach($orderDetails as $od)
            // {
            //     $method = $od['method'] ?? "Cash";
            //     $html.='<tr>
            //         <th style = "width: 70.6%"></th>
            //         <th style = "width: 16%; ">'.$od['date_paid'].' |&nbsp;'.$method.'</th>
            //         <th style = "width: 20%;  text-align: right; ">P'.number_format($od['paid_amount'],2).'</th>
            //     </tr>';
            //     $i++;
            //     $paid_amount += $od['paid_amount'];
            // }
            //  $html.='<tr>
            //             <th style = "width: 70.6%;"></th>
            //             <th style = "width: 16%; font-weight: bold">Paid amount</th>
            //             <th style = "width:20%; text-align: right; font-weight: bold">P'.number_format($paid_amount,2).'</th>
            //         </tr>';
            // $html.='<tr>
            //     <th style = "width: 70.6%;"></th>
            //     <th style = "width: 16%; font-weight: bold">Amount Due</th>
            //     <th style = "width:20%; text-align: right; font-weight: bold">P'.number_format($items[0]['unpaid_amount'],2).'</th>
            // </tr>';
           
        $html.='</thead>
    </table> <br><br>';

$pdf->SetFont('helvetica', '', 9);
$pdf->writeHTML($html, true, 0, true, true);
$pdf->Ln(5);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(0, 10, 'References:', 0, false, 'L');
$pdf->Ln(3.5);
foreach($orderDetails as $od)
{
    $pdf->SetFont('helvetica', '', 8);
    $pdf->Cell(0, 10, '---', 0, false, 'L');
    $pdf->Ln(4);
}

$pdf->lastPage();

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);



$pdf->SetFont('times', 'BI', 5);

$pdfPath = $pdfFolder . 'e1.pdf';
$pdf->Output($pdfPath, 'F');

$pdf->Output('e1.pdf', 'I');
