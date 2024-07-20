<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');
include( __DIR__ . '/../utils/models/bir-facade.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

header('Access-Control-Allow-Origin: *'); 
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

$items = $birFacade->E_reports(4, $startDate, $endDate);

$sheet->mergeCells('A1:J1');
$sheet->mergeCells('A2:J2');
$sheet->mergeCells('A3:J3');

$sheet->mergeCells('A12:J12');
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

$sheet->setCellValue('A12', 'Solo Parent Sales Book/Report');
$sheet->setCellValue('A13', 'Date');
$sheet->setCellValue('B13', 'SPIC No.');
$sheet->setCellValue('C13', 'Name of Solo Parent');
$sheet->setCellValue('D13', 'Name of child');
$sheet->setCellValue('E13', 'Birth Date of child');
$sheet->setCellValue('F13', 'Age of child');
$sheet->setCellValue('G13', 'SI / OR Number');
$sheet->setCellValue('H13', 'Gross Sales');
$sheet->setCellValue('I13', 'Discount');
$sheet->setCellValue('J13', 'Net Sales');
$rowIndex = 16;
if(count($items) > 0)
{
    foreach($items as $item)
    {
        $vat_amount = number_format(0.00, 2);
        $sales_vat = number_format(0.00, 2);
        $discount20percent = number_format(0.00, 2);
    
        $customerID = $item['customerID'] ?? '---';
        $customerTIN = $item['customerTIN'] ?? '---';
        $name = $item['first_name']." ".$item['last_name'];
        $child_name = $item['child_name'] ?? '---';
        $child_birth = $item['child_birth'] ?? '---';
        $child_age = $item['child_age'] ?? '---';
        $date_time_of_payment = $item['date_time_of_payment'];
        $date_time = new DateTime($date_time_of_payment);
        $current_date = $date_time->format('F j, Y');

        $sheet->setCellValue('A' . $rowIndex, $current_date); 
        $sheet->setCellValue('B' . $rowIndex, $name);
        $sheet->setCellValue('C' . $rowIndex, $customerID); 
        $sheet->setCellValue('D' . $rowIndex, $child_name); 
        $sheet->setCellValue('E' . $rowIndex, $child_birth);
        $sheet->setCellValue('F' . $rowIndex, $child_age); 
        $sheet->setCellValue('G' . $rowIndex, $item['barcode'],); 
        $sheet->setCellValue('H' . $rowIndex, number_format($item['totalAmount'], 2)); 
        $sheet->setCellValue('I' . $rowIndex, number_format($item['overAllDiscounts'], 2)); 
        $sheet->setCellValue('J' . $rowIndex, number_format($item['netSales'], 2));
    }
}
$headerStyle = [
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        'wrapText' => true, 
    ], 
];
$headerStyleData = [
    'alignment' => [
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
$headerStyleA = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'A6A6A6'] 
    ],
];
$headerStyleB = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'ED7D31'] 
    ],
];
$headerStyleC = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'FFC000'] 
    ]
];
$headerStyleDF = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'FFFF00'] 
    ],
];
$headerStyleG = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '92D050'] 
    ],
];
$headerStyleH = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '00B0F0'] 
    ],
];
$headerStyleI= [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '9999FF'] 
    ],
];
$headerStyleJ= [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'FF66FF'] 
    ],
];

$headerStyleA12K12 = [
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


$sheet->getStyle('A1:J1')->applyFromArray($headerStyle);
$sheet->getStyle('A2:J2')->applyFromArray($headerStyle);
$sheet->getStyle('A3:J3')->applyFromArray($headerStyle);

$sheet->getStyle('A12:J12')->applyFromArray($headerStyleA12K12);
$sheet->getStyle('A13:J13')->applyFromArray($headerStyleData);
$sheet->getStyle('A14:J14')->applyFromArray($headerStyleData);
$sheet->getStyle('A15:J15')->applyFromArray($headerStyleData);
$sheet->getStyle('A13')->applyFromArray($headerStyleA);
$sheet->getStyle('B13')->applyFromArray($headerStyleB);
$sheet->getStyle('C13')->applyFromArray($headerStyleC);
$sheet->getStyle('D13')->applyFromArray($headerStyleDF);
$sheet->getStyle('E13')->applyFromArray($headerStyleDF);
$sheet->getStyle('F13')->applyFromArray($headerStyleDF);
$sheet->getStyle('G13')->applyFromArray($headerStyleG);
$sheet->getStyle('H13')->applyFromArray($headerStyleH);
$sheet->getStyle('I13')->applyFromArray($headerStyleI);
$sheet->getStyle('J13')->applyFromArray($headerStyleJ);

$sheet->getStyle('A16:J16')->applyFromArray($headerStyleData);

foreach (range('A', 'J') as $column) {
    $sheet->getColumnDimension($column)->setWidth(17);
}

$writer = new Xlsx($spreadsheet);
$writer->save('e5.xlsx'); 

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="e1.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');

exit;
?>
