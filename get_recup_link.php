<?php
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');

if (file_exists('recup_link.json')) {
    $data = json_decode(file_get_contents('recup_link.json'), true);
    if (!empty($data['lien'])) {
        echo json_encode(['success' => true, 'lien' => $data['lien']]);
        exit;
    }
}
echo json_encode(['success' => false, 'lien' => '']);
?>