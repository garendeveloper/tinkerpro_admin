<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/supplier-facade.php');
include(__DIR__ . '/../utils/models/product-facade.php');

$supplierFacade = new SupplierFacade;
$products = new ProductFacade();



try {
    
    $searchQuery = $_GET['searchQuery'] ?? null;
    $fetchSupplier = $supplierFacade->getSupplierAndSuppliedData($searchQuery);
    
    if (!$fetchSupplier) {
        throw new Exception("No data returned from the database.");
    }

    // Define the headers
    $headers = [
        'Supplier',
        'Contact',
        'Email',
        'Company'
    ];

    // Set headers to prompt download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="supplier.csv"');

    // Open the output stream
    $output = fopen('php://output', 'w');

    // Write the headers to the CSV file
    if (fputcsv($output, $headers) === false) {
        throw new Exception("Unable to write the header row to the CSV file.");
    }

   
    foreach ($fetchSupplier  as $row) {
        
        $row = (array) $row;

      
        $data = [
            $row['name'] ?? '',
            $row['contact'] ?? '',
            $row['email'] ?? '',
            $row['company'] ?? ''
        
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
