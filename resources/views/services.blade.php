{{--
    This is the refactored Services page.
    It uses the same header and footer, styled with Tailwind CSS, and includes an interactive modal.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خدماتنا - المركبة المخملية</title>

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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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

<body class="bg-gray-100 font-cairo" x-data="{ orderModalOpen: false, selectedService: null }">

    @include('web.header')

    <main>
        <!-- Page Header Section -->
        <section class="bg-gradient-to-br from-velvet-dark to-indigo-900 text-white pt-32 pb-20">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold drop-shadow-lg">
                    {{ __('home.services') }}
                </h1>
                <p class="text-lg text-gray-300 mt-4 max-w-2xl mx-auto">
                    اكتشف باقاتنا المصممة لتقديم أفضل عناية لسيارتك، أينما كنت.
                </p>
            </div>
        </section>

        <!-- Services Grid Section -->
        <section class="py-24">
            <div class="container mx-auto px-6">
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

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    @foreach ($mainProducts as $service)
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col transform hover:-translate-y-2">
                        <div class="overflow-hidden h-64">
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-2xl font-bold text-velvet mb-2">{{ $service->name }}</h3>
                            <p class="text-gray-600 mb-6 flex-grow">{{ $service->description }}</p>
                            <button
                                @click="orderModalOpen = true; selectedService = {{ json_encode($service) }}"
                                class="w-full mt-auto bg-velvet text-white font-bold py-3 px-6 rounded-lg hover:bg-brand-pink transition-colors duration-300">
                                {{ __('home.request_service') }}
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    <!-- Order Modal -->
    <div x-show="orderModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 p-4" style="display: none;">
        <div @click.away="orderModalOpen = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-8" x-show="orderModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <h2 class="text-3xl font-bold text-velvet mb-2">طلب خدمة: <span x-text="selectedService?.name"></span></h2>
            <p class="text-gray-500 mb-6">الرجاء تعبئة البيانات التالية لإتمام الطلب.</p>

            <form :action="'/cart/' + selectedService?.id" method="POST">
                @csrf
                <!-- Car Size Selection -->
                <div class="mb-6">
                    <label class="block font-semibold text-gray-700 mb-2">اختر حجم السيارة:</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <template x-if="selectedService?.small_car_price">
                            <label class="block p-4 border rounded-lg text-center cursor-pointer has-[:checked]:bg-velvet-light/10 has-[:checked]:border-velvet">
                                <input type="radio" name="car_size" value="small" class="sr-only">
                                <i class="fas fa-car-side text-3xl text-velvet mb-2"></i>
                                <span class="font-semibold block">صغيرة</span>
                                <span class="text-sm text-gray-600" x-text="selectedService?.small_car_price + ' ر.س'"></span>
                            </label>
                        </template>
                        <template x-if="selectedService?.medium_car_price">
                            <label class="block p-4 border rounded-lg text-center cursor-pointer has-[:checked]:bg-velvet-light/10 has-[:checked]:border-velvet">
                                <input type="radio" name="car_size" value="medium" class="sr-only">
                                <i class="fas fa-car text-3xl text-velvet mb-2"></i>
                                <span class="font-semibold block">متوسطة</span>
                                <span class="text-sm text-gray-600" x-text="selectedService?.medium_car_price + ' ر.س'"></span>
                            </label>
                        </template>
                        <template x-if="selectedService?.large_car_price">
                            <label class="block p-4 border rounded-lg text-center cursor-pointer has-[:checked]:bg-velvet-light/10 has-[:checked]:border-velvet">
                                <input type="radio" name="car_size" value="large" class="sr-only">
                                <i class="fas fa-truck-monster text-3xl text-velvet mb-2"></i>
                                <span class="font-semibold block">كبيرة</span>
                                <span class="text-sm text-gray-600" x-text="selectedService?.large_car_price + ' ر.س'"></span>
                            </label>
                        </template>
                        <template x-if="selectedService?.x_large_car_price">
                            <label class="block p-4 border rounded-lg text-center cursor-pointer has-[:checked]:bg-velvet-light/10 has-[:checked]:border-velvet">
                                <input type="radio" name="car_size" value="x-large" class="sr-only">
                                <i class="fas fa-bus text-3xl text-velvet mb-2"></i>
                                <span class="font-semibold block">كبيرة جداً</span>
                                <span class="text-sm text-gray-600" x-text="selectedService?.x_large_car_price + ' ر.س'"></span>
                            </label>
                        </template>
                    </div>
                </div>

                <!-- Location Selection -->
                <div class="mb-6">
                    <label class="block font-semibold text-gray-700 mb-2">حدد موقعك:</label>
                    <div id="modalMap" class="h-64 w-full rounded-lg z-0"></div>
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 space-x-reverse">
                    <button type="button" @click="orderModalOpen = false" class="px-6 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">إلغاء</button>
                    <button type="submit" class="px-6 py-2 text-white bg-brand-pink rounded-lg hover:bg-velvet transition-colors">تأكيد الطلب</button>
                </div>
            </form>
        </div>
    </div>

    @include('web.footer')

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('app', () => ({
                orderModalOpen: false,
                selectedService: null,
                map: null,
                marker: null,
                initMap() {
                    this.map = L.map('modalMap').setView([24.7136, 46.6753], 13); // Default to Riyadh
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(this.map);

                    this.marker = L.marker([24.7136, 46.6753], { draggable: true }).addTo(this.map);

                    document.getElementById('latitude').value = 24.7136;
                    document.getElementById('longitude').value = 46.6753;

                    this.marker.on('dragend', (event) => {
                        const position = this.marker.getLatLng();
                        document.getElementById('latitude').value = position.lat;
                        document.getElementById('longitude').value = position.lng;
                    });
                }
            }));
        });

        // We need to initialize or re-initialize the map when the modal opens
        document.addEventListener('alpine:init', () => {
             Alpine.store('mapInitializer', {
                map: null,
                marker: null,
                init() {
                    // Watch for the modal to open
                    this.$watch('$store.app.orderModalOpen', (isOpen) => {
                        if (isOpen) {
                            // Use a timeout to ensure the DOM is visible
                            setTimeout(() => {
                                if (!this.map) {
                                    this.map = L.map('modalMap').setView([24.7136, 46.6753], 13);
                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(this.map);
                                    this.marker = L.marker([24.7136, 46.6753], { draggable: true }).addTo(this.map);

                                    this.marker.on('dragend', (event) => {
                                        const position = this.marker.getLatLng();
                                        document.getElementById('latitude').value = position.lat;
                                        document.getElementById('longitude').value = position.lng;
                                    });
                                }
                                this.map.invalidateSize(); // Important to fix map rendering issues in modals
                                document.getElementById('latitude').value = this.marker.getLatLng().lat;
                                document.getElementById('longitude').value = this.marker.getLatLng().lng;
                            }, 10);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
