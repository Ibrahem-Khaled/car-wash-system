<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملفي الشخصي</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-image: linear-gradient(to right, #4a2f85, #ed0f7d);
            color: white;
            height: 100vh;
            overflow: hidden;
            position: relative;
            direction: rtl;

        }

        .profile-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            position: relative;
        }

        .profile-card {
            width: 400px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            padding: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .profile-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin-top: -20px;
            border: 5px solid white;
        }

        .profile-details h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #4a2f85;
            margin-top: 10px;
        }

        .profile-details p {
            font-size: 1rem;
            margin: 5px 0;
            color: #333;
        }

        .status-active {
            color: #28a745;
        }

        .status-inactive {
            color: #dc3545;
        }

        .btn-primary {
            background-color: #4a2f85;
            border: none;
            width: 100%;
            margin-top: 15px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn-primary:hover {
            background-color: #ed0f7d;
            transform: scale(1.05);
        }

        .backdrop {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('https://images.unsplash.com/photo-1610878180933-04ecba6b87d5');
            background-size: cover;
            background-position: center;
            filter: blur(20px);
            z-index: -1;
            opacity: 0.7;
        }

        .social-icons {
            margin-top: 20px;
        }

        .social-icons a {
            font-size: 1.5rem;
            color: #4a2f85;
            margin: 0 10px;
            transition: color 0.3s, transform 0.3s;
        }

        .social-icons a:hover {
            color: #ed0f7d;
            transform: scale(1.2);
        }
    </style>
</head>

<body>

    @include('homeLayouts.nav-bar')

    <div class="profile-wrapper">
        <div class="profile-card">
            <img src="{{ $user->image }}" alt="Profile Image" class="profile-img">
            <div class="profile-details">
                <h2>{{ $user->name }}</h2>
                <p><strong>البريد الإلكتروني:</strong> {{ $user->email }}</p>
                <p><strong>رقم الهاتف:</strong> {{ $user->phone ?? 'غير متوفر' }}</p>
                <p><strong>العنوان:</strong> {{ $user->address ?? 'غير متوفر' }}</p>
                <p><strong>المدينة:</strong> {{ $user->city ?? 'غير متوفر' }}</p>
                <p>
                    <strong>حالة الحساب:</strong>
                    <span class="{{ $user->status == 'active' ? 'status-active' : 'status-inactive' }}">
                        {{ $user->status == 'active' ? 'نشط' : 'غير نشط' }}
                    </span>
                </p>
                <p><strong>نوع الحساب:</strong> {{ ucfirst($user->role) }}</p>
            </div>

            <a href="#" class="btn btn-primary">تعديل البيانات</a>

            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>

    @include('homeLayouts.footer')

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
