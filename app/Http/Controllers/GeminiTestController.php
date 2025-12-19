<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiTestController extends Controller
{
    public function test()
    {
        $url = config('services.gemini.endpoint') . '/' .
               config('services.gemini.model') . ':generateContent?key=' .
               config('services.gemini.key');

        $payload = [
            'contents' => [[
                'role' => 'user',
                'parts' => [[
                    'text' => 'Hello Gemini! What are 3 extracurricular activities for a high school student interested in music and coding?'
                ]],
            ]],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 512,
            ],
        ];

        $response = Http::post($url, $payload);
        $json = $response->json();

        // Log full response for debugging
        Log::info('Gemini response:', $json);

        // Extract reply text safely
        $text = data_get($json, 'candidates.0.content.parts.0.text');

        // Fallback if text is missing
        if (empty($text)) {
            $text = '[No response text returned. Check model config or token limits.]';
        }

        return response()->json([
            'reply' => $text,
            'model' => config('services.gemini.model'),
            'tokens_used' => data_get($json, 'usageMetadata.totalTokenCount'),
        ]);
    }
}
?>