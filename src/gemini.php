<?php

namespace Faiznurullah\Gemini;

use GuzzleHttp\Client;


class Gemini {

    public $apikey;
    public function __construct($apikey = null)
      {
         $this->apikey = $apikey ?? env('API_KEY_GEMINI'); 
      }

    public static function generateFromText($text){ 

        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=' . env('API_KEY_GEMINI');;
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
