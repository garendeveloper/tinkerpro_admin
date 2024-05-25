<?php
require_once('./vendor/autoload.php');
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/customer-facade.php');
include(__DIR__ . '/../utils/models/product-facade.php');

$customerFacade = new CustomerFacade();
$products = new ProductFacade();



try {
    
    $searchQuery = $_GET['searchQuery'] ?? null;
    $customer = $customerFacade->getCustomersData($searchQuery);
    
    if (!$customer) {
        throw new Exception("No data returned from the database.");
    }

    // Define the headers
    $headers = [
        'First Name',
        'Last Name',
        'Contact',
        'Code /ID',
        'Type',
        'Email',
        'Address',
    ];

    // Set headers to prompt download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="customer.csv"');

    // Open the output stream
    $output = fopen('php://output', 'w');

    // Write the headers to the CSV file
    if (fputcsv($output, $headers) === false) {
        throw new Exception("Unable to write the header row to the CSV file.");
    }

   
    foreach ($customer  as $row) {
        
        $row = (array) $row;

      
        $data = [
            $row['firstname'] ?? '',
            $row['lastname'] ?? '',
            $row['contact'] ?? '',
            $row['code'] ?? '',
            $row['type'] ?? '',
            $row['email'] ?? '',
            $row['address'] ?? '',
          
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
