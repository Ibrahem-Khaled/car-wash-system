{{--
    This is the fully refactored Services and Subscriptions page.
    It uses a tabbed interface and has the modal code directly integrated.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الخدمات والباقات - المركبة المخملية</title>

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

    <!-- Leaflet.js for Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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

<body class="bg-gray-100 font-cairo" x-data="pageData()">

    @include('web.header')

    <main>
        <!-- Page Header Section -->
        <section class="bg-gradient-to-br from-velvet-dark to-indigo-900 text-white pt-32 pb-20">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold drop-shadow-lg">خدماتنا وباقاتنا</h1>
                <p class="text-lg text-gray-300 mt-4 max-w-2xl mx-auto">اختر الخدمة المنفردة التي تناسبك أو اشترك في
                    إحدى باقاتنا المميزة للعناية الكاملة.</p>
            </div>
        </section>

        <!-- Main Content Section with Tabs -->
        <section class="py-24" x-data="{ activeTab: 'services' }">
            <div class="container mx-auto px-6">
                <!-- Tab Buttons -->
                <div class="flex justify-center mb-12 border-b border-gray-300">
                    <button @click="activeTab = 'services'"
                        :class="{ 'border-velvet text-velvet': activeTab === 'services', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-400': activeTab !== 'services' }"
                        class="py-4 px-6 block font-semibold border-b-2 focus:outline-none transition-colors duration-300">
                        <i class="fas fa-hand-sparkles mr-2"></i> الخدمات المنفردة
                    </button>
                    <button @click="activeTab = 'subscriptions'"
                        :class="{ 'border-velvet text-velvet': activeTab === 'subscriptions', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-400': activeTab !== 'subscriptions' }"
                        class="py-4 px-6 block font-semibold border-b-2 focus:outline-none transition-colors duration-300">
                        <i class="fas fa-star mr-2"></i> باقات الاشتراك
                    </button>
                </div>

                <!-- Error Display -->
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded-lg" role="alert">
                        <p class="font-bold">خطأ</p>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Services Tab Content -->
                <div x-show="activeTab === 'services'" style="display: none;"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    {{-- FIX: Changed $mainProducts to $mainServices to match the controller variable --}}
                    @foreach ($mainServices as $service)
                        <div
                            class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col transform hover:-translate-y-2">
                            <div class="overflow-hidden h-64"><img src="{{ asset('storage/' . $service->image) }}"
                                    alt="{{ $service->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="p-6 flex flex-col flex-grow">
                                <h3 class="text-2xl font-bold text-velvet mb-2">{{ $service->name }}</h3>
                                <p class="text-gray-600 mb-6 flex-grow">{{ $service->description }}</p>
                                <button @click="openServiceModal({{ json_encode($service) }})"
                                    class="w-full mt-auto bg-velvet text-white font-bold py-3 px-6 rounded-lg hover:bg-brand-pink transition-colors duration-300">{{ __('home.request_service') }}</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Subscriptions Tab Content -->
                <div x-show="activeTab === 'subscriptions'" style="display: none;"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    @foreach ($subscriptions as $subscription)
                        <div
                            class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 flex flex-col transform hover:-translate-y-2 p-8 text-center">
                            <div class="flex-grow">
                                @if ($subscription->image)
                                    <img src="{{ asset('storage/' . $subscription->image) }}"
                                        alt="{{ $subscription->name }}"
                                        class="w-24 h-24 mx-auto mb-6 rounded-full border-4 border-velvet-light object-cover">
                                @else
                                    <div
                                        class="w-24 h-24 mx-auto mb-6 rounded-full border-4 border-velvet-light bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-star text-velvet text-4xl"></i>
                                    </div>
                                @endif
                                <h3 class="text-2xl font-bold text-velvet mb-2">{{ $subscription->name }}</h3>
                                <p class="text-gray-600 mb-4">{{ $subscription->description }}</p>
                                <ul class="text-gray-700 space-y-2 mb-6 text-right">
                                    @foreach ($subscription->products as $product)
                                        <li class="flex items-center"><i
                                                class="fas fa-check-circle text-green-500 ml-2"></i>
                                            {{ $product->name }} - {{ $product->pivot->quantity }} غسلات</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="mt-auto">
                                <h4 class="text-4xl font-extrabold text-gray-800 mb-4">{{ $subscription->price }} <span
                                        class="text-lg font-medium text-gray-500">ريال / شهر</span></h4>
                                <button @click="openSubscriptionModal({{ json_encode($subscription) }})"
                                    class="w-full bg-brand-pink text-white font-bold py-3 px-6 rounded-lg hover:bg-velvet transition-colors duration-300">{{ __('home.subscribe_now') }}</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    <!-- Service Order Modal -->
    <div x-show="serviceModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 p-4" style="display: none;">
        <div @click.away="serviceModalOpen = false"
            class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto"
            x-show="serviceModalOpen" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <div class="p-8">
                <h2 class="text-3xl font-bold text-velvet mb-2">طلب خدمة: <span x-text="selectedService?.name"></span>
                </h2>
                <p class="text-gray-500 mb-6">الرجاء تعبئة البيانات التالية لإتمام الطلب.</p>

                <form :action="'/cart/' + selectedService?.id" method="POST">
                    @csrf
                    <!-- Car Size Selection -->
                    <div class="mb-6">
                        <label class="block font-semibold text-gray-700 mb-2">اختر حجم السيارة:</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <template x-if="selectedService?.small_car_price"><label
                                    class="block p-4 border rounded-lg text-center cursor-pointer has-[:checked]:bg-velvet-light/10 has-[:checked]:border-velvet"><input
                                        type="radio" name="car_size" value="small" class="sr-only" required><i
                                        class="fas fa-car-side text-3xl text-velvet mb-2"></i><span
                                        class="font-semibold block">صغيرة</span><span class="text-sm text-gray-600"
                                        x-text="selectedService?.small_car_price + ' ر.س'"></span></label></template>
                            <template x-if="selectedService?.medium_car_price"><label
                                    class="block p-4 border rounded-lg text-center cursor-pointer has-[:checked]:bg-velvet-light/10 has-[:checked]:border-velvet"><input
                                        type="radio" name="car_size" value="medium" class="sr-only"><i
                                        class="fas fa-car text-3xl text-velvet mb-2"></i><span
                                        class="font-semibold block">متوسطة</span><span class="text-sm text-gray-600"
                                        x-text="selectedService?.medium_car_price + ' ر.س'"></span></label></template>
                            <template x-if="selectedService?.large_car_price"><label
                                    class="block p-4 border rounded-lg text-center cursor-pointer has-[:checked]:bg-velvet-light/10 has-[:checked]:border-velvet"><input
                                        type="radio" name="car_size" value="large" class="sr-only"><i
                                        class="fas fa-truck-monster text-3xl text-velvet mb-2"></i><span
                                        class="font-semibold block">كبيرة</span><span class="text-sm text-gray-600"
                                        x-text="selectedService?.large_car_price + ' ر.س'"></span></label></template>
                            <template x-if="selectedService?.x_large_car_price"><label
                                    class="block p-4 border rounded-lg text-center cursor-pointer has-[:checked]:bg-velvet-light/10 has-[:checked]:border-velvet"><input
                                        type="radio" name="car_size" value="x-large" class="sr-only"><i
                                        class="fas fa-bus text-3xl text-velvet mb-2"></i><span
                                        class="font-semibold block">كبيرة جداً</span><span
                                        class="text-sm text-gray-600"
                                        x-text="selectedService?.x_large_car_price + ' ر.س'"></span></label></template>
                        </div>
                    </div>
                    <!-- Location Selection -->
                    <div class="mb-6">
                        <label class="block font-semibold text-gray-700 mb-2">حدد موقعك:</label>
                        <div id="serviceModalMap" class="h-64 w-full rounded-lg z-0"></div>
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                    </div>
                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4 space-x-reverse border-t pt-6 mt-6">
                        <button type="button" @click="serviceModalOpen = false"
                            class="px-6 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">إلغاء</button>
                        <button type="submit"
                            class="px-6 py-2 text-white bg-brand-pink rounded-lg hover:bg-velvet transition-colors">تأكيد
                            الطلب</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Subscription Payment Modal -->
    <div x-show="subscriptionModalOpen" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 p-4" style="display: none;">
        <div @click.away="subscriptionModalOpen = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-md"
            x-show="subscriptionModalOpen" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <div class="p-8">
                <h2 class="text-3xl font-bold text-velvet mb-2">إتمام الاشتراك</h2>
                <p class="text-gray-500 mb-6">أنت على وشك الاشتراك في: <strong class="text-velvet-dark"
                        x-text="selectedSubscription?.name"></strong></p>

                <form action="{{ route('add.subscription') }}" method="POST">
                    @csrf
                    <input type="hidden" name="subscription_id" :value="selectedSubscription?.id">

                    <div class="space-y-4">
                        <div>
                            <label for="card_name" class="block text-sm font-medium text-gray-700">اسم صاحب
                                البطاقة</label>
                            <input type="text" name="card_name" id="card_name" required
                                class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-velvet focus:border-velvet">
                        </div>
                        <div>
                            <label for="card_number" class="block text-sm font-medium text-gray-700">رقم
                                البطاقة</label>
                            <input type="text" name="card_number" id="card_number" required
                                class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-velvet focus:border-velvet">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="expiry_date" class="block text-sm font-medium text-gray-700">تاريخ
                                    الانتهاء</label>
                                <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YY"
                                    required
                                    class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-velvet focus:border-velvet">
                            </div>
                            <div>
                                <label for="cvv" class="block text-sm font-medium text-gray-700">CVV</label>
                                <input type="text" name="cvv" id="cvv" required
                                    class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-velvet focus:border-velvet">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 space-x-reverse border-t pt-6 mt-6">
                        <button type="button" @click="subscriptionModalOpen = false"
                            class="px-6 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">إلغاء</button>
                        <button type="submit"
                            class="px-8 py-2 text-white bg-brand-pink rounded-lg hover:bg-velvet transition-colors">
                            <span x-text="'ادفع ' + selectedSubscription?.price + ' ريال'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('web.footer')

    <script>
        function pageData() {
            return {
                // Service Modal Data
                serviceModalOpen: false,
                selectedService: null,
                // Subscription Modal Data
                subscriptionModalOpen: false,
                selectedSubscription: null,
                // Map instance
                map: null,
                marker: null,

                openServiceModal(service) {
                    this.selectedService = service;
                    this.serviceModalOpen = true;
                    this.$nextTick(() => this.initMap('serviceModalMap'));
                },

                openSubscriptionModal(subscription) {
                    this.selectedSubscription = subscription;
                    this.subscriptionModalOpen = true;
                },

                initMap(mapId) {
                    // Invalidate previous map instance if it exists
                    if (this.map) {
                        this.map.remove();
                        this.map = null;
                    }

                    this.map = L.map(mapId).setView([24.7136, 46.6753], 13); // Default to Riyadh
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(this.map);

                    this.marker = L.marker([24.7136, 46.6753], {
                        draggable: true
                    }).addTo(this.map);

                    const latitudeInput = document.getElementById('latitude');
                    const longitudeInput = document.getElementById('longitude');

                    latitudeInput.value = 24.7136;
                    longitudeInput.value = 46.6753;

                    this.marker.on('dragend', (event) => {
                        const position = this.marker.getLatLng();
                        latitudeInput.value = position.lat;
                        longitudeInput.value = position.lng;
                    });

                    // Fix map rendering issue in modal
                    setTimeout(() => this.map.invalidateSize(), 100);
                }
            }
        }
    </script>
</body>

</html>
