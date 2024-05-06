<?php

// Xendit API endpoint
$url = 'https://api.xendit.co/qr_codes';

// API key to be encoded
$apiKey = 'xnd_development_Udyi6IjLn4yBranJYjJLablYxOcU6GtEfNHtPlKkhV2OxPjgrvlG32C4PHOukP';

// Data to be sent in the request body
$data = [
    "reference_id" => "order-id-1666420204",
    "type" => "DYNAMIC",
    "currency" => "IDR",
    "amount" => 10000,
    "expires_at" => "2022-10-23T09:56:43.60445Z"
];

// Encode data to JSON format
$dataJson = json_encode($data);

// Initialize cURL session
$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'api-version: 2022-07-31',
    'Authorization: Basic ' . base64_encode('tinkerpro_api:' . $apiKey)
]);

// Execute cURL request
$response = curl_exec($ch);

// Check for errors
if(curl_errno($ch)){
    echo 'Error: ' . curl_error($ch);
} else {
    // Decode JSON response
    $responseData = json_decode($response, true);
    // Print response
    print_r($responseData);
}

// Close cURL session
curl_close($ch);

?>
