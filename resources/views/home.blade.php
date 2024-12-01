<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المركبة المخملية</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: "Cairo", sans-serif;
            direction: rtl;
            background-color: #f8f9fa;
        }

        .services-section {
            padding: 60px 20px;
            background-color: #ffffff;
        }

        .service-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .service-card:hover {
            transform: translateY(-10px);
        }

        .stats-section {
            padding: 60px 20px;
            background-color: #4a2f85;
            color: white;
        }

        .testimonial-section {
            padding: 60px 20px;
            background-color: #f1f1f1;
        }

        .testimonial {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            background: white;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    @include('homeLayouts.nav-bar')
    @include('homeLayouts.hero-section')

    <!-- Services Section -->
    <section id="services" class="services-section">
        <div class="container text-center">
            <h2 class="mb-4">خدماتنا</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="service-card p-4">
                        <i class="fas fa-car-side fa-3x mb-3 text-primary"></i>
                        <h5>غسيل خارجي</h5>
                        <p>تنظيف خارجي شامل باستخدام أفضل المعدات.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card p-4">
                        <i class="fas fa-car-alt fa-3x mb-3 text-success"></i>
                        <h5>غسيل داخلي</h5>
                        <p>تنظيف داخلي دقيق للحفاظ على سيارتك كالجديدة.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card p-4">
                        <i class="fas fa-spray-can fa-3x mb-3 text-warning"></i>
                        <h5>تلميع السيارات</h5>
                        <p>تلميع خارجي لإعادة بريق سيارتك.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section text-center">
        <div class="container">
            <h2 class="mb-4">إحصائياتنا</h2>
            <div class="row">
                <div class="col-md-3">
                    <h3>10,000+</h3>
                    <p>سيارة مغسولة</p>
                </div>
                <div class="col-md-3">
                    <h3>500+</h3>
                    <p>عملاء راضون</p>
                </div>
                <div class="col-md-3">
                    <h3>20+</h3>
                    <p>فرع</p>
                </div>
                <div class="col-md-3">
                    <h3>50+</h3>
                    <p>موظف محترف</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonial-section">
        <div class="container text-center">
            <h2 class="mb-4">آراء عملائنا</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial">
                        <p>"خدمة ممتازة وسريعة. شكراً لكم!"</p>
                        <h5>- أحمد علي</h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial">
                        <p>"أفضل مغسلة سيارات زرتها على الإطلاق!"</p>
                        <h5>- سارة محمد</h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial">
                        <p>"تعامل راقٍ وجودة عالية. أنصح بها بشدة."</p>
                        <h5>- خالد حسن</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('homeLayouts.float-buttons')
    @include('homeLayouts.footer')

    <!-- جافا سكريبت -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
