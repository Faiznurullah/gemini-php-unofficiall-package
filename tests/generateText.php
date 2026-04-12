<?php

use PHPUnit\Framework\TestCase;
use Faiznurullah\Gemini\Gemini;
use Faiznurullah\Gemini\Exceptions\GeminiException;
use Dotenv\Dotenv;

Class generateText extends TestCase
{

    protected function setUp():void{
        $dotenv = Dotenv::createImmutable(__DIR__.'/..');
        $dotenv->load();
    }

    // Green Test
    public function testGenerateFromText()
    {
        $apikey = $_ENV['API_KEY_GEMINI'];
        $gemini = new Gemini($apikey);
        $text = 'Siapa CEO Google Sekarang?';
        $response = $gemini->generateFromText($text);
        $response_decode = json_decode($response, true);
        $this->assertIsArray($response_decode, "Response is not a valid JSON string that can be decoded to an array");
    }

    public function testGenerateFromTextThrowsWhenApiKeyMissing()
    {
        $gemini = new Gemini('');

        $this->expectException(GeminiException::class);
        $this->expectExceptionMessage('Gemini API key is missing');
        $gemini->generateFromText('halo');
    }

    public function testGenerateFromFilesThrowsWhenFileNotFound()
    {
        $gemini = new Gemini('dummy-key');

        $this->expectException(GeminiException::class);
        $this->expectExceptionMessage('File not found or not readable');
        $gemini->generateFromFiles('jelaskan berkas', [__DIR__ . '/does-not-exist.pdf']);
    }
}