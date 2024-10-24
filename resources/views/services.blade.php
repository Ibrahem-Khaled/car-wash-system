<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خدمات المغسلة المتنقلة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f9f9f9;
            direction: rtl;
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

                @foreach ($services as $service)
                    <div class="col-md-6 col-lg-4">
                        <div class="card service-card p-4 text-center">
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}"
                                class="img-fluid mb-3" style="max-height: 150px;">
                            <h3 class="h5 mb-3">{{ $service->name }}</h3>
                            <p class="text-secondary">{{ $service->description }}</p>
                            <p class="text-info">
                                نوع الخدمة: {{ $service->type == 'main' ? 'رئيسية' : 'فرعية' }}
                            </p>
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
                                                    <input type="text" class="form-control" name="car_number_letters"
                                                        maxlength="3" placeholder="حروف" required>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" class="form-control" name="car_number_digits"
                                                        maxlength="4" placeholder="أرقام" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="car_wash" class="form-label">تاريخ الغسيل</label>
                                            <input type="datetime-local" class="form-control" name="car_wash" required>
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
    <script>
        document.querySelectorAll('#car_type').forEach(select => {
            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const price = selectedOption.text.split('-')[1].trim().replace('ريال', '');
                this.closest('form').querySelector('#service_price').value = price;
            });
        });
    </script>
</body>

</html>
