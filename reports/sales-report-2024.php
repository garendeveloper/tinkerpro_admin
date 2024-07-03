<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/product-facade.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$fetchShop = $products->getShopDetails();

$sheet->mergeCells('A12:AF12');
$sheet->mergeCells('A13:A15');
$sheet->mergeCells('B13:B15');
$sheet->mergeCells('C13:C15');
$sheet->mergeCells('D13:D15');
$sheet->mergeCells('E13:E15');
$sheet->mergeCells('F13:F15');
$sheet->mergeCells('G13:G15');
$sheet->mergeCells('H13:H15');
$sheet->mergeCells('I13:I15');
$sheet->mergeCells('J13:J15');
$sheet->mergeCells('K13:K15');

$sheet->mergeCells('L13:S13');
$sheet->mergeCells('L14:P14');
$sheet->mergeCells('Q14:Q15');
$sheet->mergeCells('R14:R15');
$sheet->mergeCells('S14:S15');

$sheet->mergeCells('T13:Y13');
$sheet->mergeCells('T14:V14');
$sheet->mergeCells('W14:W15');
$sheet->mergeCells('X14:X15');
$sheet->mergeCells('Y14:Y15');

$sheet->mergeCells('Z13:Z15');
$sheet->mergeCells('AA13:AA15');
$sheet->mergeCells('AB13:AB15');
$sheet->mergeCells('AC13:AC15');
$sheet->mergeCells('AD13:AD15');
$sheet->mergeCells('AE13:AE15');
$sheet->mergeCells('AF13:AF15');


$sheet->setCellValue('A12', 'BIR SALES SUMMARY  REPORT');
$sheet->setCellValue('A13', 'Date');
$sheet->setCellValue('B13', 'Beginning SI/OR No.');
$sheet->setCellValue('C13', 'Ending SI/OR No.');
$sheet->setCellValue('D13', 'Grand Accum. Sales Ending Balance');
$sheet->setCellValue('E13', 'Grand Accum. Beg.Balance');
$sheet->setCellValue('F13', 'Sales Issued w/ Manual SI/OR (per RR 16-2018)');
$sheet->setCellValue('G13', 'Gross Sales for the Day');
$sheet->setCellValue('H13', 'VATable Sales');
$sheet->setCellValue('I13', 'VAT Amount');
$sheet->setCellValue('J13', 'VAT-Exempt Sales');
$sheet->setCellValue('K13', 'Zero-Rated Sales');

$sheet->setCellValue('L13', 'Deductions');
$sheet->setCellValue('L14', 'Discount');
$sheet->setCellValue('L15', 'SC');
$sheet->setCellValue('M15', 'PWD');
$sheet->setCellValue('N15', 'NAAC');
$sheet->setCellValue('O15', 'Solo Parent');
$sheet->setCellValue('P15', 'Others');
$sheet->setCellValue('Q14', 'Returns');
$sheet->setCellValue('R14', 'Voids');
$sheet->setCellValue('S14', 'Total Deductions');

$sheet->setCellValue('T13', 'Adjustment on VAT');
$sheet->setCellValue('T14', 'Discount');
$sheet->setCellValue('T15', 'SC');
$sheet->setCellValue('U15', 'PWD');
$sheet->setCellValue('V15', 'Others');
$sheet->setCellValue('W14', 'Vat on Returns');
$sheet->setCellValue('X14', 'Others');
$sheet->setCellValue('Y14', 'Total Vat Adjustment');

$sheet->setCellValue('Z13', 'VAT Payable');
$sheet->setCellValue('AA13', 'Net Sales');
$sheet->setCellValue('AB13', 'Sales Overrun /Overflow');
$sheet->setCellValue('AC13', 'Total Income');
$sheet->setCellValue('AD13', 'Reset Counter');
$sheet->setCellValue('AE13', 'Z-Counter');
$sheet->setCellValue('AF13', 'Remarks');

$headerStyleAtoC = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'A6A6A6'] 
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        'wrapText' => true, 
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];
$headerStyleDtoG = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '00B0F0'] 
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        'wrapText' => true, 
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];

$headerStyleHtoK = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'FFFF00'] 
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        'wrapText' => true, 
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];
$headerStyleLtoS = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'FFC000'] 
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        'wrapText' => true, 
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];
$headerStyleTtoY = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '92D050'] 
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        'wrapText' => true, 
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];
$headerStyleZtoAF = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'A6A6A6'] 
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        'wrapText' => true, 
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];
$headerStyle = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        
    ],
    'font' => [
        'bold' => true,
        'size' => 12, 
        
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        'wrapText' => true,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
        ],
    ],
];

$sheet->getStyle('A13:C15')->applyFromArray($headerStyleAtoC);
$sheet->getStyle('D13:G15')->applyFromArray($headerStyleDtoG);
$sheet->getStyle('H13:K15')->applyFromArray($headerStyleHtoK);
$sheet->getStyle('L13:S15')->applyFromArray($headerStyleLtoS);
$sheet->getStyle('T13:Y15')->applyFromArray($headerStyleTtoY);
$sheet->getStyle('Z13:AF15')->applyFromArray($headerStyleZtoAF);
$sheet->getStyle('A12:AF12')->applyFromArray($headerStyle);
$products = new ProductFacade();

$searchQuery = $_GET['searchQuery'] ?? null;
$selectedProduct = $_GET['selectedProduct'] ?? null;
$selectedCategories = $_GET['selectedCategories'] ?? null;
$selectedSubCategories = $_GET['selectedSubCategories'] ?? null;
$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

$count = $products->getTotalProductsCount();

$recordsPerPage = $count;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;


$fetchProducts = $products->fetchProducts($searchQuery, $selectedProduct, $singleDateData, $startDate, $endDate, $selectedCategories, $selectedSubCategories, $offset, $recordsPerPage);
$counter = 1; 

while ($row = $fetchProducts->fetch(PDO::FETCH_ASSOC)) {
 
}


foreach (range('A', 'K') as $column) {
    $sheet->getColumnDimension($column)->setWidth(17);
}


$dataStyle = [
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        'wrapText' => true,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];
$lastRow = $sheet->getHighestRow();
$sheet->getStyle('A16:K' . $lastRow)->applyFromArray($dataStyle);

// Save the Excel file
$writer = new Xlsx($spreadsheet);
$writer->save('sales-report.xlsx'); // Save the file with a given filename

// Force the download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="sales-report.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
?>
