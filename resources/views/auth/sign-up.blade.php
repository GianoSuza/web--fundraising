<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Bantu.In - Sign Up</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Ensure emoji support */
        .country-button span:first-child {
            font-family: "Apple Color Emoji", "Segoe UI Emoji", "Noto Color Emoji", "Android Emoji", "EmojiSymbols", sans-serif;
            font-size: 1.5rem;
            line-height: 1;
        }
        
        .bg-teal-400 {
            background-color: #4ECDC4 !important;
        }
        .bg-teal-500 {
            background-color: #45B7AA !important;
        }
        .bg-teal-50 {
            background-color: rgba(78, 205, 196, 0.1) !important;
        }
        .text-teal-400 {
            color: #4ECDC4 !important;
        }
        .text-teal-500 {
            color: #4ECDC4 !important;
        }
        .border-teal-400 {
            border-color: #4ECDC4 !important;
        }
        .border-teal-500 {
            border-color: #4ECDC4 !important;
        }
        .ring-teal-500 {
            --tw-ring-color: rgba(78, 205, 196, 0.5) !important;
        }
        .focus\:border-teal-500:focus {
            border-color: #4ECDC4 !important;
        }
        .focus\:ring-teal-500:focus {
            --tw-ring-color: rgba(78, 205, 196, 0.5) !important;
        }
        .hover\:bg-teal-500:hover {
            background-color: #45B7AA !important;
        }
        .hover\:text-teal-500:hover {
            color: #45B7AA !important;
        }
        .text-teal-500 {
            --tw-text-opacity: 1;
            color: #4ECDC4 !important;
        }
        
        .step {
            display: none;
        }
        .step.active {
            display: block;
        }
        
        .country-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        
        .country-button {
            display: flex;
            align-items: center;
            padding: 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            transition: all 0.2s;
            cursor: pointer;
            background: white;
        }
        
        .country-button:hover {
            border-color: #9ca3af;
        }
        
        .country-button.selected {
            border-color: #4ECDC4;
            background-color: rgba(78, 205, 196, 0.1);
        }
        
        .progress-bar {
            width: 100%;
            height: 0.5rem;
            background-color: #e5e7eb;
            border-radius: 9999px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background-color: #4ECDC4;
            transition: width 0.3s ease;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center p-4 relative">
    <div class="w-full max-w-2xl">
        <!-- Progress Bar -->
        <div class="w-full max-w-md mx-auto mb-8" id="progressContainer" style="display: none;">
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill" style="width: 33.33%"></div>
            </div>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 max-w-md mx-auto">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('sign-up.post') }}" method="POST" id="signUpForm">
            @csrf
            
            <!-- Step 1: Basic Information -->
            <div class="step active" id="step1">
                <div class="w-full max-w-md mx-auto space-y-8">
                    <!-- Logo/Brand -->
                    <div class="text-center">
                        <h1 class="text-4xl font-bold text-teal-500">Bantu.In</h1>
                    </div>

                    <div class="space-y-6">
                        <!-- Name Field -->
                        <div class="space-y-2">
                            <input
                                type="text"
                                name="name"
                                placeholder="Mohammad Salah"
                                value="{{ old('name') }}"
                                class="w-full h-12 px-4 border border-gray-300 rounded-lg bg-white placeholder:text-gray-600 focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:outline-none transition-colors"
                                required
                            />
                        </div>

                        <!-- Email Field -->
                        <div class="space-y-2">
                            <input
                                type="email"
                                name="email"
                                placeholder="mosalah@gmail.com"
                                value="{{ old('email') }}"
                                class="w-full h-12 px-4 border border-gray-300 rounded-lg bg-white placeholder:text-gray-600 focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:outline-none transition-colors"
                                required
                            />
                        </div>

                        <!-- Password Field -->
                        <div class="space-y-2">
                            <div class="relative">
                                <input
                                    type="password"
                                    name="password"
                                    placeholder="••••••••"
                                    class="w-full h-12 px-4 pr-12 border border-gray-300 rounded-lg bg-white placeholder:text-gray-600 focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:outline-none transition-colors"
                                    required
                                />
                                <button
                                    type="button"
                                    onclick="togglePassword()"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                                >
                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Terms Checkbox -->
                        <div class="flex items-center space-x-3">
                            <input
                                type="checkbox"
                                id="terms"
                                name="agree_to_terms"
                                value="1"
                                class="w-4 h-4 text-teal-500 border-gray-300 rounded focus:ring-teal-500"
                                required
                            />
                            <label for="terms" class="text-sm text-gray-600">
                                I agree
                                <a href="{{ route('terms') }}" class="text-teal-400 hover:underline">
                                    Terms of Service
                                </a>
                                and
                                <a href="{{ route('privacy') }}" class="text-teal-400 hover:underline">
                                    Privacy Policy
                                </a>
                            </label>
                        </div>

                        <!-- Next Button -->
                        <button
                            type="button"
                            onclick="nextStep()"
                            class="w-full h-12 bg-teal-400 hover:bg-teal-500 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                        >
                            Next
                        </button>

                        <!-- Sign In Link -->
                        <div class="text-center">
                            <p class="text-sm text-gray-600">
                                Already have an account?
                                <a href="{{ route('sign-in') }}" class="text-gray-800 font-medium hover:underline transition-colors">
                                    Sign in
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Country Selection -->
            <div class="step" id="step2">
                <div class="w-full max-w-2xl mx-auto space-y-8">
                    <!-- Header with back button -->
                    <div class="flex items-center space-x-4">
                        <button type="button" onclick="prevStep()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                            <i class="fas fa-arrow-left text-gray-600 text-xl"></i>
                        </button>
                    </div>

                    <!-- Title -->
                    <div class="text-center">
                        <h2 class="text-2xl font-semibold text-gray-800">Select your country</h2>
                    </div>

                    <!-- Country Grid -->
                    <div class="country-grid">
                        <div class="country-button" onclick="selectCountry('Australia', '🇦🇺', '+61')">
                            <span class="text-2xl mr-3">🇦🇺</span>
                            <span class="text-gray-700 font-medium">Australia</span>
                        </div>
                        <div class="country-button" onclick="selectCountry('China', '🇨🇳', '+86')">
                            <span class="text-2xl mr-3">🇨🇳</span>
                            <span class="text-gray-700 font-medium">China</span>
                        </div>
                        <div class="country-button" onclick="selectCountry('Indonesia', '🇮🇩', '+62')">
                            <span class="text-2xl mr-3">🇮🇩</span>
                            <span class="text-gray-700 font-medium">Indonesia</span>
                        </div>
                        <div class="country-button" onclick="selectCountry('Malaysia', '🇲🇾', '+60')">
                            <span class="text-2xl mr-3">🇲🇾</span>
                            <span class="text-gray-700 font-medium">Malaysia</span>
                        </div>
                        <div class="country-button" onclick="selectCountry('Singapore', '🇸🇬', '+65')">
                            <span class="text-2xl mr-3">🇸🇬</span>
                            <span class="text-gray-700 font-medium">Singapore</span>
                        </div>
                        <div class="country-button" onclick="selectCountry('Spain', '🇪🇸', '+34')">
                            <span class="text-2xl mr-3">🇪🇸</span>
                            <span class="text-gray-700 font-medium">Spain</span>
                        </div>
                        <div class="country-button" onclick="selectCountry('United States', '🇺🇸', '+1')">
                            <span class="text-2xl mr-3">🇺🇸</span>
                            <span class="text-gray-700 font-medium">United States</span>
                        </div>
                        <div class="country-button" onclick="selectCountry('United Kingdom', '🇬🇧', '+44')">
                            <span class="text-2xl mr-3">🇬🇧</span>
                            <span class="text-gray-700 font-medium">United Kingdom</span>
                        </div>
                    </div>

                    <input type="hidden" name="country" id="selectedCountry" value="{{ old('country') }}">
                    <input type="hidden" name="country_code" id="selectedCountryCode" value="{{ old('country_code') }}">

                    <!-- Next Button -->
                    <div class="flex justify-center">
                        <button
                            type="button"
                            onclick="nextStep()"
                            id="countryNextBtn"
                            disabled
                            class="w-full max-w-md h-12 bg-teal-400 hover:bg-teal-500 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                        >
                            Next
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 3: Profile Completion -->
            <div class="step" id="step3">
                <div class="w-full max-w-md mx-auto space-y-8">
                    <!-- Header with back button -->
                    <div class="flex items-center space-x-4">
                        <button type="button" onclick="prevStep()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                            <i class="fas fa-arrow-left text-gray-600 text-xl"></i>
                        </button>
                    </div>

                    <!-- Profile Photo -->
                    <div class="flex justify-center">
                        <div class="relative">
                            <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=96&h=96&fit=crop&crop=face" alt="Profile" class="w-full h-full object-cover" />
                            </div>
                            <button type="button" class="absolute bottom-0 right-0 w-8 h-8 bg-teal-400 rounded-full flex items-center justify-center text-white hover:bg-teal-500 transition-colors">
                                <i class="fas fa-camera text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Phone Field -->
                        <div class="space-y-2">
                            <div class="flex">
                                <div class="flex items-center px-3 border border-r-0 border-gray-300 rounded-l-lg bg-gray-50">
                                    <span class="text-sm" id="countryDisplay">🇺🇸 +1</span>
                                </div>
                                <input
                                    type="tel"
                                    name="phone"
                                    placeholder="8445578293"
                                    value="{{ old('phone') }}"
                                    class="flex-1 h-12 px-4 border border-gray-300 rounded-r-lg bg-white placeholder:text-gray-600 focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:outline-none transition-colors"
                                    required
                                />
                            </div>
                        </div>

                        <!-- Gender Dropdown -->
                        <div class="space-y-2">
                            <div class="relative">
                                <select
                                    name="gender"
                                    class="w-full h-12 px-4 pr-10 border border-gray-300 rounded-lg bg-white text-gray-700 focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:outline-none transition-colors appearance-none"
                                >
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                            </div>
                        </div>

                        <!-- Complete Button -->
                        <button
                            type="submit"
                            class="w-full h-12 bg-teal-400 hover:bg-teal-500 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                        >
                            Complete
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Bottom Logo -->
        <div class="absolute bottom-8 left-8">
            <h1 class="text-2xl font-bold text-teal-500">Bantu.In</h1>
        </div>
    </div>

    <script>
        let currentStep = 1;
        let selectedCountryData = { name: '', flag: '', code: '' };

        function togglePassword() {
            const passwordInput = document.querySelector('input[name="password"]');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

        function nextStep() {
            if (currentStep < 3) {
                // Hide current step
                document.getElementById(`step${currentStep}`).classList.remove('active');
                
                // Show next step
                currentStep++;
                document.getElementById(`step${currentStep}`).classList.add('active');
                
                // Show progress bar from step 2
                if (currentStep >= 2) {
                    document.getElementById('progressContainer').style.display = 'block';
                    updateProgressBar();
                }
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                // Hide current step
                document.getElementById(`step${currentStep}`).classList.remove('active');
                
                // Show previous step
                currentStep--;
                document.getElementById(`step${currentStep}`).classList.add('active');
                
                // Hide progress bar on step 1
                if (currentStep === 1) {
                    document.getElementById('progressContainer').style.display = 'none';
                } else {
                    updateProgressBar();
                }
            }
        }

        function updateProgressBar() {
            const progress = (currentStep / 3) * 100;
            document.getElementById('progressFill').style.width = `${progress}%`;
        }

        function selectCountry(name, flag, code) {
            // Remove selected class from all buttons
            document.querySelectorAll('.country-button').forEach(btn => {
                btn.classList.remove('selected');
            });
            
            // Add selected class to clicked button
            event.currentTarget.classList.add('selected');
            
            // Store selected country data
            selectedCountryData = { name, flag, code };
            
            // Update hidden inputs
            document.getElementById('selectedCountry').value = name;
            document.getElementById('selectedCountryCode').value = code;
            
            // Update country display in step 3 with proper emoji rendering
            document.getElementById('countryDisplay').innerHTML = `${flag} ${code}`;
            
            // Enable next button
            document.getElementById('countryNextBtn').disabled = false;
        }

        // Initialize with old values if available
        document.addEventListener('DOMContentLoaded', function() {
            const oldCountry = '{{ old('country') }}';
            const oldCountryCode = '{{ old('country_code') }}';
            
            if (oldCountry && oldCountryCode) {
                // Find and select the country button
                const countryButtons = document.querySelectorAll('.country-button');
                countryButtons.forEach(btn => {
                    const countryName = btn.querySelector('span:last-child').textContent;
                    if (countryName === oldCountry) {
                        btn.classList.add('selected');
                        document.getElementById('countryNextBtn').disabled = false;
                        
                        // Update country display
                        const flag = btn.querySelector('span:first-child').textContent;
                        document.getElementById('countryDisplay').textContent = `${flag} ${oldCountryCode}`;
                    }
                });
            }
        });
    </script>
</body>
</html>
