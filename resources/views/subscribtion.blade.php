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

    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">باقات الاشتراك</h2>
            <div class="row gy-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card package-card p-4 text-center">
                        <i class="fas fa-gem package-icon"></i>
                        <h3 class="h5 mb-3">الباقة الفضية</h3>
                        <p class="text-secondary">3 غسلات شهريًا - غسيل خارجي وداخلي.</p>
                        <h4 class="text-primary">100 ريال / شهر</h4>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#packageModal" data-package="الباقة الفضية" data-price="100" data-details="3 غسلات شهريًا مع غسيل خارجي وداخلي.">عرض التفاصيل</button>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card package-card p-4 text-center">
                        <i class="fas fa-star package-icon"></i>
                        <h3 class="h5 mb-3">الباقة الذهبية</h3>
                        <p class="text-secondary">5 غسلات شهريًا مع تعقيم.</p>
                        <h4 class="text-primary">150 ريال / شهر</h4>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#packageModal" data-package="الباقة الذهبية" data-price="150" data-details="5 غسلات شهريًا مع تعقيم داخلي وخارجي.">عرض التفاصيل</button>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card package-card p-4 text-center">
                        <i class="fas fa-crown package-icon"></i>
                        <h3 class="h5 mb-3">الباقة البلاتينية</h3>
                        <p class="text-secondary">عدد غير محدود من الغسلات مع فحص كامل.</p>
                        <h4 class="text-primary">300 ريال / شهر</h4>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#packageModal" data-package="الباقة البلاتينية" data-price="300" data-details="عدد غير محدود من الغسلات مع فحص كامل للسيارة.">عرض التفاصيل</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('homeLayouts.footer')

    <!-- Package Modal -->
    <div class="modal fade" id="packageModal" tabindex="-1" aria-labelledby="packageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="packageModalLabel">تفاصيل الباقة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 class="text-primary" id="modalPackageName"></h4>
                    <p id="modalPackageDetails"></p>
                    <h5 class="text-secondary">السعر: <span id="modalPackagePrice"></span> ريال / شهر</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="button" class="btn btn-primary">الدفع الآن</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const packageModal = document.getElementById('packageModal');
        packageModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const packageName = button.getAttribute('data-package');
            const packagePrice = button.getAttribute('data-price');
            const packageDetails = button.getAttribute('data-details');

            document.getElementById('modalPackageName').textContent = packageName;
            document.getElementById('modalPackageDetails').textContent = packageDetails;
            document.getElementById('modalPackagePrice').textContent = packagePrice;
        });
    </script>

</body>

</html>
