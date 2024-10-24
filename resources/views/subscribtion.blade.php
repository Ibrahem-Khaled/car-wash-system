<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خدمات وباقات المغسلة المتنقلة</title>
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

        .service-card,
        .package-card {
            border: none;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .service-card:hover,
        .package-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .service-icon,
        .package-icon {
            font-size: 3rem;
            color: #4a2f85;
            margin-bottom: 15px;
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

    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">باقات الاشتراك</h2>
            <div class="row gy-4">
                @foreach ($subscriptions as $subscription)
                    <div class="col-md-6 col-lg-4">
                        <div class="card package-card p-4 text-center">
                            @if ($subscription->image)
                                <img src="{{ asset('storage/' . $subscription->image) }}"
                                    alt="{{ $subscription->name }}" class="img-thumbnail"
                                    style="width: 100px; height: 100px;">
                            @else
                                <i class="fas fa-star package-icon" style="font-size: 2rem;"></i>
                            @endif
                            <h3 class="h5 mb-3">{{ $subscription->name }}</h3>
                            <p class="text-secondary">{{ $subscription->description }}</p>
                            <ul class="list-unstyled">
                                @foreach ($subscription->products as $product)
                                    <li>{{ $product->name }} - {{ $product->pivot->quantity }} غسلة</li>
                                @endforeach
                            </ul>
                            <h4 class="text-primary">{{ $subscription->price }} ريال / شهر</h4>
                            <form method="POST" action="#">
                                @csrf
                                <input type="hidden" name="subscription_id" value="{{ $subscription->id }}">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#paymentModal-{{ $subscription->id }}">
                                    اشترك الآن
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Payment Modal -->
                    <div class="modal fade" id="paymentModal-{{ $subscription->id }}" tabindex="-1"
                        aria-labelledby="paymentModalLabel-{{ $subscription->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="paymentModalLabel-{{ $subscription->id }}">إتمام الدفع
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="#">
                                        @csrf
                                        <input type="hidden" name="subscription_id" value="{{ $subscription->id }}">

                                        <div class="mb-3">
                                            <label class="form-label">اسم صاحب البطاقة</label>
                                            <input type="text" class="form-control" name="card_name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">رقم البطاقة</label>
                                            <input type="text" class="form-control" name="card_number" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">تاريخ الانتهاء</label>
                                            <input type="text" class="form-control" name="expiry_date"
                                                placeholder="MM/YY" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">الرمز السري (CVV)</label>
                                            <input type="text" class="form-control" name="cvv" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">إتمام الدفع</button>
                                    </form>
                                </div>
                            </div>
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
