{{--
    This is the refactored Privacy Policy page.
    It uses the same header and footer and is styled with Tailwind CSS.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('privacy.title', [], 'ar') }} - المركبة المخملية</title>

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
                    {{ __('privacy.title', [], 'ar') }}
                </h1>
                <p class="text-lg text-gray-300 mt-4">
                    نلتزم بحماية خصوصيتك وتوضيح حقوقك وواجباتك.
                </p>
            </div>
        </section>

        <!-- Policies Content Section -->
        <section class="py-24">
            <div class="container mx-auto px-6 max-w-4xl">

                <!-- Privacy Policy Box -->
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 mb-12">
                    <h2 class="text-3xl font-bold text-velvet mb-6 flex items-center">
                        <i class="fas fa-user-shield text-brand-pink mr-4 text-3xl"></i>
                        {{ __('privacy.privacy.title', [], 'ar') }}
                    </h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">{{ __('privacy.privacy.description', [], 'ar') }}</p>

                    <h3 class="font-semibold text-xl text-velvet-dark mt-8 mb-4">{{ __('privacy.privacy.data_collected', [], 'ar') }}</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-700">
                        @foreach (__('privacy.privacy.data_list', [], 'ar') as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>

                    <h3 class="font-semibold text-xl text-velvet-dark mt-8 mb-4">{{ __('privacy.privacy.protection', [], 'ar') }}</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-700">
                        @foreach (__('privacy.privacy.protection_list', [], 'ar') as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>

                <!-- Terms & Conditions Box -->
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 mb-12">
                    <h2 class="text-3xl font-bold text-velvet mb-6 flex items-center">
                        <i class="fas fa-file-contract text-brand-pink mr-4 text-3xl"></i>
                        {{ __('privacy.terms.title', [], 'ar') }}
                    </h2>
                    <ul class="list-disc list-inside space-y-2 text-gray-700 mb-6">
                        @foreach (__('privacy.terms.terms_list', [], 'ar') as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>

                    <h3 class="font-semibold text-xl text-velvet-dark mt-8 mb-4">{{ __('privacy.terms.payment', [], 'ar') }}</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-700">
                         @foreach (__('privacy.terms.payment_list', [], 'ar') as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>

                    <h3 class="font-semibold text-xl text-velvet-dark mt-8 mb-4">{{ __('privacy.terms.cancellation', [], 'ar') }}</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-700">
                         @foreach (__('privacy.terms.cancellation_list', [], 'ar') as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>

                <!-- Refund Policy Box -->
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 mb-12">
                    <h2 class="text-3xl font-bold text-velvet mb-6 flex items-center">
                        <i class="fas fa-undo text-brand-pink mr-4 text-3xl"></i>
                        {{ __('privacy.refund.title', [], 'ar') }}
                    </h2>

                    <h3 class="font-semibold text-xl text-velvet-dark mt-8 mb-4">{{ __('privacy.refund.problem', [], 'ar') }}</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-700">
                        @foreach (__('privacy.refund.problem_list', [], 'ar') as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>

                    <h3 class="font-semibold text-xl text-velvet-dark mt-8 mb-4">{{ __('privacy.refund.how_to_refund', [], 'ar') }}</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-700">
                        @foreach (__('privacy.refund.how_to_refund_list', [], 'ar') as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>

                <!-- Modification Policy Box -->
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12">
                    <h2 class="text-3xl font-bold text-velvet mb-6 flex items-center">
                        <i class="fas fa-edit text-brand-pink mr-4 text-3xl"></i>
                        {{ __('privacy.modification.title', [], 'ar') }}
                    </h2>
                    <ul class="list-disc list-inside space-y-2 text-gray-700">
                        @foreach (__('privacy.modification.modification_list', [], 'ar') as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </section>
    </main>

    {{-- Include the consistent footer --}}
    @include('web.footer')

</body>
</html>
