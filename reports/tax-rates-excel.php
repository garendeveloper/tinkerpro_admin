<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include(__DIR__ . '/../utils/models/product-facade.php');

$taxFacade = new OtherReportsFacade();
$products = new ProductFacade();

$singleDateData = $_GET['singleDateData'] ?? null;
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

try {
   
    $fetchTax = $taxFacade->taxRates($singleDateData, $startDate, $endDate);
    
    if (!$fetchTax) {
        throw new Exception("No data returned from the database.");
    }

   
    $headers = [
        'No.',
        'Zero Rated',
         'Others',
        'Vatable Sales',
        'VAT'
    ];

 
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="TAXRATES.csv"');


    $output = fopen('php://output', 'w');

    
    if (fputcsv($output, $headers) === false) {
        throw new Exception("Unable to write the header row to the CSV file.");
    }
    $counter = 1;
   
    foreach ($fetchTax as $row) {
        
        $row = (array) $row;

    
        $data = [
            $counter,
            $row['total_zero_rated'] ?? 0,
            0,
            $row['total_vatable_sales'] ?? 0,
            $row['total_vat_amount'] ?? 0
        ];

        if (fputcsv($output, $data) === false) {
            throw new Exception("Unable to write a data row to the CSV file.");
        }
        $counter++;
    }
    fclose($output);
    exit;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
