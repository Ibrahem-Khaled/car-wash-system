<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>متابعة الطلبات</title>
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
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #4a2f85;
            border: none;
        }

        .btn-primary:hover {
            background-color: #ed0f7d;
        }

        .input-group {
            max-width: 300px;
            margin: auto;
        }
    </style>
</head>

<body>

    @include('homeLayouts.nav-bar')
    @include('homeLayouts.float-buttons')

    <section class="py-5">
        <div class="container">
            <h2 class="section-title">متابعة الطلبات</h2>

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
                        @foreach ($orders->whereIn('status', ['pending', 'unpaid']) as $item)
                            <div class="col-md-6">
                                <div class="order-card bg-white">
                                    <h5>طلب رقم #{{ $item->id }}</h5>
                                    <p>{{ $item->product->name }}</p>
                                    <p><strong>تاريخ الطلب:</strong> {{ $item->created_at->format('Y-m-d') }}</p>
                                    <p class="order-status">حالة الطلب: {{ $item->status }}</p>

                                    <form action="{{ route('updateOrderStatus', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="input-group mb-3">
                                            <select class="form-select" name="status" required>
                                                <option value="acepted"
                                                    {{ $item->status == 'acepted' ? 'selected' : '' }}>مقبول</option>
                                                <option value="declined"
                                                    {{ $item->status == 'declined' ? 'selected' : '' }}>مرفوض</option>
                                                <option value="pending"
                                                    {{ $item->status == 'pending' ? 'selected' : '' }}>قيد التنفيذ
                                                </option>
                                                <option value="unpaid"
                                                    {{ $item->status == 'unpaid' ? 'selected' : '' }}>غير مدفوع</option>
                                            </select>
                                            <button class="btn btn-primary" type="submit">تحديث</button>
                                        </div>
                                    </form>

                                    <button class="btn btn-secondary mt-3"
                                        onclick="openMap({{ $item->latitude }}, {{ $item->longitude }})">
                                        عرض الموقع على الخريطة
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- الطلبات السابقة -->
                <div class="tab-pane fade" id="past-orders" role="tabpanel" aria-labelledby="past-orders-tab">
                    <div class="row">
                        @foreach ($orders->whereIn('status', ['acepted', 'declined']) as $item)
                            <div class="col-md-6">
                                <div class="order-card bg-white">
                                    <h5>طلب رقم #{{ $item->id }}</h5>
                                    <p>{{ $item->product->name }}</p>
                                    <p><strong>تاريخ الطلب:</strong> {{ $item->created_at->format('Y-m-d') }}</p>
                                    <p class="order-status">حالة الطلب: {{ $item->status }}</p>
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
