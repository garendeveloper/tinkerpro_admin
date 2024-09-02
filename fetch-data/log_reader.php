<?php
    $ipAddress = gethostbyname(gethostname());
    $remote_url = 'http://192.168.0.116/tinkerpros/www/assets/logs/logs.txt';

    header("Access-Control-Allow-Origin: *"); 
    header("Access-Control-Allow-Methods: GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $content = file_get_contents($remote_url);
    function formatDateToAMPM($datetimeString) {
        // Create a DateTime object from the datetime string
        $date = new DateTime($datetimeString);
        
        // Format the date and time
        $formattedTime = $date->format('g:i:s A');
        $formattedDate = $date->format('M j, Y');
        
        // Combine date and time into one string
        return $formattedDate . ' ' . $formattedTime;
    }
    function displayLogData($logText) {
        // Split the log text into lines
        $lines = explode("\n", $logText);
        
        // Start building the HTML table rows
        $html = '';
        
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line) {
                $columns = explode('|', $line);
                if (count($columns) >= 6) {
                    $role = isset($columns[3]) ? trim($columns[3]) : '';
                    $datetime = isset($columns[0]) ? trim($columns[0]) : '';
                    
                    if ($datetime !== '') {
                        $datetime = formatDateToAMPM($datetime);
                    }
                    
                    // Map roles to their descriptions
                    switch ($role) {
                        case "1":
                            $role = "Super Admin";
                            break;
                        case "2":
                            $role = "Admin";
                            break;
                        case "3":
                            $role = "Cashier";
                            break;
                        default:
                            $role = '';
                            break;
                    }
                    
                    // Create the row HTML
                    $html .= '<tr>';
                    $html .= '<td style="width: 15%;">' . htmlspecialchars($datetime) . '</td>';
                    $html .= '<td style="width: 15%">' . htmlspecialchars(trim($columns[1])) . '</td>';
                    $html .= '<td style="width: 10%">' . htmlspecialchars($role) . '</td>';
                    $html .= '<td style="width: 15%">' . htmlspecialchars(trim($columns[4])) . '</td>';
                    $html .= '<td style="width: 50%">' . htmlspecialchars(trim($columns[5])) . '</td>';
                    $html .= '</tr>';
                } else {
                    error_log('Line does not have enough columns: ' . $line);
                }
            }
        }
        
        // Return the HTML for the table body
       return $html;
    }
    echo displayLogData($content);
?>      