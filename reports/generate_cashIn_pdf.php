<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');

$pdfFolder = __DIR__ . '/../assets/pdf/entries/';

$files = glob($pdfFolder . '*'); 
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file); 
    }
}

function autoAdjustFontSize($pdf, $text, $maxWidth, $initialFontSize = 10) {
    $pdf->SetFont('', '', $initialFontSize);
    while ($pdf->GetStringWidth($text) > $maxWidth) {
        $initialFontSize--;
        $pdf->SetFont('', '', $initialFontSize);
    }
    return $initialFontSize;
}

$refundFacade = new OtherReportsFacade();
$products = new ProductFacade();

$counter = 1;
$entries = $_GET['entries'] ?? null;
$userId = $_GET['userId'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

if((empty($startDate) && empty($endDate)) && !empty($singleDateData))
{
    $startDate = $singleDateData;
    $endDate = $singleDateData;
}
if((empty($startDate) && empty($endDate)) && empty($singleDateData))
{
    $startDate = date('Y-m-d');
    $endDate = date('Y-m-d');
}

$fetchRefund= $refundFacade->cashInAmountsData($userId,$startDate,$endDate,$entries);
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);


$pdf = new TCPDF();
$pdf->SetCreator('TinkerPro Inc.');
$pdf->SetAuthor('TinkerPro Inc.');
$pdf->SetTitle('Cash In and Out Entries PDF');
$pdf->SetSubject('Cash In and Out Entries PDF Document');
$pdf->SetKeywords('TCPDF, PDF, Cash In and Out Entries, table');

$pdf->AddPage();


$pdf->SetCellHeightRatio(1.5);
$imageFile = './../assets/img/tinkerpro-logo-dark.png'; 
$imageWidth = 45; 
$imageHeight = 15; 
$imageX = 10; 
$pdf->Image($imageFile, $imageX, $y = 10, $w = $imageWidth, $h = $imageHeight, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);
$pdf->SetFont('', 'I', 8);



$pdf->SetFont('', 'B', 10);
if($entries == "in"){
    $pdf->Cell(0, 10, 'Cash In Entries', 0, 1, 'R', 0); 
}else{
    $pdf->Cell(0, 10, 'Cash Out Entries', 0, 1, 'R', 0); 
}
$pdf->Ln(-5);
$pdf->SetFont('',  10);
$pdf->Cell(0, 10, "{$shop['shop_name']}", 0, 1, 'R', 0); 

$pdf->Ln(-3);
$pdf->SetFont('', '', 10); 
$pdf->MultiCell(0, 10, "{$shop['shop_address']}", 0, 'R');
$pdf->Ln(-6);
$pdf->SetFont('', '', 10); 
$pdf->MultiCell(0, 10, "{$shop['shop_email']}", 0, 'R');
$pdf->Ln(-12);
$pdf->SetFont('', '', 8); 
$pdf->MultiCell(0, 10, "Contact: {$shop['contact_number']}", 0, 'L');

$pdf->Ln(-3);
$pdf->SetFont('' , 10); 
$pdf->MultiCell(0, 10, "VAT REG TIN: {$shop['tin']}", 0, 'R');
$pdf->Ln(-6);
$pdf->SetFont('' , 8); 
$pdf->MultiCell(0, 10, "MIN: {$shop['min']}", 0, 'L');
$pdf->Ln(-6);
$pdf->SetFont('' , 8); 
$pdf->MultiCell(0, 10, "S/N: {$shop['series_num']}", 0, 'L');
$pdf->SetFont('' , 8); 
$pdf->Ln(-9);
$current_date = date('F j, Y');
$pdf->Cell(0, 10, "Date: $current_date", 0, 'L');
$pdf->Ln(-3);
if ($singleDateData && !$startDate && !$endDate) {
    $formattedDate = date('M j, Y', strtotime($singleDateData));
    $pdf->SetFont('', '', 11); 
    $pdf->Cell(0, 10, "Period: $formattedDate", 0, 'L');
} else if (!$singleDateData && $startDate && $endDate) {
    $formattedStartDate = date('M j, Y', strtotime($startDate));
    $formattedEndDate = date('M j, Y', strtotime($endDate));
    $pdf->SetFont('', '', 11); 
    $pdf->Cell(0, 10, "Period: $formattedStartDate - $formattedEndDate", 0, 'L');
} else {
    $otherFacade = new OtherReportsFacade;
    $others =    $otherFacade->getDatePayments();
    $dates = [];
    while ($row = $others->fetch(PDO::FETCH_ASSOC)) {
        $dates[] = $row['date'];
    }
    
    if (!empty($dates)) {
        $startDate = min($dates);
        $endDate = max($dates);
    
      
        $formattedStartDate = date('M j, Y', strtotime($startDate));
        $formattedEndDate = date('M j, Y', strtotime($endDate));
        $pdf->SetFont('', '', 11); 
        $pdf->Cell(0, 10, "Period: $formattedStartDate - $formattedEndDate", 0, 'L');
    } 
}

$pdf->SetDrawColor(192, 192, 192); 
$pdf->SetLineWidth(0.3); 


$groupedData = [];
$totalDiscount = 0;
$grandTotal = 0;
$hasData = $fetchRefund->rowCount() > 0;
if($hasData)
{
    if($entries === "all")
    {
        $data = $fetchRefund->fetchAll(PDO::FETCH_ASSOC);
        $totalAmount = 0;
        $pdf->SetDrawColor(192, 192, 192); 
        $pdf->SetLineWidth(0.3); 
        $header = array('No.', 'Cash Type', 'User', 'Description', 'Date', 'Total');
        $headerWidths = array(20, 20, 30, 50, 40, 30);
        $maxCellHeight = 5; 
    
        $hexColor = '#F5F5F5';
        list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");
        
        $pdf->SetFillColor($r, $g, $b);
        
        $pdf->SetFont('', 'B', 9);
        foreach ($header as $i => $headerItem) {
            $pdf->Cell($headerWidths[$i], $maxCellHeight, $headerItem, 1, 0, 'C', true);
        }  
        $pdf->Ln();
    
        $counter = 1;
        $pdf->SetFont('', '', 8);
        foreach ($data as $row) 
        {
            $amount = $row['cashType'] == 1 ? $row['cash_out_amount'] : $row['cash_in_amount'];
            $formattedDate = date('d F Y h:i A', strtotime($row['date']));
            $pdf->Cell($headerWidths[0], $maxCellHeight, $counter, 1, 0, 'C');
            $pdf->Cell($headerWidths[1], $maxCellHeight, $row['cashType'] == 1 ? "In" : "Out", 1, 0, 'C');
            $pdf->Cell($headerWidths[2], $maxCellHeight, $row['first_name']." ".$row['last_name'], 1, 0, 'L');
            $pdf->Cell($headerWidths[3], $maxCellHeight, $row['reason_note'], 1, 0, 'L');
            $pdf->Cell($headerWidths[4], $maxCellHeight, $formattedDate, 1, 0, 'C');
            $pdf->Cell($headerWidths[5], $maxCellHeight, number_format($amount, 2), 1, 0, 'R');
            $totalAmount += $amount; 
            $pdf->Ln(); 
            $counter++;
        }
       
        $pdf->SetFont('', 'B', 9); 
        $pdf->Cell($headerWidths[0] + $headerWidths[1], $maxCellHeight, 'Total', 1, 0, 'C'); 
        $pdf->Cell( $headerWidths[2] + $headerWidths[3] + $headerWidths[4] + $headerWidths[5] , $maxCellHeight, number_format( $totalAmount, 2), 1, 0, 'R');
    }
    else
    {
        while ($row = $fetchRefund->fetch(PDO::FETCH_ASSOC)) 
        {
            $lastName = $row['last_name'];
            $firstName = $row['first_name'];
            $grandTotal += $row['amount'];
            if (!isset($groupedData[$lastName])) {
                $groupedData[$lastName] = [];
            }
            $groupedData[$lastName][] = $row;
        }
        
        foreach ($groupedData as $lastName => $userData) 
        {
            $totalDiscount = 0;
            $pdf->SetFont('', 'B', 10);
            $pdf->Cell(0, 10, 'User Name: ' . $firstName . ' ' . $lastName, 0, 1, 'L', 0);
            $pdf->Ln(-2); 
            $pdf->SetDrawColor(192, 192, 192); 
            $pdf->SetLineWidth(0.3); 
            $header = array('No.', 'Date', 'Note', 'Amount',);
            $headerWidths = array(10, 60, 60, 60);
            $maxCellHeight = 5; 
        
            $hexColor = '#F5F5F5';
            list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");
            
            $pdf->SetFillColor($r, $g, $b);
            
            $pdf->SetFont('', 'B', 10);
            foreach ($header as $i => $headerItem) {
                $pdf->Cell($headerWidths[$i], $maxCellHeight, $headerItem, 1, 0, 'C', true);
            }  
            $pdf->Ln();
        
            $counter = 1;
            foreach ($userData as $row) 
            {
                $amount = $row['cashType'] == 1 ? $row['cash_out_amount'] : $row['cash_in_amount'];
                $pdf->SetFont('', '', 8);
                $pdf->Cell($headerWidths[0], $maxCellHeight, $counter, 1, 0, 'C');
                $formattedDate = date('M d, Y', strtotime($row['date']));
                $pdf->Cell($headerWidths[1], $maxCellHeight, $formattedDate, 1, 0, 'C');
                $pdf->Cell($headerWidths[2], $maxCellHeight, $row['reason_note'], 1, 0, 'C');
                $pdf->Cell($headerWidths[3], $maxCellHeight, number_format($amount, 2), 1, 0, 'R');
                $totalDiscount += $amount; 
                $pdf->Ln(); 
                $counter++;
            }
           
            $pdf->SetFont('', 'B', 9); 
            $pdf->Cell($headerWidths[0] + $headerWidths[1], $maxCellHeight, 'Total', 1, 0, 'C'); 
            $pdf->Cell( $headerWidths[2] + $headerWidths[3] , $maxCellHeight, number_format( $totalDiscount, 2), 1, 0, 'R');
            $pdf->Ln(15); 
            $pdf->Cell($headerWidths[0] + $headerWidths[1], $maxCellHeight, 'Overall Total', 1, 0, 'C'); 
            $pdf->Cell( $headerWidths[2] + $headerWidths[3] , $maxCellHeight, number_format($grandTotal , 2), 1, 0, 'R'); 
            $pdf->Ln();
        }
    }
}
else
{
    $pdf->SetFont('', 'B', 9);
    $pdf->Cell(0, 10, 'User Name: ---', 0, 1, 'L', 0);
    $pdf->Ln(-2); 
    $pdf->SetDrawColor(192, 192, 192); 
    $pdf->SetLineWidth(0.3); 
    $header = array('No.', 'Date', 'Note', 'Amount',);
    $headerWidths = array(10, 60, 60, 60);
    $maxCellHeight = 5; 

    $hexColor = '#F5F5F5';
    list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");
    
    $pdf->SetFillColor($r, $g, $b);
    
    $pdf->SetFont('', 'B', 10);
    foreach ($header as $i => $headerItem) {
        $pdf->Cell($headerWidths[$i], $maxCellHeight, $headerItem, 1, 0, 'C', true);
    }  
    $pdf->Ln();

    $pdf->SetFont('', '', 10);
    $mergedWidth = array_sum($headerWidths);
    $cellHeight = $maxCellHeight;
    $mergedContent = 'No available data.';
    $pdf->MultiCell($mergedWidth, $cellHeight, $mergedContent, 1, 'C');
    $pdf->SetXY($pdf->GetX() + $mergedWidth, $pdf->GetY());
}
$pdfPath = $pdfFolder . 'cashEntriesList.pdf';
$pdf->Output($pdfPath, 'F');

$pdf->Output('cashEntriesList.pdf', 'I');

?>
