<?php
header('Content-Type: application/json');
// Supprimer le lien après qu'il ait été consommé
if (file_exists('recup_link.json')) {
    unlink('recup_link.json');
}
echo json_encode(['success' => true]);
?>