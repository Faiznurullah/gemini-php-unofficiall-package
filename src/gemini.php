<?php

namespace Faiznurullah\Gemini;

require_once __DIR__ . '/../vendor/autoload.php';
use GuzzleHttp\Client;


class Gemini {

    function generateFromText($apikey, $text){ 

        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=' . $apikey;
        $new_client = new Client();
        $data = [
            'contents' => [
                 [
                     'parts' => [
                        [
                            'text' => $text
                          ]
                  ]
            ]
            ]
        ]; 
        $response = $new_client->request('POST', $url, [
            'headers' => [
                'Content-Type'  => 'application/json',
            ],
              'json' => $data,
        ]);
    
        return $response->getBody()->getContents(); 
    
    }

}
