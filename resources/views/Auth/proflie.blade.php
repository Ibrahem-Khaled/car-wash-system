<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>الملف الشخصي</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.min.css" rel="stylesheet" />


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #e1bee7;
            background-image: linear-gradient(135deg, #8e24aa 30%, #e1bee7 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Cairo", sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
            direction: rtl;
        }

        .container {
            max-width: 600px;
            width: 100%;
            padding: 20px;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            background-color: #fff;
            color: #333;
        }

        .card-header {
            background-color: #8e24aa;
            color: #fff;
            padding: 15px;
            border-radius: 15px 15px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h3 {
            margin: 0;
        }

        .btn-primary, .btn-danger, .btn-delete {
            width: 100%;
            padding: 10px;
            border-radius: 25px;
            border: none;
            transition: background-color 0.3s ease;
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #8e24aa;
        }

        .btn-primary:hover {
            background-color: #7b1fa2;
        }

        .btn-danger {
            background-color: #d32f2f;
        }

        .btn-danger:hover {
            background-color: #c62828;
        }

        .btn-delete {
            background-color: #9c27b0;
        }

        .btn-delete:hover {
            background-color: #7b1fa2;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 20px;
            margin-bottom: 15px;
            border: 1px solid #e1bee7;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #8e24aa;
            box-shadow: none;
        }

        .alert-success {
            background-color: #4caf50;
            color: #fff;
            border-radius: 25px;
            padding: 10px 20px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">الملف الشخصي</h3>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">تسجيل الخروج</button>
                </form>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">الاسم الكامل</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">البريد الإلكتروني</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="address">العنوان</label>
                        <input type="text" class="form-control" id="address" name="address"
                            value="{{ old('address', $user->address) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">رقم الهاتف</label>
                        <input type="phone" class="form-control" id="phone" name="phone"
                            value="{{ old('phone', $user->phone) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password">كلمة المرور الجديدة (اترك الحقل فارغًا إذا كنت لا ترغب في تغييرها)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">تأكيد كلمة المرور</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation">
                    </div>
                    <button type="submit" class="btn btn-primary">تحديث الملف الشخصي</button>
                </form>

                <form id="delete-account-form" action="{{ route('account.delete') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-delete">حذف الحساب</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.min.js"></script>
</body>

</html>