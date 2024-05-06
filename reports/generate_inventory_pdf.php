<?php
require_once ('vendor/autoload.php');
include('../utils/db/connector.php');
include('../utils/models/user-facade.php');
include('../utils/models/product-facade.php');
include('../utils/models/inventory-facade.php');
include('../utils/models/order-facade.php');
include('../utils/models/loss_and_damage-facade.php');
include('../utils/models/supplier-facade.php');
include('../utils/models/inventorycount-facade.php');


function autoAdjustFontSize($pdf, $text, $maxWidth, $initialFontSize = 10)
{
    $pdf->SetFont('dejavusans', '', $initialFontSize);
    while ($pdf->GetStringWidth($text) > $maxWidth) {
        $initialFontSize--;
        $pdf->SetFont('', '', $initialFontSize);
    }
    return $initialFontSize;
}

$products = new ProductFacade();
$inventory = new InventoryFacade();
$orders = new OrderFacade();

$counter = 1;

$active_id = $_GET['active_type'] ?? null;

$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);


$pdf = new TCPDF();
$pdf->SetCreator('TinkerPro Inc.');
$pdf->SetAuthor('TinkerPro Inc.');
$pdf->SetTitle('Inventory Table PDF');
$pdf->SetSubject('Inventory Table PDF Document');
$pdf->SetKeywords('TCPDF, PDF, product, table');

$pdf->AddPage();


$pdf->SetCellHeightRatio(1.5);
$imageFile = '../assets/img/tinkerpro-logo-dark.png';
$imageWidth = 45;
$imageHeight = 15;
$imageX = 10; // Adjust this value to your desired left margin
$pdf->Image($imageFile, $imageX, $y = 10, $w = $imageWidth, $h = $imageHeight, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);
$pdf->SetFont('', 'I', 8);




switch($active_id)
{
    case "tbl_products":
        $pdf->SetFont('', 'B', 10);
        $pdf->Cell(0, 10, 'INVENTORIES', 0, 1, 'R', 0);
        $pdf->Ln(-5);
        $pdf->SetFont('', 10);
        $pdf->Cell(0, 10, "{$shop['shop_name']}", 0, 1, 'R', 0);

        $pdf->Ln(-3);
        $pdf->SetFont('', 'I', 10); // Bold, size 10
        $pdf->MultiCell(0, 10, "{$shop['shop_address']}", 0, 'R');
        $pdf->Ln(-9);
        $pdf->SetFont('', 'I', 8); // Italic, size 8
        $pdf->MultiCell(0, 10, "Contact: {$shop['contact_number']}", 0, 'L');
        $pdf->SetFont('', 8);
        $pdf->Ln(-9);
        $current_date = date('F j, Y');
        $pdf->Cell(0, 10, "Date: $current_date", 0, 'L');
        $pdf->Ln(-2);

        $items = $inventory->get_allInventories();
        $header = array('No.', 'Product Name', 'Barcode', 'UOM', 'Qty in Store', 'Amt. Before Tax', 'Amt. After Tax', 'Is Paid');
        $headerWidths = array(7, 50, 35, 25, 20, 20, 20, 15);
        $maxCellHeight = 5;
        
        $hexColor = '#FF6900';
        list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");
        
        $pdf->SetFillColor($r, $g, $b);
        
        $pdf->SetFont('', 'B', 10);
        for ($i = 0; $i < count($header); $i++) {
            $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'L', true);
        }
        $pdf->Ln();
        
        $pdf->SetFont('', '', 10);
        $totalCost = 0;
        $totalSellingPrice = 0;
        $totalTax = 0;
        $formatted_tax = 0;
        foreach ($items as $item) {

            $amountBeforeTaxFormatted = '₱' . number_format($item['amount_beforeTax'], 2);
            $amountAfterTaxFormatted = '₱' . number_format($item['amount_afterTax'], 2);

            $pdf->Cell($headerWidths[0], $maxCellHeight, $counter, 1, 0, 'C');
            $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['id'], $headerWidths[1]));
            $pdf->Cell($headerWidths[1], $maxCellHeight, $item['prod_desc'], 1, 0, 'L');
            $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['prod_desc'], $headerWidths[2]));
            $pdf->Cell($headerWidths[2], $maxCellHeight, $item['barcode'], 1, 0, 'L');
            $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['barcode'], $headerWidths[3]));
            $pdf->Cell($headerWidths[3], $maxCellHeight, $item['uom_name'], 1, 0, 'L');
            $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['uom_name'], $headerWidths[4]));
            $pdf->Cell($headerWidths[4], $maxCellHeight, $item['stock'], 1, 0, 'C');
            $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['stock'], $headerWidths[5]));
            $pdf->Cell($headerWidths[5], $maxCellHeight, $amountBeforeTaxFormatted, 1, 0, 'R');
            $pdf->SetFont('', '', autoAdjustFontSize($pdf, $amountBeforeTaxFormatted, $headerWidths[6]));
            $pdf->Cell($headerWidths[6], $maxCellHeight, $amountAfterTaxFormatted, 1, 0, 'R');
            $pdf->SetFont('', '', autoAdjustFontSize($pdf, $amountAfterTaxFormatted, $headerWidths[7]));
            $pdf->Cell($headerWidths[7], $maxCellHeight, $item['isPaid'] == 1 ? "Yes" : "No", 1, 0, 'C');
            $pdf->Ln(); 
            $counter++;
        }
        
        break;
    case 'tbl_orders':
        $pdf->SetFont('', 'B', 10);
        $pdf->Cell(0, 10, 'PURCHASE ORDERS', 0, 1, 'R', 0);
        $pdf->Ln(-5);
        $pdf->SetFont('', 10);
        $pdf->Cell(0, 10, "{$shop['shop_name']}", 0, 1, 'R', 0);

        $pdf->Ln(-3);
        $pdf->SetFont('', 'I', 10); // Bold, size 10
        $pdf->MultiCell(0, 10, "{$shop['shop_address']}", 0, 'R');
        $pdf->Ln(-9);
        $pdf->SetFont('', 'I', 8); // Italic, size 8
        $pdf->MultiCell(0, 10, "Contact: {$shop['contact_number']}", 0, 'L');
        $pdf->SetFont('', 8);
        $pdf->Ln(-9);
        $current_date = date('F j, Y');
        $pdf->Cell(0, 10, "Date: $current_date", 0, 'L');
        $pdf->Ln(-2);

        $items = $orders->get_allPurchaseOrders();
        $header = array('No.','PO#', 'Supplier', 'Date Purchased', 'Total', 'Is Paid');
        $headerWidths = array(10, 35, 50, 35, 35, 25);
        $maxCellHeight = 5;
        
        $hexColor = '#FF6900';
        list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");
        
        $pdf->SetFillColor($r, $g, $b);
        
        $pdf->SetFont('', 'B', 10);
        for ($i = 0; $i < count($header); $i++) {
            $pdf->Cell($headerWidths[$i], $maxCellHeight, $header[$i], 1, 0, 'L', true);
        }
        $pdf->Ln();
        
        foreach ($items as $item) {
            $total = '₱' . number_format($item['totalPrice'], 2);
            $originalDate = $item['date_purchased'];
            $date_purchased = date("M d, Y", strtotime($originalDate));

            $pdf->Cell($headerWidths[0], $maxCellHeight, $counter, 1, 0, 'L');
            $pdf->SetFont('', '', autoAdjustFontSize($pdf, $counter, $headerWidths[0]));
            $pdf->Cell($headerWidths[1], $maxCellHeight, $item['po_number'], 1, 0, 'L');
            $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['po_number'], $headerWidths[1]));
            $pdf->Cell($headerWidths[2], $maxCellHeight, $item['supplier'], 1, 0, 'L');
            $pdf->SetFont('', '', autoAdjustFontSize($pdf, $item['supplier'], $headerWidths[2]));
            $pdf->Cell($headerWidths[3], $maxCellHeight, $date_purchased, 1, 0, 'C');
            $pdf->SetFont('', '', autoAdjustFontSize($pdf, $date_purchased, $headerWidths[3]));
            $pdf->Cell($headerWidths[4], $maxCellHeight, $total, 1, 0, 'R');
            $pdf->SetFont('', '', autoAdjustFontSize($pdf, $total, $headerWidths[4]));
            $pdf->Cell($headerWidths[5], $maxCellHeight, $item['isPaid'] == 1 ? "Yes" : "No", 1, 0, 'C');
            $pdf->Ln(); 
            $counter++;
        }
        
        break;
    default:
        break;
}




// $pdf->SetFont('', 'B', 10);
// $pdf->Cell($headerWidths[0] + $headerWidths[1] + $headerWidths[2] + $headerWidths[3] + $headerWidths[4], $maxCellHeight, 'Total', 1, 0, 'C');
// $pdf->Cell($headerWidths[5], $maxCellHeight, number_format($totalCost, 2), 1, 0, 'L');
// $pdf->Cell($headerWidths[6], $maxCellHeight, number_format($totalSellingPrice, 2), 1, 0, 'L');
// $pdf->Cell($headerWidths[7], $maxCellHeight, number_format($totalTax, 2), 1, 0, 'L');
// $pdf->Ln();


$pdf->Output('inventory_list.pdf', 'I');
$pdfPath = __DIR__ . '/assets/pdf/inventory/inventory_list.pdf';

if (file_exists($pdfPath)) {

    unlink($pdfPath);
}
$pdf->Output($pdfPath, 'F');
?>