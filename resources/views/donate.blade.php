<!DOCTYPE html>
<html lang="{{ session('locale', 'id') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantu.In - {{ session('locale') == 'en' ? 'Donate' : 'Donasi' }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
        
        .dark .bg-gray-100 {
            background-color: #374151 !important;
        }
        
        .dark .bg-gray-200 {
            background-color: #4b5563 !important;
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
        
        .dark .text-gray-500 {
            color: #9ca3af !important;
        }
        
        .dark .text-gray-400 {
            color: #6b7280 !important;
        }
        
        .dark .border-gray-200 {
            border-color: #374151 !important;
        }
        
        .dark .border-gray-100 {
            border-color: #4b5563 !important;
        }
        
        .dark .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.3) !important;
        }
        
        /* Campaign Image */
        .campaign-image {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }
        
        /* Amount Input */
        .amount-input {
            background-color: #F3F4F6;
            border-radius: 12px;
            padding: 16px 20px;
            font-size: 24px;
            font-weight: 600;
            text-align: center;
            border: none;
            transition: all 0.3s ease;
        }
        
        .dark .amount-input {
            background-color: #374151;
            color: #f9fafb;
        }
        
        .amount-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.3);
        }
        
        /* Quick Amount Buttons */
        .quick-amount {
            background-color: #F3F4F6;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .quick-amount:hover {
            background-color: #4ECDC4;
            color: white;
        }
        
        .dark .quick-amount {
            background-color: #374151;
            color: #d1d5db;
        }
        
        .dark .quick-amount:hover {
            background-color: #4ECDC4;
            color: white;
        }
        
        /* Payment Method Selector */
        .payment-selector {
            background-color: #F3F4F6;
            border-radius: 12px;
            padding: 16px 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }
        
        .dark .payment-selector {
            background-color: #374151;
        }
        
        .payment-selector:hover {
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.3);
        }
        
        /* Payment Methods List */
        .payment-methods {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 8px;
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transition: all 0.3s ease;
        }
        
        .payment-methods.show {
            max-height: 400px;
            opacity: 1;
        }
        
        .dark .payment-methods {
            background-color: #1f2937;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        
        .payment-method {
            padding: 16px 20px;
            border-bottom: 1px solid #F3F4F6;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: between;
        }
        
        .dark .payment-method {
            border-bottom: 1px solid #374151;
        }
        
        .payment-method:last-child {
            border-bottom: none;
        }
        
        .payment-method:hover {
            background-color: rgba(78, 205, 196, 0.05);
        }
        
        .payment-method.selected {
            background-color: rgba(78, 205, 196, 0.1);
        }
        
        /* Radio Button */
        .radio-button {
            width: 20px;
            height: 20px;
            border: 2px solid #D1D5DB;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
        }
        
        .radio-button.selected {
            border-color: #4ECDC4;
        }
        
        .radio-button.selected::after {
            content: "";
            width: 12px;
            height: 12px;
            background-color: #4ECDC4;
            border-radius: 50%;
        }
        
        /* Continue Button */
        .continue-btn {
            background: linear-gradient(135deg, #4ECDC4 0%, #45B7AA 100%);
            border-radius: 12px;
            padding: 16px 32px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .continue-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(78, 205, 196, 0.3);
        }
        
        .continue-btn:disabled {
            opacity: 0.7;
            transform: none;
            box-shadow: none;
            cursor: not-allowed;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen transition-colors duration-300">
    <!-- Header -->
    <div class="bg-white shadow-sm px-4 py-4 flex items-center justify-between transition-colors duration-300">
        <div class="flex items-center">
            <a href="{{ route('campaign.detail', $campaign['id']) }}" class="p-2 hover:bg-gray-100 rounded-full transition-colors mr-2">
                <i class="fas fa-arrow-left text-gray-600 text-xl"></i>
            </a>
            <h1 class="text-xl font-semibold text-gray-800">{{ session('locale') == 'en' ? 'Details' : 'Detail' }}</h1>
        </div>
        <button class="p-2 hover:bg-gray-100 rounded-full transition-colors">
            <i class="fas fa-heart text-gray-400 text-xl hover:text-red-500"></i>
        </button>
    </div>

    <div class="container mx-auto px-4 py-6 max-w-md">
        <!-- Campaign Image -->
        <div class="campaign-image mb-6">
            <img src="{{ $campaign['image'] }}" alt="{{ $campaign['title'] }}" class="w-full h-48 object-cover">
        </div>

        <form action="{{ route('donate.process') }}" method="POST" id="donateForm">
            @csrf
            <input type="hidden" name="campaign_id" value="{{ $campaign['id'] }}">
            
            <!-- Fill the nominal -->
            <div class="mb-6">
                <h2 class="text-lg font-medium text-gray-800 mb-4 text-center">{{ session('locale') == 'en' ? 'Fill the nominal' : 'Isi nominal' }}</h2>
                
                <div class="flex items-center amount-input mb-4">
                    <span class="text-gray-500 mr-2">Rp</span>
                    <input 
                        type="text" 
                        name="amount" 
                        id="amount" 
                        value="200.000"
                        class="bg-transparent border-none w-full focus:outline-none text-center"
                        inputmode="numeric"
                    >
                </div>
                
                <!-- Quick Amount Buttons -->
                <div class="grid grid-cols-3 gap-3 mb-6">
                    @foreach($quickAmounts as $amount)
                    <button 
                        type="button" 
                        class="quick-amount"
                        data-amount="{{ $amount }}"
                    >
                        Rp {{ number_format($amount / 1000) }}.000
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Payment Method Section -->
            <div class="mb-8">
                <div class="payment-selector flex items-center justify-between" id="paymentSelector">
                    <span class="text-gray-700" id="selectedPaymentText">{{ session('locale') == 'en' ? 'Select Payment Method' : 'Pilih Metode Pembayaran' }}</span>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform" id="chevronIcon"></i>
                </div>
                
                <!-- Payment Methods List -->
                <div class="payment-methods" id="paymentMethods">
                    @foreach($paymentMethods as $method)
                    <div class="payment-method" data-method="{{ $method['id'] }}" data-name="{{ $method['name'] }}">
                        <div class="flex items-center">
                            @if($method['logo'])
                            <img src="{{ $method['logo'] }}" alt="{{ $method['name'] }}" class="h-6 w-auto mr-3 object-contain">
                            @else
                            <div class="w-6 h-6 bg-custom-teal rounded mr-3 flex items-center justify-center">
                                <i class="fas fa-wallet text-white text-xs"></i>
                            </div>
                            @endif
                            <span class="font-medium text-gray-800">{{ $method['name'] }}</span>
                            @if($method['id'] == 'balance')
                            <span class="text-sm text-gray-500 ml-2">(Rp {{ number_format($userBalance, 0, ',', '.') }})</span>
                            @endif
                        </div>
                        <div class="radio-button"></div>
                        <input type="radio" name="payment_method" value="{{ $method['id'] }}" class="hidden">
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Continue Button -->
            <button 
                type="submit" 
                class="continue-btn w-full text-white text-center"
                id="continueBtn"
            >
                {{ session('locale') == 'en' ? 'Continue' : 'Lanjutkan' }}
            </button>
        </form>
    </div>

    <!-- Bantu.In Logo -->
    <div class="fixed bottom-4 left-4">
        <h1 class="text-3xl font-bold text-custom-teal">Bantu.In</h1>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Apply dark mode on page load
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            if (isDarkMode) {
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark');
            }
            
            const amountInput = document.getElementById('amount');
            const paymentSelector = document.getElementById('paymentSelector');
            const paymentMethods = document.getElementById('paymentMethods');
            const chevronIcon = document.getElementById('chevronIcon');
            const selectedPaymentText = document.getElementById('selectedPaymentText');
            const continueBtn = document.getElementById('continueBtn');
            
            let selectedPayment = null;
            
            // Format amount input
            function formatAmount(value) {
                value = value.replace(/\D/g, '');
                if (value === '') return '';
                return new Intl.NumberFormat('id-ID').format(value);
            }
            
            function unformatAmount(value) {
                return value.replace(/\D/g, '');
            }
            
            // Format initial value
            amountInput.value = formatAmount(amountInput.value);
            
            // Format on input
            amountInput.addEventListener('input', function(e) {
                const cursorPosition = this.selectionStart;
                const originalLength = this.value.length;
                
                const unformattedValue = unformatAmount(this.value);
                const formattedValue = formatAmount(unformattedValue);
                
                this.value = formattedValue;
                
                const newLength = this.value.length;
                const newPosition = cursorPosition + (newLength - originalLength);
                this.setSelectionRange(newPosition, newPosition);
            });
            
            // Quick amount buttons
            document.querySelectorAll('.quick-amount').forEach(button => {
                button.addEventListener('click', function() {
                    const amount = this.getAttribute('data-amount');
                    amountInput.value = formatAmount(amount);
                });
            });
            
            // Payment method selector
            paymentSelector.addEventListener('click', function() {
                const isOpen = paymentMethods.classList.contains('show');
                
                if (isOpen) {
                    paymentMethods.classList.remove('show');
                    chevronIcon.style.transform = 'rotate(0deg)';
                } else {
                    paymentMethods.classList.add('show');
                    chevronIcon.style.transform = 'rotate(180deg)';
                }
            });
            
            // Payment method selection
            document.querySelectorAll('.payment-method').forEach(method => {
                method.addEventListener('click', function() {
                    const methodId = this.getAttribute('data-method');
        
                    // Jika memilih saldo, cek apakah saldo mencukupi
                    if (methodId === 'balance') {
                        const currentAmount = parseInt(unformatAmount(amountInput.value)) || 0;
                        const userBalance = {{ $userBalance }};
                        
                        if (currentAmount > userBalance) {
                            alert('{{ session('locale') == 'en' ? 'Insufficient balance. Please top up first.' : 'Saldo tidak mencukupi. Silakan top up terlebih dahulu.' }}');
                            return;
                        }
                    }
                    
                    // Remove selected class from all methods
                    document.querySelectorAll('.payment-method').forEach(m => {
                        m.classList.remove('selected');
                        m.querySelector('.radio-button').classList.remove('selected');
                    });
                    
                    // Add selected class to clicked method
                    this.classList.add('selected');
                    this.querySelector('.radio-button').classList.add('selected');
                    
                    // Check the radio button
                    const radio = this.querySelector('input[type="radio"]');
                    radio.checked = true;
                    
                    // Update selected text
                    const methodName = this.getAttribute('data-name');
                    selectedPaymentText.textContent = methodName;
                    selectedPayment = methodId;
                    
                    // Close dropdown
                    paymentMethods.classList.remove('show');
                    chevronIcon.style.transform = 'rotate(0deg)';
                    
                    // Enable continue button
                    continueBtn.disabled = false;
                    
                    // Update continue button text
                    setTimeout(updateContinueButton, 100);
                });
            });

            // Update continue button text based on payment method
            function updateContinueButton() {
                if (selectedPayment === 'balance') {
                    continueBtn.textContent = '{{ session('locale') == 'en' ? 'Donate Now' : 'Donasi Sekarang' }}';
                } else {
                    continueBtn.textContent = '{{ session('locale') == 'en' ? 'Continue' : 'Lanjutkan' }}';
                }
            }
            
            // Form submission
            document.getElementById('donateForm').addEventListener('submit', function(e) {
                // Unformat amount before submission
                const amount = unformatAmount(amountInput.value);
                amountInput.value = amount;
                
                // Disable submit button
                continueBtn.disabled = true;
                continueBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>' + 
                    (localStorage.getItem('language') === 'en' ? 'Processing...' : 'Memproses...');
                
                // Biarkan form submit secara normal ke donate.process
            });
            
            // Initially disable continue button
            continueBtn.disabled = true;
        });
    </script>
</body>
</html>
