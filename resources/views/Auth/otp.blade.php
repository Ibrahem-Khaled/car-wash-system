<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('auth.title') }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;400;700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            background: linear-gradient(to bottom right, #6200ea, #b388ff);
            font-family: 'Cairo', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #fff;
        }

        .otp-container {
            max-width: 400px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
            background-color: rgba(255, 255, 255, 0.9);
            color: #333;
        }

        .otp-input {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
            text-align: center;
            margin: 0 5px;
            border: 2px solid #ced4da;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .otp-input:focus {
            border-color: #6200ea;
            box-shadow: 0 0 0 0.2rem rgba(98, 0, 234, 0.25);
        }

        .btn-primary {
            background-color: #6200ea;
            border: none;
        }

        .btn-primary:hover {
            background-color: #4b00b5;
        }

        .resend-link {
            color: #6200ea;
            cursor: pointer;
            text-decoration: none;
        }

        .resend-link:hover {
            color: #4b00b5;
        }

        .disabled {
            pointer-events: none;
            opacity: 0.6;
        }
    </style>
</head>

<body>
    <div class="otp-container text-center">
        <h4 class="mb-3">{{ __('otp.title') }}</h4>
        <form id="otpForm" method="POST" action="{{ route('verifyOtp') }}">
            @csrf
            <div class="d-flex justify-content-center mb-4">
                @for ($i = 0; $i < 5; $i++)
                    <input type="text" class="otp-input" maxlength="1" pattern="\d" required>
                @endfor
            </div>
            <input type="hidden" name="otp" id="otpHiddenInput">
            <button type="submit" class="btn btn-primary w-100 mb-3">{{ __('otp.submit') }}</button>
        </form>
        <p id="timer" class="text-muted"></p>
        <a id="resendLink" class="resend-link disabled">{{ __('otp.resend') }}</a>
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
            resendLink.classList.add('disabled');
            let remainingTime = timerDuration;
            timerElement.textContent = messages.timer.replace(':seconds', remainingTime);

            const timer = setInterval(() => {
                remainingTime--;
                timerElement.textContent = messages.timer.replace(':seconds', remainingTime);
                if (remainingTime <= 0) {
                    clearInterval(timer);
                    if (resendAttempts > 0) {
                        resendLink.classList.remove('disabled');
                        timerElement.textContent = '';
                    } else {
                        timerElement.textContent = messages.resendDisabled;
                    }
                }
            }, 1000);
        }

        resendLink.addEventListener('click', () => {
            if (resendAttempts > 0) {
                resendAttempts--;
                alert(messages.resendSuccess);
                startTimer();
            }
        });

        otpInputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && index > 0 && !input.value) {
                    otpInputs[index - 1].focus();
                }
            });
        });

        startTimer();

        const otpForm = document.getElementById('otpForm');
        const otpHiddenInput = document.getElementById('otpHiddenInput');

        otpForm.addEventListener('submit', (e) => {
            let otpValue = '';
            otpInputs.forEach(input => {
                otpValue += input.value;
            });
            otpHiddenInput.value = otpValue;
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
