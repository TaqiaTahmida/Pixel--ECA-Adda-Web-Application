<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class AIController extends Controller
{
    /**
     * Show the AI Advisor chat page.
     */
    public function index()
    {
        return view('dashboard.aidash');
    }

    /**
     * Handle chat requests and return Gemini AI response.
     */
    public function chat(Request $request)
    {
        $userMessage = $request->input('message');

        if (empty($userMessage)) {
            return response()->json([
                'reply' => 'Please enter a message before sending.'
            ], 400);
        }

        try {
            $url = config('services.gemini.endpoint') . '/' .
                   config('services.gemini.model') . ':generateContent?key=' .
                   config('services.gemini.key');

            $payload = [
                'contents' => [[
                    'role' => 'user',
                    'parts' => [[ 'text' => $userMessage ]]
                ]],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 512,
                ],
            ];

            $response = Http::post($url, $payload);

            if ($response->failed()) {
                Log::error('Gemini API request failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return response()->json([
                    'reply' => 'Sorry, the AI service is currently unavailable. Please try again later.'
                ], 500);
            }

            $json = $response->json();
            Log::info('Gemini chat response:', $json);

            $parts = data_get($json, 'candidates.0.content.parts', []);
            $reply = collect($parts)->pluck('text')->implode("\n");

            if (empty($reply)) {
                Log::warning('Gemini returned no reply', ['message' => $userMessage]);
                $reply = 'Sorry, I didn’t catch that. Can you rephrase or ask something else?';
            }

            return response()->json(['reply' => $reply]);

        } catch (\Exception $e) {
            Log::error('Gemini chat exception', ['error' => $e->getMessage()]);

            return response()->json([
                'reply' => 'An unexpected error occurred while contacting the AI service.'
            ], 500);
        }
    }
}
?>