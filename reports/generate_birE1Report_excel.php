<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');
include( __DIR__ . '/../utils/models/bir-facade.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

header('Access-Control-Allow-Origin: *'); // Replace * with specific domains as needed
header('Access-Control-Allow-Methods: GET');

session_start();
date_default_timezone_set('Asia/Manila');
$products = new ProductFacade();
$fetchShop = $products->getShopDetails();
$shop = $fetchShop->fetch(PDO::FETCH_ASSOC);
$birFacade = new BirFacade();

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

if((empty($singleDateData) && empty($startDate) && empty($endDate)) || (!empty($singleDateData) && empty($startDate) && empty($endDate)))
{
    $singleDateData = date('Y-m-d');
}
if($singleDateData !== null && ($startDate === null && $endDate === null))
{
    $startDate = $singleDateData;
    $endDate = $singleDateData;
}

$items = $birFacade->getAllZread( $startDate, $endDate);

$sheet->mergeCells('A1:AF1');
$sheet->mergeCells('A2:AF2');
$sheet->mergeCells('A3:AF3');

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

$hostname = gethostname();
$currentDateTime = date('F j, Y h:i:s A');
$user_id = $_SESSION['users_identification'] ?? null;

$sheet->setCellValue('A1', "{$shop['shop_name']}");
$sheet->setCellValue('A2', "{$shop['shop_address']}");
$sheet->setCellValue('A3', "{$shop['tin']}");
$sheet->setCellValue('A5', "Software: {$shop['pos_provided']}");
$sheet->setCellValue('A6', "Serial No: {$shop['series_num']}");
$sheet->setCellValue('A7', "Machine Name: {$hostname}");
$sheet->setCellValue('A8', "POS Terminal No: ");
$sheet->setCellValue('A9', "Date and Time Generated: {$currentDateTime}");
$sheet->setCellValue('A10', "User ID: {$user_id}");

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


$rowIndex = 16;
if($items)
{
    function formatValue($value) 
    {
        return ($value == 0 || empty($value)) ? '' : number_format($value, 2);
    }
    for($i = 0; $i<count($items); $i++)
    {
        $sheet->setCellValue('A' . $rowIndex, $items[$i]['dateRange']); 
        $sheet->setCellValue('B' . $rowIndex, $items[$i]['beginning_si']);
        $sheet->setCellValue('C' . $rowIndex, $items[$i]['end_si']); 
        $sheet->setCellValue('D' . $rowIndex, $items[$i]['grandEndAccumulated']); 
        $sheet->setCellValue('E' . $rowIndex, $items[$i]['grandBegAccumulated']);
        $sheet->setCellValue('F' . $rowIndex, $items[$i]['issued_si']); 
        $sheet->setCellValue('G' . $rowIndex, $items[$i]['grossSalesToday']);
        $sheet->setCellValue('H' . $rowIndex, formatValue($items[$i]['vatable_sales'])); 
        $sheet->setCellValue('I' . $rowIndex, formatValue($items[$i]['vatAmount'])); 
        $sheet->setCellValue('J' . $rowIndex, formatValue($items[$i]['vatExempt'])); 
        $sheet->setCellValue('K' . $rowIndex, formatValue($items[$i]['zero_rated'])); 
        $sheet->setCellValue('L' . $rowIndex, formatValue($items[$i]['sc_discount']));
        $sheet->setCellValue('M' . $rowIndex, formatValue($items[$i]['pwd_discount'])); 
        $sheet->setCellValue('N' . $rowIndex, formatValue($items[$i]['naac_discount'])); 
        $sheet->setCellValue('O' . $rowIndex, formatValue($items[$i]['solo_parent_discount'])); 
        $sheet->setCellValue('P' . $rowIndex, formatValue($items[$i]['other_discount'])); 
        $sheet->setCellValue('Q' . $rowIndex, formatValue($items[$i]['returned'])); 
        $sheet->setCellValue('R' . $rowIndex, formatValue($items[$i]['voids'])); 
        $sheet->setCellValue('S' . $rowIndex, formatValue($items[$i]['totalDeductions'])); 
        $sheet->setCellValue('T' . $rowIndex, formatValue(0)); 
        $sheet->setCellValue('U' . $rowIndex, formatValue(0)); 
        $sheet->setCellValue('V' . $rowIndex, formatValue(0)); 
        $sheet->setCellValue('W' . $rowIndex, formatValue($items[$i]['returnd_vat']));
        $sheet->setCellValue('X' . $rowIndex, formatValue($items[$i]['othersVatAdjustment'])); 
        $sheet->setCellValue('Y' . $rowIndex, formatValue($items[$i]['totalVatAjustment'])); 
        $sheet->setCellValue('Z' . $rowIndex, formatValue(0)); 
        $sheet->setCellValue('AA' . $rowIndex, formatValue($items[$i]['netSales'])); 
        $sheet->setCellValue('AB' . $rowIndex, formatValue(0)); 
        $sheet->setCellValue('AC' . $rowIndex, formatValue($items[$i]['totalIncome'])); 
        $sheet->setCellValue('AD' . $rowIndex, $items[$i]['resetCount']); 
        $sheet->setCellValue('AE' . $rowIndex, $items[$i]['z_counter']); 
        $sheet->setCellValue('AF' . $rowIndex, ''); 
        $rowIndex++;
    }
}



$headerStyleAtoAF = [
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        'wrapText' => true, 
    ]
];

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

$headerStyleData = [
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
$sheet->getStyle('A1:AF1')->applyFromArray($headerStyleAtoAF);
$sheet->getStyle('A2:AF2')->applyFromArray($headerStyleAtoAF);
$sheet->getStyle('A3:AF3')->applyFromArray($headerStyleAtoAF);
$sheet->getStyle('A12:AF12')->applyFromArray($headerStyle);
$sheet->getStyle('A'.$rowIndex.':AF'.$rowIndex)->applyFromArray($headerStyleData);


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
// $lastRow = $sheet->getHighestRow();
// $sheet->getStyle('A16:AF16' . $lastRow)->applyFromArray($dataStyle);

// Save the Excel file
$writer = new Xlsx($spreadsheet);
$writer->save('e1.xlsx'); // Save the file with a given filename

// Force the download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="e1.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');

// $excelFilePath  = __DIR__ . '/../assets/excel/e1.xlsx'; // Adjust path as needed
// $writer = new Xlsx($spreadsheet);
// $writer->save($excelFilePath); // Save the file with a given filename


// // Check if the file exists
// if (!file_exists($excelFilePath)) {
//     header("HTTP/1.0 404 Not Found");
//     die('File not found.');
// }

// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Disposition: inline; filename="e1.xlsx"'); // Use inline to display in browser
// header('Cache-Control: max-age=0');

// // Read the Excel file and output its contents
// readfile($excelFilePath);

// $excelFilePath = 'e1.xlsx'; // Adjust path as needed
// $writer = new Xlsx($spreadsheet);
// $writer->save($excelFilePath);

// if (!file_exists($excelFilePath)) {
//     header("HTTP/1.0 404 Not Found");
//     die('File not found.');
// }

// // Set headers to serve the Excel file inline
// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Disposition: inline; filename="e1.xlsx"'); // Use inline to display in browser
// header('Cache-Control: max-age=0');

// // Read the Excel file and output its contents
// $writer->save('php://output');
exit;
?>
