<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduPath - Find Your Perfect Course & School</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .spinner {
            animation: spin 1s linear infinite;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-black text-white py-6 shadow-lg">
        <div class="container mx-auto px-6">
            <h1 class="text-4xl font-bold">🎓 EduPath</h1>
            <p class="text-gray-300 mt-2">Discover the perfect course and school for your future</p>
        </div>
    </header>

    <!-- Main Content Grid -->
    <div class="container mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Left Side - Input Form -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Student Information</h2>
                    <p class="text-gray-600">Fill out your details to get personalized recommendations</p>
                </div>

                <form id="eduForm" action="process.php" method="POST" class="space-y-6">
                    <div>
                        <label for="level" class="block text-sm font-semibold text-gray-700 mb-2">
                            Current Academic Level *
                        </label>
                        <select id="level" name="level" required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition">
                            <option value="">Select your level</option>
                            <option value="high_school">High School (Grade 7-10)</option>
                            <option value="senior_high">Senior High School (Grade 11-12)</option>
                        </select>
                    </div>

                    <div>
                        <label for="interests" class="block text-sm font-semibold text-gray-700 mb-2">
                            Your Interests & Hobbies *
                        </label>
                        <textarea id="interests" name="interests" required rows="3"
                                  placeholder="Tell us what you love to do..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition resize-none"></textarea>
                    </div>

                    <div>
                        <label for="strengths" class="block text-sm font-semibold text-gray-700 mb-2">
                            Your Strengths & Best Subjects *
                        </label>
                        <textarea id="strengths" name="strengths" required rows="3"
                                  placeholder="What are you good at?"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition resize-none"></textarea>
                    </div>

                    <div>
                        <label for="goals" class="block text-sm font-semibold text-gray-700 mb-2">
                            Your Future Goals *
                        </label>
                        <textarea id="goals" name="goals" required rows="3"
                                  placeholder="What do you want to become?"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition resize-none"></textarea>
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">
                            Preferred Location (Optional)
                        </label>
                        <input type="text" id="location" name="location" 
                               placeholder="e.g., Manila, Cebu, Davao"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent transition">
                    </div>

                    <button type="submit" 
                            class="w-full bg-black text-white py-4 rounded-lg font-semibold hover:bg-gray-800 transition transform hover:scale-105 active:scale-95">
                        Find My Path 🚀
                    </button>
                </form>
            </div>

            <!-- Right Side - Output Results -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <!-- Initial State -->
                <div id="initialState" class="flex items-center justify-center h-full">
                    <div class="text-center">
                        <div class="text-6xl mb-4">📚</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Ready to Find Your Path?</h3>
                        <p class="text-gray-600">Fill out the form on the left to get started with personalized course and school recommendations.</p>
                    </div>
                </div>

                <!-- Loading State -->
                <div id="loading" class="hidden">
                    <div class="flex flex-col items-center justify-center h-full">
                        <div class="w-16 h-16 border-4 border-gray-200 border-t-black rounded-full spinner mb-4"></div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Analyzing your profile...</h3>
                        <p class="text-gray-600">Finding the best courses and schools for you!</p>
                    </div>
                </div>

                <!-- Results State -->
                <div id="results" class="hidden overflow-y-auto" style="max-height: calc(100vh - 200px);">
                    <div class="mb-4">
                        <button onclick="resetForm()" 
                                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-semibold">
                            ← New Search
                        </button>
                    </div>
                    <div id="resultsContent" class="space-y-4"></div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function resetForm() {
            document.getElementById('results').classList.add('hidden');
            document.getElementById('initialState').classList.remove('hidden');
            document.getElementById('eduForm').reset();
        }

        document.getElementById('eduForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Hide initial state, show loading
            document.getElementById('initialState').classList.add('hidden');
            document.getElementById('loading').classList.remove('hidden');

            const formData = new FormData(this);

            fetch('process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(html => {
                // Hide loading, show results
                document.getElementById('loading').classList.add('hidden');
                document.getElementById('results').classList.remove('hidden');
                document.getElementById('resultsContent').innerHTML = html;
            })
            .catch(() => {
                alert('An error occurred. Please try again.');
                resetForm();
            });
        });
    </script>
</body>
</html>