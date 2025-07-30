{{--
    This is the fully refactored Contact Us page.
    It uses the same header and footer and is styled with Tailwind CSS.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('contact.title', [], 'ar') }} - المركبة المخملية</title>

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

    @include('web.header')

    <main>
        <!-- Page Header Section -->
        <section class="bg-gradient-to-br from-velvet-dark to-indigo-900 text-white pt-32 pb-20">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold drop-shadow-lg">
                    {{ __('contact.title', [], 'ar') }}
                </h1>
                <p class="text-lg text-gray-300 mt-4 max-w-2xl mx-auto">
                    نحن هنا للإجابة على جميع استفساراتكم. تواصلوا معنا في أي وقت.
                </p>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="py-24">
            <div class="container mx-auto px-6">
                <div class="grid lg:grid-cols-5 gap-10">
                    <!-- Contact Form -->
                    <div class="lg:col-span-3 bg-white p-8 rounded-2xl shadow-xl">
                        <h2 class="text-3xl font-bold text-velvet mb-6">أرسل لنا رسالة</h2>
                        <form method="POST" action="{{ route('contact-us.post') }}" class="space-y-6">
                            @csrf
                            <div>
                                <label for="name" class="sr-only">{{ __('contact.name_placeholder', [], 'ar') }}</label>
                                <input type="text" name="name" id="name" class="w-full p-3 bg-gray-100 border-2 border-gray-200 rounded-lg focus:border-velvet focus:ring-velvet transition" placeholder="{{ __('contact.name_placeholder', [], 'ar') }}" required>
                            </div>
                            <div class="grid sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="email" class="sr-only">{{ __('contact.email_placeholder', [], 'ar') }}</label>
                                    <input type="email" name="email" id="email" class="w-full p-3 bg-gray-100 border-2 border-gray-200 rounded-lg focus:border-velvet focus:ring-velvet transition" placeholder="{{ __('contact.email_placeholder', [], 'ar') }}" required>
                                </div>
                                <div>
                                    <label for="phone" class="sr-only">{{ __('contact.phone_placeholder', [], 'ar') }}</label>
                                    <input type="tel" name="phone" id="phone" class="w-full p-3 bg-gray-100 border-2 border-gray-200 rounded-lg focus:border-velvet focus:ring-velvet transition" placeholder="{{ __('contact.phone_placeholder', [], 'ar') }}">
                                </div>
                            </div>
                            <div>
                                <label for="message" class="sr-only">{{ __('contact.message_placeholder', [], 'ar') }}</label>
                                <textarea name="message" id="message" rows="5" class="w-full p-3 bg-gray-100 border-2 border-gray-200 rounded-lg focus:border-velvet focus:ring-velvet transition" placeholder="{{ __('contact.message_placeholder', [], 'ar') }}" required></textarea>
                            </div>
                            <div>
                                <button type="submit" class="w-full md:w-auto bg-brand-pink text-white font-bold py-3 px-8 rounded-lg hover:bg-velvet transition-colors duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    {{ __('contact.submit_button', [], 'ar') }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Contact Info -->
                    <div class="lg:col-span-2 space-y-8">
                        <div class="bg-white p-8 rounded-2xl shadow-xl">
                            <h3 class="text-2xl font-bold text-velvet mb-4">معلومات التواصل</h3>
                            <div class="space-y-4 text-gray-700">
                                <div class="flex items-start">
                                    <i class="fas fa-map-marker-alt text-brand-pink text-xl mt-1 ml-4"></i>
                                    <div>
                                        <h4 class="font-semibold">{{ __('contact.address', [], 'ar') }}</h4>
                                        <p>{{ $companyUser->address ?? 'العنوان الافتراضي' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-phone text-brand-pink text-xl mt-1 ml-4"></i>
                                    <div>
                                        <h4 class="font-semibold">{{ __('contact.phone', [], 'ar') }}</h4>
                                        <p>{{ $companyUser->phone ?? '+966 00 000 0000' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-envelope text-brand-pink text-xl mt-1 ml-4"></i>
                                    <div>
                                        <h4 class="font-semibold">{{ __('contact.email', [], 'ar') }}</h4>
                                        <a href="mailto:{{ $companyUser->email ?? 'email@example.com' }}" class="text-velvet hover:text-brand-pink transition-colors">{{ $companyUser->email ?? 'email@example.com' }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-8 rounded-2xl shadow-xl">
                            <h3 class="text-2xl font-bold text-velvet mb-4">{{ __('contact.important_disclosures', [], 'ar') }}</h3>
                            <ul class="space-y-3 text-gray-700">
                                <li class="flex items-center"><i class="fas fa-clock text-velvet-light ml-3"></i><strong>{{ __('contact.response_time', [], 'ar') }}:</strong><span class="mr-2">{{ __('contact.response_time_value', [], 'ar') }}</span></li>
                                <li class="flex items-center"><i class="fas fa-tools text-velvet-light ml-3"></i><strong>{{ __('contact.handling_time', [], 'ar') }}:</strong><span class="mr-2">{{ __('contact.handling_time_value', [], 'ar') }}</span></li>
                                <li class="flex items-center"><i class="fas fa-truck text-velvet-light ml-3"></i><strong>{{ __('contact.delivery_time', [], 'ar') }}:</strong><span class="mr-2">{{ __('contact.delivery_time_value', [], 'ar') }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('web.footer')

</body>
</html>
