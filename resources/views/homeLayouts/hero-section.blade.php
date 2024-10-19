<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Cairo", sans-serif;
            font-optical-sizing: auto;
        }

        .hero-section {
            position: relative;
            height: 600px;
            display: flex;
            align-items: center;
            color: #333;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Fshop.gardenstatehonda.com%2Fwp-content%2Fuploads%2Fsites%2F21%2F2020%2F05%2Fcar-wash-2.jpg&f=1&nofb=1&ipt=edb4f4d58ba2dd2e62aa30f96691db04caed2aca9368ccbc8349b4e968d4a778&ipo=images') no-repeat center center/cover;
            filter: blur(3px);
            z-index: -1;
        }

        .hero-content {
            z-index: 1;
            max-width: 800px;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            text-align: right;
        }

        .hero-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1D1E1F;
        }

        .hero-text {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
        }

        .hero-btns {
            text-align: right;
        }

        .hero-btns .btn {
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: 600;
        }

        .btn {
            background-color: #4a2f85;
            color: #fff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #ed0f7d;
        }

        .btn-outline-secondary {
            border: 2px solid #6c757d;
            color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: #fff;
        }
    </style>
</head>

<body>

    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-md-6 hero-content order-md-2">
                    <p class="lead">مغسلة متنقلة لخدمة سيارتك بكل احترافية.</p>
                    <h4 class="hero-title">اشترك الآن واستمتع بنظافة سيارتك في أي وقت وأي مكان</h4>
                    <p class="hero-text">نوفر لك خدمة غسيل متنقل تتيح لك الحفاظ على نظافة سيارتك بسهولة. اطلب الخدمة
                        وسنأتي إليك أينما كنت!</p>
                    <div class="hero-btns">
                        <a href="#" class="btn btn">احجز الآن</a>
                        <a href="#" class="btn btn-outline-secondary">استعرض جميع الخدمات</a>
                    </div>
                </div>

                <div class="col-md-6 order-md-1">
                    <!-- صورة إضافية أو محتوى فارغ -->
                </div>
            </div>
        </div>
    </section>

</body>

</html>
