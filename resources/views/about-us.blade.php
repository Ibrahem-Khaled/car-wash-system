<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('about.title') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Fonts and icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{ asset('assets/img/logo-ct.png') }}">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            background-color: #f9f9f9;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: #4a2f85;
        }

        .lead {
            color: #6c757d;
        }

        .text-primary {
            color: #4a2f85 !important;
        }

        .rounded {
            border-radius: 10px !important;
        }

        .feature-icon {
            font-size: 2rem;
            color: #4a2f85;
            margin-right: 15px;
        }

        .feature-box {
            transition: transform 0.3s ease;
        }

        .feature-box:hover {
            transform: translateY(-10px);
        }

        .about-section img {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
    </style>

<body>
    @include('homeLayouts.nav-bar')
    @include('homeLayouts.float-buttons')

    <section class="py-5 about-section" id="about">
        <div class="container">
            <div class="row gy-4 align-items-center">
                <div class="col-12 col-lg-6 col-xl-5">
                    <img class="img-fluid rounded" src="{{ asset('assets/img/car-wash.jpg') }}"
                        alt="{{ __('about.title') }}">
                </div>
                <div class="col-12 col-lg-6 col-xl-7">
                    <div class="row justify-content-xl-center">
                        <div class="col-12 col-xl-11">
                            <h2 class="section-title mb-3">{{ __('about.title') }}</h2>
                            <p class="lead fs-4 text-secondary mb-3">{{ __('about.subtitle') }}</p>
                            <p class="mb-4">{{ __('about.description') }}</p>
                            <div class="row gy-4 gx-xxl-5">
                                <div class="col-12 col-md-6">
                                    <div class="d-flex feature-box">
                                        <i class="fas fa-water feature-icon"></i>
                                        <div>
                                            <h2 class="h5 mb-2">{{ __('about.features.professional_wash.title') }}</h2>
                                            <p class="text-secondary mb-0">
                                                {{ __('about.features.professional_wash.description') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="d-flex feature-box">
                                        <i class="fas fa-map-marker-alt feature-icon"></i>
                                        <div>
                                            <h2 class="h5 mb-2">{{ __('about.features.mobile_service.title') }}</h2>
                                            <p class="text-secondary mb-0">
                                                {{ __('about.features.mobile_service.description') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row gy-4 gx-xxl-5 mt-4">
                                <div class="col-12 col-md-6">
                                    <div class="d-flex feature-box">
                                        <i class="fas fa-shield-alt feature-icon"></i>
                                        <div>
                                            <h2 class="h5 mb-2">{{ __('about.features.quality_security.title') }}</h2>
                                            <p class="text-secondary mb-0">
                                                {{ __('about.features.quality_security.description') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="d-flex feature-box">
                                        <i class="fas fa-clock feature-icon"></i>
                                        <div>
                                            <h2 class="h5 mb-2">{{ __('about.features.quick_service.title') }}</h2>
                                            <p class="text-secondary mb-0">
                                                {{ __('about.features.quick_service.description') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('homeLayouts.footer')

    <!-- جافا سكريبت -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
