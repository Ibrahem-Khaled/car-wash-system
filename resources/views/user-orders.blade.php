<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الطلبات الحالية والسابقة</title>
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

        .order-card {
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        .order-status {
            font-size: 0.9rem;
            font-weight: 600;
            margin-top: 5px;
        }

        .status-pending {
            color: #ffc107;
        }

        .status-completed {
            color: #28a745;
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
            <h2 class="section-title">طلبات المغسلة</h2>

            <ul class="nav nav-tabs mb-4" id="orderTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="current-orders-tab" data-bs-toggle="tab"
                        data-bs-target="#current-orders" type="button" role="tab" aria-controls="current-orders"
                        aria-selected="true">الطلبات الحالية</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="past-orders-tab" data-bs-toggle="tab" data-bs-target="#past-orders"
                        type="button" role="tab" aria-controls="past-orders" aria-selected="false">الطلبات
                        السابقة</button>
                </li>
            </ul>

            <div class="tab-content" id="orderTabsContent">
                <!-- الطلبات الحالية -->
                <div class="tab-pane fade show active" id="current-orders" role="tabpanel"
                    aria-labelledby="current-orders-tab">
                    <div class="row">
                        @foreach ($orders->whereIn('status', ['acepted', 'pending', 'completed'])->doesntHave('reviews') as $item)
                            <div class="col-md-6">
                                <div class="order-card bg-white">
                                    <h5>طلب رقم #{{ $item->id }}</h5>
                                    <p>{{ $item->product->name }}</p>
                                    <p><strong>تاريخ الطلب:</strong> {{ $item->created_at->format('Y-m-d') }}</p>
                                    <p class="order-status status-pending">قيد التنفيذ</p>
                                    <a href="#" class="btn btn-primary">تفاصيل الطلب</a>
                                    <a href="#"
                                        class="btn btn-success mt-2">تقييم العامل</a>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- الطلبات السابقة -->
                <div class="tab-pane fade" id="past-orders" role="tabpanel" aria-labelledby="past-orders-tab">
                    <div class="row">
                        @foreach ($orders->whereIn('status', ['declined', 'completed'])->have('reviews') as $item)
                            <div class="col-md-6">
                                <div class="order-card bg-white">
                                    <h5>طلب رقم #{{ $item->id }}</h5>
                                    <p>{{ $item->product->name }}</p>
                                    <p><strong>تاريخ الطلب:</strong> {{ $item->created_at->format('Y-m-d') }}</p>
                                    <p class="order-status status-completed">مكتمل</p>
                                    <a href="#" class="btn btn-primary">تفاصيل الطلب</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('homeLayouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
