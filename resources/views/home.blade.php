{{--
    This is the main home page view.
    It includes the header and footer and displays all dynamic content.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المركبة المخملية - الرئيسية</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Cairo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Alpine.js for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Swiper.js for slider -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f8f9fa; scroll-behavior: smooth; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background-color: #1e1b4b; }
        ::-webkit-scrollbar-thumb { background-color: #8b5cf6; border-radius: 10px; border: 2px solid #1e1b4b; }

        /* Swiper Hero Slider Styles */
        .hero-slider .swiper-slide {
            height: 100vh;
            background-size: cover;
            background-position: center;
        }
        .hero-slider .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background-color: rgba(255, 255, 255, 0.5);
            opacity: 1;
            transition: all 0.3s ease;
        }
        .hero-slider .swiper-pagination-bullet-active {
            width: 30px;
            border-radius: 5px;
            background-color: #fff;
        }
        .hero-slider .swiper-button-next, .hero-slider .swiper-button-prev {
            color: #fff !important;
        }
    </style>

    <script>
        // Customizing Tailwind theme
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'velvet': '#4a2f85', 'velvet-light': '#6d44a6', 'velvet-dark': '#3a236a',
                        'brand-pink': '#ed0f7d', 'glow': 'rgba(167, 139, 250, 0.5)',
                    },
                    fontFamily: { cairo: ['Cairo', 'sans-serif'] },
                    boxShadow: { 'glow-violet': '0 0 25px rgba(167, 139, 250, 0.6)' }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100 font-cairo">

    @include('web.header')

    <main>
        <!-- Hero Section with Swiper Slider -->
        <section class="hero-slider swiper h-screen">
            <div class="swiper-wrapper">
                @foreach($slideShows as $slide)
                <div class="swiper-slide" style="background-image: url('{{ asset('storage/' . $slide->image) }}');">
                    <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
                        <div class="text-center text-white px-4 z-10">
                            <h1 class="text-5xl md:text-7xl font-extrabold mb-4 drop-shadow-lg">{{ $slide->title }}</h1>
                            <p class="text-lg md:text-xl text-gray-300 max-w-3xl mx-auto mb-8">{!! $slide->description !!}</p>
                            @if($slide->link)
                            <a href="{{ $slide->link }}" class="bg-violet-600 hover:bg-brand-pink text-white font-bold py-3 px-8 rounded-full text-lg transition-all duration-300 transform hover:scale-105 shadow-glow-violet">
                                اكتشف الآن
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
            <!-- Add Navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </section>

        <!-- Main Services Section -->
        <section id="services" class="py-24 bg-gray-50">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-4xl font-bold text-gray-800 mb-3">خدماتنا الرئيسية</h2>
                <p class="text-gray-600 mb-16 max-w-xl mx-auto">نقدم لكم باقة من الخدمات الأساسية التي تضمن العناية الفائقة بسيارتكم.</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @forelse($mainServices as $service)
                    <a href="#" class="group relative block rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300">
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-80 object-cover transform group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black bg-opacity-50 group-hover:bg-opacity-60 transition-all duration-300 flex items-center justify-center p-4">
                            <h3 class="text-white text-2xl font-bold drop-shadow-md">{{ $service->name }}</h3>
                        </div>
                    </a>
                    @empty
                    <p class="col-span-full text-gray-500">لا توجد خدمات متاحة حالياً.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Latest Sub-Products Section -->
        <section id="products" class="py-24 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-800 mb-3">أحدث المنتجات</h2>
                    <p class="text-gray-600 max-w-xl mx-auto">تشكيلة من أفضل منتجات العناية بالسيارات التي تضمن لك نتائج مبهرة.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @forelse($latestSubProducts as $product)
                    <div class="group bg-gray-50 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col">
                        <div class="overflow-hidden">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-500 mb-4 flex-grow text-sm">{{ $product->description }}</p>
                            <div class="flex justify-between items-center mt-auto">
                                <span class="text-2xl font-bold text-velvet">
                                    <span class="text-sm font-normal text-gray-500">يبدأ من</span> {{ $product->small_car_price }} <span class="text-base font-normal">ر.س</span>
                                </span>
                                <button class="bg-velvet text-white px-5 py-2 rounded-lg hover:bg-brand-pink transition-colors duration-300 transform group-hover:scale-105">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="col-span-full text-center text-gray-500">لا توجد منتجات متاحة حالياً.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Subscriptions Section -->
        <section id="subscriptions" class="py-24 bg-velvet-dark" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-4xl font-bold text-white mb-3">باقات الاشتراك الشهرية</h2>
                <p class="text-gray-300 mb-16 max-w-xl mx-auto">انضم إلى باقاتنا واحصل على عناية دورية ومميزة لسيارتك بأسعار لا تضاهى.</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @forelse($subscriptions as $subscription)
                    <div class="group bg-white rounded-2xl shadow-lg p-8 flex flex-col transition-all duration-300 transform hover:-translate-y-3 hover:shadow-glow-violet">
                        <div class="flex-grow">
                            <img src="{{ asset('storage/' . $subscription->image) }}" alt="{{ $subscription->name }}" class="w-24 h-24 mx-auto mb-6 rounded-full border-4 border-velvet-light object-cover">
                            <h3 class="text-2xl font-bold text-velvet mb-2">{{ $subscription->name }}</h3>
                            <p class="text-gray-600 mb-6">{{ $subscription->description }}</p>
                        </div>
                        <div class="mt-auto">
                            <p class="text-4xl font-extrabold text-gray-800 mb-4">{{ $subscription->price }} <span class="text-lg font-medium text-gray-500">ر.س/شهرياً</span></p>
                            <button class="w-full bg-brand-pink text-white font-bold py-3 px-6 rounded-lg hover:bg-velvet transition-colors duration-300">
                                اشترك الآن
                            </button>
                        </div>
                    </div>
                    @empty
                    <p class="col-span-full text-center text-gray-300">لا توجد باقات اشتراك متاحة حالياً.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Latest Reviews Section -->
        <section id="reviews" class="py-24 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-800 mb-3">أحدث التقييمات</h2>
                    <p class="text-gray-600 max-w-xl mx-auto">آراء عملائنا هي شهادة على جودة خدماتنا ومنتجاتنا.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @forelse($latestReviews as $review)
                    <div class="bg-gray-50 p-8 rounded-2xl shadow-lg border-t-4 border-velvet">
                        <div class="flex items-center mb-4">
                            <img src="{{ $review->user->image ? asset('storage/' . $review->user->image) : 'https://placehold.co/100x100/e0e0e0/333?text=' . substr($review->user->name, 0, 1) }}" alt="{{ $review->user->name }}" class="w-14 h-14 rounded-full object-cover ml-4 border-2 border-velvet-light">
                            <div>
                                <h4 class="text-lg font-bold text-gray-800">{{ $review->user->name }}</h4>
                                <div class="text-yellow-400">
                                    @for ($i = 0; $i < 5; $i++)
                                        <i class="fa-star {{ $i < $review->rating ? 'fas' : 'far' }}"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600 italic">"{{ $review->comment }}"</p>
                    </div>
                    @empty
                    <p class="col-span-full text-center text-gray-500">لا توجد تقييمات متاحة حالياً.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </main>

    @include('web.footer')

    <script>
        // Initialize Swiper for the hero slider
        const heroSwiper = new Swiper('.hero-slider', {
            loop: true,
            effect: 'fade',
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
</body>
</html>
