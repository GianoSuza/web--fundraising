<!DOCTYPE html>
<html lang="{{ session('locale', 'id') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ session('locale') == 'en' ? 'Create Campaign' : 'Buat Kampanye' }} - Bantu.In</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        /* CUSTOM TEAL COLORS */
        .bg-custom-teal {
            background-color: #4ECDC4 !important;
        }
        .bg-custom-teal:hover {
            background-color: #45B7AA !important;
        }
        .text-custom-teal {
            color: #4ECDC4 !important;
        }
        .border-custom-teal {
            border-color: #4ECDC4 !important;
        }
        
        /* DARK MODE STYLES */
        .dark {
            color-scheme: dark;
        }
        
        .dark .bg-gray-50 {
            background-color: #111827 !important;
        }
        
        .dark .bg-white {
            background-color: #1f2937 !important;
        }
        
        .dark .text-gray-800 {
            color: #f9fafb !important;
        }
        
        .dark .text-gray-600 {
            color: #d1d5db !important;
        }
        
        .dark .text-gray-700 {
            color: #e5e7eb !important;
        }
        
        .dark .border-gray-200 {
            border-color: #374151 !important;
        }
        
        .dark .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.3) !important;
        }
        
        /* Image upload */
        .image-upload-container {
            border: 2px dashed #e2e8f0;
            border-radius: 0.5rem;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s;
        }
        
        .image-upload-container:hover {
            border-color: #4ECDC4;
        }
        
        .image-preview {
            max-height: 200px;
            margin-top: 1rem;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .image-preview img {
            max-width: 100%;
            max-height: 200px;
            object-fit: contain;
        }

        /* Category image styling */
        .category-image {
            width: 40px;
            height: 40px;
            object-fit: contain;
            margin: 0 auto;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm px-4 py-3 flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('dashboard') }}" class="mr-4 p-2 hover:bg-gray-100 rounded-full transition-colors">
                <i class="fas fa-arrow-left text-gray-600 text-xl"></i>
            </a>
            <h1 class="text-xl font-bold text-gray-800">{{ session('locale') == 'en' ? 'Create Campaign' : 'Buat Kampanye' }}</h1>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-3xl">
        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                {{ session('locale') == 'en' ? 'There were errors with your submission' : 'Ada kesalahan pada pengisian form' }}
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('campaign.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Donation Name -->
                <div class="mb-6">
                    <label for="donation_name" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ session('locale') == 'en' ? 'Donation Name' : 'Nama Donasi' }} *
                    </label>
                    <input 
                        type="text" 
                        id="donation_name" 
                        name="donation_name" 
                        value="{{ old('donation_name') }}"
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-teal focus:border-transparent"
                        required
                        maxlength="255"
                        placeholder="{{ session('locale') == 'en' ? 'Enter campaign name' : 'Masukkan nama kampanye' }}"
                    >
                    <div class="text-xs text-gray-500 mt-1 flex justify-end">
                        <span id="name-counter">0</span>/255
                    </div>
                </div>
                
                <!-- Target Value -->
                <div class="mb-6">
                    <label for="target_value" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ session('locale') == 'en' ? 'Target Value' : 'Target Nilai' }} *
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">Rp</span>
                        </div>
                        <input 
                            type="text" 
                            id="target_value" 
                            name="target_value" 
                            value="{{ old('target_value') }}"
                            class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-teal focus:border-transparent"
                            required
                            placeholder="1000000"
                            oninput="formatCurrency(this)"
                        >
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ session('locale') == 'en' ? 'Minimum Rp 100,000' : 'Minimal Rp 100.000' }}
                    </p>
                </div>
                
                <!-- Category -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ session('locale') == 'en' ? 'Category' : 'Kategori' }} *
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($categories as $value => $category)
                            <div class="category-option">
                                <input type="radio" name="category" id="category_{{ $value }}" value="{{ $value }}" class="hidden" {{ old('category') == $value ? 'checked' : '' }} required>
                                <label for="category_{{ $value }}" class="block border border-gray-200 rounded-lg p-4 text-center cursor-pointer hover:border-custom-teal transition-colors">
                                    <div class="mb-2">
                                        <img src="{{ asset($category['image']) }}" alt="{{ $category['name'] }}" class="category-image">
                                    </div>
                                    <span class="text-sm font-medium">{{ $category['name'] }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ session('locale') == 'en' ? 'Description' : 'Deskripsi' }} *
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="5" 
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-teal focus:border-transparent"
                        required
                        minlength="50"
                        placeholder="{{ session('locale') == 'en' ? 'Describe your campaign in detail...' : 'Jelaskan kampanye Anda secara detail...' }}"
                    >{{ old('description') }}</textarea>
                    <div class="text-xs text-gray-500 mt-1 flex justify-between">
                        <span>{{ session('locale') == 'en' ? 'Minimum 50 characters' : 'Minimal 50 karakter' }}</span>
                        <span><span id="desc-counter">0</span> {{ session('locale') == 'en' ? 'characters' : 'karakter' }}</span>
                    </div>
                </div>
                
                <!-- Finish Date -->
                <div class="mb-6">
                    <label for="finish_date" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ session('locale') == 'en' ? 'Finish Date' : 'Tanggal Selesai' }} *
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="finish_date" 
                            name="finish_date" 
                            value="{{ old('finish_date') }}"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-custom-teal focus:border-transparent"
                            required
                            placeholder="{{ session('locale') == 'en' ? 'Select a date' : 'Pilih tanggal' }}"
                            readonly
                        >
                        <div class="absolute right-3 top-2.5 text-gray-400">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Campaign Image -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ session('locale') == 'en' ? 'Campaign Image' : 'Gambar Kampanye' }}
                    </label>
                    <div class="image-upload-container" id="image-upload-container">
                        <input type="file" id="campaign_image" name="campaign_image" class="hidden" accept="image/*" onchange="previewImage(this)">
                        <label for="campaign_image" class="cursor-pointer block">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                            <p class="text-gray-500">
                                {{ session('locale') == 'en' ? 'Click to upload or drag and drop' : 'Klik untuk upload atau drag and drop' }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ session('locale') == 'en' ? 'JPG, PNG or GIF (max. 2MB)' : 'JPG, PNG atau GIF (maks. 2MB)' }}
                            </p>
                        </label>
                        <div class="image-preview hidden" id="image-preview"></div>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit" class="w-full bg-custom-teal hover:bg-custom-teal text-white font-bold py-3 px-4 rounded-lg transition-colors">
                        {{ session('locale') == 'en' ? 'Create Campaign' : 'Buat Kampanye' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Apply dark mode on page load
        document.addEventListener('DOMContentLoaded', function() {
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            if (isDarkMode) {
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark');
            }
            
            // Initialize date picker
            flatpickr("#finish_date", {
                minDate: "today",
                dateFormat: "Y-m-d"
            });
            
            // Character counters
            const nameInput = document.getElementById('donation_name');
            const nameCounter = document.getElementById('name-counter');
            
            nameInput.addEventListener('input', function() {
                nameCounter.textContent = this.value.length;
            });
            
            // Trigger once for initial value
            nameCounter.textContent = nameInput.value.length;
            
            const descInput = document.getElementById('description');
            const descCounter = document.getElementById('desc-counter');
            
            descInput.addEventListener('input', function() {
                descCounter.textContent = this.value.length;
            });
            
            // Trigger once for initial value
            descCounter.textContent = descInput.value.length;
            
            // Category selection
            const categoryOptions = document.querySelectorAll('input[name="category"]');
            categoryOptions.forEach(option => {
                option.addEventListener('change', function() {
                    document.querySelectorAll('.category-option label').forEach(label => {
                        label.classList.remove('border-custom-teal', 'border-2');
                    });
                    
                    if (this.checked) {
                        this.parentElement.querySelector('label').classList.add('border-custom-teal', 'border-2');
                    }
                });
                
                // Set initial state
                if (option.checked) {
                    option.parentElement.querySelector('label').classList.add('border-custom-teal', 'border-2');
                }
            });
        });
        
        // Image preview
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const container = document.getElementById('image-upload-container');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                    preview.classList.remove('hidden');
                    container.classList.add('border-custom-teal');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        // Format currency
        function formatCurrency(input) {
            // Remove non-digit characters
            let value = input.value.replace(/\D/g, '');
            
            // Format with thousand separators
            if (value.length > 0) {
                value = parseInt(value).toLocaleString('id-ID');
            }
            
            // Update the input value
            input.value = value;
        }
    </script>
</body>
</html>
