{{--
    This is the fully refactored Customer Loyalty Card page.
    It uses the same header and footer and is styled with Tailwind CSS.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بطاقة الولاء - {{ $user->name }}</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Cairo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Alpine.js for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f8f9fa; scroll-behavior: smooth; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background-color: #1e1b4b; }
        ::-webkit-scrollbar-thumb { background-color: #8b5cf6; border-radius: 10px; border: 2px solid #1e1b4b; }
    </style>

    <script>
        // Customizing Tailwind theme
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'velvet': '#4a2f85',
                        'velvet-light': '#6d44a6',
                        'velvet-dark': '#3a236a',
                        'brand-pink': '#ed0f7d',
                        'glow': 'rgba(167, 139, 250, 0.5)',
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
        <!-- Page Header Section -->
        <section class="bg-gradient-to-br from-velvet-dark to-indigo-900 text-white pt-32 pb-20">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold drop-shadow-lg">بطاقة الولاء الرقمية</h1>
                <p class="text-lg text-gray-300 mt-4 max-w-2xl mx-auto">نقدر ولاءك! هنا يمكنك تتبع نقاطك، هداياك، وإضافة بطاقتك إلى محفظتك الرقمية.</p>
            </div>
        </section>

        <!-- Loyalty Card Section -->
        <section class="py-24">
            <div class="container mx-auto px-6">
                <div class="grid lg:grid-cols-3 gap-10">
                    <!-- Customer Card -->
                    <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl p-8">
                        @if (session('success'))
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
                                <p class="font-bold"><i class="fas fa-check-circle mr-2"></i> نجاح</p>
                                <p>{{ session('success') }}</p>
                            </div>
                        @endif
                        @if (session('error'))
                             <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
                                <p class="font-bold"><i class="fas fa-exclamation-circle mr-2"></i> خطأ</p>
                                <p>{{ session('error') }}</p>
                            </div>
                        @endif

                        <div class="flex items-center mb-8">
                            <div class="w-20 h-20 bg-velvet text-white rounded-full flex items-center justify-center text-4xl font-bold ml-6">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <h2 class="text-3xl font-bold text-velvet">{{ $user->name }}</h2>
                                <p class="text-gray-500">{{ $user->phone }}</p>
                            </div>
                        </div>

                        <h3 class="text-2xl font-bold text-velvet-dark mb-6 border-b pb-4">إحصائيات الولاء</h3>
                        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                            <div class="bg-gray-50 p-4 rounded-lg"><p class="text-sm text-gray-500">إجمالي الخدمات</p><p class="text-3xl font-bold text-velvet-dark">{{ $loyalty['totalServices'] }}</p></div>
                            <div class="bg-gray-50 p-4 rounded-lg"><p class="text-sm text-gray-500">إجمالي الهدايا</p><p class="text-3xl font-bold text-velvet-dark">{{ $loyalty['totalGifts'] }}</p></div>
                            <div class="bg-gray-50 p-4 rounded-lg"><p class="text-sm text-gray-500">متبقي للهدية</p><p class="text-3xl font-bold text-velvet-dark">{{ $loyalty['remainingForGift'] }}</p></div>
                            <div class="bg-brand-pink/10 p-4 rounded-lg border-2 border-brand-pink"><p class="text-sm text-brand-pink">هدايا متاحة</p><p class="text-3xl font-bold text-brand-pink">{{ $loyalty['unusedGiftsCount'] }}</p></div>
                        </div>

                        @if ($loyalty['unusedGiftsCount'] > 0)
                        <div class="mt-10 text-center bg-green-50 border-2 border-dashed border-green-400 rounded-lg p-6">
                            <p class="text-xl font-bold text-green-800 mb-4"><i class="fas fa-gift"></i> لديك {{ $loyalty['unusedGiftsCount'] }} خدمة مجانية متاحة للاستخدام!</p>
                            <form action="{{ route('loyalty.useGift', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-green-700 transition-colors duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    استخدام خدمة مجانية الآن
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>

                    <!-- QR & Wallet Card -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-xl p-8 text-center sticky top-28">
                            <h3 class="text-2xl font-bold text-velvet mb-4">بطاقتك الرقمية</h3>
                            <div class="p-4 bg-gray-100 rounded-lg inline-block border">
                                {!! QrCode::size(180)->generate($qrCodeUrl) !!}
                            </div>
                            <div class="mt-8">
                                <p class="text-gray-500 mb-4">أضف بطاقتك إلى محفظة هاتفك للوصول السريع!</p>
                                <div class="space-y-4">
                                     @if (!empty($googlePassData['success']))
                                        <a href="https://pay.google.com/gp/v/c/{{ $googlePassData['signedJwt'] }}" target="_blank" class="w-full flex items-center justify-center bg-black text-white p-3 rounded-lg hover:bg-gray-800 transition-colors">
                                            <img src="https://cdn-icons-png.flaticon.com/128/196/196556.png" alt="Google Wallet" class="w-8 h-8 ml-3">
                                            <span>أضف إلى Google Wallet</span>
                                        </a>
                                    @endif
                                    @if (!empty($applePassData['success']))
                                        <a href="{{ $applePassData['downloadUrl'] }}" class="w-full flex items-center justify-center bg-black text-white p-3 rounded-lg hover:bg-gray-800 transition-colors">
                                            <i class="fab fa-apple text-2xl ml-3"></i>
                                            <span>أضف إلى Apple Wallet</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('web.footer')

</body>
</html>
