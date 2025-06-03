<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Gemini API Configuration
    |--------------------------------------------------------------------------
    */

    'api_key' => env('GEMINI_API_KEY'),
    
    'model' => env('GEMINI_MODEL', 'gemini-pro'),
    
    'max_output_tokens' => env('GEMINI_MAX_OUTPUT_TOKENS', 2048),
    
    'temperature' => env('GEMINI_TEMPERATURE', 0.7),
    
    'top_p' => env('GEMINI_TOP_P', 0.8),
    
    'top_k' => env('GEMINI_TOP_K', 40),

    /*
    |--------------------------------------------------------------------------
    | Gemini Base URL
    |--------------------------------------------------------------------------
    |
    | If you need a specific base URL for the Gemini API, you can provide it here.
    | Otherwise, leave empty to use the default value.
    */
    'base_url' => env('GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com/v1'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | The timeout may be used to specify the maximum number of seconds to wait
    | for a response. By default, the client will time out after 30 seconds.
    */

    'request_timeout' => env('GEMINI_REQUEST_TIMEOUT', 5),
];
