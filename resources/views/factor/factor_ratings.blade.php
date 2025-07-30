{{--
    This is the fully refactored Rating page.
    It uses the same header and footer, is styled with Tailwind CSS, and includes an interactive star rating system.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('rating.title', [], 'ar') }} - المركبة المخملية</title>

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
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
            scroll-behavior: smooth;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background-color: #1e1b4b;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #8b5cf6;
            border-radius: 10px;
            border: 2px solid #1e1b4b;
        }
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
                    fontFamily: {
                        cairo: ['Cairo', 'sans-serif']
                    },
                    boxShadow: {
                        'glow-violet': '0 0 25px rgba(167, 139, 250, 0.6)'
                    }
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
                <h1 class="text-4xl md:text-5xl font-extrabold drop-shadow-lg">{{ __('rating.title', [], 'ar') }}</h1>
                <p class="text-lg text-gray-300 mt-4 max-w-2xl mx-auto">رأيك يهمنا ويساعدنا على تحسين خدماتنا. شاركنا
                    تجربتك.</p>
            </div>
        </section>

        <!-- Rating Form Section -->
        <section class="py-24">
            <div class="container mx-auto px-6 max-w-2xl">
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-velvet mb-2">تقييم الخدمة للطلب رقم #{{ $order->id }}</h2>
                        <p class="text-gray-500">نأمل أن تكون راضيًا عن الخدمة المقدمة.</p>
                    </div>

                    <form action="{{ route('worker.rate') }}" method="POST" x-data="{ rating: 0, hoverRating: 0 }">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        <!-- Star Rating Component -->
                        <div class="mb-8">
                            <label
                                class="block text-center font-semibold text-gray-700 mb-4">{{ __('rating.rating_label', [], 'ar') }}</label>
                            <div
                                class="flex items-center justify-center space-x-4 space-x-reverse text-5xl text-gray-300">
                                <template x-for="star in 5">
                                    <i class="fas fa-star cursor-pointer transition-colors duration-200"
                                        @click="rating = star" @mouseenter="hoverRating = star"
                                        @mouseleave="hoverRating = 0"
                                        :class="{ 'text-yellow-400': hoverRating >= star || rating >= star }"></i>
                                </template>
                            </div>
                            <input type="hidden" name="rating" x-model="rating" required>
                            @error('rating')
                                <p class="text-red-500 text-xs mt-2 text-center">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Comment Textarea -->
                        <div class="mb-8">
                            <label for="comment"
                                class="block font-semibold text-gray-700 mb-2">{{ __('rating.comment_label', [], 'ar') }}</label>
                            <textarea
                                class="w-full p-3 bg-gray-100 border-2 border-gray-200 rounded-lg focus:border-velvet focus:ring-velvet transition"
                                id="comment" name="comment" rows="5" placeholder="{{ __('rating.comment_placeholder', [], 'ar') }}"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit"
                                class="w-full md:w-auto bg-brand-pink text-white font-bold py-3 px-10 rounded-lg hover:bg-velvet transition-colors duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                {{ __('rating.submit', [], 'ar') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    @include('web.footer')

</body>

</html>
