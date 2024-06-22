<?php
require_once '../vendor/autoload.php';
include ('../utils/db/connector.php');
include ('../utils/models/user-facade.php');
include ('../utils/models/product-facade.php');
include ('../utils/models/inventory-facade.php');
include ('../utils/models/order-facade.php');
include ('../utils/models/loss_and_damage-facade.php');
include ('../utils/models/supplier-facade.php');
include ('../utils/models/inventorycount-facade.php');
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mpdf\Mpdf;
try {
    $type = $_GET['type'];
    $inventory_id = $_GET['inv_id'];
    $inventory_count = new InventoryCountFacade();
    $products = new ProductFacade();

    if ($type === '1') {
        function autoAdjustFontSize($pdf, $text, $maxWidth, $initialFontSize = 10)
        {
            $pdf->SetFont('dejavusans', '', $initialFontSize);
            while ($pdf->GetStringWidth($text) > $maxWidth) {
                $initialFontSize--;
                $pdf->SetFont('', '', $initialFontSize);
            }
            return $initialFontSize;
        }

        $fetchShop = $products->getShopDetails();
        $shop = $fetchShop->fetch(PDO::FETCH_ASSOC);
        $items = $inventory_count->get_activeProducts();
        $currentTimestamp = date('F j, Y H:i:s');

        $pdf = new TCPDF();
        $pdf->SetCreator('TinkerPro Inc.');
        $pdf->SetAuthor('TinkerPro Inc.');
        $pdf->SetTitle('Print Count Sheet');
        $pdf->SetSubject('Print Count Sheet Document');
        $pdf->SetKeywords('TCPDF, PDF, product, table');

        $pdf->AddPage();

        $pdf->SetFont('', 'B', 12);
        $pdf->Cell(0, 12, 'INVENTORY COUNT REPORT', 0, 1, 'C', 0);
        $pdf->Ln(-6);
        $pdf->SetFont('', '', 10);
        $pdf->Cell(0, 10, "Date & Time: ".$currentTimestamp, 0, 1, 'C', 0);
        $pdf->Ln(-4);
        $pdf->SetFont('', '', 10);
        $pdf->Cell(0, 10, "REF#: ______________________", 0, 1, 'C', 0);

        $pdf->Ln(2);


        $header = array('No.', 'SKU', 'PRODUCT', 'QTY', 'COUNTED');
        $headerWidths = array(15, 35, 100, 20, 20);
        $maxCellHeight = 5;

        $hexColor = '#D3D3D3';
        list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

        $pdf->SetFillColor($r, $g, $b);

        $pdf->SetFont('', 'B', 10);
        for ($i = 0; $i < count($header); $i++) {
            $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'L', true);
        }
        $pdf->Ln();
        $counter = 1;
        foreach ($items as $item) 
        {
            $pdf->Cell($headerWidths[0], $maxCellHeight, $counter, 1, 0, 'C');
            $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['sku'] ?? '', $headerWidths[1]));
            $pdf->Cell($headerWidths[1], $maxCellHeight, $item['sku'] ?? '', 1, 0, 'C');
            $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['prod_desc'] ?? '', $headerWidths[2]));
            $pdf->Cell($headerWidths[2], $maxCellHeight, $item['prod_desc'] ?? '', 1, 0, 'L');
            $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['product_stock'] ?? '', $headerWidths[3]));
            $pdf->Cell($headerWidths[3], $maxCellHeight, $item['product_stock'] ?? '', 1, 0, 'C');
            $pdf->SetFont('', '', autoAdjustFontSize($pdf, '', $headerWidths[4]));
            $pdf->Cell($headerWidths[4], $maxCellHeight, '', 1, 0, 'C');
            $pdf->Ln();
            $counter++;
        }

        $pdf->Output('inventory_list.pdf', 'I');
        $pdfPath = __DIR__ . '/assets/pdf/inventory/inventory_list.pdf';

        if (file_exists($pdfPath)) {

            unlink($pdfPath);
        }
        $pdf->Output($pdfPath, 'F');
    } else {
        try {
            $inventory_count = new InventoryCountFacade();
            $items = $inventory_count->get_activeProducts();
            $currentTimestamp = date('F j, Y H:i:s');
            
            $printerName = "XP-80C"; 
            $connector = new WindowsPrintConnector($printerName);

            $printer = new Printer($connector);

            $printer->setEmphasis(false);
            $printer->setDoubleStrike(false);
            $printer->setFont(Printer::FONT_A);
            
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("INVENTORY COUNT REPORT\n");
            $printer->text("Date & Time: " . date('F j, Y H:i:s') . "\n");
            $printer->text("REF#: ______________________\n");
            $printer->feed();
            
            // $printer->setJustification(Printer::JUSTIFY_LEFT);
            // $printer->setEmphasis(true);
            $header = str_pad("No.", 10) . "\t" . 
            str_pad("SKU", 15) . "\t" . 
            str_pad("PRODUCT", 40) . "\t" . 
            str_pad("QTY", 15) . "\t" . 
            str_pad("COUNTED", 15) . "\n";
            $colWidths = array(10, 15, 40, 15, 15); // Adjust as needed
            $colAligns = array(Printer::JUSTIFY_RIGHT, Printer::JUSTIFY_LEFT, Printer::JUSTIFY_LEFT, Printer::JUSTIFY_RIGHT, Printer::JUSTIFY_RIGHT);
        
            // Print table header
            $header = "";
            foreach ($colWidths as $index => $width) {
                $header .= str_pad(substr("No. SKU PRODUCT QTY COUNTED", array_sum(array_slice($colWidths, 0, $index)), $width), $width, ' ', STR_PAD_RIGHT);
            }
            $header .= "\n";
            $printer->text($header);
            $printer->setEmphasis(false);
        
            // Print item details
            foreach ($items as $item) {
                $line = "";
                foreach ($colWidths as $index => $width) {
                    $line .= str_pad(substr($item['sku'] . ' ' . $item['prod_desc'] . ' ' . $item['product_stock'], array_sum(array_slice($colWidths, 0, $index)), $width), $width, ' ', STR_PAD_RIGHT);
                }
                $line .= "\n";
                $printer->text($line);
            }
        
            // Close printer connection
            $printer->close();
        
            echo json_encode(['success' => true, 'message' => 'Print successful']);
            $printer->cut();
            $printer->close();
            
            echo json_encode(['success' => true, 'message' => 'Print successful']);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Print failed: ' . $e->getMessage()]);

        }
    }

} catch (Exception $e) {
    echo "Print failed: " . $e->getMessage();
}
