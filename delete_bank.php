<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (file_exists('bank-index.html')) {
        if (unlink('bank-index.html')) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Fichier introuvable']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
}
?>