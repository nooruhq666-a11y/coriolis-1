<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$logFile = 'log.json';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data || !isset($data['index'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Index requis']);
    exit();
}

$index = $data['index'];

if (file_exists($logFile)) {
    $content = file_get_contents($logFile);
    $logs = json_decode($content, true);
    
    if ($logs && isset($logs['sessions']) && isset($logs['sessions'][$index])) {
        // Supprimer l'entrée à l'index spécifié
        array_splice($logs['sessions'], $index, 1);
        file_put_contents($logFile, json_encode($logs, JSON_PRETTY_PRINT));
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Log non trouvé']);
    }
} else {
    echo json_encode(['error' => 'Fichier log inexistant']);
}
?>