<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('auth.title_login') }}</title>

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
        .bg-login-image {
            background-image: url('https://tse1.mm.bing.net/th?id=OIP.lbCP5u8L8iojC-VZAOIj4wHaFV&pid=Api');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="bg-gray-100 font-cairo min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-xl overflow-hidden">
        <div class="flex flex-wrap min-h-[500px]">
            <!-- Image Container -->
            <div class="hidden md:block w-full md:w-1/2 bg-login-image relative">
                <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-transparent"></div>
                <div class="absolute bottom-8 left-8 text-white">
                    <h2 class="text-3xl font-bold mb-2">مرحباً بك</h2>
                    <p class="text-lg opacity-90">سجل دخولك للوصول إلى حسابك</p>
                </div>
            </div>

            <!-- Form Container -->
            <div class="w-full md:w-1/2 p-8 lg:p-12 flex flex-col justify-center">
                <!-- Logo -->
                <div class="text-center mb-8">
                    <img src="{{ asset('storage/' . $companyUser->image) }}" alt="Logo" class="mx-auto max-w-[100px] mb-4">
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">{{ __('auth.title_login') }}</h1>
                    <p class="text-gray-600 mt-2">أدخل بياناتك للوصول إلى حسابك</p>
                </div>

                <form method="POST" action="{{ route('customLogin') }}" class="space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-gray-700">
                            {{ __('auth.email_label') }}
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

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-gray-700">
                            {{ __('auth.password_label') }}
                        </label>
                        <div class="relative">
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 pl-12 pr-12"
                                   placeholder="{{ __('auth.password_placeholder') }}"
                                   required>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <button type="button"
                                    id="togglePassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox"
                                   id="chk1"
                                   name="chk"
                                   class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary focus:ring-2">
                            <label for="chk1" class="mr-2 text-sm text-gray-700 font-medium">
                                {{ __('auth.remember_me') }}
                            </label>
                        </div>
                        <a href="{{ route('forgetPassword') }}"
                           class="text-sm text-primary hover:text-primary-hover font-medium transition-colors">
                            {{ __('auth.forgot_password') }}
                        </a>
                    </div>

                    <!-- Google reCAPTCHA -->
                    <div class="flex justify-center">
                        <div class="g-recaptcha" data-sitekey="6LcHi3gqAAAAAJ05RrvUlAZIwul9-dQGqPoI8TIN"></div>
                    </div>

                    <!-- Login Button -->
                    <button type="submit"
                            class="w-full bg-primary hover:bg-primary-hover text-white font-bold py-3 px-4 rounded-xl transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        {{ __('auth.login') }}
                    </button>

                    <!-- Social Login Buttons -->
                    {{-- <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">أو سجل دخولك باستخدام</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
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
                    </div> --}}

                    <!-- Register Link -->
                    <div class="text-center pt-4">
                        <p class="text-gray-600">
                            {{ __('auth.no_account') }}
                            <a href="{{ route('register') }}"
                               class="text-primary hover:text-primary-hover font-semibold transition-colors">
                                {{ __('auth.register') }}
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        // Add some interactive animations
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
