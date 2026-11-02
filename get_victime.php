<?php
if (file_exists('victime.json')) {
    $data = json_decode(file_get_contents('victime.json'), true);
    echo json_encode($data);
} else {
    echo json_encode(['nom' => '', 'prenom' => '', 'prix' => '']);
}
?>