<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('auth.title') }}</title>

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
                        'primary-light': '#b388ff',
                    },
                    backgroundImage: {
                        'gradient-purple': 'linear-gradient(to bottom right, #6200ea, #b388ff)',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gradient-purple font-cairo min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Main OTP Container -->
        <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 text-center border border-white/20">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-3xl text-primary"></i>
                </div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-2">{{ __('otp.title') }}</h1>
                <p class="text-gray-600 text-sm">تم إرسال رمز التحقق إلى هاتفك المحمول</p>
            </div>

            <!-- OTP Form -->
            <form id="otpForm" method="POST" action="{{ route('verifyOtp') }}" class="space-y-6">
                @csrf

                <!-- OTP Input Fields -->
                <div class="flex justify-center space-x-2 rtl:space-x-reverse mb-6">
                    @for ($i = 0; $i < 5; $i++)
                        <input type="text"
                               class="otp-input w-12 h-12 sm:w-14 sm:h-14 text-xl font-bold text-center border-2 border-gray-300 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-200 bg-white shadow-sm hover:shadow-md"
                               maxlength="1"
                               pattern="\d"
                               required>
                    @endfor
                </div>

                <input type="hidden" name="otp" id="otpHiddenInput">

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full bg-primary hover:bg-primary-hover text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 shadow-lg hover:shadow-xl">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ __('otp.submit') }}
                </button>
            </form>

            <!-- Timer and Resend Section -->
            <div class="mt-6 space-y-3">
                <!-- Timer Display -->
                <div id="timer" class="text-gray-600 text-sm font-medium bg-gray-50 rounded-lg py-2 px-4 inline-block"></div>

                <!-- Resend Link -->
                <div>
                    <a id="resendLink"
                       class="inline-flex items-center text-primary hover:text-primary-hover font-semibold text-sm transition-all duration-200 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-redo-alt mr-2"></i>
                        {{ __('otp.resend') }}
                    </a>
                </div>

                <!-- Help Text -->
                <div class="text-xs text-gray-500 mt-4">
                    <p>لم تستلم الرمز؟ تأكد من رقم هاتفك وحاول مرة أخرى</p>
                </div>
            </div>
        </div>

        <!-- Security Info -->
        <div class="mt-6 text-center">
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                <div class="flex items-center justify-center text-white/90 text-sm">
                    <i class="fas fa-lock mr-2"></i>
                    <span>اتصالك محمي بتشفير 256-bit SSL</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        const otpInputs = document.querySelectorAll('.otp-input');
        const resendLink = document.getElementById('resendLink');
        const timerElement = document.getElementById('timer');
        let resendAttempts = 2;
        let timerDuration = 30; // المدة الزمنية للعداد بالثواني

        const messages = {
            timer: "{{ __('otp.timer_message', ['seconds' => ':seconds']) }}",
            resendSuccess: "{{ __('otp.resend_success') }}",
            resendDisabled: "{{ __('otp.resend_disabled') }}"
        };

        function startTimer() {
            resendLink.classList.add('opacity-50', 'cursor-not-allowed', 'pointer-events-none');
            let remainingTime = timerDuration;
            updateTimerDisplay(remainingTime);

            const timer = setInterval(() => {
                remainingTime--;
                updateTimerDisplay(remainingTime);

                if (remainingTime <= 0) {
                    clearInterval(timer);
                    if (resendAttempts > 0) {
                        resendLink.classList.remove('opacity-50', 'cursor-not-allowed', 'pointer-events-none');
                        timerElement.innerHTML = '<i class="fas fa-check-circle text-green-500 mr-1"></i>يمكنك طلب رمز جديد الآن';
                        timerElement.className = 'text-green-600 text-sm font-medium bg-green-50 rounded-lg py-2 px-4 inline-block border border-green-200';
                    } else {
                        timerElement.innerHTML = '<i class="fas fa-times-circle text-red-500 mr-1"></i>' + messages.resendDisabled;
                        timerElement.className = 'text-red-600 text-sm font-medium bg-red-50 rounded-lg py-2 px-4 inline-block border border-red-200';
                    }
                }
            }, 1000);
        }

        function updateTimerDisplay(seconds) {
            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = seconds % 60;
            const timeString = `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;

            timerElement.innerHTML = `<i class="fas fa-clock text-blue-500 mr-1"></i>إعادة الإرسال متاحة خلال ${timeString}`;
            timerElement.className = 'text-blue-600 text-sm font-medium bg-blue-50 rounded-lg py-2 px-4 inline-block border border-blue-200';
        }

        resendLink.addEventListener('click', () => {
            if (resendAttempts > 0 && !resendLink.classList.contains('pointer-events-none')) {
                resendAttempts--;

                // Show success message with animation
                const successDiv = document.createElement('div');
                successDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 z-50';
                successDiv.innerHTML = '<i class="fas fa-check-circle mr-2"></i>' + messages.resendSuccess;
                document.body.appendChild(successDiv);

                setTimeout(() => successDiv.classList.remove('translate-x-full'), 100);
                setTimeout(() => {
                    successDiv.classList.add('translate-x-full');
                    setTimeout(() => document.body.removeChild(successDiv), 300);
                }, 3000);

                startTimer();
            }
        });

        // OTP Input Handling
        otpInputs.forEach((input, index) => {
            // Auto-focus next input
            input.addEventListener('input', (e) => {
                if (e.target.value && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }

                // Add animation effect
                if (e.target.value) {
                    e.target.classList.add('border-primary', 'bg-primary/5', 'scale-110');
                    setTimeout(() => e.target.classList.remove('scale-110'), 150);
                } else {
                    e.target.classList.remove('border-primary', 'bg-primary/5');
                }

                // Check if all inputs are filled
                checkAllInputsFilled();
            });

            // Handle backspace
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && index > 0 && !input.value) {
                    otpInputs[index - 1].focus();
                }
            });

            // Only allow numbers
            input.addEventListener('keypress', (e) => {
                if (!/[0-9]/.test(e.key) && e.key !== 'Backspace') {
                    e.preventDefault();
                }
            });

            // Add focus effects
            input.addEventListener('focus', () => {
                input.classList.add('ring-2', 'ring-primary/20', 'border-primary');
            });

            input.addEventListener('blur', () => {
                if (!input.value) {
                    input.classList.remove('ring-2', 'ring-primary/20', 'border-primary');
                }
            });
        });

        function checkAllInputsFilled() {
            const allFilled = Array.from(otpInputs).every(input => input.value);
            const submitBtn = document.querySelector('button[type="submit"]');

            if (allFilled) {
                submitBtn.classList.add('bg-green-500', 'hover:bg-green-600');
                submitBtn.classList.remove('bg-primary', 'hover:bg-primary-hover');
                submitBtn.innerHTML = '<i class="fas fa-check-circle mr-2"></i>تأكيد الرمز';
            } else {
                submitBtn.classList.remove('bg-green-500', 'hover:bg-green-600');
                submitBtn.classList.add('bg-primary', 'hover:bg-primary-hover');
                submitBtn.innerHTML = '<i class="fas fa-check-circle mr-2"></i>{{ __("otp.submit") }}';
            }
        }

        // Form submission
        const otpForm = document.getElementById('otpForm');
        const otpHiddenInput = document.getElementById('otpHiddenInput');

        otpForm.addEventListener('submit', (e) => {
            let otpValue = '';
            otpInputs.forEach(input => {
                otpValue += input.value;
            });
            otpHiddenInput.value = otpValue;

            // Add loading state
            const submitBtn = document.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>جاري التحقق...';
            submitBtn.disabled = true;
        });

        // Start timer on page load
        startTimer();

        // Add some entrance animations
        window.addEventListener('load', () => {
            const container = document.querySelector('.bg-white\\/95');
            container.classList.add('animate-pulse');
            setTimeout(() => container.classList.remove('animate-pulse'), 1000);
        });
    </script>
</body>

</html>
