<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Fonts and icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Cairo", sans-serif;
            font-optical-sizing: auto;
        }

        /* تنسيق النافبار */
        .navbar-custom {
            background-color: #ffffff;
            padding: 30px;
            height: 65px;
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #4a2f85;
            transition: color 0.3s ease;
        }

        .navbar-custom .navbar-brand:hover,
        .navbar-custom .nav-link:hover {
            color: #ed0f7d;
            /* لون ذهبي عند التمرير */
        }

        .btn-custom {
            background-color: #ccc;
            color: #4a2f85;
            padding: 8px 20px;
            border-radius: 5px;
        }

        .btn-custom:hover {
            background-color: #ed0f7d;
            color: #fff;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.5);
        }

        .navbar-toggler-icon {
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-list" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2.5 3a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5z"/></svg>');
        }

        section {
            padding: 100px 0;
            margin-top: 60px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom ">
        <div class="container">
            <!-- اللوجو -->
            <a class="navbar-brand" href="{{ route('home') }}">المركبة المخملية</a>

            <!-- زر التبديل للجوالات -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- الروابط -->
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#about">من نحن</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#privacy">سياسة الخصوصية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#subscriptions">الاشتراكات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">تواصل معنا</a>
                    </li>
                </ul>
            </div>

            @if (Auth::check())
                <a class="btn btn-custom" href="{{ route('logout') }}">تسجيل الخروج</a>
                <a class="btn btn-primary" style="background-color: #4a2f85; border-color: #4a2f85;"
                    href="{{ route('home.dashboard') }}">لوحة التحكم</a>
            @else
                <a class="btn btn-custom" href="{{ route('login') }}">تسجيل الدخول</a>
            @endif
        </div>
    </nav>
    <!-- جافا سكريبت -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // إضافة سلاسة في التمرير
        document.querySelectorAll('.nav-link').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>
