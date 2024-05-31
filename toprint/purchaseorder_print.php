<?php
    require_once '../vendor/autoload.php';
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
            $products = new ProductFacade();
            $fetchShop = $products->getShopDetails();
            $shop = $fetchShop->fetch(PDO::FETCH_ASSOC);
            $this->SetFont('helvetica', 'B', 12);

            $imageFile = '../assets/img/tinkerpro-logo-dark.png'; 
            $imageWidth = 45; 
            $imageHeight = 15; 
            $imageX = 10; 

            $this->Image($imageFile, $imageX, $y = 5, $w = $imageWidth, $h = $imageHeight, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);

            $this->SetY(10); 
            $this->SetX($imageX + $imageWidth + 5); 

            $this->SetFont('', 'B', 10);

            $this->Cell(0, 10, '', 0, 1, 'L', 0);
            $this->Ln(-3);
            $this->SetFont('', '', 10); 

            $this->MultiCell(0, 10, "{$shop['shop_address']}", 0, 'L');
            $this->Ln(-5);
            $this->SetFont('', '', 10); 

            $this->MultiCell(0, 10, "Contact: {$shop['contact_number']}", 0, 'L');
            $this->SetFont('', 10); 
            $this->Ln(-6);

            $current_date = date('F j, Y');
            $this->MultiCell(0, 10, "TIN: {$shop['tin']}", 0, 'L');
            $this->Ln(-7);

            $barcodeValue = $_GET['po_number']; 
            $barcodeFormat = 'C128';
            $barcodeWidth = 10;
            $barcodeHeight= 10; 
            $barcodePosX = $this->getPageWidth() - 70; 
            $barcodePosY = 12; 
            $this->write1DBarcode($barcodeValue, $barcodeFormat, $barcodePosX, $barcodePosY, '', $barcodeWidth, $barcodeHeight, null, 'N');
            
            $textWidth = $this->GetStringWidth('PURCHASE ORDER');
            $xPos = $barcodePosX + (50 - $textWidth); 
            $this->SetY($barcodePosY - 7); 
            $this->SetX($xPos + 3);
            $this->SetFont('', 'B', 12); 
            $this->MultiCell(0, 10, "PURCHASE ORDER", 0, 'C');

            $this->SetY($barcodePosY + $barcodeHeight + 3); 
            $this->SetX($barcodePosX);
            $this->SetFont('', '', 12); 
            $this->MultiCell(0, 10, "{$barcodeValue}", 0, 'R');   

            $this->Ln(-4);
            $this->Cell(0, 10, '', 0, 1, 'R', 0);
            $this->SetFont('', '', 10);

        }    
    }

    function autoAdjustFontSize($pdf, $text, $maxWidth, $initialFontSize = 10)
    {
        $pdf->SetFont('dejavusans', '', $initialFontSize);
        while ($pdf->GetStringWidth($text) > $maxWidth) {
            $initialFontSize--;
            $pdf->SetFont('', '', $initialFontSize);
        }
        return $initialFontSize;
    }

    function addFooter($pdf, $preparedBy, $receivedBy) {
        $pageWidth = $pdf->getPageWidth();
        $pageHeight = $pdf->getPageHeight();

        $footerXLeft = 10; 
        $footerY = $pageHeight - 31; 
        $pdf->SetXY($footerXLeft, $footerY);
        $pdf->SetFont('', 'B', 10);
        $pdf->Cell(0, 10, 'PREPARED BY: ' . $preparedBy, 0, 1, 'L');

        $footerXRight = $pageWidth - 70; 
        $pdf->SetXY($footerXRight, $footerY);
        $pdf->Cell(0, 10, 'RECEIVED BY: ' . $receivedBy, 0, 0, 'R');
    }

    ob_start();
    $orders = new OrderFacade();
    $pdf = new CustomPDF();
    $counter = 1;
    $order_id = $_GET['order_id'] ?? 0;

    $pdf->SetCreator('TinkerPro Inc.');
    $pdf->SetAuthor('TinkerPro Inc.');
    $pdf->SetTitle('Purchase Orders PDF');
    $pdf->SetSubject('Purchase Orders Table PDF Document');
    $pdf->SetKeywords('TCPDF, PDF, PurchaseOrders, table');

    $pdf->AddPage();

    $pdf->SetFont('helvetica', '', 12);
    $pdf->Ln(24);

    $items = $orders->get_orderData($order_id);
    $header = array('No.', 'S/N', 'ITEM DESCRIPTION', 'QTY', 'PRICE(Php.)', 'VAT(12%)', 'TOTAL (Php.)');
    $headerWidths = [];
    $maxCellHeight = 5;
    foreach ($header as $title) {
        $cellWidth = $pdf->GetStringWidth($title) + 8; 
        $headerWidths[] = $cellWidth;
    }

    $hexColor = '#F5F5F5';
    list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

    $pdf->SetFillColor($r, $g, $b);

    $pdf->SetFont('', 'B', 10);
    foreach ($header as $i => $title) {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $title, 1, 0, 'L', true);
    }
    $pdf->Ln();

    $pdf->SetFont('', '', 8);
    $totalCost = 0;
    $totalSellingPrice = 0;
    $totalTax = 0;
    $formatted_tax = 0;

    foreach ($items as $item) 
    {
        $amountBeforeTaxFormatted = '₱' . number_format($item['amount_beforeTax'], 2);
        $tax = '₱' . number_format($item['tax'], 2);
        $total = '₱' . number_format($item['total'], 2);

        $pdf->Cell($headerWidths[0], $maxCellHeight, $counter, 1, 0, 'C');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $counter, $headerWidths[1]));
        $pdf->Cell($headerWidths[1], $maxCellHeight, $item['sku'], 1, 0, 'L');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['sku'], $headerWidths[2]));
        $pdf->Cell($headerWidths[2], $maxCellHeight, $item['prod_desc'], 1, 0, 'L');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['prod_desc'], $headerWidths[3]));
        $pdf->Cell($headerWidths[3], $maxCellHeight, $item['qty_purchased'], 1, 0, 'L');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['qty_purchased'], $headerWidths[4]));
        $pdf->Cell($headerWidths[4], $maxCellHeight, $amountBeforeTaxFormatted, 1, 0, 'C');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $amountBeforeTaxFormatted, $headerWidths[5]));
        $pdf->Cell($headerWidths[5], $maxCellHeight, $tax, 1, 0, 'R');
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $tax, $headerWidths[6]));
        $pdf->Cell($headerWidths[6], $maxCellHeight, $total, 1, 0, 'R');
        $pdf->Ln(); 
        $counter++;
    }

    addFooter($pdf, '_______________________________', '_______________________________');

    ob_end_clean(); 
    $pdf->Output('purchaseorder.pdf', 'I');
    $pdfPath = __DIR__ . '/assets/pdf/inventory/purchaseorder.pdf';

    if (file_exists($pdfPath)) {

        unlink($pdfPath);
    }
    $pdf->Output($pdfPath, 'F');
?>