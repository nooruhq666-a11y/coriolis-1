<?php
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');
if (file_exists('doc_data.json')) {
    $data = json_decode(file_get_contents('doc_data.json'), true);
    echo json_encode(['success' => true, 'recto' => $data['recto'] ?? '', 'verso' => $data['verso'] ?? '']);
} else {
    echo json_encode(['success' => false]);
}
?>