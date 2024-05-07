<?php

$url = 'https://api.xendit.co/qr_codes';

$data = array(
    'reference_id' => 'order-id-1666420204',
    'type' => 'DYNAMIC',
    'currency' => 'IDR',
    'amount' => 10000,
    'expires_at' => '2022-10-23T09:56:43.60445Z'
);

$headers = array(
    'api-version: 2022-07-31',
    'Content-Type: application/json'
);

$apiKey = 'xnd_development_Udyi6IjLn4yBranJYjJLablYxOcU6GtEfNHtPlKkhV2OxPjgrvlG32C4PHOukP';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_USERPWD, $apiKey);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

if ($httpCode == 200) {
    echo "QR Code created successfully!";
    // Handle response data if needed
} else {
    echo "Error: " . $response;
    // Handle error
}

?>
