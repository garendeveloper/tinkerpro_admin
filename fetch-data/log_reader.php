<?php
    // Fetch the IP address and construct the URL
    $ipAddress = gethostbyname(gethostname());
    $remote_url = 'http://'.$ipAddress.'/tinkerpros/www/assets/logs/logs.txt';

    // Set headers for CORS
    header("Access-Control-Allow-Origin: *"); 
    header("Access-Control-Allow-Methods: GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // Get the content from the remote URL
    $content = file_get_contents($remote_url);

    // Split the content into lines
    $lines = explode("\n", trim($content));

    // Function to parse date and time from log entry
    function extractDateTime($line) {
        // Assume the date and time are at the start of the line and formatted as "YYYY-MM-DD HH:MM:SS"
        return substr($line, 0, 19);
    }

    // Sort the lines based on the extracted date and time
    usort($lines, function($a, $b) {
        $dateTimeA = extractDateTime($a);
        $dateTimeB = extractDateTime($b);
        return strcmp($dateTimeB, $dateTimeA); // Descending order
    });

    // Output the sorted content
    echo implode("\n", $lines);
?>
