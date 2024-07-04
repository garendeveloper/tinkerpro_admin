<?php
// URL of the remote server
$remote_url = 'http://192.168.0.111/tinkerpros/www/assets/logs/logs.txt';

// Set appropriate headers for CORS
header("Access-Control-Allow-Origin: *"); // Adjust as needed
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Fetch the content from the remote server
$content = file_get_contents($remote_url);

// Output the content
echo $content;
?>