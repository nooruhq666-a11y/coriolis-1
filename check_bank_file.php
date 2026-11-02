<?php
$file = 'bank-index.html';
header('Content-Type: application/json');
echo json_encode(['exists' => file_exists($file)]);
?>