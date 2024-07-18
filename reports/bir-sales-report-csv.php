<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include(__DIR__ . '/../utils/models/product-facade.php');

$refundFacade = new OtherReportsFacade();
$products = new ProductFacade();

$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

try {
    // Fetch data from the database
    $fetchRefund = $refundFacade->birSalesReport($singleDateData, $startDate, $endDate);
    
    if (!$fetchRefund) {
        throw new Exception("No data returned from the database.");
    }

    // Define the headers
    $headers = [
        'TIN',
        'Branch',
        'Month',
        'Year',
        'MIN',
        'Last OR',
        'Vatable Sales',
        'Vat Zero Rated Sales',
        'Vat Exempt Sales',
        'Sales Subject to other percentage taxes'
    ];

    // Set headers to prompt download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="SALESREPORT.csv"');

    // Open the output stream
    $output = fopen('php://output', 'w');

    // Write the headers to the CSV file
    if (fputcsv($output, $headers) === false) {
        throw new Exception("Unable to write the header row to the CSV file.");
    }

   
    foreach ($fetchRefund as $row) {
        
        $row = (array) $row;

        $lastOR = str_pad($row['last_receipt'] ?? '', 9, '0', STR_PAD_LEFT);
        $data = [
            $row['tin'] ?? '',
            $row['branch'] ?? '',
            $row['month'] ?? '',
            $row['year'] ?? '',
            $row['min'] ?? '',
            $row['last_receipt'] ?? '',
            $row['total_vatable_sales'] ?? 0,
            0,
            $row['total_vat_exempt'] ?? 0,
            0
        ];

        if (fputcsv($output, $data) === false) {
            throw new Exception("Unable to write a data row to the CSV file.");
        }
    }
    fclose($output);
    exit;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
