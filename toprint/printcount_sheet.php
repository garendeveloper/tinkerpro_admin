<?php
require_once ('vendor/autoload.php');


use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector; 

try {
    $connector = new WindowsPrintConnector("EPSON_TM-T20II"); 
    $printer = new Printer($connector);
    $printer->text("Hello, Thermal Printer!\n");
    $printer->cut();

    $printer->close();
} catch (Exception $e) {
    echo "Print failed: " . $e->getMessage();
}
