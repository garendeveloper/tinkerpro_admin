<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/utils/db/connector.php');
include(__DIR__ . '/utils/models/user-facade.php');

use TCPDF;

function autoAdjustFontSize($pdf, $text, $maxWidth, $initialFontSize = 10) {
    $pdf->SetFont('', '', $initialFontSize);
    while ($pdf->GetStringWidth($text) > $maxWidth) {
        $initialFontSize--;
        $pdf->SetFont('', '', $initialFontSize);
    }
    return $initialFontSize;
}

$userFacade = new UserFacade();

$counter = 1;
$searchQuery = $_GET['searchQuery'] ?? null;
$value = $_GET['selectedValue'] ?? null; 
$fetchUser = $userFacade->fetchUsers($value,$searchQuery);


$pdf = new TCPDF();
$pdf->SetCreator('TinkerPro Inc.');
$pdf->SetAuthor('TinkerPro Inc.');
$pdf->SetTitle('User Table PDF');
$pdf->SetSubject('Users Table PDF Document');
$pdf->SetKeywords('TCPDF, PDF, employee, table');

$pdf->AddPage();

// Adjust cell height ratio
$pdf->SetCellHeightRatio(1.5); // Adjust the value as per your requirement

$imageFile = './assets/img/tinkerPro.png'; 
$imageWidth = 20; 
$imageHeight = 0; 
$imageX = ($pdf->GetPageWidth() - $imageWidth) / 2; 
$pdf->Image($imageFile, $imageX, $y = 10, $w = $imageWidth, $h = $imageHeight, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);
$pdf->Ln(20);

$pdf->SetFont('', 'B', 25);
$pdf->Cell(0, 10, 'TinkerPro Inc.', 0, 1, 'C', 0); 
$pdf->Ln(-4);
$pdf->SetFont('', 'B', 16);
$pdf->Cell(0, 10, 'User List Report', 0, 1, 'C', 0); 
$pdf->Ln(5);


$header = array('No.', 'Name', 'Role', 'Identification', 'Employee Number', 'Date Hired', 'Status');
$headerWidths = array(10, 50, 25, 25, 35, 25, 20);
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
while ($row = $fetchUser->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell($headerWidths[0], $maxCellHeight, $counter, 1, 0, 'C');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['first_name'] . ' ' . $row['last_name'], $headerWidths[1]));
    $pdf->Cell($headerWidths[1], $maxCellHeight, $row['first_name'] . ' ' . $row['last_name'], 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['role_name'], $headerWidths[2]));
    $pdf->Cell($headerWidths[2], $maxCellHeight, $row['role_name'], 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['identification'], $headerWidths[3]));
    $pdf->Cell($headerWidths[3], $maxCellHeight, $row['identification'], 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['employeeNum'], $headerWidths[4]));
    $pdf->Cell($headerWidths[4], $maxCellHeight, $row['employeeNum'], 1, 0, 'L');
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['dateHired'] !== null ? date('M j, Y', strtotime($row['dateHired'])) : '', $headerWidths[5]));
    $pdf->Cell($headerWidths[5], $maxCellHeight, $row['dateHired'] !== null ? date('M j, Y', strtotime($row['dateHired'])) : '', 1, 0, 'L');    
    $pdf->SetFont('', '', autoAdjustFontSize($pdf, $row['status'], $headerWidths[6]));
    $pdf->Cell($headerWidths[6], $maxCellHeight, $row['status'], 1, 0, 'L');
    $pdf->Ln(); // Move to next line
    $counter++;
}

$pdf->Output('usersList.pdf', 'I');
?>
