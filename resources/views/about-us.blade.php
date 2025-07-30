{{--
    This is the refactored About Us page.
    It uses the same header and footer and is styled with Tailwind CSS.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('about.title', [], 'ar') }} - المركبة المخملية</title>

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
        // Customizing Tailwind theme to match the main design
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

    {{-- Include the consistent header --}}
    @include('web.header')

    <main>
        <!-- Page Header Section -->
        <section class="bg-gradient-to-br from-velvet-dark to-indigo-900 text-white pt-32 pb-20">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold drop-shadow-lg">
                    {{ __('about.title', [], 'ar') }}
                </h1>
                <p class="text-lg text-gray-300 mt-4 max-w-2xl mx-auto">
                    تعرف على قصتنا، رؤيتنا، والقيم التي تدفعنا لتقديم الأفضل دائمًا.
                </p>
            </div>
        </section>

        <!-- About Us Content Section -->
        <section class="py-24">
            <div class="container mx-auto px-6">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    <!-- Image Column -->
                    <div class="relative">
                        <img class="w-full h-auto rounded-2xl shadow-2xl" src="{{ asset('assets/img/car-wash.jpg') }}" alt="{{ __('about.title', [], 'ar') }}">
                        <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-velvet/20 rounded-full filter blur-xl -z-10"></div>
                        <div class="absolute -top-4 -left-4 w-32 h-32 bg-brand-pink/20 rounded-full filter blur-xl -z-10"></div>
                    </div>

                    <!-- Text Content Column -->
                    <div class="text-right">
                        <h2 class="text-3xl lg:text-4xl font-bold text-velvet mb-4">{{ __('about.subtitle', [], 'ar') }}</h2>
                        <p class="text-gray-600 leading-relaxed mb-8">{{ __('about.description', [], 'ar') }}</p>

                        <!-- Features Grid -->
                        <div class="grid md:grid-cols-2 gap-8">
                            <!-- Feature 1: Professional Wash -->
                            <div class="flex items-start p-4 rounded-lg transition-all duration-300 hover:bg-velvet-light/10">
                                <i class="fas fa-water text-brand-pink text-3xl mt-1 ml-4"></i>
                                <div>
                                    <h3 class="font-bold text-lg text-velvet-dark mb-1">{{ __('about.features.professional_wash.title', [], 'ar') }}</h3>
                                    <p class="text-gray-500 text-sm">{{ __('about.features.professional_wash.description', [], 'ar') }}</p>
                                </div>
                            </div>

                            <!-- Feature 2: Mobile Service -->
                            <div class="flex items-start p-4 rounded-lg transition-all duration-300 hover:bg-velvet-light/10">
                                <i class="fas fa-map-marker-alt text-brand-pink text-3xl mt-1 ml-4"></i>
                                <div>
                                    <h3 class="font-bold text-lg text-velvet-dark mb-1">{{ __('about.features.mobile_service.title', [], 'ar') }}</h3>
                                    <p class="text-gray-500 text-sm">{{ __('about.features.mobile_service.description', [], 'ar') }}</p>
                                </div>
                            </div>

                            <!-- Feature 3: Quality & Security -->
                            <div class="flex items-start p-4 rounded-lg transition-all duration-300 hover:bg-velvet-light/10">
                                <i class="fas fa-shield-alt text-brand-pink text-3xl mt-1 ml-4"></i>
                                <div>
                                    <h3 class="font-bold text-lg text-velvet-dark mb-1">{{ __('about.features.quality_security.title', [], 'ar') }}</h3>
                                    <p class="text-gray-500 text-sm">{{ __('about.features.quality_security.description', [], 'ar') }}</p>
                                </div>
                            </div>

                            <!-- Feature 4: Quick Service -->
                            <div class="flex items-start p-4 rounded-lg transition-all duration-300 hover:bg-velvet-light/10">
                                <i class="fas fa-clock text-brand-pink text-3xl mt-1 ml-4"></i>
                                <div>
                                    <h3 class="font-bold text-lg text-velvet-dark mb-1">{{ __('about.features.quick_service.title', [], 'ar') }}</h3>
                                    <p class="text-gray-500 text-sm">{{ __('about.features.quick_service.description', [], 'ar') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- Include the consistent footer --}}
    @include('web.footer')

</body>
</html>
