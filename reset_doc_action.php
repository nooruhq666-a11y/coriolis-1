<?php
header('Content-Type: application/json');
if (file_exists('doc_action.json')) unlink('doc_action.json');
echo json_encode(['success' => true]);
?>