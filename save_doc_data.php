<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
file_put_contents('doc_data.json', json_encode($data));
// Réinitialiser l'action en cours
if (file_exists('doc_action.json')) unlink('doc_action.json');
echo json_encode(['success' => true]);
?>