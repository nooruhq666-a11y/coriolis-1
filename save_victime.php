<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if ($data) {
        $victimeData = [
            'nom' => $data['nom'] ?? '',
            'prenom' => $data['prenom'] ?? '',
            'prix' => $data['prix'] ?? ''
        ];
        
        file_put_contents('victime.json', json_encode($victimeData));
        
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Données invalides']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
}
?>