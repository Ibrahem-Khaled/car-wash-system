<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
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
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">المركبة المخملية</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">
                    <i class="bi bi-list" style="font-size: 1.5rem; color: #4a2f85;"></i>
                </span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about-us') }}">من نحن</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#privacy">سياسة الخصوصية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact-us') }}">تواصل معنا</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('services') }}">الخدمات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('subscribtion') }}">الاشتراكات</a>
                    </li>
                </ul>

                <div class="btn-container d-lg-flex align-items-center">
                    <!-- Cart Icon with Counter -->
                    <div class="position-relative me-3">
                        <a href="{{ route('user.carts') }}" class="text-decoration-none">
                            <i class="fas fa-shopping-cart" style="font-size: 1.5rem; color: #4a2f85;"></i>
                            {{-- <span class="cart-counter">{{ App\Models\Cart::count() }}</span> --}}
                        </a>
                    </div>

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
                                <li><a class="dropdown-item" href="{{ route('profile') }}">الملف الشخصي</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.orders') }}">طلباتي</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.subscriptions') }}">اشتراكاتي</a>
                                </li>
                                @if (!in_array(auth()->user()->role, ['factor', 'company', 'customer']))
                                    <li><a class="dropdown-item" href="{{ route('home.dashboard') }}">لوحة التحكم</a>
                                    </li>
                                @else
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        تسجيل الخروج
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a class="btn-custom" href="{{ route('login') }}">تسجيل الدخول</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</body>

</html>
