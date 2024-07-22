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
        $this->Cell(0, 1, "DELIVERY RECEIPT", 0, false, 'L', 0, '', 0, false, 'L', 'M');
        $this->Ln();
        $this->Cell(0, 1, "{$shop['shop_name']}", 0, false, 'L', 0, '', 0, false, 'L', 'M');
        $this->Ln();
    
        $this->SetFont('helvetica', '', 11);
        $this->Cell(0, 10, "{$shop['shop_address']}", 0, false, 'L');
        $this->Ln();
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

        $imageFile = './../assets/img/tinkerpro-logo-dark.png'; 
        $imageWidth = 45; 
        $imageHeight = 15; 
        $imageX = 150; 
        $this->Image($imageFile, $imageX, $y = 10, $w = $imageWidth, $h = $imageHeight, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);
     
    }
    public function Footer() 
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
function ordinalSuffix($number) 
{
    $suffix = 'th'; 

    if (in_array($number % 100, [11, 12, 13])) {
        $suffix = 'th';
    } else {
        switch ($number % 10) {
            case 1:
                $suffix = 'st';
                break;
            case 2:
                $suffix = 'nd';
                break;
            case 3:
                $suffix = 'rd';
                break;
        }
    }

    return $number . $suffix;
}

$products = new ProductFacade();
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);

$pdf = new MYPDF('P', 'mm', 'A4');
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("{$shop['shop_name']}");
$pdf->SetTitle('PURCHASE ORDER');   
$pdf->SetSubject('UNPAID PURCHASE ORDER');
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

$html = '<style>
            #tblHeader{
                text-align: left;
            }
            #mainTable thead th{
                border: 0.1px solid black;
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
                    <th style = "width: 25%">DR No.: </th>
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
                    <th style = "width: 25%; color: red;">Unpaid</th>
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

    $html .= '<tr >
                <td style = "width: 4%; text-align: center; ">'.$counter.'</td>
                <td style = "width: 36%">'.$item['prod_desc'].'</td>
                <td style = "text-align: right">'.number_format($item['qty_purchased'],2).'</td>
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
                    <th style = "width: 16%; border: 1px solid black;">Subtotal</th>
                    <th style = "width: 20%; border: 1px solid black; text-align: right">P'.number_format($overall_price,2).'</th>
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
            </tr>';

            $paid_amount = 0;
            $i = 1;
            foreach($orderDetails as $od)
            {
                $method = $od['method'] ?? "Cash";
                $html.='<tr>
                    <th style = "width: 70.6%"></th>
                    <th style = "width: 16%; ">'.$od['date_paid'].' |&nbsp;'.$method.'</th>
                    <th style = "width: 20%;  text-align: right; ">P'.number_format($od['paid_amount'],2).'</th>
                </tr>';
                $i++;
                $paid_amount += $od['paid_amount'];
            }
             $html.='<tr>
                        <th style = "width: 70.6%;"></th>
                        <th style = "width: 16%; font-weight: bold">Paid amount</th>
                        <th style = "width:20%; text-align: right; font-weight: bold">P'.number_format($paid_amount,2).'</th>
                    </tr>';
            $html.='<tr>
                <th style = "width: 70.6%;"></th>
                <th style = "width: 16%; font-weight: bold">Amount Due</th>
                <th style = "width:20%; text-align: right; font-weight: bold">P'.number_format($items[0]['unpaid_amount'],2).'</th>
            </tr>';
           
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
    $pdf->Cell(0, 10, $od['reference_no'], 0, false, 'L');
    $pdf->Ln(4);
}

$pdf->lastPage();

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);



$pdf->SetFont('times', 'BI', 5);

$pdfPath = $pdfFolder . 'e1.pdf';
$pdf->Output($pdfPath, 'F');

$pdf->Output('e1.pdf', 'I');
