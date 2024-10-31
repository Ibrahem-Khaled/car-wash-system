<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عربة الطلبات</title>
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

        .cart-item {
            display: flex;
            align-items: center;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .cart-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        .cart-item img {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            margin-left: 15px;
        }

        .item-details {
            flex-grow: 1;
        }

        .item-details h5 {
            font-size: 1.25rem;
            margin-bottom: 5px;
        }

        .order-status {
            font-size: 0.9rem;
            font-weight: 600;
            margin-top: 5px;
        }

        .status-pending {
            color: #ffc107;
        }

        .status-accepted {
            color: #28a745;
        }

        .status-unpaid {
            color: #dc3545;
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

    <div class="container py-5">
        <h2 class="section-title">عربة الطلبات</h2>
        <form method="POST" action="{{ route('user.carts.updatePayment') }}">
            @csrf
            <div class="row">
                @if (count($carts) == 0)
                    <p class="text-center">لا يوجد طلبات في العربة</p>
                @else
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">طريقة الدفع:</label>
                        <select class="form-select" id="payment_method" name="payment_method" required>
                            <option value="paid">بطاقة</option>
                            <option value="cash_on_delivery">عند الاستلام</option>
                        </select>
                    </div>
                    @foreach ($carts as $item)
                        <div class="col-md-6">
                            <div class="cart-item">
                                <img src="{{ asset('storage/' . optional($item->product)->image) }}"
                                    alt="{{ optional($item->product)->name ?? 'لا يوجد اسم' }}">
                                <div class="item-details">
                                    <h5>{{ optional($item->product)->name ?? 'اسم غير متوفر' }}</h5>
                                    <p>نوع السيارة: {{ ucfirst($item->car_type ?? 'غير محدد') }}</p>
                                    <p>لون السيارة: {{ $item->car_color ?? 'غير محدد' }}</p>
                                    <p>رقم السيارة: {{ $item->car_number ?? 'غير محدد' }}</p>
                                    <p><strong>تاريخ الغسيل:</strong>
                                        {{ $item->car_wash ? $item->car_wash : 'لم يتم التحديد' }}
                                    </p>
                                    <p class="order-status">
                                        @switch($item->status)
                                            @case('pending')
                                                <span class="status-pending">قيد التنفيذ</span>
                                            @break

                                            @case('acepted')
                                                <span class="status-accepted">مقبول</span>
                                            @break

                                            @case('unpaid')
                                                <span class="status-unpaid">غير مدفوع</span>
                                            @break

                                            @default
                                                <span>مرفوض</span>
                                        @endswitch
                                    </p>
                                </div>
                                <div class="text-end">
                                    <p><strong>السعر:</strong> {{ $item->price ?? 'غير محدد' }} ريال</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">تحديث طريقة الدفع</button>
            </div>
        </form>
    </div>

    @include('homeLayouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
