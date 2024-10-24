<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>إنشاء حساب</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;400;700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Cairo', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            max-width: 850px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            overflow: hidden;
            background-color: #fff;
            display: flex;
            flex-wrap: wrap;
        }

        .image-container {
            background-image: url('https://tse1.mm.bing.net/th?id=OIP.lbCP5u8L8iojC-VZAOIj4wHaFV&pid=Api');
            background-size: cover;
            background-position: center;
            width: 50%;
            min-height: 400px;
        }

        @media (max-width: 768px) {
            .image-container {
                display: none;
            }
        }

        .form-container {
            padding: 40px;
            width: 100%;
            max-width: 400px;
            margin: auto;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-container img {
            max-width: 100px;
        }

        .btn-primary {
            background-color: #6200ea;
            border: none;
        }

        .btn-primary:hover {
            background-color: #4b00b5;
        }

        .btn-google {
            background-color: #db4437;
            color: #fff;
        }

        .btn-google:hover {
            background-color: #c23321;
        }

        .btn-facebook {
            background-color: #3b5998;
            color: #fff;
        }

        .btn-facebook:hover {
            background-color: #2d4373;
        }

        a {
            color: #6200ea;
            text-decoration: none;
        }

        a:hover {
            color: #4b00b5;
        }

        .form-check-label {
            font-weight: 300;
        }

        .text-muted {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="image-container d-none d-md-block"></div>
        <div class="form-container">
            <div class="logo-container">
                <img src="{{ asset('assets/img/logo-ct-dark.png') }}" alt="Logo">
            </div>
            <h3 class="mb-4 text-center">إنشاء حساب</h3>
            <form method="POST" action="{{ route('customRegister') }}">
                @csrf

                <div class="form-group mb-4">
                    <label for="name" class="form-label">الاسم الكامل</label>
                    <input type="text" id="name" name="name" class="form-control"
                        placeholder="أدخل اسمك الكامل" required>
                </div>

                <div class="form-group mb-4">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" class="form-control"
                        placeholder="أدخل بريدك الإلكتروني" required>
                </div>

                <div class="form-group mb-4">
                    <label for="phone" class="form-label">رقم الهاتف</label>
                    <input type="tel" id="phone" name="phone" class="form-control"
                        placeholder="أدخل رقم هاتفك" required>
                </div>

                <div class="form-group mb-4">
                    <label for="address" class="form-label">العنوان</label>
                    <input type="text" id="address" name="address" class="form-control" placeholder="أدخل عنوانك"
                        required>
                </div>

                <div class="form-group mb-4">
                    <label for="password" class="form-label">كلمة المرور</label>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="أدخل كلمة المرور" required>
                </div>

                <div class="form-group mb-4">
                    <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                        placeholder="أعد إدخال كلمة المرور" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">تسجيل</button>
                <div class="d-flex justify-content-between">
                    <a href="#" class="btn btn-google w-48"><i class="fab fa-google me-2"></i>Google</a>
                    <a href="#" class="btn btn-facebook w-48"><i class="fab fa-facebook-f me-2"></i>Facebook</a>
                </div>

                <p class="text-center text-muted">لديك حساب بالفعل؟ <a href="{{ route('login') }}">تسجيل الدخول</a></p>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
