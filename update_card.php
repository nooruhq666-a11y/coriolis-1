<?php
// update_card.php
header('Content-Type: application/json');

// Récupérer les données JSON envoyées
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if ($data !== null) {
    // Écrire dans card.json
    if (file_put_contents('card.json', json_encode($data, JSON_PRETTY_PRINT))) {
        echo json_encode(['success' => true, 'message' => 'card.json mis à jour']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur d\'écriture']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Données invalides']);
}
?>