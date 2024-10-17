<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: "Cairo", sans-serif;
            direction: rtl;
            /* لتغيير اتجاه النص للعربية */
            text-align: right;
        }

        /* اللون البني الأساسي */
        .text-brown {
            color: #4a2f85;
        }

        .bg-brown {
            background-color: #4a2f85;
        }

        .btn-brown {
            background-color: #4a2f85;
            color: #fff;
            border: none;
        }

        .btn-brown:hover {
            background-color: #ed0f7d;
        }

        .form-control {
            border: 2px solid #4a2f85;
        }

        .form-control:focus {
            border-color: #ed0f7d;
            box-shadow: none;
        }
    </style>
</head>

<body>
    <section class="py-5 bg-light" id="contact">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 bg-white p-5">
                    <h2 class="display-6 fw-bold text-center text-brown mb-4">تواصل معنا</h2>
                    <form method="POST" action="#">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <input class="form-control bg-light" name="name" placeholder="الاسم"
                                        type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input class="form-control bg-light" name="email" placeholder="البريد الإلكتروني"
                                        type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input class="form-control bg-light" name="phone" placeholder="رقم الهاتف"
                                        type="tel">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <textarea class="form-control bg-light" name="message" placeholder="اكتب رسالتك هنا" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-grid">
                                    <button class="btn btn-brown" type="submit">إرسال الرسالة</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-5 text-brown mt-5 mt-lg-4">
                    <div class="mb-4">
                        <div>العنوان</div>
                        <div class="display-8 fw-semibold">
                            123 جبل فيو، كاليفورنيا، الولايات المتحدة
                        </div>
                    </div>
                    <div class="mb-4">
                        <div>الهاتف</div>
                        <div class="display-8 fw-semibold">
                            +1 123-458-789
                        </div>
                    </div>
                    <div class="mb-4">
                        <div>البريد الإلكتروني</div>
                        <div class="display-8 fw-semibold text-break">
                            <a class="text-link text-brown text-decoration-none"
                                href="mailto:samplemail@mail.com">hello@yourdomain.com</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
