<?php

    date_default_timezone_set('Asia/Manila');

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Get the data sent via POST
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $action = $_POST["action"];
        $details = $_POST["details"];
        $cashierId = $_POST["cashierId"]; 
        $role_id = $_POST["role_id"]; 

        logActivity($firstName, $lastName, $cashierId, $role_id, $action, $details);
    }

    function logActivity($firstName, $lastName, $cashierId, $role_id, $action, $details = "") 
    {
        $timestamp = date("Y-m-d H:i:s");
        $logEntry = "$timestamp | $firstName $lastName | $cashierId | $role_id | $action | $details " . PHP_EOL;

        $logFilePath = '../assets/logs/logs.txt';
        file_put_contents($logFilePath, $logEntry, FILE_APPEND);
    }

