<?php
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');

if (file_exists('facture_data.json')) {
    $data = json_decode(file_get_contents('facture_data.json'), true);
    echo json_encode([
        'success' => true,
        'numero'  => $data['numero']  ?? '',
        'montant' => $data['montant'] ?? '',
        'date'    => $data['date']    ?? '',
        'email'   => $data['email']   ?? ''
    ]);
} else {
    echo json_encode(['success' => false]);
}
?>