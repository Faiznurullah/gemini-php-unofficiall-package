<?php
require_once '../gemini.php';
$apikey = 'API KEY';
$gemini = new Faiznurullah\Gemini\Gemini($apikey);
$text = 'Siapa CEO Google Sekarang?';
$response = $gemini->generateFromText($text);
$response_decode = json_decode($response, true);
echo $response_decode['candidates'][0]['content']['parts'][0]['text'];