<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/other-reports-facade.php');
include( __DIR__ . '/../utils/models/user-facade.php');
include( __DIR__ . '/../utils/models/product-facade.php');

$userFacade = new UserFacade();
$products = new ProductFacade();



try {
    
    $value = $_GET['selectedValue'] ?? null; 
    $searchQuery = $_GET['searchQuery'] ?? null;
    $userFacade = new UserFacade();
    
    $fetchCoupon = $userFacade->getAllCouponsStatus($value,$searchQuery);
    
    if (!$fetchCoupon) {
        throw new Exception("No data returned from the database.");
    }

    // Define the headers
    $headers = [
        'Transaction Date',
        'QR Number',
        'Used Date',
        'Expiration Date',
        'Amount',
    ];

    // Set headers to prompt download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="coupons_list.csv"');


    $output = fopen('php://output', 'w');
    if (fputcsv($output, $headers) === false) {
        throw new Exception("Unable to write the header row to the CSV file.");
    }

   
    foreach ($fetchCoupon  as $row) {
        
        $row = (array) $row;

      
        $data = [
            $row['transaction_dateTime'] ?? '',
            $row['qrNumber'] ?? '',
            $row['used_date'] ?? '',
            $row['expiry_dateTime'] ?? '',
            $row['c_amount'] ?? 0,
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
