<style>
    body {
        font-family: "Cairo", sans-serif;
    }

    .navbar-custom {
        background-color: #ffffff;
        padding: 15px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .navbar-custom .navbar-brand,
    .navbar-custom .nav-link {
        color: #4a2f85;
        transition: color 0.3s ease;
    }

    .navbar-custom .navbar-brand:hover,
    .navbar-custom .nav-link:hover {
        color: #ed0f7d;
    }

    .navbar-toggler {
        border: none;
    }

    .dropdown-menu {
        text-align: right;
    }

    .user-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .btn-custom {
        padding: 10px 20px;
        text-decoration: none;
        color: #4a2f85;
        border: 1px solid #4a2f85;
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s;
    }

    .btn-custom:hover {
        background-color: #ed0f7d;
        color: white;
    }

    .cart-counter {
        position: absolute;
        top: 0;
        right: 0;
        background-color: #ed0f7d;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        text-align: center;
        font-size: 12px;
        line-height: 20px;
    }

    /* Language Switcher */
    .language-switcher {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 25px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #4a2f85;
    }

    input:checked+.slider:before {
        transform: translateX(26px);
    }


    @media (max-width: 768px) {
        .navbar-custom {
            padding: 10px;
        }

        .btn-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    }
</style>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('assets/img/logo-ct-dark.png') }}" alt="Logo" class="user-icon">
            المركبة المخملية
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="bi bi-list" style="font-size: 1.5rem; color: #4a2f85;"></i>
            </span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">{{ __('navbar.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about-us') }}">{{ __('navbar.about_us') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('privacy-policy') }}">{{ __('navbar.privacy_policy') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact-us') }}">{{ __('navbar.contact_us') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('services') }}">{{ __('navbar.services') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('subscribtion') }}">{{ __('navbar.subscribtion') }}</a>
                </li>
            </ul>

            <!-- Language Switcher -->
            <form action="{{ route('change-language') }}" method="POST" id="languageForm">
                @csrf
                <input type="hidden" name="language" id="languageInput" value="{{ app()->getLocale() }}">
                <div class="language-switcher d-flex align-items-center">
                    <label class="switch">
                        <input type="checkbox" id="languageSwitch" {{ app()->getLocale() == 'en' ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                    <span class="ms-2" id="languageLabel">{{ __('navbar.language') }}</span>
                </div>
            </form>

            <div class="btn-container d-lg-flex align-items-center">
                <!-- Cart Icon with Counter -->
                @if (Auth::check())
                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none" id="userDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Auth::user()->image ?? asset('images/default-avatar.png') }}"
                                alt="User Avatar" class="user-icon me-2">
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">{{ __('navbar.profile') }}</a>
                            </li>
                            <li><a class="dropdown-item"
                                    href="{{ route('user.orders') }}">{{ __('navbar.orders') }}</a></li>
                            <li><a class="dropdown-item"
                                    href="{{ route('user.subscriptions') }}">{{ __('navbar.subscriptions') }}</a>
                            </li>
                            @if (!in_array(auth()->user()->role, ['factor', 'company', 'customer']))
                                <li><a class="dropdown-item"
                                        href="{{ route('home.dashboard') }}">{{ __('navbar.dashboard') }}</a></li>
                            @endif
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('navbar.logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="btn-custom" href="{{ route('login') }}">{{ __('navbar.login') }}</a>
                @endif
            </div>


        </div>
    </div>
</nav>

<script>
    document.getElementById('languageSwitch').addEventListener('change', function() {
        const language = this.checked ? 'en' : 'ar'; // اختيار اللغة بناءً على حالة السويتش
        document.getElementById('languageInput').value = language; // تحديث الحقل المخفي
        document.getElementById('languageForm').submit(); // إرسال النموذج
    });
</script>
