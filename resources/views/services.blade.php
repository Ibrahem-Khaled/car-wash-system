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

        .service-icon {
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

    <section class="py-5">
        <div class="container">
            <h2 class="section-title">خدمات المغسلة المتنقلة</h2>
            <div class="row gy-4">


                @foreach ($services as $service)
                    <div class="col-md-6 col-lg-4">
                        <div class="card service-card p-4 text-center">
                            <i class="fas fa-car-wash service-icon">
                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}">
                            </i>
                            <h3 class="h5 mb-3">{{ $service->name }}</h3>
                            <p class="text-secondary">
                                {{ $service->description }}
                            </p>
                            <a href="#" class="btn btn-primary">اطلب الخدمة</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('homeLayouts.footer')

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
