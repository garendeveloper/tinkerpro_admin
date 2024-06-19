<?php
    require_once '../reports/vendor/autoload.php';
    include('../utils/db/connector.php');
    include('../utils/models/user-facade.php');
    include('../utils/models/product-facade.php');
    include('../utils/models/inventory-facade.php');
    include('../utils/models/order-facade.php');
    include('../utils/models/loss_and_damage-facade.php');
    include('../utils/models/supplier-facade.php');
    include('../utils/models/inventorycount-facade.php');

    class CustomPDF extends TCPDF 
    {
        public function Header() 
        {
            $inventoryfacade = new InventoryFacade();
            $products = new ProductFacade();
            $fetchShop = $products->getShopDetails();
            $shop = $fetchShop->fetch(PDO::FETCH_ASSOC);
            $this->SetFont('helvetica', 'B', 12);
            $product_id = $_GET['product_id'] ?? 0;
            $items = $inventoryfacade->get_allStocksData($product_id)['inventoryInfo'];

            $imageFile = '../assets/img/tinkerpro-logo-dark.png'; 
            $imageWidth = 45; 
            $imageHeight = 15; 
            $imageX = 8; 

            $this->Image($imageFile, $imageX, $y = 5, $w = $imageWidth, $h = $imageHeight, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);

            $this->SetY(10); 
            $this->SetX($imageX + $imageWidth + 5); 

            $this->SetFont('', 'B', 10);

            $this->Cell(0, 10, '', 0, 1, 'L', 0);
            $this->Ln(-2);
            $this->SetFont('', '', 10); 

            $this->MultiCell(0, 10, "{$shop['shop_address']}", 0, 'L');
            $this->Ln(-5);
            $this->SetFont('', '', 10); 

            $this->MultiCell(0, 10, "Contact: {$shop['contact_number']}", 0, 'L');
            $this->SetFont('', 10); 
            $this->Ln(-7);

            $current_date = date('F j, Y');
            $this->MultiCell(0, 10, "TIN: {$shop['tin']}", 0, 'L');
            $this->Ln(-9);
             
            $this->SetFont('','B'); 
            $this->MultiCell(0, 10, "STOCK HISTORY OF : {$items['prod_desc']}", 0, 'R');
            $this->Ln(-9);

            

        // $pdf->Ln(-3);
        // $pdf->SetFont('', 'I', 10); // Bold, size 10
        // $pdf->MultiCell(0, 10, "{$shop['shop_address']}", 0, 'R');
        // $pdf->Ln(-9);
        // $pdf->SetFont('', 'I', 8); // Italic, size 8
        // $pdf->MultiCell(0, 10, "Contact: {$shop['contact_number']}", 0, 'L');
        // $pdf->SetFont('', 8);
        // $pdf->Ln(-9);
        // $current_date = date('F j, Y');
        // $pdf->Cell(0, 10, "Date: $current_date", 0, 'L');
        // $pdf->Ln(-2);
        }    
    }

    function autoAdjustFontSize($pdf, $text, $width) {
        $maxFontSize = 7; 
        $minFontSize = 6; 
        $pdf->SetFont('dejavusans', '', $width);
        while ($maxFontSize >= $minFontSize) {
            $pdf->SetFont('', '', $maxFontSize);
            if ($pdf->GetStringWidth($text) <= $width) {
                break;
            }
            $maxFontSize--;
        }
    
        return $maxFontSize;
    }

    ob_start();
    $inventoryfacade = new InventoryFacade();
    $pdf = new CustomPDF();
    $counter = 1;

    $start_date = $_GET['start_date'] ?? 0;
    $end_date = $_GET['end_date'] ?? 0;
    $product_id = $_GET['product_id'] ?? 0;

    $pdf->SetCreator('TinkerPro Inc.');
    $pdf->SetAuthor('TinkerPro Inc.');
    $pdf->SetTitle('Stock History PDF');
    $pdf->SetSubject('Stock History Table PDF Document');
    $pdf->SetKeywords('TCPDF, PDF, StockHistory, table');

    $pdf->AddPage();

    $pdf->SetFont('helvetica', '', 10);
    $pdf->Ln(22);
    $pdf->setDrawColor(192,192,192);
    $pdf->SetLineWidth(0.3); 

    $items = $inventoryfacade->get_allStocksData($product_id)['stocks'];
    if($start_date != 0 && $end_date != 0)
    {
        $items = $inventoryfacade->get_allStocksDataByDate($product_id, $start_date, $end_date)['stocks'];
    }
    $header = array('No.', 'Document Type', 'Document', 'User', 'Date', 'Stock Date', 'Quantity', 'In Stock');
    $headerWidths = [];
    $maxCellHeight = 5;
    foreach ($header as $title) {
        $cellWidth = $pdf->GetStringWidth($title) + 10; 
        $headerWidths[] = $cellWidth;
    }

    $hexColor = '#F5F5F5';
    list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

    $pdf->SetFillColor($r, $g, $b);

    $pdf->SetFont('', '', 8);
    foreach ($header as $i => $title) {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $title, 1, 0, 'L', true);
    }
    $pdf->Ln();
    foreach ($items as $item) 
    {
        $stockDateTime = strtotime($item['stock_date']);
        $stockDate = date("M d y", $stockDateTime);
        $stockTimestamp = date("M d y H:i:s", $stockDateTime); 
    
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $counter, $headerWidths[0]));
        $pdf->Cell($headerWidths[0], $maxCellHeight, $counter, 1, 0, 'C');
    
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['transaction_type'], $headerWidths[1]));
        $pdf->Cell($headerWidths[1], $maxCellHeight, $item['transaction_type'], 1, 0, 'L');
    
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['document_number'], $headerWidths[2]));
        $pdf->Cell($headerWidths[2], $maxCellHeight, $item['document_number'], 1, 0, 'C');
    
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['stock_customer'], $headerWidths[3]));
        $pdf->Cell($headerWidths[3], $maxCellHeight, $item['stock_customer'], 1, 0, 'C');
    
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $stockDate, $headerWidths[4]));
        $pdf->Cell($headerWidths[4], $maxCellHeight, $stockDate, 1, 0, 'C');
    
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $stockTimestamp, $headerWidths[5]));
        $pdf->Cell($headerWidths[5], $maxCellHeight, $stockTimestamp, 1, 0, 'C');
    
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['stock_qty'], $headerWidths[6]));
        $pdf->Cell($headerWidths[6], $maxCellHeight, $item['stock_qty'], 1, 0, 'R');
    
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['stock'], $headerWidths[7]));
        $pdf->Cell($headerWidths[7], $maxCellHeight, $item['stock'], 1, 0, 'R');
    
        $pdf->Ln(); 
        $counter++;
    }
    
    ob_end_clean(); 
    $pdf->Output('purchaseorder.pdf', 'I');
    $pdfPath = __DIR__ . '/assets/pdf/inventory/purchaseorder.pdf';

    if (file_exists($pdfPath)) {

        unlink($pdfPath);
    }
    $pdf->Output($pdfPath, 'F');
?>