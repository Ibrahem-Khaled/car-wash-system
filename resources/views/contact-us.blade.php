<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> تواصل معنا</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/img/logo-ct.png') }}">

    <style>
        body {
            font-family: "Cairo", sans-serif;
            direction: rtl;
            text-align: right;
        }

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

        .info-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            border: 2px solid #4a2f85;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    @include('homeLayouts.nav-bar')
    @include('homeLayouts.float-buttons')

    <section class="py-5 bg-light" id="contact">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 bg-white p-5">
                    <h2 class="display-6 fw-bold text-center text-brown mb-4">تواصل معنا</h2>
                    <form method="POST" action="{{ route('contact-us.post') }}">
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
                            {{ $companyUser->address }}
                        </div>
                    </div>
                    <div class="mb-4">
                        <div>الهاتف</div>
                        <div class="display-8 fw-semibold">
                            {{ $companyUser->phone }}
                        </div>
                    </div>
                    <div class="mb-4">
                        <div>البريد الإلكتروني</div>
                        <div class="display-8 fw-semibold text-break">
                            <a class="text-link text-brown text-decoration-none"
                                href="mailto:samplemail@mail.com">{{ $companyUser->email }}</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- قسم الإفصاحات -->
            <div class="info-box mt-4">
                <h3 class="text-brown fw-bold mb-3">إفصاحات هامة</h3>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-clock text-brown"></i>
                        <strong>وقت الرد على الشكاوى:</strong> يتم الرد على الشكاوى خلال 24 ساعة عمل.
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-tools text-brown"></i>
                        <strong>وقت معالجة الشكاوى:</strong> يتم معالجة الشكاوى خلال 5 أيام عمل.
                    </li>
                    <li>
                        <i class="fas fa-truck text-brown"></i>
                        <strong>وقت التوصيل:</strong> تتم الخدمة بعد 24 ساعة من وقت الطلب، ويظهر ذلك بوضوح
                        في الفاتورة.
                    </li>
                </ul>
            </div>
        </div>
    </section>
    @include('homeLayouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
