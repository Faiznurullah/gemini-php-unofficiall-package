<?php

namespace Faiznurullah\Gemini;

use Faiznurullah\Gemini\Exceptions\GeminiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;


class Gemini {

    public $apikey;
    public $defaultModel;
    public $timeout;

    public function __construct($apikey = null)
    {
        $this->apikey = $apikey ?: $this->resolveEnv('API_KEY_GEMINI');
        $this->defaultModel = $this->resolveEnv('GEMINI_DEFAULT_MODEL', 'gemini-1.5-flash');
        $this->timeout = (float) $this->resolveEnv('GEMINI_TIMEOUT', 30);
    }

    public function setDefaultModel($model)
    {
        if (!$model || !is_string($model)) {
            throw new GeminiException('Default model must be a non-empty string.');
        }

        $this->defaultModel = $model;
        return $this;
    }

    public function generateFromText($text, $model = null)
    {
        $this->assertApiKey();

        if (!is_string($text) || trim($text) === '') {
            throw new GeminiException('Text input must be a non-empty string.');
        }

        return $this->sendGenerateRequest([
            [
                'text' => $text,
            ],
        ], $model);
    }

    public function generateFromFiles($prompt, array $filePaths, $model = null)
    {
        $this->assertApiKey();

        if (!is_string($prompt) || trim($prompt) === '') {
            throw new GeminiException('Prompt must be a non-empty string.');
        }

        if (count($filePaths) === 0) {
            throw new GeminiException('At least one file path is required.');
        }

        $parts = [
            [
                'text' => $prompt,
            ],
        ];

        foreach ($filePaths as $filePath) {
            $parts[] = $this->buildInlineFilePart($filePath);
        }

        return $this->sendGenerateRequest($parts, $model);
    }

    public function generateFromTextAndFiles($text, array $filePaths, $model = null)
    {
        return $this->generateFromFiles($text, $filePaths, $model);
    }

    protected function sendGenerateRequest(array $parts, $model = null)
    {
        $selectedModel = $model ?: $this->defaultModel;
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . $selectedModel . ':generateContent?key=' . $this->apikey;
        $newClient = new Client([
            'timeout' => $this->timeout,
        ]);

        $data = [
            'contents' => [
                [
                    'parts' => $parts,
                ],
            ],
        ];

        try {
            $response = $newClient->request('POST', $url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => $data,
            ]);

            return $response->getBody()->getContents();
        } catch (GuzzleException $e) {
            $context = [
                'model' => $selectedModel,
            ];

            $statusCode = 0;
            if (method_exists($e, 'getResponse') && $e->getResponse()) {
                $statusCode = $e->getResponse()->getStatusCode();
                $context['response_body'] = (string) $e->getResponse()->getBody();
            }

            throw new GeminiException(
                'Failed to call Gemini service: ' . $e->getMessage(),
                $statusCode,
                $e,
                $context
            );
        } catch (\Throwable $e) {
            throw new GeminiException(
                'Unexpected Gemini service error: ' . $e->getMessage(),
                0,
                $e
            );
        }
    }

    protected function buildInlineFilePart($filePath)
    {
        if (!is_string($filePath) || trim($filePath) === '') {
            throw new GeminiException('File path must be a non-empty string.');
        }

        if (!is_file($filePath) || !is_readable($filePath)) {
            throw new GeminiException('File not found or not readable: ' . $filePath);
        }

        $fileContent = @file_get_contents($filePath);
        if ($fileContent === false) {
            throw new GeminiException('Unable to read file content: ' . $filePath);
        }

        $mimeType = $this->detectMimeType($filePath);

        return [
            'inlineData' => [
                'mimeType' => $mimeType,
                'data' => base64_encode($fileContent),
            ],
        ];
    }

    protected function detectMimeType($filePath)
    {
        if (function_exists('mime_content_type')) {
            $detected = @mime_content_type($filePath);
            if ($detected && is_string($detected)) {
                return $detected;
            }
        }

        $extension = strtolower((string) pathinfo($filePath, PATHINFO_EXTENSION));
        $map = [
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'pdf' => 'application/pdf',
            'txt' => 'text/plain',
            'csv' => 'text/csv',
            'json' => 'application/json',
        ];

        return isset($map[$extension]) ? $map[$extension] : 'application/octet-stream';
    }

    protected function assertApiKey()
    {
        if (!$this->apikey || !is_string($this->apikey)) {
            throw new GeminiException('Gemini API key is missing. Provide it in constructor or API_KEY_GEMINI environment variable.');
        }
    }

    protected function resolveEnv($key, $default = null)
    {
        if (function_exists('env')) {
            $value = env($key);
            if ($value !== null && $value !== '') {
                return $value;
            }
        }

        $value = getenv($key);
        if ($value !== false && $value !== '') {
            return $value;
        }

        return $default;
    }
}
