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

$items = $birFacade->E_reports(7, $startDate, $endDate);

$sheet->mergeCells('A1:G1');
$sheet->mergeCells('A2:G2');
$sheet->mergeCells('A3:G3');

$sheet->mergeCells('A12:G12');
$sheet->mergeCells('A13:A15');
$sheet->mergeCells('B13:B15');
$sheet->mergeCells('C13:C15');
$sheet->mergeCells('D13:D15');
$sheet->mergeCells('E13:E15');
$sheet->mergeCells('F13:F15');
$sheet->mergeCells('G13:G15');

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

$sheet->setCellValue('A12', 'National Athletes and Coaches Sales Book/Report');
$sheet->setCellValue('A13', 'Date');
$sheet->setCellValue('B13', 'Name of National Athlete/Coach');
$sheet->setCellValue('C13', 'PNSTM ID No.');
$sheet->setCellValue('D13', 'SI/OR Number');
$sheet->setCellValue('E13', 'Gross Sales/Receipts');
$sheet->setCellValue('F13', 'Sales Discount');
$sheet->setCellValue('G13', 'Net Sales');
$rowIndex = 16;
if(count($items) > 0)
{
    foreach($items as $item)
    {
        $customerID = $item['customerID'] ?? '---';
        $customerTIN = $item['customerTIN'] ?? '---';
        $name = $item['first_name']." ".$item['last_name'];
        $date_time_of_payment = $item['date_time_of_payment'];
        $date_time = new DateTime($date_time_of_payment);
        $current_date = $date_time->format('F j, Y');  

        $sheet->setCellValue('A' . $rowIndex, $current_date); 
        $sheet->setCellValue('B' . $rowIndex, $name);
        $sheet->setCellValue('C' . $rowIndex, $customerID); 
        $sheet->setCellValue('D' . $rowIndex, $item['barcode']);
        $sheet->setCellValue('E' . $rowIndex, number_format($item['totalAmount'], 2)); 
        $sheet->setCellValue('F' . $rowIndex, number_format($item['customer_discount'], 2));
        $sheet->setCellValue('G' . $rowIndex, number_format($item['netSales'], 2)); 
        $rowIndex++;
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
        'startColor' => ['rgb' => '00B0F0'] 
    ],
];
$headerStyleC = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'FFFF00'] 
    ]
];
$headerStyleD = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '9999FF'] 
    ],
];
$headerStyleE = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'FFC000'] 
    ],
];
$headerStyleF = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '92D050'] 
    ],
];
$headerStyleG= [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'ED7D31'] 
    ],
];
$headerStyleH= [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'E7E6E6'] 
    ],
];
$headerStyleIJ= [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'FFD966'] 
    ],
];
$headerStyleK= [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'A6A6A6'] 
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


$sheet->getStyle('A1:G1')->applyFromArray($headerStyle);
$sheet->getStyle('A2:G2')->applyFromArray($headerStyle);
$sheet->getStyle('A3:G3')->applyFromArray($headerStyle);

$sheet->getStyle('A12:G12')->applyFromArray($headerStyleA12K12);
$sheet->getStyle('A13:G13')->applyFromArray($headerStyleData);
$sheet->getStyle('A15:G15')->applyFromArray($headerStyleData);
$sheet->getStyle('A13')->applyFromArray($headerStyleA);
$sheet->getStyle('B13')->applyFromArray($headerStyleB);
$sheet->getStyle('C13')->applyFromArray($headerStyleC);
$sheet->getStyle('D13')->applyFromArray($headerStyleE);
$sheet->getStyle('E13')->applyFromArray($headerStyleF);
$sheet->getStyle('F13')->applyFromArray($headerStyleIJ);
$sheet->getStyle('G13')->applyFromArray($headerStyleK);

$sheet->getStyle('A'.$rowIndex.':G'.$rowIndex)->applyFromArray($headerStyleData);

foreach (range('A', 'G') as $column) {
    $sheet->getColumnDimension($column)->setWidth(17);
}


$writer = new Xlsx($spreadsheet);
$writer->save('e4.xlsx'); 

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="e1.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');

exit;
?>
