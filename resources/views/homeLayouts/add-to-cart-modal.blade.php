<!-- Modal -->
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

                    <div class="mb-3">
                        <label for="car_model" class="form-label">السيارة</label>
                        <select class="form-select" name="car_model" required>
                            @foreach ($cars as $car)
                                <option value="{{ $car->id }}">{{ $car->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="car_type" class="form-label">نوع السيارة</label>
                        <select class="form-select" name="car_type" required id="car_type">
                            <option value="small">صغيرة - {{ $service->small_car_price }} ريال</option>
                            <option value="medium">متوسطة - {{ $service->medium_car_price }} ريال</option>
                            <option value="large">كبيرة - {{ $service->large_car_price }} ريال</option>
                            <option value="x_large">كبيرة جدا - {{ $service->x_large_car_price }} ريال</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="car_color" class="form-label">لون السيارة</label>
                        <select class="form-select" name="car_color" id="car_color" required>
                            <option value="أسود">أسود</option>
                            <option value="أبيض">أبيض</option>
                            <option value="أحمر">أحمر</option>
                            <option value="أزرق">أزرق</option>
                            <option value="رمادي">رمادي</option>
                            <option value="فضي">فضي</option>
                            <option value="أخضر">أخضر</option>
                            <option value="أصفر">أصفر</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="car_number" class="form-label">رقم السيارة</label>
                        <div class="row gx-2">
                            <div class="col-4">
                                <input type="text" class="form-control" name="car_number_letters1" maxlength="1"
                                    pattern="[a-zA-Z]" title="يجب إدخال حرف إنجليزي واحد" placeholder="الحرف الاول"
                                    required>
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control" name="car_number_letters2" maxlength="1"
                                    pattern="[a-zA-Z]" title="يجب إدخال حرف إنجليزي واحد" placeholder="الحرف الثاني"
                                    required>
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control" name="car_number_letters3" maxlength="1"
                                    pattern="[a-zA-Z]" title="يجب إدخال حرف إنجليزي واحد" placeholder="الحرف الثالث"
                                    required>
                            </div>
                            <div class="col-12 mt-2">
                                <input type="number" class="form-control" name="car_number_digits" maxlength="4"
                                    placeholder="أرقام" required pattern="\d{1,4}" title="يجب إدخال 1 إلى 4 أرقام فقط">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="car_wash" class="form-label">تاريخ ووقت الغسيل</label>
                        <input type="text" class="form-control" name="car_wash" required id="car_wash">
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">اختر الموقع على الخريطة</label>
                        <div id="map-{{ $service->id }}" class="modal-map"></div>
                        <input type="hidden" name="latitude" id="latitude-{{ $service->id }}">
                        <input type="hidden" name="longitude" id="longitude-{{ $service->id }}">
                    </div>

                    <input type="hidden" name="price" id="service_price"
                        value="{{ $service->small_car_price }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">أضف إلى السلة</button>
                </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // إعداد Flatpickr لمنع اختيار تاريخ سابق
        flatpickr("#car_wash", {
            enableTime: true,
            dateFormat: "Y-m-d H:i", // تنسيق التاريخ والوقت
            minuteIncrement: 60, // اختيار الساعة فقط بدون دقائق
            minTime: "16:00", // أقل وقت متاح: 4 م
            maxTime: "22:00", // أقصى وقت متاح: 10 م
            defaultHour: 16, // التوقيت الافتراضي: 4 م
            disableMobile: "true", // تعطيل واجهة الجوال الافتراضية
            minDate: "today", // منع اختيار تاريخ سابق
        });

        // إعداد الخريطة داخل النافذة المنبثقة (modal)
        document.querySelectorAll('[data-bs-toggle="modal"]').forEach((modalButton) => {
            modalButton.addEventListener('click', function() {
                const modalId = this.getAttribute('data-bs-target');
                const mapId = modalId.replace('#orderModal-', 'map-');

                setTimeout(() => {
                    const map = L.map(mapId).setView([24.7136, 46.6753], 12);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    const marker = L.marker([24.7136, 46.6753], {
                        draggable: true
                    }).addTo(map);

                    marker.on('dragend', function(e) {
                        const {
                            lat,
                            lng
                        } = e.target.getLatLng();
                        document.getElementById(
                            `latitude-${mapId.split('-')[1]}`).value = lat;
                        document.getElementById(
                            `longitude-${mapId.split('-')[1]}`).value = lng;
                    });

                    map.invalidateSize();
                }, 200);
            });
        });

        // تحقق من الإدخالات قبل الإرسال
        document.querySelector('form').addEventListener('submit', function(event) {
            const requiredFields = ['car_model', 'car_type', 'car_color', 'car_number_letters1',
                'car_number_letters2', 'car_number_letters3', 'car_number_digits', 'car_wash',
                'latitude', 'longitude'
            ];
            let isValid = true;

            requiredFields.forEach(fieldName => {
                const field = document.querySelector(`[name="${fieldName}"]`);
                if (!field || !field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid'); // إضافة تنسيق عند عدم ملء الحقل
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            // التحقق من إدخال الحروف الإنجليزية في الحقول
            ['car_number_letters1', 'car_number_letters2', 'car_number_letters3'].forEach(fieldName => {
                const field = document.querySelector(`[name="${fieldName}"]`);
                if (field && !/^[a-zA-Z]+$/.test(field.value)) {
                    isValid = false;
                    field.classList.add('is-invalid');
                    alert('يرجى إدخال حروف إنجليزية فقط في حقول الحروف.');
                }
            });

            if (!isValid) {
                event.preventDefault(); // منع الإرسال إذا كانت البيانات غير مكتملة
                alert('يرجى ملء جميع الحقول المطلوبة وتحديد الوقت لإكمال الطلب.');
            }
        });
    });
</script>
