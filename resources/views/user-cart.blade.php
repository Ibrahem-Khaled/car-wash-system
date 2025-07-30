{{--
    This is the fully refactored Shopping Cart page.
    It uses the same header and footer and is styled with Tailwind CSS.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عربة التسوق - المركبة المخملية</title>

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
                    عربة التسوق
                </h1>
                <p class="text-lg text-gray-300 mt-4 max-w-2xl mx-auto">
                    مراجعة طلباتك خطوة أخيرة قبل الحصول على العناية الفائقة.
                </p>
            </div>
        </section>

        <!-- Cart Section -->
        <section class="py-24">
            <div class="container mx-auto px-6">
                @if ($carts->isEmpty())
                    <!-- Empty Cart State -->
                    <div class="text-center bg-white p-12 rounded-2xl shadow-xl">
                        <i class="fas fa-shopping-cart text-velvet-light text-6xl mb-6"></i>
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">عربة التسوق فارغة</h2>
                        <p class="text-gray-500 mb-8">لم تقم بإضافة أي خدمات بعد. تصفح خدماتنا المميزة الآن!</p>
                        <a href="{{ route('services') }}" class="bg-brand-pink text-white font-bold py-3 px-8 rounded-lg hover:bg-velvet transition-colors duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            تصفح الخدمات
                        </a>
                    </div>
                @else
                    <form method="POST" action="{{ route('user.carts.updatePayment') }}">
                        @csrf
                        <div class="grid lg:grid-cols-3 gap-10">
                            <!-- Cart Items -->
                            <div class="lg:col-span-2 space-y-6">
                                @foreach ($carts as $item)
                                <div class="bg-white rounded-2xl shadow-lg p-6 flex items-start space-x-6 space-x-reverse">
                                    <img src="{{ asset('storage/' . optional($item->product)->image) }}" alt="{{ optional($item->product)->name ?? 'لا يوجد اسم' }}" class="w-24 h-24 object-cover rounded-lg flex-shrink-0">
                                    <div class="flex-grow">
                                        <h3 class="text-xl font-bold text-velvet">{{ optional($item->product)->name ?? 'اسم غير متوفر' }}</h3>
                                        <p class="text-sm text-gray-500 mt-1"><strong>نوع السيارة:</strong> {{ ucfirst($item->car_type ?? 'غير محدد') }}</p>
                                        <p class="text-sm text-gray-500"><strong>تاريخ الغسيل:</strong> {{ $item->car_wash ? $item->car_wash : 'لم يتم التحديد' }}</p>
                                        <a href="{{ route('user.carts.destroy', $item->id) }}" class="text-red-500 hover:text-red-700 text-sm font-semibold mt-3 inline-block transition-colors">
                                            <i class="fas fa-trash-alt mr-1"></i> حذف
                                        </a>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-lg font-bold text-gray-800">{{ $item->price ?? '0.00' }} ريال</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Order Summary -->
                            <div class="lg:col-span-1">
                                <div class="bg-white rounded-2xl shadow-xl p-6 sticky top-28">
                                    <h3 class="text-2xl font-bold text-velvet border-b pb-4 mb-4">ملخص الطلب</h3>
                                    <div class="space-y-3 text-gray-700">
                                        @php
                                            $subtotal = $carts->sum('price');
                                            $tax = $subtotal * 0.15;
                                            $total = $subtotal + $tax;
                                        @endphp
                                        <div class="flex justify-between">
                                            <span>الإجمالي</span>
                                            <span class="font-semibold">{{ number_format($subtotal, 2) }} ريال</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>الضريبة (15%)</span>
                                            <span class="font-semibold">{{ number_format($tax, 2) }} ريال</span>
                                        </div>
                                        <div class="flex justify-between text-xl font-bold text-velvet-dark border-t pt-4 mt-4">
                                            <span>الإجمالي الكلي</span>
                                            <span>{{ number_format($total, 2) }} ريال</span>
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">طريقة الدفع:</label>
                                        <select id="payment_method" name="payment_method" required class="w-full p-3 bg-gray-100 border-2 border-gray-200 rounded-lg focus:border-velvet focus:ring-velvet transition">
                                            <option value="cash_on_delivery">عند الاستلام</option>
                                            {{-- <option value="paid">بطاقة ائتمانية</option> --}}
                                        </select>
                                    </div>

                                    <div class="mt-8">
                                        <button type="submit" class="w-full bg-brand-pink text-white font-bold py-3 px-8 rounded-lg hover:bg-velvet transition-colors duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                            إتمام الدفع
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </section>
    </main>

    @include('web.footer')

</body>
</html>
