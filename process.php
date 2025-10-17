<?php
// Load API key
$envFile = __DIR__ . '/.env.local';
if (!file_exists($envFile)) die("Missing .env.local file");

$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    if (strpos($line, 'GEMINI_API_KEY=') === 0) {
        $apiKey = trim(substr($line, strlen('GEMINI_API_KEY=')));
        break;
    }
}

if (empty($apiKey)) die("API key not found in .env.local");

// Get user input
$level = $_POST['level'] ?? '';
$interests = $_POST['interests'] ?? '';
$strengths = $_POST['strengths'] ?? '';
$goals = $_POST['goals'] ?? '';
$location = $_POST['location'] ?? '';

if (empty($level) || empty($interests) || empty($strengths) || empty($goals)) {
    die('<div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">Please fill in all required fields</div>');
}

// Determine academic level description
$levelDesc = ($level === 'high_school') ? 'High School (Grades 7-10)' : 'Senior High School (Grades 11-12)';

// Create prompt for Gemini AI
$prompt = "You are an expert education counselor in the Philippines. A student needs guidance on choosing the right course and school.

Student Profile:
- Academic Level: {$levelDesc}
- Interests & Hobbies: {$interests}
- Strengths & Best Subjects: {$strengths}
- Future Goals: {$goals}
- Preferred Location: {$location}

Please provide comprehensive guidance in this EXACT JSON structure (respond ONLY with valid JSON, no markdown):

{
  \"career_paths\": [
    {
      \"title\": \"Career Name\",
      \"description\": \"Why this career fits their profile\",
      \"outlook\": \"Career prospects and opportunities\"
    }
  ],
  \"courses\": [
    {
      \"name\": \"Course Name\",
      \"match_reason\": \"Why this matches their profile\",
      \"opportunities\": \"Career opportunities after graduation\",
      \"focus_areas\": \"Required subjects/skills to focus on\"
    }
  ],
  \"schools\": [
    {
      \"name\": \"School Name\",
      \"location\": \"City, Province\",
      \"reason\": \"Why recommended for this student\",
      \"programs\": \"Notable programs\",
      \"requirements\": \"Basic admission requirements\"
    }
  ],
  \"action_steps\": {
    \"immediate\": [\"Step 1\", \"Step 2\"],
    \"academic_focus\": [\"Subject 1\", \"Subject 2\"],
    \"skills_to_develop\": [\"Skill 1\", \"Skill 2\"],
    \"activities\": [\"Activity 1\", \"Activity 2\"]
  }
}

Provide 3-4 career paths, 3-4 courses, 5-7 schools, and comprehensive action steps. Be specific to Philippine education system.";

// Gemini API endpoint
$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp:generateContent?key=$apiKey";

// Prepare data payload
$data = [
    'contents' => [
        [
            'parts' => [
                ['text' => $prompt]
            ]
        ]
    ],
    'generationConfig' => [
        'temperature' => 0.7,
        'topK' => 40,
        'topP' => 0.95,
        'maxOutputTokens' => 3000,
    ]
];

// Make API request
$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
    CURLOPT_POSTFIELDS => json_encode($data)
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    die("<div class='p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg'>cURL Error: " . curl_error($ch) . "</div>");
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200) {
    die("<div class='p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg'>Gemini API Error (HTTP $httpCode)</div>");
}

// Parse response
$json = json_decode($response, true);
$reply = $json['candidates'][0]['content']['parts'][0]['text'] ?? 'No response text.';

// Clean up JSON response (remove markdown if present)
$reply = preg_replace('/```json\s*|\s*```/', '', $reply);
$reply = trim($reply);

// Try to parse the AI JSON reply
$parsed = json_decode($reply, true);

if (json_last_error() === JSON_ERROR_NONE) {
    
    echo "<div class='bg-black text-white p-6 rounded-lg mb-4'>";
    echo "<h2 class='text-2xl font-bold mb-2'>🎯 Your Personalized Education Path</h2>";
    echo "<p class='text-gray-300'><strong>Academic Level:</strong> " . htmlspecialchars($levelDesc) . "</p>";
    echo "</div>";
    
    if (!empty($parsed['career_paths'])) {
        echo "<div class='bg-gray-50 p-6 rounded-lg mb-4 border border-gray-200'>";
        echo "<h2 class='text-xl font-bold text-gray-900 mb-4'>🚀 Recommended Career Paths</h2>";
        foreach ($parsed['career_paths'] as $career) {
            echo "<div class='bg-white p-4 rounded-lg mb-3 border border-gray-200'>";
            echo "<h3 class='font-bold text-lg text-gray-900 mb-2'>" . htmlspecialchars($career['title']) . "</h3>";
            echo "<p class='text-gray-700 text-sm mb-2'><strong>Why this fits:</strong> " . htmlspecialchars($career['description']) . "</p>";
            echo "<p class='text-gray-700 text-sm'><strong>Outlook:</strong> " . htmlspecialchars($career['outlook']) . "</p>";
            echo "</div>";
        }
        echo "</div>";
    }
    
    if (!empty($parsed['courses'])) {
        echo "<div class='bg-gray-50 p-6 rounded-lg mb-4 border border-gray-200'>";
        echo "<h2 class='text-xl font-bold text-gray-900 mb-4'>📚 Best Course Recommendations</h2>";
        foreach ($parsed['courses'] as $course) {
            echo "<div class='bg-white p-4 rounded-lg mb-3 border-l-4 border-black'>";
            echo "<h3 class='font-bold text-lg text-gray-900 mb-2'>" . htmlspecialchars($course['name']) . "</h3>";
            echo "<p class='text-gray-700 text-sm mb-2'><strong>Match Reason:</strong> " . htmlspecialchars($course['match_reason']) . "</p>";
            echo "<p class='text-gray-700 text-sm mb-2'><strong>Opportunities:</strong> " . htmlspecialchars($course['opportunities']) . "</p>";
            echo "<p class='text-gray-700 text-sm'><strong>Focus Areas:</strong> " . htmlspecialchars($course['focus_areas']) . "</p>";
            echo "</div>";
        }
        echo "</div>";
    }
    
    if (!empty($parsed['schools'])) {
        echo "<div class='bg-gray-50 p-6 rounded-lg mb-4 border border-gray-200'>";
        echo "<h2 class='text-xl font-bold text-gray-900 mb-4'>🏫 Recommended Schools in the Philippines</h2>";
        foreach ($parsed['schools'] as $school) {
            echo "<div class='bg-white p-4 rounded-lg mb-3 border border-gray-300'>";
            echo "<h3 class='font-bold text-lg text-gray-900 mb-2'>" . htmlspecialchars($school['name']) . "</h3>";
            echo "<p class='text-gray-700 text-sm mb-2'><strong>📍 Location:</strong> " . htmlspecialchars($school['location']) . "</p>";
            echo "<p class='text-gray-700 text-sm mb-2'><strong>Why Recommended:</strong> " . htmlspecialchars($school['reason']) . "</p>";
            echo "<p class='text-gray-700 text-sm mb-2'><strong>Programs:</strong> " . htmlspecialchars($school['programs']) . "</p>";
            echo "<p class='text-gray-700 text-sm'><strong>Requirements:</strong> " . htmlspecialchars($school['requirements']) . "</p>";
            echo "</div>";
        }
        echo "</div>";
    }
    
    if (!empty($parsed['action_steps'])) {
        echo "<div class='bg-gray-50 p-6 rounded-lg mb-4 border border-gray-200'>";
        echo "<h2 class='text-xl font-bold text-gray-900 mb-4'>✅ Your Action Plan</h2>";
        
        if (!empty($parsed['action_steps']['immediate'])) {
            echo "<div class='mb-4'>";
            echo "<h3 class='font-semibold text-gray-900 mb-2'>Immediate Steps:</h3>";
            echo "<ul class='list-disc list-inside space-y-1 text-gray-700 text-sm'>";
            foreach ($parsed['action_steps']['immediate'] as $step) {
                echo "<li>" . htmlspecialchars($step) . "</li>";
            }
            echo "</ul></div>";
        }
        
        if (!empty($parsed['action_steps']['academic_focus'])) {
            echo "<div class='mb-4'>";
            echo "<h3 class='font-semibold text-gray-900 mb-2'>Subjects to Focus On:</h3>";
            echo "<ul class='list-disc list-inside space-y-1 text-gray-700 text-sm'>";
            foreach ($parsed['action_steps']['academic_focus'] as $subject) {
                echo "<li>" . htmlspecialchars($subject) . "</li>";
            }
            echo "</ul></div>";
        }
        
        if (!empty($parsed['action_steps']['skills_to_develop'])) {
            echo "<div class='mb-4'>";
            echo "<h3 class='font-semibold text-gray-900 mb-2'>Skills to Develop:</h3>";
            echo "<ul class='list-disc list-inside space-y-1 text-gray-700 text-sm'>";
            foreach ($parsed['action_steps']['skills_to_develop'] as $skill) {
                echo "<li>" . htmlspecialchars($skill) . "</li>";
            }
            echo "</ul></div>";
        }
        
        if (!empty($parsed['action_steps']['activities'])) {
            echo "<div>";
            echo "<h3 class='font-semibold text-gray-900 mb-2'>Extracurricular Activities:</h3>";
            echo "<ul class='list-disc list-inside space-y-1 text-gray-700 text-sm'>";
            foreach ($parsed['action_steps']['activities'] as $activity) {
                echo "<li>" . htmlspecialchars($activity) . "</li>";
            }
            echo "</ul></div>";
        }
        
        echo "</div>";
    }
    
    // Final encouragement
    echo "<div class='bg-black text-white p-6 rounded-lg'>";
    echo "<h3 class='text-xl font-bold mb-2'>💡 Next Steps</h3>";
    echo "<p class='text-gray-300 text-sm'>Save these recommendations and discuss them with your parents, teachers, or guidance counselor. Research the schools mentioned and visit their websites. Start focusing on the suggested subjects and join relevant activities. Your future starts with the decisions you make today! 🌟</p>";
    echo "</div>";
    
} else {
    echo "<div class='p-4 bg-gray-100 border border-gray-300 rounded-lg'>";
    echo "<h3 class='font-bold text-gray-900 mb-2'>Raw Gemini Response:</h3>";
    echo "<pre class='text-sm text-gray-700 whitespace-pre-wrap'>" . htmlspecialchars($reply) . "</pre>";
    echo "</div>";
}
?>