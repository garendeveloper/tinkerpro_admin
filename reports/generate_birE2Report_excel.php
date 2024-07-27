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

$items = $birFacade->E_reports(1, $startDate, $endDate);

$sheet->mergeCells('A1:K1');
$sheet->mergeCells('A2:K2');
$sheet->mergeCells('A3:K3');

$sheet->mergeCells('A12:K12');
$sheet->mergeCells('A13:A14');
$sheet->mergeCells('B13:B14');
$sheet->mergeCells('C13:C14');
$sheet->mergeCells('D13:D14');
$sheet->mergeCells('E13:E14');
$sheet->mergeCells('F13:F14');
$sheet->mergeCells('G13:G14');
$sheet->mergeCells('H13:H14');

//Discount
$sheet->mergeCells('I13:J13');
$sheet->mergeCells('J14:J14');

//Net Sales
$sheet->mergeCells('K13:K14');

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

$sheet->setCellValue('A12', 'Senior Citizen Sales Book/Report');
$sheet->setCellValue('A13', 'Date');
$sheet->setCellValue('B13', 'Name of Senior Citizen (SC)');
$sheet->setCellValue('C13', 'OSCA ID No./ SC ID No.');
$sheet->setCellValue('D13', 'SC TIN');
$sheet->setCellValue('E13', 'SI/OR Number');
$sheet->setCellValue('F13', 'Sales (inclusive of VAT)');
$sheet->setCellValue('G13', 'VAT Amount');
$sheet->setCellValue('H13', 'VAT-Exempt Sales');
$sheet->setCellValue('I13', 'Discount');
$sheet->setCellValue('I14', '5%');
$sheet->setCellValue('J14', '20%');
$sheet->setCellValue('K13', 'Net Sales');
$rowIndex = 15;
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
        $date_time_of_payment = $item['date_time_of_payment'];
        $date_time = new DateTime($date_time_of_payment);
        $current_date = $date_time->format('F j, Y');

        $sheet->setCellValue('A' . $rowIndex, $current_date); 
        $sheet->setCellValue('B' . $rowIndex, $name);
        $sheet->setCellValue('C' . $rowIndex, $customerID); 
        $sheet->setCellValue('D' . $rowIndex, $customerTIN); 
        $sheet->setCellValue('E' . $rowIndex, $item['barcode']);
        $sheet->setCellValue('F' . $rowIndex, $sales_vat); 
        $sheet->setCellValue('G' . $rowIndex, $vat_amount);
        $sheet->setCellValue('H' . $rowIndex, number_format($item['vatable_sales'], 2)); 
        $sheet->setCellValue('I' . $rowIndex, number_format($item['customerDiscount'], 2)); 
        $sheet->setCellValue('J' . $rowIndex, number_format($discount20percent, 2)); 
        $sheet->setCellValue('K' . $rowIndex, number_format($item['netSales'], 2));
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


$sheet->getStyle('A1:K1')->applyFromArray($headerStyle);
$sheet->getStyle('A2:K2')->applyFromArray($headerStyle);
$sheet->getStyle('A3:K3')->applyFromArray($headerStyle);

$sheet->getStyle('A12:K12')->applyFromArray($headerStyleA12K12);
$sheet->getStyle('A13:K13')->applyFromArray($headerStyleData);
$sheet->getStyle('A14:K14')->applyFromArray($headerStyleData);
$sheet->getStyle('A13')->applyFromArray($headerStyleA);
$sheet->getStyle('B13')->applyFromArray($headerStyleB);
$sheet->getStyle('C13')->applyFromArray($headerStyleC);
$sheet->getStyle('D13')->applyFromArray($headerStyleD);
$sheet->getStyle('E13')->applyFromArray($headerStyleE);
$sheet->getStyle('F13')->applyFromArray($headerStyleF);
$sheet->getStyle('G13')->applyFromArray($headerStyleG);
$sheet->getStyle('H13')->applyFromArray($headerStyleH);
$sheet->getStyle('I13')->applyFromArray($headerStyleIJ);
$sheet->getStyle('I14')->applyFromArray($headerStyleIJ);
$sheet->getStyle('J14')->applyFromArray($headerStyleIJ);
$sheet->getStyle('K13')->applyFromArray($headerStyleK);

$sheet->getStyle('A'.$rowIndex.':K'.$rowIndex)->applyFromArray($headerStyleData);

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
$writer->save('e2.xlsx'); // Save the file with a given filename

// Force the download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="e1.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');

exit;
?>
