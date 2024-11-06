<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خدمات المغسلة المتنقلة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha512-sA+qNc3y...="
        crossorigin="" />

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f9f9f9;
            direction: rtl;
        }

        .modal-map {
            height: 300px;
            width: 100%;
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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="container">
            <h2 class="section-title">خدمات المغسلة المتنقلة</h2>
            <div class="row gy-4">

                @foreach ($mainProducts as $service)
                    <div class="col-md-6 col-lg-4">
                        <div class="card service-card p-4 text-center">
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}"
                                class="img-fluid mb-3" style="max-height: 150px;">
                            <h3 class="h5 mb-3">{{ $service->name }}</h3>
                            <p class="text-secondary">{{ $service->description }}</p>
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#orderModal-{{ $service->id }}">
                                اطلب الخدمة
                            </button>
                        </div>
                    </div>

                    @include('homeLayouts.add-to-cart-modal', ['service' => $service])
                @endforeach

            </div>
        </div>
    </section>

    @include('homeLayouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha512-VNf5a2...=" crossorigin=""></script>



</body>

</html>
