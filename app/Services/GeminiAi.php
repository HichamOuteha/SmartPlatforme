<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;

class GeminiAi
{
    protected $apiKey;
    protected $apiUrl;
    protected $httpClient;

    public function __construct()
    {
        $this->apiKey = config('gemini.api_key');
        $this->apiUrl = config('gemini.base_url');
        $this->httpClient = new Client();
    }

    public function generateGeminiResponse($prompt)
    {
        $modelName = config('gemini.model', 'gemini-pro');
        $url = "{$this->apiUrl}/models/{$modelName}:generateContent?key={$this->apiKey}";

        $data = [
            'contents' => [
    [
        'parts' => [
            ['text' => "Tu es un assistant pédagogique pour une plateforme d'apprentissage en ligne sur le développement et la cybersécurité. 
Réponds de manière claire, concise et pédagogique aux questions des étudiants, même s'ils sont débutants.

Cours ou question : " . $prompt]
        ]
    ]
],

            'generationConfig' => [
                'temperature' => config('gemini.temperature', 0.7),
                'topP' => config('gemini.top_p', 0.8),
                'topK' => config('gemini.top_k', 40),
                'maxOutputTokens' => config('gemini.max_output_tokens', 2048),
            ]
        ];

        try {
            $response = $this->httpClient->post($url, [
                'json' => $data,
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'timeout' => config('gemini.request_timeout', 30)
            ]);

            $result = json_decode($response->getBody(), true);

            if (isset($result['candidates']) && is_array($result['candidates']) && !empty($result['candidates'])) {
                foreach ($result['candidates'] as $candidate) {
                    if (isset($candidate['content']['parts']) && is_array($candidate['content']['parts'])) {
                        foreach ($candidate['content']['parts'] as $part) {
                            if (isset($part['text'])) {
                                return $part['text'];
                            }
                        }
                    }
                }
            }

            throw new Exception('No valid response received from Gemini API');

        } catch (Exception $e) {
            throw new Exception('Error communicating with Gemini API: ' . $e->getMessage());
        }
    }
} 