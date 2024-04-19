<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/utils/db/connector.php');
include( __DIR__ . '/utils/models/ingredients-facade.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();



$sheet->setCellValue('A1', 'No.');
$sheet->setCellValue('B1', 'Ingredients');
$sheet->setCellValue('C1', 'Barcode');
$sheet->setCellValue('D1', 'UOM');
$sheet->setCellValue('E1', 'Cost');
$sheet->setCellValue('F1', 'Status');



$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF6900']],
];
$sheet->getStyle('A1:F1')->applyFromArray($headerStyle);



$ingredients = new IngredientsFacade();

$searchQuery = $_GET['searchQuery'] ?? null;
$selectedIngredients = $_GET['selectedIngredients'] ?? null;
// Fetch users with pagination
$fetchIngredients = $ingredients->getAllIngredients($searchQuery,$selectedIngredients);
$counter = 1; // Start numbering from 1

while ($row = $fetchIngredients->fetch(PDO::FETCH_ASSOC)) {
   
    $sheet->setCellValue('A' . ($counter + 1), $counter); 
    $sheet->setCellValue('B' . ($counter + 1), $row['name']);
    $sheet->setCellValue('C' . ($counter + 1), $row['barcode']); 
    $sheet->setCellValue('D' . ($counter + 1), $row['uom_name']); 
    $sheet->setCellValue('E' . ($counter + 1), $row['cost']); 
    $sheet->setCellValue('F' . ($counter + 1), $row['status']); 
   
    $counter++;
}

foreach (range('A', 'F') as $column) {
    $sheet->getColumnDimension($column)->setAutoSize(true);
}

$lastRow = $sheet->getHighestRow();
$lastColumn = $sheet->getHighestColumn();
$range = 'A1:' . $lastColumn . $lastRow;
$style = [
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];
$sheet->getStyle($range)->applyFromArray($style);

// Save the Excel file
$writer = new Xlsx($spreadsheet);
$writer->save('ingredientList.xlsx'); // Save the file with a given filename

// Force the download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ingredientList.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
?>
