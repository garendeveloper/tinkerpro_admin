<?php
// File path
$filePath = 'C:/Users/Patoy/Desktop/TextFile/sales_report.txt';

if (file_exists($filePath)) {
    $fileContent = file_get_contents($filePath);
    echo "<pre>" . htmlspecialchars($fileContent) . "</pre>";
} else {
    echo "File does not exist.";
}
?>
