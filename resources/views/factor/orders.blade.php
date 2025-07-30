{{--
    This is the fully refactored Orders page.
    It uses a tabbed interface and has the review modal code directly integrated.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('orders.title') }} - المركبة المخملية</title>

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
                <div class="flex flex-wrap justify-center mb-12 border-b border-gray-300">
                    <button @click="activeTab = 'current'" :class="{ 'border-velvet text-velvet': activeTab === 'current', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-400': activeTab !== 'current' }" class="py-4 px-6 block font-semibold border-b-2 focus:outline-none transition-colors duration-300"><i class="fas fa-stream mr-2"></i> {{ __('orders.tabs.current_orders') }}</button>
                    <button @click="activeTab = 'past'" :class="{ 'border-velvet text-velvet': activeTab === 'past', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-400': activeTab !== 'past' }" class="py-4 px-6 block font-semibold border-b-2 focus:outline-none transition-colors duration-300"><i class="fas fa-history mr-2"></i> {{ __('orders.tabs.past_orders') }}</button>
                    @if (auth()->user()->role == 'supervisor')
                        <button @click="activeTab = 'accepted'" :class="{ 'border-velvet text-velvet': activeTab === 'accepted', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-400': activeTab !== 'accepted' }" class="py-4 px-6 block font-semibold border-b-2 focus:outline-none transition-colors duration-300"><i class="fas fa-check-circle mr-2"></i> {{ __('orders.tabs.accepted_orders') }}</button>
                        <button @click="activeTab = 'declined'" :class="{ 'border-velvet text-velvet': activeTab === 'declined', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-400': activeTab !== 'declined' }" class="py-4 px-6 block font-semibold border-b-2 focus:outline-none transition-colors duration-300"><i class="fas fa-times-circle mr-2"></i> {{ __('orders.tabs.declined_orders') }}</button>
                        <button @click="activeTab = 'completed'" :class="{ 'border-velvet text-velvet': activeTab === 'completed', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-400': activeTab !== 'completed' }" class="py-4 px-6 block font-semibold border-b-2 focus:outline-none transition-colors duration-300"><i class="fas fa-star mr-2"></i> {{ __('orders.tabs.completed_orders') }}</button>
                    @endif
                </div>

                <!-- User Tabs -->
                <div x-show="activeTab === 'current'">@include('partials.order-list', ['orders' => $orders->whereIn('status', ['pending', 'acepted'])])</div>
                <div x-show="activeTab === 'past'" style="display: none;">@include('partials.order-list', ['orders' => $orders->whereIn('status', ['completed', 'declined'])])</div>

                <!-- Supervisor Tabs -->
                @if (auth()->user()->role == 'supervisor')
                    <div x-show="activeTab === 'accepted'" style="display: none;">@include('partials.order-list', ['orders' => $allOrdersToSupervisor->where('status', 'pending')])</div>
                    <div x-show="activeTab === 'declined'" style="display: none;">@include('partials.order-list', ['orders' => $allOrdersToSupervisor->where('status', 'declined')])</div>
                    <div x-show="activeTab === 'completed'" style="display: none;">@include('partials.order-list', ['orders' => $allOrdersToSupervisor->where('status', 'completed')])</div>
                @endif
            </div>
        </section>
    </main>

    <!-- Review Modal -->
    <div x-show="reviewModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 p-4" style="display: none;">
        <div @click.away="reviewModalOpen = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-lg" x-show="reviewModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <div class="p-8">
                <h2 class="text-3xl font-bold text-velvet mb-2">تقييم الخدمة</h2>
                <p class="text-gray-500 mb-6">طلب رقم: <strong class="text-velvet-dark" x-text="'#' + selectedOrder?.id"></strong></p>
                <form :action="'/worker/rate/' + selectedOrder?.id" method="POST" x-data="{ rating: 0, hoverRating: 0 }">
                    @csrf
                    <input type="hidden" name="order_id" :value="selectedOrder?.id">
                    <div class="mb-6">
                        <label class="block text-center font-semibold text-gray-700 mb-4">التقييم (من 1 إلى 5 نجوم):</label>
                        <div class="flex items-center justify-center space-x-2 space-x-reverse text-4xl text-gray-300">
                            <template x-for="star in 5">
                                <i class="fas fa-star cursor-pointer" @click="rating = star" @mouseenter="hoverRating = star" @mouseleave="hoverRating = 0" :class="{ 'text-yellow-400': hoverRating >= star || rating >= star }"></i>
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
                },
                openMap(lat, lng) {
                    if (lat && lng) {
                        const googleMapUrl = `https://www.google.com/maps?q=${lat},${lng}`;
                        window.open(googleMapUrl, '_blank');
                    } else {
                        alert('{{ __("orders.no_coordinates") }}');
                    }
                }
            }
        }
    </script>
</body>
</html>
