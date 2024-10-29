<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خدمات المغسلة المتنقلة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha512-sA+qNc3y...="
        crossorigin="" />

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f9f9f9;
            direction: rtl;
        }

        .modal-map {
            height: 300px;
            width: 100%;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #4a2f85;
            text-align: center;
            margin-bottom: 30px;
        }

        .service-card {
            border: none;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #4a2f85;
            border: none;
        }

        .btn-primary:hover {
            background-color: #ed0f7d;
        }
    </style>
</head>

<body>

    @include('homeLayouts.nav-bar')
    @include('homeLayouts.float-buttons')

    <section class="py-5">
        <div class="container">
            <h2 class="section-title">خدمات المغسلة المتنقلة</h2>
            <div class="row gy-4">

                @foreach ($mainProducts as $service)
                    <div class="col-md-6 col-lg-4">
                        <div class="card service-card p-4 text-center">
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}"
                                class="img-fluid mb-3" style="max-height: 150px;">
                            <h3 class="h5 mb-3">{{ $service->name }}</h3>
                            <p class="text-secondary">{{ $service->description }}</p>
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#orderModal-{{ $service->id }}">
                                اطلب الخدمة
                            </button>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="orderModal-{{ $service->id }}" tabindex="-1"
                        aria-labelledby="orderModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="orderModalLabel">طلب خدمة - {{ $service->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
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
                                                <option value="small">صغيرة - {{ $service->small_car_price }} ريال
                                                </option>
                                                <option value="medium">متوسطة - {{ $service->medium_car_price }} ريال
                                                </option>
                                                <option value="large">كبيرة - {{ $service->large_car_price }} ريال
                                                </option>
                                                <option value="x_large">كبيرة جدا - {{ $service->x_large_car_price }}
                                                    ريال</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="car_color" class="form-label">لون السيارة</label>
                                            <input type="text" class="form-control" name="car_color" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="car_number" class="form-label">رقم السيارة</label>
                                            <div class="row gx-2">
                                                <div class="col-4">
                                                    <input type="text" class="form-control"
                                                        name="car_number_letters1" maxlength="1" placeholder="الحرف الاول"
                                                        required>
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" class="form-control"
                                                        name="car_number_letters2" maxlength="1" placeholder="الحرف الثاني"
                                                        required>
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" class="form-control"
                                                        name="car_number_letters3" maxlength="1" placeholder="الحرف الثالث"
                                                        required>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <input type="text" class="form-control" name="car_number_digits"
                                                        maxlength="4" placeholder="أرقام" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="car_wash" class="form-label">تاريخ الغسيل</label>
                                            <input type="datetime-local" class="form-control" name="car_wash"
                                                required id="car_wash">
                                        </div>

                                        <div class="mb-3">
                                            <label for="location" class="form-label">اختر الموقع على الخريطة</label>
                                            <div id="map-{{ $service->id }}" class="modal-map"></div>
                                            <input type="hidden" name="latitude" id="latitude-{{ $service->id }}">
                                            <input type="hidden" name="longitude"
                                                id="longitude-{{ $service->id }}">
                                        </div>

                                        <input type="hidden" name="price" id="service_price"
                                            value="{{ $service->small_car_price }}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">إغلاق</button>
                                        <button type="submit" class="btn btn-primary">أضف إلى السلة</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    @include('homeLayouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha512-VNf5a2...=" crossorigin=""></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carWashInput = document.getElementById('car_wash');
            const now = new Date();
            now.setMinutes(0, 0, 0); // تعيين الدقائق والثواني إلى 0
            carWashInput.min = now.toISOString().slice(0, 16); // تحديد الحد الأدنى للوقت الحالي

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
        });
    </script>

</body>

</html>
