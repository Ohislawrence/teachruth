<?php

namespace App\Services;

use App\Models\User;
use App\Models\TeacherProfile;
use App\Models\QualifyingQuestion;
use Illuminate\Support\Facades\Log;

class AIApiService
{
    protected $apiKey;
    protected $apiUrl = 'https://api.deepseek.com/v1/chat/completions';
    protected $maxRetries = 3;
    protected $retryDelay = 1000; // milliseconds

    public function __construct()
    {
        $this->apiKey = config('services.deepseek.api_key');

        if (empty($this->apiKey)) {
            Log::warning('DeepSeek API key is not configured');
        } else {
            Log::info('DeepSeek API service initialized with key: ' . substr($this->apiKey, 0, 10) . '...');
        }
    }

    public function appraiseTeacher($data)
    {
        Log::info('Starting teacher appraisal process', [
            'user_id' => $data['user']->id,
            'user_name' => $data['user']->name,
        ]);

        try {
            $user = $data['user'];
            $profile = $data['profile'];
            $qualifyingAnswers = $data['qualifying_answers'] ?? [];

            // Get questions and answers
            $questions = QualifyingQuestion::active()->ordered()->get();
            $qaPairs = [];

            Log::info('Processing qualifying questions', [
                'total_questions' => $questions->count(),
                'answers_provided' => count($qualifyingAnswers)
            ]);

            foreach ($questions as $index => $question) {
                if (isset($qualifyingAnswers[$index])) {
                    $qaPairs[] = [
                        'question' => $question->question,
                        'answer' => $qualifyingAnswers[$index]
                    ];
                }
            }

            // Prepare the prompt
            $prompt = $this->buildAppraisalPrompt($user, $profile, $qaPairs);

            Log::info('Prompt built successfully', [
                'prompt_length' => strlen($prompt),
                'qa_pairs_count' => count($qaPairs)
            ]);

            // Call DeepSeek API with retry logic
            $response = $this->callDeepSeekAPIWithRetry($prompt);

            Log::info('DeepSeek API response received', [
                'has_choices' => isset($response['choices']),
                'response_keys' => array_keys($response)
            ]);

            // Parse the response
            $appraisalData = $this->parseAIResponse($response, $user, $profile);

            Log::info('Appraisal data parsed successfully', [
                'overall_score' => $appraisalData['overall_score'],
                'has_breakdown' => !empty($appraisalData['scores_breakdown'])
            ]);

            return $appraisalData;

        } catch (\Exception $e) {
            Log::error('AI Appraisal Failed: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
                'user_id' => isset($data['user']) ? $data['user']->id : 'unknown',
                'fallback_triggered' => true
            ]);

            // Create detailed fallback with the actual data
            return $this->createDetailedFallbackAppraisal($data);
        }
    }

    private function callDeepSeekAPIWithRetry($prompt)
    {
        $lastException = null;

        for ($attempt = 1; $attempt <= $this->maxRetries; $attempt++) {
            try {
                Log::info("DeepSeek API attempt {$attempt}/{$this->maxRetries}");

                $response = $this->callDeepSeekAPI($prompt);

                Log::info("DeepSeek API attempt {$attempt} successful");
                return $response;

            } catch (\Exception $e) {
                $lastException = $e;

                Log::warning("DeepSeek API attempt {$attempt} failed", [
                    'error' => $e->getMessage(),
                    'attempt' => $attempt
                ]);

                // If not the last attempt, wait and retry
                if ($attempt < $this->maxRetries) {
                    usleep($this->retryDelay * 1000); // Convert ms to microseconds
                    continue;
                }
            }
        }

        // If all retries failed
        Log::error('All DeepSeek API retries failed', [
            'max_retries' => $this->maxRetries,
            'last_error' => $lastException ? $lastException->getMessage() : 'Unknown error'
        ]);

        throw new \Exception('Failed to get AI response after ' . $this->maxRetries . ' attempts: ' .
                           ($lastException ? $lastException->getMessage() : 'Unknown error'));
    }

    private function callDeepSeekAPI($prompt)
    {
        $ch = curl_init();

        $payload = json_encode([
            'model' => 'deepseek-chat',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a professional teacher assessment specialist. Always respond with valid JSON only, no additional text. Format your response as: {"overall_score": 85.5, "scores_breakdown": {...}, "strengths": ["..."], "improvement_areas": ["..."], "detailed_feedback": "..."}'
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'temperature' => 0.3,
            'max_tokens' => 2000,
        ]);

        curl_setopt_array($ch, [
            CURLOPT_URL => $this->apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->apiKey,
                'Content-Type: application/json',
                'Accept: application/json',
            ],
            CURLOPT_SSL_VERIFYPEER => false, // Disable SSL verification for development
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);

        curl_close($ch);

        Log::info('CURL request completed', [
            'http_code' => $httpCode,
            'curl_error' => $curlError,
            'response_length' => strlen($response)
        ]);

        if ($response === false) {
            throw new \Exception('CURL error: ' . $curlError);
        }

        if ($httpCode !== 200) {
            Log::error('DeepSeek API returned non-200 status', [
                'http_code' => $httpCode,
                'response' => $response
            ]);
            throw new \Exception('API returned HTTP ' . $httpCode . ': ' . substr($response, 0, 200));
        }

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Failed to decode API response', [
                'json_error' => json_last_error_msg(),
                'raw_response' => substr($response, 0, 500)
            ]);
            throw new \Exception('Invalid JSON response: ' . json_last_error_msg());
        }

        if (!isset($data['choices'][0]['message']['content'])) {
            Log::error('Invalid API response structure', [
                'response_keys' => array_keys($data),
                'full_response' => $data
            ]);
            throw new \Exception('Invalid API response structure');
        }

        return $data;
    }

    private function buildAppraisalPrompt($user, $profile, $qaPairs)
    {
        $qaText = '';
        foreach ($qaPairs as $i => $pair) {
            $qaText .= "Question " . ($i + 1) . ": " . $pair['question'] . "\n";
            $qaText .= "Answer " . ($i + 1) . ": " . $pair['answer'] . "\n\n";
        }

        $profileInfo = "TEACHER PROFILE:\n";
        $profileInfo .= "Name: {$user->name}\n";
        $profileInfo .= "Email: {$user->email}\n";
        if ($profile->qualification) $profileInfo .= "Qualification: {$profile->qualification}\n";
        if ($profile->years_of_experience) $profileInfo .= "Years of Experience: {$profile->years_of_experience}\n";
        if ($profile->specialization) $profileInfo .= "Specialization: {$profile->specialization}\n";
        if ($profile->bio) $profileInfo .= "Bio: {$profile->bio}\n";

        return <<<PROMPT
{$profileInfo}

QUALIFYING QUESTIONS AND ANSWERS:
{$qaText}

ASSESSMENT TASK:
You are an expert teacher assessor. Evaluate this teacher using the Level-3 Competency Rubrics.
Score each competency indicator from 1-4 based on the teacher's profile and answers.

REQUIRED OUTPUT FORMAT (JSON ONLY):
{
    "overall_score": 85.5,
    "scores_breakdown": {
        "competency_1": {
            "name": "Innovative Teaching Strategies",
            "score": 82,
            "indicators": {
                "supportive_environment": 4,
                "curriculum_planning": 3,
                "teaching_strategies": 4,
                "facilitates_learning": 3,
                "knowledge_initiatives": 3
            }
        },
        "competency_2": {
            "name": "Student Assessment & Reporting",
            "score": 78,
            "indicators": {
                "fair_assessment": 3,
                "assessment_strategies": 3,
                "explicit_information": 4,
                "valid_judgements": 3,
                "comprehensive_reporting": 3
            }
        },
        "competency_3": {
            "name": "Self Development & Reflection",
            "score": 85,
            "indicators": {
                "self_reflection": 4,
                "professional_growth": 3,
                "applies_knowledge": 3,
                "seeks_feedback": 4
            }
        },
        "competency_4": {
            "name": "Enhance Colleagues' Development",
            "score": 72,
            "indicators": {
                "plans_learning": 3,
                "development_strategies": 2,
                "encourages_learning": 3,
                "applies_initiatives": 3
            }
        },
        "competency_5": {
            "name": "School Leadership",
            "score": 80,
            "indicators": {
                "applies_research": 3,
                "promotes_processes": 3,
                "change_management": 3,
                "team_environment": 4,
                "collaborative_partnerships": 3
            }
        }
    },
    "strengths": ["List 3-5 specific strengths"],
    "improvement_areas": ["List 2-3 areas for improvement"],
    "detailed_feedback": "Provide 150-200 words of specific feedback and recommendations based on the rubric assessment."
}
PROMPT;
    }

    private function parseAIResponse($response, $user, $profile)
    {
        $content = $response['choices'][0]['message']['content'];

        Log::info('Raw AI response content', [
            'content_length' => strlen($content),
            'content_preview' => substr($content, 0, 200)
        ]);

        // Clean the response
        $content = trim($content);

        // Remove markdown code blocks
        if (strpos($content, '```json') !== false) {
            $content = preg_replace('/```json\s*/', '', $content);
            $content = preg_replace('/\s*```/', '', $content);
            $content = trim($content);
        }

        // Remove any leading/trailing non-JSON text
        $jsonStart = strpos($content, '{');
        $jsonEnd = strrpos($content, '}');

        if ($jsonStart !== false && $jsonEnd !== false && $jsonEnd > $jsonStart) {
            $content = substr($content, $jsonStart, $jsonEnd - $jsonStart + 1);
        }

        Log::info('Cleaned AI response', [
            'cleaned_length' => strlen($content),
            'cleaned_preview' => substr($content, 0, 200)
        ]);

        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Failed to parse cleaned AI response', [
                'json_error' => json_last_error_msg(),
                'cleaned_content' => $content
            ]);

            // Try to extract any valid JSON part
            preg_match('/\{.*\}/s', $content, $matches);
            if (!empty($matches[0])) {
                $data = json_decode($matches[0], true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    Log::info('Recovered JSON from regex match');
                }
            }
        }

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Failed to parse AI response as JSON: ' . json_last_error_msg());
        }

        // Validate and sanitize the response
        return [
            'overall_score' => $this->sanitizeScore($data['overall_score'] ?? 75.0),
            'scores_breakdown' => $data['scores_breakdown'] ?? $this->createDefaultBreakdown(),
            'strengths' => $this->sanitizeArray($data['strengths'] ?? $this->generateDefaultStrengths()),
            'improvement_areas' => $this->sanitizeArray($data['improvement_areas'] ?? $this->generateDefaultImprovementAreas()),
            'detailed_feedback' => $this->sanitizeText($data['detailed_feedback'] ?? $this->generateDefaultFeedback($user, $profile)),
        ];
    }

    private function sanitizeScore($score)
    {
        $score = floatval($score);
        return max(0, min(100, $score));
    }

    private function sanitizeArray($array)
    {
        if (!is_array($array)) {
            return [];
        }
        return array_filter(array_map('trim', $array));
    }

    private function sanitizeText($text)
    {
        return trim(strip_tags($text));
    }

    private function createDetailedFallbackAppraisal($data)
    {
        $user = $data['user'];
        $profile = $data['profile'];
        $qualifyingAnswers = $data['qualifying_answers'] ?? [];

        Log::info('Creating detailed fallback appraisal', [
            'user_id' => $user->id,
            'fallback_reason' => 'AI service unavailable'
        ]);

        // Calculate a more intelligent fallback based on actual data
        $experienceBonus = $profile->years_of_experience ? min($profile->years_of_experience * 2, 20) : 0;
        $answersBonus = count($qualifyingAnswers) > 5 ? 10 : 5;

        $baseScore = 65 + $experienceBonus + $answersBonus;
        $overallScore = min(85, $baseScore);

        return [
            'overall_score' => $overallScore,
            'scores_breakdown' => $this->createDefaultBreakdown($overallScore),
            'strengths' => $this->generateContextualStrengths($profile, $qualifyingAnswers),
            'improvement_areas' => $this->generateContextualImprovementAreas($profile),
            'detailed_feedback' => $this->generateContextualFeedback($user, $profile, $overallScore),
        ];
    }

    private function createDefaultBreakdown($overallScore = 75)
    {
        $baseScores = [
            'competency_1' => $overallScore - 3,
            'competency_2' => $overallScore - 5,
            'competency_3' => $overallScore + 2,
            'competency_4' => $overallScore - 7,
            'competency_5' => $overallScore - 2,
        ];

        $breakdown = [];
        $competencies = [
            'competency_1' => 'Innovative Teaching Strategies',
            'competency_2' => 'Student Assessment & Reporting',
            'competency_3' => 'Self Development & Reflection',
            'competency_4' => 'Enhance Colleagues\' Development',
            'competency_5' => 'School Leadership',
        ];

        foreach ($competencies as $key => $name) {
            $score = max(60, min(90, $baseScores[$key]));
            $breakdown[$key] = [
                'name' => $name,
                'score' => $score,
                'indicators' => [
                    'indicator_1' => rand(2, 4),
                    'indicator_2' => rand(2, 4),
                    'indicator_3' => rand(2, 4),
                ]
            ];
        }

        return $breakdown;
    }

    private function generateContextualStrengths($profile, $answers)
    {
        $strengths = [];

        if ($profile->years_of_experience && $profile->years_of_experience > 3) {
            $strengths[] = "Substantial teaching experience ({$profile->years_of_experience} years)";
        }

        if ($profile->qualification) {
            $strengths[] = "Strong educational background in {$profile->qualification}";
        }

        if (count($answers) > 7) {
            $strengths[] = "Detailed and thoughtful responses to qualifying questions";
        }

        if (empty($strengths)) {
            $strengths = [
                "Commitment to professional development",
                "Willingness to engage in self-reflection",
                "Student-centered approach to teaching"
            ];
        }

        return array_slice($strengths, 0, 3);
    }

    private function generateContextualImprovementAreas($profile)
    {
        $areas = [];

        if (!$profile->years_of_experience || $profile->years_of_experience < 2) {
            $areas[] = "Gain more practical classroom experience";
        }

        $areas[] = "Develop more comprehensive assessment strategies";
        $areas[] = "Enhance collaboration with colleagues";

        return array_slice($areas, 0, 2);
    }

    private function generateContextualFeedback($user, $profile, $score)
    {
        $grade = $this->getGrade($score);
        $experience = $profile->years_of_experience ? "{$profile->years_of_experience} years" : "limited";

        return "Based on your profile, {$user->name}, you have received an appraisal score of {$score} ({$grade}). " .
               "With {$experience} of experience in {$profile->specialization}, you demonstrate good teaching potential. " .
               "We recommend focusing on practical classroom experience and professional development opportunities " .
               "to further enhance your teaching skills. Consider seeking mentorship and engaging in peer observation " .
               "to accelerate your professional growth.";
    }

    private function getGrade($score)
    {
        if ($score >= 90) return 'A+';
        if ($score >= 80) return 'A';
        if ($score >= 70) return 'B';
        if ($score >= 60) return 'C';
        return 'D';
    }
}
