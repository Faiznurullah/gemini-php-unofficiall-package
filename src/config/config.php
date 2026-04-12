<?php

$resolveEnv = function ($key, $default = null) {
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
};

return [
    'API_KEY_GEMINI' => $resolveEnv('API_KEY_GEMINI', 'Your API key'),
    'DEFAULT_MODEL' => $resolveEnv('GEMINI_DEFAULT_MODEL', 'gemini-1.5-flash'),
    'TIMEOUT' => (float) $resolveEnv('GEMINI_TIMEOUT', 30),
];