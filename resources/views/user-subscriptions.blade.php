<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اشتراكاتي</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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

        .subscription-card {
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .subscription-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        .product-list img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }

        .remaining-services {
            font-weight: 600;
            margin-top: 10px;
            color: #4a2f85;
        }

        .btn-primary {
            background-color: #4a2f85;
            border: none;
        }

        .btn-primary:hover {
            background-color: #ed0f7d;
        }

        .status-active {
            color: #28a745;
        }

        .status-expired {
            color: #dc3545;
        }
    </style>
</head>

<body>

    @include('homeLayouts.nav-bar')
    @include('homeLayouts.float-buttons')

    <section class="py-5">
        <div class="container">
            <h2 class="section-title">اشتراكاتي</h2>

            <div class="row gy-4">
                @foreach ($subscriptions as $subscription)
                    <div class="col-md-6">
                        <div class="subscription-card bg-white p-4 rounded shadow-sm">
                            <h5 class="mb-3">{{ $subscription['name'] }}</h5>
                            <p><strong>الوصف:</strong> {{ $subscription['description'] }}</p>
                            <p><strong>السعر:</strong> {{ $subscription['price'] }} ريال / شهر</p>

                            <div class="subscription-details mt-3">
                                <p class="remaining-services">
                                    حالة الاشتراك:
                                    <span
                                        class="{{ $subscription['pivot']['status'] == 'active' ? 'status-active' : 'status-expired' }}">
                                        {{ $subscription['pivot']['status'] == 'active' ? 'نشط' : 'منتهي' }}
                                    </span>
                                </p>

                                <h6 class="mt-4">الخدمات المشمولة:</h6>
                                <ul class="list-unstyled product-list">
                                    @foreach ($subscription['products'] as $product)
                                        @php
                                            // جلب الكمية المتبقية باستخدام دالة getRemainingQuantity
                                            $remainingQuantity = app()->call(
                                                'App\Http\Controllers\homeController@getRemainingQuantity',
                                                [
                                                    'userId' => Auth::user()->id,
                                                    'subscriptionId' => $subscription['id'],
                                                    'productId' => $product['id'],
                                                ],
                                            );
                                        @endphp
                                        <li class="d-flex align-items-center mb-3">
                                            <img src="{{ asset('storage/' . $product['image']) }}"
                                                alt="{{ $product['name'] }}" class="me-3"
                                                style="width: 50px; height: 50px;">
                                            <div>
                                                <strong>{{ $product['name'] }}</strong>
                                                <p class="mb-0">{{ $product['description'] }}</p>
                                                <span>الكمية المتاحة: {{ $product['pivot']['quantity'] }}</span><br>
                                                <span>المتبقي: {{ $remainingQuantity }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <a href="#" class="btn btn-primary mt-3">عرض المزيد</a>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    @include('homeLayouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
