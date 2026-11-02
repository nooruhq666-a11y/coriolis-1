<?php
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');

if (file_exists('numero_data.json')) {
    $data = json_decode(file_get_contents('numero_data.json'), true);
    echo json_encode(['success' => true, 'numero' => $data['numero'] ?? '']);
} else {
    echo json_encode(['success' => false, 'numero' => '']);
}
?>