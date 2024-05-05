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

require_once 'location/gemini.php';
// API Key
$apikey = 'GEMINI_API_KEY';
```

## Contributing
For any requests, bugs, or comments, please open an [issue](https://github.com/Faiznurullah/gemini-php-unofficiall-package/issues).

## Installing Packages
Before you start to code, run this command to install all of the required packages. Make sure you have composer installed in your computer.
```
composer install
```
I hope you can enjoy and contribute to future development.
