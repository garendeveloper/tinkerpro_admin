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

$items = $birFacade->getSalesDaily();
var_dump($items);

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
        
            table td {
                border: solid 1px black;
                word-wrap: break-word;
            }
            table thead th {
                border: solid 1px #666;
                word-wrap: break-word;
                text-align: center;       
                vertical-align: middle;
                font-size: 6px;
            }
            th{
              border: solid 1px #666;
            word-wrap: break-word;
            text-align: center;       
            vertical-align: middle;
            font-size: 6px;
            }
            th.rowspan-cell {
                background-color: #f2f2f2; 
                font-weight: bold; 
            }
            .ac{
                background-color: #A6A6A6;
            }
            .dg{
                background-color: #00B0F0;
            }
            .hk{
                background-color: #FFFF00;
            }
            .ls{
                background-color: #FFC000;
            }
            .ty{
                background-color: #92D050;
            }
              
            .daily-reports{
                width: 946vw;


            }


        </style>';

if($items)
{
    $html .= '<table  class="daily-reports">
                <thead >
                    <tr >
                        <th  style = " margin-left:-50px; width: 105%; font-size: 12px;  font-weight: bold;">DAILY TRANSACTION</th>
                    </tr>
                    <tr>
                        <th style = "width: 3%;"class = "ac" rowspan="3">Date</th>
                        <th style = "width: 5%" class = "ac" rowspan="3">SI No.</th>
                        <th style = "width: 5%" class = "dg" rowspan="3">Sales Issued w/ Manual SI/OR (per RR 16-2018)</th>
                        <th style = "width: 5%" class = "dg" rowspan="3">Gross Sales for the Day</th>
                        <th style = "width: 5%" class = "hk" rowspan="3">VATable Sales</th>
                        <th style = "width: 5%" class = "hk" rowspan="3">VAT Amount</th>
                        <th style = "width: 5%" class = "hk" rowspan="3">VAT-Exempt Sales</th>
                        <th style = "width: 3%" class = "hk" rowspan="3">Zero-Rated Sales</th>
                        <th style = "width: 27%; text-align: center" class = "ls" colspan = "4">Deductions</th>
                        <th style = "width: 18%; text-align: center" class = "ty" colspan = "4">Adjustment on VAT</th>

                        <th style = "width: 3%; text-align: center" class = "ac" rowspan = "3">VAT Payable</th>
                        <th style = "width: 4%; text-align: center" class = "ac" rowspan = "3">Net Sales</th>
                        <th style = "width: 3%; text-align: center" class = "ac" rowspan = "3">Sales Overrun/Overflow</th>
                        <th style = "width: 3%; text-align: center" class = "ac" rowspan = "3">Total Income</th>
                        <th style = "width: 3%; text-align: center" class = "ac" rowspan = "3">Reset Counter</th>
                        <th style = "width: 3%; text-align: center" class = "ac" rowspan = "3">Z-Counter</th>
                        <th style = "width: 5%; text-align: center" class = "ac" rowspan = "3">Remarks</th>
                    </tr> 
                    <tr>
                        <th style = "width: 18%; text-align: center"class = "ls" colspan = "5">Discount</th>
                        <th style = "width: 3%; text-align: center" class = "ls" rowspan = "2">Returns</th>
                        <th style = "width: 3%" class = "ls" rowspan = "2">Voids</th>
                        <th style = "width: 3%" class = "ls" rowspan = "2">Total Deductions</th>

                        <th style = "width: 9%; text-align: center"class = "ty" colspan = "3">Discount</th>
                        <th style = "width: 3%; text-align: center" class = "ty" rowspan = "2">VAT on Returns</th>
                        <th style = "width: 3%" class = "ty" rowspan = "2">Others</th>
                        <th style = "width: 3%" class = "ty" rowspan = "2">Total VAT Adjustment</th>
                    </tr>
                    <tr>
                        <th style = "width: 3%" class = "ls">SC</th>
                        <th style = "width: 3%" class = "ls">PWD</th>
                        <th style = "width: 3%" class = "ls">NAAC</th>
                        <th style = "width: 3%" class = "ls">Solo Parent</th>
                        <th style = "width: 3%" class = "ls">MOV</th>
                        <th style = "width: 3%" class = "ls">Others</th>

                        <th style = "width: 3%" class = "ty">SC</th>
                        <th style = "width: 3%" class = "ty">PWD</th>
                        <th style = "width: 3%" class = "ty">Others</th>
                    </tr>
                </thead>
                <tbody>';
                
                function formatValue($value) 
                {
                    return ($value == 0 || empty($value)) ? '' : $value;
                }
                for($i = 0; $i<count($items); $i++)
                {
                    
                    $html .= '<tr style="border: 1px solid black; font-size: 6px;">
                                <td style="width: 3%">' . ($items[$i]['DATE']) . '</td>
                                <td style="width: 5%">' . ($items[$i]['BEG_SI']) . '</td>
                                <td style="width: 5%; text-align: center">' . (null) . '</td>
                                <td style="width: 5%; text-align: right">' . formatValue(($items[$i]['subtotal'])) . '</td>
                                <td style="width: 5%; text-align: right">' . formatValue(($items[$i]['VAT_SALES'])) . '</td>
                                <td style="width: 5%; text-align: right">' . formatValue(($items[$i]['VAT_AMOUNT'])) . '</td>
                                <td style="width: 5%; text-align: right">' . formatValue(($items[$i]['VAT_EXEMPT'])) . '</td>
                                <td style="width: 3%; text-align: right">' . formatValue(0) . '</td>
                                <td style="width: 3%; text-align: right">' . formatValue($items[$i]['sc_discount']) . '</td>
                                <td style="width: 3%; text-align: right">' . formatValue($items[$i]['pwd_discount']) . '</td>
                                <td style="width: 3%; text-align: right">' . formatValue($items[$i]['naac_discount']) . '</td>
                                <td style="width: 3%; text-align: right">' . formatValue($items[$i]['sp_discount']) . '</td>
                                <td style="width: 3%; text-align: right">' . formatValue($items[$i]['mov_discount']) . '</td>
                                <td style="width: 3%; text-align: right">' . formatValue(0) . '</td>
                                <td style="width: 3%; text-align: right">' . formatValue($items[$i]['totalReturn']) . '</td>
                                <td style="width: 3%; text-align: right">' . formatValue(($items[$i]['VOID'])) . '</td>
                                <td style="width: 3%; text-align: right">' . formatValue(($items[$i]['less_discount'])) . '</td>
                                <td style="width: 3%; text-align: right">' . formatValue($items[$i]['sc_ref_ret_void_discount']) . '</td>
                                <td style="width: 3%; text-align: right">' . formatValue($items[$i]['pwd_ref_ret_void_discount']) . '</td>
                                <td style="width: 3%; text-align: right">' . formatValue($items[$i]['sp_ref_ret_void_discount'] + $items[$i]['naac_ref_ret_void_discount']) . '</td>
                                <td style="width: 3%; text-align: right">' . formatValue($items[$i]['VAT_AMOUNT_REF_RET']) . '</td>
                                <td style="width: 3%; text-align: right">' . formatValue($items[$i]['othersVatAdjustment']) . '</td>
                                <td style="width: 3%; text-align: right">' . formatValue($items[$i]['VAT_AMOUNT_REF_RET']) . '</td>
                                <td style="width: 3%; text-align: right">' . formatValue(0) . '</td>
                                <td style="width: 4%; text-align: right">' . formatValue($items[$i]['NET']) . '</td>
                                <td style="width: 3%; text-align: right">' . formatValue($items[$i]['SHORT_OVER']) . '</td>
                                <td style="width: 3%; text-align: right">' . formatValue($items[$i]['NET']) . '</td>
                                <td style="width: 3%; text-align: right">' . ($items[$i]['RESET_COUNT']) . '</td>
                                <td style="width: 3%; text-align: right">' . ($items[$i]['Z_READ_COUNT']) . '</td>
                                <td style="width: 5%; text-align: right"></td>
                            </tr>';
                }
                $html.='</tbody>
            </table>';
}
// else
// {
//     $html .= '<table class="daily-reports" border="1" cellpadding="3">
//             <thead >
//                 <tr >
//                     <th style = "text-align: center; font-size: 12px; width: 107%; font-weight: bold;">DAILY TRANSACTION</th>
//                 </tr>
//                 <tr>
//                     <th style = "width: 3%;"class = "ac" rowspan="3">Date</th>
//                     <th style = "width: 3%" class = "ac" rowspan="3">Beginning SI/OR No.</th>
//                     <th style = "width: 3%" class = "ac" rowspan="3">Ending SI/OR No.</th>
//                     <th style = "width: 5%" class = "dg" rowspan="3">Grand Accum. Sales Ending Balance</th>
//                     <th style = "width: 5%" class = "dg" rowspan="3">Grand Accum. Beg. Balance</th>
//                     <th style = "width: 5%" class = "dg" rowspan="3">Sales Issued w/ Manual SI/OR (per RR 16-2018)</th>
//                     <th style = "width: 5%" class = "dg" rowspan="3">Gross Sales for the Day</th>
//                     <th style = "width: 3%" class = "hk" rowspan="3">VATable Sales</th>
//                     <th style = "width: 3%" class = "hk" rowspan="3">VAT Amount</th>
//                     <th style = "width: 3%" class = "hk" rowspan="3">VAT-Exempt Sales</th>
//                     <th style = "width: 3%" class = "hk" rowspan="3">Zero-Rated Sales</th>
//                     <th style = "width: 27%; text-align: center" class = "ls" colspan = "4">Deductions</th>
//                     <th style = "width: 18%; text-align: center" class = "ty" colspan = "4">Adjustment on VAT</th>

//                     <th style = "width: 3%; text-align: center" class = "ac" rowspan = "3">VAT Payable</th>
//                     <th style = "width: 3%; text-align: center" class = "ac" rowspan = "3">Net Sales</th>
//                     <th style = "width: 3%; text-align: center" class = "ac" rowspan = "3">Sales Overrun/Overflow</th>
//                     <th style = "width: 3%; text-align: center" class = "ac" rowspan = "3">Total Income</th>
//                     <th style = "width: 3%; text-align: center" class = "ac" rowspan = "3">Reset Counter</th>
//                     <th style = "width: 3%; text-align: center" class = "ac" rowspan = "3">Z-Counter</th>
//                     <th style = "width: 3%; text-align: center" class = "ac" rowspan = "3">Remarks</th>
//                 </tr> 
//                 <tr>
//                     <th style = "width: 18%; text-align: center"class = "ls" colspan = "5">Discount</th>
//                     <th style = "width: 3%; text-align: center" class = "ls" rowspan = "2">Returns</th>
//                     <th style = "width: 3%" class = "ls" rowspan = "2">Voids</th>
//                     <th style = "width: 3%" class = "ls" rowspan = "2">Total Deductions</th>

//                     <th style = "width: 9%; text-align: center"class = "ty" colspan = "3">Discount</th>
//                     <th style = "width: 3%; text-align: center" class = "ty" rowspan = "2">VAT on Returns</th>
//                     <th style = "width: 3%" class = "ty" rowspan = "2">Others</th>
//                     <th style = "width: 3%" class = "ty" rowspan = "2">Total VAT Adjustment</th>
//                 </tr>
//                 <tr>
//                     <th style = "width: 3%" class = "ls">SC</th>
//                     <th style = "width: 3%" class = "ls">PWD</th>
//                     <th style = "width: 3%" class = "ls">NAAC</th>
//                     <th style = "width: 3%" class = "ls">Solo Parent</th>
//                     <th style = "width: 3%" class = "ls">MOV</th>
//                     <th style = "width: 3%" class = "ls">Others</th>

//                     <th style = "width: 3%" class = "ty">SC</th>
//                     <th style = "width: 3%" class = "ty">PWD</th>
//                     <th style = "width: 3%" class = "ty">Others</th>
//                 </tr>
//             </thead>
//             <tbody >
//                 <tr style = "border: 1px solid black; font-size: 6px;">
//                     <td style = "text-align: center; width: 104%" colspan = "19">No available data. ***</td>
//                 </tr>
//             </tbody>
//         </table>';

// }

$pdf->SetFont('helvetica', '', 10);
$pdf->writeHTML($html, true, 0, true, true);
$pdf->Ln();
$pdf->lastPage();

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);



$pdf->SetFont('times', 'BI', 5);

$pdfPath = $pdfFolder . 'e0.pdf';
$pdf->Output($pdfPath, 'F');

$pdf->Output('e0.pdf', 'I');
