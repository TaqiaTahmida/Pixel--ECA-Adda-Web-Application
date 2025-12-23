<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Eca;
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
            $user = $request->user();
            $ecas = Eca::query()
                ->select('title', 'category', 'level', 'short_description', 'full_description')
                ->orderBy('title')
                ->get();

            if ($this->isRecommendationRequest($userMessage)) {
                $reply = $this->buildRecommendationReply($userMessage, $user, $ecas);
                return response()->json(['reply' => $reply]);
            }

            $systemPrompt = $this->buildAdvisorPrompt($user, $ecas);

            $url = config('services.gemini.endpoint') . '/' .
                   config('services.gemini.model') . ':generateContent?key=' .
                   config('services.gemini.key');

            $payload = [
                'contents' => [[
                    'role' => 'user',
                    'parts' => [[ 'text' => $systemPrompt . "\n\nUser message: {$userMessage}" ]],
                ]],
                'generationConfig' => [
                    'temperature' => 0.3,
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

    private function buildAdvisorPrompt($user, $ecas): string
    {
        $educationLevel = $user?->education_level ?: 'unknown';
        $interests = $user?->interests;
        $interestsList = (is_array($interests) && count($interests))
            ? implode(', ', $interests)
            : 'not provided';

        $ecaLines = $ecas->map(function ($eca) {
            $category = $eca->category ?: 'General';
            $level = $eca->level ?: 'Beginner';
            $description = $eca->short_description ?: $eca->full_description ?: 'No description provided.';
            return "- {$eca->title} | Category: {$category} | Level: {$level} | {$description}";
        })->implode("\n");

        if ($ecaLines === '') {
            $ecaLines = 'None listed.';
        }

        return implode("\n", [
            'You are the ECA Adda AI Advisor.',
            'Use only the ECAs listed under Available ECAs. Do not invent or rename ECAs.',
            'If the user asks about ECAs that are not listed, say they are not currently offered and suggest the closest match from the list.',
            'When the user asks for recommendations, suggest 3-5 ECAs with short reasons and include category and level.',
            'Match suggestions to the user\'s interests and education level. Prefer details from the user\'s message over the profile if they conflict.',
            'If interests or education level are missing, ask one short follow-up question before recommending.',
            'Do not list the full catalog unless the user asks for it.',
            'When explaining an ECA, paraphrase its description in your own words and avoid quoting it verbatim.',
            'Formatting for recommendations:',
            '1) Title (Category: X, Level: Y) - Short reason.',
            'Keep responses concise and plain text.',
            'Education level guidance:',
            '- grade6-8: prioritize Beginner; avoid Advanced unless explicitly requested.',
            '- grade9-10: prioritize Beginner and Intermediate; avoid Advanced unless explicitly requested.',
            '- grade11-12: prioritize Intermediate and Advanced.',
            '- gap-year: prioritize Intermediate and Advanced with career/portfolio focus.',
            '',
            'User profile:',
            "- Education level: {$educationLevel}",
            "- Interests: {$interestsList}",
            '',
            'Available ECAs:',
            $ecaLines,
        ]);
    }

    private function isRecommendationRequest(string $message): bool
    {
        $message = strtolower($message);
        $keywords = [
            'recommend',
            'recommendation',
            'suggest',
            'suggestion',
            'eca for',
            'which eca',
            'what eca',
            'best eca',
            'join',
            'enroll',
            'pick',
            'choose',
        ];

        foreach ($keywords as $keyword) {
            if (strpos($message, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    private function buildRecommendationReply(string $message, $user, $ecas): string
    {
        $educationLevel = $user?->education_level;
        $allowedLevels = $this->allowedLevelsForEducation($educationLevel);
        $keywords = $this->collectInterestKeywords($message, $user?->interests ?? []);

        if (empty($keywords) && empty($educationLevel)) {
            return 'Tell me your interests and education level so I can recommend ECAs.';
        }

        if (empty($keywords)) {
            return 'Tell me a few interests and I will recommend ECAs that fit your level.';
        }

        $scored = $ecas->map(function ($eca) use ($keywords) {
            $title = strtolower((string) $eca->title);
            $category = strtolower((string) ($eca->category ?? ''));
            $shortDescription = strtolower((string) ($eca->short_description ?? ''));
            $fullDescription = strtolower((string) ($eca->full_description ?? ''));
            $level = $this->normalizeLevel($eca->level);
            $description = $eca->short_description ?: $eca->full_description ?: '';

            $score = 0;
            $matched = [];

            foreach ($keywords as $keyword) {
                $matchedHere = false;

                if ($keyword !== '' && str_contains($title, $keyword)) {
                    $score += 3;
                    $matchedHere = true;
                }

                if ($keyword !== '' && str_contains($category, $keyword)) {
                    $score += 2;
                    $matchedHere = true;
                }

                if ($keyword !== '' && (str_contains($shortDescription, $keyword) || str_contains($fullDescription, $keyword))) {
                    $score += 1;
                    $matchedHere = true;
                }

                if ($matchedHere) {
                    $matched[$keyword] = true;
                }
            }

            return [
                'title' => (string) $eca->title,
                'category' => $eca->category ?: 'General',
                'level' => $eca->level ?: 'Beginner',
                'normalized_level' => $level,
                'score' => $score,
                'matched' => array_keys($matched),
                'description' => $description,
            ];
        });

        $matches = $scored->filter(fn ($eca) => $eca['score'] > 0);
        $levelMatches = $matches->filter(function ($eca) use ($allowedLevels) {
            if (empty($allowedLevels)) {
                return true;
            }
            return in_array($eca['normalized_level'], $allowedLevels, true);
        });

        if ($levelMatches->isEmpty()) {
            if ($matches->isNotEmpty() && !empty($allowedLevels)) {
                return 'I found ECAs related to your interests, but they may be above your current level. Want to see them anyway?';
            }

            $categories = $ecas
                ->pluck('category')
                ->filter()
                ->unique()
                ->values()
                ->all();

            if (!empty($categories)) {
                $categoryList = implode(', ', $categories);
                return "I do not see a matching ECA for that interest right now. Are you interested in any of these areas: {$categoryList}?";
            }

            return 'I do not see a matching ECA for that interest right now. Tell me another interest and I will suggest options.';
        }

        $recommendations = $levelMatches
            ->sortByDesc('score')
            ->take(5)
            ->values();

        $lines = ['Here are a few ECAs that fit your interests and level:'];
        foreach ($recommendations as $index => $eca) {
            $matched = $eca['matched'];
            $reason = 'A good fit based on your interests.';
            $overview = $this->paraphraseDescription($eca['description'] ?? '');

            if (!empty($matched)) {
                $topic = $matched[0];
                $reason = "Matches your interest in {$topic}.";
            } elseif (!empty($eca['category'])) {
                $reason = "Fits the {$eca['category']} area.";
            }

            $lines[] = sprintf(
                '%d) %s (Category: %s, Level: %s) - %s Overview: %s',
                $index + 1,
                $eca['title'],
                $eca['category'],
                $eca['level'],
                $reason,
                $overview
            );
        }

        $lines[] = 'Want more options or a different focus?';

        return implode("\n", $lines);
    }

    private function allowedLevelsForEducation(?string $educationLevel): array
    {
        if (empty($educationLevel)) {
            return [];
        }

        return match ($educationLevel) {
            'grade6-8' => ['beginner'],
            'grade9-10' => ['beginner', 'intermediate'],
            'grade11-12' => ['intermediate', 'advanced'],
            'gap-year' => ['intermediate', 'advanced'],
            default => [],
        };
    }

    private function normalizeLevel(?string $level): string
    {
        $level = strtolower((string) $level);

        if (str_contains($level, 'advanced')) {
            return 'advanced';
        }
        if (str_contains($level, 'intermediate')) {
            return 'intermediate';
        }
        if (str_contains($level, 'beginner')) {
            return 'beginner';
        }

        return 'beginner';
    }

    private function collectInterestKeywords(string $message, $interests): array
    {
        $keywords = $this->extractKeywords($message);

        if (is_array($interests)) {
            foreach ($interests as $interest) {
                $keywords = array_merge($keywords, $this->extractKeywords((string) $interest));
            }
        }

        $keywords = array_values(array_unique($keywords));

        return $keywords;
    }

    private function extractKeywords(string $text): array
    {
        $tokens = preg_split('/[^a-z0-9]+/i', strtolower($text), -1, PREG_SPLIT_NO_EMPTY);
        $stopwords = [
            'a', 'an', 'the', 'and', 'or', 'of', 'to', 'in', 'for', 'with', 'about',
            'i', 'im', 'me', 'my', 'we', 'our', 'you', 'your',
            'recommend', 'recommendation', 'suggest', 'suggestion', 'eca', 'ecas',
            'activity', 'activities', 'club', 'clubs', 'like', 'love', 'want', 'need',
            'please', 'help', 'interested', 'interest', 'looking', 'best', 'join',
        ];

        $keywords = [];
        foreach ($tokens as $token) {
            if (strlen($token) < 3 || in_array($token, $stopwords, true)) {
                continue;
            }
            $keywords[] = $token;
        }

        return $keywords;
    }

    private function paraphraseDescription(?string $text): string
    {
        $text = trim((string) $text);

        if ($text === '') {
            return 'An engaging activity designed to build practical skills.';
        }

        $text = preg_replace('/\s+/', ' ', $text);
        $text = rtrim($text, '.');

        $replacements = [
            '/\bThis ECA introduces\b/i' => 'This activity gives you a practical introduction to',
            '/\bLearn the basics of\b/i' => 'Get a hands-on intro to',
            '/\bStudents work with\b/i' => 'You will work with',
            '/\bFocuses on\b/i' => 'Centered on',
            '/\bImprove\b/i' => 'Build',
            '/\bTurn ideas into\b/i' => 'Take ideas and shape them into',
            '/\bLearn\b/i' => 'Explore',
            '/\bthrough\b/i' => 'by using',
        ];

        foreach ($replacements as $pattern => $replacement) {
            if (preg_match($pattern, $text)) {
                $text = preg_replace($pattern, $replacement, $text, 1);
            }
        }

        if (strlen($text) > 180) {
            $text = substr($text, 0, 177) . '...';
        }

        if (!preg_match('/[.!?]$/', $text)) {
            $text .= '.';
        }

        return $text;
    }
}
?>
