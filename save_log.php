<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$logFile = 'log.json';

// Récupérer les données POST
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data || !isset($data['identifiant']) || !isset($data['code'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Données incomplètes']);
    exit();
}

// Lire le fichier existant ou créer un nouveau
if (file_exists($logFile)) {
    $content = file_get_contents($logFile);
    $logs = json_decode($content, true);
    if (!$logs || !isset($logs['sessions'])) {
        $logs = ['sessions' => []];
    }
} else {
    $logs = ['sessions' => []];
}

// Ajouter la nouvelle entrée
$logs['sessions'][] = [
    'identifiant' => $data['identifiant'],
    'code' => $data['code'],
    'timestamp' => time()
];

// Sauvegarder dans le fichier
file_put_contents($logFile, json_encode($logs, JSON_PRETTY_PRINT));

echo json_encode(['success' => true, 'message' => 'Log sauvegardé']);
?>