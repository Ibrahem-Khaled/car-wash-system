{{--
    This is the fully refactored Orders page.
    It uses the same header and footer, is styled with Tailwind CSS, and includes an interactive review modal.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلباتي - المركبة المخملية</title>

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

<body class="bg-gray-100 font-cairo" x-data="pageData()">

    @include('web.header')

    <main>
        <!-- Page Header Section -->
        <section class="bg-gradient-to-br from-velvet-dark to-indigo-900 text-white pt-32 pb-20">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold drop-shadow-lg">{{ __('orders.title') }}</h1>
                <p class="text-lg text-gray-300 mt-4 max-w-2xl mx-auto">تتبع طلباتك الحالية واطلع على سجل طلباتك السابقة بكل سهولة.</p>
            </div>
        </section>

        <!-- Orders Section with Tabs -->
        <section class="py-24" x-data="{ activeTab: 'current' }">
            <div class="container mx-auto px-6">
                <!-- Tab Buttons -->
                <div class="flex justify-center mb-12 border-b border-gray-300">
                    <button @click="activeTab = 'current'" :class="{ 'border-velvet text-velvet': activeTab === 'current', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-400': activeTab !== 'current' }" class="py-4 px-6 block font-semibold border-b-2 focus:outline-none transition-colors duration-300">
                        <i class="fas fa-stream mr-2"></i> {{ __('orders.current_orders') }}
                    </button>
                    <button @click="activeTab = 'past'" :class="{ 'border-velvet text-velvet': activeTab === 'past', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-400': activeTab !== 'past' }" class="py-4 px-6 block font-semibold border-b-2 focus:outline-none transition-colors duration-300">
                        <i class="fas fa-history mr-2"></i> {{ __('orders.past_orders') }}
                    </button>
                </div>

                <!-- Current Orders Tab -->
                <div x-show="activeTab === 'current'">
                    <div class="grid md:grid-cols-2 gap-8">
                        @php
                            $currentOrders = $orders->whereIn('status', ['accepted', 'pending', 'completed'])->filter(fn($item) => optional($item->reviews)->isEmpty());
                        @endphp
                        @forelse ($currentOrders as $item)
                        <div class="bg-white rounded-2xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-xl font-bold text-velvet"> {{ __('orders.order_number') }} #{{ $item->id }}</h3>
                                    <p class="text-gray-600">{{ optional($item->product)->name }}</p>
                                </div>
                                <span class="px-3 py-1 text-sm font-semibold rounded-full
                                    @if($item->status == 'completed') bg-green-100 text-green-800
                                    @elseif($item->status == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ __('orders.statuses.' . $item->status, [], 'ar') }}
                                </span>
                            </div>
                            <div class="border-t my-4"></div>
                            <div class="flex justify-between items-center text-sm text-gray-500">
                                <span><strong>{{ __('orders.order_date') }}:</strong> {{ $item->created_at->format('Y-m-d') }}</span>
                                <span class="text-lg font-bold text-velvet-dark">{{ $item->price }} ريال</span>
                            </div>
                            <div class="mt-6 flex space-x-4 space-x-reverse">
                                <a href="#" class="flex-1 text-center bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 transition-colors">{{ __('orders.order_details') }}</a>
                                @if ($item->status == 'completed')
                                <button @click="openReviewModal({{ json_encode($item) }})" class="flex-1 bg-brand-pink text-white font-bold py-2 px-4 rounded-lg hover:bg-velvet transition-colors">{{ __('orders.rate_worker') }}</button>
                                @endif
                            </div>
                        </div>
                        @empty
                        <p class="md:col-span-2 text-center text-gray-500 py-12">لا توجد طلبات حالية.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Past Orders Tab -->
                <div x-show="activeTab === 'past'" style="display: none;">
                    <div class="grid md:grid-cols-2 gap-8">
                        @php
                            $pastOrders = $orders->where('status', 'completed')->filter(fn($item) => optional($item->reviews)->isNotEmpty())->merge($orders->where('status', 'declined'));
                        @endphp
                        @forelse ($pastOrders as $item)
                        <div class="bg-white rounded-2xl shadow-lg p-6 opacity-80">
                             <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-600"> {{ __('orders.order_number') }} #{{ $item->id }}</h3>
                                    <p class="text-gray-500">{{ optional($item->product)->name }}</p>
                                </div>
                                <span class="px-3 py-1 text-sm font-semibold rounded-full
                                    @if($item->status == 'completed') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ __('orders.statuses.' . $item->status, [], 'ar') }}
                                </span>
                            </div>
                            <div class="border-t my-4"></div>
                            <div class="flex justify-between items-center text-sm text-gray-500">
                                <span><strong>{{ __('orders.order_date') }}:</strong> {{ $item->created_at->format('Y-m-d') }}</span>
                                <a href="#" class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 transition-colors">{{ __('orders.order_details') }}</a>
                            </div>
                        </div>
                        @empty
                        <p class="md:col-span-2 text-center text-gray-500 py-12">لا يوجد طلبات سابقة.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Review Modal -->
    <div x-show="reviewModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 p-4" style="display: none;">
        <div @click.away="reviewModalOpen = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-lg" x-show="reviewModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <div class="p-8">
                <h2 class="text-3xl font-bold text-velvet mb-2">تقييم الخدمة</h2>
                <p class="text-gray-500 mb-6">طلب رقم: <strong class="text-velvet-dark" x-text="'#' + selectedOrder?.id"></strong></p>

                <form :action="'/worker/rate/' + selectedOrder?.id" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" :value="selectedOrder?.id">

                    <!-- Star Rating Component -->
                    <div class="mb-6" x-data="{ rating: 0, hoverRating: 0 }">
                        <label class="block text-sm font-medium text-gray-700 mb-2">التقييم (من 1 إلى 5 نجوم):</label>
                        <div class="flex items-center justify-center space-x-2 space-x-reverse text-4xl text-gray-300">
                            <template x-for="star in 5">
                                <i class="fas fa-star cursor-pointer"
                                   @click="rating = star"
                                   @mouseenter="hoverRating = star"
                                   @mouseleave="hoverRating = 0"
                                   :class="{ 'text-yellow-400': hoverRating >= star || rating >= star }"></i>
                            </template>
                        </div>
                        <input type="hidden" name="rating" x-model="rating" required>
                    </div>

                    <div>
                        <label for="comment" class="block text-sm font-medium text-gray-700">تعليق (اختياري)</label>
                        <textarea name="comment" id="comment" rows="4" class="mt-1 w-full p-3 bg-gray-100 border-2 border-gray-200 rounded-lg focus:border-velvet focus:ring-velvet transition" placeholder="اكتب تعليقك هنا..."></textarea>
                    </div>

                    <div class="flex justify-end space-x-4 space-x-reverse border-t pt-6 mt-6">
                        <button type="button" @click="reviewModalOpen = false" class="px-6 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">إغلاق</button>
                        <button type="submit" class="px-8 py-2 text-white bg-brand-pink rounded-lg hover:bg-velvet transition-colors">إرسال التقييم</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('web.footer')

    <script>
        function pageData() {
            return {
                reviewModalOpen: false,
                selectedOrder: null,
                openReviewModal(order) {
                    this.selectedOrder = order;
                    this.reviewModalOpen = true;
                }
            }
        }
    </script>
</body>
</html>
