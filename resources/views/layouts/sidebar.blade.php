<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('storage/' . $companyUser->image) }}" class="h-50 w-50 rounded-circle" alt="main_logo">
        </div>
        <div class="sidebar-brand-text mx-3">{{$companyUser->name}}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>الموقع الرئيسي</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        الإدارة
    </div>

    <!-- Nav Items -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-fw fa-user-plus"></i>
            <span>انشاء مستخدم او عامل</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('products.index') }}">
            <i class="fas fa-fw fa-box"></i>
            <span>الخدمات</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('cars.index') }}">
            <i class="fas fa-fw fa-car"></i>
            <span>السيارات</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('carts.index') }}">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>الطلبات</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('subscriptions.index') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>ادارة الاشتراك</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('user_ratings.index') }}">
            <i class="fas fa-fw fa-star"></i>
            <span>تقييمات المستخدم</span>
        </a>
    </li>

    <!-- Nav Item - Loyalty Program (New Section) -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLoyalty"
           aria-expanded="true" aria-controls="collapseLoyalty">
            <i class="fas fa-fw fa-award"></i>
            <span>نقاط الولاء</span>
        </a>
        <div id="collapseLoyalty" class="collapse" aria-labelledby="headingLoyalty" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">إدارة الولاء:</h6>
                {{-- استخدمت الرابط الذي أنشأناه في الخطوة السابقة هنا --}}
                <a class="collapse-item" href="{{ route('wallet.edit') }}">تصميم البطاقة</a>
                <a class="collapse-item" href="#">إعدادات البرنامج</a>
                <a class="collapse-item" href="#">مستويات الأعضاء</a>
                <a class="collapse-item" href="#">كتالوج المكافآت</a>
                <a class="collapse-item" href="#">تقارير الولاء</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('slide_shows.index') }}">
            <i class="fas fa-fw fa-images"></i>
            <span>الصور المتحركة</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('notifications.index') }}">
            <i class="fas fa-fw fa-bell"></i>
            <span>ادارة الاشعارات</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('contact-us.index') }}">
            <i class="fas fa-fw fa-envelope"></i>
            <span>التواصل معنا</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Site Management -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSiteManagement"
           aria-expanded="true" aria-controls="collapseSiteManagement">
            <i class="fas fa-fw fa-cogs"></i>
            <span>إدارة الموقع</span>
        </a>
        <div id="collapseSiteManagement" class="collapse" aria-labelledby="headingSiteManagement" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">إعدادات الموقع:</h6>
                <a class="collapse-item" href="{{ route('dashboard.settings.edit') }}">بيانات الموقع</a>
                <a class="collapse-item" href="#">سياسة الخصوصية</a>
                <a class="collapse-item" href="#">شروط الاستخدام</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        الإعدادات
    </div>

    <!-- Nav Items -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('profile') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>الصفحة الشخصية</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('live.chat') }}">
            <i class="fas fa-fw fa-comments"></i>
            <span>محادثة مباشرة</span>
        </a>
    </li>


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline mt-4">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
