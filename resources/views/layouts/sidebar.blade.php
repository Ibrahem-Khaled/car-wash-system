<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header d-flex justify-content-between align-items-center">
        <a class="navbar-brand m-0" href="{{ route('home') }}">
            <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white">لوحة تحكم تطبيق غسيل السيارات</span>
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
                <a class="nav-link text-white" href="{{ route('users.index') }}">
                    <i class="fas fa-user-plus"></i>
                    <span class="nav-link-text ms-1">انشاء مستخدم او عامل</span>
                </a>
            </li>

            <!-- المنتجات -->
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('products.index') }}">
                    <i class="fas fa-box"></i>
                    <span class="nav-link-text ms-1">المنتجات</span>
                </a>
            </li>

            <!-- السيارات -->
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('cars.index') }}">


                    <i class="fas fa-car"></i>
                    <span class="nav-link-text ms-1">السيارات</span>
                </a>
            </li>

            <!-- الطلبات -->
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('carts.index') }}">


                    <i class="fas fa-shopping-cart"></i>
                    <span class="nav-link-text ms-1">الطلبات</span>
                </a>
            </li>

            <!-- تقييمات المستخدم -->
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('user_ratings.index') }}">


                    <i class="fas fa-star"></i>
                    <span class="nav-link-text ms-1">تقييمات المستخدم</span>
                </a>
            </li>

            <!-- الصور المتحركة -->
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('slide_shows.index') }}">


                    <i class="fas fa-images"></i>
                    <span class="nav-link-text ms-1">الصور المتحركة</span>
                </a>
            </li>

            <!-- إدارة الإشعارات -->
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('notifications.index') }}">
                    <i class="fas fa-bell"></i>
                    <span class="nav-link-text ms-1">ادارة الاشعارات</span>
                </a>
            </li>

            <!-- الصفحة الشخصية -->
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('profile') }}">
                    <i class="fas fa-user"></i>
                    <span class="nav-link-text ms-1">الصفحة الشخصية</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('contact-us.index') }}">
                    <i class="fas fa-envelope"></i>
                    <span class="nav-link-text ms-1"> التواصل معنا</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
