<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('auth.title_register') }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;400;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'cairo': ['Cairo', 'sans-serif'],
                    },
                    colors: {
                        'primary': '#6200ea',
                        'primary-hover': '#4b00b5',
                        'google': '#db4437',
                        'google-hover': '#c23321',
                        'facebook': '#3b5998',
                        'facebook-hover': '#2d4373',
                    }
                }
            }
        }
    </script>

    <style>
        .bg-register-image {
            background-image: url('https://tse1.mm.bing.net/th?id=OIP.lbCP5u8L8iojC-VZAOIj4wHaFV&pid=Api');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="bg-gray-100 font-cairo min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-xl overflow-hidden">
        <div class="flex flex-wrap min-h-[600px]">
            <!-- Image Container -->
            <div class="hidden lg:block w-full lg:w-2/5 bg-register-image relative">
                <div class="absolute inset-0 bg-gradient-to-br from-primary/30 to-primary-hover/20"></div>
                <div class="absolute bottom-8 left-8 text-white">
                    <h2 class="text-3xl font-bold mb-2">انضم إلينا</h2>
                    <p class="text-lg opacity-90">أنشئ حسابك الجديد واستمتع بخدماتنا</p>
                    <div class="mt-4 flex items-center space-x-4 rtl:space-x-reverse">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-400 mr-2"></i>
                            <span class="text-sm">حماية عالية</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-400 mr-2"></i>
                            <span class="text-sm">سهولة الاستخدام</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div class="w-full lg:w-3/5 p-6 lg:p-10 flex flex-col justify-center">
                <!-- Logo and Header -->
                <div class="text-center mb-6">
                    <img src="{{ asset('storage/' . $companyUser->image) }}" alt="Logo" class="mx-auto max-w-[80px] mb-4">
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-2">{{ __('auth.title_register') }}</h1>
                    <p class="text-gray-600">املأ البيانات التالية لإنشاء حسابك الجديد</p>
                </div>

                <form method="POST" action="{{ route('customRegister') }}" class="space-y-4">
                    @csrf

                    <!-- Name Field -->
                    <div class="space-y-1">
                        <label for="name" class="block text-sm font-semibold text-gray-700">
                            {{ __('auth.name') }}
                        </label>
                        <div class="relative">
                            <input type="text"
                                   id="name"
                                   name="name"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 pl-12"
                                   placeholder="{{ __('auth.name_placeholder') }}"
                                   required>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="space-y-1">
                        <label for="email" class="block text-sm font-semibold text-gray-700">
                            {{ __('auth.email') }}
                        </label>
                        <div class="relative">
                            <input type="email"
                                   id="email"
                                   name="email"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 pl-12"
                                   placeholder="{{ __('auth.email_placeholder') }}"
                                   required>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Phone Field -->
                    <div class="space-y-1">
                        <label for="phone" class="block text-sm font-semibold text-gray-700">
                            {{ __('auth.phone') }}
                        </label>
                        <div class="flex rounded-xl border border-gray-300 focus-within:ring-2 focus-within:ring-primary focus-within:border-transparent transition-all duration-200">
                            <span class="inline-flex items-center px-3 text-sm text-gray-600 bg-gray-50 border-r border-gray-300 rounded-r-xl">
                                {{ __('auth.phone_prefix') }}
                            </span>
                            <div class="relative flex-1">
                                <input type="tel"
                                       id="phone"
                                       name="phone"
                                       class="w-full px-4 py-3 border-0 rounded-l-xl focus:ring-0 focus:outline-none pl-10"
                                       placeholder="{{ __('auth.phone_placeholder') }}"
                                       pattern="\d{9}"
                                       title="يرجى إدخال 9 أرقام فقط بعد مفتاح الدولة"
                                       required>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Field -->
                    <div class="space-y-1">
                        <label for="address" class="block text-sm font-semibold text-gray-700">
                            {{ __('auth.address') }}
                        </label>
                        <div class="relative">
                            <input type="text"
                                   id="address"
                                   name="address"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 pl-12"
                                   placeholder="{{ __('auth.address_placeholder') }}"
                                   required>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-1">
                        <label for="password" class="block text-sm font-semibold text-gray-700">
                            {{ __('auth.password') }}
                        </label>
                        <div class="relative">
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 pl-12 pr-12"
                                   placeholder="{{ __('auth.password_placeholder') }}"
                                   required
                                   pattern="^(?!.*(\d)\1{2})(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"
                                   title="يجب أن تحتوي كلمة المرور على 8 أحرف على الأقل، وحرف واحد على الأقل ورقم واحد على الأقل.">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <button type="button"
                                    id="togglePassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="passwordStrength" class="hidden mt-1">
                            <div class="flex space-x-1 rtl:space-x-reverse">
                                <div class="h-1 flex-1 bg-gray-200 rounded"></div>
                                <div class="h-1 flex-1 bg-gray-200 rounded"></div>
                                <div class="h-1 flex-1 bg-gray-200 rounded"></div>
                                <div class="h-1 flex-1 bg-gray-200 rounded"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">قوة كلمة المرور: <span id="strengthText">ضعيفة</span></p>
                        </div>
                    </div>

                    <!-- Password Confirmation Field -->
                    <div class="space-y-1">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">
                            {{ __('auth.password_confirmation') }}
                        </label>
                        <div class="relative">
                            <input type="password"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 pl-12 pr-12"
                                   placeholder="{{ __('auth.password_confirmation_placeholder') }}"
                                   required>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <button type="button"
                                    id="toggleConfirmPassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="passwordMatch" class="hidden mt-1 text-xs">
                            <span class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                كلمات المرور متطابقة
                            </span>
                        </div>
                        <div id="passwordMismatch" class="hidden mt-1 text-xs">
                            <span class="flex items-center text-red-500">
                                <i class="fas fa-times-circle mr-1"></i>
                                كلمات المرور غير متطابقة
                            </span>
                        </div>
                    </div>

                    <!-- Register Button -->
                    <button type="submit"
                            class="w-full bg-primary hover:bg-primary-hover text-white font-bold py-3 px-4 rounded-xl transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 mt-6">
                        <i class="fas fa-user-plus mr-2"></i>
                        {{ __('auth.register') }}
                    </button>

                    <!-- Social Login Buttons -->
                    <div class="relative mt-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">أو سجل باستخدام</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <a href="#"
                           class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 hover:shadow-md group">
                            <i class="fab fa-google text-google group-hover:scale-110 transition-transform duration-200 mr-2"></i>
                            <span class="font-medium">{{ __('auth.google') }}</span>
                        </a>
                        <a href="#"
                           class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 hover:shadow-md group">
                            <i class="fab fa-facebook-f text-facebook group-hover:scale-110 transition-transform duration-200 mr-2"></i>
                            <span class="font-medium">{{ __('auth.facebook') }}</span>
                        </a>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center pt-4">
                        <p class="text-gray-600">
                            {{ __('auth.already_have_account') }}
                            <a href="{{ route('login') }}"
                               class="text-primary hover:text-primary-hover font-semibold transition-colors">
                                {{ __('auth.login') }}
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        // Toggle password visibility function
        function toggleVisibility(input, toggleButton) {
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            toggleButton.querySelector('i').classList.toggle('fa-eye');
            toggleButton.querySelector('i').classList.toggle('fa-eye-slash');
        }

        togglePassword.addEventListener('click', () => toggleVisibility(passwordInput, togglePassword));
        toggleConfirmPassword.addEventListener('click', () => toggleVisibility(confirmPasswordInput, toggleConfirmPassword));

        // Password strength checker
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strengthDiv = document.getElementById('passwordStrength');
            const strengthText = document.getElementById('strengthText');
            const strengthBars = strengthDiv.querySelectorAll('.h-1');

            if (password.length > 0) {
                strengthDiv.classList.remove('hidden');

                let strength = 0;
                let strengthLabel = 'ضعيفة جداً';
                let strengthColor = 'bg-red-500';

                // Check criteria
                if (password.length >= 8) strength++;
                if (/[A-Z]/.test(password)) strength++;
                if (/[a-z]/.test(password)) strength++;
                if (/\d/.test(password)) strength++;
                if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength++;

                // Update strength display
                strengthBars.forEach((bar, index) => {
                    bar.className = 'h-1 flex-1 bg-gray-200 rounded transition-colors duration-300';
                });

                if (strength >= 1) {
                    strengthBars[0].classList.replace('bg-gray-200', 'bg-red-500');
                    strengthLabel = 'ضعيفة';
                }
                if (strength >= 2) {
                    strengthBars[1].classList.replace('bg-gray-200', 'bg-orange-500');
                    strengthLabel = 'متوسطة';
                }
                if (strength >= 3) {
                    strengthBars[2].classList.replace('bg-gray-200', 'bg-yellow-500');
                    strengthLabel = 'جيدة';
                }
                if (strength >= 4) {
                    strengthBars[3].classList.replace('bg-gray-200', 'bg-green-500');
                    strengthLabel = 'قوية';
                }

                strengthText.textContent = strengthLabel;
            } else {
                strengthDiv.classList.add('hidden');
            }

            checkPasswordMatch();
        });

        // Password match checker
        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            const matchDiv = document.getElementById('passwordMatch');
            const mismatchDiv = document.getElementById('passwordMismatch');

            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    matchDiv.classList.remove('hidden');
                    mismatchDiv.classList.add('hidden');
                    confirmPasswordInput.classList.remove('border-red-300', 'focus:ring-red-500');
                    confirmPasswordInput.classList.add('border-green-300', 'focus:ring-green-500');
                } else {
                    matchDiv.classList.add('hidden');
                    mismatchDiv.classList.remove('hidden');
                    confirmPasswordInput.classList.remove('border-green-300', 'focus:ring-green-500');
                    confirmPasswordInput.classList.add('border-red-300', 'focus:ring-red-500');
                }
            } else {
                matchDiv.classList.add('hidden');
                mismatchDiv.classList.add('hidden');
                confirmPasswordInput.classList.remove('border-red-300', 'focus:ring-red-500', 'border-green-300', 'focus:ring-green-500');
            }
        }

        confirmPasswordInput.addEventListener('input', checkPasswordMatch);

        // Phone number validation
        const phoneInput = document.getElementById('phone');
        phoneInput.addEventListener('input', function() {
            // Remove any non-digit characters
            this.value = this.value.replace(/\D/g, '');

            // Limit to 9 digits
            if (this.value.length > 9) {
                this.value = this.value.slice(0, 9);
            }
        });

        // Form submission validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('كلمات المرور غير متطابقة');
                return false;
            }

            // Add loading state
            const submitBtn = document.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>جاري إنشاء الحساب...';
            submitBtn.disabled = true;
        });

        // Add focus animations
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('scale-[1.02]');
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('scale-[1.02]');
            });
        });
    </script>
</body>

</html>
