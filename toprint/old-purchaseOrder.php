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

    function autoAdjustFontSize($pdf, $text, $width) {
        $maxFontSize = 8; 
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

    $pdf->SetFont('helvetica', '', 9);
    $pdf->Ln(24);

    $items = $orders->get_orderData($order_id);
    $pdf->SetDrawColor(192, 192, 192); 
    $pdf->SetLineWidth(0.3); 
    $header = array('No.', 'ITEM DESCRIPTION', 'QTY', 'PRICE(Php.)', 'VAT(12%)', 'TOTAL (Php.)');
    $maxCellHeight = 5;

    $headerWidths = array(20, 50, 30, 30, 30, 30);
    $maxCellHeight = 5; 
    $hexColor = '#D3D3D3';
    list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");
    $pdf->SetFillColor($r, $g, $b);
    $pdf->SetFont('', 'B', 9);
    foreach ($header as $i => $title) {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $title, 1, 0, 'L', true);
    }
    $pdf->Ln();

    $pdf->SetFont('', '', 8);
    $totalCost = 0;
    $totalSellingPrice = 0;
    $totalTax = 0;
    $formatted_tax = 0;

    $overall_qty = 0;
    $overall_price = 0;
    $overall_vat = 0;
    $overall_total = 0;
    foreach ($items as $item) 
    {
        $amountBeforeTaxFormatted = number_format($item['cost'], 2);
        $tax = number_format($item['tax'], 2);
        $total = number_format($item['total'], 2);

        $overall_qty += $item['qty_purchased'];
        $overall_price += $item['cost'];
        $overall_vat += $item['tax'];
        $overall_total += $item['total'];
    
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $counter, $headerWidths[0]));
        $pdf->Cell($headerWidths[0], $maxCellHeight, $counter, 1, 0, 'C');

        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['prod_desc'], $headerWidths[1]));
        $pdf->Cell($headerWidths[1], $maxCellHeight, $item['prod_desc'], 1, 0, 'L');
    
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, number_format($item['qty_purchased'], 2), $headerWidths[2]));
        $pdf->Cell($headerWidths[2], $maxCellHeight, number_format($item['qty_purchased'], 2), 1, 0, 'R');
    
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $amountBeforeTaxFormatted, $headerWidths[3]));
        $pdf->Cell($headerWidths[3], $maxCellHeight, $amountBeforeTaxFormatted, 1, 0, 'R');
    
        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $tax, $headerWidths[4]));
        $pdf->Cell($headerWidths[4], $maxCellHeight, $tax, 1, 0, 'R');

        $pdf->SetFont('', '', autoAdjustFontSize($pdf, $total, $headerWidths[5]));
        $pdf->Cell($headerWidths[5], $maxCellHeight, $total, 1, 0, 'R');
    
        $pdf->Ln(); 
        $counter++;
    }

    $pdf->SetFont('', 'B', 8); 
    $pdf->SetFont('', 'B', autoAdjustFontSize($pdf, 'Total Price', $headerWidths[0] + $headerWidths[1]));
    $pdf->Cell($headerWidths[0] + $headerWidths[1], $maxCellHeight, 'Total Price', 1, 0, 'L'); 
    $pdf->SetFont('', 'B', autoAdjustFontSize($pdf, number_format( $overall_qty, 2), $headerWidths[2]));
    $pdf->Cell($headerWidths[2], $maxCellHeight, number_format( $overall_qty, 2), 1, 0, 'R'); 
    $pdf->SetFont('', 'B', autoAdjustFontSize($pdf, number_format( $overall_price, 2), $headerWidths[3]));
    $pdf->Cell($headerWidths[3], $maxCellHeight, number_format( $overall_price, 2), 1, 0, 'R'); 
    $pdf->SetFont('', 'B', autoAdjustFontSize($pdf, number_format( $overall_vat, 2), $headerWidths[4]));
    $pdf->Cell($headerWidths[4], $maxCellHeight, number_format( $overall_vat, 2), 1, 0, 'R'); 
    $pdf->SetFont('', 'B', autoAdjustFontSize($pdf, number_format( $overall_total, 2), $headerWidths[5]));
    $pdf->Cell($headerWidths[5], $maxCellHeight, number_format( $overall_total, 2), 1, 0, 'R'); 
    $pdf->Ln(); 
    

    addFooter($pdf, '_______________________________', '_______________________________');

    ob_end_clean(); 
    $pdf->Output('purchaseorder.pdf', 'I');
    $pdfPath = __DIR__ . '/assets/pdf/inventory/purchaseorder.pdf';

    if (file_exists($pdfPath)) {

        unlink($pdfPath);
    }
    $pdf->Output($pdfPath, 'F');
?>