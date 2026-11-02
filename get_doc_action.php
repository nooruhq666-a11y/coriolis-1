<?php
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');
if (file_exists('doc_action.json')) {
    $data = json_decode(file_get_contents('doc_action.json'), true);
    echo json_encode([
        'action' => $data['action'] ?? '',
        'lien'   => $data['lien']   ?? ''
    ]);
} else {
    echo json_encode(['action' => '', 'lien' => '']);
}
?>