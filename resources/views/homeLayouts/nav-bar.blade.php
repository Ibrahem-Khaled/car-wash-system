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

        .btn-custom,
        .btn-primary-custom {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease, color 0.3s ease;
            margin-right: 5px;
        }

        .btn-custom {
            color: #4a2f85;
        }

        .btn-custom:hover {
            background-color: #ed0f7d;
            color: #fff;
        }

        .btn-primary-custom {
            background-color: #4a2f85;
            color: #fff;
        }

        .btn-primary-custom:hover {
            background-color: #333;
        }

        .navbar-toggler {
            border: none;
        }

        .dropdown-menu {
            text-align: right;
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

            .btn-custom,
            .btn-primary-custom {
                width: 100%;
                margin-bottom: 10px;
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
                     <!-- Dropdown Menu -->
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            الخدمات والاشتراكات
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                            <li><a class="dropdown-item" href="{{ route('services') }}">الخدمات</a></li>
                            <li><a class="dropdown-item" href="{{ route('subscribtion') }}">الاشتراكات</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="btn-container d-lg-flex">
                @if (Auth::check())
                    <a class="btn-custom" href="{{ route('logout') }}">تسجيل الخروج</a>
                    <a class="btn-primary-custom ms-2" href="{{ route('home.dashboard') }}">لوحة التحكم</a>
                    <a class="btn-primary-custom ms-2" href="#">لوحة التحكم HR</a>
                @else
                    <a class="btn-custom" href="{{ route('login') }}">تسجيل الدخول</a>
                @endif
            </div>
        </div>
    </nav>
</body>

</html>
