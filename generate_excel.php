<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/utils/db/connector.php');
include(__DIR__ . '/utils/models/user-facade.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();


$sheet->setCellValue('G5', 'USER LIST REPORT');
$sheet->setCellValue('D7', 'No.');
$sheet->setCellValue('E7', 'Name');
$sheet->setCellValue('F7', 'Role');
$sheet->setCellValue('G7', 'Identification');
$sheet->setCellValue('H7', 'Employee Number');
$sheet->setCellValue('I7', 'Date Hired');
$sheet->setCellValue('J7', 'Status');


$headerStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF6900']],
];
$sheet->getStyle('D7:J7')->applyFromArray($headerStyle);

$textStyle = [
    'font' => ['bold' => true],
    'size' => 18,
];

$sheet->getStyle('G5')->applyFromArray($textStyle);

$userFacade = new UserFacade();
$value = $_GET['selectedValue'] ?? null; 
$searchQuery = $_GET['searchQuery'] ?? null;
$fetchUser = $userFacade->fetchUsers($value,$searchQuery);
$counter = 8; 


while ($row = $fetchUser->fetch(PDO::FETCH_ASSOC)) {
    $sheet->setCellValue('D' . $counter, $counter - 7); // Incrementing counter for each row
    $sheet->setCellValue('E' . $counter, $row['first_name'] . ' ' . $row['last_name']);
    $sheet->setCellValue('F' . $counter, $row['role_name']);
    $sheet->setCellValue('G' . $counter, $row['identification']);
    $sheet->setCellValue('H' . $counter, $row['employeeNum']);
    $sheet->setCellValue('I' . $counter, $row['dateHired']);
    $sheet->setCellValue('J' . $counter, $row['status']);
    $counter++;
}

foreach (range('D', 'J') as $column) {
    $sheet->getColumnDimension($column)->setAutoSize(true);
}

$lastRow = $sheet->getHighestRow();
$lastColumn = $sheet->getHighestColumn();
$range = 'D7:' . $lastColumn . $lastRow;
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
$sheet->getStyle('G5')->getAlignment()->setHorizontal( \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,);
// Save the Excel file
$writer = new Xlsx($spreadsheet);
$writer->save('usersList.xlsx'); // Save the file with a given filename

// Force the download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="usersList.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
?>
