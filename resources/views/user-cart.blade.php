<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عربة التسوق</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f5f5f5;
            direction: rtl;
        }

        .cart-container {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
        }

        .cart-item {
            display: flex;
            align-items: flex-start;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .cart-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            margin-left: 15px;
        }

        .item-details {
            flex-grow: 1;
            margin-right: 15px;
        }

        .item-details h5 {
            font-size: 1.2rem;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .item-details p {
            margin-bottom: 4px;
            font-size: 0.9rem;
            color: #555;
        }

        .price-container {
            text-align: right;
        }

        .total-summary {
            margin-top: 30px;
            padding: 15px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .total-summary p {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
        }

        .btn-update {
            background-color: #4a2f85;
            border: none;
            margin-top: 20px;
            padding: 10px 20px;
        }

        .btn-update:hover {
            background-color: #ed0f7d;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            margin-top: 5px;
        }

        .quantity-selector input {
            width: 50px;
            height: 30px;
            text-align: center;
            margin: 0 5px;
        }

        .remove-link {
            color: #dc3545;
            font-size: 0.9rem;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>

<body>
    @include('homeLayouts.nav-bar')

    <div class="cart-container">
        <h2 class="text-center mb-4">عربة التسوق</h2>

        <form method="POST" action="{{ route('user.carts.updatePayment') }}">
            @csrf
            @if (count($carts) == 0)
                <p class="text-center">لا يوجد طلبات في العربة</p>
            @else
                @foreach ($carts as $item)
                    <div class="cart-item">
                        <img src="{{ asset('storage/' . optional($item->product)->image) }}"
                            alt="{{ optional($item->product)->name ?? 'لا يوجد اسم' }}">
                        <div class="item-details">
                            <h5>{{ optional($item->product)->name ?? 'اسم غير متوفر' }}</h5>
                            <p>نوع السيارة: {{ ucfirst($item->car_type ?? 'غير محدد') }}</p>
                            <p>لون السيارة: {{ $item->car_color ?? 'غير محدد' }}</p>
                            <p>رقم السيارة: {{ $item->car_number ?? 'غير محدد' }}</p>
                            <p><strong>تاريخ الغسيل:</strong> {{ $item->car_wash ? $item->car_wash : 'لم يتم التحديد' }}
                            </p>
                            {{-- <div class="quantity-selector">
                                <button type="button" class="btn btn-sm btn-outline-secondary">-</button>
                                <input type="number" name="quantity[{{ $item->id }}]" value="1"
                                    min="1">
                                <button type="button" class="btn btn-sm btn-outline-secondary">+</button>
                            </div> --}}
                            <form method="POST" action="{{ route('user.carts.destroy', $item->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="remove-link btn btn-sm btn-outline-danger">إزالة</button>
                            </form>
                        </div>
                        <div class="price-container">
                            <p><strong>السعر:</strong> {{ $item->price ?? 'غير محدد' }} ريال</p>
                        </div>
                    </div>
                @endforeach

                <div class="total-summary">
                    <p><strong>الإجمالي:</strong> {{ $carts->sum('price') }} ريال</p>
                    <p><strong>الضريبة:</strong> {{ $carts->sum('price') * 0.15 }} ريال</p>
                    <p><strong>الإجمالي الكلي:</strong> {{ $carts->sum('price') * 0.15 }} ريال</p>
                </div>

                <div class="mb-3 mt-4">
                    <label for="payment_method" class="form-label">طريقة الدفع:</label>
                    <select class="form-select" id="payment_method" name="payment_method" required>
                        {{-- <option value="paid">بطاقة</option> --}}
                        <option value="cash_on_delivery">عند الاستلام</option>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-update">تحديث طريقة الدفع</button>
                </div>
            @endif
        </form>
    </div>
    @include('homeLayouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
