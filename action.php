<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Si c'est une requête OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$actionFile = 'action.json';

// GET - Récupérer l'action
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (file_exists($actionFile)) {
        $content = file_get_contents($actionFile);
        $data = json_decode($content, true);
        
        // Vérifier si l'action est expirée (plus de 10 secondes)
        if ($data && isset($data['timestamp'])) {
            $age = time() - $data['timestamp'];
            if ($age > 10) {
                // Action trop vieille, on la supprime
                unlink($actionFile);
                echo json_encode(['action' => null]);
                exit();
            }
        }
        
        echo json_encode($data ?: ['action' => null]);
    } else {
        echo json_encode(['action' => null]);
    }
    exit();
}

// POST - Définir une action
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    if (!$data || !isset($data['action'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Action requise']);
        exit();
    }
    
    // Ajouter un timestamp
    $data['timestamp'] = time();
    
    // Sauvegarder l'action
    file_put_contents($actionFile, json_encode($data));
    
    echo json_encode(['success' => true, 'action' => $data['action']]);
    exit();
}

// DELETE - Supprimer l'action (quand elle est consommée)
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (file_exists($actionFile)) {
        unlink($actionFile);
    }
    echo json_encode(['success' => true]);
    exit();
}

// Méthode non supportée
http_response_code(405);
echo json_encode(['error' => 'Méthode non supportée']);
?>