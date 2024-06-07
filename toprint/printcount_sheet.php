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
        $items = $inventory_count->get_inventoryCountDataById($inventory_id);
        $items_info = $items['info'];
        $items_data = $items['data'];

        $pdf = new TCPDF();
        $pdf->SetCreator('TinkerPro Inc.');
        $pdf->SetAuthor('TinkerPro Inc.');
        $pdf->SetTitle('Print Count Sheet');
        $pdf->SetSubject('Print Count Sheet Document');
        $pdf->SetKeywords('TCPDF, PDF, product, table');

        $pdf->AddPage();

        $pdf->SetCellHeightRatio(1.5);
        $imageFile = '../assets/img/tinkerpro-logo-dark.png';
        $imageWidth = 45;
        $imageHeight = 15;
        $imageX = 10;
        $pdf->Image($imageFile, $imageX, $y = 10, $w = $imageWidth, $h = $imageHeight, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);
        $pdf->SetFont('', 'I', 8);

        $pdf->SetFont('', 'B', 10);
        $pdf->Cell(0, 10, 'INVENTORY COUNT SHEET', 0, 1, 'R', 0);
        $pdf->Ln(-5);
        $pdf->SetFont('', 10);
        $pdf->Cell(0, 10, "{$shop['shop_name']}", 0, 1, 'R', 0);
        $pdf->Ln(-3);

        $pdf->SetFont('', 'I', 10); 
        $pdf->MultiCell(0, 10, "{$shop['shop_address']}", 0, 'R');
        $pdf->Ln(-6);

        $pdf->SetFont('', 'I', 10);
        $pdf->Cell(0, 10, "Reference No: {$items_info['reference_no']}", 0, 1, 'L', 0);
        $pdf->SetFont('', 10);
        $pdf->Ln(-6);
        $date = new DateTime($items_info['date_counted']);
        $pdf->Cell(50, 10, "Date Counted: ", 0, 0, 'L', 0);
        $pdf->Cell(0, 10, $date->format('F j, Y'), 0, 1, 'R', 0);
        $pdf->Ln(2);


        $header = array('No.', 'ITEM DESCRIPTION', 'QTY', 'COUNTED', 'DIFFERENCE');
        $headerWidths = array(15, 70, 35, 35, 35);
        $maxCellHeight = 5;

        $hexColor = '#808080';
        list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

        $pdf->SetFillColor($r, $g, $b);

        $pdf->SetFont('', 'B', 10);
        for ($i = 0; $i < count($header); $i++) {
            $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'L', true);
        }
        $pdf->Ln();
        $counter = 1;
        foreach ($items_data as $item) {
            $pdf->Cell($headerWidths[0], $maxCellHeight, $counter, 1, 0, 'C');
            $pdf->SetFont('', '', autoAdjustFontSize($pdf, $counter, $headerWidths[1]));
            if (isset($item['prod_desc'])) {
                $pdf->Cell($headerWidths[1], $maxCellHeight, $item['prod_desc'], 1, 0, 'L');
            } else {
                $pdf->Cell($headerWidths[1], $maxCellHeight, '', 1, 0, 'L');
            }
            $pdf->SetFont('', '', autoAdjustFontSize($pdf, isset($item['prod_desc']) ? $item['prod_desc'] : '', $headerWidths[2]));
            if (isset($item['counted_qty'])) {
                $pdf->Cell($headerWidths[2], $maxCellHeight, $item['counted_qty'], 1, 0, 'C');
            } else {
                $pdf->Cell($headerWidths[2], $maxCellHeight, '', 1, 0, 'C');
            }
            $pdf->SetFont('', '', autoAdjustFontSize($pdf, isset($item['counted_qty']) ? $item['counted_qty'] : '', $headerWidths[3]));
            if (isset($item['counted'])) {
                $pdf->Cell($headerWidths[3], $maxCellHeight, $item['counted'], 1, 0, 'C');
            } else {
                $pdf->Cell($headerWidths[3], $maxCellHeight, '', 1, 0, 'C');
            }
            $pdf->SetFont('', '', autoAdjustFontSize($pdf, isset($item['counted']) ? $item['counted'] : '', $headerWidths[4]));
            if (isset($item['difference'])) {
                $difference = $item['difference'] > 0 ? "+".$item['difference'] : $item['difference'];
                $pdf->Cell($headerWidths[4], $maxCellHeight, $difference, 1, 0, 'C');
            } else {
                $pdf->Cell($headerWidths[4], $maxCellHeight, '', 1, 0, 'C');
            }
          
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
        $connector = new WindowsPrintConnector("XP_80C");
        $printer = new Printer($connector);
        $printer->text("Hello, Thermal Printer!\n");

        
        $pdf->Output('inventory_list.pdf', 'I');
        $pdfPath = __DIR__ . '/assets/pdf/inventory/inventory_list.pdf';

        if (file_exists($pdfPath)) {

            unlink($pdfPath);
        }
        $pdf->Output($pdfPath, 'F');
    }

} catch (Exception $e) {
    echo "Print failed: " . $e->getMessage();
}
