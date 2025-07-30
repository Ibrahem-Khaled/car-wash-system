{{--
    This is the fully refactored Supervisor Orders page.
    It uses a tabbed interface and includes a detailed order-card partial.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('orders.title') }} - لوحة تحكم المشرف</title>

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

<body class="bg-gray-100 font-cairo">

    @include('web.header')

    <main>
        <!-- Page Header Section -->
        <section class="bg-gradient-to-br from-velvet-dark to-indigo-900 text-white pt-32 pb-20">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold drop-shadow-lg">{{ __('orders.title') }}</h1>
                <p class="text-lg text-gray-300 mt-4 max-w-2xl mx-auto">إدارة وتتبع جميع الطلبات بكفاءة وسهولة.</p>
            </div>
        </section>

        <!-- Orders Section with Tabs -->
        <section class="py-24" x-data="{ activeTab: 'pending' }">
            <div class="container mx-auto px-6">
                <!-- Tab Buttons -->
                <div class="flex flex-wrap justify-center mb-12 border-b border-gray-300">
                    <button @click="activeTab = 'pending'" :class="{ 'border-velvet text-velvet': activeTab === 'pending', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-400': activeTab !== 'pending' }" class="py-4 px-6 block font-semibold border-b-2 focus:outline-none transition-colors duration-300"><i class="fas fa-clock mr-2"></i> {{ __('orders.tabs.pending_orders') }}</button>
                    <button @click="activeTab = 'accepted'" :class="{ 'border-velvet text-velvet': activeTab === 'accepted', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-400': activeTab !== 'accepted' }" class="py-4 px-6 block font-semibold border-b-2 focus:outline-none transition-colors duration-300"><i class="fas fa-check-circle mr-2"></i> {{ __('orders.tabs.accepted_orders') }}</button>
                    <button @click="activeTab = 'completed'" :class="{ 'border-velvet text-velvet': activeTab === 'completed', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-400': activeTab !== 'completed' }" class="py-4 px-6 block font-semibold border-b-2 focus:outline-none transition-colors duration-300"><i class="fas fa-star mr-2"></i> {{ __('orders.tabs.completed_orders') }}</button>
                    <button @click="activeTab = 'declined'" :class="{ 'border-velvet text-velvet': activeTab === 'declined', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-400': activeTab !== 'declined' }" class="py-4 px-6 block font-semibold border-b-2 focus:outline-none transition-colors duration-300"><i class="fas fa-times-circle mr-2"></i> {{ __('orders.tabs.declined_orders') }}</button>
                </div>

                <!-- Orders Content -->
                <div x-show="activeTab === 'pending'">@include('partials.supervisor-order-list', ['orders' => $orders->where('status', 'unpaid')])</div>
                <div x-show="activeTab === 'accepted'" style="display: none;">@include('partials.supervisor-order-list', ['orders' => $orders->where('status', 'acepted')])</div>
                <div x-show="activeTab === 'completed'" style="display: none;">@include('partials.supervisor-order-list', ['orders' => $orders->where('status', 'completed')])</div>
                <div x-show="activeTab === 'declined'" style="display: none;">@include('partials.supervisor-order-list', ['orders' => $orders->where('status', 'declined')])</div>
            </div>
        </section>
    </main>

    @include('web.footer')

    <script>
        function openMap(lat, lng) {
            if (lat && lng) {
                const googleMapUrl = `https://www.google.com/maps?q=${lat},${lng}`;
                window.open(googleMapUrl, '_blank');
            } else {
                alert('{{ __("orders.no_coordinates") }}');
            }
        }
    </script>
</body>
</html>
