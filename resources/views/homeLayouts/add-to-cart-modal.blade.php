<style>
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: black;
        background-size: 100%;
        border-radius: 50%;
    }

    .modal-map {
        width: 100%;
        height: 300px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
</style>


<div class="modal fade" id="orderModal-{{ $service->id }}" tabindex="-1" aria-labelledby="orderModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">طلب خدمة - {{ $service->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('user.carts.store') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="product_id" value="{{ $service->id }}">

                    <!-- Step 1: اختيار السيارة -->
                    <div class="step step-1">
                        <div class="mb-3">
                            <label for="car_model" class="form-label">السيارة</label>
                            <div id="carCarousel-{{ $service->id }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($cars as $index => $car)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $car->image) }}" class="d-block w-100"
                                                alt="{{ $car->name }}"
                                                style="max-height: 200px; object-fit: contain;">
                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>{{ $car->name }}</h5>
                                                <input type="radio" name="car_model" value="{{ $car->id }}"
                                                    {{ $index === 0 ? 'checked' : '' }} style="display: none;">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carCarousel-{{ $service->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">السابق</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carCarousel-{{ $service->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">التالي</span>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="car_type_{{ $service->id }}" class="form-label">نوع السيارة</label>
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="car_type" value="small"
                                    id="car_type_small_{{ $service->id }}" required>
                                <label class="btn btn-outline-primary" for="car_type_small_{{ $service->id }}">
                                    <i class="fas fa-car-side"></i> صغيرة - {{ $service->small_car_price }} ريال
                                </label>

                                <input type="radio" class="btn-check" name="car_type" value="medium"
                                    id="car_type_medium_{{ $service->id }}">
                                <label class="btn btn-outline-primary" for="car_type_medium_{{ $service->id }}">
                                    <i class="fas fa-car"></i> متوسطة - {{ $service->medium_car_price }} ريال
                                </label>

                                <input type="radio" class="btn-check" name="car_type" value="large"
                                    id="car_type_large_{{ $service->id }}">
                                <label class="btn btn-outline-primary" for="car_type_large_{{ $service->id }}">
                                    <i class="fas fa-truck-pickup"></i> كبيرة - {{ $service->large_car_price }} ريال
                                </label>

                                <input type="radio" class="btn-check" name="car_type" value="x_large"
                                    id="car_type_x_large_{{ $service->id }}">
                                <label class="btn btn-outline-primary" for="car_type_x_large_{{ $service->id }}">
                                    <i class="fas fa-truck"></i> كبيرة جدا - {{ $service->x_large_car_price }} ريال
                                </label>
                            </div>
                        </div>

                    </div>

                    <!-- Step 2: إدخال المعلومات -->
                    <div class="step step-2 d-none">
                        <div class="mb-3">
                            <label for="car_color" class="form-label">لون السيارة</label>
                            <select class="form-select" name="car_color" id="car_color" required>
                                <option>من فضلك اختر لون السيارة</option>
                                @foreach ($colors as $color)
                                    <option value="{{ $color }}">{{ $color }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="car_number" class="form-label">رقم السيارة</label>
                            <div class="row gx-2">
                                <div class="col-4">
                                    <input type="text" class="form-control" name="car_number_letters1"
                                        maxlength="1" pattern="[A-Za-z]" title="يجب إدخال حرف إنجليزي فقط"
                                        placeholder="الحرف الاول" required>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" name="car_number_letters2"
                                        maxlength="1" pattern="[A-Za-z]" title="يجب إدخال حرف إنجليزي فقط"
                                        placeholder="الحرف الثاني" required>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" name="car_number_letters3"
                                        maxlength="1" pattern="[A-Za-z]" title="يجب إدخال حرف إنجليزي فقط"
                                        placeholder="الحرف الثالث" required>
                                </div>
                                <div class="col-12 mt-2">
                                    <input type="text" class="form-control" name="car_number_digits"
                                        maxlength="4" placeholder="أرقام" required pattern="\d{1,4}"
                                        title="يجب إدخال 1 إلى 4 أرقام فقط">
                                </div>
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="car_wash" class="form-label">تاريخ ووقت الغسيل</label>
                            <input type="text" class="form-control" name="car_wash" required id="car_wash">
                        </div>
                    </div>

                    <!-- Step 3: اختيار الموقع -->
                    <div class="step step-3 d-none">
                        <div class="mb-3">
                            <label for="location" class="form-label">اختر الموقع على الخريطة</label>
                            <div id="map-{{ $service->id }}" class="modal-map"></div>
                            <input type="hidden" name="latitude" id="latitude-{{ $service->id }}">
                            <input type="hidden" name="longitude" id="longitude-{{ $service->id }}">
                        </div>
                    </div>

                    <!-- Step 4: الدفع -->
                    <div class="step step-4 d-none">
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">اختر وسيلة الدفع</label>
                            <div class="btn-group-vertical w-100" role="group">
                                <button type="button" class="btn btn-outline-secondary w-100" disabled>
                                    <i class="fas fa-credit-card"></i> بطاقة الائتمان (قريباً)
                                </button>
                                <button type="button" class="btn btn-outline-secondary w-100" disabled>
                                    <i class="fas fa-wallet"></i> PayPal (قريباً)
                                </button>
                                <button type="button" class="btn btn-outline-secondary w-100" disabled>
                                    <i class="fas fa-money-bill"></i> Apple Pay (قريباً)
                                </button>
                                <button type="button" class="btn btn-outline-secondary w-100" disabled>
                                    <i class="fas fa-money-check"></i> Mada (قريباً)
                                </button>
                                <button type="button" class="btn btn-outline-secondary w-100" disabled>
                                    <i class="fas fa-money-bill-wave"></i> STC Pay (قريباً)
                                </button>
                                <input type="radio" class="btn-check" name="payment_method"
                                    value="cash_on_delivery" id="payment_cash" checked>
                                <label class="btn btn-outline-primary w-100" for="payment_cash">
                                    <i class="fas fa-hand-holding-usd"></i> الدفع عند الاستلام
                                </label>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="price" id="service_price"
                        value="{{ $service->small_car_price }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary step-prev d-none">السابق</button>
                    <button type="button" class="btn btn-primary step-next">التالي</button>
                    <button type="submit" class="btn btn-primary d-none" id="final-submit">اطلب الخدمة الان</button>
                </div>
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async
    defer></script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // إعداد Flatpickr لمنع اختيار تاريخ سابق
        flatpickr("#car_wash", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minuteIncrement: 60,
            minTime: "16:00",
            maxTime: "22:00",
            defaultHour: 16,
            disableMobile: "true",
            minDate: "today",
        });

        // إدارة الخطوات
        document.querySelectorAll('[data-bs-toggle="modal"]').forEach((modalButton) => {
            modalButton.addEventListener('click', function() {
                const modalId = this.getAttribute('data-bs-target');
                const modalElement = document.querySelector(modalId);
                const steps = modalElement.querySelectorAll('.step');
                let currentStep = 0;

                function showStep(index) {
                    steps.forEach((step, i) => {
                        step.classList.toggle('d-none', i !== index);
                    });

                    modalElement.querySelector('.step-prev')?.classList.toggle('d-none',
                        index === 0);
                    modalElement.querySelector('.step-next')?.classList.toggle('d-none',
                        index === steps.length - 1);
                    modalElement.querySelector('#final-submit')?.classList.toggle('d-none',
                        index !== steps.length - 1);
                }

                modalElement.querySelector('.step-next')?.addEventListener('click', () => {
                    if (currentStep < steps.length - 1) {
                        currentStep++;
                        showStep(currentStep);
                    }
                });

                modalElement.querySelector('.step-prev')?.addEventListener('click', () => {
                    if (currentStep > 0) {
                        currentStep--;
                        showStep(currentStep);
                    }
                });

                showStep(currentStep); // عرض الخطوة الأولى عند فتح المودال

                // إعداد خريطة Google داخل المودال
                modalElement.addEventListener('shown.bs.modal', function() {
                    const mapId = modalId.replace('#orderModal-', 'map-');
                    const mapContainer = document.getElementById(mapId);
                    const latInput = document.getElementById(
                        `latitude-${mapId.split('-')[1]}`);
                    const lngInput = document.getElementById(
                        `longitude-${mapId.split('-')[1]}`);
                    const autoLocationButton = document.getElementById(
                        `auto-location-${mapId.split('-')[1]}`);

                    if (!mapContainer._mapInstance) {
                        const defaultLocation = {
                            lat: 24.7136,
                            lng: 46.6753
                        }; // الافتراضي: الرياض

                        const map = new google.maps.Map(mapContainer, {
                            center: defaultLocation,
                            zoom: 12,
                        });

                        const marker = new google.maps.Marker({
                            position: defaultLocation,
                            map: map,
                            draggable: true, // السماح بسحب العلامة
                        });

                        // تحديث الإحداثيات عند سحب العلامة
                        google.maps.event.addListener(marker, 'dragend', function(
                            event) {
                            const lat = event.latLng.lat();
                            const lng = event.latLng.lng();
                            latInput.value = lat;
                            lngInput.value = lng;
                        });

                        // تحديث الإحداثيات عند النقر على الخريطة
                        google.maps.event.addListener(map, 'click', function(event) {
                            const lat = event.latLng.lat();
                            const lng = event.latLng.lng();
                            marker.setPosition(event
                                .latLng); // تحديث موضع العلامة
                            latInput.value = lat;
                            lngInput.value = lng;
                        });

                        // ميزة الموقع التلقائي
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(
                                (position) => {
                                    const userLocation = {
                                        lat: position.coords.latitude,
                                        lng: position.coords.longitude,
                                    };
                                    map.setCenter(userLocation);
                                    marker.setPosition(userLocation);
                                    latInput.value = userLocation.lat;
                                    lngInput.value = userLocation.lng;
                                },
                                () => {
                                    alert(
                                        "تعذر تحديد الموقع الحالي. يرجى التحقق من إعدادات الموقع."
                                    );
                                }
                            );
                        }

                        // زر تحديد الموقع التلقائي
                        autoLocationButton.addEventListener('click', () => {
                            if (navigator.geolocation) {
                                navigator.geolocation.getCurrentPosition(
                                    (position) => {
                                        const userLocation = {
                                            lat: position.coords
                                                .latitude,
                                            lng: position.coords
                                                .longitude,
                                        };
                                        map.setCenter(userLocation);
                                        marker.setPosition(userLocation);
                                        latInput.value = userLocation.lat;
                                        lngInput.value = userLocation.lng;
                                        alert("تم تحديد الموقع بنجاح.");
                                    },
                                    () => {
                                        alert(
                                            "تعذر تحديد الموقع الحالي. يرجى التحقق من إعدادات الموقع."
                                        );
                                    }
                                );
                            } else {
                                alert(
                                    "ميزة تحديد الموقع غير مدعومة على هذا المتصفح."
                                );
                            }
                        });

                        // تخزين المرجع لتجنب إعادة الإنشاء
                        mapContainer._mapInstance = map;
                    } else {
                        google.maps.event.trigger(mapContainer._mapInstance, 'resize');
                    }
                });


            });
        });
    });
</script>
