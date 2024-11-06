<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقييم العامل</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f9f9f9;
            direction: rtl;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: #4a2f85;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
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
            <h2 class="section-title">تقييم العامل</h2>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form-container">
                        <form action="{{ route('worker.rate', ['order_id' => $order->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <div class="mb-3">
                                <label for="rating" class="form-label">التقييم (من 1 إلى 5)</label>
                                <select class="form-select" id="rating" name="rating" required>
                                    <option value="1">1 - ضعيف</option>
                                    <option value="2">2 - مقبول</option>
                                    <option value="3">3 - جيد</option>
                                    <option value="4">4 - جيد جدًا</option>
                                    <option value="5">5 - ممتاز</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="comment" class="form-label">تعليق</label>
                                <textarea class="form-control" id="comment" name="comment" rows="4" placeholder="اكتب تعليقك هنا..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">إرسال التقييم</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
