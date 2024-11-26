<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المركبة المخملية</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Cairo", sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        /* Footer Styling */
        .footer {
            background-color: #4a2f85;
            color: #fff;
            padding: 60px 0;
        }

        .footer h5 {
            font-weight: 700;
            margin-bottom: 20px;
        }

        .footer a {
            color: #fff;
            text-decoration: none;
            margin-bottom: 10px;
            display: block;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: #ed0f7d;
        }

        .footer .social-icons a {
            margin: 0 10px;
            font-size: 24px;
            transition: color 0.3s ease;
        }

        .footer .social-icons a:hover {
            color: #ed0f7d;
        }

        .footer .contact-info p {
            margin-bottom: 8px;
            font-size: 15px;
        }

        .footer .contact-info i {
            margin-right: 8px;
            color: #ed0f7d;
        }

        .footer-bottom {
            text-align: center;
            padding: 15px 0;
            background-color: #333;
            color: #fff;
            font-size: 14px;
        }

        /* توزيع متناسق */
        .footer .container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 30px;
        }

        .footer .col {
            flex: 1;
            min-width: 250px;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }

        /* مظهر متجاوب */
        @media (max-width: 768px) {
            .footer .container {
                flex-direction: column;
                text-align: center;
            }

            .footer .social-icons {
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <!-- روابط سريعة -->
            <div class="col">
                <h5>روابط سريعة</h5>
                <a href="{{ route('about-us') }}">من نحن</a>
                <a href="{{ route('services') }}">خدماتنا</a>
                <a href="{{ route('subscribtion') }}">الاشتراكات</a>
                <a href="{{ route('privacy-policy') }}">سياسة الخصوصية</a>
            </div>

            <!-- وسائل التواصل الاجتماعي -->
            <div class="col text-center">
                <h5>تابعنا</h5>
                <div class="social-icons">
                    <a href="#" class="fab fa-facebook"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-instagram"></a>
                    <a href="#" class="fab fa-linkedin"></a>
                </div>
            </div>

            <!-- معلومات الاتصال -->
            <div class="col">
                <h5>اتصل بنا</h5>
                <div class="contact-info">
                    <p><i class="fas fa-phone"></i>{{ $companyUser?->phone }}</p>
                    <p><i class="fas fa-envelope"></i>{{ $companyUser?->email }}</p>
                    <p><i class="fas fa-map-marker-alt"></i>{{ $companyUser?->address }} - {{ $companyUser?->city }}</p>
                    <a href="https://wa.me/message/PZZU6X5DK243B1" target="_blank"><i class="fas fa-envelope"></i>تواصل
                        معنا الان</a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} جميع الحقوق محفوظة. المركبة المخملية.</p>
        </div>
    </footer>

</body>

</html>
