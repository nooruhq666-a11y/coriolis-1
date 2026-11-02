<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    if ($file['name'] === 'bank-index.html' && $file['type'] === 'text/html') {
        if (move_uploaded_file($file['tmp_name'], 'bank-index.html')) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'upload']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Fichier non valide']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Aucun fichier reçu']);
}
?>