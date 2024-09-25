<style>
    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    .sidenav-header {
        animation: fadeIn 0.5s ease-in-out;
    }

    .icon {
        transition: transform 0.3s ease;
    }

    .icon:hover {
        transform: scale(1.1);
    }

    .nav-link:hover {
        background-color: #eaeaea;
        border-radius: 10px;
    }
</style>

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3"
    id="sidenav-main">
    <div class="sidenav-header d-flex justify-content-between align-items-center">
        <a class="navbar-brand m-0" href="{{ route('home') }}">
            <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">لوحة تحكم تطبيق غسيل السيارات</span>
        </a>
        <button class="btn d-xl-none" type="button" id="iconSidenav">
            <i class="fas fa-times text-secondary"></i>
        </button>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- إنشاء مستخدم -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow bg-white text-center d-flex align-items-center justify-content-center">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <span class="nav-link-text ms-1">انشاء مستخدم او عامل</span>
                </a>
            </li>

            <!-- المنتجات -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('products.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow bg-white text-center d-flex align-items-center justify-content-center">
                        <i class="fas fa-box"></i>
                    </div>
                    <span class="nav-link-text ms-1">المنتجات</span>
                </a>
            </li>

            <!-- السيارات -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cars.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow bg-white text-center d-flex align-items-center justify-content-center">
                        <i class="fas fa-car"></i>
                    </div>
                    <span class="nav-link-text ms-1">السيارات</span>
                </a>
            </li>

            <!-- الطلبات -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('carts.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow bg-white text-center d-flex align-items-center justify-content-center">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <span class="nav-link-text ms-1">الطلبات</span>
                </a>
            </li>

            <!-- تقييمات المستخدم -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user_ratings.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow bg-white text-center d-flex align-items-center justify-content-center">
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="nav-link-text ms-1">تقييمات المستخدم</span>
                </a>
            </li>

            <!-- الصور المتحركة -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('slide_shows.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow bg-white text-center d-flex align-items-center justify-content-center">
                        <i class="fas fa-images"></i>
                    </div>
                    <span class="nav-link-text ms-1">الصور المتحركة</span>
                </a>
            </li>

            <!-- إدارة الإشعارات -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('notifications.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow bg-white text-center d-flex align-items-center justify-content-center">
                        <i class="fas fa-bell"></i>
                    </div>
                    <span class="nav-link-text ms-1">ادارة الاشعارات</span>
                </a>
            </li>

            <!-- الصفحة الشخصية -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile') }}">
                    <div
                        class="icon icon-shape icon-sm shadow bg-white text-center d-flex align-items-center justify-content-center">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="nav-link-text ms-1">الصفحة الشخصية</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
