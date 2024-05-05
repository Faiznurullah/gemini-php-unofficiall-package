<?php
require_once '../gemini.php';
$gemini = new Faiznurullah\Gemini\Gemini;
$apikey = 'API KEY';
$text = 'Siapa CEO Google Sekarang?';
$response = $gemini->generateFromText($apikey, $text);
$response_decode = json_decode($response, true);
echo $response_decode['candidates'][0]['content']['parts'][0]['text'];