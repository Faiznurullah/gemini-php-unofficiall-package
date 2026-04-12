# Gemini for php projects

this package is unofficial Gemini written in PHP.

## Official documentation
For Documentation please check [Gemini docs](https://ai.google.dev/gemini-api/docs)

## Installation
Install this package with composer by following command:
```
composer require faiznurullah/gemini-php-unofficial
```
or add manually in your ```Composer.json``` file.

## Usage 
### Laravel
on file .env you can add this configuration:
```
API_KEY_GEMINI = "GEMINI_API_KEY";
GEMINI_DEFAULT_MODEL = "gemini-1.5-flash";
GEMINI_TIMEOUT = 30;
```
on file ```config/app.php```  you can add this configuration.
```
'providers' => [ 
    Faiznurullah\Gemini\GeminiServiceProvider::class,
],
```
### Native
Initialize some required credentials. You can get credentials on your ai studio google account dashboard.
```
<?php

require_once __DIR__ . '/vendor/autoload.php';
// API Key
$apikey = 'GEMINI_API_KEY';
```

### Multi model selection
```php
$gemini = new Faiznurullah\Gemini\Gemini($apikey);

// use default model from env/config
$textResponse = $gemini->generateFromText('Jelaskan teori relativitas secara singkat.');

// choose model per request
$proResponse = $gemini->generateFromText('Buat analisa mendalam.', 'gemini-1.5-pro');
```

### Multi file request (image/pdf/dll)
```php
$filesResponse = $gemini->generateFromFiles(
    'Ringkas isi semua berkas ini dalam 5 poin.',
    [
        __DIR__ . '/files/photo.png',
        __DIR__ . '/files/report.pdf',
        __DIR__ . '/files/data.csv',
    ],
    'gemini-1.5-flash'
);
```

### Error handling
```php
use Faiznurullah\Gemini\Exceptions\GeminiException;

try {
    $response = $gemini->generateFromText('Halo Gemini!');
} catch (GeminiException $e) {
    $context = $e->getContext();
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
    if (isset($context['response_body'])) {
        echo 'API response: ' . $context['response_body'] . PHP_EOL;
    }
}
```

## Contributing
For any requests, bugs, or comments, please open an [issue](https://github.com/Faiznurullah/gemini-php-unofficiall-package/issues).

## Installing Packages
Before you start to code, run this command to install all of the required packages. Make sure you have composer installed in your computer.
```
composer install
```
I hope you can enjoy and contribute to future development.
