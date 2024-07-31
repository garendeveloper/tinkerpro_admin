<?php
    require_once '../reports/vendor/autoload.php';
    include('../utils/db/connector.php');
    include('../utils/models/user-facade.php');
    include('../utils/models/product-facade.php');
    include('../utils/models/inventory-facade.php');
    include(__DIR__ . '/../utils/models/other-reports-facade.php');
    include('../utils/models/order-facade.php');
    include('../utils/models/loss_and_damage-facade.php');
    include('../utils/models/supplier-facade.php');
    include('../utils/models/inventorycount-facade.php');

    $refundFacade = new OtherReportsFacade();
    $products = new ProductFacade();
    $fetchShop = $products->getShopDetails();
    $shop = $fetchShop->fetch(PDO::FETCH_ASSOC);

    function autoAdjustFontSize($pdf, $text, $maxWidth, $initialFontSize = 6) 
    {
        $pdf->SetFont('', '', $initialFontSize);
        while ($pdf->GetStringWidth($text) > $maxWidth) {
            $initialFontSize--;
            $pdf->SetFont('', '', $initialFontSize);
        }
        return $initialFontSize;
    }
    
    
    $pdf = new TCPDF();
    $pdf->SetCreator('TinkerPro Inc.');
    $pdf->SetAuthor('TinkerPro Inc.');
    $pdf->SetTitle('Inventory Count Table PDF');
    $pdf->SetSubject('Inventory Count PDF Document');
    $pdf->SetKeywords('TCPDF, PDF, Inventory Count, table');
    $pdf->setPageOrientation('L');
    $pdf->AddPage();
    
    
    $pdf->SetCellHeightRatio(1.5);
    $ipAddress = gethostbyname(gethostname());
    $imageFile = "http://".$ipAddress."/tinkerpros/www/assets/company_logo/".$shop['company_logo'];
    
    $imageWidth = 30; 
    $imageHeight = 30; 
    $imageX = 10; 
    $serverFilePath = $_SERVER['DOCUMENT_ROOT'] . "/tinkerpros/www/assets/company_logo/{$shop['company_logo']}";

    // if (file_exists($serverFilePath)) {
    //     $this->Image($serverFilePath, $imageX, $y = 20, $w = $imageWidth, $h = $imageHeight);
    // } else {
    //     echo "File does not exist.";
    // }
    $pdf->Image($serverFilePath, $imageX, $y = 10, $w = $imageWidth, $h = $imageHeight, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);
    $pdf->SetFont('', 'I', 8);

    $pdf->SetFont('', 'B', 10);
    $pdf->Cell(0, 10, 'Inventory Count', 0, 1, 'R', 0); 
    $pdf->Ln(-5);
    $pdf->SetFont('',  10);
    $pdf->Cell(0, 10, "{$shop['shop_name']}", 0, 1, 'R', 0); 
    
    $pdf->Ln(-3);
    $pdf->SetFont('', '', 10); 
    $pdf->MultiCell(0, 10, "{$shop['shop_address']}", 0, 'R');
    $pdf->Ln(-6);
    $pdf->SetFont('', '', 10); 
    $pdf->MultiCell(0, 10, "{$shop['shop_email']}", 0, 'R');
    $pdf->Ln(3);
    $pdf->SetFont('', '', 8); 
    $pdf->MultiCell(0, 10, "Contact: {$shop['contact_number']}", 0, 'L');
    
    $pdf->Ln(-16);
    $pdf->SetFont('' , 10); 
    $pdf->MultiCell(0, 10, "VAT REG TIN: {$shop['tin']}", 0, 'R');
    $pdf->Ln(2);
    $pdf->SetFont('' , 9); 
    $pdf->MultiCell(0, 10, "MIN: {$shop['min']}", 0, 'L');
    $pdf->Ln(-6);
    $pdf->SetFont('' , 9); 
    $pdf->MultiCell(0, 10, "S/N: {$shop['series_num']}", 0, 'L');
    $pdf->SetFont('' , 9); 
    $pdf->Ln(-9);
    $current_date = date('F j, Y');
    $pdf->Cell(0, 10, "Date Generated: $current_date", 0, 'L');
    $pdf->Ln(-6);
    $current_date = date('F j, Y');
    $pdf->Cell(0, 10, "Date Counted: {$_GET['date_counted']}", 0, 'L');
    $pdf->Ln(-6);
    $current_date = date('F j, Y');
    $pdf->Cell(0, 10, "Reference No: {$_GET['reference']}", 0, 'L');
    $pdf->Ln(-12);     
    
    $pdf->SetDrawColor(192, 192, 192); 
    $pdf->SetLineWidth(0.3); 

    ob_start();
    $counter = 1;

    $pdf->SetFont('helvetica', '', 9);
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
                border: 0.5px solid rgba(0, 0, 0, 0.1);
            }
        </style>';

    $html .= '<table border = "1" cellpadding = "2" id = "mainTable" style = "font-size: 9px;">
    <thead>
        <tr style = "border-bottom: 10px solid #gray; background-color: #d3d3d3">
            <th style = "width: 4%; text-align: center">No.</th>
            <th style = "width: 36%; text-align: center">Item Description</th>
            <th style = "text-align: center">Quantity</th>
            <th style = "text-align: center">Counted</th>
            <th style = "text-align: center">Difference</th>
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
    $items = json_decode($_GET['tableData']);
    for($i = 0; $i<count($items); $i++)
    {
        $html .= '<tr>
                    <td style = "width: 4%; text-align: center; ">'.$counter.'</td>
                    <td style = "width: 36%">'.$items[$i][0].'</td>
                    <td style = "text-align: right">'.$items[$i][1].'</td>
                    <td style = "text-align: right">'.$items[$i][2].'</td>
                    <td style = "text-align: right">'.$items[$i][3].'</td>
                </tr>';
            $counter++; 
    }
    $pdf->ln();
    $html .= '</tbody>
    </table>';

    $pdf->SetFont('helvetica', '', 9);
    $pdf->writeHTML($html, true, 0, true, true);

    
    
    ob_end_clean(); 
    $pdf->Output('inventorycount.pdf', 'I');
    $pdfPath = __DIR__ . '/assets/pdf/inventory/inventorycount.pdf';

    if (file_exists($pdfPath)) {

        unlink($pdfPath);
    }
    $pdf->Output($pdfPath, 'F');
?>