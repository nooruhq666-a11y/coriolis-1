<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

$logFile = 'log.json';

if (file_exists($logFile)) {
    $content = file_get_contents($logFile);
    $logs = json_decode($content, true);
    if ($logs && isset($logs['sessions'])) {
        echo json_encode($logs);
    } else {
        echo json_encode(['sessions' => []]);
    }
} else {
    echo json_encode(['sessions' => []]);
}
?>