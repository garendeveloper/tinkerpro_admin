<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reportData'])) {
    $reportData = $_POST['reportData'];
    $homeDir = getenv('USERPROFILE');
    $filePath = 'C:/Users/Patoy/Desktop/TextFile/sales_report.txt';
    // Write the data to the file
    if (file_put_contents($filePath, $reportData) !== false) {
        echo $filePath;
    } else {
        http_response_code(500);
        echo "Failed to save file.";
    }
} else {
    http_response_code(400);
    echo "Invalid request.";
}
?>
