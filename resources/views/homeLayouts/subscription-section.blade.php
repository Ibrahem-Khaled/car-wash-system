<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اختيار خطة الاشتراك</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Fonts and icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Cairo", sans-serif;
            background-color: #f8f9fa;
        }

        .pricing-container {
            padding: 50px 0;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .pricing-container h2 {
            font-weight: 700;
            color: #4a2f85;
            margin-bottom: 50px;
        }

        .pricing-row {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .pricing-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            flex: 1;
            max-width: 350px;
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.2);
        }

        .pricing-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #4a2f85;
            margin-bottom: 20px;
        }

        .pricing-card .price {
            font-size: 2rem;
            font-weight: 700;
            color: #ed0f7d;
            margin-bottom: 20px;
        }

        .pricing-card ul {
            list-style: none;
            padding: 0;
            margin-bottom: 20px;
        }

        .pricing-card ul li {
            color: #333;
            margin-bottom: 10px;
        }

        .pricing-card .btn {
            background-color: #4a2f85;
            color: #fff;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .pricing-card .btn:hover {
            background-color: #ed0f7d;
        }
    </style>
</head>

<body>
    <div class="container pricing-container" id="subscriptions">
        <h2>اختر خطة الاشتراك المناسبة لك</h2>
        <div class="pricing-row">
            <!-- الخطة الأساسية -->

            @foreach ($plans as $plan)
                <div class="pricing-card">
                    <h3>{{ $plan->title }}</h3>
                    <div class="price">${{ $plan->price }} /{{ $plan->duration }} شهر</div>
                    <ul>
                        <li>{{ $plan->description }}</li>
                    </ul>
                    <a href="#" class="btn">اشترك الآن</a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- JavaScript and Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
