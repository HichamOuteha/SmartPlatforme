<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('chat.index');
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        try {
            $apiKey = config('gemini.api_key');
            if (empty($apiKey)) {
                throw new \Exception('Gemini API key is not configured.');
            }

            // Préparation du prompt pour obtenir une réponse structurée
            $prompt = "En tant qu'assistant pédagogique, réponds à la question suivante de manière structurée et claire. 
            Utilise le format suivant pour ta réponse :
            
            ## Points Clés
            - Liste les points principaux de la réponse
            
            ## Explication Détaillée
            Fournis une explication détaillée
            
            ## Exemples (si pertinent)
            Donne des exemples concrets
            
            ## Ressources Complémentaires (si pertinent)
            Suggère des ressources pour approfondir
            
            Question : " . $request->message;

            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-05-20:generateContent?key=$apiKey", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topP' => 0.8,
                    'topK' => 40,
                    'maxOutputTokens' => 2048
                ]
            ]);

            if (!$response->ok()) {
                throw new \Exception('Erreur API Gemini : ' . $response->body());
            }

            $result = $response->json();
            $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (!$text) {
                throw new \Exception("Réponse vide ou inattendue de l'API Gemini");
            }

            // Structurer la réponse
            $formattedResponse = [
                'title' => 'Réponse du Chatbot',
                'content' => $text,
                'metadata' => [
                    'timestamp' => now(),
                    'model' => 'gemini-pro'
                ]
            ];

            return response()->json([
                'success' => true,
                'message' => $text,
                'formatted_response' => $formattedResponse
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur Gemini API', [
                'message' => $request->message,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = app()->environment('local')
                ? $e->getMessage()
                : 'Une erreur est survenue lors du traitement.';

            return response()->json([
                'success' => false,
                'message' => $errorMessage,
                'debug_info' => app()->environment('local') ? [
                    'error' => $e->getMessage(),
                    'api_key_set' => !empty(config('gemini.api_key')),
                    'api_key_length' => strlen(config('gemini.api_key')),
                    'model' => 'gemini-pro'
                ] : null
            ], 500);
        }
    }
}
