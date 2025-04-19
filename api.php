<?php
header('Content-Type: application/json');
$raw = file_get_contents('php://input');
$payload = json_decode($raw,true);
$prompt = $payload['prompt'] ?? '';
$action = $payload['action'] ?? 'generate';

if(trim($prompt) === ''){
  echo json_encode(['error'=>'Prompt vazio.']);
  exit;
}

require 'config.php';

if (!defined('OPENAI_API_KEY') || empty(OPENAI_API_KEY)) {
  echo json_encode(['error'=>'Chave de API não definida em config.php']);
  exit;
}

$messages = [
  ['role'=>'system','content'=>'Você é um assistente de programação bem humorado que responde em português.'],
  ['role'=>'user','content'=>"Ação solicitada: $action. Texto:
$prompt"]
];

$data = [
  'model'       => 'gpt-4o-mini',
  'store'       => true,
  'messages'    => $messages,
  'max_tokens'  => 800,
  'temperature' => 0.2,
];

$ch = curl_init('https://api.openai.com/v1/chat/completions');
curl_setopt_array($ch, [
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER     => [
    'Content-Type: application/json',
    'Authorization: Bearer ' . OPENAI_API_KEY
  ],
  CURLOPT_POSTFIELDS     => json_encode($data),
]);

$response = curl_exec($ch);
if(curl_errno($ch)){
  echo json_encode(['error'=>curl_error($ch)]);
  exit;
}
curl_close($ch);

$json = json_decode($response, true);

// Propagar erros da API
if (isset($json['error'])) {
    echo json_encode([
        'error' => $json['error']['message']
    ]);
    exit;
}

// Resposta esperada
if (isset($json['choices'][0]['message']['content'])) {
    echo json_encode([
        'response' => $json['choices'][0]['message']['content']
    ]);
} else {
    echo json_encode([
        'error' => 'Resposta inesperada da API',
        'raw'   => $json
    ]);
}
?>