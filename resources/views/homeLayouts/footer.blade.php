<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer عصري</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Cairo", sans-serif;
            background-color: #ffffff;
        }

        /* Footer Styling */
        .footer {
            background-color: #ffffff;
            color: #4a2f85;
            padding: 50px 0;
            border-width: 1px;
            border-style: solid;
            border-color: #4a2f85;
            border-radius: 10px;
            justify-content: space-between;
        }

        .footer h5 {
            font-weight: 700;
            color: #4a2f85;
            margin-bottom: 20px;
        }

        .footer a {
            color: #4a2f85;
            text-decoration: none;
            margin-bottom: 10px;
            display: block;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: #FFD700;
        }

        .footer .social-icons a {
            margin-right: 15px;
            font-size: 20px;
            color: #4a2f85;
            transition: color 0.3s ease;
        }

        .footer .social-icons a:hover {
            color: #FFD700;
        }

        .footer .contact-info p {
            margin-bottom: 10px;
            font-size: 14px;
            color: #4a2f85;
        }

        .footer .contact-info i {
            margin-right: 10px;
            color: #FFD700;
        }

        .footer-bottom {
            text-align: center;
            padding: 20px 0;
            background-color: #f1f1f1;
            color: #4a2f85;
            font-size: 14px;
        }

        /* توزيع العناصر بتناسق */
        .footer .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .footer .col-md-4 {
            margin-bottom: 20px;
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

            .footer .col-md-4 {
                margin-bottom: 30px;
            }
        }
    </style>
</head>

<body>
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <!-- روابط سريعة -->
            <div class="col-md-4">
                <h5>روابط سريعة</h5>
                <a href="#">من نحن</a>
                <a href="#">خدماتنا</a>
                <a href="#">الاشتراكات</a>
                <a href="#">سياسة الخصوصية</a>
            </div>

            <!-- وسائل التواصل الاجتماعي -->
            <div class="col-md-4 text-center">
                <h5>تابعنا</h5>
                <div class="social-icons d-flex justify-content-center">
                    <a href="#" class="fab fa-facebook"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-instagram"></a>
                    <a href="#" class="fab fa-linkedin"></a>
                </div>
            </div>

            <!-- معلومات الاتصال -->
            <div class="col-md-4">
                <h5>اتصل بنا</h5>
                <div class="contact-info">
                    <p><i class="fas fa-phone"></i> +123 456 789</p>
                    <p><i class="fas fa-envelope"></i> info@example.com</p>
                    <p><i class="fas fa-map-marker-alt"></i> شارع المثال، مدينة الأمثلة</p>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 جميع الحقوق محفوظة. اسم شركتك.</p>
        </div>
    </footer>


    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
