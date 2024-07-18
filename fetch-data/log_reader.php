<?php
    $ipAddress = gethostbyname(gethostname());
    $remote_url = 'http://'.$ipAddress.'/tinkerpros/www/assets/logs/logs.txt';

    header("Access-Control-Allow-Origin: *"); 
    header("Access-Control-Allow-Methods: GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $content = file_get_contents($remote_url);

    echo $content;
?>      